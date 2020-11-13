<?php
	include("../../../connect/co.php"); 
    $rs = mysql_query("delete from verdict Where id='".$_POST['code']."'") or die(mysql_error());
    echo 1;
   	
?>	