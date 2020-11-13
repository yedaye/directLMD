<?php
	include("../../../connect/co.php"); 
    $rs = "delete from ecole_ufr Where code_ecole='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>	