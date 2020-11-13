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
	$controle=selTableDataCount("mode","code",$_POST['code']);
	if($controle==0){
		$champ=array('code','Intitule','actif');
		$valeur=array($_POST['code'],$_POST['libelle'],$_POST['actif']);
		insTable("mode",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?statut&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?statut&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('code','Intitule','actif');
	$valeur=array($_POST['code2'],$_POST['libelle2'],$_POST['actif2']);
	updTable("mode",$champ,$valeur,"code",$_POST['modif']);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?statut&modifOK');
		// -->
		</script>";
}

?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#list_statut').dataTable({	
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
	 $.messager.confirm('Confirm','Voulez vous supprimer ce statut : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_statut.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?statut&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES STATUTS</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Statut Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','Statut modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Ce statut existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Ce statut a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
            <a href="?statut&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_statut" class="display">
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
$liste=selTableData("mode","code");
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td><?php echo $liste[$i]['code']; ?></td>
    <td><?php echo $liste[$i]['Intitule']; ?></td>
    <td <?php if($liste[$i]['actif']==1){echo "bgcolor=\"#FFFF99\""; }?>><?php echo $liste[$i]['actif']; ?></td>
    <td>  
<a href="?statut&modif=<?php echo $liste[$i]['code']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
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
<div align="center" id='retour' style="display:none"> <a href="ufr.php" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouveau statut" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Code</td>
            <td><input name="code" id="code" class="easyui-validatebox" required="true" ></td>
          </tr>
          <tr>
            <td>Libellé</td>
            <td><input name="libelle" id="libelle" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Actif</td>
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
$modifcation=selTableDataWhere("mode","code",$_GET['modif']);
?>
<div align="center" id='retour' style="display:none"> <a href="ufr.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Ajout d'un nouveau" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Code</td>
            <td><input name="code2" id="code2" class="easyui-validatebox" required="true" value="<?php echo $modifcation['code']; ?>"></td>
          </tr>
          <tr>
            <td>Libellé</td>
            <td><input name="libelle2" id="libelle2" class="easyui-validatebox" required="true" value="<?php echo $modifcation['Intitule']; ?>"></td>
          </tr>
          <tr>
            <td>Détail</td>
            <td><input name="actif2" id="actif2" type="checkbox" value="1" <?php if($modifcation['actif']==1){ echo "checked=\"checked\"";} ?> /></td>
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