<body>

			<div id="navigation" class="dps-nav-container">
			  <ul>
			    <li>
			    	<?php $attrib = array('title' => 'Daily Pouring Schedule','class' => 'active') ?>
			    	<?php echo anchor('deu', 'Equipment Status', $attrib) ?>
			    	<ul>
				        <li><?php echo anchor('deu/monthly_repairs', 'Monthly Repairs', 'title="View Monthly Repairs"') ?></li>
				    </ul> 
			    	
			    </li>

			    <li><?php echo anchor('deu/maintenance', 'Maintenance', 'title="Projects"') ?>
			      <ul>
			        <li><?php echo anchor('deu/add_repair', 'Add Repair', 'title="Add Repair"') ?></li>
			        <li><?php echo anchor('deu/search_history', 'Search Repair History', 'title="Search Repair History"') ?></li>
			      	 <li><?php echo anchor('deu/equipment_list', 'Equipment List', 'title="Equipment List"') ?></li>
			      </ul> 
			     </li>

			     <li><?php echo anchor('', 'Options', 'title="Options" onclick="return false" ') ?>
			      <ul>
			        <li><?php echo anchor('deu/view_units', 'Units', 'title="Units"') ?></li>
			      </ul> 
			     </li>

			     

			    
			    <li><a href="javascript:window.print()">Print</a>
			    	
			    </li>
			  </ul>
			</div>