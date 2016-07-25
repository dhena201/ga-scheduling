<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Buat_jadwal.php');
class Fitness{

    public static $kelas = array();
    public static $ruang = array();
    /* Public methods */
    public static function setInput($kelas,$ruang) {
         Fitness::$kelas = $kelas;
         Fitness::$ruang = $ruang;

    }

    // Calculate individuals fitness by comparing it to our candidate solution
    // low fitness values are better,0=goal fitness is really a cost function in this instance
    
    public static function  getFitness($individual) {
        $fitness = 0;
        $sol_count=count(Fitness::$kelas);  /* get array size */
        $conflict = false;
        // Loop through our individuals genes and compare them to our candidates
        for ($i=0; $i <= $sol_count-1; $i++ ){
            $jj = (Fitness::$kelas[$i]['kapasitas'] > $individual->getGene1($i)['kapasitas']); // cek kapasitas ruangan
            for ($j=$i+1; $j < $sol_count; $j++) {
                $aa = ($individual->getGene3($i) == $individual->getGene3($j));                 //cek hari sama
                $bb = ($individual->getGene2($i) == $individual->getGene2($j));                 //cek jam sama
                $cc = (Fitness::$kelas[$i]['id_prodi'] == Fitness::$kelas[$j]['id_prodi']);     //cek prodi sama
                $dd = ($individual->getGene1($i)['id_ruang'] == $individual->getGene1($j)['id_ruang']);         //cek ruang sama
                $ee = ($individual->getGene2($i) >= $individual->getGene2($j) and $individual->getGene2($i) < $individual->waktuhabis[$j]); //cek irisan 1
                $ff = ($individual->getGene2($j) >= $individual->getGene2($i) and $individual->getGene2($j) < $individual->waktuhabis[$i]); //cek irisan 2
                $gg = (Fitness::$kelas[$i]['id_dosen'] == Fitness::$kelas[$j]['id_dosen']);         //cek dosen sama
                $hh = (Fitness::$kelas[$i]['semester'] == Fitness::$kelas[$j]['semester']);         //cek semester
                $ii = (Fitness::$kelas[$i]['id_kuliah'] == Fitness::$kelas[$j]['id_kuliah']); //cek mata kuliah yang sama
                $kk = (Fitness::$kelas[$i]['semester'] != 0);
                if ($aa) { //untuk kelas di hari yang sama
                    if($cc){ //untuk prodi yang sama
                        if(($ee or $ff) and !$ii){  //irisan waktu
                            if($hh and $kk){//irisan waktu mk semester yang sama
                                $fitness+=30;
                                $conflict = true;
                            }
                            if($gg){// irisan waktu dosen yg sama
                                $fitness+=20;
                                $conflict = true;
                            }
                            if($dd){// irisan waktu ruangan yg sama
                                $fitness+=30;
                                $conflict = true;
                            }
                            // if(!$hh){// irisan mk semester berbeda
                            //     $fitness+=5;
                            //     $conflict = true;
                            // }
                        }
                    }
                    else if(!$cc){// beda prodi
                        if($ee or $ff){  //irisan waktu
                            if($gg){// irisan waktu dosen yg sama
                                $fitness+=20;
                                $conflict = true;
                            }
                            if($dd){// irisan waktu ruangan yg sama
                                $fitness+=30;
                                $conflict = true;
                            }
                        }
                    }
                }
            }
            if($jj){//kapasitas ruangan kurang dari kapasitas kelas
                    $fitness+=15;
                    $conflict =true;
            }
        }
        //echo "Fitness: $fitness";
        return $fitness;  //inverse of cost function
        
    }
    // Get optimum fitness
    public static function getMaxFitness() {
        $maxFitness = 0; //maximum matches assume each exact charaters yields fitness 1
        return $maxFitness;
    }
    
}

	
?>