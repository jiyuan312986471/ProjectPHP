<?php

	include_once 'include/util.php';
	include 'conn.php';
	include 'PHPExcel/Classes/PHPExcel.php';
	
	// get datas
	$ref 			 = $_POST["ref"];
	$startTime = $_POST["startTime"];
	$endTime 	 = $_POST["endTime"];
	
	$listData = getDataByRefAndTime($conn, $ref, $startTime, $endTime);
	
	echo json_encode($listData);

?>