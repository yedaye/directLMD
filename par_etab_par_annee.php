<?php
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");
if (is_file("../param.php"))
	include_once ("../param.php");
	
if(isset($_SESSION['droit']) && $_SESSION['droit']=='0'){
	echo "<script language='Javascript'>
		<!--
		document.location.replace('accueil.php');
		// -->
		</script>";
}

$err_msg="";
$msg_ajout="";
$msg_modif="";
$msg_dja="";
//print_r($_SESSION);
//// requete pour la liste
$where="";

if(isset($_POST['etab']) && $_POST['etab']!=""){
	$where.=" AND filiere.ecole='".$_POST['etab']."'";	
}
// ajout du controle de l'établissement
//print_r($_SESSION['etablissement']);
if(isset($_SESSION['etablissement']) && !isset($_POST['etab'])){
	if(!in_array('uak',$_SESSION['etablissement']) || !in_array('aucun',$_SESSION['etablissement'])){
		$where.=" AND (";
	   	for($i=0;$i<count($_SESSION['etablissement']);$i++){
			if($_SESSION['etablissement'][$i]!='uak' && $_SESSION['etablissement'][$i]!='aucun'){
				$where.="filiere.ecole='".$_SESSION['etablissement'][$i]."'";	
			}
			if(count($_SESSION['etablissement'])>0){
				$where.=" OR ";	
			}
		}
		$where=substr($where,0,-4);
		if(count($_SESSION['etablissement'])>0){
			$where.=") ";	
		}
	}
}
if($where==" AND () "){
	$where="";
}
$anne=$anneeEtude;
if(isset($_POST['annee'])){
	$anne=$_POST['annee'];
};

if(isset($_POST['valide']) && $_POST['valide']!=""){
	$where.=" AND controle='".$_POST['valide']."'";	
};

$query_inscrits = "SELECT annee_academique, ecole, sexe, count( * ) as nombre FROM `inscription` , `filiere` , student WHERE filiere.code = inscription.filiere AND `annee_academique` = '".$anne."' AND student.matricule = inscription.matricule".$where." GROUP BY ecole, sexe";
//echo $query_inscrits;

$_SESSION['requete']=$query_inscrits;

$inscrits = mysql_query($query_inscrits) or die(mysql_error());
$row_inscrits = mysql_fetch_assoc($inscrits);
$totalRows_inscrits = mysql_num_rows($inscrits);


///// requete pour remplir le champ etablissement
$query_etab = "SELECT * FROM ecole_ufr ORDER BY lib_ecole ASC";
$etab = mysql_query($query_etab) or die(mysql_error());
$row_etab = mysql_fetch_assoc($etab);



