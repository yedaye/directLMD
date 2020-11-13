<?php
function selTableDataDesc($table,$optfield=""){
   $qry = ($optfield!="")? "SELECT * FROM ".$table." ORDER BY ".$optfield." DESC": "SELECT * FROM ".$table;
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
}
function selTableDataDescLimit($table,$optfield="",$limit){
   $qry = ($optfield!="")? "SELECT * FROM ".$table." ORDER BY ".$optfield." DESC LIMIT 0,".$limit : "SELECT * FROM ".$table;
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
}
function requete($qstr){
   $rs = mysql_query($qstr) or die(mysql_error());
   $result=array();
   while($row=mysql_fetch_array($rs)){
      array_push($result,$row);
   }
   return $result;
}
function selTableData($table,$optfield=""){
   $qry = ($optfield!="")? "SELECT * FROM ".$table." ORDER BY ".$optfield." ASC": "SELECT * FROM ".$table;
//   echo $qry;
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
}
function selTableDataLimit($table,$optfield="",$limit){
   $qry = ($optfield!="")? "SELECT * FROM ".$table." ORDER BY ".$optfield." ASC LIMIT 0,".$limit: "SELECT * FROM ".$table;
//   echo $qry;
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
}
function selTableData2Fields($table,$optfield="",$value="",$optfield1="",$value1=""){
   $qry =  "SELECT * FROM ".$table." WHERE 1";
   $qry .= ($optfield!="" && $value!="")?  " AND ".$optfield."='".$value."' ": "";
   $qry .= ($optfield1!="" && $value1!="")?  "  AND ".$optfield1."='".$value1."'": "";
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
 }
 function selTableData2FieldsAsc($table,$optfield="",$value="",$optfield1="",$value1="",$filter){
   $qry =  "SELECT * FROM ".$table." WHERE 1";
   $qry .= ($optfield!="" && $value!="")?  " AND ".$optfield."='".$value."' ": "";
   $qry .= ($optfield1!="" && $value1!="")?  "  AND ".$optfield1."='".$value1."'": "";
   $qry .=" ORDER BY ".$filter." ASC";
  // echo $qry;
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
 }
 function selTableData3Fields($table,$optfield="",$value="",$optfield1="",$value1="",$optfield2="",$value2=""){
   $qry =  "SELECT * FROM ".$table." WHERE 1";
   $qry .= ($optfield!="" && $value!="")?  " AND ".$optfield."='".$value."' ": "";
   $qry .= ($optfield1!="" && $value1!="")?  "  AND ".$optfield1."='".$value1."'": "";
   $qry .= ($optfield2!="" && $value2!="")?  "  AND ".$optfield2."='".$value2."'": "";
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
 }
 
 
function selTableDataOr2Fields($table,$optfield="",$value="",$optfield1="",$value1=""){
   $qry =  "SELECT * FROM ".$table." WHERE ";
   $qry .= ($optfield!="" && $value!="")?  $optfield."='".$value."' ": "";
   $qry .= ($optfield1!="" && $value1!="")?  "  OR ".$optfield1."='".$value1."'": "";
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
 }
function selTableDataUnique($table,$optfield=""){
   $qry = ($optfield!="")? "SELECT DISTINCT ".$optfield." FROM ".$table." ORDER BY ".$optfield." ASC": "SELECT * FROM ".$table;
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
	}
   return $result;
}
function selTableDataUnique2Fields($table,$optfield="",$optfield2=""){
   $qry = ($optfield!="")? "SELECT DISTINCT(".$optfield."),".$optfield2." FROM ".$table." ORDER BY ".$optfield." ASC": "SELECT * FROM ".$table;
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
	}
   return $result;
}
function selTableDataUnique3Fields($table,$optfield="",$optfield2="",$optfield3=""){
   $qry = ($optfield!="")? "SELECT DISTINCT(".$optfield."),".$optfield2.",".$optfield3." FROM ".$table." ORDER BY ".$optfield." ASC": "SELECT * FROM ".$table;
   $rs = mysql_query($qry) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
	}
   return $result;
}
function selTableDataWhereSpecial($table,$matricule="",$session=""){
   $qstr = "SELECT * FROM ".$table." WHERE Matricule='".$matricule."' OR (NumTable='".$matricule."' AND SESSION='".$session."')";
	$rs = mysql_query($qstr) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
} 
function selTableDataCount($table,$optfield="",$whereclause=""){
   $qstr = "SELECT count(*) as nombre FROM ".$table;
	if(is_numeric($whereclause)){
		$where = " WHERE ".$optfield."=".$whereclause;
	}else{
		$where = " WHERE ".$optfield."= '".$whereclause."'";
	} 
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
	$rs = mysql_query($qstr) or die(mysql_error());
   $result = mysql_fetch_assoc($rs);
return $result['nombre'];
}
function selTableDataCount2($table,$optfield="",$whereclause="",$optfield2="",$whereclause2=""){
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
	$rs = mysql_query($qstr) or die(mysql_error());
   $result = mysql_fetch_assoc($rs);
return $result['nombre'];
}
function selTableDataWhere($table,$optfield="",$whereclause=""){
	$result="";
	$qstr = "SELECT * FROM ".$table;
	if(is_numeric($whereclause)){
		$where = " WHERE ".$optfield."=".$whereclause;
	}else{
		$where = " WHERE ".$optfield."= '".$whereclause."'";
	} 
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   //echo $qstr;
	$rs = mysql_query($qstr) or die(mysql_error());
	$nombre=mysql_num_rows($rs);
	//echo $nombre;
	if($nombre>0){
		$result = mysql_fetch_assoc($rs);
	}
   	return $result;
}


