<table id='mytable'>
						
						<tr id='heading'>
							
							<th width='220'>CUSTOMER NAME / PROJECT / LOCATION</th>
							<th>OTHER<br />REMARKS</th>
							<th>ACCTG<br />REMARKS</th>
							<th>REMARKS</th>
							<th>VOLUME</th>
							<th align='center'>CONCRETE DESIGN
								<div id='condes-header'>
									<span class='alt'><a>PSI</a></span>
									<span class='alt2'><a>MSA</a></span>
									<span class='alt'><a>C</a></span>
									<span class='alt2'><a>S</a></span>
								</div>
							</th>
							<th>POURING<br />TYPE</th>
							<th>STRUCTURE</th>
							<th>BATCHING<br />PLANT</th>
							<th>SALES<br />ENGR</th>
							<th>FORM</th>
							<th>TIME<br />(hours)</th>
							<th>STATUS</th>
							<th>UPDATE</th>
						</tr>
<?php
$i=0;
$rows = $rowcount;
			while ( $i < $rows) {
					
					$row = $result->row($i);
					

					$id = $row->o202_id;
					$project_id = $row->project_id;
					$client_id = $row->client_id;
					$form_no = $row->form_no;
					$project_name = strtoupper($row->proj_name);
					$project_address = strtoupper($row->proj_address);
					$cust_name = strtoupper($row->cust_name);


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
					$qc_remarks = $row->qc_remarks;
					$acctg_remarks = $row->acctg_remarks;
					$design_time = $row->modified_time;
					$design_date = $row->modified_date;
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


					//decide the bgcolor according to design status
					switch ($design_status) {
						case 'Re-Sched':
							$myClass = 'resched-schedule';
							break;

						case 'Insert':
							$myClass = 'insert-schedule';
							break;

						case 'For Confirmation':
							$myClass = 'forconfirm-schedule';
							break;

						default:
							$myClass = 'normal-schedule';
							break;
					}
?>

					<tr class='items'>
						<td align='left' class='$myClass'>
							<p class='info'><strong><a href='' class='dpscust-item'><?php echo $cust_name ?></a></strong></p>
							<p class='info'><strong><a href=''><?php echo $project_name ?></a></strong></p>
							<p class='info'><?php echo $project_address ?></p>
						</td>

						<td align='center'><?php echo $qc_remarks ?></td>
						<td align='center' class='altcol'><?php echo $acctg_remarks ?></td>

						

						<td align='center' class='altcol'><?php echo $remarks ?></td>
						<td align='center'><?php echo $design_volume ?></td>

						<td align='center' id='designtd' width='160'>
							<div id='tdwrapper'>
								<div id='design'>
									<span class='alt'><a><?php echo $book_psi ?></a></span>
									<span class='alt2'><a><?php echo $book_msa ?></a></span>
									<span class='alt'><a><?php echo $book_cd ?></a></span>
									<span class='alt2'><a><?php echo $book_sp ?></a></span>
								</div>

								<div id='code'>
									<span id='code1'><a><?php echo $f_code1 ?></a></span>
									<span id='code2'><a><?php echo $f_code2 ?></a></span>
								</div>
							</div>
						</td>


						<td align='center'><?php echo $pouring ?></td>
						<td align='center' class='altcol'><?php echo $structure ?></td>
						<td align='center'><?php echo $batching_plant ?></td>
						<td align='center' class='altcol'><?php echo $sales_engr ?></td>						
						<td align='center'><?php echo $form_no ?></td>

						<td align='center'>
							<?php echo $design_time ?><br />
							<input type='text' class='pendingsched-date' name='design-date' id='<?php echo $id ?>' value='<?php echo $design_date ?>' />
						</td>

						<td align='center'>
							<select name="designstatus<?php echo $id ?>" id="designstatus<?php echo $id ?>" class="sched-designstatus-update validate[required]" style="width:70px;">
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
						<td align='center' id='left' class='altcol' >
							<a href='#' id='<?php echo $id ?>' class='pendingsched-updatebut'>UPDATE</a>
						</td>





					</tr>
<?php
				$i++;
			}
?>
			</table>