<?php

	include_once 'include/util.php';
	include 'conn.php';
	
	// get datas
	$id					 = $_POST["id"];
	$nom				 = $_POST["nom"];
	$seuil			 = $_POST["seuil"];
	$typeProduit = $_POST["typeProduit"];
	$status 		 = $_POST["status"];
	
	$result = "";
	
	if(modifMachine($conn, $id, $nom, $seuil, $typeProduit, $status)){
		$result .= "Machine ".$id." Modified!";
	}
	else{
		$result .= "Failed to modify machine ".$id."!";
	}
	
	echo $result;

?>