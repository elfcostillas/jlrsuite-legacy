

<div id="content" class="grid-940">

	<!-- LINK FOR THE FORM 1 -->
	<a href="addproject_form1" class="dps-buttons" id="add-new-customer-button">Go back (Form 1)</a>

	<div id="content-body">

		<!-- <a href="#" id="lock-button">button</a>  -->

		<?php

			if($pagestatus == 'old'){
				foreach ($customerinfo as $customer_info) {
					$customer_name = $customer_info['customer_name'];
					$customer_address = $customer_info['customer_address'];
				}

				/*
				foreach ($projectcontact as $project_contact) {
					$owner_name = $project_contact['owner_name'];
					$owner_contact = $project_contact['owner_contact'];

					$engineer_name = $project_contact['engineer_name'];
					$engineer_contact = $project_contact['engineer_contact'];

					$accounting_name = $project_contact['acctg_name'];
					$accounting_contact = $project_contact['acctg_contact'];

					$witness_name = $project_contact['witness_name'];
					$witness_contact = $project_contact['witness_contact'];
				}
				*/

			}

			
			
		?>
		
		<form name="add-project-form1a" class="add-project-form" method="POST" action="process_form1a">


		<?php
			if($pagestatus == 'old'){
		?>

				<!-- hidden fields for the submission of others fields -->
				<input type="hidden" name="cust-name" value="<?php echo $client_id ?>">
				<input type="hidden" name="project-id" value="<?php echo $project_id ?>">
				<input type="hidden" name="project-name" value="<?php echo $project_name ?>">
				<input type="hidden" name="location" value="<?php echo $project_address ?>">
				<input type="hidden" name="customer" value="<?php echo $customer_name ?>">

				<input type="hidden" name="form1astatus" value="old" />



				<div id="dps-project-customerinfo" class="dps-addproject-div addproject-lock">
					<div id="form-num-wrapper" class="form1a">
						<label>Date : </label><input type="text" name="current-date" id="current-date" disabled="true" value="<?php echo $datenow; ?>">
						<label>Form no : </label><input type="text" name="form-num" id="form-num" class="validate[required]">
					</div>
				</div>


				<!--	 CUSTOMER NAME FIELDS 	DEFAULT - DISABLED  -->
				<div id="dps-project-customerinfo" class="dps-addproject-div addproject-lock">
										<div class="dps-fields-left" id="customer-name">
											<div id="dps-addproject-fields">
												<label>Customer Name</label>
												<input type="text" class="name validate[required]" name="cust-name" id="cust-name" value="<?php echo htmlentities($customer_name, ENT_QUOTES) ?>" disabled="true"/>
											</div>
											
											<div id="dps-addproject-fields">
												<label>Office Address</label>
												<input type="text" class="address validate[required]" name="office-add" id="office-add" value="<?php echo $customer_address ?>" disabled="true"/>
											</div>
										</div>
										<div class="dps-fields-right" id="project-name">
											<div id="dps-addproject-fields">
												<label>Project Name</label>
												<input type="text" class="name validate[required]" name="project-name" id="project-name" value="<?php echo $project_name ?>" disabled="true"/>
											</div>
											
											<div id="dps-addproject-fields">
												<label>Location</label>
												<input type="text" class="address validate[required]" name="location" id="location" value="<?php echo $project_address ?>" disabled="true"/>
												<input type="hidden" class="address validate[required]" name="location" id="location" value="<?php echo $project_address ?>"/>
											</div>
										</div>
				</div>	
		<?php
			}else{
		?>
				<input type="hidden" name="form1astatus" value="new" />
				<div id="dps-project-customerinfo" class="dps-addproject-div addproject-lock">
					<div id="form-num-wrapper" class="form1a">
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
								<input type="text" class="name validate[required]" name="cust-name" id="cust-name" value="" />
							-->
							<select name="cust-name" id="cust-name" class="name form1acustomerselect validate[required]">
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
							<label></label>
							<!--
								<label>Office Address</label>
								<input type="text" class="address validate[required]" name="office-add" id="office-add" value="" />
							-->
						</div>
						
					</div>
					<div class="dps-fields-right" id="project-name">
						<div id="dps-addproject-fields">
							<label>Project Name</label>
							<div id="getproject-result-wrapper">
								<select class="name validate[required]" id="selectedprojectby_cust" disabled="true">
								</select>
								<input type="hidden" name="project-name" id="hidden-projectname" />
								<input type="hidden" name="project-id" id="hidden-projectid" />
							</div>
							<!--
							<input type="text" class="name validate[required]" name="project-name" id="project-name" value=""/>
							-->
						</div>
						
						<div id="dps-addproject-fields">
							<label>Location</label>
							<input type="text" class="address validate[required]" name="location" id="location" value="" disabled="true"/>
						</div>
					</div>
				</div>	

				

		<?php
			}
		?>

			<!--	 CONTACT PERSONS FIELDS   DEFAULT - DISABLED 	  -->
			<div id="dps-project-designinfo" class="dps-addproject-div addproject-lock">
				<div class="dps-fields-left">
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
			</div>



			<!-- START OF NO PHP VARIABLES -->

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
												           //    echo '<option value="' . $des_structure['struct_name'] . '">' . $structure .'</option>';
												           //}
											            ?>
													</select>-->
													<input  type="text" name="struct1" id="struct1" class="validate[required] form-struct" >
												</td>

												

												<td>
													<input type="text" name="estvolume1" id="estvolume1" class="design-inputbox-volume form-volume validate[required,custom[number]]">
												</td>

												<td id="right">
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
														<option value="Confirmation">For Confirmation</option>
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
											<input type="text" class="num validate[required]" name="contract-num" id="contract-num" value="0" />
										</div>
										
										<div id="dps-addproject-fields">
											<label>P.O. No.</label>
											<input type="text" class="num validate[required]" name="po-num" id="po-num" value="0" />
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
											<input type="text" name="check-entfee" id="check-entfee" class="validate[required,custom[integer]]"/> 
										</div>

										<div class="check-wrapper">
											<input type="checkbox" class="checkbox" name="check-hasothers" id="check-hasothers" /><label class="check-label">Others</label>
											<input type="text" name="check-others" id="check-others" class="validate[required]"/> 
										</div>
						</div>
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

										<div class="check-wrapper">
											<input type="checkbox" class="checkbox" name="check-plantcast" id="check-plantcast"/><label class="check-label">PLANT CAST</label>
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
			<div class="dps-addproject-div">
				<center><p id="submit-beforenote">(please review the informations before clicking this button)</p></center>
				<input type="submit" id="addproject-submit" name="addproject-submit-form1a" value="ADD PROJECT">
			</div>

		</form>

		
	</div>
</div>			
