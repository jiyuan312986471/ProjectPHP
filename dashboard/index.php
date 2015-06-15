<?php

	include_once 'util.php';
	include_once '../pers.php';
	include_once '../bdd.php';
	
	// DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
	
	// get time
  $date  = date('Y-m-d');
  $heure = date('H:i');
  $jour  = date('D');
  
  // refresh in order to keep informed
	//echo '<META HTTP-EQUIV="Refresh" CONTENT="8; URL=index.php">';
	
	// get pourcentage graph
	$graph = getPourcGraphData("All");

	// set date format
	if($graph['jour'][6] != date('D')) {		
		// algo with count
		for($i = 0; $i < count($graph['pourc'])-1; $i++) {
			$graph['pourc'][$i] = $graph['pourc'][$i+1];
		}
		
		$graph['pourc'][6] = 0;
		
		$graph['jour'][6] = date('D');
			
		$date = new DateTime();
		for($i = 0; $i < 6; $i++) {
			$date->add(new DateInterval('P1D'));
			if ($date->format('N')<8) {
				$graph['jour'][$i]=$date->format('D');
			}
		}
	}
	
	// Chercher des nb total et taux de defaut pour chaque machine
	$paraMachine = array( "nb" 	=> array(0,0,0,0,0,0), "pourc"	=> array(0,0,0,0,0,0) );
	
	sscanf(nbdefaut($conn,'AK'),  "%d %f",$paraMachine['nb'][0], $paraMachine['pourc'][0]);
	sscanf(nbdefaut($conn,'SAK'), "%d %f",$paraMachine['nb'][1], $paraMachine['pourc'][1]);
	sscanf(nbdefaut($conn,'DT1'), "%d %f",$paraMachine['nb'][2], $paraMachine['pourc'][2]);
	sscanf(nbdefaut($conn,'DT2'), "%d %f",$paraMachine['nb'][3], $paraMachine['pourc'][3]);
	sscanf(nbdefaut($conn,'DT3'), "%d %f",$paraMachine['nb'][4], $paraMachine['pourc'][4]);
	sscanf(nbdefaut($conn,'SAD'), "%d %f",$paraMachine['nb'][5], $paraMachine['pourc'][5]);
	
	$sum = 0;
	$sumdefaut = 0;
	for ($i = 0; $i < count($paraMachine['nb']); $i++) {
		$sum = $paraMachine['nb'][$i] + $sum;
		$sumdefaut = $paraMachine['nb'][$i] * $paraMachine['pourc'][$i] + $sumdefaut;
	}
	
	if($sum == 0) {
		$nombre = 0;
	}
	else {
		$nombre = round($sumdefaut/$sum,2);
	}
	
	//GraphTotal
  if($graph['pourc'][6]!= $nombre) {
  	$graph['pourc'][6] = $nombre;
	}
	
	// Enregistrer des données dans le graph.bat
	$donne = sprintf("%f\t%f\t%f\t%f\t%f\t%f\t%f\n%s\t%s\t%s\t%s\t%s\t%s\t%s", 
										$graph['pourc'][0],$graph['pourc'][1],$graph['pourc'][2],$graph['pourc'][3],$graph['pourc'][4],$graph['pourc'][5],$graph['pourc'][6],
										$graph['jour'][0], $graph['jour'][1], $graph['jour'][2], $graph['jour'][3], $graph['jour'][4], $graph['jour'][5], $graph['jour'][6] );
	file_put_contents('graph.dat', $donne);
	
	// set date display format
	foreach($graph['jour'] as &$jour){
		$jour = convert_j($jour);
	}
	
	// encode graph into json
	$jsonGraph = json_encode($graph);
	
?>


