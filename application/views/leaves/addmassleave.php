<body>
	<div class="edit-content-body">
		<br /><br />

		<div class="notice-success" id="notice-editleave-success"><strong>Success! </strong>Record successfully updated.</div>

		<div class="edit-form">

			<form id="massleave-form" method="POST" action="process_massleave">

				<div id="massleave-selectall">
					<input type="checkbox" id="checkall">
					<label>Select All Employees</label>
				</div>

				<div id="massleave-table">
					<div class="massleave-dept-wrapper">
						<h1>SSDiv</h1>
						<?php
							foreach ($employee_list as $emp) {
								$dept = $emp['department'];
								$id = $emp['o1_id'];
								$fullname = $this->leaveclass->convert_Big_Ntilde($emp['fullname']);

								if($dept == 'SSDiv' OR $dept == 'IT' OR $dept == 'HR' OR $dept == 'SMD' OR $dept == 'ADMIN' OR $dept == 'FINANCE' OR $dept == 'QMS'){
									echo "<div class='massleave-item-wrapper'>";
										echo"<p>";
											echo"<input type='checkbox' name='emp-items[]'' class='chkitem' value='$id'>";
											echo"$fullname";
										echo"</p>";
										
									echo"</div>";
								}
							}
						?>
					</div>

					<div class="massleave-dept-wrapper">
						<h1>RMD</h1>
						<?php
							foreach ($employee_list as $emp) {
								$dept = $emp['department'];
								$id = $emp['o1_id'];
								$fullname = $this->leaveclass->convert_Big_Ntilde($emp['fullname']);

								if($dept == 'RMD'){
									echo "<div class='massleave-item-wrapper'>";
										echo"<p>";
											echo"<input type='checkbox' name='emp-items[]'' class='chkitem' value='$id'>";
											echo"$fullname";
										echo"</p>";
										
									echo"</div>";
								}
							}
						?>
					</div>

					<div class="massleave-dept-wrapper">
						<h1>RMC</h1>
						<?php
							foreach ($employee_list as $emp) {
								$dept = $emp['department'];
								$id = $emp['o1_id'];
								$fullname = $this->leaveclass->convert_Big_Ntilde($emp['fullname']);

								if($dept == 'RMC' OR $dept == 'QA'){
									echo "<div class='massleave-item-wrapper'>";
										echo"<p>";
											echo"<input type='checkbox' name='emp-items[]'' class='chkitem' value='$id'>";
											echo"$fullname";
										echo"</p>";
										
									echo"</div>";
								}
							}
						?>
					</div>

					<div class="massleave-dept-wrapper">
						<h1>QAD</h1>
						<?php
							foreach ($employee_list as $emp) {
								$dept = $emp['department'];
								$id = $emp['o1_id'];
								$fullname = $this->leaveclass->convert_Big_Ntilde($emp['fullname']);

								if($dept == 'QAD'){
									echo "<div class='massleave-item-wrapper'>";
										echo"<p>";
											echo"<input type='checkbox' name='emp-items[]'' class='chkitem' value='$id'>";
											echo"$fullname";
										echo"</p>";
										
									echo"</div>";
								}
							}
						?>
					</div>
				</div>

				
				<div id="massleave-inputs-wrapper">
					<div class="alt-edit-field massleave-itemswrapper">
						<label>Reason : </label><input type="text" id="massleave-reason" name="massleave-reason">
					</div>
					
					
						<div class="alt-edit-field2 massleave-itemswrapper">
							<label>Date Filed : </label><input type="text" id="massleave-datefiled" name="massleave-datefiled">
						</div>
						
					<!--
						<div class="alt-edit-field massleave-itemswrapper">
							<label>Date From : </label><input type="text" id="massleave-datefrom">
						</div>
						
						
						<div class="alt-edit-field2 massleave-itemswrapper">
							<label>Date To : </label><input type="text" id="massleave-dateto">
						</div>
					-->


				
					<div class="alt-edit-field2">
						<div class="edit-form-field3">
							<center><p>Note: Please review again the details before clicking the submit button.</p>
							<input type="submit" name="massleave-submit" class="submit-button" value="Add Mass Leave" />
							<!--<a href="#" name="edit-record-submit" class="submit-button" id="edit-record-submit" >Add Mass Leave</a>--></center>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