?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#list_ecole').dataTable({	
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
function suppression(lematricule,lannee){
	 $.messager.confirm('Confirm','Voulez vous supprimer inscription de  : '+lematricule,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_inscription.php',{matricule:lematricule,annee:lannee},function(data){  
				if(data==1){
					document.location.href="?liste_annee";
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
<div id="haut" style="height:75px"><center>
Nombre d'étudiant par année et par établissement groupé par sexe
</center></div>
<hr/>
<div id="toolbar" align="right">
<table border="0" width="100%">
      	      <tbody><tr>
      	        <td valign="middle" width="232"><a href="Excel/sortieFichier.php" target="_blank"><img src="../img/excel.jpg" alt="" align="left" border="0" height="33" width="32"></a><br>
   	            <span class="ds">  Exporter en Excel</span></td>
      	        <td width="1549"><form id="form1" method="post" action="">
      	          <table width="100%" border="0">
      	            <tr>
      	              <td width="137" bgcolor="#B8B8B8">Année Académique :</td>
      	              <td width="124" bgcolor="#B8B8B8"><label for="annee"></label>
      	                <select name="annee" id="annee">
   	                    <?php
						$query = "SELECT * FROM annee_academique ORDER BY lib_annee DESC";
						$ane = mysql_query($query) or die(mysql_error());
						$row_ane = mysql_fetch_assoc($ane);
						do{
							$select="";
							if($row_ane['lib_annee']==$anneeEtude && !isset($_POST['annee'])){
								$select="selected=\"selected\"";	
							}
							if(isset($_POST['annee']) && $row_ane['lib_annee']==$_POST['annee']){
								$select="selected=\"selected\"";	
							}
							
							echo "<option ".$select." value='".$row_ane['lib_annee']."'>".$row_ane['lib_annee']."</option>";	
						}while($row_ane=mysql_fetch_assoc($ane));
						?>
                        </select></td>
      	              <td width="132" bgcolor="#B8B8B8">Etablissement :</td>
      	              <td width="281" bgcolor="#B8B8B8">
                      <label>
                        <select name="etab" id="etab" onchange="submit">
						<option value=''> </option>
						<?php
do {  
	if(!in_array("uak",$_SESSION['etablissement'])){
		if(in_array($row_etab['code_ecole'],$_SESSION['etablissement'])){
?>              
<option  value="<?php echo $row_etab['code_ecole']?>"<?php if(isset($_POST['etab'])){if (!(strcmp($row_etab['code_ecole'], $_POST['etab']))) {echo " selected=\"selected\"";}} ?>><?php echo $row_etab['lib_ecole']?></option>
      	                  <?php
		}
	}else{
?>
<option ".$select." value="<?php echo $row_etab['code_ecole']?>"<?php if(isset($_POST['etab'])){if (!(strcmp($row_etab['code_ecole'], $_POST['etab']))) {echo " selected=\"selected\"";}} ?>><?php echo $row_etab['lib_ecole']?></option>
	<?php
    }
} while ($row_etab = mysql_fetch_assoc($etab));
?>
          </select>
        </label></td>
     	<td width="106" bgcolor="#B8B8B8">Validation : </td>
     	<td width="327" bgcolor="#B8B8B8"><select name="valide" id="valide">
     	  <option value="">--Filtre validation--</option>
     	  <option value="oui"  <?php 
if(isset($_POST['valide']) && $_POST['valide']=="oui"){ echo "selected"; }
?>>Valider</option>
     	  <option value="non" <?php 
if(isset($_POST['valide']) && $_POST['valide']=="non"){ echo "selected"; }
?>>Non valide</option>
   	  </select></td>
     	<td bgcolor="#B8B8B8"><input type="submit" name="button" id="button" value="Filtrer le resultat" /></td>
     	<td>&nbsp;</td>
      	            </tr>
      	            <tr>
      	              <td colspan="6">&nbsp;</td>
      	              <td width="257">&nbsp;</td>
      	              <td width="1">&nbsp;</td>
   	                </tr>
      	            </table>
   	            </form></td>
   	          </tr>
   	        </tbody></table>
</div>
<hr />
<div id="toolbar" align="right"><a href="?verdict&ajoutlot" class="easyui-linkbutton" iconCls="icon-add" plain="true">Importer un fichier csv</a>     <a href="?verdict&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<?php if($totalRows_inscrits>0){
	$_SESSION['colonne']="ANNEE ACADEMIQUE;ETABLISSEMENT;SEXE;NOMBRE";
	?>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ecole" class="display"><br />
<caption>
    	Nombre d'étudiant par année et par établissement groupé par sexe
</caption>
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
 	<td width="21%">Annee Académique</td>
    <td width="20%">Etablissement</td>
    <td width="34%">Sexe</td>
    <td width="34%">Nombre</td>
    <td width="25%"></td>
  </tr>
</thead>
<tbody>
<?php
//print_r($row_inscrits);
do { 
	if(in_array("uak",$_SESSION['etablissement']) || in_array($row_inscrits['ecole'],$_SESSION['etablissement'])){
	//$liste=selTableDataWhere("student","matricule",$row_inscrits['matricule']);
	?>
	  <tr valign="top">
		<td title=""><?php echo $row_inscrits['annee_academique']; ?></td>
		<td><?php echo $row_inscrits['ecole']; ?></td>
		<td><img src="<?php if($row_inscrits['sexe']=="M"){echo "../img/homme.gif";}else{echo "../img/femme.gif";}; ?>" alt="" width="13" height="27"/>&nbsp;<?php echo $row_inscrits['sexe']; ?></td>
  		<td><?php echo $row_inscrits['nombre']; ?></td>
		<td align="center"></td>
	  </tr>
	<?php
	}
}while ($row_inscrits = mysql_fetch_assoc($inscrits));

?>
</tbody>
</table>
<?php 
}else{
	echo "PAS DE RESULTATS";
} 
//print_r($_SESSION['etablissement']);
?> 
