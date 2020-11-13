<?php
	//$user="root";
	$user="admin";
	//$pwd="Un@_U@k_2018";
	$pwd="R@@t2019";
	$host="localhost";
	$db="inscription";
	$cnx=mysql_connect($host,$user,$pwd) or die(mysql_error());
	if($cnx){$db=mysql_select_db($db,$cnx) or die("An error occurs while attempting to connect to database :"." ".$db);}
?>
