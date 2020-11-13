<?php
if(isset($_FILES['photo_new']) && $_FILES['photo_new']!=''){
	print_r($_POST);
	break;
	if($_FILES['photo_new']['name']!=""){
		copy($_FILES['photo_new']['tmp_name'],"photo/".trim($_GET['matricule2']).".jpg");
	}
}
?>