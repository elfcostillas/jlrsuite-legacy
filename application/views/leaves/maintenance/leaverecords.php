<?php
		//get the user level of the login person
		$lvl = $this->session->userdata('userlvl');
	?>
<div id="content" class="grid-940">
	<div class="content-body">
		<h3>Leave Records</h3>

		

		<?php 
			if($records <> null){
		?>
			<!-- Display the records here-->
				<table id="leave-table" padding="0" class="tables">

				<tr id="head">
					<th id="right-head">Name</th>
					<th class="heading">Date filed</th>
					<th class="heading">Date from</th>
					<th class="heading">Date To</th>
					<th class="heading">Reason</th>
					<th id="left-head">Action</th>
				</tr>

					
						<?php foreach ($records as $records_list): ?>
						
						
							<tr class="items" id="<?php echo $records_list->o200_id ?>">
								<?php
									$firstname = $this->leaveclass->convert_Big_Ntilde($records_list->first_name);
			            			$lastname = $this->leaveclass->convert_Big_Ntilde($records_list->last_name);
								?>
								<td align="left" id="left-item"><?php echo $lastname . "," . $firstname ?></td>
								<td align="center" style="padding : 0 4px;width:75px"><?php echo date('M d, Y',strtotime($records_list->date_filed)) ?></td>
								<td align="center" style="padding : 0 4px;width:75px"><?php echo date('M d, Y',strtotime($records_list->inclusive_from)) ?></td>
								<td align="center" style="padding : 0 4px;width:75px"><?php echo date('M d, Y',strtotime($records_list->inclusive_to)) ?></td>
								<td align="center" ><?php echo $records_list->reason ?></td>
								<td align="center" id="left">
									<?php
										if ($this->functionlist->isHR($lvl) OR $this->functionlist->isAdmin($lvl)){
											//if($this->functionlist->isHRStaff($lvl) == false){
												echo "<a href='editleave?id=$records_list->o200_id&emp_id=$records_list->emp_id' class='edit-leave-records fancybox.ajax'><img alt='' align='absmiddle' border='0' src='" . base_url('css/images/edit.png') . "' title='Edit leave'/></a>";
											//}
										}
										
									?>
									<!--
									<?php 
										echo $records_list->status . "&nbsp&nbsp&nbsp&nbsp";
										if ($records_list->status == 'Pending' OR $records_list->status == 'Approved' OR $records_list->status == 'Inactive' ){
											//can edit and can delete
											echo "<a href='editleave?id=$records_list->o200_id&emp_id=$records_list->emp_id' class='edit-leave-records fancybox.ajax'><img alt='' align='absmiddle' border='0' src='" . base_url('css/images/edit.png') . "' title='Edit leave'/></a>";
											echo "&nbsp&nbsp";
											echo "<a href='#' class='delete'><img alt='' align='absmiddle' border='0' src='" . base_url("css/images/delete.png") . "' title='Delete leave'/></a>";
											echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
										}


										if ($records_list->status == 'Active' OR $records_list->status == ''){
											//can edit
											echo "<a href='edit_leave' class='fancybox.iframe edit-leave-records'><img alt='' align='absmiddle' border='0' src='" . base_url("css/images/edit.png") . "' title='Edit leave'/></a>";
											echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
										}

									?>
								-->
									
								</td>
										
							</tr>
					<?php endforeach ?>
			</table>

		<?php
			}
			else{
				echo "<div class='error-notify'><p>There is no record of employees available</p></div>";
			}
		?>
			

					
	</div>				

</div>
