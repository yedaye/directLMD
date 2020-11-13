<?php
//session_start();
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");
if (is_file("../param.php"))
	include_once ("../param.php");
	
if(isset($_SESSION['droit']) && $_SESSION['droit']=='0'){
	echo "<script language='Javascript'>
		<!--
		document.location.replace('accueil.php');
		// -->
		</script>";
}

$err_msg="";
$msg_ajout="";
$msg_modif="";
$msg_dja="";

//// requete pour la liste
$where="";
if(isset($_POST['matricule']) && $_POST['matricule']!=""){
	$where.=" AND matricule='".$_POST['matricule']."'";	
}
if(isset($_POST['statut']) && $_POST['statut']!=""){
	$where.=" AND statut='".$_POST['statut']."'";	
}
if(isset($_POST['etab']) && $_POST['etab']!=""){
	if($_POST['etab']=='CAG'){
		$wheresec.=" AND (filiere.code LIKE 'LP1,2-%' OR filiere.code LIKE 'LP3,4-%')";
	}elseif($_POST['etab']=='ED'){
		$wheresec.=" AND (filiere.code LIKE '%-ED')";
	}else{
		$wheresec.=" AND filiere.ecole ='".$_POST['etab']."'";
	}
}
// ajout du controle de l'établissement
//print_r($_SESSION['etablissement']);
if(isset($_SESSION['etablissement']) && !isset($_POST['etab'])){
	if(!in_array('uak',$_SESSION['etablissement']) && !in_array('aucun',$_SESSION['etablissement'])){
			$where.=" AND (";
			for($i=0;$i<count($_SESSION['etablissement']);$i++){
				if($_SESSION['etablissement'][$i]!='uak' && $_SESSION['etablissement'][$i]!='aucun'){
					$where.="filiere.ecole='".$_SESSION['etablissement'][$i]."'";	
				}
				if(count($_SESSION['etablissement'])>0){
					$where.=" OR ";	
				}
			}
			$where=substr($where,0,-4);
			if(count($_SESSION['etablissement'])>0){
				$where.=") ";	
			}
	}
}
//echo $where;
//filtrage par validation
if(isset($_POST['valide']) && $_POST['valide']!=""){
	$where.=" AND controle='".$_POST['valide']."'";	
};
//filtrage par la filiere
if(isset($_POST['filiere']) && $_POST['filiere']!=""){
	$where.=" AND filiere='".$_POST['filiere']."'";	
};
//initialisation et filtrage par lannee academique
$anne=$anneeEtude;
if(isset($_POST['annee'])){
	$anne=$_POST['annee'];
};
//initialisation de an precedent
$query_anp = "SELECT * FROM annee_academique WHERE lib_annee='".$anne."'";
$anp = $pdo->query($query_anp);
$row_anp = $anp->fetchAll(PDO::FETCH_ASSOC);
//print_r($row_anp);
$row_anp=$row_anp[0]['an_precedent'];
//echo $row_anp;


//filtrage par l'etablissement
$wheresec="";
if((isset($_POST['etab'])) && ($_POST['etab']!="")){
	if($_POST['etab']=='CAG'){
		$wheresec.=" AND (filiere.code LIKE 'LP1,2-%' OR filiere.code LIKE 'LP3,4-%')";
	}elseif($_POST['etab']=='ED'){
		$wheresec.=" AND (filiere.code LIKE '%-ED')";
	}else{
		$wheresec.=" AND filiere.ecole ='".$_POST['etab']."'";
	}
}


$query_inscrits = "SELECT nom, prenoms, telephone, sexe, Nationalite, date_naissance, lieu_naissance, email_uak, statut, date_inscription, FF, FI, student.matricule, filiere, annee_academique, ecole, controle, code, montant_reprise FROM inscription,filiere,student WHERE student.matricule=inscription.matricule AND filiere.code=inscription.filiere AND annee_academique = '".$anne."'".$where." ".$wheresec." ORDER BY date_inscription DESC LIMIT 500";
//echo $query_inscrits;

