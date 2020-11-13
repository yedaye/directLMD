<?php
//print_r($_POST);
if (is_file("connect/co.php"))
	include_once ("connect/co.php");
if (is_file("functions/queries.php"))
	include_once ("functions/queries.php");
///webservice uakbenin pour la génération des xml de la banque

//code de la webservice 
/* require the user as the parameter */
if(isset($_POST['matricule'])) {

	
	$format = strtolower($_POST['format']) == 'xml' ? 'xml' : 'json'; //xml is the default
	$matricule=$_POST['matricule'];
    $annee=$_POST['anneeAcademique'];
    $filiere=$_POST['anneeEtude'];
    $user=$_POST['banqueIdentifiant'];
    $mp=$_POST['banquePassword'];
    
    //controle de la concordance des ientifiants
    if($user="EcobankUna" && $mp="680dce0f694c7faffeb876681e109a5d"){

    $etudiant=selTableDataWhere("student","matricule",$matricule);
        
   //controle étudiant
    if(count($etudiant)==0){ 
        echo "Ce numéro n'appartient à aucun étudiant";
        break;
    }
    $inscription=selTableData3Fields("inscription","matricule",$matricule,"annee_academique",$annee,"filiere",$filiere);

    $montantdu=$inscription[0]['FF']+$inscription[0]['FI']+$inscription[0]['montant_reprise'];

    $ecole=selTableDataWhere('filiere','code',$inscription[0]['filiere']);
		
    //$xmlfile=genexml2($_POST['matricule'],$etudiant['nom'],$etudiant['prenoms'],$etudiant['date_naissance'],$etudiant['lieu_naissance'],$etudiant['telephone'],$montantdu,$inscription[0]['annee_academique'],$inscription[0]['statut'],$ecole['ecole'],$inscription[0]['filiere'],$etudiant['nationalite'],"inscription");

	//	echo $xmlfile;

	

	/* create one master array of the records */
	$etudiants=array("etudiant"=>array("matricule"=>$matricule,"nom"=>$etudiant['nom'],"prenom"=>$etudiant['prenoms'],"telephone"=>$etudiant['telephone'],"anneeAcademique"=>$annee,"etablissement"=>$ecole['ecole'],"anneeEtude"=>$inscription[0]['filiere'],"nationalite"=>$etudiant['nationalite'],"statut"=>$inscription[0]['statut'],"montant"=>$montantdu,"categorie"=>"inscription","datePaiement"=>"","reftransaction"=>"","intermediairePaiement"=>"","banqueIdentifiant"=>"","banquePassword"=>""));
  //  $collections = array("collection"=>$etudiant);
        
    
    /*    
	if(mysql_num_rows($result)) {
		while($collection = mysql_fetch_assoc($result)) {
			$posts[] = array('post'=>$post);
		}
	}
    */

	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('collection'=>$etudiants));
	}
	else {
		header('Content-type: text/xml');
		echo '<collection>';
            echo "<etudiant>";
		foreach($etudiants as $index => $post) {
           /* print_r($etudiants);
            echo "<br/>";
            print_r($index);
            echo "<br/>";
            print_r($post);
            break;*/
			if(is_array($post)) {
				foreach($post as $key => $value) {
					echo '<',$key,'>';
				    echo htmlentities($value);
					echo '</',$key,'>';
				}
			}
		}
            echo "</etudiant>";
		echo '</collection>';
	}

    }else{
        echo "vous n'êtes pas autorisé à utiliser ce service";
    }
}

?>