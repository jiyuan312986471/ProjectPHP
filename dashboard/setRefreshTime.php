<?php

	session_start();
	
	$time = $_POST["time"];
	$_SESSION["refreshTime"] = $time;
	$result = "Nouvelle frequence d'actualisation: ".$time."s";
	
	echo $result;

?>