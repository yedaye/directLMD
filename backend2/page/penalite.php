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
if(isset($_POST['ajouter'])){
	//controle de l'existance
	$array_field=array('matricule','annee_academique','montant','observation','etablissement');
	$array_values=array($_POST['matricule'],$_POST['annee_acad'],$_POST['montant'],addslashes($_POST['observation']),$_POST['etablissement']);
	$controle=selTableDataWhereArray("penalite",$array_field,$array_values);
	if(count($controle)==0){
		$champ=array('matricule','annee_academique','montant','observation','etablissement');
		$valeur=array($_POST['matricule'],$_POST['annee_acad'],$_POST['montant'],addslashes($_POST['observation']),$_POST['etablissement']);
		insTable("penalite",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?penalite&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?penalite&ajoutDJA');
		// -->
		</script>";
	}
	
	// génération du XML
	$etudiant=selTableDataWhere("student","matricule",$_POST['matricule']);
	$inscription=selTableData2Fields("inscription","matricule",$etudiant['matricule'],"annee_academique",$_POST['annee_acad']);
	//$montantdu=$inscription[0]['FF']+$inscription[0]['FI']+$inscription[0]['montant_reprise'];
	$montantdu=$_POST['montant'];
	$ecole=selTableDataWhere('filiere','code',$inscription[0]['filiere']);
	$xmlfile=genexml($etudiant['matricule'],$etudiant['nom'],$etudiant['prenoms'],$etudiant['date_naissance'],$etudiant['lieu_naissance'],$etudiant['telephone'],$montantdu,$inscription[0]['annee_academique'],$inscription[0]['statut'],$ecole['ecole'],$inscription[0]['filiere'],$etudiant['Nationalite'],"penalite");
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('matricule','annee_academique','montant','observation','etablissement');
	$valeur=array($_POST['matricule2'],$_POST['annee_acad2'],$_POST['montant2'],addslashes($_POST['observation2']),$_POST['etablissement2']);
	updTable("penalite",$champ,$valeur,"id",$_POST['modif']);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?penalite&modifOK');
		// -->
		</script>";
	// génération du XML
	$etudiant=selTableDataWhere("student","matricule",$_POST['matricule2']);
	$inscription=selTableData2Fields("inscription","matricule",$etudiant['matricule'],"annee_academique",$_POST['annee_acad2']);
	//$montantdu=$inscription[0]['FF']+$inscription[0]['FI']+$inscription[0]['montant_reprise'];
	$montantdu=$_POST['montant2'];
	$ecole=selTableDataWhere('filiere','code',$inscription[0]['filiere']);
	$xmlfile=genexml($etudiant['matricule'],$etudiant['nom'],$etudiant['prenoms'],$etudiant['date_naissance'],$etudiant['lieu_naissance'],$etudiant['telephone'],$montantdu,$inscription[0]['annee_academique'],$inscription[0]['statut'],$ecole['ecole'],$inscription[0]['filiere'],$etudiant['Nationalite'],"penalite");
		
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
	 $.messager.confirm('Confirm','Voulez vous supprimer ce montant : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_penalite.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?penalite&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES PENALITES</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Montant Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','Montant modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Ce montant existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Ce montant a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
            <a href="?penalite&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ecole" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>MATRICULE</td>
    <td>ANNEE ACADEMIQUE</td>
    <td>MONTANT</td>
    <td>OBSERVATION</td>
    <td>ETABLISSEMENT</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableDataDesc("penalite","id");
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td title=""><?php echo $liste[$i]['matricule']; ?></td>
    <td><?php echo $liste[$i]['annee_academique']; ?></td>
    <td><?php echo $liste[$i]['montant']; ?></td>
    <td><?php echo $liste[$i]['observation']; ?></td>
    <td><?php echo $liste[$i]['etablissement']; ?></td>
   	<td>  
 <a href="fiche_penalite.php?matricule=<?php echo $liste[$i]['matricule']; ?>&an_etude=<?php echo $liste[$i]['annee_academique']; ?>" class="easyui-linkbutton" iconCls="icon-print" target="_new" plain="true">Imprimer </a> | <a href="?penalite&modif=<?php echo $liste[$i]['id']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a> |
<a onclick="suppression('<?php echo $liste[$i]['id']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a>
    </td>
  </tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="?montant" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'un nouveau montant" style="width:700px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Année Academique</td>
            <td><select name="annee_acad" id="annee_acad">
              <?php
			$ufr=selTableData("annee_academique");
			for($i=0;$i<count($ufr);$i++){
				echo "<option value='".$ufr[$i]['lib_annee']."'>".strtolower($ufr[$i]['lib_annee'])."</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>Matricule</td>
            <td><label for="matricule"></label>
            <input type="text" name="matricule" id="matricule" /></td>
          </tr>
          <tr>
            <td>Montant</td>
            <td><input name="montant" id="montant" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Observation</td>
            <td><textarea name="observation" cols="50" rows="7" class="easyui-validatebox" id="observation" required="true"></textarea></td>
          </tr>
          <tr>
          <td>Etablissement</td>
          <td>
           <select required="true" name="etablissement" id="etablissement">
            <?php
			$ufr=selTableMultiAnswer("ecole_ufr","actif",'1');
			for($i=0;$i<count($ufr);$i++){
				echo "<option value='".$ufr[$i]['code_ecole']."'>".strtolower($ufr[$i]['lib_ecole'])." (".$ufr[$i]['code_ecole'].")</option>";
			}
			?>
            </select>
            <td>
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
<?php if(isset($_GET['modif']) && $_GET['modif']!="" && !isset($_GET['ajout'])){ 
$modification=selTableDataWhere("penalite","id",$_GET['modif']);
?>
<div align="center" id='retour' style="display:none"> <a href="penalite.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Ajout d'une nouvelle école" style="width:700px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post" action="">  
       <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Année Academique</td>
            <td><select name="annee_acad2" id="annee_acad2">
              <?php
			$ufr=selTableData("annee_academique");
			for($i=0;$i<count($ufr);$i++){
				$select="";
				if($modification['annee_academique']==$ufr[$i]['lib_annee']){
					$select="selected=\"selected\"";	
				}
			echo "<option ".$select." value='".$ufr[$i]['lib_annee']."'>".strtolower($ufr[$i]['lib_annee'])."</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>Matricule</td>
            <td><label for="matricule"></label>
            <input type="text" name="matricule2" id="matricule2" value="<?php echo $modification['matricule']; ?>" /></td>
          </tr>
          <tr>
            <td>Montant</td>
            <td><input name="montant2" id="montant2" class="easyui-validatebox" required="true" value="<?php echo $modification['montant']; ?>"></td>
          </tr>
          <tr>
            <td>Observation</td>
            <td><textarea name="observation2" cols="50" rows="7" class="easyui-validatebox" id="observation2" required="true"><?php echo $modification['observation']; ?></textarea></td>
          </tr>
          <tr>
          <td>Etablissement</td>
          <td>
           <select required="true" name="etablissement2" id="etablissement2">
            <?php
			$val=$modification['etablissement'];
			$ufr=selTableMultiAnswer("ecole_ufr","actif","1");
			for($i=0;$i<count($ufr);$i++){
				$selected="";
				if($val==$ufr[$i]['code_ecole']){ $selected="selected=\"selected\"";}
				echo "<option value='".$ufr[$i]['code_ecole']."' ".$selected.">".strtolower($ufr[$i]['lib_ecole'])." (".$ufr[$i]['code_ecole'].")</option>";
			}
			?>
            </select>
          </td>
          </tr>
          <tr>
            <td colspan="2">
            <div id="dlg-buttons" align="center" style="padding:15px">
				<input name="modifier" type="submit" value="Modifier" /><input name="modif" type="hidden" value="<?php echo $modification['id']; ?>" />
   			</div>
            </td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
?>