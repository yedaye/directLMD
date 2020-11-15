<?php
///function for app use
function selTableDataDesc($table,$optfield="", $pdo){
   $qry = ($optfield!="")? "SELECT * FROM ".$table." ORDER BY ".$optfield." DESC": "SELECT * FROM ".$table;
   //echo $qry;
   $result = array();
   $stm = $pdo->query($qry);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}
function selTableDataDescLimit($table,$optfield="",$limit, $pdo){
   $qry = ($optfield!="")? "SELECT * FROM ".$table." ORDER BY ".$optfield." DESC LIMIT 0,".$limit : "SELECT * FROM ".$table;
   $result = array();
   $stm = $pdo->query($qry);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
}
function requete($qstr, $pdo){
   $result=array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}
function selTableData($table,$optfield="", $pdo){
    $result=array();
   $qry = ($optfield!="")? "SELECT * FROM ".$table." ORDER BY ".$optfield." ASC": "SELECT * FROM ".$table;
   //echo $qry;
   $stm = $pdo->query($qry);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
        //print_r($row);
        array_push($result,$row);
   }
    //print_r($result);
    return $result;
}
function selTableDataLimit($table,$optfield="",$limit, $pdo){
   $qry = ($optfield!="")? "SELECT * FROM ".$table." ORDER BY ".$optfield." ASC LIMIT 0,".$limit: "SELECT * FROM ".$table;
//   echo $qry;
   $result = array();
   $stm = $pdo->query($qry);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}
function selTableData2Fields($table,$optfield="",$value="",$optfield1="",$value1="", $pdo){
   $qry =  "SELECT * FROM ".$table." WHERE 1";
   $qry .= ($optfield!="" && $value!="")?  " AND ".$optfield."='".$value."' ": "";
   $qry .= ($optfield1!="" && $value1!="")?  "  AND ".$optfield1."='".$value1."'": "";
   $result = array();
   $stm = $pdo->query($qry);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   //print_r($result);
   if(count($result)==1){
      return $result[0];
   }else{
      return $result;
   }
   
 }
 function selTableData2FieldsAsc($table,$optfield="",$value="",$optfield1="",$value1="",$filter, $pdo){
   $qry =  "SELECT * FROM ".$table." WHERE 1";
   $qry .= ($optfield!="" && $value!="")?  " AND ".$optfield."='".$value."' ": "";
   $qry .= ($optfield1!="" && $value1!="")?  "  AND ".$optfield1."='".$value1."'": "";
   $qry .=" ORDER BY ".$filter." ASC";
  // echo $qry;
  $result = array();
  $stm = $pdo->query($qry);
  $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach($rows as $row) {
     array_push($result,$row);
  }
   //print_r($result);
   return $result;
   
 }
 function selTableData3Fields($table,$optfield="",$value="",$optfield1="",$value1="",$optfield2="",$value2="", $pdo){
   $qry =  "SELECT * FROM ".$table." WHERE 1";
   $qry .= ($optfield!="" && $value!="")?  " AND ".$optfield."='".$value."' ": "";
   $qry .= ($optfield1!="" && $value1!="")?  "  AND ".$optfield1."='".$value1."'": "";
   $qry .= ($optfield2!="" && $value2!="")?  "  AND ".$optfield2."='".$value2."'": "";
   $result = array();
   $stm = $pdo->query($qry);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   //print_r($result);
   if(count($result)==1){
      return $result[0];
   }else{
      return $result;
   }
 }
 
 
function selTableDataOr2Fields($table,$optfield="",$value="",$optfield1="",$value1="", $pdo){
   $qry =  "SELECT * FROM ".$table." WHERE ";
   $qry .= ($optfield!="" && $value!="")?  $optfield."='".$value."' ": "";
   $qry .= ($optfield1!="" && $value1!="")?  "  OR ".$optfield1."='".$value1."'": "";
   $result = array();
   $stm = $pdo->query($qry);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   //print_r($result);
   if(count($result)==1){
      return $result[0];
   }else{
      return $result;
   }
 }
