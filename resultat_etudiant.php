<?php
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("connect/co.php"))
	include_once ("connect/co.php");
if (is_file("functions/queries.php"))
	include_once ("functions/queries.php");
	include_once ("param.php");
	
if(isset($_FILES['photo_new']['name'])){
	if($_FILES['photo_new']['name']!=""){
		copy($_FILES['photo_new']['tmp_name'],"backend/photo/".trim($_POST['matricule2']).".jpg");
	}
}

/* if(isset($_POST['matricule2'])){
	for($i=0;$i<count($_POST['ecu']);$i++){
//		echo "la note de ".$_POST['ecu'][$i]." est ".$_POST['valeur'][$i]."<br/>";	
		$array_field=array('matricule','code_ecu','annee_acad','moyenne');
		$array_value=array($_POST['matricule2'],$_POST['ecu'][$i],$_POST['annee_acad'],$_POST['valeur'][$i]);
		insTable("result_ecu",$array_field,$array_value);
	}
	
} */


$err_msg="";
$msg_ajout="";
$msg_modif="";
$msg_dja="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
<link rel="stylesheet" type="text/css" href="js/default/easyui.css">  
<link rel="stylesheet" type="text/css" href="js/icon.css"> 
<link rel="stylesheet" type="text/css" href="js/icon.css"> 
<title>VALIDATION DE L'INSCRIPTION</title>
<script language="javascript1.2" type="text/javascript">
	function valide(type,matricule,filiere,annee_etude){
		$('#spinner').show();
		lot="";
		if(type=='valide_final'){
			lot=document.getElementById('lot1').value;	
		}
		if(type=='valide_final' || type=='valide'){
			$.post('../js/xphp/valide_inscrit.php',{letype:type,lematricule:matricule,lafiliere:filiere,lannee:annee_etude,lelot:lot},function(data){  
				if(data==1){
					alert('opération effectuée');
					$('#spinner').hide();
					window.location=document.URL;
				}
			});  
		}
		if(type=='rejet'){
			motif=document.getElementById('motif').value;
			$.post('../js/xphp/valide_inscrit.php',{letype:type,lematricule:matricule,lafiliere:filiere,lannee:annee_etude,lemotif:motif},function(data){  
				if(data==1){
					alert('opération effectuée');
					$('#spinner').hide();
					window.location=document.URL;
				}
			});  
		}
	}
	function supprime(type,matricule,filiere,annee_etude){
		$('#spinner').show();
		$.post('../js/xphp/supr_inscrit_validation.php',{letype:type,lematricule:matricule,lafiliere:filiere,lannee:annee_etude},function(data){  
//			alert(data);
			if(data==1){
				alert('opération effectuée');
				$('#spinner').hide();
				window.location=document.URL;
			}
		});    	
	}
	function moy_ue(ue,moyenne){
		document.getElementById(ue).innerHTML=moyenne;
	}
</script>
</head>
<body>

<p class="panel-title" align="center">CONSULTATION DES RESULTATS</p><br /><br />
<form name="form2" id="form2" action="" method="POST">
<table width="81%" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td width="20%" align="right" bgcolor="#FFFF99">Matricule :</td>
    <td width="23%" bgcolor="#FFFF99"><input name="matricule" type="text" size="30" value="<?php if(isset($_POST['matricule'])){ echo $_POST['matricule']; } ?>" /></td>
    <td width="18%" align="right" bgcolor="#FFFF99">Annee Academique ::</td>
    <td width="26%" bgcolor="#FFFF99"><select required="true" name="annee" id="annee" onChange='submit()'>
      <?php
			$ufr=selTableDataDesc("annee_academique","lib_annee");
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['lib_annee']."'>".strtoupper($ufr[$i]['lib_annee'])."</option>";
				}	
			?>
    </select></td>
    <td width="13%" bgcolor="#FFFF99"><input name="controler" type="submit" value="controler" /></td>
    </tr>
