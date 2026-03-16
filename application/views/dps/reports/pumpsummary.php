<?php


		//process first plant3
		//next is plant4
		
		$pumpsumm = array();
		$pumpsumm[]=$plant3;
		$pumpsumm[]=$plant4;


		//count the size of the array
		
		$cnt = 0;


		$data[] = $pumpsumm[0]['result'];
		$data[] = $pumpsumm[1]['result'];

		$arr_cnt = count($data);

		$total_pump_sched_n = 0;
		$total_pump_sched_s = 0;


		$pump3 = 0;
		$pump4 = 0;
		$pump5 = 0;
		$pump6 = 0;
		$pump7 = 0;
		$pump8 = 0;
		//<!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
		$pump9 = 0;
		//<!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->
		$pump10 = 0;

		$pump3_s = 0;
		$pump4_s = 0;
		$pump5_s = 0;
		$pump6_s = 0;
		$pump7_s = 0;
		$pump8_s = 0;
		//<!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
		$pump9_s = 0;
		//<!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->
		$pump10_s = 0;



		$agg_g1_vol = 0;
		$agg_34_vol = 0;
		

		while($cnt <= $arr_cnt - 1){

			$rows = $data[$cnt]->num_rows();
			$i = 0;

			$pump_3_vol = 0;
			$pump_4_vol = 0;
			$pump_5_vol = 0;
			$pump_6_vol = 0;
			$pump_7_vol = 0;
			$pump_8_vol = 0;
			//<!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
			$pump_9_vol = 0;
			//<!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->
			$pump_10_vol = 0;

			$pump_3_cnt = 0;
			$pump_4_cnt = 0;
			$pump_5_cnt = 0;
			$pump_6_cnt = 0;
			$pump_7_cnt = 0;
			$pump_8_cnt = 0;
			//<!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
			$pump_9_cnt = 0;
			//<!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->
			$pump_10_cnt = 0;

			

			
			while ( $i < $rows) {
				
					
				
					
					$row = $data[$cnt]->row($i);

					//var_dump($row);

					//$id = $row->o202_id;
					$pump = $row->pour_type;
					$vol = $row->batch_vol;

					switch ($pump) {
						case 'PUMP 3':
							$pump_3_vol = $pump_3_vol + $vol;
							$pump_3_cnt = $pump_3_cnt + 1;
							break;

						case 'PUMP 4':
							$pump_4_vol = $pump_4_vol + $vol;
							$pump_4_cnt = $pump_4_cnt + 1;
							break;

						case 'PUMP 5':
							$pump_5_vol = $pump_5_vol + $vol;
							$pump_5_cnt = $pump_5_cnt + 1;
							break;

						case 'PUMP 6':
							$pump_6_vol = $pump_6_vol + $vol;
							$pump_6_cnt = $pump_6_cnt + 1;
							break;

						case 'PUMP 7':
							$pump_7_vol = $pump_7_vol + $vol;
							$pump_7_cnt = $pump_7_cnt + 1;
							break;
						case 'PUMP 8':
							$pump_8_vol = $pump_8_vol + $vol;
							$pump_8_cnt = $pump_8_cnt + 1;
							break;
						//<!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
						case 'PUMP 9':
						 	$pump_9_vol = $pump_9_vol + $vol;
						 	$pump_9_cnt = $pump_9_cnt + 1;
						 	break;
						//<!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->
						case 'PUMP 10':
						 	$pump_10_vol = $pump_10_vol + $vol;
						 	$pump_10_cnt = $pump_10_cnt + 1;
						 	break;



					}
			$i ++;
			}




			if($cnt == 0){
				// var_dump('lol');

				// exit();
				//this is plant3
				

				//$total_pump_sched_n_tmp = $pump_3_cnt + $pump_4_cnt + $pump_5_cnt + $pump_6_cnt + $pump_7_cnt;
				//$total_pump_sched_n_tmp = $pump_3_vol + $pump_4_vol + $pump_5_vol + $pump_6_vol + $pump_7_vol + $pump_8_vol;
				//$total_pump_sched_n_tmp = $pump_3_vol + $pump_4_vol + $pump_5_vol + $pump_6_vol + $pump_7_vol + $pump_8_vol + $pump_9_vol;//<!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
				$total_pump_sched_n_tmp = $pump_3_vol + $pump_4_vol + $pump_5_vol + $pump_6_vol + $pump_7_vol + $pump_8_vol + $pump_9_vol + $pump_10_vol;//<!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->


				if($total_pump_sched_n_tmp == 0){
					$total_pump_sched_n = '';
				}else{
					$total_pump_sched_n = '<span class="pump-n">' . $total_pump_sched_n_tmp . '</span>';
				}

				if($pump_3_cnt == 0){
					$pump3 = '';
				}else{
					$pump3 = '<span class="pump-n">' . $pump_3_vol . '</span>';
					//<strong>' . $pump_3_cnt . '</strong>/
				}

				if($pump_4_cnt == 0){
					$pump4 = '';
				}else{
					$pump4 = '<span class="pump-n">' . $pump_4_vol . '</span>';
					//<strong>' . $pump_4_cnt . '</strong>/
				}

				if($pump_5_cnt == 0){
					$pump5 = '';
				}else{
					$pump5 = '<span class="pump-n">' . $pump_5_vol . '</span>';
					//<strong>' . $pump_5_cnt . '</strong>/
				}

				if($pump_6_cnt == 0){
					$pump6 = '';
				}else{
					$pump6 = '<span class="pump-n">' . $pump_6_vol . '</span>';
					//<strong>' . $pump_6_cnt . '</strong>/
				}

				if($pump_7_cnt == 0){
					$pump7 = '';
				}else{
					$pump7 = '<span class="pump-n">' . $pump_7_vol . '</span>';
					//<strong>' . $pump_7_cnt . '</strong>/
				}

				if($pump_8_cnt == 0){
					$pump8 = '';
				}else{
					$pump8 = '<span class="pump-n">' . $pump_8_vol . '</span>';
					//<strong>' . $pump_7_cnt . '</strong>/
				}

				//<!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
				if($pump_9_cnt == 0){
				 	$pump9 = '';
				 }else{
				 	$pump9 = '<span class="pump-n">' . $pump_9_vol . '</span>';
				 	//<strong>' . $pump_9_cnt . '</strong>/
				}
				//<!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->
				if($pump_10_cnt == 0){
				 	$pump10 = '';
				 }else{
				 	$pump10 = '<span class="pump-n">' . $pump_10_vol . '</span>';
				 	//<strong>' . $pump_10_cnt . '</strong>/
				}


			}else{
				//this is plant4
				
				//$total_pump_sched_s_tmp = $pump_3_cnt + $pump_4_cnt + $pump_5_cnt + $pump_6_cnt + $pump_7_cnt;
				//$total_pump_sched_s_tmp = $pump_3_vol + $pump_4_vol + $pump_5_vol + $pump_6_vol + $pump_7_vol + $pump_8_vol ;
				//$total_pump_sched_s_tmp = $pump_3_vol + $pump_4_vol + $pump_5_vol + $pump_6_vol + $pump_7_vol + $pump_8_vol + $pump_9_vol; //<!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
				$total_pump_sched_s_tmp = $pump_3_vol + $pump_4_vol + $pump_5_vol + $pump_6_vol + $pump_7_vol + $pump_8_vol + $pump_9_vol + $pump_10_vol; //<!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->


				if($total_pump_sched_s_tmp == 0){
					$total_pump_sched_s = '';
				}else{
					$total_pump_sched_s = '<span class="pump-s">' . $total_pump_sched_s_tmp . '</span>';
				}

				if($pump_3_cnt == 0){
					$pump3_s = '';
				}else{
					$pump3_s = '<span class="pump-s">' . $pump_3_vol . '</span>';
					//<strong>' . $pump_3_cnt . '</strong>/
				}

				if($pump_4_cnt == 0){
					$pump4_s = '';
				}else{
					$pump4_s = '<span class="pump-s">' . $pump_4_vol . '</span>';
					//<strong>' . $pump_4_cnt . '</strong>/
				}

				if($pump_5_cnt == 0){
					$pump5_s = '';
				}else{
					$pump5_s = '<span class="pump-s">' . $pump_5_vol . '</span>';
					//<strong>' . $pump_5_cnt . '</strong>/
				}

				if($pump_6_cnt == 0){
					$pump6_s = '';
				}else{
					$pump6_s = '<span class="pump-s">' . $pump_6_vol . '</span>';
					//<strong>' . $pump_6_cnt . '</strong>/
				}

				if($pump_7_cnt == 0){
					$pump7_s = '';
				}else{
					$pump7_s = '<span class="pump-s">' . $pump_7_vol . '</span>';
					//<strong>' . $pump_7_cnt . '</strong>/
				}
				if($pump_8_cnt == 0){
					$pump8_s = '';
				}else{
					$pump8_s = '<span class="pump-s">' . $pump_8_vol . '</span>';
					//<strong>' . $pump_7_cnt . '</strong>/
				}
				//<!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
				 if($pump_9_cnt == 0){
				 	$pump9_s = '';
				 }else{
					$pump9_s = '<span class="pump-s">' . $pump_9_vol . '</span>';
				//	<strong>' . $pump_8_cnt . '</strong>
				}
				//<!-- EDITED MOCINCO NOVEMBER 04,2020 - ADD PUMP10-->
				if($pump_10_cnt == 0){
				 	$pump10_s = '';
				}else{
				 	$pump10_s = '<span class="pump-s">' . $pump_10_vol . '</span>';
				 	//<strong>' . $pump_10_cnt . '</strong>/
				}



			}


			$cnt ++;
		}


		
		// var_dump($total_pump_sched_n);
		// var_dump($total_pump_sched_s); exit();


		



		

		

?>



	
<td align="center"><?php echo $pump3 ?><?php echo $pump3_s ?></td>
<td align="center"><?php echo $pump4 ?><?php echo $pump4_s ?></td>
<td align="center"><?php echo $pump5 ?><?php echo $pump5_s ?></td>
<td align="center"><?php echo $pump6 ?><?php echo $pump6_s ?></td>
<td align="center"><?php echo $pump7 ?><?php echo $pump7_s ?></td>
<td align="center"><?php echo $pump8 ?><?php echo $pump8_s ?></td>
<td align="center"><?php echo $pump9 ?><?php echo $pump9_s ?></td> <!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
<td align="center"><?php echo $pump10 ?><?php echo $pump10_s ?></td> <!-- EDITED WBSOLON JULY 18,2019 - ADD PUMP9-->
<td align="center"><?php echo $total_pump_sched_n ?><?php echo $total_pump_sched_s ?></td>
