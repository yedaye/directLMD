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
if(isset($_POST['nom'])){
	//controle de l'existance
	$controle=selTableDataCount("utilisateur","nom",$_POST['nom']);
	if($controle==0){
		//print_r($_POST);
		$maliste=implode(";",$_POST['ecole']);
		$champ=array('nom','prenoms','username','mot_de_passe','droit','etab');
		$valeur=array($_POST['nom'],$_POST['prenoms'],$_POST['login'],MD5($_POST['mp']),$_POST['droit'],$maliste);
		insTable("utilisateur",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?user&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?user&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$maliste=implode(";",$_POST['ecole2']);
	$champ=array('nom','prenoms','username','mot_de_passe','droit','etab');
	$valeur=array($_POST['nom2'],$_POST['prenoms2'],$_POST['login2'],MD5($_POST['mp2']),$_POST['droit2'],$maliste);	
	updTable("utilisateur",$champ,$valeur,"id",$_POST['modif']);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?user&modifOK');
		// -->
		</script>";
}

?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#list_user').dataTable({	
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
	 $.messager.confirm('Confirm','Voulez vous supprimer ce type : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_user.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?user&supOK";
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
<div id="haut" style="height:75px"><center>GESTION DES UTILISATEURS</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Utilisateur Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','Utilisateur modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Cet utilisateur existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Ce type a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
     <a href="?user&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="list_user" class="display">
<thead style="background-image:url(../img/back_tableau.jpg); background-repeat:repeat">
 <tr>
    <td>Nom</td>
    <td>Prenoms </td>
    <td>Login </td>
    <td>Rôle</td>
    <td>Etablissement</td>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
$liste=selTableData("utilisateur","nom");
for($i=0; $i<count($liste);$i++){
?>
  <tr valign="top">
    <td><?php echo $liste[$i]['nom']; ?></td>
    <td><?php echo $liste[$i]['prenoms']; ?></td>
    <td><?php echo $liste[$i]['username']; ?></td>
    <td><?php 
	if($liste[$i]['droit']==0){
		echo "Agent inscripteur";
	}
	if($liste[$i]['droit']==1){
		echo "Scolarite";
	}
	if($liste[$i]['droit']==2){
		echo "Administrateur";
	}
	 ?></td>
     <td><?php echo $liste[$i]['etab']; ?></td>
    <td>  
  <a href="?user&modif=<?php echo $liste[$i]['id']; ?>" class="easyui-linkbutton" iconCls="icon-edit" plain="true">Modifier  </a>
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
<div align="center" id='retour' style="display:none"> <a href="?zone" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'un nouveau type" style="width:700px;height:450px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Nom :</td>
            <td><input name="nom" id="nom" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Prenoms 
            
            :</td>
            <td><label>
              <input type="text" name="prenoms" id="prenoms" />
            </label></td>
          </tr>
          <tr>
            <td>Login :</td>
            <td><label>
              <input type="text" name="login" id="login" />
            </label></td>
          </tr>
          <tr>
            <td>Mot de passe :</td>
            <td><label>
              <input type="text" name="mp" id="mp" />
            </label></td>
          </tr>
          <tr>
            <td>Droit :</td>
            <td>
                <label>
                  <select name="droit" id="droit">
                    <option value="0">Agent inscripteur</option>
                    <option value="1">Scolarite</option>
                    <option value="2">Administrateur</option>
                  </select>
                </label>
            </td>
            </tr>
            <tr>
            <td>
            Etablissement Autorisé :
            </td>
            <td>
            <select name="ecole[]" size="8" multiple="multiple" id="ecole[]" required="true">
            <option value='aucun'>Aucun</option>
            <option value='uak'>UAK</option>
            <?php
			$ufr=selTableMultiAnswer("ecole_ufr","actif","1");
			for($i=0;$i<count($ufr);$i++){
				echo "<option value='".$ufr[$i]['code_ecole']."'>".strtolower($ufr[$i]['lib_ecole'])." (".$ufr[$i]['code_ecole'].")</option>";
			}
			?>
            </select>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center"><br />
				<span style="padding:15px">
              		<input name="ajouter2" type="submit" value="ajouter" />
            	</span></td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
?>
<!-- formulaire de modification -->
<?php if(isset($_GET['modif']) && $_GET['modif']!="" && !isset($_GET['ajout'])){ 
$modifcation=selTableDataWhere("utilisateur","id",$_GET['modif']);
?>
<div align="center" id='retour' style="display:none"> <a href="ufr.php" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Ajout d'un nouveau type" style="width:700px;height:450px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">
      <table width="100%" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td>Nom :</td>
          <td><input name="nom2" id="nom2" class="easyui-validatebox" required="true" value="<?php echo $modifcation['nom']; ?>" /></td>
        </tr>
        <tr>
          <td>Prenoms 
            
            :</td>
          <td><label>
            <input type="text" name="prenoms2" id="prenoms2" value="<?php echo $modifcation['prenoms']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td>Login :</td>
          <td><label>
            <input type="text" name="login2" id="login2" value="<?php echo $modifcation['username']; ?>"/>
          </label></td>
        </tr>
        <tr>
          <td>Mot de passe :</td>
          <td><label>
            <input type="text" name="mp2" id="mp2" value="" />
          </label></td>
        </tr>
        <tr>
          <td>Droit :</td>
          <td><label>
            <select name="droit2" id="droit2">
              <option value="0" <?php if($modifcation['droit']==0){ echo "selected"; } ?> >Agent inscripteur</option>
              <option value="1" <?php if($modifcation['droit']==1){ echo "selected"; } ?>>Scolarite</option>
              <option value="2" <?php if($modifcation['droit']==2){ echo "selected"; } ?>>Administrateur</option>
            </select>
            <input type="hidden" name="modif" id="modif" value="<?php echo $modifcation['id']; ?>" />
          </label></td>
        </tr>
        <tr>
        <td>Etablissement : </td>
        <td>
        <?php 
		$liste=explode(";",$modifcation['etab']);
		?>
        	<select name="ecole2[]" size="8" multiple="multiple" id="ecole2[]" required="true">
            	<option value='aucun' <?php if(in_array('aucun',$liste)){ echo "selected";} ?>>Aucun</option>
            	<option value='uak' <?php if(in_array('uak',$liste)){ echo "selected";} ?>>UAK</option>
				<?php
                $ufr=selTableMultiAnswer("ecole_ufr","actif","1");
                for($i=0;$i<count($ufr);$i++){
                    echo "<option value='".$ufr[$i]['code_ecole']."' ";
					if(in_array($ufr[$i]['code_ecole'],$liste)){ echo "selected";} 
					echo ">".strtolower($ufr[$i]['lib_ecole'])." (".$ufr[$i]['code_ecole'].")</option>";
                }
                ?>
            </select>
        </td>
        </tr>
        <tr>
          <td colspan="2" align="center"><span style="padding:15px">
            <input name="ajouter" type="submit" value="Modifier" />
          </span></td>
        </tr>
      </table>
    </form> 
</div>
<?php
}
?>