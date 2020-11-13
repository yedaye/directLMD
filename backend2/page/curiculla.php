<?php
//session_start();
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");
	include_once ("../param.php");
	
if(isset($_FILES['photo_new']['name'])){
	if($_FILES['photo_new']['name']!=""){
		copy($_FILES['photo_new']['tmp_name'],"photo/".trim($_POST['matricule2']).".jpg");
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
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
<link rel="stylesheet" type="text/css" href="../js/default/easyui.css">  
<link rel="stylesheet" type="text/css" href="../js/icon.css"> 
<link rel="stylesheet" type="text/css" href="../js/icon.css"> 
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

<p class="panel-title" align="center">CURRICULA</p><br /><br />
	<form id="form1" name="form1" method="GET" action="">
	  <table width="80%" border="0" align="center" cellspacing="2">
	    <tr>
	      <td width="17%" align="left" bgcolor="#D6D6D6">Filiere :</td>
	      <td width="23%" align="left" bgcolor="#D6D6D6"><label for="filiere"></label>
	        <select name="filieres" id="filieres">
            <?php
			$fil=selTableDataDesc("filiere","code");
				for($i=0;$i<count($fil);$i++){
					$select="";
					if(isset($_GET['filieres']) && $_GET['filieres']==$fil[$i]['code']){ $select="selected"; }
					echo "<option ".$select." value='".$fil[$i]['code']."'>".strtoupper($fil[$i]['code'])."</option>";
				}	
			?>
          </select></td>
	      <td width="24%" align="left" bgcolor="#D6D6D6">Promotion :</td>
	      <td width="36%" align="left"><select required="true" name="promotion" id="promotion">
                    <option value='P1' <?php if(isset($_GET['promotion']) && $_GET['promotion']=='P1'){ echo "selected=\"selected\""; } ?>>Promo1 (2013-2014)</option>
					<option value='P2' <?php if(isset($_GET['promotion']) && $_GET['promotion']=='P2'){ echo "selected=\"selected\""; } ?>>Promo2 (2014-2015)</option>					
					<option value='P3' <?php if(isset($_GET['promotion']) && $_GET['promotion']=='P3'){ echo "selected=\"selected\""; } ?>>Promo3 (2015-2016)</option>
					<option value='P4' <?php if(isset($_GET['promotion']) && $_GET['promotion']=='P4'){ echo "selected=\"selected\""; } ?>>Promo4 (2016-2017)</option>
                </select>
          <input type="submit" name="button" id="button" value="Rechercher" /><input type='hidden' name='curiculla'/></td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
        </tr>
      </table>
</form>
<br />
<?php  
if(isset($_GET['filieres'])){  
$_SESSION['colonne']="CODE;DESIGNATION;CREDIT";
$_SESSION['UE']=array();
?>
<hr />
<br />
<div align="center" id="spinner" style="display:none"><img src="../img/global_spinner.gif" /></div>
<div align='center'><a href="Excel/sortieFichier2.php" target="_blank"><img src="../img/excel.jpg" alt="" align="left" border="0" height="33" width="32"></a><br>
   	            <span class="ds">  Exporter en Excel</span></div>
  <table width="100%" border="0" cellpadding="0" cellspacing="2" class="datagrid-body" style='font-size:18px' align='center'>
    <tr>
      <td align="center" valign="middle">
      <table width="80%" border="0" cellspacing="2" align='center'>
  <tr>
    <td width="59%" bgcolor="#FFCCCC">Unité d'Enseignement (UE) / Eléments Constitutifs de l'UE</td>
    <td width="13%" align="center" bgcolor="#FFCCCC">Nombre de crédits</td>
  </tr>
 <?php
	$ue=array();
	$ue=selTableData2FieldsAsc("table_ue_new","code_ecole",$_GET['filieres'],"promotion",$_GET['promotion'],"designation");
	//print_r($ue);
	$a=0;
	for($i=0;$i<count($ue);$i++){
		//array_push($_SESSION['UE'],array($ue[$i]['code_ue'],$ue[$i]['designation'],$ue[$i]['credit']);
		array_push($_SESSION['UE'], $ue[$i]);
	?>
  <tr bgcolor="#D0DBF9">
    <td bgcolor="#D0DBF9"><b><?php echo strtoupper(utf8_decode($ue[$i]['designation']."(".$ue[$i]['code_ue'].")")); ?></b></td>
    <td align="center" bgcolor="#D0DBF9"><b><?php echo $ue[$i]['credit']; ?></b></td>
  </tr>
	<?php 
			$ecu=selTableData2FieldsAsc("table_ecu_new","code_ue",$ue[$i]['code_ue'],"promotion",$_GET['promotion'],"designation");
			for($a=0;$a<count($ecu);$a++){
				//array_push($_SESSION['UE'],array("==>".$ecu[$a]['code_ecu'],"==>".$ecu[$a]['designation'],"==>".$ecu[$a]['credit']);
				array_push($_SESSION['UE'], $ecu[$a]);
			?>
			<tr bgcolor="#FFFFCC">
			<td bgcolor="#FFFFCC"><?php echo utf8_encode($ecu[$a]['designation']."(".$ecu[$a]['code_ecu'].")"); ?></td>
			<td align="center" bgcolor="#FFFFCC"><?php echo $ecu[$a]['credit']; ?></td>
			</tr>
			<?php	 
			}
	}  
	?>
    <tr bgcolor="#FFFFCC">
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
	</tr>
</table>
<?php
//print_r($_SESSION['UE']);
?>
      </td>
    </tr>
  </table>

<?php 
}
?>
</body>
</html>