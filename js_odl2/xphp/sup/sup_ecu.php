<?php
	include("../../../connect/co.php"); 
    $rs = "delete from table_ecu Where code_ecu='".$_POST['code']."'";
    $query = $pdo->query($rs);
    echo 1;
   	
?>