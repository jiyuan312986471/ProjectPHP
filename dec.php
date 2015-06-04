<?php
	
	session_start();
	
	session_unset();
	session_destroy();
	
	header("refresh:1;url=index.html");
	echo "<center><img src=\"img/loading.gif\" /></center>";

?>