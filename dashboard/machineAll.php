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
  
  // get time
  $date = date('Y-m-d');
  $heure = date('H:i');
  $jour = date('D');
  
  // refresh
  //echo '<META HTTP-EQUIV="Refresh" CONTENT="8; URL=machineAll.php">';
  
  // declare 6 machines
  $listMachine = array("AK","SAK","DT1","DT2","SAD","DT3");
  
  // declare graph pourcentage
  $graphPourc = array();
  
  // declare graph pareto
  $graphPareto = array();
  
  // initialize display option
  $listOption = array("pourc","pourc","pourc","pourc","pourc","pourc");
  $optionMachine = array_combine($listMachine, $listOption);
  
?>


<!------------------------------------------ PAGE STRUCTURE ------------------------------------------>

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
		<!------- JAVASCRIPT ------->
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
    
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
       		<?php
       			include('divs/logo.php');
       			//notification et logout
            include('divs/barre.php');
            //Menu
            include('divs/menu.php');
          ?>
        </nav>

        <!-- contenu -->
        <div id="page-wrapper">
        	
        	<div class="row">
        		<div class="col-lg-12">
        			<h1 class="page-header">
        				Machines
        			</h1>
        		</div>
          </div>
          
        	<div class="row">


<!----------------------------------------- FOR EACH MACHINE ----------------------------------------->
  
<?php

  foreach($listMachine as $machine) {
  	
  	////////////////////////////////// DATA PREPARATION //////////////////////////////////
  	
  	/*********************************
  	*					DISPLAY OPTION				 *
  	*********************************/
  	$option = $optionMachine[$machine];
  	
  	/*********************************
  	*					PARETO GRAPH					 *
  	*********************************/		
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
		
		// combine pareto array(value) with defaut array(key)
		//$graphPareto = array_combine($listDefaut, $listPareto);
  	
  	/*********************************
  	*					POURC GRAPH						 *
  	*********************************/
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
								
?>

<!------------------------------------ DRAW GRAPH OF EACH MACHINE ------------------------------------>
        	
	        	<!-- panel for machine -->
	        	<div class="col-lg-6">
		        	<div class="panel panel-success" id="graphMachine<?php echo $machine; ?>"></div>
			      </div>
		
		<!-- Draw Chosen Graph -->
    <script language="javascript">
    	start(
    		<?php echo json_encode($machine); ?>,
    		<?php echo json_encode($option); ?>,
    		<?php echo json_encode($graphPourc); ?>,
    		<?php echo json_encode($listDefaut); ?>,
    		<?php echo json_encode($listPareto); ?>
    	);
    </script>

<?php
  } // end foreach machine
?>

					</div>
				</div>
		</div>

<!------------------------------------------ PAGE STRUCTURE ------------------------------------------>

</body>
</html>