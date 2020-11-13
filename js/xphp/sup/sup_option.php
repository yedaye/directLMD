<?php
	include("../../../connect/co.php"); 
    $rs = "delete from options Where code='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>	