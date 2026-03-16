<?php
class Leaves extends CI_Controller {

    var $current_year;

	 public function __construct()
	 {
		   parent::__construct();
		   //$this->load->model('leaves_model');
		   //$this->load->library('leaveclass');
		   //$this->load->helper('url');
		   $this->load->helper('date');
		   $this->load->helper('form');
           $this->current_year = date("Y"); 
	 }

	function index()
        {
            //check if user has been logged in
            if($this->session->userdata('is_logged_in')){
                $query_leave = $this->leaves_model->get_onleave();

                $data['onleave'] = $query_leave['onleave'];
                $data['onleave_count'] = $query_leave['onleave_count'];

                $this->pagemaker->setSoftname('Leave Monitoring');

                $this->body['view'] = 'leaves/index';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Home');
            }else{
                redirect('main/login_leave');
            }
    		  
    		
    	}


	function leave()
        {
            //check if user has been logged in
            if($this->session->userdata('is_logged_in')){
        	 	//$query_employee = $this->leaves_model->get_employee_list();
                $query_employee = $this->leaves_model->get_employeelist();

        		$data['employee'] = $query_employee['employee'];
        		$data['employee_count'] = $query_employee['employee_count'];

                $data['dept'] = $this->leaves_model->get_department_list();

        	 	
                $this->pagemaker->setSoftname('Leave Monitoring');
        		$this->body['view'] = 'leaves/leave';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Employee List');
            }else{
                redirect('main/login_leave');
            }

    	}
	function addleave()
    	{
             //check if user has been logged in
            if($this->session->userdata('is_logged_in')){
        	 	$query_employee = $this->leaves_model->get_employee_list();

        		$data['employee'] = $query_employee['employee'];
                $this->pagemaker->setSoftname('Leave Monitoring');
        		$this->body['view'] = 'leaves/addleave';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Add Leave');
            }else{
                redirect('main/login_leave');
            }
    	}
    function add_leave()
        {
            //$id = $_POST['emp_name'];

            $year = $_POST['currentyear'];
            $id = $_POST['addleave_emp_name'];

            $leave_type = $_POST['leave_type'];

            if ($leave_type == 'undertime'){
                $this->leaves_model->set_leave($id,$year);
            }
            else{
                $paystatus = $_POST['addleave-nobalance'];
                $pay1 = $_POST['pay_amount1'];
                $pay2 = $_POST['pay_amount2'];
                $pay3 = $_POST['pay_amount3'];    //for employee that do not have balance but can leave

                

                if ($paystatus == 'zerobalance'){
                    //insert the details but do not subtract in the credit
                    //no update query needed just INSERT
                    //var_dump($paystatus); exit();
                    $this->leaves_model->set_leave_zero_balance($id,$year,$pay3);
                }
                else{
                    $paytotal = ($pay1 + $pay2); //this is the credit that will be subtracted to the current credit

                    $currentbalance = $_POST['emp-credit-balance'];
                
                    $newbalance = ($currentbalance - $paytotal);

                    $this->leaves_model->set_leave($id,$year,$newbalance,$paytotal);
                    $this->leaves_model->update_new_balance($id,$year,$newbalance);
                }

                

                 
            }
            
            
        }

    function add_massleave()
    {
        $data['status'] = '';

        $query_employee = $this->leaves_model->get_employeelist();
        $data['employee_list'] =  $query_employee['employee'];
        $this->pagemaker->setSoftname('Leave Monitoring');
        $this->body['view'] = 'leaves/addmassleave';
        $this->body['content'] = $data;
        $this->pagemaker->basePage($this->body,'Add Mass Leave');
       
    }

    function process_massleave(){

        $reason = $_POST['massleave-reason'];
        $date = $_POST['massleave-datefiled'];
        foreach ($_POST['emp-items'] as $val) {
            $id = $val;
        
            //echo 'inserting info of userid = ' . $checkbox1results ."<br />";

            //insert into database
            $this->leaves_model->insert_massleave($id,$reason,$date);
        }

        redirect('leaves/addleave');
    }

