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


<div id="usual1" class="usual">
	<ul> 
	    <li><a href="#tab1" class="selected">Today's Pouring</a></li> 
	    <li><a href="#tab2">Next Day Pouring</a></li> 
	</ul> 
	
	<div id="tab1">
		<?php
			if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSCoordinator($lvl)){
				echo $batchsched_today_coor;
				echo "<br /><br />";
			}
			
			

			if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSsmd($lvl)){
				echo $batchsched_today_smd;
			}
			
		?>
	</div>

	<div id="tab2">
		<?php
			if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSCoordinator($lvl)){
				echo $batchsched_nextday_coor;
				echo "<br /><br />";
			}
			
			

			if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSsmd($lvl)){
				echo $batchsched_nextday_smd;
			}
		?>
	</div>
</div>


</div>

<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>