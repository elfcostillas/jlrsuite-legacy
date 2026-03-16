<!-- Modal for contract details entry -->
<div class="container-fluid">
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Contract Details</h4>
      </div>
      <div class="modal-body">
			<div class = 'alert alert-danger my_alert_sm small' id="error-dialog">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Oops!</strong>
			</div>

			<div class="form-group">	
  				<label for="new_cement_supp" class="control-label cement_supp">Cement Factor</label>
  				<input type="text" 	class="form-control numeric cement_supp input-sm" name="cement_supp" id="new_cement_supp"/>
			</div>

			<div class="form-group">	
  				<label for="new_strength" class="control-label">Strength</label>
  				<select name="strength" id="new_strength" class="form-control input-sm">
  					<?php foreach($strength as $row): ?>
						<option value="<?=$row->code ?>"><?= $row->code ?></option>
  					<?php endforeach; ?>
  				</select>
			</div>

			<div class="form-group">	
	  			<label for="new_size_of_agg" class="control-label">Max. size of aggregates(inch)</label>
	  			<select name=size_of_agg id="new_size_of_agg" class="form-control input-sm">
	  				<option value="3/4">3/4</option>
	  				<option value="3/8">3/8</option>
	  				<option value="1 1/2">1 1/2</option>
  			    </select>
  			</div>

			<div class="form-group">	
  			 	<label for="slump" class="control-label ">Slump(inch)</label>
  			 	<select name="slump" id="new_slump" class="form-control input-sm">	
					<option value="4-6">4-6</option>
					<option value="6-8">6-8</option>
					<option value="8-10">8-10</option>
  			 	</select>
			</div>

			<div class="form-group">	
  				<label for="new_curing_days" class="control-label">Curing Days</label>
  				<select name="curing_days" id="new_curing_days" class="form-control input-sm">
  					<option value="1">1</option>
  					<option value="3">3</option>
  					<option value="7">7</option>
  					<option value="14">14</option>
  					<option value="28">28</option>
  				</select>
			</div>
  		
			<div class="form-group">	
  				<label for="new_deliv_price" class="control-label">Delivery Price</label>
  				<input type="text" class="form-control numeric input-sm" name="deliv_price" id="new_deliv_price">
			</div>

			<div class="form-group">	
  				<label for="new_pickup_price" class="pickup control-label">Pickup Price</label>
  				<input type="text" class="form-control numeric pickup input-sm" name="pickup_price" id="new_pickup_price">
			</div>

			<div class="form-group">	
  				<label for="remarks" class="control-label">Remarks</label>
  				<select name="remarks" id="new_remarks" class="form-control input-sm">	
					<option value="Pump Design">Pump Design</option>
					<option value="Direct Pouring">Direct Pouring</option>
  			 	</select>
  			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="cntr-submit">Submit</button>
      </div>
    </div>
  </div>
</div>
</div>