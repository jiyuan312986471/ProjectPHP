<?php

	$fileName = $_GET['fileName'];
	
	$file = fopen("excel/test.xls", "r");
	
	//header("Pragma: public");
	//header("Expires: 0");
	//header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-excel");
	//header("Content-Type:application/octet-stream");
	//header("Content-Type:application/download");;
	header("Content-Disposition:attachment;filename=\"".$fileName."\"");
	header("Content-Transfer-Encoding:binary");
	echo fread($file, filesize("excel/test.xls"));
	
	fclose($file);

?>