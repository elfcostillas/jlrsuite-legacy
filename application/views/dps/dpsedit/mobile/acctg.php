<table id="m-acctg-tbl">
	
	<tr id="heading">
		<th colspan="2">CUSTOMER</th>
		<th colspan="2">CONTRACT</th>
		<th>TERMS</th>
		<th>SALES</th>
		<th>ACCOUNTING REMARKS</th>

		<?php if(!$this->functionlist->isViewMobile($this->lvl)){ ?>
		<th>ACCEPT</th>
		<?php } ?>
	</tr>

	<?php
	ini_set('display_errors', 0);
	
		$rows = $result->num_rows();
		$i = 0;

		
		while ( $i < $rows) {
			$row = $result->row($i);
			
			$id = $row->o202_id;
			$project_id = $row->project_id;
			$client_id = $row->client_id;
			$form_no = $row->form_no;

			$modified_date = $row->modified_date;
			$modified_time = $row->modified_time;

			$cust_name = strtoupper($row->cust_name);
			$project_name = strtoupper($row->proj_name);
			$project_loc = strtoupper($row->proj_address);
			$acctg_remarks = $row->acctg_remarks;
			$fcode1 = $row->f_code1;
			$fcode2 = $row->f_code2;
			$special_se = $row->special_se;
			$acctg_notes = $row->note_acctg;
			$contract_no = $row->contract_no;
			$proj_code = $row->proj_code;
			$terms = $row->terms;
			// <!-- ADDED WBSOLON : SAP -->
			$cust_code = $row->cust_code;
	?>

	<?php 
		if($acctg_remarks == ''){
			$dpsedit_class = 'm_dpsedit-pending';
		}else{
			$dpsedit_class = '';
		}
	?>

	<tbody id="<?php echo $id ?>" class="<?php echo $dpsedit_class ?>">
		<tr class="row">
			<td rowspan="2" colspan="2" class="clientname">
				<p><strong><?php echo $cust_name ?></strong></p>
				<p><strong><?php echo $project_name ?></strong></p>	
				<p><?php echo $project_loc ?></p>
			</td>

			<td rowspan="1" colspan="2" align="center"> <!--from rowspan="0"-->
				<?php
					if ($contract_no <> 0){
						echo $contract_no;
					}else{
						echo 'n/a';
					}
					
				?>
			</td>
			<!-- ADDED WBSOLON : SAP -->
			<?php
    			$conn = odbc_connect('MSSQLServer', 'sa','Sb1@JLRC');
    			$result1=odbc_exec($conn,"SELECT TOP 1 a.CreditLine AS 'CREDIT_LIMIT',b.PymntGroup AS 'TERMS' FROM OCRD a inner join OCTG b on a.GroupNum = b.GroupNum Where a.CardCode = '$cust_code' ");
					// $cust_credit_sap = odbc_result($result1, "CREDIT_LIMIT");
					$cust_terms_sap  =odbc_result($result1, "TERMS");
				odbc_close($conn);
			?>

			<?php 
				// $query = $this->db->query("select cust_code,terms,credit_limit from jlr_customers_sap where cust_code = '{$cust_code}'");
				// foreach ($query->result_array() as $row)
				// {
       				// $cust_credit_sap =  $row['credit_limit'];
        			//$cust_terms_sap =	$row['terms'];       								
				// }
			?>
			<!-- <td align="center" style="font-style:italic;color:blue;"><?php echo $terms ?></td> -->

			<!-- ADDED WBSOLON : SAP -->
			<td align="center" style="font-style:italic;color:blue;"><?php echo $cust_terms_sap ?></td>


			<td align="center"><?php echo $special_se ?></td>
			
			<!-- FOR CVR REQUEST MOBILE VIEW ONLY  WBSOLON -->
			<?php if(!$this->functionlist->isViewMobile($this->lvl)){ ?>
			<td align="center">
				<select autocomplete="off" name="acctg-remarks" id="acctg-remarks<?php echo $id ?>" class="m_acctg-remarks">
					<?php
						foreach($remarks_acctg as $acctgrem_list){
								$acctgremark = $acctgrem_list;
								if ($acctg_remarks == $acctgremark){
									echo '<option selected="true" value="' . $acctgremark . '">' . $acctgremark .'</option>';
								}else{
									echo '<option value="' . $acctgremark . '">' . $acctgremark .'</option>';
								}
						}			
					?>
				</select>
			</td>
			<?php }else{ ?>
			<td align="center"><?php echo $acctg_remarks ?></td>	
			<?php } ?>


			<!-- FOR CVR REQUEST MOBILE VIEW ONLY  WBSOLON -->
			<?php if(!$this->functionlist->isViewMobile($this->lvl)){ ?>
			<td  align="center" rowspan="1">
				<!--
				<input type="checkbox" name="dpscheck"  class="dpscheck" id="<?php echo $id ?>" />
			-->
				<a href="#tab2" id="acctg-updatebut<?php echo $id ?>" class="m-acctg-updatebut m-acctg-updatebut">UPDATE</a>
				<input type="hidden" name="sched_date" value="<?php echo $modified_date ?>" />

				<?php
				if ($proj_code == '1'){
					echo "<button class ='prep-but' id='$id' title='Prepaid'>Unprepaid</button>";
				}
				?>		
			</td>
			<?php } ?>
	    </tr>
		<!-- FOR CVR REQUEST MOBILE VIEW ONLY  WBSOLON -->
		<?php if(!$this->functionlist->isViewMobile($this->lvl)){ ?>
	    <tr class="row">
			<td align="center" id="left" colspan="6"> <!--from colspan="4"-->
				<input autocomplete="off" type="text" name="acctg-otherrem" id="acctg-otherrem" class="m_acctg-remarks" value="<?php echo $acctg_notes ?>"/>
			</td>
	    
	    <?php }else{ ?>
	    	<td align="center" id="left" colspan="6"> <!--from colspan="4"-->
				<p><strong><?php echo $acctg_notes ?></strong></p>
			</td>
	    <?php } ?>
	    </tr>
	</tbody>

	<?php
		$i++;
		}
	?>

</table>