<?php

function connexion_db() {
	
	//$serverName = "RDITS-MDC"; 
	//$connectionInfo = array("UID"=>"bdd_user", "PWD"=>"user_bdd", "Database"=>"ping2");
	$serverName = "SAMUEL-PC";
	$connectionInfo = array("UID"=>"bdd_user", "PWD"=>"user_bdd", "Database"=>"ping2");
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	
	if( $conn == false) {
		echo "connection failed!\n";
		die( print_r( sqlsrv_errors(), true));
	}
	else {
		//echo "connection established!";
		return $conn;
	}
	
}

?>