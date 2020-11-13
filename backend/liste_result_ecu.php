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

///action pour l'ajout d'une UFR
if(isset($_POST['matricule'])){
	//controle de l'existance
	$champ=array('matricule','filiere','annee_academique','result_semestre_1','result_semestre_2','moyenne','observation');
	$valeur=array($_POST['matricule'],$_POST['filiere'],$_POST['annee_academique'],$_POST['result_semestre_1'],$_POST['result_semestre_2'],$_POST['moyenne'],$_POST['observation']);
	insTable("verdict",$champ,$valeur,$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?verdict&ajoutOK');
		// -->
		</script>";
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('matricule','filiere','annee_academique','result_semestre_1','result_semestre_2','moyenne','observation');
	$valeur=array($_POST['matricule2'],$_POST['filiere2'],$_POST['annee_academique2'],$_POST['result_semestre_3'],$_POST['result_semestre_4'],$_POST['moyenne2'],$_POST['observation2']);
	updTable("verdict",$champ,$valeur,"id",$_POST['modif'],$pdo);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?verdict&modifOK');
		// -->
		</script>";
}
?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<style>
.verticaltext {
    color:#333;
    writing-mode:tb-rl;
    -webkit-transform:rotate(270deg);
    -moz-transform:rotate(270deg);
    white-space:nowrap;
    display:block;
    bottom:-60px;
	padding-top:90px;
    width:40px;
    height:100px;
    font-family:Verdana, Geneva, sans-serif;
    font-size:12px;
    font-weight:bold;
	margin-top:250px;
	margin-left: auto;
	margin-right: auto;
	position:relative;
	
}
</style>
<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#list_ecoles').dataTable({	
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
	 $.messager.confirm('Confirm','Voulez vous supprimer ce verdict : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_verdict.php',{code:val},function(data){  
				if(data==1){
					document.location.href="?verdict&supOK";
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

	
	th.rotate {
		/* Something you can count on */
		height: 140px;
		white-space: nowrap;
	}

	th.rotate > div {
		transform: 
		/* Magic Numbers */
		translate(25px, 51px)
		/* 45 is really 360 - 45 */
		rotate(315deg);
		width: 30px;
	}
	th.rotate > div > span {
		text-align:center;
     	white-space:nowrap;
		border-bottom: 1px solid #ccc;
		padding: 5px 10px;
	}

	table.timecard {
		margin: auto;
		width: 600px;
		border-collapse: collapse;
		border: 1px solid #fff; /*for older IE*/
		border-style: hidden;
	}

	table.timecard thead th {
		padding: 8px;
		background-color: #fde9d9;
		font-size: large;
	}

	table.timecard td {
		padding: 3px;
		border-width: 1px;
		border-style: solid;
		border-color: #f79646 #ccc;
	}

	table.timecard td {
		text-align: right;
	}

	table.timecard tbody {
		text-align: left;
		font-weight: normal;
	}

	table.timecard tr.even {
		background-color: #fde9d9;
	}

</style>
<div id="haut" style="height:75px"><center>GESTION DES RESULTATS DES ECUS</center></div>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','Verdict Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php		
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','verdict modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Ce verdict existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Ce verdict a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout']) && !isset($_GET['ajoutlot'])){ ?>
	<form id="form1" name="form1" method="post" action="">
	  <table width="80%" border="0" align="center" cellspacing="2">
	    <tr>
	      <td width="17%" align="left" bgcolor="#D6D6D6">Filiere :</td>
	      <td width="23%" align="left" bgcolor="#D6D6D6"><label for="filiere"></label>
	        <select name="filiere" id="filiere">
            <?php
			$fil=selTableDataDesc("filiere","code",$pdo);
				for($i=0;$i<count($fil);$i++){
					$select="";
					if(isset($_POST['filiere']) && $_POST['filiere']==$fil[$i]['code']){ $select="selected"; }
					echo "<option ".$select." value='".$fil[$i]['code']."'>".strtoupper($fil[$i]['code'])."</option>";
				}	
			?>
          </select></td>
	      <td width="24%" align="left" bgcolor="#D6D6D6">Année Académique :</td>
	      <td width="36%" align="left"><select required="true" name="annee" id="annee">
      <?php
			$ufr=selTableDataDesc("annee_academique","lib_annee",$pdo);
				for($i=0;$i<count($ufr);$i++){
					$select="";
					if(isset($_POST['annee']) && $_POST['annee']==$ufr[$i]['lib_annee']){ $select="selected"; }
					echo "<option ".$select." value='".$ufr[$i]['lib_annee']."'>".strtoupper($ufr[$i]['lib_annee'])."</option>";
				}	
			?>
    </select>
          <input type="submit" name="button" id="button" value="Rechercher" /></td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
        </tr>
      </table>
</form>
<?php } ?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout']) && !isset($_GET['ajoutlot']) && isset($_POST['filiere'])){ ?>

<div id="toolbar" align="right">  
    <a href="?liste_result_ecu&ajoutlot" class="easyui-linkbutton" iconCls="icon-add" plain="true">Importer un fichier csv</a>     <a href="?verdict&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<?php
 $etudiant=selTableData2Fields("inscription","filiere",$_POST['filiere'],"annee_academique",$_POST['annee'],$pdo);
 //print_r($etudiant);
 //exit;
 if(count($etudiant)>0){
	$promotion=seltableDataWhere('student','matricule',$etudiant[3]['matricule'],$pdo);
	$promotion=$promotion['promotion'];
 ?>
<br />
<table width='90%' align='center' class='timecard'>
<?php 
	$ecu=requete("SELECT table_ecu_new.code_ecu,table_ecu_new.designation FROM table_ecu_new, table_ue_new WHERE table_ue_new.code_ue=table_ecu_new.code_ue AND code_ecole='".$_POST['filiere']."' AND table_ue_new.promotion='".$promotion."' order by table_ecu_new.code_ecu ASC",$pdo);
	//print_r($ecu); 
?>
	<tr><th> </th>
	<?php  
		for($e=0;$e<count($ecu);$e++){
			echo "<th class='rotate'><div><span>".$ecu[$e]['code_ecu']."</span></div></th>";
		}
	?> </tr>
	<tbody>
	<?php 
		 $color='#EEF7EE';
		$a=0;
		for($i=0;$i<count($etudiant);$i++){
			echo "<tr><td background-color='".$color."'>".$etudiant[$i]['matricule']."</td>";
			//$note=requete("SELECT * FROM `result_ecu` WHERE matricule='".$etudiant[$i]['matricule']."' AND annee_acad='".$_POST['annee']."' ORDER BY `code_ecu` ASC",$pdo);
			
			for($e=0;$e<count($ecu);$e++){
				$note=requete("SELECT * FROM `result_ecu` WHERE matricule='".$etudiant[$i]['matricule']."' AND annee_acad='".$_POST['annee']."' AND code_ecu='".$ecu[$e]['code_ecu']."'",$pdo);
				if(isset($note[0]['moyenne'])){
					echo "<td>".$note[0]['moyenne']."</td>";
				}else{
					echo "<td> - </td>";

				}
			}

			/* for($n=0;$n<count($note);$n++){
				echo "<td>".$note[$n]['moyenne']."</td>";
			} */
			echo '<tr>';
			
			if($a==0){
				$color='';
				$a++;
			}else{
				$color='#EEF7EE';
				$a--;
			}
		}  
		//echo "-- En maintenance --"
	?>
	</tbody>
</table>
<?php
 }else{
	 echo "PAS D'ETUDIANT INSCRIT DANS CETTE FILIERE";
 }
?>
<br />
<br />
<br />
<br />
<br />

<?php  
}
if(isset($_GET['ajoutlot'])){
?>
<br /><br /><br />
<table><tr><td>
<div align="center" id='retour' style="display:none"> <a href="liste_result_ecu.php" class="easyui-linkbutton">RETOUR</a></div>
<div align="center" id="p" class="easyui-panel" title="Ajout à partir d'un fichier excel CSV pour les ajouts" style="width:350px;height:200px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
<form enctype="multipart/form-data" action="" method="post">
<p><input name="file" type="file"/></p>
<p><input name="lot" id="lot" /></p>
<p><input type="submit" value="Importer le fichier"/> </p>
</form>
</div>
<br/>
</td><td>
         
</td><td>
<div align="center" id="p2" class="easyui-panel" title="Ajout à partir d'un fichier excel CSV pour les mises a jour" style="width:350px;height:200px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
<form enctype="multipart/form-data" action="" method="post">
<p><input name="file2" type="file"/></p>
<p><input name="lot2" id="lot2" /></p>
<p><input type="submit" value="Importer le fichier pour la mise a jour"/> </p>
</form>
</div><br/>
<!-- <div align="center" id="p3" class="easyui-panel" title="Mises à jour des redoublants" style="width:350px;height:200px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
<form enctype="multipart/form-data" action="" method="post">
<p><input name="file3" type="file"/></p>
<p><input name="lot3" id="lot3" /></p>
<p><input type="submit" value="Importer le fichier pour les redoublants"/> </p>
</form>
</div> -->
</td></tr></table>
<?php	
}
if(isset($_POST['lot'])){
		//process the csv file
		$handle=fopen($_FILES['file']['tmp_name'],'r');
		$data=fgetcsv($handle,1000,";");
		//remove if csv file does not have column heading
		$matricule1="";
		while(($data=fgetcsv($handle,1000,";"))!==FALSE){
			$matricule=$data[0];
			$code_ecu=$data[1];
			$annee_academique=$data[2];		
			$moyenne1=$data[4];		
			$moyenne1=explode(",",$moyenne1);
			$moyenne=$moyenne1[0].".".$moyenne1[1];
			if($matricule!=$matricule1){
				$filiere=$data[3];
				$moyenne_gene=$data[5];
				$verdict=$data[6];
				$champ2=array('matricule','filiere','annee_academique','result_semestre_1','result_semestre_2','moyenne','observation');
	    		$valeur2=array($matricule,$filiere,$annee_academique,$verdict,$verdict,$moyenne_gene,'');
				insTable("verdict",$champ2,$valeur2,$pdo);
				$matricule1=$matricule;
			}
			$champ=array('matricule','code_ecu','annee_acad','moyenne');
	    	$valeur=array($matricule,$code_ecu,$annee_academique,$moyenne);
			insTable("result_ecu",$champ,$valeur,$pdo);
		}
		header("Location:?liste_result_ecu");
}
//COde pour la mise à jour des ecus repris et des redoublants
if(isset($_POST['lot2'])){
		//process the csv file
		$handle=fopen($_FILES['file2']['tmp_name'],'r');
		$data=fgetcsv($handle,1000,";");
		//remove if csv file does not have column heading
		$matricule1="";
		while(($data=fgetcsv($handle,1000,";"))!==FALSE){
			$matricule=$data[0];
			$code_ecu=$data[1];
			$annee_academique=$data[2];		
			$moyenne1=$data[3];		
			$moyenne1=explode(",",$moyenne1);
			$moyenne=$moyenne1[0].".".$moyenne1[1];
			$champ=array("moyenne");
			$valeur=array($moyenne);
			$ArWherField=array("matricule","code_ecu","annee_acad");
			$ArWherVal=array($matricule,$code_ecu,$annee_academique);
			updTableWhereArray("result_ecu",$champ,$valeur,$ArWherField,$ArWherVal,$pdo);
		}
		header("Location:?liste_result_ecu");
}

//zone des redoublants
/*if(isset($_POST['lot3'])){
		//process the csv file
	$handle=fopen($_FILES['file3']['tmp_name'],'r');
	$data=fgetcsv($handle,1000,";");
	//remove if csv file does not have column heading
	$matricule1="";
	while(($data=fgetcsv($handle,1000,";"))!==FALSE){
		$matricule=$data[0];
		$code_ecu=$data[1];
		$annee_academique=$data[2];		
		$moyenne1=$data[3];		
		$moyenne1=explode(",",$moyenne1);
		$moyenne=$moyenne1[0].".".$moyenne1[1];
		 if($matricule!=$matricule1){
			$filiere=mysql_real_escape_string($data[3]);
			$moyenne_gene=mysql_real_escape_string($data[5]);
			$verdict=mysql_real_escape_string($data[6]);
			$sql="INSERT INTO verdict (matricule,filiere,annee_academique,result_semestre_1,result_semestre_2,moyenne,observation) VALUES ('".$matricule."','".$filiere."','".$an_precedent."','".$verdict."','".$verdict."','".$moyenne_gene."','')";
			mysql_query($sql) or die(mysql_error());
			$matricule1=$matricule;
		} 
		//$sql="INSERT INTO result_ecu (matricule,code_ecu,annee_acad,moyenne) VALUES ('".$matricule."','".$code_ecu."','".$annee_academique."','".$moyenne."')";
		$champ=array('matricule','code_ecu','annee_acad','moyenne');
		$valeur=array($matricule,$code_ecu,$annee_academique,$moyenne);
		insTable("result_ecu",$champ,$valeur,$pdo);	}
	
	header("Location:?liste_result_ecu");
}*/
?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout']) && !isset($_GET['ajoutlot'])){ ?>

<?php
}
?>
<!-- formulaire de modification -->
<?php 
if(isset($_GET['modif']) && $_GET['modif']!="" && !isset($_GET['ajout']) && !isset($_GET['ajoutlot'])){ 
	$modification=selTableDataWhere("verdict","id",$_GET['modif'],$pdo);
?>

<?php
}
?>