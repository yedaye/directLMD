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
	$controle=selTableDataCount("table_ue","code_ue",$_POST['code']);
	if($controle==0){
		$champ=array('code_ue','designation','credit','code_ecole');
		$valeur=array($_POST['code'],addslashes($_POST['libelle']),$_POST['credit'],$_POST['code_ecole']);
		insTable("table_ue",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?ue&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?ue&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('code_ue','designation','credit','code_ecole');
	$valeur=array($_POST['code2'],addslashes($_POST['libelle2']),$_POST['credit2'],$_POST['code_ecole2']);
	updTable("table_ue",$champ,$valeur,"code_ue",$_POST['modif']);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?ue&modifOK');
		// -->
		</script>";
}

?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#list_ue').dataTable({	
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
	 $.messager.confirm('Confirm','Voulez vous supprimer cette UE : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_ue.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?ue&supOK";
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
<div id="haut" style="height:75px"><center>
GESTION DES UNITES D'ENSEIGNEMENTS
</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','UE Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','UE modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Cette UE existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Cette UE a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
     <a href="?ue&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ue" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>CODE Filiere</td>
    <td>CODE UE</td>
    <td>LIBELLE UE</td>
    <td>CREDIT UE</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableData("table_ue","code_ue");
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td height="25"><?php echo $liste[$i]['code_ecole']; ?></td>
    <td height="25"><?php echo $liste[$i]['code_ue']; ?></td>
    <td><?php echo utf8_encode($liste[$i]['designation']); ?></td>
    <td><?php echo $liste[$i]['credit']; ?></td>
    <td>  
<a href="?ue&modif=<?php echo $liste[$i]['code_ue']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
<a onclick="suppression('<?php echo $liste[$i]['code_ue']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a>
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
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouvelle UFR" style="width:850px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Code Filiere</td>
            <td>
                <select required="true" name="code_ecole" id="code_ecole">
                    <?php
                    $ufr=selTableData("filiere","code");
                    for($i=0;$i<count($ufr);$i++){
                        echo "<option value='".$ufr[$i]['code']."'>".$ufr[$i]['libelle']."</option>";
                    }
                    ?>
                </select>
            </td>
          </tr>
          <tr>
            <td>Code UE</td>
            <td><input name="code" id="code" class="easyui-validatebox" required="true" ></td>
          </tr>
          <tr>
            <td>Libellé UE</td>
            <td><input name="libelle" id="libelle" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Crédit</td>
            <td><input name="credit" id="credit" class="easyui-validatebox" required="true"></td>
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
$modification=selTableDataWhere("table_ue","code_ue",$_GET['modif']);
?>
<div align="center" id='retour' style="display:none"> <a href="ufr.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Modification UE" style="width:850px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Code ECOLE</td>
            <td>
                <select required="true" name="code_ecole2" id="code_ecole2">
                    <?php
                    $ufr=selTableData("filiere","code");
                    for($i=0;$i<count($ufr);$i++){
                        $selected="";
                        if($modification['code_ecole']==$ufr[$i]['code']){ $selected="selected=\"selected\""; }
                        echo "<option value='".$ufr[$i]['code']."' ".$selected.">".$ufr[$i]['libelle']."</option>";
                    }
                    ?>
                </select>
            </td>
          </tr>
          <tr>
            <td>Code UE</td>
            <td><input name="code2" id="code2" class="easyui-validatebox" required="true" value="<?php echo $modification['code_ue']; ?>"></td>
          </tr>
          <tr>
            <td>Libellé UE</td>
            <td><input name="libelle2" id="libelle2" class="easyui-validatebox" required="true" value="<?php echo $modification['designation']; ?>"></td>
          </tr>
          <tr>
            <td>Credit</td>
            <td><input name="credit2" id="credit2" class="easyui-validatebox" required="true" value="<?php echo $modification['credit']; ?>"></td>
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