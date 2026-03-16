<table class="deu-table">
	<tr id="heading">
		<th>Unit</th>
		<th>Date In<br />Time In</th>
		<th>Details</th>
		<th>Location</th>
		<th>Est</th>
		<th>Mechanic</th>
		<th>Addtional Works<br />Updates/Remarks</th>
		<th>%</th>
		<th>Date Out<br />Time Out</th>
		<th>Done</th>
		<th></th>
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
			$est_days = $row->est_days;
			$est_hours = $row->est_hours;
			$mech = $row->mech;
			$ex_details = $row->ex_details;
			$perc = $row->comptage;
			$date_out = $row->date_out;
			$time_out = $row->time_out;

			$d1 = new DateTime($date_in);
			$d2 = new DateTime(date("Y-m-d"));

			

			$interval = $d2->diff($d1);
			$m = $interval->format('%m')*30;
			$d = $interval->format('%d'); 
 			$diff = number_format($m+$d-(($m+$d)/7),0,',','.');
						
			if($est_days > 0){ 
				$est = "$est_days D"; 
				$var = number_format($diff-$est_days,0,',','.');
			}else{ 	
				$est = "$est_hours H";
				$date = date("Hi");
				$var=number_format(($date-($est_hours * 100))/100,0,',','.');
			}
			
			//$fdIn	= date('m/d/Y',strtotime($date_in));
			$timeout = '';
			if($time_out != ''){
				$timeout = $time_out."H";
			}

		
			
	?>

	

	<tr class="items" id="<?php echo $id ?>">
		
		<td align="center" class="deu-altcol"><?php echo $unit ?></td>

		<td align="center" id="datetimein">
			<input id="maint-datein"  class="deumaint-short" type="text" width="50" value="<?php echo $date_in ?>" />
			<input id="maint-timein" class="deumaint-short" type="text" value="<?php echo $time_in ?>" />
		</td>

		<td align="center" width="250" class="deu-altcol">
			<input id="maint-details" class="deumaint-details" type="text" value="<?php echo $details ?>" />
		</td>

		<td align="center" >
			<input id="maint-location" class="deumaint-veryshort" type="text" value="<?php echo $location ?>" />
		</td>

		<td align="center" class="deu-altcol">
			<input id="maint-est" class="deumaint-veryshort" type="text" value="<?php echo $est_days ?>" />
			
		</td>

		<td align="center">
			<input type="text" id="edit-mech" value="<?php echo $mech ?>" />
		</td>

		<td align="center" class="deu-altcol">
			<textarea id="edit-exdetails"><?php echo $ex_details ?></textarea>
		</td>

		<td align="center">
			<input type="text" id="edit-perc" value="<?php echo $perc ?>" />
		</td>

		<td align="center" class="deu-altcol">
			<input type="text" placeholder="yyyy-mm-dd" id="edit-dateout" value="<?php echo $date_out ?>" />
			<br />
			<select id="edit-timeout">
				<?php
					foreach($timelist as $time_list){
							$time = $time_list;
							if ($timeout == $time){
								echo '<option selected="true" value="' . $time . '"><center>' . $time .'</center></option>';
							}else{
								echo '<option value="' . $time . '"><center>' . $time .'</center></option>';
							}
							
					}
				?>
			</select>
		</td>

		<td class="deu-altcol" align="center">
			<input type="checkbox" id="maint-status"/>
		</td>	

		<td class="deu-altcol" align="center">
			<a href="#" id="deu-maint-updatebut<?php echo $id ?>" class="deu-maint-updatebut">Update</a>
			
		</td>	

		
		
	</tr>

	<?php
		$i++;
		}

	?>


</table>