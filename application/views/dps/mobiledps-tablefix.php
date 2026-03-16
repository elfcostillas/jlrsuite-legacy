<?php
	/* get the result from the returned mysql query*/
	$rows = $result->num_rows();
	$i = 0;
?>

<table id="mdpstable-fix">
	<tr>
		<th>Customer Name</th>
		<th>Volume</th>
		<th>Time</th>
		<th>Remarks</th>
		
	</tr>

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
?>

		<tr class="mtable-alt1" rowspan="2">
			<td>
				<strong><p><?php echo $cust_name ?></p></strong>
				<p><?php echo $project_name ?></p>
				<p><?php echo $project_address ?></p>
			</td>

			<td align="center" ><p ><?php echo $design_volume ?></p></td>
			<td align="center"><p><?php echo $design_time ?></p></td>
			<td align="center"><p><?php echo $remarks ?></p></td>

			<tr>
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
			<td align="center" colspan="2"><p><?php echo $structure ?></p></td>
			</tr>
		</tr>

		

<?php
	$i++;
	}
?>
</table>