function selTableDataUnique($table,$optfield="", $pdo){
   $qry = ($optfield!="")? "SELECT DISTINCT ".$optfield." FROM ".$table." ORDER BY ".$optfield." ASC": "SELECT * FROM ".$table;
   $result = array();
   $stm = $pdo->query($qry);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}
function selTableDataUnique2Fields($table,$optfield="",$optfield2="", $pdo){
   $qry = ($optfield!="")? "SELECT DISTINCT(".$optfield."),".$optfield2." FROM ".$table." ORDER BY ".$optfield." ASC": "SELECT * FROM ".$table;
   $result = array();
   $stm = $pdo->query($qry);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}
function selTableDataUnique3Fields($table,$optfield="",$optfield2="",$optfield3="", $pdo){
   $qry = ($optfield!="")? "SELECT DISTINCT(".$optfield."),".$optfield2.",".$optfield3." FROM ".$table." ORDER BY ".$optfield." ASC": "SELECT * FROM ".$table;
   $result = array();
   $stm = $pdo->query($qry);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}
function selTableDataWhereSpecial($table,$matricule="",$session="", $pdo){
   $qstr = "SELECT * FROM ".$table." WHERE Matricule='".$matricule."' OR (NumTable='".$matricule."' AND SESSION='".$session."')";
	$result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
} 
function selTableDataCount($table,$optfield="",$whereclause="", $pdo){
   $qstr = "SELECT * FROM ".$table;
	if(is_numeric($whereclause)){
		$where = " WHERE ".$optfield."=".$whereclause;
	}else{
		$where = " WHERE ".$optfield."= '".$whereclause."'";
	} 
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   //echo $qstr;
	//$result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result['nombre'];
}

function selTableDataCount2($table,$optfield="",$whereclause="",$optfield2="",$whereclause2="", $pdo){
   $qstr = "SELECT count(*) as nombre FROM ".$table;
   $where="";
	if(is_numeric($whereclause)){
		$where.= " WHERE ".$optfield."=".$whereclause;
	}else{
		$where.= " WHERE ".$optfield."= '".$whereclause."'";
	} 
	if(is_numeric($whereclause2)){
		$where.= " AND ".$optfield2."=".$whereclause2;
	}else{
		$where.= " AND ".$optfield2."= '".$whereclause2."'";
	} 
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
	$result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
return $result['nombre'];
}
function selTableDataWhere($table,$optfield="",$whereclause="", $pdo){
   $nombre=0;
	$qstr = "SELECT * FROM ".$table;
	if(is_numeric($whereclause)){
		$where = " WHERE ".$optfield."=".$whereclause;
	}else{
		$where = " WHERE ".$optfield."= '".$whereclause."'";
	} 
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   //echo $qstr;
	$result = array();
   $stm = $pdo->query($qstr);
   if($stm){ 
      $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
      foreach($rows as $row) {
         array_push($result,$row);
      }  
   } 	
   return $result[0];
}


function selTableMultiAnswer($table,$optfield="",$whereclause="", $pdo){
   	$qstr = "SELECT * FROM ".$table;
	if(is_numeric($whereclause)){
		$where = " WHERE ".$optfield."=".$whereclause;
	}else{
		$where = " WHERE ".$optfield."= '".$whereclause."'";
	} 
   	$qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
      $result = array();
      $stm = $pdo->query($qstr);
      $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
      foreach($rows as $row) {
         array_push($result,$row);
      }
   	return $result;
}

function selTableMultiAnswerAsc($table,$optfield="",$whereclause="",$order="", $pdo){
   $qstr = "SELECT * FROM ".$table;
	if(is_numeric($whereclause)){
		$where = " WHERE ".$optfield."=".$whereclause;
	}else{
		$where = " WHERE ".$optfield."= '".$whereclause."'";
	} 
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $qstr.=" ORDER BY ".$order." ASC";
	$result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}

