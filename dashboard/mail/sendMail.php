<?php

	include("mail.php");
	
	// prepare mail
	$address = "y.zhang.10@groupe-esigelec.fr";
	$subject = "Schneider Mail Test";
	$body		 = "Congratulation! You can see me!";
	
	// send mail
	if(!send_mail($address, $subject, $body)){
		echo "Failed";
	}
	else{
		echo "Success";
	}
	
?>