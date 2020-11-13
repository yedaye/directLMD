<?php
session_start();
	//recuperation du db name
if (is_file("../../connect/co.php"))
	include_once ("../../connect/co.php");
if (is_file("../../functions/queries.php"))
	include_once("../../functions/queries.php");
if (is_file("../../param.php"))
	include_once("../../param.php");
	if($db){
		if($_POST['lemode']=="bachelier"){
			$test=selTableData2Fields("resultatbac","NumTable",$_POST['lenum'],"session",$_POST['lasession'],"",$pdo);
			print_r($test);
			if(count($test)>0){
				if(in_array($test[0]['Serie'],array("D","C","E","F1","F2","F3","F4","DTI","DEAT","DT","EA"))){
					echo "<input type='hidden' value='OUI' id='montest'>";	
				}else{
					echo "<input type='hidden' value='BAC' id='montest'>";	
				}			
			}else{
				echo "<input type='hidden' value='NON' id='montest'>";	
			}
		};
		if($_POST['lemode']=="reinscription"){
			$test=selTableMultiAnswer("student","matricule",$_POST['lenum'],$pdo);
			//echo $_POST['lenum']."/////".count($test);
			if(count($test)>0){
				echo "<input type='hidden' value='OUI' id='montest'>";	
			}else{
				echo "<input type='hidden' value='NON' id='montest'>";	
			}
		};
		if($_POST['lemode']=="autorisation"){
			$qstr1 = "SELECT * FROM autorisation WHERE annee_auto='".$anneeEtude."' AND code_auto='".$_POST['lecode']."' AND valide='OUI' AND annee_auto='".$anneeEtude."'";
			$queryb = $pdo->query($qstr1);
			$nombre = $queryb->rowcount();
			if($nombre>0){
				echo "<input type='hidden' value='OUI' id='montest'>";	
			}else{
				echo "<input type='hidden' value='NON' id='montest'>";	
			}
		};
	}
?>