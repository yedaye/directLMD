<?php
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");

$err_msg="";
$msg_ajout="";
$msg_modif="";
$msg_dja="";

$etu=selTableMultiAnswer('student','matricule');
//print_r($etudiant);

for($i=0;$i<count($etu);$i++){
	copy("http://inscription.uac.bj/photo_uac/N".$etu[$i]['matricule'].".jpg","photo/".$etu[$i]['matricule'].".jpg");
}
?>