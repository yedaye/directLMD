<?php
	include("../../../connect/co.php"); 
    $rs = mysql_query("delete from table_ue Where code_ue='".$_POST['code']."'") or die(mysql_error());
    echo 1;
   	
?>