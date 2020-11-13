<!-- DataTables CSS -->
<link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
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
if(isset($_POST['code'])){
	//controle de l'existance
	$controle=selTableDataCount("ufr","code_ufr",$_POST['code']);
	if($controle==0){
		$champ=array('code_ufr','lib_ufr','detail_ufr');
		$valeur=array($_POST['code'],$_POST['libelle'],$_POST['details']);
		insTable("ufr",$champ,$valeur);
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?page=ufr&ajoutOK');
		// -->
		</script>";
	}else{
		echo "<script language='Javascript'>
		<!--
		document.location.replace('?page=ufr&ajoutDJA');
		// -->
		</script>";
	}
}

///action pour la modification d'une UFR
if(isset($_POST['modif'])){
	$champ=array('code_ufr','lib_ufr','detail_ufr');
	$valeur=array($_POST['code2'],$_POST['libelle2'],$_POST['details2']);
	updTable("ufr",$champ,$valeur,"code_ufr",$_POST['modif']);
	echo "<script language='Javascript'>
		<!--
		document.location.replace('?page=ufr&modifOK');
		// -->
		</script>";
}

?>
<script type="text/javascript" src="../js/jquery.js"></script>

<script type="text/javascript" language="javascript1.2">

function submitForm(form){
	$('#'+form).form('submit');
}
function clearForm(form){
	$('#'+form).form('clear');
}

function suppression(val){ 
	if (confirm('Voulez vous supprimer cette UFR : '+val)){  
		$.post('../js/xphp/sup/sup_ufr.php',{code:val},function(data){  
			if(data==1){
				document.location.href="?page=ufr&supOK";
			}
		}); 
	};  	
}
</script>
<hr/>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Ajout','UFR Bien ajoutée!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte de modification
if(isset($_GET['modifOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Succès Modif','UFR modifié avec succès!','info');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['ajoutDJA'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Désolé','Cette UFR existe déjà!','warning');
    </script>
<?php
}
?>
<?php
//gestion du message d'alerte d'ajout
if(isset($_GET['supOK'])){
?>
	<script type="text/javascript" language="javascript1.2">
        $.messager.alert('Suppression','Cette UFR a été bien supprimée!','info');
    </script>
<?php
}
?>
<?php if(!isset($_GET['modif']) && !isset($_GET['ajout'])){ ?>

<div id="toolbar" align="right">  
            <a href="?page=ufr&ajout" class="easyui-linkbutton" iconCls="icon-add" plain="true">Nouveau</a>    
</div>  
<hr/>
<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									Liste des UFR 
								</div>
								<div class="panel-body">	
									<div class='row'>
										<div class="col-lg-12">
										<table width='100%' class="table table-striped table-bordered table-hover" id="dataTables-example">
												<thead>
													<tr>
														<th>CODE UFR</th>
														<th>LIBELLE</th>
														<th>DETAIL</th>
														<th> </th>
													</tr>
												</thead>
												<tbody>
												<?php
													$liste=selTableData("ufr","code_ufr");
													for($i=0; $i<count($liste);$i++){
													?>
												  <tr>
														<td><?php echo $liste[$i]['code_ufr']; ?></td>
														<td><?php echo $liste[$i]['lib_ufr']; ?></td>
														<td><?php echo $liste[$i]['detail_ufr']; ?></td>
														<td>  
												<a href="?page=ufr&modif=<?php echo $liste[$i]['code_ufr']; ?>"><button class="btn btn-warning btn-circle btn-lg"><i class="fa fa-edit"></i></button></a>
												<button class="btn btn-danger btn-circle btn-lg" onclick="suppression('<?php echo $liste[$i]['code_ufr']; ?>')"><i class="fa fa-times"></i>
                             </button>
														</td>
													</tr>
												<?php
													}
												?>
												</tbody>
											  </table>
												</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				</div>
<?php } ?>
<?php if(!isset($_GET['modif']) && isset($_GET['ajout'])){ ?>
<div align="center" id='retour' style="display:none"> <a href="?page=ufr" class="easyui-linkbutton">RETOUR</a></div>
<!-- formulaire d'ajout  -->
<div align="center" id="p" class="easyui-panel" title="Ajout d'une nouvelle UFR" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Code UFR</td>
            <td><input name="code" id="code" class="easyui-validatebox" required="true" ></td>
          </tr>
          <tr>
            <td>Libellé UFR</td>
            <td><input name="libelle" id="libelle" class="easyui-validatebox" required="true"></td>
          </tr>
          <tr>
            <td>Détail</td>
            <td><textarea cols="35" rows="8" class="" name="details" id="details"></textarea></td>
          </tr>
          <tr>
            <td colspan="2">
            <div id="dlg-buttons" align="center" style="padding:15px">
				<input name="ajouter" type="submit" value="ajouter" />
   			</div>
            </td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
?>
<!-- formulaire de modification -->
<?php if(isset($_GET['modif']) && $_GET['modif']!="" && !isset($_GET['ajout'])){ 
$modifcation=selTableDataWhere("ufr","code_ufr",$_GET['modif']);
?>
<div align="center" id='retour' style="display:none"> <a href="?page=ufr" class="easyui-linkbutton">RETOUR</a></div>
<div id="p" class="easyui-panel" title="Ajout d'une nouvelle UFR" style="width:550px;height:300px;padding:10px;"
        data-options="iconCls:'icon-save',maximizable:true">
    <form id="fm2" method="post">  
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>Code UFR</td>
            <td><input name="code2" id="code2" class="easyui-validatebox" required="true" value="<?php echo $modifcation['code_ufr']; ?>"></td>
          </tr>
          <tr>
            <td>Libellé UFR</td>
            <td><input name="libelle2" id="libelle2" class="easyui-validatebox" required="true" value="<?php echo $modifcation['lib_ufr']; ?>"></td>
          </tr>
          <tr>
            <td>Détail</td>
            <td><textarea cols="35" rows="8" class="" name="details2" id="details2"> <?php echo $modifcation['detail_ufr']; ?></textarea></td>
          </tr>
          <tr>
            <td colspan="2"><input name="modif" id="modif" value="<?php echo $_GET['modif']; ?>" type="hidden" />
            <div id="dlg-buttons" align="center" style="padding:15px">
				<input name="ajouter" type="submit" value="Modifier" iconCls="icon-ok" />
   			</div>
            </td>
          </tr>
        </table>
    </form> 
</div>
<?php
}
?>
 <!-- DataTables JavaScript -->
 <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
$(document).ready(function(){
	$('#dataTables-example').DataTable({
		responsive: true
	});
});
</script>