	function searchemployee()
        {
            //check if user has been logged in
            if($this->session->userdata('is_logged_in')){
    	 	  $query_employee = $this->leaves_model->get_employee_list();
    		  
    		  $data['employee'] = $query_employee['employee'];
              $this->pagemaker->setSoftname('Leave Monitoring');
    	 	  $this->body['view'] = 'leaves/searchemployee';
              $this->body['content'] = $data;
              $this->pagemaker->basePage($this->body,'Search Employee');
            }else{
                redirect('main/login_leave');
            }
    	} 
	function ajax_employee_search()
        {
            if (isset($_POST) && isset($_POST['empname'])) {
                $emp_id = $_POST['empname'];
                $year = $_POST['year'];


                

                //get the remaining balance of the employee
                $empStatus = $this->leaves_model->get_employee_status($emp_id);
                $arrLeaveCredit = $this->leaves_model->get_leave_credit($emp_id,$year);
                $arrLeaveBalance = $this->leaves_model->get_leave_credits($emp_id,$year);
                $arrEmployee = $this->leaves_model->get_employee_search_result($emp_id,$year);

                if (is_null($arrEmployee)){
                    
                    echo "<div class='error-notify'><p>There is no leave record for this employee.</p></div>";
                }
                else
                {
                    $total_w_pay = 0;
                    $total_wo_pay = 0;
                    $total_undertime = 0;
                    $leave_credit = 0;
                    $rem_balance = 0;

                    

                    foreach ($empStatus as  $empstatus) {
                        $emp_status = $empstatus->status;
                    }

                    //get the leave credit of the employee for the whole year
                    foreach ( $arrLeaveCredit as $leaveCredit) {
                        $leave_credit = $leaveCredit->credits;
                    }

                    $rem_balance =  $leave_credit;

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
                            $date_inclu = strtotime($employee->inclusive_from);
                            $date_to = strtotime($employee->inclusive_to);

                            $conv_datefrom = date("F d, Y", $datefrom);
                            $conv_date_inclu = date("M j, Y", $date_inclu);
                            $conv_date_to = date("M j, Y", $date_to);

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
                    echo "  <td align='left'>" . date("l", $datefrom) . "</td>";
                    //reason
                    echo "  <td align='left'>" . $employee->reason . "</td>";
                    
                    //date from
                    echo "  <td align='left'>" . $conv_date_inclu . "</td>";
                    //date to
                    echo "  <td align='left'>" . $conv_date_to . "</td>";
                    //remaining balance
                    //subtracted balance by with pay leave
                    //$rem_balance = $rem_balance - $employee->w_pay;
                    echo "  <td align='center'>" . $rem_balance . "</td>";
                    $rem_balance = $rem_balance - $employee->w_pay;

                    //with pay
                    if($employee->w_pay == 0){
                        echo "  <td align='center'></td>";
                    }else{
                        echo "  <td align='center'>" . $employee->w_pay . "</td>";
                    }
                    

                    //without pay
                    if($employee->wo_pay == 0){
                         echo "  <td align='center'></td>";
                    }else{
                         echo "  <td align='center'>" . $employee->wo_pay . "</td>";
                    }
                   
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
                 
                
                $bal_to_date = ($leave_credit - $total_w_pay);
               

                echo "<tr class='items'>";
                echo "</tr>";

                echo "<tr class='items search-summary'>";
                        echo "<td colspan='4'>";
                            echo "<p>Total Leaves with pay: <span>" . $total_w_pay . "</span></p>";
                            echo "<p>Total Leaves without pay: <span>" . $total_wo_pay . "</span></p>";
                            echo "<p>Total Undertime: <span>" . $total_undertime . "</span></p>";
                        echo "</td>";


                        //check if employee status is regular or retired
                        if ($emp_status == 'REGULAR'){
                            echo "<td colspan='4'>";    
                                echo "<p>Remaining Balance: <span>$rem_balance</span></p>";
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
               

                //print form_dropdown('cities',$arrFinal);
            } else {
                //echo 'no post variable setted';
                //redirect('leaves'); //Else redire to the site home page.
            }
        }   
    function maintenance()
	    {
	    	$data['title'] = 'Maintenance Page';
            $data['linkclass'] = 'maintenance';
            $this->pagemaker->setSoftname('Leave Monitoring');
		 	$this->load->view('templates/header', $data);
			$this->load->view('leaves/maintenance/index');
			$this->load->view('templates/footer');
	    }
    function leaverecords()
	 {
        //check if user has been logged in
        if($this->session->userdata('is_logged_in')){
    	 	$data['records'] = $this->leaves_model->get_leave_records();
            $this->pagemaker->setSoftname('Leave Monitoring');
            $this->body['view'] = 'leaves/maintenance/leaverecords';
            $this->body['content'] = $data;
            $this->pagemaker->basePage($this->body,'Leave Records');
        }else{
                redirect('main/login_leave');
        }
	 }
	function employee_filter() 
    	{
            if (isset($_POST) && isset($_POST['filter'])) {
                $emp_filter = $_POST['filter'];
                $emp_filter_value = $_POST['filtervalue'];
                
                $arrEmployee = $this->leaves_model->search_by_filter($emp_filter,$emp_filter_value);


                if ($arrEmployee == null){
                	
                    echo "<br /><div class='error-notify'><p>There is no record of employees from this filter.</p></div>";
                }
                else
                {

                //var_dump($arrEmployee); exit(); 


                    echo "<table id='leave-table' padding='0' class='tables employee-list-table'>";

                    echo "<tr id='head'>";
                    echo "  <th id='right-head'>Employee Name</th>";
                    echo "  <th class='heading'>Leave Credits</th>";
                    echo "  <th class='heading'>Total Leaves</th>";
                    echo "  <th class='heading'>Remaining Balance</th>";
                    echo "  <th id='left-head'>Department</th>";
                    echo "</tr>";

             
                foreach ($arrEmployee as $employee) {
                    //$arrFinal[$cities->city] = $cities->city;


                    echo "<tr class='items'>";
                
    					$fullname = $this->leaveclass->convert_Big_Ntilde($employee->fullname);

    			        if ($employee->department == null){
    			        	$employee->department = '<strong>n/a</strong>';
    			        }


                        //query for the leave credits
                                    $id = $employee->id;
                                    $year = mdate('%Y', time());
                                    $credit_for_year = 0;
                                    $credit_balance = 0;
                                    $rem_balance = 0 ;
                                    $wdpay = 0;
                                    $wdopay = 0;
                                    $leavecredits = $this->leaves_model->get_leave_credit($id,$year);
                                    

                                   //get the leave credit for the current year of the employee
                                    foreach ($leavecredits as $leave_credit) {
                                        $credit_for_year = $leave_credit->credits;
                                        $credit_balance = $leave_credit->balance;

                                    }
                                    $rem_balance = $credit_for_year;


                                    $arrEmployee = $this->leaves_model->get_employee_search_result($id,$year);
                                    if (is_array($arrEmployee)){
                                        foreach ($arrEmployee as $empleave) {
                                        
                                        //get all the leave of the employee
                                            $with_pay = $empleave->w_pay;
                                            $witho_pay = $empleave->wo_pay;
                                            $rem_balance = $rem_balance - $with_pay;
                                            $wdpay = $wdpay + $with_pay;
                                            $wdopay = $wdopay + $witho_pay;

                                        }

                                        //subtract the credit and the leave[with pay] and
                                    }

    			       $total_leave = $wdpay + $wdopay;
    		
                    echo "  <td align='left' id='left-item'><a href='empleave_summary?id=$id'>" .$fullname. "</a></td>";
                    echo "  <td align='center'>" . $credit_for_year . "</td>";
                    echo "  <td align='center'>" . $total_leave . "</td>";
                    echo "  <td align='center'>" . $rem_balance . "</td>";
                    echo "  <td align='center' id='left'>" . $employee->department . "</td>";
                    echo "</tr>";
                    

                    
                }
                 
                //Using the form_dropdown helper function to get the new dropdown.
                

                

                echo "</table><br />";
                } // end of the if condition when no record is found
               

                //print form_dropdown('cities',$arrFinal);
            } else {
            	//echo 'no post variable setted';
                redirect('leaves'); //Else redire to the site home page.
            }
        }


    function employee_letter_sort()
        {
            if (isset($_POST) && isset($_POST['value'])) {
                $sort_value = $_POST['value'];


                
                $arrEmployee = $this->leaves_model->search_by_letter_sort($sort_value);


                if ($arrEmployee == null){
                    
                    echo "<br /><div class='error-notify'><p>There is no record of employees from this filter.</p></div>";
                }
                else
                {

                //var_dump($arrEmployee); exit(); 


                    echo "<table id='leave-table' padding='0' class='tables employee-list-table'>";

                    echo "<tr id='head'>";
                    echo "  <th id='right-head'>Employee Name</th>";
                    echo "  <th class='heading'>Leave Credits</th>";
                    echo "  <th class='heading'>Total Leaves</th>";
                    echo "  <th class='heading'>Remaining Balance</th>";
                    echo "  <th id='left-head'>Department</th>";
                    echo "</tr>";

             
                foreach ($arrEmployee as $employee) {
                    //$arrFinal[$cities->city] = $cities->city;


                    echo "<tr class='items'>";
                
                        $fullname = $this->leaveclass->convert_Big_Ntilde($employee->fullname);

                        if ($employee->department == null){
                            $employee->department = '<strong>n/a</strong>';
                        }


                        //query for the leave credits
                                    $id = $employee->id;
                                    $year = mdate('%Y', time());
                                    $credit_for_year = 0;
                                    $credit_balance = 0;
                                    $rem_balance = 0 ;
                                    $wdpay = 0;
                                    $wdopay = 0;
                                    $leavecredits = $this->leaves_model->get_leave_credit($id,$year);
                                    //get the leave credit for the current year of the employee
                                    foreach ($leavecredits as $leave_credit) {
                                        $credit_for_year = $leave_credit->credits;
                                        $credit_balance = $leave_credit->balance;

                                    }
                                    $rem_balance = $credit_for_year;


                                    $arrEmployee = $this->leaves_model->get_employee_search_result($id,$year);
                                    if (is_array($arrEmployee)){
                                        foreach ($arrEmployee as $empleave) {
                                        
                                        //get all the leave of the employee
                                            $with_pay = $empleave->w_pay;
                                            $witho_pay = $empleave->wo_pay;
                                            $rem_balance = $rem_balance - $with_pay;
                                            $wdpay = $wdpay + $with_pay;
                                            $wdopay = $wdopay + $witho_pay;

                                        }

                                        //subtract the credit and the leave[with pay] and
                                    }

                                    

                       $total_leave = $wdpay + $wdopay;
            
                    echo "  <td align='left' id='left-item'><a href='empleave_summary?id=$id'>" .$fullname. "</a></td>";
                    echo "  <td align='center'>" . $credit_for_year . "</td>";
                    echo "  <td align='center'>" . $total_leave . "</td>";
                    echo "  <td align='center'>" . $rem_balance . "</td>";
                    echo "  <td align='center' id='left'>" . $employee->department . "</td>";
                    echo "</tr>";
                    

                    
                }
                 
                //Using the form_dropdown helper function to get the new dropdown.
                

                

                echo "</table><br />";
                } // end of the if condition when no record is found
               

                //print form_dropdown('cities',$arrFinal);
            } else {
                //echo 'no post variable setted';
                redirect('leaves'); //Else redirect to the site home page.
            }
        }
    function delete_leave_record()
        {
        	$id = $_POST['id'];
        	$this->leaves_model->del_leave_record($id);
        }
    function approve_pending()
        {
        	$data = $this->leaves_model->get_pending_leaves();
    	 	//$data['title'] = 'Leave Records';

    	 	//var_dump($data); exit();

    	 	//$this->load->view('templates/header', $data);
    		$this->load->view('leaves/approvepending',$data);
    		//$this->load->view('templates/footer');
        }
    function approve_leave_record()
        {
        	$id = $_POST['id'];
        	$this->leaves_model->approve_leave_record($id);
        }
    function editleave()
        {
            
        	if(isset($_GET['id']) AND isset($_GET['emp_id']) ){

        		$leave_id = $_GET['id'];
        		$leave_emp_id = $_GET['emp_id'];

        		$data['records'] = $this->leaves_model->get_specific_leave_record($leave_id,$leave_emp_id);

        	//var_dump($_GET['id']);

        	
            $this->body['view'] = 'leaves/editleave';
            $this->body['content'] = $data;
            $this->pagemaker->noBannerpage($this->body,'Edit Leave Record');
        	}
        	else{
        		redirect('leaves');
        	}
        }
    function update_leave_record()
        {
        	//update the single leave record
        	
        	$id = $_POST['id'];

        	//var_dump($id); exit();
        	$this->leaves_model->update_leave_record($id);
        }
    function leavecredits()
        {
            //check if user has been logged in
            if($this->session->userdata('is_logged_in')){
                $query_employee = $this->leaves_model->get_employee_list();
                $data['employee'] = $query_employee['employee'];
                $this->pagemaker->setSoftname('Leave Monitoring');
                $this->body['view'] = 'leaves/maintenance/leavecredits';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Leave Credits');
            }else{
                redirect('main/login_leave');
            }
        }
    function get_leave_credits()
        {
            $id = $_POST['id'];
            $year = $_POST['year'];
            

            $leave_w_pay = $this->leaves_model->get_real_emp_leaves($id,$year);
            
            //query the leave_credits table for the employee id and specified year  
            //revise by ralph june 15, 2015 because of buggy flow
            $credit = $this->leaves_model->get_real_leave_credit($id,$year);

            $rem_balance = $credit - $leave_w_pay;
           
            echo $rem_balance;

        }
    function add_credits()
        {
            $id = $_POST['id'];
            $year = $_POST['year'];
            $credit = $_POST['credits'];

            $result = $this->leaves_model->add_leave_credits($id,$year,$credit);
        }
    function edit_credits()
        {
            $id = $_POST['id'];
            $year = $_POST['year'];
            $credit = $_POST['credits'];

            $result = $this->leaves_model->edit_leave_credits($id,$year,$credit);
        }
    function empleave_summary()
        {
            $id = $_GET['id'];
            //var_dump($data['id']); exit();
            $data['title'] = 'Employee Leave Summary';
            $data['linkclass'] = 'leaves';

            //query the employee table for the id posted
            $data['emp_name'] = $this->leaves_model->get_employee_name($id);
            $data['emp_summary'] = $this->leaves_model->get_employee_summary($id);
            //var_dump($data['emp_name']); exit();
            $this->pagemaker->setSoftname('Leave Monitoring');
            $this->body['view'] = 'leaves/empleave_summary';
            $this->body['content'] = $data;
            $this->pagemaker->basePage($this->body,'Leave Summary');
        }
    function leave_reports()
        {

          $this->pagemaker->setSoftname('Leave Monitoring');

          $data['name'] = 'testing lang hehehe';
          $this->body['view'] = 'leaves/leave_report';
          $this->body['content'] = $data;
          $this->pagemaker->basePage($this->body,'Leave Report');
        }
    function ajax_leave_reports()
        {
            $value = $_POST['value'];
            $choice = $_POST['choice'];
            $hvalue = $_POST['headervalue'];
            $hchoice = $_POST['headerchoice'];

            $arrLeaveRecords = $this->leaves_model->get_leave_reports($choice,$value);

            $rept_header = $hchoice . ":" . $hvalue;

            if ($hchoice == 'Monthly'){
                switch ($hvalue) {
                    case 'January':
                        $selected_val = 1;
                        break;
                    case 'February':
                        $selected_val = 2;
                        break;
                    case 'March':
                        $selected_val = 3;
                        break;
                    case 'April':
                        $selected_val = 4;
                        break;
                    case 'May':
                        $selected_val = 5;
                        break;
                    case 'June':
                        $selected_val = 6;
                        break;
                    case 'July':
                        $selected_val = 7;
                        break;
                    case 'August':
                        $selected_val = 8;
                        break;
                    case 'September':
                        $selected_val = 9;
                        break;
                    case 'October':
                        $selected_val = 10;
                        break;
                    case 'November':
                        $selected_val = 11;
                        break;
                    case 'December':
                        $selected_val = 12;
                        break;
                    
                }

                //$this->current_year = '2014';
                $tmp_period = $this->leaveclass->days_in_month($selected_val,$this->current_year);
                $period =  $hvalue ." 1-".$tmp_period.",  ".$this->current_year;
            }

            if ($hchoice == 'Quarterly'){
                switch ($hvalue) {
                    case '1st Quarter':
                        $selected_val = 3;
                        $mval1 = 'January';
                        $mval2 = 'March';
                        break;
                    case '2nd Quarter':
                        $selected_val = 6;
                        $mval1 = 'April';
                        $mval2 = 'June';
                        break;
                    case '3rd Quarter':
                        $selected_val = 9;
                        $mval1 = 'July';
                        $mval2 = 'September';
                        break;
                    case '4th Quarter':
                        $selected_val = 12;
                        $mval1 = 'October';
                        $mval2 = 'December';
                        break;
                    
                    
                }
                $tmp_period = $this->leaveclass->days_in_month($selected_val,$this->current_year);
                $period =  $mval1 . " 1 - " . $mval2 . " " . $tmp_period . ",  ".$this->current_year;
            }


            if ($hchoice == 'Semi-Annual'){
                switch ($hvalue) {
                    case '1st Half':
                        $selected_val = 6;
                        $mval1 = 'January';
                        $mval2 = 'June';
                        break;

                    case '2nd Half':
                        $selected_val = 12;
                        $mval1 = 'July';
                        $mval2 = 'December';
                        break;
                }
                $tmp_period = $this->leaveclass->days_in_month($selected_val,$this->current_year);
                $period =  $mval1 . " 1 - " . $mval2 . " " . $tmp_period . ",  ".$this->current_year;
            }

            if ($hchoice == 'Annual'){
                $mval1 = 'January';
                $mval2 = 'December';
                $tmp_period = $this->leaveclass->days_in_month('12',$hvalue);
                $period =  $mval1 . " 1 - " . $mval2 . " " . $tmp_period . ",  ".$hvalue;
            }


            //for printing only
            
            echo "<div id='printonly'>";
                echo "<p id='leaverep-header'>" . $rept_header . "<br /><span>Period : " . $period . "</span></p>";
                echo "<p id='leaverep-gendate'>Generated : " . date('F d, Y') . "</p>";
            echo "</div>";
            
            if ($arrLeaveRecords == null){
                    
                    echo "<div class='error-notify'><p>There is no leave records found.</p></div>";
                }
                else
                {

                //var_dump($arrLeaveRecords); exit(); 


                    echo "<table id='leave-table' padding='0' class='tables'>";

                    echo "<tr id='head'>";
                    echo "  <th id='right-head' width='85px'>Date</th>";
                    echo "  <th class='heading'>Name</th>";
                    echo "  <th class='heading'>Dept</th>";
                    echo "  <th class='heading'>Reason</th>";
                    echo "  <th class='heading'>Duration</th>";
                    echo "  <th id='left-head'>Undertime</th>";
                    echo "</tr>";

             
                foreach ($arrLeaveRecords as $leave_report) {
                    //$arrFinal[$cities->city] = $cities->city;
                    $with = $leave_report->w_pay;
                    $without = $leave_report->wo_pay;
                    $undertime = $leave_report->hours;

                    $duration = $with + $without;
                    
                

                    echo "<tr class='items'>";
                    echo "  <td align='left' id='left-item'>" . $leave_report->inclusive_from . "</td>";
                    echo "  <td align='left'>&nbsp&nbsp" . $leave_report->fullname . "</td>";
                    echo "  <td align='center'>" . $leave_report->department . "</td>";
                    echo "  <td align='left'>&nbsp&nbsp" . $leave_report->reason . "</td>";
                    echo "  <td align='left'>&nbsp&nbsp" . $duration . "</td>";
                    echo "  <td align='left' id='left'>&nbsp&nbsp" . $undertime . "</td>";
                    echo "</tr>";
                
                

                }

                echo "</table>";

                


                } // end of the if condition when no record is found
        }

        function update_old_id()
        {
            $new_id = 500;

              for ($inc_id=1; $inc_id <=193; $inc_id++)
                { 
                    $new_id++;
                    $this->leaves_model->update_old_id_leave($inc_id,$new_id);
                    //var_dump($new_id); exit();

                }

            header('location:www.google.com');
            
            
        }

        //function of this module is for generation leave credits for all the employee
        //added by ralph january 22, 2013 ,special usage only
        function gencredit(){

            //$emp = $this->leaves_model->get_employee_list();
            //var_dump($emp);


            //$this->leaves_model->add_leave_credits($id,'2013','10')
        }

} 
