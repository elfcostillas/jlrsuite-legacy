<?php
	//get the user level of the login person
	$lvl = $this->session->userdata('userlvl');
?>
<body>

	<div id="navigation" class="dps-nav-container">
	  <ul>
	    <li>
	    	<?php $attrib = array('title' => 'Daily Cancelled DR','class' => 'active') ?>
	    	<?php echo anchor('drmon', 'Daily Cancelled DR', $attrib) ?>
	    	
	    </li>

	  </ul>
	</div>