<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript1.2" src="ajax.js"></script>
<title>GESTION DES PHOTOS</title>
</head>
<body>
<?php
if(!isset($_POST['matricule3'])){
?>
<center>
<table>
	<tr>
		<td colspan="2" align="center" valign="middle">
			<?php
				if(file_exists("photo/".trim($_GET['matricule3']).".jpg")){
			?>
				<img src="<?php echo "photo/".trim($_GET['matricule3']).".jpg"; ?>" alt="" name="photo" width="220" height="187" id="photo" />
			<?php
				}else{
			?>
				<img src="<?php echo "photo/2013/".$_GET['num_table']."_2013.jpg"; ?>" alt="" name="photo" width="220" height="187" id="photo" />
			<?php	
				}
			?>
		</td>
	</tr>
</table>
<form id="form3" name="form3" method="POST" action="" enctype="multipart/form-data">       
	<input type="submit" name="tof" id="tof" value="Changer la photo" />
	<input name="matricule3" type="hidden" value="<?php echo $_GET['matricule3']; ?>" />
	<input type="file" name="photo_new" id="photo_new" />
</form></center>
<?php
}else{
 	if($_FILES['photo_new']['name']!=""){
		copy($_FILES['photo_new']['tmp_name'],"photo/".trim($_POST['matricule3']).".jpg");
	}
	echo "<script language='Javascript'>
		document.location.replace(\"accueil.php?matricule=".$_POST['matricule3']."&annee=2017-2018&validation=&controler=controler\");
		</script>";
}
?>
</body>
</html>