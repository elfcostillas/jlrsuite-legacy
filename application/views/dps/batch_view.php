		<!-- COORDINATOR SCHEDULER TABLE-->
		<div id="coordinator-scheduler-table">
			<form method="POST" action="batch_upload" autocomplete="off">
				<input type="hidden" name="selectcounter" id="selectcounter" value="0" />

				<div class="approvedupbut-wrapper">
					<input type="submit" name="upload-approved-submit" class="upload-approved-submit" value="Upload" title="upload?">
				</div>
				<br />
				<table id="mytable" class="scheduler-table">
									<tr id="heading">
						<th width="220" height="25">CUSTOMER NAME / PROJECT / LOCATION <br> </th>
						<!--<th >PO #</th>-->
						<th >PSI</th>
						<th >AGG</th>
						<th >CURING</th>
						<th >SLUMP</th>
						<th >FORMULA</th>
						<th >POURING</th>
						<th >STRUCTURE</th>
						<th >REMARKS</th>
						<th >EST VOLUME</th>
						<th width="50">DATE</th>
						<th width="50">TIME</th>
						<th >FORM #</th>
						<th >STATUS</th>
						<th >ACTION</th>

					</tr>

					<?php

						$rows = $result->num_rows();
						$i = 0;
						$ctr = 0;


						while ( $i < $rows) {
				
							$row = $result->row($i);
							

							
							$id = $row->o202_id;
							$project_id = $row->project_id;
							$client_id = $row->client_id;

							$cust_name = $row->cust_name;
							$project_name = $row->proj_name;
							$project_loc = $row->proj_address;

							$str = $row->book_psi;
							$agg = $row->book_msa;
							$curing = $row->book_cd;
							$slump = $row->book_sp;
							$formula = $row->f_code1;
							$pouring = $row->pour_type;
							$structure = $row->structure;
							$remarks = $row->remarks;
							$estvolume = $row->batch_vol;
							
							$sched_date = $row->sched_date;
							$sched_time = $row->sched_time;

							$modified_date = $row->modified_date;
							$modified_time = $row->modified_time;

							$coor_status = $row->coor_status;
							$smd_status = $row->smd_status;

							$form_num = $row->form_no;

							$plant = $row->batching_plant;

							$design_status = $row->design_status;

							//$po = $row->po_no;
							$contract = $row->contract_no;
							$plant_cast = $row->plant_cast;
							$plant_upload = $row->plant_upload;



							if($plant_upload == 'F'){
								echo "<tr class='items scheduler-trow scheduler' id='$id' style='background-color:#fff2f2'>";
							}elseif ($plant_upload == 'D'){echo "<tr class='items scheduler-trow scheduler' id='$id' style='background-color:#99CB5C'>";}
							else{
								echo "<tr class='items scheduler-trow scheduler' id='$id'>";
							}
						
						
					?>


					

						<td align="left" id="left-item" class="scheduler-left-item">
							<?php
								if($plant == 'Plant 4'){
									echo "<div class='plant-color-upload'></div>";
								}
							?>
													
							<p class="bschedulerp" id="bcust-item">
							<?php echo $this->functionlist->convertNtilde(strtoupper($cust_name)) ?>
							</p>
							<p class="bschedulerp"><?php echo $this->functionlist->convertNtilde(strtoupper($project_name)) ?></p>	
							<p class="bschedulerp"><?php echo $this->functionlist->convertNtilde(strtoupper($project_loc)) ?></p>

	
						<td align="center"><?php echo $str ?></td>
						<td align="center"><?php echo $agg ?></td>
						<td align="center"><?php echo $curing ?></td>
						<td align="center"><?php echo $slump ?></td>
						 <!-- <td align="center" style="font-size: 20px;"><?php //echo $formula ?></td> -->
						<td align="center" style="font-size:17px;color:#f00000;text-shadow: 1px 1px 2px green;">
						<?php 
							if($formula==''){
								 echo ' ';
							}else{
								echo $formula;
							}						
						?>
						</td>
						<td align="center"><?php echo $pouring ?></td>
						<td align="center"><?php echo $structure ?></td>
						<td align="center"><?php echo $remarks ?></td>
						<td align="center"><?php echo $estvolume ?></td>

						<td align='center' id='toy'>
							<p class="batch-orig-datetime" id="b-orig-dt"><?php echo $sched_date ?></p>
							
							<?php 
								if($modified_date <> null OR $modified_date <> $sched_date){
									echo "<p class='batch-mod-datetime' id='b-mod-dt'><strong>$modified_date</strong></p>";
								}
							?>
						</td>

						<td align='center' id='toy'>
							<p class="batch-orig-datetime" id="b-orig-dt1"><?php echo $sched_time ?></p>
							<?php 
								if($modified_time <> null OR $modified_time <> $sched_time){
									echo "<p class='batch-mod-datetime' id='b-mod-dt1' ><strong>$modified_time</strong></p>";
								}
							?>
							
						</td>

						<td align="center"  ><?php echo $form_num ?></td>
						
						<td align="center" id="stat<?php echo $ctr ?>"><?php 
							if($plant_upload == 'F'){	
								echo 'For Upload' ;
							}else if($plant_upload == 'D'){
								echo 'Uploaded' ;
							}

						?></td>

						<td align="center" id="left">
									<input type="hidden" name="schedpage" id="schedpage" value="<?php echo $whatday ?>"/>
									<!--<input type="hidden" name="schedplant" id="schedplant" value="<?php echo $batchingplant ?>"/>-->
									<input type="hidden" name="scheduler-smdstatus" id="scheduler-smdstatus" value="<?php echo $smd_status ?>"/>
									<a href="#"  value="link<?php echo $ctr ?>"  
										class =  "<?php if($plant_upload == 'D') { echo "update-upload";} else {echo "";} ?>" 
										id = "<?php echo $ctr ?>"> 
										<img id = "img<?php echo $ctr ?>" src= "<?php if($plant_upload == 'F') { echo base_url("css/images/upload.png");} else {echo base_url("css/images/update.png");} ?>" 
										title = "<?php if($plant_upload == 'F') { echo "Upload";} else {echo "Reset upload";}  ?>" />
									</a>
									&nbsp&nbsp
									<!-- Checkbox value is the scheduled item id-->
									<?php
										//if($coor_status == 'Approved' OR $design_status == 'Cancelled'){
										if($plant_upload == 'D' OR $design_status == 'Cancelled'){
											echo "<input type='checkbox' name='upselected[]' id='upselected$ctr' class='upload-select-checkbox' value='$id' disabled='true'/>" ;
										}
										else{
											echo "<input type='checkbox' name='upselected[]' id='upselected$ctr' class='upload-select-checkbox' value='$id' title='check for upload'/>" ;
										}
									?>
						</td>

							
						<!-- hidden fields for the projects -->
						<input type="hidden" name="projectname<?php echo $id?>" value="<?php echo $project_name ?>"/>
						<!-- hidden fields for the projects modified date -->
						<input type="hidden" name="sched-datetime-input" value="<?php echo $modified_date ?>"/>
						

					</tr>

					<?php
						$ctr++;
						$i++;
						}
					?>
				</table>

				
				<div class="approvedupbut-wrapper">
					<!--<input type="hidden" name="whatday" value="<?php// echo $whatday ?>" />-->
					<input type="submit" name="upload-approved-submit" class="upload-approved-submit" value="Upload" title="upload?">
				</div>
			</form>
		</div>

	