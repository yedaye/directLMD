<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json;charset=UTF-8');
  
// include database and object files
include_once 'config/database.php';
include_once 'objects/etudiant.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare product object
$etudiant = new Etudiant($db);
  
// set ID property of record to read
$etudiant->annee = isset($_GET['annee']) ? $_GET['annee'] : die();
  
// read the details of product to be edited
$stmt=$etudiant->readOne();
$num = $stmt->rowCount();
  
// check if more than 0 record found
//echo $num;
if($num>0){
  
    // products array
    $etudiants_arr=array();
    $etudiants_arr["etudiants"]=array();

  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
       // extract($row);
            // set values to object properties
            $specialite=$row['filiere'];
            $specialite=explode("-",$specialite);
            $doc=array("D1,2","D3,4","D5,6");

            if(!in_array($specialite[0],$doc)){
                $codspec=substr($row['filiere'],6);
            }else{
                $codspec=substr($row['filiere'],5);
            }

            //correction date de naissance
            if(strpos($row['date_naissance'],"/") > 0){
                $date=str_replace("/","-",$row['date_naissance']);
            }else{
                //$date=$row['date_naissance'];
                $dates=explode("-",$row['date_naissance']);
                $date=$dates[2]."-".$dates[1]."-".$dates[0];
            }
  
        $etudiant_item=array(
            "matricule" => $row['matricule'],
            "nom"=>$row['nom'],
            "prenoms"=>trim($row['prenoms']),
           "date_naissance"=>$date,
            "lieu_naissance"=>$row['lieu_naissance'],
            "entite"=>$row['ecole'],
            "libspecialite"=>$row['libelle'],
            "codspecialite"=>$codspec,
            "codeanetude"=>$specialite[0],
            "telephone"=>"+229".trim($row['telephone']),
            "emailperso"=>$row['email'],
            "emailuak"=>$row['email_uak']."@etu.una.bj",
            "username"=>$row['email_uak']
        );
  
        array_push($etudiants_arr["etudiants"], $etudiant_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($etudiants_arr, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT |  JSON_UNESCAPED_UNICODE);
}else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "Pas d'étudiant au cours de cette année")
    );
}
?>