</table>
</form><br />
<?php  
if(isset($_POST['matricule'])){

	////CONTROLE DE VALIDATION DE L'INSCRIPTION
	$arrayfield=array('matricule','annee_academique','controle');
	$arrayvalue=array($_POST['matricule'],$_POST['annee'],'non');
	$inscritcontrole=selTableDataWhereArray('inscription',$arrayfield,$arrayvalue);
	if(count($inscritcontrole)>0){
		$msg="<br/><br/><strong>Votre préinscription de l'année antérieur n'a pas été validée.<br/> Veuillez vous rapprocher de la scolarité centrale pour régularisation de votre inscription.</strong><br/><br/>";	
		echo "<center><span class='calendar-sunday'>".$msg."</span></center><div align='center' id='retour'> <a href='resultat_etudiant.php' class='easyui-linkbutton'>RETOUR</a></div>";
		exit;
	}
	
	$etudiant=selTableDataWhere("student","matricule",$_POST['matricule']);
	$inscription=selTableMultiAnswer("inscription","matricule",$_POST['matricule']);
	$result_ecu=selTableData2Fields("result_ecu","matricule",$_POST['matricule'],"annee_acad",$_POST['annee']);
	//if(count($result_ecu)>0){	$result_ecu=$result_ecu[0]; }
	//print_r($result_ecu);
	$inscrit_encours=selTableData2Fields("inscription","matricule",$_POST['matricule'],"annee_academique",$_POST['annee']);
		if(count($inscription)>0){
			$etab=selTableDataWhere('filiere','code',$inscription[0]['filiere']);
		}
?>
<hr />
<br />
<div align="center" id="spinner" style="display:none"><img src="../img/global_spinner.gif" /></div>
<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
  <table width="100%" border="0" cellpadding="0" cellspacing="2" class="datagrid-body" style='font-size:18px'>
    <tr>
      <td width="0" colspan="2" rowspan="2" align="center" valign="top"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="2" class="texte_grand">
       
        <tr>
          <td bgcolor="">
          	<p>Année Académique : <?php echo $_POST['annee']; ?><br />
            <br />
            Année d'études : <?php 
//			print_r($inscrit_encours);
			 if(count($inscrit_encours)>0){echo $inscrit_encours[0]['filiere'];} ?><br />
              <br />
            Nom et Prénoms : <?php echo utf8_encode($etudiant['nom']." ".$etudiant['prenoms']); ?><br />
            <br />
            Sexe : <?php echo $etudiant['sexe']; ?>
          </p></td>
          </tr>
        <tr>
          <td align="center" bgcolor="#CCCCC">AUTRES INSCRIPTIONS</td>
          </tr>
        <?php
		for($i=0;$i<count($inscription);$i++){
			if($inscription[$i]['annee_academique']!=$_POST['annee']){
				$verdict=selTableData2Fields('verdict','matricule',$inscription[$i]['matricule'],'annee_academique',$inscription[$i]['annee_academique']);
				if(count($verdict)>0){
					$verdict=$verdict[0];
					$verdict=$verdict['result_semestre_2'];
				}else{
					$verdict="";	
				}
		?>
        <tr>
          <td bgcolor="#FFCCCC"><?php echo $inscription[$i]['annee_academique']." ".$inscription[$i]['filiere']." ".$inscription[$i]['statut']." | ".$verdict; ?></td>
          </tr>
        <?php	
			}
		}
		if($i==0){
		?>
        <tr>
          <td bgcolor="#FFCCCC">PAS D'AUTRES INSCRIPTION </td>
          </tr>
        <?php	
		}
		?>
        <tr>
          <td bgcolor="#FFCCCC">&nbsp;</td>
          </tr>
      </table></td>
      <td width="76%" align="center">Relevé de notes du matricule : <?php echo $etudiant['matricule']; ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle">
      <table width="100%" border="0" cellspacing="2">
  <tr>
    <td width="59%" bgcolor="#FFCCCC">Unité d'Enseignement (UE) / Eléments Constitutifs de l'UE</td>
    <td width="10%" align="center" bgcolor="#FFCCCC">Crédit Validé</td>
    <td width="13%" align="center" bgcolor="#FFCCCC">Nombre de crédits</td>
    <td width="10%" align="center" bgcolor="#FFCCCC">Moyenne</td>
    <td width="8%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
 <?php
	$ue=array();
	if(count($inscrit_encours)>0){ 
		$ue=selTableData2FieldsAsc("table_ue_new","code_ecole",$inscrit_encours[0]['filiere'],"promotion",$etudiant['promotion'],"designation");
		$param=selTableDataWhere("param","annee_academique",$inscrit_encours[0]['annee_academique']);
	}
	//echo $inscrit_encours[0]['filiere'];
	//echo " / ".$etudiant['promotion'];
	//print_r($ue);
	
$a=0;
for($i=0;$i<count($ue);$i++){
 ?>
  <tr bgcolor="#D0DBF9">
    <td bgcolor="#D0DBF9"><b><?php echo utf8_encode($ue[$i]['designation']); ?></b></td>
    <td align="center" bgcolor="#D0DBF9"><b><div id="<?php echo "verdict_".$ue[$i]['code_ue']; ?>"></div><b></td>
    <td align="center" bgcolor="#D0DBF9"><b><?php echo $ue[$i]['credit']; ?></b></td>
    <td align="center" bgcolor="#D0DBF9"><b><div id="<?php echo $ue[$i]['code_ue']; ?>"></div><b></td>
    <td align="center" bgcolor="#FFFFFF"></td>
  </tr>
 <?php 
 	$ecu=selTableData2FieldsAsc("table_ecu_new","code_ue",$ue[$i]['code_ue'],"promotion",$etudiant['promotion'],"designation");
	//print_r($ecu);
	$total=0;
	$test_ue="oui";
	for($a=0;$a<count($ecu);$a++){
	?>
    <tr bgcolor="#FFFFCC">
    <td bgcolor="#FFFFCC"><?php echo utf8_encode($ecu[$a]['designation']); ?></td>
    <td align="center" bgcolor="#FFFFCC"><div id="<?php echo "verdict_".$ecu[$a]['code_ecu']; ?>"></div></td>
    <td align="center" bgcolor="#FFFFCC"><?php echo $ecu[$a]['credit']; ?></td>
    <td align="center" bgcolor="#FFFFCC">
    <?php 
	$lamoyenne_ecu=0;
		 for($o=0;$o<count($result_ecu);$o++){
	  		if($result_ecu[$o]['code_ecu']==$ecu[$a]['code_ecu']){ 
	  			$lamoyenne_ecu=$result_ecu[$o]['moyenne'];
				$total=$total+$result_ecu[$o]['moyenne'];
	  		}
	  	} 
		 
		 ?>
    <label>
      <?php echo $lamoyenne_ecu; ?>
    </label>
    <?php 
		if($lamoyenne_ecu<$param['moyenne_ecu_mini']){
			echo "<script>moy_ue('"."verdict_".$ecu[$a]['code_ecu']."','NON')</script>";
			if($test_ue=="oui"){
				$test_ue="non";	
			}
		}else{
			echo "<script>moy_ue('"."verdict_".$ecu[$a]['code_ecu']."','OUI')</script>";	
		}
	 ?>
    </td>
    <td align="center" bgcolor="#FFFFFF"></td>
  	</tr>
    <?php	 
	}
	//echo $total;
	
	$total=$total/$a;
		echo "<script>moy_ue('".$ue[$i]['code_ue']."','".round($total,2)."')</script>";
//		echo $param['moyenne_ue_mini'];
	
		/* if($etab['ecole']=="ESTCTPA"){
			if(round($total,2)>=12 && $test_ue=="oui"){
				echo "<script>moy_ue('"."verdict_".$ue[$i]['code_ue']."','OUI')</script>";
			}else{
				echo "<script>moy_ue('"."verdict_".$ue[$i]['code_ue']."','<b>NON</b>')</script>";	
			}
		}else{ */
			if(round($total,2)>=$param['moyenne_ue_mini'] && $test_ue=="oui"){
				echo "<script>moy_ue('"."verdict_".$ue[$i]['code_ue']."','OUI')</script>";
			}else{
				echo "<script>moy_ue('"."verdict_".$ue[$i]['code_ue']."','<b>NON</b>')</script>";	
			}
		//}
    }  
		$verdict=selTableData2Fields('verdict','matricule',$inscription[$i]['matricule'],'annee_academique',$_POST['annee']);
		if(count($verdict)>0){
			$verdict=$verdict[0];
			$verdict=$verdict['result_semestre_2'];
		}else{
			$verdict="";	
		}
	?>
    <tr bgcolor="#FFFFCC">
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" colspan='2'></td>
      <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
	<tr bgcolor="#FFFFCC">
      <td align="center" bgcolor="#FFCCAA" colspan='4'><?php echo "VERDICT DU JURY : <b>".$verdict."</b>";  ?></td>
    </tr>
</table>

      </td>
    </tr>
  </table>
</form>

<?php 
}
?>
</body>
</html>