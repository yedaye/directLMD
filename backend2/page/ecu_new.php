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
	$controle=selTableDataCount2("table_ecu_new","code_ecu",$_POST['code'],"promotion",$_POST['promo']);
	if($controle==0){
		$champ=array('promotion','code_ue','designation','credit','code_ecu');
		$valeur=array($_POST['promo'],$_POST['code_ue'],utf8_decode(addslashes($_POST['libelle'])),$_POST['credit'],$_POST['code']);
		insTable("table_ecu_new",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?ecu_new&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?ecu_new&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('promotion','code_ecu','designation','credit','code_ue');
	$valeur=array($_POST['promo2'],$_POST['code2'],utf8_decode(addslashes($_POST['libelle2'])),$_POST['credit2'],$_POST['code_ue2']);
	$ArWherField=array("promotion","code_ecu");
	$ArWherVal=array($_POST['promo3'],$_POST['modif']);
	updTableWhereArray("table_ecu_new",$champ,$valeur,$ArWherField,$ArWherVal);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?ecu_new&modifOK');
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

function suppression(val,val2){
	 $.messager.confirm('Confirm','Voulez vous supprimer cette ECU : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_ecu_new.php',{code:val, promo:val2},function(data){  
				if(data==1){
					document.location.href="?ecu_new&supOK";
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
GESTION DES ECU <?php
if(!isset($_GET['promotion'])){
	echo "DE LA PROMOTION ".$_GET['promotion'];
}
?>
</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','ECU Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','ECU modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Cette ECU existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Cette ECU a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
     <a href="?ecu_new&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>  |   <form method='GET'>  <select required="true" name="promotion" id="promotion" onChange='submit();'>
                    <option value='P1' <?php if(isset($_GET['promotion']) && $_GET['promotion']=='P1'){ echo "selected=\"selected\""; } ?>>Promo1 (2013-2014)</option>
					<option value='P2' <?php if(isset($_GET['promotion']) && $_GET['promotion']=='P2'){ echo "selected=\"selected\""; } ?>>Promo2 (2014-2015)</option>					
					<option value='P3' <?php if(isset($_GET['promotion']) && $_GET['promotion']=='P3'){ echo "selected=\"selected\""; } ?>>Promo3 (2015-2016)</option>
					<option value='P4' <?php if(isset($_GET['promotion']) && $_GET['promotion']=='P4'){ echo "selected=\"selected\""; } ?>>Promo4 (2016-2017)</option>
                </select><input name='ecu_new' value='' type='hidden'/></form>
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_ue" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>PROMOTION</td>
	<td>CODE UE</td>
    <td>CODE ECU</td>
    <td>LIBELLE ECU</td>
    <td>CREDIT ECU</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
if(!isset($_GET['promotion'])){
	$liste=selTableMultiAnswer("table_ecu_new","promotion","P1");
}else{
	$liste=selTableMultiAnswer("table_ecu_new","promotion",$_GET['promotion']);
}
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td height="25"><?php echo $liste[$i]['promotion']; ?></td>
	<td height="25"><?php echo $liste[$i]['code_ue']; ?></td>
    <td height="25"><?php echo $liste[$i]['code_ecu']; ?></td>
    <td><?php echo utf8_encode($liste[$i]['designation']); ?></td>
    <td><?php echo $liste[$i]['credit']; ?></td>
    <td>  
<a href="?ecu_new&modif=<?php echo $liste[$i]['code_ecu']; ?>&promo=<?php echo $liste[$i]['promotion']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true"> Modifier </a>
<a onclick="suppression('<?php echo $liste[$i]['code_ecu']; ?>','<?php echo $liste[$i]['promotion']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true"> Supprimer </a>
    </td>
  </tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="ecu_new.php" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouvelle ECU" style="width:850px;height:400px;padding:10px;"
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
            <td>Code UE</td>
            <td>
                <select required="true" name="code_ue" id="code_ue">
                    <?php
                    $ufr=selTableDataUnique3Fields("table_ue_new","code_ue","designation","promotion");
                    for($i=0;$i<count($ufr);$i++){
                        echo "<option value='".$ufr[$i]['code_ue']."'>(".$ufr[$i]['code_ue'].")(".utf8_encode($ufr[$i]['promotion']).") ".$ufr[$i]['designation']."</option>";
                    }
                    ?>
                </select>
            </td>
          </tr>
          <tr>
            <td>Code ECU</td>
            <td><input name="code" id="code" class="easyui-validatebox" required="true" ></td>
          </tr>
          <tr>
            <td>Libellé ECU</td>
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
$modification=selTableData2Fields("table_ecu_new","code_ecu",$_GET['modif'],'promotion',$_GET['promo']);
?>
<div align="center" id='retour' style="display:none"> <a href="ecu_new.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Modification ECU" style="width:850px;height:400px;padding:10px;"
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
            <td>Code UE</td>
            <td>
                <select required="true" name="code_ue2" id="code_ue2">
                    <?php
                    $ufr=selTableDataUnique3Fields("table_ue_new","code_ue","designation","promotion");
                    for($i=0;$i<count($ufr);$i++){
                        $selected="";
                        if($modification[0]['code_ue']==$ufr[$i]['code_ue']){ $selected="selected=\"selected\""; }
                        echo "<option value='".$ufr[$i]['code_ue']."' ".$selected.">(".$ufr[$i]['code_ue'].")(".$ufr[$i]['promotion'].") ".utf8_encode($ufr[$i]['designation'])."</option>";
                    }
                    ?>
                </select>
            </td>
          </tr>
          <tr>
            <td>Code ECU</td>
            <td><input name="code2" id="code2" class="easyui-validatebox" required="true" value="<?php echo $modification[0]['code_ecu']; ?>"></td>
          </tr>
          <tr>
            <td>Libellé ECU</td>
            <td><input name="libelle2" id="libelle2" class="easyui-validatebox" required="true" value="<?php echo utf8_encode($modification[0]['designation']); ?>"></td>
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