$_SESSION['requete']=$query_inscrits;
$inscrits = $pdo->query($query_inscrits);
$totalRows_inscrits = $inscrits->rowcount();
$row_inscritss = $inscrits->fetchAll(PDO::FETCH_ASSOC);
//foreach($rows as $element) {


///// requete pour remplir le champ etablissement
$query_etab = "SELECT * FROM ecole_ufr ORDER BY lib_ecole ASC";
$etab = $pdo->query($query_etab);
$row_etabs = $etab->fetchAll(PDO::FETCH_ASSOC);


//requete pour les filieres
$query_filiere = "SELECT * FROM `filiere` WHERE 1".$wheresec." ORDER BY code ASC";
//echo $query_filiere;
$filiere = $pdo->query($query_filiere);
$row_filieres = $filiere->fetchAll(PDO::FETCH_ASSOC);

//requete pour le statut
$query_statut = "SELECT * FROM mode WHERE actif=1 ORDER BY code ASC";
$statut = $pdo->query($query_statut);
$row_statuts = $statut->fetchAll(PDO::FETCH_ASSOC);

?>
<script type="text/javascript">
	$(document).ready( function () {
		$('#liste_etu').dataTable({	
			"sPaginationType":"full_numbers",
			"oLanguage":{
				"sLengthMenu":"Afficher _MENU_ informations par page",
				"sZeroRecords":"Aucun resultat",
				"sInfo":"Liste de _START_ à _END_ sur _TOTAL_ ",
				"sInfoEmpty":"Liste de 0 à 0 sur 0",
				"sInfoFiltered":"(filtré à partir de _MAX_ enregistrements)"	
			}
		});
	});
</script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript1.2">

function montre(photo){
	$('#montre').html("<img src='photo/"+photo+".jpg' alt='' width='300' height='310'/>");
	$('#montre').dialog({ autoOpen: false, title: "dialog", width: 350, height:400, modal:true });	
}
</script>
<style type="text/css" title="styledatatable">
	@import "../css/demo_table.css";
	div.dataTables_filter{
	}
	div.dataTables_lenght{
	}
	div.dataTables_info{
	}
	div.dataTables_paginate{
	}
</style>
<div id="haut" style="height:25px"><center>LISTE DES ETUDIANTS AVEC MODE DE FILTRAGE</center></div>
<hr/>
<div id="toolbar" align="right">
<table border="0" width="100%">
      	      <tbody><tr>
      	        <td valign="middle" width="232"><a href="Excel/sortieFichier.php" target="_blank"><img src="../img/excel.jpg" alt="" align="left" border="0" height="33" width="32"></a><br>
   	            <span class="ds">  Exporter en Excel</span></td>
      	        <td width="1549"><form id="form1" method="post" action="">
      	          <table width="100%" border="0">
      	            <tr>
      	              <td width="139">Année Académique :</td>
      	              <td width="276" bgcolor="#D6D6D6"><label for="annee"></label>
      	                <select name="annee" id="annee"  onchange="submit();">
   	                    <?php
						$query = "SELECT * FROM annee_academique ORDER BY lib_annee DESC";
						$ane = $pdo->query($query);
						$row_anes = $ane->fetchAll(PDO::FETCH_ASSOC);	
						foreach($row_anes as $row_ane) {
							$select="";
							if($row_ane['lib_annee']==$anneeEtude && !isset($_POST['annee'])){
								$select="selected=\"selected\"";	
							}
							if(isset($_POST['annee']) && $row_ane['lib_annee']==$_POST['annee']){
								$select="selected=\"selected\"";	
							}
							
							echo "<option ".$select." value='".$row_ane['lib_annee']."'>".$row_ane['lib_annee']."</option>";	
						}
						?>
                        </select></td>
      	              <td width="20">&nbsp;</td>
      	              <td width="142">Etablissement :</td>
      	              <td width="307" bgcolor="#D6D6D6">
                      <label>
                        <select name="etab" id="etab"  onchange="submit();" style="width:200px">
						<option value=''> </option>
						<?php
						
