<?php

	// get infos
	$machine = $_POST['machine'];
	$option  = $_POST['option'];
	
	// check option
	switch($option) {
		case "pourc":
			// get data
			$listMachineGraphPourc = $_POST['listMachineGraphPourc'];
			break;
			
		case "pareto":
			
			break;
			
		default:
			break;
	}

?>