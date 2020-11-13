<?php
session_start();
if (is_file("connect/co.php"))
	include_once ("connect/co.php");

if (is_file("functions/queries.php"))
	include_once ("functions/queries.php");

if (is_file("param.php"))
	include_once ("param.php");

//initialisation des variables
$type=$_GET['type'];
$matricule="";
$num_table="";
$serie_bac="";
$session="";
$moyenne_bac="";
$nom="";
$prenoms="";
$codsexe="";
$date_nais="";
$lieu_nais="";
$codpays="";
$codnation="";
$coddept="";
$codesitufam="";
$nombre_enfant="";
$telephone="";
$email="";
$bp="";
$codmode="";
$codannee_etude="";
$code_auto="";
$departement="";
$montant=0;
// recuperation des données
/// CAS D'UN BACHELIER
if($type=='bachelier' and !isset($_GET['modifier'])){
	//recuperation des infos du bachelier
	$etudiant=selTableData2Fields('resultatbac','NumTable',$_POST['numbac'],"session",$_POST['anneebac']);
	$etudiant=$etudiant[0];
	//print_r($etudiant);
	$num_table=$etudiant['NumTable'];
	$serie_bac=$etudiant['Serie'];
	$session=$etudiant['session'];;
	$moyenne_bac=$etudiant['Moyenne'];	
	$nom=$etudiant['Nom'];
	$dis_nom="readonly";
	$prenoms=$etudiant['Prenoms'];
	$dis_prenom="readonly";
	$codsexe=$etudiant['sexe'];
	$dis_sexe="readonly";
	$date_nais=$etudiant['Date_Nais'];
	$dis_date_nais="readonly";
	$lieu_nais=$etudiant['Lieu_Nais'];
	$dis_lieu_nais="readonly";
	$codpays=$etudiant['Nationalite'];
	$codnation=$etudiant['Nationalite'];
	$departement="";
	$codesitufam="";
	$nombre_enfant="";
	$telephone="";
	$email="";
	$bp="";
	$codannee_etude="";
	$code_auto="";
}
////reinscription
if($type=='reinscription' and !isset($_GET['modifier'])){
	//recuperation des infos du bachelier
	$etudiant=selTableDataWhere('student','matricule',$_POST['matricule']);
	//print_r($etudiant);
	$matricule=$_POST['matricule'];
	$num_table=$etudiant['num_table'];
	$serie_bac=$etudiant['serie'];
	$session=$etudiant['session'];;
	$moyenne_bac="";	
	$nom=$etudiant['nom'];
	$dis_nom="readonly";
	$prenoms=$etudiant['prenoms'];
	$dis_prenom="readonly";
	$codsexe=$etudiant['sexe'];
	$dis_sexe="readonly";
	$date_nais=$etudiant['date_naissance'];
	$dis_date_nais="readonly";
	$lieu_nais=$etudiant['lieu_naissance'];
	$dis_lieu_nais="readonly";
	$codpays=$etudiant['pays_naissance'];
	$codnation=$etudiant['Nationalite'];
	$departement=$etudiant['departement'];
	$codesitufam=$etudiant['situ_fam'];
	$nombre_enfant=$etudiant['nombre_enfant'];
	$telephone=$etudiant['telephone'];
	$email=$etudiant['email'];
	$bp=$etudiant['adresse_postal'];
	$codannee_etude=$anneeEtude;
	$code_auto="";
}

