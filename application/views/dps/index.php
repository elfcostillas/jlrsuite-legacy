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
					<h2>Today's Schedule<br /><span><?php echo date("F d, Y") ?></span></h2>
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
							<th>10</th> <!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->
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
					<h2>Next Day's Schedule<br /><span><?php echo date("F d, Y", $dateTom2) ?></span></h2>
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
							<th>10</th> <!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->
							
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
						<span class="m3">RML</span>
						<span class="m4">CTL</span>
						<span class="m5">NBA</span>
						<span class="m6">APJ</span>
						<span class="m7">JTA</span>
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
						<span class="m3">RML</span>
						<span class="m4">CTL</span>
						<span class="m5">NBA</span>
						<span class="m6">APJ</span>
						<span class="m7">JTA</span>
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
						<span class="m3">RML</span>
						<span class="m4">CTL</span>
						<span class="m5">NBA</span>
						<span class="m6">APJ</span>
						<span class="m7">JTA</span>
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
						<span class="m3">RML</span>
						<span class="m4">CTL</span>
						<span class="m5">NBA</span>
						<span class="m6">APJ</span>
						<span class="m7">JTA</span>
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
						<span class="m3">RML</span>
						<span class="m4">CTL</span>
						<span class="m5">NBA</span>
						<span class="m6">APJ</span>
						<span class="m7">JTA</span>
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


		<script type="text/javascript">
			$(document).ready(function(){
				
				// $('.lol').qtip({
				// 	content: 'test qtip'
				// });
				// Get items
				/*function getGroupItems(group){
					
					var cnt = 0;
			        var id_arr = [];

					$(group + " > li").each(function() {
			            $this = $(this);

			            //get id
			            var ids = $this.attr('id');
			            //var ids = $this.text();
			            //var id_split = ids.split('-');

			            id_arr[cnt] = ids;

			            cnt ++;

			          
			        });

					alert(id_arr);
					console.log(id_arr);
			       
				}
					*/
				function getTotalVolumes(group){
					var cnt = 0;
			        var volume_cnt = 0;

					$(group + "> li > a > span > i").each(function() {
			            $this = $(this);
			            var vol = parseFloat($this.text());
			            volume_cnt = volume_cnt + vol;
			        });

					return volume_cnt;
				}

				function getRecordCount(group){
					var cnt = 0;

					$(group + "> li").each(function() {
			            cnt ++;
			        });

					return cnt;
				}
				function getNorthCount(group){
					var cnt = 0;

					$(group + "> li > input#vol").filter('.north').each(function() {
			            cnt ++;
			        });

					return cnt;
				}
				function getSouthCount(group){
					var cnt = 0;

					$(group + "> li > input#vol").filter('.south').each(function() {
			            cnt ++;
			        });

					return cnt;
				}

				function getTotalNorthVolumes(group){
			        var volume_cnt = 0;
					$(group + "> li > input#vol").filter('.north').each(function() {
			            $this = $(this);
			            	var vol = parseFloat($this.val());
			            	volume_cnt = volume_cnt + vol;
			        });

					return volume_cnt;
				}

				function getTotalSouthVolumes(group){
			        var volume_cnt = 0;
					$(group + "> li > input#vol").filter('.south').each(function() {
			            $this = $(this);
			            	var vol = parseFloat($this.val());
			            	volume_cnt = volume_cnt + vol;
			        });

					return volume_cnt;
				}
				

				//lock all
				//$('#week-sched .sortable-list').sortable("disable");
				//var lol = $('#week-sched .sortable-list').sortable("destroy");
				if ($('#week-sched .sortable-list').data( "ui-sortable" )){ 
					$('#week-sched .sortable-list').sortable("destroy"); 
				}

				$('.lock-button').mouseover(function(){
					var but_caption = $(this).children('i').hasClass('fa-lock');
					// if(but_caption == true){
					// 	$(this).qtip({
					// 		content: '[UNLOCK] - Click to Lock.'
					// 	});
					// }else{
					// 	$(this).qtip({
					// 		content: '[LOCK] - Click to Unlock.'
					// 	});
					// }
					console.log()
				});

				//test only
				$('.waiting-button').mouseover(function(){
					$('.waiting-button').qtip({
						content: 'Click to view the waiting list.'
					});
					console.log('1');		
				});

				

				$('.lock-button').click(function(){
					var but_caption = $(this).children('i').hasClass('fa-lock');
					var sort_container = $(this).attr('id');
					var sched_date = $(this).next().next('.sched-date').val();
					var main_group = $(this).parent().parent().parent().attr('id');

					
					
					if(but_caption == true){ //if lock icon
						
						//it means that the user wants to edit the state of the container
						//$('#'+sort_container+'.sortable-list').sortable("disable");
						$('#'+sort_container+'.sortable-list').sortable("destroy");
						$(this).children('i').removeClass('fa-lock').addClass('fa-unlock-alt');
						
						//it means that the user wants to save the state of the container and locked it

						//get the id's of the scheds

						var sched_ids = getSchedIds('#'+sort_container);
						
						// // //ajax update the result
						$.ajax({
			             type: "POST",
			             url: "dps/ajax_update_weekly_sched",
			             data: "sched-ids="+sched_ids+"&sched-date="+sched_date,
			             dataType: "json",
			             cache:false,
			             success:
			                  function(data){
			                  	//msg for success here
			                  }
			            });

						$(this).next('.waiting-button').click();

					}else{

						
						$('#'+sort_container+'.sortable-list').sortable({
							connectWith: '#week-sched .sortable-list',
							update: function(event, ui) {
					        	$('div#day1 > p > span.total-vol').text(getTotalVolumes('#day1'));
					        	$('div#day1 > p > span.total-north-vol').text(getTotalNorthVolumes('#day1'));
					        	$('div#day1 > p > span.total-south-vol').text(getTotalSouthVolumes('#day1'));
					        	$('div#day1 > p > span > i.total-rows').text(getRecordCount('#day1'));
					        	$('div#day1 > p > span > i.total-north').text(getNorthCount('#day1'));
					        	$('div#day1 > p > span > i.total-south').text(getSouthCount('#day1'));

					        	
					        	$('div#day2 > p > span.total-vol').text(getTotalVolumes('#day2'));
					        	$('div#day2 > p > span.total-north-vol').text(getTotalNorthVolumes('#day2'));
					        	$('div#day2 > p > span.total-south-vol').text(getTotalSouthVolumes('#day2'));
					        	$('div#day2 > p > span > i.total-rows').text(getRecordCount('#day2'));
					        	$('div#day2 > p > span > i.total-north').text(getNorthCount('#day2'));
					        	$('div#day2 > p > span > i.total-south').text(getSouthCount('#day2'));

					        	
					        	$('div#day3 > p > span.total-vol').text(getTotalVolumes('#day3'));
					        	$('div#day3 > p > span.total-north-vol').text(getTotalNorthVolumes('#day3'));
					        	$('div#day3 > p > span.total-south-vol').text(getTotalSouthVolumes('#day3'));
					        	$('div#day3 > p > span > i.total-rows').text(getRecordCount('#day3'));
					        	$('div#day3 > p > span > i.total-north').text(getNorthCount('#day3'));
					        	$('div#day3 > p > span > i.total-south').text(getSouthCount('#day3'));

					        	$('div#day4 > p > span.total-vol').text(getTotalVolumes('#day4'));
					        	$('div#day4 > p > span.total-north-vol').text(getTotalNorthVolumes('#day4'));
					        	$('div#day4 > p > span.total-south-vol').text(getTotalSouthVolumes('#day4'));
					        	$('div#day4 > p > span > i.total-rows').text(getRecordCount('#day4'));
					        	$('div#day4 > p > span > i.total-north').text(getNorthCount('#day4'));
					        	$('div#day4 > p > span > i.total-south').text(getSouthCount('#day4'));

					        	$('div#day5 > p > span.total-vol').text(getTotalVolumes('#day5'));
					        	$('div#day5 > p > span.total-north-vol').text(getTotalNorthVolumes('#day5'));
					        	$('div#day5 > p > span.total-south-vol').text(getTotalSouthVolumes('#day5'));
					        	$('div#day5 > p > span > i.total-rows').text(getRecordCount('#day5'));
					        	$('div#day5 > p > span > i.total-north').text(getNorthCount('#day5'));
					        	$('div#day5 > p > span > i.total-south').text(getSouthCount('#day5'));
					        }
						});
						$(this).children('i').removeClass('fa-unlock-alt').addClass('fa-lock');

						
					}

					

					return false;
				});

				$('.waiting-button').click(function(){
					var but_id = $(this).attr('id');
					var but_class = $(this).hasClass('view-only');
					var is_smd_mngr = $('#is-smd-manager').val();
					var sort_container = $(this).attr('id');
					var sched_date = $(this).next('.sched-date').val();
					var main_group = $(this).parent().parent().attr('id');

					var waiting_cnt = $('#' + but_id + '.waiting-wrapper').length;

					console.log(is_smd_mngr);

					if(waiting_cnt == 0){
						$('#'+main_group).after('<div class="waiting-wrapper left" id="' + but_id + '"><ul class="sortable-list ui-sortable" id="waiting-cont"></div>');
						$.ajax({
				           type: "POST",
				           url: "dps/ajax_get_weekly_waiting",
				           data: "sched-date="+sched_date,
				           dataType: "json",
				           cache:false,
				           success:
				                function(data){
				                  if(data != 'none'){
				                  	
				                    //var json = $.parseJSON(data);
				                    var json_obj_cnt = Object.keys(data).length;

				                    var limit = json_obj_cnt - 1;

				                    //console.log(json[1].project_id);

				                    //add the count to the notification counter
				                    var plant_class = '';
				                    var batching_plant = '';

				                    for ( var i = 0; i < json_obj_cnt; i++)
				                    {
				                    	if (data[i].batching_plant === 'Plant 3') {
				                    		plant_class = 'north-plant';
						               		batching_plant = 'north';
				                    	}else{
				                    		plant_class = 'south-plant';
						               		batching_plant = 'south';
				                    	}


				                    	var sales_code = data[i].special_se;
				                    	var disable_class = '';

				                    	if(but_class == true ){
				                    		if(is_smd_mngr == 'yes'){
				                    			disable_class = 'dropdown disable-waiting';

				                    			$('#waiting-cont')
						                          .prepend($('<li>')
						                          	.attr('class',disable_class)
						                            .attr('id', data[i].o202_id)
						                            .append($('<span class="sales-code-marker ' + sales_code.toLowerCase() + '"></span>'))
						                            .append($('<input type="hidden" id="vol" class="' + batching_plant + '" value="' + data[i].batch_vol + '">'))
						                            .append($('<a>')
						                              .attr('id', data[i].project_id)
					                                  .attr('class', 'sched-cont project-dropdown')
					                                  .attr('data-toggle','dropdown')
					                                  .attr('href','#')
					                                  .append($('<div>')
					                                    .attr('class','sched-wrapper')
					                                    .text(data[i].special_se + ' - ' + data[i].cust_name)
					                                    .append($('<span>')
						                                  .text(data[i].proj_name)
						                                )
						                                .append($('<span>' + data[i].proj_address + ' - ' + data[i].modified_time + ' - <i class="formno">' + data[i].form_type + ' ' + data[i].form_no + '</i></span>'))
					                                  )
					                                  .append($('<span class="sched-vol-wrapper ' + plant_class + '"><i class="sched-vol">' + data[i].batch_vol + '</i></span>'))
					                                )
						                          	   .append($('<p class="override-waitinglist" id="' + data[i].o202_id + '"><a href="#">UNLOCK</a></p>'))
						                          	
						                       	)
											}else{
												disable_class = 'dropdown disable-waiting';

				                    			$('#waiting-cont')
						                          .prepend($('<li>')
						                          	.attr('class',disable_class)
						                            .attr('id', data[i].o202_id)
						                            .append($('<span class="sales-code-marker ' + sales_code.toLowerCase() + '"></span>'))
						                            .append($('<input type="hidden" id="vol" class="' + batching_plant + '" value="' + data[i].batch_vol + '">'))
						                            .append($('<a>')
						                              .attr('id', data[i].project_id)
					                                  .attr('class', 'sched-cont project-dropdown')
					                                  .attr('data-toggle','dropdown')
					                                  .attr('href','#')
					                                  .append($('<div>')
					                                    .attr('class','sched-wrapper')
					                                    .text(data[i].special_se + ' - ' + data[i].cust_name)
					                                    .append($('<span>')
						                                  .text(data[i].proj_name)
						                                )
						                                .append($('<span>' + data[i].proj_address + ' - ' + data[i].modified_time + ' - <i class="formno">' + data[i].form_type + ' ' + data[i].form_no + '</i></span>'))
					                                  )
					                                  .append($('<span class="sched-vol-wrapper ' + plant_class + '"><i class="sched-vol">' + data[i].batch_vol + '</i></span>'))
					                                )
						                          	  // .append($('<p class="override-waitinglist" id="' + data[i].o202_id + '"><a href="#">UNLOCK</a></p>'))
						                          	
						                       	)
											}
				                    		
				                    	}else{
				                    		if(i == limit || data[i].waiting_override == 1){
				                          		disable_class = 'dropdown';

				                          		$('#waiting-cont')
						                          .prepend($('<li>')
						                          	.attr('class',disable_class)
						                            .attr('id', data[i].o202_id)
						                            .append($('<span class="sales-code-marker ' + sales_code.toLowerCase() + '"></span>'))
						                            .append($('<input type="hidden" id="vol" class="' + batching_plant + '" value="' + data[i].batch_vol + '">'))
						                            .append($('<a>')
						                              .attr('id', data[i].project_id)
					                                  .attr('class', 'sched-cont project-dropdown')
					                                  .attr('data-toggle','dropdown')
					                                  .attr('href','#')
					                                  .append($('<div>')
					                                    .attr('class','sched-wrapper')
					                                    .text(data[i].special_se + ' - ' + data[i].cust_name)
					                                    .append($('<span>')
						                                  .text(data[i].proj_name)
						                                )
						                                .append($('<span>' + data[i].proj_address + ' - ' + data[i].modified_time + ' - <i class="formno">' + data[i].form_type + ' ' + data[i].form_no + '</i></span>'))
					                                  )
					                                  .append($('<span class="sched-vol-wrapper ' + plant_class + '"><i class="sched-vol">' + data[i].batch_vol + '</i></span>'))
					                                )
						                       	)
				                          	}else{
				                          		disable_class = 'dropdown disable-waiting';

				                          		$('#waiting-cont')
						                          .prepend($('<li>')
						                          	.attr('class',disable_class)
						                            .attr('id', data[i].o202_id)
						                            .append($('<span class="sales-code-marker ' + sales_code.toLowerCase() + '"></span>'))
						                            .append($('<input type="hidden" id="vol" class="' + batching_plant + '" value="' + data[i].batch_vol + '">'))
						                            .append($('<a>')
						                              .attr('id', data[i].project_id)
					                                  .attr('class', 'sched-cont project-dropdown')
					                                  .attr('data-toggle','dropdown')
					                                  .attr('href','#')
					                                  .append($('<div>')
					                                    .attr('class','sched-wrapper')
					                                    .text(data[i].special_se + ' - ' + data[i].cust_name)
					                                    .append($('<span>')
						                                  .text(data[i].proj_name)
						                                )
						                                .append($('<span>' + data[i].proj_address + ' - ' + data[i].modified_time + ' - <i class="formno">' + data[i].form_type + ' ' + data[i].form_no + '</i></span>'))
					                                  )
					                                  .append($('<span class="sched-vol-wrapper ' + plant_class + '"><i class="sched-vol">' + data[i].batch_vol + '</i></span>'))
					                                )
						                          	  //.append($('<p class="override-waitinglist" id="' + data[i].o202_id + '"><a href="#">UNLOCK</a></p>'))
						                          	
						                       	)
				                          	}
				                    	}

				                        
				                        
				                    }
				                  }
				                  
				                  
				                }
				        });

						$('#waiting-cont').sortable({
							connectWith: '#week-sched .sortable-list',
							update: function(event, ui) {

					        },
					        receive: function(event, ui) {
					        	//console.log(getTotalNorthVolumes('#day1'));

					        }
						});
					}else{
						//hide
						$('#' + but_id + '.waiting-wrapper').remove();
					}

					
					return false;
				});

				function getSchedIds(group){
					var cnt = 0;
					var schedid_arr = [];

					$(group + "> li").each(function() {
			            $this = $(this);
			           	schedid_arr[cnt] = $this.attr('id');

			           	cnt ++;
			        });

					return JSON.stringify(schedid_arr);
				}

				$('.project-dropdown').click(function(){
					 $this = $(this);
			         var id = $this.parent().attr('id');



			         var sched_detail_cnt = $('#detail' + id + '.sched-details').length;

			         //alert(sched_detail_cnt);

			         if(sched_detail_cnt == 0){
			         	//append the div
			         	$this.append('<div class="sched-details" id="detail' + id + '"></div>');

			         	//ajax get the scheds detail
			         	$.ajax({
				           type: "POST",
				           url: "dps/ajax_get_weekly_sched_detail",
				           data: "sched-id="+id,
				           dataType: "json",
				           cache:false,
				           success:
				                function(data){
				                  if(data != 'none'){
				                  	
				                    var json_obj_cnt = Object.keys(data).length;

				                    console.log(json_obj_cnt);
				                    if(json_obj_cnt > 0){

				                    	$('#detail' + id + '.sched-details')
				                          .prepend($('<div>')
				                            .attr('class', 'bubble')
				                            .append($('<div>')
			                                  .attr('class', 'sched-details-wrapper')
			                                  .append($('<div>')
			                                    .append($('<span>')
				                                    .text('PSI : ' + data[0].book_psi)
				                                  )

				                                  .append($('<span>')
				                                    .text('AGG : ' + data[0].book_msa)
				                                  )

				                                  .append($('<span>')
				                                    .text('CURING : ' + data[0].book_cd)
				                                  )

				                                  .append($('<span>')
				                                    .text('SLUMP : ' + data[0].book_sp)
				                                  )
			                                  )
			                                  .append($('<div>')
			                                    .append($('<span>')
				                                    .text('Structure : ' + data[0].structure)
				                                  )

				                                  .append($('<span>')
				                                    .text('Pouring Type : ' + data[0].pour_type)
				                                  )

				                                  .append($('<span>')
				                                    .text('Service Engr. : ' + data[0].service_engr)
				                                  )

				                                  .append($('<span>')
				                                    .text('QA Rep. : ' + data[0].qa_rep)
				                                  )
			                                  )
			                                  
			                                  

			                                )
				                       	  )


				                    }
				                  }
				                  
				                  
				                }
				        });




			         	
			         }else{
			         	//remove the div
			         	$('#detail' + id + '.sched-details').remove();
			         }
			         
			         

			         return false;
				});



				/*//test only
				$(".slider").diyslider({
				    width: "1080px", // width of the slider
				    height: "1200px", // height of the slider
				    display: 3, // number of slides you want it to display at once
				    loop: false // disable looping on slides
				}); // this is all you need!

				// use buttons to change slide
				$("#go-left").bind("click", function(){
				    // Go to the previous slide
				    $(".slider").diyslider("move", "back");
				});
				$("#go-right").bind("click", function(){
				    // Go to the previous slide
				    $(".slider").diyslider("move", "forth");
				});*/

				$('#weekly-sched-container').on('click','.override-waitinglist',function(){
					var sched_id = $(this).attr('id');
					
					console.log(sched_id);

					// new Messi(
					// 	'Do you want to override this specific schedule?',
					// 	 {
					// 	 	title: 'Confirmation', 
					// 	 	buttons: [
					// 	 	{
					// 	 		id: 0, 
					// 	 		label: 'Yes', 
					// 	 		val: 'Y'
					// 	 	}, 
					// 	 	{
					// 	 		id: 1, 
					// 	 		label: 'No', 
					// 	 		val: 'N'
					// 	 	}
					// 	 	], 
					// 	 	callback: function(val) { 
					// 	 		if(val == 'Y'){
					// 	 			//ajax
					// 				$.ajax({
					// 		             type: "POST",
					// 		             url: "dps/ajax_override_waiting_list",
					// 		             data: "sched-id="+sched_id,
					// 		             dataType: "json",
					// 		             cache:false,
					// 		             success:
					// 		                  function(data){
					// 		                  	//msg for success here
					// 		                  }
					// 		            });
					// 	 		}else{

					// 	 		}
					// 	 	}
					// 	 });

					swal({   
						title: "Are you sure?",   
						text: "You want to override this specific schedule?",   
						ype: "warning",   
						showCancelButton: true,   
						confirmButtonColor: "#DD6B55",   
						confirmButtonText: "Yes, override it!",   
						closeOnConfirm: false }, 
						function(){
							//ajax
							$.ajax({
					             type: "POST",
					             url: "dps/ajax_override_waiting_list",
					             data: "sched-id="+sched_id,
					             dataType: "json",
					             cache:false,
					             success:
					                  function(data){
					                  	//msg for success here
					                  	swal("Success!", "Override Done!", "success");
					                  }
					        });
							 
						});

					

					return false;
				});

				// $('.override-waitinglist').click(function(){
					
				// });

			
			});
		</script>
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