<?php
include("ClassConnexion.php");
 //recuperer la liste des car
class ClassAnneeAcad extends ClassConnexion {
	public function ListAnnee(){
		$BFetch=$this->connectDB()->prepare("select * from annee_academique");
		$BFetch->execute();
		
		$J=[];
		$I=0;
		
		while($Fetch=$BFetch->fetch(PDO::FETCH_ASSOC)){
			$J[$I]=[
				"Libele"=>$Fetch['lib_annee'],
				"Date_debut"=> $Fetch['date_debut'],
				"Date_fin"=>$Fetch['date_fin']
			];
			$I++;
		}
		
		header("Access-Control-Allow-Origin:*");
		header("Content-type:application/json");
		echo json_encode($J);
		
	}
}
?>