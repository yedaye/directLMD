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
	$champ=array('filiere','verdict','fil_auto');
	$valeur=array($_POST['filiere'],$_POST['verdict'],$_POST['fil_auto']);
	insTable("mapping",$champ,$valeur,$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?mapping&ajoutOK');
		// -->
		</script>";
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('filiere','verdict','fil_auto');
	$valeur=array($_POST['filiere'],$_POST['verdict'],$_POST['fil_auto2']);
	updTable("mapping",$champ,$valeur,"id",$_POST['modif'],$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?mapping&modifOK');
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
	 $.messager.confirm('Confirm','Voulez vous supprimer ce mapping : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_mapping.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?mapping&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES MAPPING</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Mapping Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','mapping modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Ce mapping existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Ce mapping a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
    <a href="?mapping&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ecole" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>Filiere</td>
    <td>Verdict</td>
    <td>Filière autorisé</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableDataDesc("mapping","id",$pdo);
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td title=""><?php echo $liste[$i]['filiere']; ?></td>
    <td><?php echo $liste[$i]['verdict']; ?></td>
    <td><?php echo $liste[$i]['fil_auto']; ?></td>
    <td>  
  <a href="?mapping&modif=<?php echo $liste[$i]['id']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
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
<div align="center" id='retour' style="display:none"> <a href="ecole_ufr.php" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouvelle ecole" style="width:700px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Filière</td>
            <td>
            <select required="true" name="filiere" id="filiere">
            <?php
			$ufr=selTableData("filiere","code",$pdo);
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['code']."'>".strtoupper($ufr[$i]['code'])."</option>";
				}	
			?>
            </select></td>
          </tr>
          <tr>
            <td>Verdict</td>
            <td><label for="verdict"></label>
              <select name="verdict" id="verdict">
                <option value="Admis">Admis</option>
                <option value="Refuse">Refuse</option>
                <option value="Chevauche">Chevauche</option>
            </select></td>
          </tr>
          <tr>
            <td>filière autorisé</td>
            <td><select required="true" name="fil_auto" id="fil_auto">
              <?php
				$ufr=selTableData("filiere","code",$pdo);
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['code']."'>".strtoupper($ufr[$i]['code'])."</option>";
				}			?>
            </select></td>
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
$modification=selTableDataWhere("mapping","id",$_GET['modif'],$pdo);
?>
<div align="center" id='retour' style="display:none"> <a href="mapping.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Modification du mapping" style="width:700px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Filière</td>
            <td><select required="true" name="filiere2" id="filiere2">
              <?php
				$ufr=selTableData("filiere","code",$pdo);
				for($i=0;$i<count($ufr);$i++){
					$select="";
					if($modification['code']==$ufr[$i]['code']){ $select="selected=\"selected\""; }
					echo "<option value='".$ufr[$i]['code']."' ".$select.">".strtoupper($ufr[$i]['code'])."</option>";
				}			?>
            </select></td>
          </tr>
          <tr>
            <td>Verdict</td>
            <td><label for="verdict"></label>
              <select name="verdict2" id="verdict2">
                <option value="Admis" <?php if("Admis"==$modification['verdict']){ echo "selected=\"selected\""; } ?>>Admis</option>
                <option value="Refuse" <?php if("Refuse"==$modification['verdict']){ echo "selected=\"selected\""; } ?>>Refuse</option>
                <option value="Chevauche" <?php if("Chevauche"==$modification['verdict']){ echo "selected=\"selected\""; } ?>>Chevauche</option>
              </select></td>
          </tr>
          <tr>
            <td>Filière autorisé</td>
            <td><select required="true" name="fil_auto2" id="fil_auto2">
              <?php
			$ufr=selTableData("filiere","code",$pdo);
			for($i=0;$i<count($ufr);$i++){
				$select="";
				if($modification['code']==$ufr[$i]['code']){ $select="selected=\"selected\""; }
				echo "<option value='".$ufr[$i]['code']."'".$select.">".strtoupper($ufr[$i]['code'])."</option>";
			}
			?>
            </select></td>
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