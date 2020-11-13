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
	$controle=selTableDataCount("param","anne_academique",$_POST['anne_academique']);
	if($controle==0){
		$champ=array('anne_academique','an_precedent','moyenne_ecu_mini','moyenne_ue_mini','pourcentage_ue_mini','session_bac','montant_ecu');
		$valeur=array($_POST['anne_academique'],$_POST['an_precedent'],$_POST['moyenne_ecu_mini'],$_POST['moyenne_ue_mini'],$_POST['pourcentage_ue_mini'],$_POST['session_bac'],$_POST['montant_ecu']);
		insTable("param",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?param&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?param&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
		$champ=array('anne_academique','an_precedent','moyenne_ecu_mini','moyenne_ue_mini','pourcentage_ue_mini','session_bac','montant_ecu');
		$valeur=array($_POST['anne_academique2'],$_POST['an_precedent2'],$_POST['moyenne_ecu_mini2'],$_POST['moyenne_ue_mini2'],$_POST['pourcentage_ue_mini2'],$_POST['session_bac2'],$_POST['montant_ecu2']);
		updTable("param",$champ,$valeur,"id",$_POST['id']);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?param&modifOK');
		// -->
		</script>";
}

?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#paramtable').dataTable({	
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
	 $.messager.confirm('Confirm','Voulez vous supprimer ce parametre : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_param.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?param&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES PARAMETRES</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','parametre Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','parametre modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Ce parametre existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Ce parametre a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right" width='90%'>  
            <a href="?param&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="90%" border="0" cellspacing="2" cellpadding="0" id="paramtable" class="display" align='center'>
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>ANNEE ACADEMIQUE</td>
    <td>AN_PRECEDENT</td>
	<td>MOYENNE ECU MINI</td>
    <td>MOYENNE UE MINI</td>
	<td>POURCENTAGE UE MINI</td>
    <td>SESSION BAC</td>
	<td>MONTANT ECU</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableData("param","id");
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td><?php echo $liste[$i]['anne_academique']; ?></td>
    <td><?php echo $liste[$i]['an_precedent']; ?></td>
	<td><?php echo $liste[$i]['moyenne_ecu_mini']; ?></td>
	<td><?php echo $liste[$i]['moyenne_ue_mini']; ?></td>
	<td><?php echo $liste[$i]['pourcentage_ue_mini']; ?></td>
	<td><?php echo $liste[$i]['session_bac']; ?></td>
	<td><?php echo $liste[$i]['montant_ecu']; ?></td>
	<td></td>
    <td>  
<a href="?param&modif=<?php echo $liste[$i]['id']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
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
<div align="center" id='retour' style="display:none"> <a href="?param" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'un nouveau parametre" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Annee Academique</td>
            <td><input name="anne_academique" id="anne_academique" class="easyui-validatebox" required="true" ></td>
          </tr>
          <tr>
            <td>Annee Précédente</td>
            <td><input name="an_precedent" id="an_precedent" class="easyui-validatebox" required="true"></td>
          </tr>
		  <tr>
            <td>Moyenne Ecu Mini</td>
            <td><input name="moyenne_ecu_mini" id="moyenne_ecu_mini" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Moyenne UE Mini</td>
            <td><input name="moyenne_ue_mini" id="moyenne_ue_mini" class="easyui-validatebox" required="true"></td>
          </tr>
		  <tr>
            <td>Pourcentage Ue Mini</td>
            <td><input name="pourcentage_ue_mini" id="pourcentage_ue_mini" class="easyui-validatebox" required="true"></td>
          </tr>
		  <tr>
            <td>Session bac</td>
            <td><input name="session_bac" id="session_bac" class="easyui-validatebox" required="true"></td>
          </tr>
		  <tr>
            <td>Montant ECU</td>
            <td><input name="montant_ecu" id="montant_ecu" class="easyui-validatebox" required="true"></td>
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
$modifcation=selTableDataWhere("param","id",$_GET['modif']);
?>
<div align="center" id='retour' style="display:none"> <a href="?param" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Modifier un parametre" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Annee Academique</td>
            <td><input name="anne_academique2" id="anne_academique2" class="easyui-validatebox" required="true" value='<?php echo $modifcation['anne_academique']; ?>' ></td>
          </tr>
          <tr>
            <td>Annee Précédente</td>
            <td><input name="an_precedent2" id="an_precedent2" class="easyui-validatebox" required="true" value='<?php echo $modifcation['an_precedent']; ?>'></td>
          </tr>
		  <tr>
            <td>Moyenne Ecu Mini</td>
            <td><input name="moyenne_ecu_mini2" id="moyenne_ecu_mini2" class="easyui-validatebox" required="true" value='<?php echo $modifcation['moyenne_ecu_mini']; ?>'></td>
          </tr>
          <tr>
            <td>Moyenne UE Mini</td>
            <td><input name="moyenne_ue_mini2" id="moyenne_ue_mini2" class="easyui-validatebox" required="true" value='<?php echo $modifcation['moyenne_ue_mini']; ?>'></td>
          </tr>
		  <tr>
            <td>Pourcentage Ue Mini</td>
            <td><input name="pourcentage_ue_mini2" id="pourcentage_ue_mini2" class="easyui-validatebox" required="true" value='<?php echo $modifcation['pourcentage_ue_mini']; ?>'></td>
          </tr>
		  <tr>
            <td>Session bac</td>
            <td><input name="session_bac2" id="session_bac2" class="easyui-validatebox" required="true" value='<?php echo $modifcation['session_bac']; ?>'></td>
          </tr>
		  <tr>
            <td>Montant ECU</td>
            <td><input name="montant_ecu2" id="montant_ecu2" class="easyui-validatebox" required="true" value='<?php echo $modifcation['montant_ecu']; ?>'></td>
          </tr>
		  <tr>
            <td colspan="2">
            <div id="dlg-buttons" align="center" style="padding:15px">
			<input type='hidden' name='id' id='id' value='<?php echo $modifcation['id']; ?>'/>
				<input name="modif" type="submit" value="modifier" />
   			</div>
            </td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
?>