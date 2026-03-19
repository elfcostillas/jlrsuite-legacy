<div id="dps-tables-wrapper">
		

					<table id="mytable">
						
						<tr id="heading">
							<th width="200">CUSTOMER</th>
							<th>TIME<br />(hours)</th>
							<th>BATCHING PLANT</th>
							<th align="center">CONCRETE DESIGN
								<div id="condes-header">
									<span class="alt"><a>PSI</a></span>
									<span class="alt2"><a>MSA</a></span>
									<span class="alt"><a>C</a></span>
									<span class="alt2"><a>S</a></span>
								</div>
							</th>
							<th>FORMULA CODE</th>
							<th>QA REPRESENTATIVE</th>
							<th>QC REMARKS</th>
							<th>ACCEPT</th>

						</tr>

						

						
						<?php
							$rows = $result->num_rows();
							$i = 0;

							
							while ( $i < $rows) {
								$row = $result->row($i);

								// var_dump($row->dropdown);
								// die();
								
								$id = $row->o202_id;
								$project_id = $row->project_id;
								$client_id = $row->client_id;
								$form_no = $row->form_no;

								$cust_name = strtoupper($row->cust_name);
								$project_name = strtoupper($row->proj_name);
								$project_loc = strtoupper($row->proj_address);
								$batching_plant = $row->batching_plant;

								$str = $row->book_psi;
								$agg_design = $row->book_msa;
								$curing = $row->book_cd;
								$slump_design = $row->book_sp;
								$pouring = $row->pour_type;
								$structure_design = $row->structure;
								$remarks = $row->remarks;
								$estvolume = $row->batch_vol;
								
								

								$modified_date = $row->modified_date;
								$modified_time = $row->modified_time;

								$coor_status = $row->coor_status;
								$smd_status = $row->smd_status;
								$design_status = $row->design_status;

								$acctg_remarks = $row->acctg_remarks;
								$fcode1 = $row->f_code1;
								$fcode2 = $row->f_code2;
								$qa_rep = $row->qa_rep;
								$qc_remarks = $row->qc_remarks;

						?>

						<tr class="items qc-tr" id="<?php echo $id ?>">
							<td align="left" id="left-item" class="scheduler-left-item">
								<p class="info" id="customer"><strong><?php echo $cust_name ?></strong></p>
								<p class="info"><strong><?php echo $project_name ?></strong></p>	
								<p class="info"><?php echo $project_loc ?></p>	
							</td>	

							<td align="center"><?php echo $modified_time ?></td>
							<td align="center">
                                    
                                        <?php
                                            if($batching_plant == 'Plant 4'){
                                                echo "<span id='plantcoloredit'>" . $batching_plant . "</span>";
                                            }else{
                                                echo $batching_plant;
                                            }
                                            
                                        ?>
                                    
                            </td>
							
							<td align="center" id="designtd" width="160">
								<div id="tdwrapper">
									<div id="design">
										<span class="alt"><a><?php echo $str ?></a></span>
										<span class="alt2"><a><?php echo $agg_design ?></a></span>
										<span class="alt"><a><?php echo $curing ?></a></span>
										<span class="alt2"><a><?php echo $slump_design ?></a></span>
									</div>

									<div id="code">
										<span id="code1"><a id="<?php echo $id ?>"><?php echo $fcode1 ?></a></span>
										<span id="code2"><a id="<?php echo $id ?>"><?php echo $fcode2 ?></a></span>
									</div>
								</div>
							</td>

							<?php
								if($fcode1 == '' AND $fcode2 == ''){
									$dpsedit_class = 'dpsedit-pending';
								}else{
									$dpsedit_class = '';
								} 
							?>

							<td align="center" class="<?php echo $dpsedit_class?>">
								
								<select autocomplete="off" name="fcode1" id="fcode1<?php echo $id ?>" class="fcode1">
									<option value="">Select</option>
									<?php
									
										// foreach($fcode as $fcode_list){
										foreach($row->dropdown as $fcode_list){
												$f_code = $fcode_list->code;
												$f_code_ltr = $fcode_list->Group_Qlt;
												if ($fcode1 == $f_code){
													echo '<option selected="true" value="' . $f_code . '">' . $f_code .'</option>';
												}else{
													echo '<option value="' . $f_code . '">' . $f_code .'</option>';
												}
										}			
									?>

								</select>

								<select autocomplete="off" name="fcode2" id="fcode2<?php echo $id ?>" class="fcode2">
									<option value="">Select</option>
									<?php
									
										// foreach($fcode as $fcode_list){
										foreach($row->dropdown as $fcode_list){
												$f_code = $fcode_list->code;
												$f_code_ltr = $fcode_list->Group_Qlt;
												if ($fcode2 == $f_code){
													echo '<option selected="true" value="' . $f_code . '">' . $f_code .'</option>';
												}else{
													echo '<option value="' . $f_code . '">' . $f_code .'</option>';
												}
										}			
									?>

								</select>
							</td>

							<?php
								if($qa_rep == ''){
									$dpsedit_class = 'dpsedit-pending';
								}else{
									$dpsedit_class = '';
								} 
							?>

							<td align="center" class="<?php echo $dpsedit_class?>">
								<select autocomplete="off" name="qa_rep" id="qa_rep<?php echo $id ?>" class="qa_rep">
									<option value="NONE">None</option>
									<?php
									
										foreach($qareps as $qareps_list){
												$qa_reps = $qareps_list->code;
												if ($qa_rep == $qa_reps){
													echo '<option selected="true" value="' . $qa_reps . '">' . $qa_reps .'</option>';
												}else{
													echo '<option value="' . $qa_reps . '">' . $qa_reps .'</option>';
												}
										}			
									?>
								</select>
							</td>

							<?php
								if($qc_remarks == ''){
									$dpsedit_class = 'dpsedit-pending';
								}else{
									$dpsedit_class = '';
								} 
							?>

							<td align="center" class="<?php echo $dpsedit_class?>">
								<select autocomplete="off" name="qc_remarks" id="qc_remarks<?php echo $id ?>" class="qc_remarks">
									<?php
										switch ($qc_remarks) {
											case 'Yield Test - Internal':
												echo "<option value=''>Please Select</option>";
												echo "<option value='Yield Test - Internal' selected='true'>Yield Test - Internal</option>";
												echo "<option value='Yield Test - External 1'>Yield Test - External 1</option>";
												echo "<option value='Yield Test - External 2'>Yield Test - External 2</option>";
												echo "<option value='None'>None</option>";
												break;

											case 'Yield Test - External 1':
												echo "<option value=''>Please Select</option>";
												echo "<option value='Yield Test - Internal'>Yield Test - Internal</option>";
												echo "<option value='Yield Test - External 1' selected='true'>Yield Test - External 1</option>";
												echo "<option value='Yield Test - External 2'>Yield Test - External 2</option>";
												echo "<option value='None'>None</option>";
												break;

											case 'Yield Test - External 2':
												echo "<option value=''>Please Select</option>";
												echo "<option value='Yield Test - Internal'>Yield Test - Internal</option>";
												echo "<option value='Yield Test - External 1'>Yield Test - External 1</option>";
												echo "<option value='Yield Test - External 2' selected='true'>Yield Test - External 2</option>";
												echo "<option value='None'>None</option>";
												break;

											case 'None':
												echo "<option value=''>Please Select</option>";
												echo "<option value='Yield Test - Internal'>Yield Test - Internal</option>";
												echo "<option value='Yield Test - External 1'>Yield Test - External 1</option>";
												echo "<option value='Yield Test - External 2'>Yield Test - External 2</option>";
												echo "<option value='None' selected='true'>None</option>";
												break;
											
											default:
												echo "<option value=''>Please Select</option>";
												echo "<option value='Yield Test - Internal'>Yield Test - Internal</option>";
												echo "<option value='Yield Test - External 1'>Yield Test - External 1</option>";
												echo "<option value='Yield Test - External 2'>Yield Test - External 2</option>";
												echo "<option value='None'>None</option>";
												break;
										}
									?>
								</select>
								<input autocomplete="off" type="text" name="qc_opt_remarks" id="qc_opt_remarks<?php echo $id ?>"/>
							</td>

							<td align="center" id="left">
								<input type="checkbox" name="qccheck" class="qccheck" id="<?php echo $id ?>">
								<a href="#tab4" id="qc-updatebut<?php echo $id ?>" class="edit-dps-updatebut qc-updatebut">Update</a>
								<input type="hidden" name="sched_date" value="<?php echo $modified_date ?>" />
							</td>

								

						</tr>

						<?php
							$i++;
							}
						?>

						

							
					</table>
				</div>