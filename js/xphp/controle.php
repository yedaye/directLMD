<?php
session_start();
	//recuperation du db name
if (is_file("../../connect/co.php"))
	include_once ("../../connect/co.php");
if (is_file("../../functions/queries.php"))
	include_once("../../functions/queries.php");
if (is_file("../../param.php"))
	include_once("../../param.php");
	
////recuperation des variables
$letype=$_POST['letype'];
$lenum_table=$_POST['lenum_table'];
$lasession=$_POST['lasession'];
$lematricule=$_POST['lematricule'];
$lecole=$_POST['lecole'];
$lannee_etude=$_POST['lannee_etude'];
$lemode=$_POST['lemode'];
$lanationalite=$_POST['lanationalite'];
$lafiliere=trim($_POST['lafiliere']);
$lecodeauto=$_POST['lecode'];

//fin variable	
////////////////////////ZONE DES MONTANTS
//////////////////////DEBUT CALCUL MONTANT////////
function lemontant($specialite,$lepays,$mode,$pdo){
		$aff="";
		//recuperation de la zone du pays
		$qstr1 = "SELECT cod_zone FROM pays WHERE cod_pays='".$lepays."'";
		//echo $qstr1;
		$query = $pdo->query($qstr1);
		$total = $query->rowcount();
		//echo $total;
		//exit;
		$lazone="";
		if($total>0){
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
			//print_r($result);
			$lazone=$result[0]['cod_zone'];
		}
		if($lazone==""){
			echo utf8_decode("VEUILLEZ CORRIGER VOTRE NATIONALITE");	
			echo utf8_decode("<input id='stop' name='stop' value=' ' readonly/>");
			$tests=1;
		}
		//recuperation du montant a payer
		$qstr1 = "SELECT * FROM montant WHERE filiere='".$specialite."' AND statut='".$mode."' AND zone='".$lazone."'";
		$query = $pdo->query($qstr1);
		$num = $query->rowcount();
		//echo "SELECT * FROM montant WHERE COD_SPE='".$specialite."' AND CODSTATUS='".$mode."' AND CODZONE='".$lazone."'";
		if($num>0){
				
				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				if($num>0){
					$ff=$result[0]['FF'];
					$fi=$result[0]['FI'];
					$total=$ff+$fi;
					$aff.=" FF= ".$ff."  FI= ".$fi." <br/> TOTAL A PAYER = ".$total;
					$aff.="<input id='lemontant1' name='lemontant1' value='".$total."' type='hidden'/><input id='leff' name='leff' value='".$ff."' type='hidden'/><input id='lefi' name='lefi' value='".$fi."' type='hidden'/>";
					$aff.="<script>document.getElementById('valide').value='oui';</script>";
				}else{
					$aff.=utf8_decode("AUCUN MONTANT NE CORRESPOND A VOTRE CHOIX, VEUILLEZ VERIFIER LA FILIERE ET LE STATUT");
					$aff.="<input id='stop' name='stop' value=' ' readonly/>";
					$tests=1;
				}
		}else{
			$aff.=utf8_decode('ERROR: IL Y A UN PROBLEME AVEC LA REQUETE DES MONTANTS, VEUILLEZ VOUS RENDRE A LA SCOLARITE');
			$aff.="<input id='stop' name='stop' value=' ' readonly/>";
			$tests=1;
		}
		return $aff;
	}
	/////////////////////////// FIN CALCUL MONTANT /////////////////////////////////

		if($_POST['letype']=="bachelier"){
				$qstr1="SELECT * FROM autorisation WHERE annee_auto='".$anneeEtude."' AND num_bac='".trim($lenum_table)."' AND type_auto=1 AND filiere='".$lafiliere."' and mode='".$lemode."' AND valide='OUI'";
		//echo $qstr1;
		//exit;
				$queryb = $pdo->query($qstr1);
				if($queryb){
					$num = $queryb->rowcount();
					if($num==0){
						echo utf8_decode(" STOP : VOUS N'ETES PAS AUTORISE A FAIRE CETTE SPECIALITE OU CHOISISSEZ LE BON STATUT");
						echo "<input type='hidden' id='stop' name='stop' value=' ' readonly/>";
						$tests=1;
					}else{
						////////////////////////////////// CALCUL DU MONTANT ////////////////////////
						$val=lemontant($lafiliere,$lanationalite,$lemode,$pdo);
						echo $val;
						
						////////////////////////////////// FIN CALCUL DU MONTANT ////////////////////////
					}
				}else{
					echo utf8_decode('PROBLEME AVEC LA REQUETE DE VERIFICATION, VEUILLEZ VOUS RENDRE A LA SCOLARITE POUR RECEVOIR UNE AIDE');
					echo "<input  type='hidden'  id='stop' name='stop' value=' ' readonly/>";
					$tests=1;
				}	
		}	

		if($_POST['letype']=="reinscription"){
			//controle du statut
			$statut=selTableData2Fields("inscription","matricule",$lematricule,"annee_academique",$an_precedent,$pdo);
//			print_r($statut);
			
			if(count($statut)>0){
				$statut=$statut['statut'];
				if($lemode!=$statut){
					echo "Veuillez choisir le même mode d'accès que l'année passé.";
					echo "<input type='hidden'  id='stop' name='stop' value=' ' readonly/>";
					echo "<script>ferme('reprise')</script>";
					exit;
				}
			}
			
			
			
			$resultat=selTableData2Fields("verdict","matricule",$lematricule,"annee_academique",$an_precedent,$pdo);
			$resultat2=selTableData2Fields("verdict","matricule",$lematricule,"annee_academique",$an_precedent2,$pdo);
			//print_r($resultat);
			if(count($resultat)>0){
				/// recuperation de la filiere s'il est en deuxieme année STCTPA
				//echo "1///".$lafiliere;
				/* if($lafiliere=="LP3,4-ESTCTPA"){
					//echo "$$$$".$lafiliere."$$$$";
					//echo "///".$resultat[0]['filiere']."////";
					$lafiliere=$resultat[0]['filiere'];	
				} */
				$test=selTableData2Fields("mapping","filiere",$resultat['filiere'],'verdict',$resultat['result_semestre_2'],$pdo);
				//echo $lafiliere;
				//echo $test[0]['fil_auto'];
				//print_r($test);
				//echo count($test);
				//echo "////".$resultat[0]['filiere']."////".$resultat[0]['result_semestre_2'];
				if(count($test)>0){
					//$liste_matricule=array('15447113','12868113','11396913','11494412');
				//	echo '//'.$test['fil_auto'].'//';
					//echo '//'.$lafiliere.'//';
					if(trim($test['fil_auto'])==$lafiliere){
						if($resultat['result_semestre_2']=="Refuse"){
							if($lecole!='STA' && !in_array($lematricule,$liste_matricule)){
								echo "Frais d'inscription : 15000 FCFA<br/>";
								echo "Veuillez Sélectionner les ECU que vous voulez reprendre et cliquer sur controler";
								echo "<input id='lemontant1' name='lemontant1' value='15000' type='hidden'/><input id='leff' name='leff' value='0' type='hidden'/><input id='lefi' name='lefi' value='15000' type='hidden'/>";
								echo "<script>ouvrir('reprise');document.getElementById('valide').value='oui';</script>";
							}else{
								$val=lemontant($lafiliere,$lanationalite,$lemode,$pdo);
								echo $val;	
							}
						}	
						if( $resultat['result_semestre_2']=="Chevauche"){
							//if($lecole!='STA' && !in_array($lematricule,$liste_matricule)){
							//	$val=lemontant($lafiliere,$lanationalite,$lemode);
							//	echo $val;
							//	echo "<script>ouvrir('reprise');document.getElementById('valide').value='oui';</script>";	
							//}else{
								$val=lemontant($lafiliere,$lanationalite,$lemode,$pdo);
								echo $val;	
							//}
						}
						if( $resultat['result_semestre_2']=="Admis"){
							$val=lemontant($lafiliere,$lanationalite,$lemode,$pdo);
							echo $val;
						}
						if(isset($resultat2) && count($resultat2)>0){
							if($resultat2['result_semestre_2']=='Refuse' || $resultat2['result_semestre_2']=='Chevauche'){
								echo "<script>ouvrir('reprise');document.getElementById('valide').value='oui';</script>";	
							//echo $val;
							}
						}
					}else{
						//echo $test['fil_auto']."///".$lafiliere;
						echo "Vous n'avez pas choisis la bonne filieres: probleme de mapping";	
						echo "<script>ferme('reprise')</script>";
					}
				}else{
					echo "Vous n'avez pas choisi la bonne filiere: probleme de verdict";
					echo "<script>ferme('reprise')</script>";	
				}
			}else{
				echo "Vos resultats ne sont pas encore parvenu à la scolarité";
				echo "<script>ferme('reprise')</script>";
			}
		};
		if($_POST['letype']=="autorisation"){
			$array_field=array('code_auto','annee_auto','mode');
			$array_value=array($lecodeauto,$anneeEtude,$lemode);
			$test=selTableDataWhereArray('autorisation',$array_field,$array_value,$pdo);
				//print_r($test);
				//echo count($test);
				echo $test[0]['filiere']."///".$lafiliere."<br/>";
				if(count($test)>0){
					if($test[0]['FF']==0 && $test[0]['FI']==0){ 
						$val=lemontant($lafiliere,$lanationalite,$lemode,$pdo);
						echo $val;
					}else{
						$total=$test[0]['FF']+$test[0]['FI'];
						echo "FF= ".$test[0]['FF']."  FI= ".$test[0]['FI']." <br/> TOTAL A PAYER = ".$total;
						echo "<input id='lemontant1' name='lemontant1' value='".$total."' type='hidden'/><input id='leff' name='leff' value='".$test[0]['FF']."' type='hidden'/><input id='lefi' name='lefi' value='".$test[0]['FI']."' type='hidden'/>";
						echo "<script>document.getElementById('valide').value='oui';</script>";
					}
				}else{
					echo "Vous n'avez pas choisi la bonne filiere ou le bon statut";	
				}
		}
?>