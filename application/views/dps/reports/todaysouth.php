
<div id="print-header-wrapper">
	<div id="dpsreport-headleft">
		<img src="<?php echo base_url("css/images/jlr_logo_print.jpg") ?>" />
		<p>READY-MIXED CONCRETE DEPARTMENT <br />DAILY POURING SCHEDULE <br /><i>As of <?php echo date("F d, Y") ?></i></p>
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
			case 'todaynorth':
				echo "<center><h2>NORTH</h2></center>";
				break;
		}
	?>
	
	<div id="report-table">
		<?php echo $dps_rept_normal ?>
		<?php echo $dps_rept_insert ?>
	</div>
</div>
	

	
	


	
	
