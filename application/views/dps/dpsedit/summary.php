<div id="dps-tables-wrapper">
	
		<table id="mytable">
			
			<tr id="heading">
				<th width="200">CUSTOMER</th>
				<th>TIME<br />(hours)</th>
				<th>VOLUME<br />(m<sup>3</sup>)</th>
				<!--
				<th class="heading" id="right-head" rowspan="2">Unloading<br />Rate<br />(m<sup>3</sup>/hour)</th>
				-->
				
				<th align="center">CONCRETE DESIGN
					<div id="condes-header">
						<span class="alt"><a>PSI</a></span>
						<span class="alt2"><a>MSA</a></span>
						<span class="alt"><a>C</a></span>
						<span class="alt2"><a>S</a></span>
					</div>
				</th>
				
				<th>STRUCTURE</th>
				<th>POURING<br />TYPE</th>
				<th>REMARKS</th>
				<th>RECEIPT</th>
				<th>OTHER<br />REMARKS</th>
				<!--
				<th class="heading" id="right-head" rowspan="2">Transit Mixer Cap(m<sup>3</sup>)</th>
				-->
				<th>TERMS</th>
				<th>ACCOUNTING<br />REMARKS</th>
				<th>DESIGN<br />CHECKED</th>

			</tr>

			

			
			<?php
				$rows = $result->num_rows();
				$i = 0;

				
				while ( $i < $rows) {
					$row = $result->row($i);
					
					$id = $row->o202_id;
					$project_id = $row->project_id;
					$client_id = $row->client_id;
					$form_no = $row->form_no;

					$cust_name = strtoupper($row->cust_name);
					$project_name = strtoupper($row->proj_name);
					$project_loc = strtoupper($row->proj_address);

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

					$acctg_remarks = $row->acctg_remarks;
					$fcode1 = $row->f_code1;
					$fcode2 = $row->f_code2;

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
					$terms = $row->terms;


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
				

					switch ($design_status) {
						case 'Okay':
							
							$dps_myclass = 'normal';
							break;
						
						case 'Insert':
							
							$dps_myclass = 'insert-schedule';
							break;

						case 'Re-Sched':
						
							$dps_myclass = 'resched-schedule';
							break;

						case 'For Confirmation':
							
							$dps_myclass = 'forconfirm-schedule';
							break;
					}

					
			?>


					<tr class="items" id="<?php echo $id ?>">


						<td align="left" id="left-item" class="<?php echo $dps_myclass ?>">
							
							<p class="info" id="customer"><strong><?php echo $cust_name ?></strong></p>
							<p class="info" ><strong><?php echo $project_name ?></strong></p>	
							<p class="info" ><?php echo $project_loc ?></p>	
						</td>	

									
						<td align="center" class="altcol"><?php echo $modified_time ?></td>
						<td align="center"><?php echo $estvolume ?></td>
						<!--
						<td rowspan="2" align="center">n/a</td>
						-->
						
						<td align="center" id="designtd" width="160">
							<div id="tdwrapper">
								<div id="design">
									<span class="alt"><a><?php echo $str ?></a></span>
									<span class="alt2"><a><?php echo $agg_design ?></a></span>
									<span class="alt"><a><?php echo $curing ?></a></span>
									<span class="alt2"><a><?php echo $slump_design ?></a></span>
								</div>

								<div id="code">
									<span id="code1"><a><?php echo $fcode1 ?></a></span>
									<span id="code2"><a><?php echo $fcode2 ?></a></span>
								</div>
							</div>
						</td>
						<td align="center"><?php echo $structure_design ?></td>
						<td align="center"><?php echo $pouring ?></td>
						<td align="center"><?php echo $remarks ?></td>
						<td align="center"><?php echo $form_no ?></td>


						<td align="center"><?php echo $other_remarks ?></td>
						<!--
						<td rowspan="2" align="center">IN PLANT</td>
						-->

							<?php
							if ($smd_status == 'Approved'){
								$checked = 'Yes';
								
							}
							else{
								$checked = 'No';

							}
							?>
						
						<td align="center" style="font-size:10px;font-style: oblique;"><?php echo $terms ?></td>
						<td align="center"><?php echo $acctg_remarks ?></td>							
						<td align="center" id="left"><?php echo $checked ?></td>

					

				</tr>

			<?php
				$i++;
				}
			?>		
		</table>

		
</div>