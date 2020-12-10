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
if(isset($_POST['cod_pays'])){
	//controle de l'existance
	$controle=selTableDataCount("pays","cod_pays",$_POST['cod_pays'],$pdo);
	if($controle==0){
		$champ=array('cod_pays','cod_zone','lib_pays','lib_nation');
		$valeur=array($_POST['cod_pays'],$_POST['cod_zone'],$_POST['lib_pays'],$_POST['lib_nation']);
		insTable("pays",$champ,$valeur,$pdo);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?pays&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?pays&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('cod_pays','cod_zone','lib_pays','lib_nation');
	$valeur=array($_POST['cod_pays2'],$_POST['cod_zone2'],$_POST['lib_pays2'],$_POST['lib_nation2']);
	updTable("pays",$champ,$valeur,"cod_pays",$_POST['modif'],$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?pays&modifOK');
		// -->
		</script>";
}

?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#list_pays').dataTable({	
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
	 $.messager.confirm('Confirm','Voulez vous supprimer ce pays : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_pays.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?pays&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES PAYS</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Pays Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','Pays modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Ce pays existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Ce pays a été bien supprimée!','info');
    </script>
<?php
}
///action pour l'ajout d'une UFR
if(isset($_POST['cod_zone'])){
	//controle de l'existance
	$controle=selTableDataCount("pays","cod_zone",$_POST['cod_zone'],$pdo);
	if($controle==0){
		$champ=array('cod_pays','cod_zone','lib_pays','lib_nation');
		$valeur=array($_POST['cod_pays'],$_POST['cod_zone'],$_POST['lib_pays'],$_POST['lib_nation']);
		insTable("pays",$champ,$valeur,$pdo);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?type&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?type&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('cod_pays','cod_zone','lib_pays','lib_nation');
	$valeur=array($_POST['cod_pays2'],$_POST['cod_zone2'],$_POST['lib_pays2'],$_POST['lib_nation2']);
	updTable("pays",$champ,$valeur,"id",$_POST['modif'],$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?type&modifOK');
		// -->
		</script>";
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
     <a href="?pays&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_pays" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>CODE PAYS</td>
    <td>CODE ZONE</td>
    <td>LIBELLE PAYS</td>
    <td>LIBELLE NATION</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableData("pays","cod_pays",$pdo);
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td><?php echo $liste[$i]['cod_pays']; ?></td>
    <td <?php 
	$zone=selTableDataWhere("zone","COD_ZONE",$liste[$i]['cod_zone'],$pdo);
	echo "title=\"".$zone['LIB_ZONE']."\"";
	echo $liste[$i]['cod_zone']; ?>><?php echo $liste[$i]['cod_zone']; ?></td>
    <td><?php echo $liste[$i]['lib_pays']; ?></td>
    <td><?php echo $liste[$i]['lib_nation']; ?></td>
    <td>  
<a href="?pays&modif=<?php echo $liste[$i]['cod_pays']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
<a onclick="suppression('<?php echo $liste[$i]['cod_pays']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a>
    </td>
  </tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="?pays" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouveau pays" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
         <tr>
            <td>Code zone</td>
            <td>
            <select required="true" name="cod_zone" id="cod_zone">
            <?php
			$ufr=selTableData("zone","COD_ZONE",$pdo);
			for($i=0;$i<count($ufr);$i++){
				echo "<option value='".$ufr[$i]['COD_ZONE']."'>".strtolower($ufr[$i]['LIB_ZONE'])."</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>Code pays</td>
            <td><input name="cod_pays" id="cod_pays" class="easyui-validatebox" required="true" ></td>
          </tr>
          <tr>
            <td>Libellé pays</td>
            <td><input name="lib_pays" id="lib_pays" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Libellé Nationalité</td>
            <td><input name="lib_nation" id="lib_nation" class="easyui-validatebox" required="true"></td>
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
$modifcation=selTableDataWhere("pays","cod_pays",$_GET['modif'],$pdo);
?>
<div align="center" id='retour' style="display:none"> <a href="?pays" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Modifier d'un pays" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
           <tr>
            <td>Code zone</td>
            <td>
            <select required="true" name="cod_zone2" id="cod_zone2">
            <?php
			$ufr=selTableData("zone","COD_ZONE",$pdo);
			for($i=0;$i<count($ufr);$i++){
				$selected="";
				if($modifcation['cod_zone']==$ufr[$i]['COD_ZONE']){ $selected="selected=\"selected\""; }
				echo "<option value='".$ufr[$i]['COD_ZONE']."' ".$selected.">".strtolower($ufr[$i]['LIB_ZONE'])."</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td>Code pays</td>
            <td><input name="cod_pays2" id="cod_pays2" class="easyui-validatebox" required="true" value="<?php echo $modifcation['cod_pays']; ?>"></td>
          </tr>
          <tr>
            <td>libellé pays</td>
            <td><input name="lib_pays2" id="lib_pays2" class="easyui-validatebox" required="true" value="<?php echo $modifcation['lib_pays']; ?>"></td>
          </tr>
          <tr>
            <td>nationalité</td>
            <td><input name="lib_nation2" id="lib_nation2" class="easyui-validatebox" required="true" value="<?php echo $modifcation['lib_nation']; ?>"></td>
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