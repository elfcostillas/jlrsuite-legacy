<table id='mytable'>
						
						<tr id='heading'>
							
							<th width='220'>CUSTOMER NAME / PROJECT / LOCATION</th>
							<th>OTHER<br />REMARKS</th>
							<th>ACCTG<br />REMARKS</th>
							<th>TIME<br />(hours)</th>
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
							<th>UPDATE</th>
						</tr>
<?php
			while ( $i < $rows) {
					
					$row = $ajaxfetch['result']->row($i);
					

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
							<p class='info'><strong><a href='' class='dpscust-item'>$cust_name</a></strong></p>
							<p class='info'><strong><a href=''>$project_name</a></strong></p>
							<p class='info'>$project_address</p>
						</td>

						<td align='center'>$qc_remarks</td>
						<td align='center' class='altcol'>$acctg_remarks</td>

						<td align='center'>
							$design_time<br />
							<input type='text' class='searchbydate-date' name='design-date' id='$id' value='$design_date' />
						</td>

						<td align='center' class='altcol'>$remarks</td>
						<td align='center'>$design_volume</td>

						<td align='center' id='designtd' width='160'>
							<div id='tdwrapper'>
								<div id='design'>
									<span class='alt'><a>$book_psi</a></span>
									<span class='alt2'><a>$book_msa</a></span>
									<span class='alt'><a>$book_cd</a></span>
									<span class='alt2'><a>$book_sp</a></span>
								</div>

								<div id='code'>
									<span id='code1'><a>$f_code1</a></span>
									<span id='code2'><a>$f_code2</a></span>
								</div>
							</div>
						</td>


						<td align='center'>$pouring</td>
						<td align='center' class='altcol'>$structure</td>
						<td align='center'>$batching_plant</td>
						<td align='center' class='altcol'>$sales_engr</td>						
						<td align='center'>$form_no</td>
						<td align='center' id='left' class='altcol' ><a href='#' id='$id' class='searchbydate-updatebut'>UPDATE</a></td>





					</tr>
<?php
				$i++;
			}
?>
			</table>