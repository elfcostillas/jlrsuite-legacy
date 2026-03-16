<script type="text/javascript" src="<?php echo base_url("js/contract.js")?>"></script>

<div id="content" class="my_container">
	<div class="container-fluid">
		<?php echo form_open('contract-insert',"class ='frm-contract form-horizontal' id='form-contract' role='form'"); ?>

		<div class="row">
		<!-- panel -->
		<div class="panel panel-default">
			<div class="panel-heading" id="my_heading">
				<div class="panel-title">
					<!-- <strong>Cntract No.</strong> -->
					<input tyep="hidden" name='key' id='key' class=hide>
					<span class="glyphicon glyphicon-list"></span>
					<span class="pull-right glyphicon glyphicon-plus" ></span>
				</div>
			</div>
			<div class="panel-body">
				<!-- 1st row -->
				<div class="row">
					<!-- left row -->
					<div class="col-md-5">
						<div class="form-group">
							<label for="contract" class="control-label col-md-4">
								Contract Type
							</label>
							<div class="col-md-8 col-xs-12">
							<?php echo form_dropdown('contract_type', $cntr_opt, 'Straight Contract','class="form-control input-sm" id="contract_type" '); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="doc_date" class="control-label col-md-4">Date </label>
							<div class="col-md-8 col-xs-12">
								<div class="input-group input-group-sm">
									<input type="text" name = "doc_date" id='doc_date' class="dtpicker form-control" value="<?= set_value('doc_date'); ?>"
									/>
									<div class="input-group-addon">
										<a  class="date_click">
											<span class="glyphicon glyphicon-calendar"></span>
										</a>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="form-group">
							<label for="client" class="control-label col-md-4">
								Client Name
							</label>
							<div class="col-md-8">
							<select name="client" id="client"  class="form-control input-sm">
								<?php foreach($client_list as $value ):?>
									<option value="<?= $value->o5_id; ?>">
										<?= $value->customer_name; ?>
									</option>
								<?php endforeach; ?>
							</select>
							</div>
						</div>
						<div class="form-group">
							<label for="client_address" class="control-label col-md-4">
								Address
							</label>
							<div class="col-md-8">
								<textarea name="client_address" id="client_address" rows="3" class="validate[required] text-input form-control input-sm"
								/><?php  echo set_value('client_address'); ?></textarea>
							</div>
							<div class="err-msg text-danger col-md-offset-4 col-md-8">
								<?php echo form_error('client_address'); ?>
							</div>
						</div>
						
						<div class="form-group">
							<label for="client_contact" class="control-label col-md-4">
								Tel. no.
							</label>
							<div class="col-md-8">
								<div class="input-group input-group-sm">
									<input type="text" name = "client_contact" id = "client_contact" class="form-control validate[required] input-sm" value="<?php echo set_value('client_contact'); ?>"/>
									<div class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></div>
								</div>
							</div>
							<div class="err-msg text-danger col-md-offset-4 col-md-8">
								<?php echo form_error('client_contact'); ?>
							</div>
						</div>

						<div class="form-group">
							<label for="client_terms" class="control-label col-md-4">
								Terms
							</label>
							<div class="col-md-8">
								<textarea name="client_terms" id="client_terms" cols="10" rows="2" class="form-control input-sm"></textarea>
							</div>
							<div class="err-msg text-danger col-md-offset-4 col-md-8">
								<?php echo form_error('client_terms'); ?>
							</div>
						</div>
					</div>
					<!-- right row -->
					<div class="col-md-offset-1 col-md-5">
						<div class="form-group">
							<label for="project" class="control-label col-md-4">
								Project
							</label>
							<div class="col-md-8">
								<input type="text" name = "project" id='project' class="form-control validate[required] input-sm" value="<?php echo set_value('project'); ?>">
							</div>
							<div class="err-msg text-danger col-md-offset-4 col-md-8">
								<?php echo form_error('project'); ?>
							</div>
						</div>

						<div class="form-group">
							<label for="location" class="control-label col-md-4">
								Location
							</label>
							<div class="col-md-8">
								<textarea name = "location" id='location' class="form-control validate[required] input-sm" cols="30" rows="2"><?php echo set_value('location'); ?></textarea>
							</div>
							<div class="err-msg text-danger col-md-offset-4 col-md-8">
								<?php echo form_error('location'); ?>
							</div>
						</div>

						<div class="form-group">
							<label for="est_volume" class="control-label col-md-4">
								Est. Volume
							</label>
							<div class="col-md-8">
								<input type="text" name = "est_volume" id='est_volume' class="form-control  input-sm" value="<?php echo set_value('est_volume'); ?>"/>
							</div>
							<div class="err-msg text-danger col-md-offset-4 col-md-8">
								<?php echo form_error('est_volume'); ?>
							</div>
						</div>
						
						<!-- Duration -->
						<div class="form-group">
							<label for="fromDate" class="control-label col-md-4">Duration</label>
							<div class="col-md-8">
								<div class="input-group input-group-sm">
									<div class="input-group-addon">From</div>
									<input type="text" name = "fromDate" id = "fromDate" class="date-month form-control input-sm" value="<?php echo set_value('fromDate'); ?>">
									<div class="input-group-addon">
										<a  class="fromDate_Click"><span class="glyphicon glyphicon-calendar"></span></a>
									</div>
								</div>
							</div>
							<div class="err-msg text-danger col-md-offset-4 col-md-4">
								<?php echo form_error('fromDate'); ?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-4 col-md-8">
								<div class="input-group input-group-sm">
									<div class="input-group-addon">To &nbsp;&nbsp;&nbsp;&nbsp;</div>
									<input type="text" name = "toDate" id = "toDate" class="date-month form-control input-sm" value="<?php echo set_value('toDate'); ?>">
									<div class="input-group-addon">
										<a class="toDate_Click"><span class="glyphicon glyphicon-calendar"></span></a></div>
									</div>
							</div>
							<div class="err-msg text-danger col-md-offset-8 col-md-4">
								<?php echo form_error('toDate'); ?>
							</div>
						</div>
					</div>
				</div>
				<!-- end of first row -->
				<!-- 2nd row -->
				<div class="row">
					<div class="col-md-12">
						<div id="separator"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-5">
							<input type="hidden" id='key'>
							<div class="form-group">
								<label for="name_prefix" class="control-label col-md-4">
									Prefix	
								</label>
								<div class="col-md-4">
									<select name="client_rep_prefix" id="name_prefix" class="form-control">
										<?php foreach($name_prefix as $prefix): ?>
											<option value="<?= $prefix->cbo_value; ?>"><?= $prefix->cbo_display; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="client_rep" class="control-label col-md-4">
									Client Rep.
								</label>
								<div class="col-md-8">
										<input type="text" name = "client_rep" id='client_rep' class="form-control validate[required] input-sm" value="<?php  echo set_value('client_rep'); ?>">
								</div>
								<div class="err-msg text-danger col-md-offset-4 col-md-8">
									<?php echo form_error('client_rep'); ?>
								</div>
							</div>

							<div class="form-group">
								<label for="client_pos" class="control-label col-md-4">
									Client Pos.
								</label>
								<div class="col-md-8">
									<select name="client_pos" id="client_pos" class="form-control input-sm">
										<?php foreach ($cust_position as $position): ?>
											<option value="<?= $position->cbo_value; ?>"><?= $position->cbo_display; ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="err-msg text-danger col-md-offset-4 col-md-8">
									<?php echo form_error('client_pos'); ?>
								</div>
							</div>

							<div class="form-group">
								<label for="client_rep_no" class="control-label col-md-4">
									Contact No.
								</label>
								<div class="col-md-8">
									<input type="text" name = "client_rep_no" id='client_rep_no' class="form-control input-sm" value="<?php echo set_value('client_rep_no'); ?>">
								</div>
								<div class="err-msg text-danger col-md-offset-4 col-md-8">
									<?php echo form_error('client_rep_no'); ?>
								</div>
							</div>
						</div>
					
						<!-- right -->
						<div class=" col-md-offset-1  col-md-5">
							<div class="form-group">
								<label for="sales_rep" class="control-label col-md-4">
									Sales Rep.
								</label>
								<div class="col-md-8">
									<!-- <input type="text" name = "sales_rep" id='sales_rep' class="form-control validate[required]"> -->
									<select name="sales_rep" id="sales_rep" class="form-control input-sm">
										<?php foreach($sales as $key): ?>
											<option value="<?=$key->sales_id?>" <?php echo set_select('sales_rep', $key->sales_id) ?> >
												<?php $name = $key->fname.' '.substr($key->mname,0,1).'. '.$key->lname ?>
												<?php $name = $key->prefix !== null && $key->prefix !== '' ? $key->prefix.' '.$name : $name; ?>
												<?php $name = $key->suffix !== null && $key->suffix !== ''? $name.' '.$key->suffix :$name; ?>
												<?php echo $name; ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="err-msg text-danger col-md-offset-4 col-md-8">
									<?php echo form_error('sales_rep'); ?>
								</div>
							</div>

							<div class="form-group">
								<label for="sales_contct_no1" class="control-label col-md-4">
									Contact No. 1
								</label>
								<div class="col-md-8">
									<input type="text" name = "sales_contct_no1" id='sales_contct_no1' class="form-control validate[required] input-sm">
								</div>
							</div>

							<div class="form-group">
								<label for="sales_contct_no2" class="control-label col-md-4">
									Contact No. 2
								</label>
								<div class="col-md-8">
									<input type="text" name = "sales_contct_no2" id='sales_contct_no2' class="form-control input-sm">
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end of 2nd row -->
				<!--  3rd row -->
				<div class="row">
					<div class="col-md-12">
						<div id="separator"></div>
						<div class="col-md-12">
							<!-- Contract table manipulation powered by jquery -->
							<caption>Details</caption>
							<table id = "contr-tbl" class ="table table-condensed">
								<thead></thead>
								<tbody></tbody>
							</table>
						</div>
						<div class="col-md-12">
							<button type="button" class="btn btn-primary btn-xs" id='add_details'>Add Details</button>
						</div>
					</div>
				</div>
				<!-- end of 3rd row -->
				<!-- 4th row -->
				<div class="row">
					<div class="col-md-12">
						<div id="separator"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-12">
							<!-- Load all active conditions here -->
							<h5><strong>Terms and Conditions</strong> </h5>
							<!-- Terms and Conditions tabs -->
							  <!-- Nav tabs -->
							  <ul class="nav nav-tabs" role="tablist">
							    <li role="presentation" class="active"><a href="#standard" aria-controls="Standard" role="tab" data-toggle="tab">Standard</a></li>
							    <li role="presentation"><a href="#pump_charges" aria-controls="profile" role="tab" data-toggle="tab">Pump Charges</a></li>
							  </ul>

							  <!-- Tab panes -->
							  <div class="tab-content">
							  	<div role="tabpanel" class="tab-pane" id="pump_charges"> <!-- tabpanel -->
						  			<ul style="list-style-type: none;">
										<?php foreach($pumps as $pump): ?>
										<li>
											<div class="checkbox">
											<label >
												<input type="checkbox" name='pumps[]' class="pump" 
												value="<?= $pump->pump_id ?>" >
												<?= $pump->pump_desc; ?>
												<a href="#my_modal" data-toggle= "modal" class="btn badge edit_pump hide">edit</a>
											</label>
											</div>
											<ul class="<?= 'charges'.$pump->pump_id; ?> list-group"></ul>
										</li>
										<?php endforeach; ?>
									</ul>
									<div class="edit_charges"></div>
								</div> 

							    <!-- end of tabpanel -->
							    <div role="tabpanel" class="tab-pane active" id="standard">
									<blockquote class="small">
										<ul style="list-style-type:none">
											<?php if($cntr_conditions !== null): ?>
												<?php foreach($cntr_conditions as $value ): ?>
													<li>
													<label>
														<input type="checkbox" name='conditions[]' value="<?= $value->cd_id; ?>" <?php echo set_checkbox('conditions[]',$value->cd_id); ?> <?php $checked = ($value->is_default) ? 'checked' : '' ; echo $checked; ?>> 
														<?= $value->condition_desc; ?>
														<ul style="list-style-type:square">
															<?php foreach($cntr_child_conditions  as $value2 ): ?>
																<?php if($value->cd_id === $value2->parent): ?>
																	<li><?= $value2->condition_desc; ?></li>
																<?php endif; ?>
															<?php endforeach; ?>
														</ul>
													</label>
													</li>
												<?php endforeach; ?>
											<?php endif; ?>
											<li><label><input type="checkbox" name = 'chck_proc' checked disabled > 
												Sampling Procedure: <textarea name="sample_proc" id="sample_proc" cols="100" rows="4" class="form-control validate[required]" style="font-size: 90%;"><?php echo set_value('sample_proc'); ?>For every 75.0 m³ volume, one set of 6 cylinder samples (0 client copy; 6 JLR copy) is to be taken randomly from a single batch or one mixer truck.
												</textarea>
											</label></li>
										</ul>
									</blockquote>
									</div>
							    </div>
							  </div>
						</div>
						<div class="col-md-12">	
							<h5><strong>Additional Conditions</strong>(optional)</h5>
							<textarea name="add_condition" id="add_condition" cols="30" rows="4" class="form-control"></textarea>
						</div>
					</div>
				</div>
				<!-- end of 4th row -->
				
				<!-- 5th row -->
				<div class="row">
					<div class="col-md-12">	
						<div id="separator"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-5">	
							<input type="hidden" id='contr_id'>
							<div class="form-group">
								<label for="client_sign_by" class="control-label col-md-4">
									Client sign by.
								</label>
								<div class="col-md-8">
									<input type="text" name = "client_sign_by" id='client_sign_by' class="form-control input-sm" value="<?php  echo set_value('client_sign_by'); ?>">
								</div>
								<div class="err-msg text-danger col-md-offset-4 col-md-8">
									<?php echo form_error('client_sign_by'); ?>
								</div>
							</div>
						</div>
						<div class="col-md-5">	
							<div class="form-group">
								<label for="client_sign_pos" class="control-label col-md-4">
									Client position
								</label>
								<div class="col-md-8">
									<input type="text" name = "client_sign_pos" id='client_sign_pos' class="form-control input-sm" value="<?php echo set_value('client_sign_pos'); ?>">
								</div>
								<div class="err-msg text-danger col-md-offset-4 col-md-8">
									<?php echo form_error('client_sign_pos'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end of 5th row -->
			</div>
			<div class="panel-footer">
				<!-- 6th row -->
				<div class="row">
					<div class="col-md-12">
						<div id="separator"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-12">
								<div class="col-md-offset-8">
								<div class="col-md-5">
									<div class="form-group">	
									<button class="btn btn-primary btn-block" type="Submit" name="cntr-save" id="cntr-save">
									<span class="glyphicon glyphicon-save">  </span> Save
									</button>
									</div>
								</div>
								<div class="col-md-offset-1 col-md-5">
										<div class="form-group">	
									<a href="contracts" class="btn btn-default btn-block" type="button" name="close" id="close"> Close</a>
									</div>
								</div>
								</div>
						</div>
					</div>
				</div>
				<!-- end of 6th row -->
			</div>
		</div>
		<!-- end of panel -->
		</div>
		<?php echo form_close(); ?>
	</div>
</div> 
<?php $this->load->view('contracts/contract_modal'); ?>
