<div class="grid-940" id="deu-main-wrapper" >
	<div class="search-wrapper" id="searchhistory">
		<form action="add_units" method="POST" id="addunits" enctype="multipart/form-data" autocomplete="off">
			<div id="addunitforms-container">
				<div class="items">
					<input type="hidden" name="unit-id" id="addunit-unitid" />
					<label>Unit Code :</label><input type="text" id="addunit-unitcode" name="unit-code" class="validate[required]"/>&nbsp&nbsp&nbsp
					<label>Color :</label><input type="text" id="addunit-unitcolor" name="unit-color" class="validate[required]"/>
				</div>

				<div class="items">
					<label>Description :</label><input type="text"  name="unit-desc" id="unitbox-desc" class="validate[required]"/>
				</div>

				<div class="items">
					<label>Plate No. :</label><input type="text" id="addunit-plateno" name="plateno" class="validate[required]"/>&nbsp&nbsp&nbsp
					<label>Capacity :</label><input type="text" id="addunit-capacity" name="capacity" class="validate[required]"/>
				</div>

				<div class="items">
					<label>Model :</label><input type="text" id="addunit-model" name="model" class="validate[required]"/>&nbsp&nbsp&nbsp
					<label>Serial No. :</label><input type="text" id="addunit-serial" name="serialno" class="validate[required]"/>
				</div>

				<div class="items">
					<label>Type :</label><input type="text" id="addunit-unittype" name="type" class="validate[required]"/>&nbsp&nbsp&nbsp
					<label>Make :</label><input type="text" id="addunit-unitmake" name="make" class="validate[required]"/>
				</div>

				<div class="items">
					<label>Weight :</label><input type="text" id="addunit-unitweight" name="weight" class="validate[required]"/>&nbsp&nbsp&nbsp
					<label>Location :</label>
					<select id="addunit-unitlocation" name="location" class="validate[required]">
						<option value="">Please Select</option>
						<option value="RMCD">RMCD</option>
						<option value="RMD">RMD</option>
						<option value="QAD">QAD</option>
					</select>
				</div>

				<div class="items">
					<label>Assigned to :</label><input type="text" id="addunit-assignedto" name="assignedto" class="validate[required]"/>&nbsp&nbsp&nbsp
					<label>Status :</label>
					<select id="addunit-unitstatus" name="unit-status" class="validate[required]">
						<option value="">Please Select</option>
						<option value="Active">ACTIVE</option>
						<option value="Out of Service">OUT OF SERVICE</option>
						<option value="Sold">SOLD</option>
					</select>
				</div>

				<div id="addbutton-wrapper">
					<input type="submit" value="ADD UNIT" id="addunit-button" />
				</div>
			</div>

			<div id="imageupload-container">
				<a href="#" id="addunit-browseimg-but">
					<img id="preview" src="../css/images/heavyequip.png" height="280px" width="300px"/>
					
				</a>
				<input type="file" id='deu-browseupload' name="deu-browseupload" onchange="previewImage(this)" accept="image/*"/>
				<script type="text/javascript">      
				  function previewImage(input) {
				    if (input.files && input.files[0]) {
				      var reader = new FileReader();
				      reader.onload = function (e) {
				        //the only jQuery line.  All else is the File API.
				        $('#preview').attr('src', e.target.result);

				      }
				      reader.readAsDataURL(input.files[0]);
				    }
				  }
				</script>
			</div>
			
		</form>

		
		
	</div>

	<h1 class="deu-h1">UNIT LIST</h1>
	<br />
	<?php
		echo $unitlist;
	?>
</div>