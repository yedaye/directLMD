<?php
	include("../../../connect/co.php"); 
    $rs = mysql_query("delete from zone Where COD_ZONE='".$_POST['code']."'") or die(mysql_error());
    echo 1;
   	
?>	