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
	$etudiant=selTableDataWhere("student","matricule",$_GET['matricule'],$pdo);
	$inscription=selTableData2Fields("inscription","matricule",$_GET['matricule'],"annee_academique",$_GET['annee'],$pdo);

	//marquage de l'inscription comme imprimer
	if($_GET['num_carte']==""){
		//compte du nombre de carte
		$qstr = "SELECT count(*) as nombre FROM `duplicata` WHERE annee_acad='".$_GET['annee']."' AND num_carte!=NULL"; 
		$stm = $pdo->query($qstr);
		$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
		//print_r($rows);
		//exit;
		//print_r($inscription);
		//exit;
		$num_carte=$rows[0]['nombre']+1;
		//echo $num_carte;
		//exit;
		//fin du comptage
		$champ=array('num_carte');
		$valeur=array($num_carte);
		$wherefield=array('matricule','annee_acad');
		$wherevalue=array($_GET['matricule'],$_GET['annee']);
		updTableWhereArray("duplicata",$champ,$valeur,$wherefield,$wherevalue,$pdo);
	}else{
		$num_carte=$_GET['num_carte'];
	}
	
?>
<page>
<div style=" background-image:url(../img/logo_blanc_duplicata.jpg); background-position:center; background-repeat:no-repeat; width:100%">
<div style="width:100%; font-size:50px; text-align:center"><strong>CARTE D'ETUDIANT </strong><hr/></div>
<table style="width: 96%" cellspacing="5"><tr><td style="width: 30%">
	  	<table align="left" border="1" cellspacing="0" cellpadding="0" style="font-size:35px; text-align:center">
        <tr>
            <td align="center" valign="top" bgcolor="#00CC99">MATRICULE<br><b><?php echo $inscription['matricule']; ?></b></td>
        </tr>
        <tr>
            <td align="center" valign="top">
            <?php
	  	if(file_exists("photo/".strtoupper($inscription['matricule']).".jpg")){
		?>
        	<img src="<?php echo "photo/".strtoupper($inscription['matricule']).".jpg"; ?>" alt="" name="photo" width="300" height="300" id="photo" />
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
 	 		<td style="width:35%"><strong>Nom : </strong></td><td style="width:65% <?php if(strlen($etudiant['nom'])>15){ echo ";font-size:35px";}  ?>"><?php echo $etudiant['nom']; ?></td>
        </tr>
    </table>
	<table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>Prénoms : </strong></td><td style="width:65%; padding-top:10px <?php if(strlen($etudiant['prenoms'])>15){ echo ";font-size:25px";}  ?>"><?php echo $etudiant['prenoms']; ?></td>
        </tr>
    </table>
    <table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>Né(e): </strong></td><td style="width:65%; padding-top:10px"><?php echo $etudiant['date_naissance']; ?></td>
        </tr>
    </table>
    <table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>A : </strong></td><td style="width:65%; padding-top:10px"><?php echo $etudiant['lieu_naissance']; ?></td>
        </tr>
    </table>
	<table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>Nationalite :</strong></td><td style="width:65%; padding-top:10px"><b><?php 
		  $nation=selTableDataWhere("pays","cod_pays",$etudiant['Nationalite'],$pdo);
		  echo $nation['lib_nation']; ?></b></td>
        </tr>
    </table>
	<table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>Téléphone :</strong></td><td style="width:65%; padding-top:10px"><?php echo $etudiant['telephone']; ?></td>
        </tr>
    </table>
    <table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px"><strong>Email :</strong></td><td style="width:65%; padding-top:10px"><?php echo strtolower($etudiant['email_uak']."@etu.una.bj"); ?></td>
        </tr>
    </table>
	<table style="width:100%" align="left" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:35%; padding-top:10px; background-color:#DDFFE1"><strong>Spécialité :</strong></td><td style="width:65%; padding-top:10px; background-color:#DDFFE1"><?php 	
				echo $inscription['filiere'];
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
    <td style="width:70%; text-align:center; vertical-align:middle"><img src='../qrcode.png'/></td>
  </tr>
</table>
</div></page>
<page>
<div style="background-image:url(../img/logo_carte.jpg); background-position:center; background-repeat:no-repeat; width:100%; height:100%">
	<table style="width:100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:100%;text-align:center">
			  <p style="font-size: 40px; font-weight:bold">REPUBLIQUE DU BENIN <br/>
			  		---------------------<br/>
			  UNIVERSITE NATIONALE D'AGRICULTURE</p><br/>
			</td>
        </tr>
    </table>
	<table style="width:100%; vertical-align:bottom" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:100%;text-align:left">
			  <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
			</td>
        </tr>
    </table>
	<table style="width:90%; vertical-align:bottom;" border="0" cellspacing="0" align="center" cellpadding="0">
        <tr>
 	 		<td style="width:45%;text-align:left"><?php echo "<h2>N°   ".$num_carte." | Ref: ".$inscription['num_inscription']."</h2>"; ?></td>
			<td style="width:45%;text-align:right"><?php echo "<h2>".$inscription['annee_academique']."</h2>"; ?></td>
        </tr>
    </table>
	<table style="width:95%; vertical-align:bottom" border="0" cellspacing="0" cellpadding="0">
        <tr>
 	 		<td style="width:100%;text-align:center"><h2>NB: Cette carte est rigoureusement personnelle. En cas de perte, l'&eacute;tudiant devra en faire la d&eacute;position dans un commissariat de police et payer les frais d'impression du duplicata.</h2></td>
			
        </tr>
    </table>
</div>
</page>
<?php 
	} 
	$texte=ob_get_clean();
	try{
		$html2pdf=new HTML2PDF("L");
		$html2pdf->SetDefaultFont('Arial','B',16);
		$html2pdf->WriteHTML($texte);
		$html2pdf->Output("carte_pdf/carte_duplicata_UNA_".$_GET['matricule'].".pdf");
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}
?>