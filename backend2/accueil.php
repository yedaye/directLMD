<?php
session_start();
if(!isset($_SESSION['nom'])){
	header("location:index.php?reset");	
}
include_once("../connect/co.php");
include_once("../param.php");
include_once ("../functions/queries.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ESPACE ADMIN UNA</title>

   
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	 <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">DIRECT LMD v2.0</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Tâche 1</strong>
                                    <span class="pull-right text-muted">
                                        <em>Chef Sco</em>
                                    </span>
                                </div>
                                <div>Importer les autorisations des DEAT</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Tâche 2</strong>
                                    <span class="pull-right text-muted">
                                        <em>Landry</em>
                                    </span>
                                </div>
                                <div>Vérifier la conformité des curriculas</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Toutes les tâches</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i><?php echo $_SESSION['nom']." ".$_SESSION['prenoms'];  ?> </a></li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Profil </a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="index.php?reset"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="?accueil"><i class="fa fa-dashboard fa-fw"></i> TABLEAU DE BORD</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Inscription<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="?page=fiche">Imprimer la fiche</a>
                                </li>
                                <li>
                                    <a href="?page=validation">Valider une inscription</a>
                                </li>
								<li>
                                    <a href="?page=liste_etu">Liste des étudiants par année</a>
                                </li>
								<li>
                                    <a href="?page=liste_result_ecu">Note par filiere</a>
                                </li>
								<li>
                                    <a href="?page=resultat_ecu">Note par etudiant</a>
                                </li>
                                <li>
                                    <a href="?page=penalite">Pénalité</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-bar-chart-o fa-fw"></i> Administration<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
                                <li>
                                    <a href="?page=autorisation">Autorisation</a>
                                </li>
								<li>
                                    <a href="?page=resultatbac">Résultat BAC</a>
                                </li>
								<li>
                                    <a href="?page=mapping">Mapping Filière</a>
                                </li>
								<li>
                                    <a href="?page=parametre">Critère validation</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-wrench fa-fw"></i> Configuration<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
                                <li>
                                    <a href="?page=ufr">UFR</a>
                                </li>
								<li>
                                    <a href="?page=ecole_ufr">Ecoles</a>
                                </li>
								<li>
                                    <a href="?page=annee_acad">Année Académique</a>
                                </li>
								<li>
                                    <a href="#">Gestion Curricula</a>
									 <ul class="nav nav-third-level">
                                        <li>
                                            <a href="?page=curiculla">Imprimer Curricula</a>
                                        </li>
                                        <li>
                                            <a href="?page=ue_new">Gestion des UEs</a>
                                        </li>
                                        <li>
                                            <a href="?page=ecu_new">Gestions des Ecus</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
								<li>
                                    <a href="?page=pays">Pays</a>
                                </li>
                                <li>
                                    <a href="?page=statut">Statut</a>
                                </li>
								<li>
                                    <a href="?page=zone">Zone</a>
                                </li>
								<li>
                                    <a href="?page=montant">Montant</a>
                                </li>
								<li>
                                    <a href="?page=type">Type Autorisation</a>
                                </li>
								<li>
                                    <a href="?page=option">Diplome (Option)</a>
                                </li>
								<li>
                                    <a href="?page=user">Utilisateur</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
		
		<!----  DEBUT DE LA PAGE INTERNE --->
		
	<?php   
		if(isset($_GET['accueil'])){
		?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
			<br/>
			<!-- breve statistic -->
                <div class="row">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-comments fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">
											<?php
												$nombre=requete("SELECT count(*) as val FROM inscription WHERE annee_academique='".$anneeEtude."'");
												echo $nombre[0]['val'].'</br>';
											?>
										</div>
										<div>Préinscription</div>
									</div>
								</div>
							</div>
							<!--a href="#">
								<div class="panel-footer">
									<span class="pull-left">View Details</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a-->
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-green">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-tasks fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">
											<?php
												$nombre=requete("SELECT count(*) as val FROM inscription WHERE annee_academique='".$anneeEtude."' AND controle='OUI'");
												echo $nombre[0]['val'];
											?>
										</div>
										<div>Validations</div>
									</div>
								</div>
							</div>
							<!--a href="#">
								<div class="panel-footer">
									<span class="pull-left">View Details</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a-->
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-yellow">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-plus-square fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">
											<?php
												$nombre=requete("SELECT count(*) as val FROM  `student` WHERE  `matricule` LIKE  '%17UNA'");
												echo $nombre[0]['val'];
											?>
										</div>
										<div>Nouveau</div>
									</div>
								</div>
							</div>
							<!--a href="#">
								<div class="panel-footer">
									<span class="pull-left">View Details</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a-->
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-red">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-support fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">
											<?php
												$nombre=requete("SELECT count(*) as val FROM  `ecole_ufr` WHERE  actif='1'");
												echo $nombre[0]['val'];
											?>
										</div>
										<div>Ecoles</div>
									</div>
								</div>
							</div>
							<!--a href="#">
								<div class="panel-footer">
									<span class="pull-left">View Details</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a-->
						</div>
					</div>
				</div>
				<!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        
		            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Statistique Genre
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Promotion</th>
                                                    <th>Femmes</th>
                                                    <th>Hommes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
													$nombre=requete("SELECT DISTINCT promotion FROM student ORDER BY promotion ASC");
													//print_r($nombre);
													for($i=0;$i<count($nombre);$i++){
														echo "<tr><td>".$nombre[$i]['promotion']."</td>";
															$nombre2=requete("SELECT count(*) as val , sexe FROM student WHERE promotion ='".$nombre[$i]['promotion']."' GROUP BY sexe");
															for($a=0;$a<count($nombre2);$a++){
																echo "<td>".$nombre2[$a]['val']."</td>";
															}
														echo "</tr>";
													}
												
												?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-6">
							        <div id="morris-bar-chart"></div>
									<!--div id="morris-area-chart"></div-->
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications Panel
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small"><em>12 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small"><em>27 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small"><em>43 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small"><em>11:32 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Server Crashed!
                                    <span class="pull-right text-muted small"><em>11:13 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-warning fa-fw"></i> Server Not Responding
                                    <span class="pull-right text-muted small"><em>10:57 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed
                                    <span class="pull-right text-muted small"><em>9:49 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-money fa-fw"></i> Payment Received
                                    <span class="pull-right text-muted small"><em>Yesterday</em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
		</div>
        <!-- /#page-wrapper -->
	<?php  
		}
		if(isset($_GET['page'])){
		?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
			<br/>
			<!-- breve statistic -->
                <div class="row">
					<div class="col-lg-12 col-md-12">
                    <?php

                        include("page/".$_GET['page'].'.php');
                        
                    }
                    
                ?>
                 </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    	</div>
        <!-- /#page-wrapper -->
	
		<!---- FIN DE LA PAGE INTERNE  ---->
	
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

	<?php   
		if(isset($_GET['accueil'])){
	?>
		<!-- Morris Charts JavaScript -->
		<script src="vendor/raphael/raphael.min.js"></script>
		<script src="vendor/morrisjs/morris.min.js"></script>
		<script src="data/morris-data.js"></script>
	<?php   
		}
	?>
    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
	<?php   
		if(isset($_GET['accueil'])){
		
			$aff="<script type='text/javascript'>
			$(function() {
				Morris.Bar({
					element: 'morris-bar-chart',
					data: [";
			for($i=0;$i<count($nombre);$i++){
				$aff.="{y:'".$nombre[$i]['promotion']."',";
					$nombre2=requete("SELECT count(*) as val , sexe FROM student WHERE promotion ='".$nombre[$i]['promotion']."' GROUP BY sexe");
					$texte='a';
					
					for($a=0;$a<count($nombre2);$a++){
						$aff.=$texte.":".$nombre2[$a]['val'].",";
						$texte='b';
					}
					$aff=substr($aff,0,-1);
					$aff.="},";
			}
			$aff=substr($aff,0,-1);
			echo $aff;
			
		
		echo "],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Femmes', 'Hommes'],
				hideHover: 'auto',
				resize: true
			});
		});
		</script>";
		}
	?>
	
</body>

</html>
