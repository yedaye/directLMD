<?php
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");

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

///action pour l'ajout d'une UFR
if(isset($_POST['matricule'])){
	//controle de l'existance
	$champ=array('matricule','nom','prenoms','sexe','date_naissance','lieu_naissance','situ_fam','nombre_enfant','email','telephone','pays_naissance','Nationalite','adresse_postal','num_table','session','code_auto','serie','email_uak');
	$valeur=array($_POST['matricule'],utf8_decode($_POST['nom']),utf8_decode($_POST['prenoms']),$_POST['sexe'],$_POST['date_naissance'],utf8_decode($_POST['lieu_naissance']),$_POST['situ_fam'],$_POST['nombre_enfant'],$_POST['email'],$_POST['telephone'],$_POST['pays_naissance'],$_POST['nationalite'],utf8_decode($_POST['adrese_postal']),$_POST['num_table'],$_POST['session'],$_POST['code_auto'],$_POST['serie'],$_POST['email_uak']);
	insTable("student",$champ,$valeur,$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?liste&ajoutOK');
		// -->
		</script>";
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('matricule','nom','prenoms','sexe','date_naissance','lieu_naissance','situ_fam','nombre_enfant','email','telephone','pays_naissance','Nationalite','adresse_postal','num_table','session','code_auto','serie','email_uak');
	$valeur=array($_POST['matricule2'],utf8_decode($_POST['nom2']),utf8_decode($_POST['prenoms2']),$_POST['sexe2'],$_POST['date_naissance2'],utf8_decode($_POST['lieu_naissance2']),$_POST['situ_fam2'],$_POST['nombre_enfant2'],$_POST['email2'],$_POST['telephone2'],$_POST['pays_naissance2'],$_POST['nationalite2'],utf8_decode($_POST['adrese_postal2']),$_POST['num_table2'],$_POST['session2'],$_POST['code_auto2'],$_POST['serie2'],$_POST['email_uak2']);
	updTable("student",$champ,$valeur,"matricule",$_POST['modif'],$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?liste&modifOK');
		// -->
		</script>";
}
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
<div id="haut" style="height:75px"><center>GESTION DES ETUDIANTS</center></div>
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
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout']) && !isset($_GET['ajoutlot'])){ ?>

<div id="toolbar" align="right"><a href="?liste&ajoutlot" class="easyui-linkbutton" iconCls="icon-add" plain="true">Importer un fichier csv</a>     <a href="?liste&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ecole" class="display">
<thead style="background-color:#D6E8AB">
 <tr>
    <td>Matricule</td>
    <td>Nom</td>
	<td>Prenoms</td>
    <td>sexe</td>
    <td>Date de naissance</td>
    <td>Lieu de naissance</td>
    <td>situation familiale</td>
    <td>nombre enfant</td>
    <td>email</td>
    <td>telephone</td>
    <td>pays de naissance</td>
    <td>Nationalite</td>
    <td>Adresse</td>
    <td>Num Table Bac</td>
    <td>session</td>
    <td>code_auto</td>
    <td>serie</td>
    <td>email uak</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableData("student","nom",$pdo);
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td title=""><?php echo $liste[$i]['matricule']; ?></td>
    <td><?php echo $liste[$i]['nom']; ?></td>
    <td><?php echo $liste[$i]['prenoms']; ?></td>
    <td><?php echo $liste[$i]['sexe']; ?></td>
    <td><?php echo $liste[$i]['date_naissance']; ?></td>
	<td><?php echo $liste[$i]['lieu_naissance']; ?></td>
	<td><?php echo $liste[$i]['situ_fam']; ?></td>
    <td><?php echo $liste[$i]['nombre_enfant']; ?></td>
    <td><?php echo $liste[$i]['email']; ?></td>
    <td><?php echo $liste[$i]['telephone']; ?></td>
    <td><?php echo $liste[$i]['pays_naissance']; ?></td>
	<td><?php echo $liste[$i]['Nationalite']; ?></td>
    <td><?php echo $liste[$i]['adresse_postal']; ?></td>
    <td><?php echo $liste[$i]['num_table']; ?></td>
    <td><?php echo $liste[$i]['session']; ?></td>
    <td><?php echo $liste[$i]['code_auto']; ?></td>
	<td><?php echo $liste[$i]['serie']; ?></td>
	<td><?php echo $liste[$i]['email_uak']; ?></td>
    <td>  
  <a href="?liste&modif=<?php echo $liste[$i]['matricule']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
  <a onclick="suppression('<?php echo $liste[$i]['matricule']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a>
    </td>
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
<div align="center" id='retour' style="display:none"> <a href="verdict.php" class="easyui-linkbutton">RETOUR</a></div>
<div align="center" id="p" class="easyui-panel" title="Ajout à partir d'un fichier excel" style="width:350px;height:200px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
<form enctype="multipart/form-data" action="" method="post">
<p><input name="file" type="file"/></p>
<p><input name="lot" id="lot" /></p>
<p><input type="submit" value="Importer le fichier"/> </p>
</form>
</div>
<?php	
}
if(isset($_POST['lot'])){
		//process the csv file
		$handle=fopen($_FILES['file']['tmp_name'],'r');
		$data=fgetcsv($handle,1000,";");
		//remove if csv file does not have column heading
		while(($data=fgetcsv($handle,1000,";"))!==FALSE){
			$matricule=mysql_real_escape_string($data[0]);
			$nom=mysql_real_escape_string($data[1]);
			$prenoms=mysql_real_escape_string($data[2]);
			$sexe=mysql_real_escape_string($data[3]);		
			$date_naissance=mysql_real_escape_string($data[4]);
			$lieu_naissance=mysql_real_escape_string($data[5]);
			$situ_fam=mysql_real_escape_string($data[6]);	
			$email=mysql_real_escape_string($data[7]);	
			$telephone=mysql_real_escape_string($data[8]);	
			$pays_naissance=mysql_real_escape_string($data[9]);	
			$nationalite=mysql_real_escape_string($data[10]);
			$adresse_postal=mysql_real_escape_string($data[11]);
			$num_table=mysql_real_escape_string($data[12]);	
			$session=mysql_real_escape_string($data[13]);	
			$code_auto=mysql_real_escape_string($data[14]);	
			$serie=mysql_real_escape_string($data[15]);	
			$email=mysql_real_escape_string($data[16]);	
		
			//$sql="INSERT INTO student (matricule,nom,prenoms,sexe,date_naissance,lieu_naissance,situ_fam,nombre_enfant,email,telephone,pays_naissance,Nationalite,adresse_postal,num_table,session,code_auto,serie,email_uak) VALUES ('".$matricule."','".$nom."','".$prenoms."','".$sexe."','".$date_naissance."','".$lieu_naissance."','".$situ_fam."','".$email."','".$telephone."','".$pays_naissance."','".$nationalite."','".$adresse_postal."','".$num_table."','".$session."','".$code_auto."','".$serie."','".$email."')"; 
			//mysql_query($sql) or die(mysql_error());
		}
		header("Location:?liste");
		//mysql_close();
}
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
            <td><input name="pays_naissance" id="pays_naissance" value="" /></td>
          </tr><tr>
          	<td>Natonalite </td>
            <td><input name="nationalite" id="nationalite" value="" /></td>
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
$modification=selTableDataWhere("student","matricule",$_GET['modif'],$pdo);
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
            <td><input name="date_naissance2" id="date_naissance2" value="<?php echo convertdateanglais($modification['date_naissance']); ?>" /></td>
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
            <td><input name="pays_naissance2" id="pays_naissance2" value="<?php echo $modification['pays_naissance']; ?>" /></td>
          </tr><tr>
          	<td>Natonalite </td>
            <td><input name="nationalite2" id="nationalite2" value="<?php echo $modification['Nationalite']; ?>" /></td>
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