<?php

	include_once '../bdd.php';
	
	// DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();

?>