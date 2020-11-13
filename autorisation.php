<?php
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");
if (is_file("../param.php"))
	include_once ("../param.php");
	

$err_msg="";
$msg_ajout="";
$msg_modif="";
$msg_dja="";
// ajout par lot 
if(isset($_POST['lot']){
        print_r($_POST['lot']);
		//process the csv file
		$handle=fopen($_FILES['file']['tmp_name'],'r');
		$data=fgetcsv($handle,1000,";");
		//remove if csv file does not have column heading
		while(($data=fgetcsv($handle,1000,";"))!==FALSE){
            print_($data);
			$nom=$data[0];
			$prenoms=$data[1];
			$date_naissance=$data[2];
			$lieu_naissance=$data[3];
			$nationalite=$data[4];
			$annee_auto=$data[5];
			$observ_auto=$data[6];
			$num_bac=$data[7];		
			$session_bac=$data[8];
			$matricule=$data[9];
			$filiere=$data[10];	
			$mode=$data[11];	
			$ff=$data[12];	
			$fi=$data[13];	
			$type_auto=$data[14];	
			$memo1=$data[15];	
			$memo2=$data[16];	
			$valide=$data[17];
			$annee_inscrit=$data[18];	
            
			$num_auto=num_autorisation($anneeEtude,$type_auto,$pdo);
			$champ=array('code_auto','nom','prenoms','date_naissance','lieu_naissance','Nationalite','annee_auto','annee_inscrit','observ_auto','num_bac','session_bac','matricule','filiere','mode','FF','FI','type_auto','memo1','memo2','valide');
	$valeur=array($num_auto,$nom,$prenoms,convertdatefrancais($date_naissance),$lieu_naissance,$nationalite,$annee_auto,$annee_inscrit,$observ_auto,$num_bac,$session_bac,$matricule,$filiere,$mode,$ff,$fi,$type_auto,$memo1,$memo2,$valide);
			insTable("autorisation",$champ,$valeur,$pdo);
		}
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?auto&ajoutOK');
		// -->
		</script>";
}

///action pour l'ajout d'une UFR
if(isset($_POST['nom'])){
  
	//controle de l'existance
	$date_nais=$_POST['date_naissance'];
  $num_auto=num_autorisation($anneeEtude,$_POST['type_auto'],$pdo);
	$champ=array('code_auto','nom','prenoms','date_naissance','lieu_naissance','Nationalite','annee_auto','annee_inscrit','observ_auto','num_bac','session_bac','matricule','filiere','mode','FF','FI','type_auto','memo1','memo2','valide');
	$valeur=array($num_auto,utf8_decode($_POST['nom']),utf8_decode($_POST['prenoms']),$date_nais,utf8_decode($_POST['lieu_naissance']),$_POST['nationalite'],$anneeEtude,$_POST['annee_inscrit'],$_POST['observ_auto'],$_POST['num_table'],$_POST['session_bac'],$_POST['matricule'],$_POST['filiere'],$_POST['mode'],$_POST['FF'],$_POST['FI'],$_POST['type_auto'],$_POST['memo1'],$_POST['memo2'],"NON");
	insTable("autorisation",$champ,$valeur,$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?auto&ajoutOK');
		// -->
		</script>";
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('nom','prenoms','date_naissance','lieu_naissance','Nationalite','annee_auto','annee_inscrit','observ_auto','num_bac','session_bac','matricule','filiere','mode','FF','FI','type_auto','memo1','memo2','valide');
	$valeur=array(utf8_decode($_POST['nom2']),utf8_decode($_POST['prenoms2']),$_POST['date_naissance2'],$_POST['lieu_naissance2'],$_POST['nationalite2'],$anneeEtude,$_POST['annee_inscrit2'],$_POST['observation2'],$_POST['num_table2'],$_POST['session2'],$_POST['matricule2'],$_POST['filiere2'],$_POST['mode2'],$_POST['FF2'],$_POST['FI2'],$_POST['type_auto2'],$_POST['memo3'],$_POST['memo4'],"NON");
	updTable("autorisation",$champ,$valeur,"id",$_POST['modif'],$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?auto&modifOK');
		// -->
		</script>";
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

function suppression(val){
	 $.messager.confirm('Confirm','Voulez vous supprimer cette autorisation : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_auto.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?auto&supOK";
				}
			});  
		}  
	});  	
}

