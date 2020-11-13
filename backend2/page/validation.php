<!-- Page Content -->
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
			<p class="panel-title" align="center">GESTION DES VALIDATIONS</p><br />
				<div class="row">
					<form action="?page=validation" method="GET">
						<div class="col-lg-5">Matricule : <input name='matricule' class="form-control" placeholder="Entre le matricule" size='30' value="<?php if(isset($_GET['matricule'])){ echo $_GET['matricule']; } ?>" /> </div>
						<div class="col-lg-5">Annee Academique : <select class="form-control" required="true" name="annee" id="annee">
						  <?php
								$ufr=selTableDataDesc("annee_academique","lib_annee");
									for($i=0;$i<count($ufr);$i++){
										echo "<option value='".$ufr[$i]['lib_annee']."'>".strtoupper($ufr[$i]['lib_annee'])."</option>";
									}	
								?>
						</select><input name="page" type="hidden" value="validation"/></div>
						<div class="col-lg-2"><br/><button type="submit" class="btn btn-default">Controler</button></div>
					</form>
				</div>
			<br />
			</div>
			<?php  if(isset($_GET['matricule'])){ 
				$montant=0; 
				$etudiant=selTableDataWhere("student","matricule",$_GET['matricule']);
				$inscription=selTableMultiAnswer("inscription","matricule",$_GET['matricule']);
				if(count($inscription)>0){
					$etab=selTableDataWhere('filiere','code',$inscription[0]['filiere']);
				
			?>
			<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-4">
							<div class="panel panel-info">
								<div class="panel-heading">
									Photo
								</div>
								<div class="panel-body">	
									<div class='row'>
										<div class="col-lg-12">
											<?php
												if(file_exists("photo/".trim($_GET['matricule']).".jpg")){
											?>
												<img align='center' src="<?php echo "photo/".trim($_GET['matricule']).".jpg"; ?>" alt="" name="photo" width="220" height="200" id="photo" />
											<?php
												}else{
											?>
												<img align='center' src="<?php echo "photo/2013/".$etudiant['num_table']."_2013.jpg"; ?>" alt="" name="photo" width="220" height="187" id="photo" />
											<?php	
												}
											?>
										</div>
									</div>
								</div>
								<div class="panel-footer">
									<input name="controler" type="submit" value="Changer la photo" />
								</div>
							</div>
							<!--  INTERFACE DES AUTORISATIONS -->
							<div class="panel panel-red">
								<div class="panel-heading">
									Autorisations et autres inscriptions
								</div>
								<div class="panel-body">	
									<div class='row'>
										<div class="table-responsive">
											<table class="table table-striped">
												<tr>
												  <td align="center" bgcolor="#CCCCC">AUTORISATION</td>
												</tr>
												<?php 
													if($etudiant['session']=='2013'){
														$auto=selTableData2Fields("autorisation","num_bac",$etudiant['num_table'],"annee_auto",$anneeEtude);
													}else{
														$auto=selTableData2Fields("autorisation","matricule",$etudiant['matricule'],"annee_auto",$anneeEtude);
													}
													if(count($auto)>0){
														for($i=0;$i<count($auto);$i++){
												?>
														<tr>
														  <td bgcolor="">
															<?php echo "<p class='text-muted'>[".$auto[$i]['code_auto']."]".utf8_encode($auto[$i]['nom'])." ".utf8_encode($auto[$i]['prenoms'])." [".$auto[$i]['filiere']."][".$auto[$i]['mode']."]</p>"; ?>      
														  </td>
														</tr>		
												 <?php
														}
													}else{
												?>
														<tr>
															<td bgcolor="">
																AUCUNE AUTORISATION
															</td>
														</tr>
												<?php			
													}
												 ?>
												 <tr>
												  <td bgcolor="">&nbsp;</td>
												</tr>
												<tr>
												  <td align="center" bgcolor="#CCCCC">AUTRES INSCRIPTIONS</td>
												</tr>
												<?php
												for($i=0;$i<count($inscription);$i++){
													if($inscription[$i]['annee_academique']!=$_GET['annee']){
														$verdict=selTableData2Fields('verdict','matricule',$inscription[$i]['matricule'],'annee_academique',$inscription[$i]['annee_academique']);
														if(count($verdict)>0){
															$verdict=$verdict[0];
															$verdict=$verdict['result_semestre_2'];
														}else{
															$verdict="";	
														}
												?>
												<tr>
												  <td bgcolor=""><p class='text-muted'><?php echo $inscription[$i]['annee_academique']." ".$inscription[$i]['filiere']." ".$inscription[$i]['statut']." | ".$verdict; ?></p></td>
												</tr>
												<?php	
													}
												}
												if($i==0){
												?>
												<tr>
												  <td bgcolor="#FFCCCC">PAS D'AUTRES INSCRIPTION </td>
												</tr>
												<?php	
												}
												?>
												<tr>
												  <td bgcolor="#FFCCCC">&nbsp;</td>
												</tr>
											  </table>
											</div>
										</div>
									</div>
								<div class="panel-footer">
									
								</div>
							</div>
							
						</div>
						<div class="col-lg-8">
							<div class="panel panel-info">
								<div class="panel-heading">
									Information personnel
								</div>
								<div class="panel-body">	
									<div class='row'>
										<div class="col-lg-12">
											<div class="table-responsive">
												<table class="table table-striped">
														<tr>
															<td>Matricule</td>
															<td><?php echo "<b>".$etudiant['matricule']."</b>"; ?><input name="matricule2" type="hidden" value="<?php echo $etudiant['matricule']; ?>" /></td>
														</tr>
														<tr>
															<td>Nom</td>
															<td><input name="nom" type="text" id="nom" value="<?php echo utf8_encode($etudiant['nom']); ?>" size="45" /></td>
														</tr>
														<tr>
															<td>Prénoms</td>
															<td><input name="prenoms" type="text" id="prenoms" value="<?php echo utf8_encode($etudiant['prenoms']); ?>" size="45"/></td>
														</tr>
														<tr>
															<td>Date et Lieu de naissance</td>
															<td>
													<input name="date_nais" type="date" id="date_nais" value="<?php echo $etudiant['date_naissance']; ?>" size="15"/> à <input name="lieu_naissance" type="text" id="lieu_naissance" value="<?php echo utf8_encode($etudiant['lieu_naissance']); ?>" size="20"/></td>
														</tr>
														<tr>
															<td>Nationalite</td>
															<td><?php $nation=selTableDataWhere("pays","cod_pays",$etudiant['Nationalite']);
																echo utf8_encode($nation['lib_nation']); ?></td>
														</tr>
														<tr>
															<td>Email UNA</td>
															<td><input name="email" type="text" id="email" value="<?php echo utf8_encode(strtolower($etudiant['email_uak'])); ?>" size="10"/> @unabenin.org <br/> <img src="../img/email.png" width="48" height="48" onclick="ajout_email('<?php echo strtolower(substr(utf8_encode($etudiant['nom']),0,2).substr(utf8_encode($etudiant['prenoms']),0,2).substr(utf8_encode($etudiant['lieu_naissance']),0,2)); ?>')" /></td>
														</tr>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-footer">
									<input name="controler" type="submit" value="Enregistrer les modifications" />
								</div>
							</div>
							<!-- VOLET INSCRIPTION EN COURS ---->
							<div class="panel panel-info">
								<div class="panel-heading">
									Information personnel
								</div>
								<div class="panel-body">	
									<div class='row'>
										<div class="col-lg-12">
											<div class="table-responsive">
												<table width="100%" border="0" cellpadding="0" cellspacing="2" class="texte_grand">
												<tr>
												  <td colspan="2" align="center" bgcolor="#CCCCC">INSCRIPTION DE L'ANNEE :<?php echo $_GET['annee']; ?> </td>
												  </tr>
												<?php
													for($i=0;$i<count($inscription);$i++){
														$a=0;
														if($inscription[$i]['annee_academique']==$_GET['annee']){		
														$a++;
												?>
												<tr>
												  <td colspan="2" align="center" bgcolor="#FFFFCC"><br />
													<?php 
														$ecole=selTableDataWhere("filiere","code",$inscription[$i]['filiere']);
														$ecole=selTableDataWhere("ecole_ufr","code_ecole",$ecole['ecole']);
														echo $ecole['lib_ecole']; 
													?>
													</td>
												  </tr>
												<tr>
												  <td colspan="2" align="center" bgcolor="#EAFAD1"><br />
													<?php 
														$montant=round($inscription[$i]['FF']+$inscription[$i]['FI']);
														echo $inscription[$i]['filiere']." (".$inscription[$i]['statut'].")<hr/><p  class='totat'>MONTANT : ".$montant."</p>"; 
													?>
													</td>
												  </tr>
												<tr>
												  <td colspan="2" align="center" bgcolor="">
												  <?php
													$ecu=selTableData2Fields("reprise_ecu","matricule",$etudiant['matricule'],"annee_academique",$_GET['annee']);
													if(count($ecu)>0){
													?>
													 <table bordercolor="#CCCCCC" width="99%" border="1" cellspacing="0">
														 <tr>
														   <td bgcolor="#E7E7E7">Intitulé</td>
														   <td bgcolor="#E7E7E7">Crédit</td>
														   <td bgcolor="#E7E7E7">Montant (FCFA)</td>
														 </tr>
														 <?php 
														 $tot=0;
															for($o=0;$o<count($ecu);$o++){
														  ?>
														 <tr >
														   <td><?php 
														  
															$lib=selTableData2Fields("table_ecu_new","code_ecu",$ecu[$o]['code_ecu'],'promotion',$etudiant['promotion']);
															$lib=$lib[0];
															//echo ">";
														   
															echo utf8_encode(strtoupper($lib['designation']))." (".$ecu[$o]['code_ecu'].")";
															?></td>
														   <td><?php echo $lib['credit']; ?></td>
														   <td><?php 
														   $tot=$tot+round(7000*$lib['credit']);
														   echo round(7000*$lib['credit']); ?></td>
														 </tr>
														 <?php 
														 }
														  ?>
														 <tr class="totat">
														   <td>TOTAL</td>
														   <td>&nbsp;</td>
														   <td><?php echo $tot; ?></td>
														 </tr>
													   </table><br/>
													   <table bordercolor="#CCCCCC" width="99%" border="1" cellspacing="0">
														 <tr class="totat">
															<td>TOTAL A PAYER : FI+FF+Reprise </td>
															<td colspan="2" align="center"> <?php echo $tot+$montant; ?> FCFA</td>
														 </tr>
													   </table>
													<?php
													}
												  ?>
												  </td>
												</tr>
												<tr>
												  <td width="50%" bgcolor="#FAAFCC" align="center"><?php if($inscription[$i]['controle']=='non'){ ?><img onclick="valide('valide','<?php echo $inscription[$i]['matricule'] ?>','<?php echo $inscription[$i]['filiere'] ?>','<?php echo $inscription[$i]['annee_academique'] ?>')" src="../img/valide.png" height="24" width="24" /><?php }else{ echo "Dossier validé par ".$inscription[$i]['utilisateur']." le ".convertdateanglais($inscription[$i]['date_validation'])."<br><img src='../img/cancel.png' width='25' height='25'/>"; } ?></td>
												  <td width="50%" bgcolor="#CCCFCC" align="center"><?php 
												  if($inscription[$i]['controle']=='oui'){
													  if($inscription[$i]['carte_imprime']=='non' || $inscription[$i]['carte_imprime']==''){ ?><a href="<?php  echo "carte_pdf.php?matricule=".$inscription[$i]['matricule']."&annee=".$_GET['annee']; ?>" target="_blank"><img src="../img/imprimante.png" height="24" width="24" /></a><?php }else{ echo "Carte déja imprimée par ".$inscription[$i]['carte_user']."<br><img src='../img/cancel.png' width='25' height='25'/>"; 
													  }
												  }
												  ?>
												  </td>
												  </tr>
												<?php
												if(in_array("uak",$_SESSION['etablissement']) && $inscription[$i]['carte_imprime']=='oui' && $inscription[$i]['controle']=='oui'){
												?>
												<tr>
												  <td align="center" bgcolor="#99CCCC">
												  <?php 
												   if($inscription[$i]['validation_final']==''){
												  ?>
												  Classer le dossier<br />          
													<img src="../img/classeur.png" width="48" height="48" onclick="valide('valide_final','<?php echo $inscription[$i]['matricule'] ?>','<?php echo $inscription[$i]['filiere'] ?>','<?php echo $inscription[$i]['annee_academique'] ?>');"/><br />
												   <?php 
																		$val=1;
																		$query_lotl="SELECT count( * ) as Nbre , lot FROM `inscription` WHERE filiere = \"".$inscription[$i]['filiere']."\" AND annee_academique = \"".$_GET['annee']."\" AND lot IS NOT NULL GROUP BY lot ORDER BY lot DESC";
																		//echo $query_lotl;
																		$lot=mysql_query($query_lotl) or die(mysql_error());
																		$row_lot1 = mysql_fetch_assoc($lot);
																		$tot=mysql_num_rows($lot);
																		//echo $tot;
																		echo "<select name='lot1' id='lot1'>";
																		$o=0;
																		$select1="";
																		$tota10=0;
																		$val=0;
																		$val1=$row_lot1['lot'];
																		do{
																			if($inscription[$i]['lot']!='' && $row_lot1['lot']==$inscription[$i]['lot']) $select1="selected";
																			if($tot==0){
																				echo "<option value='1'> Cr&eacute;er le premier lot </option>";
																			}else{
																				echo "<option value='".$row_lot1['lot']."' ".$select1.">LOT ".$row_lot1['lot']." (".$row_lot1['Nbre'].") </option>";
																			}
																			$o++;
																			$select1="";
																		}while($row_lot1 = mysql_fetch_assoc($lot));
																		if($tot>0){
																			echo "<option value='".round($val1+1)."' style=\"background:#FC0\"> Lot Suivant -->  </option>";
																		}
																		echo "</select>";
																					
																}else{
																	if($inscription[$i]['validation_final']=='oui'){
																		echo "Dossier déja validé par ".$inscription[$i]['user_valide_final']." le ".$inscription[$i]['date_validation_final']." et se trouve dans le lot :".$inscription[$i]['lot'];
																	}
																}
																			?>   
															  </td>
															  <td align="center" bgcolor="#99CCCC">
															  <?php
																  if($inscription[$i]['validation_final']=='non'){
																		echo "Dossier rejeté par ".$inscription[$i]['user_valide_final']." le ".$inscription[$i]['date_validation_final']." et le motif est  :".$inscription[$i]['motif_rejet'];
																	}else{
																		if($inscription[$i]['validation_final']==''){
															  ?>
															  <label>
																Rejeter le dossier<br />
																<textarea name="motif" id="motif" cols="45" rows="5"></textarea>
																<br />
																<img src="../img/stop.png" width="48" height="48"  onclick="if(confirm('Voulez vous rejeter ce dossier')){valide('rejet','<?php echo $inscription[$i]['matricule'] ?>','<?php echo $inscription[$i]['filiere'] ?>','<?php echo $inscription[$i]['annee_academique'] ?>');}" /></label>
																<?php
																		}
																	}
																?>
																</td>
															  </tr>
															<?php	
															}
																	}
																}
															?>
															
														  </table>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-footer">
									<input name="controler" type="submit" value="Enregistrer les modifications" />
								</div>
							</div>
							
							<!---- FIN VOLET INSCRIPTION -->
							
							
							
						</div>
				</div>
			</div>
			<?php 
				}
			}
			?>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</div>