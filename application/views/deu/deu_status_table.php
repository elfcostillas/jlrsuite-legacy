<table class="deu-table">
	<tr id="heading">
		<th width="30">No.</th>
		<th width="50">Unit</th>
		<th width="100">Date In<br />Time In</th>
		<th>Details</th>
		<th width="50">Location</th>
		<th width="50">Duration</th>
		<th>Technician</th>
		<th>Addtional Works<br />Updates/Remarks</th>
		<th width="30">%</th>
		<th width="50">AT</th>
		<th width="30">Var.</th>
		<th width="100">Date Out<br />Time Out</th>
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

	

	<tr class="items">
		<td align="center" width="20"><?php echo $i ?></td>
		<td align="center" width="40" class="deu-altcol"><?php echo $unit ?></td>
		<td align="center" width="70"><?php echo $date_in ?><br /><?php echo $time_in ?></td>
		<td width="300" align="center" class="deu-altcol"><?php echo $details ?></td>
		<td align="center" width="50"><?php echo $location ?></td>
		<td align="center" width="40" class="deu-altcol"><?php echo $est_days ?></td>
		<td align="center" width="100"><?php echo $mech ?></td>
		<td width="200" align="center" class="deu-altcol"><?php echo $ex_details ?></td>
		<td align="center" width="20"><?php echo $perc ?></td>
		<td align="center" class="deu-altcol"><?php echo $diff ?></td>
		<td align="center"><?php echo $var ?></td>
		<td align="center" width="70" class="deu-altcol"><?php echo $date_out ?><br /><?php echo $timeout ?></td>
		
	</tr>

	<?php
		$i++;
		}

	?>


</table>