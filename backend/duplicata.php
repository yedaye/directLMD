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
	//controle de la validation
	$controle=requete("SELECT count(*) as nombre FROM inscription WHERE matricule='".$_POST['matricule']."' AND annee_academique='".$_POST['annee']."' AND carte_imprime='oui'", $pdo);
	if($controle[0]['nombre']>0){
		$champ=array('matricule','num_enregistrement','annee_acad','user');
		$valeur=array($_POST['matricule'],$_POST['enregistrement'],$_POST['annee'],$_POST['user']);
		insTable("duplicata",$champ,$valeur, $pdo);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?duplicata&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?duplicata&ajoutDJA');
		// -->
		</script>";
	}
}


?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#list_dept').dataTable({	
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

function suppression(val,val2){
	
    $.messager.confirm('Confirm','Voulez vous supprimer ce duplicata : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_duplicata.php',{matricule:val,annee:val2},function(data){  
				if(data==1){
					document.location.href="?duplicata&supOK";
				}else{
                    document.write(data);
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
<div id="haut" style="height:75px"><center>GESTION DES DUPLICATA</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','duplicata Bien ajoutée!','info');
    </script>
<?php
}
?>

<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','L\'inscription n\'a encore jamais été validé' ,'warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Cette duplicata a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
            <a href="?duplicata&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_dept" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>Matricule</td>
    <td>Ann&eacute;e Acad&eacute;mique</td>
    <td>Num&eacute;ro D'enregistrement</td>
    <td>Date</td>
    <td>Utilisateur</td>
    <td>Num_carte</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableDataDesc("duplicata","id", $pdo);
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td><?php echo $liste[$i]['matricule']; ?></td>
    <td><?php echo $liste[$i]['annee_acad']; ?></td>
    <td><?php echo utf8_decode($liste[$i]['num_enregistrement']); ?></td>
    <td><?php echo $liste[$i]['date']; ?></td>
    <td><?php echo $liste[$i]['user']; ?></td>
    <td><?php echo $liste[$i]['num_carte']; ?></td>
    <td><a href="<?php  echo "carte_duplicata_pdf.php?matricule=".$liste[$i]['matricule']."&annee=".$liste[$i]['annee_acad']."&num_carte=".$liste[$i]['num_carte']; ?>" target="_blank"><img src="../img/imprimante.png" height="24" width="24" /></a></td>
    <td><?php if($_SESSION['username']=='sylvain'){ ?><a onclick="suppression('<?php echo $liste[$i]['matricule']; ?>','<?php echo $liste[$i]['annee_acad']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a><?php  } ?>
    </td>
  </tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="?duplicata" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouvelle duplicata" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Matricule</td>
            <td><input name="matricule" id="matricule" class="easyui-validatebox" required="true" ></td>
          </tr>
            <tr>
            <td>Année Académique</td>
            <td ><select required="true" name="annee" id="annee">
            <?php
			     $ufr=selTableDataDesc("annee_academique","lib_annee", $pdo);
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['lib_annee']."'>".strtoupper($ufr[$i]['lib_annee'])."</option>";
				}	
			?>
            </select></td>
          </tr>
          <tr>
            <td>N°Enregistrement</td>
            <td><input name="enregistrement" id="enregistrement" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td colspan="2">
            <div id="dlg-buttons" align="center" style="padding:15px">
				<input name="Imprimer" type="submit" value="ajouter" /><input name="user" id="user" type="hidden" value="<?php echo $_SESSION['username'] ?>"/><input name="ajout" id="ajout" type="hidden" value=""/>
   			</div>
            </td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
?>
