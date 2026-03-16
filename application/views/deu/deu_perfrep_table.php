<table class="deu-table" border="0" cellspacing="0" cellpadding="0">
	<tr id="heading">
		<th width="100">DATE</th>
		<th width="70">UNITS (QAD)</th>
		<th width="40">A</th>
		<th width="40">D</th>
		<th width="40">A%</th>
		<th width="40">T%</th>
		<th width="70">AVERAGE</th>

		<th width="70">UNITS (RMCD)</th>
		<th width="40">A</th>
		<th width="40">D</th>
		<th width="40">A%</th>
		<th width="40">T%</th>
		<th width="70">AVERAGE</th>

		<th width="40">PI TARGET</th>
		<th width="40">PI OVERALL</th>

	</tr>

	<?php
		
		/* get the result from the returned mysql query*/
		$i = 1;
		foreach ($result->result() as $row)
 		{
				
				$id = $row->id;

				$date = $row->record_date;

				$q_dt_units = $row->qad_dt_u;
				$q_pl_units = $row->qad_pl_u;
				$q_bh_units = $row->qad_bh_u;
				$q_bd_units = $row->qad_bd_u;

				$q_dt_actual = $row->qad_dt_a;
				$q_pl_actual = $row->qad_pl_a;
				$q_bh_actual = $row->qad_bh_a;
				$q_bd_actual = $row->qad_bd_a;

				$q_dt_d = $row->qad_dt_d;
				$q_pl_d = $row->qad_pl_d;
				$q_bh_d = $row->qad_bh_d;
				$q_bd_d = $row->qad_bd_d;

				$q_dt_perca = $row->qad_dt_perca;
				$q_pl_perca = $row->qad_pl_perca;
				$q_bh_perca = $row->qad_bh_perca;
				$q_bd_perca = $row->qad_bd_perca;

				$q_dt_perct = $row->qad_dt_perct;
				$q_pl_perct = $row->qad_pl_perct;
				$q_bh_perct = $row->qad_bh_perct;
				$q_bd_perct = $row->qad_bd_perct;

				$qad_average = $row->qad_average;
				
				//rmcd

				$r_tm_units = $row->rmcd_tm_u;
				$r_pump_units = $row->rmcd_pump_u;
				$r_pl_units = $row->rmcd_pl_u;
				$r_ss_units = $row->rmcd_ss_u;

				$r_tm_actual = $row->rmcd_tm_a;
				$r_pump_actual = $row->rmcd_pump_a;
				$r_pl_actual = $row->rmcd_pl_a;
				$r_ss_actual = $row->rmcd_ss_a;

				$r_tm_d = $row->rmcd_tm_d;
				$r_pump_d = $row->rmcd_pump_d;
				$r_pl_d = $row->rmcd_pl_d;
				$r_ss_d = $row->rmcd_ss_d;

				$r_tm_perca = $row->rmcd_tm_perca;
				$r_pump_perca = $row->rmcd_pump_perca;
				$r_pl_perca = $row->rmcd_pl_perca;
				$r_ss_perca = $row->rmcd_ss_perca;

				$r_tm_perct = $row->rmcd_tm_perct;
				$r_pump_perct = $row->rmcd_pump_perct;
				$r_pl_perct = $row->rmcd_pl_perct;
				$r_ss_perct = $row->rmcd_ss_perct;

				$rmcd_average = $row->rmcd_average;

				$rmdpi_target = $row->rmdpi_target;
				$rmdpi_overall = $row->rmdpi_overall;
	?>

	

	<tr class="items">
		<td align="center" class="perfrep-tbltd"><?php echo $date ?></td>

		<td align="center" class="perfrep-tbltd">
			<div class="tbl-horitems altrapoy"><p>DT<span><?php echo $q_dt_units ?></span></p></div>
			<div class="tbl-horitems"><p>PL<span><?php echo $q_pl_units ?></span></p></div>
			<div class="tbl-horitems altrapoy"><p>BH<span><?php echo $q_bh_units ?></span></p></div>
			<div class="tbl-horitems"><p>BD<span><?php echo $q_bd_units ?></span></p></div>
		</td>

		<td align="center" class="perfrep-tbltd">
			<div class="tbl-horitems altrapoy"><p><?php echo $q_dt_actual ?></p></div>
			<div class="tbl-horitems"><p><?php echo $q_pl_actual ?></p></div>
			<div class="tbl-horitems altrapoy"><p><?php echo $q_bh_actual ?></p></div>
			<div class="tbl-horitems"><p><?php echo $q_bd_actual ?></p></div>
		</td>

		<td align="center" class="perfrep-tbltd">
			<div class="tbl-horitems altrapoy"><p><?php echo $q_dt_d ?></p></div>
			<div class="tbl-horitems"><p><?php echo $q_pl_d ?></p></div>
			<div class="tbl-horitems altrapoy"><p><?php echo $q_bh_d ?></p></div>
			<div class="tbl-horitems"><p><?php echo $q_bd_d ?></p></div>
		</td>

		<td align="center" class="perfrep-tbltd">
			<div class="tbl-horitems altrapoy"><p><?php echo $q_dt_perca ?></p></div>
			<div class="tbl-horitems"><p><?php echo $q_pl_perca ?></p></div>
			<div class="tbl-horitems altrapoy"><p><?php echo $q_bh_perca ?></p></div>
			<div class="tbl-horitems"><p><?php echo $q_bd_perca ?></p></div>
		</td>

		<td align="center" class="perfrep-tbltd">
			<div class="tbl-horitems altrapoy"><p><?php echo $q_dt_perct ?></p></div>
			<div class="tbl-horitems"><p><?php echo $q_pl_perct ?></p></div>
			<div class="tbl-horitems altrapoy"><p><?php echo $q_bh_perct ?></p></div>
			<div class="tbl-horitems"><p><?php echo $q_bd_perct ?></p></div>
		</td>

		<td align="center" class="perfrep-tbltd">
			<?php echo $qad_average ?>
		</td>




		<td align="center" class="perfrep-tbltd">
			<div class="tbl-horitems altrapoy"><p>TM<span><?php echo $r_tm_units ?></span></p></div>
			<div class="tbl-horitems"><p>PUMP<span><?php echo $r_pump_units ?></span></p></div>
			<div class="tbl-horitems altrapoy"><p>PL<span><?php echo $r_pl_units ?></span></p></div>
			<div class="tbl-horitems"><p>SS<span><?php echo $r_ss_units ?></span></p></div>
		</td>

		<td align="center" class="perfrep-tbltd">
			<div class="tbl-horitems altrapoy"><p><?php echo $r_tm_actual ?></p></div>
			<div class="tbl-horitems"><p><?php echo $r_pump_actual ?></p></div>
			<div class="tbl-horitems altrapoy"><p><?php echo $r_pl_actual ?></p></div>
			<div class="tbl-horitems"><p><?php echo $r_ss_actual ?></p></div>
		</td>

		<td align="center" class="perfrep-tbltd">
			<div class="tbl-horitems altrapoy"><p><?php echo $r_tm_d ?></p></div>
			<div class="tbl-horitems"><p><?php echo $r_pump_d ?></p></div>
			<div class="tbl-horitems altrapoy"><p><?php echo $r_pl_d ?></p></div>
			<div class="tbl-horitems"><p><?php echo $r_ss_d ?></p></div>
		</td>

		<td align="center" class="perfrep-tbltd">
			<div class="tbl-horitems altrapoy"><p><?php echo $r_tm_perca ?></p></div>
			<div class="tbl-horitems"><p><?php echo $r_pump_perca ?></p></div>
			<div class="tbl-horitems altrapoy"><p><?php echo $r_pl_perca ?></p></div>
			<div class="tbl-horitems"><p><?php echo $r_ss_perca ?></p></div>
		</td>

		<td align="center" class="perfrep-tbltd">
			<div class="tbl-horitems altrapoy"><p><?php echo $r_tm_perct ?></p></div>
			<div class="tbl-horitems"><p><?php echo $r_pump_perct ?></p></div>
			<div class="tbl-horitems altrapoy"><p><?php echo $r_pl_perct ?></p></div>
			<div class="tbl-horitems"><p><?php echo $r_ss_perct ?></p></div>
		</td>

		<td align="center" class="perfrep-tbltd">
			<?php echo $rmcd_average ?>
		</td>

		<td align="center" class="perfrep-tbltd">
			<?php echo $rmdpi_target ?>
		</td>

		<td align="center" class="perfrep-tbltd">
			<?php echo $rmdpi_overall ?>
		</td>
		
	</tr>

	

	<?php
		$i++;
		}

	?>


</table>