<style>
	body{
		background-color:#ccc;
	}
</style>
<script src="../js/Chart.min.js"></script>
<script src="../js/utils.js"></script>
<style>
canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
</style>
<?php
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");

$err_msg="";
$msg_ajout="";
$msg_modif="";
$msg_dja="";

?>
<!--  graphic en donut -->

<script>
		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						87,
						997
					],
					backgroundColor: [
						window.chartColors.orange,
						window.chartColors.blue
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Reste à valider',
					'valider'
				]
			},
			options: {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Inscription 2019-2020'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		};

		
<!--  graphic en courbe -->

		var MONTHS = ['2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020'];
		var config2 = {
			type: 'line',
			data: {
				labels: ['2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020'],
				datasets: [{
					label: 'Femme',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						35,
						53,
						69,
						118,
						127,
						161,
						166,
						145,
						154,
						174,
						216,
						143
					],
					fill: false,
				}, {
					label: 'Homme',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: [
						159
						,220
						,326
						,474
						,523
						,603
						,686
						,609
						,631
						,696
						,867
						,445
					],
				}]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'evolution des inscriptions par genre par année'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Genre'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Nombre'
						}
					}]
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myDoughnut = new Chart(ctx, config);

			var ctx2 = document.getElementById('canvastwo').getContext('2d');
			window.myLine = new Chart(ctx2, config2);
		};
		
	</script>
<script type="text/javascript" src="../js/jquery.js"></script>
<table width="95%">
<tr><td>
	<div class="card border-primary">
					<div class="card-header">UFR</div>
					<div class="card-body">
						<h2 class="card-title">10</h2>
					</div>
				</div>
				<div class="card border-primary">
			<div class="card-header">Etudiants depuis la creation</div>
			<div class="card-body">
				<h2 class="card-title">3035</h2>
			</div>
		</div>
	</td>
	<td>
			<div id="canvas-holder" style="width:40%">
					<canvas id="chart-area"></canvas>
				</div>
	</td>
</tr>
<tr>	
	<td colspan='2'><hr/>
	</td>
	</tr>
	<tr>	
	<td colspan='2'>
				<canvas id="canvastwo"></canvas>
			</td></tr>
<table>
