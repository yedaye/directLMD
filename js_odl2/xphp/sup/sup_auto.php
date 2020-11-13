<?php
	include("../../../connect/co.php"); 
    $rs = "delete from autorisation Where id='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>