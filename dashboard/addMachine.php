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
	$willAddMachine = true;
	
	// check type produit
	$isTypeExist = false;
	$listTypeProduit = getTypeProduit($conn);
	foreach($listTypeProduit as $type){
		if($typeProduit == $type){
			$isTypeExist = true;
		}
	}
	
	// add new type into DB
	if(!$isTypeExist){
		if(addTypeProduit($conn, $typeProduit)){
			$result .= "Succes de l'ajout du nouveau Type Produit ".$typeProduit."!";
		}
		else{
			$result .= "Echec de l'ajout du nouveau Type Produit ".$typeProduit."!";
			$willAddMachine = false;
		}
	}
	
	// add machine into DB
	if($willAddMachine){
		if(addNewMachine($conn, $id, $nom, $seuil, $typeProduit, $status)){
			$result .= "\nSucces de l'ajout de la nouvelle machine ".$id."!";
		}
		else{
			$result .= "\nEchec de l'ajout de la nouvelle machine ".$id."!";
		}
	}
	
	echo $result;

?>