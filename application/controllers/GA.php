<?php
/************************************************************************
/ GA : Genetic Algorithms  main page
/
/************************************************************************/

require_once('Individual.php');  //supporting individual 
require_once('Population.php');  //supporting population 
require_once('Fitness.php');  //supporting fitnesscalc 
require_once('Algorithm.php');  //supporting fitnesscalc 
/**
 * Constructs the SSE data format and flushes that data to the client.
 *
 * @param string $id Timestamp/id of this connection.
 * @param string $msg Line of text that should be transmitted.
 */

class GA extends MY_Controller{
	public $minstart = 440;
	public $minsks = 50;

	public function __construct(){
		parent::__construct();
        $this->load->model('Kelas_model','kelas',TRUE);
        $this->load->model('Ruang_model','ruang',TRUE);
        $this->load->model('Jadwal_model','jadwal',TRUE);
	}
	public function sendMsg($id, $json_msg) {
		
        echo "id: $id".PHP_EOL;
		echo "event: update".PHP_EOL;
		echo "data: $json_msg".PHP_EOL;
		echo PHP_EOL;
		ob_flush();
		flush();
	//  usleep(10000); ////wait for 0.10 seconds
	}
	public function convertTime($jamkul){
		$menit = intval($jamkul)*50;
		$menitall = $menit+440;

		$hour = intval($menitall/60);
		$min = $menitall%60;
		if($min==0){
			$min="00";
		}

		return "$hour".":"."$min";

	}
	public function getKelas(){
        $list = $this->kelas->get_datatables();
        $kelas = array();
        foreach ($list as $data) {
            $row = array(
            	'id_kelas' => $data['id_kelas'],
                'id_dosen' => $data['id_dosen'],
                'id_kuliah' => $data['id_kuliah'],
                'semester' => $data['semester'],
                'sks' => $data['sks'],
                'id_prodi' => $data['id_prodi'],
                'kapasitas' =>$data['kapasitas']
                );
            $kelas[] = $row;
        }
        return $kelas;
    }
    public function getRuang(){
        $list = $this->ruang->get_datatables();
        $ruang = array();
        foreach ($list as $data) {
            $row = array(
                'id_ruang' => $data['id_ruang'],
                'nama_ruang' => $data['nama_ruang'],
                'kapasitas' => $data['kapasitas_ruang'],
                );
            $ruang[] = $row;
        }
        return $ruang;
    }
    public function saveTmp($fittest,$thnajar){
		$hariall = array('Senin','Selasa','Rabu','Kamis','Jumat');
    	$this->jadwal->delTmp();
    	$row = array();
    	for($i=0;$i<count(Fitness::$kelas);$i++){
    		$data = array(
    			'id_jadwal' => '',
                'thn_ajar' => $thnajar,
                'id_kelas' => Fitness::$kelas[$i]['id_kelas'],
                'id_ruang' => $fittest->getGene1($i)['id_ruang'],
                'hari' => $hariall[$fittest->getGene3($i)],
                'jam' => $this->convertTime($fittest->getGene2($i))
            );
            $row [] = $data;
            	
    	}
    	$this->jadwal->saveTmp($row);

    }
    public function evolve($thnajar){
    	header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');
		$initial_population_size=75;		//how many random individuals 
		$generationCount = 0;
		$generation_stagnant=0; 
		$most_fit=0;
		$most_fit_last=400;
		$time1 = microtime(true);
		$jamulai = 7;
		$hariall = array('Senin','Selasa','Rabu','Kamis','Jumat');
		$response = array();  //holdse the JSON object to be returned
		$response['done']=false; //assume not done 
		$response['gen1']=array();
		$response['gen2']=array();
		$response['gen3']=array();
		$response['status']=array();
		Fitness::setInput($this->getKelas(),$this->getRuang());
		// Create an initial population
		$myPop = new population($initial_population_size, true);
		
		// Evolve our population until we reach an optimum solution
		while ($myPop->getFittest()->getFitness() > Fitness::getMaxFitness()){
			$response['stagnant']=0;
			$generationCount++;
			$response['update'] = false;
			$most_fit=$myPop->getFittest()->getFitness();          
				$myPop = algorithm::evolvePopulation($myPop); //create a new generation
				if ($most_fit < $most_fit_last){
				// echo " *** MOST FIT ".$most_fit." Most fit last".$most_fit_last;
					$response['update'] = true;
					$response['generation'] =$generationCount;
				 	$response['stagnant']=$generation_stagnant;
				 	$response['best_fittest_value']=$most_fit;
				 	$most_fit_last=$most_fit;
				 	$generation_stagnant=0; //reset stagnant generation counter
					$this->saveTmp($myPop->getFittest(),$thnajar); 
					$time2 = microtime(true);
					$response['elapsed'] = round($time2-$time1,2)."s";
					$response['message'] = '<strong>PHP Server Working...</strong>';
					$serverTime = microtime();			
					$this->sendMsg($serverTime,json_encode($response));
				}
				else{
					$generation_stagnant++; //no improvement increment may want to end early
					$time2 = microtime(true);
					$response['generation'] =$generationCount;
				 	$response['stagnant']=$generation_stagnant;
					$response['elapsed'] = round($time2-$time1,2)."s";
					$response['message'] = '<strong>PHP Server Working...</strong>';
					$serverTime = microtime();			
					$this->sendMsg($serverTime,json_encode($response));
				}

				if ( $generation_stagnant >= algorithm::$max_generation_stagnant){
				$response['stagnant']=$generation_stagnant;
			  	$response['message'] = "<strong><font color='red'>BERHENTI</font></strong> (".algorithm::$max_generation_stagnant.") generasi stagnant. Menampilkan Hasil Terbaik <br>";
			  	break;
				}

		}  //end of while loop

		//we're done
		$time2 = microtime(true);
		$response['generation'] =$generationCount;
		$response['best_fittest_value']=Fitness::getFitness($myPop->getFittest());
		$response['update'] = true;
		$response['elapsed'] = round($time2-$time1,2)."s";
		$response['message'].="<strong><font color='green'>Selesai!</font></strong>, Algoritma Genetika telah selesai untuk solusi ini";
		$response['done']=true;
		$serverTime = microtime();
		$this->saveTmp($myPop->getFittest(),$thnajar);			
		$this->sendMsg($serverTime,json_encode($response));
		exit;
	}
		

		
}
?>
