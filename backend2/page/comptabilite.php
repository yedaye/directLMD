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

///action pour l'ajout d'une UFR
if(isset($_POST['code'])){
	//controle de l'existance

}


?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="../js/graphe/TableBarChart.css" />
<script type="text/javascript" src="../js/graphe/TableBarChart.js"></script>
<script type="text/javascript">
    $(function() {
        $('#source').tableBarChart('#target', '', false);
		$('#source2').tableBarChart('#target2', '', false);
		$('#source3').tableBarChart('#target3', '', false);
    });
</script>
<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#list_ue').dataTable({	
		"sPaginationType":"full_numbers",
		"oLanguage":{
			"sLengthMenu":"Afficher _MENU_ informations par page",
			"sZeroRecords":"Aucun resultat",
			"sInfo":"Liste de _START_ à _END_ sur _TOTAL_ ",
			"sInfoEmpty":"Liste de 0 à 0 sur 0",
			"sInfoFiltered":"(filtré à partir de _MAX_ enregistrements)"	
		}
	});	
});

function submitForm(form){
	$('#'+form).form('submit');
}
function clearForm(form){
	$('#'+form).form('clear');
}

function suppression(val){
	 $.messager.confirm('Confirm','Voulez vous supprimer cette UE : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_ue.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?ue&supOK";
				}
			});  
		}  
	});  	
}

</script>
<style type="text/css" title="styledatatable">
	@import "../css/demo_table.css";
	div.dataTables_filter{
	}
	div.dataTables_lenght{
	}
	div.dataTables_info{
	}
	div.dataTables_paginate{
	}
	
</style>
<div id="haut"><center>
GESTION DE LA COMPTABILITE LIEE DE LA SCOLARITE
</center></div>
<hr/>

 <form action="" method="get">
        Filtrer par Année Académique : <select required="true" name="annee2" id="annee2">
      <?php
			$ufr=selTableDataDesc("annee_academique","lib_annee");
				for($i=0;$i<count($ufr);$i++){
					$select="";
					if(isset($_GET['annee2']) && $_GET['annee2']==$ufr[$i]['lib_annee']){ $select="selected";}
					echo "<option value='".$ufr[$i]['lib_annee']."' ".$select.">".strtoupper($ufr[$i]['lib_annee'])."</option>";
				}	
			?>
    </select>
    <?php
if(in_array("uak",$_SESSION['etablissement'])){
?>
     Filtrer par Etablissement : <select name="ecoles" id="ecoles">
      <?php
			$ufr=selTableDataDesc("ecole_ufr","code_ecole");
				echo "<option value=''>Selectionner un etablissement</option>";
				for($i=0;$i<count($ufr);$i++){
					$select="";
					if(isset($_GET['ecoles']) && $_GET['ecoles']==$ufr[$i]['code_ecole']){ $select="selected";}
					echo "<option value='".$ufr[$i]['code_ecole']."' ".$select.">".strtoupper($ufr[$i]['code_ecole'])."</option>";
				}	
			?>
    	</select>
   <?php
		}
	?>
    <input name="comptabilite" type="hidden" value="" /><input name="Envoyer" type="submit" value="Filtrer" />
        </form>
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr><td></td><td></td></tr>
  <tr>
    <td width="48%" style="padding-right:10px">
<?php
if(isset($_GET['annee2'])){
		$an=$_GET['annee2'];	
	}else{
		$an=$anneeEtude;		
	}
	$where="";
	if(isset($_GET['ecoles']) && $_GET['ecoles']!=""){
		if($_GET['ecoles']=='CAG'){
			$where="AND (filiere.code LIKE 'LP1,2-%' OR filiere.code LIKE 'LP3,4-%') ";	
		}else{
			$where="AND ecole='".$_GET['ecoles']."'";	
		}
	}
	if(!in_array("uak",$_SESSION['etablissement'])){
		$where="AND (";
		for($l=0;$l<count($_SESSION['etablissement']);$l++){
			$where.="ecole='".$_SESSION['etablissement'][$l]."' OR ";	
		}	
		$where=substr($where,0,-3);
		$where.=")";
		//echo $where;
	}
 $rs = mysql_query("SELECT FF, count( * ) as nombre, ecole FROM `inscription`, filiere WHERE filiere.code=inscription.filiere AND controle = 'oui' AND annee_academique = '".$an."' ".$where."  AND FI!=15000 GROUP BY FF"); 
	//echo "SELECT FF, count( * ) as nombre, ecole FROM `inscription`, filiere WHERE filiere.code=inscription.filiere AND controle = 'oui' AND annee_academique = '".$an."' ".$where."  AND FI!=15000 GROUP BY FF";
	if(mysql_num_rows($rs)>0){
		echo "<table id='source' width='95%' cellpadding='0' cellspacing='2' align='center' style='border:thin'>
				<caption>Graphique des frais de formation payées</caption> <!-- optional -->
    			<thead>               <!-- Must have -->
					<tr style='background-color:#FFFCCC; font-size:20px'>
						<th>Type de frais de formation</th>       <!-- Must have an empty <th> here -->
						<th>Nombre d'étudiant</th> <!-- Must have -->
						...
					</tr>
    			</thead>
    			<tbody>                   <!-- Must have -->";
				$element=mysql_fetch_assoc($rs);
				$color='#FFAFAA';
				do{			
					echo "<tr style='background-color:".$color."; font-size:20px'>
            		<th>".$element['FF']."</th>    <!-- First cell of each row must be <th> -->
            		<td>".$element['nombre']."</td>    <!-- Data cell must be <td> -->
           	 		....
        			</tr>
        			...             <!-- Repeat above pattern -->";
					if($color!=""){
						$color="";
					}else{
						$color='#FFAFAA';
					}
				}while($element=mysql_fetch_assoc($rs));
    			echo "</tbody>
				</table><br/><br/>
				
				<div id='target' style='width: 600px; height: 400px'>
				</div>"; 
	}
