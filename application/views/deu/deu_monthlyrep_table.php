<table class="deu-table" id="monthlyrep-table">
	<tr id="heading">
		<th width="100">Date In<br />Time In</th>
		<th width="50">Unit</th>
		<th>Repair Details</th>
		<th width="200">Updates</th>
		<th>Location</th>
		<th>Repair Type</th>
		<th width="100">Date Out<br />Time Out</th>
		<th width="120">Mechanics</th>
		<th>Status</th>
	</tr>

	<?php
		
		/* get the result from the returned mysql query*/
		$i = 1;
		foreach ($result->result() as $row)
 		{
				
				$id = $row->rmdID;

				$unit = $row->unit;
				$date_in = $row->date_in;
				$time_in = $row->time_in;
				$details = $row->details;
				$location = $row->location;
				$type = $row->type;
				$status = $row->status;
				$mech = $row->mech;
				$date_out = $row->date_out;
				$time_out = $row->time_out;
	?>

	

	<tr class="items">
		<td align="center"><?php echo $date_in ?><br /><?php echo $time_in ?></td>
		<td align="center"class="deu-altcol"><?php echo $unit ?></td>
		<td align="center"><?php echo $details ?></td>
		<td align="center" class="deu-altcol">update daw</td>
		<td align="center"><?php echo $location ?></td>
		<td align="center" class="deu-altcol"><?php echo $type ?></td>
		<td align="center"><?php echo $date_out ?><br /><?php echo $time_out ?></td>
		<td align="center" width="150" class="deu-altcol"><?php echo $mech ?></td>

		<?php
			if($status == 'COMPLETE'){
				echo "<td align='center' class='rep-stats-complete' >$status</td>";
			}else{
				echo "<td align='center' class='rep-stats-pending' >$status</td>";
			}
		?>
		
		
	</tr>

	<?php
		$i++;
		}

	?>


</table>