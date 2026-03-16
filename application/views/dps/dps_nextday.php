<input type="hidden" id="is-smd-manager" value = "<?php echo $issmd_man?>">

<div id="main-container-mobile">
		<div id="mobile-nav">
			<h1>JLR - Daily Pouring Schedule</h1>
			<a id="menu-toggle"></a>
			<ul id="mobilemenu">
				<?php if (!$this->functionlist->isCVR($this->lvl)) {?>
					<?php echo anchor('contracts', 'Contract', 'class="mlink"'); ?>				
			    	<?php echo anchor('dps', 'Daily Pouring Schedule', 'class="mlink"'); ?>			    
		        	<?php echo anchor('dps/schedulertoday', 'Scheduler Today', 'class="mlink"'); ?>		        
	            	<?php echo anchor('dps/schedulertom', 'Scheduler Next Day', 'class="mlink"'); ?>
	            	<?php echo anchor('dps/edit_pouring_yesterday', 'View Yesterday Schedule', 'class="mlink"') ;?>	            
	      			<?php echo anchor('dps/edit_pouring_today', 'View Today Schedule', 'class="mlink"'); ?>
	            	<?php echo anchor('dps/next_pouring_sched', 'View Next Day Schedule', 'class="mlink"'); ?>	            
					
				<?php  }else{?>
					<?php echo anchor('dps', 'Daily Pouring Schedule', 'class="mlink"'); ?>	
					<?php echo anchor('dps/dpsNextDay', 'Next Day Schedule', 'class="mlink"'); ?>	
					<?php echo anchor('dps/dpsYesterday', 'Yesterday Schedule', 'class="mlink"'); ?>		          	
				<?php  }?>
				<?php echo anchor('main/logout?requestingpage=mobiledps', 'Log-out', 'class="mlink"') ;?>

			</ul>
		</div>

		<div id="content-wrapper">
			

			<!-- POURING TODAY SCHEDULE MOBILE AND SEMI FLUID -->
			<div id="pouringtoday">
				<div id="title">
					<h2>Next Day's Schedule<br /><span><?php echo date('F d, Y', strtotime('+1 day')) ?></span></h2>
					<p>Total Volume<br /><span><?php echo number_format($mtodaytotal_vol,1) ?> m<sup>3</sup></span></p>
				</div>

				<a href="#" id="todaynorth-but">
					<div id="summary-north">
						<h3>North</h3>
						
						<div class="summary-details">
							<p>Volume : 
								<span style="font-size: 1.2em;"><?php echo $mtodaynorth_vol ?> m<sup>3</sup>
								</span>
							</p>
							<p>Schedules : 
								<span style="font-size: 1.1em;"><?php echo $mtodaynorth_okaycount ?>									
								</span>
							</p>
							<p>Inserts : 
								<span style="font-size: 1.1em;"><?php echo $mtodaynorth_insertcount ?></span>
								<span class="mobile-volume-badge">(<?php echo $mtodaynorth_insertvolume ?> m<sup>3</sup>)
								</span>
							</p>
							<p style="padding-bottom: 10px;">Re-Sched : 
								<span style="font-size: 1.1em;"><?php echo $mtodaynorth_reschedcount ?></span>
								<span class="mobile-volume-badge">(<?php echo $mtodaynorth_reschedvolume ?> m<sup>3</sup>)
								</span>
							</p>
						</div>
						<div class="mobile-aggsum-wrapper">
							<?php echo $today_north_aggsummary; ?>
						</div>
					</div>
				</a>

				<a href="#" id="todaysouth-but">
					<div id="summary-south">
						<h3>South</h3>
						<div class="summary-details">
							<p>Volume : <span style="font-size: 1.2em;"><?php echo $mtodaysouth_vol ?> m<sup>3</sup></span></p>
							<p>Schedules : <span style="font-size: 1.1em;"><?php echo $mtodaysouth_okaycount ?></span></p>
							<p>Inserts : <span style="font-size: 1.1em;"><?php echo $mtodaysouth_insertcount ?></span><span class="mobile-volume-badge">(<?php echo $mtodaysouth_insertvolume ?> m<sup>3</sup>)</span></p>
							<p style="padding-bottom: 10px;">Re-Sched : 
								<span style="font-size: 1.1em;"><?php echo $mtodaysouth_reschedcount ?></span><span class="mobile-volume-badge">(<?php echo $mtodaysouth_reschedvolume ?> m<sup>3</sup>)</span></p>
						</div>
						<div class="mobile-aggsum-wrapper">
							<?php echo $today_south_aggsummary; ?>
						</div>
					</div>
				</a>

				<center>
					<table id="pump-summ-tbl" cellspacing='0'>
						<tr>
							<th>PUMP</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
							<th>6</th>
							<th>7</th>
							<th>8</th>
							<th>9</th> <!-- EDITED WBSOLON JULY 18,2019 NORTH- ADD PUMP9-->

							<th>Total</th>
							<th>Over All</th>
						</tr>
					    
						<tr>
							<td>6AM - 12NN</td>
							<?php echo $pumps1; ?>
							<td align="center" rowspan="4" style="font-size: 1.8em;color: #44b356;font-weight: bold;"><?php echo $today_over_all_pump; ?></td>
						</tr>

						<tr class='even'>
							<td>1PM - 8PM</td>
							<?php echo $pumps2; ?>
						</tr>

						<tr>
							<td>9PM - 12MN</td>
							<?php echo $pumps3; ?>
						</tr>

						<tr>
							<td>1AM - 6AM</td>
							<?php echo $pumps4; ?>
						</tr>

					</table>
				</center>

				
					<div class="mytable-wrapper-north" id="today">

						<!-- display the manager approval notification -->
						<div class="mobile-approve-wrapper">
							<form method="POST" action="dps/mngr_approved">
										<input type="hidden" name="plant" value="Plant 3" />
										<input type="hidden" name="date" value="<?php echo $this->dateNow ?>" />

							<?php
								if(isset($manager_status_north)){
									if ($manager_status_north <= 0){
										//it is approved
										echo "<a class='m-approved'>approved</a>";

									}else{
										//it is not approved
										echo "<a class='m-unapproved'>not yet approved</a>";
							?>									

										<!-- if not approved then show the button 
										echo "<a href='#' class='m-approvalbut'>APPROVED NOW</a>";
										-->

										<?php
											if($this->lvl == '90' OR $this->lvl == '70' OR $this->lvl == '1' OR $this->lvl == '71'){
										?>
											
											<input type="submit" value="APPROVED NOW" class="m-approvalbut"/>
										
							<?php
											}
									}
								}
							?>
						</div>
									

									<div id="table-wrapper-fluid">
										<?php echo $m_today_north ?>
									</div>

									<div id="table-wrapper-fix">
										<?php echo $m_today_northfix ?>
									</div>

								</form>
							

							
					</div>
				
					<div class="mytable-wrapper-south" id="today">
						<!-- display the manager approval notification -->
						<div class="mobile-approve-wrapper">
							<form method="POST" action="dps/mngr_approved">
										<input type="hidden" name="plant" value="Plant 4" />
										<input type="hidden" name="date" value="<?php echo $this->dateNow ?>" />

							<?php 
								if(isset($manager_status_south)){
									if ($manager_status_south <= 0){
										//it is approved
										echo "<a class='m-approved'>approved</a>";
										

									}else{
										//it is not approved
										echo "<a class='m-unapproved'>not yet approved</a>";
							?>									

										<!-- if not approved then show the button 
										echo "<a href='#' class='m-approvalbut'>APPROVED NOW</a>";
										-->

										<?php
											if($this->lvl == '90' OR $this->lvl == '70' OR $this->lvl == '1' OR $this->lvl == '71'){
										?>
											
											<input type="submit" value="APPROVED NOW" class="m-approvalbut"/>
										
							<?php
											}
									}
								}
							?>
						</div>
							
							<div id="table-wrapper-fluid">
								<?php echo $m_today_south ?>
							</div>

							<div id="table-wrapper-fix">
								<?php echo $m_today_southfix ?>
							</div>
						</form>
							
					</div>	
			</div>

			<div id="mobilepouring-div"></div>


			<!-- POURING THE NEXT DAY MOBILE AND SEMI FLUID -->
			<div id="pouringtoday">
				<div id="title">
					<h2>Other Next Day's Schedule<br /><span><?php echo date('F d, Y', strtotime('+2 day')) ?></span></h2>
					<p>Total Volume<br /><span><?php echo number_format($mtomtotal_vol,1) ?> m<sup>3</sup></span></p>
				</div>

				<a href="#" id="tomnorth-but">
					<div id="summary-north">
						<h3>North</h3>
						<div class="summary-details">
							<p>Volume : <span style="font-size: 1.2em;"><?php echo $mtomnorth_vol ?> m<sup>3</sup></span></p>
							<p>Schedules : <span style="font-size: 1.1em;"><?php echo $mtomnorth_okaycount ?></span></p>
							<p>Inserts : <span style="font-size: 1.1em;"><?php echo $mtomnorth_insertcount ?></span><span class="mobile-volume-badge">(<?php echo $mtomnorth_insertvolume ?> m<sup>3</sup>)</span></p>
							<p style="padding-bottom: 10px;">Re-Sched : 
							<span style="font-size: 1.1em;"><?php echo $mtomnorth_reschedcount ?></span><span class="mobile-volume-badge">(<?php echo $mtomnorth_reschedvolume ?> m<sup>3</sup>)</span></p>
						</div>
						<div class="mobile-aggsum-wrapper">
							<?php echo $tom_north_aggsummary; ?>
						</div>
					</div>
				</a>

				<a href="#" id="tomsouth-but">
					<div id="summary-south">
						<h3>South</h3>
						<div class="summary-details">
							<p>Volume : <span style="font-size: 1.2em;"><?php echo $mtomsouth_vol ?> m<sup>3</sup></span></p>
							<p>Schedules : <span style="font-size: 1.1em;"><?php echo $mtomsouth_okaycount ?></span></p>
							<p>Inserts : <span style="font-size: 1.1em;"> <?php echo $mtomsouth_insertcount ?></span><span class="mobile-volume-badge">(<?php echo $mtomsouth_insertvolume ?> m<sup>3</sup>)</span></p>
							<p style="padding-bottom: 10px;">Re-Sched : 
								<span style="font-size: 1.1em;"><?php echo $mtomsouth_reschedcount ?></span><span class="mobile-volume-badge">(<?php echo $mtomsouth_reschedvolume ?> m<sup>3</sup>)</span></p>
						</div>
						<div class="mobile-aggsum-wrapper">
							<?php echo $tom_south_aggsummary; ?>
						</div>
					</div>
				</a>

				<center>
					<table id="pump-summ-tbl" cellspacing='0'>
						<tr>
							<th>PUMP</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
							<th>6</th>
							<th>7</th>
							<th>8</th>
							<th>9</th> <!-- EDITED WBSOLON JULY 18,2019 SOUTH- ADD PUMP9-->
							
							<th>Total</th>
							<th>Over All</th>
							<!-- <td align="center" rowspan="4"><?php echo $total_pump_sched_n ?></td> -->

						</tr>
					    
						<tr>
							<td>6AM - 12NN</td>
							<?php echo $pumps1_tom; ?>
							<td align="center" rowspan="4" style="font-size: 1.8em;color: #44b356;font-weight: bold;"><?php echo $tom_over_all_pump; ?></td>
						</tr>

						<tr class='even'>
							<td>1PM - 8PM</td>
							<?php echo $pumps2_tom; ?>
						</tr>

						<tr>
							<td>9PM - 12MN</td>
							<?php echo $pumps3_tom; ?>
						</tr>

						<tr>
							<td>1AM - 6AM</td>
							<?php echo $pumps4_tom; ?>
							
						</tr>

					</table>
				</center>

				
					<div class="mytable-wrapper-north" id="tom">
						<!-- display the manager approval notification -->
						<div class="mobile-approve-wrapper">
							<form method="POST" action="dps/mngr_approved">
										<input type="hidden" name="plant" value="Plant 3" />
										<input type="hidden" name="date" value="<?php echo $this->dateTom ?>" />

							<?php 
								if(isset($manager_status_north2)){
									if ($manager_status_north2 <= 0){
										//it is approved
										echo "<a class='m-approved'>approved</a>";

									}else{
										//it is not approved
										echo "<a class='m-unapproved'>not yet approved</a>";
							?>									

										<!-- if not approved then show the button 
										echo "<a href='#' class='m-approvalbut'>APPROVED NOW</a>";
										-->

										<?php
											if($this->lvl == '90' OR $this->lvl == '70' OR $this->lvl == '1' OR $this->lvl == '71'){
										?>
											
											<input type="submit" value="APPROVED NOW" class="m-approvalbut"/>
										
							<?php
											}
									}
								}
							?>
						</div>

							
							<div id="table-wrapper-fluid">
								<?php echo $m_tom_north ?>
							</div>

							<div id="table-wrapper-fix">
								<?php echo $m_tom_northfix ?>
							</div>
						</form>
					</div>
				
					<div class="mytable-wrapper-south" id="tom">

						<!-- display the manager approval notification -->
						<div class="mobile-approve-wrapper">
							<form method="POST" action="dps/mngr_approved">
										<input type="hidden" name="plant" value="Plant 4" />
										<input type="hidden" name="date" value="<?php echo $this->dateTom ?>" />

							<?php
								if (isset($manager_status_south2)){
									if ($manager_status_south2 <= 0){
										//it is approved
										echo "<a class='m-approved'>approved</a>";

									}else{
										//it is not approved
										echo "<a class='m-unapproved'>not yet approved</a>";
							?>									

										<!-- if not approved then show the button 
										echo "<a href='#' class='m-approvalbut'>APPROVED NOW</a>";
										-->

										<?php
											if($this->lvl == '90' OR $this->lvl == '70' OR $this->lvl == '1' OR $this->lvl == '71'){
										?>
											
											<input type="submit" value="APPROVED NOW" class="m-approvalbut"/>
										
							<?php
											}
									}
								}
							?>
						</div>

							

							<div id="table-wrapper-fluid">
								<?php echo $m_tom_south ?>
							</div>

							<div id="table-wrapper-fix">
								<?php echo $m_tom_southfix ?>
							</div>
						</form>
					</div>
			</div>
		</div>

		<div id="mfooter">
			<p>Copyright <strong>&copy; 2012</strong> - JLR Construction and Aggregates Inc. - Ralph</p>
		</div>
