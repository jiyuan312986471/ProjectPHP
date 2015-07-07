<?php

	include 'include/util.php';
  include 'include/conn.php';
	
	// get machine
	$machine = $_GET['machine'];
	
	// get graph Pourc
  $graphPourc = getPourcGraphData($machine);
	
  // get graph Pareto
	$graphPareto = getParetoGraphData($machine, $conn);
	
	// get listDefaut
	$listDefaut = array_keys($graphPareto);
	
	// get listPareto
	$listPareto = array_values($graphPareto);
	
	echo json_encode($graphPourc)."AND".json_encode($listDefaut)."AND".json_encode($listPareto);

?>