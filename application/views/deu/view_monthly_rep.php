<div class="semifluid" id="deu-main-wrapper" >
	<div class="search-wrapper" id="monthlyrepairs">
		<div class="float-right">
		
			<!-- must set the actual month and date first -->
			<select>
				<option value="">Select Month</option>
				<?php
					$ctr = 1;
					foreach ($months as $mon) {
						echo "<option value='$ctr'>$mon</option>";
						$ctr++;
					}
				?>
			</select>

			<select>
				<option value="">Select Year</option>
				<?php
					foreach ($years as $yr) {
						echo "<option value='$yr'>$yr</option>";
					}
					
				?>
			</select>

			<a href="#" class="search-button">SEARCH</a>
		</div>
	</div>

	<div id="monthlyrep-printheader">
		<p>Report generated on : <?php echo date('F m, Y') ?></p>
	</div>

	<div id="monthlyreps-wrapper">
		<h1 class="deu-h1">Repairs Recorded for <?php echo $monthfull . " " . $year ?></h1>
		<?php echo $monthly_repair ?>
	</div>
	
</div>