<?php
	session_start();
	include("../../connect/co.php"); 
   if($_POST['letype']=='valide'){
		$rs = "UPDATE inscription SET controle='oui', utilisateur='".$_SESSION['username']."',date_validation='".date('Y-m-d')."' Where filiere='".$_POST['lafiliere']."' AND matricule='".$_POST['lematricule']."' AND annee_academique='".$_POST['lannee']."'";
		$query = $pdo->query($rs);
		echo 1;
	}   
	if($_POST['letype']=='valide_final'){
		$rs = "UPDATE inscription SET validation_final='oui', motif_rejet='', date_validation_final='".date('Y-m-d')."', user_valide_final='".$_SESSION['username']."', lot='".$_POST['lelot']."' Where filiere='".$_POST['lafiliere']."' AND matricule='".$_POST['lematricule']."' AND annee_academique='".$_POST['lannee']."'";
		$query = $pdo->query($rs);
		echo 1;
	}  
	if($_POST['letype']=='rejet'){
		$rs = "UPDATE inscription SET validation_final='non', date_validation_final='".date('Y-m-d')."', user_valide_final='".$_SESSION['username']."', motif_rejet='".utf8_encode(addslashes($_POST['lemotif']))."' Where filiere='".$_POST['lafiliere']."' AND matricule='".$_POST['lematricule']."' AND annee_academique='".$_POST['lannee']."'";
		$query = $pdo->query($rs);
		echo 1;
	}  
?>