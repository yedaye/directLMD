<?php
session_start();
include("../connect/co.php");
include("../param.php");
if(!isset($_SESSION['nom'])){
	header("location:index.php?error");	
}
if(is_file("../functions/queries.php")){
	include_once ("../functions/queries.php");
}
if(isset($_GET['accueil'])){
	header("location:accueil.php");
}
//		print_r($_SESSION['etablissement']);
$nombre=0;	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Espace privé UAK</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	text-align: center;
	font-size: 14px;
}

</style>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
<link rel="stylesheet" type="text/css" href="../js/default/easyui.css"> 
<?php  if(count($_GET)==0 || isset($_GET['annee1'])){ ?> 
<link rel="stylesheet" type="text/css" href="../js/icon.css"> 
<link rel="stylesheet" href="../js/graphe/TableBarChart.css" />
<script type="text/javascript" src="../js/graphe/TableBarChart.js"></script>
<script type="text/javascript">
    $(function() {
        $('#source4').tableBarChart('#target4', '', false);
        $('#source3').tableBarChart('#target3', '', false);
    });
</script>
<?php  } ?>
</head>

<body>
<div class="easyui-layout" style="width:auto;height:700px;" align="center">
        <div region="west" split="true" title="MENU" style="width:250px;">
          	<div class="easyui-accordion" style="width:240px;height:550px;" align="center">
                <div title="Utilisateur" data-options="iconCls:'icon-ok'" style="overflow:auto;padding:10px;">
                	Bienvenu <?php echo $_SESSION['nom']." ".$_SESSION['prenoms']; ?><br/>
                    <a href="index.php?reset">Deconnexion</a><br /><br />
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="?accueil"> Accueil</a> <br/><br />
                </div>
                <div title="Inscription" data-options="iconCls:'icon-ok'" style="overflow:auto;padding:10px;">
                   <?php if($_SESSION['droit']=='0' || $_SESSION['droit']=='1' || $_SESSION['droit']=='2'){ ?>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="../inscription.php"> Inscription</a> <br/><br />
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?fiche">fiche de préinscription </a><br/><br />
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?validation">Validation</a><br/><br /><br />
					<img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?comptabilite">Comptabilite</a><br/><br/>
                   <?php 
				   }
				   if($_SESSION['droit']=='1' || $_SESSION['droit']=='2'){ ?>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/>  <a href="accueil.php?liste_annee">Liste des étudiants par année académique </a><br/><br />
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?verdict"> Resultat étudiant</a><br/><br/>
                  <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?result_ecu"> Resultat ECU pour un étudiant</a><br/><br/>
                  <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?liste_result_ecu"> Liste Resultat par ECU</a><br/><br/>
                   <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?penalite"> Penalité </a><br/><br/>
				   <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?curiculla"> Curiculla </a><br/><br/>
				   <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?duplicata"> Duplicata </a><br/><br/>
                    <?php } ?>
                </div>
                <?php if($_SESSION['droit']=='2'){ ?>
                <div title="Administration" data-options="iconCls:'icon-help'" style="padding:10px;">
					<img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?statistique">Statistique</a> <br/><br />
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/>  <a href="accueil.php?liste">Liste étudiant </a><br/><br />
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?auto"> autorisation</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?bac">Resultat BAC</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?mapping"> Mapping</a><br/><br/>
					<img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?parametre"> Parametre UE</a><br/><br/>
					<!--img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?xmlgene"> Regeneration xml</a><br/><br/-->
                   
                </div>
                <div title="configuration" data-options="iconCls:'icon-cut'" style="padding:10px;">
               	 	<img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?anneeacad">Année académique</a><br/><br/>
					<img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?ue_new">Unité d'enseignement (Nouveau)</a><br/><br/>
					<img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?ecu_new">Unité ECU (Nouveau)</a><br/><br/><hr />
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?dept">Département</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?ufr">UFR</a><br/><br/>
               	 	<img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?ecole">Ecoles</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?filiere">Filières</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?statut">Statut</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?pays">Pays</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?zone">Zone</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?montant">Montant</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?type">Type_auto</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/><a href="accueil.php?option">Option(Diplome)</a><br/><br/>
                    <img src="../js/icons/ok.png" align="left" style="padding-right:15px"/> <a href="accueil.php?user">Utilisateur</a><br/><br/>
                </div>
                <?php  } ?>
            </div>
        </div>
        <div id="content" region="center" title="" style="padding:5px; font-size:15px" align="center"> 
        
        <?php
		if(count($_GET)==0 || isset($_GET['annee1'])){
		?>
        <form action="" method="get">
        Filtrer par Année Académique : <select required="true" name="annee1" id="annee1">
      <?php
			$ufr=selTableDataDesc("annee_academique","lib_annee",$pdo);
				for($i=0;$i<count($ufr);$i++){
					$select="";
					if(isset($_GET['annee1']) && $_GET['annee1']==$ufr[$i]['lib_annee']){ $select="selected";}
					echo "<option value='".$ufr[$i]['lib_annee']."' ".$select.">".strtoupper($ufr[$i]['lib_annee'])."</option>";
				}	
			?>
    </select><input name="Envoyer" type="submit" value="Filtrer" />
        </form><hr />
    <table width="95%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr><td colspan="2" align="center" bgcolor="#6699FF"><b>STATISTIQUE DES PREINSCRIPTIONS</b></td></tr>
     <tr>
    <td width="50%">
	<?php
	if(isset($_GET['annee1'])){
		$an=$_GET['annee1'];	
	}else{
		$an=$anneeEtude;		
	}
    
	if(in_array("uak",$_SESSION['etablissement'])){
	$elementpag=requete("SELECT count(*) as nombre FROM `inscription`, filiere Where annee_academique='".$an."' AND filiere.code=inscription.filiere AND (inscription.filiere LIKE 'LP1,2-%' OR inscription.filiere LIKE 'LP3,4-%') ORDER BY filiere.ecole",$pdo);
	//echo "SELECT count(*) as nombre FROM `inscription`, filiere Where annee_academique='".$anneeEtude."' AND filiere.code=inscription.filiere AND (inscription.filiere LIKE 'LP1,2-%' OR inscription.filiere LIKE 'LP3,4-%') ORDER BY filiere.ecole";
	//print_r ($elementpag);
	$rs = requete("SELECT ecole, count(*) as nombre FROM `inscription`, filiere Where annee_academique='".$an."' AND filiere.code=inscription.filiere GROUP BY filiere.ecole ORDER BY filiere.ecole",$pdo); 
	if(count($rs)>0){
		echo "<table id='source4' width='95%' border='0' cellpadding='0' cellspacing='2'>
				<caption>Graphique du nombre d'inscription par ecole</caption> <!-- optional -->
    			<thead>               <!-- Must have -->
					<tr style='background-color:#FFFCCC; font-size:20px'>
						<th></th><!-- Must have an empty <th> here -->
						<th>Nombre d'étudiant</th> <!-- Must have -->
						...
					</tr>
    			</thead>
    			<tbody><!-- Must have -->";
				//$element=mysql_fetch_assoc($rs);
				$nombre1=0;
				$color='#FFAFAA';
				foreach($rs as $element){			
					echo "<tr style='background-color:".$color."; font-size:20px'>
            		<th>".$element['ecole']."</th>    <!-- First cell of each row must be <th> -->
            		<td>".$element['nombre']."</td>    <!-- Data cell must be <td> -->
           	 		....
        			</tr>
        			...             <!-- Repeat above pattern -->";
					if($color!=""){
						$color="";
					}else{
						$color='#FFAFAA';
					}
					$nombre+=$element['nombre'];
				};
				echo "<tr style='background-color:#AAC; font-size:20px'>
            		<th>TOTAL CAG</th>    <!-- First cell of each row must be <th> -->
            		<td>".$elementpag[0]['nombre']."</td>    <!-- Data cell must be <td> -->
           	 		....
        			</tr>
        			...             <!-- Repeat above pattern -->";
    			echo "</tbody>
				<tfoot style='background-color:#FFFCCC; font-size:20px'><td align='center'><b>Total </b></td><td>".$nombre."</td></tfoot>
				</table><br/><br/>"; 
	}
	
	}else{
		if(!in_array("uak",$_SESSION['etablissement'])){
			$where="AND (";
			for($l=0;$l<count($_SESSION['etablissement']);$l++){
				$where.="ecole='".$_SESSION['etablissement'][$l]."' OR ";	
			}	
			$where=substr($where,0,-3);
			$where.=")";
			//echo $where;
		}
		$rs = requete("SELECT ecole, count(*) as nombre,sexe FROM `inscription`, filiere, student Where student.matricule=inscription.matricule AND annee_academique='".$an."' ".$where." AND filiere.code=inscription.filiere GROUP BY filiere.ecole, sexe ORDER BY filiere.ecole",$pdo); 
		if(count($rs)>0){
		echo "<table id='source4' width='95%' border='0' cellpadding='0' cellspacing='2'>
				<caption>Graphique du nombre d'inscription par ecole</caption> <!-- optional -->
    			<thead>               <!-- Must have -->
					<tr style='background-color:#FFFCCC; font-size:20px'>
						<th></th>       <!-- Must have an empty <th> here -->
						<th>Nombre d'étudiant</th> <!-- Must have -->
						<th>Ecole</th> <!-- Must have -->
						...
					</tr>
    			</thead>
    			<tbody>                   <!-- Must have -->";
				//$element=mysql_fetch_assoc($rs);
				$color='#FFAFAA';
				$nombre=0;
				foreach($rs as $element){			
					echo "<tr style='background-color:".$color."; font-size:20px'>
            		<th>".$element['sexe']."</th>    <!-- First cell of each row must be <th> -->
            		<td>".$element['nombre']."</td>    <!-- Data cell must be <td> -->
					<td>".$element['ecole']."</td>    <!-- Data cell must be <td> -->
           	 		....
        			</tr>
        			...             <!-- Repeat above pattern -->";
					if($color!=""){
						$color="";
					}else{
						$color='#FFAFAA';
					}
					$nombre+=$element['nombre'];
				};
    			echo "</tbody>
				<tfoot style='background-color:#FFFCCC; font-size:20px'><td align='center'><b>Total</b></td><td>".$nombre."</td></tfoot>
				</table><br/><br/>"; 
		}	
	}
	?>
    </td>
    <td width="50%">
		    <div id='target4' style='width: 600px; height: 400px'>
			</div>
    </td>
  </tr>
   <tr><td colspan="2" align="center" bgcolor="#6699FF"><b>STATISTIQUE DES INSCRIPTIONS VALIDEES</b></td></tr>
  <tr>
    <td width="50%">
	<?php
	if(isset($_GET['annee1'])){
		$an=$_GET['annee1'];	
	}else{
		$an=$anneeEtude;		
	}
	if(in_array("uak",$_SESSION['etablissement'])){
	$elementpag3=requete("SELECT ecole, count(*) as nombre FROM `inscription`, filiere Where annee_academique='".$anneeEtude."' AND controle = 'oui' AND filiere.code=inscription.filiere AND (inscription.filiere LIKE 'LP1,2-%' OR inscription.filiere LIKE 'LP3,4-%') ORDER BY filiere.ecole ",$pdo);
	
	$rs = requete("SELECT ecole, count(*) as nombre FROM `inscription`, filiere Where controle='oui' AND annee_academique='".$an."' AND filiere.code=inscription.filiere GROUP BY filiere.ecole ORDER BY filiere.ecole",$pdo); 
	if(count($rs)>0){
		echo "<table id='source3' width='95%' border='0' cellpadding='0' cellspacing='2'>
				<caption>Graphique du nombre d'inscription par ecole</caption> <!-- optional -->
    			<thead>               <!-- Must have -->
					<tr style='background-color:#FFFCCC; font-size:20px'>
						<th></th>       <!-- Must have an empty <th> here -->
						<th>Nombre d'étudiant</th> <!-- Must have -->
						...
					</tr>
    			</thead>
    			<tbody>                   <!-- Must have -->";
				//$element=mysql_fetch_assoc($rs);
				$color='#FFAFAA';
				$nombre=0;
				foreach($rs as $element){			
					echo "<tr style='background-color:".$color."; font-size:20px'>
            		<th>".$element['ecole']."</th>    <!-- First cell of each row must be <th> -->
            		<td>".$element['nombre']."</td>    <!-- Data cell must be <td> -->
           	 		....
        			</tr>
        			...             <!-- Repeat above pattern -->";
					if($color!=""){
						$color="";
					}else{
						$color='#FFAFAA';
					}
					$nombre+=$element['nombre'];
				};
				echo "<tr style='background-color:#AAC; font-size:20px'>
            		<th>TOTAL CAG</th>    <!-- First cell of each row must be <th> -->
            		<td>".$elementpag3[0]['nombre']."</td>    <!-- Data cell must be <td> -->
           	 		....
        			</tr>
        			...             <!-- Repeat above pattern -->";
    			echo "</tbody>
				<tfoot style='background-color:#FFFCCC; font-size:20px'><td align='center'><b>Total</b></td><td>".$nombre."</td></tfoot>
				</table><br/><br/>"; 
	}
	
	}else{
		if(!in_array("uak",$_SESSION['etablissement'])){
			$where="AND (";
			for($l=0;$l<count($_SESSION['etablissement']);$l++){
				$where.="ecole='".$_SESSION['etablissement'][$l]."' OR ";	
			}	
			$where=substr($where,0,-3);
			$where.=")";
			//echo $where;
		}
		$elementpag2=requete("SELECT ecole, count(*) as nombre FROM `inscription`, filiere Where annee_academique='".$anneeEtude."' AND controle = 'oui' AND filiere.code=inscription.filiere AND (inscription.filiere LIKE 'LP1,2-%' OR inscription.filiere LIKE 'LP3,4-%') ORDER BY filiere.ecole ",$pdo);
		
		
		$rs = requete("SELECT ecole, count(*) as nombre,sexe FROM `inscription`, filiere, student Where student.matricule=inscription.matricule AND controle = 'oui' AND annee_academique='".$an."' ".$where." AND filiere.code=inscription.filiere GROUP BY filiere.ecole, sexe ORDER BY filiere.ecole",$pdo); 
		if(count($rs)>0){
		echo "<table id='source3' width='95%' border='0' cellpadding='0' cellspacing='2'>
				<caption>Graphique du nombre d'inscription par ecole</caption> <!-- optional -->
    			<thead>               <!-- Must have -->
					<tr style='background-color:#FFFCCC; font-size:20px'>
						<th></th>       <!-- Must have an empty <th> here -->
						<th>Nombre d'étudiant</th> <!-- Must have -->
						<th>Ecole</th> <!-- Must have -->
						...
					</tr>
    			</thead>
    			<tbody>                   <!-- Must have -->";
				//$element=mysql_fetch_assoc($rs);
				$color='#FFAFAA';
				foreach($rs as $element){			
					echo "<tr style='background-color:".$color."; font-size:20px'>
            		<th>".$element['sexe']."</th>    <!-- First cell of each row must be <th> -->
            		<td>".$element['nombre']."</td>    <!-- Data cell must be <td> -->
					<td>".$element['ecole']."</td>    <!-- Data cell must be <td> -->
           	 		....
        			</tr>
        			...             <!-- Repeat above pattern -->";
					if($color!=""){
						$color="";
					}else{
						$color='#FFAFAA';
					}
				};
				echo "<tr style='background-color:#FFAACC; font-size:20px'>
            		<th>".$elementpag2['sexe']."</th>    <!-- First cell of each row must be <th> -->
            		<td>".$elementpag2[0]['nombre']."</td>    <!-- Data cell must be <td> -->
					<td>TOTAL CAG</td>    <!-- Data cell must be <td> -->
           	 		....
        			</tr>
        			...             <!-- Repeat above pattern -->";
    			echo "</tbody>
				</table><br/><br/>"; 
		}	
	}
	?>
    </td>
    <td width="50%">
		    <div id='target3' style='width: 600px; height: 400px'>
			</div>
    </td>
  </tr>
  </table>

        <?php
		}
		if(isset($_GET['fiche'])){
			include("fiche.php");	
		}
		if(isset($_GET['ufr'])){
			include("ufr.php");	
		}
		if(isset($_GET['ecole'])){
			include("ecole_ufr.php");	
		}
		if(isset($_GET['pays'])){
			include("pays.php");	
		}
		if(isset($_GET['statut'])){
			include("statut.php");	
		}
		if(isset($_GET['anneeacad'])){
			include("annee_acad.php");	
		}
		if(isset($_GET['dept'])){
			include("departement.php");	
		}
		if(isset($_GET['zone'])){
			include("zone.php");	
		}
		if(isset($_GET['type'])){
			include("type.php");	
		}
		if(isset($_GET['option'])){
			include("option.php");	
		}
		if(isset($_GET['filiere'])){
			include("filiere.php");	
		}
		if(isset($_GET['montant'])){
			include("montant.php");	
		}
		if(isset($_GET['mapping'])){
			include("mapping.php");	
		}
		if(isset($_GET['verdict'])){
			include("verdict.php");	
		}
		if(isset($_GET['auto'])){
			include("autorisation.php");	
		}
		if(isset($_GET['validation'])){
			include("validation.php");	
		}
		if(isset($_GET['liste'])){
			include("liste.php");	
		}
		if(isset($_GET['statistique'])){
			include("statistique.php");	
		}
		if(isset($_GET['bac'])){
			include("resultatbac.php");	
		}
		if(isset($_GET['user'])){
			include("user.php");	
		}
		if(isset($_GET['liste_annee'])){
			include("liste_annee_academique_etab.php");	
		}
		if(isset($_GET['par_etab_par_annee'])){
			include("par_etab_par_annee.php");	
		}
		if(isset($_GET['ue'])){
			include("ue.php");	
		}
		if(isset($_GET['ecu'])){
			include("ecu.php");	
		}
		if(isset($_GET['ue_new'])){
			include("ue_new.php");	
		}
		if(isset($_GET['ecu_new'])){
			include("ecu_new.php");	
		}
		if(isset($_GET['result_ecu'])){
			include("resultat_ecu.php");	
		}
		if(isset($_GET['liste_result_ecu'])){
			include("liste_result_ecu.php");	
		}
		if(isset($_GET['penalite'])){
			include("penalite.php");	
		}
		if(isset($_GET['comptabilite'])){
			include("comptabilite.php");	
		}
		if(isset($_GET['photo'])){
			include("photo.php");	
		}
		if(isset($_GET['curiculla'])){
			include("curiculla.php");	
		}
		if(isset($_GET['ecu2'])){
			include("ecu_new2.php");	
		}
		if(isset($_GET['parametre'])){
			include("parametre.php");	
		}
        if(isset($_GET['duplicata'])){
			include("duplicata.php");	
		}
		if(isset($_GET['xmlgene'])){
			include("../xmlgene.php");	
		}
	?>
        </div>
</div>
</body>
</html>