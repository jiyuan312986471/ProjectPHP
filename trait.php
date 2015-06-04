<?php

session_start();

include_once 'pers.php';
include_once 'bdd.php';

if(isset($_POST['submit'])){
	// get infos
	$name = $_POST['user'];
	$pass = $_POST['pass'];
	
	// DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$connInfo = $db->getConn();
	
	// login attempt
	$result = Personne::login($name, $pass, $connInfo);
	
	// check login
	if(sqlsrv_num_rows($result) != 1) {
		// unset session
		session_unset();
		
		// drop db connection
		unset($db);
		
		// error display
	  echo "Authentification Incorrecte";
	  
	  // destroy session
	  session_destroy();
	}
	
	// login success  
	else {
		// get user info
		$row = sqlsrv_fetch_array($result);
		$id = $row[0];
		
		// create user for session
		$validUser = new Personne($id, $name, $pass);
		
		// store user into session
		$_SESSION["utilisateur"] = $validUser;
		
		// redirection
		header("refresh:3;url=dashboard/index.php");
		echo "<center><img src=\"img/loading.gif\" /></center>";
		
		// disconnect DB
		unset($connInfo);
		unset($db);
	}
}

?>
