<?php

	/* Fonction qui permet de compter le num��ro journalier des produit mauvais pour la machine s��lectionn��e */
	/* Entre  : jour d'aujourd'hui, machine s��lectionn��e																										*/
	/* Sortie : nombre des d��fauts pour cette machine pendant la journ��e																		*/
	function nb_defaut_m ($jour,$machine,$conn) {
		$nb = 0;
		$req = "SELECT MAX(nb) AS nb FROM [ping2].[dbo].[graf] WHERE jour =  '$jour' AND  machine =  '$machine'";
    
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, $req, array(), array("Scrollable"=>"buffered"))); 
		$nb = $row['nb'];
		return $nb;
	}
	
	
	/* Fonction qui permet de compter le num��ro journalier des produit mauvais pour toutes les machines			*/
	/* Entre  : jour d'aujourd'hui																																					*/
	/* Sortie : nombre des d��fauts pour toutes les machines pendant la journ��e															*/
	function nb_defaut ($jour,$conn) {
		$nb = 0;
		$req = "SELECT max(nb) AS nb FROM [ping2].[dbo].[graftotal] WHERE jour = '$jour' ";
    
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, $req, array(), array("Scrollable"=>"buffered"))); 
		$nb = $row['nb'];
		return $nb;
	}
	
	/* Fonction permettante de calculer le par��to d'un d��faut pour la machine s��letionn��e										*/
	/* Entre  : defaut, nombre des d��fauts pour toutes les machines																					*/
	/* Sortie : pourcetage pour ce d��faut journalier																												*/
	function pareto($defaut,$nombre,$conn) {
		$type = 0;
    $req = "SELECT COUNT ([nom]) AS nb
						FROM [ping2].[dbo].[defaut] AS [defau]
						JOIN [ping2].[dbo].[tesysk_auto] AS [defec] ON [defau].[code] = [defec].[CodeDefaut]
						AND defau.nom LIKE  '%$defaut%'
						AND  cast(convert(char(8), [Date], 112) as int) =  cast(convert(char(8), GETDATE(), 112) as int)
						GROUP BY [defau].[nom]";
    
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, $req, array(), array("Scrollable"=>"buffered")));
		if($nombre != 0) {
			$type = round($row['nb']/$nombre*100,2);
		}
		return $type;
	}

?>