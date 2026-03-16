<?php
class Leavesv2 extends CI_Controller {

    var $current_year;
    var $email_recipient;

	 public function __construct()
	 {
		   parent::__construct();
           $this->load->library('email');
           $this->current_year = date("Y");
           $this->dateNow = date("Y-m-d H:m:s");

           //get the id of the employee who is currently logged
           $this->emp_id = $this->session->userdata('employee_id');
           $this->lvl = $this->session->userdata('userlvl');
           $this->firstname = $this->session->userdata('first_name');
           $this->lastname = $this->session->userdata('last_name');

           $this->email_recipient = 'ceriacoralph@gmail.com';
	 }

	function index()
        {

            //check if logged in
            if($this->session->userdata('is_logged_in')){
                
                //var_dump($this->session->userdata);
                //var_dump($this->functionlist->isLeaveViewer($this->lvl));

                if($this->functionlist->isLeaveSup($this->emp_id) OR $this->functionlist->isLeaveMngr($this->emp_id) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isLeaveViewer($this->lvl)){
                    //$data['status'] = "test";
                    $data['datenow'] =  $this->dateNow;
                    $data['empid'] = $this->emp_id;
                    $data['u_lvl'] = $this->lvl;
                    $data['leavesv2_page'] = 'index';

                    $this->pagemaker->setSoftname('Leave Monitoring V2.0');

                    $data['onleaves'] = $this->leaves_model2->get_on_leaves();

                    $this->body['view'] = 'leavesv2/index';
                    $this->body['content'] = $data;
                    $this->pagemaker->basePage($this->body,'Home');
                    
                }     
                else{ redirect('welcome/denied'); }

            }
            else{ redirect('main/login_leave'); }
    	}

