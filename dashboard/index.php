<?php

	include_once 'include/util.php';
	
	include 'conn.php';
	
	include 'include/listMachine.php';
	include 'include/listTypeProduit.php';
	include 'include/listDefaut.php';
	
	// Chercher des nb total et taux de defaut pour chaque machine
	$nbMachine = count($listMachine);
	$arrayNb = array();
	$arrayPourc = array();
	
	for($i = 0; $i < $nbMachine; $i++) {
		array_push($arrayNb, 0);
		array_push($arrayPourc, 0);
	}
	
	$paraMachine = array( "nb" 	=> $arrayNb, "pourc"	=> $arrayPourc );
	
	for($i = 0; $i < $nbMachine; $i++) {
		sscanf(nbdefaut($conn, $listMachine[$i]),  "%d %f",$paraMachine['nb'][$i], $paraMachine['pourc'][$i]);
	}
	
	$sum = 0;
	$sumdefaut = 0;
	for ($i = 0; $i < $nbMachine; $i++) {
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
	<!-- Head -->
	<?php include 'divs/head.php'; ?>
	
	<body>
		<!-- Configuration Modal -->
		<?php include 'divs/modalConfig.php'; ?>
		
		<div id="wrapper">
			<!-- NavBar -->
			<?php include 'divs/navbar.php'; ?>
			
			<!-- contenu -->
			<div id="page-wrapper">
				
				<!-- Three indices -->
				<div class="row">
					<div class="col-lg-12">
						<div class="page-header">
							<div class="row">
								
								<!-- Pourcentage Defaut -->
								<div class="col-md-4">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-comments fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge">
														<?php echo $nombre."%"; ?>
													</div>
													<div>Pourcentage Défaut</div>
												</div>
											</div>
										</div>
										<a href="#">
											<div class="panel-footer">
												<span class="pull-left">Voir</span>
												<span class="pull-right">
													<i class="fa fa-arrow-circle-right"></i>
												</span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
								</div>
								
								<!-- QG Graphique -->
								<div class="col-md-4">
									<div class="panel panel-green">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-tasks fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge"><?php echo $nbMachine; ?></div>
													<div>QG Graphique</div>
												</div>
											</div>
										</div>
										<a href="machineAll.php">
											<div class="panel-footer">
												<span class="pull-left">Voir</span>
												<span class="pull-right">
													<i class="fa fa-arrow-circle-right"></i>
												</span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
								</div>
								
								<!-- Alertes -->
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
												<span class="pull-right">
													<i class="fa fa-arrow-circle-right"></i>
												</span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
								</div>
								
							</div>
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
				
			</div>
		</div>
		
		<!-- Common Script Src Pool -->
		<?php include 'include/scripts.php'; ?>
		
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
	
	</body>
</html>