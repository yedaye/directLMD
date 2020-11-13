<?php   
session_start();
include_once ("functions/queries.php");
include("connect/co.php");
include("param.php");
$nombre=0;	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Espace privé UNA</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	text-align: center;
	font-size: 14px;
}

</style>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
<link rel="stylesheet" type="text/css" href="../js/default/easyui.css">  
<link rel="stylesheet" type="text/css" href="../js/icon.css"> 
<link rel="stylesheet" href="../js/graphe/TableBarChart.css" />
<script type="text/javascript" src="../js/graphe/TableBarChart.js"></script>
<script type="text/javascript">
    $(function() {
        $('#source4').tableBarChart('#target4', '', false);
    });
</script>
</head>

<body>
    <table width="95%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr><td colspan="2" align="center" bgcolor="#6699FF"><b>STATISTIQUE DES PREINSCRIPTIONS</b></td></tr>
     <tr>
    <td width="90%">
	<?php
	$rs = mysql_query("SELECT ecole, count(*) as nombre FROM `inscription`, filiere Where annee_academique='".$an."' AND filiere.code=inscription.filiere GROUP BY filiere.ecole ORDER BY filiere.ecole"); 
	if(mysql_num_rows($rs)>0){
		echo "<table id='source4' width='95%' border='0' cellpadding='0' cellspacing='2'>
				<caption>Graphique du nombre d'inscription par ecole</caption> <!-- optional -->
    			<thead>               <!-- Must have -->
					<tr style='background-color:#FFFCCC; font-size:20px'>
						<th></th>       <!-- Must have an empty <th> here -->
						<th>Nombre d'étudiant</th> <!-- Must have -->
						...
					</tr>
    			</thead>
    			<tbody><!-- Must have -->";
				$element=mysql_fetch_assoc($rs);
				$nombre1=0;
				$color='#FFAFAA';
				do{			
					echo "<tr style='background-color:".$color."; font-size:20px'>
            		<th>".$element['ecole']."</th>    <!-- First cell of each row must be <th> -->
            		<td>".$element['nombre']."</td>    <!-- Data cell must be <td> -->
           	 		....
        			</tr>
        			...             <!-- Repeat above pattern -->";
					if($color!=""){
						$color="";
					}else{
						$color='#FFAFAA';
					}
					$nombre+=$element['nombre'];
				}while($element=mysql_fetch_assoc($rs));
    			echo "</tbody>
				<tfoot style='background-color:#FFFCCC; font-size:20px'><td align='center'><b>Total</b></td><td>".$nombre."</td></tfoot>
				</table><br/><br/>"; 
			?>
    </td>
  </tr>
  </table>
</body>
</html>