function selTableDataWhereArray($table,$arrayFields,$arrayValues, $pdo){
   $qstr = "SELECT * FROM ".$table;
   $ar_size=(sizeof($arrayFields)>=sizeof($arrayValues)) ? sizeof($arrayFields):sizeof($arrayValues);
   $where=" WHERE 1";
   for($i=0;$i<$ar_size;$i++){
	   	if(is_numeric($arrayValues[$i])){
		   $where.=(isset($arrayFields[$i]) && isset($arrayValues[$i]) && $arrayFields[$i]!='' && $arrayValues[$i]!='' ) ? " AND ".$arrayFields[$i]." = ".$arrayValues[$i]." ": " ";
	   	}else{
		   $where.=(isset($arrayFields[$i]) && isset($arrayValues[$i]) && $arrayFields[$i]!='' && $arrayValues[$i]!='' ) ? " AND ".$arrayFields[$i]." = '".$arrayValues[$i]."' ": " ";   
		}
   }
   $qstr .= $where ;
   $result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}
function selTableDataWhereDistinctArray($table,$arrayDistinct,$arrayFields,$arrayValues, $pdo){
   $strDistinct="";
   for($i=0;$i<sizeof($arrayDistinct);$i++){
      $strDistinct.=$arrayDistinct[$i];
   }
   $strDistinct=substr($strDistinct,0,-1);
   $qstr = "SELECT DISTINCT ".$strDistinct." FROM ".$table;
   $ar_size=(sizeof($arrayFields)>=sizeof($arrayValues)) ? sizeof($arrayFields):sizeof($arrayValues);
   $where=" WHERE 1";
   for($i=0;$i<$ar_size;$i++){
	  if ($i==count($ar_size)-1){
	     $where.=$arrayFields[$i]."<".$arrayValues[$i]." ORDER BY ".$arrayFields[$i]." DESC";
		 }else
		    $where.=(isset($arrayFields[$i]) && isset($arrayValues[$i]) && $arrayFields[$i]!='' && $arrayValues[$i]!='' ) ? " AND ".$arrayFields[$i]." = '".$arrayValues[$i]."' ": " ";
   }
   $qstr .= $where ;
   $result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}
