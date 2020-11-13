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
if(isset($_POST['matricule'])){
	//controle de l'existance
	$champ=array('matricule','filiere','annee_academique','result_semestre_1','result_semestre_2','moyenne','observation');
	$valeur=array($_POST['matricule'],$_POST['filiere'],$_POST['annee_academique'],$_POST['result_semestre_1'],$_POST['result_semestre_2'],$_POST['moyenne'],$_POST['observation']);
	insTable("verdict",$champ,$valeur);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?verdict&ajoutOK');
		// -->
		</script>";
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('matricule','filiere','annee_academique','result_semestre_1','result_semestre_2','moyenne','observation');
	$valeur=array($_POST['matricule2'],$_POST['filiere2'],$_POST['annee_academique2'],$_POST['result_semestre_3'],$_POST['result_semestre_4'],$_POST['moyenne2'],$_POST['observation2']);
	updTable("verdict",$champ,$valeur,"id",$_POST['modif']);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?verdict&modifOK');
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
	 $.messager.confirm('Confirm','Voulez vous supprimer ce verdict : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_verdict.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?verdict&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES VERDICTS</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Verdict Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','verdict modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Ce verdict existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Ce verdict a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout']) && !isset($_GET['ajoutlot'])){ ?>

<div id="toolbar" align="right">  
    <a href="?verdict&ajoutlot" class="easyui-linkbutton" iconCls="icon-add" plain="true">Importer un fichier csv</a>     <a href="?verdict&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ecole" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>Matricule</td>
    <td>Filiere</td>
	<td>Année académique</td>
    <td>Resultat semestre 1</td>
    <td>Resultat semestre 2</td>
    <td>moyenne</td>
    <td>observation</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableDataDesc("verdict","id");
for($i=0; $i<count($liste);$i++){
$etab=selTableDataWhere('filiere','code',$liste[$i]['filiere']);
if(count($etab)>0 && (in_array('uak',$_SESSION['etablissement']) || in_array($etab['ecole'],$_SESSION['etablissement']))){
		
?>
  <tr valign="top">
    <td title=""><?php echo $liste[$i]['matricule']; ?></td>
    <td><?php echo $liste[$i]['filiere']; ?></td>
    <td><?php echo $liste[$i]['annee_academique']; ?></td>
    <td><?php echo $liste[$i]['result_semestre_1']; ?></td>
    <td><?php echo $liste[$i]['result_semestre_2']; ?></td>
	<td><?php echo $liste[$i]['moyenne']; ?></td>
	<td><?php echo $liste[$i]['observation']; ?></td>
    <td>  
  <a href="?verdict&modif=<?php echo $liste[$i]['id']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
  <a onclick="suppression('<?php echo $liste[$i]['id']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a>
    </td>
  </tr>
<?php
}
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
			$filiere=mysql_real_escape_string($data[1]);
			$annee_academique=mysql_real_escape_string($data[2]);
			$result_semestre_1=mysql_real_escape_string($data[3]);		
			$result_semestre_2=mysql_real_escape_string($data[4]);
			$moyenne=mysql_real_escape_string($data[5]);
			$observation=mysql_real_escape_string($data[6]);	
		
			$sql="INSERT INTO verdict (matricule,filiere,annee_academique,result_semestre_1,result_semestre_2,moyenne,observation) VALUES ('".$matricule."','".$filiere."','".$annee_academique."','".$result_semestre_1."','".$result_semestre_2."','".$moyenne."','".$observation."')"; 
			mysql_query($sql) or die(mysql_error());
		}
		header("Location:?verdict");
		mysql_close();
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
            <td>Filière</td>
            <td>
            <select required="true" name="filiere" id="filiere">
            <?php
			$ufr=selTableData("filiere","code");
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['code']."'>".strtoupper($ufr[$i]['code'])."</option>";
				}	
			?>
            </select></td>
          </tr>
          <tr>
            <td>Année académique</td>
            <td><select required="true" name="annee_academique" id="annee_academique">
              <?php
				$ufr=selTableDataDesc("annee_academique","lib_annee");
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['lib_annee']."'>".strtoupper($ufr[$i]['lib_annee'])."</option>";
				}			?>
            </select></td>
          </tr>
          <tr>
            <td>Resultat Semestre 1</td>
            <td><label for="verdict"></label>
              <select name="result_semestre_1" id="result_semestre_1">
                <option value="Admis">Admis</option>
                <option value="Refuse">Refuse</option>
                <option value="Chevauche">Chevauche</option>
            </select></td>
          </tr>
          <tr>
            <td>Resultat Semestre 2</td>
            <td><label for="verdict"></label>
              <select name="result_semestre_2" id="result_semestre_2">
                <option value="Admis">Admis</option>
                <option value="Refuse">Refuse</option>
                <option value="Chevauche">Chevauche</option>
            </select></td>
          </tr>
          <tr>
          	<td>Moyenne </td>
            <td><input name="moyenne" id="moyenne" value="" /></td>
          </tr>
          <tr>
          	<td>Observation </td>
            <td><input name="observation" id="observation" value="" /></td>
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
$modification=selTableDataWhere("verdict","id",$_GET['modif']);
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
            <td>Filière</td>
            <td><select required="true" name="filiere2" id="filiere2">
              <?php
				$ufr=selTableData("filiere","code");
				for($i=0;$i<count($ufr);$i++){
					$select="";
					if($modification['filiere']==$ufr[$i]['code']){ $select="selected=\"selected\""; }
					echo "<option value='".$ufr[$i]['code']."' ".$select.">".strtoupper($ufr[$i]['code'])."</option>";
				}			?>
            </select></td>
          </tr>
          <tr>
            <td>Année académique</td>
            <td><select required="true" name="annee_academique2" id="annee_academique2">
              <?php
				$ufr=selTableDataDesc("annee_academique","lib_annee");
				for($i=0;$i<count($ufr);$i++){
					$select="";
					if($modification['annee_academique']==$ufr[$i]['lib_annee']){ $select="selected=\"selected\""; }
					echo "<option value='".$ufr[$i]['lib_annee']."' ".$select.">".strtoupper($ufr[$i]['lib_annee'])."</option>";
				}			?>
            </select></td>
          </tr>
          <tr>
            <td>Resultat Semestre 1</td>
            <td><label for="verdict"></label>
              <select name="result_semestre_3" id="result_semestre_3">
                 <option value="Admis" <?php if("Admis"==$modification['result_semestre_1']){ echo "selected=\"selected\""; } ?>>Admis</option>
                <option value="Refuse" <?php if("Refuse"==$modification['result_semestre_1']){ echo "selected=\"selected\""; } ?>>Refuse</option>
                <option value="Chevauche" <?php if("Chevauche"==$modification['result_semestre_1']){ echo "selected=\"selected\""; } ?>>Chevauche</option>
            </select></td>
          </tr>
          <tr>
            <td>Resultat Semestre 2</td>
            <td><label for="verdict"></label>
              <select name="result_semestre_4" id="result_semestre_4">
                 <option value="Admis" <?php if("Admis"==$modification['result_semestre_2']){ echo "selected=\"selected\""; } ?>>Admis</option>
                <option value="Refuse" <?php if("Refuse"==$modification['result_semestre_2']){ echo "selected=\"selected\""; } ?>>Refuse</option>
                <option value="Chevauche" <?php if("Chevauche"==$modification['result_semestre_2']){ echo "selected=\"selected\""; } ?>>Chevauche</option>
            </select></td>
          </tr>
          <tr>
          	<td>Moyenne </td>
            <td><input name="moyenne2" id="moyenne2" value="<?php echo $modification['moyenne']; ?>" /></td>
          </tr>
          <tr>
          	<td>Observation </td>
            <td><input name="observation2" id="observation2" value="<?php echo $modification['observation']; ?>" /></td>
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