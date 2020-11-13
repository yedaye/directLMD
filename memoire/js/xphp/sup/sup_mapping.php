<?php
	include("../../../connect/co.php"); 
    $rs = "delete from mapping Where id='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>