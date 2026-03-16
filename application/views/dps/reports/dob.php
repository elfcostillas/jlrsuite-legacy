
<div class="grid-940" id="dob-wrapper">
	<div id="dob-header">
		<div id="dob-logo">
			<img src="<?php echo base_url("css/images/jlr_logo_print.jpg") ?>" />

			<?php
				$pieces = explode("-",$scheddate);
			?>
			<p><strong>READY-MIXED CONCRETE DEPARTMENT <br />DAILY POURING SCHEDULE</strong> <br /><i>As of <?php echo date("F d, Y",mktime(0,0,0,$pieces['1'],$pieces['2'],$pieces['0'])) ?></i></p>
		</div>

		<div id="dob-volume">
			<h1>
				Total Volume: <?php echo $volume ?> m<sup>3</sup><br /><br />
				<span><?php echo date("m/d/Y h:i") ?></span>
			</h1>
		</div>
	</div>

	<!-- STARTOF THE REPORT TABLE -->
	<br /><br />
	<div id="dob-table-wrapper">
		<?php echo $dob_items ?>
	</div>
	

</div>
	


	
	
