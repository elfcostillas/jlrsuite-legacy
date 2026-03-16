<?php

	 //var_dump($deptlist[0][0]);
	//display the department list

	 
	
?>

<div class="container">

		<br/>
		
		<h3 class="pg-heading">Pending Withdrawal Requests</h3><span class="pg-sub-heading">Listing of request that needs to be approved first before warehouse processing.</span>
		<hr>
		
		
		<?php
			//var_dump($pending);
		?>

		<div class="row">
			<!-- the filter here (employee name and submit button) -->
		</div>

		<div class="row" id="testid-only">
			<!-- the table here -->
			<div class="col-md-12">

	          


	          <table class="table" id="leave-status-table">
	              <thead>
	                  <tr class="tbl-row-hdr">
	                      <th>Withdrawal Slip No.</th>
	                      <th>Date / Time</th>
	                      <th>Charged Dept.</th>
	                      <th>Charged Unit</th>
	                      <th>Area</th>
	                      <th>Requested By</th>
	                      <th>Action</th>
	                  </tr>
	              </thead>

	              <tbody id="leave-status-recs">
	              	<?php

	              		$cnt = 0;
                              foreach ($pending_list as $pending) {

                                $cnt ++;

                    ?>

                    			<tr class="small tbl-row ws-row" id="<?php echo $pending->id; ?>">
                    				<td>
                    					<i class="fa fa-info-circle info-icon" aria-hidden="true"></i>
                    					<a href="#" title="click to view items" class="hylit itemdetails-tgl" id="<?php echo $pending->id; ?>">
                    						<?php echo $pending->ws_code; ?>
                    					</a>
		                            </td>

	                    			<td>
		                                <?php echo $pending->withdrawal_date; ?>
		                            </td>

		                            <td>
		                                <?php echo $pending->charged_dept; ?>
		                            </td>

		                            <td>
		                                <?php echo $pending->charged_unit; ?>
		                            </td>

		                            <td>
		                                <?php echo $pending->depot; ?>
		                            </td>

		                            <td>
		                                <?php echo $pending->req_by; ?>
		                            </td>
		                            
		                            <td>
		                                <a title="Approve Application" href="#" class="app-btn withdrawal-approve-but" id="<?php echo $pending->ws_code; ?>"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Approve</a>
		                            </td>
                    			</tr>

                    			<tr class="itemdetails-tbl-row collapse" id="<?php echo $pending->id; ?>">
								  <td colspan=7>
								    <div class="item-details-wrapper" id="<?php echo $pending->id; ?>">
								      
								    </div>
								  </td>
								</tr>
								

                    <?php
                              }
	              	?>
	              </tbody>



	          </table>


	           

	          <br />
	          <br />
	          <br />
	          <br />
	        </div>
		</div>



</div>