<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <title>Schneider Application</title>
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
	    <link href="css/plugins/timeline.css" rel="stylesheet">
	    <link href="css/sb-admin-2.css" rel="stylesheet">
	    <link href="css/plugins/morris.css" rel="stylesheet">
	    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
	    <div id="wrapper">
	
	        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: auto">
	            <?php
	            	// Logo Schneider
	            	include('divs/logo.php');
	            	// Notification et Logout
	             	include('divs/barre.php');
	          		// Menu
	          		include('divs/menu.php');
	          	?>
	        </nav>
	
	        <!-- contenu -->
	        <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
	                    <center><h1 class="page-header"></h1></center>
	                </div>
	            </div>
	            <!-- defaut machine alertes -->
	            <div class="row">
	                <div class="col-md-4">
	                    <div class="panel panel-primary">
	                        <div class="panel-heading">
	                            <div class="row">
	                                <div class="col-xs-3">
	                                    <i class="fa fa-comments fa-5x"></i>
	                                </div>
	                                <div class="col-xs-9 text-right">
	                                    <div class="huge">
	                                    	<?php
	                                    		echo $nombre."%";
	                                    	?>
	                                    </div>
	                                    <div>Pourcentage Défaut</div>
	                                </div>
	                            </div>
	                        </div>
	                        <a href="#">
	                            <div class="panel-footer">
	                                <span class="pull-left">Voir</span>
	                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                                <div class="clearfix"></div>
	                            </div>
	                        </a>
	                    </div>
	                </div>
	                <div class="col-md-4">
	                    <div class="panel panel-green">
	                        <div class="panel-heading">
	                            <div class="row">
	                                <div class="col-xs-3">
	                                    <i class="fa fa-tasks fa-5x"></i>
	                                </div>
	                                <div class="col-xs-9 text-right">
	                                    <div class="huge">6</div>
	                                    <div>QG Graphique</div>
	                                </div>
	                            </div>
	                        </div>
	                        <a href="machineAll.php">
	                            <div class="panel-footer">
	                                <span class="pull-left">Voir</span>
	                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                                <div class="clearfix"></div>
	                            </div>
	                        </a>
	                    </div>
	                </div>
	                <div class="col-md-4">
	                    <div class="panel panel-red">
	                        <div class="panel-heading">
	                            <div class="row">
	                                <div class="col-xs-3">
	                                    <i class="fa fa-support fa-5x"></i>
	                                </div>
	                                <div class="col-xs-9 text-right">
	                                    <div class="huge">
	                                    	<?php
	                                    		if(isset($Nbalert)){
	                                    			echo $Nbalert;
	                                    		}
	                                    		else {
	                                    			echo 0;
	                                    		}
	                                    	?>
	                                    </div>
	                                    <div>Alertes</div>
	                                </div>
	                            </div>
	                        </div>
	                        <a href="alertes.php">
	                            <div class="panel-footer">
	                                <span class="pull-left">Voir</span>
	                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                                <div class="clearfix"></div>
	                            </div>
	                        </a>
	                    </div>
	                </div>
	            </div>
	            <!-- defaut machine alertes -->
	
	            <!-- corps -->
	            <div class="row">
	            		<div class="col-lg-12">
	            				<div class="panel panel-default">
	                        <div class="panel-heading">
	                            Pourcentage Défauts Usine
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
	                            <div id="pourcUsine"></div>
	                        </div>
	                        <!-- /.panel-body -->
	                    </div>
	                    <!-- /.panel -->
	                </div>
	                <!-- /.col-lg-6 -->
	
	                <!-- notifications-->
	
	            </div>
	            <!-- corps -->
	        </div>
	        <!-- contenu -->
	    </div>
	    <!-- /#wrapper -->
	    
	    <!-- jQuery -->
	    <script src="js/jquery.js"></script>
	
	    <!-- Bootstrap Core JavaScript -->
	    <script src="js/bootstrap.min.js"></script>
	
	    <!-- Metis Menu Plugin JavaScript -->
	    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
	
	    <!-- Morris Charts JavaScript -->
	    <script src="js/plugins/morris/raphael.min.js"></script>
	    <script src="js/plugins/morris/morris.min.js"></script>
	    <script src="js/plugins/morris/morris-data.js"></script>
	
	    <!-- Custom Theme JavaScript -->
	    <script src="js/sb-admin-2.js"></script>
	    
	    <!-- Functions used JavaScript -->
   		<script src="js/util.js"></script>
	    
	    <script type="text/javascript">
	    	drawPourcGraph("All", <?php echo $jsonGraph; ?>);
	    </script>
	
	</body>
</html>
