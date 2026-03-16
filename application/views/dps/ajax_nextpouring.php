		
		<center>
			<h1 class="head">Pouring Schedule for (<?php echo $dateTom ?>)</h1>
			<p class="title-date">Details of the Scheduled Pourings for <?php echo $dateTom2 ?></p>
		</center>
		<!-- DISPLAY TOMORROW'S BOOKING -->
		<?php echo $dps_tom_north ?>
		<?php echo $dps_tom_north_insert ?>
		</table>
		<?php
			if($volume_tom_north != 0){
				echo "<center><h2>Total Volume: " . $volume_tom_north . " m<sup>3</sup></h2><center>";
			}
		?>

		<br /><br />

		<?php echo $dps_tom_south ?>
		<?php echo $dps_tom_south_insert ?>
		</table>

		<?php
			if($volume_tom_south != 0){
				echo "<center><h2>Total Volume: " . $volume_tom_south . " m<sup>3</sup></h2><center>";
			}
		?>

		<br /><br />

		<?php echo $dps_tom_forconfirm ?>
		</table>
		<?php
			if($volume_tom_forconfirm != 0){
				echo "<center><h2>Total Volume: " . $volume_tom_forconfirm . " m<sup>3</sup></h2><center>";
			}
		?>