function numRowWhereDistinctArray($table,$arrayDistinct,$arrayFields,$arrayValues, $pdo){
   $strDistinct="";
   for($i=0;$i<sizeof($arrayDistinct);$i++){
      $strDistinct.=$arrayDistinct[$i].",";
   }
   $strDistinct=substr($strDistinct,0,-1);
   $qstr = "SELECT DISTINCT ".$strDistinct." FROM ".$table;
   $ar_size=(sizeof($arrayFields)>=sizeof($arrayValues)) ? sizeof($arrayFields):sizeof($arrayValues);
   $where=" WHERE 1 ";
   for($i=0;$i<$ar_size;$i++){
	  if ($i==count($ar_size)){
	     $where.=" AND ".$arrayFields[$i]."< '".$arrayValues[$i]."' ORDER BY ".$arrayFields[$i]." DESC";
		 }else
		    $where.=(isset($arrayFields[$i]) && isset($arrayValues[$i]) && $arrayFields[$i]!='' && $arrayValues[$i]!='' ) ? " AND ".$arrayFields[$i]." = '".$arrayValues[$i]."' ": " ";
   }
   $qstr .= $where ;
   $result = array();
   $stm = $pdo->query($qstr);
   $nombre = $stm->rowcount();
  return $nombre;
}
function selTableDataWhereLike($table,$optfield="",$whereclause="", $pdo){
   $qstr = "SELECT * FROM ".$table;
   $where = " WHERE ".$optfield." LIKE '".$whereclause."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   //   return $qstr;
   $result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
} 
function selTableMaxWhereLike($table,$maxfield,$optfield="",$whereclause="", $pdo){
   $qstr = "SELECT MAX(".$maxfield.") as nbre FROM ".$table;
   $where = " WHERE ".$optfield." LIKE '".$whereclause."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
} 
function numRowTableData2Where($table,$optfield="",$whereclause="",$optfield2="",$whereclause2="", $pdo){
   $qstr = "SELECT * FROM ".$table;
   $where = " WHERE ".$optfield." = '".$whereclause."' AND ".$optfield2." = '".$whereclause2."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $stm = $pdo->query($qstr);
   $result = $stm->rowcount();
   return $result;
}
function numRowTableDataWhere($table,$optfield="",$whereclause="", $pdo){
   $qstr = "SELECT * FROM ".$table;
   $where = " WHERE ".$optfield." = '".$whereclause."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $stm = $pdo->query($qstr);
   $result = $stm->rowcount();
   return $result;
}
function numRowTableDataLike($table,$optfield="",$whereclause="", $pdo){
   $qstr = "SELECT * FROM ".$table;
   $where =" WHERE ".$optfield." LIKE '".$whereclause."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $stm = $pdo->query($qstr);
   $result = $stm->rowcount();
   return $result;
}
function numRowTableDataLike2($table,$optfield="",$whereclause="", $pdo){
   $qstr = "SELECT MAX(Matricule) as nombre FROM ".$table;
   $where =" WHERE ".$optfield." LIKE '".$whereclause."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   $lenombre=substr($rows[0]['nombre'],0,-2);
   return $lenombre;
}
function numRowTableDataWhereLike($table,$optfield="",$whereclause="", $pdo){
   $qstr = "SELECT * FROM ".$table;
   $where =" WHERE ".$optfield." LIKE '%".$whereclause."%'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $stm = $pdo->query($qstr);
   $result = $stm->rowcount();
   return $result;
}
function numRowTableDataWhere2Like($table,$optfield="",$whereclause="",$optfield1="",$whereclause1="", $pdo){
   $qstr = "SELECT * FROM ".$table;
   	if(is_numeric($whereclause) || is_numeric($whereclause1)){
		$where = " WHERE ".$optfield." LIKE ".$whereclause." AND ".$optfield1." LIKE ".$whereclause1 ;
   	}else{
		$where =" WHERE ".$optfield." LIKE '".$whereclause."' AND ".$optfield1." LIKE '".$whereclause1."'";
	}
   $qstr .= (($optfield!="" && $whereclause!="") && ($optfield1!="" && $whereclause1!=""))? $where : " ";
   $stm = $pdo->query($qstr);
   $result = $stm->rowcount();
   return $result;
}
function SelRowTableData2Where($table1,$optfield1="",$table2,$optfield2="",$optfield="",$whereclause="", $pdo){
   $qstr = "SELECT * FROM ".$table1.",".$table2;
   $where = " WHERE ".$table1.".".$optfield1." = ".$table2.".".$optfield2." AND ".$table1.".".$optfield." = '".$whereclause."'";
   $qstr .= ($optfield1!="" && $optfield2!="" && $whereclause!="")? $where : " ";
   $result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}
