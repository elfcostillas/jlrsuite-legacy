<div id="dps-tables-wrapper">
		

					<table id="mytable">
						
						<tr id="heading">
							<th width="200">CUSTOMER</th>
							<th>VOLUME</th>
							<th>TIME (hours)</th>
							<th>BATCHING PLANT</th>
							<th>SERVICE ENGINEER</th>
							<th>STRUCTURE</th>
							<th>POURING</th>
							<th>ACCEPT</th>

						</tr>

						
						<?php
							$rows = $result->num_rows();
							$i = 0;

							
							while ( $i < $rows) {
								$row = $result->row($i);
								
								$id = $row->o202_id;
								$project_id = $row->project_id;
								$client_id = $row->client_id;
								$form_no = $row->form_no;

								$cust_name = strtoupper($row->cust_name);
								$project_name = strtoupper($row->proj_name);
								$project_loc = strtoupper($row->proj_address);
								$batching_plant = $row->batching_plant;

								$modified_date = $row->modified_date;
								$modified_time = $row->modified_time;

								$coor_status = $row->coor_status;
								$smd_status = $row->smd_status;

								$design_status = $row->design_status;

								$serv_engr = $row->service_engr;

								//added by ralph volume/structure/pouring type
								$volume = $row->batch_vol;
								$pour_type = $row->pour_type;
								$des_struct = $row->structure;

							?>

						<tr class="items sp-tr" id="<?php echo $id ?>">
							<td  align="left" id="left-item" class="scheduler-left-item">
								<p class="info" id="customer"><strong><?php echo $cust_name ?></strong></p>
								<p class="info" ><strong><?php echo $project_name ?></strong></p>	
								<p class="info" ><?php echo $project_loc ?></p>	
							</td>	

							<td align="center"><?php echo $volume ?></td>

							<td align="center" width="10">
								
								<select class='schedtimeplant' name='schedtime' id='schedtime<?php echo $id ?>'>
										<?php
											foreach($timerap as $time_list){
													$time = $time_list;
													if ($modified_time == $time){
														echo '<option selected="true" value="' . $time . '"><center>' . $time .'</center></option>';
													}else{
														echo '<option value="' . $time . '"><center>' . $time .'</center></option>';
													}
													
											}
										?>
									</select>
							</td>

							<?php 
								if($batching_plant == ''){
									$dpsedit_class = 'dpsedit-pending';
								}else{
									$dpsedit_class = '';
								}
							?>

							<td align="center" class="<?php echo $dpsedit_class ?>">
								<select autocomplete="off" name="batch-plant" id="batch-plant<?php echo $id ?>" class="batch-plant">

									<?php
										

										switch ($batching_plant) {
											case 'Plant 3':
												echo "<option value=''>Select Plant</option>";
												echo "<option value='Plant 3' selected='true' >Plant 3</option>";
												echo "<option value='Plant 4'>Plant 4</option>";
												echo "<option value='Plant 5'>Plant 5</option>";
												break;
											
											case 'Plant 4':
												echo "<option value=''>Select Plant</option>";
												echo "<option value='Plant 3'>Plant 3</option>";
												echo "<option value='Plant 4' selected='true' >Plant 4</option>";
												echo "<option value='Plant 5'>Plant 5</option>";
												break;

											case 'Plant 5':
												echo "<option value=''>Select Plant</option>";
												echo "<option value='Plant 3'>Plant 3</option>";
												echo "<option value='Plant 4'>Plant 4</option>";
												echo "<option value='Plant 5' selected='true'>Plant 5</option>";
												break;

											default:
												echo "<option value=''>Select Plant</option>";
												echo "<option value='Plant 3'>Plant 3</option>";
												echo "<option value='Plant 4'>Plant 4</option>";
												echo "<option value='Plant 5'>Plant 5</option>";
												break;
										}
									?>
									
								</select>
							</td>

							<?php
								if($serv_engr == ''){
									$dpsedit_class = 'dpsedit-pending';
								}else{
									$dpsedit_class = '';
								} 
							?>
							<td align="center" class="<?php echo $dpsedit_class ?>">
								<select autocomplete="off" name="servengr" id="servengr<?php echo $id ?>" class="servengr">
									<option value=""></option>
									<?php
										
										foreach($serviceengr as $serviceengr_list){
												$service_engr = $serviceengr_list;
												if ($serv_engr == $service_engr){
													echo '<option selected="true" value="' . $service_engr . '">' . $service_engr .'</option>';
												}else{
													echo '<option value="' . $service_engr . '">' . $service_engr .'</option>';
												}
										}			
									?>
								</select>
							</td>

							<td align="center"><?php echo $des_struct ?></td>
							<td align="center"><?php echo $pour_type ?></td>

							<td align="center" id="left">
								<input type="checkbox" name="spcheck" class="spcheck" id="<?php echo $id ?>">
								<a href="#tab3" id="supervisor-updatebut<?php echo $id ?>" class="edit-dps-updatebut supervisor-updatebut">Update</a>
								<input type="hidden" name="sched_date" value="<?php echo $modified_date ?>" />
								<input type="hidden" name="mod_time" value="<?php echo $modified_time ?>" />
							</td>	

						</tr>

						<?php
							$i++;
							}
						?>

							
					</table>
				</div>