<body>

			<div id="navigation" class="dps-nav-container">
			  <ul>
			  	<?php $attrib = array('title' => 'Dashboard','class' => 'active') ?>
				<li><?php echo anchor('admin/index', 'Dashboard',$attrib) ?></li>
			    <li><?php echo anchor('admin/tools', 'Tools', 'title="Tools"') ?></li>
			  </ul>
			</div>