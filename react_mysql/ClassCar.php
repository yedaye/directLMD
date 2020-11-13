<?php
include("ClassConnexion.php");
 //recuperer la liste des car
class ClassCar extends ClassConnexion {
	public function exibeCarros(){
		$BFetch=$this->connectDB()->prepare("select * from carros");
		$BFetch->execute();
		
		$J=[];
		$I=0;
		
		while($Fetch=$BFetch->fetch(PDO::FETCH_ASSOC)){
			$J[$I]=[
				"Id"=>$Fetch['Id'],
				"Marque"=> $Fetch['Marca'],
				"Modelo"=>$Fetch['Modelo'],
				"Ano"=>$Fetch['Ano']
			];
			$I++;
		}
		
		header("Access-Control-Allow-Origin:*");
		header("Content-type:application/json");
		echo json_encode($J);
		
	}
}
?>