<?php

	session_unset ();
	session_destroy ();
	
	echo"<center><img src=\"img/loading.gif\" /></center>";
	echo "<meta http-equiv=\"refresh\" content=\"3;index.html\" />";

?>