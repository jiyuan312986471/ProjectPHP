<?php
	
	include 'util.php';
  require_once('../bdd.php');

  // DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
  
  // get machine
  $machine = $_GET['machine'];
	
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Schneider application</title>
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
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<?php
				// logo schneider
				include('divs/logo.php');
				
				// notification et logout
				include('divs/barre.php');
				
				// Menu
				include('divs/menu.php');
			?>
		</nav>
		
		<!-- contenu -->
		<div id="page-wrapper">
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
			
			<div class="row">
				<div class="row" id="graphMachine<?php echo $machine; ?>"></div>
			</div>
			
		</div>
		
	</div>
	
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
    
  <!-- JS Functions -->
  <script src="js/util.js"></script>
    
  <script type="text/javascript">
  	// refresh every 8s
	  setInterval(refreshMachine(<?php echo json_encode($machine); ?>), 8000);
  </script>

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
	
	<!-- Modal Exporter -->
	<div class="modal fade" id="modalExport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
