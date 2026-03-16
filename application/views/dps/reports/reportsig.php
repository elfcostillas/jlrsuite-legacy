<?php
	
		foreach ($siggy as $sig) {
			//var_dump($sig->rmcc_time); exit();
?>
			<td colspan="18" class="items" id="dps-report-wrapper">
				<table id="dpsreport-sig">

					<td width="13%" class="report-td-right">
						<strong>SMDC - <?php echo $sig->rmcc_init ?></strong><br />
						<?php echo $sig->rmcc_time ?>
					</td>

					<td width="13%" class="report-td-right">
						<strong>PS - <?php echo $sig->ps_init ?></strong><br />
						<?php echo $sig->ps_time ?>
					</td>

					<td width="13%" class="report-td-right">
						<strong>QA - <?php echo $sig->qa_init ?></strong><br />
						<?php echo $sig->qa_time ?>
					</td>

					<td width="13%" class="report-td-right">
						<strong>ACCTG - <?php echo $sig->acctg_init ?></strong><br />
						<?php echo $sig->acctg_time ?>
					</td>

					<td width="13%" class="report-td-right">
						<strong>SMD - <?php echo $sig->smd_init ?></strong><br />
						<?php echo $sig->smd_time ?>
					</td>

					<td width="13%" class="report-td-right">
						Legend:<br />
						<img src="<?php echo base_url("css/images/inserticon.png") ?>" /> - Insert<br />
						<img src="<?php echo base_url("css/images/reschedicon.png") ?>" /> - Reschedule
					</td>

					<td width="30%">
						* 14 days design in bold<br />
						* 7 days design with shade<br />
						* Initial higlighted item: DISPATCHER<br />
					</td>
				</table>
			</td>
<?php
		} //end of for each
	
?>