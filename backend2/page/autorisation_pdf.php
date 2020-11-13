<?php
ob_start();
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
?>
<page>
<div style="width:100%; font-size:16px">
<?php
	$qstr1 = "SELECT * FROM autorisation WHERE id=".$_GET['id'];
	$rs1 = mysql_query($qstr1) or die(mysql_error());
	$row=mysql_fetch_assoc($rs1);
	
	/// CUO
	if($row['type_auto']==2){
		?>
        <div style="width:100%; text-align:center"><img src="img/entete.jpg" width="650px" heigth="222px"/></div>
		<div><p>N°________/ R-UNA / VR / SG / SSC / SA</p></div>
        <br>
        <div style="padding-left:400px"><u>Code d'autorisation</u> : <b><?php  echo $row['code_auto']; ?></b></div>
        <br>
        <p align="center"><img src="img/autorisationCUO.jpg" width="609" height="80"/></p><br><br><br><br>
	
		<div style="width:100%; padding-left:30px">Le Recteur de l'Universit&eacute; Nationale d'Agriculture (UNA), autorise: </div><br>
		<div style="width:100%; padding-left:15px">
        	<u>Nom et Pr&eacute;noms</u> : <b><?php echo utf8_encode($row['nom']."   ".$row['prenoms']); ?></b> <br><br>

			<u>Date et lieu de naissance :</u> <b><?php echo $row['date_naissance']."</b> &agrave; <b>".$row['lieu_naissance']; ?></b><br><br>

			<u>Nationalit&eacute;</u> : <b>
					<?php
						$qstr2 = "SELECT * FROM pays WHERE cod_pays='".$row['Nationalite']."'";
						$rs2 = mysql_query($qstr2) or die(mysql_error());
						$row2=mysql_fetch_assoc($rs2);
						echo utf8_encode($row2['lib_nation']);
                    ?>
        			</b> </div><br>
<br>

		<div style="width:100%; padding-left:15px;"> s'inscrire en <b><?php echo $row['filiere']; ?></b> avec le statut : <?php 
		$qstr2 = "SELECT * FROM mode WHERE code='".$row['mode']."'";
						$rs2 = mysql_query($qstr2) or die(mysql_error());
						$row2=mysql_fetch_assoc($rs2);
						echo "<b>".utf8_encode($row2['Intitule'])."</b>";
					?><br><br> &agrave; <b>
					<?php
                    $nom_ecole=explode("-",$row['filiere']);
                    $nom_ecole=$nom_ecole[1];
                    $qstr3 = "SELECT * FROM ecole_ufr WHERE code_ecole='".$nom_ecole."'";
                    $rs3 = mysql_query($qstr3) or die(mysql_error());
                    $row3=mysql_fetch_assoc($rs3);
                    echo $row3['lib_ecole']." (".$nom_ecole.")"; ?>
                    
                    </b><br><br> au titre de l'ann&eacute;e acad&eacute;mique <?php echo $anneeEtude; ?>.</div>
		<br><br><br><br><br><br>
		<div style="width:100%; padding-left:400px"><p align='center'>Le Recteur de l'Universit&eacute; Nationale <br/> d'Agriculture (UNA)</p></div>
		<br><br><br><br><br>
        <div style="width:100%; padding-left:400px"><p align='center'><br><br/><b><u>Professeur Gauthier BIAOU</u></b></p></div>
		</div> 
  </page>
<?php
	}
	$texte=ob_get_clean();
	try{
		$html2pdf=new HTML2PDF("P");
		$html2pdf->SetDefaultFont('Arial','B',18);
		$html2pdf->WriteHTML($texte);
		$html2pdf->Output("pdf/fiche_autorisation_UNA_".$_GET['id'].".pdf");
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}			
?>