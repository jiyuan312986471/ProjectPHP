<?php

	/************************************************/
	/* Les fonctions utilisés dans les fichiers php */
	/************************************************/
	
	/* Fonction permettante de calculer le paréto d'un défaut pour la machine séletionnée										*/
	/* Entre  : defaut, machine sélectionné, nombre des défauts pour cette machine													*/
	/* Sortie : pourcentage pour ce défaut																																	*/
	function pareto_m($defaut,$machine,$nombre,$conn) {
		$type = 0;
		$count = 0;
		
    $query = sqlsrv_query($conn, "SELECT [defau].[code],[defau].[nom],QuelleMachine,NumEnr,NumPal,[Date]
																	FROM [ping2].[dbo].[defaut] AS [defau]
																	JOIN [ping2].[dbo].[tesysk_auto] AS [defec] ON [defau].[code] = [defec].[CodeDefaut]
																	AND defec.QuelleMachine LIKE '%$machine%'
																	AND defau.nom LIKE  '%$defaut%'
																	AND cast(convert(char(8), [Date], 112) as int) =  cast(convert(char(8), getdate(), 112) AS int)
																	ORDER BY [Date] ASC",
													array(), array("Scrollable"=>"buffered"));
    		
		while($rownext = sqlsrv_fetch_array($query)) {
			if($rownext['NumEnr'] == $row['NumEnr'] + 1 && $rownext['NumPal'] == $row['NumPal']) {
				$count++;
			}
			
			$row = $rownext;
		}
		$row = sqlsrv_num_rows($query);
		
    if($nombre != 0) {
			$type = round($count/$nombre*100,2);
		}
		return $type;
	}
	
	/* Fonction permettante de convertir le jour en anglais vers le jour en français												*/
	/* Entre	: le jour en anglais																																					*/
	/* Sortie	:	le jour en français																																					*/
	function convert_j($jour) {
		switch($jour) {
			case 'Sun':
				return 'Dim';
			case 'Mon':
				return 'Lun';
			case 'Tue':
				return 'Mar';
			case 'Wed':
				return 'Mer';
			case 'Thu':
				return 'Jeu';
			case 'Fri':
				return 'Ven';
			case 'Sat':
				return 'Sam';
			default:
				break;
		}
	}
	
	/* Fonction permettante de préparer le graph du nbDéfaut de la machine																	*/
	/* Entre	:	la machine																																									*/
	/* Sortie	:	le graph du nbDéfaut																																				*/
	function getGraphNbDefaut($machine) {
		// declare the graph array
		$graph = array("jour" => array("","","","","","",""), "nb"	 => array(0, 0, 0, 0, 0, 0, 0));
	
		// get machine data
		$donne = file_get_contents('graph_'.$machine.'.dat');
		$n = sscanf($donne,"%f\t%f\t%f\t%f\t%f\t%f\t%f\n%s\t%s\t%s\t%s\t%s\t%s\t%s",
								$graph['nb'][0],  $graph['nb'][1],  $graph['nb'][2],  $graph['nb'][3],  $graph['nb'][4],  $graph['nb'][5],  $graph['nb'][6],
								$graph['jour'][0],$graph['jour'][1],$graph['jour'][2],$graph['jour'][3],$graph['jour'][4],$graph['jour'][5],$graph['jour'][6]);
		
		return $graph;
	}
	
	/* Fonction permettante de calculer le nb defaut de la machine																					*/
	/* Entre	: la machine et DB connection																																	*/
	/* Sortie	: nbDéfaut																																										*/
	function getNbDefaut($conn, $machine) {
		// initialize counter
    $count = 0;
		
		// get first defaut record
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT TOP 1 QuelleMachine,[Date],CodeDefaut,NumEnr,NumPal 
																									 FROM [ping2].[dbo].[TeSysK_Auto]",
																					 array(), array("Scrollable"=>"buffered")));
    
    // get defaut records of machine
		$query = sqlsrv_query($conn, "SELECT QuelleMachine,[Date],CodeDefaut,NumEnr,NumPal 
																	FROM [ping2].[dbo].[TeSysK_Auto] 
																	WHERE [CodeDefaut] > 0
																	AND QuelleMachine = '$machine'
																	AND cast(convert(char(8), [Date], 112) AS int) = cast(convert(char(8), getdate(), 112) AS int)",
													array(), array("Scrollable"=>"buffered"));
		
		// calculate nb defaut
		while($rowNext = sqlsrv_fetch_array($query)) {
			if($rowNext['NumEnr'] == $row['NumEnr'] + 1 && $rowNext['NumPal'] == $row['NumPal']) {
				$count++;
			}
			$row = $rowNext;
		}
		
		return $count;
	}
	
	/* Fonction permettante de calculer le nb total de la machine																						*/
	/* Entre	: la machine et DB connection																																	*/
	/* Sortie	: nb total																																										*/
	function getNbTotal($conn, $machine) {
		// get total nb
		$line = sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT count([CodeDefaut]) AS nombre 
																										FROM  [ping2].[dbo].[TeSysK_Auto] 
																										WHERE  [CodeDefaut] = 0
																										AND QuelleMachine = '$machine'
																										AND cast(convert(char(8), [Date], 112) AS int) = cast(convert(char(8), getdate(), 112) AS int)",
																						array(), array("Scrollable"=>"buffered")));
		return $line['nombre'];
	}
	
	/* Fonction permettante de calculer le pourcentage du defaut de la machine															*/
	/* Entre	: nb defaut et nb total																																				*/
	/* Sortie	: pourcentage																																									*/
	function calcuPourc($nb_defaut, $nb_total) {
		if($nb_defaut != 0) {
			$pourcentage = round( $nb_defaut / ($nb_total + $nb_defaut) * 100, 2);
		}
		else {
			$pourcentage = 0;
		}
		
		return $pourcentage;
	}
	
	/* Fonction	permettante de stocker nb defaut et nb total dans les fichiers															*/
	/* Entre	:	la machine et DB connection																																	*/
	/* Sortie	:	nb total et pourcentage																																			*/
	function nbdefaut($conn,$machine) {
		// get machine data
		$graph = getGraphNbDefaut($machine);
		
		// set date format
		if($graph['jour'][6] != date('D')) {
			for($i = 0; $i < count($graph['nb'])-1; $i++) {
				$graph['nb'][$i] = $graph['nb'][$i+1];
			}
			$graph['nb'][6] = 0;
		
			$graph['jour'][6] = date('D');	
			$date = new DateTime();
			for($i = 0; $i < 6; $i++){
				$date->add(new DateInterval('P1D'));
				if ($date->format('N')<8) {
					$graph['jour'][$i]=$date->format('D');
				}
			}
		}	
    
    // get nb defaut
    $count = getNbDefaut($conn, $machine);
		
		// get total nb
		$nb_total = getNbTotal($conn, $machine);

		// Calculer le pourcentage du défaut
		$pourcentage = calcuPourc($count, $nb_total);
		
		// store nb defaut into macdef.dat file
		file_put_contents("macdef/".$machine.".dat", $count);
		
		// GraphMachine
		if($graph['nb'][6]!= $pourcentage) {
			$graph['nb'][6] = $pourcentage;
		}
		
		// prepare data to store
		$donne = sprintf("%.2f\t%.2f\t%.2f\t%.2f\t%.2f\t%.2f\t%.2f\n%s\t%s\t%s\t%s\t%s\t%s\t%s", 
											$graph['nb'][0],  $graph['nb'][1],  $graph['nb'][2],  $graph['nb'][3],  $graph['nb'][4],  $graph['nb'][5],  $graph['nb'][6],
											$graph['jour'][0],$graph['jour'][1],$graph['jour'][2],$graph['jour'][3],$graph['jour'][4],$graph['jour'][5],$graph['jour'][6]);
		
		// store data into graph.dat file
		file_put_contents('graph_'.$machine.'.dat', $donne);
		
		return $nb_total.' '.$pourcentage;
	}
	
	/* Fonction permettante d'identifier la machine																													*/
	/* Entre	:	le type de machine																																					*/
	/* Sortie	:	array des defauts correspondants																														*/
	function identifyMachine($machine) {
		// identify machine
		switch($machine) {
			case 'AK':
				/* ressort */
				$defaut1 = 'ressort'; 
				
				/* 2 circuit mobile */
				$defaut2 = '2 circ';
				        
				/* contact */
				$defaut3 = 'contact';
				        
				/* contacteur bruyant */
				$defaut4 = 'bruy';
				 
				/* ecrasement */
				$defaut5 = 'ecras';
				      
				/* etiquette */
				$defaut6 = 'etiq';
				    
				/* montée retombée */
				$defaut7 = 'mont';
				   
				/* motorisation */
				$defaut8 = 'motori';
				
		    	/* position doigt */
				$defaut9 = 'doigt';
				        
				/* course */
				$defaut10 = 'course';
				break;
			
			case 'SAK':
				/* ressort */
				$defaut1 = 'ressort'; 
				
				/* 2 circuit mobile */
				$defaut2 = '2 circ';
				        
				/* contact */
				$defaut3 = 'contact';
				        
				/* contacteur bruyant */
				$defaut4 = 'bruy';
				 
				/* ecrasement */
				$defaut5 = 'ecras';
				      
				/* etiquette */
				$defaut6 = 'etiq';
				    
				/* montée retombée */
				$defaut7 = 'mont';
				   
				/* motorisation */
				$defaut8 = 'motori';
				
		    	/* position doigt */
				$defaut9 = 'doigt';
				        
				/* course */
				$defaut10 = 'course';
				break;
			
			case 'DT1':
				/* battement */
				$defaut1 = 'bat';    
				
				/* impédance */
				$defaut2 = 'impé';
				        
				/* fiabilité */
				$defaut3 = 'fiabil';
				        
				/* temps de fermeture DC BD */
				$defaut4 = 'ferm';
				 
				/* Course/ecrasement */
				$defaut5 = 'Course/ecras';
				      
				/* tension de montée */
				$defaut6 = 'mont';
				    
				/* tension de retombée */
				$defaut7 = 'retomb';
				   
				/* consommation */
				$defaut8 = 'conso';
				
		    	/* schéma*/
				$defaut9 = 'schéma';
				        
				/* Présence transil sur Cde sans transil */
				$defaut10 = 'transil';
				break;
			
			case 'DT2':
				/* battement */
				$defaut1 = 'bat';    
				
				/* impédance */
				$defaut2 = 'impé';
				        
				/* fiabilité */
				$defaut3 = 'fiabil';
				        
				/* temps de fermeture DC BD */
				$defaut4 = 'ferm';
				 
				/* Course/ecrasement */
				$defaut5 = 'Course/ecras';
				      
				/* tension de montée */
				$defaut6 = 'mont';
				    
				/* tension de retombée */
				$defaut7 = 'retomb';
				   
				/* consommation */
				$defaut8 = 'conso';
				
		    	/* schéma*/
				$defaut9 = 'schéma';
				        
				/* Présence transil sur Cde sans transil */
				$defaut10 = 'transil';
				break;
			
			case 'SAD':
				/* battement */
				$defaut1 = 'bat';    
				
				/* impédance */
				$defaut2 = 'impé';
				        
				/* fiabilité */
				$defaut3 = 'fiabil';
				        
				/* temps de fermeture DC BD */
				$defaut4 = 'ferm';
				 
				/* Course/ecrasement */
				$defaut5 = 'Course/ecras';
				      
				/* tension de montée */
				$defaut6 = 'mont';
				    
				/* tension de retombée */
				$defaut7 = 'retomb';
				   
				/* consommation */
				$defaut8 = 'conso';
				
		    	/* schéma*/
				$defaut9 = 'schéma';
				        
				/* Présence transil sur Cde sans transil */
				$defaut10 = 'transil';
				break;
			
			case 'DT3':
				/* battement */
				$defaut1 = 'bat';    
				
				/* course/ecrasement */
				$defaut2 = 'course/e';
				        
				/* tension de montée */
				$defaut3 = 'mont';
				        
				/* consommation  */
				$defaut4 = 'conso';
				 
				/* tension de retombée */
				$defaut5 = 'retomb';
				      
				/* schéma */
				$defaut6 = 'schéma';
				    
				/* Défaut appel maintien */
				$defaut7 = 'Défaut appel';
				   
				/* Fiabilité */
				$defaut8 = 'Fiabil';
				
		    	/* contact appel/maintien produit */
				$defaut9 = 'appel/maintien';
				        
				/* Courant appel trop long */
				$defaut10 = 'appel trop long';
				break;
			
			default:
				break;
		}
		
		// create array
		$listDefaut = array($defaut1, $defaut2, $defaut3, $defaut4, $defaut5, $defaut6, $defaut7, $defaut8, $defaut9, $defaut10);
		
		return $listDefaut;
	}
	
	/* Fonction permettante de préparer les données pour Pourcentage Graph																	*/
	/* Entre	:	la machine																																									*/
	/* Sortie	:	les données pour Pourcentage Graph (en 2D Array)																						*/
	function getPourcGraphData($machine) {
		// declare the percentage array
		$graphPourc = array("pourc" => array(0,0,0,0,0,0,0), "jour" => array("","","","","","",""));
		
		// get machine data
		$dataPourc = file_get_contents('graph_'.$machine.'.dat');
		$n = sscanf($dataPourc,"%f\t%f\t%f\t%f\t%f\t%f\t%f\n%s\t%s\t%s\t%s\t%s\t%s\t%s",
								$graphPourc['pourc'][0], 
								$graphPourc['pourc'][1],
								$graphPourc['pourc'][2], 
								$graphPourc['pourc'][3], 
								$graphPourc['pourc'][4], 
								$graphPourc['pourc'][5], 
								$graphPourc['pourc'][6],
								
								$graphPourc['jour'] [0], 
								$graphPourc['jour'] [1],	
								$graphPourc['jour'] [2], 
								$graphPourc['jour'] [3],	
								$graphPourc['jour'] [4], 
								$graphPourc['jour'] [5],	
								$graphPourc['jour'] [6] );
								
		// set date display format
		foreach($graphPourc['jour'] as &$jour){
			$jour = convert_j($jour);
		}
								
		return $graphPourc;
	}
	
	/* Fonction permettante de préparer les données pour Pareto Graph																				*/
	/* Entre	:	la machine et DB connection																																	*/
	/* Sortie	:	les données pour Pareto Graph (en 1D Array)																									*/
	function getParetoGraphData($machine, $conn) {
		$graphPareto = array();
		
		// identify machine and get corresponding defauts
  	$listDefaut = identifyMachine($machine);
  	
  	// get pareto data
		$dataPareto = file_get_contents("macdef/".$machine.".dat");
		
		// declare pareto array
		$listPareto = array();
		
		// set value of pareto array
		for($i = 0; $i < 10; $i++) {
			// calculate pareto
			$pareto = pareto_m($listDefaut[$i], $machine, $dataPareto, $conn);
			
			// add pareto into array
			array_push($listPareto, $pareto);
		}
		
		// map keys and values
		$graphPareto = array_combine($listDefaut, $listPareto);
		
		return $graphPareto;
	}
	
?>