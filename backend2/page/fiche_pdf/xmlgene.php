<?php
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if (is_file("../connect/co.php"))
	include_once ("../connect/co.php");
if (is_file("../functions/queries.php"))
	include_once ("../functions/queries.php");

$err_msg="";
$msg_ajout="";
$msg_modif="";
$msg_dja="";

///action pour l'ajout d'une UFR
if(isset($_POST['matricule'])){
	//controle de la validation
	$controle=requete("SELECT count(*) as nombre FROM inscription WHERE matricule='".$_POST['matricule']."' AND annee_academique='".$_POST['annee']."' AND carte_imprime='oui'");
	if($controle[0]['nombre']>0){
		$champ=array('matricule','num_enregistrement','annee_acad','user');
		$valeur=array($_POST['matricule'],$_POST['enregistrement'],$_POST['annee'],$_POST['user']);
		insTable("duplicata",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?duplicata&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?duplicata&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('code','libelle');
	$valeur=array($_POST['code2'],$_POST['libelle2']);
	updTable("duplicatas",$champ,$valeur,"code",$_POST['modif']);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?duplicata&modifOK');
		// -->
		</script>";
}

?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript1.2">
$(document).ready( function(){
	$('#list_dept').dataTable({	
		"sPaginationType":"full_numbers",
		"oLanguage":{
			"sLengthMenu":"Afficher _MENU_ informations par page",
			"sZeroRecords":"Aucun resultat",
			"sInfo":"Liste de _START_ à _END_ sur _TOTAL_ ",
			"sInfoEmpty":"Liste de 0 à 0 sur 0",
			"sInfoFiltered":"(filtré à partir de _MAX_ enregistrements)"	
		}
	});	
});

function submitForm(form){
	$('#'+form).form('submit');
}
function clearForm(form){
	$('#'+form).form('clear');
}

function suppression(val,val2){
	
    $.messager.confirm('Confirm','Voulez vous supprimer ce duplicata : '+val,function(r){  
		if (r){  
			$.post('../js/xphp/sup/sup_duplicata.php',{matricule:val,annee:val2},function(data){  
				if(data==1){
					document.location.href="?duplicata&supOK";
				}else{
                    document.write(data);
                }
			});  
		}  
	});  	
}

</script>
<style type="text/css" title="styledatatable">
	@import "../css/demo_table.css";
	div.dataTables_filter{
	}
	div.dataTables_lenght{
	}
	div.dataTables_info{
	}
	div.dataTables_paginate{
	}
</style>
<div id="haut" style="height:75px"><center>GESTION DES XML</center></div>
<hr/>


<?php if(!isset($_GET['matricule']) || !isset($_GET['filiere']) || !isset($_GET['annee_acad'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="?duplicata" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="generation fichier xml" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="GET">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Matricule</td>
            <td><input name="matricule" id="matricule" class="easyui-validatebox" ></td>
          </tr>
            <tr>
            <td>filière</td>
            <td ><select name="filieres" id="filieres">
            <?php
			     $ufr=selTableData("filiere","code");
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['code']."'>".strtoupper($ufr[$i]['code'])."</option>";
				}	
			?>
            </select></td>
          </tr>
		  <tr>
            <td>Année Académique</td>
            <td ><select required="true" name="annees" id="annees">
            <?php
			     $ufr=selTableDataDesc("annee_academique","lib_annee");
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".$ufr[$i]['lib_annee']."'>".strtoupper($ufr[$i]['lib_annee'])."</option>";
				}	
			?>
            </select></td>
          </tr>
          <tr>
            <td colspan="2">
            <div id="dlg-buttons" align="center" style="padding:15px">
				<input name="generer" type="submit" value="Générer le xml" /><input name="users" id="users" type="hidden" value="<?php echo $_SESSION['username'] ?>"/><input name="xmlgene" id="xmlgene" type="hidden" value=""/>
   			</div>
            </td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
if(isset($_GET['matricule']) || !isset($_GET['filieres'])){
	if($_GET['matricule']!=""){
		$etudiant=selTableDataWhere("student","matricule",$_GET['matricule']);
		$inscription=selTableData2Fields("inscription","matricule",$etudiant['matricule'],"annee_academique",$_GET['annees']);
		$montantdu=$inscription[0]['FF']+$inscription[0]['FI']+$inscription[0]['montant_reprise'];
		$ecole=selTableDataWhere('filiere','code',$inscription[0]['filiere']);
		
		$xmlfile=genexml($_GET['matricule'],$etudiant['nom'],$etudiant['prenoms'],$etudiant['date_naissance'],$etudiant['lieu_naissance'],$etudiant['telephone'],$montantdu,$inscription[0]['annee_academique'],$inscription[0]['statut'],$ecole['ecole'],$inscription[0]['filiere'],$etudiant['nationalite'],"inscription");
	}
	if($_GET['matricule']=="" && $_GET['filieres']!=""){
			$liste=selTableData2Fields("inscription","filiere",$_GET['filieres'],"annee_academique",$_GET['annees']);
			var_dump($liste);
			for($i=0;$i<count($liste);$i++){
				$etudiant=selTableDataWhere("student","matricule",$liste[$i]['matricule']);
				$inscription=selTableData2Fields("inscription","matricule",$etudiant['matricule'],"annee_academique",$_GET['annees']);
				$montantdu=$inscription[0]['FF']+$inscription[0]['FI']+$inscription[0]['montant_reprise'];
				$ecole=selTableDataWhere('filiere','code',$inscription[0]['filiere']);
				
				$xmlfile=genexml($etudiant['matricule'],$etudiant['nom'],$etudiant['prenoms'],$etudiant['date_naissance'],$etudiant['lieu_naissance'],$etudiant['telephone'],$montantdu,$inscription[0]['annee_academique'],$inscription[0]['statut'],$ecole['ecole'],$inscription[0]['filiere'],$etudiant['Nationalite'],"inscription");
				var_dump($xmlfile);
				//echo "/////".$i."//////".$etudiant['matricule']."//".$etudiant['nom']."//".$etudiant['prenoms']."//".$etudiant['date_naissance']."//".$etudiant['lieu_naissance']."//".$etudiant['telephone']."//".$montantdu."//".$inscription[0]['annee_academique']."//".$inscription[0]['statut']."//".$ecole['ecole']."//".$inscription[0]['filiere']."//".$etudiant['Nationalite']."//"."inscription<br/>";
			}
			echo $i." fichier xml généré";
	}
}

?>