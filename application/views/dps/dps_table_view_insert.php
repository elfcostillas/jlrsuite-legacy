	<?php
		/* get the result from the returned mysql query*/
		$rows = $result->num_rows();
		$i = 0;

		if($plant_loc == 'Plant 3'){
					echo "<h1 class='north'>NORTH</h1>";
				}
				elseif($plant_loc == 'Plant 4'){
					echo "<h1 class='south'>SOUTH</h1>";
				}
	?>

		
				<table id="mytable">
					
					<tr id="heading">
						
						<th width="220">CUSTOMER NAME / PROJECT / LOCATION</th>
						<th>SMD<br />commitments</th>
						<th>ACCTG<br />REMARKS</th>
						<th>TIME<br />(hours)</th>
						<th>REMARKS</th>
						<th>VOLUME</th>
						<th align="center">CONCRETE DESIGN
							<div id="condes-header">
								<span class="alt"><a>PSI</a></span>
								<span class="alt2"><a>MSA</a></span>
								<span class="alt"><a>C</a></span>
								<span class="alt2"><a>S</a></span>
							</div>
						</th>
						<th>POURING<br />TYPE</th>
						<th>STRUCTURE</th>
						<th>BATCHING<br />PLANT</th>
						<th>SERVICE<br />ENGR</th>
						<th>QA REP</th>
						<th>SALES<br />ENGR</th>
						<th>FORM</th>
					</tr>
	<?php
		
					




		while ( $i < $rows) {
				
				$row = $result->row($i);
				

				$id = $row->o202_id;
				$project_id = $row->project_id;
				$client_id = $row->client_id;
				$form_no = $row->form_no;
				$project_name = $row->proj_name;
				$project_address = $row->proj_address;
				$cust_name = $row->cust_name;
				$form_type = $row->form_type;


				//get the design status and batching plant location
				$smd_status = $row->smd_status;
				$design_status = $row->design_status;
				$batching_plant = $row->batching_plant;

				// get design values
				$book_psi = $row->book_psi;
				$book_msa = $row->book_msa;
				$book_cd = $row->book_cd;
				$book_sp = $row->book_sp;

				//get values of other fields
				$qc_remarks = $row->design_status;
				$acctg_remarks = $row->acctg_remarks;
				$design_time = $row->modified_time;
				$remarks = $row->remarks;
				$design_volume = $row->batch_vol;
				$pouring = $row->pour_type;
				$structure = $row->structure;
				$service_engr = $row->service_engr;
				$qa_rep = $row->qa_rep;
				$sales_engr = $row->special_se;
				$f_code1 = $row->f_code1;
				$f_code2 = $row->f_code2;

				//get the notes value
				$notes_admin = $row->note_admin;
				$notes_acctg = $row->note_acctg;
				$notes_smd = $row->note_smd;
				$notes_dispatch = $row->note_dispatch;
				$notes_qa = $row->note_qa;

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

				if($add_pipes != 'NO'){
					$other_remarks = 'Pipes=' . $add_pipes . ',' . $other_remarks ;
				}

				if($add_vibrator != 'NO'){
					$other_remarks = 'Vibrator=' . $add_vibrator . ',' . $other_remarks;
				}

				if($add_slumpcone == 'YES'){
					$add_slumpcone = 'Slumpcone';
					$other_remarks = $add_slumpcone . ',' . $other_remarks;
				}

				if($add_beam == 'YES'){
					$add_beam = 'Beam Molds';
					$other_remarks = $add_beam . ',' . $other_remarks;
				}

				if($add_others != 'NO'){
					$other_remarks = $add_others . ',' . $other_remarks;
				}

				if($po != '0'){
					$other_remarks = 'PO#' . $po . '<br />' . $other_remarks;
				}

				if($contract != '0'){
					$other_remarks = 'Contract#' . $contract . ',' . $other_remarks;
				}
				
				if($plant_cast == 'YES'){
					//$plant_cast = 'echo ""';
					$other_remarks = '<span class="plantcast">Plant Cast</span>' . ',' . $other_remarks;
				}

				$other_remarks = $qc_remarks . ',' . $other_remarks;

				$other_remarks = trim($other_remarks,',');


				//decide the bgcolor according to design status
				switch ($design_status) {
					case 'Insert':
						$myClass = 'insert-schedule';
						break;
				}
	?>
			<tr class="items" id="<?php echo $id ?>">

				

				<td align="left" class="<?php echo $myClass ?>" >
					<!--  ADDED BY RALPH 12/2/2013 -->
					<input type="checkbox" value="<?php echo $id ?>" checked="true" name="dps-summary-checkitems[]" id="manager-approved-check"/>
					<p class="info">
						<strong>
							<a href="" class="dpscust-item"><?php echo $this->functionlist->convertNtilde($cust_name) ?></a>
						</strong>
					</p>
					
					<p class="info">
						<strong>
							<a href="" class="dpsproj-item" id="<?php echo $id ?>"><?php echo $this->functionlist->convertNtilde(strtoupper($project_name)) ?></a>
						</strong>
					</p>

					<p class="info"><?php echo $this->functionlist->convertNtilde($project_address) ?></p>

					<div class="dps-approvelvl-wrapper">
						<?php
							//smd approval
							//accounting
							//plant supervisor
							//qa
							if($smd_status == 'Approved'){
								echo "<p class='approve-lvl' id='lvl1'>&nbsp</p>";
								if($acctg_remarks != ''){
									echo "<p class='approve-lvl' id='lvl2'>&nbsp</p>";
								}

								if($batching_plant != '' AND $service_engr != ''){
									echo "<p class='approve-lvl' id='lvl3'>&nbsp</p>";
								}

								if($f_code1 != '' AND $f_code2 != '' AND $qa_rep != '' AND $qc_remarks != ''){
									echo "<p class='approve-lvl' id='lvl4'>&nbsp</p>";
								}
							}
						?>

						<!-- RESTRICT THIS ICON TO BE VIEWED BY ANY USERS. ONLY SELECTED USERS CAN VIEW THIS-->
						<?php 
							//get the lvl of the user currently logged
							$user = $this->session->userdata('userlvl');

							if($user == 1 OR $user == 30 OR $user == 31 OR $user == 40 OR $user == 41 OR $user == 70 OR $user == 71 OR $user == 81 OR $user == 82){
						?>
						<a href="#" title="Add a Note" class="addnoteform" id="<?php echo $id ?>"><img src="<?php echo base_url("css/images/addnote.gif") ?>"/></a>
						<?php
							}
						?>
					</div>

					<div class="dpscontacts-wrapper" id="<?php echo $id ?>">
					</div>

					<div class="dpsnotes-wrapper" id="<?php echo $id ?>">
						<div class="notes-wrapper">
							<p id="title"><strong>NOTES</strong></p>
							<?php
								if($notes_admin != ''){
									echo "<p id='admin' class='items'><span>ADMIN :</span> " . $notes_admin . "</p>";
								}
								if($notes_acctg != ''){
									echo "<p id='acctg' class='items'><span>ACCOUNTING :</span> " . $notes_acctg . "</p>";
								}
								if($notes_smd != ''){
									echo "<p id='smd' class='items'><span>SMD :</span> " . $notes_smd . "</p>";
								}
								if($notes_dispatch != ''){
									echo "<p id='dispatch' class='items'><span>DISPATCH :</span> " . $notes_dispatch . "</p>";
								}
								if($notes_qa != ''){
									echo "<p id='qa' class='items'><span>QA :</span> " . $notes_qa . "</p>";
								}
							?>
						</div>
					</div>

					

					<div class="dpsnotes-form" id="<?php echo $id ?>">
						<div id="dpsaddnotes">
							
							<form id="addnote-form" method="POST">
								<?php
									
									
								
									if($user == 1){
										$user='admin';
										$data = $this->dps_model->get_dpsnotes($id,$user);

										foreach ($data as $notes) {
											$added_note = $notes['note'];
										}
									}

									if($user == 30 OR $user == 31){
										$user='acctg';
										$data = $this->dps_model->get_dpsnotes($id,$user);

										foreach ($data as $notes) {
											$added_note = $notes['note'];
										}
									}
								

									if($user == 40 OR $user == 41){
										$user='smd';
										$data = $this->dps_model->get_dpsnotes($id,$user);

										foreach ($data as $notes) {
											$added_note = $notes['note'];
										}
									}
								
									if($user == 70 OR $user == 71){
										$user='dispatch';
										$data = $this->dps_model->get_dpsnotes($id,$user);

										foreach ($data as $notes) {
											$added_note = $notes['note'];
										}
									}

									if($user == 81 OR $user == 82){
										$user='qa';
										$data = $this->dps_model->get_dpsnotes($id,$user);

										foreach ($data as $notes) {
											$added_note = $notes['note'];
										}
									} 
								
									
								?>
								<label><span>Recent note : </span>
									<?php 
										$added_note = (isset($added_note)) ? $added_note : ""; 
										echo $added_note;
									?>
								</label>
								<textarea name="note" class="dpsnote-textarea" id="dpsnote-content<?php echo $id ?>"></textarea>
								<input type="hidden" name="dpsnote-user" id="dpsnote-user<?php echo $id ?>" value="<?php echo $user ?>" />
								
								<a href="#" class="dpsnote-submit" id="<?php echo $id ?>" name="dpsnote-submit">Post Note</a>
							</form>
						</div>
					</div>
				</td>
			
				<td align="center"><p id="other-rems-info"><?php echo $other_remarks ?></p></td>
				<td align="center" class="altcol"><?php echo $acctg_remarks ?></td>
				<td align="center"><?php echo $design_time ?></td>
				<td align="center" class="altcol"><?php echo $remarks ?></td>
				<td align="center"><?php echo $design_volume ?></td>
				<td align="center" id="designtd" width="160">
					<div id="tdwrapper">
						<div id="design">
							<span class="alt"><a><?php echo $book_psi ?></a></span>
							<span class="alt2"><a><?php echo $book_msa ?></a></span>
							<span class="alt"><a><?php echo $book_cd ?></a></span>
							<span class="alt2"><a><?php echo $book_sp ?></a></span>
						</div>

						<div id="code">
							<span id="code1"><a><?php echo $this->functionlist->bold_fcode($f_code1) ?></a></span>
							<span id="code2"><a><?php echo $this->functionlist->bold_fcode($f_code2) ?></a></span>
						</div>
					</div>
				</td>
				<td align="center"><?php echo $pouring ?></td>
				<td align="center" class="altcol"><?php echo $structure ?></td>
				<td align="center"><?php echo $batching_plant ?></td>
				<td align="center" class="altcol"><?php echo $service_engr ?></td>
				<td align="center"><?php echo $qa_rep ?></td>
				<td align="center" class="altcol"><?php echo $sales_engr ?></td>							
				<td align="center" id="left"><?php echo $form_type .'-'. $form_no ?></td>


				<!--
				<tr class="dps-items2 <?php echo $myClass ?>">
					<td colspan="3" rowspan="1" ><p><?php echo $f_code1 ?></p></td>
					<td align="center" ><p><?php echo $f_code2 ?></p></td>
				</tr>
				-->
			</tr>

			
	<?php

				
			$i++;
			
		}  // end of while loop


	?>
					


				
				
			

				
			