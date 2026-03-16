
	<div id="content" class="grid-940">
		<a href="leaves/leave_reports" id="leave-report" class="noprint">Leave Report</a>
		<div class="content-body">
			
			
			<!-- <a id="approve-pending" class="fancybox.iframe" href="leaves/approve_pending">Approve Pending Leaves</a> -->
			<h3>Currently On-leave Employees - <span>Count : <?php echo $onleave_count ?></span><br /><p id="onleavedate">As of : <?php echo date("F d, Y") ?></p></h3>

			<p id="onleave-reptgen">Report Generated : <?php echo date("F d, Y") ?></p>
			
			<?php
				if ($onleave_count <= 0){
					//display an error message
					echo "<div class='error-notify'><p>There is no record of employees that are currently on leave.</p></div>";
				}
				else{
					//display the table
					?>
						<table id="leave-table" class="tables">

							<tr id="head">
								<th id="right-head">Name</th>
								<th class="heading">Reason</th>
								<th class="heading">Duration(day)</th>
								<th class="heading">Date From</th>
								<th class="heading">Date To</th>
								<th class="heading">Hours</th>
								<th id="left-head">Type</th>
							</tr>

								<?php foreach ($onleave as $leave): ?>
									
									
									<tr class="items">
										<?php
											$fullname = $this->leaveclass->convert_Big_Ntilde($leave['fullname']);
					            			//$lastname = $this->leaveclass->convert_Big_Ntilde($leave['lastname']);
					            			
										?>


										<td align="left" id="left-item"><?php echo $fullname ?></td>
										<?php
											$withpay = $leave['w_pay'];
											$withoutpay = $leave['wo_pay'];
											
											if ($withpay == '' && $withoutpay == ''){
												$duration = 'n/a';
											}
											else{
												$duration = ($withpay + $withoutpay);
											}

											
										?>

										<td align="center"><?php echo $leave['reason'] ?></td>

										<td align="center"><?php echo $duration ?></td>	
										
										<?php
											$datefrom = strtotime($leave['inclusive_from']);
											$conv_datefrom = date("F d, Y", $datefrom);
										?>
										<td align="center"><?php echo $conv_datefrom ?></td>

										<?php
											$dateto = strtotime($leave['inclusive_to']);
											$conv_dateto = date("F d, Y", $dateto);
										?>
										<td align="center"><?php echo $conv_dateto ?></td>

										
										
										<?php
											//check if the leave type is undertime if yes then get the amount 
											if($leave['leave_type'] == 'undertime'){
												$hours = $leave['hours'];
											}
											else{
												$hours = "n/a";
											}
												
										?>
										<td align="center"><?php echo $hours ?></td>
										<td align="center" id="left"><?php echo $leave['leave_type'] ?></td>
									</tr>

								<?php endforeach ?>
						</table>

					<?php
				}
			?>


			
		</div>
				
		

	</div>