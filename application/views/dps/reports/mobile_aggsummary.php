<table id="mobile_agg_summ">
	
	<tr>
		<th rowspan="2">TIME</th>
		<th rowspan="2">CLIENTS</th>
		<th colspan="2">VOLUME</th>
		<th rowspan="2">TOTAL</th>
	</tr>
	<td colspan="1" align="center"><strong>G1</strong></td>
	<td colspan="1" align="center"><strong>3/4</strong></td>

	<tr >
		<!-- normal sched -->
		<td align="left"  style="font-size: 1em;"><strong>6am - 12nn</strong></td>
		<?php echo $clientcnt1?>
	</tr>

	<tr >
		<!-- insert sched -->
		<td align="left"  style="font-size: 1em;"><strong>1pm - 8pm</strong></td>
		<?php echo $clientcnt2 ?>
	</tr>

	<tr > 
		<!-- insert sched -->
		<td align="left" style="font-size: 1em;"><strong>9pm - 12mn</strong></td>
		<?php echo $clientcnt3 ?>
	</tr>
</table>