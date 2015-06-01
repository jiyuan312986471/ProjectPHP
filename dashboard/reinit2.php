<?php
require_once('con_db.php');
connexion_db();

$reinit="TRUNCATE TABLE graftotal";
mysql_query($reinit) or die(mysql_error());

?>