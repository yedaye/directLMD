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
if(isset($_POST['code_ecole'])){
	//controle de l'existance
	$controle=selTableDataCount("ecole_ufr","code_ecole",$_POST['code_ecole']);
	if($controle==0){
		$champ=array('code_ecole','code_ufr','lib_ecole','detail_ecole','actif');
		$valeur=array($_POST['code_ecole'],$_POST['code_ufr'],addslashes($_POST['libelle']),addslashes($_POST['details']),$_POST['actif']);
		insTable("ecole_ufr",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?ecole&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?ecole&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('code_ecole','code_ufr','lib_ecole','detail_ecole','actif');
	$valeur=array($_POST['code_ecole2'],$_POST['code_ufr2'],addslashes($_POST['libelle2']),addslashes($_POST['details2']),$_POST['actif2']);
	updTable("ecole_ufr",$champ,$valeur,"code_ecole",$_POST['modif']);
	echo "<script language='Javascript'>
	<!--
	document.location.replace('?ecole&modifOK');
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
	 $.messager.confirm('Confirm','Voulez vous supprimer cette ecole : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_ecole.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?ecole&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES UFR</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','UFR Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','UFR modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Cette UFR existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Cette UFR a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
            <a href="?ecole&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ecole" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>UFR</td>
    <td>ECOLE</td>
    <td>LIBELLE ECOLE</td>
    <td>DETAIL</td>
    <td>ACTIVATION</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableData("ecole_ufr","code_ecole");
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td title=""><?php echo $liste[$i]['code_ufr']; ?></td>
    <td><?php echo $liste[$i]['code_ecole']; ?></td>
    <td><?php echo stripslashes($liste[$i]['lib_ecole']); ?></td>
    <td><?php echo stripslashes($liste[$i]['detail_ecole']); ?></td>
   	<td <?php 
	if($liste[$i]['actif']=='1'){ echo "bgcolor='#FFAACC'"; } ?> ><input type="checkbox" readonly="readonly" disabled="disabled" <?php 
	if($liste[$i]['actif']=='1'){ echo "checked=\"checked\""; } ?> /></td>
    <td>  
<a href="?ecole&modif=<?php echo $liste[$i]['code_ecole']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
<a onclick="suppression('<?php echo $liste[$i]['code_ecole']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a>
    </td>
  </tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="ecole_ufr.php" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouvelle ecole" style="width:700px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Code UFR</td>
            <td>
            <select required="true" name="code_ufr" id="code_ufr">
            <?php
			$ufr=selTableData("ufr","code_ufr");
			for($i=0;$i<count($ufr);$i++){
				echo "<option value='".$ufr[$i]['code_ufr']."'>".strtolower($ufr[$i]['lib_ufr'])." (".$ufr[$i]['code_ufr'].")</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>Code école</td>
            <td><input name="code_ecole" id="code_ecole" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Libellé école</td>
            <td><textarea name="libelle" cols="50" rows="5" class="easyui-validatebox" id="libelle" required="true"></textarea></td>
          </tr>
          <tr>
            <td>Détail</td>
            <td><textarea cols="35" rows="8" class="" name="details" id="details"></textarea></td>
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
$modification=selTableDataWhere("ecole_ufr","code_ecole",$_GET['modif']);
?>
<div align="center" id='retour' style="display:none"> <a href="ecole_ufr.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Ajout d'une nouvelle école" style="width:700px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Code UFR</td>
            <td>
            <select required="true" name="code_ufr2" id="code_ufr2">
            <?php
			$ufr=selTableData("ufr","code_ufr");
			for($i=0;$i<count($ufr);$i++){
				$selected="";
				if($modification['code_ufr']==$ufr[$i]['code_ufr']){ $selected="selected=\"selected\""; }
				echo "<option value='".$ufr[$i]['code_ufr']."' ".$selected.">".$ufr[$i]['lib_ufr']."</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>Code école</td>
            <td><input value="<?php echo $modification['code_ecole']; ?>" name="code_ecole2" id="code_ecole2" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Libellé école</td>
            <td><textarea name="libelle2" cols="50" rows="5" class="easyui-validatebox" id="libelle2" required="true"><?php echo $modification['lib_ecole']; ?></textarea></td>
          </tr>
          <tr>
            <td>Détail</td>
            <td><textarea cols="35" rows="8" class="" name="details2" id="details2"><?php echo $modification['detail_ecole']; ?></textarea></td>
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