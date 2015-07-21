<?php

	include_once 'include/util.php';
	include 'conn.php';
	include 'PHPExcel/Classes/PHPExcel.php';
	
	// get datas
	$ref 			 = $_POST["ref"];
	$startTime = $_POST["startTime"];
	$endTime 	 = $_POST["endTime"];
	
	// get all data from DB
	$listData = getDataByRefAndTime($conn, $ref, $startTime, $endTime);
	
	/**************************
	*				EXCEL PART
	**************************/
	
	echo json_encode($listData);

?>