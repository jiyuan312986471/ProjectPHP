<?php

	include 'util.php';
  require_once('../bdd.php');

  // DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
  
  // get time
  $date = date('Y-m-d');
  $heure = date('H:i');
  $jour = date('D');
  
  // refresh
  echo '<META HTTP-EQUIV="Refresh" CONTENT="8; URL=machineAll.php">';
  
  // declare 6 machines
  $listMachine = array("AK","SAK","DT1","DT2","SAD","DT3");
  
  // declare graph pourcentage
  $graphPourc = array();
  
  // declare graph pareto
  $graphPareto = array();
  
  
  /***********************************************************
  *																													 *
	*										FOR	EACH MACHINE		  								 *
  *																													 *
  ***********************************************************/
  foreach($listMachine as $machine) {
  	
  	/*********************************
  	*					PARETO GRAPH					 *
  	*********************************/		
  	// identify machine and get corresponding defauts
  	$listDefaut = identifyMachine($machine);
  	
  	// get pareto data
		$dataPareto = file_get_contents("macdef/".$machine.".dat");
		
		// declare pareto array
		$listPareto = array();
		
		// set value of pareto array
		for($i = 0; $i < 10; $i++) {
			// calculate pareto
			$pareto = pareto_m($listDefaut[$i], $machine, $dataPareto, $conn);
			
			// add pareto into array
			array_push($listPareto, $pareto);
		}
		
		// combine pareto array(value) with defaut array(key)
		$graphPareto = array_combine($listDefaut, $listPareto);
  	
  	/*********************************
  	*					POURC GRAPH						 *
  	*********************************/
  	// declare the percentage array
		$listPourc = array("pourc" => array(0,0,0,0,0,0,0), "jour" => array("","","","","","",""));
  }

?>