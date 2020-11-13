<?php
session_start();
include("../connect/co.php");
$a=0;
if(isset($_POST['login']) && $_POST['login']!=""){
	//print_r($_POST);
	//exit;
	$qry="select * from utilisateur where username='".$_POST['login']."' AND mot_de_passe=MD5('".$_POST['mp']."')";
  //echo $_POST['email']."///".$_POST['email'];	
  //echo $qry;
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
</head>

<body>
<?php   
	if($a==1){
?>
	<center><div class="messager-warning" id="Message" align="center" style="height:100px; width:450px"><?php echo "VOUS N'ETES PAS 	AUTORISEZ A ACCEDER A CETTE PAGE!" ?></div></center><br />
<?php	
	}
?>
<div align="center" id='retour'> <a href="../" class="easyui-linkbutton">RETOUR</a></div><br/>
 <p align="center"><img src="../img/cadenas.png" width="48" height="48" /></p>
 <table border="0" align="center"><tr><td>
 <div class="easyui-panel" title="Connexion au backend" style="width:550px" align="center">
<form id="forma" name="forma" method="post" action="index.php">
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
		<input name="btn_envoi" type="submit" value="connexion" />
      </td>
    </tr>
  </table>
</form>
</div>
</td></tr></table><br/>
</body>
</html>