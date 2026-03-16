<div id="content" class="grid-940">


	<div id="usual1" class="usual">  
		<ul>
			<li><a href='#tab1'>Strength</a></li>
			<li><a href='#tab2'>Aggregates</a></li>
			<li><a href='#tab3'>Slump</a></li>
			<li><a href='#tab4'>Pouring Type</a></li>
			<li><a href='#tab5'>Structures</a></li>
		</ul> 

		<div id="tab1">
			<br />
				<div class="fields maint-selection-wrapper2" id="strength">
					<label class="title">Strength : </label>
					<input type="text" />
					&nbsp&nbsp&nbsp
					<label class="title">Type : </label>
					<select>
						<option value=""></option>
						<option value="psi">PSI</option>
						<option value="flex">FLEX</option>
					</select>
					<a href="#" id="strength" class="searchbutton adddesign-but">Add to List</a>

					<label class="exist">Existing : </label>
					<select name="strength1" id="strength1" class="validate[required]">
						<OPTION value="">Select</OPTION>
						<?php				
				            foreach($strength as $des_strength){
				            	$strength_value = $des_strength['strength'] . " " . $des_strength['type'];
				                echo '<option value="' . $des_strength['code'] . '">' . $strength_value .'</option>';
				            }
			            ?>
					</select>
				</div>
			<br />
		</div>

		<div id="tab2">
			<br />
				<div class="fields maint-selection-wrapper2" id="aggregates">
					<label class="title">Aggregates Name : </label>
					<input type="text" class="agg"/>
					&nbsp&nbsp&nbsp
					<label class="title">Aggregates Code : </label>
					<input type="text" class="agg"/>
					<a href="#" id="aggregates" class="searchbutton adddesign-but">Add to List</a>

					<label class="exist">Existing : </label>
					<select name="agg1" id="agg1" class="validate[required]">
						<OPTION value="">Select</OPTION>
						<?php				
				            foreach($agg as $des_agg){
				            	$agg_value = $des_agg['code'];
				                echo '<option value="' . $agg_value . '">' . $agg_value .'</option>';
				            }
			            ?>
					</select>
				</div>
			<br />
		</div>

		<div id="tab3">
			<br />
				<div class="fields maint-selection-wrapper2" id="slump">
					<label class="title">Slump : </label>
					<input type="text" class="agg"/>
					&nbsp&nbsp&nbsp
					<label class="title">Code : </label>
					<input type="text" class="agg"/>
					<a href="#" id="slump" class="searchbutton adddesign-but">Add to List</a>

					<label class="exist">Existing : </label>
					<select name="slump1" id="slump1" class="validate[required]">
						<OPTION value="">Select</OPTION>
						<?php				
				            foreach($slump as $des_slump){
				            	$slump = $des_slump['slump'];
				                echo '<option value="' . $des_slump['slump'] . '">' . $slump .'</option>';
				            }
			            ?>
					</select>
				</div>
			<br />
		</div>

		<div id="tab4">
			<br />
				<div class="fields maint-selection-wrapper2" id="pouringtype">
					<label class="title">Pouring Type : </label>
					<input type="text" class="agg"/>
					&nbsp&nbsp&nbsp
					<label class="title">Status : </label>
					<select>
						<option value=""></option>
						<option value="ACTIVE">ACTIVE</option>
						<option value="INACTIVE">INACTIVE</option>
					</select>
					<a href="#" id="pouringtype" class="searchbutton adddesign-but">Add to List</a>

					<label class="exist">Existing : </label>
					<select name="pouring1" id="pouring1" class="validate[required]">
						<OPTION value="">Select</OPTION>
						<?php				
				            foreach($pouringtype as $des_pouringtype){
				            	$pouringtype = $des_pouringtype['Type'];
				                echo '<option value="' . $des_pouringtype['Type'] . '">' . $pouringtype .'</option>';
				            }
			            ?>
					</select>
				</div>
			<br />
		</div>

		<div id="tab5">
			<br />
				<div class="fields maint-selection-wrapper2" id="structures">
					<label class="title">Structures : </label>
					<input type="text" class="" />
					<a href="#" id="structures" class="searchbutton adddesign-but">Add to List</a>

					<label class="exist">Existing : </label>
					<select name="struct1" id="struct1" class="validate[required]">
						<OPTION value="">Select</OPTION>
						<?php				
				            foreach($structure as $des_structure){
				            	$structure = $des_structure['struct_name'];
				                echo '<option value="' . $des_structure['struct_name'] . '">' . $structure .'</option>';
				            }
			            ?>
					</select>
				</div>
			<br />
		</div>


	</div>

	<script type="text/javascript"> 
	  $("#usual1 ul").idTabs(); 
	</script>
</div>