<?php
    if(!isset($_GET['annee'])){
        header("Location:http://una.bj");
    }else{
        include_once("etudiant/read_one.php");
    }   
?>