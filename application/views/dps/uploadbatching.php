		<!-- SMD ADMIN SCHEDULER TABLE-->
		<div id="coordinator-scheduler-table">
			<form method="POST" action="smd_approved_schedule" autocomplete="off">
				<input type="hidden" name="selectcounter" id="selectcounter" value="0" />

				<div class="approvedbut-wrapper">
					<input type="submit" name="scheduler-approved-submit" class="scheduler-approved-submit" value="Approved">
				</div>
				<br />
				<table id="mytable" class="scheduler-table">

					<tr id="heading">
						<th width="220">CUSTOMER NAME / PROJECT / LOCATION</th>
						<th >PO #</th>
						<th >PSI</th>
						<th >AGG</th>
						<th >CURING</th>
						<th >SLUMP</th>
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

							//get the other remarks
							$add_pipes = $row->add_pipes;
							$add_vibrator = $row->add_vibrator;
							$add_slumpcone = $row->add_slumpcone;
							$add_beam = $row->add_beam;
							$add_others = $row->add_others;

							$plant = $row->batching_plant;

							$design_status = $row->design_status;

							//added by ralph march 10, 2014
							//get the other remarks
							$add_pipes = $row->add_pipes;
							$add_vibrator = $row->add_vibrator;
							$add_slumpcone = $row->add_slumpcone;
							$add_beam = $row->add_beam;
							$add_others = $row->add_others;
							$qc_remarks = $row->qc_remarks;

							$po = $row->po_no;
							$contract = $row->contract_no;
							$plant_cast = $row->plant_cast;


							$other_remarks = '';
							

							if($add_others != 'NO'){
								$other_remarks = $add_others . ',' . $other_remarks;
							}

							if($po != '0'){
								$other_remarks = 'PO#' . $po . '<br />' . $other_remarks;
							}

							if($contract != '0'){
								$other_remarks = 'Contract#' . $contract . ',' . $other_remarks;
							}
							
							if($qc_remarks != 'None'){
								$other_remarks = $qc_remarks . ',' . $other_remarks;
							}

							if($plant_cast == 'YES'){
								//$plant_cast = 'echo ""';
								$other_remarks = '<span class="plantcast">Plant Cast</span>' . ',' . $other_remarks;
							}

							$other_remarks = trim($other_remarks,',');


							
							if($coor_status == 'Approved' AND $smd_status == 'Approved'){
								echo "<tr class='items scheduler-trow scheduler' id='$id' style='background-color:#99CB5C'>";
							}elseif($coor_status == 'Approved' AND ($smd_status == '' OR $smd_status == 'Unapproved') ){
								echo "<tr class='items scheduler-trow scheduler' id='$id' style='background-color:#bfd18c'>";
							}
							else{
								echo "<tr class='items scheduler-trow scheduler' id='$id'>";
							}
						


						

						
					?>


					

						<td align="left" id="left-item" class="scheduler-left-item">
							<?php
								if($plant == 'Plant 4'){
									echo "<div class='plant-color'></div>";
								}
							?>
							
								<p id="customer" class="schedulerp">
									<a href="" class="smdcust-item" id="<?php echo $id ?>">
										<?php echo $this->functionlist->convertNtilde(strtoupper($cust_name)) ?>
									</a>
								</p>
							
							
							<p class="schedulerp"><?php echo $this->functionlist->convertNtilde(strtoupper($project_name)) ?></p>	
							<p class="schedulerp"><?php echo $this->functionlist->convertNtilde(strtoupper($project_loc)) ?></p>

							<div class="dpssmdsched-wrapper" id="<?php echo $id ?>">
								<div class="smdsched-wrapper">
									<p id="title"><strong>OTHER REMARKS</strong></p>

									<p class="items"><?php echo $other_remarks ?></p>
									<p class="items">Pipes : <?php echo $add_pipes ?></p>
									<p class="items">Vibrator : <?php echo $add_vibrator ?></p>
									<p class="items">Slumpcone : <?php echo $add_slumpcone ?></p>
									<p class="items">Beam : <?php echo $add_beam ?></p>
									<br />
								</div>
							</div>

						</td>



						<td align="center">
							<?php 
								if($po == 0){
									echo "";
								}else{
									echo $po;
								}
							
							?>
						</td>
						<td align="center"><?php echo $str ?></td>
						<td align="center"><?php echo $agg ?></td>
						<td align="center"><?php echo $curing ?></td>
						<td align="center"><?php echo $slump ?></td>
						<td align="center"><?php echo $pouring ?></td>
						<td align="center"><?php echo $structure ?></td>
						<td align="center"><?php echo $remarks ?></td>
						<td align="center"><?php echo $estvolume ?></td>

						<td align='center' id='toy'>
							<p class="smd-orig-datetime"><?php echo $sched_date ?></p>
							
							<?php 
								if($modified_date <> null OR $modified_date <> $sched_date){
									echo "<p class='smd-mod-datetime'><strong>$modified_date</strong></p>";
								}
							?>
						</td>

						<td align='center' id='toy'>
							<p class="smd-orig-datetime"><?php echo $sched_time ?></p>
							<?php 
								if($modified_time <> null OR $modified_time <> $sched_time){
									echo "<p class='smd-mod-datetime'><strong>$modified_time</strong></p>";
								}
							?>
							
						</td>

						<td align="center"><?php echo $form_num ?></td>
						<td align="center"><?php echo $design_status ?></td>
												
						<td align="center" id="left">
							
							<!-- Checkbox value is the scheduled item id-->
							<?php
							if($smd_status == 'Approved' OR $coor_status == 'Unapproved' OR $design_status == 'Cancelled'){
								//echo "<input type='checkbox' name='selectedsched[]' id='selectedsched$ctr' class='sched-select-checkbox' value='$id' disabled='true'/>";
								//echo "Unapproved?";
								//display the unapproved button
								echo "<a href='#' class='unapproved-button' id='$id'>Unapproved</a>";

							}
							else{
								echo "<input type='checkbox' name='selectedsched[]' id='selectedsched$ctr' class='sched-select-checkbox' value='$id'/>";
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

				<div class="approvedbut-wrapper">
					<input type="hidden" name="whatday" value="<?php echo $whatday ?>" />
					<input type="submit" name="scheduler-approved-submit" class="scheduler-approved-submit" value="Approved">
				</div>
			</form>
		</div>

	