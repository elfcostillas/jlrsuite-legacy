<body id="dps-print">
<div id="print-header-wrapper">
	<div id="dpsreport-headleft">
		<img src="<?php echo base_url("css/images/jlr_logo_print.jpg") ?>" />

		<?php
			$pieces = explode("-",$scheddate);
		?>
		<p>READY-MIXED CONCRETE DEPARTMENT <br />DAILY POURING SCHEDULE <br /><i>As of <?php echo date("F d, Y",mktime(0,0,0,$pieces['1'],$pieces['2'],$pieces['0'])) ?></i></p>
	</div>

	<div id="dpsreport-headright">
		<table id="agg_summ" border="1px">
			<tr>
				<th rowspan="2">TIME</th>
				<th rowspan="2">CLIENTS</th>
				<th colspan="2">VOLUME</th>
				<th rowspan="2">TOTAL</th>
			</tr>
			<td colspan="1" align="center"><strong>G1</strong></td>
			<td colspan="1" align="center"><strong>3/4</strong></td>

			<tr>
				<!-- normal sched -->
				<td align="center"><strong>7am - 12nn</strong></td>
				<?php echo $clientcnt1 ?>
			</tr>

			<tr>
				<!-- insert sched -->
				<td align="center"><strong>1pm - 8pm</strong></td>
				<?php echo $clientcnt2 ?>
			</tr>

			<tr>
				<!-- insert sched -->
				<td align="center"><strong>9pm - 12mn</strong></td>
				<?php echo $clientcnt3 ?>
			</tr>
		</table>
		
		<h1 id="total-vol">
			Total Volume: <?php echo $volume_total ?> m<sup>3</sup><br /><br />
			<span><?php echo date("m/d/Y h:i") ?></span>
		</h1>
	</div>
</div>

<div id="rept-wrapper">
	<?php 
		switch ($printparam) {
			case 'todaysouth':
				echo "<center><h2>SOUTH</h2></center>";
				break;
			case 'tomsouth':
				echo "<center><h2>SOUTH</h2></center>";
				break;
			case 'todaynorth':
				echo "<center><h2>NORTH</h2></center>";
				break;
			case 'tomnorth':
				echo "<center><h2>NORTH</h2></center>";
				break;
		}
	?>
	
	<div id="report-table">
		<?php 
			if(isset($warning)){
				echo $warning;
			}else{
		?>

				<table id="dpsreport-table" class="tables dpsrept-table">
					
					<tr id="head">
						
						<th class="heading unheading" id="right-head" rowspan="2" width="250px">CUSTOMER NAME / PROJECT / LOCATION</th>
						<th class="heading unheading" id="right-head" rowspan="2">SMD commitments</th>
						<th class="heading unheading" id="right-head" rowspan="2">Vibrator<br />Use</th>
						<th class="heading unheading" id="right-head" rowspan="2">Acctg.<br />Remarks</th>
						<th class="heading unheading" id="right-head" rowspan="2">TIME<br />(hours)</th>
						<th class="heading unheading" id="right-head" rowspan="2">REMARKS</th>
						<th class="heading unheading" id="right-head" rowspan="2">VOLUME</th>
						<th class="heading unheading" id="right-head" colspan="4">CONCRETE DESIGNS</th>
						<th class="heading unheading" id="right-head" rowspan="2">POURING TYPE</th>
						<th class="heading unheading" id="right-head" rowspan="2">STRUCTURE</th>
						<?php /*<th class="heading unheading" id="right-head" rowspan="2">BATCHING PLANT</th>*/?>
						<th class="heading unheading" id="right-head" rowspan="2">SERVICE ENG'R</th>
						<th class="heading unheading" id="right-head" rowspan="2">QA Rep.</th>
						<th class="heading unheading" id="right-head" rowspan="2">SALES ENG'R</th>
						<th class="heading unheading" id="left-head" rowspan="2">FORM</th>
					</tr>

					<tr>
						<td class="heading unheading" style="width:40px; border-left:1px solid #666666; border-bottom:1px solid #666666;" align="center">PSI</td>
						<td class="heading unheading" style="width:35px; border-left:1px solid #666666; border-bottom:1px solid #666666;" align="center">MSA</td>
						<td class="heading unheading" style="width:35px; border-left:1px solid #666666; border-bottom:1px solid #666666;" align="center">C</td>
						<td class="heading unheading" style="width:40px; border-left:1px solid #666666; border-bottom:1px solid #666666;" align="center">S</td>
					</tr>
		
		<?php	
			}
		?>

		

		<?php echo $dps_rept_normal ?>
		<?php echo $dps_rept_insert ?>


		<?php 
			if(isset($signature)){
				echo $signature;
			}
		?>
	</div>
</div>

</body>
	

	
	


	
	
