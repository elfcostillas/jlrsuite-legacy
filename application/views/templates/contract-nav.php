<?php
	//get the user level of the login person
	$lvl = $this->session->userdata('userlvl');
?>
<body>
	<!-- for mobile nav -->
	<nav class="navbar navbar-inverse visible-xs">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Contracts</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li><?php echo anchor('contracts', 'Contract'); ?></li>
	        <li role="separator" class="divider"></li>
	      	<li><?php echo anchor('dps', 'Daily Pouring Schedule', 'class="mlink"') ?></li>
	        <li><?php echo anchor('dps/schedulertoday', 'Scheduler Today', 'class="mlink"') ?></li>
	        <li><?php echo anchor('dps/schedulertom', 'Scheduler Next Day', 'class="mlink"') ?></li>
	        <li><?php echo anchor('dps/edit_pouring_today', 'Edit Today Schedule', 'class="mlink"') ?></li>
	        <li><?php echo anchor('dps/next_pouring_sched', 'Edit Next Day Schedule', 'class="mlink"') ?>
	        </li>
	        <li role="separator" class="divider"></li>

	        <li><?php echo anchor('main/logout?requestingpage=mobiledps', 'Log-out', 'class="mlink"') ?>
	        </li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	       
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>		

	<!-- for desktop nav -->
	<div id="navigation" class="nav-container .visible-md .visible-sm" style="height:60px; ">
	  <ul>
	    <li>
	    	<?php $attrib = array('title' => 'Daily Pouring Schedule','class' => 'active') ?>
	    	<?php echo anchor('dps', 'Daily Pouring Sched', $attrib) ?>

	    	<?php
	      		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isDPSps($lvl)){
			?>
				<ul>
	            		  <li><?php echo anchor('dps/uploadbatching', 'Batching Upload', 'title="Batching Upload"') ?></li>
	            		  <!-- added by:WBSOLON 09/10/2018 -->
	            		  <li><?php echo anchor('dps/upload_batch', 'Batching Upload ', 'title="Batching Upload"') ?></li>

				</ul>	    
			<?php		
			}
	      	?>	
	    	
	    </li>
	    
		<!-- added by Rodren S. Gil 2017.04.28 -->
		<?php if($this->functionlist->isAdmin($lvl) || $this->functionlist->isSMD($lvl) || $this->functionlist->isCVR($lvl)): ?>
	    <li><?php echo anchor('contracts', 'Contracts', 'title="Contracts"') ?></li> 
		<?php endif; ?>
	    <li><?php echo anchor('dps#', 'Projects', 'title="Projects" onclick="return false"') ?>
	      <ul>
	        <li><?php echo anchor('dps/addproject', 'Add Project', 'title="Add Project"') ?></li>
	        <li><?php echo anchor('dps/searchproject', 'Search Project', 'title="Search Project"') ?></li>
	        <li><?php echo anchor('dps/bookprojects', 'Book Projects', 'title="Book Projects"') ?></li>
	        <li><?php echo anchor('dps/updatecontracts', 'Update Contracts', 'title="Update Contracts"') ?></li>
	      </ul> 
	     </li>

	     <li><?php echo anchor('dps/scheduler', 'Scheduler', 'title="Scheduler" onclick="return false"') ?>
	      <ul>
	      	<?php
	      		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isCVR($lvl) OR $this->functionlist->isDPSCoordinator($lvl) OR $this->functionlist->isDPSsmd($lvl) OR $this->functionlist->isSMD($lvl)){
			?>
					<li><?php echo anchor('dps/schedulertoday', 'Scheduler Today', 'title=""') ?></li>
	      			<li><?php echo anchor('dps/schedulertom', 'Scheduler Next Day', 'title=""') ?></li>
	      			<li><?php echo anchor('dps/schedulersat', 'Scheduler Saturday', 'title=""') ?></li>
	      			<li><?php echo anchor('dps/schedulersun', 'Scheduler Sunday', 'title=""') ?></li>
	      			<li><?php echo anchor('dps/schedulermon', 'Scheduler Monday', 'title=""') ?></li>
			<?php
				}
	      	?>

	      	<li><?php echo anchor('dps/edit_pouring_today', 'Edit Today Schedule', 'title=""') ?></li>
	      	<li><?php echo anchor('dps/next_pouring_sched', 'Edit Next day Schedule', 'title=""') ?></li>

	      	<?php
	      		if($this->functionlist->isAdmin($lvl) OR $this->functionlist->isDPSCoordinator($lvl)){
			?>
	      			<li><?php echo anchor('dps/view_pendings', 'View Pending Schedules', 'title=""') ?></li>
	      	<?php
				}
	      	?>

	      	<!-- added by ralph 07-30-2015 for finance manager request -->
			
	      </ul> 
	     </li>

	    <li><?php echo anchor('dps#', 'Maintenance', 'title="Maintenance" onclick="return false"') ?>
	      <ul>
	      	<li><?php echo anchor('dps/maintain_holidays', 'Holidays', 'title=""') ?></li>
	      	<li><?php echo anchor('dps/maintain_customers', 'Customers', 'title=""') ?></li>
	      	<li><?php echo anchor('dps/maintain_projects', 'Projects', 'title=""') ?></li>
	      	<li><?php echo anchor('dps/maintain_design', 'Designs', 'title=""') ?></li>
	      	<li><?php echo anchor('dps/maintain_sketch', 'Location Sketch', 'title="Upload Location Sketch"') ?></li>
	      </ul> 
	     </li>
	    <li><?php echo anchor('dps#', 'Print', 'title="Print"') ?>
	    	<ul>
		      	<li><?php echo anchor('dps/print_today_south', 'Today - South', 'title=""') ?></li>
		      	<li><?php echo anchor('dps/print_today_north', 'Today - North', 'title=""') ?></li>
		      	<li><?php echo anchor('dps/print_tom_south', 'Tomorrow - South', 'title=""') ?></li>
		      	<li><?php echo anchor('dps/print_tom_north', 'Tomorrow - North', 'title=""') ?></li>
		      	<li><?php echo anchor('dps/print_dob', 'DOB', 'title=""') ?></li>
	        </ul> 
	    </li>
	  </ul>
	</div>