?>
</td>
<td width="4%" valign="top" style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat-y">&nbsp;&nbsp;</td>
    <td width="48%" valign="top" style="padding-left:10px">
    <?php
if(in_array("uak",$_SESSION['etablissement'])){
	
	if($_GET['ecoles']=='CAG'){
		$where="AND (filiere.code LIKE 'LP1,2-%' OR filiere.code LIKE 'LP3,4-%') ";	
	}else{
		$where="AND ecole='".$_GET['ecoles']."'";	
	}
 $rs = mysql_query("SELECT ecole, SUM(FF) as FF, SUM(FI) as FI, SUM(`montant_reprise`) as reprise FROM `inscription`, filiere WHERE controle = 'oui' AND annee_academique='".$an."' AND filiere.code=inscription.filiere ".$where."  GROUP BY filiere.ecole ORDER BY filiere.ecole"); 
	if(mysql_num_rows($rs)>0){
		echo "<table id='source2' width='95%' border='0' cellpadding='0' cellspacing='2' align='center'>
				<caption>Graphique des frais regrouper par entité pour l'année </caption> <!-- optional -->
    			<thead>               <!-- Must have -->
					<tr style='font-size:20px'>
						<th>Ecole</th>       <!-- Must have an empty <th> here -->
						<th>Frais de formation</th> <!-- Must have -->
						<th>Frais d'inscription</th> <!-- Must have -->
						<th>Frais de reprise</th> <!-- Must have -->
						<th>Frais de pénalité</th> <!-- Must have -->
						...
					</tr>
    			</thead>
    			<tbody>                   <!-- Must have -->";
				$element=mysql_fetch_assoc($rs);
				$color='#FFAFAA';
				do{			
					echo "<tr style='background-color:".$color."; font-size:20px'>
            		<th>".$element['ecole']."</th>    <!-- First cell of each row must be <th> -->
            		<td align='right'>".$element['FF']."</td>    <!-- Data cell must be <td> -->
            		<td align='right'>".$element['FI']."</td>    <!-- Data cell must be <td> -->
            		<td align='right'>".$element['reprise']."</td>    <!-- Data cell must be <td> -->";
					//calcul des frais de pénalité
					$rsm = mysql_query("SELECT SUM(montant) as penalite FROM inscription,`penalite` WHERE inscription.matricule=penalite.matricule AND inscription.annee_academique=penalite.annee_academique AND inscription.controle='oui' AND penalite.annee_academique='".$an."' AND penalite.etablissement='".$element['ecole']."'");
					$isnull=mysql_num_rows($rsm); 
					if($isnull>0){
						$Element_Montant=mysql_fetch_assoc($rsm);
						echo "<td align='right'>".$Element_Montant['penalite']."</td><!-- Data cell must be <td> -->";
					}else{
						echo "<td align='right'>".$isnull."</td><!-- Data cell must be <td> -->";	
					}
           	 		echo "....
        			</tr>
        			...             <!-- Repeat above pattern -->";
					if($color!=""){
						$color="";
					}else{
						$color='#FFAFAA';
					}
				}while($element=mysql_fetch_assoc($rs));
    			echo "</tbody>
				</table><br/><br/>
				
				<div id='target2' style='width: 600px; height: 400px'>
				</div>"; 
	}
}
?>
    </td>
  </tr>
  <tr>
      <td width="48%" valign="top" colspan='2' style="padding-left:10px">
    <?php
if(in_array("uak",$_SESSION['etablissement'])){
	
	if($_GET['ecoles']=='CAG'){
		$where="AND (filiere.code LIKE 'LP1,2-%' OR filiere.code LIKE 'LP3,4-%') ";	
	}else{
		$where="AND ecole='".$_GET['ecoles']."'";	
	}
	
 $rs = mysql_query("SELECT ecole, COUNT(*) as nombre, SUM(montant_reprise) as montant FROM `inscription`,filiere WHERE filiere.code=inscription.filiere AND montant_reprise!=0 AND annee_academique='".$an."' ".$where." GROUP BY filiere.ecole"); 
	if(mysql_num_rows($rs)>0){
		echo "<table id='source3' width='95%' border='0' cellpadding='0' cellspacing='2' align='center'>
				<caption>Graphique des frais de reprise regroupées par école </caption>
    			<thead>               <!-- Must have -->
					<tr style='font-size:20px'>
						<th>Ecole</th>       <!-- Must have an empty <th> here -->
						<th>Montant</th> <!-- Must have -->
						<th>Nombre</th> <!-- Must have -->
						...
					</tr>
    			</thead>
    			<tbody>";
				$element=mysql_fetch_assoc($rs);
				$color='#FFAFAA';
				do{			
					echo "<tr style='background-color:".$color."; font-size:20px'>
            		<th>".$element['ecole']."</th>    <!-- First cell of each row must be <th> -->
            		<td align='right'>".$element['montant']."</td>    <!-- Data cell must be <td> -->
            		<td align='right'>".$element['nombre']."</td>    <!-- Data cell must be <td> -->
            		</tr>";
					if($color!=""){
						$color="";
					}else{
						$color='#FFAFAA';
					}
				}while($element=mysql_fetch_assoc($rs));
    			echo "</tbody>
				</table><br/><br/>
				
				<div id='target3' style='width: 600px; height: 400px'>
				</div>"; 
	}
}
?>
    </td>
</tr>
  
  </table>