////AUTORISATION
if($type=='autorisation' and !isset($_GET['modifier'])){
	//recuperation des infos du bachelier
	$auto=selTableData2Fields('autorisation','code_auto',$_POST['codeauto'],'annee_auto',$anneeEtude);
	//print_r($etudiant);
	if(count($auto)>0){
		$auto=$auto[0];
		$code_auto=$auto['code_auto'];
		$anneeEtude=$auto['annee_inscrit'];
		/// verification si l'étudiant avait dja un matricule
		if($auto['matricule']!=""){
			$matricule=$auto['matricule'];	
			$etudiant=selTableDataWhere('student','matricule',$matricule);
			//print_r($etudiant);
			$num_table=$etudiant['num_table'];
			$serie_bac=$etudiant['serie'];
			$session=$etudiant['session'];;
			$moyenne_bac="";	
			$nom=$etudiant['nom'];
			$dis_nom="readonly";
			$prenoms=$etudiant['prenoms'];
			$dis_prenom="readonly";
			$codsexe=$etudiant['sexe'];
			$dis_sexe="readonly";
			$date_nais=$etudiant['date_naissance'];
			$dis_date_nais="readonly";
			$lieu_nais=$etudiant['lieu_naissance'];
			$dis_lieu_nais="readonly";
			$codpays=$etudiant['pays_naissance'];
			$codnation=$etudiant['Nationalite'];
			$departement=$etudiant['departement'];
			$codesitufam=$etudiant['situ_fam'];
			$nombre_enfant=$etudiant['nombre_enfant'];
			$telephone=$etudiant['telephone'];
			$email=$etudiant['email'];
			$bp=$etudiant['adresse_postal'];
			$codannee_etude=$anneeEtude;
			$codauto=$etudiant['code_auto'];
		}else{
			$matricule="";	
			$num_table=$auto['num_bac'];
			$serie_bac="";
			$session=$auto ['session_bac'];;
			$moyenne_bac="";	
			$nom=$auto['nom'];
			$dis_nom="readonly";
			$prenoms=$auto['prenoms'];
			$dis_prenom="readonly";
			$codsexe="";
			$dis_sexe="readonly";
			$date_nais=$auto['date_naissance'];
			$dis_date_nais="readonly";
			$lieu_nais=$auto['lieu_naissance'];
			$dis_lieu_nais="readonly";
			$codpays=$auto['Nationalite'];
			$codnation=$auto['Nationalite'];
			$departement="";
			$codesitufam="";
			$nombre_enfant="";
			$telephone="";
			$email="";
			$bp="";
			$codannee_etude=$anneeEtude;
			$codauto=$auto['code_auto'];
		}
	}
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Formulaire à l'UAK</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="js/default/easyui.css">
<link rel="stylesheet" type="text/css" href="js/icon.css">
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
<script type="text/javascript" language="javascript1.2">
	jQuery(function($) {
			$('#div_validation').hide();
			$('#div_contro').show();	
			$('#ecole').combobox({disabled:false});
			$('#annee_etude').combobox({disabled:false});
			$('#lemode').combobox({disabled:false});
			$('#ecole').combobox({editable:false});
			$('#annee_etude').combobox({editable:false});
			$('#lemode').combobox({editable:false});
			$('#reprise').hide();
			
	});
	function ouvrir(nom){
		$('#'+nom).show('slow');
	}
	function ferme(nom){
		$('#'+nom).hide('slow');
	}
	function retour(){
		$('#ecole').combobox({disabled:false});
		$('#annee_etude').combobox({disabled:false});
		$('#lemode').combobox({disabled:false});
		$('#ecole').combobox('clear');
		$('#annee_etude').combobox('clear');
		$('#lemode').combobox('clear');	
		$('#div_validation').hide();
		$('#div_contro').show();
		$('#letest').hide('slow');
		$('#reprise').hide('slow');
		document.getElementById('valide').value='';
	}
	function controles(){
		//document.getElementById('letest').style.display="block";
		montype=document.getElementById('letype').value;
		num_table=document.getElementById('num_table').value;
		session=document.getElementById('session').value;	
		ecole=$('#ecole').combobox('getValue');
		annee_etude=$('#annee_etude').combobox('getValue');
		mode=$('#lemode').combobox('getValue');
		matricule=document.getElementById('matricule').value;	
		code_auto=document.getElementById("code_auto").value;
		nationalite=document.getElementById("nationalite").value;
		filiere=annee_etude+"-"+ecole;
		if(mode!="" && ecole!="" && annee_etude!=""){
//			alert(type+"/"+num_table+"/"+session+"/"+ecole+"/"+annee_etude+"/"+mode+"/"+nationalite+"/"+filiere);
		
			$.post("js/xphp/controle.php", {letype:montype,lenum_table:num_table,lasession:session, lecole:ecole ,lannee_etude:annee_etude, lemode:mode, lanationalite:nationalite, lafiliere:filiere, lematricule:matricule, lecode:code_auto}, function(data){
				if(data.length >0){
					$('#letest').html(data);
					document.getElementById('letest').style.display="block";
					if(document.getElementById('valide').value!='oui'){
						document.getElementById('validation').disabled=true;
						$('#div_validation').hide();
						$('#div_contro').show();
						$('#ecole').combobox('enable');
						$('#annee_etude').combobox({disabled:false});
						$('#lemode').combobox({disabled:false});
						$('#ecole').combobox('clear');
						$('#annee_etude').combobox('clear');
						$('#lemode').combobox('clear');
					}else{					
						$('#div_validation').show();
						$('#reprise').show('slow');
						$('#div_contro').hide();
						document.getElementById('validation').disabled=false;
						document.getElementById('ecole_bon').value=$('#ecole').combobox('getValue');
						document.getElementById('annee_etude_bon').value=$('#annee_etude').combobox('getValue');
						document.getElementById('lemode_bon').value=$('#lemode').combobox('getValue');
						$('#ecole').combobox('disable');
						$('#annee_etude').combobox('disable');
						$('#lemode').combobox('disable');
					}
				}else{
					alert("Aucun resultat, veuillez faire le bon choix");	
					$('#ecole').combobox('clear');
					$('#annee_etude').combobox('clear');
					$('#lemode').combobox('clear');
				}
			});
		}else{
			alert("refaire le choix de votre etablissement, section et option");
			$('#ecole').combobox('clear');
			$('#annee_etude').combobox('clear');
			$('#lemode').combobox('clear');
		}
	}
	function soumettre(){
		var a=0;
		if(document.getElementById('valide').value==""){
		 	$.messager.alert('Erreur','Veuillez remplir correctement le formulaire!','warning');
		}else{
			if(document.getElementById('nombre_enfant').value==""){
				$.messager.alert('Erreur',"Veuillez préciser le nombre d'enfant!",'warning');
				a=1;
			}
			if(document.getElementById('telephone').value==""){
				$.messager.alert('Erreur',"Veuillez préciser votre numéro de téléphone!",'warning');
				a=1
			}
			if(document.getElementById('email').value==""){
				$.messager.alert('Erreur',"Veuillez préciser votre email!",'warning');
				a=1
			}
			if(document.getElementById('departement').value==""){
				$.messager.alert('Erreur',"Veuillez préciser votre departement!",'warning');
				a=1
			}
			if(a==0){
				if(confirm("Etes vous sur d'avoir bien rempli le formulaire, si oui cliquez sur OK, sinon cliquer sur ANNULER")){
					document.forms['form1'].submit();
				}
			}
		}
	}
	function ischecked(madiv,credit,montant_ecu,total){
		var montant;
		
		if(document.getElementById(madiv).checked){
			document.getElementById('montant_'+madiv).innerHTML=Math.round(montant_ecu*credit)+' FCFA';
			montant=Math.round(document.getElementById(total).innerHTML);
			montant=Math.round(montant+Math.round(montant_ecu*credit));
			document.getElementById(total).innerHTML=montant;
			document.getElementById('FF').value=montant;
		}else{
			document.getElementById('montant_'+madiv).innerHTML="";
			montant=Math.round(document.getElementById(total).innerHTML);
			montant=Math.round(montant-Math.round(montant_ecu*credit));
			document.getElementById(total).innerHTML=montant;
			document.getElementById('FF').value=montant;
		}
	}
	function nodischecked(monid){
		document.getElementById(monid).checked=true;
	}
</script>
</head>

<body>
<?php include("include_menu.html"); 
$a=0;
if($type=='bachelier'){
	$verif=selTableData2Fields('student','num_table',$num_table,'session',$_POST['anneebac']);
	if(isset($verif[0]['matricule']) && $verif[0]['matricule']!=""){
		//recuperation des données de l'étudiant
		$matricule=$verif[0]['matricule'];
		$num_table=$verif[0]['num_table'];
		$serie_bac=$verif[0]['serie'];
		$session=$verif[0]['session'];;
		$moyenne_bac=$etudiant['Moyenne'];	
		$nom=$verif[0]['nom'];
		$dis_nom="readonly";
		$prenoms=$verif[0]['prenoms'];
		$dis_prenom="readonly";
		$codsexe=$verif[0]['sexe'];
		$dis_sexe="readonly";
		$date_nais=$verif[0]['date_naissance'];
		$dis_date_nais="readonly";
		$lieu_nais=$verif[0]['lieu_naissance'];
		$dis_lieu_nais="readonly";
		$codpays=$verif[0]['pays_naissance'];
		$codnation=$verif[0]['Nationalite'];
		$departement=$verif[0]['departement'];
		$codesitufam=$verif[0]['situ_fam'];
		$nombre_enfant=$verif[0]['nombre_enfant'];
		$telephone=$verif[0]['telephone'];
		$email=$verif[0]['email'];
		$bp=$verif[0]['adresse_postal'];
		//$promotion=$verif[0]['promotion'];
		$codannee_etude=$anneeEtude;
		
		//fin recuperation
		$inscrit=selTableData2Fields('inscription','matricule',$verif['matricule'],'annee_academique',$anneeEtude);
		if(isset($inscrit[0]['filiere']) && $inscrit[0]['filiere']!=""){
			$msg=" <a class='titre_form' href='backend/fiche.php?matricule=".$matricule."&annee=".$anneeEtude."'>IMPRIMER MA FICHE DE PREINSCRIPTION</a><br/><strong>Vous êtes déja inscrit en ".$inscrit[0]['filiere']." au cours de l'année académique ".$anneeEtude."</strong>";	
			echo "<center>".$msg."</center><div align='center' id='retour'> <a href='inscription.php?reset' class='easyui-linkbutton'>RETOUR</a></div>";
		}else{
			$a++;	
		}
	}else{
		$a++;	
	}
}

/////reinscription
if($type=='reinscription'){
	$inscrit=selTableData2Fields('inscription','matricule',$matricule,'annee_academique',$anneeEtude);
	if(isset($inscrit[0]['filiere']) && $inscrit[0]['filiere']!=""){
		$msg=" <a class='titre_form' href='backend/fiche.php?matricule=".$matricule."&annee=".$anneeEtude."'>IMPRIMER MA FICHE DE PREINSCRIPTION</a><br/><strong>Vous êtes déja inscrit en ".$inscrit[0]['filiere']." au cours de l'année académique ".$anneeEtude."</strong>";	
		echo "<center>".$msg."</center><div align='center' id='retour'> <a href='inscription.php?reset' class='easyui-linkbutton'>RETOUR</a></div>";
	}else{
		$a++;	
	}	
	$arrayfield=array('matricule','annee_academique','controle');
	$arrayvalue=array($matricule,$an_precedent,'non');
	$inscritcontrole=selTableDataWhereArray('inscription',$arrayfield,$arrayvalue);
	if(isset($inscritcontrole[0]['filiere']) && $inscritcontrole[0]['filiere']!=""){
		$msg="<br/><br/><strong>Votre préinscription de l'année antérieur n'a pas été validée.<br/> Veuillez vous rapprocher de la scolarité centrale pour régularisation de votre inscription.</strong><br/><br/>";	
		echo "<center><span class='calendar-sunday'>".$msg."</span></center><div align='center' id='retour'> <a href='inscription.php?reset' class='easyui-linkbutton'>RETOUR</a></div>";
		exit;
	}	
}
/////reinscription
if($type=='autorisation'){
	//verification de l'inscription
	$num=selTableDataCount('student','code_auto',$code_auto);
	if($num>0){
		$info=selTableDataWhere('student','code_auto',$code_auto);
		$matricule=$info['matricule'];
		$inscrit=selTableData2Fields('inscription','matricule',$matricule,'annee_academique',$anneeEtude);
		if(isset($inscrit[0]['filiere']) && $inscrit[0]['filiere']!=""){
			$msg=" <a class='titre_form' href='backend/fiche.php?matricule=".$matricule."&annee=".$anneeEtude."'>IMPRIMER MA FICHE DE PREINSCRIPTION</a><br/><strong>Vous êtes déja inscrit en ".$inscrit[0]['filiere']." au cours de l'année académique ".$anneeEtude."</strong>";	
			echo "<center>".$msg."</center><div align='center' id='retour'> <a href='inscription.php?reset' class='easyui-linkbutton'>RETOUR</a></div>";
		}else{
			$a++;	
		}
	}else{
		$a++;	
	}
}

if($a>0){
?>
<form id="form1" name="form1" method="post" action="final.php">
<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
      <table width="100%" border="0" cellpadding="0" cellspacing="3">
       <tr>
        <td colspan="2" align="center"><div align="center" id='retour'> <a href="inscription.php?reset" class="easyui-linkbutton">RETOUR</a></div><br/><strong>2ème ETAPE<br/>
            <span class="calendar-sunday"><strong>IMPORTANT : Remplissez le formulaire en prenant soin de vérifier que toutes vos informations sont correctes. Si vous constatez des erreurs que vous ne pouvez corriger, veuillez contacter l'administration.</strong></br>
            </span></strong>
        <hr/></td>
      </tr>
        <tr>
          <td colspan="2" align="center" valign="top" class="calendar-selected"><b>DECLARATION D'IDENTITE</b></td>
          </tr>
        <tr>
          <td width="27%" valign="top"><b>Nom de famille :</b></td>
          <td width="73%" valign="top"><label for="nom_famille"></label>
            <input type="text" name="nom_famille" id="nom_famille" class="easyui-validatebox" data-options="required:true" value="<?php echo utf8_encode($nom); ?>" <?php echo $dis_nom; ?>/></td>
        </tr>
        <tr bgcolor="#D6D6D6">
          <td valign="top"><b>Prénoms :</b></td>
          <td valign="top"><label for="prenoms"></label>
            <input type="text" name="prenoms" id="prenoms" class="easyui-validatebox" data-options="required:true"  value="<?php echo utf8_encode($prenoms); ?>"  <?php echo $dis_prenom; ?>/></td>
        </tr>
        <tr>
          <td valign="top"><b>Sexe :</b></td>
          <td valign="top"><label for="sexe"></label>
            <?php if($codsexe!=""){ ?>
	            <input name="sexe" id="sexe" size="5" value="<?php echo $codsexe; ?>" type="hidden"/>
            <?php 
				if(trim($codsexe)=="F"){echo "Féminin";}else{ echo "Masculin";} 
            }else{ ?>
            	<select name="sexe" id="sexe" class="easyui-combobox">
            	  <option value="F">Féminin</option>
           		  <option value="M">Masculin</option>
            	</select>
            <?php } ?>
            </td>
        </tr>
        <tr bgcolor="#D6D6D6">
          <td valign="top"><b>Date de naissance :</b></td>
          <td valign="top"><label for="date_naissance"></label>
			<?php 
				if($date_nais!=""){ ?>
					<input name="date_naissance" id="date_naissance" size="5" value="<?php echo $date_nais; ?>" type="hidden"/>
			<?php 
					echo utf8_encode($date_nais);
				}else{ ?>
            <input name="date_naissance" id="date_naissance" class="easyui-datebox" data-options="required:true" value="<?php echo utf8_encode($date_nais); ?>" <?php echo $dis_date_nais; ?>/>
            <?php } ?>
            </td>
        </tr>
        <tr>
          <td valign="top"><b>Lieu de naissance :</b></td>
          <td valign="top"><label for="lieu_naissance"></label>
            <?php 
				if($lieu_nais!=""){ ?>
					<input name="lieu_naissance" id="lieu_naissance" size="5" value="<?php echo utf8_encode($lieu_nais); ?>" type="hidden"/>
			<?php 
					echo utf8_encode($lieu_nais);
				}else{ ?>
            		<input type="text" name="lieu_naissance" id="lieu_naissance" class="easyui-validatebox" data-options="required:true" value="<?php echo utf8_encode($lieu_nais); ?>" <?php echo $dis_lieu_nais; ?>/></td>
	        <?php } ?>
        </tr>
        <tr bgcolor="#D6D6D6">
          <td valign="top"><b>Pays de naissance :</b></td>
          <td valign="top"><label for="pays_naissance"></label>
             <?php if($codpays!=""){ ?>
                        <input name="txtpays" id="txtpays" size="5" value="<?php echo $codpays; ?>" type="hidden"/>
                        <?php 
						$libpays=selTableDataWhere('pays','cod_pays',$codpays);
						echo utf8_encode($libpays['lib_pays']);
						}else{ ?>
                        <select name="pays_naissance" id="pays_naissance" class="easyui-combobox">
						<option value=""></option>
						<?php
							$pays = selTableData('pays','lib_pays');
							$a=0;
							foreach ($pays as $py) {
							if($py['cod_pays']==$codpays){ 
								$spy="selected"; 								
							}else{
								$spy="";
							}
							echo "<option value='".$py['cod_pays']."' ".$spy.">".utf8_encode(strtolower($py['lib_pays']))."</option>";
							}
						?>
                        </select>
                        <?php } ?>
</td>
        </tr>
        <tr>
          <td valign="top"><b>Nationalité :</b></td>
          <td valign="top"><label for="nationalite"></label>
            <?php if($codnation!=""){ ?>
                        <input name="nationalite" id="nationalite" size="5" value="<?php echo $codnation; ?>" type="hidden"/>
                        <?php 
							$libpays=selTableDataWhere('pays','cod_pays',$codnation);
							echo utf8_encode($libpays['lib_nation']);
						}else{ 
						?>
                        <select name="nationalite" id="nationalite" class="easyui-combobox">
						<option value=""></option>
						<?php
							$pays = selTableData('pays','lib_pays');
							$a=0;
							foreach ($pays as $py) {
								if($py['cod_pays']==$codnation){ 
									$spy="selected"; 								
								}else{
									$spy="";
								}
							echo "<option value='".$py['cod_pays']."' ".$spy.">".utf8_encode(strtolower($py['lib_nation']))."</option>";
							}
						?>
                        </select>
                        <?php } ?>
                    </td>
        </tr>
        <tr bgcolor="#D6D6D6">
          <td valign="top"><b>Département d'origine :</b></td>
          <td valign="top"><label for="departement"></label>
            <?php 
			if($departement!=""){ ?>
                        <input name="departement" id="departement" size="5" value="<?php echo $departement; ?>" type="hidden"/>
                        <?php 
							$libpays=selTableDataWhere('departement','code_dept',$departement);
							echo $libpays['lib_dept'];
						}else{ 
						?>
			            <select name="departement" id="departement" class="easyui-combobox">
						<?php
							$pays = selTableData('departement','lib_dept');
							$a=0;
							foreach ($pays as $py) {
								if($py['code_dept']==$departement){ 
									$spy="selected"; 								
								}else{
									$spy="";
								}
							echo "<option value='".$py['code_dept']."' ".$spy.">".utf8_encode(strtolower($py['lib_dept']))."</option>";
							}
						?>
                        </select>
            <?php } ?></td>
        </tr>
        <tr>
          <td valign="top"><b>Stituation familiale :</b></td>
          <td valign="top"><label for="situation familiale"></label>
            <select name="situation familiale" id="situation familiale" class="easyui-combobox">
            	<option value="C" <?php if($codesitufam=="C"){echo "selected=\"selected\"";} ?>>Célibataire</option>
               	<option value="D" <?php if($codesitufam=="D"){echo "selected=\"selected\"";} ?>>Divorcé(e)</option>
               	<option value="M" <?php if($codesitufam=="M"){echo "selected=\"selected\"";} ?>>Marié(e)</option>
               	<option value="V" <?php if($codesitufam=="V"){echo "selected=\"selected\"";} ?>>Veuf(ve)</option>
            </select></td>
        </tr>
        <tr bgcolor="#D6D6D6">
          <td valign="top"><b>Nombre d'enfants :</b></td>
          <td valign="top"><label for="nombre_enfant"></label>
            <input type="text" name="nombre_enfant" id="nombre_enfant" class="easyui-numberbox" data-options="required:true,min:0,precision:0" value="<?php echo $nombre_enfant; ?>"/></td>
        </tr>
        <tr>
          <td valign="top"><b>Téléphone :</b></td>
          <td valign="top"><label for="telephone"></label>
            <input type="text" value='<?php echo $telephone; ?>' name="telephone" id="telephone" class="easyui-numberbox" data-options="required:true,min:0,precision:0"/></td>
        </tr>
        <tr bgcolor="#D6D6D6">
          <td valign="top"><b>Email :</b></td>
          <td valign="top"><label for="email"></label>
            <input type="text" name="email" id="email" value="<?php echo $email; ?>" class="easyui-validatebox" data-options="required:true,validType:'email'"/></td>
        </tr>
        <tr>
          <td valign="top"><b>Boite postale :</b></td>
          <td valign="top"><label for="bp"></label>
            <textarea name="bp" id="bp" cols="45" rows="5"><?php echo $bp; ?></textarea></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2"><hr /></td>
  </tr>
  <tr class="calendar-selected">
    <td colspan="2" align="center"><b>INSCRIPTION DANS UNE ECOLE</b></td>
  </tr>
  <tr>
    <td colspan="2"><p class="titre_form">Choississez l'école dans laquelle vous voulez vous inscrire :</p>
      <p>
        <input name="ecole_bon" id="ecole_bon" type="hidden" value=""/>
        <input name="ecole" id="ecole" class="easyui-combobox" style="width:600px" data-options="
				url: 'js/xphp/ecole.php',
				valueField: 'code_ecole',
				textField: 'lib_ecole',
				formatter:formatItem"/>
        <script type="text/javascript">
			function formatItem(row){
				var s = "<span><img src=\"js/icons/mini_add.png\" align=\"left\" />&nbsp;&nbsp;<b>UFR : </b><i>" +row.code_ufr+"</i> / <b>ECOLE</b> <i> :"+ row.code_ecole + "</i></span><br/>" +
						"<span style=\"color:#090\"><b>" + row.lib_ecole + "</b></span>";
				return s;
			}
	     </script>
      </p></td>
    </tr>
  <tr><td colspan="2">
  <p class="titre_form">Choisissez votre année d'étude</p>
  </td></tr>
  <tr>
    <td colspan="2">
    <input name="annee_etude_bon" id="annee_etude_bon" type="hidden" value=""/>
    <select name="annee_etude" id="annee_etude" class="easyui-combobox">
            <option value=""></option>
            <?php
                $mode = selTableData('options');
                $a=0;
                foreach ($mode as $mo) {
					if($mo['code']==$codannee_etude){ 
						$spy="selected"; 								
					}else{
						$spy="";
					}
					if(isset($_GET['type']) && $_GET['type']=='bachelier'){
						if($mo['code']=='LP1,2'){
							echo "<option value='".$mo['code']."' ".$spy.">".utf8_encode(strtoupper($mo['libelle']))."</option>";
						}
					}else{
						echo "<option value='".$mo['code']."' ".$spy.">".utf8_encode(strtoupper($mo['libelle']))."</option>";	
					}
                }
            ?>
            </select>
      </td>
  </tr>
  <tr>
    <td width="50%">
	<p class="titre_form">Choisir votre mode d'accès à l'UNA</p>
            <input name="lemode_bon" id="lemode_bon" type="hidden" value=""/>
            <select name="lemode" id="lemode" class="easyui-combobox">
            <option value=""></option>
            <?php
                $mode = selTableMultiAnswer('mode','actif',1);
                $a=0;
                foreach ($mode as $mo) {
                if($mo['code']==$codmode){ 
                    $spy="selected=\"selected\""; 								
                }else{
                    $spy="";
                }
                echo "<option value='".$mo['code']."' ".$spy.">".utf8_encode(strtoupper($mo['Intitule']))."</option>";
                }
            ?>
            </select>
    </td>
    <td width="50%" align="center" valign="middle" class="titre_form"><div id="letest" style="border:dotted; border-color:#F00; font-size:14px; font-family:Georgia, 'Times New Roman', Times, serif; display:none"></div><div align="center" id="stay" style="display:none"><br />
			<img src="img/global_spinner.gif" alt="Veuillez patienter" id="encours" /><br />
		</div></td>
  </tr>
  <tr>
    <td colspan="2">
 		<input name="num_table" id="num_table" size="5" value="<?php echo $num_table; ?>" type="hidden"/>
  		<input name="session" id="session" size="5" value="<?php echo $session; ?>" type="hidden"/>
  		<input name="matricule" id="matricule" size="5" value="<?php echo $matricule; ?>" type="hidden"/>
  		<input name="letype" id="letype" size="5" value="<?php echo $type; ?>" type="hidden"/>
  		<input name="serie" id="serie" size="5" value="<?php echo $serie_bac; ?>" type="hidden"/>
   		<input name="code_auto" id="code_auto" size="5" value="<?php echo $code_auto; ?>" type="hidden"/>
        <input name="valide" id="valide" size="5" value="" type="hidden"/>
        <input name="annee_inscrit" id="annee_inscrit" size="5" value="<?php echo $anneeEtude; ?>" type="hidden"/>
   	</td>
  </tr>
  <tr><td colspan="6"><hr/> </td></tr>
  <tr><td colspan="6" align="center"> 
  <div id="reprise" style='display:none'>
  <table width="95%" border="0" cellspacing="2">
  <?php
  if($_GET['type']=="reinscription"){ 
	$affichage="";
	$montant=0;
	$montant1=0;
	$montant2=0;
	$montant3=0;
	$filiere1="";
	$filiere2="";
	$filiere3="";
	
	//volet concernant l'année en cours
		$affichage="";
		$verdict=selTableData2Fields("verdict","matricule",$matricule,"annee_academique",$an_precedent);
		$result_ecu=selTableData2Fields("result_ecu","matricule",$matricule,"annee_acad",$an_precedent);
		$letest=explode("-",$verdict[0]['filiere']);
		$filiere1=$verdict[0]['filiere'];
		//print_r($result_ecu);
		//print_r($verdict);
		//gestion des ecu ancien et nouvelle version
		
		$ue=selTableData2FieldsAsc("table_ue_new","code_ecole",$verdict[0]['filiere'],"promotion",$etudiant['promotion'],"designation");
		$param=selTableDataWhere("param","anne_academique",$anneeEtude);
		//print_r($ue);
		//print_r($param);
		$a=0;
		for($i=0;$i<count($ue);$i++){
			$liste_ue="<tr><td colspan='3' bgcolor='#33DDEE'><b>UE : ".utf8_encode($ue[$i]['designation'])."</b></td></tr>";
			$ecu=selTableData2FieldsAsc("table_ecu_new","code_ue",$ue[$i]['code_ue'],"promotion",$etudiant['promotion'],"designation");
			$total=0;
			$test_ue="oui";
			$liste_ecu="";
			$liste_reserve="";
			$montant_ecu2=0;
		    //print_r($ecu);
			for($a=0;$a<count($ecu);$a++){
				$k=0;
				for($o=0;$o<count($result_ecu);$o++){
					$montant_ecu=0;
					if($result_ecu[$o]['code_ecu']==$ecu[$a]['code_ecu']){ 
						$total=$total+ $result_ecu[$o]['moyenne'];
						if($result_ecu[$o]['moyenne']<$param['moyenne_ecu_mini']){
							$montant_ecu=$montant_ecu+round($param['montant_ecu']*$ecu[$a]['credit']);
							$montant_ecu2=$montant_ecu2+$montant_ecu;
							$liste_ecu.="<tr align='left'><td>".utf8_encode($ecu[$a]['designation'])." (".$result_ecu[$o]['moyenne']."/20)</td><td>".$ecu[$a]['credit']."</td><td align='left'><input name='ECU[]' type='checkbox' value='".$ecu[$a]['code_ecu']."' onchange=\"nodischecked('".$ecu[$a]['code_ecu']."')\" id='".$ecu[$a]['code_ecu']."' checked /><div align='right'> ".round($param['montant_ecu']*$ecu[$a]['credit'])." FCFA</div></td></tr>";
						}else{
							$liste_reserve.="<tr align='left'><td>".utf8_encode($ecu[$a]['designation'])." (".$result_ecu[$o]['moyenne']."/20)</td><td>".$ecu[$a]['credit']."</td><td align='left'><input name='ECU[]' type='checkbox' value='".$ecu[$a]['code_ecu']."' onchange=\"ischecked('".$ecu[$a]['code_ecu']."','".$ecu[$a]['credit']."','".$param['montant_ecu']."','total1')\" id='".$ecu[$a]['code_ecu']."'/> <div id='montant_".$ecu[$a]['code_ecu']."' align='right'></div></td></tr>";	
						}
						$k++;						
					}
				}
				if($k==0){
					$montant_ecu=$montant_ecu+round($param['montant_ecu']*$ecu[$a]['credit']);
					$montant_ecu2=$montant_ecu2+$montant_ecu;
					$liste_ecu.="<tr align='left'><td>".utf8_encode($ecu[$a]['designation'])." (0/20)</td><td>".$ecu[$a]['credit']."</td><td align='left'><input name='ECU[]' type='checkbox' value='".$ecu[$a]['code_ecu']."' onchange=\"nodischecked('".$ecu[$a]['code_ecu']."','total1')\" id='".$ecu[$a]['code_ecu']."' checked /><div align='right'> ".round($param['montant_ecu']*$ecu[$a]['credit'])." FCFA</div></td></tr>";
				}
			}
			$totale=round($total/$a,2);
//			echo $montant_ecu2;
			//echo $totale."///";
			//echo $total."/".$a."/".$totale."$$";
			
			//print_r($letest);
			/* if($letest[1]=="ESTCTPA"){
				//echo round($total,2);
				if($totale<12 && ($liste_ecu!="" || $liste_reserve!="")){
					$affichage.=$liste_ue.$liste_ecu.$liste_reserve;
					//print_r($affichage);
					$montant2=$montant2+$montant_ecu2;
				}
			}else{ */
				if($totale<$param['moyenne_ue_mini'] && ($liste_ecu!="" || $liste_reserve!="")){
					$affichage.=$liste_ue.$liste_ecu.$liste_reserve;
					$montant2=$montant2+$montant_ecu2;
				}else{
					if($liste_ecu!=""){
						$affichage.=$liste_ue.$liste_ecu.$liste_reserve;
						$montant2=$montant2+$montant_ecu2;
					}	
				}	
			//}
		}
		//print_r($affichage);
	  if($affichage!=""){
	   ?>
  <tr>
  <td colspan="3" align="center" bgcolor="#FBEC88"><hr><br/>Liste des ECU à reprendre pour l'année <b><?php echo $an_precedent; ?></b> (ancienne note)</td>
    </tr>
  	<?php echo $affichage; ?>
    <tr>
    <td align="right" style="font-size:24px; color:#F00;" bgcolor="#FBEC88">MONTANT DES REPRISES : FF = </td>
    <td align="left" style="font-size:24px; color:#F00;" bgcolor="#FBEC88"><div align="left" id='total1'><?php echo $montant2; ?></div></td>
    <td align="left" style="font-size:24px; color:#F00;" bgcolor="#FBEC88">FCFA  <?php  if($verdict[0]['result_semestre_1']=="Refuse"){ echo "/ FI=15000 FCFA"; } ?></td>
    </tr>
	<tr><td colspan='3'><script type="text/javascript" language="javascript1.2">$('#reprise').show('slow');</script></td></tr>
<?php
	  }
	
	
	
	$affichage="";
	/////////////////////////////////////////////////////////////////////////////volet concernant deux ans en arrière 
	  $verdict=selTableData2Fields("verdict","matricule",$matricule,"annee_academique",$an_precedent2);
	  $result_ecu=selTableData2Fields("result_ecu","matricule",$matricule,"annee_acad",$an_precedent2);
	  $etab_controle=explode("-",$verdict[0]['filiere']);
	  $filiere2=$verdict[0]['filiere'];
	  //print_r($etab_controle);
	  if(($verdict[0]['result_semestre_1']=="Refuse" || $verdict[0]['result_semestre_1']=="Chevauche") && $filiere2!=$filiere1){
		 // echo "test";
		  //exit;
		//gestion des ecu ancien et nouvelle version
		$ue=selTableData2FieldsAsc("table_ue_new","code_ecole",$verdict[0]['filiere'],"promotion",$etudiant['promotion'],"designation");
		//print_r($ue);
		$param=selTableDataWhere("param","anne_academique",$an_precedent2);
		//print_r($ue);
		$a=0;
		for($i=0;$i<count($ue);$i++){
			$liste_ue="<tr><td colspan='3' bgcolor='#33DDEE'><b>UE : ".utf8_encode($ue[$i]['designation'])."</b></td></tr>";
			$ecu=selTableData2FieldsAsc("table_ecu_new","code_ue",$ue[$i]['code_ue'],"promotion",$etudiant['promotion'],"designation");
			$total=0;
			$test_ue="oui";
			$liste_ecu="";
			$liste_reserve="";
			$montant_ecu2=0;
			for($a=0;$a<count($ecu);$a++){
				for($o=0;$o<count($result_ecu);$o++){
					$montant_ecu=0;
					if($result_ecu[$o]['code_ecu']==$ecu[$a]['code_ecu']){ 
						$total=$total+ $result_ecu[$o]['moyenne'];
						if($result_ecu[$o]['moyenne']<$param['moyenne_ecu_mini']){
							$montant_ecu=$montant_ecu+round($param['montant_ecu']*$ecu[$a]['credit']);
							$montant_ecu2=$montant_ecu2+$montant_ecu;
							$liste_ecu.="<tr align='left'><td>".utf8_encode($ecu[$a]['designation'])." (".$result_ecu[$o]['moyenne']."/20)</td><td>".$ecu[$a]['credit']."</td><td align='left'><input name='ECU[]' type='checkbox' value='".$ecu[$a]['code_ecu']."' onchange=\"nodischecked('".$ecu[$a]['code_ecu']."')\" id='".$ecu[$a]['code_ecu']."' checked /><div align='right'> ".round($param['montant_ecu']*$ecu[$a]['credit'])." FCFA</div></td></tr>";
						}else{
							$liste_reserve.="<tr align='left'><td>".utf8_encode($ecu[$a]['designation'])." (".$result_ecu[$o]['moyenne']."/20)</td><td>".$ecu[$a]['credit']."</td><td align='left'><input name='ECU[]' type='checkbox' value='".$ecu[$a]['code_ecu']."' onchange=\"ischecked('".$ecu[$a]['code_ecu']."','".$ecu[$a]['credit']."','".$param['montant_ecu']."','total2')\" id='".$ecu[$a]['code_ecu']."'/> <div id='montant_".$ecu[$a]['code_ecu']."' align='right'></div></td></tr>";	
						}
						
					}
				}		
			}
			$total=$total/$a;
//			echo $montant_ecu2;
			$letest=explode("-",$verdict[0]['filiere']);
			/* if($letest[1]=="ESTCTPA"){
				if(round($total,2)<12 && ($liste_ecu!="" || $liste_reserve!="")){
					$affichage.=$liste_ue.$liste_ecu.$liste_reserve;
					$montant1=$montant1+$montant_ecu2;
				}
			}else{ */
				if(round($total,2)<$param['moyenne_ue_mini'] && ($liste_ecu!="" || $liste_reserve!="")){
					$affichage.=$liste_ue.$liste_ecu.$liste_reserve;
					$montant1=$montant1+$montant_ecu2;
				}else{
					if($liste_ecu!=""){
						$affichage.=$liste_ue.$liste_ecu.$liste_reserve;
						$montant1=$montant1+$montant_ecu2;
					}	
				}	
			//}
		}
	  if($affichage!=""){
	   ?>
  <tr>
  <td colspan="3" align="center" bgcolor="#FBEC88">Liste des ECU à reprendre pour l'année <b><?php echo $an_precedent2; ?></b> (ancienne note)</td>
    </tr>
  	<?php echo $affichage; ?>
    <tr>
    <td align="right" style="font-size:24px; color:#F00;" bgcolor="#FBEC88">MONTANT DES REPRISES : FF = </td>
    <td align="left" style="font-size:24px; color:#F00;" bgcolor="#FBEC88"><div align="left" id='total2'><?php echo $montant1; ?></div></td>
    <td align="left" style="font-size:24px; color:#F00;" bgcolor="#FBEC88">FCFA  <?php  if($verdict[0]['result_semestre_1']=="Refuse"){ echo "/ FI=15000 FCFA"; } ?></td>
    </tr>
<?php   
	  }
	} 
	
	//////////////////////////////////////////////////////////////////////////////////////volet concernant trois ans en arrière 
	  $verdict=selTableData2Fields("verdict","matricule",$matricule,"annee_academique",$an_precedent3);
	  $result_ecu=selTableData2Fields("result_ecu","matricule",$matricule,"annee_acad",$an_precedent3);
	  $etab_controle=explode("-",$verdict[0]['filiere']);
	  $filiere3=$verdict[0]['filiere'];
	  //print_r($etab_controle);
	  if(($verdict[0]['result_semestre_1']=="Refuse" || $verdict[0]['result_semestre_1']=="Chevauche") && $etab_controle[1]!='ESTCTPA' && $filiere3!=$filiere2){
		 // echo "test";
		  //exit;
		//gestion des ecu ancien et nouvelle version
		$ue=selTableData2FieldsAsc("table_ue_new","code_ecole",$verdict[0]['filiere'],"promotion",$etudiant['promotion'],"designation");
		//print_r($ue);
		$param=selTableDataWhere("param","annee_academique",$an_precedent);
		//print_r($ue);
		$a=0;
		for($i=0;$i<count($ue);$i++){
			$liste_ue="<tr><td colspan='3' bgcolor='#33DDEE'><b>UE : ".utf8_encode($ue[$i]['designation'])."</b></td></tr>";
			$ecu=selTableData2FieldsAsc("table_ecu_new","code_ue",$ue[$i]['code_ue'],"promotion",$etudiant['promotion'],"designation");
			$total=0;
			$test_ue="oui";
			$liste_ecu="";
			$liste_reserve="";
			$montant_ecu2=0;
			for($a=0;$a<count($ecu);$a++){
				for($o=0;$o<count($result_ecu);$o++){
					$montant_ecu=0;
					if($result_ecu[$o]['code_ecu']==$ecu[$a]['code_ecu']){ 
						$total=$total+ $result_ecu[$o]['moyenne'];
						if($result_ecu[$o]['moyenne']<$param['moyenne_ecu_mini']){
							$montant_ecu=$montant_ecu+round($param['montant_ecu']*$ecu[$a]['credit']);
							$montant_ecu2=$montant_ecu2+$montant_ecu;
							$liste_ecu.="<tr align='left'><td>".utf8_encode($ecu[$a]['designation'])." (".$result_ecu[$o]['moyenne']."/20)</td><td>".$ecu[$a]['credit']."</td><td align='left'><input name='ECU[]' type='checkbox' value='".$ecu[$a]['code_ecu']."' onchange=\"nodischecked('".$ecu[$a]['code_ecu']."')\" id='".$ecu[$a]['code_ecu']."' checked /><div align='right'> ".round($param['montant_ecu']*$ecu[$a]['credit'])." FCFA</div></td></tr>";
						}else{
							$liste_reserve.="<tr align='left'><td>".utf8_encode($ecu[$a]['designation'])." (".$result_ecu[$o]['moyenne']."/20)</td><td>".$ecu[$a]['credit']."</td><td align='left'><input name='ECU[]' type='checkbox' value='".$ecu[$a]['code_ecu']."' onchange=\"ischecked('".$ecu[$a]['code_ecu']."','".$ecu[$a]['credit']."','".$param['montant_ecu']."','total3')\" id='".$ecu[$a]['code_ecu']."'/> <div id='montant_".$ecu[$a]['code_ecu']."' align='right'></div></td></tr>";	
						}
						
					}
				}		
			}
			$total=$total/$a;
//			echo $montant_ecu2;
			$letest=explode("-",$verdict[0]['filiere']);
			/* if($letest[1]=="ESTCTPA"){
				if(round($total,2)<12 && ($liste_ecu!="" || $liste_reserve!="")){
					$affichage.=$liste_ue.$liste_ecu.$liste_reserve;
					$montant3=$montant3+$montant_ecu2;
				}
			}else{ */
				if(round($total,2)<$param['moyenne_ue_mini'] && ($liste_ecu!="" || $liste_reserve!="")){
					$affichage.=$liste_ue.$liste_ecu.$liste_reserve;
					$montant3=$montant3+$montant_ecu2;
				}else{
					if($liste_ecu!=""){
						$affichage.=$liste_ue.$liste_ecu.$liste_reserve;
						$montant3=$montant3+$montant_ecu2;
					}	
				}	
			//}
		}
	  if($affichage!=""){
	   ?>
  <tr>
  <td colspan="3" align="center" bgcolor="#FBEC88">Liste des ECU à reprendre pour l'année <b><?php echo $an_precedent3; ?></b> (ancienne note)</td>
    </tr>
  	<?php echo $affichage; ?>
    <tr>
    <td align="right" style="font-size:24px; color:#F00;" bgcolor="#FBEC88">MONTANT DES REPRISES : FF = </td>
    <td align="left" style="font-size:24px; color:#F00;" bgcolor="#FBEC88"><div align="left" id='total3'><?php echo $montant3; ?></div></td>
    <td align="left" style="font-size:24px; color:#F00;" bgcolor="#FBEC88">FCFA  <?php  if($verdict[0]['result_semestre_1']=="Refuse"){ echo "/ FI=15000 FCFA"; } ?></td>
    </tr>
<?php   
	  }
	}
		   
	$montant=$montant1+$montant2+$montant3;
  }

?>
</table><input type="hidden" name="FF" id="FF" value="<?php echo $montant; ?>"/></div>
</td></tr>
  <tr>
    <td colspan="6" align="center"><br />
<br />
<div id="div_contro" align="center"><input type="button" id="contro" name="contro" value="Controler" onClick="controles();" /></div><hr/></td>
  </tr>
  <tr>
    <td colspan="6" align="center"><div id="div_validation"><input type="button" id="reprendre" name="reprendre" value="<== Reprendre" onClick="retour();" /><input type="button" id="validation" name="validation" value="Suivant ==>" onClick="soumettre();" /></div></td>
  </tr>
</table>
</form>
<?php
}
?>
</body>
</html>