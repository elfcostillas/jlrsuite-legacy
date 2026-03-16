<div class="semifluid" id="deu-main-wrapper" >
	<div class="search-wrapper" id="searchhistory">
		<div class="float-right">
			<select>
				<option value="">Select Unit</option>
				<?php
					foreach ($units as $unitlist) {
						echo "<option value='$unitlist->unitcode'>$unitlist->unitcode</option>";
					}
				?>
			</select>

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

	<div id="searchhistory-printheader">
		<p>Report generated : <?php echo date('F m, Y') ?></p>
	</div>

	<div id="searchhistory-wrapper">
		<h1 class="deu-h1">SEARCH HISTORY</h1>
		<?php echo $monthly_repair ?>
	</div>
</div>