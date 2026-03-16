<div id="dps-tables-wrapper">
		
		  			
					<table id="mytable">
						
						<tr id="heading">
							<th width="200">CUSTOMER</th>
							<th>SALES ENGINEER</th>
							<th>CONTRACT NO</th>
							<th>CREDIT LIMIT</th>
							<th>TERMS</th>
							<th>ACCOUNTING REMARKS</th>
							<th>OTHER REMARKS</th>
							<th>ACCEPT</th>
							<th>APPROVAL</th>
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

								$cust_name = strtoupper($row->cust_name);
								$project_name = strtoupper($row->proj_name);
								$project_loc = strtoupper($row->proj_address);

								$str = $row->book_psi;
								$agg_design = $row->book_msa;
								$curing = $row->book_cd;
								$slump_design = $row->book_sp;
								$pouring = $row->pour_type;
								$structure_design = $row->structure;
								$remarks = $row->remarks;
								$estvolume = $row->batch_vol;
								
								$sched_date = $row->sched_date;
								$sched_time = $row->sched_time;

								$modified_date = $row->modified_date;
								$modified_time = $row->modified_time;

								$coor_status = $row->coor_status;
								$smd_status = $row->smd_status;

								$design_status = $row->design_status;

								$acctg_remarks = $row->acctg_remarks;
								$fcode1 = $row->f_code1;
								$fcode2 = $row->f_code2;
								$special_se = $row->special_se;
								$acctg_notes = $row->note_acctg;
								$contract_no = $row->contract_no;
								$proj_code = $row->proj_code;
								$credit = $row->credit;
								$terms = $row->terms;
								$cust_code = $row->cust_code;
								
						?>



						<tr class="items acctg-remtr" id="<?php echo $id ?>">
							<td  align="left" id="left-item" class="scheduler-left-item">
								<p class="info" id="customer"><strong><?php echo $cust_name ?></strong></p>
								<p class="info" ><strong><?php echo $project_name ?></strong></p>	
								<p class="info" ><?php echo $project_loc ?></p>	
							</td>	

										
							<td align="center"><?php echo $special_se ?></td>
							<td align="center">
								<?php
									if ($contract_no <> 0){
										echo $contract_no;
									}else{
										echo 'n/a';
									}
									
								?>
							</td>

							<?php
								//$server = '172.17.56.117';
    							$user = 'sa';
    							$pass = 'Sb1@JLRC';
    							//Define Port
    							//$port='Port=1433';
    							//$database = 'SBOLIVE_JLRC';
								$host = '172.17.56.117';
								$db = 'SBOLIVE_JLRC';
								$connection_string = "DRIVER={ODBC Driver 17 for SQL Server};SERVER=$host;PORT=1433;DATABASE=$db";

    							// $conn = odbc_connect('MSSQLServer', 'sa','Sb1@JLRC');
    							$conn = odbc_connect($connection_string,$user,$pass);
    							   							
    							$result1=odbc_exec($conn,"SELECT TOP 1 a.CreditLine AS 'CREDIT_LIMIT',b.PymntGroup AS 'TERMS' FROM OCRD a inner join OCTG b on a.GroupNum = b.GroupNum Where a.CardCode = '$cust_code' ");
																
									 $cust_credit_sap = odbc_result($result1, "CREDIT_LIMIT");
									 $cust_terms_sap  =odbc_result($result1, "TERMS");

								// $query = $this->db->query("select cust_code,terms,credit_limit from jlr_customers_sap where cust_code = '{$cust_code}'");

								// 	foreach ($query->result_array() as $row)
								// 	{
       	 								//$cust_credit_sap =  $row['credit_limit'];
         								//$cust_terms_sap =	$row['terms'];
        								
								// 	}
								odbc_close($conn);

							?>

							
							<!-- <td align="center" style="font-size:15px;font-weight: bold;"><?php echo $cust_credit_sap; ?></td>
							<td align="center" style="font-size:12px;font-style: oblique;"><?php echo $cust_terms_sap; ?></td> -->

							<!-- <td align="center" style="font-size:15px;font-weight: bold;"><?php echo number_format($credit,2) ?></td>
							<td align="center" style="font-size:12px;font-style: oblique;"><?php echo $terms ?></td> -->

							<td align="center" style="font-size:15px;font-weight: bold;"><?php echo number_format($cust_credit_sap,2) ?></td>
							<td align="center" style="font-size:12px;font-style: oblique;"><?php echo $cust_terms_sap ?></td>
							<?php 
								if($acctg_remarks == ''){
									$dpsedit_class = 'dpsedit-pending';
								}else{
									$dpsedit_class = '';
								}
							?>

							<td  align="center" class="<?php echo $dpsedit_class ?>">
								<select autocomplete="off" name="acctg-remarks" id="acctg-remarks<?php echo $id ?>" class="acctg-remarks">
									<?php
										foreach($remarks_acctg as $acctgrem_list){
												$acctgremark = $acctgrem_list;
												/*if ($acctg_remarks == $acctgremark ){*/
												if ($acctg_remarks == $acctgremark || (preg_match("/{$acctg_remarks}/i", $acctgremark) && $acctg_remarks <>'') ){
													echo '<option selected="true" value="' . $acctgremark . '">' . $acctgremark .'</option>';
												}else{
													echo '<option value="' . $acctgremark . '">' . $acctgremark .'</option>';
												}
										}			
									?>
								</select>
							</td>

							<td  align="center" class="<?php echo $dpsedit_class ?>">
								<input autocomplete="off" type="text" name="acctg-otherrem" id="acctg-otherrem" value="<?php echo $acctg_notes ?>"/>
							</td>

							
							<td align="center" id="left">
								<input type="checkbox" name="dpscheck"  class="dpscheck" id="<?php echo $id ?>" />
								<a href="#tab2" id="acctg-updatebut<?php echo $id ?>" class="edit-dps-updatebut acctg-updatebut">Update</a>
								<input type="hidden" name="sched_date" value="<?php echo $modified_date ?>" />
							</td>	
							
							<td align="center"> <?php
							if ($proj_code == '1'){
								echo "<button class ='prep-but' id='$id' title='Prepaid'>Unprepaid</button>";
							}else{
								echo "_";
							}
							?>
							</td>
							

						</tr>

						<?php
							$i++;
							}
						?>

							
					</table>
					 
				</div>