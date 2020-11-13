<?php
	include("../../../connect/co.php"); 
    $rs = mysql_query("delete from ufr Where code_ufr='".$_POST['code']."'") or die(mysql_error());
    echo 1;
   	
?>