<?php
require_once '/pers.php';

if(isset($_POST['submit'])){

	$name=$_POST['user'];
	$pass=$_POST['pass'];
	$object=new personne();
	$object->login($name,$pass);
	
	if($object->id!=0){
		// Redirection
		echo"<center><img src=\"img/loading.gif\" /></center>";
		echo "<meta http-equiv=\"refresh\" content=\"1;dashboard/index.php\" />";
	}
}

?>
