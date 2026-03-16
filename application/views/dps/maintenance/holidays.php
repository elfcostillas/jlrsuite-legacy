<div id="content" class="grid-940">
	<center>
		<h3>List of Holidays for Year <?php echo date("Y") ?></h3>
	</center>

	<fieldset>
		<legend>Legend</legend>
		<ul class="scheduler-legend-wrapper">
			<li id="holiday-active">Exempted Date (No Display)</li>
			<li id="holiday-inactive">Not Exempted Date (Display)</li>
		</ul>
	</fieldset>

	<br />
	<br />
	<br />
	<div id='hdays-wrapper'>
		<?php
			foreach ($holiday_date as $holidate) {
		       			$dates = $holidate->holidate;
		       			$status = $holidate->status;

		       			switch ($status) {
		       				case 'ACTIVE':
		       					$myclass = 'hday-active';
		       					break;
		       				case 'INACTIVE':
		       					$myclass = 'hday-inactive';
		       					break;
		       				
		       			}
		?>

				<a href="#" class="<?php echo $myclass ?> hdaysvalue" id="<?php echo $dates ?>" ><?php echo $dates?></a>
				
		<?php
		       		
		    }
	    ?>
    </div>

    
	<div class="hdaysedit-form" id="hdaysedit">
		<label>Edit Holiday : </label>
		<select name="update-hdaysvalue" id="update-hdaysvalue">
			<option value=""></option>
			<option value="ACTIVE">Active</option>
			<option value="INACTIVE">Inactive</option>
		</select>
		<input type="hidden" id="hdaysedit-hidden" />
		&nbsp&nbsp&nbsp<a href="#" class="hdays-button" id="hdaysedit-submit-button" >Update</a>
    	
    </div>
	
	<div class="hdaysedit-form" id="hdaysadd">
		<label>Add Holiday : </label>
    	<input type="text" class="hdayspicker" name="hdayspicker" placeholder="Pick a date" id="" value="" />
    	<input type="hidden" id="alternatehdays" name="alternate"/>
    	&nbsp&nbsp&nbsp<a href="#" class="hdays-button" id="hdaysadd-submit-button" >Submit</a>
    	<p id="exist" class="hdaysadd-error">Date already exist on the database.</p>
    	<p id="inserted" class="hdaysadd-error">Date successfully added to holiday list.</p>
    </div>

    

    <div id="hdays-action-wrapper">
    	<a href="#" class="hdays-button" id="hdaysadd-button" >Add a Holiday</a>
    </div>
    
</div>