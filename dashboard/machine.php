<?php
	
	include 'util.php';
  require_once('../bdd.php');
  
  // DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
  
  include 'listMachine.php';
  
  // get machine
  $machine = $_GET['machine'];
	
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
				
				<!-- Machine name and export button -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Machine <?php echo $machine; ?>
							<button class="btn btn-primary btn-lg pull-right" id="export<?php echo $machine; ?>" style="margin-top: -3px" data-toggle="modal" data-target="#modalExport">
								<i class="fa fa-database fa-fw"></i>
								Exporter <?php echo $machine; ?>
							</button>
						</h1>
					</div>
				</div>
				
				<!-- Graphs -->
				<div class="row">
					<div class="row" id="graphMachine<?php echo $machine; ?>"></div>
				</div>
				
			</div>
		</div>
		
		<!-- Common Script Src Pool -->
		<?php include 'scripts.php'; ?>
	    
	  <script type="text/javascript">
	  	// refresh every 8s
		  setInterval(refreshMachine(<?php echo json_encode($machine); ?>), 8000);
	  </script>
		
		<!-- Modal Exporter -->
		<div class="modal fade" id="modalExport<?php echo $machine; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Exporter <?php echo $machine; ?></h4>
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