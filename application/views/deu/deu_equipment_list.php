<table class="deu-table" id="equiplist-table">
	<tr id="heading">
		<th>Unit ID</th>
		<th>Description</th>
		<th>Make</th>
		<th>Model</th>
		<th>Serial No.</th>
		<th>Type</th>
		<th>Location</th>
		<th>Weight</th>
		<th>Assigned To</th>
		<th>Status</th>
	</tr>

	<?php
		
		/* get the result from the returned mysql query*/
		$i = 1;
		foreach ($result->result() as $row)
 		{
			$unit_id = $row->code;
			$desc = $row->desc;
			$make = $row->make;
			$model = $row->model;
			$serial = $row->serial;
			$type = $row->type;
			$location = $row->location;
			$weight = $row->weight;
			$assigned_to = $row->assignedto;
			$status = $row->status;
			$unit_image = $row->image;
	
	?>

	

	<tr class="items">
		<td align="center" width="60">

			<?php
				if($unit_image == ''){
					echo $unit_id;

				}else{
					echo "<a href='".base_url($unit_image)."' class='unitcode'>";
						echo $unit_id;
					echo "</a>";
				}

			?>
			
			
		</td>
		<td align="center" width="150" class="deu-altcol"><?php echo $desc ?></td>
		<td align="center" width="100"><?php echo $make ?></td>
		<td width="100" align="center" class="deu-altcol"><?php echo $model ?></td>
		<td align="center" width="100"><?php echo $serial ?></td>
		<td align="center" width="100" class="deu-altcol"><?php echo $type ?></td>
		<td align="center" width="50"><?php echo $location ?></td>
		<td width="70" align="center" class="deu-altcol"><?php echo $weight ?></td>
		<td align="center" width="150"><?php echo $assigned_to ?></td>

		<?php
			if($status == 'Active'){
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