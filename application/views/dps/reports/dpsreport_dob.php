<table>
					
	<tr id="head">
		<th width="300">CUSTOMER NAME / PROJECT / LOCATION</th>
		<th>TIME</th>
		<th>VOLUME</th>
		<th>POURING TYPE</th>
		<th>STRUCTURE</th>
		<th>PLANT</th>
		<th>SERVICE ENGR</th>
		<th>QA REP</th>
	</tr>



<?php
	/* get the result from the returned mysql query*/
	$rows = $rowcount;
	$i = 0;

	while ( $i < $rows) {
	
		$row = $result->row($i);
		

		$id = $row->o202_id;
		$cust_name = $row->cust_name;
		$cust_proj = $row->proj_name;
		$cust_add = $row->proj_address;
		$time = $row->modified_time;
		$volume = $row->batch_vol;
		$pouringtype = $row->pour_type;
		$structure = $row->structure;
		$plant = $row->batching_plant;
		$service_engr = $row->service_engr;
		$qa_rep = $row->qa_rep;
?>
	<tr>
		<td>
			<strong><p class="info" id="custname"><?php echo strtoupper($cust_name) ?></p></strong>
			<p class="info"><?php echo strtoupper($cust_proj) ?></p>
			<p class="info"><?php echo strtoupper($cust_add) ?></p>
		</td>
		<td align="center"><p class="items"><?php echo $time ?></p></td>
		<td align="center"><p class="items"><?php echo $volume ?></p></td>
		<td align="center"><p class="items"><?php echo $pouringtype ?></p></td>
		<td align="center"><p class="items"><?php echo $structure ?></p></td>
		<td align="center"><p class="items"><?php echo $plant ?></p></td>
		<td align="center"><p class="items"><?php echo $service_engr ?></p></td>
		<td align="center"><p class="items"><?php echo $qa_rep ?></p></td>
	</tr>

<?php
	$i++;
	}
?>

</table>
	


	
	
