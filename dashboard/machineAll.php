<?php

	/***********************************************************
  *																													 *
	*											FOR	THE PAGE		  									 *
  *																													 *
  ***********************************************************/
	
	include 'util.php';
  require_once('../bdd.php');

  // DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
	
	include 'listMachine.php';
  
  // get time
  $date = date('Y-m-d');
  $heure = date('H:i');
  $jour = date('D');
  
  // declare graph pourcentage
  $graphPourc = array();
  
  // declare graph pareto
  $graphPareto = array();
  
  // all graph pourcentage
  $listGraphPourc = array();
  
  // all graph pareto
  $listGraphPareto = array();
  
  // machine -> graphPourc
  $listMachineGraphPourc = array();
  
  // machine -> graphPareto
  $listMachineGraphPareto = array();
  
?>


<!------------------------------------------ PAGE STRUCTURE ------------------------------------------>

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

			<!-- JSON -->
		  <script src="js/json2.js"></script>
		
		  <!-- Initialize Display Option JavaScript -->
		  <script language="javascript">
		  	// listOption
		  	var listOption 	= new Array("pourc","pourc","pourc","pourc","pourc","pourc");
		   		
		  	// listMachine
		  	var listMachine = <?php echo json_encode($listMachine); ?>;
		   		
		  	// create OptionMachine
		  	var optionMachine = {};
		   		
		  	// combine 
		  	for(var index in listMachine){
		  		optionMachine[listMachine[index]] = listOption[index];
		  	}
		  </script>
				
      <!-- contenu -->
      <div id="page-wrapper">
        
        <!-- Title -->
      	<div class="row">
      		<div class="col-lg-12">
      			<h1 class="page-header">
      				Machines
      			</h1>
      		</div>
        </div>
        
        <!-- Graphs -->
       	<div class="row" id="graphs">

<!----------------------------------------- FOR EACH MACHINE ----------------------------------------->
  
<?php

  foreach($listMachine as $machine) {
  	
  	////////////////////////////////// DATA PREPARATION //////////////////////////////////
  	
  	// POURCENTAGE GRAPH
		$graphPourc = getPourcGraphData($machine);
  	
		// PARETO GRAPH
  	$graphPareto = getParetoGraphData($machine, $conn);
  	$listDefaut = array_keys($graphPareto);
  	$listPareto = array_values($graphPareto);
  	
		// push datas into graph lists
		array_push($listGraphPourc, $graphPourc);
		array_push($listGraphPareto, $graphPareto);
								
?>
        	
        	<!-- panel for machine -->
	       	<div class="col-lg-6">
	        	<div class="panel panel-success" id="graphMachine<?php echo $machine; ?>"></div>
		      </div>

<?php
  } // end foreach machine
?>

				</div>
				
			</div>
		</div>

<!------------------------------------------ PAGE STRUCTURE ------------------------------------------>

<?php

	// map machine list (as keys) with graphPourc list (as values)
	$listMachineGraphPourc = array_combine($listMachine, $listGraphPourc);
	
	// map machine list (as keys) with graphPareto list (as values)
	$listMachineGraphPareto = array_combine($listMachine, $listGraphPareto);

?>

		<!-- Common Script Src Pool -->
		<?php include 'scripts.php'; ?>
		
		<!-- MUTATION OBSERVER-->
		<script language="javascript">
			// prepare mutation observer
			var MutationObserver = window.MutationObserver || window.WebKitMutationObserver ||  window.MozMutationObserver;
			var mutationObserverSupport = !!MutationObserver;
			
			// set callback function
			var callback = function(mutationRecords){
				// get mutation record
		    mutationRecords.forEach(function(mutationRecord){
		    	// get node
		    	var node = mutationRecord.target;
		    	
		    	// check class value
		    	if(node.attributes["class"].value.indexOf("active") >= 0) { // button active    		
		    		// get id
		    		var idTarget = node.attributes["id"].value;
		    		
		    		// Pourcentage button
		    		if(idTarget.indexOf("Pourcentage") >= 0) {
		    			// get machine
		    			var machine = idTarget.substring("Pourcentage".length);
		    			
		    			// set option
		    			var option = "pourc";
		    			optionMachine[machine] = option;
		    			
		    			// prepare parametres for AJAX
		    			var url = "ajaxPrepareGraphData.php";
		    			var datas = {
		    				machine: machine,
		    				option:	option,
		    				listMachineGraphPourc: <?php echo json_encode($listMachineGraphPourc); ?>,
		    			};
		    			
		    			// send data to AJAX
		    			$.post(url, datas, function(graphPourc){
		    														changeToGraphPourc(machine, graphPourc);
		    												 });
		    		}
		    		
		    		// Pareto button
		    		else if(idTarget.indexOf("Pareto") >= 0) {
		    			// get machine
		    			var machine = idTarget.substring("Pareto".length);
		    			
		    			// set option
		    			var option = "pareto";
		    			optionMachine[machine] = option;
		    			
		    			// prepare parametres for AJAX
		    			var url = "ajaxPrepareGraphData.php";
		    			var datas = {
		    				machine: machine,
		    				option:	option,
		    				listMachineGraphPareto: <?php echo json_encode($listMachineGraphPareto); ?>,
		    			};
		    			
		    			// send data to AJAX
		    			$.post(url, datas, function(graphPareto){
		    														changeToGraphPareto(machine, graphPareto);
		    												 });
		    		}
		    		
		    		// refresh after change
		    		var jsonOptionMachine = JSON.stringify(optionMachine);
		    		setInterval(refreshMachineAllGraph(jsonOptionMachine), 8000);
		    	}
		    });
			};
			
			// create mutation observer
			var mo = new MutationObserver(callback);
			
			// set element
			var element = document.getElementById('graphs');
		
			// set option
			var observerOption = {
			    attributes: true,
			    attributeFilter: ["class"],
			    subtree: true
			};
			
			// start observer
			mo.observe(element, observerOption);
			
			// draw graph and refresh
		  var jsonOptionMachine = JSON.stringify(optionMachine);
		  setInterval(refreshMachineAllGraph(jsonOptionMachine), 8000); // 8 seconds
		</script>
		
		<!-- Modals Exporter -->
		<?php foreach($listMachine as $machine) { ?>
			<div class="modal fade" id="modalExport<?php echo $machine; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<!-- Modal Header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Exporter <?php echo $machine; ?></h4>
						</div>
						
						<!-- Modal Body-->
						<div class="modal-body">
							...
						</div>
						
						<!-- Modal Footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-primary">Exporter</button>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		
	</body>
</html>