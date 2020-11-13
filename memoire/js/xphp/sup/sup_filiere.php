<?php
	include("../../../connect/co.php"); 
    $rs = "delete from filiere Where code='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>