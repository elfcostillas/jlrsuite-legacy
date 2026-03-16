<div class="grid-940" id="deu-main-wrapper" >
	<div class="search-wrapper" id="equipmentlist">
		<div class="float-right">
			<select>
				<option value="">Select Unit Type</option>
				<option value="BC">Bulk Cement Truck</option>
				<option value="BD">Bulldozer</option>
				<option value="BH">Backhoe</option>
				<option value="BT">Boom Truck</option>
				<option value="DT">Dump Truck</option>
				<option value="FL">Fork Lift</option>
				<option value="MV">Motorcycle</option>
				<option value="PL">Payloader</option>
				<option value="PUMP">Concrete Pump</option>
				<option value="SV">Service Vehicle</option>
				<option value="TC">Telescopic Crane</option>
				<option value="TM">Transit Mixer</option>
			</select>

			<a href="#" class="search-button">SEARCH</a>
		</div>
	</div>

	<div id="equiplist-printheader">
		<p>Report generated : <?php echo date('F m, Y') ?></p>
	</div>

	<div id="equiplist-wrapper">
		<h1 class="deu-h1">EQUIPMENT LIST</h1>
		<?php echo $equiplist ?>
	</div>
</div>