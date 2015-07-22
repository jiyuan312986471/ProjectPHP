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
	
	// string treatment
	$startDate = explode(" ", $startTime)[0];
	$startTime = explode(" ", $startTime)[1];
	$endDate = explode(" ", $endTime)[0];
	$endTime = explode(" ", $endTime)[1];
	$ref = explode(":", $ref)[1];
	$ref = trim($ref);
	$ref = str_replace("  ", "-", $ref);
	
	/**************************
	*				EXCEL PART
	**************************/
	$excel = new PHPExcel();
	
	// table head preparation
	$colomns = array(
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP'
	);
	
	$data = $listData[0];
	for($i = 0; $i < count(array_keys($data)); $i++) {
		$key = key($data[$i]);
		$excel->getActiveSheet()->setCellValue("$colomns[$i]1","$key");
	}
	
	// table content filling
	for ($i = 2; $i <= count($listData) + 1; $i++) {
		$j = 0;
		foreach ($listData[$i-2] as $data) {
			$key = key($data);
			$value = $data[$key];
			$excel->getActiveSheet()->setCellValue("$colomns[$j]$i","$value");
			$j++;
		}
	}
	
	// style setting
	foreach($colomns as $col){
		$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		for($row = 1; $row <= count($listData) + 1; $row++){
			$excel->getActiveSheet()->getStyle($col.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$excel->getActiveSheet()->getStyle($col.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
	}
	
	// excel output
	$fileName = 'DataRef'.$ref.'_From'.$startDate.'_'.$startTime.'_To'.$endDate.'_'.$endTime.'.xls';
	$write = new PHPExcel_Writer_Excel5($excel);
	$write->save("excel/test.xls");
	
	echo $fileName;

?>