foreach($row_etabs as $row_etab) {  
	if(!in_array("uak",$_SESSION['etablissement'])){
		if(in_array($row_etab['code_ecole'],$_SESSION['etablissement'])){
?>              
<option  value="<?php echo $row_etab['code_ecole']?>"<?php if(isset($_POST['etab'])){if (!(strcmp($row_etab['code_ecole'], $_POST['etab']))) {echo " selected=\"selected\"";}} ?>><?php echo $row_etab['lib_ecole']?></option>
      	                  <?php
		}
	}else{
?>
<option ".$select." value="<?php echo $row_etab['code_ecole']?>"<?php if(isset($_POST['etab'])){if (!(strcmp($row_etab['code_ecole'], $_POST['etab']))) {echo " selected=\"selected\"";}} ?>><?php echo $row_etab['lib_ecole']?></option>
	<?php
    }
}
?>
          <option ".$select." value='ED' <?php if(isset($_POST['etab'])){if (!(strcmp('ED', $_POST['etab']))) {echo " selected=\"selected\"";}} ?>>TOUTES LES ECOLES DOCTORALES</option>
		  </select>
        </label></td>
     	<td width="23">&nbsp;</td>
			</tr>
		<tr>
			<td>Matricule :</td>
			<td bgcolor="#D6D6D6"><label>
			<input type="text" name="matricule" id="matricule" value="<?php if(isset($_POST['matricule'])){ echo $_POST['matricule']; } ?>" />
			</label></td>
			<td>&nbsp;</td>
			<td>Filiere :</td>
			<td bgcolor="#D6D6D6"><select name="filiere" id="filiere" onchange="submit();">
			<option value=""> </option>
			<?php
	foreach($row_filieres as $row_filiere) {  
			if(in_array("uak",$_SESSION['etablissement']) || in_array($row_filiere['ecole'],$_SESSION['etablissement'])){
		?>
      	    <option value="<?php echo $row_filiere['code']?>"
        <?php 
if(isset($_POST['filiere']) && $_POST['filiere']==$row_filiere['code']){ echo "selected"; }
?> ><?php echo utf8_encode($row_filiere['code']); ?></option>
      	                <?php
			}
}
?>
    	                </select></td>
      	              <td>&nbsp;</td>
   	                </tr>
					<tr>
					<td width="68">Statut :</td>
      	              <td width="419" bgcolor="#D6D6D6">
      	                <select name="statut" id="statut"  onchange="submit();">
      	                  <option value=""></option>
      	                  <?php
		foreach($row_statuts as $row_statut) { 
?>
			<option value="<?php echo $row_statut['code']?>"<?php if(isset($_POST['statut'])){ if (!(strcmp($row_statut['code'], $_POST['statut']))) {echo "selected=\"selected\"";}} ?>><?php echo $row_statut['Intitule']?></option>
			<?php
		}
?>
			</select></td>
			<td width="20">&nbsp;</td>
			<td>Valider : </td>
      	              <td colspan="3"><select name="valide" id="valide">
                          <option value="">--Filtre validation--</option>
                          <option value="oui"  <?php 
if(isset($_POST['valide']) && $_POST['valide']=="oui"){ echo "selected"; }
?>>Valider</option>
                          <option value="non" <?php 
if(isset($_POST['valide']) && $_POST['valide']=="non"){ echo "selected"; }
?>>Non valide</option>
                      </select>
   	                  <input type="submit" name="button" id="button" value="Filtrer le résultat" /></td>
					</tr>
      	            </table>
   	            </form></td>
   	          </tr>
   	        </tbody></table>
</div>
<hr />
<div id="toolbar" align="right"><a href="?verdict&ajoutlot" class="easyui-linkbutton" iconCls="icon-add" plain="true">mporter un fichier csv</a>     <a href="?verdict&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<?php if($totalRows_inscrits>0){
	$_SESSION['colonne']="ANNEE ACADEMIQUE;SEXE;MATRICULE;NOM;PRENOMS;TELEPHONE;DATE DE NAISSANCE;LIEU DE NAISSANCE;EMAIL;USERNAME;NATIONALITE;ETABLISSEMENT;FILIERE;STATUT;MONTANT;MONTANT_REPRISE;VERDICT AN PRECEDENT";
	?>
    <div id='montre'></div>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="liste_etu" class="display"><br />
