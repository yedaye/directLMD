<?php
	include("../../../connect/co.php"); 
    $rs = "delete from table_ecu_new Where code_ecu='".$_POST['code']."' AND promotion='".$_POST['promo']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>