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
		
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT TOP 1 [defau].[code],[defau].[nom],QuelleMachine,NumEnr,NumPal,[Date] 
																									 FROM [ping2].[dbo].[defaut] AS [defau]
																									 JOIN [ping2].[dbo].[TeSysK_Auto] AS [defec] ON [defau].[code] = [defec].[CodeDefaut]
																									 AND  cast(convert(char(8), [Date], 112) AS int) =  cast(convert(char(8), getdate(), 112) AS int)",
																					 array(), array("Scrollable"=>"buffered")));
		
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
		if(file_exists('graph_'.$machine.'.dat')){
			$donne = file_get_contents('graph_'.$machine.'.dat');
			$n = sscanf($donne,"%f\t%f\t%f\t%f\t%f\t%f\t%f\n%s\t%s\t%s\t%s\t%s\t%s\t%s",
									$graph['nb'][0],  $graph['nb'][1],  $graph['nb'][2],  $graph['nb'][3],  $graph['nb'][4],  $graph['nb'][5],  $graph['nb'][6],
									$graph['jour'][0],$graph['jour'][1],$graph['jour'][2],$graph['jour'][3],$graph['jour'][4],$graph['jour'][5],$graph['jour'][6]);
		}
		
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
				$defaut7 = 'Vmont';
				   
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
				$defaut7 = 'Vmont';
				   
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
				$defaut6 = 'Vmont';
				    
				/* tension de retombée */
				$defaut7 = 'Vretomb';
				   
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
				$defaut6 = 'Vmont';
				    
				/* tension de retombée */
				$defaut7 = 'Vretomb';
				   
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
				$defaut6 = 'Vmont';
				    
				/* tension de retombée */
				$defaut7 = 'Vretomb';
				   
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
				$defaut3 = 'Vmont';
				        
				/* consommation  */
				$defaut4 = 'conso';
				 
				/* tension de retombée */
				$defaut5 = 'Vretomb';
				      
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
		
		if($machine != "All"){
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
		}
		else {
			// get data from graph.bat
			$donne = file_get_contents('graph.dat');
			$n = sscanf($donne,"%f\t%f\t%f\t%f\t%f\t%f\t%f\n%s\t%s\t%s\t%s\t%s\t%s\t%s",
								  $graph['pourc'][0], $graph['pourc'][1], $graph['pourc'][2], $graph['pourc'][3], $graph['pourc'][4], $graph['pourc'][5], $graph['pourc'][6],
								  $graph['jour'][0],  $graph['jour'][1],  $graph['jour'][2],  $graph['jour'][3],  $graph['jour'][4],  $graph['jour'][5],  $graph['jour'][6] );
		}
								
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
	
	/* Fonction permettante de récupérer les infos machines dans BD																					*/
	/* Entre	:	DB connection																																								*/
	/* Sortie	:	les infos	machines																																					*/
	function getListMachine($conn) {
		$listMachineInfo = array();
		$infoMachine = array();
		
		// prepare query
		$query = sqlsrv_query($conn, "SELECT [ID],[Nom],[Seuil],[TypeProduit],[Status]
  																FROM [ping2].[dbo].[machine]",
													array(), array("Scrollable"=>"buffered"));
		
		// execute query
		while($row = sqlsrv_fetch_array($query)) {
			// push info
			$infoMachine["Nom"] 				= $row["Nom"];
			$infoMachine["Seuil"] 			= $row["Seuil"];
			$infoMachine["TypeProduit"] = $row["TypeProduit"];
			$infoMachine["Status"] 			= $row["Status"];
			
			// map machine ID with info
			$ID = $row["ID"];
			$listMachineInfo[$ID] = $infoMachine;
		}
		
		return $listMachineInfo;
	}
	
	/* Fonction permettante de récupérer les types produits																									*/
	/* Entre	:	DB connection																																								*/
	/* Sortie	:	les types produits																																					*/
	function getTypeProduit($conn) {
		$listTypeProduit = array();
		
		// prepare query
		$query = sqlsrv_query($conn, "SELECT [type]
  																FROM [ping2].[dbo].[TypeProduit]",
													array(), array("Scrollable"=>"buffered"));
													
		// execute query
		while($row = sqlsrv_fetch_array($query)) {
			array_push($listTypeProduit, $row["type"]);
		}
		
		return $listTypeProduit;
	}
	
	/* Fonction permettante de récupérer les defauts dans BD																								*/
	/* Entre	:	DB connection																																								*/
	/* Sortie	:	les defauts																																									*/
	function getListDefaut($conn) {
		$listDefautInfo = array();
		$infoDefaut = array();
		
		// prepare query
		$query = sqlsrv_query($conn, "SELECT [code],[nom],[nomAbrege],[typeProduit]
  																FROM [ping2].[dbo].[defaut]
  																ORDER BY [code] ASC",
													array(), array("Scrollable"=>"buffered"));
													
		// execute query
		while($row = sqlsrv_fetch_array($query)) {			
			// push info
			$infoDefaut["Nom"] 				 = $row["nom"];
			$infoDefaut["NomAbrege"] 	 = $row["nomAbrege"];
			$infoDefaut["TypeProduit"] = $row["typeProduit"];
			
			// map codeDefaut with defaut info
			$codeDefaut = $row["code"];
			$listDefautInfo[$codeDefaut] = $infoDefaut;
		}
		
		return $listDefautInfo;
	}
	
	/* Fonction permettante d'ajouter un nouveau type produit dans BD																				*/
	/* Entre	:	DB connection	et type produit																																*/
	/* Sortie	:	true si succes, false si echec																															*/
	function addTypeProduit($conn, $type) {
		// prepare statement
		$sql = "INSERT INTO [dbo].[TypeProduit] ([type]) VALUES (?)";
		$param = array($type);
		
		// execute statement
		$stmt = sqlsrv_query($conn, $sql, $param);
		
		if( $stmt === false ) {
     return false;
		}
		return true;
	}
	
	/* Fonction permettante d'ajouter une nouvelle machine dans BD																					*/
	/* Entre	:	DB connection, ID, nom, seuil, type, status																									*/
	/* Sortie	:	true si succes, false si echec																															*/
	function addNewMachine($conn, $id, $nom, $seuil, $typeProduit, $status) {
		// prepare statement
		$sql = "INSERT INTO [dbo].[machine] ([ID],[Nom],[Seuil],[TypeProduit],[Status]) 
						VALUES (?,?,?,?,?)";
		$param = array($id, $nom, $seuil, $typeProduit, $status);
		
		// execute statement
		$stmt = sqlsrv_query($conn, $sql, $param);
		
		if( $stmt === false ) {
     return false;
		}
		return true;
	}
	
	/* Fonction permettante de modifier la machine dans BD																									*/
	/* Entre	:	DB connection, ID, nom, seuil, type, status																									*/
	/* Sortie	:	true si succes, false si echec																															*/
	function modifMachine($conn, $id, $nom, $seuil, $typeProduit, $status) {
		// nom machine
		if($nom != ""){
			// prepare statement
			$sql = "UPDATE [ping2].[dbo].[machine]
							SET [Nom] = ?
							WHERE [ID] = ?";
			$param = array($nom, $id);
			
			// execute statement
			$stmt = sqlsrv_query($conn, $sql, $param);
			
			if( $stmt === false ) {
	     return false;
			}
		}
		
		// seuil machine
		if($seuil != ""){
			$seuil = (int)$seuil;
			
			// prepare statement
			$sql = "UPDATE [ping2].[dbo].[machine]
							SET [Seuil] = ?
							WHERE [ID] = ?";
			$param = array($seuil, $id);
			
			// execute statement
			$stmt = sqlsrv_query($conn, $sql, $param);
			
			if( $stmt === false ) {
	     return false;
			}
		}
		
		// type produit machine
		if($typeProduit != ""){
			// prepare statement
			$sql = "UPDATE [ping2].[dbo].[machine]
							SET [TypeProduit] = ?
							WHERE [ID] = ?";
			$param = array($typeProduit, $id);
			
			// execute statement
			$stmt = sqlsrv_query($conn, $sql, $param);
			
			if( $stmt === false ) {
	     return false;
			}
		}
		
		// type produit machine
		if($status != ""){
			// prepare statement
			$sql = "UPDATE [ping2].[dbo].[machine]
							SET [Status] = ?
							WHERE [ID] = ?";
			$param = array($status, $id);
			
			// execute statement
			$stmt = sqlsrv_query($conn, $sql, $param);
			
			if( $stmt === false ) {
	     return false;
			}
		}
		
		return true;
	}
	
	/* Fonction permettante d'ajouter un nouveau defaut dans BD																							*/
	/* Entre	:	DB connection, code, nom, nomAbrege, type																										*/
	/* Sortie	:	true si succes, false si echec																															*/
	function addNewDefaut($conn, $code, $nom, $nomAbrege, $typeProduit) {
		// prepare statement
		$sql = "INSERT INTO [dbo].[defaut] ([code],[nom],[nomAbrege],[typeProduit]) 
						VALUES (?,?,?,?)";
		$param = array($code, $nom, $nomAbrege, $typeProduit);
		
		// execute statement
		$stmt = sqlsrv_query($conn, $sql, $param);
		
		if( $stmt === false ) {
     return false;
		}
		return true;
	}
	
	/* Fonction permettante de modifier le defaut dans BD																										*/
	/* Entre	:	DB connection, codeAncien, code, nom, nomAbrege, type																				*/
	/* Sortie	:	true si succes, false si echec																															*/
	function modifDefaut($conn, $codeAncien, $code, $nom, $nomAbrege, $typeProduit) {
		// prepare statement
		$sql = "UPDATE [dbo].[defaut]
						SET [code] = ?, [nom] = ?, [nomAbrege] = ?, [typeProduit] = ?
						WHERE [code] = ?";
		$param = array($code, $nom, $nomAbrege, $typeProduit, $codeAncien);
		
		// execute statement
		$stmt = sqlsrv_query($conn, $sql, $param);
		
		if( $stmt === false ) {
     return false;
		}
		return true;
	}
	
	/* Fonction permettante de récupérer les donnees d'un jour																							*/
	/* Entre	:	DB connection, machine, dateOffset																													*/
	/* Sortie	:	les donnees																																									*/
	function get24hData($conn, $machine, $dateOffset) {
		$listData = array();
		$data = array();
		
		if($machine != "All"){
			// prepare query
			$query = sqlsrv_query($conn, "SELECT [QuelleMachine],
																					 [NumEnr],
																					 [Date],
																					 [NumPal],
																					 [Ref],
																					 [CodeDefaut],
																					 [EcrasementP1],
																					 [EcrasementP2],
																					 [EcrasementP3],
																					 [EcrasementP4],
																					 [EcrasementAux1],
																					 [EcrasementAux2],
																					 [PosRepos],
																					 [PosTravail],
																					 [Course],
																					 [Consommation],
																					 [TpsFermetureDC],
																					 [MoyenneF],
																					 [MoyenneO],
																					 [MinP1],
																					 [MaxP1],
																					 [MinP2],
																					 [MaxP2],
																					 [MinP3],
																					 [MaxP3],
																					 [MinP4],
																					 [MaxP4],
																					 [MinPosRepos],
																					 [MaxPosRepos],
																					 [MinPosTravail],
																					 [MaxPosTravail],
																					 [MinMoyenneF],
																					 [MaxMoyenneF],
																					 [MinMoyenneO],
																					 [MaxMoyenneO],
																					 [CoeffA],
																					 [CoeffB],
																					 [CoeffC],
																					 [OffsetRepos],
																					 [OffsetTravail],
																					 [CorrectionRepos],
																					 [CorrectionTravail]
																		FROM [ping2].[dbo].[TeSysK_Auto]
	  																WHERE [QuelleMachine] LIKE '$machine'
	  																AND DAY([Date]) = DAY(DATEADD(day, -125, GETDATE()))",
														array(), array("Scrollable"=>"buffered"));
														
			// execute query
			while($row = sqlsrv_fetch_array($query)) {			
				// push info
				$data["QuelleMachine"] = $row["QuelleMachine"];
				$data["NumEnr"] = $row["NumEnr"];
				$data["Date"] = $row["Date"];
				$data["NumPal"] = $row["NumPal"];
				$data["Ref"] = $row["Ref"];
				$data["CodeDefaut"] = $row["CodeDefaut"];
				$data["EcrasementP1"] = $row["EcrasementP1"];
				$data["EcrasementP2"] = $row["EcrasementP2"];
				$data["EcrasementP3"] = $row["EcrasementP3"];
				$data["EcrasementP4"] = $row["EcrasementP4"];
				$data["EcrasementAux1"] = $row["EcrasementAux1"];
				$data["EcrasementAux2"] = $row["EcrasementAux2"];
				$data["PosRepos"] = $row["PosRepos"];
				$data["PosTravail"] = $row["PosTravail"];
				$data["Course"] = $row["Course"];
				$data["Consommation"] = $row["Consommation"];
				$data["TpsFermetureDC"] = $row["TpsFermetureDC"];
				$data["MoyenneF"] = $row["MoyenneF"];
				$data["MoyenneO"] = $row["MoyenneO"];
				$data["MinP1"] = $row["MinP1"];
				$data["MaxP1"] = $row["MaxP1"];
				$data["MinP2"] = $row["MinP2"];
				$data["MaxP2"] = $row["MaxP2"];
				$data["MinP3"] = $row["MinP3"];
				$data["MaxP3"] = $row["MaxP3"];
				$data["MinP4"] = $row["MinP4"];
				$data["MaxP4"] = $row["MaxP4"];
				$data["MinPosRepos"] = $row["MinPosRepos"];
				$data["MaxPosRepos"] = $row["MaxPosRepos"];
				$data["MinPosTravail"] = $row["MinPosTravail"];
				$data["MaxPosTravail"] = $row["MaxPosTravail"];
				$data["MinMoyenneF"] = $row["MinMoyenneF"];
				$data["MaxMoyenneF"] = $row["MaxMoyenneF"];
				$data["MinMoyenneO"] = $row["MinMoyenneO"];
				$data["MaxMoyenneO"] = $row["MaxMoyenneO"];
				$data["CoeffA"] = $row["CoeffA"];
				$data["CoeffB"] = $row["CoeffB"];
				$data["CoeffC"] = $row["CoeffC"];
				$data["OffsetRepos"] = $row["OffsetRepos"];
				$data["OffsetTravail"] = $row["OffsetTravail"];
				$data["CorrectionRepos"] = $row["CorrectionRepos"];
				$data["CorrectionTravail"] = $row["CorrectionTravail"];
				
				// add data into list
				array_push($listData, $data);
			}
		}
		else {
			// prepare query
			$query = sqlsrv_query($conn, "SELECT [QuelleMachine],
																					 [NumEnr],
																					 [Date],
																					 [NumPal],
																					 [Ref],
																					 [CodeDefaut],
																					 [EcrasementP1],
																					 [EcrasementP2],
																					 [EcrasementP3],
																					 [EcrasementP4],
																					 [EcrasementAux1],
																					 [EcrasementAux2],
																					 [PosRepos],
																					 [PosTravail],
																					 [Course],
																					 [Consommation],
																					 [TpsFermetureDC],
																					 [MoyenneF],
																					 [MoyenneO],
																					 [MinP1],
																					 [MaxP1],
																					 [MinP2],
																					 [MaxP2],
																					 [MinP3],
																					 [MaxP3],
																					 [MinP4],
																					 [MaxP4],
																					 [MinPosRepos],
																					 [MaxPosRepos],
																					 [MinPosTravail],
																					 [MaxPosTravail],
																					 [MinMoyenneF],
																					 [MaxMoyenneF],
																					 [MinMoyenneO],
																					 [MaxMoyenneO],
																					 [CoeffA],
																					 [CoeffB],
																					 [CoeffC],
																					 [OffsetRepos],
																					 [OffsetTravail],
																					 [CorrectionRepos],
																					 [CorrectionTravail]
																		FROM [ping2].[dbo].[TeSysK_Auto]
	  																WHERE DAY([Date]) = DAY(DATEADD(day, -125, GETDATE()))",
														array(), array("Scrollable"=>"buffered"));
														
			// execute query
			while($row = sqlsrv_fetch_array($query)) {			
				// push info
				$data["QuelleMachine"] = $row["QuelleMachine"];
				$data["NumEnr"] = $row["NumEnr"];
				$data["Date"] = $row["Date"];
				$data["NumPal"] = $row["NumPal"];
				$data["Ref"] = $row["Ref"];
				$data["CodeDefaut"] = $row["CodeDefaut"];
				$data["EcrasementP1"] = $row["EcrasementP1"];
				$data["EcrasementP2"] = $row["EcrasementP2"];
				$data["EcrasementP3"] = $row["EcrasementP3"];
				$data["EcrasementP4"] = $row["EcrasementP4"];
				$data["EcrasementAux1"] = $row["EcrasementAux1"];
				$data["EcrasementAux2"] = $row["EcrasementAux2"];
				$data["PosRepos"] = $row["PosRepos"];
				$data["PosTravail"] = $row["PosTravail"];
				$data["Course"] = $row["Course"];
				$data["Consommation"] = $row["Consommation"];
				$data["TpsFermetureDC"] = $row["TpsFermetureDC"];
				$data["MoyenneF"] = $row["MoyenneF"];
				$data["MoyenneO"] = $row["MoyenneO"];
				$data["MinP1"] = $row["MinP1"];
				$data["MaxP1"] = $row["MaxP1"];
				$data["MinP2"] = $row["MinP2"];
				$data["MaxP2"] = $row["MaxP2"];
				$data["MinP3"] = $row["MinP3"];
				$data["MaxP3"] = $row["MaxP3"];
				$data["MinP4"] = $row["MinP4"];
				$data["MaxP4"] = $row["MaxP4"];
				$data["MinPosRepos"] = $row["MinPosRepos"];
				$data["MaxPosRepos"] = $row["MaxPosRepos"];
				$data["MinPosTravail"] = $row["MinPosTravail"];
				$data["MaxPosTravail"] = $row["MaxPosTravail"];
				$data["MinMoyenneF"] = $row["MinMoyenneF"];
				$data["MaxMoyenneF"] = $row["MaxMoyenneF"];
				$data["MinMoyenneO"] = $row["MinMoyenneO"];
				$data["MaxMoyenneO"] = $row["MaxMoyenneO"];
				$data["CoeffA"] = $row["CoeffA"];
				$data["CoeffB"] = $row["CoeffB"];
				$data["CoeffC"] = $row["CoeffC"];
				$data["OffsetRepos"] = $row["OffsetRepos"];
				$data["OffsetTravail"] = $row["OffsetTravail"];
				$data["CorrectionRepos"] = $row["CorrectionRepos"];
				$data["CorrectionTravail"] = $row["CorrectionTravail"];
				
				// add data into list
				array_push($listData, $data);
			}
		}
		
		return $listData;
	}
	
?>