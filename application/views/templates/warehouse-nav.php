<?php
	$this->firstname = $this->session->userdata('first_name');
	$this->lastname = $this->session->userdata('last_name');
	$this->fullname = ucwords(strtolower($this->firstname . ' ' . $this->lastname));

?>
	<body>
		
				<nav class="navbar navbar-default navbar-fixed-top">
				  <div class="container">
				  	<div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      <a class="navbar-brand" href="#">
				      	
				      	<img alt="Brand" src='<?php echo base_url("css/images/jlr-newlogo-hor.png") ?>'>
				      	
				      </a>
				    </div>

				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				      <ul class="nav navbar-nav">
				        <li><a href='<?php echo site_url("warehouse"); ?>'>Home</a></li>
				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Withdrawals <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				           	<li><a href='<?php echo site_url("warehouse/approved_withdrawals"); ?>'>Approved List</a></li>
				           	<li><a href='<?php echo site_url("warehouse/pending_withdrawals"); ?>'>Pending List</a></li>
					        <!-- <li><a href='<?php echo site_url("leavesv2/leave_mass"); ?>'>Mass Leave</a></li>
					        <li><a href='<?php echo site_url("leavesv2/leave_credits"); ?>'>Leave Credits</a></li> -->
				          </ul>
				        </li>
				        <!-- <li><a href='<?php echo site_url("warehouse/leave_status"); ?>'>Leaves Status</a></li>
				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Human Resource <span class="caret"></span></a>
				          <ul class="dropdown-menu">
				           	<li><a href='<?php echo site_url("leavesv2/leave_records"); ?>'>Leave Records</a></li>
				           	<li><a href='<?php echo site_url("leavesv2/emp_records"); ?>'>Employee Records</a></li>
				        					        <li><a href='<?php echo site_url("leavesv2/leave_mass"); ?>'>Mass Leave</a></li>
				        					        <li><a href='<?php echo site_url("leavesv2/leave_credits"); ?>'>Leave Credits</a></li>
				          </ul>
				        </li> -->
				      </ul>
				      
				      <ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->fullname ?> <i class="fa fa-caret-down"></i></a>
				      			<ul class="dropdown-menu">
								    <li><a href="#"><i class="fa fa-cog"></i> Account Settings</a></li>
								    <li><a href='<?php echo site_url("welcome"); ?>'><i class="fa fa-home"></i> Welcome Page</a></li>
								    <li role="separator" class="divider"></li>
								    <li><a href='<?php echo site_url("main/logout?requestingpage=".$softname) ?>'><i class="fa fa-sign-out"></i> Logout</a></li>
								</ul>
							</li>
				      	<!-- hidden values for the query -->
				      	<input hidden="true" id="emp-id" name="emp-id" value='<?php echo $this->session->userdata('employee_id'); ?>' />
				      	<input hidden="true" id="emp-lvl" name="emp-lvl" value='<?php echo $this->session->userdata('userlvl'); ?>' />
				      </ul>
				      
				      <!-- <ul class="nav navbar-nav navbar-right">
				        <li class="dropdown">
				          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
				          <ul class="dropdown-menu" role="menu">
				            <li><a href="#">Action</a></li>
				            <li><a href="#">Another action</a></li>
				            <li><a href="#">Something else here</a></li>
				            <li class="divider"></li>
				            <li><a href="#">Separated link</a></li>
				          </ul>
				        </li>
				      </ul> -->

				    </div><!-- /.navbar-collapse -->
				  	
				  </div>
				</nav>
		


