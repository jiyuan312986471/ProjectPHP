<?php

	include_once 'util.php';
	include_once '../bdd.php';
	
	// DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
	
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
			<!-- jQuery -->
	    <script src="js/jquery.js"></script>
	    
	    <!-- Show Clock -->
			<script src="js/MyDigitClock.js"></script>
		
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
	                    <div class="page-header">
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
	                    </div>
	                </div>
	            </div>
	            
	
	            <!-- corps -->
	            <div class="row">
	            		<div class="col-lg-12">
	            				<div class="panel panel-primary">
	                        <div class="panel-heading">
	                            <h4>Pourcentage Défauts Usine</h4>
	                        </div>
	                        <div class="panel-body">
	                            <div id="pourcUsine"></div>
	                        </div>
	                        <div class="panel-footer">
	                        	<!-- Modal Exporter Trigger -->
	                        	<button type="button" class="btn btn-primary" id="exportAll" data-toggle="modal" data-target="#modalExport">
	                        		<i class="fa fa-database fa-fw"></i>
	                        		Exporter
	                        	</button>
														
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <!-- corps -->
	        </div>
	        <!-- contenu -->
	        
	    </div>
	    <!-- /#wrapper -->
	    
	    
	    <!-- Bootstrap Core JavaScript -->
	    <script src="js/bootstrap.js"></script>
	
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
	    
	    <script language="javascript">
	    	// refresh every 8s
	    	setInterval(refreshIndex(), 8000);
	    </script>
	
			<!-- Modal Exporter -->
			<div class="modal fade" id="modalExport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Exporter</h4>
						</div>
						<div class="modal-body">
							...
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary">Exporter</button>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Modal Configer -->
			<div class="modal fade bs-example-modal-lg" id="modalConfig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Configuration</h4>
						</div>
						<div class="modal-body">
							...
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary">Valider</button>
						</div>
					</div>
				</div>
			</div>
	
	</body>
</html>
