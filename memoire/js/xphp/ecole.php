<?php
	include("../../connect/co.php"); 
	 
    $rs = "select ufr.code_ufr,lib_ecole,code_ecole from ufr,ecole_ufr WHERE ecole_ufr.code_ufr=ufr.code_ufr AND actif=1";
    
    $items = array();
    $stm = $pdo->query($rs);
    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach($rows as $row) {
        array_push($items,$row); 
		$rs2 = "select departement from ecole_dpt WHERE ecole='".$row['code_ecole']."' ORDER BY departement ASC";
        $stm2 = $pdo->query($rs2);
        $rows2 = $stm2->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows2 as $row2) {
            $item=array('code_ufr'=>$row['code_ufr'], 'lib_ecole'=>$row['lib_ecole'].' / '.$row2['departement'], 'code_ecole'=>$row2['departement'].'-'.$row['code_ecole']);
				array_push($items,$item);
        }
		
        array_push($result,$row);
    }
    return $result;
    //$result["rows"] = $items;  
      print_r($items);
    echo json_encode($items,$rs);  
?>