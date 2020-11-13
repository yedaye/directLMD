<?php
session_start();
//print_r($_SESSION);

require_once('../../connect/co.php');
if (is_file("../../functions/queries.php"))
	include_once ("../../functions/queries.php");
include('FichierExcel.php');
$query_etudiant = $_SESSION['requete'];
$query_etudiant=substr($query_etudiant,0,-41);
//echo $query_etudiant;
$query = $pdo->query($query_etudiant);
$row_inscritss = $query->fetchAll(PDO::FETCH_ASSOC);	
$fichier = new FichierExcel();
$fichier->Colonne($_SESSION['colonne']);
// 

//initialisation de an precedent
$query_anp = "SELECT * FROM annee_academique WHERE lib_annee='".trim($row_inscritss[0]['annee_academique'])."'";
$anp = $pdo->query($query_anp);
$row_anp = $anp->fetchAll(PDO::FETCH_ASSOC);
//print_r($row_anp);
$row_anp=$row_anp[0]['an_precedent'];
//print_r($row_inscritss);
//exit;
foreach($row_inscritss as $row_inscrits) {
	if(in_array("uak",$_SESSION['etablissement']) || in_array($row_inscrits['ecole'],$_SESSION['etablissement'])){
		$montant=round($row_inscrits['FF']+$row_inscrits['FI']);
		$liste=selTableDataWhere("student","matricule",$row_inscrits['matricule'],$pdo);
		$nation=selTableDataWhere('pays','cod_pays',$liste['Nationalite'],$pdo);
		$nom=$liste['nom'];
		$prenoms=$liste['prenoms'];
		//VERDICT AN PRECEDENT
		$query_vp = "SELECT * FROM verdict where annee_academique='".$row_anp."' and matricule='".$liste['matricule']."'";
			//echo $query_vp;
			$vp = $pdo->query($query_vp);
			$row_vp = $vp->fetchAll(PDO::FETCH_ASSOC);
			//print($row_vp);
			if(count($row_vp)!=0){
				//echo $query_vp;\
//				print_r($row_vp);
				$verdict= $row_vp[0]['result_semestre_2'];
			}else{
				$verdict= "n/a";
			}
		//correction date de naissance
		if(strpos($liste['date_naissance'],"/") > 0){
			$date=str_replace("/","-",$liste['date_naissance']);
		}else{
			//$date=$row['date_naissance'];
			$dates=explode("-",$liste['date_naissance']);
			$date=$dates[2]."-".$dates[1]."-".$dates[0];
		}

		$fichier->Insertion(trim($row_inscrits['annee_academique']).";".$liste['sexe'].";".trim($liste['matricule']).";".$nom.";".$prenoms.";".trim($liste['telephone']).";".trim($date).";".trim($liste['lieu_naissance']).";".trim(strtolower($liste['email_uak']))."@etu.una.bj;".trim(strtolower($liste['email_uak'])).";".trim($nation['lib_nation']).";".$row_inscrits['ecole'].";".$row_inscrits['filiere'].";".$row_inscrits['statut'].";".$montant.";".$row_inscrits['montant_reprise'].";".$verdict);
	}
}
//
$date=date("Y-m-d");
$fichier->output('maliste_'.$date); 
echo "Fichier excel ".$date."<br/>";
?>