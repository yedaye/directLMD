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
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IMPRESSION DE LA CARTE DU PDF</title>
<style type="text/css">
.centre {
	text-align: center;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<?php
if(isset($_GET['matricule'])){  
	$etudiant=selTableDataWhere("student","matricule",$_GET['matricule']);
	$inscription=selTableData2Fields("inscription","matricule",$_GET['matricule'],"annee_academique",$_GET['annee']);
?>
<div class="contenant" style="background-image:url(../img/logo.jpg); background-position:center; background-repeat:no-repeat;">
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td colspan="2" align="center" valign="top" class="centre"><strong>CARTE D'ETUDIANT </strong><hr/></td>
    </tr>
  <tr>
    <td width="15%" align="left" valign="top"><table align="center" width="157" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="top" bgcolor="#00CC99">MATRICULE<br><?php echo $inscription[0]['matricule']; ?></td>
      </tr>
      <tr>
        <td align="center" valign="top"><img src="<?php echo "photo/".$inscription[0]['matricule'].".jpg"; ?>" width="157" height="187" ></td>
      </tr>
    </table></td>
    <td width="85%" align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
      <tr>
        <td width="18%" height="24" bgcolor="#FFFFCC"><strong>Nom : </strong></td>
        <td width="82%"><?php echo utf8_encode($etudiant['nom']); ?></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFCC"><strong>Prénoms :</strong></td>
        <td><?php echo utf8_encode($etudiant['prenoms']); ?></td>
      </tr>
      <tr>
        <td height="24" bgcolor="#FFFFCC"><strong>Date de naissance:</strong></td>
        <td><?php echo $etudiant['date_naissance']; ?></td>
      </tr>
      <tr>
        <td height="26" bgcolor="#FFFFCC"><strong>Lieu de naissance :</strong></td>
        <td><?php echo $etudiant['lieu_naissance']; ?></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFCC"><strong>Nationalite :</strong></td>
        <td><b><?php 
		  $nation=selTableDataWhere("pays","cod_pays",$etudiant['Nationalite']);
		  echo utf8_encode($nation['lib_nation']); ?></b>
        </td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFCC"><strong>Telephone :</strong></td>
        <td><?php echo $etudiant['telephone']; ?></td>
      </tr>
      <tr>
        <td height="24" bgcolor="#FFFFCC"><strong>Email :</strong></td>
        <td><?php echo $etudiant['email_uak']."@uak.bj"; ?></td>
      </tr>
      <tr>
        <td height="25" bgcolor="#FFFFCC"><strong>Ecole : </strong></td>
        <td bgcolor=""><?php 	
				$ecole=selTableDataWhere("filiere","code",$inscription[0]['filiere']);
				echo $ecole['ecole']; 
			?></td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="../img/signature.jpg" width="158" height="84"></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
</table>

</div>
<?php } ?> 
<p>&nbsp;</p></body></html>