</div>

<!-- START OF THE FLUID LAYOUT FOR THE DPS DESKTOP LAYOUT -->

<div id="content-fluid">

	
		<!--
			<div id="chat-wrapper">
				<div id="chat-header">
					<p>Online Users : <span id="olusers-count"></span></p>
					<a href="#" id="chat-togglebut">Show</a>
				</div>
				<div id="chat-content-wrapper">
					
					<div id="chat-messages">
					</div>

					<div id="chat-online-wrapper">
					</div>
					
					<input type="text" id="message-box" placeholder="type"/>
					<input type="hidden" id="chat-username" value="<?php echo $chatname ?>" />
				</div>
			</div>
		-->


	<?php
		//date tomorrow
		//$tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
		//$dateTom = date("Y-m-d", $tomorrow);


		//for accounting,plant supervisor,qc
		if(isset($notify_today) AND $notify_today > 0){
			echo "<div class='dpspanel-notification'><span>TODAY</span>: ". $notify_msg . $notify_today ." booking(s) awaiting for your approval. <a href='dps/edit_pouring_today'>see it here</a></div>";
		}

		if(isset($notify_tomorrow) AND $notify_tomorrow > 0){
			echo "<div class='dpspanel-notification'><span>TOMORROW</span>: " . $notify_msg . $notify_tomorrow . " booking(s) awaiting for your approval. <a href='dps/next_pouring_sched'>see it here</a></div>";
		}

		//for smd manager,coordinator
		if(isset($notify_today_smd) AND $notify_today_smd > 0){
			echo "<div class='dpspanel-notification'><span>TODAY</span>: ". $notify_msg . $notify_today_smd ." booking(s) awaiting for your approval. <a href='dps/schedulertoday'>see it here</a></div>";
		}

		if(isset($notify_tomorrow_smd) AND $notify_tomorrow_smd > 0){
			echo "<div class='dpspanel-notification'><span>TOMORROW</span>: " . $notify_msg . $notify_tomorrow_smd . " booking(s) awaiting for your approval. <a href='dps/schedulertom'>see it here</a></div>";
		}

		
	?>

		<!-- <div class='upnotify'>
			<span>DPS UPDATE [9-29-2015 02:50pm]:</span>
			<br /><br />
			<li>[SMD] - Added 3days/SPARE/BEAM option for QC Laboratory in Form1(Testing Schedule/Sampling Procedure).</li>
			<li>[Coordinator] - Added information checker in Maintenace->Designs to eliminate blank Structures/Wrong Strengths.</li>
			<br />
			If you encounter any problem after this update, please contact IT immediately, Thank you.
		</div> -->

	<div id="display-icons">
		<a href="#" id="display-switcher"><i class="fa fa-th fa-lg"></i></a>
	</div>

	<div id="weekly-sched-container">
		<!-- display the weekly schedules here via an iframe -->
		<div class="container" id="week-sched">
			<div class="weekly-sched-row">
				<div class="column left first" id="cont-1">
					<div class="weekly-wrapper">
						<h3 class="weekly-date">
							<?php 
								$date = date_create($sched_date[1]);
								echo date_format($date, 'l');
							?>
							<span>
								<?php 
								$date = date_create($sched_date[1]);
								echo date_format($date, 'F d, Y');
								?>
							</span>
						</h3>
						<a href="#" class="lock-button <?php echo $lock_class ?>" id="day1"><i class="fa fa-unlock-alt"></i></a>
						
						<a href="" class="waiting-button <?php echo $waiting_class ?>" id="day1"><i class="fa fa-list"></i></a>
						<input type="hidden" class="sched-date" value="<?php echo $sched_date[1] ?>">
					</div>
					

					<div id="day1" class="weekly-totals">
			            <p><span class="text">Total Vol. (<i class="tot-cnt total-rows"><?php echo $total_rows[1] ?></i>)</span><span class="cnt total-vol"><?php echo $total_volume[1] ?></span></p>
			            <p><span class="text">North (<i class="tot-cnt total-north"><?php echo $total_north_rows[1] ?></i>)</span><span class="cnt total-north-vol"><?php echo $total_north[1] ?></span></p>
			            <p><span class="text">South (<i class="tot-cnt total-south"><?php echo $total_south_rows[1] ?></i>)</span><span class="cnt total-south-vol"><?php echo $total_south[1] ?></span></p>

					</div>
					<div class="sales-code-legend">
						<span class="north">NORTH</span>
						<span class="south">SOUTH</span>
						<span class="m3">M3</span>
						<span class="m4">M4</span>
						<span class="m5">M5</span>
						<span class="m6">M6</span>
						<span class="m8">M8</span>
					</div>

					<ul class="sortable-list" id="day1">

						<?php
							$res_count = count($scheds1);

							if($res_count > 0){
								
								foreach ($scheds1 as $row)
					            {
					               $sched_id =  $row['o202_id'];
					               $proj_id =  $row['project_id'];
					               $proj_name =  $row['proj_name'];
					               $cust_name =  $row['cust_name'];
					               $proj_address =  $row['proj_address'];
					               $proj_sales_rep =  $row['special_se'];
					               $plant =  $row['batching_plant'];
					               $sched_time =  $row['modified_time'];
					               $formno =  '<i class="formno">'.$row['form_type'] . ' ' . $row['form_no'].'</i>' ;
					               
					               $vol =  $row['batch_vol'];

					               

					               switch ($plant) {
					               	case 'Plant 3':
					               		$plant_class = 'north-plant';
					               		$batching_plant = 'north';
					               		break;
					               	case 'Plant 4':
					               		$plant_class = 'south-plant';
					               		$batching_plant = 'south';
					               		break;
					               }
					    ?>

					               <li class="dropdown" id="<?php echo $sched_id ?>">
					               	<span class="sales-code-marker <?php echo strtolower($proj_sales_rep) ?>"></span>
					               	<input type="hidden" id="vol" class="<?php echo $batching_plant ?>" value="<?php echo $vol ?>">
								     <a href="#" class="sched-cont project-dropdown" data-toggle="dropdown" id="<?php echo $proj_id ?>">
								     	
								     	<div class="sched-wrapper">
								     		<?php echo $cust_name ?>
									     	<span><?php echo $proj_name ?></span>
									     	<span><?php echo $proj_address . ' - ' . $sched_time . ' - ' . $formno ?></span>
								     	</div>
								     	
								     	
							     		<span class="sched-vol-wrapper <?php echo $plant_class ?>">
							     			<i class="sched-vol"><?php echo $vol ?></i>
							     		</span>
								     	
								     </a>
								   </li>
						<?php
					            }
					            


							}else{
								echo "<center>No Schedules</center>";
							}
						?> 
					</ul>
				</div>

				<div class="column left" id="cont-2">
					<div class="weekly-wrapper">
						<h3 class="weekly-date">
							<?php 
								$date = date_create($sched_date[2]);
								echo date_format($date, 'l');
							
							?>
							<span>
								<?php 
								$date = date_create($sched_date[2]);
								echo date_format($date, 'F d, Y');
								?>
							</span>
						</h3>
						<a href="#" class="lock-button <?php echo $lock_class ?>" id="day2"><i class="fa fa-unlock-alt"></i></a>
						
						<a href="" class="waiting-button <?php echo $waiting_class ?>"><i class="fa fa-list"></i></a>
						<input type="hidden" class="sched-date" value="<?php echo $sched_date[2] ?>">
					</div>
					
					<div id="day2" class="weekly-totals">
			            <p><span class="text">Total Vol. (<i class="tot-cnt total-rows"><?php echo $total_rows[2] ?></i>)</span><span class="cnt total-vol"><?php echo $total_volume[2] ?></span></p>
			            <p><span class="text">North (<i class="tot-cnt total-north"><?php echo $total_north_rows[2] ?></i>)</span><span class="cnt total-north-vol"><?php echo $total_north[2] ?></span></p>
			            <p><span class="text">South (<i class="tot-cnt total-south"><?php echo $total_south_rows[2] ?></i>)</span><span class="cnt total-south-vol"><?php echo $total_south[2] ?></span></p>

					</div>
					<div class="sales-code-legend">
						<span class="north">NORTH</span>
						<span class="south">SOUTH</span>
						<span class="m3">M3</span>
						<span class="m4">M4</span>
						<span class="m5">M5</span>
						<span class="m6">M6</span>
						<span class="m8">M8</span>
					</div>

					<ul class="sortable-list" id="day2">

						<?php
							$res_count = count($scheds2);
							if($res_count > 0){
								
								foreach ($scheds2 as $row)
					            {
					               $sched_id =  $row['o202_id'];
					               $proj_id =  $row['project_id'];
					               $proj_name =  $row['proj_name'];
					               $cust_name =  $row['cust_name'];
					               $proj_address =  $row['proj_address'];
					               $proj_sales_rep =  $row['special_se'];
					               $plant =  $row['batching_plant'];
					               $sched_time =  $row['modified_time'];
					               $formno =  '<i class="formno">'.$row['form_type'] . ' ' . $row['form_no'].'</i>' ;
					               
					               $vol =  $row['batch_vol'];


					               switch ($plant) {
					               	case 'Plant 3':
					               		$plant_class = 'north-plant';
					               		$batching_plant = 'north';
					               		break;
					               	case 'Plant 4':
					               		$plant_class = 'south-plant';
					               		$batching_plant = 'south';
					               		break;
					               }
					    ?>

					               <li class="dropdown" id="<?php echo $sched_id ?>">
					               	<span class="sales-code-marker <?php echo strtolower($proj_sales_rep) ?>"></span>
					               	<input type="hidden" id="vol" class="<?php echo $batching_plant ?>" value="<?php echo $vol ?>">
								     <a href="#" class="sched-cont project-dropdown" data-toggle="dropdown" id="<?php echo $proj_id ?>">
								     	
								     	<div class="sched-wrapper">
								     		<?php echo $cust_name ?>
									     	<span><?php echo $proj_name ?></span>
									     	<span><?php echo $proj_address . ' - ' . $sched_time . ' - ' . $formno ?></span>
								     	</div>
								     	
								     	
							     		<span class="sched-vol-wrapper <?php echo $plant_class ?>">
							     			<i class="sched-vol"><?php echo $vol ?></i>
							     		</span>
								     	
								     </a>
								   </li>
						<?php
					            }


							}else{
								echo "<center>No Schedules</center>";
							}
						?> 
					</ul>
				</div>

				<div class="column left" id="cont-3">
					<div class="weekly-wrapper">
						<h3 class="weekly-date">
							<?php 
								$date = date_create($sched_date[3]);
								echo date_format($date, 'l');
							
							?>
							<span>
								<?php 
								$date = date_create($sched_date[3]);
								echo date_format($date, 'F d, Y');
								?>
							</span>
						</h3>
						<a href="#" class="lock-button <?php echo $lock_class ?>" id="day3"><i class="fa fa-unlock-alt"></i></a>
						
						<a href="" class="waiting-button <?php echo $waiting_class ?>"><i class="fa fa-list"></i></a>
						<input type="hidden" class="sched-date" value="<?php echo $sched_date[3] ?>">
					</div>
					

					<div id="day3" class="weekly-totals">
			            <p><span class="text">Total Vol. (<i class="tot-cnt total-rows"><?php echo $total_rows[3] ?></i>)</span><span class="cnt total-vol"><?php echo $total_volume[3] ?></span></p>
			            <p><span class="text">North (<i class="tot-cnt total-north"><?php echo $total_north_rows[3] ?></i>)</span><span class="cnt total-north-vol"><?php echo $total_north[3] ?></span></p>
			            <p><span class="text">South (<i class="tot-cnt total-south"><?php echo $total_south_rows[3] ?></i>)</span><span class="cnt total-south-vol"><?php echo $total_south[3] ?></span></p>

					</div>
					<div class="sales-code-legend">
						<span class="north">NORTH</span>
						<span class="south">SOUTH</span>
						<span class="m3">M3</span>
						<span class="m4">M4</span>
						<span class="m5">M5</span>
						<span class="m6">M6</span>
						<span class="m8">M8</span>
					</div>

					<ul class="sortable-list" id="day3">

						<?php
							$res_count = count($scheds3);
							if($res_count > 0){
								
								foreach ($scheds3 as $row)
					            {
					               $sched_id =  $row['o202_id'];
					               $proj_id =  $row['project_id'];
					               $proj_name =  $row['proj_name'];
					               $cust_name =  $row['cust_name'];
					               $proj_address =  $row['proj_address'];
					               $proj_sales_rep =  $row['special_se'];
					               $plant =  $row['batching_plant'];
					               $sched_time =  $row['modified_time'];
					               $formno =  '<i class="formno">'.$row['form_type'] . ' ' . $row['form_no'].'</i>' ;
					               
					               $vol =  $row['batch_vol'];


					               switch ($plant) {
					               	case 'Plant 3':
					               		$plant_class = 'north-plant';
					               		$batching_plant = 'north';
					               		break;
					               	case 'Plant 4':
					               		$plant_class = 'south-plant';
					               		$batching_plant = 'south';
					               		break;
					               }
					    ?>

					               <li class="dropdown" id="<?php echo $sched_id ?>">
					               	<span class="sales-code-marker <?php echo strtolower($proj_sales_rep) ?>"></span>
					               	<input type="hidden" id="vol" class="<?php echo $batching_plant ?>" value="<?php echo $vol ?>">
								     <a href="#" class="sched-cont project-dropdown" data-toggle="dropdown" id="<?php echo $proj_id ?>">
								     	
								     	<div class="sched-wrapper">
								     		<?php echo $cust_name ?>
									     	<span><?php echo $proj_name ?></span>
									     	<span><?php echo $proj_address . ' - ' . $sched_time . ' - ' . $formno ?></span>
								     	</div>
								     	
								     	
							     		<span class="sched-vol-wrapper <?php echo $plant_class ?>">
							     			<i class="sched-vol"><?php echo $vol ?></i>
							     		</span>
								     	
								     </a>
								   </li>
						<?php
					            }


							}else{
								echo "<center>No Schedules</center>";
							}
						?> 
					</ul>
				</div>
			</div>
				
			<div class="weekly-sched-row">
				<div class="column left first" id="cont-4">
					<div class="weekly-wrapper">
						<h3 class="weekly-date">
							<?php 
								$date = date_create($sched_date[4]);
								echo date_format($date, 'l');
							
							?>
							<span>
								<?php 
								$date = date_create($sched_date[4]);
								echo date_format($date, 'F d, Y');
								?>
							</span>
						</h3>
						<a href="#" class="lock-button <?php echo $lock_class ?>" id="day4"><i class="fa fa-unlock-alt"></i></a>
						
						<a href="" class="waiting-button <?php echo $waiting_class ?>"><i class="fa fa-list"></i></a>
						<input type="hidden" class="sched-date" value="<?php echo $sched_date[4] ?>">
					</div>
					

					<div id="day4" class="weekly-totals">
			            <p><span class="text">Total Vol. (<i class="tot-cnt total-rows"><?php echo $total_rows[4] ?></i>)</span><span class="cnt total-vol"><?php echo $total_volume[4] ?></span></p>
			            <p><span class="text">North (<i class="tot-cnt total-north"><?php echo $total_north_rows[4] ?></i>)</span><span class="cnt total-north-vol"><?php echo $total_north[4] ?></span></p>
			            <p><span class="text">South (<i class="tot-cnt total-south"><?php echo $total_south_rows[4] ?></i>)</span><span class="cnt total-south-vol"><?php echo $total_south[4] ?></span></p>

					</div>
					<div class="sales-code-legend">
						<span class="north">NORTH</span>
						<span class="south">SOUTH</span>
						<span class="m3">M3</span>
						<span class="m4">M4</span>
						<span class="m5">M5</span>
						<span class="m6">M6</span>
						<span class="m8">M8</span>
					</div>

					<ul class="sortable-list" id="day4">

						<?php
							$res_count = count($scheds4);
							if($res_count > 0){
								
								foreach ($scheds4 as $row)
					            {
					               $sched_id =  $row['o202_id'];
					               $proj_id =  $row['project_id'];
					               $proj_name =  $row['proj_name'];
					               $cust_name =  $row['cust_name'];
					               $proj_address =  $row['proj_address'];
					               $proj_sales_rep =  $row['special_se'];
					               $plant =  $row['batching_plant'];
					               $sched_time =  $row['modified_time'];
					               $formno =  '<i class="formno">'.$row['form_type'] . ' ' . $row['form_no'].'</i>' ;
					               
					               $vol =  $row['batch_vol'];


					               switch ($plant) {
					               	case 'Plant 3':
					               		$plant_class = 'north-plant';
					               		$batching_plant = 'north';
					               		break;
					               	case 'Plant 4':
					               		$plant_class = 'south-plant';
					               		$batching_plant = 'south';
					               		break;
					               }
					    ?>

					               <li class="dropdown" id="<?php echo $sched_id ?>">
					               	<span class="sales-code-marker <?php echo strtolower($proj_sales_rep) ?>"></span>
					               	<input type="hidden" id="vol" class="<?php echo $batching_plant ?>" value="<?php echo $vol ?>">
								     <a href="#" class="sched-cont project-dropdown" data-toggle="dropdown" id="<?php echo $proj_id ?>">
								     	
								     	<div class="sched-wrapper">
								     		<?php echo $cust_name ?>
									     	<span><?php echo $proj_name ?></span>
									     	<span><?php echo $proj_address . ' - ' . $sched_time . ' - ' . $formno ?></span>
								     	</div>
								     	
								     	
							     		<span class="sched-vol-wrapper <?php echo $plant_class ?>">
							     			<i class="sched-vol"><?php echo $vol ?></i>
							     		</span>
								     	
								     </a>
								   </li>
						<?php
					            }


							}else{
								echo "<center>No Schedules</center>";
							}
						?> 
					</ul>
				</div>

				<div class="column left" id="cont-5">
					<div class="weekly-wrapper">
						<h3 class="weekly-date">
							<?php 
								$date = date_create($sched_date[5]);
								echo date_format($date, 'l');
							
							?>
							<span>
								<?php 
								$date = date_create($sched_date[5]);
								echo date_format($date, 'F d, Y');
								?>
							</span>
						</h3>
						<a href="#" class="lock-button <?php echo $lock_class ?>" id="day5"><i class="fa fa-unlock-alt"></i></a>
						
						<a href="" class="waiting-button <?php echo $waiting_class ?>"><i class="fa fa-list"></i></a>
						<input type="hidden" class="sched-date" value="<?php echo $sched_date[5] ?>">
					</div>
					

					<div id="day5" class="weekly-totals">
			            <p><span class="text">Total Vol. (<i class="tot-cnt total-rows"><?php echo $total_rows[5] ?></i>)</span><span class="cnt total-vol"><?php echo $total_volume[5] ?></span></p>
			            <p><span class="text">North (<i class="tot-cnt total-north"><?php echo $total_north_rows[5] ?></i>)</span><span class="cnt total-north-vol"><?php echo $total_north[5] ?></span></p>
			            <p><span class="text">South (<i class="tot-cnt total-south"><?php echo $total_south_rows[5] ?></i>)</span><span class="cnt total-south-vol"><?php echo $total_south[5] ?></span></p>

					</div>
					<div class="sales-code-legend">
						<span class="north">NORTH</span>
						<span class="south">SOUTH</span>
						<span class="m3">M3</span>
						<span class="m4">M4</span>
						<span class="m5">M5</span>
						<span class="m6">M6</span>
						<span class="m8">M8</span>
					</div>

					<ul class="sortable-list" id="day5">

						<?php
							$res_count = count($scheds5);
							if($res_count > 0){
								
								foreach ($scheds5 as $row)
					            {
					               $sched_id =  $row['o202_id'];
					               $proj_id =  $row['project_id'];
					               $proj_name =  $row['proj_name'];
					               $cust_name =  $row['cust_name'];
					               $proj_address =  $row['proj_address'];
					               $proj_sales_rep =  $row['special_se'];
					               $plant =  $row['batching_plant'];
					               $sched_time =  $row['modified_time'];
					               $formno =  '<i class="formno">'.$row['form_type'] . ' ' . $row['form_no'].'</i>' ;
					               
					               $vol =  $row['batch_vol'];


					               switch ($plant) {
					               	case 'Plant 3':
					               		$plant_class = 'north-plant';
					               		$batching_plant = 'north';
					               		break;
					               	case 'Plant 4':
					               		$plant_class = 'south-plant';
					               		$batching_plant = 'south';
					               		break;
					               }
					    ?>

					               <li class="dropdown" id="<?php echo $sched_id ?>">
					               	<span class="sales-code-marker <?php echo strtolower($proj_sales_rep) ?>"></span>
					               	<input type="hidden" id="vol" class="<?php echo $batching_plant ?>" value="<?php echo $vol ?>">
								     <a href="#" class="sched-cont project-dropdown" data-toggle="dropdown" id="<?php echo $proj_id ?>">
								     	
								     	<div class="sched-wrapper">
								     		<?php echo $cust_name ?>
									     	<span><?php echo $proj_name ?></span>
									     	<span><?php echo $proj_address . ' - ' . $sched_time . ' - ' . $formno ?></span>
								     	</div>
								     	
								     	
							     		<span class="sched-vol-wrapper <?php echo $plant_class ?>">
							     			<i class="sched-vol"><?php echo $vol ?></i>
							     		</span>
								     	
								     </a>
								   </li>
						<?php
					            }


							}else{
								echo "<center>No Schedules</center>";
							}
						?> 
					</ul>
				</div>
			</div>
		</div>
	</div>








	<div id="daily-sched-container">
		<!-- display the table layout here (the old dps table) -->
		<!-- DISPLAY TODAY'S BOOKING -->
		<div class="dps-index">

			<center>
				<h1 class="head">Current Pouring Schedule</h1>
				<p class="title-date">Details of the Scheduled Pourings for <?php echo date("F d, Y") ?></p>
			</center>

			

			<?php
				if (isset($manager_status_north)){
					if($manager_status_north <= 0 ){
						echo "<a class='managerapprove'>approved</a>";
						$this->isHaveCount = 'no';
						//echo "<a href='#' class='index-importbut' id='todaynorth-import' >Import</a>";
					}else{
						echo "<a class='blink'>not yet approved</a>";
						$this->isHaveCount = 'yes';
					}
				}else{
					$this->isHaveCount = 'no';
				}
			?>

				<form method="POST" action="dps/mngr_approved">
					<input type="hidden" name="plant" value="Plant 3" />
					<input type="hidden" name="date" value="<?php echo $this->dateNow ?>" />
					<?php echo $dps_today_north ?>
					<?php echo $dps_today_north_insert ?>
					</table>
					<?php
						if($this->isHaveCount == 'yes' AND ($this->lvl == '90' OR $this->lvl == '70' OR $this->lvl == '1' OR $this->lvl == '71')){
					?>
						<div id="manager-approved-wrapper">
							<center><input type="submit" value="APPROVED SCHEDULES FOR TODAY" class="searchbutton managerapproved-but"/></center>
						</div>
					<?php
						}
					?>
				</form>

			<?php
				if($volume_today_north != 0){
					echo "<center><h2>Total Volume: " . $volume_today_north . " m<sup>3</sup></h2></center>";
				}
			?>

			<br /><br />

			<?php
				if (isset($manager_status_south)){
					if($manager_status_south <= 0 ){
						echo "<a class='managerapprove'>approved</a>";
						//echo $manager_status_south;
						$this->isHaveCount = 'no';
						//echo "<a href='#' class='index-importbut' >Import</a>";
					}else{
						echo "<a class='blink'>not yet approved</a>";
						$this->isHaveCount = 'yes';
					}
				}else{
					$this->isHaveCount = 'no';
				}
			?>

				<form method="POST" action="dps/mngr_approved">
					<input type="hidden" name="plant" value="Plant 4" />
					<input type="hidden" name="date" value="<?php echo $this->dateNow ?>" />
					<?php echo $dps_today_south ?>
					<?php echo $dps_today_south_insert ?>
					</table>
					<?php
						if($this->isHaveCount == 'yes' AND ($this->lvl == '90' OR $this->lvl == '70' OR $this->lvl == '1' OR $this->lvl == '71')){
					?>
						<div id="manager-approved-wrapper">
							<center><input type="submit" value="APPROVED SCHEDULES FOR TODAY" class="searchbutton managerapproved-but"/></center>
						</div>
					<?php
						}
					?>
				</form>
			<?php
				if($volume_today_south != 0){
					echo "<center><h2>Total Volume: " . $volume_today_south . " m<sup>3</sup></h2><center>";
				}
			?>


			<br /><br />


			<!-- CONFIRMATION TABLE - - - - - - - - -
			|
			|
			|
			-->
			<?php echo $dps_today_forconfirm ?>
			</table>
			<?php
				if($volume_today_forconfirm != 0){
					echo "<center><h2>Total Volume: " . $volume_today_forconfirm . " m<sup>3</sup></h2><center>";
				}
			?>
		</div>

		<!-- NEXT DAY BOOKINGS START HERE -->
		<div class="dps-index">
			<div id="datejump">
				<label>Select Date : </label><input type="text" name="pouring-selectdate" id="selected-pouringdate"/>
				<a href="" id="nextpouring-jumpdate">Search</a>
			</div>
			
			

			<div id="ajax-content">
				<center>
					<h1 class="head">Pouring Schedule for (<?php echo $dateTom ?>)</h1>
					<p class="title-date">Details of the Scheduled Pourings for <?php echo date("F d, Y", $dateTom2) ?></p>
				</center>
				<!-- DISPLAY TOMORROW'S BOOKING -->


				<?php
					if (isset($manager_status_north2)){
						if($manager_status_north2 <= 0 ){
							echo "<a class='managerapprove'>approved</a>";
							$this->isHaveCount = 'no';
						}else{
							echo "<a class='blink'>not yet approved</a>";
							$this->isHaveCount = 'yes';
						}
					}else{
						$this->isHaveCount = 'no';
					}
				?>

				<form method="POST" action="dps/mngr_approved">
					<input type="hidden" name="plant" value="Plant 3" />
					<input type="hidden" name="date" value="<?php echo $this->dateTom ?>" />
					<?php echo $dps_tom_north ?>
					<?php echo $dps_tom_north_insert ?>
					</table>
					<?php
						if($this->isHaveCount == 'yes' AND ($this->lvl == '90' OR $this->lvl == '70' OR $this->lvl == '1' OR $this->lvl == '71')){
					?>
						<div id="manager-approved-wrapper">
							<center><input type="submit" value="APPROVED SCHEDULES FOR TODAY" class="searchbutton managerapproved-but"/></center>
						</div>
					<?php
						}
					?>
				</form>

				<?php
					if($volume_tom_north != 0){
						echo "<center><h2>Total Volume: " . $volume_tom_north . " m<sup>3</sup></h2></center>";
					}
				?>

				<br /><br />

				<?php
					if (isset($manager_status_south2)){
						if($manager_status_south2 <= 0 ){
							echo "<a class='managerapprove'>approved</a>";
							$this->isHaveCount = 'no';
						}else{
							echo "<a class='blink'>not yet approved</a>";
							$this->isHaveCount = 'yes';
						}
					}else{
						$this->isHaveCount = 'no';
					}
				?>

				<form method="POST" action="dps/mngr_approved">
					<input type="hidden" name="plant" value="Plant 4" />
					<input type="hidden" name="date" value="<?php echo $this->dateTom ?>" />
					<?php echo $dps_tom_south ?>
					<?php echo $dps_tom_south_insert ?>
					</table>
					<?php
						if($this->isHaveCount == 'yes' AND ($this->lvl == '90' OR $this->lvl == '70' OR $this->lvl == '1' OR $this->lvl == '71')){
					?>
						<div id="manager-approved-wrapper">
							<center><input type="submit" value="APPROVED SCHEDULES FOR TODAY" class="searchbutton managerapproved-but"/></center>
						</div>
					<?php
						} 
					?>
				</form>

				<?php
					if($volume_tom_south != 0){
						echo "<center><h2>Total Volume: " . $volume_tom_south . " m<sup>3</sup></h2><center>";
					}
				?>

				<br /><br />

				<?php echo $dps_tom_forconfirm ?>
				</table>
				<?php
					if($volume_tom_forconfirm != 0){
						echo "<center><h2>Total Volume: " . $volume_tom_forconfirm . " m<sup>3</sup></h2><center>";
					}
				?>
			</div>
		</div>
	</div>
		
</div>