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
if(isset($_POST['lib_annee'])){
	//controle de l'existance
	$controle=selTableDataCount("annee_academique","lib_annee",$_POST['lib_annee']);
	if($controle==0){
		$champ=array('lib_annee','date_debut','date_fin');
		$valeur=array($_POST['lib_annee'],$_POST['date_debut'],$_POST['date_fin']);
		insTable("annee_academique",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?anneeacad&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?anneeacad&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('lib_annee','date_debut','date_fin');
	$valeur=array($_POST['lib_annee2'],$_POST['date_debut2'],$_POST['date_fin2']);
	updTable("annee_academique",$champ,$valeur,"lib_annee",$_POST['modif']);
	echo "<script language='Javascript'>
	<!--
	document.location.replace('?anneeacad&modifOK');
	// -->
	</script>";
}

?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#list_ufr').dataTable({	
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
	 $.messager.confirm('Confirm','Voulez vous supprimer cette annee_academique : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_annee.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?anneeacad&supOK";
				}
			});  
		}  
	});  	
}
function myformatter(date){
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var d = date.getDate();
	return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
}
function myparser(s){
	if (!s) return new Date();
	var ss = s.split('-');
	var y = parseInt(ss[0],10);
	var m = parseInt(ss[1],10);
	var d = parseInt(ss[2],10);
	if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
		return new Date(y,m-1,d);
	} else {
		return new Date();
	}
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
<div id="haut" style="height:75px"><center>GESTION DES ANNEES ACADEMIQUES</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Année Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','Année modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Cette année existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Cette année a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
            <a href="?anneeacad&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ufr" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>CODE ANNEE</td>
    <td>DATE DEBUT</td>
    <td>DATE FIN</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableData("annee_academique","lib_annee");
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td><?php echo $liste[$i]['lib_annee']; ?></td>
    <td><?php echo $liste[$i]['date_debut']; ?></td>
    <td><?php echo $liste[$i]['date_fin']; ?></td>
    <td>  
<a href="?anneeacad&modif=<?php echo $liste[$i]['lib_annee']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
<a onclick="suppression('<?php echo $liste[$i]['lib_annee']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a>
    </td>
  </tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="?anneeacad" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouvelle année" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post" action="">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Libellé année</td>
            <td><input name="lib_annee" id="lib_annee" class="easyui-validatebox" required="true" ></td>
          </tr>
          <tr>
            <td>Date debut</td>
            <td><input name="date_debut" id="date_debut" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"></td>
          </tr>
          <tr>
            <td>Date fin</td>
            <td><input name="date_fin" id="date_fin" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"></td>
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
$modifcation=selTableDataWhere("annee_academique","lib_annee",$_GET['modif']);
?>
<div align="center" id='retour' style="display:none"> <a href="accueil.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Ajout d'une nouvelle année" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post" action="">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Libellé année</td>
            <td><input name="lib_annee2" id="lib_annee2" class="easyui-validatebox" required="true" value="<?php echo $modifcation['lib_annee']; ?>"></td>
          </tr>
          <tr>
            <td>Date debut</td>
            <td><input name="date_debut2" id="date_debut2" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" value="<?php echo $modifcation['date_debut']; ?>"></td>
          </tr>
          <tr>
            <td>Date fin</td>
            <td><input name="date_fin2" id="date_fin2" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" value="<?php echo $modifcation['date_fin']; ?>"></td>
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