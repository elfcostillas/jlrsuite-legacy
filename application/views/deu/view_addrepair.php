<div class="grid-940" id="deu-main-wrapper" >
	<br />
	<h1 class="deu-h1">ADD REPAIR</h1>


	<form id="addrepair-form" action="insert_repair" method="POST">
		<div id="left" class="addrepair-wrapper-half">
			<div class="fields-wrapper">
				<label>Unit :</label>
				<select class="validate[required]" name="unit">
					<option value="">Select Unit</option>
					<?php
						foreach ($units as $unitlist) {
							echo "<option value='$unitlist->unitcode'>$unitlist->unitcode</option>";
						}
					?>
				</select>
			</div>
			<div class="fields-wrapper">
				<label>Date In :</label>
				<input type="text" class="deu-add-time validate[required]" name="date-in"/>
			</div>
			<div class="fields-wrapper">
				<label>Time In :</label>
				<select class="time validate[required]" name="time-in">
					<?php
						foreach ($time as $time_list) {
							echo "<option value='$time_list'>$time_list</option>";
						}
					?>
				</select>
			</div>
			<div class="fields-wrapper">
				<label>Repair Type :</label>
				<select class="validate[required]" name="repair-type">
					<option value=""></option>
					<option value="Major">Major</option>
					<option value="Major">Minor</option>
					<option value="Running">Running</option>
				</select>
			</div>
			<div class="fields-wrapper">
				<label>Availability :</label>
				<select class="validate[required]" name="availability">
					<option value=""></option>
					<option value="yes">YES</option>
					<option value="no">NO</option>
				</select>
			</div>
		</div>

		<div id="right" class="addrepair-wrapper-half">
			<div class="fields-wrapper">
				<label>Location :</label>
				<select class="validate[required]" name="location">
					<option value=""></option>
					<option value="S">RMDS</option>
					<option value="N">RMDN</option>
					<option value="Q">QAD</option>
				</select>
			</div>
			<div class="fields-wrapper">
				<label>Date Out :</label>
				<input type="text" class="deu-add-time" name="date-out"/>
			</div>
			<div class="fields-wrapper">
				<label>Time Out :</label>
				<select class="time" name="time-out">
					<?php
						foreach ($time as $time_list) {
							echo "<option value='$time_list'>$time_list</option>";
						}
					?>
				</select>
			</div>
			<div class="fields-wrapper">
				<label>Estimate :</label>
				<input type="text" class="short validate[required]" placeholder="days" name="est-day">
				<input type="text" class="short validate[required]" placeholder="hours" name="est-time">
			</div>
			<div class="fields-wrapper">
				<label>Technician :</label>
				<input type="text" class="validate[required]" name="technician"/>
			</div>
		</div>

		<div id="addrepair-wrapper-whole">
			<div class="fields-wrapper">
				<label class="widelabels">Scope of Work</label>
				<span id="scopespacer"></span>
				
				<input type="checkbox" class="addrepair-check validate[minCheckbox[1]]" name="scope[]" value="Mechanical"><label class="checkboxlabels">Mechanical</label>
				<input type="checkbox" class="addrepair-check validate[minCheckbox[1]]" name="scope[]" value="Hydraulics"><label class="checkboxlabels">Hydraulics</label>
				<input type="checkbox" class="addrepair-check validate[minCheckbox[1]]" name="scope[]" value="Electrical"><label class="checkboxlabels">Electrical</label>
				<input type="checkbox" class="addrepair-check validate[minCheckbox[1]]" name="scope[]" value="Welding / Fabrication"><label class="checkboxlabels">Welding / Fabrication</label>
				<input type="checkbox" class="addrepair-check validate[minCheckbox[1]]" name="scope[]" value="Body Building / Painting"><label class="checkboxlabels">Body Building / Painting</label>
			
			</div>

			<div class="fields-wrapper">
				<label>Details</label><br />
				<textarea class="long validate[required]" name="details"></textarea>
			</div>

			<div class="fields-wrapper">
				<label id="add-details-updates">Additional Works / Updates</label><br />
				<textarea class="long validate[required]" name="additional-works"></textarea>
			</div>
		</div>

		<div id="addrepair-wrapper-whole">
			<input type="submit" id="addrepair-submitbutton" value="ADD NEW REPAIR"/>
		</div>
	</form>

	
	
</div>