function selTableMultiAnswer($table,$optfield="",$whereclause=""){
   	$qstr = "SELECT * FROM ".$table;
	if(is_numeric($whereclause)){
		$where = " WHERE ".$optfield."=".$whereclause;
	}else{
		$where = " WHERE ".$optfield."= '".$whereclause."'";
	} 
   	$qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
	$rs = mysql_query($qstr) or die(mysql_error());
   	$result = array();
   	while ($row=mysql_fetch_assoc($rs)){
        array_push($result,$row);
   	}
   	return $result;
}

function selTableMultiAnswerAsc($table,$optfield="",$whereclause="",$order=""){
   $qstr = "SELECT * FROM ".$table;
	if(is_numeric($whereclause)){
		$where = " WHERE ".$optfield."=".$whereclause;
	}else{
		$where = " WHERE ".$optfield."= '".$whereclause."'";
	} 
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $qstr.=" ORDER BY ".$order." ASC";
	$rs = mysql_query($qstr) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_assoc($rs)){
        array_push($result,$row);
   }
   return $result;
}

function selTableDataWhereArray($table,$arrayFields,$arrayValues){
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
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
}
function selTableDataWhereDistinctArray($table,$arrayDistinct,$arrayFields,$arrayValues){
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
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
}
function numRowWhereDistinctArray($table,$arrayDistinct,$arrayFields,$arrayValues){
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
   $recs=mysql_query($qstr) or die(mysql_error());
   $rs = mysql_num_rows($recs);
  return $rs;
}
function selTableDataWhereLike($table,$optfield="",$whereclause=""){
   $qstr = "SELECT * FROM ".$table;
   $where = " WHERE ".$optfield." LIKE '".$whereclause."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
//   return $qstr;
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
} 
function selTableMaxWhereLike($table,$maxfield,$optfield="",$whereclause=""){
   $qstr = "SELECT MAX(".$maxfield.") as nbre FROM ".$table;
   $where = " WHERE ".$optfield." LIKE '".$whereclause."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
} 
function numRowTableData2Where($table,$optfield="",$whereclause="",$optfield2="",$whereclause2=""){
   $qstr = "SELECT * FROM ".$table;
   $where = " WHERE ".$optfield." = '".$whereclause."' AND ".$optfield2." = '".$whereclause2."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = mysql_num_rows($rs);
   return $result;
}
function numRowTableDataWhere($table,$optfield="",$whereclause=""){
   $qstr = "SELECT * FROM ".$table;
   $where = " WHERE ".$optfield." = '".$whereclause."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = mysql_num_rows($rs);
   return $result;
}
function numRowTableDataLike($table,$optfield="",$whereclause=""){
   $qstr = "SELECT * FROM ".$table;
   $where =" WHERE ".$optfield." LIKE '".$whereclause."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = mysql_num_rows($rs);
   return $result;
}
function numRowTableDataLike2($table,$optfield="",$whereclause=""){
   $qstr = "SELECT MAX(Matricule) as nombre FROM ".$table;
   $where =" WHERE ".$optfield." LIKE '".$whereclause."'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = mysql_fetch_assoc($rs);
   $lenombre=substr($result['nombre'],0,-2);
   return $lenombre;
}
function numRowTableDataWhereLike($table,$optfield="",$whereclause=""){
   $qstr = "SELECT * FROM ".$table;
   $where =" WHERE ".$optfield." LIKE '%".$whereclause."%'";
   $qstr .= ($optfield!="" && $whereclause!="")? $where : " ";
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = mysql_num_rows($rs);
   return $result;
}
function numRowTableDataWhere2Like($table,$optfield="",$whereclause="",$optfield1="",$whereclause1=""){
   $qstr = "SELECT * FROM ".$table;
   	if(is_numeric($whereclause) || is_numeric($whereclause1)){
		$where = " WHERE ".$optfield." LIKE ".$whereclause." AND ".$optfield1." LIKE ".$whereclause1 ;
   	}else{
		$where =" WHERE ".$optfield." LIKE '".$whereclause."' AND ".$optfield1." LIKE '".$whereclause1."'";
	}
   $qstr .= (($optfield!="" && $whereclause!="") && ($optfield1!="" && $whereclause1!=""))? $where : " ";
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = mysql_num_rows($rs);
   return $result;
}
function SelRowTableData2Where($table1,$optfield1="",$table2,$optfield2="",$optfield="",$whereclause=""){
   $qstr = "SELECT * FROM ".$table1.",".$table2;
   $where = " WHERE ".$table1.".".$optfield1." = ".$table2.".".$optfield2." AND ".$table1.".".$optfield." = '".$whereclause."'";
   $qstr .= ($optfield1!="" && $optfield2!="" && $whereclause!="")? $where : " ";
   $rs = mysql_query($qstr) or die(mysql_error());
   $result=array();
   while($row= mysql_fetch_array($rs)){
      array_push($result,$row);
   }
   return $result;
}
function SelRowTableData2WhereLeftJoin($table1,$optfield1="",$table2,$optfield2="",$optfield="",$whereclause="",$start,$end){
   $qstr = "SELECT * FROM ".$table1." LEFT JOIN ".$table2." ON (".$table1.".".$optfield1."=".$table2.".".$optfield2.") ";
   $where = " WHERE ".$table1.".".$optfield." ='".$whereclause."' LIMIT ".$start.",".$end;
   $qstr .= ($optfield1!="" && $optfield2!="" && $whereclause!="")? $where : " ";
   $rs = mysql_query($qstr) or die(mysql_error());
   $result=array();
   while($row= mysql_fetch_array($rs)){
      array_push($result,$row);
   }
   return $result;
}
function insTable($table,$array_field,$array_value){
  $field="";
  $value="";
	foreach($array_field as $fi){
		$field.=$fi.", ";
	}
   	$field=substr($field,0,-2);
	//print_r($field);
	foreach($array_value as $fi){ 
		$value.="'".$fi."', ";
	}
   	$value=substr($value,0,-2);
  	$qstr = "INSERT INTO " .$table." (".$field.") VALUES (".$value.")";
	//echo $qstr;
	$rs=mysql_query($qstr) or die(mysql_error());
}
function updTable($table,$array_field,$array_value,$wherefield,$wherevalue){
   $field="";
   $value="";
   $nbre=count($array_field);
   $str="";
	$i=0;
   for($i=0;$i<=$nbre-1;$i++){	
	$str.=$array_field[$i]."='".$array_value[$i]."', ";
   }
   $str=substr($str,0,-2);
   $qstr = "UPDATE ".$table." SET ".$str." WHERE ".$wherefield."='".$wherevalue."'";
   $rs=mysql_query($qstr) or die(mysql_error());
}
function delTable($table,$wherefield,$wherevalue){
   $qstr = "DELETE FROM ".$table." WHERE ".$wherefield."='".$wherevalue."'";
   $rs=mysql_query($qstr) or die(mysql_error());
}
function updTableWhereArray($table,$array_field,$array_value,$ArWherField,$ArWherVal){
   $field="";
   $value="";
   $nbre=count($array_field);
 	$str="";
	$i=0;
   for($i=0;$i<=$nbre-1;$i++){	
	$str.=$array_field[$i]."='".$array_value[$i]."', ";
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
   $rs=mysql_query($qstr) or die(mysql_error());
}
function updTableWhereNotInOrIn($table,$array_field,$array_value,$whf1,$whf2,$ecole){
   $field="";
   $value="";
   $nbre=count($array_field);
 	$str="";
	$i=0;
   for($i=0;$i<=$nbre-1;$i++){	
	$str.=$array_field[$i]."=`".$array_value[$i]."`, ";
   }
   $str=substr($str,0,-2);
   $qstr = "UPDATE ".$table." SET ".$str." WHERE ".$whf1." NOT IN ".$ecole." AND ".$whf2." IN ".$ecole ;
   $rs=mysql_query($qstr) or die(mysql_error());
}
function selTableDataLinks($table1,$table2,$table3,$linkf1,$linkf2,$linkvalue){
  	$qstr = "SELECT * FROM ".$table1.",".$table2.",".table3." WHERE ".$table1.".".$linkf1."=".$table2.".".$linkf1." AND ".$table2.".".$linkf2."=".			
  	$table3.".".$linkf2." AND ".linkf2." = ".$linkvalue;
  	$rs = mysql_query($qstr) or die(mysql_error());
   	$result = array();
   	while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   	}
	return $result;
}
function selTableDataLink($table1,$table2,$table3,$linkf1){
  $qstr = "SELECT * FROM ".$table1.",".$table2." WHERE ".$table1.".".$linkf1."=".$table2.".".$linkf1;
   $rs = mysql_query($qstr) or die(mysql_error());
   $result = array();
   while ($row=mysql_fetch_array($rs)){
        array_push($result,$row);
   }
   return $result;
}
function date_expiration($date){
	//décomposition de la date pour mieu comprendre
	$ladate=explode('-',$date);
	$anne=$ladate[0];
	$moi=$ladate[1];
	$jour=$ladate[2];
	$jour=round($jour+30);
	$madate=date("d-m-Y", mktime(0, 0, 0, $moi, $jour, $anne));
	$result=$madate;
	return $result;
}
function comparedate($date1,$date2){
	$ladate1=explode('-',$date1);
	$anne1=$ladate1[0];
	$moi1=$ladate1[1];
	$jour1=$ladate1[2];
	$jour1=round($jour1+30);
	$ladate2=explode('-',$date2);
	$anne2=$ladate2[0];
	$moi2=$ladate2[1];
	$jour2=$ladate2[2];
	$verifdate1=mktime(0, 0, 0, $moi1, $jour1, $anne1);
	$verifdate2=mktime(0, 0, 0, $moi2, $jour2, $anne2);
	$ess=$verifdate1-$verifdate2;
	$result="";
	if($ess<604800){
		$result="faux";
	}
	if($ess<0){
		$result="vrai";
	}
	return $result;
}
function envoiemail($mail,$sujet,$message){
    $headers ="From: info\n";
     $headers .='Reply-To: info@uac.bj'."\n";
     $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
     $headers .='Content-Transfer-Encoding: 8bit';

     if(mail($mail,$sujet,$message,$headers))
     {
          $result='Le message a bien &eacutes;t&eacutes; envoy&eacutes; &agraves;  '.$mail;
     }
     else
     {
          $result='Le message n\'a pu &ecirc;tre envoy&eacutes;';
     } 
   return $result;
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
 //Cette fonction génére l'ordre du nouveau étudiant dans  avec comme argument le nombre actuel d'etudiant dans la categorie.
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
///////////////////// génération du numero de la fiche
function numfiche(){
	$testnum=1;
	while($testnum>0){
			$val1=lettre_mdp(3);
			$val2=chiffre_mdp(999);
		$val3=lettre_mdp(3);
		$numfiche1=$val1.$val2.$val3;
		$testnum=numRowTableDataWhere('inscription','num_inscription',$numfiche1);
	}
	return $numfiche1;
}
function num_matricule($statut,$cycle,$annee_etude,$ufr,$ecole){
	$annee_etude=substr($annee_etude,-2);
	$ordre=numRowTableDataWhereLike("student","matricule","%".$annee_etude);
	//echo "§/§/§".$ordre."/§/§/§/".$annee_etude;
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

///numero autorisation
function num_autorisation($annee_etude,$type_auto){
	$ordre=numRowTableDataWhere("autorisation","annee_auto",$annee_etude);
	$ordre=$ordre+1;
	if($type_auto==1){
		$num_auto="CUOUNA".$ordre;
	}else{
		$num_auto="AUTOUNA".$ordre;
	}
	return $num_auto;
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
function genexml($matricule,$nom,$prenom,$datenaissance,$lieunaissance,$telephone,$montant,$anneeacademique,$statut,$etablissement,$filiere,$nationalite, $type){
	$xml = new DOMDocument('1.0', 'utf-8');
	//$items = $xml->createElement('id_dataTable');
		$item = $xml->createElement('etudiant');
		$db_item=["matricule"=>$matricule,"nom"=>$nom,"prenom"=>$prenom,"telephone"=>$telephone,"anneeacademique"=>$anneeacademique,"etablissement"=>$etablissement,"anneeEtude"=>$filiere,"nationalite"=>$nationalite,"statut"=>$statut,"montant"=>$montant,"categorie"=>$type,"datePaiement"=>"","reftransaction"=>"","intermediairePaiement"=>""];
		foreach($db_item as $key => $value){
			$node = $xml->createElement($key,$value);
			$item->appendChild($node);
		}
		//$items->appendChild($item);
	$xml->appendChild($item);
	$date=date("Y-m-d");
	$date=convertdatebanque($date);
	$xml->save("../UPLOAD/UNA_".$date."_".$matricule."_".$anneeacademique."_".$filiere."_Inscription.xml");
	return "Fichier généré";
}

?>