	<?php
		//get the user level of the login person
		$lvl = $this->session->userdata('userlvl');
	?>

	<body>

		
			<div id="navigation">
			  <ul>
			    <li>
			    	<?php
				    	if($activepage == 'Home'){
				    		$attrib = array('title' => 'Attendance Reports','class' => 'active');
			    			echo anchor('leaves', 'Attendance Reports', $attrib);
				    	}
				    	else{
				    		echo anchor('leaves', 'Attendance Reports','title="Attendance Reports"');
				    	}
			    	?>
			    	
			    </li>

			    <li>
			    	<?php
				    	if($activepage == 'Employee List'){
				    		$attrib = array('title' => 'Employee List','class' => 'active');
			    			echo anchor('leaves/leave', 'Leaves', $attrib);
				    	}
				    	else{
				    		echo anchor('leaves/leave', 'Leaves','title="Employee List"');
				    	}
			    	?>

			      <ul>
			      	<!-- ========== SUB MENU ========== -->
			        <li>
			        	<?php
					    	if($activepage == 'Add Leave'){
					    		$attrib = array('title' => 'Add Leave Form','class' => 'active');
				    			echo anchor('leaves/addleave', 'Add Leave', $attrib);
					    	}
					    	else{
					    		echo anchor('leaves/addleave', 'Add Leave','title="Add Leave Form"');
					    	}
				    	?>
			        </li>

			        <li>
			        	<?php
					    	if($activepage == 'Search Employee'){
					    		$attrib = array('title' => 'Search Employee','class' => 'active');
				    			echo anchor('leaves/searchemployee', 'Search Employee', $attrib);
					    	}
					    	else{
					    		echo anchor('leaves/searchemployee', 'Search Employee','title="Search Employee"');
					    	}
				    	?>
			        </li>

			      </ul> 
			     </li>
			    <li><?php echo anchor('', 'Maintenance', 'title="Maintenance"') ?>
			      <ul>
			      	<li>
			      		<?php
					    	if($activepage == 'Leave Records'){
					    		$attrib = array('title' => 'Leave Records','class' => 'active');
				    			echo anchor('leaves/leaverecords', 'Leave Records', $attrib);
					    	}
					    	else{
					    		echo anchor('leaves/leaverecords', 'Leave Records','title="Leave Records"');
					    	}
				    	?>
			      	</li>
			      	
			      	<?php
			      		

			      		//only hr manager and admin can see this menu
			      		if ($this->functionlist->isHR($lvl) OR $this->functionlist->isAdmin($lvl)){
			      			if($this->functionlist->isHRStaff($lvl) == false){
			      				echo "<li>";
					      
							    	if($activepage == 'Leave Credits'){
							    		$attrib = array('title' => 'Leave Credits','class' => 'active');
						    			echo anchor('leaves/leavecredits', 'Leave Credits', $attrib);
							    	}
							    	else{
							    		echo anchor('leaves/leavecredits', 'Leave Credits','title="Leave Credits"');
							    	}
						    	
					      		echo "</li>";
			      			}
			      			
			      			
			      		}
			      	?>
			      	

			      </ul> 
			     </li>
			    <li><a href="javascript:window.print()">Print</a></li>
			  </ul>
			</div>