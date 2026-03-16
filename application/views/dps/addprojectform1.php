


<div id="content" class="grid-940">
	<!-- LINK FOR THE FORM 1A WITHOUT RECENT BOOKINGS -->
	<a href="addproject_form1a?action=new1a" class="dps-buttons" id="add-new-customer-button">Go to Form 1A</a>
	<div id="content-body">

		<!-- <a href="#" id="lock-button">button</a>  -->

		
		
		<form name="add-project-form" class="add-project-form" method="POST" action="process_form1" enctype="multipart/form-data">

			<div id="dps-project-customerinfo" class="dps-addproject-div addproject-lock">
				<div id="form-num-wrapper" class="form1">
					<label>Date : </label><input type="text" name="current-date" id="current-date" disabled="true" value="<?php echo $datenow; ?>">
					<label>Form no : </label><input type="text" name="form-num" id="form-num" class="validate[required]">
				</div>
			</div>
			<!--	 CUSTOMER NAME FIELDS 	DEFAULT - DISABLED  -->
			<div id="dps-project-customerinfo" class="dps-addproject-div addproject-lock">
				<div class="dps-fields-left" id="customer-name">
					<div id="dps-addproject-fields">
						<label>Customer Name</label>
						<!--
							<input type="text" class="name validate[required]" name="cust-name" id="cust-name" />
						-->
						<select name="cust-name" id="cust-name" class="name">
							<option value=""></option>
							<?php
								foreach ($custnames as $custlist) {
									$custname = $this->functionlist->convert_Big_Ntilde($custlist->customer_name);
									$custlist->o5_id;
									echo "<option value='$custlist->o5_id'>$custname</option>";
								}
							?>	
						</select>
					</div>
					
					<div id="dps-addproject-fields">
						<label>Office Address</label>
						<input type="text" class="address validate[required]" name="office-add" id="office-add" value="n/a" />
					</div>
				</div>
				<div class="dps-fields-right" id="project-name">
					<div id="dps-addproject-fields">
						<label>Project Name</label>
						<input type="text" class="name validate[required]" name="project-name" id="project-name"  />
					</div>
					
					<div id="dps-addproject-fields">
						<label>Location</label>
						<input type="text" class="address validate[required]" name="project-location" id="location" />
					</div>
				</div>
			</div>	

							
			<!--	 CONTACT PERSONS FIELDS   DEFAULT - DISABLED 	  -->
			<div id="dps-project-designinfo" class="dps-addproject-div addproject-lock">
								<div class="dps-fields-left">
									<div id="dps-addproject-fields">
										<label>Owner</label>
										<input type="text" name="owner" id="owner" class=""/>
										<img src="<?php echo base_url("css/images/phone.png")?>" width="20px" height="20px"/> 	
										<input type="text" class="phonenum" name="owner-phone" id="owner-phone" />
									</div>
									<div id="dps-addproject-fields">
										<label>Engineer/Foreman</label>
										<input type="text" name="engg-foreman" id="engg-foreman" class=""/>
										<img src="<?php echo base_url("css/images/phone.png")?>" width="20px" height="20px"/> 	
										<input type="text" class="phonenum" name="engg-foreman-phone" id="engg-foreman-phone" />
									</div>

									<div id="dps-addproject-fields">
										<label>Pouring Engineer</label>
										<input type="text" name="pour-engg" id="pour-engg" class=""/>
										<img src="<?php echo base_url("css/images/phone.png")?>" width="20px" height="20px"/> 	
										<input type="text" class="phonenum" name="pour-engg-phone" id="pour-engg-phone" />
									</div>
									<div id="dps-addproject-fields">
										<label>Finishing Coor</label>
										<input type="text" name="fin-coor" id="fin-coor" class=""/>
										<img src="<?php echo base_url("css/images/phone.png")?>" width="20px" height="20px"/> 	
										<input type="text" class="phonenum" name="fin-coor-phone" id="fin-coor-phone" />
									</div>

								</div>
								

									
						
								<div class="dps-fields-right" id="more-contacts">
									<div id="dps-addproject-fields">
										<label>Accounting</label>
										<input type="text" name="accounting" id="accounting" class=""/>
										<img src="<?php echo base_url("css/images/phone.png")?>" width="20px" height="20px"/> 	
										<input type="text" class="phonenum" name="accounting-phone" id="accounting-phone" />
									</div>
									
									<div id="dps-addproject-fields">
										<label>Witness</label>
										<input type="text" name="witness" id="witness" class=""/>
										<img src="<?php echo base_url("css/images/phone.png")?>" width="20px" height="20px"/> 	
										<input type="text" class="phonenum" name="witness-phone" id="witness-phone" />
									</div>

								</div>
								<a href="#" id="more-contacts-button">More</a>

			</div>

			<!--	 PROJECT DESIGN FIELDS 	 DEFAULT - ENABLED  -->
			<div id="dps-project-designinfo" class="dps-addproject-div">
				
								<div class="dps-fields-left" id="design">
									<input type="hidden" name="designtable-ctr" id="designtable-ctr" value="1"/>

									<table id="dps-addproject">

										<tr id="heading">
											<th>Strength</th>
											<th>Aggregates</th>
											<th>Curing Days</th>
											<th>Slump</th>
											<th>Pouring Type</th>
											<th>Structure</th>
											<th>Volume</th>
											<th>Date</th>
											<th>Time</th>
											<th>Remarks</th>
											<th id="right">Status</th>
											
										</tr>

									<tbody id="designbody">

										<tr>
											<td>
												<select name="strength1" id="strength1" class="validate[required]">
													<OPTION value="">Select</OPTION>
													<?php				
											            foreach($strength as $des_strength){
											            	$strength_value = $des_strength['strength'] . " " . $des_strength['type'];
											                echo '<option value="' . $des_strength['code'] . '">' . $strength_value .'</option>';
											            }
										            ?>
												</select>
											</td>

											<td>
												<select name="agg1" id="agg1" class="validate[required]">
													<OPTION value="">Select</OPTION>
													<?php				
											            foreach($agg as $des_agg){
											            	$agg_value = $des_agg['code'];
											                echo '<option value="' . $agg_value . '">' . $agg_value .'</option>';
											            }
										            ?>
												</select>
											</td>

											<td>
												<select name="curing1" id="curing1" class="validate[required]">
													<OPTION value="">Select</OPTION>
													<OPTION value="15H">15 hours</OPTION>
													<OPTION value="1D">1 day</OPTION>
													<OPTION value="3D">3 days</OPTION>
													<OPTION value="5D">5 days</OPTION>
													<OPTION value="7D">7 days</OPTION>
													<OPTION value="14D">14 days</OPTION>
													<OPTION value="28D">28 days</OPTION>
												</select>
											</td>

											<td>
												<select name="slump1" id="slump1" class="validate[required]">
													<OPTION value="">Select</OPTION>
													<?php				
											            foreach($slump as $des_slump){
											            	$slump = $des_slump['slump'];
											                echo '<option value="' . $des_slump['code'] . '">' . $slump .'</option>';
											            }
										            ?>
												</select>
											</td>

											<td>
												<select name="pouring1" id="pouring1" class="validate[required] form-pouring">
													<OPTION value="">Select</OPTION>
													<?php				
											            foreach($pouringtype as $des_pouringtype){
											            	$pouringtype = $des_pouringtype['Type'];
											                echo '<option value="' . $des_pouringtype['Type'] . '">' . $pouringtype .'</option>';
											            }
										            ?>
												</select>
											</td>

											<td>
												<!--<select name="struct1" id="struct1" class="validate[required] form-struct">
													<OPTION value="">Select</OPTION>
													<?php				
											           // foreach($structure as $des_structure){
											           // 	$structure = $des_structure['struct_name'];
											           //     echo '<option value="' . $des_structure['struct_name'] . '">' . $structure .'</option>';
											           // }
										            ?>
												</select>-->
												<input type="text" name="struct1" id="struct1" class="validate[required] form-struct" />
											</td>

											

											<td>
												<input type="text" name="estvolume1" id="estvolume1" class="design-inputbox-volume form-volume validate[required,custom[number]]">
											</td>

											<td>
												<input type="text" name="scheddate1" id="scheddate1" class="design-inputbox-date">
											</td>

											<td>
												<select name="schedtime1" id="schedtime1" class="validate[required] form-time">
													<?php
														foreach($time as $time_list){
											            	$time = $time_list;
											                echo '<option value="' . $time . '">' . $time .'</option>';
											            }

													?>
													
												</select>
											</td>

											<td>
												<select name="remarks1" id="remarks1" class="validate[required]">
													<OPTION value="">Select</OPTION>
													<OPTION value="N/A">N/A</OPTION>
													<OPTION value="COS">COS</OPTION>
													<OPTION value="POS">POS</OPTION>
													<OPTION value="FC">FC</OPTION>
													<OPTION value="BT">BT</OPTION>
													<OPTION value="PD">PD</OPTION>
												</select>
											</td>

											<td id="right">
												<select name="designstatus1" id="designstatus1" class="validate[required]">
													<option value=""></option>
													<option value="Okay">Okay</option>
													<option value="Cancelled">Cancelled</option>
													<option value="Insert">Insert</option>
													<option value="Re-Sched">Re-Sched</option>
													<option value="For Confirmation">For Confirmation</option>
													<option value="On Hold">On Hold</option>
												</select>
											</td>
										</tr>

									</tbody>
									</table>
									<a href="#" id="add-table-row" class="addproject-tablebuttons">Add New Design Row </a>
									<a href="#" id="remove-last-table-row" class="addproject-tablebuttons">Remove Last Row</a>


								</div>

								<!--   CONTRACT / PO / SCHED   -->

								<div class="dps-fields-left" id="contract">
									<div id="dps-addproject-fields">
										<label>Contract No.</label>
										<input type="text" class="num validate[required]" name="contract-num" id="contract-num" />
									</div>
									
									<div id="dps-addproject-fields">
										<label>P.O. No.</label>
										<input type="text" class="num validate[required]" name="po-num" id="po-num" value="0"/>
									</div>

									<!-- added by ralph july 15, 2015 -->
									<div id="dps-addproject-fields">
										<label>Plant</label>
										<select name="batchplant" id="batchplant" class="validate[required]">
											<option value=""></option>
											<option value="Plant 3">North</option>
											<option value="Plant 4">South</option>
										</select>
									</div>

									<div id="dps-addproject-fields">
										<input type="checkbox" class="" name="check-prepaid" id="check-prepaid"/>
										<label id="lblprep">Prepaid</label>
									</div>
									
								</div>						
			</div>

			<div id="dps-project-designinfo" class="dps-addproject-div addproject-lock">
				<div class="dps-fields-left" id="permits">
									<p id="title">Permits</p>
					<div id="permit-check-wrapper">
										
									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-citom" id="check-citom"/><label class="check-label">CITOM</label>
									</div>

									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-brgy" id="check-brgy"/><label class="check-label">Barangay</label>
									</div>

									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-hasentfee" id="check-hasentfee"/><label class="check-label">Entrance Fee</label>
										<input type="text" name="check-entfee" id="check-entfee"/> 
									</div>

									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-hasothers" id="check-hasothers" /><label class="check-label">Others</label>
										<input type="text" name="check-others" id="check-others"/> 
									</div>
					</div>
				</div>
			</div>

			<!--	 SAMPLING PROCEDURE FIELDS 	 DEFAULT - DISABLED -->

			<div class="dps-addproject-div">
				<div id="sampling-proc-wrapper" class="column3">
					<p id="title">Sampling Procedure</p><br />

					<!-- standard constant = 14 cylinders/75 cu m-->
					<div class="samp-wrapper">
						<input type="radio" name="check-sampling" id="check-sampling-standard" checked value="standard" class="sampling-radio validate[required]"/>
						<label class="check-label" for="check-sampling-standard">Standard (<span>for every 75 cu m </span>)</label>
						<div class="samp-standard-wrapper">
							<label>Cylinders : </label><input type="text" name="samp-standard-cyl"  id="samp-standard-cyl" class=""/>
							<label> Beams : </label><input type="text"  name="samp-standard-beam" id="samp-standard-beam" class=""/>
						</div>
					</div>

					

					<br />

					<div class="samp-wrapper">
						<input type="radio" name="check-sampling" id="check-sampling-others" value="others" class="sampling-radio validate[required]"/>
						<label class="check-label" for="check-sampling-others">Others</label>
						<br />
						<div id="samp-others-wrapper">
							<input type="text"  name="cylinders" id="cylinders" class="samp-input-others validate[required,custom[integer]]"/><label>cylinders</label>
							<input type="text"  name="cubic-meters" id="cubic-meters" class="samp-input-others validate[required,custom[integer]]"/><label>cubic</label>
						</div>
					</div>

					<br />
					<div class="samp-wrapper">
						<input type="checkbox" class="checkbox" name="check-plantcast" id="check-plantcast" value="value" />
						<label class="check-label" for="check-plantcast">PLANT CAST</label>
					</div>
					
					<br />
					<p id="title">Curing</p>
					<br />
					<div class="check-wrapper">
						<input type="checkbox" class="checkbox" name="check-atsite" id="check-atsite"/><label class="check-label">At Site</label>
					</div>

					<div class="check-wrapper">
						<input type="checkbox" class="checkbox" name="check-atjlr" id="check-atjlr" checked/><label class="check-label">At JLR Lab</label>
					</div>
					<br />
					<br />
				</div>

				<div id="testing-sched-wrapper" class="column3">
					<p id="title">Testing Schedule</p>
					<br />

					<div class="check-wrapper">
						<input type="checkbox" class="checkbox" name="check-testing-jlrlab" id="check-testing-jlrlab" checked/><label class="check-label">JLR MQC Lab (cylinders)</label>
					</div>
					
					<div class="check-wrapper" id="test-jlrlab">
						<input type="checkbox" class="test-check" name="test-jlr-3" id="test-jlr-3"/><label class="test-check">3D</label>
						<input type="checkbox" class="test-check" name="test-jlr-7" id="test-jlr-7" checked/><label class="test-check">7D</label>
						<input type="checkbox" class="test-check" name="test-jlr-14" id="test-jlr-14"/><label class="test-check">14D</label>
						<input type="checkbox" class="test-check" name="test-jlr-28" id="test-jlr-28" checked/><label class="test-check">28D</label>
						<input type="checkbox" class="test-check" name="test-jlr-spare" id="test-jlr-spare"/><label class="test-check">SPARE</label>
					</div>
					
					<br /><br />
					
					<div class="check-wrapper">
						<input type="checkbox" class="checkbox" name="check-testing-external" id="check-testing-external" checked/><label class="check-label">External Lab Charge</label>
					</div>
					
					<div class="check-wrapper test-extlab">
						<label class="test-check">Cyls.: </label>
						<input type="checkbox" class="test-check" name="test-ext-7" id="test-ext-7" checked/><label class="test-check">7D</label>
						<input type="checkbox" class="test-check" name="test-ext-14" id="test-ext-14"/><label class="test-check">14D</label>
						<input type="checkbox" class="test-check" name="test-ext-28" id="test-ext-28" checked/><label class="test-check">28D</label>
						<input type="checkbox" class="test-check" name="test-ext-spare" id="test-ext-spare"/><label class="test-check">SPARE</label>
					</div>
					<div class="check-wrapper test-extlab">
						<label class="test-check">Beams: </label>
						<input type="checkbox" class="test-check" name="test-ext-beam-7" id="test-ext-beam-7" checked/><label class="test-check">7D</label>
						<input type="checkbox" class="test-check" name="test-ext-beam-14" id="test-ext-beam-14"/><label class="test-check">14D</label>
						<input type="checkbox" class="test-check" name="test-ext-beam-28" id="test-ext-beam-28" checked/><label class="test-check">28D</label>
						<input type="checkbox" class="test-check" name="test-ext-beam-spare" id="test-ext-beam-spare"/><label class="test-check">SPARE</label>
					</div>


					<br />
					<br />
					<div id="extlab-input-wrappers">
						
						<label>C/O Lab :</label><input type="text" name="co_lab" id="co_lab" class="validate[required]"/>
						<label>Lab Name :</label>
						<select name="ext-labname" id="ext-labname" class="validate[required]">
							<OPTION value="">Select External Lab</OPTION>
								<?php				
									foreach($extlab as $extlab_list){
										$extlab = $extlab_list->lab_name;
										echo '<option value="' . $extlab_list->o15_id . '">' . $extlab .'</option>';
									}
								?>
						</select>
						<br />
						<br />
					</div>
				</div>
				<div id="client-witness-wrapper" class="column3">
					<p id="title">Client Witness</p>
					<br />
					<div class="check-wrapper">
						<input type="radio" class="checkbox validate[required] witness-choice" name="client-witness" id="witness-with" value="with"/><label class="check-label">With</label>
					</div>

					<div class="check-wrapper">
						<input type="radio" class="checkbox validate[required] witness-choice" name="client-witness" id="witness-without" value="without"/><label class="check-label">Without</label>
					</div>

					<div class="check-wrapper">
						<input type="radio" class="checkbox validate[required] witness-choice" name="client-witness" id="witness-sameas" value="sameas"/><label class="check-label">Same in Contacts</label>
					</div>

					<br /><br />
					<div id="witness-main-wrapper">
						<div class="witness-wrapper">
							<label>Consultant : </label><input type="text" name="consultant-name" id="consultant-name" class="validate[required]">
						</div>
						
						<div class="witness-wrapper">
							<label>Contact No : </label><input type="text" name="consultant-num" name="consultant-num" class="validate[required,custom[integer]]">
						</div>
					</div>
					
					<br />
				</div>
			</div>
			
			
									
									


			<!--	 ADDITIONAL EQUIPMENT FIELDS 	DEFAULT - ENABLED  -->
			<div id="dps-project-designinfo" class="dps-addproject-div">
								<div class="dps-fields-left" id="equip">
									<p id="title">Additional Equipment</p>
								<div id="permit-check-wrapper">	
									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-add-pipes" id="check-add-pipes"/><label class="check-label">Pipes</label>
										<input type="text" class="sampling-input validate[required,custom[integer]]" name="add-pipes-num" id="add-pipes-num"/>
									</div>

									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-add-vibrator" id="check-add-vibrator"/><label class="check-label">Vibrator</label>
										<input type="text" class="sampling-input validate[required,custom[integer]]" name="add-vibrator-pesos" id="add-vibrator-pesos"/>
									</div>

									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-add-slumpcone" id="check-add-slumpcone"/><label class="check-label">Slump Cone</label>
									</div>

									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-add-beam" id="check-add-beam"/><label class="check-label">Beam Molds</label>
									</div>

									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-add-others" id="check-add-others"/><label class="check-label">Others</label>
										<input type="text" class="sampling-input validate[required]" name="add-others-value" id="add-others-value"/>
									</div>
								</div>
										
								</div>
			</div>
							
			<!--	 SPECIAL INSTRUCTIONS FIELDS 	DEFAULT - ENABLED  -->
			<div id="dps-project-landmarks" class="dps-addproject-div">
								<div class="dps-fields-left" id="special1">
									<p id="title">Special Inst.</p>
								<div id="permit-check-wrapper">
									<div class="landmark-inputbox">
										<label class="check-label">Service: </label><br />
										<textarea id="landmark-across" name="check-service" class="validate[required]">n/a</textarea>
									</div>

									<div class="landmark-inputbox">
										<label class="check-label">Production : </label><br />
										<textarea id="landmark-right" name="check-production" class="validate[required]">n/a</textarea>
									</div>

									<div class="landmark-inputbox">
										<label class="check-label">QC : </label><br />
										<textarea id="landmark-left" name="check-qc" class="validate[required]">n/a</textarea>
									</div>
								</div>
								</div>

									
								
			</div>
							
			<!--	 SPECIAL INSTRUCTIONS FIELDS2 	DEFAULT - ENABLED  -->
			<div id="dps-project-landmarks" class="dps-addproject-div addproject-lock">
								<div class="dps-fields-left" id="special2">
									
								
									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-forinspection" id="check-forinspection"/><label class="check-label">FOR INSPECTION</label>
									</div>

									<div class="check-wrapper">
										<input type="checkbox" class="checkbox" name="check-forpouring" id="check-forpouring"/><label class="check-label">FOR POURING</label>
									</div>

										
								</div>

								<div class="dps-fields-left" id="special2-half">
									<p id="title">Sales Engineer</p>
						
									<select name="special-sales-engg" id="special-sales-engg" class="validate[required]">		
										<OPTION value="">Select Sales Engineer</OPTION>
											<?php				
											    foreach($salesengg as $salesengg_list){
											        $salesengg = $salesengg_list->name;
											        echo '<option value="' . $salesengg_list->code . '">' . $salesengg .'</option>';
											    }
										    ?>
									</select>
								
								</div>
			</div>

			<!--	 LANDMARKS FIELDS 	 DEFAULT - ENABLED -->
			<div id="dps-project-landmarks" class="dps-addproject-div addproject-lock">
								
									<p id="landmark-title">Landmarks</p>

									<div class="landmark-inputbox">
										<label class="check-label">Across : </label><br />
										<textarea name="landmark-across" id="landmark-across" class="validate[required]">n/a</textarea>
									</div>

									<div class="landmark-inputbox">
										<label class="check-label">Right side : </label><br />
										<textarea name="landmark-right" id="landmark-right" class="validate[required]">n/a</textarea>
									</div>

									<div class="landmark-inputbox">
										<label class="check-label">Left side : </label><br />
										<textarea name="landmark-left" id="landmark-left" class="validate[required]">n/a</textarea>
									</div>

									
										<div id="upload-wrapper">
											<!--<label>Upload a sketch Map</label><input type="file" id="files" name="landmark-image" class="validate[required]"/>-->
											<input type="hidden" id="selected-image" name="landmark-sketch" />
											<div id="select-sketch-notify"></div>

											<div id="imageexplorer-container">

												<?php
													$i=0;
													foreach(glob("./location_sketch/thumbnails/*.jpg") as $filename){
														$imgname = basename($filename);
													    echo "<div class='bigsquares' id='$i'>";
													    	echo "<img value='$imgname' class='selectable' id='$i' src='../location_sketch/thumbnails/$imgname' disabled='disabled' />";
													    	echo "<p id='pew'>$imgname</p>";
													    	echo "<div id='img-info-wrapper'>";
													    		echo "<a href='../location_sketch/$imgname' class='expand image-expand'>Expand Image</a>";

													    	echo "</div>";
															echo "<input type='checkbox' class='img-selectbox' id='$i' value='0' />";
														echo "</div>";
														$i++;
													}

												?>
											</div>
										</div>
									
								</div>

								<!-- MAPS -->

								
									
								<div id="preview-wrapper">
									<output id="image-preview"></output>
								</div>							
								


			<!--	 LANDMARKS FIELDS 	 DEFAULT - ENABLED -->
			<div class="dps-addproject-div">
				<center><p id="submit-beforenote">(please review the informations before clicking this button)</p></center>
				<input type="submit" id="addproject-submit" name="addproject-submit" value="ADD PROJECT">
			</div>
		</form>
	</div>
</div>			
