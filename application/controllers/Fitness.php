<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Buat_jadwal.php');
class Fitness extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Fitness_model','fitness',TRUE);
    }
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
        $aa = false;
        // Loop through our individuals genes and compare them to our candidates
        for ($i=0; $i < $sol_count-1; $i++ )
        {
            for ($j=$i+1; $j < $sol_count; $j++) {
                // cek untuk kelas dengan prodi yang sama
                $aa = (Fitness::$kelas[$i]['id_prodi'] == Fitness::$kelas[$j]['id_prodi']);   //cek prodi sama
                $bb = ($individual->getGene2($i) == $individual->getGene2($j));                 //cek jam sama
                $cc = ($individual->getGene3($i) == $individual->getGene3($j));                 //cek hari sama
                $dd = ($individual->getGene1($i)['id_ruang'] == $individual->getGene1($j)['id_ruang']);         //cek ruang sama
                $ee = ($individual->getGene2($i) > $individual->getGene2($j) and $individual->getGene2($i) < $individual->waktuhabis[$j]); //cek irisan 1
                $ff = ($individual->getGene2($j) > $individual->getGene2($i) and $individual->getGene2($j) < $individual->waktuhabis[$i]); //cek irisan 2
                $gg = (Fitness::$kelas[$i]['id_dosen'] == Fitness::$kelas[$j]['id_dosen']);         //cek dosen sama
                $hh = (Fitness::$kelas[$i]['semester'] == Fitness::$kelas[$j]['semester']);   //cek semester

                if ($aa and $cc) { //untuk kelas di hari yang sama dan prodi yang sama
                    if($bb and $hh){ // bentrok jam dan mk semester yg sama
                        $fitness+=30;
                        //echo "*1 +30 ";
                    }
                    if($bb and $gg){ //bentrok dosen
                        $fitness+=30;
                        //echo "*2 +30 ";
                    }
                    if($hh and ($ee or $ff)){ //beririsan mk semester yg sama
                        $fitness+=20;
                        //echo "*3 +20 ";
                    }
                    if($bb and !$hh){ // bentrok mk prodi yg sama beda semester di jam yg sama
                        $fitness+=10;
                        //echo "*4 +10 ";
                    }
                    if($ee or $ff){ //beririsan mk prodi yg sama
                        $fitness+=5;
                        //echo "*5 +5 ";
                    }
                }else if($cc and !$aa){ //untuk kelas di hari yang sama berbeda prodi
                    if($bb and $cc){ //bentrok ruangan di jam yg sama
                        $fitness+=20;
                        //echo "bentrok ruang ";
                    }
                    if($cc and ($ee or $ff)){ // irisan ruangan
                        $fitness+=20;
                        //echo "irisan ruang ";
                    }
                }
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