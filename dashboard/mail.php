<?php

function send_mail($machine,$code) {
$to = "badr23001@hotmail.com";
$subject = "Alerte!";
$txt = "le nombre de défaut ".$code." de la machine ".$machine." dépasse 3"; 
$headers = "From: badr23001@hotmail.com" . "\r\n" ."CC: ";

mail($to,$subject,$txt,$headers);
}

?>