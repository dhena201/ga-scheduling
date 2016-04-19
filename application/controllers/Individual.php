<?php
/************************************************************************
/ Class Individual : Genetic Algorithms 
/
/************************************************************************/
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Fitness.php');  //supporting class file


 class Individual {

    public $defaultGeneLength = 64;
    public  $waktuhabis = array();
    public  $genes1=array();  //defines an empty  array of genes arbitrary length gen1 define ruang
    public  $genes2=array();  //defines an empty  array of genes arbitrary length gen2 define waktu
    public  $genes3=array();  //defines an empty  array of genes arbitrary length gen3 define hari
	// Cache

    public $fitness = 0;
	
	public function random() {
	return (float)rand()/(float)getrandmax();
	}
    // Create a random individual
    public function generateIndividual($size) {
        for ($i=0; $i < $size; $i++ )  {
            $this->genes1[$i] = Fitness::$ruang[rand(0, count(Fitness::$ruang) - 1)];
        	$this->genes2[$i] = rand(0,(10 - (Fitness::$kelas[$i]['sks']))) ;
            $this->waktuhabis[$i] = $this->genes2[$i] + Fitness::$kelas[$i]['sks'];
        	$this->genes3[$i] = rand(0,4);
        }   
    }

    /* Getters and setters */
    // Use this if you want to create individuals with different gene lengths
    public function setDefaultGeneLength($length) {
        $this->defaultGeneLength = $length;
    }
    
    public function getGene1($index) {
        return $this->genes1[$index];
    }
    public function getGene2($index) {
        return $this->genes2[$index];
    }
    public function getGene3($index) {
        return $this->genes3[$index];
    }
    public function setGene($index,$val1,$val2,$val3){
        $this->genes1[$index] = $val1;
        $this->genes2[$index] = $val2;
        $this->waktuhabis[$index] = $val2 + Fitness::$kelas[$index]['sks'];
        $this->genes3[$index] = $val3;
        $this->fitness = 0;
    }
    public function setGene1($index,$value) {
        $this->genes1[$index] = $value;
        $this->fitness = 0;
    }
    public function setGene2($index,$value) {
        $this->genes2[$index] = $value;
        $this->waktuhabis[$index] = $value + Fitness::$kelas[$index]['sks'];
        $this->fitness = 0;
    }
    public function setGene3($index,$value) {
        $this->genes3[$index] = $value;
        $this->fitness = 0;
    }

    /* Public methods */
	  public function size() {
		  return count(FItness::$kelas);
	  }

    public function getFitness() {
        if ($this->fitness == 0) {
            $this->fitness = Fitness::getFitness($this);  //call static method to calculate fitness
        }
        return $this->fitness;
    }

    
}


?>