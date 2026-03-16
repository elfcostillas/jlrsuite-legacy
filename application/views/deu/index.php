<div class="semifluid" id="deu-main-wrapper" >
	<div id="perfrep-button-wrapper">
		<a href="deu/perf_report" class="perfrep-button" >Performance Report</a>
	</div>
	

	<div id="deu-summary-wrapper">

		<div id="left" class="summarybox">
			<h2>QAD</h2>
			<?php echo $qad_summary ?>
		</div>

		<div id="center" class="summarybox">
			<h2>RMCD</h2>
			<?php echo $rmcd_summary ?>
		</div>

		<div id="right" class="summarybox">
			<h2>RMD Performance Indicator</h2>
			<table id="deu-summary-tbl">
				<tr id="heading">
					<th>TARGET</th>
					<th>OVERALL</th>
				</tr>

				<tr class="items" id="pi">
					<td align="center"><?php echo $pi['oat'] ?></td>
					<td align="center"><?php echo $pi['ova'] ?></td>
				</tr>
			</table>
		</div>

	</div>

	<br />
	<br />
	<br />
	

	<h1 class='deu-h1'>QAD/RMD MAJOR REPAIRS</h1>
	<?php echo $pendingMajorS ?>
	<br /><br />
	<h1 class='deu-h1'>RMCD MAJOR REPAIRS</h1>
	<?php echo $pendingMajorN ?>
	<br /><br />
	<h1 class='deu-h1'>RUNNING REPAIRS</h1>
	<?php echo $pendingRunning ?>

</div>