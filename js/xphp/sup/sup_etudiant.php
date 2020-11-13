<?php
	include("../../../connect/co.php"); 
    $rs = "delete from student Where matricule='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>	