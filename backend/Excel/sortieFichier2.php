<?php
session_start();
require_once('../../connect/co.php');
if (is_file("../../functions/queries.php"))
	include_once ("../../functions/queries.php");
include('FichierExcel.php');
$query_etudiant = $_SESSION['requete'];
//$query_etudiant=substr($query_etudiant,0,-41);
//echo $query_etudiant;
$query = $pdo->query($query_etudiant);
$row_inscritss = $query->fetchAll(PDO::FETCH_ASSOC);	
$fichier = new FichierExcel();
$fichier->Colonne($_SESSION['colonne']);
// 
foreach($row_inscritss as $row_inscrits) {
	if(in_array("uak",$_SESSION['etablissement']) || in_array($row_inscrits['ecole'],$_SESSION['etablissement'])){
		$fichier->Insertion($row_inscrits['annee_academique'].";".$row_inscrits['ecole'].";".$row_inscrits['code'].";".$row_inscrits['sexe'].";".$row_inscrits['nombre']);
	}
}
//
$date=date("Y-m-d");
$fichier->output('statistique'.$date); 
echo "Fichier excel des statistiques".$date."<br/>";
?>