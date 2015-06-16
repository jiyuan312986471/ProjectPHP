<?php

	include_once 'util.php';
	include_once '../pers.php';
	include_once '../bdd.php';
	
	// DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
	
	// get time
  $date  = date('Y-m-d');
  $heure = date('H:i');
  $jour  = date('D');
  
  // refresh in order to keep informed
	//echo '<META HTTP-EQUIV="Refresh" CONTENT="8; URL=index.php">';
	
	// get pourcentage graph
	$graph = getPourcGraphData("All");

	// set date format
	if($graph['jour'][6] != date('D')) {		
		// algo with count
		for($i = 0; $i < count($graph['pourc'])-1; $i++) {
			$graph['pourc'][$i] = $graph['pourc'][$i+1];
		}
		
		$graph['pourc'][6] = 0;
		
		$graph['jour'][6] = date('D');
			
		$date = new DateTime();
		for($i = 0; $i < 6; $i++) {
			$date->add(new DateInterval('P1D'));
			if ($date->format('N')<8) {
				$graph['jour'][$i]=$date->format('D');
			}
		}
	}
	
	// Chercher des nb total et taux de defaut pour chaque machine
	$paraMachine = array( "nb" 	=> array(0,0,0,0,0,0), "pourc"	=> array(0,0,0,0,0,0) );
	
	sscanf(nbdefaut($conn,'AK'),  "%d %f",$paraMachine['nb'][0], $paraMachine['pourc'][0]);
	sscanf(nbdefaut($conn,'SAK'), "%d %f",$paraMachine['nb'][1], $paraMachine['pourc'][1]);
	sscanf(nbdefaut($conn,'DT1'), "%d %f",$paraMachine['nb'][2], $paraMachine['pourc'][2]);
	sscanf(nbdefaut($conn,'DT2'), "%d %f",$paraMachine['nb'][3], $paraMachine['pourc'][3]);
	sscanf(nbdefaut($conn,'DT3'), "%d %f",$paraMachine['nb'][4], $paraMachine['pourc'][4]);
	sscanf(nbdefaut($conn,'SAD'), "%d %f",$paraMachine['nb'][5], $paraMachine['pourc'][5]);
	
	$sum = 0;
	$sumdefaut = 0;
	for ($i = 0; $i < count($paraMachine['nb']); $i++) {
		$sum = $paraMachine['nb'][$i] + $sum;
		$sumdefaut = $paraMachine['nb'][$i] * $paraMachine['pourc'][$i] + $sumdefaut;
	}
	
	if($sum == 0) {
		$nombre = 0;
	}
	else {
		$nombre = round($sumdefaut/$sum,2);
	}
	
	//GraphTotal
  if($graph['pourc'][6]!= $nombre) {
  	$graph['pourc'][6] = $nombre;
	}
	
	// Enregistrer des donn��es dans le graph.bat
	$donne = sprintf("%f\t%f\t%f\t%f\t%f\t%f\t%f\n%s\t%s\t%s\t%s\t%s\t%s\t%s", 
										$graph['pourc'][0],$graph['pourc'][1],$graph['pourc'][2],$graph['pourc'][3],$graph['pourc'][4],$graph['pourc'][5],$graph['pourc'][6],
										$graph['jour'][0], $graph['jour'][1], $graph['jour'][2], $graph['jour'][3], $graph['jour'][4], $graph['jour'][5], $graph['jour'][6] );
	file_put_contents('graph.dat', $donne);
	
	// set date display format
	foreach($graph['jour'] as &$jour){
		$jour = convert_j($jour);
	}
	
	// encode graph into json and return
	echo json_encode($graph);

?>