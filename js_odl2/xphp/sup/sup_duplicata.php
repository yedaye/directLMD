<?php
	include("../../../connect/co.php"); 
    $rs = "delete from duplicata Where matricule='".$_POST['matricule']."' AND annee_acad='".$_POST['annee']."'";
    $query = $pdo->query($rs);
   	echo "1";
?>	