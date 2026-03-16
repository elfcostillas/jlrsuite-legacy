<table>
					
	<tr id="head">
		<th>PROJECT SITE</th>
		<th width="300">CUSTOMER NAME / PROJECT / LOCATION</th>
		<th>VOLUME</th>
		<th>QA REP</th>
		<th>DESIGN</th>
		
	</tr>



<?php
	/* get the result from the returned mysql query*/
	
	$rows = $rowcount;
	$i = 0;

	while ( $i < $rows) {
	
		$row = $result->row($i);
		

		//$id = $row->o202_id;
		$proj_id = $row->proj_id;
		$cust_name = $row->cust_name;
		$cust_proj = $row->proj_name;
		$cust_add = $row->proj_address;
		$psi = $row->psi;
		$msa = $row->msa;
		$cd = $row->cd;
		$sp = $row->sp;
		$volume = $row->batch_vol;
		$form = $row->f_code1;
		$desc = $row->f_desc;
		//$structure = $row->structure;
		//$plant = $row->batching_plant;
		//$service_engr = $row->service_engr;
		$qa_rep = $row->q;
?>
	<tr>
		<td align="center"><p class="items"><?php echo $proj_id ?></p></td>
		<td>
			<strong><p class="info" id="custname"><?php echo strtoupper($cust_name) ?></p></strong>
			<p class="info"><?php echo strtoupper($cust_proj) ?></p>
			<p class="info"><?php echo strtoupper($cust_add) ?></p>
		</td>
		<td align="center"><p class="items"><?php echo $volume ?></p></td>
		<td align="center"><p class="items"><?php echo $qa_rep ?></p></td>
		<td align="center"><p class="items"><b><?php echo $form ?></b>  = <?php echo $desc ?></p><p class="items">booked = <?php echo $psi." ".$cd." ".$msa." ".$sp; ?></p></td>
		
	</tr>

<?php
	$i++;
	}
?>

</table>
	


	
	
