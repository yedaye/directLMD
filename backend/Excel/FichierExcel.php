<?php
class FichierExcel {
	
private 
	$csv = Null;
	//$nomFichier="montest";
	/**
	 * Cette ligne permet de créer les colonnes du fichers Excel
	 * Cette fonction est totalement faculative, on peut faire la même chose avec la
	 * fonction insertion, c'est juste une clarté pour moi
	 */
	function Colonne($file) {
		
		$this->csv.=$file."\n";
		return $this->csv;
		
	}
	
	/**
	 * Insertion des lignes dans le fichiers Excel, il faut introduire les données sous formes de chaines
	 * de caractère.
	 * Attention a séparer avec une virgule.
	 */
	function Insertion($file){
		
		$this->csv.=$file."\n";
		return $this->csv;
	}
	
	/**
	 * fonction de sortie du fichier avec un nom spécifique.
	 *
	 */
	function output($NomFichier){
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
//		header('Content-Disposition: attachment; filename=file.csv');
		header("Content-disposition: attachment; filename=$NomFichier.csv");
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		echo "\xEF\xBB\xBF"; // UTF-8 BOM
	//	header("content-type:application/csv;charset=UTF-8");
		print $this->csv;
		exit;
	}
}
 
?>
