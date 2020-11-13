<!-- DataTables CSS -->
<link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
<!-- Page Content -->
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
			<p class="panel-title" align="center">Liste des étudiants</p><br />
				<div class="row">
					<form action="?page=validation" method="GET">
						<div class="col-lg-3">Matricule : <input name='matricule' class="form-control" placeholder="Entre le matricule" size='30' value="<?php if(isset($_GET['matricule'])){ echo $_GET['matricule']; } ?>" /> </div>
						<div class="col-lg-3">Ecole : 
							<select name='ecole' id='ecole' class="form-control">
								<option value=''>---</option>
								<?php
									$ecole=requete('SELECT * FROM ecole_ufr WHERE actif=1 ORDER BY lib_ecole ASC');
									//$ecole=$ecole[0];
									$select="";
									for($o=1;$o<count($ecole);$o++){
										if(isset($_GET['ecole']) && $_GET['ecole']==$ecole[$o]['code_ecole']){$select="selected=\"selected\"";}
										echo "<option value='".$ecole[$o]['code_ecole']."' ".$select.">".$ecole[$o]['lib_ecole']."</option>";
										$select="";
									}
								?>
							</select>
						</div>
						<div class="col-lg-3">Annee Academique : <select class="form-control" required="true" name="annee" id="annee">
						  <?php
								$ufr=selTableDataDesc("annee_academique","lib_annee");
									for($i=0;$i<count($ufr);$i++){
										echo "<option value='".$ufr[$i]['lib_annee']."'>".strtoupper($ufr[$i]['lib_annee'])."</option>";
									}	
								?>
						</select><input name="page" type="hidden" value="liste_etu"/></div>
						<div class="col-lg-2"><br/><button type="submit" class="btn btn-default">Filtrer</button><div id='montre'></div></div>
					</form>
				</div>
			<br />
			</div>
			<?php 
			if(isset($_GET['matricule'])){ 
				$where="";
				if($_GET['matricule']!=''){ $where.=" AND student.matricule='".$_GET['matricule']."'"; }	
				if($_GET['ecole']!=''){ $where.=" AND filiere LIKE '%".$_GET['ecole']."'"; }	
				if($_GET['annee']!=''){ $where.=" AND annee_academique = '".$_GET['annee']."'"; }	
				$requete="SELECT student.matricule, nom, prenoms, date_naissance, lieu_naissance, annee_academique, filiere, date_inscription  FROM student, inscription WHERE student.matricule=inscription.matricule ".$where." ORDER BY filiere ASC";
			}else{
				$requete="SELECT student.matricule, nom, prenoms, date_naissance, lieu_naissance, telephone, annee_academique, filiere, date_inscription, (FF+FI+montant_reprise) as paye FROM student, inscription WHERE student.matricule=inscription.matricule AND annee_academique='".$anneeEtude."' ORDER BY filiere ASC";
			}
			
			//session pour excel
			$_SESSION['requete']=$requete;
			$_SESSION['colonne']="matricule, nom, prenoms, date_naissance, lieu_naissance, annee_academique, filiere, date_inscription, paye";
			
			$etudiant=requete($requete);
			
			if(count($etudiant)>0){
			?>
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									Liste des étudiants de l'année <?php echo $anneeEtude; ?>
								</div>
								<div class="panel-body">	
									<div class='row'>
										<div class="col-lg-12">
											 <table width='100%' class="table table-striped table-bordered table-hover" id="dataTables-example">
												<thead>
													<tr>
														<th></th>
														<th>Matricule</th>
														<th>Nom</th>
														<th>Prénoms</th>
														<th>Date Naissance</th>
														<th>Lieu Naissance</th>
														<th>Téléphone</th>
														<th>Filière</th>
														<th>Montant Payé</th>
													</tr>
												</thead>
												<tbody>
												<?php
													for($i=0;$i<count($etudiant);$i++){
												?>
												  <tr>
													<td>
														<img onClick="montre('<?php echo $etudiant['matricule']; ?>')" src="<?php echo "../backend/photo/".$etudiant[$i]['matricule'].".jpg"; ?>" alt="" width="30" height="27"/>
													</td>
													<td><?php echo $etudiant[$i]['matricule']; ?></td>
													<td><?php echo utf8_encode($etudiant[$i]['nom']); ?></td>
													<td><?php echo utf8_encode($etudiant[$i]['prenoms']); ?></td>
													<td><?php echo $etudiant[$i]['date_naissance']; ?></td>
													<td><?php echo utf8_encode($etudiant[$i]['lieu_naissance']); ?></td>
													<td><?php echo $etudiant[$i]['telephone']; ?></td>
													<td><?php echo $etudiant[$i]['filiere']; ?></td>
													<td><?php echo $etudiant[$i]['paye']; ?></td>
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
								<div class="panel-footer">
									<span align='right'><a href=""> Exporter le resultat sous excel ==></a></span>
								</div>
							</div>
						</div>
				</div>
			<?php 
				}else{
			?>
			<div class="col-lg-12">
				<div class="alert alert-info">
					<strong>Info!</strong> Aucun étudiant trouvé.
				</div>
			</div>
			<?php
			
				}
			?>
			
			<!-- /.col-lg-12 -->
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</div>

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

function montre(photo){
	$('#montre').html("<img src='../backend/photo/"+photo+".jpg' alt='' width='300' height='310'/>");
	$('#montre').dialog({ autoOpen: false, title: "dialog", width: 350, height:400, modal:true });	
}
</script>