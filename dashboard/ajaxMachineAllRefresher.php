<?php

	include "include/util.php";
	include "include/conn.php";
	
	// get optionMachine
	$jsonOptionMachine = $_GET['jsonOptionMachine'];
	$data = json_decode(json_encode($jsonOptionMachine),true);
	
	// make optionMachine as array
	$listMachine = array();
	$listOption = array();
	$data = str_replace("\"","",$data);
	$data = substr($data, 1, strlen($data)-2);
	$maps = explode(",",$data);
	foreach($maps as $map){
		$keyValue = explode(":",$map);
		$machine = $keyValue[0];
		$option = $keyValue[1];
		array_push($listMachine,$machine);
		array_push($listOption,$option);
	}
	$optionMachine = array_combine($listMachine, $listOption);
	
	// get data for each machine
	$listGraph = array();
	foreach($listMachine as $machine){
		if($optionMachine[$machine] == "pourc"){
			$graph = getPourcGraphData($machine);
		}
		else if($optionMachine[$machine] == "pareto"){
			$graph = getParetoGraphData($machine, $conn);
		}
		array_push($listGraph, $graph);
	}
	$listMachineGraph = array_combine($listMachine,$listGraph);
	
	echo json_encode($listMachine)."AND".json_encode($optionMachine)."AND".json_encode($listMachineGraph);

?>