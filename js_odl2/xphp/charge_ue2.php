<?php
	//recuperation du db name
if (is_file("../../connect/co.php"))
	include_once ("../../connect/co.php");
if (is_file("../../functions/queries.php"))
	include_once("../../functions/queries.php");
if (is_file("../../param.php"))
	include_once("../../param.php");
	

//fin variable	


	if($db){
		if($_GET['lep']!=""){
			if($_GET['letype']=='ajout'){
				$titre='code_ue';
			}else{
				$titre='code_ue2';
			}
			$qstr1="SELECT * FROM table_ue_new WHERE promotion='".$_GET['lep']."'";
	//echo $qstr1;
			$liste=requete($qstr1);
//					$queryb=mysql_query($qstr1) or die(mysql_error());
			if(count($liste)>0){
				echo "<select required='true' name='".$titre."' id='".$titre."'>";
				<?php
					for($i=0;$i<count($liste);$i++){
						echo "<option value='".$liste[$i]['code_ue']."'>(".$liste[$i]['code_ue'].")(".utf8_encode($liste[$i]['promotion']).") ".$liste[$i]['designation']."</option>";
					}
				?>
				echo "</select>";
				$tests=1;
			}else{
				echo utf8_decode('PROBLEME AVEC LA REQUETE DE VERIFICATION, VEUILLEZ VOUS RENDRE A LA SCOLARITE POUR RECEVOIR UNE AIDE');
				$tests=1;
			}	
		}
	}		

?>