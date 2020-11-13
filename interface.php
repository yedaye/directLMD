<?php
session_start();
if(!isset($_SESSION['login'])){
	header("Location:../indexa.php");	
}
require_once('../Connections/connection.php'); 
include_once("../param.php");
include_once("../connect/dbcon.php");
include_once("../functions/queries.php");
/// REDIRECTION SI LAGENT N'EST PAS CONNECTE
///
$nomb=0;
if(isset($_GET['matricule']) && isset($_GET['filiere']) && isset($_GET['annee']) && isset($_GET['carte'])){
	$array_field=array('editercarte','usercardedit','dateimpr');
	$wherefield=array('MATRICULE','FIL_COD_FIL','AN_COD_ANNEE');
	$array_value=array('','','');
	$wherevalue=array($_GET['matricule'],$_GET['filiere'],$_GET['annee']);
	updTableWhereArray("inscrits",$array_field,$array_value,$wherefield,$wherevalue);
}
if(isset($_GET['matricule']) && isset($_GET['filiere']) && isset($_GET['annee']) && isset($_GET['fiche'])){
	$array_field=array('CONTROLE','user_valid','date');
	$wherefield=array('MATRICULE','FIL_COD_FIL','AN_COD_ANNEE');
	$array_value=array('','','');
	$wherevalue=array($_GET['matricule'],$_GET['filiere'],$_GET['annee']);
	updTableWhereArray("inscrits",$array_field,$array_value,$wherefield,$wherevalue);
}
if(isset($_POST['matricule']) && isset($_POST['filiere']) && isset($_POST['annee'])){
	$array_field=array('editercarte','usercardedit','dateimpr');
	$wherefield=array('MATRICULE','FIL_COD_FIL','AN_COD_ANNEE');
	$array_value=array('','','');
	$wherevalue=array($_GET['matricule'],$_GET['filiere'],$_GET['annee']);
	updTableWhereArray("inscrits",$array_field,$array_value,$wherefield,$wherevalue);
}
if(isset($_POST['matricule']) && $_POST['matricule']!=""){
	$nombre=numRowTableDataWhere("etudiant_new","Matricule",$_POST['matricule']);
	if($nombre>0){
		$inscrit2009=selTableData2Fields("inscrits","Matricule",$_POST['matricule'],"AN_COD_ANNEE",$_POST['annee']);
		$etudiant=selTableDataWhere("etudiant_new","Matricule",$_POST['matricule']);
		$resultat=selTableMultiAnswer("resultatunivers","Matricule",$_POST['matricule']);
		$nomb=1;
	}
}
$mess=""	;
if(isset($_POST['validematricule'])){
//	print_r($_POST['inscrits']);
//	break;
	$_POST['inscrits']=substr($_POST['inscrits'],0,-2);
	$mesinscrit=explode("//",$_POST['inscrits']);
	for($a=0;$a<count($mesinscrit);$a++){
		$array_field=array('CONTROLE','user_valid','date');
		$wherefield=array('MATRICULE','FIL_COD_FIL','AN_COD_ANNEE');
		$login=$_SESSION['login'];
		$date=date('Y-m-d H:i:s');
		$annee=$_POST['lannee'];
		$array_value=array('OUI',$login,$date);
		$wherevalue=array($_POST['validematricule'],$mesinscrit[$a],$annee);
		updTableWhereArray("inscrits",$array_field,$array_value,$wherefield,$wherevalue);
	}
	$array_field=array('NUMIDENT','NOM','PRENOMS','DATE_NAIS','LIEU_NAIS');
	$array_value=array($_POST['numident'],$_POST['lenom'],$_POST['leprenom'],$_POST['ladate'],$_POST['lelieu']);
	updTable("etudiant_new",$array_field,$array_value,"Matricule",$_POST['validematricule']);
	$mess="DOSSIER VALIDER POUR LE NUMERO ".$_POST['validematricule'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VALIDATION SIMPLE</title>
<script language="javascript1.2" type="text/javascript" src="../js/ui_jquery/js/jquery-1.4.2.min.js"></script>
<script language="javascript1.2" type="text/javascript">
function validation(filiere){
	$('#inscrits').append(filiere+"//");
}

function supr(filiere, matricule, ladiv, annee){
		if(filiere.length == 0) {
			// Hide the suggestion box.
			alert("Veuillez refaire le click");
		}else{
		//	alert(montype)
			$('#'+ladiv).append('<img src="../img_news/spinner.gif" alt="Veuillez patienter" id="encours" />Veuillez patienter');
			$.post("../functions/supr.php", {lafiliere:filiere, lematricule:matricule, lannee:annee}, function(data){
					$('#'+ladiv).html(data);
					$('#'+ladiv).fadeOut(500, function() {
							$(this).remove();	
					});
			});
		}
	} // lookup
	function changetable(){
		$('#wait').append('<img src="../img_news/spinner.gif" alt="Veuillez patienter" id="encours" />Veuillez patienter');
		latable=document.getElementById('reftable').value;
		matricule=document.getElementById('validematricule').value;
		$.post("../functions/changetable.php", {newtable:latable, lematricule:matricule}, function(data){
			$('#wait').html(data);
		});
	}
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {
	color: #003399;
	font-size: 16px;
	font-family: "Times New Roman", Times, serif;
}
.style2 {
	font-size: 16px;
	font-family: "Times New Roman", Times, serif;
}
.nation {
	font-size: 18px;
	color: #F00;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" align="center"><img src="images/top-image.jpg" width="1000" height="150" /></td>
  </tr>
  <tr>
    <td height="19" align="left" background="images/gradient-bar.jpg">
    <div align="right">
    <?php  
        if(isset($_SESSION['login'])){
        	echo "Bienvenue ".$_SESSION['nom']." ".$_SESSION['prenoms']." <a href='../index.php?logout=true'>se déconnecter</a>";
        }
    ?>
    </div></td>
  </tr>
  <tr>
    <td height="342" align="left" valign="top" style="background-position:top; background-repeat:repeat-x; font-weight: bold;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%" align="center"><div align="left"> <a href='../index2.php'>RETOUR</a> </div>
          Interface de controle de l'&eacute;tudiant<br/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr bgcolor="#D6D6D6">
        <td>
          <form id="form1" method="post" action="">
            <table width="974" border="0" align="center">
              <tr>
                <td width="83"><strong>Matricule :</strong></td>
                <td width="18" bgcolor="#FFE1C5">&nbsp;</td>
                <td width="150"><label>
                  <input type="text" name="matricule" id="matricule" value="<?php 
				  $matricule='';
				  if(isset($_POST['matricule'])){
				 	 $matricule=$_POST['matricule'];
				  }
				  echo $matricule;
				  ?>"/>
                </label></td>
                <td width="274"></td>
                <td width="18" bgcolor="#FFE7D0">&nbsp;</td>
                <td width="261">Ann&eacute;e Acad&eacute;mique :
                  <select name="annee" id="annee">
                    <?php
				  $anne=selTableData("anacademique","AN_COD_ANNEE");
				  for($i=0;$i<count($anne);$i++){
						$sel="";
					  	if($anneeEtude==$anne[$i]['AN_COD_ANNEE']){
						  $sel="selected";
						}
						if(isset($_POST['annee']) && ($_POST['annee']==$anne[$i]['AN_COD_ANNEE'])){
						  $sel="selected";
						}
						echo "<option ".$sel." value='".$anne[$i]['AN_COD_ANNEE']."'>".$anne[$i]['AN_COD_ANNEE']."</option>";  
				  }
				  ?>
                  </select></td>
                <td width="69"><input type="submit" name="button" id="button" value="Controler" /></td>
              </tr>
            </table>
          </form>
          </td>
      </tr>
      <tr>
        <td></td>
      </tr>
  </table>
      </div><hr/>    <?php 
		  if(isset($_POST['matricule']) && $nomb==1){?>
      <br />
      <table width="100%" border="0">
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
      </table>
         <form id="form2" method="post" action="">
           <table width="100%" border="0">
        <tr>
          <td width="38%" align="center" valign="top"> 
          <p>
			      <?php 
			  if(strlen($matricule)>6 && substr($matricule,6,2)==12){
				echo "<img width='100' name='photoetu' src='../photo_uac/N".$etudiant['NumTable'].".jpg' id='photoetu' alt='photo'/>";
			  }else{
				echo "<img width='100' name='photoetu' src='../photo_uac/N".$etudiant['Matricule'].".jpg' id='photoetu' alt='photo'/>";
			  }
			  ?>
		        
          </p><br />
          <table width="100%" border="1">
		          <tr>
		            <td>
                    Ancien num&eacute;ro : <input name="numtable" id="numtable" type="text" size="12" readonly="readonly" value="<?php echo $etudiant['NumTable']; ?>"/>
                    Nouveau num&eacute;ro : <input name="reftable" id="reftable" type="text" size="12" value=""/>
                    
                    <img src="../img_news/transfert.gif" alt="" onclick="changetable()" width="24" height="24" /><div id="wait"></div></td>
	              </tr>
		          <tr>
		            <td align="center"></td>
	            </tr>
	            </table>
          </td>
          <td colspan="2" align="center" valign="top">Information personnelle<br />
            <br />
            <table width="100%" border="0">
            <tr>
             <td width="25%" align="left" valign="top" bgcolor="#D6D6D6"><strong>Matricule :</strong></td>
              <td width="25%" align="left" valign="top" bgcolor="#FFFFCC"><?php echo $etudiant['Matricule']; ?></td>
            </tr>
             <tr>
              <td align="left" valign="top" bgcolor="#D6D6D6"><strong>Num Volet :</strong></td>
              <td width="25%" align="left" valign="top" bgcolor="#FFFFCC"><?php echo "<input name='numident' id='numident' value=\"".$etudiant['NUMIDENT']."\">"; ?></td>
            </tr>
            <tr>
              <td align="left" valign="top" bgcolor="#D6D6D6"><strong>Nom :</strong></td>
              <td width="25%" align="left" valign="top" bgcolor="#FFFFCC"><?php echo "<input name='lenom' id='lenom' value=\"".$etudiant['NOM']."\">"; ?></td>
            </tr>
            <tr>
              <td align="left" valign="top" bgcolor="#D6D6D6"><strong>Pr&eacute;nom :</strong></td>
              <td width="25%" align="left" valign="top" bgcolor="#FFFFCC"><?php echo "<input name='leprenom' id='leprenom' size='35' value=\"".$etudiant['PRENOMS']."\">"; ?></td>
            </tr>
            <tr>
              <td align="left" valign="top" bgcolor="#D6D6D6"><strong>Date et lieu de naissance :</strong></td>
              <td width="25%" align="left" valign="top" bgcolor="#FFFFCC"><?php echo "<input name='ladate' id='ladate' value=\"".$etudiant['DATE_NAIS']."\">"." "."<input name='lelieu' id='lelieu' value=\"".$etudiant['LIEU_NAIS']."\">"; ?></td>
            </tr>
            <tr>
              <td align="left" valign="top" bgcolor="#D6D6D6"><strong>Nationalit&eacute; : </strong></td>
              <td align="left" valign="top" bgcolor="#FFFFCC">
			  <span class="nation"><?php 
			  	$libnation=selTableDataWhere("nationalites","COD_NATION",$etudiant['NATION_COD_NATION']);
			  	$libnation=$libnation['LIB_NATION'];
			  	echo $libnation; 
			  ?></span></td>
              </tr>
            </table>
            </td>
          <td width="19%" align="center" valign="top">
          <table width="100%" border="0">
          <tr>
          <td width="26%" rowspan="6" align="center" valign="middle"><?php if(isset($_POST['matricule'])){ ?>
                <input type="hidden" name="validematricule" id="validematricule"  value="<?php echo $_POST['matricule']; ?>"/>
                <input type="hidden" name="validenumfiche" id="validenumfiche" value="<?php echo $_POST['numfiche']; ?>"/>
				<input type="hidden" name="lannee" id="lannee" value="<?php echo $_POST['annee']; ?>"/>
                <br />
				<textarea name="inscrits" id="inscrits" readonly="readonly"></textarea>
                <br />
<label>
  <input name="button2" type="submit" class="style1" id="button2" value="VALIDER LE DOSSIER" />
            </label>
                <?php } ?></td>
                </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td align="center" valign="top" background="images/back_tableau.jpg">CONTROLE</td>
          <td width="21%" align="center"  background="images/back_tableau.jpg" valign="top">Inscription1</td>
          <td width="22%" align="center" valign="top"  background="images/back_tableau.jpg">Inscription2</td>
          <td align="center" valign="top" background="images/back_tableau.jpg">Resultat de l'ann&eacute;e en cours</td>
        </tr>
        <tr>
          <td align="center" valign="top">
            <table width="100%" border="0">
              <tr>
                <td colspan="2" align="left" valign="top"  bgcolor="#D6D6D6"><strong>Sanction :</strong></td>
                <td colspan="2" align="left" valign="top" bgcolor="#D6D6D6"><?php  
					mysql_select_db($database_connection, $connection);
					$query_speci1 = "SELECT * FROM sanction WHERE matricule='".$_POST['matricule']."'";
					$speci1 = mysql_query($query_speci1, $connection) or die(mysql_error());
					$row_speci1 = mysql_fetch_assoc($speci1);
					$nbautospecial = mysql_num_rows($speci1);
					if($nbautospecial>0){
						do{
							echo "<fieldset id='valide1' width='250px' style='background-color:#F63'>[".$row_speci1['motif']."]<br/>".$row_speci1['nom']." ".$row_speci1['prenoms']." <br/> [".$row_speci1['filiere']."] </fieldset>";
						}while($row_speci1 = mysql_fetch_assoc($speci1));
					}
				  ?></td>
              </tr>
              <tr>
                <td colspan="4" align="center" bgcolor="#FFFFFF" background="images/back_tableau.jpg">Autorisation</td>
              </tr>
              <tr>
                <td colspan="2"  bgcolor="#D6D6D6"><strong>Bachelier :</strong></td>
                <td colspan="2" bgcolor="#D6D6D6"><?php  
					mysql_select_db($database_connection, $connection);
					$query_speci1 = "SELECT * FROM code_autorisation, autorisations WHERE code_autorisation.COD_AUTO=autorisations.COD_AUTO AND NOM LIKE \"%".addslashes($etudiant['NOM'])."%\" AND autorisations.TYPE=0 AND ANNEE_AUTO='".$anneeEtude."'";
					$speci1 = mysql_query($query_speci1, $connection) or die(mysql_error());
					$row_speci1 = mysql_fetch_assoc($speci1);
					$nbautospecial = mysql_num_rows($speci1);
					if($nbautospecial>0){
						$z=0;
						$col="#A3CEFA";
						echo "<select>";
						do{
							if($z!=0){
								$z=0;
								$col="";
							}else{
								$z=1;
								$col="#A3CEFA";
							}
							echo "<option style=\"background-color:".$col."\">".$row_speci1['NOM']." ".$row_speci1['PRENOMS']." [".$row_speci1['COD_SPE']."] [".$row_speci1['STATUT']."] [".$row_speci1['COD_AUTO']."] "."</option>";
						}while($row_speci1 = mysql_fetch_assoc($speci1));
						echo "</select>";
					}
				  ?></td>
              </tr>
              <tr bgcolor="#F5EEC5">
                <td colspan="2"><strong>scolarit&eacute; :</strong></td>
                <td colspan="2"><?php  
					mysql_select_db($database_connection, $connection);
					$query_scol1 = "SELECT * FROM autorisations, code_autorisation WHERE code_autorisation.COD_AUTO=autorisations.COD_AUTO AND (NOM LIKE \"%".addslashes($etudiant['NOM'])."%\" OR MATRICULE='".$etudiant['Matricule']."') AND autorisations.TYPE=1 AND ANNEE_AUTO='".$anneeEtude."'";
					$scol1 = mysql_query($query_scol1, $connection) or die(mysql_error());
					$row_scol1 = mysql_fetch_assoc($scol1);
					$nbautoscol = mysql_num_rows($scol1);
					//print_r($row_scol1);
					if($nbautoscol>0){
						$z=0;
						$col="#A3CEFA";
						echo "<select>";
						do{
							if($z!=0){
								$z=0;
								$col="";
							}else{
								$z=1;
								$col="#A3CEFA";
							}
							echo "<option style=\"background-color:".$col."\">".utf8_decode($row_scol1['NOM'])." ".$row_scol1['PRENOMS']." [".$row_scol1['COD_SPE']."] [".$row_scol1['STATUT']."]  [".$row_scol1['COD_AUTO']."]"."</option>";
						}while($row_scol1 = mysql_fetch_assoc($scol1));
						echo "</select>";
					}
				  ?></td>
              </tr>
              <tr bgcolor="#CCCFFF">
                <td colspan="2"><strong>d&eacute;rogation:</strong></td>
                <td colspan="2"><?php  
					mysql_select_db($database_connection, $connection);
					$query_derog1 = "SELECT * FROM autorisations, code_autorisation WHERE  code_autorisation.COD_AUTO=autorisations.COD_AUTO AND Matricule='".$etudiant['Matricule']."' AND autorisations.TYPE=2 AND ANNEE_AUTO='".$anneeEtude."'";
					$derog1 = mysql_query($query_derog1, $connection) or die(mysql_error());
					$row_derog1 = mysql_fetch_assoc($derog1);
					$nbautoderog = mysql_num_rows($derog1);
					//print_r($row_scol1);
					if($nbautoderog>0){
						$z=0;
						$col="#A3CEFA";
						echo "<select>";
						do{
							if($z!=0){
								$z=0;
								$col="";
							}else{
								$z=1;
								$col="#A3CEFA";
							}
							echo "<option style=\"background-color:".$col."\">".$etudiant['NOM']." ".$etudiant['PRENOMS']." [".$row_derog1['COD_SPE']."] [".$row_derog1['STATUT']."] [".$row_derog1['COD_AUTO']."]"."</option>";
						}while($row_derog1 = mysql_fetch_assoc($derog1));
						echo "</select>";
					}
				  ?></td>
              </tr>
              <tr bgcolor="#F5EEC5">
                <td colspan="2"><strong>&eacute;quivalence :</strong></td>
                <td colspan="2"><?php  
					mysql_select_db($database_connection, $connection);
					$query_equiv1 = "SELECT * FROM autorisations, code_autorisation WHERE code_autorisation.COD_AUTO=autorisations.COD_AUTO AND (NOM LIKE \"".$etudiant['NOM']."%\" OR MATRICULE='".$etudiant['Matricule']."')  AND (TYPE='3' || TYPE='4') AND ANNEE_AUTO='".$anneeEtude."'";
					$equiv1 = mysql_query($query_equiv1, $connection) or die(mysql_error());
					$row_equiv1 = mysql_fetch_assoc($equiv1);
					$nbautoequiv = mysql_num_rows($equiv1);
					//print_r($row_scol1);
					if($nbautoequiv>0){
						$z=0;
						$col="#A3CEFA";
						echo "<select>";
						do{
							if($z!=0){
								$z=0;
								$col="";
							}else{
								$z=1;
								$col="#A3CEFA";
							}
							echo "<option style=\"background-color:".$col."\">".$row_equiv1['NOM']." ".$row_equiv1['PRENOMS']." [".$row_equiv1['COD_SPE']."] [".$row_equiv1['STATUT']."] [".$row_equiv1['ANNEE_AUTO']."] [".$row_equiv1['COD_AUTO']."]"."</option>";
						}while($row_equiv1 = mysql_fetch_assoc($equiv1));
						echo "</select>";
					}
				  ?></td>
              </tr>
              <tr bgcolor="#CCCFFF">
                <td colspan="2"><strong>Exon&eacute;ration :</strong></td>
                <td colspan="2"><?php  
					mysql_select_db($database_connection, $connection);
					$query_equiv1 = "SELECT * FROM exoneration WHERE (NOM LIKE '".addslashes($etudiant['NOM'])."%' OR MATRICULE='".$etudiant['Matricule']."') AND Annee='".substr($anneeEtude,-4)."'";
					$equiv1 = mysql_query($query_equiv1, $connection) or die(mysql_error());
					$row_equiv1 = mysql_fetch_assoc($equiv1);
					$nbautoequiv = mysql_num_rows($equiv1);
					//print_r($row_scol1);
					if($nbautoequiv>0){
						$z=0;
						$col="#A3CEFA";
						echo "<select>";
						do{
							if($z!=0){
								$z=0;
								$col="";
							}else{
								$z=1;
								$col="#A3CEFA";
							}
							echo "<option style=\"background-color:".$col."\">".$row_equiv1['NOM']." ".$row_equiv1['PRENOM']." [".$row_equiv1['FILIERE']."] [".$row_equiv1['MONTANT']."] [".$row_equiv1['ANNEE']."]"."</option>";
						}while($row_equiv1 = mysql_fetch_assoc($equiv1));
						echo "</select>";
					}
				  ?></td>
              </tr>
              <tr bgcolor="#F5EEC5">
                <td colspan="2"><strong>Refugie :</strong></td>
                <td colspan="2"><?php  
					mysql_select_db($database_connection, $connection);
					$query_equiv1 = "SELECT * FROM refugie WHERE (Nom LIKE \"".addslashes($etudiant['NOM'])."%\" OR MATRICULE='".$etudiant['Matricule']."') AND Annee='".substr($anneeEtude,-4)."'";
					$equiv1 = mysql_query($query_equiv1, $connection) or die(mysql_error());
					$row_equiv1 = mysql_fetch_assoc($equiv1);
					$nbautoequiv = mysql_num_rows($equiv1);
					//print_r($row_scol1);
					if($nbautoequiv>0){
						echo "<select>";
						do{
							echo "<option style=\"background-color:".$col."\">".$row_equiv1['Nom']." ".$row_equiv1['Prenoms']." [".$row_equiv1['Filiere']."] [".$row_equiv1['Annee']."]"."</option>";
						}while($row_equiv1 = mysql_fetch_assoc($equiv1));
						echo "</select>";
					}
				  ?></td>
              </tr>
            </table>
<table width="100%" border="0">
                <tr>
                  <td colspan="4" align="center" bgcolor="#FFFFFF" background="images/back_tableau.jpg">Inscription ant&eacute;rieure</td>
                </tr>
                <?php  
					mysql_select_db($database_connection, $connection);
					$query_insc1 = "SELECT * FROM inscrits WHERE Matricule='".$etudiant['Matricule']."' AND AN_COD_ANNEE != '".$_POST['annee']."' ORDER BY AN_COD_ANNEE DESC";
					$insc1 = mysql_query($query_insc1, $connection) or die(mysql_error());
					$row_insc1 = mysql_fetch_assoc($insc1);
					$nbautoinsc = mysql_num_rows($insc1);
					//print_r($row_scol1);
					$color='#C1D8F9';
					if($nbautoinsc>0){
						$c=0;
						do{
							  echo "<tr bgcolor='".$color."' align='left'>";
							  echo "<td>".$row_insc1['AN_COD_ANNEE']."</td>";
							  echo "<td>".$row_insc1['FIL_COD_FIL']."</td>";
							  echo "<td>".$row_insc1['STATUT']."    (".$row_insc1['MONTANT'].")   </td>";
							  echo "<td>";
								mysql_select_db($database_connection, $connection);
								$query_resul1 = "SELECT * FROM resultatunivers WHERE Matricule='".$etudiant['Matricule']."' AND AN_COD_ANNEE='".$row_insc1['AN_COD_ANNEE']."' AND Filiere='".$row_insc1['FIL_COD_FIL']."'";
								$resul1 = mysql_query($query_resul1, $connection) or die(mysql_error());
								$row_resul1 = mysql_fetch_assoc($resul1);
								$nbautoresul = mysql_num_rows($resul1);
								//print_r($row_scol1);
								if($nbautoresul>0){
									 echo "<center>--- ".$row_resul1['Resultat2']." ---</center>";
								}else{
									echo "<center>----</center>";	
								}
							  
							  echo "</td>";
							  echo "</tr>";
							  	if($c==0){
									$color='#F5EEC5';
									$c=1;
								}else{
									$color='#C1D8F9';
									$c=0;
								}
						}while($row_insc1 = mysql_fetch_assoc($insc1));
						
					}
				  ?>
              </table>
          </td>
          <td align="center" valign="top">
           <?php 
		   		if(isset($inscrit2009[0]['AN_COD_ANNEE'])){ 
			   		/// CONTROLE DE LA POSSIBILITE DE VALIDE L'INSCRIPTION
					$query_resul4 = "SELECT * FROM lieurendezvous WHERE etablissement LIKE '%".$inscrit2009[0]['COD_ETBS']."%'";
					$resul4 = mysql_query($query_resul4, $connection) or die(mysql_error());
					$row_resul4 = mysql_fetch_assoc($resul4);
					$a=0;
					for($z=0;$z<count($_SESSION['etablissement']);$z++){
						if($_SESSION['etablissement'][$z]!='0' && $_SESSION['etablissement'][$z]!='101' && $_SESSION['etablissement'][$z]!='102' && $_SESSION['etablissement'][$z]!='100' && $inscrit2009[0]['COD_ETBS']!=$_SESSION['etablissement'][$z]){
							if($b!=0){
								$b=1;
							}
						}else{
							$b=0;	
						}
					}
			   ?>
               <div id="insc1">
                <table width="100%" border="0">
                  <tr>
                    <td colspan="2" align="center" bgcolor="#99CCFF"><?php  
                    if(isset($inscrit2009[0]['AN_COD_ANNEE'])){
						$etab1=selTableDataWhere("etablissements","COD_ETBS",$inscrit2009[0]['COD_ETBS']);
						echo $etab1['LIB_ETBS']."<br/><hr/>";
                        echo "<b>".$inscrit2009[0]['FIL_COD_FIL']."   (".$inscrit2009[0]['numfiche']." ) (".$inscrit2009[0]['MONTANT'].")</b>";	
                    }
                ?>
                  <input type="hidden"  id="sup" name="sup" value="<?php echo $inscrit2009[0]['FIL_COD_FIL']; ?>"/>
                </td>
                  </tr>
                  <tr>
                    <td width="50%" align="center" bgcolor="#CC9999">
                    <?php  if($inscrit2009[0]['CONTROLE']!='OUI'){ ?>
                    <img onclick="if(confirm('Voulez vous vraiment supprimer cette inscription')){supr('<?php echo $inscrit2009[0]['FIL_COD_FIL'];  ?>','<?php echo $inscrit2009[0]['MATRICULE'];  ?>','insc1','<?php echo $_POST['annee'];  ?>');}" src="../img_news/supprimer.jpg" alt="" width="24" height="24" />
                    <?php 
                    }
                    ?>
                    </td>
                    <td width="50%" align="center" bgcolor="#CCCC66">
                    <?php 
                    if($a==1){
                            echo "Inscription &agrave; valider &agrave; : ".$row_resul4['lieu'];
                        }else{
                    if($inscrit2009[0]['CONTROLE']=='OUI'){ echo "- inscription d&eacute;j&agrave; valid&eacute;e par : ".$inscrit2009[0]['user_valid']; }else{ ?>
                    <img onclick="validation('<?php echo $inscrit2009[0]['FIL_COD_FIL']; ?>');" src="../img_news/valide.gif" alt="" width="24" height="24" />
                    <?php  }
					if($inscrit2009[0]['usercardedit']!=""){ echo "<br/>- Carte d&eacute;j&agrave; imprim&eacute;e "; }
						}
                    ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" bgcolor="#FFFF66">
                    <?php if($_SESSION['login']=='julie' || $_SESSION['login']=='admin' || $_SESSION['login']=='Elvire' || $_SESSION['login']=='tossou' || $_SESSION['login']=='Marie' || $_SESSION['login']=='octavie'){ ?>
                    <a href="interface.php?matricule=<?php echo $inscrit2009[0]['MATRICULE']; ?>&filiere=<?php echo $inscrit2009[0]['FIL_COD_FIL']; ?>&annee=<?php echo $inscrit2009[0]['AN_COD_ANNEE']; ?>&fiche"><b>Débloquer validation</b></a>
                    <a href="interface.php?matricule=<?php echo $inscrit2009[0]['MATRICULE']; ?>&filiere=<?php echo $inscrit2009[0]['FIL_COD_FIL']; ?>&annee=<?php echo $inscrit2009[0]['AN_COD_ANNEE']; ?>&carte"><b>Débloquer carte</b></a>
                    <?php } ?>
                    </td>
                  </tr>
                </table>
        </div>
				<?php } ?>
          </td>
          <td align="center" valign="top">
           <?php 
		   if(isset($inscrit2009[1]['AN_COD_ANNEE'])){ 
			 // echo $_SESSION['etablissement'];
				  	$query_resul4 = "SELECT * FROM lieurendezvous WHERE etablissement LIKE '%".$inscrit2009[1]['COD_ETBS']."%'";
					$resul4 = mysql_query($query_resul4, $connection) or die(mysql_error());
					$row_resul4 = mysql_fetch_assoc($resul4);
					$liste=explode(",",$row_resul4['etablissement']);
					$b=1;
					for($z=0;$z<count($_SESSION['etablissement']);$z++){
						if($_SESSION['etablissement'][$z]!='0' && $_SESSION['etablissement'][$z]!='101' && $_SESSION['etablissement'][$z]!='102' && $_SESSION['etablissement'][$z]!='100' && $inscrit2009[1]['COD_ETBS']!=$_SESSION['etablissement'][$z]){
							if($b!=0){
								$b=1;
							}
						}else{
							$b=0;	
						}
					}
			  ?>
  <div id="insc2">
              <table width="100%" border="0">
	<tr>
		<td colspan="2" align="center" bgcolor="#99CCFF"><?php 
		if(isset($inscrit2009[1]['AN_COD_ANNEE'])){
			$etab2=selTableDataWhere("etablissements","COD_ETBS",$inscrit2009[1]['COD_ETBS']);
			echo $etab2['LIB_ETBS']."<br/><hr/>";
			echo "<b>".$inscrit2009[1]['FIL_COD_FIL']."   (".$inscrit2009[1]['numfiche']." ) (".$inscrit2009[1]['MONTANT'].")</b>";	
		}
	?>
			<input type="hidden"  id="sup" name="sup" value="<?php echo $inscrit2009[1]['FIL_COD_FIL']; ?>"/>
		</td>
	</tr>
	<tr>
		<td width="51%" align="center" bgcolor="#CC9999">
		<?php  if($inscrit2009[1]['CONTROLE']!='OUI'){ ?>
		<img onclick="if(confirm('Voulez vous vraiment supprimer cette inscription')){supr('<?php echo $inscrit2009[1]['FIL_COD_FIL'];  ?>','<?php echo $inscrit2009[1]['MATRICULE']; ?>','insc2','<?php echo $_POST['annee'];  ?>');}" src="../img_news/supprimer.jpg" alt="" width="24" height="24" />
		<?php  } ?>
		</td>
		<td width="49%" align="center" bgcolor="#CCCC66">
		<?php 
		 if($b==1){
			echo "Inscription &agrave; valider &agrave; : ".$row_resul4['lieu'];
		}else{
		if($inscrit2009[1]['CONTROLE']=='OUI'){ echo "- inscription d&eacute;j&agrave; valid&eacute;e par : ".$inscrit2009[1]['user_valid']; }else{ ?>
		<img onclick="validation('<?php echo $inscrit2009[1]['FIL_COD_FIL']; ?>');" src="../img_news/valide.gif" alt="" width="24" height="24" />
		<?php  } 
		if($inscrit2009[1]['usercardedit']!=""){ echo "<br/>- Carte d&eacute;j&agrave; imprim&eacute;e "; }
		}
		?>
		</td>
	</tr>
	<tr>
	  <td colspan="2" align="center" bgcolor="#FFFF66"><?php if($_SESSION['login']=='julie' || $_SESSION['login']=='admin' || $_SESSION['login']=='tossou' || $_SESSION['login']=='Elvire' || $_SESSION['login']=='Marie' || $_SESSION['login']=='octavie'){ ?>
                    <a href="interface.php?matricule=<?php echo $inscrit2009[1]['MATRICULE']; ?>&filiere=<?php echo $inscrit2009[1]['FIL_COD_FIL']; ?>&annee=<?php echo $inscrit2009[1]['AN_COD_ANNEE']; ?>&fiche"><b>Débloquer validation</b></a>
                    <a href="interface.php?matricule=<?php echo $inscrit2009[1]['MATRICULE']; ?>&filiere=<?php echo $inscrit2009[1]['FIL_COD_FIL']; ?>&annee=<?php echo $inscrit2009[1]['AN_COD_ANNEE']; ?>&carte"><b>Débloquer carte</b></a>
                    <?php } ?></td>
	  </tr>
              </table>
            </div>
            <?php  } ?>
          </td>
          <td align="center" valign="top">
          <?php
				if(count($resultat)>0){

					for($i=0;$i<count($resultat);$i++){
	//				foreach($resultat as $resultats){
						if($resultat[$i]['AN_COD_ANNEE']=='2011-2012'){
							echo "<b>-".$resultat[$i]['Matricule']." --> ".$resultat[$i]['Filiere']." --> ".$resultat[$i]['Resultat2']."<b><br/>";  
						}
					}
				}else{
						echo "<b>Pas de resultats</b>";	
				}	
			  ?>
          </td>
        </tr>
           </table>
    </form>
    <?php }else{ if(!isset($_POST['validematricule']) && isset($_POST['matricule'])){ ?>
	<img src='images/stop.jpg' height='24px' width='24px'><br/><fieldset id="valide1" style="background-color:#FC3"><center>
		AUCUN ETUDIANT NE PORTE LE NUMERO : <?php echo $_POST['matricule']; ?>
	</center></fieldset>
	<?php 
	}else{
		echo "<center>".$mess."</center>";
	}} 
	?>
    </td>
        </tr>
          </table>
          </form>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td background="images/gradient-bar.jpg"><?php include('../foot.php'); ?></td>
  </tr>
</table>
</body>
</html>
