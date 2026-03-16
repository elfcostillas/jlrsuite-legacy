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
					<h2>Yesterday Schedule<br /><span><?php echo date('F d, Y', strtotime('-1 day')) ?></span></h2>
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
					<h2>Other Day's Schedule<br /><span><?php echo date('F d, Y', strtotime('-2 day')) ?></span></h2>
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

