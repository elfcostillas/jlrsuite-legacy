<?php
	/* get the result from the returned mysql query*/
	ini_set('display_errors', 0);
	$rows = $result->num_rows();
	$i = 0;


	if($layout == 'fluid'){
?>
		
		<table id="mdpstable-fluid">
			<tr>
				<th>Customer Name</th>
				<!-- <th>Terms</th> -->
				<th>Acctg.</th>
				<th>Volume</th>
				<th>Time</th>
				<th>Design</th>
				<th>Structure | Pouring</th>
				<th>Sales</th>
			</tr>

<?php
	}elseif($layout == 'fix'){
?>
		
		<table id="mdpstable-fix">
			<tr>
				<th>Customer Name<br />Design</th>
				<th>Acctg.</th>
				<th>Volume</th>
				<th>Time</th>
				
			</tr>
<?php
	}
?>





<?php

	while ( $i < $rows) {
				
		$row = $result->row($i);
		

		$id = $row->o202_id;
		$project_id = $row->project_id;

		$form_no = $row->form_no;
		$project_name = $row->proj_name;
		$project_address = $row->proj_address;
		$cust_name = $row->cust_name;


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
		$design_status = $row->design_status;
		
		$design_time = $row->modified_time;
		$remarks = $row->remarks;
		$design_volume = $row->batch_vol;
		$pouring = $row->pour_type;
		$structure = $row->structure;
		$sales_engr = $row->special_se;

		$acctg_remarks = $row->acctg_remarks;
		$service_engr = $row->service_engr;
		$qa_rep = $row->qa_rep;
		$f_code1 = $row->f_code1;
		$f_code2 = $row->f_code2;

		//get the notes value
		$notes_admin = $row->note_admin;
		$notes_acctg = $row->note_acctg;
		$notes_smd = $row->note_smd;
		$notes_dispatch = $row->note_dispatch;
		$notes_qa = $row->note_qa;
		$terms = $row->terms;

		$m_cust_code = $row->cust_code;


		if($layout == 'fluid'){		
?>
			<tr class="mtable-alt1">
				<?php 
					if ($design_status == 'Insert'){
						echo "<td class='m-insert' >";
					}elseif($design_status == 'Re-Sched'){
						echo "<td class='m-resched' >";
					}else{
						echo "<td >";
					}
				?>
					<input type="checkbox" value="<?php echo $id ?>" checked="true" name="dps-summary-checkitems[]" id="manager-approved-check"/>
					<strong><p  style="font-size: 12px;text-shadow: 1px 1px 2px #e8f4fa;color:#47494a;"><?php echo $cust_name ?></p></strong>
					<p><?php echo $project_name ?></p>
					<p><?php echo $project_address ?></p>
					
					<?php
						if (is_null($acctg_remarks) OR $acctg_remarks == "" OR is_null($f_code1) OR $f_code1 == ""){
							echo "<div class='arrow-up'></div>";
						}
					?>
					
					
				</td>

	
				<?php
    				$conn = odbc_connect('MSSQLServer', 'sa','Sb1@JLRC');
    				$result1=odbc_exec($conn,"SELECT TOP 1 a.CreditLine AS 'CREDIT_LIMIT',b.PymntGroup AS 'TERMS' FROM OCRD a inner join OCTG b on a.GroupNum = b.GroupNum Where a.CardCode = '$m_cust_code' ");
					// $cust_credit_sap = odbc_result($result1, "CREDIT_LIMIT");
					$cust_terms_sap =odbc_result($result1, "TERMS");
					odbc_close($conn);
				?>
				<!-- <td align="center" style="font-family: helvetica;font-size: 8px;"><?php echo $terms?></td> -->
				<!-- <td align="center" style="font-family: helvetica;font-size: 8px;"><?php echo $cust_terms_sap ?></td>
				
				<td align="center">
					<p>
						<?php
							// if(is_null($acctg_remarks) OR $acctg_remarks == ""){

							// }else{
								// echo "<a href='' id='$notes_acctg' class='mobile-acctg-terms-btn'>$acctg_remarks</a>";
							// }
						?>
					</p>
				</td> -->
				
			
				<td align="center"><p style="font-size: 12px;"><?php echo $cust_terms_sap ?></p>
					
						<?php //echo $acctg_remarks
						if(is_null($acctg_remarks) OR $acctg_remarks == ""){

							}elseif($acctg_remarks == "APPROVED" OR $acctg_remarks == "FBP-PAID"){
								//echo "<a href='' id='$notes_acctg' class='mobile-acctg-terms-btn'>$acctg_remarks</a>";
								echo "<span id='$notes_acctg' class='mobile-acctg-terms-btn-notfix'>$acctg_remarks</span>";
								
							}else{
								echo "<span class='mobile-acctg-terms-btn-notfix-unappr m-unapproved'> $acctg_remarks</span>";
							}
						?>
					
				</td>
							
				<td align="center" id='td-volume'><p class="mobile-volume" style="font-size: 12px;font-weight: bold;text-shadow: 1px 1px 2px #b0b4b5"><?php echo $design_volume ?></p></td>
				<td align="center"><p><?php echo $design_time ?><span class="mobile-pouring-type"><?php echo $remarks ?></span></p></td>
				<td align="center">
					<p>
						<ul>
							<li><a><?php echo $book_psi ?></a></li>
							<li><a><?php echo $book_msa ?></a></li>
							<li><a><?php echo $book_cd ?></a></li>
							<li><a><?php echo $book_sp ?></a></li>
						</ul>
					</p>
				</td>
				
				<!-- <td align="center"><p><?php //echo $pouring ?></p></td> -->
				<td align="center" ><p style="font-size: 8px;"><?php echo $structure ?></p><span class="mobile-pouring-type"><?php echo $pouring ?></span></td>
				<td align="center" ><p  style="font-size: 9px;"><?php echo $sales_engr ?></p></td>
			</tr>





<?php	
		}elseif ($layout == 'fix') {
?>
			<tr class="mtable-alt1" rowspan="2">
				<?php 
					if ($design_status == 'Insert'){
						echo "<td class='m-insert'>";
					}elseif($design_status == 'Re-Sched'){
						echo "<td class='m-resched'>";
					}else{
						echo "<td>";
					}
				?>
					<input type="checkbox" value="<?php echo $id ?>" checked="true" name="dps-summary-checkitems[]" id="manager-approved-check"/>
					<strong><p style="font-size: 12px;text-shadow: 1px 1px 2px #e8f4fa;"><?php echo $cust_name ?></p></strong>
					<p><?php echo $project_name ?></p>
					<p><?php echo $project_address ?></p>
					<?php
						if (is_null($acctg_remarks) OR $acctg_remarks == "" OR is_null($f_code1) OR $f_code1 == ""){
							echo "<div class='arrow-up'></div>";
						}
					?>
				</td>

				<td align="center">
					<p>
						<?php
							if(is_null($acctg_remarks) OR $acctg_remarks == ""){

							}elseif($acctg_remarks == "APPROVED" OR $acctg_remarks == "FBP-PAID"){
								echo "<a href='' id='$notes_acctg' class='mobile-acctg-terms-btn'>$acctg_remarks</a>";
							}else{
								echo "<a href='' id='$notes_acctg' class='mobile-acctg-terms-btn-notfix-unappr m-unapproved'>$acctg_remarks</a>";
							}
						?>
					</p>
				</td>

				<td align="center"><p class="mobile-volume" style="font-size: 13px;font-weight: bold;text-shadow: 1px 1px 2px #b0b4b5"><?php echo $design_volume ?></p></td>
				<td align="center"><p><?php echo $design_time ?></p><p><?php echo $remarks ?></p></td>
				

				<tr bgcolor="#fff">
					<td align="center">
						<p>
							<ul>
								<li><a><?php echo $book_psi ?></a></li>
								<li><a><?php echo $book_msa ?></a></li>
								<li><a><?php echo $book_cd ?></a></li>
								<li><a><?php echo $book_sp ?></a></li>
							</ul>
						</p>
					</td>
					<td align="center"><p><?php echo $pouring ?></p></td>
					<td align="center" colspan="1"><p><?php echo $structure ?></p></td>
					<td align="center"><p><?php echo $sales_engr ?></p></td>
				</tr>
			</tr>
<?php	
		}
?>

		

<?php
	$i++;
	}
?>

	
</table>