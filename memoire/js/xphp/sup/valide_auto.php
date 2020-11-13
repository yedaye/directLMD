<?php
	include("../../../connect/co.php"); 
    $rs = mysql_query("UPDATE autorisation SET valide='".$_POST['valeur']."'Where id='".$_POST['code']."'") or die(mysql_error());
    echo 1;
   	
?>