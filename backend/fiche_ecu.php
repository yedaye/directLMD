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
<title>Fiche de préinscription</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">td img {display: block;}body,td,th {
	font-family: Georgia, Times New Roman, Times, serif;
	font-size: 15px;
}
</style>
<!--Fireworks CS5 Dreamweaver CS5 target.  Created Sat Sep 27 13:07:13 GMT+0200 2014-->
</head>
<body bgcolor="#ffffff">
<?php
if(isset($_GET['matricule']) || isset($_GET['num_table'])){
	if($_GET['matricule']!=""){
		$etudiant=selTableDataWhere("student","matricule",$_GET['matricule']);
	}else{
		$etudiant=selTableDataWhere("student","num_table",$_GET['num_table']);
	}
	$inscription=selTableData2Fields("inscription","matricule",$etudiant['matricule'],"annee_academique",$_GET['an_etude']);
//	print_r($inscription);
}
?>
<table border="0" cellpadding="0" cellspacing="0" width="650" align="center">
<!-- fwtable fwsrc="fiche_ecu.png" fwpage="Page 1" fwbase="fiche_ecu.jpg" fwstyle="Dreamweaver" fwdocid = "1350424229" fwnested="0" -->
  <tr>
   <td><img src="../fiche/image_ecu/spacer.gif" width="20" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="112" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="76" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="24" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="50" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="41" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="19" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="40" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="23" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="212" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="12" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="21" height="1" border="0" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
   <td colspan="12"><img name="fiche_ecu_r1_c1" src="../fiche/image_ecu/fiche_ecu_r1_c1.jpg" width="650" height="5" border="0" id="fiche_ecu_r1_c1" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="5" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="4" colspan="6"><img name="fiche_ecu_r2_c1" src="../fiche/image_ecu/fiche_ecu_r2_c1.jpg" width="323" height="123" border="0" id="fiche_ecu_r2_c1" alt="" /></td>
   <td colspan="4"><img name="fiche_ecu_r2_c7" src="../fiche/image_ecu/fiche_ecu_r2_c7.jpg" width="294" height="36" border="0" id="fiche_ecu_r2_c7" alt="" /></td>
   <td rowspan="24" colspan="2"><img name="fiche_ecu_r2_c11" src="../fiche/image_ecu/fiche_ecu_r2_c11.jpg" width="33" height="507" border="0" id="fiche_ecu_r2_c11" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="36" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="4"><img name="fiche_ecu_r3_c7" src="../fiche/image_ecu/fiche_ecu_r3_c7.jpg" width="294" height="4" border="0" id="fiche_ecu_r3_c7" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="4" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="4"><img name="fiche_ecu_r4_c7" src="../fiche/image_ecu/fiche_ecu_r4_c7.jpg" width="294" height="36" border="0" id="fiche_ecu_r4_c7" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="36" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="4"><img name="fiche_ecu_r5_c7" src="../fiche/image_ecu/fiche_ecu_r5_c7.jpg" width="294" height="47" border="0" id="fiche_ecu_r5_c7" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="47" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="12" colspan="3"><img name="fiche_ecu_r6_c1" src="../fiche/image_ecu/fiche_ecu_r6_c1.jpg" width="208" height="237" border="0" id="fiche_ecu_r6_c1" alt="" /></td>
   <td colspan="7"><img name="fiche_ecu_r6_c4" src="../fiche/image_ecu/fiche_ecu_r6_c4.jpg" width="409" height="27" border="0" id="fiche_ecu_r6_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r7_c4" src="../fiche/image_ecu/fiche_ecu_r7_c4.jpg" width="409" height="5" border="0" id="fiche_ecu_r7_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="5" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r8_c4" src="../fiche/image_ecu/fiche_ecu_r8_c4.jpg" width="409" height="27" border="0" id="fiche_ecu_r8_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r9_c4" src="../fiche/image_ecu/fiche_ecu_r9_c4.jpg" width="409" height="6" border="0" id="fiche_ecu_r9_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="6" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r10_c4" src="../fiche/image_ecu/fiche_ecu_r10_c4.jpg" width="409" height="27" border="0" id="fiche_ecu_r10_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r11_c4" src="../fiche/image_ecu/fiche_ecu_r11_c4.jpg" width="409" height="5" border="0" id="fiche_ecu_r11_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="5" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r12_c4" src="../fiche/image_ecu/fiche_ecu_r12_c4.jpg" width="409" height="27" border="0" id="fiche_ecu_r12_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r13_c4" src="../fiche/image_ecu/fiche_ecu_r13_c4.jpg" width="409" height="7" border="0" id="fiche_ecu_r13_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="7" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r14_c4" src="../fiche/image_ecu/fiche_ecu_r14_c4.jpg" width="409" height="27" border="0" id="fiche_ecu_r14_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="27" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r15_c4" src="../fiche/image_ecu/fiche_ecu_r15_c4.jpg" width="409" height="9" border="0" id="fiche_ecu_r15_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="9" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r16_c4" src="../fiche/image_ecu/fiche_ecu_r16_c4.jpg" width="409" height="63" border="0" id="fiche_ecu_r16_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="63" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="7"><img name="fiche_ecu_r17_c4" src="../fiche/image_ecu/fiche_ecu_r17_c4.jpg" width="409" height="7" border="0" id="fiche_ecu_r17_c4" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="7" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="8" colspan="2"><img name="fiche_ecu_r18_c1" src="../fiche/image_ecu/fiche_ecu_r18_c1.jpg" width="132" height="147" border="0" id="fiche_ecu_r18_c1" alt="" /></td>
   <td rowspan="2" colspan="5"><img name="fiche_ecu_r18_c3" src="../fiche/image_ecu/fiche_ecu_r18_c3.jpg" width="210" height="27" border="0" id="fiche_ecu_r18_c3" alt="" /></td>
   <td colspan="3"><img name="fiche_ecu_r18_c8" src="../fiche/image_ecu/fiche_ecu_r18_c8.jpg" width="275" height="1" border="0" id="fiche_ecu_r18_c8" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="4" colspan="2"><img name="fiche_ecu_r19_c8" src="../fiche/image_ecu/fiche_ecu_r19_c8.jpg" width="63" height="43" border="0" id="fiche_ecu_r19_c8" alt="" /></td>
   <td rowspan="2"><img name="fiche_ecu_r19_c10" src="../fiche/image_ecu/fiche_ecu_r19_c10.jpg" width="212" height="27" border="0" id="fiche_ecu_r19_c10" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="26" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="2" colspan="5"><img name="fiche_ecu_r20_c3" src="../fiche/image_ecu/fiche_ecu_r20_c3.jpg" width="210" height="15" border="0" id="fiche_ecu_r20_c3" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="2"><img name="fiche_ecu_r21_c10" src="../fiche/image_ecu/fiche_ecu_r21_c10.jpg" width="212" height="16" border="0" id="fiche_ecu_r21_c10" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="14" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="2" colspan="2"><img name="fiche_ecu_r22_c3" src="../fiche/image_ecu/fiche_ecu_r22_c3.jpg" width="100" height="27" border="0" id="fiche_ecu_r22_c3" alt="" /></td>
   <td colspan="3"><img name="fiche_ecu_r22_c5" src="../fiche/image_ecu/fiche_ecu_r22_c5.jpg" width="110" height="2" border="0" id="fiche_ecu_r22_c5" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="2" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="3"><img name="fiche_ecu_r23_c5" src="../fiche/image_ecu/fiche_ecu_r23_c5.jpg" width="50" height="103" border="0" id="fiche_ecu_r23_c5" alt="" /></td>
   <td rowspan="2" colspan="3"><img name="fiche_ecu_r23_c6" src="../fiche/image_ecu/fiche_ecu_r23_c6.jpg" width="100" height="27" border="0" id="fiche_ecu_r23_c6" alt="" /></td>
   <td rowspan="3"><img name="fiche_ecu_r23_c9" src="../fiche/image_ecu/fiche_ecu_r23_c9.jpg" width="23" height="103" border="0" id="fiche_ecu_r23_c9" alt="" /></td>
   <td rowspan="2"><img name="fiche_ecu_r23_c10" src="../fiche/image_ecu/fiche_ecu_r23_c10.jpg" width="212" height="27" border="0" id="fiche_ecu_r23_c10" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="25" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="2" colspan="2"><img name="fiche_ecu_r24_c3" src="../fiche/image_ecu/fiche_ecu_r24_c3.jpg" width="100" height="78" border="0" id="fiche_ecu_r24_c3" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="2" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="3"><img name="fiche_ecu_r25_c6" src="../fiche/image_ecu/fiche_ecu_r25_c6.jpg" width="100" height="76" border="0" id="fiche_ecu_r25_c6" alt="" /></td>
   <td><img name="fiche_ecu_r25_c10" src="../fiche/image_ecu/fiche_ecu_r25_c10.jpg" width="212" height="76" border="0" id="fiche_ecu_r25_c10" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="76" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="2"><img name="fiche_ecu_r26_c1" src="../fiche/image_ecu/fiche_ecu_r26_c1.jpg" width="20" height="448" border="0" id="fiche_ecu_r26_c1" alt="" /></td>
   <td colspan="10"><img name="fiche_ecu_r26_c2" src="../fiche/image_ecu/fiche_ecu_r26_c2.jpg" width="609" height="380" border="0" id="fiche_ecu_r26_c2" alt="" /></td>
   <td rowspan="2"><img name="fiche_ecu_r26_c12" src="../fiche/image_ecu/fiche_ecu_r26_c12.jpg" width="21" height="448" border="0" id="fiche_ecu_r26_c12" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="380" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="10"><img name="fiche_ecu_r27_c2" src="../fiche/image_ecu/fiche_ecu_r27_c2.jpg" width="609" height="68" border="0" id="fiche_ecu_r27_c2" alt="" /></td>
   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="68" border="0" alt="" /></td>
  </tr>
</table>
</body>
</html>
