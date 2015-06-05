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
  echo '<META HTTP-EQUIV="Refresh" CONTENT="8; URL=machineAll.php">';
  
  // declare 6 machines
  $listMachine = array("AK","SAK","DT1","DT2","SAD","DT3");
  
  // declare graph pourcentage
  $graphPourc = array();
  
  // declare graph pareto
  $graphPareto = array();
  
  // declare graph list of machines
  //$listMachineGraph = array();
  
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


<!----------------------------------------- FOR EACH MACHINE ----------------------------------------->
  
<?php

  foreach($listMachine as $machine) {
  	
  	////////////////////////////////// DATA PREPARATION //////////////////////////////////
  	
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
		$graphPareto = array_combine($listDefaut, $listPareto);
  	
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
								
		/*********************************
  	*	 COMBINE 2 GRAPH AND MACHINE	 *
  	*********************************/
  	// combine 2 graphs
  	$graph = array($graphPourc, $graphPareto);
  	
  	// combine machine with graph
  	$machineGraph = array($machine => $graph);
  	
  	// add combination into listMachineGraph
  	//array_push($listMachineGraph, $machineGraph);
  	
?>

<!------------------------------------ DRAW GRAPH OF EACH MACHINE ------------------------------------>
        	
        	<!-- header -->
        	<div class="row">
        		<div class="col-lg-12">
        			<h1 class="page-header">Machine <?php echo $machine; ?></h1>
        		</div>
        	</div>
        	
        	<!-- graphs -->
        	<div class="row">
        		
        		<!-- graphPourc -->
        		<div class="col-lg-6">
        			<div class="panel panel-default">
        				<div class="panel-heading">
        					Pourcentage Defauts <?php echo $machine; ?>
        				</div>
        				<div class="panel-body">
        					<div id="pourcDefaut<?php echo $machine ?>"></div>
        				</div>
        			</div>
        		</div>
        		
        		<!-- graphPareto -->
        		<div class="col-lg-6">
        			<div class="panel panel-default">
        				<div class="panel-heading">
        					Pareto des Defauts <?php echo $machine; ?>
        				</div>
        				<div class="panel-body">
        					<div id="paretoDefaut<?php echo $machine ?>"></div>
        				</div>
        			</div>
        		</div>
        		
        	</div>
        	
        </div>

    <script type="text/javascript">
	    new Morris.Line({
			  // ID of the element in which to draw the chart.
			  element: 'pourcDefaut<?php echo $machine ?>',
			  
			  // Chart data records -- each entry in this array corresponds to a point on the chart.
			  data: [
			    { nbr: '<?php echo convert_j($graphPourc['jour'][0]);?>', valeur: <?php if(isset($graphPourc['pourc'][0])) { echo $graphPourc['pourc'][0];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graphPourc['jour'][1]);?>', valeur: <?php if(isset($graphPourc['pourc'][1])) { echo $graphPourc['pourc'][1];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graphPourc['jour'][2]);?>', valeur: <?php if(isset($graphPourc['pourc'][2])) { echo $graphPourc['pourc'][2];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graphPourc['jour'][3]);?>', valeur: <?php if(isset($graphPourc['pourc'][3])) { echo $graphPourc['pourc'][3];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graphPourc['jour'][4]);?>', valeur: <?php if(isset($graphPourc['pourc'][4])) { echo $graphPourc['pourc'][4];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graphPourc['jour'][5]);?>', valeur: <?php if(isset($graphPourc['pourc'][5])) { echo $graphPourc['pourc'][5];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graphPourc['jour'][6]);?>', valeur: <?php if(isset($graphPourc['pourc'][6])) { echo $graphPourc['pourc'][6];} else { echo 0; } ?> },
			  ],
			  
			  // The name of the data record attribute that contains x-values.
			  xkey: 'nbr',
			  
			  // A list of names of data record attributes that contain y-values.
			  ykeys: ['valeur'],
			  
			  // Labels for the ykeys -- will be displayed when you hover over the chart.
			  labels: ['Pourcentage'],
			
			 	pointFillColors: ['#FF530D','#81530D','#BBD20D','#FF0000','#FF009D','#6F009D','#0953B4','#09DCB4','#046351','#E16351','#4C221C'],
			  parseTime: false,
			  hideHover: false,
			});
	
	    new Morris.Bar({
			  // ID of the element in which to draw the chart.
			  element: 'paretoDefaut<?php echo $machine ?>',
			  
			  // Chart data records -- each entry in this array corresponds to a point on the chart.
			  data: [
			  	<?php
			  		foreach(array_keys($graphPareto) as $defaut) {
			  			// get pareto
			  			$pareto = $graphPareto[$defaut];
			  			
			  			// draw with JS
			  			?>
			  			{ pourcentage: '<?php echo $defaut ?>',  value: <?php if(isset($pareto))  { echo $pareto;  } else { echo 0; } ?> },
			  			<?php
			  		}
			  	?>
			  ],
			  // The name of the data record attribute that contains x-values.
			  xkey: 'pourcentage',
			  
			  // A list of names of data record attributes that contain y-values.
			  ykeys: ['value'],
			  
			  // Labels for the ykeys -- will be displayed when you hover over the chart.
			  labels: ['Pourcentage'],
			});
    </script>

<?php
  } // end foreach machine
?>

	</div>
	</div>

<!------------------------------------------ PAGE STRUCTURE ------------------------------------------>

</body>
</html>