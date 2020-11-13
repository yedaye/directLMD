<?php
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");

$liste=selTableDataWhereLike("inscription","annee_academique","2017-2018");
for($i=0; $i<count($liste); $i++){
	echo "matricule généré : ".$liste[$i]['matricule'];
	$nom=selTableDataWhere("student","matricule",$liste[$i]['matricule']);
	//print_r($nom);
	$montant = $liste[$i]['FI']+$liste[$i]['FF'];
	$ecole=explode("-",$liste[$i]['filiere']);
	$ecole=$ecole[1];
	$xmlfile=genexml($nom['matricule'],$nom['nom'],$nom['prenoms'],$nom['date_naissance'],$nom['lieu_naissance'],$nom['telephone'],$montant,$liste[$i]['annee_academique'],$liste[$i]['statut'],$ecole,$liste[$i]['filiere'],$nom['Nationalite'],"inscription");
	echo "<br/>";
}
?>