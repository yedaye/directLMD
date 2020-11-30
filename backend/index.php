<?php
session_start();
include("../connect/co.php");
$a=0;
if(isset($_POST['login']) && $_POST['login']!=""){
  //captcha control
  $response = $_POST["g-recaptcha-response"];

	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => '6LfYN_MZAAAAAHEvcpk4JzymUdlvztzBH6R5FkH0',
		'response' => $_POST["g-recaptcha-response"]
	);
	$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success=json_decode($verify);

	if ($captcha_success->success==false) {
		$a=2;
	} else if ($captcha_success->success==true) {
    $qry="select * from utilisateur where username='".$_POST['login']."' AND mot_de_passe=MD5('".$_POST['mp']."')";
    $stm = $pdo->query($qry);
    $count = $stm->rowcount(); 
    if($count>0){
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
      $result=$result[0];
      $_SESSION['nom']=$result['nom'];
      $_SESSION['prenoms']=$result['prenoms'];
      $_SESSION['droit']=	$result['droit'];
      $_SESSION['id']=$result['id'];
      $_SESSION['username']=$result['username'];
      $_SESSION['etablissement']=array();
      $_SESSION['etablissement']=explode(";",$result['etab']);	
      header("location:accueil.php?accueil");
    }else{
      $a=1;
    }
  }
}
if(isset($_GET['reset'])){
	session_destroy();
	session_start();	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ESPACE PRIVE DE UAK</title>
<link rel="stylesheet" type="text/css" href="../css/default.css" />
<link rel="stylesheet" type="text/css" href="../js/default/easyui.css">
<link rel="stylesheet" type="text/css" href="../js/icon.css">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
<script type="text/javascript">
    var onloadCallback = function() {
      grecaptcha.render('html_element', {
        'sitekey' : '6LfYN_MZAAAAAF6-8PHlpEumDAsri-88pCpHg34J'
      });
    };
  </script>
</head>

<body>
<?php   
	if($a==1){
?>
	<center><div class="messager-warning" id="Message" align="center" style="height:100px; width:450px"><?php echo "VOUS N'ETES PAS 	AUTORISEZ A ACCEDER A CETTE PAGE!" ?></div></center><br />
<?php	
  }
  if($a==2){
    ?>
      <center><div class="messager-warning" id="Message2" align="center" style="height:100px; width:450px"><?php echo "Veuillez cocher le captcha de controle" ?></div></center><br />
    <?php	
      }
?>
<div align="center" id='retour'> <a href="../" class="easyui-linkbutton">RETOUR</a></div><br/>
 <p align="center"><img src="../img/cadenas.png" width="48" height="48" /></p>
 <table border="0" align="center"><tr><td>
 <div class="easyui-panel" title="Connexion au backend" style="width:550px" align="center">
<form id="demo-form" name="demo-form" method="post" action="index.php"  enctype="multipart/form-data">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="5" id='ff'>
    <tr>
      <td width="119"><strong>Login :</strong></td>
      <td width="281"><label for="login"></label>
      <input name="login" type="text" class="easyui-validatebox" id="login" size="35" data-options="required:true"/></td>
    </tr>
    <tr>
      <td><strong>Mot de passe :</strong></td>
      <td><label for="mp"></label>
      <input name="mp" type="password" class="easyui-validatebox" id="mp" size="35" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
      <div class="captcha_wrapper">
        <div id="html_element" class="g-recaptcha"></div>
      </div>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>
      <button type="submit" id="send_message">connexion</button>
     </td>
    </tr>
  </table>
  
     
</form>
</div>
</td></tr></table><br/>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>
</body>
</html>