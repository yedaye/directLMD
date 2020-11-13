<?php
ob_start();
session_start();
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");
if (is_file("../param.php"))
	include_once ("../param.php");
require('../html2pdf/html2pdf.class.php');
$err_msg="";
$msg_ajout="";
$msg_modif="";
$msg_dja="";
if(isset($_GET['matricule'])){  
	$etudiant=selTableDataWhere("student","matricule",$_GET['matricule']);
	$inscription=selTableData2Fields("inscription","matricule",$_GET['matricule'],"annee_academique",$_GET['annee']);
	  $rs = mysql_query("UPDATE inscription SET carte_imprime='oui', carte_user='".$_SESSION['username']."' Where filiere='".$inscription[0]['filiere']."' AND matricule='".$_GET['matricule']."' AND annee_academique='".$_GET['annee']."'") or die(mysql_error());
?>
<page>
<div style=" background-image:url(../img/logo_blanc.jpg); background-position:center; background-repeat:no-repeat; width:100%">
<div style="width:100%; font-size:50px; text-align:center"><strong>CARTE D'ETUDIANT </strong><hr/></div>
<table style="width: 96%" cellspacing="5"><tr><td style="width: 30%">
	  	<table align="left" border="1" cellspacing="0" cellpadding="0" style="font-size:35px; text-align:center">
        <tr>
            <td align="center" valign="top" bgcolor="#00CC99">MATRICULE<br><b><?php echo $inscription[0]['matricule']; ?></b></td>
        </tr>
        <tr>
            <td align="center" valign="top">
            <?php
	  	if(file_exists("photo/".strtoupper($inscription[0]['matricule']).".jpg")){
		?>
        	<img src="<?php echo "photo/".strtoupper($inscription[0]['matricule']).".jpg"; ?>" alt="" name="photo" width="300" height="300" id="photo" />
        <?php
	   	}else{
		?>
        	<img src="<?php echo "photo/2013/".$etudiant['num_table']."_2013.jpg"; ?>" alt="" name="photo" width="300" height="300" id="photo" />
        <?php	
		}
	  ?>
            </td>
        </tr>
    	</table>
 </td>
 <td style="width:70%; font-size:40px; padding-left:10px">
 	<table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%"><strong>Nom : </strong></td><td style="width:65% <?php if(strlen(utf8_encode($etudiant['nom']))>15){ echo ";font-size:35px";}  ?>"><?php echo utf8_encode($etudiant['nom']); ?></td>
        </tr>
    </table>
	<table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>Prénoms : </strong></td><td style="width:65%; padding-top:10px <?php if(strlen(utf8_encode($etudiant['prenoms']))>15){ echo ";font-size:25px";}  ?>"><?php echo utf8_encode($etudiant['prenoms']); ?></td>
        </tr>
    </table>
    <table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>Né(e): </strong></td><td style="width:65%; padding-top:10px"><?php echo $etudiant['date_naissance']; ?></td>
        </tr>
    </table>
    <table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>A : </strong></td><td style="width:65%; padding-top:10px"><?php echo utf8_encode($etudiant['lieu_naissance']); ?></td>
        </tr>
    </table>
	<table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>Nationalite :</strong></td><td style="width:65%; padding-top:10px"><b><?php 
		  $nation=selTableDataWhere("pays","cod_pays",$etudiant['Nationalite']);
		  echo utf8_encode($nation['lib_nation']); ?></b></td>
        </tr>
    </table>
	<table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>Téléphone :</strong></td><td style="width:65%; padding-top:10px"><?php echo $etudiant['telephone']; ?></td>
        </tr>
    </table>
    <table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>Email :</strong></td><td style="width:65%; padding-top:10px"><?php echo strtolower($etudiant['email_uak']."@unabenin.bj"); ?></td>
        </tr>
    </table>
	<table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px; background-color:#DDFFE1"><strong>Spécialité :</strong></td><td style="width:65%; padding-top:10px; background-color:#DDFFE1"><?php 	
				echo $inscription[0]['filiere'];
				//$ecole=selTableDataWhere("filiere","code",$inscription[0]['filiere']);
				//echo $ecole['ecole']; 
			?></td>
        </tr>
    </table>
 </td></tr></table>
<hr/>
  <table border="0" cellspacing="2" cellpadding="0" style="width:100%;text-align:center;padding-left:15px">
  <tr>
    <td style="width:30%; text-align:center;font-size:25px; font-weight:bold"><img src="../img/signature.jpg" width="153" height="60"><br>
La Secrétaire Générale</td>
    <td style="width:70%; text-align:center; vertical-align:middle"><barcode type="C39" value="<?php echo $inscription[0]['matricule']; ?>" label="<?php echo $inscription[0]['matricule']; ?>" style="width: 200mm; height: 32mm"></barcode></td>
  </tr>
</table>
</div></page>
<?php 
		} 
		$texte=ob_get_clean();
		try{
			$html2pdf=new HTML2PDF("L");
			$html2pdf->SetDefaultFont('Arial','B',16);
			$html2pdf->WriteHTML($texte);
			$html2pdf->Output("carte_pdf/carte_UNA_".$_GET['matricule'].".pdf");
		}
		catch(HTML2PDF_exception $e) {
        	echo $e;
        	exit;
    	}
		
?>