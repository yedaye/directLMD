<?php
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");
	include_once ("../param.php");

	
if(isset($_GET['nom'])){
	//print_r($_GET);
	//exit;
	$array_field=array('nom','prenoms','date_naissance','lieu_naissance','email_uak');
	$array_value=array(addslashes($_GET['nom']),addslashes($_GET['prenoms']),$_GET['date_nais'],addslashes($_GET['lieu_naissance']),addslashes($_GET['email']));
	updTable('student',$array_field,$array_value,'matricule',$_GET['matricule2'],$pdo);
	//exit;
	echo "<script language='Javascript'>
		document.location.replace('accueil.php?validation&matricule=".$_GET['matricule2']."&annee=".$_GET['annee2']."');
		</script>";
		
}

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
					window.location=document.URL+"?validation&matricule="+matricule+"&annee="+annee_etude;
				}
			});  
		}
		if(type=='rejet'){
			motif=document.getElementById('motif').value;
			$.post('../js/xphp/valide_inscrit.php',{letype:type,lematricule:matricule,lafiliere:filiere,lannee:annee_etude,lemotif:motif},function(data){  
				if(data==1){
					alert('opération effectuée');
					$('#spinner').hide();
					window.location=document.URL+"?validation&matricule="+matricule+"&annee="+annee_etude;
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
				window.location=document.URL+"?validation&matricule="+matricule+"&annee="+annee_etude;
			}
		});    	
	}
	function ajout_email(email){
		document.getElementById('email').value=email;
	}
</script>
</head>
<body>
<p class="panel-title" align="center">GESTION DES VALIDATIONS</p><br /><br />
<form action="?validation" method="get">
<table width="81%" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td width="20%" align="right" bgcolor="#FFFF99">Matricule :</td>
    <td width="23%" bgcolor="#FFFF99"><input name="matricule" type="text" size="30" value="<?php if(isset($_GET['matricule'])){ echo $_GET['matricule']; } ?>" /></td>
    <td width="18%" align="right" bgcolor="#FFFF99">Annee Academique ::</td>
    <td width="26%" bgcolor="#FFFF99"><select required="true" name="annee" id="annee">
      <?php
			$ufr=selTableDataDesc("annee_academique","lib_annee", $pdo);
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['lib_annee']."'>".strtoupper($ufr[$i]['lib_annee'])."</option>";
				}	
			?>
    </select><input name="validation" type="hidden" value=""/></td>
    <td width="13%" bgcolor="#FFFF99"><input name="controler" type="submit" value="controler" /></td>
    </tr>
