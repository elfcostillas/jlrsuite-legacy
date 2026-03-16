
<!--<a href="process_formula">IMPORT LATEST FORMULA</a>-->
			<div id="content" class="grid-940">
			
				<!-- LINK FOR THE FORM 1A WITHOUT RECENT BOOKINGS -->
				<a href="addproject_form1a?action=new1a" class="dps-buttons" id="add-new-customer-button">Form 1A</a>
				<!-- LINK FOR THE FORM 1 -->
				<a href="addproject_form1" class="dps-buttons" id="add-new-customer-button">Add New Project (Form 1)</a>
				

				<table id="leave-table" class="tables addproject-table">

							<tr id="head">
								<th id="right-head">Customer / Project / Location</th>
								<th class="heading" id="left-head">Location Sketch</th>
							</tr>

							<?php
								$last_projectid ='';
								
								foreach ($recentPouring as $recent_pouring) {	  
							

								$client_id = $recent_pouring['client_id'];
								$project_id = $recent_pouring['project_id'];
								$project_name = $recent_pouring['proj_name'];
								$project_address = $recent_pouring['proj_address'];

								//query for the landmark using the project id
								
								$landmark_sketch = $this->dps_model->get_landmark_sketch($project_id);


								
								foreach ($landmark_sketch as $sketch) {
									$loc_sketch = $sketch->landmark_sketch; 
									

								//check if value is like the previous
								if($last_projectid != $project_id){
							?>

							
									<tr class="items">
											<td align="left" id="left-item">

												
												<div id="project-list-select">
													<form method="POST" action="addproject_form1a">
														<input type="hidden" value="<?php echo $client_id ?>" name="client_id" />
														<input type="hidden" value="<?php echo $project_id ?>" name="project_id" />
														<input type="hidden" value="<?php echo $project_name ?>" name="project_name" />
														<input type="hidden" value="<?php echo $project_address ?>" name="project_address" />
														<input type="submit" value="new booking" name="recent-pour-select" id="recent-pour-select"/>
													</form>
												</div>

												<div id="project-list-customer">
													<p id="customer"><?php echo strtoupper($recent_pouring['cust_name']) ?></p>
													<p class="cust-details"><?php echo  strtoupper($recent_pouring['proj_name']) ?></p>
													<p class="cust-details"><?php echo  strtoupper($recent_pouring['proj_address']) ?></p>
												</div>
											</td>	
											
											<td align="center" id="left">
												<?php
												
												
													if(is_null($loc_sketch) || $loc_sketch == 'NA'){
														echo "none";
													}else{
														
												?>
														
														<a class="landmark_box"  href="<?php echo base_url('/location_sketch/'. $loc_sketch) ?>">
															
															<img src="<?php echo base_url("css/images/map.png") ?>" />
														</a>
													
												<?php
													}
												?>
											</td>								
									</tr>
							
							<?php
								}//endofthe if last_projectid
								}//end of for each location_sketch
									$last_projectid = $recent_pouring['project_id'];
								}
							?>
								

							
							
				</table>

			</div>



				



