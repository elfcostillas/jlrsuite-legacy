
<!-- <button id="go-left">&laquo;</button> <button id="go-right">&raquo;</button> -->
<div class="container slider" id="week-sched">

	<div>
		<div class="column left first" id="cont-1">
			<div class="weekly-wrapper">
				<h3 class="weekly-date">
					<?php 
						$date = date_create($sched_date[1]);
						echo date_format($date, 'l');
					?>
					<span>
						<?php 
						$date = date_create($sched_date[1]);
						echo date_format($date, 'F d, Y');
						?>
					</span>
				</h3>
				<a href="#" class="lock-button" id="day1"><i class="fa fa-unlock-alt"></i></a>
				
				<a href="" class="waiting-button" id="day1"><i class="fa fa-list"></i></a>
				<input type="hidden" class="sched-date" value="<?php echo $sched_date[1] ?>">
			</div>
			

			<div id="day1" class="weekly-totals">
	            <p><span class="text">Total Vol. (<i class="tot-cnt total-rows"><?php echo $total_rows[1] ?></i>)</span><span class="cnt total-vol"><?php echo $total_volume[1] ?></span></p>
	            <p><span class="text">North (<i class="tot-cnt total-north"><?php echo $total_north_rows[1] ?></i>)</span><span class="cnt total-north-vol"><?php echo $total_north[1] ?></span></p>
	            <p><span class="text">South (<i class="tot-cnt total-south"><?php echo $total_south_rows[1] ?></i>)</span><span class="cnt total-south-vol"><?php echo $total_south[1] ?></span></p>

			</div>
			<div class="sales-code-legend">
				<span class="north">NORTH</span>
				<span class="south">SOUTH</span>
				<span class="m3">RML</span>
				<span class="m4">CTL</span>
				<span class="m5">NBA</span>
				<span class="m6">APJ</span>
				<span class="m7">JTA</span>
			</div>

			<ul class="sortable-list" id="day1">

				<?php
					$res_count = count($scheds1);

					if($res_count > 0){
						
						foreach ($scheds1 as $row)
			            {
			               $sched_id =  $row['o202_id'];
			               $proj_id =  $row['project_id'];
			               $proj_name =  $row['proj_name'];
			               $cust_name =  $row['cust_name'];
			               $proj_address =  $row['proj_address'];
			               $proj_sales_rep =  $row['special_se'];
			               $plant =  $row['batching_plant'];
			               $sched_time =  $row['modified_time'];
			               
			               $vol =  $row['batch_vol'];

			               

			               switch ($plant) {
			               	case 'Plant 3':
			               		$plant_class = 'north-plant';
			               		$batching_plant = 'north';
			               		break;
			               	case 'Plant 4':
			               		$plant_class = 'south-plant';
			               		$batching_plant = 'south';
			               		break;
			               }
			    ?>

			               <li class="dropdown" id="<?php echo $sched_id ?>">
			               	<span class="sales-code-marker <?php echo strtolower($proj_sales_rep) ?>"></span>
			               	<input type="hidden" id="vol" class="<?php echo $batching_plant ?>" value="<?php echo $vol ?>">
						     <a href="#" class="sched-cont project-dropdown" data-toggle="dropdown" id="<?php echo $proj_id ?>">
						     	
						     	<div class="sched-wrapper">
						     		<?php echo $cust_name ?>
							     	<span><?php echo $proj_name ?></span>
							     	<span><?php echo $proj_address . ' - ' . $sched_time?></span>
						     	</div>
						     	
						     	
					     		<span class="sched-vol-wrapper <?php echo $plant_class ?>">
					     			<i class="sched-vol"><?php echo $vol ?></i>
					     		</span>
						     	
						     </a>
						   </li>
				<?php
			            }
			            


					}else{
						echo "no records";
					}
				?> 
			</ul>
		</div>

   
		<div class="column left" id="cont-2">
			<div class="weekly-wrapper">
				<h3 class="weekly-date">
					<?php 
						$date = date_create($sched_date[2]);
						echo date_format($date, 'l');
					
					?>
					<span>
						<?php 
						$date = date_create($sched_date[2]);
						echo date_format($date, 'F d, Y');
						?>
					</span>
				</h3>
				<a href="#" class="lock-button" id="day2"><i class="fa fa-unlock-alt"></i></a>
				
				<a href="" class="waiting-button"><i class="fa fa-list"></i></a>
				<input type="hidden" class="sched-date" value="<?php echo $sched_date[2] ?>">
			</div>
			
			<div id="day2" class="weekly-totals">
	            <p><span class="text">Total Vol. (<i class="tot-cnt total-rows"><?php echo $total_rows[2] ?></i>)</span><span class="cnt total-vol"><?php echo $total_volume[2] ?></span></p>
	            <p><span class="text">North (<i class="tot-cnt total-north"><?php echo $total_north_rows[2] ?></i>)</span><span class="cnt total-north-vol"><?php echo $total_north[2] ?></span></p>
	            <p><span class="text">South (<i class="tot-cnt total-south"><?php echo $total_south_rows[2] ?></i>)</span><span class="cnt total-south-vol"><?php echo $total_south[2] ?></span></p>

			</div>
			<div class="sales-code-legend">
				<span class="north">NORTH</span>
				<span class="south">SOUTH</span>
				<span class="m3">RML</span>
				<span class="m4">CTL</span>
				<span class="m5">NBA</span>
				<span class="m6">APJ</span>
				<span class="m7">JTA</span>
			</div>

			<ul class="sortable-list" id="day2">

				<?php
					$res_count = count($scheds2);
					if($res_count > 0){
						
						foreach ($scheds2 as $row)
			            {
			               $sched_id =  $row['o202_id'];
			               $proj_id =  $row['project_id'];
			               $proj_name =  $row['proj_name'];
			               $cust_name =  $row['cust_name'];
			               $proj_address =  $row['proj_address'];
			               $proj_sales_rep =  $row['special_se'];
			               $plant =  $row['batching_plant'];
			               $sched_time =  $row['modified_time'];
			               
			               $vol =  $row['batch_vol'];


			               switch ($plant) {
			               	case 'Plant 3':
			               		$plant_class = 'north-plant';
			               		$batching_plant = 'north';
			               		break;
			               	case 'Plant 4':
			               		$plant_class = 'south-plant';
			               		$batching_plant = 'south';
			               		break;
			               }
			    ?>

			               <li class="dropdown" id="<?php echo $sched_id ?>">
			               	<span class="sales-code-marker <?php echo strtolower($proj_sales_rep) ?>"></span>
			               	<input type="hidden" id="vol" class="<?php echo $batching_plant ?>" value="<?php echo $vol ?>">
						     <a href="#" class="sched-cont project-dropdown" data-toggle="dropdown" id="<?php echo $proj_id ?>">
						     	
						     	<div class="sched-wrapper">
						     		<?php echo $cust_name ?>
							     	<span><?php echo $proj_name ?></span>
							     	<span><?php echo $proj_address . ' - ' . $sched_time?></span>
						     	</div>
						     	
						     	
					     		<span class="sched-vol-wrapper <?php echo $plant_class ?>">
					     			<i class="sched-vol"><?php echo $vol ?></i>
					     		</span>
						     	
						     </a>
						   </li>
				<?php
			            }


					}else{
						echo "no records";
					}
				?> 
			</ul>
		</div>


		<div class="column left" id="cont-3">
			<div class="weekly-wrapper">
				<h3 class="weekly-date">
					<?php 
						$date = date_create($sched_date[3]);
						echo date_format($date, 'l');
					
					?>
					<span>
						<?php 
						$date = date_create($sched_date[3]);
						echo date_format($date, 'F d, Y');
						?>
					</span>
				</h3>
				<a href="#" class="lock-button" id="day3"><i class="fa fa-unlock-alt"></i></a>
				
				<a href="" class="waiting-button"><i class="fa fa-list"></i></a>
				<input type="hidden" class="sched-date" value="<?php echo $sched_date[3] ?>">
			</div>
			

			<div id="day3" class="weekly-totals">
	            <p><span class="text">Total Vol. (<i class="tot-cnt total-rows"><?php echo $total_rows[3] ?></i>)</span><span class="cnt total-vol"><?php echo $total_volume[3] ?></span></p>
	            <p><span class="text">North (<i class="tot-cnt total-north"><?php echo $total_north_rows[3] ?></i>)</span><span class="cnt total-north-vol"><?php echo $total_north[3] ?></span></p>
	            <p><span class="text">South (<i class="tot-cnt total-south"><?php echo $total_south_rows[3] ?></i>)</span><span class="cnt total-south-vol"><?php echo $total_south[3] ?></span></p>

			</div>
			<div class="sales-code-legend">
				<span class="north">NORTH</span>
				<span class="south">SOUTH</span>
				<span class="m3">RML</span>
				<span class="m4">CTL</span>
				<span class="m5">NBA</span>
				<span class="m6">APJ</span>
				<span class="m7">JTA</span>
			</div>

			<ul class="sortable-list" id="day3">

				<?php
					$res_count = count($scheds3);
					if($res_count > 0){
						
						foreach ($scheds3 as $row)
			            {
			               $sched_id =  $row['o202_id'];
			               $proj_id =  $row['project_id'];
			               $proj_name =  $row['proj_name'];
			               $cust_name =  $row['cust_name'];
			               $proj_address =  $row['proj_address'];
			               $proj_sales_rep =  $row['special_se'];
			               $plant =  $row['batching_plant'];
			               $sched_time =  $row['modified_time'];
			               
			               $vol =  $row['batch_vol'];


			               switch ($plant) {
			               	case 'Plant 3':
			               		$plant_class = 'north-plant';
			               		$batching_plant = 'north';
			               		break;
			               	case 'Plant 4':
			               		$plant_class = 'south-plant';
			               		$batching_plant = 'south';
			               		break;
			               }
			    ?>

			               <li class="dropdown" id="<?php echo $sched_id ?>">
			               	<span class="sales-code-marker <?php echo strtolower($proj_sales_rep) ?>"></span>
			               	<input type="hidden" id="vol" class="<?php echo $batching_plant ?>" value="<?php echo $vol ?>">
						     <a href="#" class="sched-cont project-dropdown" data-toggle="dropdown" id="<?php echo $proj_id ?>">
						     	
						     	<div class="sched-wrapper">
						     		<?php echo $cust_name ?>
							     	<span><?php echo $proj_name ?></span>
							     	<span><?php echo $proj_address . ' - ' . $sched_time?></span>
						     	</div>
						     	
						     	
					     		<span class="sched-vol-wrapper <?php echo $plant_class ?>">
					     			<i class="sched-vol"><?php echo $vol ?></i>
					     		</span>
						     	
						     </a>
						   </li>
				<?php
			            }


					}else{
						echo "no records";
					}
				?> 
			</ul>
		</div>

		<div class="column left" id="cont-4">
			<div class="weekly-wrapper">
				<h3 class="weekly-date">
					<?php 
						$date = date_create($sched_date[4]);
						echo date_format($date, 'l');
					
					?>
					<span>
						<?php 
						$date = date_create($sched_date[4]);
						echo date_format($date, 'F d, Y');
						?>
					</span>
				</h3>
				<a href="#" class="lock-button" id="day4"><i class="fa fa-unlock-alt"></i></a>
				
				<a href="" class="waiting-button"><i class="fa fa-list"></i></a>
				<input type="hidden" class="sched-date" value="<?php echo $sched_date[4] ?>">
			</div>
			

			<div id="day4" class="weekly-totals">
	            <p><span class="text">Total Vol. (<i class="tot-cnt total-rows"><?php echo $total_rows[4] ?></i>)</span><span class="cnt total-vol"><?php echo $total_volume[4] ?></span></p>
	            <p><span class="text">North (<i class="tot-cnt total-north"><?php echo $total_north_rows[4] ?></i>)</span><span class="cnt total-north-vol"><?php echo $total_north[4] ?></span></p>
	            <p><span class="text">South (<i class="tot-cnt total-south"><?php echo $total_south_rows[4] ?></i>)</span><span class="cnt total-south-vol"><?php echo $total_south[4] ?></span></p>

			</div>
			<div class="sales-code-legend">
				<span class="north">NORTH</span>
				<span class="south">SOUTH</span>
				<span class="m3">RML</span>
				<span class="m4">CTL</span>
				<span class="m5">NBA</span>
				<span class="m6">APJ</span>
				<span class="m7">JTA</span>
			</div>

			<ul class="sortable-list" id="day4">

				<?php
					$res_count = count($scheds4);
					if($res_count > 0){
						
						foreach ($scheds4 as $row)
			            {
			               $sched_id =  $row['o202_id'];
			               $proj_id =  $row['project_id'];
			               $proj_name =  $row['proj_name'];
			               $cust_name =  $row['cust_name'];
			               $proj_address =  $row['proj_address'];
			               $proj_sales_rep =  $row['special_se'];
			               $plant =  $row['batching_plant'];
			               $sched_time =  $row['modified_time'];
			               
			               $vol =  $row['batch_vol'];


			               switch ($plant) {
			               	case 'Plant 3':
			               		$plant_class = 'north-plant';
			               		$batching_plant = 'north';
			               		break;
			               	case 'Plant 4':
			               		$plant_class = 'south-plant';
			               		$batching_plant = 'south';
			               		break;
			               }
			    ?>

			               <li class="dropdown" id="<?php echo $sched_id ?>">
			               	<span class="sales-code-marker <?php echo strtolower($proj_sales_rep) ?>"></span>
			               	<input type="hidden" id="vol" class="<?php echo $batching_plant ?>" value="<?php echo $vol ?>">
						     <a href="#" class="sched-cont project-dropdown" data-toggle="dropdown" id="<?php echo $proj_id ?>">
						     	
						     	<div class="sched-wrapper">
						     		<?php echo $cust_name ?>
							     	<span><?php echo $proj_name ?></span>
							     	<span><?php echo $proj_address . ' - ' . $sched_time?></span>
						     	</div>
						     	
						     	
					     		<span class="sched-vol-wrapper <?php echo $plant_class ?>">
					     			<i class="sched-vol"><?php echo $vol ?></i>
					     		</span>
						     	
						     </a>
						   </li>
				<?php
			            }


					}else{
						echo "no records";
					}
				?> 
			</ul>
		</div>

		<div class="column left" id="cont-5">
			<div class="weekly-wrapper">
				<h3 class="weekly-date">
					<?php 
						$date = date_create($sched_date[5]);
						echo date_format($date, 'l');
					
					?>
					<span>
						<?php 
						$date = date_create($sched_date[5]);
						echo date_format($date, 'F d, Y');
						?>
					</span>
				</h3>
				<a href="#" class="lock-button" id="day5"><i class="fa fa-unlock-alt"></i></a>
				
				<a href="" class="waiting-button"><i class="fa fa-list"></i></a>
				<input type="hidden" class="sched-date" value="<?php echo $sched_date[5] ?>">
			</div>
			

			<div id="day5" class="weekly-totals">
	            <p><span class="text">Total Vol. (<i class="tot-cnt total-rows"><?php echo $total_rows[5] ?></i>)</span><span class="cnt total-vol"><?php echo $total_volume[5] ?></span></p>
	            <p><span class="text">North (<i class="tot-cnt total-north"><?php echo $total_north_rows[5] ?></i>)</span><span class="cnt total-north-vol"><?php echo $total_north[5] ?></span></p>
	            <p><span class="text">South (<i class="tot-cnt total-south"><?php echo $total_south_rows[5] ?></i>)</span><span class="cnt total-south-vol"><?php echo $total_south[5] ?></span></p>

			</div>
			<div class="sales-code-legend">
				<span class="north">NORTH</span>
				<span class="south">SOUTH</span>
				<span class="m3">RML</span>
				<span class="m4">CTL</span>
				<span class="m5">NBA</span>
				<span class="m6">APJ</span>
				<span class="m7">JTA</span>
			</div>

			<ul class="sortable-list" id="day5">

				<?php
					$res_count = count($scheds5);
					if($res_count > 0){
						
						foreach ($scheds5 as $row)
			            {
			               $sched_id =  $row['o202_id'];
			               $proj_id =  $row['project_id'];
			               $proj_name =  $row['proj_name'];
			               $cust_name =  $row['cust_name'];
			               $proj_address =  $row['proj_address'];
			               $proj_sales_rep =  $row['special_se'];
			               $plant =  $row['batching_plant'];
			               $sched_time =  $row['modified_time'];
			               
			               $vol =  $row['batch_vol'];


			               switch ($plant) {
			               	case 'Plant 3':
			               		$plant_class = 'north-plant';
			               		$batching_plant = 'north';
			               		break;
			               	case 'Plant 4':
			               		$plant_class = 'south-plant';
			               		$batching_plant = 'south';
			               		break;
			               }
			    ?>

			               <li class="dropdown" id="<?php echo $sched_id ?>">
			               	<span class="sales-code-marker <?php echo strtolower($proj_sales_rep) ?>"></span>
			               	<input type="hidden" id="vol" class="<?php echo $batching_plant ?>" value="<?php echo $vol ?>">
						     <a href="#" class="sched-cont project-dropdown" data-toggle="dropdown" id="<?php echo $proj_id ?>">
						     	
						     	<div class="sched-wrapper">
						     		<?php echo $cust_name ?>
							     	<span><?php echo $proj_name ?></span>
							     	<span><?php echo $proj_address . ' - ' . $sched_time?></span>
						     	</div>
						     	
						     	
					     		<span class="sched-vol-wrapper <?php echo $plant_class ?>">
					     			<i class="sched-vol"><?php echo $vol ?></i>
					     		</span>
						     	
						     </a>
						   </li>
				<?php
			            }


					}else{
						echo "no records";
					}
				?> 
			</ul>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){

		// Get items
		function getGroupItems(group){
			
			var cnt = 0;
	        var id_arr = [];

			$(group + " > li").each(function() {
	            $this = $(this);

	            //get id
	            var ids = $this.attr('id');
	            //var ids = $this.text();
	            //var id_split = ids.split('-');

	            id_arr[cnt] = ids;

	            cnt ++;

	          
	        });

			alert(id_arr);
			console.log(id_arr);
	       
		}

		function getTotalVolumes(group){
			var cnt = 0;
	        var volume_cnt = 0;

			$(group + "> li > a > span > i").each(function() {
	            $this = $(this);
	            var vol = parseFloat($this.text());
	            volume_cnt = volume_cnt + vol;
	        });

			return volume_cnt;
		}

		function getRecordCount(group){
			var cnt = 0;

			$(group + "> li").each(function() {
	            cnt ++;
	        });

			return cnt;
		}
		function getNorthCount(group){
			var cnt = 0;

			$(group + "> li > input#vol").filter('.north').each(function() {
	            cnt ++;
	        });

			return cnt;
		}
		function getSouthCount(group){
			var cnt = 0;

			$(group + "> li > input#vol").filter('.south').each(function() {
	            cnt ++;
	        });

			return cnt;
		}

		function getTotalNorthVolumes(group){
	        var volume_cnt = 0;
			$(group + "> li > input#vol").filter('.north').each(function() {
	            $this = $(this);
	            	var vol = parseFloat($this.val());
	            	volume_cnt = volume_cnt + vol;
	        });

			return volume_cnt;
		}

		function getTotalSouthVolumes(group){
	        var volume_cnt = 0;
			$(group + "> li > input#vol").filter('.south').each(function() {
	            $this = $(this);
	            	var vol = parseFloat($this.val());
	            	volume_cnt = volume_cnt + vol;
	        });

			return volume_cnt;
		}
		


		// Example 2.1: Get items
		$('#week-sched .sortable-list').sortable({
			connectWith: '#week-sched .sortable-list',
			update: function(event, ui) {

				
	        	$('div#day1 > p > span.total-vol').text(getTotalVolumes('#day1'));
	        	$('div#day1 > p > span.total-north-vol').text(getTotalNorthVolumes('#day1'));
	        	$('div#day1 > p > span.total-south-vol').text(getTotalSouthVolumes('#day1'));
	        	$('div#day1 > p > span > i.total-rows').text(getRecordCount('#day1'));
	        	$('div#day1 > p > span > i.total-north').text(getNorthCount('#day1'));
	        	$('div#day1 > p > span > i.total-south').text(getSouthCount('#day1'));

	        	
	        	$('div#day2 > p > span.total-vol').text(getTotalVolumes('#day2'));
	        	$('div#day2 > p > span.total-north-vol').text(getTotalNorthVolumes('#day2'));
	        	$('div#day2 > p > span.total-south-vol').text(getTotalSouthVolumes('#day2'));
	        	$('div#day2 > p > span > i.total-rows').text(getRecordCount('#day2'));
	        	$('div#day2 > p > span > i.total-north').text(getNorthCount('#day2'));
	        	$('div#day2 > p > span > i.total-south').text(getSouthCount('#day2'));

	        	
	        	$('div#day3 > p > span.total-vol').text(getTotalVolumes('#day3'));
	        	$('div#day3 > p > span.total-north-vol').text(getTotalNorthVolumes('#day3'));
	        	$('div#day3 > p > span.total-south-vol').text(getTotalSouthVolumes('#day3'));
	        	$('div#day3 > p > span > i.total-rows').text(getRecordCount('#day3'));
	        	$('div#day3 > p > span > i.total-north').text(getNorthCount('#day3'));
	        	$('div#day3 > p > span > i.total-south').text(getSouthCount('#day3'));

	        	$('div#day4 > p > span.total-vol').text(getTotalVolumes('#day4'));
	        	$('div#day4 > p > span.total-north-vol').text(getTotalNorthVolumes('#day4'));
	        	$('div#day4 > p > span.total-south-vol').text(getTotalSouthVolumes('#day4'));
	        	$('div#day4 > p > span > i.total-rows').text(getRecordCount('#day4'));
	        	$('div#day4 > p > span > i.total-north').text(getNorthCount('#day4'));
	        	$('div#day4 > p > span > i.total-south').text(getSouthCount('#day4'));

	        	$('div#day5 > p > span.total-vol').text(getTotalVolumes('#day5'));
	        	$('div#day5 > p > span.total-north-vol').text(getTotalNorthVolumes('#day5'));
	        	$('div#day5 > p > span.total-south-vol').text(getTotalSouthVolumes('#day5'));
	        	$('div#day5 > p > span > i.total-rows').text(getRecordCount('#day5'));
	        	$('div#day5 > p > span > i.total-north').text(getNorthCount('#day5'));
	        	$('div#day5 > p > span > i.total-south').text(getSouthCount('#day5'));

	        	
	        },
	        receive: function(event, ui) {
	        	//console.log(getTotalNorthVolumes('#day1'));

	        }
		});


		$('#btn-get').click(function(){
			alert(getItems('#example-2-1'));
		});

		//lock all
		$('#week-sched .sortable-list').sortable("disable");

		$('.lock-button').click(function(){
			var but_caption = $(this).children('i').hasClass('fa-lock');
			var sort_container = $(this).attr('id');
			var sched_date = $(this).next('.sched-date').val();
			var main_group = $(this).parent().parent().parent().attr('id');

			
			
			if(but_caption == true){ //if lock icon
				//it means that the user wants to edit the state of the container
				$('#'+sort_container+'.sortable-list').sortable("disable");
				$(this).children('i').removeClass('fa-lock').addClass('fa-unlock-alt');

				alert('Commented the update module.');
			}else{

				//it means that the user wants to save the state of the container and locked it

				//get the id's of the scheds

				// var sched_ids = getSchedIds('#'+sort_container);
				
				// // //ajax update the result
				// $.ajax({
	   //           type: "POST",
	   //           url: "ajax_update_weekly_sched",
	   //           data: "sched-ids="+sched_ids+"&sched-date="+sched_date,
	   //           dataType: "json",
	   //           cache:false,
	   //           success:
	   //                function(data){
	   //                	//msg for success here
	   //                }
	   //          });

				$('#'+sort_container+'.sortable-list').sortable("enable");
				$(this).children('i').removeClass('fa-unlock-alt').addClass('fa-lock');


				
			}

			

			return false;
		});

		$('.waiting-button').click(function(){
			var but_id = $(this).attr('id');
			var sort_container = $(this).attr('id');
			var sched_date = $(this).next('.sched-date').val();
			var main_group = $(this).parent().parent().attr('id');

			var waiting_cnt = $('#' + but_id + '.waiting-wrapper').length;

			if(waiting_cnt == 0){
				$('#'+main_group).after('<div class="waiting-wrapper left" id="' + but_id + '"><ul class="sortable-list ui-sortable" id="waiting-cont"></div>');
				$.ajax({
		           type: "POST",
		           url: "ajax_get_weekly_waiting",
		           data: "sched-date="+sched_date,
		           dataType: "json",
		           cache:false,
		           success:
		                function(data){
		                  if(data != 'none'){
		                  	
		                    //var json = $.parseJSON(data);
		                    var json_obj_cnt = Object.keys(data).length;

		                    //console.log(json[1].project_id);

		                    //add the count to the notification counter
		                    var plant_class = '';
		                    var batching_plant = '';

		                    for ( var i = 0; i < json_obj_cnt; i++)
		                    {
		                    	if (data[i].batching_plant === 'Plant 3') {
		                    		plant_class = 'north-plant';
				               		batching_plant = 'north';
		                    	}else{
		                    		plant_class = 'south-plant';
				               		batching_plant = 'south';
		                    	}


		                    	var sales_code = data[i].special_se;


		                        $('#waiting-cont')
		                          .prepend($('<li>')
		                            .attr('class', 'dropdown')
		                            .attr('id', data[i].o202_id)
		                            .append($('<span class="sales-code-marker ' + sales_code.toLowerCase() + '"></span>'))
		                            .append($('<input type="hidden" id="vol" class="' + batching_plant + '" value="' + data[i].batch_vol + '">'))
		                            .append($('<a>')
		                              .attr('id', data[i].project_id)
	                                  .attr('class', 'sched-cont project-dropdown')
	                                  .attr('data-toggle','dropdown')
	                                  .attr('href','#')
	                                  .append($('<div>')
	                                    .attr('class','sched-wrapper')
	                                    .text(data[i].special_se + ' - ' + data[i].cust_name)
	                                    .append($('<span>')
		                                    .text(data[i].proj_name)
		                                  )
		                                  .append($('<span>')
		                                    .text(data[i].proj_address + ' - ' + data[i].modified_time)
		                                  )
		                                  
	                                  )
	                                  .append($('<span class="sched-vol-wrapper ' + plant_class + '"><i class="sched-vol">' + data[i].batch_vol + '</i></span>'))
	                                  
	                                  

	                                )
		                       	  )
		                        
		                    }
		                  }
		                  
		                  
		                }
		        });

				$('#waiting-cont').sortable({
					connectWith: '#week-sched .sortable-list',
					update: function(event, ui) {

			        },
			        receive: function(event, ui) {
			        	//console.log(getTotalNorthVolumes('#day1'));

			        }
				});
			}else{
				//hide
				$('#' + but_id + '.waiting-wrapper').remove();
			}

			
			return false;
		});

		function getSchedIds(group){
			var cnt = 0;
			var schedid_arr = [];

			$(group + "> li").each(function() {
	            $this = $(this);
	           	schedid_arr[cnt] = $this.attr('id');

	           	cnt ++;
	        });

			return JSON.stringify(schedid_arr);
		}

		$('.project-dropdown').click(function(){
			 $this = $(this);
	         var id = $this.parent().attr('id');



	         var sched_detail_cnt = $('#detail' + id + '.sched-details').length;

	         //alert(sched_detail_cnt);

	         if(sched_detail_cnt == 0){
	         	//append the div
	         	$this.append('<div class="sched-details" id="detail' + id + '"></div>');

	         	//ajax get the scheds detail
	         	$.ajax({
		           type: "POST",
		           url: "ajax_get_weekly_sched_detail",
		           data: "sched-id="+id,
		           dataType: "json",
		           cache:false,
		           success:
		                function(data){
		                  if(data != 'none'){
		                  	
		                    var json_obj_cnt = Object.keys(data).length;

		                    console.log(json_obj_cnt);
		                    if(json_obj_cnt > 0){

		                    	$('#detail' + id + '.sched-details')
		                          .prepend($('<div>')
		                            .attr('class', 'bubble')
		                            .append($('<div>')
	                                  .attr('class', 'sched-details-wrapper')
	                                  .append($('<div>')
	                                    .append($('<span>')
		                                    .text('PSI : ' + data[0].book_psi)
		                                  )

		                                  .append($('<span>')
		                                    .text('AGG : ' + data[0].book_msa)
		                                  )

		                                  .append($('<span>')
		                                    .text('CURING : ' + data[0].book_cd)
		                                  )

		                                  .append($('<span>')
		                                    .text('SLUMP : ' + data[0].book_sp)
		                                  )
	                                  )
	                                  .append($('<div>')
	                                    .append($('<span>')
		                                    .text('Structure : ' + data[0].structure)
		                                  )

		                                  .append($('<span>')
		                                    .text('Pouring Type : ' + data[0].pour_type)
		                                  )

		                                  .append($('<span>')
		                                    .text('Service Engr. : ' + data[0].service_engr)
		                                  )

		                                  .append($('<span>')
		                                    .text('QA Rep. : ' + data[0].qa_rep)
		                                  )
	                                  )
	                                  
	                                  

	                                )
		                       	  )


		                    }
		                  }
		                  
		                  
		                }
		        });




	         	
	         }else{
	         	//remove the div
	         	$('#detail' + id + '.sched-details').remove();
	         }
	         
	         

	         return false;
		});



		/*//test only
		$(".slider").diyslider({
		    width: "1080px", // width of the slider
		    height: "1200px", // height of the slider
		    display: 3, // number of slides you want it to display at once
		    loop: false // disable looping on slides
		}); // this is all you need!

		// use buttons to change slide
		$("#go-left").bind("click", function(){
		    // Go to the previous slide
		    $(".slider").diyslider("move", "back");
		});
		$("#go-right").bind("click", function(){
		    // Go to the previous slide
		    $(".slider").diyslider("move", "forth");
		});*/

	
	});
</script>