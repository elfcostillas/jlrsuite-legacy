<div id="unitlist-wrapper">

	<?php
		
		/* get the result from the returned mysql query*/
		$i = 1;
		foreach ($result->result() as $row)
 		{
			$id = $row->unit_id;
			$unit_code = $row->code;
			$dept = $row->location;	
	
			
			echo "<div class='unitlist-containers' id='$id'>";
	?>

				<li class="unitlist-itemcont">
					<strong><?php echo $unit_code ?></strong>
					<span>
						<a href="#" id="<?php echo $i ?>" class="edit-units">edit</a>
						&nbsp
						<a href="#" id="<?php echo $i ?>" class="delete-units">delete</a>
					</span>
				</li>
				
	<?php		
			echo "</div>";
			/*
			echo "<div class='edit-unit-wrapper'>";
			echo "<div class='edit-unit-container' id='$i'>";
				echo "<p>xfgedfgdfg</p>";
			echo "</div>";
			echo "</div>";
			*/
	
		$i++;
		}

	?>


</div>


	
	

