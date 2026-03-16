<div id="content" class="grid-940">
	
	<div id="advbooking-wrapper">
		<center><h1>Update Contracts</h1></center>
	</div>

	<div id="advbooking-conwrapper">
		<table id="mytable" class="scheduler-table">

			<tr id="heading">
				<th width="100" align="left">DATE</th>
				<th width="250" align="left">CLIENT</th>
				<th width="250" align="left">PROJECT</th>
				<th width="200" align="left">LOCATION</th>
				<th width="40" >CONTRACT NO.</th>
				<th width="50" >ACTION</th>
			</tr>


			<?php
					foreach ($projects as $project) {
						$proj_id = $project['o8_id'];
						$date = $project['date_added'];
						$customer = $project['customer'];
						$project_name = $project['project_name'];
						$location = $project['project_location'];
						$contract = $project['contract_no'];

		
			?>
				
						<tr class="items">	

							<td>
								<?php 
									$newDate = date("d-M-Y", strtotime($date));
									echo $newDate;
								?>
							</td>

							<td align="left"><?php echo $customer ?></td>

							<td align="left"><?php echo $project_name ?></td>

							<td align="left"><?php echo $location ?></td>

							<td align="center">
								<?php
								if ($contract == '' OR $contract == '0'){
									$blank_class = 'contract-blank';
								}else{
									$blank_class = 'none';
								}
								?>
								<input type="text" name="contract" id="contract<?php echo $proj_id ?>" class="contract-no-update <?php echo $blank_class ?>" value="<?php echo $contract ?>">
							</td>

							<td>
								<a href="#" class="contract-update-but" id="<?php echo $proj_id ?>">UPDATE</a>
							</td>

							
						</tr>
				<?php
					}
				?>
		</table>
	</div>

	<br /><br />

</div>