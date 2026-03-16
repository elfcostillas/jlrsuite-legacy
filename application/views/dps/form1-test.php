<form name="add-project-form" method="POST">


		<!--	 CUSTOMER NAME FIELDS 	DEFAULT - DISABLED  -->
		<div id="dps-project-customerinfo" class="dps-addproject-div addproject-lock">
								<div class="dps-fields-left" id="customer-name">
									<div id="dps-addproject-fields">
										<label>Customer Name</label>
										<input type="text" class="name" name="cust-name" id="cust-name" value="<?php echo $customer_name ?>"/>
									</div>
									
									<div id="dps-addproject-fields">
										<label>Office Address</label>
										<input type="text" class="address" name="office-add" id="office-add" value="<?php echo $customer_address ?>"/>
									</div>
								</div>
								<div class="dps-fields-right" id="project-name">
									<div id="dps-addproject-fields">
										<label>Project Name</label>
										<input type="text" class="name" name="project-name" id="project-name" value="<?php echo $project_name ?>" />
									</div>
									
									<div id="dps-addproject-fields">
										<label>Location</label>
										<input type="text" class="address" name="location" id="location" value="<?php echo $project_address ?>"/>
									</div>
								</div>
		</div>	

		<!--	 CONTACT PERSONS FIELDS   DEFAULT - DISABLED 	  -->
		<div id="dps-project-designinfo" class="dps-addproject-div addproject-lock">
							<div class="dps-fields-left">
								<div id="dps-addproject-fields">
									<label>Owner</label>
									<input type="text" name="owner" id="owner" value="<?php echo $owner_name ?>"/>
									<img src="<?php echo base_url("css/images/phone.png")?>" width="20px" height="20px"/> 	
									<input type="text" class="phonenum" name="owner-phone" id="owner-phone" value="<?php echo $owner_contact ?>"/>
								</div>
								
								<div id="dps-addproject-fields">
									<label>Engineer/Foreman</label>
									<input type="text" name="engg-foreman" id="engg-foreman" value="<?php echo $engineer_name ?>"/>
									<img src="<?php echo base_url("css/images/phone.png")?>" width="20px" height="20px"/> 	
									<input type="text" class="phonenum" name="engg-foreman-phone" id="engg-foreman-phone" value="<?php echo $engineer_contact ?>"/>
								</div>
							</div>
							<div class="dps-fields-right">
								<div id="dps-addproject-fields">
									<label>Accounting</label>
									<input type="text" name="accounting" id="accounting" value="<?php echo $accounting_name ?>"/>
									<img src="<?php echo base_url("css/images/phone.png")?>" width="20px" height="20px"/> 	
									<input type="text" class="phonenum" name="accounting-phone" id="accounting-phone" value="<?php echo $accounting_contact ?>"/>
								</div>
								
								<div id="dps-addproject-fields">
									<label>Witness</label>
									<input type="text" name="witness" id="witness" value="<?php echo $witness_name ?>"/>
									<img src="<?php echo base_url("css/images/phone.png")?>" width="20px" height="20px"/> 	
									<input type="text" class="phonenum" name="witness-phone" id="witness-phone" value="<?php echo $witness_contact ?>"/>
								</div>
							</div>
		</div>

		<!--	 PROJECT DESIGN FIELDS 	 DEFAULT - ENABLED  -->
		<div id="dps-project-designinfo" class="dps-addproject-div">
							<div class="dps-fields-left" id="design">
								<table id="dps-addproject">
									<tr id="heading">
										<th>Strength</th>
										<th>Aggregates</th>
										<th>Curing Days</th>
										<th>Slump</th>
										<th>Pouring Type</th>
										<th>Structure</th>
										<th id="right">Remarks</th>
									</tr>

									<tr>
										<td>
											<select>
												<OPTION value="">Select</OPTION>
												<OPTION value="1">1</OPTION>
												<OPTION value="2">2</OPTION>
												<OPTION value="3">3</OPTION>
											</select>
										</td>
										<td>fdfd</td>
										<td>dfdf</td>
										<td>dfdf</td>
										<td>dfdf</td>
										<td>
											<select>
												<OPTION value="">Select</OPTION>
												<OPTION value="1">1</OPTION>
												<OPTION value="2">2</OPTION>
												<OPTION value="3">3</OPTION>
											</select>
										</td>
										<td id="right">dfdf</td>
									</tr>

									<tr>
										<td>fddf</td>
										<td>fdfd</td>
										<td>dfdf</td>
										<td>dfdf</td>
										<td>dfdf</td>
										<td>dfdf</td>
										<td id="right">dfdf</td>
									</tr>

									<tr>
										<td>fddf</td>
										<td>fdfd</td>
										<td>dfdf</td>
										<td>dfdf</td>
										<td>dfdf</td>
										<td>dfdf</td>
										<td id="right">dfdf</td>
									</tr>
								</table>
							</div>

							<!--   CONTRACT / PO / SCHED   -->

							<div class="dps-fields-left" id="contract">
								<div id="dps-addproject-fields">
									<label>Contract No.</label>
									<input type="text" class="num" name="contract-num" id="contract-num"/>
								</div>
								
								<div id="dps-addproject-fields">
									<label>P.O. No.</label>
									<input type="text" class="num" name="po-num" id="po-num" />
								</div>
								<div id="dps-addproject-fields">
									<label>Est. volume</label>
									<input type="text" class="num" name="est-volume" id="est-volume"/>
								</div>
								<div id="dps-addproject-fields">
									<label>Sched Date</label>
									<input type="text" class="num" name="sched-date" id="sched-date"/>
								</div>
							</div>




							<div class="dps-fields-left" id="permits">
								<p id="title">Permits</p>
									
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

		<!--	 SAMPLING PROCEDURE FIELDS 	 DEFAULT - DISABLED -->
		<div id="dps-project-designinfo" class="dps-addproject-div addproject-lock">
							<div class="dps-fields-left" id="sampling">
								<p id="title">Sampling Procedure</p>
								
								<div class="check-wrapper">
									<!-- standard constant = 14 cylinders/75 cu m-->
									<input type="checkbox" class="checkbox" name="check-sampling-standard" id="check-sampling-standard"/><label class="check-label">Standard</label>
								</div>

								<div class="check-wrapper">
									<input type="checkbox" class="checkbox" name="check-sampling-others" id="check-sampling-others"/><label class="check-label">Others</label>
									<input type="text" class="sampling-input" name="cylinders" id="cylinders"/>
									<input type="text" class="sampling-input" name="cubic-meters" id="cubic-meters"/>
								</div>
									
							</div>


							<div class="dps-fields-left" id="curing">
								<p id="title">Curing</p>
								
								<div class="check-wrapper">
									<input type="checkbox" class="checkbox" name="check-atsite" id="check-atsite"/><label class="check-label">At Site</label>
								</div>

								<div class="check-wrapper">
									<input type="checkbox" class="checkbox" name="check-atjlr" id="check-atjlr"/><label class="check-label">At JLR Lab</label>
								</div>
									
							</div>	
		</div>

		<!--	 TESTING SCHEDULE FIELDS 	DEFAULT - DISABLED  -->
		<div id="dps-project-designinfo" class="dps-addproject-div addproject-lock">
							<div class="dps-fields-left" id="sampling">
								<p id="title">Testing Schedule</p>
								
								<div class="check-wrapper">
									<input type="checkbox" class="checkbox" name="check-testing-jlrlab" id="check-testing-jlrlab"/><label class="check-label">JLR MQC Lab</label>
								</div>

								<div class="check-wrapper">
									<input type="checkbox" class="checkbox" name="check-testing-external" id="check-testing-external"/><label class="check-label">External Lab Charge</label>
								</div>
									
							</div>
		</div>

		<!--	 ADDITIONAL EQUIPMENT FIELDS 	DEFAULT - ENABLED  -->
		<div id="dps-project-designinfo" class="dps-addproject-div">
							<div class="dps-fields-left" id="equip">
								<p id="title">Additional Equipment</p>
								
								<div class="check-wrapper">
									<input type="checkbox" class="checkbox" name="check-add-pipes" id="check-add-pipes"/><label class="check-label">Pipes</label>
									<input type="text" class="sampling-input" name="add-pipes-num" id="add-pipes-num"/>
								</div>

								<div class="check-wrapper">
									<input type="checkbox" class="checkbox" name="check-add-vibrator" id="check-add-vibrator"/><label class="check-label">Vibrator</label>
									<input type="text" class="sampling-input" name="add-vibrator-pesos" id="add-vibrator-pesos"/>
								</div>

								<div class="check-wrapper">
									<input type="checkbox" class="checkbox" name="check-add-slumpcone" id="check-add-slumpcone"/><label class="check-label">Slump Cone</label>
								</div>

								<div class="check-wrapper">
									<input type="checkbox" class="checkbox" name="check-add-beam" id="check-add-beam"/><label class="check-label">Beam Molds</label>
								</div>

								<div class="check-wrapper">
									<input type="checkbox" class="checkbox" name="check-add-others" id="check-add-others"/><label class="check-label">Others</label>
									<input type="text" class="sampling-input" name="add-others-value" id="add-others-value"/>
								</div>
									
							</div>
		</div>
						
		<!--	 SPECIAL INSTRUCTIONS FIELDS 	DEFAULT - ENABLED  -->
		<div id="dps-project-landmarks" class="dps-addproject-div">
							<div class="dps-fields-left" id="special1">
								<p id="title">Special Instructions</p>
								<div class="check-wrapper">
									<label class="check-label">Service : </label><input type="text" class="checkbox" name="check-service" id="check-service"/>
								</div>

								<div class="check-wrapper">
									<label class="check-label">Production : </label><input type="text" class="checkbox" name="check-production" id="check-production"/>
								</div>

								<div class="check-wrapper">
									<label class="check-label">QC : </label><input type="text" class="checkbox" name="check-qc" id="check-qc"/>
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
								<p id="title">SE</p>		
							</div>
		</div>

		<!--	 LANDMARKS FIELDS 	 DEFAULT - ENABLED -->
		<div id="dps-project-landmarks" class="dps-addproject-div addproject-lock">
							<div class="dps-fields-left" id="landmark1">
								<p id="title">Landmarks</p>
								<div class="check-wrapper">
									<label class="check-label">Across : </label><input type="text" class="checkbox" name="landmark-across" id="landmark-across"/>
								</div>

								<div class="check-wrapper">
									<label class="check-label">Right side : </label><input type="text" class="checkbox" name="landmark-right" id="landmark-right"/>
								</div>

								<div class="check-wrapper">
									<label class="check-label">Left side : </label><input type="text" class="checkbox" name="landmark-left" id="landmark-left"/>
								</div>
							</div>
							<div class="dps-fields-left" id="landmark2">
								<!-- MAPS -->
							</div>
		</div>


		<!--	 LANDMARKS FIELDS 	 DEFAULT - ENABLED -->
		<div class="dps-addproject-div">
			<input type="submit" id="addproject-submit" name="addproject-submit">
		</div>
	</form>