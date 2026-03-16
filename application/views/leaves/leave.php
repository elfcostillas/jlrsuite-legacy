<div id="content" class="grid-940">

			
		<div class="content-body" id="bodycontent-allemp">
			<h3>Employee List - <span>Count : <?php echo $employee_count ?></span></h3>
			
			<div class="form-field" id="employee_list_filter">
					<label>Filter by department :</label>
					<select id="dept_filter" name="dept_filter">
						<option value="">Select Department</option>
						
			            <?php	
				            foreach($dept as $dept_list){
				                echo '<option value="' . $dept_list->department . '">' . $dept_list->department .'</option>';
				            }
			            ?>
					</select> 


					<!--<label>Filter by status :</label>
					<?php
						$options = array(
						                  ''		=> 'Select One',
						                  'Regular'		=> 'Regular',
						                  'Probitionary'    => 'Probationary',
						                  
						                );
						$attrib = 'id="status_filter"';
						echo form_dropdown('status_filter', $options, '',$attrib);
					?> -->

			</div>



					<ul id="leaves-sort-alpha">
						<li><a href="#" class="sort-letter" value="A">A</a></li>
						<li><a href="#" class="sort-letter" value="B">B</a></li>
						<li><a href="#" class="sort-letter" value="C">C</a></li>
						<li><a href="#" class="sort-letter" value="D">D</a></li>
						<li><a href="#" class="sort-letter" value="E">E</a></li>
						<li><a href="#" class="sort-letter" value="F">F</a></li>
						<li><a href="#" class="sort-letter" value="G">G</a></li>
						<li><a href="#" class="sort-letter" value="H">H</a></li>
						<li><a href="#" class="sort-letter" value="I">I</a></li>
						<li><a href="#" class="sort-letter" value="J">J</a></li>
						<li><a href="#" class="sort-letter" value="K">K</a></li>
						<li><a href="#" class="sort-letter" value="L">L</a></li>
						<li><a href="#" class="sort-letter" value="M">M</a></li>
						<li><a href="#" class="sort-letter" value="N">N</a></li>
						<li><a href="#" class="sort-letter" value="O">O</a></li>
						<li><a href="#" class="sort-letter" value="P">P</a></li>
						<li><a href="#" class="sort-letter" value="Q">Q</a></li>
						<li><a href="#" class="sort-letter" value="R">R</a></li>
						<li><a href="#" class="sort-letter" value="S">S</a></li>
						<li><a href="#" class="sort-letter" value="T">T</a></li>
						<li><a href="#" class="sort-letter" value="U">U</a></li>
						<li><a href="#" class="sort-letter" value="V">V</a></li>
						<li><a href="#" class="sort-letter" value="W">W</a></li>
						<li><a href="#" class="sort-letter" value="X">X</a></li>
						<li><a href="#" class="sort-letter" value="Y">Y</a></li>
						<li><a href="#" class="sort-letter" value="Z">Z</a></li>
					</ul>
			<div id="emp_search_result"></div>

			<div id="emp_search_default">
				<table id="leave-table" padding="0" class="tables employee-list-table">
					
					<tr id="head">
						<th id="right-head">Employee Name</th>
						<th class="heading">Leave Credits</th>
						<th class="heading">Total Leaves</th>
						<th class="heading">Remaining Balance</th>
						<th id="left-head">Department</th>
					</tr>

						<?php foreach ($employee as $employee_list): ?>
							
							
							
							<tr class="items">

								<?php
									$fullname = $this->leaveclass->convert_Big_Ntilde($employee_list['fullname']);
			            			$id = $employee_list['o1_id'];

			            			//query for the leave credits
			            			$credit_for_year = 0;
			            			$credit_balance = 0;
			            			$rem_balance = 0 ;
			            			$wdpay = 0;
			            			$wdopay = 0;
			            			$year = mdate('%Y', time());
			            			$leavecredits = $this->leaves_model->get_leave_credit($id,$year);

			            			//get the leave credit for the current year of the employee
		            				foreach ($leavecredits as $leave_credit) {
		            					$credit_for_year = $leave_credit->credits;
		            					$credit_balance = $leave_credit->balance;

		            				}
		            				$rem_balance = $credit_for_year;


			            			$arrEmployee = $this->leaves_model->get_employee_search_result($id,$year);
			            			if (is_array($arrEmployee)){
			            				foreach ($arrEmployee as $empleave) {
			            				
			            				//get all the leave of the employee
			            					$with_pay = $empleave->w_pay;
			            					$witho_pay = $empleave->wo_pay;
			            					$rem_balance = $rem_balance - $with_pay;
			            					$wdpay = $wdpay + $with_pay;
			            					$wdopay = $wdopay + $witho_pay;

			            				}

			            				//subtract the credit and the leave[with pay] and
			            			}
			            			
			            		?>
								<td align="left" id="left-item"><?php echo anchor('leaves/empleave_summary?id='.$id, $fullname,'title=' . $fullname); ?></td>
								
								<?php
									
				                	if($employee_list['department'] == null){
				                		$employee_list['department'] = "<strong>n/a</strong>";
				                	}
				                	
								?>
								
								<td align="center"><?php echo $credit_for_year ?></td>	
								<td align="center"><?php echo $wdpay + $wdopay ?></td>		
								<td align="center"><?php echo $rem_balance ?></td>	
								
								
								<td align="center" id="left"><?php echo $employee_list['department'] ?></td>
								
							</tr>
							
						<?php endforeach ?>
				</table>
			</div>
		</div>

	</div>