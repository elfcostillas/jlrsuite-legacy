<?php 
	if($requestingpage == 'dps'){
		echo "<div id='banner-fluid'>";
	}else{
		echo "<div id='content' class='grid-940'>";
	}
?>



	<div id="banner-left">
		<h1><?php echo $softname . " - " . $pagename ?></h1>
		<p><?php echo "Today is : " . $curdate ?></p>
	</div>
		
	<?php
		$lvl = $this->session->userdata('userlvl');
		//echo $this->session->userdata('userinit');
		if($this->session->userdata('is_logged_in')){
	?>
		
		<div id="banner-right">
			<div id="useroption">
		        <p>Hello  <?php echo $this->session->userdata('nick')?>! <a id="option" href="#">Options</a></p>

		        <div id="submenu">
			    	<ul>
			    		<li>
					    	<?php echo anchor('welcome', 'Main Menu'); ?>
					    </li>

			    		<?php 
			    			if ($this->functionlist->isAdmin($lvl)){
						    	echo "<li>". anchor('', 'Manage Users'). "</li>";
			    			}
			    		?>
					    
					    <li>
					    	<?php echo anchor('', 'Applications'); ?>
					    </li>
					    <li>

					    	<?php 
						    	$attr = array('id' => 'useredit');
						    	echo anchor('#', 'Edit User Settings',$attr); 
					    	?>
					    	<div id="useroption-wrapper">
					    		<span id="useredit-passerror">Password does not match.</span>
					    		<span id="useredit-error">Cannot update,Error occured.</span>
					    		<span id="useredit-success">Update success.</span>	
					    		<div class="fields">
					    			<label>Username</label><input type="text" disabled="disabled" Value="<?php echo $this->session->userdata('username')?>"/>
					    		</div>
					    		<div class="fields">
					    			<label>New Password</label><input type="password" id="useredit-password"/>
					    		</div>
					    		<div class="fields">
					    			<label>Confirm New Password</label><input type="password" id="useredit-cpassword"/>
					    		</div>
					    		<div class="fields">
					    			<label>First Name</label><input type="text" id="useredit-firstname" value="<?php echo $this->session->userdata('first_name')?>"/>
					    		</div>
					    		<div class="fields">
					    			<label>Last Name</label><input type="text" id="useredit-lastname" value="<?php echo $this->session->userdata('last_name')?>"/>
					    		</div>

					    		<div class="fields">
					    			<a href="#" id="useredit-updatebut" value="<?php echo $this->session->userdata('employee_id')?>"><center>Update Profile</center></a>
					    		</div>
					    	</div>
					    </li>
					    <li>
					    	<?php echo anchor('', 'Help Desk'); ?>
					    </li>
					    <li>
					    	<?php echo anchor('main/logout?requestingpage='.$softname, 'Logout'); ?>
					    </li>
				    </ul>                
			    </div>
		    </div>            
		</div>

	<?php
		}
	?>
	
</div>


