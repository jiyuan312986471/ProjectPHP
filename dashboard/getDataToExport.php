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
	$colomn = array(
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP'
	);
	$tableHeader = array_keys($listData[0]);
	for($i = 0; $i < count($tableHeader); $i++) {
		$excel->getActiveSheet()->setCellValue("$colomn[$i]1","$tableHeader[$i]");
	}
	
	// table content filling
	for ($i = 2; $i <= count($listData) + 1; $i++) {
		$j = 0;
		foreach ($listData[$i-2] as $key => $value) {
			$key = json_encode($key);
			$value = json_encode($value);
			$excel->getActiveSheet()->setCellValue("$colomn[$j]$i","$value");
			$j++;
		}
	}
	
	// excel output
	$fileName = 'DataRef'.$ref.'_From'.$startDate.'_'.$startTime.'_To'.$endDate.'_'.$endTime.'.xls';
	$url = dirname('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	$filePath = $url.'/excel/'.$fileName;
	$write = new PHPExcel_Writer_Excel5($excel);
	$write->save($filePath);
	//header("Pragma: public");
	//header("Expires: 0");
	//header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	//header("Content-Type:application/force-download");
	//header("Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Type:application/vnd.ms-excel");
	//header("Content-Type:application/octet-stream");
	//header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"".$fileName."\"");
	//header("Content-Transfer-Encoding:binary");	
	
	
	echo $filePath;

?>