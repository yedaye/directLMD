<?php
    include("../../../connect/co.php"); 
    include("../../../functions/queries.php");
    $array_field=array('valide');
	$array_value=array($_POST['valeur']);
	updTable('autorisation',$array_field,$array_value,'id',$_POST['code'],$pdo);
    echo 1;
?>