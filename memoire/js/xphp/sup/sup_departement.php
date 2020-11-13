<?php
	include("../../../connect/co.php"); 
    $rs = "delete from departement Where code_dept='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>