    function leave_application(){


        if($this->session->userdata('is_logged_in')){
            //restrict for supervisor/manager/hr/cvr and administrator only
            if($this->functionlist->isLeaveSup($this->emp_id) OR $this->functionlist->isLeaveMngr($this->emp_id) OR $this->functionlist->isAdmin($this->lvl)){
                
                //check if supervisor
                if ($this->functionlist->isLeaveSup($this->emp_id)){
                    $dept_ids = $this->leaves_model2->get_dept_list($this->emp_id,"supervisor");
                    $data['leave_approver'] = 'supervisor';
                }
                elseif ($this->functionlist->isLeaveMngr($this->emp_id)){

                    $dept_ids = $this->leaves_model2->get_dept_list($this->emp_id,"manager");
                    $data['leave_approver'] = 'manager';

                    //check if the department has a supervisor assigned
                    //if not then make the manager to approved the application directly
                }
                elseif($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl)){
                    //get all the dept ids
                    $dept_ids = $this->leaves_model2->get_all_dept_list();
                    $data['leave_approver'] = 'manager';
                }

                $data['leave_apps'] = $this->leaves_model2->get_leaves_app($dept_ids);
                $data['leave_apps_pending'] = $this->leaves_model2->get_leaves_app_status_count($dept_ids,'PENDING');
                $data['leave_apps_approved'] = $this->leaves_model2->get_leaves_app_status_count($dept_ids,'APPROVED');
                $data['leave_apps_denied'] = $this->leaves_model2->get_leaves_app_status_count($dept_ids,'UNAPPROVED');

                $data['leavesv2_page'] = 'leave-app';
                $data['page_remark'] = "leaveAppPage";
                $this->pagemaker->setSoftname('Leave Monitoring V2.0');

                if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl)){
                    $this->body['view'] = 'leavesv2/leave_app_admin';
                }else{
                    $this->body['view'] = 'leavesv2/leave_app';
                }

                
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Home');
            }     
            else{ redirect('welcome/denied'); }

            header("Refresh: 240; URL=leave_application");

        }
        else{ redirect('main/login_leave'); }
          
    }

    function leave_status(){
        //check if logged in
            if($this->session->userdata('is_logged_in')){
                $data['status'] = "test";
                $data['datenow'] =  $this->dateNow;
                $data['leavesv2_page'] = 'leave-status';

                $this->pagemaker->setSoftname('Leave Monitoring V2.0');

                //$data['records'] = $this->leaves_model2->get_leave_records('','APPROVED');

                $this->body['view'] = 'leavesv2/leavestatus';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Home');
            }
            else{ redirect('main/login_leave'); }
    }

    function leave_records(){

            //check if logged in
            if($this->session->userdata('is_logged_in')){
                $data['status'] = "test";
                $data['datenow'] =  $this->dateNow;
                $data['leavesv2_page'] = 'leave-records';

                $this->pagemaker->setSoftname('Leave Monitoring V2.0');

                $data['records'] = $this->leaves_model2->get_leave_records('','APPROVED');

                $this->body['view'] = 'leavesv2/leaverecords';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Home');
            }
            else{ redirect('main/login_leave'); }
            
    }

    function emp_records(){

            //check if logged in
            if($this->session->userdata('is_logged_in')){
                $data['status'] = "test";
                $data['datenow'] =  $this->dateNow;
                $data['leavesv2_page'] = 'emp-records';

                $this->pagemaker->setSoftname('Leave Monitoring V2.0');

                //$data['records'] = $this->leaves_model2->get_leave_records('','APPROVED');

                $this->body['view'] = 'leavesv2/emprecords';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Home');
            }
            else{ redirect('main/login_leave'); }
            
    }

    function leave_mass(){
            //check if logged in
            if($this->session->userdata('is_logged_in')){
                $data['status'] = "test";
                $data['datenow'] =  $this->dateNow;
                $data['leavesv2_page'] = 'leave-mass';

                $this->pagemaker->setSoftname('Leave Monitoring V2.0');

                $data['deptlist'] = $this->leaves_model2->get_department_list();

                $this->body['view'] = 'leavesv2/leavemass';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Home');
            }
            else{ redirect('main/login_leave'); }
    }

    function leave_credits(){
            //check if logged in
            if($this->session->userdata('is_logged_in')){
                $data['status'] = "test";
                $data['datenow'] =  $this->dateNow;
                $data['leavesv2_page'] = 'leave-credit';

                $this->pagemaker->setSoftname('Leave Monitoring V2.0');

                //$data['deptlist'] = $this->leaves_model2->get_department_list();

                $data['credits'] = $this->leaves_model2->get_leave_credits();

                $this->body['view'] = 'leavesv2/leavecredit';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Home');
            }
            else{ redirect('main/login_leave'); }
    }

    

    //
    // All functions to perform ajax request
    // 
    //////////////////////////////////////////////////

    function ajax_get_employee(){
        $emp_q = strtoupper($this->input->get('query'));

        echo $this->leaves_model2->get_emp_id($emp_q);
        
    }

    function ajax_get_employee_by_dept(){
        $dept_id = $this->input->get('deptid');

        echo $this->leaves_model2->ajax_get_employee_by_dept($dept_id);
    }


    function ajax_get_emp_dept(){
        $emp_id = $this->input->get('emp_id');

        $res = json_encode($this->leaves_model2->get_emp_dept($emp_id));
        echo $res;
    }

    function ajax_submit_leave(){
        $emp_id = $this->input->post('sel-emp-id');
        $emp_name = $this->input->post('emp-name');
        $dept_id = $this->input->post('emp-dept-id');
        $dept = $this->input->post('emp-dept');
        $leave_reason = $this->input->post('leave-reason');
        $leave_duration = $this->input->post('leave-duration');


        $leave_data = array(
           'emp_id' => $emp_id,
           'dept_id' => $dept_id ,
           'dept' => $dept ,
           'emp_name' => $emp_name,
           'reason' => $leave_reason,
           'duration' => $leave_duration
        );

        $leave_id = $this->leaves_model2->recordleave($leave_data);

        $date_filed = date("Y-m-d H:i:s");
        $date_from = $this->input->post('dt-from');
        $date_to = $this->input->post('dt-to');
        $time_from = $this->input->post('tm-from');
        $time_to = $this->input->post('tm-to');
        $reliever = $this->input->post('reliever');
        $leave_type = $this->input->post('leave-type');
        $w_pay = $this->input->post('w-pay');
        $wo_pay = $this->input->post('wo-pay');

        $leave_details_data = array(
           'leave_id' => $leave_id ,
           'date_filed' => $date_filed ,
           'date_from' => $date_from,
           'date_to' => $date_to,
           'time_from' => $time_from ,
           'time_to' => $time_to,
           'reliever' => $reliever,
           'sup_app' => 'PENDING',
           'leave_type' => $leave_type ,
           'mngr_app' => 'PENDING',
           'w_pay' => $w_pay,
           'wo_pay' => $wo_pay
        );

        
        $id = $this->leaves_model2->recordleave_details($leave_details_data);
        // if($id > 0 ){
        //     //send mail
            
        //     mail_new_leave_app();
        //     return $id;
        // }else{
        //     //error
        //     return 0;
        // }

        //$this->mail_new_leave_app();

        echo $id;
    }

    function ajax_get_leave_app(){
        //$data['leave_apps'] = $this->leaves_model2->get_leaves_app();
        echo "test";
    }


    function ajax_approved_leave(){
        $leave_id = $this->input->post('leave-id');
        $leave_approver = $this->input->post('leave-approver');
        $approver_id = $this->input->post('approver-id');

        //get the approver initials
        $initials = $this->leaves_model2->get_approver_initials($approver_id);

        //check if suppervisor or manager
        switch ($leave_approver) {
            case 'supervisor':
                $data = array(
                   'sup_app' => "APPROVED",
                   'sup_app_time' => date("Y-m-d H:m:s"),
                   'sup_initial' => $initials
                );
                break;
            case 'manager':
                $data = array(
                   'mngr_app' => "APPROVED",
                   'mngr_app_time' => date("Y-m-d H:m:s"),
                   'mngr_initial' => $initials
                );
                break;
        }

        echo $this->leaves_model2->ajax_approved_leave($leave_id,$data);
        
    }

    function ajax_deny_leave(){
        $leave_id = $this->input->post('leave-id');
        $leave_approver = $this->input->post('leave-approver');
        $approver_id = $this->input->post('approver-id');

        //get the approver initials
        $initials = $this->leaves_model2->get_approver_initials($approver_id);

        //check if suppervisor or manager
        switch ($leave_approver) {
            case 'supervisor':
                $data = array(
                   'sup_app' => "UNAPPROVED",
                   'sup_app_time' => date("Y-m-d H:m:s"),
                   'sup_initial' => $initials
                );
                break;
            case 'manager':
                $data = array(
                   'mngr_app' => "UNAPPROVED",
                   'mngr_app_time' => date("Y-m-d H:m:s"),
                   'mngr_initial' => $initials
                );
                break;
        }


        echo $this->leaves_model2->ajax_deny_leave($leave_id,$data);
    }

    function ajax_get_times(){
        echo $this->functionlist->getTimeArrays();
    }

    function ajax_get_new_apps(){
        $emp_id = $this->input->post('emp-id');
        $app_ids = json_decode($this->input->post('app-ids'));

        //var_dump($app_ids); exit();

        if ($this->functionlist->isLeaveSup($emp_id)){
            $dept_ids = $this->leaves_model2->get_dept_list($emp_id,"supervisor");
        }elseif ($this->functionlist->isLeaveMngr($emp_id)){
            $dept_ids = $this->leaves_model2->get_dept_list($emp_id,"manager");
        }


        $id_arr = $this->leaves_model2->get_leaves_app_count($dept_ids);
        $db_app_cnt = count($id_arr);
        $browser_app_cnt = count($app_ids);

        // $db_app_cnt = $this->leaves_model2->get_leaves_app_count($dept_ids);

        $tmp_arr = array();

        if ($browser_app_cnt < $db_app_cnt){
            //get and compare the id's
            foreach ($id_arr as $row)
            {
               $tmp_arr[] = $row['leave_id'];
            }

            //print_r($tmp_arr);

            $arr_diff = array_diff($tmp_arr, $app_ids);

            $q_arr = array();
            foreach ($arr_diff as $l_ids) {
                $q_arr[] = "id = " . $l_ids;
            }

            //get the count of the array of ids and their corresponding leave ids


            //var_dump(count($q_arr));

            echo json_encode($q_arr);

            //$query_l_ids  =  join(" OR ",$q_arr);

            //$json_res = json_encode($this->leaves_model2->get_leaves_app($query_l_ids));
            
            //echo $json_res; 

        }else{
            //do nothing
            echo 'none';
        }
    }

    function ajax_get_emp_balance(){
        $emp_id = $this->input->get('emp_id');
        $year = date('Y');

        $credit  = $this->leaves_model2->ajax_get_leave_credits($emp_id,$year);
        $balance  = $this->leaves_model2->ajax_get_leave_balance($emp_id,$year);

        $new_balance = $credit - $balance;
        echo $new_balance;

    }

    function ajax_set_leave_remarks(){
        $leave_id = $this->input->post('leave-id');
        $leave_approver = $this->input->post('leave-approver');
        $leave_remarks = $this->input->post('leave-remarks');

        //check if suppervisor or manager
        switch ($leave_approver) {
            case 'supervisor':
                $data = array(
                   'sup_remarks' => $leave_remarks
                );
                break;
            case 'manager':
                $data = array(
                   'mngr_remarks' => $leave_remarks
                );
                break;
        }

        return $this->leaves_model2->ajax_set_leave_remarks($leave_id,$data);
    }

    function ajax_get_leave_remarks(){
        $leave_id = $this->input->post('leave-id');

        //return a json
        echo $this->leaves_model2->ajax_get_leave_remarks($leave_id);
    }

    function ajax_insert_massleave(){
        
        $leave_reason = $this->input->post('leave-reason');
        $leave_duration = $this->input->post('leave-duration');
        $date_filed = date("Y-m-d H:i:s");
        $date_from = $this->input->post('dt-from-mass');
        $date_to = $this->input->post('dt-to-mass');
        $time_from = $this->input->post('tm-from');
        $time_to = $this->input->post('tm-to');
        $leave_type = $this->input->post('leave-type');
        $w_pay = $this->input->post('w-pay');
        $wo_pay = $this->input->post('wo-pay');

        $empids = $this->input->post('massleave-cbox[]');
        

        //check if submitted id's variable is not null
        if (is_null($empids)){
            //do nothing
        }else{
            foreach ($empids as $val) {
                $emp_id = $val;

                //get the details of the employee using the emp_id
                $emp_details = $this->leaves_model2->get_emp_detail($emp_id);

                foreach ($emp_details as $emp) {
                    $emp_name = $emp->name;
                    $emp_dept_id = $emp->dept_id;
                    $emp_dept = $emp->dept;
                }

                $leave_data = array(
                   'emp_id' => $emp_id,
                   'dept_id' => $emp_dept_id ,
                   'dept' => $emp_dept ,
                   'emp_name' => $emp_name,
                   'reason' => $leave_reason,
                   'duration' => $leave_duration
                );

                $leave_id = $this->leaves_model2->recordleave($leave_data);


                $date_filed = $date_filed;
                $date_from = $date_from;
                $date_to = $date_to;
                $time_from = $time_from;
                $time_to = $time_to;
                $reliever = 'n/a';
                $leave_type = $leave_type;
                $w_pay = $w_pay;
                $wo_pay = $wo_pay;

                $leave_details_data = array(
                   'leave_id' => $leave_id ,
                   'date_filed' => $date_filed ,
                   'date_from' => $date_from,
                   'date_to' => $date_to,
                   'time_from' => $time_from ,
                   'time_to' => $time_to,
                   'reliever' => $reliever,
                   'sup_app' => 'APPROVED',
                   'leave_type' => $leave_type ,
                   'mngr_app' => 'APPROVED',
                   'w_pay' => $w_pay,
                   'wo_pay' => $wo_pay
                );

                //status are automatically approved.

                
                $this->leaves_model2->recordleave_details($leave_details_data);
            }
        }
    }

    function ajax_get_leave_records(){
        $filter_type = $this->input->post('type');
        $filter_value = $this->input->post('value');


        echo $this->leaves_model2->ajax_get_leave_records($filter_value,$filter_type);
    }

    function ajax_get_leave_status(){
        $emp_id = $this->input->post('emp-id');
        $leave_status = $this->input->post('leave-status');

        //check if emp_id is a designated leave encoder

        echo $this->leaves_model2->ajax_get_leave_status($emp_id,'','');

    }

    function ajax_update_credit(){
        $credit_id = $this->input->post('credit-id');
        $credit_value = $this->input->post('credit-value');

        $data = array(
           'credit' => $credit_value
        );

        echo $this->leaves_model2->ajax_update_credit($credit_id,$data);
    }

    



    /* testing modules */

    function test_send_email(){

        

        $this->email->from('jlregnersuite@gmail.com', 'JLRegner Suite');
        $this->email->to('ceriacoralph@gmail.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        if($this->email->send()){
            echo 'Email sent.';
        }else{
            show_error($this->email->print_debugger());
        }

        /*$this->load->library('email');

            $subject = 'This is a test from wamp';
            $message = '<p>This message has been sent for testing purposes. [ralphskie]</p>';

            // Get full html:
            $body =
                '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset='.strtolower(config_item('charset')).'" />
                    <title>'.html_escape($subject).'</title>
                    <style type="text/css">
                        body {
                            font-family: Arial, Verdana, Helvetica, sans-serif;
                            font-size: 16px;
                        }
                    </style>
                </head>
                <body>
                '.$message.'
                </body>
                </html>';
            // Also, for getting full html you may use the following internal method:
            //$body = $this->email->full_html($subject, $message);

            $result = $this->email
                ->from('ralphskieceriaco@gmail.com')
                ->reply_to('ralphskieceriaco@gmail.com')    // Optional, an account where a human being reads.
                ->to('ceriacoralph@gmail.com')
                ->subject($subject)
                ->message($body)
                ->send();

            var_dump($result);
            echo '<br />';
            echo $this->email->print_debugger();*/
    }

    function mail_new_leave_app(){
        $this->email->from('jlregnersuite@gmail.com', 'JLRegner Suite');
        $this->email->to($this->email_recipient);

        $this->email->subject('New Leave Application');
        $this->email->message('A new leave application is submitted. <br /> To view the details please click this link [http://www.jlregner.com/jlrsuite/leavesv2/leave_application]');

        $this->email->send();
    }


/*

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

    function add_massleave(){
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
    function get_leave_credits(){
            $id = $_POST['id'];
            $year = $_POST['year'];
            
            
            //query the leave_credits table for the employee id and specified year  
            $result = $this->leaves_model->get_leave_credits($id,$year);
           
            echo $result ;
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

                //$this->current_year = '2013';
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


        //----------------------------------------
        //
        //  Added by ralph for the online leave modules
        //
        //
        //----------------------------------------

        function onlineform(){
            //check if user has been logged in
            if($this->session->userdata('is_logged_in')){
                //$query_leave = $this->leaves_model->get_onleave();

                //$data['onleave'] = $query_leave['onleave'];
                //$data['onleave_count'] = $query_leave['onleave_count'];
                $data['status'] = "";

                $this->pagemaker->setSoftname('Leave Monitoring');

                $this->body['view'] = 'leaves/onlineform';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Online Leave Form');
            }else{
                redirect('main/login_leave');
            }
        }

*/
} 
