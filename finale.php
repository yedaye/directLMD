<?php
session_start();

if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if(isset($_GET['reset'])){
	session_destroy();
	header("Location:inscription.php");
}

if (is_file("connect/co.php"))
	include_once ("connect/co.php");

if (is_file("functions/queries.php"))
	include_once ("functions/queries.php");

if (is_file("param.php"))
	include_once ("param.php");
	
//print_r($_POST);
//break;
	
$err_msg="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inscription à l'UNA</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="js/default/easyui.css">
<link rel="stylesheet" type="text/css" href="js/icon.css">
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
<script language="javascript1.2" type="text/javascript">
</script>
</head>

<body>
<?php include("include_menu.html"); ?><br />
<br />
<br />

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><strong>Dernière ETAPE<br/>
        <span class="Style6"><strong>IMPORTANT :  VEUILLEZ BIEN NOTER VOTRE NUMERO MATRICULE, VOTRE EMAIL ET LOGIN ET MOT DE PASSE</strong></span></strong>
      <hr/></td>
  </tr>
  <tr>
    <td align="center"><div align="left" id='retour' style="display:none"> <a href="inscription.php?reset" class="easyui-linkbutton">RETOUR</a></div><br /><div style="font:Verdana, Geneva, sans-serif; width:350px; font-size:16px; color:#090; text-align:left; font-weight:bold" align="center">
	</div>
    <?php
	$nbre=0;
	$email=strtolower(substr($_POST['nom_famille'],0,2).substr($_POST['prenoms'],0,2)).substr($_POST['lieu_naissance'],0,2);
	$login=$email;	
	///enregistrement des inscriptions
	/// type bachelier
	if($_POST['letype']=='bachelier'){
		//print_r($_POST);
		//break;
	if($_POST['matricule']!=""){
		//////  Enregistrement du nouvel étudiant
		$matricule=$_POST['matricule'];
		$qstr1 = "UPDATE student SET situ_fam='".$_POST['situation_familiale']."',nombre_enfant='".$_POST['nombre_enfant']."',email='".$_POST['email']."',telephone='".$_POST['telephone']."',pays_naissance='".$_POST['txtpays']."',Nationalite='".$_POST['nationalite']."',departement='".$_POST['departement']."',adresse_postal='".$_POST['bp']."',email_uak='".$email."' WHERE matricule='".$matricule."'" ;
	}else{
		////
		$lemode=selTableDataWhere("mode","code",$_POST['lemode_bon']);
		$lemode=$lemode['num'];
		$cycle=selTableDataWhere("options","code",$_POST['annee_etude_bon']);
		$cycle=$cycle['num'];
		$ufr=selTableDataWhere("ecole_ufr","code_ecole",$_POST['ecole_bon']);
		$ecole=$ufr['num'];
		$ufr=selTableDataWhere("ufr","code_ufr",$ufr['code_ufr']);
		$ufr=$ufr['num'];
		/////
		$matricule=num_matricule($lemode,$cycle,$anneeEtude,$ufr,$ecole);
		/////
		$qstr1 = "INSERT INTO student  (matricule,nom,prenoms,sexe,date_naissance,lieu_naissance,situ_fam,nombre_enfant,email,telephone,pays_naissance,Nationalite,departement,adresse_postal,num_table,session,code_auto,serie,email_uak) VALUES ('".$matricule."','".utf8_decode($_POST['nom_famille'])."','".utf8_decode($_POST['prenoms'])."','".$_POST['sexe']."','".$_POST['date_naissance']."','".utf8_decode($_POST['lieu_naissance'])."','".$_POST['situation_familiale']."','".$_POST['nombre_enfant']."','".$_POST['email']."','".$_POST['telephone']."','".$_POST['txtpays']."','".$_POST['nationalite']."','".$_POST['departement']."','".$_POST['bp']."','".$_POST['num_table']."','".$_POST['session']."','','".$_POST['serie']."','".$email."');";
	}
		$queryb = mysql_query($qstr1) or die(mysql_error());
		///enregistrement de son inscription
		$qstr1 = "INSERT INTO inscription (matricule,filiere,annee_academique,statut,FF,FI,num_inscription) VALUES ('".$matricule."','".$_POST['annee_etude_bon']."-".$_POST['ecole_bon']."','".$anneeEtude."','".$_POST['lemode_bon']."','".$_POST['leff']."','".$_POST['lefi']."','".numfiche()."');";
			$queryb = mysql_query($qstr1) or die(mysql_error());
			///affichage pour impression de la fiche
			echo "<a class='titre_form' href='backend/fiche.php?matricule=".$matricule."&an_etude=".$anneeEtude."' target='_blank'>IMPRIMER MA FICHE DE PREINSCRIPTION</a><br/>";
			echo "Votre numéro matricule est : ".$matricule."<br/>Votre Email est : ".$email."@uak.bj<br/>Votre login est : ".$email."<br/>Votre mot de passe vous sera communiqué ultérieurement en salle de cours<hr/>";
			
	}
	
	/// type reinscription
	if($_POST['letype']=='reinscription'){
		//print_r($_POST);
		//break;
		//$email=$email);
		//////  Enregistrement du nouvel étudiant
		$matricule=$_POST['matricule'];
		$qstr1 = "UPDATE student SET situ_fam='".$_POST['situation_familiale']."',nombre_enfant='".$_POST['nombre_enfant']."',email='".$_POST['email']."',telephone='".$_POST['telephone']."',adresse_postal='".$_POST['bp']."',email_uak='".$email."' WHERE matricule='".$matricule."'" ;
		
		$queryb = mysql_query($qstr1) or die(mysql_error());
		///enregistrement de son inscription
		$qstr1 = "INSERT INTO inscription (matricule,filiere,annee_academique,statut,FF,FI,num_inscription) VALUES ('".$matricule."','".$_POST['annee_etude_bon']."-".$_POST['ecole_bon']."','".$anneeEtude."','".$_POST['lemode_bon']."','".$_POST['leff']."','".$_POST['lefi']."','".numfiche()."');";
			$queryb = mysql_query($qstr1) or die(mysql_error());
			///affichage pour impression de la fiche
			echo "<a class='titre_form' href='backend/fiche.php?matricule=".$matricule."&an_etude=".$anneeEtude."' target='_blank'>IMPRIMER MA FICHE DE PREINSCRIPTION</a><br/>";
			echo "Votre numéro matricule est : ".$matricule."<br/>Votre Email est : ".$email."@uak.bj<br/>Votre login est : ".$email."<br/>Votre mot de passe vous sera communiqué ultérieurement en salle de cours<hr/>";
			
	}
	
	/// type Autorisation
	if($_POST['letype']=='autorisation'){
		//print_r($_POST);
		//break;
	if($_POST['matricule']!=""){
		//////  Enregistrement du nouvel étudiant
		$matricule=$_POST['matricule'];
		$qstr1 = "UPDATE student SET situ_fam='".$_POST['situation_familiale']."',nombre_enfant='".$_POST['nombre_enfant']."',email='".$_POST['email']."',telephone='".$_POST['telephone']."',pays_naissance='".$_POST['txtpays']."',Nationalite='".$_POST['nationalite']."',departement='".$_POST['departement']."',adresse_postal='".$_POST['bp']."',email_uak='".$email."' WHERE matricule='".$matricule."'" ;
	}else{
		////
		$lemode=selTableDataWhere("mode","code",$_POST['lemode_bon']);
		$lemode=$lemode['num'];
		$cycle=selTableDataWhere("options","code",$_POST['annee_etude_bon']);
		$cycle=$cycle['num'];
		$ufr=selTableDataWhere("ecole_ufr","code_ecole",$_POST['ecole_bon']);
		$ecole=$ufr['num'];
		$ufr=selTableDataWhere("ufr","code_ufr",$ufr['code_ufr']);
		$ufr=$ufr['num'];
		/////
		$matricule=num_matricule($lemode,$cycle,$anneeEtude,$ufr,$ecole);
		/////
		$qstr1 = "INSERT INTO student  (matricule,nom,prenoms,sexe,date_naissance,lieu_naissance,situ_fam,nombre_enfant,email,telephone,pays_naissance,Nationalite,departement,adresse_postal,num_table,session,code_auto,serie,email_uak) VALUES ('".$matricule."','".utf8_decode($_POST['nom_famille'])."','".utf8_decode($_POST['prenoms'])."','".$_POST['sexe']."','".$_POST['date_naissance']."','".$_POST['lieu_naissance']."','".$_POST['situation_familiale']."','".$_POST['nombre_enfant']."','".$_POST['email']."','".$_POST['telephone']."','".$_POST['txtpays']."','".$_POST['nationalite']."','".$_POST['departement']."','".$_POST['bp']."','".$_POST['num_table']."','".$_POST['session']."','".$_POST['code_auto']."','".$_POST['serie']."','".$email."');";
	}
		$queryb = mysql_query($qstr1) or die(mysql_error());
		///enregistrement de son inscription
		$qstr1 = "INSERT INTO inscription (matricule,filiere,annee_academique,statut,FF,FI,num_inscription) VALUES ('".$matricule."','".$_POST['annee_etude_bon']."-".$_POST['ecole_bon']."','".$anneeEtude."','".$_POST['lemode_bon']."','".$_POST['leff']."','".$_POST['lefi']."','".numfiche()."');";
			$queryb = mysql_query($qstr1) or die(mysql_error());
			///affichage pour impression de la fiche
			echo "<a class='titre_form' href='backend/fiche.php?matricule=".$matricule."&an_etude=".$anneeEtude."' target='_blank'>IMPRIMER MA FICHE DE PREINSCRIPTION</a><br/>";
			echo "Votre numéro matricule est : ".$matricule."<br/>Votre Email est : ".$email."@uak.bj<br/>Votre login est : ".$email."<br/>Votre mot de passe vous sera communiqué ultérieurement en salle de cours<hr/>";
			
	}
	?>
    </td>
  </tr>
  <tr>
    <td>
    <div align="center" id='retour'> <a href="inscription.php?reset" class="easyui-linkbutton">QUITTER</a></div>
    </td>
  </tr>
</table>
</body>
</html>