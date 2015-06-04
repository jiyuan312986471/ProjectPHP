<?php

	include 'util.php';
  require_once('../bdd.php');

  // DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
  
  // get time
  $date = date('Y-m-d');
  $heure = date('H:i');
  $jour = date('D');
  
  // refresh
  echo '<META HTTP-EQUIV="Refresh" CONTENT="8; URL=machine.php?machine='.$machine.'">';
  
  // declare 6 machines
  $listMachine = array("AK","SAK","DT1","DT2","SAD","DT3");
  
  // declare 6 pourcentage graphs
  $listGraphPourc = array();
  
  
  /***********************************************************
  *																													 *
	*										FOR	EACH MACHINE		  								 *
  *																													 *
  ***********************************************************/
  foreach($listMachine as $machine) {
  	
  }

?>