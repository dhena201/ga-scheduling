<?php
/************************************************************************
/ Class geneticAlgorithm : Genetic Algorithms 
/
/************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Individual.php');  //supporting class file
require_once('Population.php');  //supporting class file
require_once('Fitness.php');  //supporting class file

class algorithm {

    /* GA parameters */
  public static $uniformRate=0.6;  /* crosssover determine what where to break gene string */
  public static $mutationRate=0.01; /* When choosing which genes to mutate what rate of random values are mutated */
  public static $poolSize=5;  /* When selecting for crossover how large each pool should be */
  public static $max_generation_stagnant=100;  /*how many unchanged generations before we end */
  public static $elitism=true;

    /* Public methods */
    
    // Convenience random function
 private static function random() {
  return (float)rand()/(float)getrandmax();  /* return number from 0 .. 1 as a decimal */
}
	
    public static function evolvePopulation( $pop) {
        $newPopulation = new population($pop->size(), false);
        $elitismOffset=0;
	  
        // Keep our best individual
        if (algorithm::$elitism) {
            $newPopulation->saveIndividual(0, $pop->getFittest());
            $elitismOffset = 1;
	    }
		
        // Loop over the population size and create new individuals with
        // crossover
	
        for ($i = $elitismOffset; $i < $pop->size(); $i++) 
		{
            $indiv1 = algorithm::poolSelection($pop);
            $indiv2 = algorithm::poolSelection($pop);
            if(algorithm::random() <= algorithm::$uniformRate){    
                $newIndiv =  algorithm::crossover($indiv1, $indiv2);
                $newPopulation->saveIndividual($i, $newIndiv);    
            }else{
                $newPopulation->saveIndividual($i,$indiv1);
            }	 
            
        }

        // Mutate population
	    $count_mutate = intval(algorithm::$mutationRate*($pop->size())*count(Fitness::$kelas));
        for ($i=0; $i < $count_mutate; $i++) {
            $rando = rand($elitismOffset,$pop->size()-1);
            algorithm::mutate($newPopulation->getIndividual($rando));
        }

        return $newPopulation;
    }

    // Crossover individuals (aka reproduction)
    private static function crossover($indiv1, $indiv2) 
	 {
       $newSol = new individual();  //create a offspring
        // Loop through genes
        for ($i=0; $i < $indiv1->size(); $i++) {
            // Crossover at which point 0..1 , .50 50% of time
            if (  algorithm::random() <= algorithm::$uniformRate)
			{
                $newSol->setGene($i, $indiv1->getGene1($i),$indiv1->getGene2($i),$indiv1->getGene3($i) );
            } else {
                $newSol->setGene($i, $indiv2->getGene1($i),$indiv2->getGene2($i),$indiv2->getGene3($i));
            }
        }
        return $newSol;
    }

    // Mutate an individual
    private static function mutate( $indiv) {
        $randomGen = rand(0,count(Fitness::$kelas)-1);    
        $gene = Fitness::$ruang[rand(0, count(Fitness::$ruang) - 1)];    // Create random gene
        $indiv->setGene1($randomGen, $gene); //substitute the gene into the individual
        $gene = rand(0,(10 - (Fitness::$kelas[$randomGen]['sks']))) ;    // Create random gene
        $indiv->setGene2($randomGen, $gene); //substitute the gene into the individual
        $gene = rand(0,4);    // Create random gene
        $indiv->setGene3($randomGen, $gene); //substitute the gene into the individual
    
    }

    // Select a pool of individuals for crossover
    private static function poolSelection($pop) {
        // Create a pool population
        $pool = new population(algorithm::$poolSize, false);
	
	   for ($i=0; $i < algorithm::$poolSize; $i++) {
	     $randomId = rand(0, $pop->size()-1 ); //Get a random individual from anywhere in the population
			$pool->saveIndividual($i, $pop->getIndividual( $randomId));

        }
        // Get the fittest
        $fittest = $pool->getFittest();
        return $fittest;
    }


	}  //class
?>