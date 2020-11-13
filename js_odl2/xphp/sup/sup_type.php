<?php
	include("../../../connect/co.php"); 
    $rs = "delete from type Where id='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>	