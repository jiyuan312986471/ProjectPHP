<?php
  
  // get machine info
	$listMachineInfo = getListMachine($conn);
	$listMachine = array_keys($listMachineInfo);
	
//	foreach($listMachine as &$machine){
//		$machine = str_replace(" ", "", $machine);
//	}

?>