<!-- Page Content -->
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
					<?php
				if(isset($_GET['matricule']) || isset($_GET['num_table'])){
					
					include_once("../../connect/co.php");
					include_once("../../param.php");
					include_once ("../../functions/queries.php");
					if($_GET['matricule']!=""){
						$etudiant=selTableDataWhere("student","matricule",$_GET['matricule']);
					}else{
						$etudiant=selTableDataWhere("student","num_table",$_GET['num_table']);
					}
					$inscription=selTableData2Fields("inscription","matricule",$etudiant['matricule'],"annee_academique",$_GET['an_etude']);
					
					$ecu=selTableData2Fields("reprise_ecu","matricule",$etudiant['matricule'],"annee_academique",$_GET['an_etude']);
					if(count($inscription)>0){
							if(count($ecu)>0){
							//	print_r($inscription);
							?>
							<table border="0" cellpadding="0" cellspacing="0" width="650" align="center">
							<!-- fwtable fwsrc="fiche_ecu.png" fwpage="Page 1" fwbase="fiche_ecu.jpg" fwstyle="Dreamweaver" fwdocid = "1350424229" fwnested="0" -->
							  <tr>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="20" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="112" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="76" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="24" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="50" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="41" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="19" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="40" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="23" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="212" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="12" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="21" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="1" border="0" alt="" /></td>
							  </tr>
							
							  <tr>
							   <td colspan="12"><img name="fiche_ecu_r1_c1" src="../fiche/image_ecu/fiche_ecu_r1_c1.jpg" width="650" height="5" border="0" id="fiche_ecu_r1_c1" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="5" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="4" colspan="6"><img name="fiche_ecu_r2_c1" src="../fiche/image_ecu/fiche_ecu_r2_c1.jpg" width="323" height="123" border="0" id="fiche_ecu_r2_c1" alt="" /></td>
							   <td colspan="4" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r2_c7.jpg"><?php echo $_GET['an_etude']; ?></td>
							   <td rowspan="24" colspan="2"><img name="fiche_ecu_r2_c11" src="../fiche/image_ecu/fiche_ecu_r2_c11.jpg" width="33" height="507" border="0" id="fiche_ecu_r2_c11" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="36" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="4"><img name="fiche_ecu_r3_c7" src="../fiche/image_ecu/fiche_ecu_r3_c7.jpg" width="294" height="4" border="0" id="fiche_ecu_r3_c7" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="4" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="4" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r4_c7.jpg"><?php echo $inscription[0]['num_inscription']; ?></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="36" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="4"><img name="fiche_ecu_r5_c7" src="../fiche/image_ecu/fiche_ecu_r5_c7.jpg" width="294" height="47" border="0" id="fiche_ecu_r5_c7" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="47" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="12" colspan="3"><img name="fiche_ecu_r6_c1" src="../fiche/image_ecu/fiche_ecu_r6_c1.jpg" width="208" height="237" border="0" id="fiche_ecu_r6_c1" alt="" /></td>
							   <td colspan="7" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r6_c4.jpg"><?php echo $inscription[0]['matricule']; ?></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7"><img name="fiche_ecu_r7_c4" src="../fiche/image_ecu/fiche_ecu_r7_c4.jpg" width="409" height="5" border="0" id="fiche_ecu_r7_c4" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="5" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r8_c4.jpg"><?php echo utf8_encode($etudiant['nom']); ?></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7"><img name="fiche_ecu_r9_c4" src="../fiche/image_ecu/fiche_ecu_r9_c4.jpg" width="409" height="6" border="0" id="fiche_ecu_r9_c4" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="6" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r10_c4.jpg"><?php echo utf8_encode($etudiant['prenoms']); ?></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7"><img name="fiche_ecu_r11_c4" src="../fiche/image_ecu/fiche_ecu_r11_c4.jpg" width="409" height="5" border="0" id="fiche_ecu_r11_c4" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="5" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r12_c4.jpg"><?php echo $etudiant['date_naissance']; ?> / <?php echo utf8_encode($etudiant['lieu_naissance']); ?></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7"><img name="fiche_ecu_r13_c4" src="../fiche/image_ecu/fiche_ecu_r13_c4.jpg" width="409" height="7" border="0" id="fiche_ecu_r13_c4" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="7" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r14_c4.jpg"><?php 
									  $nation=selTableDataWhere("pays","cod_pays",$etudiant['Nationalite']);
									  echo utf8_encode($nation['lib_nation']); ?></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7"><!--- <img name="fiche_ecu_r15_c4" src="../fiche/image_ecu/fiche_ecu_r15_c4.jpg" width="409" height="9" border="0" id="fiche_ecu_r15_c4" alt="" /> --></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="9" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r16_c4.jpg"><?php 	
										$ecole=selTableDataWhere("filiere","code",$inscription[0]['filiere']);
										$lib=selTableDataWhere("ecole_ufr","code_ecole",$ecole['ecole']);
										echo $libecole=$lib['lib_ecole']; 
									?></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="63" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="7"><!---<img name="fiche_ecu_r17_c4" src="../fiche/image_ecu/fiche_ecu_r17_c4.jpg" width="409" height="7" border="0" id="fiche_ecu_r17_c4" alt="" />--></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="7" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="8" colspan="2"><img name="fiche_ecu_r18_c1" src="../fiche/image_ecu/fiche_ecu_r18_c1.jpg" width="132" height="147" border="0" id="fiche_ecu_r18_c1" alt="" /></td>
							   <td colspan="5" rowspan="2" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r18_c3.jpg"><?php echo $inscription[0]['filiere']; ?></td>
							   <td colspan="3"><img name="fiche_ecu_r18_c8" src="../fiche/image_ecu/fiche_ecu_r18_c8.jpg" width="275" height="1" border="0" id="fiche_ecu_r18_c8" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="1" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="4" colspan="2"><img name="fiche_ecu_r19_c8" src="../fiche/image_ecu/fiche_ecu_r19_c8.jpg" width="63" height="43" border="0" id="fiche_ecu_r19_c8" alt="" /></td>
							   <td rowspan="2" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r19_c10.jpg"><?php echo $inscription[0]['statut']; ?></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="26" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="2" colspan="5"><img name="fiche_ecu_r20_c3" src="../fiche/image_ecu/fiche_ecu_r20_c3.jpg" width="210" height="15" border="0" id="fiche_ecu_r20_c3" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="1" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="2"><img name="fiche_ecu_r21_c10" src="../fiche/image_ecu/fiche_ecu_r21_c10.jpg" width="212" height="16" border="0" id="fiche_ecu_r21_c10" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="14" border="0" alt="" /></td>
							  </tr>
							  <tr class="totat">
							   <td colspan="2" rowspan="2" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r22_c3.jpg"><?php echo $inscription[0]['FI']; ?></td>
							   <td colspan="3"><img name="fiche_ecu_r22_c5" src="../fiche/image_ecu/fiche_ecu_r22_c5.jpg" width="110" height="2" border="0" id="fiche_ecu_r22_c5" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="2" border="0" alt="" /></td>
							  </tr>
							  <tr class="totat">
							   <td rowspan="3"><img name="fiche_ecu_r23_c5" src="../fiche/image_ecu/fiche_ecu_r23_c5.jpg" width="50" height="103" border="0" id="fiche_ecu_r23_c5" alt="" /></td>
							   <td colspan="3" rowspan="2" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r23_c6.jpg"><?php echo $inscription[0]['FF']; ?></td>
							   <td rowspan="3"><img name="fiche_ecu_r23_c9" src="../fiche/image_ecu/fiche_ecu_r23_c9.jpg" width="23" height="103" border="0" id="fiche_ecu_r23_c9" alt="" /></td>
							   <td rowspan="2" align="center" valign="middle" background="../fiche/image_ecu/fiche_ecu_r23_c10.jpg"><?php echo $inscription[0]['FF']+ $inscription[0]['FI']; ?></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="25" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="2" colspan="2"><img name="fiche_ecu_r24_c3" src="../fiche/image_ecu/fiche_ecu_r24_c3.jpg" width="100" height="78" border="0" id="fiche_ecu_r24_c3" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="2" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="3"><img name="fiche_ecu_r25_c6" src="../fiche/image_ecu/fiche_ecu_r25_c6.jpg" width="100" height="76" border="0" id="fiche_ecu_r25_c6" alt="" /></td>
							   <td><img name="fiche_ecu_r25_c10" src="../fiche/image_ecu/fiche_ecu_r25_c10.jpg" width="212" height="76" border="0" id="fiche_ecu_r25_c10" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="76" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="2"><img name="fiche_ecu_r26_c1" src="../fiche/image_ecu/fiche_ecu_r26_c1.jpg" width="20" height="448" border="0" id="fiche_ecu_r26_c1" alt="" /></td>
							   <td colspan="10" align="center" valign="top" background="../fiche/image_ecu/fiche_ecu_r26_c2.jpg">
							   <table bordercolor="#CCCCCC" width="99%" border="1" cellspacing="0">
								 <tr>
								   <td bgcolor="#E7E7E7">Intitulé</td>
								   <td bgcolor="#E7E7E7">Crédit</td>
								   <td bgcolor="#E7E7E7">Montant (FCFA)</td>
								 </tr>
								 <?php 
								 $tot=0;
								 //print_r($ecu);
									for($i=0;$i<count($ecu);$i++){
								  ?>
								 <tr >
								   <td><?php 
										//echo "////".$ecu[$i]['code_ecu']."///";
										$lib=selTableData2Fields("table_ecu_new","code_ecu",$ecu[$i]['code_ecu'],'promotion',$etudiant['promotion']);
										$lib=$lib[0];
							//			echo ">";
									//print_r($lib);
									echo utf8_encode(strtoupper($lib['designation']))." (".$ecu[$i]['code_ecu'].")";
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
									<td colspan="2" align="center"> <?php echo $tot+$inscription[0]['FF']+ $inscription[0]['FI']; ?> FCFA</td>
								 </tr>
								 </table>
							   </td>
							   <td rowspan="2"><img name="fiche_ecu_r26_c12" src="../fiche/image_ecu/fiche_ecu_r26_c12.jpg" width="21" height="448" border="0" id="fiche_ecu_r26_c12" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="380" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="10"><img name="fiche_ecu_r27_c2" src="../fiche/image_ecu/fiche_ecu_r27_c2.jpg" width="609" height="68" border="0" id="fiche_ecu_r27_c2" alt="" /></td>
							   <td><img src="../fiche/image_ecu/spacer.gif" width="1" height="68" border="0" alt="" /></td>
							  </tr>
							</table><br />
							<?php }else{ ?>
							<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
							  <!-- fwtable fwsrc="fiche.png" fwpage="Page 1" fwbase="fiche.jpg" fwstyle="Dreamweaver" fwdocid = "1350424229" fwnested="0" -->
							  <tr>
							   <td><img src="../fiche/images_old/spacer.gif" width="126" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="6" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="70" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="6" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="18" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="6" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="44" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="6" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="29" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="12" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="13" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="6" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="34" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="6" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="17" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="6" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="201" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="5" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="6" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="33" height="1" border="0" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="1" border="0" alt="" /></td>
							  </tr>
							
							  <tr>
							   <td colspan="20"><img name="fiche_r1_c1" src="../fiche/images_old/fiche_r1_c1.jpg" width="650" height="5" border="0" id="fiche_r1_c1" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="5" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="4" colspan="10"><img name="fiche_r2_c1" src="../fiche/images_old/fiche_r2_c1.jpg" width="323" height="123" border="0" id="fiche_r2_c1" alt="" /></td>
							   <td colspan="9" align="center" valign="middle" background="../fiche/images_old/fiche_r2_c11.jpg"><?php echo $_GET['an_etude']; ?></td>
							   <td rowspan="47"><img name="fiche_r2_c20" src="../fiche/images_old/fiche_r2_c20.jpg" width="33" height="955" border="0" id="fiche_r2_c20" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="36" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="9" align="center" valign="middle"><img name="fiche_r3_c11" src="../fiche/images_old/fiche_r3_c11.jpg" width="294" height="4" border="0" id="fiche_r3_c11" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="4" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="9" align="center" valign="middle" background="../fiche/images_old/fiche_r4_c11.jpg"><?php echo $inscription[0]['num_inscription']; ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="36" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="9" align="center" valign="middle"><img name="fiche_r5_c11" src="../fiche/images_old/fiche_r5_c11.jpg" width="294" height="47" border="0" id="fiche_r5_c11" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="47" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="12" colspan="4"><img name="fiche_r6_c1" src="../fiche/images_old/fiche_r6_c1.jpg" width="208" height="237" border="0" id="fiche_r6_c1" alt="" /></td>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r6_c5.jpg"><?php echo $inscription[0]['matricule']; ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r7_c5" src="../fiche/images_old/fiche_r7_c5.jpg" width="409" height="5" border="0" id="fiche_r7_c5" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="5" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r8_c5.jpg"><?php echo utf8_encode($etudiant['nom']); ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r9_c5" src="../fiche/images_old/fiche_r9_c5.jpg" width="409" height="6" border="0" id="fiche_r9_c5" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="6" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r10_c5.jpg"><?php echo utf8_encode($etudiant['prenoms']); ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r11_c5" src="../fiche/images_old/fiche_r11_c5.jpg" width="409" height="5" border="0" id="fiche_r11_c5" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="5" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r12_c5.jpg"><?php echo $etudiant['date_naissance']; ?> / <?php echo utf8_encode($etudiant['lieu_naissance']); ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r13_c5" src="../fiche/images_old/fiche_r13_c5.jpg" width="409" height="7" border="0" id="fiche_r13_c5" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="7" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r14_c5.jpg"><?php 
									  $nation=selTableDataWhere("pays","cod_pays",$etudiant['Nationalite']);
									  echo utf8_encode($nation['lib_nation']); ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r15_c5" src="../fiche/images_old/fiche_r15_c5.jpg" width="409" height="9" border="0" id="fiche_r15_c5" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="9" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r16_c5.jpg"><?php 	
										$ecole=selTableDataWhere("filiere","code",$inscription[0]['filiere']);
										$lib=selTableDataWhere("ecole_ufr","code_ecole",$ecole['ecole']);
										echo $libecole=$lib['lib_ecole']; 
									?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="63" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r17_c5" src="../fiche/images_old/fiche_r17_c5.jpg" width="409" height="7" border="0" id="fiche_r17_c5" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="7" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="24" colspan="2"><img name="fiche_r18_c1" src="../fiche/images_old/fiche_r18_c1.jpg" width="132" height="506" border="0" id="fiche_r18_c1" alt="" /></td>
							   <td colspan="10" rowspan="2" align="center" valign="middle" background="../fiche/images_old/fiche_r18_c3.jpg"><?php echo $inscription[0]['filiere']; ?></td>
							   <td colspan="7" align="center" valign="middle"><img name="fiche_r18_c13" src="../fiche/images_old/fiche_r18_c13.jpg" width="275" height="1" border="0" id="fiche_r18_c13" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="1" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="4" rowspan="4" align="center" valign="middle"><img name="fiche_r19_c13" src="../fiche/images_old/fiche_r19_c13.jpg" width="63" height="43" border="0" id="fiche_r19_c13" alt="" /></td>
							   <td colspan="3" rowspan="2" align="center" valign="middle" background="../fiche/images_old/fiche_r19_c17.jpg"><?php echo $inscription[0]['statut']; ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="26" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="10" rowspan="2" align="center" valign="middle"><img name="fiche_r20_c3" src="../fiche/images_old/fiche_r20_c3.jpg" width="210" height="15" border="0" id="fiche_r20_c3" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="1" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="3" rowspan="2" align="center" valign="middle"><img name="fiche_r21_c17" src="../fiche/images_old/fiche_r21_c17.jpg" width="212" height="16" border="0" id="fiche_r21_c17" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="14" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="4" rowspan="2" align="center" valign="middle" background="../fiche/images_old/fiche_r22_c3.jpg"><?php echo $inscription[0]['FI']; ?></td>
							   <td colspan="6" align="center" valign="middle"><img name="fiche_r22_c7" src="../fiche/images_old/fiche_r22_c7.jpg" width="110" height="2" border="0" id="fiche_r22_c7" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="2" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="2" rowspan="7" align="center" valign="middle"><img name="fiche_r23_c7" src="../fiche/images_old/fiche_r23_c7.jpg" width="50" height="225" border="0" id="fiche_r23_c7" alt="" /></td>
							   <td colspan="6" rowspan="2" align="center" valign="middle" background="../fiche/images_old/fiche_r23_c9.jpg"><?php echo $inscription[0]['FF']; ?></td>
							   <td colspan="2" rowspan="3" align="center" valign="middle"><img name="fiche_r23_c15" src="../fiche/images_old/fiche_r23_c15.jpg" width="23" height="103" border="0" id="fiche_r23_c15" alt="" /></td>
							   <td colspan="3" rowspan="2" align="center" valign="middle" background="../fiche/images_old/fiche_r23_c17.jpg"><?php echo $inscription[0]['FF']+ $inscription[0]['FI']; ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="25" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="4" rowspan="6" align="center" valign="middle"><img name="fiche_r24_c3" src="../fiche/images_old/fiche_r24_c3.jpg" width="100" height="200" border="0" id="fiche_r24_c3" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="2" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="6" align="center" valign="middle"><img name="fiche_r25_c9" src="../fiche/images_old/fiche_r25_c9.jpg" width="100" height="76" border="0" id="fiche_r25_c9" alt="" /></td>
							   <td colspan="3"><img name="fiche_r25_c17" src="../fiche/images_old/fiche_r25_c17.jpg" width="212" height="76" border="0" id="fiche_r25_c17" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="76" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="4" align="center" valign="middle"><img name="fiche_r26_c9" src="../fiche/images_old/fiche_r26_c9.jpg" width="29" height="122" border="0" id="fiche_r26_c9" alt="" /></td>
							   <td colspan="8" align="center" valign="middle" background="../fiche/images_old/fiche_r26_c10.jpg"><?php echo $_GET['an_etude']; ?></td>
							   <td rowspan="4" colspan="2"><img name="fiche_r26_c18" src="../fiche/images_old/fiche_r26_c18.jpg" width="11" height="122" border="0" id="fiche_r26_c18" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="36" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="8" align="center" valign="middle"><img name="fiche_r27_c10" src="../fiche/images_old/fiche_r27_c10.jpg" width="295" height="4" border="0" id="fiche_r27_c10" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="4" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="8" align="center" valign="middle" background="../fiche/images_old/fiche_r28_c10.jpg"><?php echo $inscription[0]['num_inscription']; ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="36" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="8" align="center" valign="middle"><img name="fiche_r29_c10" src="../fiche/images_old/fiche_r29_c10.jpg" width="295" height="46" border="0" id="fiche_r29_c10" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="46" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="12"><img name="fiche_r30_c3" src="../fiche/images_old/fiche_r30_c3.jpg" width="70" height="237" border="0" id="fiche_r30_c3" alt="" /></td>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r30_c4.jpg"><?php echo $inscription[0]['matricule']; ?></td>
							   <td rowspan="19"><img name="fiche_r30_c19" src="../fiche/images_old/fiche_r30_c19.jpg" width="6" height="326" border="0" id="fiche_r30_c19" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r31_c4" src="../fiche/images_old/fiche_r31_c4.jpg" width="409" height="5" border="0" id="fiche_r31_c4" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="5" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r32_c4.jpg"><?php echo utf8_encode($etudiant['nom']); ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r33_c4" src="../fiche/images_old/fiche_r33_c4.jpg" width="409" height="6" border="0" id="fiche_r33_c4" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="6" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r34_c4.jpg"><?php echo utf8_encode($etudiant['prenoms']); ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r35_c4" src="../fiche/images_old/fiche_r35_c4.jpg" width="409" height="5" border="0" id="fiche_r35_c4" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="5" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r36_c4.jpg"><?php echo $etudiant['date_naissance']; ?> / <?php echo utf8_encode($etudiant['lieu_naissance']); ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r37_c4" src="../fiche/images_old/fiche_r37_c4.jpg" width="409" height="7" border="0" id="fiche_r37_c4" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="7" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r38_c4.jpg"><?php 
									  $nation=selTableDataWhere("pays","cod_pays",$etudiant['Nationalite']);
									  echo utf8_encode($nation['lib_nation']); ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="27" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle"><img name="fiche_r39_c4" src="../fiche/images_old/fiche_r39_c4.jpg" width="409" height="9" border="0" id="fiche_r39_c4" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="9" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15" align="center" valign="middle" background="../fiche/images_old/fiche_r40_c4.jpg"><?php 	
										$ecole=selTableDataWhere("filiere","code",$inscription[0]['filiere']);
										$lib=selTableDataWhere("ecole_ufr","code_ecole",$ecole['ecole']);
										echo $libecole=$lib['lib_ecole']; 
									?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="63" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="15"><img name="fiche_r41_c4" src="../fiche/images_old/fiche_r41_c4.jpg" width="409" height="7" border="0" id="fiche_r41_c4" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="7" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td rowspan="7"><img name="fiche_r42_c1" src="../fiche/images_old/fiche_r42_c1.jpg" width="126" height="89" border="0" id="fiche_r42_c1" alt="" /></td>
							   <td colspan="10" rowspan="2" align="center" valign="middle" background="../fiche/images_old/fiche_r42_c2.jpg"><?php echo $inscription[0]['filiere']; ?></td>
							   <td colspan="7" align="center" valign="middle"><img name="fiche_r42_c12" src="../fiche/images_old/fiche_r42_c12.jpg" width="275" height="1" border="0" id="fiche_r42_c12" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="1" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="4" rowspan="4" align="center" valign="middle"><img name="fiche_r43_c12" src="../fiche/images_old/fiche_r43_c12.jpg" width="63" height="43" border="0" id="fiche_r43_c12" alt="" /></td>
							   <td colspan="3" rowspan="2" align="center" valign="middle" background="../fiche/images_old/fiche_r43_c16.jpg"><?php echo $inscription[0]['statut']; ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="26" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="10" rowspan="2" align="center" valign="middle"><img name="fiche_r44_c2" src="../fiche/images_old/fiche_r44_c2.jpg" width="210" height="15" border="0" id="fiche_r44_c2" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="1" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="3" rowspan="2" align="center" valign="middle"><img name="fiche_r45_c16" src="../fiche/images_old/fiche_r45_c16.jpg" width="212" height="16" border="0" id="fiche_r45_c16" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="14" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="4" rowspan="2" align="center" valign="middle" background="../fiche/images_old/fiche_r46_c2.jpg"><?php echo $inscription[0]['FI']; ?></td>
							   <td colspan="6" align="center" valign="middle"><img name="fiche_r46_c6" src="../fiche/images_old/fiche_r46_c6.jpg" width="110" height="2" border="0" id="fiche_r46_c6" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="2" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="2" rowspan="2" align="center" valign="middle"><img name="fiche_r47_c6" src="../fiche/images_old/fiche_r47_c6.jpg" width="50" height="45" border="0" id="fiche_r47_c6" alt="" /></td>
							   <td colspan="6" align="center" valign="middle" ../fiche/images_old/fiche_r47_c8.jpg><?php echo $inscription[0]['FF']; ?></td>
							   <td colspan="2" rowspan="2" align="center" valign="middle"><img name="fiche_r47_c14" src="../fiche/images_old/fiche_r47_c14.jpg" width="23" height="45" border="0" id="fiche_r47_c14" alt="" /></td>
							   <td colspan="3" align="center" valign="middle" background="../fiche/images_old/fiche_r47_c16.jpg"><?php echo $inscription[0]['FF']+ $inscription[0]['FI']; ?></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="26" border="0" alt="" /></td>
							  </tr>
							  <tr>
							   <td colspan="4"><img name="fiche_r48_c2" src="../fiche/images_old/fiche_r48_c2.jpg" width="100" height="19" border="0" id="fiche_r48_c2" alt="" /></td>
							   <td colspan="6"><img name="fiche_r48_c8" src="../fiche/images_old/fiche_r48_c8.jpg" width="100" height="19" border="0" id="fiche_r48_c8" alt="" /></td>
							   <td colspan="3"><img name="fiche_r48_c16" src="../fiche/images_old/fiche_r48_c16.jpg" width="212" height="19" border="0" id="fiche_r48_c16" alt="" /></td>
							   <td><img src="../fiche/images_old/spacer.gif" width="1" height="19" border="0" alt="" /></td>
							  </tr>
							</table>
					<?php
							}
					}
					}else{
					?>
					<p class="panel-title" align="center">IMPRESSION D'UNE FICHE DE PREINSCRIPTION</p><br /><br />
					<form action="" method="POST">
					<table width="98%" border="0" align="center" cellpadding="0" cellspacing="2">
					  <tr>
						<td width="10%" align="right" bgcolor="#FFFF99">Matricule :  </td>
						<td width="15%" bgcolor="#FFFF99">
						<input name='matricule' class="form-control" placeholder="Entre le matricule" size='30' value="<?php if(isset($_POST['matricule'])){ echo $_POST['matricule']; } ?>" onkeyup="efface('num_table');" />
						</td>
						<td width="23%" align="right" bgcolor="#FFFF99">ou Numéro de table :  </td>
						<td width="13%" bgcolor="#FFFF99">
						<input name='num_table' class="form-control" placeholder="Entre le Num de table" size='30' value="<?php if(isset($_POST['matricule'])){ echo $_POST['num_table']; } ?>" onkeyup="efface('num_table');" onkeyup="efface('matricule');"/>
						</td>
						<td width="15%" align="right" bgcolor="#FFFF99">Annee Academique :</td>
						<td width="16%" bgcolor="#FFFF99"> 
						<select class="form-control" required="true" name="annee" id="annee">
						  <?php
								$ufr=selTableDataDesc("annee_academique","lib_annee");
									for($i=0;$i<count($ufr);$i++){
										echo "<option value='".$ufr[$i]['lib_annee']."'>".strtoupper($ufr[$i]['lib_annee'])."</option>";
									}	
								?>
						</select>
						</td>
						<td width="11%" bgcolor="#FFFF99">
						<button class="btn btn-primary" name="controler" type="submit"> controler</button></td>
						</tr>
					</table>
					</form><br />
					<?php
					}
					if(isset($_POST['matricule'])){
						$inscription=selTableData2Fields("inscription","matricule",$_POST['matricule'],"annee_academique",$_POST['annee']);
						//print_r($inscription);
						if(count($inscription)>0){
							if($_POST['matricule']!=""){
								echo "<p align='center'><a href='page/fiche.php?num_table=&matricule=".$_POST['matricule']."&an_etude=".$_POST['annee']."' target='_blank'><img src='../img/fiche.png'><br/>Imprimez votre fiche de préinscription</a><br/>";
							}else{
								echo "<p align='center'><a href='page/fiche.php?matricule=&num_table=".$_POST['num_table']."&an_etude=".$_POST['annee']."'  target='_blank'><img src='../img/fiche.png'><br>Imprimez votre fiche de préinscription</a><br/>";	
							}		
						}else{
							echo "<p align='center' class='totat'>PAS D'INSCRIPTION</p>";
						}
					}
					?>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</div>