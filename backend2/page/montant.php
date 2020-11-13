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
if(isset($_POST['filiere'])){
	//controle de l'existance
	$array_field=array('filiere','statut','zone');
	$array_values=array($_POST['filiere'],$_POST['statut'],$_POST['zone']);
	$controle=selTableDataWhereArray("montant",$array_field,$array_values);
	if(count($controle)==0){
		$champ=array('filiere','statut','zone','FF','FI');
		$valeur=array($_POST['filiere'],$_POST['statut'],$_POST['zone'],$_POST['ff'],$_POST['fi']);
		insTable("montant",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?montant&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?montant&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('filiere','statut','zone','FF','FI');
	$valeur=array($_POST['filiere2'],$_POST['statut2'],$_POST['zone2'],$_POST['ff2'],$_POST['fi2']);
	updTable("montant",$champ,$valeur,"id",$_POST['modif']);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?montant&modifOK');
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
	 $.messager.confirm('Confirm','Voulez vous supprimer ce montant : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_montant.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?montant&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES MONTANTS</center></div>
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
            <a href="?montant&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ecole" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>FILIERE</td>
    <td>STATUT</td>
    <td>ZONE</td>
    <td>FF</td>
    <td>FI</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableData("montant","filiere");
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td title=""><?php echo $liste[$i]['filiere']; ?></td>
    <td><?php echo $liste[$i]['statut']; ?></td>
    <td><?php echo $liste[$i]['zone']; ?></td>
    <td><?php echo $liste[$i]['FF']; ?></td>
	<td><?php echo $liste[$i]['FI']; ?></td>
   	<td>  
<a href="?montant&modif=<?php echo $liste[$i]['id']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
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
            <td>Filiere</td>
            <td>
            <select required="true" name="filiere" id="filiere">
            <?php
			$ufr=selTableData("filiere","code");
			for($i=0;$i<count($ufr);$i++){
				echo "<option value='".$ufr[$i]['code']."'>".strtolower($ufr[$i]['libelle'])."</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>statut</td>
            <td>
            <select name="statut" id="statut">
            <?php
			$ufr=selTableMultiAnswer("mode","actif","1");
			for($i=0;$i<count($ufr);$i++){
				echo "<option value='".$ufr[$i]['code']."'>".strtolower($ufr[$i]['Intitule'])."</option>";
			}
			?>
            </select>
            </td>
          </tr>
          <tr>
            <td>zone</td>
            <td>
            <select name="zone" id="zone">
            <?php
			$ufr=selTableData("zone","COD_ZONE");
			for($i=0;$i<count($ufr);$i++){
				echo "<option value='".$ufr[$i]['COD_ZONE']."'>".strtolower($ufr[$i]['LIB_ZONE'])."</option>";
			}
			?>
            </select>
            </td>
          </tr>
          <tr>
            <td>Frais de formation</td>
            <td><input name="ff" id="ff" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Frais d'inscription</td>
            <td><input name="fi" id="fi" class="easyui-validatebox" required="true"></td>
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
$modification=selTableDataWhere("montant","id",$_GET['modif']);
?>
<div align="center" id='retour' style="display:none"> <a href="ecole_ufr.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Ajout d'une nouvelle école" style="width:700px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post" action="">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Filiere</td>
            <td>
            <select required="true" name="filiere2" id="filiere2">
            <?php
			$ufr=selTableData("filiere","code");
			for($i=0;$i<count($ufr);$i++){
				$selected="";
				if($modification['filiere']==$ufr[$i]['code']){ $selected="selected=\"selected\"";}
				echo "<option value='".$ufr[$i]['code']."'>".strtolower($ufr[$i]['libelle'])."</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>statut</td>
            <td>
            <select name="statut2" id="statut2">
            <?php
			$ufr=selTableMultiAnswer("mode","actif","1");
			for($i=0;$i<count($ufr);$i++){
				$selected="";
				if($modification['statut']==$ufr[$i]['code']){ $selected="selected=\"selected\"";}
				echo "<option value='".$ufr[$i]['code']."'>".strtolower($ufr[$i]['Intitule'])."</option>";
			}
			?>
            </select>
            </td>
          </tr>
          <tr>
            <td>zone</td>
            <td>
            <select name="zone2" id="zone2">
            <?php
			$ufr=selTableData("zone","COD_ZONE");
			for($i=0;$i<count($ufr);$i++){
				$selected="";
				if($modification['zone']==$ufr[$i]['COD_ZONE']){ $selected="selected=\"selected\"";}
				echo "<option value='".$ufr[$i]['COD_ZONE']."' ".$selected.">".strtolower($ufr[$i]['LIB_ZONE'])."</option>";
			}
			?>
            </select>
            </td>
          </tr>
          <tr>
            <td>Frais de formation</td>
            <td><input name="ff2" id="ff2" class="easyui-validatebox" required="true" value="<?php echo $modification['FF']; ?>"></td>
          </tr>
          <tr>
            <td>Frais d'inscription</td>
            <td><input name="fi2" id="fi2" class="easyui-validatebox" required="true" value="<?php echo $modification['FI']; ?>"></td>
          </tr>
          <tr>
            <td colspan="2"><input name="modif" id="modif" value="<?php echo $_GET['modif']; ?>" type="hidden" />
            <div id="dlg-buttons" align="center" style="padding:15px">
				<input name="ajouter" type="submit" value="modifier" />
   			</div>
            </td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
?>