</table>
</form><br />
<?php  if(isset($_GET['matricule'])){ 
$montant=0; 
$etudiant=selTableDataWhere("student","matricule",$_GET['matricule'], $pdo);
//print_r($etudiant);
$inscription=selTableMultiAnswer("inscription","matricule",$_GET['matricule'], $pdo);
if(count($inscription)>0){
	$etab=selTableDataWhere('filiere','code',$inscription[0]['filiere'], $pdo);
}
	if(in_array("uak",$_SESSION['etablissement']) || in_array($etab['ecole'],$_SESSION['etablissement'])){
?>
<hr />
<br />
<div align="center" id="spinner" style="display:none"><img src="../img/global_spinner.gif" /></div>
<form id="form1" name="form1" method="GET" action="" enctype="multipart/form-data"><input name="validation" type="hidden" value=""/>
  <table width="100%" border="0" cellpadding="0" cellspacing="2" class="datagrid-body" style='font-size:18px'>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
      <td width="26%">&nbsp;</td>
      <td width="17%">&nbsp;</td>
      <td width="27%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><?php
	  	if(file_exists("photo/".trim($_GET['matricule']).".jpg")){
		?>
        	<img src="<?php echo "photo/".trim($_GET['matricule']).".jpg"; ?>" alt="" name="photo" width="220" height="187" id="photo" />
        <?php
	   	}else{
		?>
        	<img src="<?php echo "photo/2013/".$etudiant['num_table']."_2013.jpg"; ?>" alt="" name="photo" width="220" height="187" id="photo" />
        <?php	
		}
	  ?>
	</td>
      <td colspan="3" align="center" valign="middle" bgcolor="#CCCCC"><p>INFORMATION PERSONNELLE</p>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td width="27%" bgcolor="#CCFFCC" class="texte"><strong class="texte_grand">Matricule</strong></td>
          <td colspan="2" bgcolor="#CCFFCC"><?php echo "<b>".$etudiant['matricule']."</b>"; ?><input name="matricule2" type="hidden" value="<?php echo $etudiant['matricule']; ?>" /></td>
        </tr>
        <tr>
          <td bgcolor="#CCFFCC" class="texte"><strong class="texte_grand">Nom :</strong></td>
          <td colspan="2" bgcolor="#CCFFCC"><label for="nom"></label>
            <input name="nom" type="text" id="nom" value="<?php echo $etudiant['nom']; ?>" size="45" /></td>
        </tr>
        <tr>
          <td bgcolor="#CCFFCC" class="texte"><strong class="texte_grand">Prénoms :</strong></td>
          <td colspan="2" bgcolor="#CCFFCC"><label for="prenoms"></label>
            <input name="prenoms" type="text" id="prenoms" value="<?php echo $etudiant['prenoms']; ?>" size="45"/></td>
        </tr>
        <tr>
          <td bgcolor="#CCFFCC" class="texte"><strong class="texte_grand">Date et lieu de naissance:</strong></td>
          <td colspan="2" bgcolor="#CCFFCC"><label for="date_nais"></label>
						<input name="date_nais" type="text" id="date_nais" value="<?php
						//correction date de naissance
							if(strpos($etudiant['date_naissance'],"/") > 0){
								$date=str_replace("/","-",$etudiant['date_naissance']);
							}else{
								//$date=$row['date_naissance'];
								$dates=explode("-",$etudiant['date_naissance']);
								$date=$dates[2]."-".$dates[1]."-".$dates[0];
							}
						 echo $date; ?>" size="30"/>
            <label for="lieu_naissance"></label>
            <input name="lieu_naissance" type="text" id="lieu_naissance" value="<?php echo $etudiant['lieu_naissance']; ?>" size="30"/></td>
        </tr>
        <tr>
          <td bgcolor="#CCFFCC" class="texte"><strong class="texte_grand">Nationalité :</strong></td>
          <td colspan="2" bgcolor="#CCFFCC" style="font-size:14px; color:#F00"><b><?php 
		  $nation=selTableDataWhere("pays","cod_pays",$etudiant['Nationalite'], $pdo);
		  echo $nation['lib_nation']; ?></b></td>
        </tr>
         <tr>
          <td bgcolor="#CCFFCC" class="texte"><strong class="texte_grand">Email UNA :</strong></td>
          <td width="75%" align="center" valign="middle" bgcolor="#CCFFCC" style="font-size:14px; color:#F00"><b>
            <input name="email" type="text" id="email" value="<?php echo utf8_encode(strtolower($etudiant['email_uak'])); ?>" size="10"/>
@unabenin.bj</b></td>
          <td width="25%" bgcolor="#CCFFCC" style="font-size:14px; color:#F00"><b><b><b><img src="../img/email.png" title="appuyer ici pour mettre à jour l'email" width="48" height="48" onclick="ajout_email('<?php echo strtolower(substr($etudiant['nom'],0,2).substr($etudiant['prenoms'],0,2).substr($etudiant['lieu_naissance'],0,2)); ?>')" /></b></b></b></td>
         </tr>
        <tr>
          <td bgcolor="#CCFFCC" class="texte">&nbsp;</td>
          <td colspan="2" bgcolor="#CCFFCC"><label>
					<input name="annee2" type="hidden" id="annee2" value="<?php echo $_GET['annee']; ?>"/>
						<input type="submit" name="modifier" id="modifier" value="Modifier" />
          </label></td>
        </tr>
      </table></td>
    </tr>
       <tr>
      <td colspan="2" align="center" bgcolor="#D6D6D6">
		<a href="accueil.php?photo&matricule3=<?php echo $etudiant['matricule']; ?>&num_table=<?php echo $etudiant['num_table'];  ?>">CHANGER LA PHOTO DE L'ETUDIANT</a>
      </label></td>
    
      <?php 
	  		for($i=0;$i<count($inscription);$i++){
				if($inscription[$i]['annee_academique']==$_GET['annee']){		
					?>
                      <td align="center">
      <input type="button" name="annule_ins" id="annule_ins" onclick="if(confirm('Voulez vous vraiment annuler cette inscription')){supprime('inscription','<?php echo $inscription[$i]['matricule']; ?>','<?php echo $inscription[$i]['filiere']; ?>','<?php echo $inscription[$i]['annee_academique']; ?>')}" value="Annuler l'inscription" /></td>
					<?php
					if($inscription[$i]['controle']=='oui' && in_array("uak",$_SESSION['etablissement'])){
						?>
                           <td align="center"><input type="button"  onclick="if(confirm('Voulez vous vraiment annuler la validation')){supprime('validation','<?php echo $inscription[$i]['matricule']; ?>','<?php echo $inscription[$i]['filiere']; ?>','<?php echo $inscription[$i]['annee_academique']; ?>')}" name="annule_ins2" id="annule_ins2" value="Annuler la validation" /></td>   
						<?php
					}else{
						echo "<td></td>";	
					}
					if($inscription[$i]['validation_final']!='' && in_array("uak",$_SESSION['etablissement'])){
						
						?>
                           <td align="center"><input type="button"  onclick="if(confirm('Voulez vous vraiment annuler la validation finale')){supprime('validation_finale','<?php echo $inscription[$i]['matricule']; ?>','<?php echo $inscription[$i]['filiere']; ?>','<?php echo $inscription[$i]['annee_academique']; ?>')}" name="annule_ins2" id="annule_ins2" value="Annuler la validation finale" /></td>   
						<?php
					}else{
						echo "<td></td>";	
					}
				}
			}			
	  ?>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="2" class="texte_grand">
        <tr>
          <td align="center" bgcolor="#CCCCC">AUTORISATION</td>
        </tr>
        <?php 
			if($etudiant['session']=='2013'){
				$auto=selTableData2Fields("autorisation","num_bac",$etudiant['num_table'],"annee_auto",$anneeEtude, $pdo);
			}else{
				$auto=selTableData2Fields("autorisation","matricule",$etudiant['matricule'],"annee_auto",$anneeEtude, $pdo);
				//print_r($auto);
			}
			if(count($auto)>0){
				//for($i=0;$i<count($auto);$i++){
		?>
                <tr>
                  <td bgcolor="#FFCCCC">
					<?php echo "[".$auto['code_auto']."]".utf8_encode($auto['nom'])." ".utf8_encode($auto['prenoms'])." [".$auto['filiere']."][".$auto['mode']."]"; ?>      
                  </td>
                </tr>		
		 <?php
				//}
			}else{
		?>
        		<tr>
                    <td bgcolor="#FFCCCC">
						AUCUNE AUTORISATION
                    </td>
                </tr>
        <?php			
			}
		 ?>
         <tr>
          <td bgcolor="">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" bgcolor="#CCCCC">AUTRES INSCRIPTIONS</td>
        </tr>
       	<?php
		for($i=0;$i<count($inscription);$i++){
			if($inscription[$i]['annee_academique']!=$_GET['annee']){
				$verdict=selTableData2Fields('verdict','matricule',$inscription[$i]['matricule'],'annee_academique',$inscription[$i]['annee_academique'], $pdo);
				if(count($verdict)>0){
					//$verdict=$verdict[0];
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
      <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="2" class="texte_grand">
        <tr>
          <td colspan="2" align="center" bgcolor="#CCCCC">INSCRIPTION DE L'ANNEE :<?php echo $_GET['annee']; ?> </td>
          </tr>
        <?php
			for($i=0;$i<count($inscription);$i++){
				$a=0;
				if($inscription[$i]['annee_academique']==$_GET['annee']){		
				$a++;
		?>
        <tr>
          <td colspan="2" align="center" bgcolor="#FFFFCC"><br />
            <?php 
				$ecole=selTableDataWhere("filiere","code",$inscription[$i]['filiere'], $pdo);
				$ecole=selTableDataWhere("ecole_ufr","code_ecole",$ecole['ecole'], $pdo);
				echo $ecole['lib_ecole']; 
			?>
            </td>
          </tr>
        <tr>
          <td colspan="2" align="center" bgcolor="#EAFAD1"><br />
            <?php 
				$montant=round($inscription[$i]['FF']+$inscription[$i]['FI']);
				echo $inscription[$i]['filiere']." (".$inscription[$i]['statut'].")<hr/><p  class='totat'>MONTANT : ".$montant."</p>"; 
			?>
            </td>
          </tr>
        <tr>
          <td colspan="2" align="center" bgcolor="">
          <?php
				$ecu=selTableData2Fields("reprise_ecu","matricule",$etudiant['matricule'],"annee_academique",$_GET['annee'], $pdo);
				//print_r($ecu);
				//echo count($ecu);
				if(count($ecu)>0){
		  	?>
             <table bordercolor="#CCCCCC" width="99%" border="1" cellspacing="0">
                 <tr>
                   <td bgcolor="#E7E7E7">Intitulé</td>
                   <td bgcolor="#E7E7E7">Crédit</td>
                   <td bgcolor="#E7E7E7">Montant (FCFA)</td>
                 </tr>
                 <?php 
                 $tot=0;
								if(isset($ecu[0])){		
								 foreach($ecu as $ecu1){

                  ?>
                 <tr >
                   <td><?php 
                  
									$lib=selTableData2Fields("table_ecu_new","code_ecu",$ecu1['code_ecu'],'promotion',$etudiant['promotion'], $pdo);
									
									echo utf8_encode(strtoupper($lib['designation']))." (".$ecu1['code_ecu'].")";
                    ?></td>
                   <td><?php echo $lib['credit']; ?></td>
                   <td><?php 
                   $tot=$tot+round(7000*$lib['credit']);
                   echo round(7000*$lib['credit']); ?></td>
                 </tr>
                 <?php 
								 }
								}else{
									?>
									<tr >
										<td><?php 
									 
									 $lib=selTableData2Fields("table_ecu_new","code_ecu",$ecu['code_ecu'],'promotion',$etudiant['promotion'], $pdo);
									 //print_r($lib);
									 //$lib=$lib[0];
									 //echo ">";
									 
									 echo strtoupper($lib['designation'])." (".$ecu['code_ecu'].")";
										 ?></td>
										<td><?php echo $lib['credit']; ?></td>
										<td><?php 
										$tot=$tot+round(7000*$lib['credit']);
										echo round(7000*$lib['credit']); ?></td>
									</tr>
									<?php
								}
                  ?>
                 <tr class="totat">
                   <td>TOTAL</td>
                   <td>&nbsp;</td>
                   <td><?php echo $tot; ?></td>
                 </tr>
               </table><br/>
               <table bordercolor="#CCCCCC" width="99%" border="1" cellspacing="0">
                 <tr class="totat">
                    <td>TOTAL A PAYER : FI+FF+Reprise </td>
                    <td colspan="2" align="center"> <?php echo $tot+$montant; ?> FCFA</td>
                 </tr>
               </table>
            <?php
			}
		  ?>
          </td>
        </tr>
		<tr><td colspan='2' bgcolor="#00A3D9">
			<?php
				$nomfichier=$inscription[$i]['matricule']."_".$inscription[$i]['annee_academique']."_".$inscription[$i]['filiere']."_inscription.xml";
				//echo $nomfichier;
				if (file_exists('../DOWNLOAD/'.$nomfichier)) {
					$banque = simplexml_load_file('../DOWNLOAD/'.$nomfichier);
					echo "Paiement fait le : ".$banque->datePaiement." | Ref Transaction : ".$banque->reftransaction." | Intermédiaire paiement : ".$banque->intermediairePaiement;
				} else {
					echo 'Fichier xml inexistant, paiement non fait ou ancienne inscription';
				}
			?>		
		</td></tr>
        <tr>
          <td width="50%" bgcolor="#FAAFCC" align="center"><?php if($inscription[$i]['controle']=='non'){ ?><img onclick="valide('valide','<?php echo $inscription[$i]['matricule'] ?>','<?php echo $inscription[$i]['filiere'] ?>','<?php echo $inscription[$i]['annee_academique'] ?>')" src="../img/valide.png" height="24" width="24" /><?php }else{ echo "Dossier validé par ".$inscription[$i]['utilisateur']." le ".convertdateanglais($inscription[$i]['date_validation'])."<br><img src='../img/cancel.png' width='25' height='25'/>"; } ?></td>
          <td width="50%" bgcolor="#CCCFCC" align="center"><?php 
		  if($inscription[$i]['controle']=='oui'){
			  if($inscription[$i]['carte_imprime']=='non' || $inscription[$i]['carte_imprime']==''){ ?><a href="<?php  echo "carte_pdf.php?matricule=".$inscription[$i]['matricule']."&annee=".$_GET['annee']; ?>" target="_blank"><img src="../img/imprimante.png" height="24" width="24" /></a><?php }else{ echo "Carte déja imprimée par ".$inscription[$i]['carte_user']."<br><img src='../img/cancel.png' width='25' height='25'/>"; 
			  }
		  }
		  ?>
          </td>
          </tr>
        <?php
		if(in_array("uak",$_SESSION['etablissement']) && $inscription[$i]['carte_imprime']=='oui' && $inscription[$i]['controle']=='oui'){
		?>
        <tr>
          <td align="center" bgcolor="#99CCCC">
          <?php 
		   if($inscription[$i]['validation_final']==''){
		  ?>
          Classer le dossier<br />          
            <img src="../img/classeur.png" width="48" height="48" onclick="valide('valide_final','<?php echo $inscription[$i]['matricule'] ?>','<?php echo $inscription[$i]['filiere'] ?>','<?php echo $inscription[$i]['annee_academique'] ?>');"/><br />
           <?php 
								$val=1;
								$query_lotl="SELECT count( * ) as Nbre , lot FROM `inscription` WHERE filiere = \"".$inscription[$i]['filiere']."\" AND annee_academique = \"".$_GET['annee']."\" AND lot IS NOT NULL GROUP BY lot ORDER BY lot DESC";
								//echo $query_lotl;
								$stm = $pdo->query($query_lotl);
								$tot = $stm->rowcount();
								$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
								//echo $tot;
								echo "<select name='lot1' id='lot1'>";
								$o=0;
								$select1="";
								$tota10=0;
								$val=0;
								
								
								if($tot==0){
									echo "<option value='1'> Cr&eacute;er le premier lot </option>";
								}else{
									foreach($rows as $row_lot1) {
										if($inscription[$i]['lot']!='' && $row_lot1['lot']==$inscription[$i]['lot']) $select1="selected";
											echo "<option value='".$row_lot1['lot']."' ".$select1.">LOT ".$row_lot1['lot']." (".$row_lot1['Nbre'].") </option>";
											$o++;
											$select1="";
											$val1=$row_lot1['lot'];
									};
								}
									
								if($tot>0){
									echo "<option value='".round($val1+1)."' style=\"background:#FC0\"> Lot Suivant -->  </option>";
								}
								echo "</select>";
								
		   	}else{
				if($inscription[$i]['validation_final']=='oui'){
					echo "Dossier déja validé par ".$inscription[$i]['user_valide_final']." le ".$inscription[$i]['date_validation_final']." et se trouve dans le lot :".$inscription[$i]['lot'];
				}
			}
						?>   
          </td>
          <td align="center" bgcolor="#99CCCC">
          <?php
			  if($inscription[$i]['validation_final']=='non'){
					echo "Dossier rejeté par ".$inscription[$i]['user_valide_final']." le ".$inscription[$i]['date_validation_final']." et le motif est  :".$inscription[$i]['motif_rejet'];
				}else{
					if($inscription[$i]['validation_final']==''){
		  ?>
          <label>
            Rejeter le dossier<br />
            <textarea name="motif" id="motif" cols="45" rows="5"></textarea>
            <br />
            <img src="../img/stop.png" width="48" height="48"  onclick="if(confirm('Voulez vous rejeter ce dossier')){valide('rejet','<?php echo $inscription[$i]['matricule'] ?>','<?php echo $inscription[$i]['filiere'] ?>','<?php echo $inscription[$i]['annee_academique'] ?>');}" /></label>
            <?php
					}
				}
			?>
            </td>
          </tr>
        <?php	
		}
				}
			}
		?>
        
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php }else{
	echo "<div style='font-size:18px' align='center'><img src='../img/stop.png'/><br/>Cet etudiant est de ".$etab['ecole'].", vous n'êtes pas autorisé à suivre son cursus</div>";	
}
}
?>
</body>
</html>