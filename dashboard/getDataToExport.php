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
	$excel->getActiveSheet()->setCellValue("A1","QuelleMachine");
	$excel->getActiveSheet()->setCellValue("B1","NumEnr");
	$excel->getActiveSheet()->setCellValue("C1","Date");
	$excel->getActiveSheet()->setCellValue("D1","NumPal");
	$excel->getActiveSheet()->setCellValue("E1","Ref");
	$excel->getActiveSheet()->setCellValue("F1","CodeDefaut");
	$excel->getActiveSheet()->setCellValue("G1","EcrasementP1");
	$excel->getActiveSheet()->setCellValue("H1","EcrasementP2");
	$excel->getActiveSheet()->setCellValue("I1","EcrasementP3");
	$excel->getActiveSheet()->setCellValue("J1","EcrasementP4");
	$excel->getActiveSheet()->setCellValue("K1","EcrasementAux1");
	$excel->getActiveSheet()->setCellValue("L1","EcrasementAux2");
	$excel->getActiveSheet()->setCellValue("M1","PosRepos");
	$excel->getActiveSheet()->setCellValue("N1","PosTravail");
	$excel->getActiveSheet()->setCellValue("O1","Course");
	$excel->getActiveSheet()->setCellValue("P1","Consommation");
	$excel->getActiveSheet()->setCellValue("Q1","TpsFermetureDC");
	$excel->getActiveSheet()->setCellValue("R1","MoyenneF");
	$excel->getActiveSheet()->setCellValue("S1","MoyenneO");
	$excel->getActiveSheet()->setCellValue("T1","MinP1");
	$excel->getActiveSheet()->setCellValue("U1","MaxP1");
	$excel->getActiveSheet()->setCellValue("V1","MinP2");
	$excel->getActiveSheet()->setCellValue("W1","MaxP2");
	$excel->getActiveSheet()->setCellValue("X1","MinP3");
	$excel->getActiveSheet()->setCellValue("Y1","MaxP3");
	$excel->getActiveSheet()->setCellValue("Z1","MinP4");
	$excel->getActiveSheet()->setCellValue("AA1","MaxP4");
	$excel->getActiveSheet()->setCellValue("AB1","MinPosRepos");
	$excel->getActiveSheet()->setCellValue("AC1","MaxPosRepos");
	$excel->getActiveSheet()->setCellValue("AD1","MinPosTravail");
	$excel->getActiveSheet()->setCellValue("AE1","MaxPosTravail");
	$excel->getActiveSheet()->setCellValue("AF1","MinMoyenneF");
	$excel->getActiveSheet()->setCellValue("AG1","MaxMoyenneF");
	$excel->getActiveSheet()->setCellValue("AH1","MinMoyenneO");
	$excel->getActiveSheet()->setCellValue("AI1","MaxMoyenneO");
	$excel->getActiveSheet()->setCellValue("AJ1","CoeffA");
	$excel->getActiveSheet()->setCellValue("AK1","CoeffB");
	$excel->getActiveSheet()->setCellValue("AL1","CoeffC");
	$excel->getActiveSheet()->setCellValue("AM1","OffsetRepos");
	$excel->getActiveSheet()->setCellValue("AN1","OffsetTravail");
	$excel->getActiveSheet()->setCellValue("AO1","CorrectionRepos");
	$excel->getActiveSheet()->setCellValue("AP1","CorrectionTravail");
	
//	$data = $listData[0];
//	for($i = 0; $i < count(array_keys($data)); $i++) {
//		$key = key($data[$i]);
//		$excel->getActiveSheet()->setCellValue("$colomns[$i]1","$key");
//	}
	
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
	$write->save("excel/temp.xls");
	
	echo $fileName;

?>