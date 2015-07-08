<?php

	include_once 'include/util.php';
	include 'conn.php';
	
	// get datas
	$code				 = $_POST["code"];
	$nom				 = $_POST["nom"];
	$nomAbrege	 = $_POST["nomAbrege"];
	$typeProduit = $_POST["typeProduit"];
	
	$result = "";
	
	if(addNewDefaut($conn, $code, $nom, $nomAbrege, $typeProduit)){
		$result .= "Succes de l'ajout du nouveau defaut (Code: ".$code.")!";
	}
	else{
		$result .= "Echec de l'ajout du nouveau defaut (Code: ".$code.")!";
	}
	
	echo $result;

?>