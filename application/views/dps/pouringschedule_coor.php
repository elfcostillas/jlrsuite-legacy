
	<!-- COORDINATOR SCHEDULER TABLE-->
	<div id="coordinator-scheduler-table">
		
		<form method="POST" action="coor_approved_schedule" autocomplete="off">
			<input type="hidden" name="selectcounter" id="selectcounter" value="0" />

			<div class="approvedbut-wrapper">
				<input type="submit" name="scheduler-approved-submit" class="scheduler-approved-submit" value="Approved">
			</div>
			<br />

			<table id="mytable" class="scheduler-table">

				<tr id="heading">
					<th width="220">CUSTOMER NAME / PROJECT / LOCATION</th>
					<th >OTHERS<br />(<a href="#" class="toggleothers">all</a>)</th>
					<th >PSI</th>
					<th >AGG</th>
					<th >CURING</th>
					<th >SLUMP</th>
					<th >POURING</th>
					<th >STRUCTURE</th>
					<th >VIBRATOR/<br/>SAMPLER</th>
					<th >REMARKS</th>
					<th >VOLUME</th>
					<th width="50">DATE</th>
					<th width="50">TIME</th>
					<th >STATUS</th>
					<th >FORM #</th>
					<th >ACTION</th>

				</tr>


				<?php

						$rows = $result->num_rows();
						$i = 0;
						$ctr = 1;

						
						while ( $i < $rows) {
				
							$row = $result->row($i);
							
							$id = $row->o202_id;

							$project_id = $row->project_id;
							$client_id = $row->client_id;

							$cust_name = $row->cust_name;
							$project_name = $row->proj_name;
							$project_loc = $row->proj_address;

							$str = $row->book_psi;
							$agg_design = $row->book_msa;
							$curing = $row->book_cd;
							$slump_design = $row->book_sp;
							$pouring = $row->pour_type;
							$structure_design = $row->structure;
							$remarks = $row->remarks;
							$estvolume = $row->batch_vol;
							
							$sched_date = $row->sched_date;
							$sched_time = $row->sched_time;

							$modified_date = $row->modified_date;
							$modified_time = $row->modified_time;

							$coor_status = $row->coor_status;
							$smd_status = $row->smd_status;

							$design_status = $row->design_status;

							$form_num = $row->form_no;

							$acctg_remarks = $row->acctg_remarks;
							$service_engr = $row->service_engr;

							$qa_rep = $row->act_vib_qc;
							$f_code1 = $row->f_code1;
							$f_code2 = $row->f_code2;
							$qc_remarks = $row->qc_remarks;


							//get the other remarks
							$add_pipes = $row->add_pipes;
							$add_vibrator = $row->add_vibrator;
							$add_slumpcone = $row->add_slumpcone;
							$add_beam = $row->add_beam;
							$add_others = $row->add_others;

							$act_vib = $row->act_vib_use;
							$act_vib_qc = $row->act_vib_qc;
							$vibrator_no = $row->vibrator_no;
							$pumpcharge_no = $row->pumpcharge_no;

							$plant = $row->batching_plant;
							$batchingplant = $row->batching_plant;
							//added by ralph april 21, 2015 for prority number
							$priority_no = $row->priority_no;

							$po_no = $row->po_no;
							

							if($coor_status == 'Approved'){
								echo "<tr rowspan='2' class='items scheduler-trow scheduler' id='$id' style='background-color:#99CB5C'>";
							}
							else{
								echo "<tr rowspan='2' class='items scheduler' id='$id'>";
							}	
				?>
					
								<td align="left" id="left-item" class="scheduler-left-item">	
									<?php
										if($plant == 'Plant 4'){
											echo "<div class='plant-color'></div>";
										}
									?>

									<!-- check the status of the schedule -->
									<?php
										$coor_cust_cls = '';
										if($acctg_remarks = ''){
											$coor_cust_cls = "blink-cust-coor cust-coor-acctg";
										}

										if($plant = '' AND $service_engr = ''){
											$coor_cust_cls = "blink-cust-coor cust-coor-plant";
										}

										if(($f_code1 = '' OR $f_code2 = '') AND $qa_rep = '' AND $qc_remarks = ''){
											$coor_cust_cls = "blink-cust-coor cust-coor-qa";
										}
									?>

									<p id="customer" class="coor-cust schedulerp <?php echo $coor_cust_cls ?>">
										<span class="prio-no"><?php echo $priority_no; ?></span>
										
										<?php echo $this->functionlist->convertNtilde(strtoupper($cust_name)) ?>
									
									</p>
									<!-- edited  by wbsolon -->
									<p class="schedulerp">
										<!-- <input type="input" name="proj_name" class="proj_name" id="<?php echo $id ?>" value="<?php echo $this->functionlist->convertNtilde(strtoupper($project_name)) ?>" style="width:180px;" readonly/>   -->
										<span name="proj_name" class="proj_name" id="<?php echo $id ?>" style="width:180px;color:blue;"><?php echo $this->functionlist->convertNtilde(strtoupper($project_name)) ?></span>  
									</p>	
									<p class="schedulerp">
										<!-- <input type="input" name="proj_address" class="proj_address" id="<?php echo $id ?>" value="<?php echo $this->functionlist->convertNtilde(strtoupper($project_loc)) ?>" style="width:180px;" readonly /> -->
										<span name="proj_address" class="proj_address" id="<?php echo $id ?>" style="width:180px;color:black;"><?php echo $this->functionlist->convertNtilde(strtoupper($project_loc))?></span>
									</p>	
								</td>	


								<td>
									<center><a href="#" class="coor-others-but" id="<?php echo $id ?>" value="hide">Hide</a></center>
									
									<div class="coorotheredit-wrapper" id="<?php echo $id ?>">
										<div class="coor-other-edit">
											<label class="others-label">PIPES</label>
											<input type="text" name="pipes" class="others add-pipes" id="<?php echo $id ?>" value="<?php echo $add_pipes ?>" />

											<label class="others-label">VIBRATOR</label>
											<input type="text" name="vibrator" class="others add-vibrator" id="<?php echo $id ?>" value="<?php echo $add_vibrator ?>" />

											<label class="others-label">SLUMP CONE</label>
											<input type="text" name="slumpcone" class="others add-slumpcone" id="<?php echo $id ?>" value="<?php echo $add_slumpcone ?>" />

											<label class="others-label">BEAM MOLDS</label>
											<input type="text" name="beam" class="others add-beam" id="<?php echo $id ?>" value="<?php echo $add_beam ?>" />

											<label class="others-label">OTHER REMARKS</label>
											<input type="text" name="others" class="others1 add-others" id="<?php echo $id ?>" value="<?php echo $add_others ?>" />
										
											<!-- added by ralph june 4, 2015 -->
											<label class="others-label">VIBRATOR NO.</label>
											<input type="text" name="vibrator-no" class="others vibrator-no" id="<?php echo $id ?>" value="<?php echo $vibrator_no ?>" />

											<label class="others-label">PUMP CHARGE NO.</label>
											<input type="text" name="pumpcharge-no" class="others pumpcharge-no" id="<?php echo $id ?>" value="<?php echo $pumpcharge_no ?>" />
										</div>
									</div>
								
								</td>
								<!-- edited  by wbsolon disabled=true-->
								<td align="center" >
									<!-- <select name="str" class="str" id="<?php echo $id?>" disabled=true>
										<?php				
								            foreach($strength as $des_strength){
								            	$strength_value = $des_strength['strength'] . " " . $des_strength['type'];
								            	if($str == $des_strength['code']){
								            		echo '<option value="' . $des_strength['code'] . '" selected="true">' . $strength_value .'</option>';
								            	}else{
								            		echo '<option value="' . $des_strength['code'] . '">' . $strength_value .'</option>';
								            	}
								                
								            }
							            ?>
									</select> -->
									<span name="str" class="str" id="<?php echo $id?>"><?php echo $str?></span>
									<input type="hidden" class="tmp-str" id="<?php echo $id?>" value="<?php echo $str ?>">
								</td>

								<!-- edited  by wbsolon disabled=true-->
								<td align="center">
									<!-- <select name="agg" class="agg" id="<?php echo $id?>" disabled=true>
										<?php				
								            foreach($agg as $des_agg){
								            	$agg_value = $des_agg['code'];
								            	if($agg_design == $agg_value){
								            		echo '<option value="' . $agg_value . '" selected="true">' . $agg_value .'</option>';
								            	}else{
								            		echo '<option value="' . $agg_value . '">' . $agg_value .'</option>';
								            	}
								                
								            }
							            ?>
									</select> -->
									<span name="agg" class="agg" id="<?php echo $id?>"><?php echo $agg_design?></span>
									<input type="hidden" class="tmp-agg" id="<?php echo $id?>" value="<?php echo $agg_design ?>">
								</td>

								<!-- edited  by wbsolon disabled=true-->
								<td align="center">
									<!-- <select name="curing" class="curing" id="<?php echo $id?>" disabled=true>
										
										<?php
											switch ($curing) {
												case '15H':
													echo "<OPTION value='15H' selected='true'>15 hours</OPTION>";
													echo "<OPTION value='1D'>1 day</OPTION>";
													echo "<OPTION value='3D'>3 days</OPTION>";
													echo "<OPTION value='5D'>5 days</OPTION>";
													echo "<OPTION value='7D'>7 days</OPTION>";
													echo "<OPTION value='14D'>14 days</OPTION>";
													echo "<OPTION value='28D'>28 days</OPTION>";
													break;

												case '1D':
													echo "<OPTION value='15H'>15 hours</OPTION>";
													echo "<OPTION value='1D' selected='true'>1 day</OPTION>";
													echo "<OPTION value='3D'>3 days</OPTION>";
													echo "<OPTION value='5D'>5 days</OPTION>";
													echo "<OPTION value='7D'>7 days</OPTION>";
													echo "<OPTION value='14D'>14 days</OPTION>";
													echo "<OPTION value='28D'>28 days</OPTION>";
													break;

												case '3D':
													echo "<OPTION value='15H'>15 hours</OPTION>";
													echo "<OPTION value='1D'>1 day</OPTION>";
													echo "<OPTION value='3D' selected='true'>3 days</OPTION>";
													echo "<OPTION value='5D'>5 days</OPTION>";
													echo "<OPTION value='7D'>7 days</OPTION>";
													echo "<OPTION value='14D'>14 days</OPTION>";
													echo "<OPTION value='28D'>28 days</OPTION>";
													break;

												case '5D':
													echo "<OPTION value='15H'>15 hours</OPTION>";
													echo "<OPTION value='1D'>1 day</OPTION>";
													echo "<OPTION value='3D'>3 days</OPTION>";
													echo "<OPTION value='5D' selected='true'>5 days</OPTION>";
													echo "<OPTION value='7D' >7 days</OPTION>";
													echo "<OPTION value='14D'>14 days</OPTION>";
													echo "<OPTION value='28D'>28 days</OPTION>";
													break;
												
												case '7D':
													echo "<OPTION value='15H'>15 hours</OPTION>";
													echo "<OPTION value='1D'>1 day</OPTION>";
													echo "<OPTION value='3D'>3 days</OPTION>";
													echo "<OPTION value='5D'>5 days</OPTION>";
													echo "<OPTION value='7D' selected='true'>7 days</OPTION>";
													echo "<OPTION value='14D'>14 days</OPTION>";
													echo "<OPTION value='28D'>28 days</OPTION>";
													break;

												case '14D':
													echo "<OPTION value='15H'>15 hours</OPTION>";
													echo "<OPTION value='1D'>1 day</OPTION>";
													echo "<OPTION value='3D'>3 days</OPTION>";
													echo "<OPTION value='5D'>5 days</OPTION>";
													echo "<OPTION value='7D'>7 days</OPTION>";
													echo "<OPTION value='14D' selected='true'>14 days</OPTION>";
													echo "<OPTION value='28D'>28 days</OPTION>";
													break;

												case '28D':
													echo "<OPTION value='15H'>15 hours</OPTION>";
													echo "<OPTION value='1D'>1 day</OPTION>";
													echo "<OPTION value='3D'>3 days</OPTION>";
													echo "<OPTION value='5D'>5 days</OPTION>";
													echo "<OPTION value='7D'>7 days</OPTION>";
													echo "<OPTION value='14D'>14 days</OPTION>";
													echo "<OPTION value='28D' selected='true'>28 days</OPTION>";
													break;
											}
										?>
									</select> -->
									<span name="curing" class="curing" id="<?php echo $id?>"><?php echo $curing?></span>
									<input type="hidden" class="tmp-curing" id="<?php echo $id?>" value="<?php echo $curing ?>">
								</td>
								
								<!-- edited  by wbsolon disabled=true-->
								<td align="center">
									
									<!-- <select name="slump" class="slump" id="<?php echo $id?>" disabled=true>
										
										<?php				
								            foreach($slump as $des_slump){
								            	if($slump_design == $des_slump['code']){
								            		echo '<option value="' . $des_slump['code'] . '" selected="true">' . $des_slump['slump'] .'</option>';
								            	}else{
								            		echo '<option value="' . $des_slump['code'] . '">' . $des_slump['slump'] .'</option>';
								            	}
								                
								            }
							            ?>
									</select> -->
									<span name="slump" class="slump" id="<?php echo $id?>"><?php echo $slump_design?></span>
									<input type="hidden" class="tmp-slump" id="<?php echo $id?>" value="<?php echo $slump_design ?>">
								</td>

								<td align="center">
									<select name="pouring" class="pouring" id="<?php echo $id?>" style="width:100px;">
										
										<?php				
								            foreach($pouringtype as $des_pouringtype){
								            	
								            	if($pouring == $des_pouringtype['Type']){
								            		echo '<option value="' . $des_pouringtype['Type'] . '" selected="true">' . $des_pouringtype['Type'] .'</option>';
								            	}else{
								            		echo '<option value="' . $des_pouringtype['Type'] . '">' . $des_pouringtype['Type'] .'</option>';
								            	}
								                
								            }
							            ?>
									</select>
								</td>

								<td align="center">
									
									<!--<select name="structure" class="structure" id="<?php //echo $id?>" style="width:100px;">
										
										<?php				
								            //foreach($structure as $des_structure){
								            	
								            //	if($structure_design == $des_structure['struct_name']){
								            //		echo '<option value="' . $des_structure['struct_name'] . '" selected="true">' . $des_structure['struct_name'] .'</option>';
								            //	}else{
								            //		echo '<option value="' . $des_structure['struct_name'] . '">' . $des_structure['struct_name'] .'</option>';
								            //	}	
								                
								            //}
							            ?>
									</select>-->
									<input type="text" name="structure" class="structure" style="width:100px; text-transform:uppercase;" id="<?php echo $id ?>" title="<?php echo $structure_design?>" value="<?php echo $structure_design?>"/>
								</td>
								<td align="center"> 
									<select name="act_vib" class="activeVibrator" id="<?php echo $id?>">
										<?php 
											switch ($act_vib) {
												case 'WVU':
													echo "<OPTION value='N/A'>N/A</OPTION>";
													echo "<OPTION value='WVU' selected='true'>With Vibrator Used</OPTION>";
													echo "<OPTION value='WVN'>With Vibrator Not Used</OPTION>";
													break;

												case 'WVN':
													echo "<OPTION value='N/A'>N/A</OPTION>";
													echo "<OPTION value='WVU'>With Vibrator Used</OPTION>";
													echo "<OPTION value='WVN' selected='true'>With Vibrator Not Used</OPTION>";
													break;

												default:
													echo "<OPTION value='N/A' selected='true'>N/A</OPTION>";
													echo "<OPTION value='WVU'>With Vibrator Used</OPTION>";
													echo "<OPTION value='WVN'>With Vibrator Not Used</OPTION>";
													break;

											}
										?>
										</option>
									</select><br/>
									<select autocomplete="off" name="qa_rep" class="qa_repv" id="<?php echo $id ?>">
									<option value="NONE">None</option>
									<?php
									
										foreach($qareps as $qareps_list){
												$qa_reps = $qareps_list->code;
												if ($qa_rep == $qa_reps){
													echo '<option selected="true" value="' . $qa_reps . '">' . $qa_reps .'</option>';
												}else{
													echo '<option value="' . $qa_reps . '">' . $qa_reps .'</option>';
												}
										}			
									?>
								</select>&emsp;&emsp;
								<a href="#" class="update-act-vib" value="link<?php echo $ctr ?>" id="update-act-vib<?php echo $ctr ?>" ><img src="<?php echo base_url("css/images/update.png") ?>" title="Update Vibrator Status"/></a>
								</td>
								<td align="center">
									<select name="remarks" class="remarks" id="<?php echo $id?>">
										<?php 
											switch ($remarks) {
												case 'COS':
													echo "<OPTION value='N/A'>N/A</OPTION>";
													echo "<OPTION value='COS' selected='true'>COS</OPTION>";
													echo "<OPTION value='POS'>POS</OPTION>";
													echo "<OPTION value='FC'>FC</OPTION>";
													echo "<OPTION value='BT'>BT</OPTION>";
													echo "<OPTION value='PD'>PD</OPTION>";
													break;

												case 'POS':
													echo "<OPTION value='N/A'>N/A</OPTION>";
													echo "<OPTION value='COS'>COS</OPTION>";
													echo "<OPTION value='POS' selected='true' >POS</OPTION>";
													echo "<OPTION value='FC'>FC</OPTION>";
													echo "<OPTION value='BT'>BT</OPTION>";
													echo "<OPTION value='PD'>PD</OPTION>";
													break;
												
												case 'FC':
													echo "<OPTION value='N/A'>N/A</OPTION>";
													echo "<OPTION value='COS'>COS</OPTION>";
													echo "<OPTION value='POS'>POS</OPTION>";
													echo "<OPTION value='FC' selected='true' >FC</OPTION>";
													echo "<OPTION value='BT'>BT</OPTION>";
													echo "<OPTION value='PD'>PD</OPTION>";
													break;

												case 'BT':
													echo "<OPTION value='N/A'>N/A</OPTION>";
													echo "<OPTION value='COS'>COS</OPTION>";
													echo "<OPTION value='POS'>POS</OPTION>";
													echo "<OPTION value='FC'>FC</OPTION>";
													echo "<OPTION value='BT' selected='true'>BT</OPTION>";
													echo "<OPTION value='PD'>PD</OPTION>";
													break;

												case 'PD':
													echo "<OPTION value='N/A'>N/A</OPTION>";
													echo "<OPTION value='COS'>COS</OPTION>";
													echo "<OPTION value='POS'>POS</OPTION>";
													echo "<OPTION value='FC'>FC</OPTION>";
													echo "<OPTION value='BT'>BT</OPTION>";
													echo "<OPTION value='PD' selected='true' >PD</OPTION>";
													break;

												default:
													echo "<OPTION value='N/A' selected='true' >N/A</OPTION>";
													echo "<OPTION value='COS'>COS</OPTION>";
													echo "<OPTION value='POS'>POS</OPTION>";
													echo "<OPTION value='FC'>FC</OPTION>";
													echo "<OPTION value='BT'>BT</OPTION>";
													echo "<OPTION value='PD'>PD</OPTION>";
													break;

											}
										?>
										</option>
									</select>
								</td>

								<td align="center">
									<!-- <input name="estvolume" class="estvolume" id="<?php echo $id ?>" value="<?php echo $estvolume ?>" style="width:40px;"/> -->
									<span name="estvolume" class="estvolume" id="<?php echo $id ?>" style="width:40px;font-size: 12px;color:blue;">
										<?php echo $estvolume ?>
									</span>
								</td>

								<td align='center' width="70" >
									<p id='orig-date'><?php echo $sched_date ?></p>
									<input type='hidden' disabled="true" class='sched-datetime-tmp' id='scheddate-tmp<?php echo $id ?>' value='<?php echo $modified_date ?>' name='scheddate-tmp'/>
									<!-- edited  by wbsolon disabled=true-->
									<input type='text' class='sched-datetime-input' id='sched-datetime-input<?php echo $id ?>' value='<?php echo $modified_date ?>' name='sched-datetime-input' disabled=true/>
								</td>

								<td align='center' width="50">
									
									<p id='orig-date' value="<?php echo $modified_time ?>"><?php echo $sched_time ?></p>

									<select class='sched-time-updater' name='sched-time-input<?php echo $ctr ?>' id='sched-time-input<?php echo $ctr ?>'>
										<?php
											foreach($timerap as $time_list){
													$time = $time_list;
													if ($modified_time == $time){
														echo '<option selected="true" value="' . $time . '"><center>' . $time .'</center></option>';
													}else{
														echo '<option value="' . $time . '"><center>' . $time .'</center></option>';
													}
													
											}
										?>
									</select>
								</td>
									

								<td align='center' id='toy'>
									<input type="hidden" name="tmp-status" id="tmp-status" class="cls-tmp-status" value="<?php echo $design_status ?>">
									<select name="designstatus<?php echo $ctr ?>" id="designstatus<?php echo $ctr ?>" class="sched-designstatus-update validate[required]" style="width:70px;">
										<?php
										foreach($designstatus as $designstatus_list){
												$des_status = $designstatus_list;
												if ($design_status == $des_status){
													echo '<option selected="true" value="' . $des_status . '">' . $des_status .'</option>';
												}else{
													echo '<option value="' . $des_status . '">' . $des_status .'</option>';
												}
										}
									?>
									</select>
								</td>

								<td align="center"><?php echo $form_num ?></td>
								
								<td align="center" id="left">
									<input type="hidden" name="schedpage" id="schedpage" value="<?php echo $whatday ?>"/>
									<input type="hidden" name="schedplant" id="schedplant" value="<?php echo $batchingplant ?>"/>
									<input type="hidden" name="scheduler-smdstatus" id="scheduler-smdstatus" value="<?php echo $smd_status ?>"/>
									<a href="#" class="update-scheddate" value="link<?php echo $ctr ?>" id="update-scheddate<?php echo $ctr ?>" ><img src="<?php echo base_url("css/images/update.png") ?>" title="Update Date and Time"/></a>
									&nbsp&nbsp
									<!-- Checkbox value is the scheduled item id-->
									<?php
										if($coor_status == 'Approved' OR $design_status == 'Cancelled'){
											echo "<input type='checkbox' name='selectedsched[]' id='selectedsched$ctr' class='sched-select-checkbox' value='$id' disabled='true'/>";
										}
										else{
											echo "<input type='checkbox' name='selectedsched[]' id='selectedsched$ctr' class='sched-select-checkbox' value='$id'/>";
										}
										?>
								</td>

								<!-- hidden fields for the projects -->
									<input type="hidden" name="projectname<?php echo $id?>" value="<?php echo $project_name ?>"/>
									<input type="hidden" name="po-no" class="po-no" id="<?php echo $id ?>" value="<?php echo $po_no ?>" />

								
							</tr>

								


					<?php
						$i ++;
						$ctr ++;
						}
					?>
							

					
				
			</table>

			<div class="approvedbut-wrapper">
				<input type="hidden" name="whatday" value="<?php echo $whatday ?>" />
				<input type="submit" name="scheduler-approved-submit" class="scheduler-approved-submit" value="Approved">
			</div>
		</form>
	</div>
	
	
