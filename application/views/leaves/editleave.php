<body>
	

		<div class="edit-content-body">
			<h2>Update Leave Record</h2>

			<div class="notice-success" id="notice-editleave-success"><strong>Success! </strong>Record successfully updated.</div>

			<div class="edit-form">
				<!-- <?php echo validation_errors(); ?> -->

				<?php foreach ($records as $records_list): ?>

				

				<?php 
					//have the lastname and fortsname into a variable
					$fullname = $records_list->last_name . "," . $records_list->first_name;

				?>

					<form id="edit-mainform">
					<div class="alt-edit-field">
						<div class="edit-form-field">
							<label>Employee Name</label>
							<input type="text" value="<?php echo $fullname ?>" disabled="true">
							
							<input type="hidden" id="leave-id" value="<?php echo $records_list->o200_id ?>" />
						</div>

						<div class="edit-form-field2">
							<label>Date Filed</label>
							<input class="input-fields" id="datefiled_picker" type="text" name="datefiled_picker" value="<?php echo $records_list->date_filed ?>"/>
						</div>
					</div>
					
					
					<div class="alt-edit-field2">
						<div class="edit-form-field">
							<label>Inclusive from</label>
							<input class="input-fields" id="edit-inclusivefrom_picker" type="text" name="edit-inclusivefrom_picker" value="<?php echo $records_list->inclusive_from ?>"/>
						</div>
					
						<div class="edit-form-field2">
							<label>Inclusive To</label>
							<input class="input-fields" id="edit-inclusiveto_picker" type="text" name="edit-inclusiveto_picker" value="<?php echo $records_list->inclusive_to ?>"/>
						</div>
					</div>
					


					<div class="alt-edit-field">
						<div class="form-reason">
							<label>Reason</label>
							<input class="input-fields reason-input" type="text" id="reason" name="reason" placeholder="Reason" value="<?php echo $records_list->reason ?>" />
						</div>
					</div>
					
					

					<div class="alt-edit-field2">
						<div class="short-select">
							<label for="title">Leave Type</label>
								<?php
									$options = array(
									                  ''  => 'Please select a type',
									                  'vacation'  => 'Vacation',
									                  'sick'  => 'Sick',
									                  'undertime'  => 'Undertime',
									                  'emergency'  => 'Emergency',
									                  'maternity/paternity'  => 'Maternity/Paternity',
									                  'birthday leave' => 'Birthday leave',
									                  'others'  => 'Others'
									                );
									$attrib = ('id="leave_type"');
									echo form_dropdown('leave_type', $options,lcfirst($records_list->leave_type),$attrib);

								?>	
						</div>

						<!--
							<div class="short-select2">
								<label for="title" class="short-label">Pay</label>

								<?php
									$options = array(
									                  ''  => 'Select',
									                  'with pay'  => 'With pay',
									                  'without pay'  => 'Without pay'
									                );

									$attrib = ('id="pay_type"');
									echo form_dropdown('pay_type', $options, $records_list->pay_type,$attrib);

								?>
								<label for="title" class="short-label">Amount</label>
								<input class="input-fields amount" type="input" name="pay_amount" id="pay_amount" value="<?php echo $records_list->pay_amount ?>"/>	
							</div>
						-->
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
							<input class="input-fields timepicker" type="input" name="pay_amount1" id="pay_amount1" value="<?php echo $records_list->w_pay ;?>" />	
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
							<input class="input-fields timepicker" type="input" name="pay_amount2" id="pay_amount2" value="<?php echo $records_list->wo_pay ;?>" />	
							<div class="addleave-error" id="payamount2-error">Error : Cannot be left blanked.</div>

						</div>
					


				<?php endforeach ?>
					
					<div class="alt-edit-field2">
						<div class="edit-form-field3">
							<center><p>Note: Please review again the details before clicking the submit button.</p>
							
							<a href="#" name="edit-record-submit" class="submit-button" id="edit-record-submit" >Update Record</a></center>
						</div>
					</div>

				</form>
			</div>

		</div>
	
<script>
	$(document).ready(function(){
		$("#addleave_paytype1").val('with pay');
		$("#addleave_paytype2").val('without pay');
	});
</script>