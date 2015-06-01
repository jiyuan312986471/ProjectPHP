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
            <?php include('divs/logo.php');     ?>
  
             <!--  notification et logout  -->
             <?php include('divs/barre.php');     ?>

            <!-- Menu -->

            <?php include('divs/menu.php');     ?>
            </nav>

          <!-- Menu -->

        <!-- contenu -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Alertes</h1>
                </div>
            </div>
            <!-- defaut machine alertes -->
           

            <!-- corps -->
            <div class="row">
            
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                               
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Contact!
                                    <span class="pull-right text-muted small"><em>11:13</em>
                                    </span>
                                </a>

                                <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Motorisation!
                                    <span class="pull-right text-muted small"><em>11:13</em>
                                    </span>
                                </a>

                                <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Course!
                                    <span class="pull-right text-muted small"><em>11:13</em>
                                    </span>
                                </a>

                                <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Ressort!
                                    <span class="pull-right text-muted small"><em>11:13</em>
                                    </span>
                                </a>
                                  <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Course!
                                    <span class="pull-right text-muted small"><em>11:13</em>
                                    </span>
                                </a>
                                  <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Course!
                                    <span class="pull-right text-muted small"><em>11:13</em>
                                    </span>
                                </a>

                                <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Contact!
                                    <span class="pull-right text-muted small"><em>11:13</em>
                                    </span>
                                </a>
                                 <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Contact!
                                    <span class="pull-right text-muted small"><em>11:13</em>
                                    </span>
                                </a>
                                 <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Course!
                                    <span class="pull-right text-muted small"><em>11:13</em>
                                    </span>
                                </a>
                                  <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Course!
                                    <span class="pull-right text-muted small"><em>11:13</em>
                                    </span>
                                </a>
                              

                            </div>
                            <!-- /.list-group -->
                      
                        </div>
                        <!-- /.panel-body -->

                    </div>
                   
                        <!-- /.panel-footer -->

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
  element: 'test',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  
  data: [
    { nbr: 'A', valeur: '<?php echo 50; ?>' },
    { nbr: 'B', valeur: 56 },
    { nbr: 'C', valeur: 34 },
    { nbr: 'D', valeur: 28 },
    { nbr: 'E', valeur: 65 },
    { nbr: 'F', valeur: 32 },
    { nbr: 'G', valeur: 15 },
    { nbr: 'H', valeur: 8 },
    { nbr: 'I', valeur: 30 },
    { nbr: 'J', valeur: 18 },
    { nbr: 'K', valeur: 39 },
  

  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'nbr',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['valeur'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Valeur'],

 pointFillColors: ['#FF530D','#81530D','#BBD20D','#FF0000','#FF009D','#6F009D','#0953B4','#09DCB4','#046351','#E16351','#4C221C'],
   parseTime: false,
   hideHover: false,

});
    new Morris.Bar({
  // ID of the element in which to draw the chart.
  element: 'test2',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
  
    { pourcentage: '1', value: <?php echo 90; ?>},
    { pourcentage: '2', value: 60 },
    { pourcentage: '3', value: 55 },
    { pourcentage: '4', value: 30 },
    { pourcentage: '5', value: 20 },
    { pourcentage: '6', value: 20 },
    { pourcentage: '7', value: 15 },
    { pourcentage: '8', value: 59 },
    { pourcentage: '9', value: 95 },
    { pourcentage: '10', value: 44 },
    { pourcentage: '11', value: 70 },
    

  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'pourcentage',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Pourcentage']
});

    </script>

</body>

</html>
