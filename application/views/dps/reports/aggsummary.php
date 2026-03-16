<?php
		/* get the result from the returned mysql query*/
		$rows = $result->num_rows();
		$i = 0;

		$agg_g1_vol = 0;
		$agg_34_vol = 0;
		
		while ( $i < $rows) {
				
				$row = $result->row($i);
				

				//$id = $row->o202_id;
				$agg = $row->book_msa;
				$vol = $row->batch_vol;
				switch ($agg) {
					case 'G1':
						$agg_g1_vol = $agg_g1_vol + $vol;
						break;

					case '3/4':
						$agg_34_vol = $agg_34_vol + $vol;
						break;
					
				}

		$i ++;
		}

		$agg_total = $agg_g1_vol + $agg_34_vol;

?>

	<td align="center" style="font-size: 1.4em;"><?php echo $rows ?></td>
	<td align="center" style="font-size: 1.4em;"><?php echo $agg_g1_vol ?></td>
	<td align="center" style="font-size: 1.4em;"><?php echo $agg_34_vol ?></td>
	<td align="center" style="color:blue;font-size: 1.5em;"><strong><?php echo $agg_total ?></strong></td>
