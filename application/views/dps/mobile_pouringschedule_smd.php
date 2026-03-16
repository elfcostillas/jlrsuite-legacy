<!-- added by ralph april 7, 2014 mobile version -->
<div id="smd-mobilewrapper">


	<FORM method="POST" action="smd_approved_schedule">
		<input type="submit" name="scheduler-approved-submit" class="smdmobile-appbut" value="APPROVED">

		<table id="smd-mobile-table">
			<tr id="heading">
				<td colspan="2">CUSTOMER</td>
				<td>VOLUME</td>
				<td>TIME</td>
				<td>REMARKS</td>
			</tr>

			


							<?php

								$rows = $result->num_rows();
								$i = 0;
								$ctr = 0;


								while ( $i < $rows) {
						
									$row = $result->row($i);
									

									
									$id = $row->o202_id;
									$project_id = $row->project_id;
									$client_id = $row->client_id;

									$cust_name = $row->cust_name;
									$project_name = $row->proj_name;
									$project_loc = $row->proj_address;

									$proj_code = $row->proj_code;

									$str = $row->book_psi;
									$agg = $row->book_msa;
									$curing = $row->book_cd;
									$slump = $row->book_sp;
									$pouring = $row->pour_type;
									$structure = $row->structure;
									$remarks = $row->remarks;
									$estvolume = $row->batch_vol;

									$design = $str .'  '. $agg .'  '. $curing .'  '. $slump;
								

									$modified_date = $row->modified_date;
									$modified_time = $row->modified_time;

									$coor_status = $row->coor_status;
									$smd_status = $row->smd_status;

									$form_num = $row->form_no;
									$form_type = $row->form_type;
									$form = $form_type .'-'. $form_num;
							

									$plant = $row->batching_plant;

									$design_status = $row->design_status;

									if ($ctr % 2 == 0 ){
										echo "<tbody class='row' id='$id'>";
									}
									else{
										echo "<tbody class='rowalt' id='$id'>";
									}
									
							?>


							<!--
								tbody is the row wrapper for the table
								- detect for the alternate row
							-->


							
								<?php
									if($plant == 'Plant 4'){
										echo "<tr class='row smdmobile-plant'>";
									}else{
										echo "<tr class='row'>";
									}
								?>
								
									<td rowspan="2" colspan="2" class="clientname">
										<?php echo $cust_name ?><br />
										<?php echo $project_name ?><br />
										<?php echo $project_loc ?>
									</td>
									<td><?php echo $estvolume ?></td>
									<td><?php echo $modified_time ?></td>
									<td><?php echo $remarks ?></td>
							    </tr>

							    <tr class="row">
									<td colspan="3"><?php echo $design ?></td>
							    </tr>
							    
								<!-- FOR CVR REQUEST VIEW ONLY  WBSOLON 12/26/2019 -->
								<?php if(!$this->functionlist->isViewMobile($this->lvl)){ ?>
							    <tr class="row">
							    	<td><?php echo $pouring ?></td>
							    	<td><?php echo $structure ?></td>
							    	<td colspan="2"><?php echo $form ?></td>
							    	<?php
							    		if($smd_status == 'Approved' AND $coor_status == 'Approved'){
							    			echo "<td class='smdmobile-approved'>";
							    		}elseif ($smd_status == 'Approved' AND $coor_status == 'Unapproved'){
							    			echo "<td class='smdmobile-unapproved'>";
							    		}else{
							    			echo "<td>";
							    		}
							    	?>
							    	
							    		<?php 
							    			if($smd_status == 'Approved' OR $coor_status == 'Unapproved' OR $design_status == 'Cancelled'){
							    				echo "<input type='checkbox' value='$id' id='$id' class='smd_mobilecheck' disabled='true'>";
							    			}else{
							    				echo "<input type='checkbox' name='selectedsched[]' value='$id' id='$id' class='smd_mobilecheck'>";
							    			}

							    		?>
							    		<?php
										if($proj_code == '1'){
											echo("<button class='mobile-prep-but' title='prepaid' id='$id'>ALLOW</button>");
										}
										?>
							    	</td>
							    </tr>
							    <?php } ?>

							    <!-- hidden fields for the projects -->
								<input type="hidden" name="projectname<?php echo $id?>" value="<?php echo $project_name ?>"/>
								<!-- hidden fields for the projects modified date -->
								<input type="hidden" name="sched-datetime-input" value="<?php echo $modified_date ?>"/>

							</tbody>

								

							<?php
								$ctr++;
								$i++;
								}
							?>
		</table>
		<input type="hidden" name="whatday" value="<?php echo $whatday ?>" />
		<input type="submit" name="scheduler-approved-submit" class="smdmobile-appbut" value="APPROVED">
	</FORM>

</div>
	

	