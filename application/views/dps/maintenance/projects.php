<div id="content" class="grid-940">
	

	<div id="usual1" class="usual">  
		<ul>
			<li><a href='#tab1'><img src="<?php echo base_url("css/images/edit-project.png") ?>" /> Edit Project</a></li>
		</ul> 

		<div id="tab1">
			<form name="add-cust-form" class="maintenance-form" method="POST" action="process_update_project">
				<div class="fields maint-selection-wrapper">
					<label>Project Name : </label>
					<select name="selected_project_id" id="selected_project_id">
						<option value="">Select a Project</option>
						<?php
							foreach ($project_list as $project) {
								echo "<option value='$project->o8_id'>$project->project_name</option>";
							}
							
						?>
						
					</select>
				</div>

				<div id="append-projinfo"></div>
				
				
				
			</form>
		</div>
	</div>

	<script type="text/javascript"> 
	  $("#usual1 ul").idTabs(); 
	</script>
</div>