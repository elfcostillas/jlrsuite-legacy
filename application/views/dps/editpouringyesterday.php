<?php
	//get the user level of the login person
	$lvl = $this->session->userdata('userlvl');
?>

<div id="main-container-mobile">
		<div id="mobile-nav">
			<h1>JLR - Daily Pouring Schedule</h1>
			<a id="menu-toggle"></a>
			<ul id="mobilemenu">
			    <?php echo anchor('dps', 'Daily Pouring Schedule', 'class="mlink"') ?>
		        <?php echo anchor('dps/schedulertoday', 'Scheduler Today', 'class="mlink"') ?>
	            <?php echo anchor('dps/schedulertom', 'Scheduler Next Day', 'class="mlink"') ?>
	            <?php echo anchor('dps/edit_pouring_yesterday', 'View Yesterday Schedule', 'class="mlink"') ?>
	      		<?php echo anchor('dps/edit_pouring_today', 'View Today Schedule', 'class="mlink"') ?>
	            <?php echo anchor('dps/next_pouring_sched', 'View Next Day Schedule', 'class="mlink"') ?>
				<?php echo anchor('main/logout?requestingpage=mobiledps', 'Log-out', 'class="mlink"') ?>
			</ul>
		</div>

		
		<div id="content-wrapper">
			<?php
		  		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSacctg($lvl)){
		  			echo "<span class='m-dept'>ACCOUNTING</span>";
		  			echo $m_acctg ;
		  		}

		  		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSps($lvl)){
		  			//echo "<span class='m-dept'>PLANT</span>";
		  			//echo $m_plant ;
		  		}

			?>
		</div>

		<div id="mfooter">
			<p>Copyright <strong>&copy; 2012</strong> - JLR Construction and Aggregates Inc. - Ralph</p>
		</div>
</div>


<div id="content-fluid">
	<div id="usual1" class="usual"> 

		<fieldset>
			<legend>Legend</legend>
			<ul class="scheduler-legend-wrapper">
				<li class="insert-schedule">Inserted</li>
				<li class="resched-schedule">Re-Scheduled</li>
				<li class="forconfirm-schedule">For Confirmation</li>
			</ul>
		</fieldset>


		<ul>
		  	<li><a href="#tab1" class="selected">DPS Summary</a></li> 
			  	<?php
			  		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSacctg($lvl)){
			  			echo "<li><a href='#tab2'>Accounting</a></li>";
			  		}

			  		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSps($lvl)){
			  			// echo "<li><a href='#tab3'>Plant Supervisor</a></li>"; 
			  		}

			  		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSqc($lvl)){
			  			// echo "<li><a href='#tab4'>Quality Control</a></li>"; 
			  		}
			  	?>
		</ul> 



	  	


		  <div id="tab1">
		  		
			  		<?php
			  			 echo $dps_summary;
			  		?>
					
		  </div> 

		  <?php
	  		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSacctg($lvl)){
	  		    echo "<div id='tab2'>$dps_summary$acctg</div>";
	  			// echo "<div id='tab2'>$acctg</div>";
	  		}

	  		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSps($lvl)){
	  			// echo "<div id='tab3'>$dps_summary$plant</div>";
	  		}

	  		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSqc($lvl)){
	  			// echo "<div id='tab4'>$dps_summary$qc</div>";
	  		}
	  	  ?>
	</div> 
</div>


<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>