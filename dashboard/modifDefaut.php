<?php

	include_once 'include/util.php';
	include 'conn.php';
	
	// get datas
	$codeAncien  = $_POST["codeAncien"];
	$code				 = $_POST["code"];
	$nom				 = $_POST["nom"];
	$nomAbrege	 = $_POST["nomAbrege"];
	$typeProduit = $_POST["typeProduit"];
	
	$result = "";
	
	if(modifDefaut($conn, $codeAncien, $code, $nom, $nomAbrege, $typeProduit)){
		$result .= "Succes de modifier defaut (Code: ".$code.", Ancien Code: ".$codeAncien.")!";
	}
	else{
		$result .= "Echec de modifier defaut (Code: ".$code.", Ancien Code: ".$codeAncien.")!";
	}
	
	echo $result;

?>