<div id="main-container-mobile">
		<div id="mobile-nav">
			<h1>JLR - Daily Pouring Schedule</h1>
			<a id="menu-toggle"></a>
			<ul id="mobilemenu">
				
			    <?php echo anchor('dps', 'Daily Pouring Schedule', 'class="mlink"') ?>
		        <?php echo anchor('dps/schedulertoday', 'Scheduler Today', 'class="mlink"') ?>
	            <?php echo anchor('dps/schedulertom', 'Scheduler Next Day', 'class="mlink"') ?>
	            <?php echo anchor('dps/edit_pouring_yesterday', 'View Yesterday Schedule', 'class="mlink"') ?>
	      		<?php echo anchor('dps/edit_pouring_today', 'Edit Today Schedule', 'class="mlink"') ?>
	            <?php echo anchor('dps/next_pouring_sched', 'Edit Next Day Schedule', 'class="mlink"') ?>
				<?php echo anchor('main/logout?requestingpage=mobiledps', 'Log-out', 'class="mlink"') ?>
			</ul>
		</div>
		<?php
			if(isset($batchsched_nextday_smd_m)){
				echo "<p class='smdmobile-bcrumb'>Scheduler Next Day</p>";
				echo $batchsched_nextday_smd_m;
			}
		?>

		<div id="mfooter">
			<p>Copyright <strong>&copy; 2012</strong> - JLR Construction and Aggregates Inc. - Ralph</p>
		</div>
</div>

<?php $lvl = $this->session->userdata('userlvl'); ?>
<div id="content-fluid">
	
	<fieldset>
		<legend>Legend</legend>
		<ul class="scheduler-legend-wrapper">
			<li id="approved">Approved</li>
			<li id="waiting_smd">Waiting SMD Approval</li>
			<li></li>
			<li id="updated">Modification Success</li>
			<li id="selected">Selected for Approval</li>
			<li></li>
			<li id="origdate">Original Date</li>
			<li id="moddate">Modified Date</li>
			<li></li>
			<li id="desforp4">Design for Plant 4</li>
		</ul>
	</fieldset>
	<?php

			if($display == 'yes'){?>
	<div style="padding-top:10px;"></div>		
	<table  style="border-collapse: collapse;width: 100%;font-size: 1em;border-bottom: 2px solid #ddd; " >			
			<tr style="color:white; background-color: #3581c5;">
				<?php foreach ($pour_result as $row){ ?>
				<th>
					<?php echo "$row->pour_type";?>
				</th>
				<?php			
        			}
				?>
			</tr>
			<tr>					
				<?php foreach ($pour_result as $row){ ?>
				<td align="center">
					<?php echo "$row->pour_vol m³";?>
				</td>
				<?php			
        			}
				?>	
			</tr>  
	</table>
	 <?php			
        			}
				?>	
	
		<?php

			if($display == 'yes'){
				//display the result coor
				if(isset($batchsched_nextday_coor)){
					echo $batchsched_nextday_coor;
					echo "<br /><br />";
				}else{
					//do nothing
				}

				//display the result smd
				if(isset($batchsched_nextday_smd)){
					echo $batchsched_nextday_smd;
					echo "<br /><br />";
				}else{
					//do nothing
				}
			}else{
		?>
				<br />
				<div class='upnotify'>
					<span>Warning!</span>
					<br />
					<p><?php echo $status ?></p>
				</div>

		<?php
			}
		?>

	



</div>

<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
