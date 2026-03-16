<script type="text/javascript" src="<?php echo base_url("js/contract.js")?>"></script>

<div id="content" class="my_container">
	<div class="container-fluid">
		<?php echo form_open('contract-approve',"class ='frm-contract form-horizontal' id='form-contract' role='form'"); ?>
		<div class="row">
		<!-- panel -->
		<div class="panel panel-default">
			<div class="panel-heading" id="my_heading">
				<div class="panel-title">
					<div class="row">
						<div class="col-md-6 col-xs-12">
							<strong class="cntr-no">
							<span class="glyphicon glyphicon-list"></span>
							Contract No. <?php echo $data['revision'] == 0 ? $data['contract_no'] : $data['contract_no']."Rev".$data['revision']; ?>
							</strong>
							<input tyep="hidden" name='key' id='key' value="<?= set_value('cc_id',$data['cc_id']) ?>" class=hide>
							<input type="hidden" name = "contract_no" id= 'contract_no' class="form-control"  
								value= "<?= set_value('contract_no',$data['contract_no'])?>">
						</div>
						<div class="col-md-6 col-xs-12">
							<?php if($data['is_approved'] == 1): ?>
								<div class="col-md-12">
									<div class="approved text-primary">APPROVED</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<!-- 1st row -->
				<div class="row">
					<!-- left row -->
					<div class="col-md-5">
						<div class="form-group">
							<label for="contract" class="control-label col-md-4 col-xs-12">
								Contract Type
							</label>
							<div class="col-md-6 col-xs-12">
							<select name="contract_type" id="contract_type" class="form-control input-sm" disabled="disabled">
								 <?php foreach($cntr_opt as $key): ?>
									<?php if($data['contract_type'] === $key): ?>
										<option value="<?= $key ?>" selected='selected'><?= $key ?></option>
									<?php else: ?>
										<option value="<?= $key ?>"><?= $key ?></option>
									<?php endif; ?>
								 <?php endforeach; ?>
							</select>
							</div>
						</div>

						<div class="form-group">
							<label for="doc_date" class="control-label col-md-4">Date </label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group input-group-sm">
									<input type="text" name = "doc_date" id='doc_date' class="dtpicker form-control validate[required]" value="<?= set_value('doc_date',$data['doc_date']); ?>"	  
									disabled = 'disabled'/>
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
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
							<select name="client" id="client"  class="form-control input-sm" disabled="disabled">
								<?php foreach($client_list as $value ):?>
									<?php if($value->o5_id === $data['client_id']): ?>
										<option value="<?= $value->o5_id; ?>" selected="selected">
									<?php else: ?>	
										<option value="<?= $value->o5_id; ?>">
									<?php endif; ?>
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
								<textarea name="client_address" id="client_address" class="validate[required] text-input form-control input-sm" disabled="disabled" 
								/><?php  echo set_value('client_address',$data['client_address']); ?></textarea>
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
									<input type="text" name = "client_contact" id = "client_contact" class="form-control validate[required] input-sm" value="<?php echo set_value('client_contact',$data['client_contct_no']); ?>" disabled="disabled"/>
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
								<textarea name="client_terms" id="client_terms" cols="30" rows="1" class="form-control input-sm" disabled="disabled"><?= $data['terms'] ?></textarea>
							</div>
							<div class="err-msg text-danger col-md-offset-4 col-md-8">
								<?php echo form_error('client_terms'); ?>
							</div>
						</div>
					</div>
					<!-- right row -->
					<div class="col-md-offset-1 col-md-5">
						<div class="form-group">
							<input tyep="hidden" name='key' id='key' value="<?= set_value('cc_id',$data['cc_id']) ?>" class=hide>
							<label for="contract_no" class="control-label col-md-4">
								Contract No.
							</label>
							<div class="col-md-5">
								<input type="text" name = "contract_no" id= 'contract_no' class="form-control" disabled="disabled" value= "<?= set_value('contract_no',$data['contract_no'])?>" >
							</div>
						</div>
						<br><br>
						<div class="form-group">
							<label for="project" class="control-label col-md-4">
								Project
							</label>
							<div class="col-md-8">
								<input type="text" name = "project" id='project' class="form-control validate[required] input-sm" disabled="disabled" value="<?php echo set_value('project',$data['project_name']); ?>">
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
								<textarea name = "location" id='location' class="form-control validate[required] input-sm" cols="30" rows="2" disabled="disabled"><?php echo set_value('location',$data['project_loc']); ?></textarea>
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
								<input type="text" name = "est_volume" id='est_volume' class="form-control validate[required] input-sm" disabled="disabled" value="<?php echo set_value('est_volume',$data['est_vol']); ?>"/>
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
									<input type="text" name = "fromDate" id = "fromDate" class="fromDate form-control validate[required] input-sm" value="<?php echo set_value('fromDate',$data['from_duration']); ?>" disabled="disabled">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
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
									<div class="input-group-addon">To</div>
									<input type="text" name = "toDate" id = "toDate" class="toDate form-control validate[required] input-sm" value="<?php echo set_value('toDate',$data['to_duration']); ?>" disabled="disabled">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span</div>
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
							<input type="hidden" id='contr_id'>
							<div class="form-group">
								<label for="client_rep" class="control-label col-md-4">
									Client Rep.
								</label>
								<div class="col-md-8">
									<input type="text" name = "client_rep" id='client_rep' class="form-control validate[required] input-sm" disabled="disabled" value="<?php  echo set_value('client_rep',$data['client_rep']); ?>">
								</div>
								<div class="err-msg text-danger col-md-offset-4 col-md-8">
									<?php echo form_error('client_rep'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="client_pos" class="control-label col-md-4">
									Client position
								</label>
								<div class="col-md-8">
									<input type="text" name = "client_pos" id='client_pos' class="form-control input-sm" value="<?php echo set_value('client_pos' ,$data['client_rep_position']); ?>" disabled="disabled" >
								</div>
								<div class="err-msg text-danger col-md-offset-4 col-md-8">
									<?php echo form_error('client_pos'); ?>
								</div>
							</div>
						</div>
						<div class=" col-md-offset-1  col-md-5">
							<div class="form-group">
								<label for="sales_rep" class="control-label col-md-4">
									Sales Rep.
								</label>
								<div class="col-md-7">
									<!-- <input type="text" name = "sales_rep" id='sales_rep' class="form-control validate[required]"> -->
									<select name="sales_rep" id="sales_rep" class="form-control input-sm" disabled="disabled">
										<?php foreach($sales as $key): ?>
											<?php if($key->sales_id === $data['sales_rep']): ?>
												<option value="<?=$key->sales_id?>" <?php echo set_select('sales_rep', $key->sales_id,true) ?> >
											<?php  else: ?>
												<option value="<?=$key->sales_id?>" <?php echo set_select('sales_rep', $key->sales_id) ?> >
											<?php  endif; ?>

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
								<div class="col-md-7">
									<input type="text" name = "sales_contct_no1" id='sales_contct_no1' class="form-control validate[required] input-sm" disabled="disabled" value="<?php echo set_value('sales_contct_no1',$data['sales_contct_no1']) ?>">
								</div>
							</div>

							<div class="form-group">
								<label for="sales_contct_no2" class="control-label col-md-4">
									Contact No. 2
								</label>
								<div class="col-md-7">
									<input type="text" name = "sales_contct_no2" id='sales_contct_no2' class="form-control input-sm" disabled="disabled" value="<?php echo set_value('sales_contct_no2',$data['sales_contct_no2']) ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end of 2nd row -->
				<!--3rd row -->
				<div class="row">
					<div class="col-md-12">
						<div id="separator"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-12">
							<!-- Contract table manipulation powered by jquery -->
							<table id= "contr-tbl" class="table table-condensed">
								<caption>Details</caption>
								<thead></thead>
								<tbody>
									<tr></tr>
								</tbody>
							</table>
							
							<div class="col-md-12">
								<!-- <button type="button" class="btn btn-primary btn-xs" id='add_details'>Add Details</button> -->
								<!-- <button type="button" class="btn btn-info btn-xs" id="check">Check</button> -->
							</div>
						</div>
					</div>
				</div>
				<!-- end of 3rd -->
				<!-- 4th row -->
				<div class="row">
					<div class="col-md-12">
						<div id="separator"></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-12">	
							<!-- Load all active conditions here -->
							<h5><strong>Terms and Conditions</strong> </h5>
							<blockquote class="small">
								<ul style="list-style-type: none">
								<?php if($cntr_conditions !== null): ?>
									<?php foreach($cntr_conditions as $value ): ?>
										<li><label><input type="checkbox" name='conditions[]' disabled value="<?= $value->cd_id; ?>"
											<?php
												$is_checked = false; 
												foreach ($data_conditions as $row) 
												{
													if ($row->cd_id === $value->cd_id) 
													{
														$is_checked = true;
														break;
													}	
												} 
											?>
										 <?php echo set_checkbox('conditions[]',$value->cd_id,$is_checked); ?>> 
											<?= $value->condition_desc; ?>
											<ul style="list-style-type:square">
												<?php foreach($cntr_child_conditions  as $value2 ): ?>
													<?php if($value->cd_id === $value2->parent): ?>
														<li><?= $value2->condition_desc; ?></li>
													<?php endif; ?>
												<?php endforeach; ?>
											</ul>
										</label></li>
									<?php endforeach; ?>
								<?php endif; ?><br>	
								<li><label><input type="checkbox" name = 'chck_proc' checked disabled > 
									Sample Procedure: <textarea name="sample_proc" id="sample_proc" cols="100" class="form-control validate[required]" style="font-size: 80%;" disabled="disabled"><?php echo set_value('sample_proc',$data['sample_proc']); ?>
									</textarea></li>
								</label>
								</ul>
							</blockquote>
						</div>
						<div class="col-md-12">	
							<h5><strong>Additional Conditions</strong>(optional)</h5>
							<textarea name="add_condition" id="add_condition" cols="30" rows="2" class="form-control" disabled="disabled"><?php echo trim($data['additional_info']); ?></textarea>
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
								<div class="col-md-7">
									<input type="text" name = "client_sign_by" id='client_sign_by' class="form-control validate[required] input-sm" value="<?php  echo set_value('client_sign_by',$data['client_sign_by']); ?>" disabled="disabled">
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
								<div class="col-md-7">
									<input type="text" name = "client_sign_pos" id='client_sign_pos' class="form-control input-sm" value="<?php echo set_value('client_sign_pos',$data['client_sign_position']); ?>" disabled="disabled">
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
										<?php if($data['is_approved'] == 0 && ($lvl == 40 || $this->functionlist->isAdmin($lvl) || $this->functionlist->isCVR($lvl))): ?>
											<button class="btn btn-primary btn-block" type="Submit" name="cntr-approve" id="cntr-approve"><span class="glyphicon glyphicon-thumbs-up"> </span> Approve
											</button>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-offset-1 col-md-5">
									<div class="form-group">	
									<a href='contracts' class="btn btn-default btn-block" type="button" name="close" id="close"> Close</a>
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

<script>
	$(document).ready(function()
	{
		var interval = null;

		function tbl_readonly()
		{
			$(".edit_only").remove();
		}

		function fading() {
			var back = ["#ff0000","blue","gray"];
		  	var rand = back[Math.floor(Math.random() * back.length)];
		  	$('.approved').css({'color':rand,'border-color':rand});
			$(".approved").fadeOut(2000);
			$(".approved").fadeIn(2000);
		}

		$(function(){
			interval = setInterval(function(){ tbl_readonly();},1);
		});

		$(function(){
			setInterval(function(){ fading();},1000);
		});
	});
</script>