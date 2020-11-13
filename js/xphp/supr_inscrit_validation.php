<?php
	session_start();
	include("../../connect/co.php"); 
	if($_POST['letype']=='inscription'){
		$rs = "DELETE FROM inscription Where filiere='".$_POST['lafiliere']."' AND matricule='".$_POST['lematricule']."' AND annee_academique='".$_POST['lannee']."'";
		$query = $pdo->query($rs);
		//suppression des reprises de l'année
		$rs = "DELETE FROM reprise_ecu Where matricule='".$_POST['lematricule']."' AND annee_academique='".$_POST['lannee']."'";
		$query = $pdo->query($rs);
		//suppression des reprises de l'année
    	echo 1;
	}
	if($_POST['letype']=='validation'){
		$rs = "UPDATE inscription SET controle='non', utilisateur='', carte_imprime='', carte_user='' Where filiere='".$_POST['lafiliere']."' AND matricule='".$_POST['lematricule']."' AND annee_academique='".$_POST['lannee']."'";
		$query = $pdo->query($rs);
    	echo 1;
	}
	if($_POST['letype']=='validation_finale'){
		$rs = "UPDATE inscription SET validation_final='', user_valide_final='', lot=NULL, date_validation_final='' Where filiere='".$_POST['lafiliere']."' AND matricule='".$_POST['lematricule']."' AND annee_academique='".$_POST['lannee']."'";
		$query = $pdo->query($rs);
    	echo 1;
	}
?>