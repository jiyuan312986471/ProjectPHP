<?php
require_once('con_db.php');
connexion_db();

$reinit="TRUNCATE TABLE graf";
mysql_query($reinit) or die(mysql_error());

?>