function valide(id,val){	  
	$.post('../js/xphp/sup/valide_auto.php',{code:id,valeur:val},function(data){  
		if(data==1){
			alert('opération effectuée');
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
<div id="haut" style="height:75px"><center>GESTION DES AUTORISATIONS</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Autorisation Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','Autorisation modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Cette autorisation existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Cette autorisation a été bien supprimée!','info');
    </script>
    
<?php } 
if(isset($_GET['ajoutlot'])){
?>
<br /><br /><br />
<div align="center" id='retour' style="display:none"> <a href="autorisation.php" class="easyui-linkbutton">RETOUR</a></div>
<div align="center" id="p" class="easyui-panel" title="Ajout à partir d'un fichier excel" style="width:350px;height:200px;padding:10px;" data-options="iconCls:'icon-save',maximizable:true">
<form enctype="multipart/form-data" action="" method="post">
<p><input name="file" type="file"/></p>
<p><input name="lot" id="lot" /></p>
<p><input type="submit" value="Importer le fichier"/> </p>
</form>
</div>
<?php	
}

if(!isset($_GET['modif']) && !isset($_GET['ajout']) && !isset($_GET['ajoutlot']) && !isset($_GET['pdf'])){ ?>

<div id="toolbar" align="right">  
	<a href="?auto&ajoutlot" class="easyui-linkbutton" iconCls="icon-add" plain="true">Importer un fichier csv</a>  
   	<a href="?auto&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<form name="auto_form" id="auto_form" action="" method="post">
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_dept" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td></td>
    <td></td>
    <td>Annee auto</td>
    <td>Type auto</td>
    <td>Code auto</td>
    <td>Matricule</td>
    <td>Numéro du bac</td>
    <td>Session du bac</td>
    <td>Nom</td>
    <td>Prenoms</td>
    <td>Date de naissance</td>
    <td>Lieu de naissance</td>
    <td>Nationalite</td>
    <td>Filiere</td>
    <td>Mode</td>
    <td>Annee inscrit</td>
    <td>FF</td>
    <td>FI</td>
    <td>Memo1</td>
    <td>Memo2</td>
    <td>Observation</td>
    <td>  </td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableDataDesc("autorisation","id",$pdo);
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
  <td><?php if($liste[$i]['valide']=='NON' || $liste[$i]['valide']==''){ ?><img onclick="valide(<?php echo $liste[$i]['id']; ?>,'OUI')" src="../img/valide.png" width="24" height="24" /><?php }else{ ?><img onclick="valide(<?php echo $liste[$i]['id']; ?>,'NON')" src="../img/cancel.png" width="24" height="24" /> <?php } ?></td>
    <td><?php if($liste[$i]['type_auto']!=1){ ?><a href="autorisation_pdf.php?id=<?php echo $liste[$i]['id']; ?>" style="border:0"><img src="../img/auto.jpg" width="50" height="36" /></a><?php } ?></td>
    <td><?php echo $liste[$i]['annee_auto']; ?></td>
    <td><?php
	$type=selTableDataWhere("type","id",$liste[$i]['type_auto'],$pdo);
	 echo $type['name']; ?></td>
    <td><?php echo $liste[$i]['code_auto']; ?></td>
    <td><?php echo $liste[$i]['matricule']; ?></td>
    <td><?php echo $liste[$i]['num_bac']; ?></td>
    <td><?php echo $liste[$i]['session_bac']; ?></td>
    <td><?php echo utf8_encode($liste[$i]['nom']); ?></td>
    <td><?php echo utf8_encode($liste[$i]['prenoms']); ?></td>
    <td><?php echo $liste[$i]['date_naissance']; ?></td>
    <td><?php echo utf8_encode($liste[$i]['lieu_naissance']); ?></td>
    <td><?php echo $liste[$i]['Nationalite']; ?></td>
    <td><?php echo $liste[$i]['filiere']; ?></td>
    <td><?php echo $liste[$i]['mode']; ?></td>
    <td><?php echo $liste[$i]['annee_inscrit']; ?></td>
    <td><?php echo $liste[$i]['FF']; ?></td>
    <td><?php echo $liste[$i]['FI']; ?></td>
    <td><?php echo $liste[$i]['memo1']; ?></td>
    <td><?php echo $liste[$i]['memo2']; ?></td>
    <td><?php echo $liste[$i]['observ_auto']; ?></td>
    <td>  
<a href="?auto&modif=<?php echo $liste[$i]['id']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
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
<div align="center" id='retour' style="display:none"> <a href="?dept" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouvelle autorisation" style="width:1050px; height:650px; padding:10px;" data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="16%" height="27" bgcolor="#CEFBD3"><strong>Nom :</strong></td>
            <td width="30%" bgcolor="#CEFBD3"><input name="nom" class="easyui-validatebox" id="nom" size="30" required="true" ></td>
            <td colspan="2" align="center" bgcolor="#FDDFD5"><strong>Bachelier ou ancien étudiant</strong></td>
          </tr>
          <tr>
            <td height="26" bgcolor="#CEFBD3"><strong>Prénoms :</strong></td>
            <td bgcolor="#CEFBD3"><input name="prenoms" class="easyui-validatebox" id="prenoms" size="40" required="true"></td>
            <td width="13%" bgcolor="#FDDFD5"><strong>Numero de table :</strong></td>
            <td width="38%" bgcolor="#FDDFD5"><label for="num_table"></label>
            <input type="text" name="num_table" id="num_table" /></td>
          </tr>
           <tr>
            <td height="28" bgcolor="#CEFBD3"><strong>Date de naissance :</strong></td>
            <td bgcolor="#CEFBD3"><input name="date_naissance" id="date_naissance" class="easyui-validatebox" required="true" ></td>
            <td bgcolor="#FDDFD5"><strong>Session :</strong></td>
            <td bgcolor="#FDDFD5"><label for="session"></label>
             <input type="text" name="session" id="session" /></td>
          </tr>
          <tr>
            <td bgcolor="#CEFBD3"><strong>Lieu de naissance :</strong></td>
            <td bgcolor="#CEFBD3"><input name="lieu_naissance" class="easyui-validatebox" id="lieu_naissance" size="30" required="true"></td>
            <td rowspan="2" bgcolor="#FDDFD5"><strong>Matricule :</strong></td>
            <td rowspan="2" bgcolor="#FDDFD5"><label for="matricule"></label>
            <input type="text" name="matricule" id="matricule" /></td>
          </tr>
          <tr>
            <td bgcolor="#CEFBD3"><strong>Nationalite :</strong></td>
            <td bgcolor="#CEFBD3"><label for="nationalite"></label>
            <select name="nationalite" id="nationalite" class="easyui-combobox">
                <option value=""></option>
                <?php
                    $pays = selTableData('pays','lib_pays',$pdo);
                    foreach ($pays as $py) {
                    	echo "<option value='".$py['cod_pays']."'>".strtolower($py['lib_nation'])."</option>";
                    }
                ?>
            </select>
                   </td>
          </tr>
           <tr>
            <td colspan="4" align="center" valign="middle" bgcolor="#FFFFCC"><strong>Autorisation</strong></td>
          </tr>
          <tr>
            <td height="32" bgcolor="#FFFFCC"><strong>Type d'autorisation :</strong></td>
            <td bgcolor="#FFFFCC"><select required="true" name="type_auto" id="type_auto">
              <?php
			$ufr=selTableData("type","name",$pdo);
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['id']."'>".strtoupper($ufr[$i]['name'])."</option>";
				}	
			?>
            </select></td>
            <td bgcolor="#FFFFCC"><p><strong>observation :</strong></p></td>
            <td bgcolor="#FFFFCC"><label for="observation"></label>
            <textarea name="observation" id="observation" cols="45" rows="5"></textarea></td>
          </tr>
           <tr>
            <td height="90" bgcolor="#FFFFCC"><strong>Texte 1 :</strong></td>
            <td bgcolor="#FFFFCC"><label for="memo1"></label>
             <textarea name="memo1" id="memo1" cols="45" rows="5"></textarea></td>
            <td bgcolor="#FFFFCC"><strong>Filiere :</strong></td>
            <td bgcolor="#FFFFCC"><select required="true" name="filiere" id="filiere">
            <?php
			$ufr=selTableData("filiere","code",$pdo);
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['code']."'>".strtoupper($ufr[$i]['code'])."</option>";
				}	
			?>
            </select></td>
          </tr>
          <tr>
            <td rowspan="2" bgcolor="#FFFFCC"><strong>Texte 2 :</strong></td>
            <td rowspan="2" bgcolor="#FFFFCC"><label for="memo2"></label>
            <textarea name="memo2" id="memo2" cols="45" rows="5"></textarea></td>
            <td bgcolor="#FFFFCC"><strong>Statut :</strong></td>
            <td bgcolor="#FFFFCC"><select name="mode" id="mode">
              <?php
			$ufr=selTableMultiAnswer("mode","actif","1",$pdo);
			for($i=0;$i<count($ufr);$i++){
				echo "<option value='".$ufr[$i]['code']."'>".strtolower($ufr[$i]['Intitule'])."</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC"><strong>Annee d'inscription :</strong></td>
            <td bgcolor="#FFFFCC"><input type="text" name="annee_inscrit" id="annee_inscrit" value="<?php echo $anneeEtude; ?>"/></td>
          </tr>
          <tr>
            <td colspan="2" rowspan="2" align="center" valign="middle" bgcolor="#FFCCCC"><strong>MONTANT :</strong></td>
            <td height="28" bgcolor="#FFCCCC"><strong>FF : </strong></td>
            <td bgcolor="#FFCCCC"><label for="FF"></label>
              <input type="text" name="FF" id="FF" /></td>
          </tr>
          <tr>
            <td height="29" bgcolor="#FFCCCC"><strong>FI :</strong></td>
            <td bgcolor="#FFCCCC"><label for="FI"></label>
            <input type="text" name="FI" id="FI" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4">
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
$modifcation=selTableDataWhere("autorisation","id",$_GET['modif'],$pdo);
?>
<div align="center" id='retour' style="display:none"> <a href="ufr.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Ajout d'un nouveau département" style="width:1050px;height:650px;padding:10px;" data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="17%" height="27" bgcolor="#CEFBD3"><strong>Nom :</strong></td>
            <td width="31%" bgcolor="#CEFBD3"><input name="nom2" class="easyui-validatebox" id="nom2" size="30" required="true" value="<?php echo $modifcation['nom']; ?>" /></td>
            <td colspan="2" align="center" bgcolor="#FDDFD5"><strong>Bachelier ou ancien étudiant</strong></td>
          </tr>
          <tr>
            <td height="26" bgcolor="#CEFBD3"><strong>Prénoms :</strong></td>
            <td bgcolor="#CEFBD3"><input name="prenoms2" class="easyui-validatebox" id="prenoms2" size="40" required="true" value="<?php echo $modifcation['prenoms']; ?>" /></td>
            <td width="15%" bgcolor="#FDDFD5"><strong>Numero de table :</strong></td>
            <td width="37%" bgcolor="#FDDFD5"><label for="num_table2"></label>
              <input type="text" name="num_table2" id="num_table2" value="<?php echo $modifcation['num_bac']; ?>"/></td>
          </tr>
          <tr>
            <td height="28" bgcolor="#CEFBD3"><strong>Date de naissance :</strong></td>
            <td bgcolor="#CEFBD3"><input name="date_naissance2" id="date_naissance2" value="<?php echo $modifcation['date_naissance']; ?>" class="easyui-validatebox" required="true" /></td>
            <td bgcolor="#FDDFD5"><strong>Session :</strong></td>
            <td bgcolor="#FDDFD5"><label for="session"></label>
              <input type="text" name="session2" id="session2" value="<?php echo $modifcation['session_bac']; ?>" /></td>
          </tr>
          <tr>
            <td bgcolor="#CEFBD3"><strong>Lieu de naissance :</strong></td>
            <td bgcolor="#CEFBD3"><input value="<?php echo $modifcation['lieu_naissance']; ?>" name="lieu_naissance2" class="easyui-validatebox" id="lieu_naissance2" size="30" required="true" /></td>
            <td rowspan="2" bgcolor="#FDDFD5"><strong>Matricule :</strong></td>
            <td rowspan="2" bgcolor="#FDDFD5"><label for="matricule"></label>
              <input type="text" name="matricule2" id="matricule2" value="<?php echo $modifcation['matricule']; ?>" /></td>
          </tr>
          <tr>
            <td bgcolor="#CEFBD3"><strong>Nationalite :</strong></td>
            <td bgcolor="#CEFBD3">
            <select name="nationalite2" id="nationalite2" class="easyui-combobox">
                <option value=""></option>
                <?php
                    $pays = selTableData('pays','lib_pays',$pdo);
                    $a=0;
                    foreach ($pays as $py) {
                        if($py['cod_pays']==$modifcation['Nationalite']){ 
                            $spy="selected"; 								
                        }else{
                            $spy="";
                        }
                    echo "<option value='".$py['cod_pays']."' ".$spy.">".strtolower($py['lib_nation'])."</option>";
                    }
                ?>
           	</select>
            </td>
          </tr>
          <tr>
            <td colspan="4" align="center" valign="middle" bgcolor="#FFFFCC"><strong>Autorisation</strong></td>
          </tr>
          <tr>
            <td height="32" bgcolor="#FFFFCC"><strong>Type d'autorisation :</strong></td>
            <td bgcolor="#FFFFCC"><select required="true" name="type_auto2" id="type_auto2">
              <?php
			$ufr=selTableData("type","name",$pdo);
				for($i=0;$i<count($ufr);$i++){
					$select="";
					if($modifcation['type_auto']==$ufr[$i]['id']){$select="selected=\"selected\"";}
					echo "<option value='".$ufr[$i]['id']."' ".$select.">".strtoupper($ufr[$i]['name'])."</option>";
				}	
			?>
            </select></td>
            <td bgcolor="#FFFFCC"><p><strong>observation :</strong></p></td>
            <td bgcolor="#FFFFCC"><label for="observation"></label>
              <textarea name="observation2" id="observation2" cols="45" rows="5"><?php echo $modifcation['observ_auto']; ?></textarea></td>
          </tr>
          <tr>
            <td height="90" bgcolor="#FFFFCC"><strong>Texte 1 :</strong></td>
            <td bgcolor="#FFFFCC"><label for="memo1"></label>
              <textarea name="memo3" id="memo3" cols="45" rows="5"><?php echo $modifcation['memo1']; ?></textarea></td>
            <td bgcolor="#FFFFCC"><strong>Filiere :</strong></td>
            <td bgcolor="#FFFFCC"><select required="true" name="filiere2" id="filiere2">
              <?php
			$ufr=selTableData("filiere","code",$pdo);
				for($i=0;$i<count($ufr);$i++){
					$select="";
					if($modifcation['filiere']==$ufr[$i]['code']){$select="selected=\"selected\"";}
					echo "<option value='".$ufr[$i]['code']."' ".$select.">".strtoupper($ufr[$i]['code'])."</option>";
				}	
			?>
            </select></td>
          </tr>
          <tr>
            <td rowspan="2" bgcolor="#FFFFCC"><strong>Texte 2 :</strong></td>
            <td rowspan="2" bgcolor="#FFFFCC"><label for="memo2"></label>
              <textarea name="memo4" id="memo4" cols="45" rows="5"><?php echo $modifcation['memo2']; ?></textarea></td>
            <td bgcolor="#FFFFCC"><strong>Statut :</strong></td>
            <td bgcolor="#FFFFCC"><select name="mode2" id="mode2">
              <?php
			$ufr=selTableMultiAnswer("mode","actif","1",$pdo);
			for($i=0;$i<count($ufr);$i++){
				$select="";
				if($modifcation['mode']==$ufr[$i]['code']){$select="selected=\"selected\"";}
				echo "<option value='".$ufr[$i]['code']."' ".$select.">".strtolower($ufr[$i]['Intitule'])."</option>";
			}
			?>
            </select></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFCC"><strong>Annee d'inscription :</strong></td>
            <td bgcolor="#FFFFCC"><input name="annee_inscrit2" type="text" id="annee_inscrit2" value="<?php echo $modifcation['annee_inscrit']; ?>" /></td>
          </tr>
          <tr>
            <td colspan="2" rowspan="2" align="center" valign="middle" bgcolor="#FFCCCC"><strong>MONTANT :</strong></td>
            <td height="28" bgcolor="#FFCCCC"><strong>FF : </strong></td>
            <td bgcolor="#FFCCCC"><label for="FF"></label>
              <input value="<?php echo $modifcation['FF']; ?>" type="text" name="FF2" id="FF2" /></td>
          </tr>
          <tr>
            <td height="29" bgcolor="#FFCCCC"><strong>FI :</strong></td>
            <td bgcolor="#FFCCCC"><label for="FI"></label>
              <input type="text" name="FI2" id="FI2" value="<?php echo $modifcation['FI']; ?>" /><input name="modif" id="modif" value="<?php echo $_GET['modif']; ?>" type="hidden" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4"><div id="dlg-buttons" align="center" style="padding:15px">
				<input name="ajouter" type="submit" value="Modifier" iconCls="icon-ok" />
   			</div></td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
?>