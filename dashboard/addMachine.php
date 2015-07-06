<?php

	include_once 'util.php';
	include_once '../bdd.php';
	
	// get datas
	$id					 = $_POST["id"];
	$nom				 = $_POST["nom"];
	$seuil			 = $_POST["seuil"];
	$typeProduit = $_POST["typeProduit"];
	$status 		 = $_POST["status"];
	
	// DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
	
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
			$result .= "Type Produit added!";
		}
		else{
			$result .= "Failed to add Type Produit!";
			$willAddMachine = false;
		}
	}
	
	// add machine into DB
	if($willAddMachine){
		if(addNewMachine($conn, $id, $nom, $seuil, $typeProduit, $status)){
			$result .= "\nNew Machine added!";
		}
		else{
			$result .= "\nFailed to add New Machine!";
		}
	}
	
	echo $result;

?>