function SelRowTableData2WhereLeftJoin($table1,$optfield1="",$table2,$optfield2="",$optfield="",$whereclause="",$start,$end, $pdo){
   $qstr = "SELECT * FROM ".$table1." LEFT JOIN ".$table2." ON (".$table1.".".$optfield1."=".$table2.".".$optfield2.") ";
   $where = " WHERE ".$table1.".".$optfield." ='".$whereclause."' LIMIT ".$start.",".$end;
   $qstr .= ($optfield1!="" && $optfield2!="" && $whereclause!="")? $where : " ";
   $result = array();
   $stm = $pdo->query($qstr);
   $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
   foreach($rows as $row) {
      array_push($result,$row);
   }
   return $result;
}
function insTable($table,$array_field,$array_value, $pdo){
  $field="";
  $value="";
  $fieldholder="";
  //champ de la table
	foreach($array_field as $fi){
		$field.=$fi.", ";
	}
      $field=substr($field,0,-2);
   // champ du placeholder 
   foreach($array_field as $fi){
		$fieldholder.=":".$fi.", ";
   }
   $fieldholder=substr($fieldholder,0,-2);
   //print_r($field);
   $qstr = "INSERT INTO " .$table." (".$field.") VALUES (".$fieldholder.")";
   $statement = $pdo->prepare($qstr);
   $a=0;
	foreach($array_value as $fi){ 
		$statement->bindValue(':'.$array_field[$a], $fi);
      $a++;
   }  
   $inserted = $statement->execute();	
	//echo $qstr;
	if($inserted){
       echo 'Row inserted!<br>';
   }
}
function updTable($table,$array_field,$array_value,$wherefield,$wherevalue, $pdo){
   $field="";
   $value="";
   $str="";
   $nbre=count($array_field);
   $set="";
	$i=0;
   for($i=0;$i<=$nbre-1;$i++){	
	   $str.=$array_field[$i]."= ? , ";
   }
   $set=substr($str,0,-2);
   //Our UPDATE SQL statement.
   $sql = "UPDATE ".$table." SET ".$set." WHERE ".$wherefield."='".$wherevalue."'";
   //print_r($sql);
   //print_r($array_value);

   $statement = $pdo->prepare($sql);
   /* 
   for($i=0;$i<=$nbre-1;$i++){
      $statement->bindValue("':".$array_field[$i]."'", $array_value[$i], PDO::PARAM_STR);
   } */
   $update = $statement->execute($array_value);
   
}
function updTableWhereArray($table,$array_field,$array_value,$ArWherField,$ArWherVal,$pdo){
   $field="";
   $value="";
   $nbre=count($array_field);
 	$str="";
	$i=0;
   for($i=0;$i<=$nbre-1;$i++){	
	$str.=$array_field[$i]."= ? , ";
   }
   $str=substr($str,0,-2);

	$nbre2=count($ArWherField);
   $str2="";
	$i=0;
   for($i=0;$i<=$nbre2-1;$i++){	
      $str2.=$ArWherField[$i]."='".$ArWherVal[$i]."' AND ";
   }
   $str2=substr($str2,0,-5);

   $qstr = "UPDATE ".$table." SET ".$str." WHERE ".$str2;

   //echo $qstr;
  // print_r($array_value);
   
    //Prepare our UPDATE SQL statement.
   $statement = $pdo->prepare($qstr);
   //binding
   /* for($i=0;$i<=$nbre-1;$i++){
      $statement->bindValue("':".$array_field[$i]."'", $array_value[$i]);
   } */
   $update = $statement->execute($array_value);
}

// function de suppression
function delTable($table,$wherefield,$wherevalue, $pdo){
   $count=$dbo->prepare("DELETE FROM ".$table." WHERE ".$wherefield."=:".$wherefield);
   $count->bindValue(":".$wherefield,$wherevalue);
   $count->execute();
   $no=$count->rowCount();
   echo " No of records deleted = ".$no;
}

/// fin de la fiche
function convertdateanglais($date){
	$ladate=explode('-',$date);
	$jour=$ladate[2];
	$moi=$ladate[1];
	$anne=$ladate[0];
	$madate=date("d/m/Y", mktime(0, 0, 0, $moi, $jour, $anne));
	return $madate;
}
function convertdatebanque($date){
	$ladate=explode('-',$date);
	$jour=$ladate[2];
	$moi=$ladate[1];
	$anne=$ladate[0];
	$madate=date("d/m/Y", mktime(0, 0, 0, $moi, $jour, $anne));
	$date=explode("/",$madate);
	$date=$date[0].$date[1].$date[2];
	return $date;
}
function convertdatefrancais($date){
	$ladate=explode('/',$date);
	$jour=$ladate[0];
	$moi=$ladate[1];
	$anne=$ladate[2];
	$madate=date("Y-m-d", mktime(0, 0, 0, $moi, $jour, $anne));
	return $madate;
}
function genexml($matricule,$nom,$prenom,$datenaissance,$lieunaissance,$telephone,$montantdu,$anneeacademique,$statut,$etablissement,$filiere,$nationalite, $type){
	$xml = new DOMDocument('1.0', 'utf-8');
	//$items = $xml->createElement('id_dataTable');
		$item = $xml->createElement('etudiant');
		$db_item=["matricule"=>$matricule,"nom"=>$nom,"prenom"=>$prenom,"telephone"=>$telephone,"anneeacademique"=>$anneeacademique,"etablissement"=>$etablissement,"anneeEtude"=>$filiere,"nationalite"=>$nationalite,"statut"=>$statut,"montant"=>$montantdu,"categorie"=>$type,"datePaiement"=>"","reftransaction"=>"","intermediairePaiement"=>""];
		foreach($db_item as $key => $value){
			$node = $xml->createElement($key,$value);
			$item->appendChild($node);
		}
		//$items->appendChild($item);
	$xml->appendChild($item);
	$date=date("Y-m-d");
	$date=convertdatebanque($date);
	$xml->save("../UPLOAD/UNA_".$date."_".$matricule."_".$anneeacademique."_".$filiere."_".$type.".xml");
	return true;
}

