<?php
abstract class ClassConnexion {
    #connexion a la base de donnée
    protected function connectDB(){
        try{
            $Con=new PDO("mysql:host=localhost;dbname=inscription",'admin','R@@t2019');
            return $Con;
        }catch(PDOException $Erro){
            return $Erro->getMessage();
        }
    }
}

?>