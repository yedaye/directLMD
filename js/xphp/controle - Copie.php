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
$lafiliere=$_POST['lafiliere'];
$lecodeauto=$_POST['lecode'];

//fin variable	
////////////////////////ZONE DES MONTANTS
//////////////////////DEBUT CALCUL MONTANT////////
function lemontant($specialite,$lepays,$mode){
		$aff="";
		//recuperation de la zone du pays
		$qstr1 = "SELECT cod_zone FROM pays WHERE cod_pays='".$lepays."'";
		$query = mysql_query($qstr1) or die(mysql_error());
		//echo "SELECT * FROM option_section WHERE section='".$lasec."' AND options='".$lopt."'";
		$lazone="";
		if($query){
			$result=mysql_fetch_assoc($query);
			$lazone=$result['cod_zone'];
			
		}
		if($lazone==""){
			echo utf8_decode("VEUILLEZ CORRIGER VOTRE NATIONALITE");	
			echo utf8_decode("<input id='stop' name='stop' value=' ' readonly/>");
			$tests=1;
		}
		//recuperation du montant a payer
		$qstr1 = "SELECT * FROM montant WHERE filiere='".$specialite."' AND statut='".$mode."' AND zone='".$lazone."'";
		$query = mysql_query($qstr1) or die(mysql_error());
		//echo "SELECT * FROM montant WHERE COD_SPE='".$specialite."' AND CODSTATUS='".$mode."' AND CODZONE='".$lazone."'";
		if($query){
				$num=mysql_num_rows($query);
				$result=mysql_fetch_assoc($query);
				if($num>0){
					$ff=$result['FF'];
					$fi=$result['FI'];
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

	if($db){
		if($_POST['letype']=="bachelier"){
				$qstr1="SELECT * FROM autorisation WHERE annee_auto='".$anneeEtude."' AND num_bac='".trim($lenum_table)."' AND type_auto=1 AND filiere='".$lafiliere."' and mode='".$lemode."' AND valide='OUI'";
		//echo $qstr1;
					$queryb=mysql_query($qstr1) or die(mysql_error());
				if($queryb){
					$num=mysql_num_rows($queryb);
					if($num==0){
						echo utf8_decode(" STOP : VOUS N'ETES PAS AUTORISE A FAIRE CETTE SPECIALITE OU CHOISISSEZ LE BON STATUT");
						echo "<input type='hidden' id='stop' name='stop' value=' ' readonly/>";
						$tests=1;
					}else{
						////////////////////////////////// CALCUL DU MONTANT ////////////////////////
						$val=lemontant($lafiliere,$lanationalite,$lemode);
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
			$statut=selTableData2Fields("inscription","matricule",$lematricule,"annee_academique",$an_precedent);
			if(count($statut)>0){
				$statut=$statut[0]['statut'];
				if($lemode!=$statut){
					echo "Veuillez choisir le même mode d'accès que l'année passé.";
					echo "<input type='hidden'  id='stop' name='stop' value=' ' readonly/>";
					exit;
				}
			}
			
			$resultat=selTableData2Fields("verdict","matricule",$lematricule,"annee_academique",$an_precedent);
			//print_r($resultat);
			if(count($resultat)>0){
				$test=selTableData2Fields("mapping","filiere",$resultat[0]['filiere'],'verdict',$resultat[0]['result_semestre_2']);
				//print_r($test);
				//echo "////".$resultat[0]['filiere']."////".$resultat[0]['result_semestre_2'];
				if(count($test)>0){
					//echo $test[0]['fil_auto'];
					//echo "///".$lafiliere;
					if($test[0]['fil_auto']==$lafiliere){
						$val=lemontant($lafiliere,$lanationalite,$lemode);
						echo $val;
					}else{
						echo "Vous n'avez pas choisi la bonne filieres";	
					}
				}else{
					echo "Vous n'avez pas choisi la bonne filiere";	
				}
			}else{
				echo "Vos resultats ne sont pas encore parvenu à la scolarité";
			}
		};
		if($_POST['letype']=="autorisation"){
			$array_field=array('code_auto','annee_auto','mode');
			$array_value=array($lecodeauto,$anneeEtude,$lemode);
			$test=selTableDataWhereArray('autorisation',$array_field,$array_value);
				//print_r($test);
				if(count($test)>0){
					$val=lemontant($lafiliere,$lanationalite,$lemode);
					echo $val;
				}else{
					echo "Vous n'avez pas choisi la bonne filiere ou le bon statut";	
				}
		}
	}
?>