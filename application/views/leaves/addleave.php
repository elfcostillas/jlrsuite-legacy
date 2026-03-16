<div id="content" class="grid-940">

	<a href="add_massleave" id="mass-leave-but">Mass Leave</a>

	<div class="content-body">
		
		
		<h2>Add a new Leave</h2>

		<div class="notice-success" id="notice-addleave-success"><strong>Success! </strong>Leave successfully added.</div>

		<div class="form">
			



			<?php 
				$attributes = array('class' => 'form-validation', 'id' => 'addleaveForm', 'name' => 'addleaveForm');
				echo form_open('',$attributes);
			?>

				<?php $year = mdate('%Y', time()) ?>

				<div class="form-field alt-field">
					<!-- load the employee list from the database in to that dropdown list -->
					<input type="hidden" id="currentyear" name="currentyear" value="<?php echo $year ?>" />
					<input type="hidden" id="emp-credit-balance" name="emp-credit-balance" />
					<label for="title">Employee Name :</label>
					<select class="input-fields validate[required]" id="addleave_emp_name" name="addleave_emp_name">
							<option value=""></option>
				            <?php				
					            foreach($employee as $employees){
					            	$firstname = $this->leaveclass->convert_Big_Ntilde($employees['first_name']);
					            	$lastname = $this->leaveclass->convert_Big_Ntilde($employees['last_name']);
					                echo '<option value="' . $employees['o1_id'] . '">' . trim($lastname) . "," . trim($firstname) .'</option>';
					            }
				            ?>
					</select>

					<label id="addleave-credits-result">Credit balance : <span></span></label>
				</div>

				<div id="addleave-wrapper">

					<div class="form-field">
						<label for="title">Date Filed :</label>
						<input class="input-fields" id="datefiled_picker" type="input" name="datefiled_picker" />
						<div class="addleave-error" id="datefiled-error">Error : Cannot be left blanked.</div>
					</div>
					
					<div class="form-field alt-field">
						<label for="title">Inclusive From :</label>
						<input class="input-fields" id="inclusivefrom_picker" type="input" name="inclusivefrom_picker" />
						<img src="<?php echo base_url("css/images/clock.png") ?>" />
						<input class="timepicker timeinput" id="timefrom" name="timefrom" type="text" />
						<div class="addleave-error" id="inclusivetime-error">Error : Cannot be left blanked.</div>
					</div>
					
					<div class="form-field">
						<label for="title">Inclusive To :</label>
						<input class="input-fields" id="inclusiveto_picker" type="input" name="inclusiveto_picker"/>
						<img src="<?php echo base_url("css/images/clock.png") ?>" />
						<input class="timepicker timeinput" id="timeto" name="timeto" type="text" />
						<div class="addleave-error" id="inclusivetimeto-error">Error : Cannot be left blanked.</div>
						<div class="error-notify" id="remarks">
							<p><strong>Error:</strong> From and To date are invalid.</p>
						</div>
					</div>

					<div class="form-field  alt-field">
						<label for="title">Reason :</label>
						<input class="input-fields validate[required]" type="input" id="reason" name="reason" />
						<div class="addleave-error" id="reason-error">Error : Cannot be left blanked.</div>
					</div>
					
					<div class="form-field">
						<label for="title">Leave Type :</label>
						<?php
							$options = array(
							                  ''  => 'Please select a type',
							                  'vacation'  => 'Vacation',
							                  'sick'  => 'Sick',
							                  'undertime'  => 'Undertime',
							                  'emergency'  => 'Emergency',
							                  'maternity/paternity'  => 'Maternity/Paternity',
							                  'bl'  => 'Birthday'
							                );
							$attrib = ('id="addleave_leavetype" class="input-fields"');
							echo form_dropdown('leave_type', $options, '',$attrib);

						?>	
						<div id="undertime-hours-wrapper">
							<img src="<?php echo base_url("css/images/clock.png") ?>" />
							<input id="undertime-hours" name="undertime-hours" class="timepicker" type="text"/>
						</div>

						<div class="addleave-error" id="leavetype_undertime-error">Error : Cannot be left blanked.</div>
					</div>
					
					<!--	Another Selectbox default to withoutpay				-->
						<div class="form-field  alt-field" id="paytype-3">
							<label for="title">Pay :</label>
							<?php
								$options = array(
								                  'without pay'  => 'Without pay'
								                );

								$attrib = ('id="addleave_paytype3" class="input-fields"');
								echo form_dropdown('pay_type3', $options, '',$attrib);

							?>
							<label for="title">Amount :</label>
							<input type="hidden" name="addleave-nobalance" id="addleave-nobalance">
							<input class="input-fields timepicker" type="input" name="pay_amount3" id="pay_amount3"/>	
							<div class="addleave-error" id="payamount3-error">Error : Cannot be left blanked.</div>				
						</div>

						<div class="form-field  alt-field" id="paytype-1">
							<label for="title">Pay :</label>
							<?php
								$options = array(
								                  ''  => 'Please Select',
								                  'with pay'  => 'With pay',
								                  'without pay'  => 'Without pay'
								                );

								$attrib = ('id="addleave_paytype1" class="input-fields"');
								echo form_dropdown('pay_type1', $options, '',$attrib);

							?>
							<label for="title">Amount :</label>
							<input class="input-fields timepicker" type="input" name="pay_amount1" id="pay_amount1"/>	
							<div class="addleave-error" id="payamount1-error">Error : Cannot be left blanked.</div>				
						</div>

						<div class="form-field  alt-field" id="paytype-2">
							<label for="title">Pay :</label>
							<?php
								$options = array(
								                  ''  => 'Please Select',
								                  'with pay'  => 'With pay',
								                  'without pay'  => 'Without pay'
								                );

								$attrib = ('id="addleave_paytype2" class="input-fields" disabled="true"');
								echo form_dropdown('pay_type2', $options, '',$attrib);

							?>
							<label for="title">Amount :</label>
							<input class="input-fields timepicker" type="input" name="pay_amount2" id="pay_amount2" value="0"/>	
							<div class="addleave-error" id="payamount2-error">Error : Cannot be left blanked.</div>

						</div>
					

					<div class="form-field alt-field">
						<p id="pay-note">Note: Please review again the details before clicking the submit button.</p>
						<center><a name="add-leave-submit" id="add-leave-submit" class="submit-button" href="#">Add Leave</a></center>
						
					</div>

				</div>
					
			</form>
		</div>

	</div>
</div>
