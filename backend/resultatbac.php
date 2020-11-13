<?php
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
include_once ("../param.php");
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");
	
	
$err_msg="";
$msg_ajout="";
$msg_modif="";
$msg_dja="";

///action pour l'ajout d'une UFR

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

function suppression(val){
	 $.messager.confirm('Confirm','Voulez vous supprimer cet etudiant : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_etudiant.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?liste&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES BACHELIERS</center></div>
<hr/>
<?php

//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Etudiant Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','Etudiant modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Cet étudiant existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Cet étudiant a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php 
if(isset($_POST['lot'])){
	//echo "test";
	//print_r($_POST);
		//process the csv file
		$handle=fopen($_FILES['file']['tmp_name'],'r');
		$data=fgetcsv($handle,1000,";");
		//remove if csv file does not have column heading
		//$matricule1="";
		while(($data=fgetcsv($handle,1000,";"))!==FALSE){
			$numtable=mysql_real_escape_string($data[0]);
			$session=mysql_real_escape_string($data[1]);
			$serie=mysql_real_escape_string($data[2]);		
			$lieu_nais=mysql_real_escape_string($data[3]);
			$date_nais=mysql_real_escape_string($data[4]);
			$nom=mysql_real_escape_string($data[5]);
			$prenoms=mysql_real_escape_string($data[6]);
			$sexe=mysql_real_escape_string($data[7]);
			$nationalite=mysql_real_escape_string($data[8]);
			$moyenne=mysql_real_escape_string($data[9]);
			$observation=mysql_real_escape_string($data[10]);
			
			$sql="INSERT INTO resultatbac (NumTable,session, Serie, Lieu_Nais, Date_Nais,Nom, Prenoms,sexe,Nationalite,Moyenne,observation) VALUES ('".$numtable."','".$session."','".$serie."','".$lieu_nais."','".$date_nais."','".$nom."','".$prenoms."','".$sexe."','".$nationalite."','".$moyenne."','".$observation."')";
			echo $sql;
			mysql_query($sql) or die(mysql_error());
		}
		//exit;
		header("Location:?bac");
		mysql_close();
}

//DEBUT AJOUT EN LOT



if(!isset($_GET['modif']) && !isset($_GET['ajout']) && !isset($_GET['ajoutlot'])){ 



?>

<div id="toolbar" align="right"><form action="accueil.php?bac" method="get"><input name="bac" type="hidden" value="" />Rechercher par la session : <select name="session" id="session">
  				<option value="2018" <?php if(isset($_GET['session']) && $_GET['session']=='2018'){ echo "selected='selected'"; } ?>>2018</option>
				<option value="2017" <?php if(isset($_GET['session']) && $_GET['session']=='2017'){ echo "selected='selected'"; } ?>>2017</option>
				<option value="2016" <?php if(isset($_GET['session']) && $_GET['session']=='2016'){ echo "selected='selected'"; } ?>>2016</option>
				<option value="2015" <?php if(isset($_GET['session']) && $_GET['session']=='2015'){ echo "selected='selected'"; } ?>>2015</option>
  				<option value="2014" <?php if(isset($_GET['session']) && $_GET['session']=='2014'){ echo "selected='selected'"; } ?>>2014</option>
                <option value="2013" <?php if(isset($_GET['session']) && $_GET['session']=='2013'){ echo "selected='selected'"; } ?>>2013</option>
               	<option value="2012" <?php if(isset($_GET['session']) && $_GET['session']=='2012'){ echo "selected='selected'"; } ?>>2012</option>
               	<option value="2011" <?php if(isset($_GET['session']) && $_GET['session']=='2011'){ echo "selected='selected'"; } ?>>2011</option>
               	<option value="2010" <?php if(isset($_GET['session']) && $_GET['session']=='2010'){ echo "selected='selected'"; } ?>>2010</option>
               	<option value="2009" <?php if(isset($_GET['session']) && $_GET['session']=='2009'){ echo "selected='selected'"; } ?>>2009</option>
               	<option value="2008" <?php if(isset($_GET['session']) && $_GET['session']=='2008'){ echo "selected='selected'"; } ?>>2008</option>
          </select> / par le nom : <input name="nom" type="text" value="<?php if(isset($_GET['nom'])){ echo $_GET['nom']; } ?>" /> <input name="Recherche" type="submit" value="Rechercher" />|  <a href="?bac&ajoutlot" class="easyui-linkbutton" iconCls="icon-add" plain="true">Importer un fichier csv</a>  |<a href="" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a> </form>   
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ecole" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>Numero de Table</td>
    <td>Session</td>
    <td>Nom</td>
	<td>Prenoms</td>
    <td>sexe</td>
    <td>Date de naissance</td>
    <td>Lieu de naissance</td>
    <td>Serie</td>
    <td>Nationalite</td>
    <td>Moyenne</td>
    <td>Observation</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
if((isset($_GET['session']) && $_GET['session']!="") && $_GET['nom']==''){
	$liste=selTableMultiAnswer("resultatbac","session",$_GET['session']);
	$count=300;
}else{
	if((isset($_GET['session']) && $_GET['session']!="") && (isset($_GET['nom']) && $_GET['nom']!="")){
		$liste=selTableData2Fields("resultatbac","session",$_GET['session'],'Nom',$_GET['nom']);
		//$liste=$liste[0];
		//print_r($liste);
		$count=count($liste);
		//echo $count;
	}else{
		$liste=selTableMultiAnswer("resultatbac","session","2015");
		//$count=300;
		$count=300;
	}
}

for($i=0; $i<$count;$i++){
?>
  <tr valign="top">
    <td><?php echo $liste[$i]['NumTable']; ?></td>
    <td><?php echo $liste[$i]['session']; ?></td>
    <td><?php echo utf8_encode($liste[$i]['Nom']); ?></td>
    <td><?php echo utf8_encode($liste[$i]['Prenoms']); ?></td>
    <td><?php echo $liste[$i]['sexe']; ?></td>
	<td><?php echo $liste[$i]['Date_Nais']; ?></td>
	<td><?php echo utf8_encode($liste[$i]['Lieu_Nais']); ?></td>
    <td><?php echo $liste[$i]['Serie']; ?></td>
    <td><?php echo $liste[$i]['Nationalite']; ?></td>
    <td><?php echo $liste[$i]['Moyenne']; ?></td>
    <td><?php echo $liste[$i]['observation']; ?></td>
    <td></td>
  </tr>
<?php
}
?>
</tbody>
</table>
<?php } 
if(isset($_GET['ajoutlot'])){
?>
<br /><br /><br />
<div align="center" id='retour' style="display:none"> <a href="?bac" class="easyui-linkbutton">RETOUR</a></div>
<div align="center" id="p" class="easyui-panel" title="Ajout à partir d'un fichier excel CSV" style="width:350px;height:200px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
<form enctype="multipart/form-data" action="?bac" method="post">
<p><input name="file" type="file"/></p>
<p><input name="lot" id="lot" /></p>
<p><input type="submit" value="Importer le fichier"/> </p>
</form>
</div>
<?php	
}



?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout']) && !isset($_GET['ajoutlot'])){ ?>

<?php
}
//FIN AJOUT EN LOT
?>

<?php if(!isset($_GET['modif']) && isset($_GET['ajout']) && !isset($_GET['ajoutlot'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="verdict.php" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouveau verdict" style="width:700px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
          	<td>Matricule </td>
            <td><input name="matricule" id="matricule" value="" /></td>
          </tr>
          <tr>
          	<td>Nom </td>
            <td><input name="nom" id="nom" value="" /></td>
          </tr>
          <tr>
          	<td>Prénoms </td>
            <td><input name="prenoms" id="prenoms" value="" /></td>
          </tr>
          <tr>
          	<td>sexe </td>
            <td><input name="sexe" id="sexe" value="" /></td>
          </tr>
          <tr>
          	<td>date de naissance </td>
            <td><input name="date_naissance" id="date_naissance" value="" /></td>
          </tr>
          <tr>
          	<td>lieu de naissance </td>
            <td><input name="lieu_naissance" id="lieu_naissance" value="" /></td>
          </tr>
          <tr>
          	<td>situation de famille </td>
            <td><input name="situ_fam" id="situ_fam" value="" /></td>
          </tr>
          <tr>
          	<td>nombre d'enfant </td>
            <td><input name="nombre_enfant" id="nombre_enfant" value="" /></td>
          </tr>
          <tr>
          	<td>email </td>
            <td><input name="email" id="email" value="" /></td>
          </tr>
          <tr>
          	<td>telephone </td>
            <td><input name="telephone" id="telephone" value="" /></td>
          </tr>
          <tr>
          	<td>pays de naissance </td>
            <td><input name="matricule" id="matricule" value="" /></td>
          </tr><tr>
          	<td>Natonalite </td>
            <td><input name="matricule" id="matricule" value="" /></td>
          </tr>
          <tr>
          	<td>adresse </td>
            <td><input name="adresse" id="adresse" value="" /></td>
          </tr>
          <tr>
          	<td>numero de table </td>
            <td><input name="num_table" id="num_table" value="" /></td>
          </tr>
          <tr>
          	<td>session </td>
            <td><input name="session" id="session" value="" /></td>
          </tr>
          <tr>
          	<td>code auto </td>
            <td><input name="code_auto" id="code_auto" value="" /></td>
          </tr>
          <tr>
          	<td>serie </td>
            <td><input name="serie" id="serie" value="" /></td>
          </tr>
          <tr>
          	<td>email uak </td>
            <td><input name="email_uak" id="email_uak" value="" /></td>
          </tr>
          <tr>
            <td colspan="2">
            <div id="dlg-buttons" align="center" style="padding:15px">
				<input name="ajouter" type="submit" value="ajouter" />
   			</div>
            </td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
?>
<!-- formulaire de modification -->
<?php if(isset($_GET['modif']) && $_GET['modif']!="" && !isset($_GET['ajout']) && !isset($_GET['ajoutlot'])){ 
$modification=selTableDataWhere("student","matricule",$_GET['modif']);
?>
<div align="center" id='retour' style="display:none"> <a href="mapping.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Modification du verdict" style="width:700px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
          	<td>Matricule </td>
            <td><input name="matricule2" id="matricule2" value="<?php echo $modification['matricule']; ?>" /></td>
          </tr>
          <tr>
          	<td>Nom </td>
            <td><input name="nom2" id="nom2" value="<?php echo $modification['nom']; ?>" /></td>
          </tr>
          <tr>
          	<td>Prénoms </td>
            <td><input name="prenoms2" id="prenoms2" value="<?php echo $modification['prenoms']; ?>" /></td>
          </tr>
          <tr>
          	<td>sexe </td>
            <td><input name="sexe2" id="sexe2" value="<?php echo $modification['sexe']; ?>" /></td>
          </tr>
          <tr>
          	<td>date de naissance </td>
            <td><input name="date_naissance" id="date_naissance" value="<?php echo convertdateanglais($modification['date_naissance']); ?>" /></td>
          </tr>
          <tr>
          	<td>lieu de naissance </td>
            <td><input name="lieu_naissance2" id="lieu_naissance2" value="<?php echo $modification['lieu_naissance']; ?>" /></td>
          </tr>
          <tr>
          	<td>situation de famille </td>
            <td><input name="situ_fam2" id="situ_fam2" value="<?php echo $modification['situ_fam']; ?>" /></td>
          </tr>
          <tr>
          	<td>nombre d'enfant </td>
            <td><input name="nombre_enfant2" id="nombre_enfant2" value="<?php echo $modification['nombre_enfant']; ?>" /></td>
          </tr>
          <tr>
          	<td>email </td>
            <td><input name="email2" id="email2" value="<?php echo $modification['email']; ?>" /></td>
          </tr>
          <tr>
          	<td>telephone </td>
            <td><input name="telephone2" id="telephone2" value="<?php echo $modification['telephone']; ?>" /></td>
          </tr>
          <tr>
          	<td>pays de naissance </td>
            <td><input name="pays_naissance2" id="pays_naissance2" value="" /></td>
          </tr><tr>
          	<td>Natonalite </td>
            <td><input name="nationalite2" id="nationalite2" value="" /></td>
          </tr>
          <tr>
          	<td>adresse </td>
            <td><input name="adresse2" id="adresse2" value="<?php echo $modification['adresse']; ?>" /></td>
          </tr>
          <tr>
          	<td>numero de table </td>
            <td><input name="num_table2" id="num_table2" value="<?php echo $modification['num_table']; ?>" /></td>
          </tr>
          <tr>
          	<td>session </td>
            <td><input name="session2" id="session2" value="<?php echo $modification['session']; ?>" /></td>
          </tr>
          <tr>
          	<td>code auto </td>
            <td><input name="code_auto2" id="code_auto2" value="<?php echo $modification['code_auto']; ?>" /></td>
          </tr>
          <tr>
          	<td>serie </td>
            <td><input name="serie2" id="serie2" value="<?php echo $modification['serie']; ?>" /></td>
          </tr>
          <tr>
          	<td>email uak </td>
            <td><input name="email_uak2" id="email_uak2" value="<?php echo $modification['email_uak']; ?>" /></td>
          </tr>
          <tr>
            <td colspan="2"><input name="modif" id="modif" value="<?php echo $_GET['modif']; ?>" type="hidden" />
            <div id="dlg-buttons" align="center" style="padding:15px">
				<input name="ajouter" type="submit" value="Modifier" iconCls="icon-ok" />
   			</div>
            </td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
?>