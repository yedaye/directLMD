<?php
session_start();
session_destroy();
if(!isset($_SESSION['erreur'])){ 
	$_SESSION['erreur']="" ;
}
if(isset($_GET['reset'])){
	session_destroy();
	header("Location:inscription.php");
}

if (is_file("connect/co.php"))
	include_once ("connect/co.php");

if (is_file("functions/queries.php"))
	include_once ("functions/queries.php");
$err_msg="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inscription à l'UAK</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="js/default/easyui.css">
<link rel="stylesheet" type="text/css" href="js/icon.css">
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
<script language="javascript1.2" type="text/javascript">
//initialisation
function ouvre(val){
	if(val=="bac"){
		$('#reins').hide();
		$('#auto2').hide();
		$('#bac').show();
		$('#label_auto').hide();
		$('#label_ri').hide();
		$('#label_pi').show();
		$('#retour').show();
		$('#type').val("bachelier");
	};
	if(val=="reins"){
		$('#reins').show();
		$('#auto2').hide();
		$('#bac').hide();
		$('#label_auto').hide();
		$('#label_ri').show();
		$('#label_pi').hide();
		$('#retour').show();
		$('#type').val("reinscription");
	};
	if(val=="auto"){
		$('#reins').hide();
		$('#auto2').show();
		$('#bac').hide();
		$('#label_auto').show();
		$('#label_ri').hide();
		$('#label_pi').hide();
		$('#retour').show();
		$('#type').val("autorisation");
	};
}

/// controle du formulaire avant l'envoi
function validation(){
	valide=document.getElementById('type').value;
	matricule=document.getElementById('matricule').value;
	numbac=document.getElementById('numbac').value;
	codeauto=document.getElementById('codeauto').value;
	anneebac=document.getElementById('anneebac').value;
	
	if(valide=="" || (matricule=="" && numbac=="" && codeauto=="")){
		alert("veuillez faire correctement le choix du type d'inscription et remplir les champs correspondants");
	}else{
		if(valide=="bachelier"){
			$('#stay').show();
			$.post("js/xphp/firstcontrole.php?bachelier", {lenum:numbac ,lasession:anneebac, lemode:valide}, function(data){
				
				$('#letest').html(data);
				if(document.getElementById('montest').value=='OUI'){
					$('#form1').attr("action","form_inscrit.php?type=bachelier");
					document.getElementById('form1').submit();
				}else{
					// cas de BAC non conforme
					if(document.getElementById('montest').value=='BAC'){
						$.messager.alert('Oups','Seul les BAC C,D,E,I,F,DTI et DEAT sont autorisés à faire l\'UAK!','info');	
						$('#stay').fadeOut(500, function() {
							$(this).hide();	
						});
					}
					//cas de BAC inexistant
					if(document.getElementById('montest').value=='NON'){
						$.messager.alert('Oups','Vous n\'êtes pas dans la liste des admis au baccalauréat!','info');
						$('#stay').fadeOut(500, function() {
							$(this).hide();	
						});
					}
				}
			});			
		};
		if(valide=="reinscription"){
			$('#stay').show();
			$.post("js/xphp/firstcontrole.php?reinscription", {lenum:matricule, lemode:valide}, function(data){
				$('#letest').html(data);
				if(document.getElementById('montest').value=='OUI'){
					$('#form1').attr("action","form_inscrit.php?type=reinscription");
					document.getElementById('form1').submit();
				}else{
					alert("Votre numéro matricule est incorrect");	
					$('#stay').fadeOut(500, function(){
						$(this).hide();	
					});
				}
			});
		};
		if(valide=="autorisation"){
			$('#stay').show();
			$.post("js/xphp/firstcontrole.php?autorisation", {lecode:codeauto, lemode:valide}, function(data){
				$('#letest').html(data);
				if(document.getElementById('montest').value=='OUI'){
					$('#form1').attr("action","form_inscrit.php?type=autorisation");
					document.getElementById('form1').submit();
				}else{
					alert("Vous n'êtes pas autorisé à vous inscrire par cette option");	
					$('#stay').fadeOut(500, function() {
						$(this).hide();	
					});
				}
			});
		};
			
	}
}


</script>
</head>

<body>
<?php include("include_menu.html"); ?><br />
<br />
<br />

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><strong>1&egrave;re ETAPE<br/>
        <span class="Style6"><strong>IMPORTANT :  EVITEZ D'OUVRIR DEUX FEN&Ecirc;TRES POUR FAIRE DEUX INSCRIPTIONS SIMULTANEES SUR LE M&Ecirc;ME ORDINATEUR. FAITES LES INSCRIPTIONS l'UNE APRES l'AUTRE.</strong></br>
    </span></strong><hr/></td>
  </tr>
  <tr>
    <td><div align="center" id='retour' style="display:none"> <a href="inscription.php?reset" class="easyui-linkbutton">RETOUR</a></div>
      <form id="form1" name="form1" method="post" action="">
        <p>&nbsp;</p><input name="type" type="hidden" id="type" value=""/>
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="34%" bgcolor="#99CCCC"><div id="label_pi"> <strong>
              <!--input type="radio" name="pi" id="pi" value="pi" onclick="ouvre('bac');"/-->
              <input type="radio" name="pi" id="pi" value="pi" onclick="ouvre('bac')"/>
              Bachelier</strong> </div></td>
            <td width="5%">&nbsp;</td>
            <td width="33%" bgcolor="#CCCC66"><strong>
              <div id="label_ri">
                <input type="radio" name="ri" id="ri" value="ri" onclick="ouvre('reins');"/>
                <label for="ri">Reinscription</label>
              </div>
            </strong></td>
            <td width="4%">&nbsp;</td>
            <td width="24%" bgcolor="#C2EFFC"><div id="auto2"><strong>
              <input type="radio" name="auto" id="auto" value="auto" onclick="ouvre('auto');"/>
              <label for="auto">Inscription par autorisation</label></strong></div></td>
          </tr>
          <tr>
            <td colspan="5" align="center"><div id='bac' style="background-color:#99CCCC; height:45px; display:none"><strong>Numéro de table du BAC</strong>
<input type="text" name="numbac" id="numbac" /> 
             <strong>Année d'obtention du BAC</strong>
			 <select name="anneebac" id="anneebac">
			<?php
				$ufr=selTableDataDesc("annee_academique","lib_annee",$pdo);
				for($i=0;$i<count($ufr);$i++){
					echo "<option value='".substr($ufr[$i]['lib_annee'],0,4)."' ".$select.">".substr($ufr[$i]['lib_annee'],0,4)."</option>";
				}	
			?>
    </select>
</div></td>
          </tr>
          <tr>
            <td colspan="5" align="center"><div id='reins' style="background-color:#CCCC66; height:45px; display:none"><strong>Numéro matricule</strong> 
            <input type="text" name="matricule" id="matricule" /></div></td>
          </tr>
          <tr>
            <td colspan="5" align="center"><div id='auto2' style="background-color:#C2EFFC; height:45px;display:none"><strong>Code de l'autorisation</strong><input type="text" name="codeauto" id="codeauto" /></div></td>
          </tr>
          <tr>
            <td colspan="5" align="center"><div id="letest"></div><div id="stay" style="display:none"><img src="img/global_spinner.gif" alt="Veuillez patienter" id="encours" /></div></td>
          </tr>
          <tr>
            <td colspan="5" align="center"><div onclick="validation();"><a class="easyui-linkbutton">SUIVANT</a></div></td>
          </tr>
          </table>
      </form>
    </td>
  </tr>
  <tr>
    <td>
    
    </td>
  </tr>
</table>


</body>
</html>