<caption>
     Liste des etudiants
</caption>
<thead style="background-color:#D6E8AB">
 <tr>
 	<td>Annee Académique</td>
    <td>photo</td>
    <td>Sexe</td>
    <td>Matricule</td>
    <td>Nom</td>
	<td>Prenoms</td>
	<td>Telephone</td>
    <td>Date de naissance</td>
    <td>Lieu de naissance</td>
    <td>Nationalite</td>
    <td>Etablissement</td>
    <td>Filière</td>
    <td>Statut</td>
	<td>Montant</td>
	<td>Montant Reprise</td>
	<td> Verdict An Precedent </p>
    <td></td>
  </tr>
</thead>
<tbody>
<?php
//print_r($row_inscrits);
$color="#FA11FA";
foreach($row_inscritss as $row_inscrits) { 
	if(in_array("uak",$_SESSION['etablissement'])){
		//correction date de naissance
			if(strpos($row_inscrits['date_naissance'],"/") > 0){
				$date=str_replace("/","-",$row_inscrits['date_naissance']);
			}else{
				//$date=$row['date_naissance'];
				$dates=explode("-",$row_inscrits['date_naissance']);
				$date=$dates[2]."-".$dates[1]."-".$dates[0];
			}
		
	
	$a=0;
	//$liste=selTableDataLimit("student","matricule",$row_inscrits['matricule']);
	if($color=="#FA11FA"){
		$color="";
	}else{
		$color="#FA11FA";
	}
	?>
	  <tr valign="top">
		<td title=""><?php echo $row_inscrits['annee_academique']; ?></td>
		<td><img onclick="montre('<?php echo $row_inscrits['matricule']; ?>')" src="<?php //echo "photo/".$row_inscrits['matricule'].".jpg"; ?>" alt="" width="30" height="27"/>
        </td>
        <td> <img src="<?php if($row_inscrits['sexe']=="M"){echo "../img/homme.gif";}else{echo "../img/femme.gif";}; ?>" alt="" width="13" height="27"/></td>
		<td><?php echo $row_inscrits['matricule']; ?></td>
		<td><?php  echo $row_inscrits['nom']; ?></td>
		<td><?php echo $row_inscrits['prenoms']; ?></td>
		<td <?php if($row_inscrits['telephone']==0) echo "bgcolor='#CCCCCC'"; ?>><?php echo $row_inscrits['telephone']; ?></td>
		<td><?php echo $date ?></td>
		<td><?php echo $row_inscrits['lieu_naissance'];  ?></td>
		<td><?php echo $row_inscrits['Nationalite'];  ?></td>
		<td><?php echo $row_inscrits['ecole']; ?></td>
		<td><?php echo $row_inscrits['filiere']; ?></td>
		<td><?php echo $row_inscrits['statut']; ?></td>
		<td><?php echo round($row_inscrits['FF']+$row_inscrits['FI']); ?></td>
		<td><?php echo $row_inscrits['montant_reprise']; ?></td>
		<td><?php  
			$query_vp = "SELECT * FROM verdict where annee_academique='".$row_anp."' and matricule='".$row_inscrits['matricule']."'";
			//echo $query_vp;
			$vp = $pdo->query($query_vp);
			$row_vp = $vp->fetchAll(PDO::FETCH_ASSOC);
			//print($row_vp);
			if(count($row_vp)!=0){
				//echo $query_vp;\
//				print_r($row_vp);
				echo $row_vp[0]['result_semestre_2'];
			}else{
				echo "n/a";
			}
		?> </td>
		<td align="center"><a onclick="suppression('<?php echo $row_inscrits['matricule']; ?>','<?php echo $row_inscrits['annee_academique']; ?>')" class="easyui-linkbutton" iconCls="icon-remove" plain="true">Supprimer </a></td>
	  </tr>
	<?php
	$a++;
	}
}

?>
</tbody>
</table>
<?php 
}else{
	echo "PAS DE RESULTATS";
} 
//print_r($_SESSION['etablissement']);
?> 
