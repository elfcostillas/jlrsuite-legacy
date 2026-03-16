<?php

	 //var_dump($deptlist[0][0]);
	//display the department list

	 
	
?>

<div class="container">

	<br/>
		<div class="row">
			<h3>Mass Leave Form</h3>
			<hr>
			
			<form method='POST' action="test" id="massleave-form">

				<div class="col-md-4">
					<div class="row" id="deptlist-wrapper">
						<?php
							foreach ($deptlist as $list) {
							 	$dept = $list->department;
							 	$dept_id = $list->dept_id;
							
						?>

					
							<div id="<?php echo strtolower($dept) ?>-dept-wrapper">
								<div class="dept-emp-group">
									<!-- <a href="#" id="<?php echo strtolower($dept) ?>" class="empcount-toggle"> -->
										<h3>
										<input type="checkbox" name="<?php echo strtolower($dept) ?>" id="checkbox-<?php echo strtolower($dept) ?>-dept" class="css-checkbox massleave-cb" />
										<label for="checkbox-<?php echo strtolower($dept) ?>-dept" class="css-label"><?php echo $dept ?></label>
										</h3>
										<input type="hidden" value="<?php echo $dept_id ?>" id="<?php echo strtolower($dept) ?>" class="we"/>
									
										<!-- must be hidden -->
										<div class="emplist-wrapper">
											<div id="<?php echo strtolower($dept) ?>" class="dept-emp-list">
											</div>
										</div>

								</div>
							</div>
							
						

						<?php
							 }
						?>
					</div>
				</div>

				<div class="col-md-8">
					<div class="form-wrapper leave-forms" id="form-massleave">
						

				        <div class="row leave-form-row" >
				          <div class="col-md-6 no-l-pads">
				            <label>Date From</label>
				            <br />
				            <input type="text" class="col-md-12 datetimepicker" placeholder="Starting Date" id="date-from-mass" name="date-from-mass">
				            <input type="hidden" class="col-md-12 " id="dt-from-mass" name="dt-from-mass">
				          </div>
				          
				          <div class="col-md-2 no-l-pads">
				            <label>Time</label>
				            <br />
				            <input type="text" class="col-md-12 timepicker" placeholder="00:00 AM" id="time-from" name="time-from">
				            <input type="hidden" class="col-md-12" id="tm-from" name="tm-from">
				          </div>      
				        </div>

				        <div class="row leave-form-row">
				          <div class="col-md-6 no-l-pads">
				            <label>Date To</label>
				            <br />
				            <input type="text" class="col-md-12 datetimepicker" placeholder="Until When" id="date-to-mass" name="date-to-mass">
				            <input type="hidden" class="col-md-12 " id="dt-to-mass" name="dt-to-mass">
				          </div>
				          
				          <div class="col-md-2 no-l-pads">
				            <label>Time</label>
				            <br />
				            <input type="text" class="col-md-12 timepicker" placeholder="00:00 PM" id="time-to" name="time-to">
				            <input type="hidden" class="col-md-12" id="tm-to" name="tm-to" >
				          </div>

				          <div class="col-md-4 no-l-pads">
				            <label>Duration (in days)</label>
				            <br />
				            <input type="text" class="col-md-12 text-center" placeholder="0" id="leave-duration" name="leave-duration">
				          </div>  
				        </div>

				        <div class="row leave-form-row">
				          <div class="col-md-12 no-l-pads">
				            <label>Reason</label> 
				            <br />
				            <input type="text" class="col-md-12" placeholder="Leave Reason" name="leave-reason" id="leave-reason">
				          </div>
				        </div>

				        <div class="row leave-form-row">
				          <div class="col-md-6 no-l-pads">
				            <label>Leave Type</label> 
				            <br />
				            <select class="col-md-11" id="leave-type" name="leave-type">
				              <option value="">SELECT A LEAVE TYPE</option>
				              <option value="VACATION">VACATION</option>
				              <option value="SICK">SICK</option>
				              <option value="EMERGENCY">EMERGENCY</option>
				              <option value="MATAERNITY/PATERNITY">MATERNITY / PATERNITY</option>
				              <option value="BIRTHDAY">BIRTHDAY</option>
				              <option value="UNDERTIME">UNDERTIME</option>
				              <option value="COMPANY LEAVE">COMPANY LEAVE</option>
				              <option selected="true" value="MASS LEAVE">MASS LEAVE</option>
				              <option value="OTHERS">OTHERS</option>
				            </select>
				          </div>

				          <div class="col-md-2 no-l-pads">
				            <label>With Pay</label>
				            <br />
				            <input type="text" class="col-md-12 text-center" placeholder="0" id="w-pay" name="w-pay">
				          </div>  

				          <div class="col-md-3 no-l-pads">
				            <label>Without Pay</label>
				            <br />
				            <input type="text" class="col-md-7 text-center" placeholder="0" id="wo-pay" name="wo-pay">
				          </div>  
				        </div>

				        <br />
				        <br />
				        <div class="row leave-form-row">
				          <div class="col-md-6 no-l-pads">
				            <button type="button"  id="massleave-submit-btn" name="submit-mass-leave" class="col-md-6 flat-button" value="submit">Submit Mass Leave <span class="glyphicon glyphicon-send"></span></button>
				          </div>
				        </div>
					</div>
					<!-- <a href="#" id="massleave-submit-btn" class="flat-btn blue">Submit Mass Leave</a> -->
				</div>

			</form>

		</div>

</div>



