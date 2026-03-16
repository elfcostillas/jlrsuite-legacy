<div id="content" class="grid-940">

			
		<div class="content-body" id="leaverep-content">
			
			
			<div id="noprint-wrapper">
				<h3>Leave Reports</h3>
				<div class="form-field alt-field">
						<label>Leave Report by :</label>
						<?php
							$options = array(
							                  ''	=> 'Select One',
							                  '1'	=> 'Monthly',
							                  '3'   => 'Quarterly',
							                  '6'	=> 'Semi Annual',
							                  '12'  => 'Annual',
							                );
							$attrib = ('id="leave-report-choice" class="input-fields"');
							echo form_dropdown('leave-report-choice', $options, '',$attrib);
						?>
				</div>

				<div class="form-field leave-report-wrappers" id="monthly-wrapper">
							<label>Monthly :</label>
							<?php
								$options = array(
								                  ''	=> 'Select One',
								                  '1'	=> 'January',
								                  '2'   => 'February',
								                  '3'	=> 'March',
								                  '4'   => 'April',
								                  '5'	=> 'May',
								                  '6'   => 'June',
								                  '7'	=> 'July',
								                  '8'   => 'August',
								                  '9'	=> 'September',
								                  '10'  => 'October',
								                  '11'	=> 'November',
								                  '12'  => 'December',
								                );
								$attrib = ('id="leave-report-monthly" class="input-fields"');
								echo form_dropdown('leave-report-monthly', $options, '',$attrib);
							?>
				</div>

				<div class="form-field leave-report-wrappers" id="quarterly-wrapper">
							<label>Quarterly :</label>
							<?php
								$options = array(
								                  ''	=> 'Select One',
								                  '1'	=> '1st Quarter',
								                  '2'   => '2nd Quarter',
								                  '3'	=> '3rd Quarter',
								                  '4'   => '4th Quarter',
								                  
								                );
								$attrib = ('id="leave-report-quarterly" class="input-fields"');
								echo form_dropdown('leave-report-quarterly', $options, '',$attrib);
							?>
				</div>

				<div class="form-field leave-report-wrappers" id="semiannually-wrapper">
							<label>Semi-Annual :</label>
							<?php
								$options = array(
								                  ''	=> 'Select One',
								                  '1'	=> '1st Half',
								                  '2'   => '2nd Half',
								                  
								                  
								                );
								$attrib = ('id="leave-report-semiannually" class="input-fields"');
								echo form_dropdown('leave-report-semiannually', $options, '',$attrib);
							?>
				</div>

				<div class="form-field leave-report-wrappers" id="annually-wrapper">
							<label>Semi-Annual :</label>
							<?php
								$options = array(
								                  ''	=> 'Select One',
								                  '2010'	=> '2010',
								                  '2011'   	=> '2011',
								                  '2012'	=> '2012',
								                  '2013'   	=> '2013',
								                  '2014'   	=> '2014',
								                  '2015'   	=> '2015',
								                  '2016'   	=> '2016'
								                );
								$attrib = ('id="leave-report-annually" class="input-fields"');
								echo form_dropdown('leave-report-annually', $options, '',$attrib);
							?>
				</div>
			</div>

			


			

			<div id="leave_report_result"></div>

			
		</div>

	</div>