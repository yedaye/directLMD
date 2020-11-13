<?php
	include("../../../connect/co.php"); 
    $rs = "delete from pays Where cod_pays='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>