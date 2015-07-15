<?php

	include_once 'include/util.php';
	include 'conn.php';
	
	// get datas
	$machine 		= $_POST["machine"];
	$dateOffset = $_POST["dateOffset"];
	
	echo "Machine: ".$machine."\nDateOffset: ".$dateOffset;

?>