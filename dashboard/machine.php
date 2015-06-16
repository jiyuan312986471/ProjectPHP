<?php
	
	include 'util.php';
  require_once('../bdd.php');

  // DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
  
  // get time
  $date = date('Y-m-d');
  $heure = date('H:i');
  $jour = date('D');
  
  // get machine
  $machine = $_GET['machine'];
  
  // refresh
  echo '<META HTTP-EQUIV="Refresh" CONTENT="8; URL=machine.php?machine='.$machine.'">';
  
  
  /*******************************************
  				Pourcentage defauts graph
  ********************************************/
  // declare the percentage graph
	$graph = array("jour" => array("","","","","","",""), "pourc"	=> array(0,0,0,0,0,0,0));
	
	// get machine data
	$donne = file_get_contents('graph_'.$machine.'.dat');
	$n = sscanf($donne,"%f\t%f\t%f\t%f\t%f\t%f\t%f\n%s\t%s\t%s\t%s\t%s\t%s\t%s",
							$graph['pourc'][0], $graph['pourc'][1], $graph['pourc'][2], $graph['pourc'][3], $graph['pourc'][4], $graph['pourc'][5], $graph['pourc'][6],
							$graph['jour'] [0],	$graph['jour'] [1],	$graph['jour'] [2],	$graph['jour'] [3],	$graph['jour'] [4],	$graph['jour'] [5],	$graph['jour'] [6]);
	
	
	
  /*******************************************
  				Pareto des defauts graph
  ********************************************/
  // get machine data
	$nombre = file_get_contents("macdef/".$machine.".dat");
	
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
			$defaut7 = 'mont';
			   
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
			$defaut7 = 'mont';
			   
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
			$defaut6 = 'mont';
			    
			/* tension de retombée */
			$defaut7 = 'retomb';
			   
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
			$defaut6 = 'mont';
			    
			/* tension de retombée */
			$defaut7 = 'retomb';
			   
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
			$defaut6 = 'mont';
			    
			/* tension de retombée */
			$defaut7 = 'retomb';
			   
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
			$defaut3 = 'mont';
			        
			/* consommation  */
			$defaut4 = 'conso';
			 
			/* tension de retombée */
			$defaut5 = 'retomb';
			      
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
	
	// calculate paretos of each type
	$type1  = pareto_m($defaut1, $machine, $nombre, $conn);
	$type2  = pareto_m($defaut2, $machine, $nombre, $conn);
	$type3  = pareto_m($defaut3, $machine, $nombre, $conn);
	$type4  = pareto_m($defaut4, $machine, $nombre, $conn);
	$type5  = pareto_m($defaut5, $machine, $nombre, $conn);
	$type6  = pareto_m($defaut6, $machine, $nombre, $conn);
	$type7  = pareto_m($defaut7, $machine, $nombre, $conn);
	$type8  = pareto_m($defaut8, $machine, $nombre, $conn);
	$type9  = pareto_m($defaut9, $machine, $nombre, $conn);
	$type10 = pareto_m($defaut10,$machine, $nombre, $conn);
	
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
                                
                    <h1 class="page-header">Machine <?php echo $machine; ?></h1>
                </div>
            </div>
            <!-- defaut machine alertes -->
            <!-- corps -->
            <div class="row">
                    <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pourcentage Défauts <?php echo $machine; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="pourcDefaut"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->

                    <!-- notifications-->
              
                      <!-- notifications-->

                    <!-- /.panel .chat-panel -->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pareto des Défauts <?php echo $machine; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="paretoDefaut"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
         
                <!-- /.col-lg-4 -->
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
    <script type="text/javascript">
	    new Morris.Line({
			  // ID of the element in which to draw the chart.
			  element: 'pourcDefaut',
			  
			  // Chart data records -- each entry in this array corresponds to a point on the chart.
			  data: [
			    { nbr: '<?php echo convert_j($graph['jour'][0]);?>', valeur: <?php if(isset($graph['pourc'][0])) { echo $graph['pourc'][0];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graph['jour'][1]);?>', valeur: <?php if(isset($graph['pourc'][1])) { echo $graph['pourc'][1];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graph['jour'][2]);?>', valeur: <?php if(isset($graph['pourc'][2])) { echo $graph['pourc'][2];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graph['jour'][3]);?>', valeur: <?php if(isset($graph['pourc'][3])) { echo $graph['pourc'][3];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graph['jour'][4]);?>', valeur: <?php if(isset($graph['pourc'][4])) { echo $graph['pourc'][4];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graph['jour'][5]);?>', valeur: <?php if(isset($graph['pourc'][5])) { echo $graph['pourc'][5];} else { echo 0; } ?> },
			    { nbr: '<?php echo convert_j($graph['jour'][6]);?>', valeur: <?php if(isset($graph['pourc'][6])) { echo $graph['pourc'][6];} else { echo 0; } ?> },
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
			  element: 'paretoDefaut',
			  
			  // Chart data records -- each entry in this array corresponds to a point on the chart.
			  data: [
			    { pourcentage: '<?php echo $defaut1 ?>',  value: <?php if(isset($type1))  { echo $type1;  } else { echo 0; } ?> },
			    { pourcentage: '<?php echo $defaut2 ?>',  value: <?php if(isset($type2))  { echo $type2;  } else { echo 0; } ?> },
			    { pourcentage: '<?php echo $defaut3 ?>',  value: <?php if(isset($type3))  { echo $type3;  } else { echo 0; } ?> },
			    { pourcentage: '<?php echo $defaut4 ?>',  value: <?php if(isset($type4))  { echo $type4;  } else { echo 0; } ?> },
			    { pourcentage: '<?php echo $defaut5 ?>',  value: <?php if(isset($type5))  { echo $type5;  } else { echo 0; } ?> },
			    { pourcentage: '<?php echo $defaut6 ?>',  value: <?php if(isset($type6))  { echo $type6;  } else { echo 0; } ?> },
			    { pourcentage: '<?php echo $defaut7 ?>',  value: <?php if(isset($type7))  { echo $type7;  } else { echo 0; } ?> },
			    { pourcentage: '<?php echo $defaut8 ?>',  value: <?php if(isset($type8))  { echo $type8;  } else { echo 0; } ?> },
			    { pourcentage: '<?php echo $defaut9 ?>',  value: <?php if(isset($type9))  { echo $type9;  } else { echo 0; } ?> },
			    { pourcentage: '<?php echo $defaut10 ?>', value: <?php if(isset($type10)) { echo $type10; } else { echo 0; } ?> },
			  ],
			  // The name of the data record attribute that contains x-values.
			  xkey: 'pourcentage',
			  
			  // A list of names of data record attributes that contain y-values.
			  ykeys: ['value'],
			  
			  // Labels for the ykeys -- will be displayed when you hover over the chart.
			  labels: ['Pourcentage'],
			});
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

</body>

</html>
