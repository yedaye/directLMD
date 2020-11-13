<?php
	include("../../../connect/co.php"); 
    $rs = "delete from inscription Where matricule='".$_POST['matricule']."' AND annee_academique='".$_POST['annee']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>