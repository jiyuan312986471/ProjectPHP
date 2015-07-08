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
		$result .= "Succes de la modification de la machine ".$id."!";
	}
	else{
		$result .= "Echec de la modification de la machine ".$id."!";
	}
	
	echo $result;

?>