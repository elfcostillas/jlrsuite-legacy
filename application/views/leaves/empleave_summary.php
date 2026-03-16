    <div id="content" class="grid-940">

		<div class="content-body">
			
			<?php  
				foreach ($emp_name as $name_list){
					$name = $name_list->last_name . ", " . $name_list->first_name;

				}
	
				//endforeach;
			?>

			<h2>
				<p><?php echo $name ?>'s Leave Summary for Year <?php echo date('Y',time())?></p>
				<p id="gendate2">Report generated : <?php echo date('F d, Y',time())?></p>
			</h2>


				
			<?php
				$emp_id = $_GET['id'];
                $year = mdate('%Y', time());

                //get the remaining balance of the employee
                $empStatus = $this->leaves_model->get_employee_status($emp_id);
                $arrLeaveCredit = $this->leaves_model->get_leave_credit($emp_id,$year);
                $arrLeaveBalance = $this->leaves_model->get_leave_credits($emp_id,$year);

                $arrEmployee = $this->leaves_model->get_employee_search_result($emp_id,$year);
                 
                //var_dump($arrEmployee); exit();

                if ($arrEmployee == null){
                    
                    echo "<div class='error-notify'><p>There is no leave record for this employee.</p></div>";
                }
                else
                {
                    $total_w_pay = 0;
                    $total_wo_pay = 0;
                    $total_undertime = 0;
                    $leave_credit = 0;

                    foreach ( $arrLeaveCredit as $leaveCredit) {
                        $leave_credit = $leaveCredit->credits;
                    }

                    foreach ($empStatus as  $empstatus) {
                        $emp_status = $empstatus->status;
                    }
                //var_dump($arrEmployee); exit(); 


                    echo "<table id='leave-table' padding='0' class='tables'>";

                    echo "<tr id='head'>";
                    echo "  <th id='right-head'>Date Filed</th>";
                    echo "  <th class='heading'>Day</th>";
                    echo "  <th class='heading'>Reason</th>";
                    echo "  <th class='heading'>Date From</th>";
                    echo "  <th class='heading'>Date To</th>";
                    echo "  <th class='heading'>Remaining Balance</th>";
                    echo "  <th class='heading'>w/ Pay</th>";
                    echo "  <th class='heading'>w/o Pay</th>";
                    echo "  <th class='heading'>Hours</th>";
                    echo "  <th class='heading'>Duration</th>";
                    echo "  <th id='left-head'>Type</th>";
                    echo "</tr>";

             
                foreach ($arrEmployee as $employee) {
                    //$arrFinal[$cities->city] = $cities->city;


                    echo "<tr class='items'>";
                            $datefrom = strtotime($employee->date_filed);
                            $conv_datefrom = date("F d, Y", $datefrom);
                    	if($conv_datefrom == null){
                    		$conv_datefrom = "<i><strong>n/a</strong></i>";
                    	}
                    	if($employee->reason == null){
                    		$employee->reason = "<i><strong>n/a</strong></i>";
                    	}
                    	if($employee->leave_type == null){
                    		$employee->leave_type = "<i><strong>n/a</strong></i>";
                    	}

                    echo "  <td align='left' id='left-item'>" . $conv_datefrom . "</td>";
                    //day
                    echo "  <td align='center'>" . date("l", $datefrom) . "</td>";
                    //reason
                    echo "  <td align='center'>" . $employee->reason . "</td>";
                    
                    //date from
                    echo "  <td align='center'>" . $employee->inclusive_from . "</td>";
                    //date to
                    echo "  <td align='center'>" . $employee->inclusive_to . "</td>";
                    //remaining balance
                    echo "  <td align='center'>" . $employee->running_bal . "</td>";
                    //with pay
                    echo "  <td align='center'>" . $employee->w_pay . "</td>";
                    //without pay
                    echo "  <td align='center'>" . $employee->wo_pay . "</td>";
                    //hours
                    echo "  <td align='center'>" . $employee->hours . "</td>";

                    //duration
                    $duration = ($employee->w_pay + $employee->wo_pay);
                    echo "  <td align='center'>" . $duration . "</td>";
                    //type
                    echo "  <td align='center' id='left'>" . $employee->leave_type . "</td>";


                    
                    echo "</tr>";

                    
                    $total_w_pay = ($total_w_pay + $employee->w_pay);
                    $total_wo_pay = ($total_wo_pay + $employee->wo_pay);
                    $total_undertime = ($total_undertime + $employee->hours);

                    
                }
                 
                //Using the form_dropdown helper function to get the new dropdown.
                $bal_to_date = ($leave_credit - $total_w_pay);
                //$bal_to_date = ($arrLeaveCredit - $total_w_pay);

                echo "<tr class='items'>";
                echo "</tr>";

                echo "<tr class='items search-summary'>";
                        echo "<td colspan='4'>";
                            echo "<p>Total Leaves with pay: <span>" . $total_w_pay . "</span></p>";
                            echo "<p>Total Leaves without pay: <span>" . $total_wo_pay . "</span></p>";
                            echo "<p>Total Undertime: <span>" . $total_undertime . "</span></p>";
                        echo "</td>";


                        //check if employee statsu is regular or retired
                        if ($emp_status == 'REGULAR'){
                            echo "<td colspan='4'>";    
                                echo "<p>Remaining Balance: <span>$arrLeaveBalance</span></p>";
                                echo "<p>Charged to last pay: <span>n/a</span></p>";
                            echo "</td>";
                        }
                        elseif($emp_status == 'RESIGNED'){
                             echo "<td colspan='4'>";    
                                echo "<p>Remaining Balance: <span>n/a</span></p>";
                                echo "<p>Charged to last pay: <span>$arrLeaveBalance</span></p>";
                            echo "</td>";
                        }
                        

                        echo "<td colspan='3' id='left'>";    
                             echo "<p>Balance to date: <span>".  $bal_to_date ."</span></p>";
                        echo "</td>";

                    echo "</tr>";

                echo "</table>";

                


                } // end of the if condition when no record is found

                ?>
			
		</div>
				
		

	</div>