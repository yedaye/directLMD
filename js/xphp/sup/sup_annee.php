<?php
	include("../../../connect/co.php"); 
    $rs = "delete from annee_academique Where lib_annee='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>