<?php
	$dateNow = date("Y-m-d");

	

	if($confirmpage == 'yes'){
		echo "<div class='dpspanel-warning'><span>FOR CONFIRMATION : </span>".$message ."</div>";
	}elseif($confirmpage == 'scheduler' OR $confirmpage == 'editpouring' OR $confirmpage == 'dob'){
		echo "<div class='dpspanel-warning'><span>NO POURING SCHEDULE</span></div>";
	}elseif($confirmpage == 'mobile'){
		echo "<div class='mobile-nodpsdata'><span>NO POURING SCHEDULE</span></div>";
	}
	else
	{
		if($date == $dateNow){
			$day = 'Today';
		}else{
			$day = 'Tomorrow';
		}

		switch ($plant_loc) {
			case 'Plant 3':
				$plant = 'NORTH';
				break;
			
			case 'Plant 4':
				$plant = 'SOUTH';
				break;	
		}
		echo "<div class='dpspanel-warning'><span>".$day.'('.$plant.') : </span>'.$message ."</div>";
	}
?>

