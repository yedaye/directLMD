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
if(isset($_POST['option'])){
	//$filiere=$_POST['option']."-".$_POST['ecole'];
	//controle de l'existance
	$controle=selTableDataCount("filiere","code",$_POST['option'],$pdo);
	if($controle==0){
		$champ=array('code','libelle','ecole','actif');
		$valeur=array($_POST['option'],$_POST['libelle'],$_POST['ecole'],$_POST['actif']);
		insTable("filiere",$champ,$valeur,$pdo);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?filiere&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?filiere&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	//$filiere2=$_POST['option2']."-".$_POST['ecole2'];
	$champ=array('code','libelle','ecole','actif');
	$valeur=array($_POST['option2'],$_POST['libelle2'],$_POST['ecole2'],$_POST['actif2']);
	updTable("filiere",$champ,$valeur,"code",$_POST['modif'],$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?filiere&modifOK');
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
	 $.messager.confirm('Confirm','Voulez vous supprimer cette filiere : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_filiere.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?filiere&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES FILIERES</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Filière Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','Filière modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Cette filière existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Cette filière a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
            <a href="?filiere&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ecole" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>CODE</td>
    <td>LIBELLE</td>
    <td>ACTIVATION</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableData("filiere","code",$pdo);
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td title=""><?php echo $liste[$i]['code']; ?></td>
    <td><?php echo $liste[$i]['libelle']; ?></td>
   	<td <?php 
	if($liste[$i]['actif']=='1'){ echo "bgcolor='#FFAACC'"; } ?> ><input type="checkbox" readonly="readonly" disabled="disabled" <?php 
	if($liste[$i]['actif']=='1'){ echo "checked=\"checked\""; } ?> /></td>
    <td>  
<a href="?filiere&modif=<?php echo $liste[$i]['code']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
<a onclick="suppression('<?php echo $liste[$i]['code']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a>
    </td>
  </tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="?filiere" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouvelle filière" style="width:750px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>ECOLE</td>
            <td>
            <select required="true" name="ecole" id="ecole">
            <?php
			$ufr=selTableData("ecole_ufr","code_ecole",$pdo);
			for($i=0;$i<count($ufr);$i++){
				echo "<option value='".$ufr[$i]['code_ecole']."'>".strtolower($ufr[$i]['lib_ecole'])." (".$ufr[$i]['code_ecole'].")</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>OPTION</td>
            <td>
            <input name="option" id="option" class="easyui-validatebox" required="true">
            </td>
          </tr>
          <tr>
            <td>Libellé</td>
            <td><input name="libelle" id="libelle" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Activation</td>
            <td><input name="actif" id="actif" type="checkbox" value="1" /></td>
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
$modification=selTableDataWhere("filiere","code",$_GET['modif'],$pdo);
?>
<div align="center" id='retour' style="display:none"> <a href="?filiere" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Ajout d'une nouvelle filière" style="width:750px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>ECOLE</td>
            <td>
            <select required="true" name="ecole2" id="ecole2">
            <?php
			$val=explode("-",$modification['code']);
			$ufr=selTableData("ecole_ufr","code_ecole",$pdo);
			for($i=0;$i<count($ufr);$i++){
				$selected="";
				if($val[1]==$ufr[$i]['code_ecole']){ $selected="selected=\"selected\"";}
				echo "<option value='".$ufr[$i]['code_ecole']."' ".$selected.">".strtolower($ufr[$i]['lib_ecole'])." (".$ufr[$i]['code_ecole'].")</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>OPTION</td>
            <td>
				<input name="option2" id="option2" class="easyui-validatebox" required="true" value="<?php echo $modification['code'] ?>">
            </td>
          </tr>
          <tr>
            <td>Libellé</td>
            <td><input name="libelle2" id="libelle2" class="easyui-validatebox" value="<?php echo $modification['libelle']; ?>" required="true"></td>
          </tr>
          <tr>
            <td>Activation</td>
            <td><input name="actif2" id="actif2" type="checkbox" value="1" <?php if($modification['actif']==1){ echo "checked=\"checked\"";} ?> /></td>
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