//generation xml par la banque 
function genexml2($matricule,$nom,$prenom,$datenaissance,$lieunaissance,$telephone,$montantdu,$anneeacademique,$statut,$etablissement,$filiere,$nationalite, $type){
	$xml = new DOMDocument('1.0', 'utf-8');
	//$items = $xml->createElement('id_dataTable');
		$item = $xml->createElement('etudiant');
		$db_item=["matricule"=>$matricule,"nom"=>$nom,"prenom"=>$prenom,"telephone"=>$telephone,"anneeacademique"=>$anneeacademique,"etablissement"=>$etablissement,"anneeEtude"=>$filiere,"nationalite"=>$nationalite,"statut"=>$statut,"montant"=>$montantdu,"categorie"=>$type,"datePaiement"=>"","reftransaction"=>"","intermediairePaiement"=>""];
		foreach($db_item as $key => $value){
			$node = $xml->createElement($key,$value);
			$item->appendChild($node);
		}
		//$items->appendChild($item);
	$xml->appendChild($item);
	$date=date("Y-m-d");
	$date=convertdatebanque($date);
	
	return $xml->saveXML();
}

function num_matricule($statut,$cycle,$annee_etude,$ufr,$ecole,$pdo){
	$annee_etude=substr($annee_etude,-2);
	$ordre=numRowTableDataWhereLike("student","matricule","%".$annee_etude,$pdo);
	$ordre=$ordre+1;
	if(strlen($ordre)==1){
		$ordre="0000".$ordre;	
	}
	if(strlen($ordre)==2){
		$ordre="000".$ordre;	
	}
	if(strlen($ordre)==3){
		$ordre="00".$ordre;	
	}
	if(strlen($ordre)==4){
		$ordre="0".$ordre;	
	}
	$matricule=$statut.$cycle.$ordre.$ufr.$ecole.$annee_etude."UNA";
	return $matricule;
}

//generation du numero de la fiche
function numfiche($pdo){
	$testnum=1;
	while($testnum>0){
			$val1=lettre_mdp(3);
			$val2=chiffre_mdp(999);
		$val3=lettre_mdp(3);
		$numfiche1=$val1.$val2.$val3;
		$testnum=numRowTableDataWhere('inscription','num_inscription',$numfiche1,$pdo);
	}
	return $numfiche1;
}

function lettre_mdp($len = 2){
	$r = '';
   	for($i=0; $i<$len; $i++)
       $r .=chr(rand(0, 25) + ord('a'));
       return $r;
}
function chiffre_mdp($len = 5){   	
       $r=rand(0, $len);
       return $r;
}
 //Cette fonction g�n�re l'ordre du nouveau �tudiant dans  avec comme argument le nombre actuel d'etudiant dans la categorie.
function stuOrder($cstu){
	$order="";
	$cstu++;
	$numberlimit=array(9,99,999,9999);
	for($i=3;$i>=0;$i--){
	   if ($cstu<=$numberlimit[$i])
		   $order.="0";
	}
	$order=$order.$cstu;
	return $order;
}
///numero autorisation
function num_autorisation($annee_etude,$type_auto,$pdo){
	$ordre=numRowTableDataWhere("autorisation","annee_auto",$annee_etude,$pdo);
	$ordre=$ordre+1;
	if($type_auto==1){
		$num_auto="CUOUNA".$ordre;
	}else{
		$num_auto="AUTOUNA".$ordre;
	}
	return $num_auto;
}


function datecorrect($dateold){
   //correction date de naissance
   if(strpos($dateold,"/") > 0){
      $date=str_replace("/","-",$dateold);
   }else{
      //$date=$row['date_naissance'];
      $dates=explode("-",$dateold);
      $date=$dates[2]."-".$dates[1]."-".$dates[0];
   }
   return $date;
}
?>