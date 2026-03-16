	<?php

	if($count == 'norecord'){

	}else{
		/* get the result from the returned mysql query*/
		$rows = $result->num_rows();
		$i = 0;
		$ctr = 1;
		$client_ctr1 = 0;
		$client_ctr2 = 0;
		

		switch ($status) {
			case 'normal':
		?>
				
		<?php
				break;

				case 'insert':
				if($rows <= 0){
					echo "<tr>";
					echo "<td colspan='18' id='trow2' ><center>There are no Inserted pourings as of this moment</center></td>";
					echo "</tr>";
					
				}else{
					echo "<tr>";
					echo "<td colspan='18' id='trow2' ><center>Inserted Pourings</center></td>";
					echo "</tr>";
				}
				break;
		}

		while ( $i < $rows) {
				
				$row = $result->row($i);
				

				$id = $row->o202_id;
				$project_id = $row->project_id;
				$client_id = $row->client_id;
				$form_no = $row->form_no;
				$form_type = $row->form_type;
				$project_name = $row->proj_name;
				$project_address = $row->proj_address;
				$cust_name = $row->cust_name;


				//get the design status and batching plant location
				$smd_status = $row->smd_status;
				$design_status = $row->design_status;
				$batching_plant = $row->batching_plant;

				//get vibrator use status
				$act_vib = $row->act_vib_use;
				$act_vib_qc = $row->act_vib_qc;

				// get design values
				$book_psi = $row->book_psi;
				$book_msa = $row->book_msa;
				$book_cd = $row->book_cd;
				$book_sp = $row->book_sp;

				//get values of other fields
				//$qc_remarks = $row->design_status;
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

				$add_others = $row->add_others;
				$qc_remarks = $row->qc_remarks;
				$plant_cast = $row->plant_cast;

				$po = $row->po_no;
				$contract = $row->contract_no;
			

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

				//calculate the data for display in the print summary

				if($design_time >= '0700' AND $design_time <= '1200' ){
					$client_ctr1 ++;
				}
				if($design_time >= '1300' AND $design_time <= '2000' ){
					$client_ctr2 ++;
				}


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
			<tr class="items dpsindex-table-tr <?php echo $myClass ?>" id="<?php echo $id ?>">

				

				<td rowspan="2" align="left" id="left-item" class="scheduler-left-item">
					<p class="toink">&nbsp<strong><?php echo $ctr.'. '.$cust_name ?></strong></p>
					<p class="toink">&nbsp<?php echo $project_name ?></p>	
					<p class="toink">&nbsp<?php echo $project_address ?></p>

				</td>
			
				<td rowspan="2" align="center"><p><?php echo $other_remarks ?></p></td>
				<td rowspan="2" align="center"><p><?php echo $act_vib ?><br/><?php echo $act_vib_qc ?></p></td>
				<td rowspan="2" align="center"><p><?php echo $acctg_remarks ?></p></td>
				<td rowspan="2" align="center"><p><?php echo $design_time ?></p></td>
				<td rowspan="2" align="center"><p><?php echo $remarks ?></p></td>
				<td rowspan="2" align="center"><p><?php echo $design_volume ?></p></td>

				<?php
					if($book_cd == '3D' OR $book_cd == '7D'){
						$myDesignClass = 'img-bg';
					}else{
						$myDesignClass = '';
					}
				?>

				<td align="center" class="<?php echo $myDesignClass ?>"><p><?php echo $book_psi ?></p></td>
				<td align="center" class="<?php echo $myDesignClass ?>"><p><?php echo $book_msa ?></p></td>
				<td align="center" class="<?php echo $myDesignClass ?>">
					<?php
						if($book_cd == '3D' OR $book_cd == '7D' OR $book_cd == '14D'){
							echo "<strong><p>$book_cd</p></strong>";
						}else{
							echo "<p>$book_cd</p>";
						}
					?>
					
				</td>
				<td align="center" class="<?php echo $myDesignClass ?>"><p><?php echo $book_sp ?></p></td>

				<td rowspan="2" align="center"><p><?php echo $pouring ?></p></td>
				<td rowspan="2" align="center"><p><?php echo $structure ?></p></td>
				<?php /*<td rowspan="2" align="center"><p><?php echo $batching_plant ?></p></td>*/?>
				<td rowspan="2" align="center"><p><?php echo $service_engr ?></p></td>
				<td rowspan="2" align="center"><p><?php echo $qa_rep ?></p></td>
				<td rowspan="2" align="center"><p><?php echo $sales_engr ?></p></td>							
				<td rowspan="2" align="center" id="left"><p><?php echo $form_type .'-'. $form_no ?></p></td>

				<tr class="<?php echo $myClass ?>">
					<td align="left" colspan="3" rowspan="1" style="border-left:1px solid #666666; border-bottom:1px solid #666666;">
						<?php
							//$str_split = explode(' ', $f_code1);
						?>
						<p>&nbspFCode : <?php echo "<strong>".$f_code1."</strong>"; ?></p>
					</td>
					<td align="center" style="border-left:1px solid #666666; border-bottom:1px solid #666666;">

						<?php
							if($f_code2 <> ''){
								//$str_split = explode(' ', $f_code2);
								echo "<p><strong>".$f_code2."</strong></p>";
							}else{
								echo "<p></p>";
							}
							
						?>
						
					</td>
				</tr>
			
				
			</tr>

			
	<?php

				
			$i++;
			$ctr++;
			
		}  // end of while loop

	?>
					
<?php			
}//end of the main if statement
?>
					


				
			

				
			