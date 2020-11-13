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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0014)about:internet -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>FICHE DE PREINSCRIPTION</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
td img {display: block;}body,td,th {
	font-family: Georgia, Times New Roman, Times, serif;
	font-size: 15px;
}
.totat {
	color: #F00;
	font-family: Arial, Helvetica, sans-serif;
}
.totat td {
	font-weight: bold;
}
</style>
<script language="javascript1.2" type="text/javascript">
	function efface(val){
		if(maval=='matricule'){
			$("#num_table").val="";	
		}else{
			$("#matricule").val="";		
		}
	};
</script>
</head>
<body bgcolor="#ffffff">
<?php
if(isset($_GET['matricule']) || isset($_GET['num_table'])){
	if($_GET['matricule']!=""){
		$etudiant=selTableDataWhere("student","matricule",$_GET['matricule'],$pdo);
	}else{
		$etudiant=selTableDataWhere("student","num_table",$_GET['num_table'],$pdo);
	}
	$inscription=selTableData2Fields("inscription","matricule",$etudiant['matricule'],"annee_academique",$_GET['an_etude'],$pdo);
  $penalite=selTableData2Fields("penalite","matricule",$etudiant['matricule'],"annee_academique",$_GET['an_etude'],$pdo);
  //print_r($inscription);
  //echo "<hr/>";
  //print_r($penalite);
 ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
<!-- fwtable fwsrc="fiche_penalite.png" fwpage="Page 1" fwbase="fiche_penalite.jpg" fwstyle="Dreamweaver" fwdocid = "1350424229" fwnested="0" -->
  <tr>
   <td><img src="../fiche/image_penalite/spacer.gif" width="202" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="6" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="103" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="12" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="283" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="5" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="6" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="33" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
   <td colspan="8"><img name="fiche_penalite_r1_c1" src="../fiche/image_penalite/fiche_penalite_r1_c1.jpg" width="650" height="5" border="0" id="fiche_penalite_r1_c1" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="5" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="4" colspan="4"><img name="fiche_penalite_r2_c1" src="../fiche/image_penalite/fiche_penalite_r2_c1.jpg" width="323" height="123" border="0" id="fiche_penalite_r2_c1" alt="" /></td>
   <td colspan="3" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r2_c5.jpg"><?php echo $_GET['an_etude']; ?></td>
   <td rowspan="40"><img name="fiche_penalite_r2_c8" src="../fiche/image_penalite/fiche_penalite_r2_c8.jpg" width="33" height="955" border="0" id="fiche_penalite_r2_c8" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="36" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="3"><img name="fiche_penalite_r3_c5" src="../fiche/image_penalite/fiche_penalite_r3_c5.jpg" width="294" height="4" border="0" id="fiche_penalite_r3_c5" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="4" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="3" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r4_c5.jpg"><?php echo $inscription['num_inscription']; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="36" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="3"><img name="fiche_penalite_r5_c5" src="../fiche/image_penalite/fiche_penalite_r5_c5.jpg" width="294" height="47" border="0" id="fiche_penalite_r5_c5" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="47" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="20" colspan="2"><img name="fiche_penalite_r6_c1" src="../fiche/image_penalite/fiche_penalite_r6_c1.jpg" width="208" height="506" border="0" id="fiche_penalite_r6_c1" alt="" /></td>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r6_c3.jpg"><?php echo $inscription['matricule']." (".$etudiant['email_uak'].")"; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r7_c3" src="../fiche/image_penalite/fiche_penalite_r7_c3.jpg" width="409" height="5" border="0" id="fiche_penalite_r7_c3" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="5" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r8_c3.jpg"><?php echo utf8_encode($etudiant['nom']); ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r9_c3" src="../fiche/image_penalite/fiche_penalite_r9_c3.jpg" width="409" height="6" border="0" id="fiche_penalite_r9_c3" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="6" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r10_c3.jpg"><?php echo $etudiant['prenoms']; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r11_c3" src="../fiche/image_penalite/fiche_penalite_r11_c3.jpg" width="409" height="5" border="0" id="fiche_penalite_r11_c3" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="5" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r12_c3.jpg"><?php echo $etudiant['date_naissance']; ?> / <?php echo $etudiant['lieu_naissance']; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r13_c3" src="../fiche/image_penalite/fiche_penalite_r13_c3.jpg" width="409" height="7" border="0" id="fiche_penalite_r13_c3" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="7" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r14_c3.jpg"><?php 
		  $nation=selTableDataWhere("pays","cod_pays",$etudiant['Nationalite'],$pdo);
		  echo $nation['lib_nation']; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r15_c3" src="../fiche/image_penalite/fiche_penalite_r15_c3.jpg" width="409" height="9" border="0" id="fiche_penalite_r15_c3" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="9" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r16_c3.jpg"><?php 	
            $ecole=selTableDataWhere("filiere","code",$inscription['filiere'],$pdo);
            $lib=selTableDataWhere("ecole_ufr","code_ecole",$ecole['ecole'],$pdo);
			echo $libecole=$lib['lib_ecole']; 
        ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="63" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r17_c3" src="../fiche/image_penalite/fiche_penalite_r17_c3.jpg" width="409" height="10" border="0" id="fiche_penalite_r17_c3" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="10" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r18_c3.jpg"><?php echo $inscription['filiere']; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r19_c3" src="../fiche/image_penalite/fiche_penalite_r19_c3.jpg" width="409" height="14" border="0" id="fiche_penalite_r19_c3" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="14" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r20_c3.jpg"><?php echo $penalite['montant']."FCFA"; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="28" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r21_c3" src="../fiche/image_penalite/fiche_penalite_r21_c3.jpg" width="409" height="75" border="0" id="fiche_penalite_r21_c3" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="75" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="4"><img name="fiche_penalite_r22_c3" src="../fiche/image_penalite/fiche_penalite_r22_c3.jpg" width="103" height="122" border="0" id="fiche_penalite_r22_c3" alt="" /></td>
   <td colspan="2" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r22_c4.jpg"><?php echo $_GET['an_etude']; ?></td>
   <td rowspan="4" colspan="2"><img name="fiche_penalite_r22_c6" src="../fiche/image_penalite/fiche_penalite_r22_c6.jpg" width="11" height="122" border="0" id="fiche_penalite_r22_c6" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="36" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="2"><img name="fiche_penalite_r23_c4" src="../fiche/image_penalite/fiche_penalite_r23_c4.jpg" width="295" height="4" border="0" id="fiche_penalite_r23_c4" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="4" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="2" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r24_c4.jpg"><?php echo $inscription['num_inscription']; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="36" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="2"><img name="fiche_penalite_r25_c4" src="../fiche/image_penalite/fiche_penalite_r25_c4.jpg" width="295" height="46" border="0" id="fiche_penalite_r25_c4" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="46" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="16"><img name="fiche_penalite_r26_c1" src="../fiche/image_penalite/fiche_penalite_r26_c1.jpg" width="202" height="326" border="0" id="fiche_penalite_r26_c1" alt="" /></td>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r26_c2.jpg"><?php echo $inscription['matricule']." (".$etudiant['email_uak'].")"; ?></td>
   <td rowspan="16"><img name="fiche_penalite_r26_c7" src="../fiche/image_penalite/fiche_penalite_r26_c7.jpg" width="6" height="326" border="0" id="fiche_penalite_r26_c7" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r27_c2" src="../fiche/image_penalite/fiche_penalite_r27_c2.jpg" width="409" height="5" border="0" id="fiche_penalite_r27_c2" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="5" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r28_c2.jpg"><?php echo utf8_encode($etudiant['nom']); ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r29_c2" src="../fiche/image_penalite/fiche_penalite_r29_c2.jpg" width="409" height="6" border="0" id="fiche_penalite_r29_c2" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="6" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r30_c2.jpg"><?php echo $etudiant['prenoms']; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r31_c2" src="../fiche/image_penalite/fiche_penalite_r31_c2.jpg" width="409" height="5" border="0" id="fiche_penalite_r31_c2" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="5" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r32_c2.jpg"><?php echo $etudiant['date_naissance']; ?> / <?php echo utf8_encode($etudiant['lieu_naissance']); ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r33_c2" src="../fiche/image_penalite/fiche_penalite_r33_c2.jpg" width="409" height="7" border="0" id="fiche_penalite_r33_c2" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="7" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r34_c2.jpg"><?php 
		  $nation=selTableDataWhere("pays","cod_pays",$etudiant['Nationalite'],$pdo);
		  echo $nation['lib_nation']; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r35_c2" src="../fiche/image_penalite/fiche_penalite_r35_c2.jpg" width="409" height="9" border="0" id="fiche_penalite_r35_c2" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="9" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r36_c2.jpg"><?php 	
            $ecole=selTableDataWhere("filiere","code",$inscription['filiere'],$pdo);
            $lib=selTableDataWhere("ecole_ufr","code_ecole",$ecole['ecole'],$pdo);
            echo $libecole=$lib['lib_ecole']; 
        ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="63" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r37_c2" src="../fiche/image_penalite/fiche_penalite_r37_c2.jpg" width="409" height="8" border="0" id="fiche_penalite_r37_c2" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="8" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r38_c2.jpg"><?php echo $inscription['filiere']; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r39_c2" src="../fiche/image_penalite/fiche_penalite_r39_c2.jpg" width="409" height="14" border="0" id="fiche_penalite_r39_c2" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="14" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5" align="center" valign="middle" background="../fiche/image_penalite/fiche_penalite_r40_c2.jpg"><?php echo $penalite['montant']."FCFA"; ?></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="28" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="5"><img name="fiche_penalite_r41_c2" src="../fiche/image_penalite/fiche_penalite_r41_c2.jpg" width="409" height="19" border="0" id="fiche_penalite_r41_c2" alt="" /></td>
   <td><img src="../fiche/image_penalite/spacer.gif" width="1" height="19" border="0" alt="" /></td>
  </tr>
</table>
<?php
}else{
	echo "veuillez revoir votre choix";	
}
?>
</body>
</html>
