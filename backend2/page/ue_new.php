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
	$controle=selTableDataCount2("table_ue_new","code_ue",$_POST['code'],"promotion",$_POST['promo']);
	if($controle==0){
		$champ=array('promotion','code_ue','designation','credit','code_ecole');
		$valeur=array($_POST['promo'],$_POST['code'],addslashes($_POST['libelle']),$_POST['credit'],$_POST['code_ecole']);
		insTable("table_ue_new",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?ue_new&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?ue_new&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('promotion','code_ue','designation','credit','code_ecole');
	$valeur=array($_POST['promo2'],$_POST['code2'],addslashes($_POST['libelle2']),$_POST['credit2'],$_POST['code_ecole2']);
	$ArWherField=array("promotion","code_ue");
	$ArWherVal=array($_POST['promo3'],$_POST['modif']);
	updTableWhereArray("table_ue_new",$champ,$valeur,$ArWherField,$ArWherVal);
	//updTable("table_ue_new",$champ,$valeur,"code_ue",$_POST['modif']);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?ue_new&modifOK');
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

function suppression(val, val2){
	 $.messager.confirm('Confirm','Voulez vous supprimer cette UE : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_ue_new.php',{code:val, promo:val2},function(data){  
				if(data==1){
					document.location.href="?ue_new&supOK";
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
     <a href="?ue_new&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ue" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>PROMOTION</td>
	<td>CODE Filiere</td>
    <td>CODE UE</td>
    <td>LIBELLE UE</td>
    <td>CREDIT UE</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableData("table_ue_new","code_ue");
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
      <td height="25"><?php echo $liste[$i]['promotion']; ?></td>
    <td height="25"><?php echo $liste[$i]['code_ecole']; ?></td>
    <td height="25"><?php echo $liste[$i]['code_ue']; ?></td>
    <td><?php echo utf8_encode($liste[$i]['designation']); ?></td>
    <td><?php echo $liste[$i]['credit']; ?></td>
    <td>  
<a href="?ue_new&modif=<?php echo $liste[$i]['code_ue']; ?>&promo=<?php echo $liste[$i]['promotion']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
<a onclick="suppression('<?php echo $liste[$i]['code_ue']; ?>','<?php echo $liste[$i]['promotion']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a>
    </td>
  </tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="ue_new.php" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouvelle UFR" style="width:850px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
		 <tr>
            <td>Promotion</td>
            <td>
                <select required="true" name="promo" id="promo">
                    <option value='P1'>Promo1 (2013-2014)</option>
					<option value='P2'>Promo2 (2014-2015)</option>					
					<option value='P3'>Promo3 (2015-2016)</option>
					<option value='P4'>Promo4 (2016-2017)</option>
                </select>
            </td>
          </tr>
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
$modification=selTableData2Fields("table_ue_new","code_ue",$_GET['modif'],'promotion',$_GET['promo']);
?>
<div align="center" id='retour' style="display:none"> <a href="ue_new.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Modification UE" style="width:850px;height:400px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
		<tr>
            <td>Promotion</td>
            <td>
                <select required="true" name="promo2" id="promo2">
                    <option value='P1' <?php if($modification[0]['promotion']=='P1'){ echo "selected=\"selected\""; } ?>>Promo1 (2013-2014)</option>
					<option value='P2' <?php if($modification[0]['promotion']=='P2'){ echo "selected=\"selected\""; } ?>>Promo2 (2014-2015)</option>					
					<option value='P3' <?php if($modification[0]['promotion']=='P3'){ echo "selected=\"selected\""; } ?>>Promo3 (2015-2016)</option>
					<option value='P4' <?php if($modification[0]['promotion']=='P4'){ echo "selected=\"selected\""; } ?>>Promo4 (2016-2017)</option>
                </select>
            </td>
          </tr>
          <tr>
            <td>Code ECOLE</td>
            <td>
                <select required="true" name="code_ecole2" id="code_ecole2">
                    <?php
                    $ufr=selTableData("filiere","code");
                    for($i=0;$i<count($ufr);$i++){
                        $selected="";
                        if($modification[0]['code_ecole']==$ufr[$i]['code']){ $selected="selected=\"selected\""; }
                        echo "<option value='".$ufr[$i]['code']."' ".$selected.">".$ufr[$i]['libelle']."</option>";
                    }
                    ?>
                </select>
            </td>
          </tr>
          <tr>
            <td>Code UE</td>
            <td><input name="code2" id="code2" class="easyui-validatebox" required="true" value="<?php echo $modification[0]['code_ue']; ?>"></td>
          </tr>
          <tr>
            <td>Libellé UE</td>
            <td><input name="libelle2" id="libelle2" class="easyui-validatebox" required="true" value="<?php echo $modification[0]['designation']; ?>"></td>
          </tr>
          <tr>
            <td>Credit</td>
            <td><input name="credit2" id="credit2" class="easyui-validatebox" required="true" value="<?php echo $modification[0]['credit']; ?>"></td>
          </tr>
          <tr>
            <td colspan="2"><input name="modif" id="modif" value="<?php echo $_GET['modif']; ?>" type="hidden" />
			<input name="promo3" id="promo3" value="<?php echo $modification[0]['promotion']; ?>" type="hidden" />
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