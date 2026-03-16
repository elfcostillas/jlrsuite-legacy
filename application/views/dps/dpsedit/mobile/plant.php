<table id="m-acctg-tbl">
		
		<tr id="heading">
			<th colspan="2">CUSTOMER</th>
			<th>TIME (hours)</th>
			<th>BATCHING PLANT</th>
			<!-- FOR CVR REQUEST MOBILE VIEW ONLY  WBSOLON -->
			<?php if(!$this->functionlist->isViewMobile($this->lvl)){ ?>
			<th>ACCEPT</th>
			<?php } ?>
		</tr>

		
		<?php
			$rows = $result->num_rows();
			$i = 0;

			
			while ( $i < $rows) {
				$row = $result->row($i);
				
				$id = $row->o202_id;
				$project_id = $row->project_id;
				$client_id = $row->client_id;
				$form_no = $row->form_no;

				$cust_name = strtoupper($row->cust_name);
				$project_name = strtoupper($row->proj_name);
				$project_loc = strtoupper($row->proj_address);
				$batching_plant = $row->batching_plant;

				$modified_date = $row->modified_date;
				$modified_time = $row->modified_time;

				$coor_status = $row->coor_status;
				$smd_status = $row->smd_status;

				$design_status = $row->design_status;

				$serv_engr = $row->service_engr;

			?>

		<?php 
			if($batching_plant == ''){
				$dpsedit_class = 'm_dpsedit-pending';
			}else{
				$dpsedit_class = '';
			}
		?>

		<tbody id="<?php echo $id ?>" class="<?php echo $dpsedit_class ?>">
			<tr class="row">
				<td rowspan="2" colspan="2" class="clientname">
					<p><strong><?php echo $cust_name ?></strong></p>
					<p><strong><?php echo $project_name ?></strong></p>	
					<p><?php echo $project_loc ?></p>
				</td>

				<td align="center"><?php echo $modified_time ?></td>

				<!-- FOR CVR REQUEST MOBILE VIEW ONLY  WBSOLON -->
				<?php if(!$this->functionlist->isViewMobile($this->lvl)){ ?>
				<td align="center">
					
					<select autocomplete="off" name="batch-plant" id="batch-plant<?php echo $id ?>" class="batch-plant m_plant-remarks">

					<?php
						switch ($batching_plant) {
							case 'Plant 3':
								echo "<option value=''>Select Plant</option>";
								echo "<option value='Plant 3' selected='true' >Plant 3</option>";
								echo "<option value='Plant 4'>Plant 4</option>";
								echo "<option value='Plant 5'>Plant 5</option>";
								break;
							
							case 'Plant 4':
								echo "<option value=''>Select Plant</option>";
								echo "<option value='Plant 3'>Plant 3</option>";
								echo "<option value='Plant 4' selected='true' >Plant 4</option>";
								echo "<option value='Plant 5'>Plant 5</option>";
								break;

							case 'Plant 5':
								echo "<option value=''>Select Plant</option>";
								echo "<option value='Plant 3'>Plant 3</option>";
								echo "<option value='Plant 4'>Plant 4</option>";
								echo "<option value='Plant 5' selected='true'>Plant 5</option>";
								break;

							default:
								echo "<option value=''>Select Plant</option>";
								echo "<option value='Plant 3'>Plant 3</option>";
								echo "<option value='Plant 4'>Plant 4</option>";
								echo "<option value='Plant 5'>Plant 5</option>";
								break;
						}
					?>
					
				</select>
				</td>
				<?php }else{ ?>
				<td align="center" style="font-size: 1.2em;"><?php echo $batching_plant ?></td>
				<?php } ?>


				<!-- FOR CVR REQUEST MOBILE VIEW ONLY  WBSOLON -->
				<?php if(!$this->functionlist->isViewMobile($this->lvl)){ ?>
				<td  align="center" rowspan="2">
					<input type="checkbox" name="spcheck" class="spcheck" id="<?php echo $id ?>">
					<a href="#tab3" id="supervisor-updatebut<?php echo $id ?>" class="m_plant-updatebut m-supervisor-updatebut">UPDATE</a>
					<input type="hidden" name="sched_date" value="<?php echo $modified_date ?>" />
				</td>
				<?php } ?>
		    </tr>

		    <tr class="row">
		    	<!-- FOR CVR REQUEST MOBILE VIEW ONLY  WBSOLON -->
				<?php if(!$this->functionlist->isViewMobile($this->lvl)){ ?>
				<td align="center" id="left" colspan="2">
					<select autocomplete="off" name="servengr" id="servengr<?php echo $id ?>" class="servengr m_plant-remarks">
						<option value=""></option>
						<?php
							
							foreach($serviceengr as $serviceengr_list){
									$service_engr = $serviceengr_list;
									if ($serv_engr == $service_engr){
										echo '<option selected="true" value="' . $service_engr . '">' . $service_engr .'</option>';
									}else{
										echo '<option value="' . $service_engr . '">' . $service_engr .'</option>';
									}
							}			
						?>
					</select>
				</td>
				<?php }else { ?>
				<td align="center" id="left" colspan="2"><?php echo $serv_engr ?> </td>
				<?php }?>
		    </tr>
		</tbody>

		<?php
			$i++;
			}
		?>
	</table>
