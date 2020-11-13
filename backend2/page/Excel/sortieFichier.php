<?php
session_start();
//print_r($_SESSION);

require_once('../../connect/co.php');
if (is_file("../../functions/queries.php"))
	include_once ("../../functions/queries.php");
include('FichierExcel.php');
$query_etudiant = $_SESSION['requete'];
//echo $query_etudiant;
$inscrits = mysql_query($query_etudiant) or die(mysql_error());
$row_inscrits = mysql_fetch_assoc($inscrits);
$fichier = new FichierExcel();
$fichier->Colonne($_SESSION['colonne']);
// 
do { 
	if(in_array("uak",$_SESSION['etablissement']) || in_array($row_inscrits['ecole'],$_SESSION['etablissement'])){
		$montant=round($row_inscrits['FF']+$row_inscrits['FI']);
		$liste=selTableDataWhere("student","matricule",$row_inscrits['matricule']);
		$nation=selTableDataWhere('pays','cod_pays',$liste['Nationalite']);
		$nom=$liste['nom'];
		$prenoms=$liste['prenoms'];
		
		$fichier->Insertion($row_inscrits['annee_academique'].";".$liste['sexe'].";".$liste['matricule'].";".$nom.";".$prenoms.";".$liste['date_naissance'].";".$liste['lieu_naissance'].";".$nation['lib_nation'].";".$row_inscrits['ecole'].";".$row_inscrits['filiere'].";".$row_inscrits['statut'].";".$montant);
	}
}while ($row_inscrits = mysql_fetch_assoc($inscrits));
//
mysql_free_result($inscrits);
$fichier->output('maliste'); 
echo "Fichier généré<br/>";
?>