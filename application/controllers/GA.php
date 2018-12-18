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
        $this->load->model('Jadwal_model','jadwalmodel',TRUE);
        $this->load->model('Konflik_model','konflik',TRUE);
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
	public function sendMsg2($id) {
		
        echo "id: $id".PHP_EOL;
		echo "event: update2".PHP_EOL;
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
	public function deconvertTime($waktu){
		$jams = explode(":", $waktu);
		$jamint = intval($jams[0]);
		$menitint = intval($jams[1]);
		$jam = $jamint*60;
		$menitall = ($jam+$menitint)-440;
		$jamkul = $menitall/50;
		return $jamkul;
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
		$hariall = array('Senin','Selasa','Rabu','Kamis','Jum\'at');
    	$this->jadwalmodel->delTmp();
    	$row = array();
    	for($i=0;$i<count(Fitness::$kelas);$i++){
    		$data = array(
    			'id_jadwal' => '',
                'thn_ajar' => $thnajar,
                'id_kuliah' => Fitness::$kelas[$i]['id_kuliah'],
                'id_dosen' => Fitness::$kelas[$i]['id_dosen'],
                'kelas' => Fitness::$kelas[$i]['kelas'],
                'kapasitas' => Fitness::$kelas[$i]['kapasitas'],
                'id_ruang' => $fittest->getGene1($i)['id_ruang'],
                'hari' => $hariall[$fittest->getGene3($i)],
                'jam' => $this->convertTime($fittest->getGene2($i))
            );
            $row [] = $data;
    	}
    	$this->jadwalmodel->saveTmp($row);
    }
    public function saveKonflik($idjadwal,$idbatasan,$idjadwal2)
    {
    	$data = array(
                'id_jadwal' => $idjadwal,
                'id_batasan' => $idbatasan,
                'id_jadwal2' => $idjadwal2
            );
        $insert = $this->konflik->save($data);
    }
    public function  evaluasi($thnajar) {
    	$this->konflik->delete();
        $list = $this->jadwalmodel->get_datatablestmp($thnajar);
        $data = array();
        $i = 0;
        foreach ($list as $jadwal) {
            $row = array(
                "id_jadwal" => $jadwal['id_jadwal'],
            	"thn_ajar" => $jadwal['thn_ajar'],
            	"id_kuliah" => $jadwal['id_kuliah'],
            	"semester" => $jadwal['semester'],
            	"id_dosen" => $jadwal['id_dosen'],
            	"id_prodi" => $jadwal['id_prodi'],
            	"kapasitas" => $jadwal['kapasitas'],
                "id_ruang" => $jadwal['id_ruang'],
                "kapasitas_ruang" => $jadwal['kapasitas_ruang'],
                "hari" => $jadwal['hari'],
                "jam" => $this->deconvertTime($jadwal['jam']),
                "waktuhabis" => $this->deconvertTime($jadwal['jam'])+$jadwal['sks']
            	);   
            $data[] = $row;
            	echo $i." ";
             	echo $jadwal['id_jadwal']." ";
            	echo $jadwal['thn_ajar']." ";
            	echo $jadwal['id_kuliah']." ";
            	echo $jadwal['semester']." ";
            	echo $jadwal['id_dosen']." ";
            	echo $jadwal['id_prodi']." ";
            	echo $jadwal['kapasitas']." ";
                echo $jadwal['id_ruang']." ";
                echo $jadwal['kapasitas_ruang']." ";
                echo $jadwal['hari']." ";
                echo $this->deconvertTime($jadwal['jam'])." ";
                echo $this->deconvertTime($jadwal['jam'])+$jadwal['sks']." ";
                echo "<br>";
                $i++;
        }
        for ($i=0; $i < count($data); $i++ ){
        	$jj = ($data[$i]['kapasitas'] > $data[$i]['kapasitas_ruang']); // cek kapasitas ruangan
            for ($j=$i+1; $j < count($data); $j++){
            	$kaka = $data[$i]['id_kuliah'];
            	//echo "$kaka <br>";
                $aa = ($data[$i]['hari'] == $data[$j]['hari']);                 //cek hari sama
                $bb = ($data[$i]['jam'] == $data[$j]['jam']);                 //cek jam sama
                $cc = ($data[$i]['id_prodi'] == $data[$j]['id_prodi']);     //cek prodi sama
                $dd = ($data[$i]['id_ruang'] == $data[$j]['id_ruang']);         //cek ruang sama
                $ee = ($data[$i]['jam'] >= $data[$j]['jam'] and $data[$i]['jam'] < $data[$j]['waktuhabis']); //cek irisan 1
                $ff = ($data[$j]['jam'] >= $data[$i]['jam'] and $data[$j]['jam'] < $data[$i]['waktuhabis']); //cek irisan 2
                $gg = ($data[$i]['id_dosen'] == $data[$j]['id_dosen']);         //cek dosen sama
                $hh = ($data[$i]['semester'] == $data[$j]['semester']);         //cek semester
                $ii = ($data[$i]['id_kuliah'] == $data[$j]['id_kuliah']); //cek mata kuliah yang sama
                $kk = ($data[$i]['semester'] != 0);
                if ($aa) { //untuk kelas di hari yang sama
                    if($cc){ //untuk prodi yang sama
                        if(($ee or $ff) and !$ii){  //Bentrok waktu
                            if($hh and $kk){//Bentrok waktu mk semester yang sama
                                $a = $data[$i]['semester'];
                                $b = $data[$j]['semester'];
                                $jama = $data[$i]['jam']."-".$data[$i]['waktuhabis'];
                                $jamb = $data[$j]['jam']."-".$data[$j]['waktuhabis'];
                                $this->saveKonflik($data[$i]['id_jadwal'],1,$data[$j]['id_jadwal']);
                                echo "$i semester $a $jama dan $j semester $b $jamb bentrok 1 <br>";
                            }
                            if($gg){// Bentrok waktu dosen yg sama
                            	$this->saveKonflik($data[$i]['id_jadwal'],2,$data[$j]['id_jadwal']);
                            	echo "$i dan $j bentrok 2<br>";   
                            }
                            if($dd){// Bentrok waktu ruangan yg sama
                                $this->saveKonflik($data[$i]['id_jadwal'],3,$data[$j]['id_jadwal']);
                                echo "$i dan $j bentrok 3<br>";
                            }
                            // if(!$hh){// Bentrok mk semester berbeda
                            //     $this->saveKonflik($data[$i]['id_jadwal'],4,$data[$j]['id_jadwal']);
                            //     echo "$i dan $j bentrok 4<br>";
                            // }
                        }
                    }
                    else if(!$cc){// beda prodi
                        if($ee or $ff){  //irisan waktu
                            if($gg){// Bentrok waktu dosen yg sama
                                $this->saveKonflik($data[$i]['id_jadwal'],5,$data[$j]['id_jadwal']);
                                echo "$i dan $j bentrok 5<br>";
                            }
                            if($dd){// Bentrok waktu ruangan yg sama
                            	$this->saveKonflik($data[$i]['id_jadwal'],6,$data[$j]['id_jadwal']);
                            	echo "$i dan $j bentrok 6<br>";
                            }
                        }
                    }
                }
            }
            if($jj){//kapasitas ruangan kurang dari kapasitas kelas
            	$this->saveKonflik($data[$i]['id_jadwal'],7,$data[$i]['id_jadwal']);
                $ru = $data[$i]['kapasitas_ruang'];
                $kel = $data[$i]['kapasitas'];
            	echo "$i Kapasitas Ruangan Kurang $ru < $kel<br>";
            }   
        }
    }
    public function evolve($thnajar){
    	header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');
		$initial_population_size=15;		//how many random individuals 
		$generationCount = 0;
		$generation_stagnant=0; 
		$most_fit=0;
		$most_fit_last=10000;
		$time1 = microtime(true);
		$jamulai = 7;
		$hariall = array('Senin','Selasa','Rabu','Kamis','Jumat');
		$response = array();  //holdse the JSON object to be returned
		$response['done']=false; //assume not done 
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
					$time2 = microtime(true);
					$response['elapsed'] = round($time2-$time1,2)."s";
					$response['message'] = '<strong>PHP Server Working...</strong>';
					$serverTime = microtime();		
					$this->sendMsg($serverTime,json_encode($response));
				}
				else{
					$generation_stagnant++; //no improvement increment may want to end early
					$time2 = microtime(true);
                    $response['best_fittest_value']=$most_fit;
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
		$fittest = $myPop->getFittest();
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
