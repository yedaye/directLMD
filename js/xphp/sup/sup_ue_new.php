<?php
	include("../../../connect/co.php"); 
    $rs = mysql_query("delete from table_ue_new Where code_ue='".$_POST['code']."' AND promotion='".$_POST['promo']."'") or die(mysql_error());
    echo 1;
   	
?>