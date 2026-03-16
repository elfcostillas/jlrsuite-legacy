<html>
<head>
	<title>JLR Construction and Aggregates Inc.</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">

	<link rel="stylesheet" type="text/css" href='<?php echo base_url("css/welcomestyle.css") ?>' />
</head>
<body>
	<div id="header-wrapper">
		<div class="container">
			<div class="col four">
				<img src="<?php echo base_url("css/images/welcome-logo.png") ?>" />
				<h1 id="brand">JLR Software Suite <br /><span>version 2.0</span>
				</h1>
			</div>
			
		
			<div id="header-date">
				<p>TODAY<br /><span><?php echo date("F d, Y")?></span></p>
			</div>
		</div>
		
	</div>

	<div class="container" id="menu">
		<div class="row">
			<div class="col three">
				<a href="leaves" class="btn btn-dark-blue">Attendance Monitoring</a>		
			</div>
			<div class="col three">
				<a href="dps" class="btn btn-dark-blue">Daily Pouring Schedule</a>		
			</div>
			<div class="col three">
				<!-- <a href="deu" class="btn btn-dark-blue">Daily Equipment Update</a>	 -->
				<a href="#" class="btn btn-dark-blue">Daily Equipment Update</a>	
			</div>
			<div class="col three">
				<!-- <a href="drmon" class="btn btn-dark-blue">DR Monitoring</a>		 -->
				<a href="#" class="btn btn-dark-blue">DR Monitoring</a>
			</div>
		</div>

		<div class="row">
			<div class="col three">
				<!-- <a href="leavesv2" class="btn btn-dark-blue">Online Leave V2.0</a>		 -->
				<a href="#" class="btn btn-dark-blue">Online Leave V2.0</a>
			</div>
			<div class="col three">
				<!-- <a href="warehouse" class="btn btn-dark-blue">Warehouse Inventory</a>		 -->
				<a href="#" class="btn btn-dark-blue">Warehouse Inventory</a>	
			</div>
			<div class="col three">
				<!-- <a href="#" class="btn btn-dark-blue">Reserved Link</a> -->
				<a href="#" class="btn btn-dark-blue">Reserved Link</a>
			</div>
			<div class="col three">
				
				<?php
					if($level == '5' OR $level == '1'){
						//echo "<a href='admin' class='btn btn-dark-blue'>Admin Dashboard</a>";
						echo "<a href='#' class='btn btn-dark-blue'>Admin Dashboard</a>";
					}else{
						echo "<a href='#' class='btn btn-dark-blue'>Reserved Link</a>";
					}
				?>		
			</div>
		</div>
	</div>

	<!-- <div class="grid960" id="main-wrapper">
		
		<div class="item-wrapper">
			<center>
				<a href="leaves" class="a_demo_four">Attendance Monitoring</a>
			</center>
		</div>
	
		<div class="item-wrapper">
			<center>
				<a href="dps" class="a_demo_four">Daily Pouring Schedule</a>
			</center>
		</div>
		
		<div class="item-wrapper">
			<center>
				<a href="deu" class="a_demo_four">Daily Equipment Update</a>
			</center>
		</div>
	
		<div class="item-wrapper">
			<center>
				<a href="drmon" class="a_demo_four">DR Monitoring</a>
			</center>
		</div>
	
	
		NEW ITEM ROWS
		<div class="item-wrapper">
			<center>
				<a href="leavesv2" class="a_demo_four">Online Leave V2.0</a>
			</center>
		</div>
	
		<div class="item-wrapper">
			<center>
				<a href="warehouse" class="a_demo_four">Warehouse Inventory</a>
			</center>
		</div>
	
		<div class="item-wrapper">
			<center>
				<a href="#" class="a_demo_four">Reserved Links</a>
			</center>
		</div>
	
		<div class="item-wrapper">
			<center>
				<?php
					if($level == '5' OR $level == '1'){
						echo "<a href='admin' class='a_demo_four'>Admin Dashboard</a>";
					}else{
						echo "<a href='#' class='a_demo_four'>Reserved Links</a>";
					}
				?>
			</center>
		</div>
		
	</div> -->


	<div class="container" id="footer-wrapper">
		<div class="col tweleve" id="footer-content">
			<p>&copy; Copyright 2012 &bull; JLR Construction and Aggregates Inc. - [Ralphskie]</p>
			<a href="main/logout?requestingpage=welcomepage">Logout</a>
		</div>
	</div>

	<!-- <div class="grid960" id="footer-wrapper">
		<p>&copy; Copyright 2012 &bull; JLR Construction and Aggregates Inc. - [Ralphskie]</p>
		<a href="main/logout?requestingpage=welcomepage">Logout</a>
	</div> -->

	<!--
		<div class="item-wrapper">
			<div class="item-desc">
				<p>This is the description for the leave monitoring system.</p>
			</div>
			<center><a href="leaves">Leave Monitoring</a></center>
		</div>
	-->
	
</body>
</html>