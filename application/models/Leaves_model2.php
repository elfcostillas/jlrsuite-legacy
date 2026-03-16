<?php
class Leaves_model2 extends CI_Model {

	public function __construct()
	{
        $this->current_year = date("Y");
	}

    function get_leaves_app($query_deptid)
    {
        $queryString = "SELECT * FROM view_hr_test_leave WHERE (" . $query_deptid . ") AND date_to >= CURDATE()";
        $query =  $this->db->query($queryString);

        if($query->num_rows() > 0)  {
            $res = $query->result();
        }else{
            $res = 0;
        }

        return $res;
    }

    function get_leaves_app_count($query_deptid)
    {

        $queryString = "SELECT leave_id FROM view_hr_test_leave WHERE (" . $query_deptid . ") AND date_to >= CURDATE()";

        $query =  $this->db->query($queryString);

        return $query->result_array();
    }

    function get_leaves_app_status_count($query_deptid,$status)
    {

        $queryString = "SELECT leave_id FROM view_hr_test_leave WHERE (" . $query_deptid . ") AND date_to >= CURDATE() AND mngr_app = '{$status}' ";

        $query =  $this->db->query($queryString);

        if ($query->num_rows() > 0){
            return $query->num_rows();
        }else{
            return 0;
        }
    }

    function recordleave($leave){
        
        $this->db->insert('hr_test_leave', $leave);
        $last_id = $this->db->insert_id();

        return $last_id;
        
       
    }

    function recordleave_details($leave_details){
        
        $this->db->insert('hr_test_leave_details', $leave_details);
        $id = $this->db->affected_rows();

        return $id;
    }

    function get_emp_id($emp_q){
        
        $this->db->select("CONCAT(last_name,',',first_name)as value,o1_id as data",FALSE);
        $this->db->like('last_name', $emp_q,'both');
        $query = $this->db->get('jlr_employees');
        
        $json =  json_encode($query->result());

        return '{"suggestions":' . $json . '}';
    }

    function get_approver_initials($id){
        $this->db->select("initials",FALSE);
        $this->db->where('o1_id', $id);
        $query = $this->db->get('jlr_employees');

        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
              $ini = $row->initials;
           }
        }else{
            $ini = 'null';
        }

        return $ini;
    }

    function get_emp_dept($empid){
        $this->db->select("dept_id,dept",FALSE);
        $this->db->where('o1_id', $empid);
        $query = $this->db->get('jlr_employees');

        return $query->result();

    }

    function get_emp_detail($empid){
        $this->db->select("CONCAT(last_name,',',first_name) as name,dept_id,dept",FALSE);
        $this->db->where('o1_id', $empid);
        $query = $this->db->get('jlr_employee_list');

        return $query->result();
    }

    function get_dept_list($emp_id,$option){
        $this->db->select("id as dept_id",FALSE);

        switch ($option) {
            case 'supervisor':
                $this->db->where('supervisor_id', $emp_id);
                break;
            case 'manager':
                $this->db->where('manager_id', $emp_id);
                break;
        }
        

        $query = $this->db->get('jlr_departments');

        $res = array();
        if($query->num_rows() > 0){
            foreach ($query->result() as $row)
            {
              
               $res[] = "dept_id = " . $row->dept_id;
            }

            $query_dept_id  =  join(" OR ",$res);

            return $query_dept_id;

        }else{
            //do nothing
        }

        //return $query->result();    
    }

    function get_all_dept_list(){
        $this->db->select("id as dept_id",FALSE);
        $this->db->where('not ISNULL(division)');
        $query = $this->db->get('jlr_departments');

        $res = array();
        if($query->num_rows() > 0){
            foreach ($query->result() as $row)
            {
              
               $res[] = "dept_id = " . $row->dept_id;
            }

            $query_dept_id  =  join(" OR ",$res);

            return $query_dept_id;

        }else{
            //do nothing
        }

        //return $query->result();    
    }

    function check_ifhas_supervisor($dept_id){
        $this->db->select("supervisor_id",FALSE);
        $this->db->where('id', $dept_id);
        $this->db->where('not ISNULL(supervisor_id)');
        $query = $this->db->get('jlr_departments');

        if ($query->num_rows() > 0)
        {
            return true;
        }else{
            return false;
        }

      
    }

    function get_leave_records($filter,$status){
        $this->db->select("*",FALSE);
        $this->db->where('mngr_app',$status);
        $query = $this->db->get('view_hr_test_leave');

        if ($query->num_rows() > 0)
        {
            $res = $query->result();
        }else{
            $res = 0;
        }

        return $res;
    }

    function get_on_leaves(){
        $this->db->select("*",FALSE);
        $this->db->where('NOW() BETWEEN date_from and date_to');
        $query = $this->db->get('view_hr_test_leave');

        if ($query->num_rows() > 0)
        {
            $res = $query->result();
        }else{
            $res = 0;
        }

        return $res;
    }

    function get_department_list(){
        $this->db->select("department,id as dept_id",FALSE);
        $this->db->where('NOT ISNULL(division)');
        $query = $this->db->get('jlr_departments');

        if ($query->num_rows() > 0)
        {
            $res = $query->result();
        }else{
            $res = 0;
        }

        return $res;
    }

    function get_leave_credits(){
        $this->db->select("jlr_employees.o1_id as empid,CONCAT(last_name,',',first_name) as name,credit,id as credit_id",FALSE);
        $this->db->where('jlr_employees.o1_id = hr_test_leave_credits.emp_id');
        $this->db->where('year',$this->current_year);
        $query = $this->db->get('jlr_employees,hr_test_leave_credits');

        if ($query->num_rows() > 0)
        {
            $res = $query->result();
        }else{
            $res = 0;
        }

        return $res;
    }




    /* AJAX METHODS BELOW */


    function ajax_approved_leave($leave_id,$data){

        $this->db->where('leave_id', $leave_id);
        $this->db->update('hr_test_leave_details', $data); 
       
        if ($this->db->affected_rows() > 0){
            //success
            echo "success";
        }else{
            echo "error";
        }

    }

    function ajax_deny_leave($leave_id,$data){

        $this->db->where('leave_id', $leave_id);
        $this->db->update('hr_test_leave_details', $data); 
       
        if ($this->db->affected_rows() > 0){
            //success
            echo "success";
        }else{
            echo "error";
        }

    }

    function ajax_get_leave_credits($empid,$year){
        
        $this->db->select("credit",FALSE);
        $this->db->where('emp_id', $empid);
        $this->db->where('year', $year);
        $query = $this->db->get('hr_test_leave_credits');

        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
              $credit = $row->credit;
           }
        }else{
            $credit = 0;
        }

        return $credit;
    }

    function ajax_get_leave_balance($empid,$year){
        
        $this->db->select("SUM(w_pay) as leave_count",FALSE);
        $this->db->where('emp_id', $empid);
        $this->db->where('YEAR(date_from)', $year);
        $this->db->where('mngr_app', 'APPROVED');
        $query = $this->db->get('view_hr_test_leave');

        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
              $l_count = $row->leave_count;
           }
        }else{
            $l_count = 0;
        }

        return $l_count;
    }


    function ajax_set_leave_remarks($leave_id,$data){
        $this->db->where('leave_id', $leave_id);
        $this->db->update('hr_test_leave_details', $data); 
       
        if ($this->db->affected_rows() > 0){
            //success
            echo "success";
        }else{
            echo "error";
        }
    }

    function ajax_get_leave_remarks($leave_id){
        $this->db->select("sup_remarks,mngr_remarks",FALSE);
        $this->db->where('leave_id', $leave_id);
        $query = $this->db->get('view_hr_test_leave');

        $json =  json_encode($query->result());

        return $json;
    }

    function ajax_get_employee_by_dept($dept_id){
        $this->db->select("CONCAT(last_name,',',first_name) as name,o1_id as emp_id,",FALSE);
        $this->db->where('dept_id', $dept_id);
        $query = $this->db->get('jlr_employee_list');

        $json =  json_encode($query->result());

        return $json;
    }

    function ajax_insert_massleave($leave_details){
        $this->db->insert('hr_test_leave', $leave_details);
    }

    function ajax_get_leave_records($filter_value,$filter_type){

        switch ($filter_type) {
            case 'by-dept':
                $type = 'dept';
                break;
            
            case 'by-emp':
                $type = 'emp_name';
                break;

            case 'by-leavetype':
                $type = 'leave_type';
                break;

            case 'by-period':
                $type = 'dept';
                break;
        }

        $this->db->select("*",FALSE);
        $this->db->where($type, $filter_value);
        $query = $this->db->get('view_hr_test_leave');

        $json =  json_encode($query->result()); 

        return $json;
    }


    function ajax_get_leave_status($emp_id,$status,$test){
        $this->db->select("*",FALSE);
        $this->db->where('emp_id', $emp_id);
        $this->db->order_by('date_filed', 'DESC');
        $query = $this->db->get('view_hr_test_leave');

        $json =  json_encode($query->result()); 

        return $json;
    }

    function ajax_update_credit($credit_id,$data){
        $this->db->where('id', $credit_id);
        $this->db->update('hr_test_leave_credits', $data); 
       
        if ($this->db->affected_rows() > 0){
            //success
            echo "success";
        }else{
            echo "error";
        }
    }



/*
    function get_employee_name($emp_id){
        $query = $this->db->query("SELECT CONCAT(first_name,' ',last_name) as name FROM `jlr_employees` where o1_id = '{$emp_id}' ");
        return $query->result();
    }

*/


/*

    function get_onleave()
    	{
    		$dateNow = date("Y-m-d");
            $yearNow = date("Y");
            
    		$query = $this->db->query(
                "SELECT
                CONCAT(jlr_employees.last_name,', ',jlr_employees.first_name) as fullname,
                hr_leave.reason,
                hr_leave.w_pay,
                hr_leave.wo_pay,
                hr_leave.inclusive_from,
                hr_leave.inclusive_to,
                hr_leave.hours,
                hr_leave.leave_type
                 FROM 
                `hr_leave`, jlr_employees 
                WHERE 
                jlr_employees.o1_id = hr_leave.emp_id 
                AND 
                (hr_leave.inclusive_from <= '{$dateNow}' AND hr_leave.inclusive_to >= '{$dateNow}')
                AND (YEAR(inclusive_from) = '{$yearNow}' AND YEAR(inclusive_to) = '{$yearNow}')
                ORDER BY fullname,inclusive_from ASC
                ")->result_array();

    		return array(
        			'onleave' => $query,
        			'onleave_count' => count($query)
    				);

    	
    	}
    function get_employee_name($id)
        {

            $query = $this->db->query("SELECT * FROM  `jlr_employees` WHERE o1_id='{$id}'");
            return $query->result();    
        }
    function get_employee_summary($id)
        {
            $year = date('Y',time());
            $query = $this->db->query("SELECT * FROM  `hr_leave` WHERE o200_id='{$id}' AND YEAR(date_filed) = '{$year}'");
            return $query->result();    
        }
    function get_department_list()
        {
            $query = $this->db->query("SELECT DISTINCT company_assigned_div as department FROM  `jlr_emp_personal_info` ORDER BY department ");
            return $query->result();    
        }
	function get_employee_list()
    	{
           
    		$query = $this->db->query("SELECT * FROM jlr_employees,jlr_emp_personal_info WHERE jlr_employees.o1_id = jlr_emp_personal_info.employee_id AND `company_status` <> 'RESIGNED' ORDER BY jlr_employees.last_name ")->result_array();
    		
    		return array(
        			'employee' => $query,
        			'employee_count' => count($query)
    				);
    	
    	}

    function get_employeelist()
        {
            $query = $this->db->query("SELECT 
                                    CONCAT(jlr_employees.last_name,', ',jlr_employees.first_name) as fullname,
                                    jlr_employees.o1_id,
                                    jlr_emp_personal_info.company_assigned_div as department
                                    FROM jlr_employees,jlr_emp_personal_info
                                    WHERE jlr_employees.o1_id = jlr_emp_personal_info.employee_id
                                    AND jlr_emp_personal_info.company_status <> 'RESIGNED'
                                    ORDER BY jlr_emp_personal_info.company_assigned_div,fullname")->result_array();
            
            return array(
                    'employee' => $query,
                    'employee_count' => count($query)
                    );
        }
	function search_employee_history()
    	{
    		//$query = $this->db->query('SELECT * FROM leave WHERE id=')->result_array();
    	}
    function get_employee_status($id)
        {
           $query = $this->db->query("SELECT company_status as status FROM `jlr_emp_personal_info` WHERE employee_id = '{$id}' ");
             
            if ($query->num_rows > 0) {
                return $query->result();
            } 
        }
	function get_employee_search_result($id,$year) 
        {
            $query = $this->db->query("SELECT * FROM `hr_leave` WHERE emp_id = '{$id}' AND YEAR(date_filed) = '{$year}' ORDER BY `date_filed` ");
             
            if ($query->num_rows > 0) {
                return $query->result();
            }
        }
    function set_leave($id,$year,$newbalance,$paytotal)
        {
            

            $leave_type = $_POST['leave_type'];

            if ($leave_type == 'undertime'){
                //insert to 
                $data = array(
                    'emp_id' => $id,
                    'date_filed' => $_POST['datefiled_picker'],
                    'inclusive_from' => $_POST['inclusivefrom_picker'],
                    'inclusive_to' => $_POST['inclusiveto_picker'],
                    'time_from' => $_POST['timefrom'],
                    'time_to' => $_POST['timeto'],
                    'reason' => $_POST['reason'],
                    'running_bal' => $_POST['emp-credit-balance'], //current balance do not subtract
                    'leave_type' => $_POST['leave_type'],
                    'hours' => $_POST['undertime-hours'],
                    
                );
            }
            else{
                //add the pay_amount1 + pay_amount2 then subtract it to the current balance and also insert it in the hours
                

                $pay_type1 = $_POST['pay_type1'];

                if ($pay_type1 == 'with pay'){
                    $withpay = $_POST['pay_amount1'];
                    $withoutpay = $_POST['pay_amount2'];
                }
                elseif ($pay_type1 == 'without pay'){
                    $withpay = $_POST['pay_amount2'];
                    $withoutpay = $_POST['pay_amount1'];
                }

                $data = array(
                    'emp_id' => $id,
                    'date_filed' => $_POST['datefiled_picker'],
                    'inclusive_from' => $_POST['inclusivefrom_picker'],
                    'inclusive_to' => $_POST['inclusiveto_picker'],
                    'time_from' => $_POST['timefrom'],
                    'time_to' => $_POST['timeto'],
                    'reason' => $_POST['reason'],
                    'running_bal' =>  $newbalance, //current balance do not subtract
                    'leave_type' => $_POST['leave_type'],
                    'w_pay' =>  $withpay,
                    'wo_pay' => $withoutpay,
                    
                );
            }



        	

    		return $this->db->insert('hr_leave', $data);

            
            

        }


    function set_leave_zero_balance($id,$year,$pay3)
    {
        
            $data = array(
                'emp_id' => $id,
                'date_filed' => $_POST['datefiled_picker'],
                'inclusive_from' => $_POST['inclusivefrom_picker'],
                'inclusive_to' => $_POST['inclusiveto_picker'],
                'time_from' => $_POST['timefrom'],
                'time_to' => $_POST['timeto'],
                'reason' => $_POST['reason'],
                'running_bal' =>  '0', //current balance do not subtract
                'leave_type' => $_POST['leave_type'],
                'w_pay' =>  '0',
                'wo_pay' => $pay3,
                
            );

        return $this->db->insert('hr_leave', $data);

    }

    function update_new_balance($id,$year,$newbalance)
        {
            //update the leave credits table
            $query = $this->db->query("UPDATE `hr_leavecredits` SET hr_leavecredits.balance = $newbalance WHERE hr_leavecredits.o201_id = $id AND hr_leavecredits.year = $year ");
        }

    function search_by_letter_sort($sort_value)
        {
            $query = $this->db->query("SELECT
                     CONCAT(jlr_employees.last_name,', ',jlr_employees.first_name) as fullname,
                    jlr_employees.o1_id as id,
                    jlr_emp_personal_info.company_assigned_div as department
                    FROM  `jlr_employees`,`jlr_emp_personal_info` 
                    WHERE jlr_employees.last_name LIKE '{$sort_value}%' AND jlr_employees.o1_id = jlr_emp_personal_info.employee_id AND jlr_emp_personal_info.company_status <> 'RESIGNED'
                    ORDER BY jlr_emp_personal_info.company_assigned_div,jlr_employees.last_name");
             
                if ($query->num_rows > 0) {
                    return $query->result();
                }
        }
    function search_by_filter($filter,$filterValue)
        {
        	if ($filter == 'department'){
        		//search by department
        		$query = $this->db->query("SELECT
                     CONCAT(jlr_employees.last_name,', ',jlr_employees.first_name) as fullname,
                    jlr_employees.o1_id as id,
                    jlr_emp_personal_info.company_assigned_div as department
                    FROM  `jlr_employees`,`jlr_emp_personal_info` 
                    WHERE jlr_emp_personal_info.company_assigned_div = '{$filterValue}' AND jlr_employees.o1_id = jlr_emp_personal_info.employee_id AND jlr_emp_personal_info.company_status <> 'RESIGNED'
                    ORDER BY fullname ASC");
             
    	        if ($query->num_rows > 0) {
    	            return $query->result();
    	        }
        	}
        	else{
        		//search by status
                //$query = $this->db->query("SELECT * FROM  `jlr_employees` WHERE status = '{$filterValue}'");
             
                //if ($query->num_rows > 0) {
                //    return $query->result();
                //}
        	}
        }
    function get_leave_records()
        {
        	//get the active leave records
            //bug detected dated january 22, 2013
            // AND should be OR
        	$query = $this->db->query(
                "SELECT 
                    jlr_employees.first_name,
                    jlr_employees.last_name,
                    hr_leave.o200_id,
                    hr_leave.emp_id,
                    hr_leave.date_filed,
                    hr_leave.inclusive_from,
                    hr_leave.inclusive_to,
                    hr_leave.reason,
                    hr_leave.status 
        		FROM  `hr_leave`,`jlr_employees` 
        		WHERE jlr_employees.o1_id = hr_leave.emp_id 
        		AND year(date_filed) = '2013' ORDER BY `date_filed`
        		");
             
    	        if ($query->num_rows > 0) {
    	            return $query->result();
    	        }
        }
    function del_leave_record($id)
        {
            //var_dump($id); exit();
        	//delete record  --> not totally delete just set the status to discarded so that even it is not seen it is recorded in the database
        	$query = $this->db->query("UPDATE `hr_leave` SET hr_leave.status = 'Discarded' WHERE hr_leave.o200_id = '{$id}'");

        	//test query for automatic update of the status to inactive if finished
        	//UPDATE `leave` SET status ='Inactive' WHERE status = 'Approved' AND inclusive_to <= '2012-09-28' 
        }
    function get_pending_leaves()
    	{
    		$query = $this->db->query('SELECT * FROM `hr_leave` WHERE status = "Pending" ')->result_array();
    		
    		return array(
        			'pending_leaves' => $query,
        			'pending_leave_count' => count($query)
    				);
    	
    	}
	function approve_leave_record($id)
        {
        	//delete record  --> not totally delete just set the status to discarded so that even it is not seen it is recorded in the database
        	$query = $this->db->query("UPDATE `hr_leave` SET hr_leave.status = 'Approved' WHERE hr_leave.id = '{$id}' AND hr_leave.status = 'Pending' ");

        	//test query for automatic update of the status to inactive if finished
        	//UPDATE `leave` SET status ='Inactive' WHERE status = 'Approved' AND inclusive_to <= '2012-09-28' 
        }
    function get_specific_leave_record($id,$emp_id)
        {
        	//get the active leave records
        	$query = $this->db->query(
        		"SELECT
        			hr_leave.date_filed,
        			hr_leave.inclusive_from,
        			hr_leave.inclusive_to,
        			hr_leave.time_from,
        			hr_leave.time_to,
        			hr_leave.reason,
        			hr_leave.leave_type,
        			hr_leave.o200_id,
        			hr_leave.emp_id,
        			jlr_employees.first_name,
        			jlr_employees.last_name
        		FROM  `hr_leave`,`jlr_employees` 
        		WHERE jlr_employees.o1_id = hr_leave.emp_id 
        		AND (hr_leave.o200_id = '{$id}' AND hr_leave.emp_id = '{$emp_id}')
        		");
             
    	        if ($query->num_rows > 0) {
    	            return $query->result();
    	        }

        }
    function update_leave_record($id)
        {
        	//var_dump($id); exit();
        	$query = $this->db->query(
        		"UPDATE `hr_leave` 
    	    		SET 
    	    		hr_leave.date_filed = '{$_POST['datefiled_picker']}',
    	    		hr_leave.inclusive_from = '{$_POST['edit-inclusivefrom_picker']}',
    	    		hr_leave.inclusive_to = '{$_POST['edit-inclusiveto_picker']}',
    	    		hr_leave.reason = '{$_POST['reason']}',
    	    		hr_leave.leave_type = '{$_POST['leave_type']}'
    	    		WHERE 
    	    		hr_leave.o200_id = '{$id}' 
    	    		 
        		");
        	
        }
    function get_leave_credits($id,$year)
        {
            $query = $this->db->query(
                "SELECT balance 
                fROM hr_leavecredits 
                WHERE 
                hr_leavecredits.o201_id = '{$id}' 
                AND hr_leavecredits.year = '{$year}'");

             $credit = $query->result();

             if ($query->num_rows > 0) {
                    foreach($credit as $credit_result){
                        return $credit_result->balance;
                    }
                }
                else{
                    return "0";
                }
            
        }
    function get_leave_credit($id,$year)
        {
            $query = $this->db->query(
                "SELECT credits,balance
                fROM hr_leavecredits 
                WHERE 
                hr_leavecredits.o201_id = '{$id}' 
                AND hr_leavecredits.year = '{$year}'");

             return $query->result();
        }
    function add_leave_credits($id,$year,$credit)
        {
            $query = $this->db->query(
                "INSERT INTO hr_leavecredits 
                VALUES ('{$id}',$credit,'{$year}',$credit)
                ");
        }
    function edit_leave_credits($id,$year,$credit)
        {
            $query = $this->db->query(
                "UPDATE hr_leavecredits
                SET balance = $credit 
                WHERE o201_id = '{$id}'
                AND year = '{$year}'
                ");
        }
    function get_leave_reports($choice,$value)
        {
            // get the current year
            $year = mdate('%Y', time());
            //$year = '2013';

            //var_dump($year); exit();
            switch ($choice)
                {
                case 1:
                  //monthly
                  $query_append = " AND YEAR(inclusive_from)='$year' AND MONTH(inclusive_from)='$value' ";          
                  break;
                case 3:
                  //quarterly
                    switch($value)
                    {
                        case 1:
                            $value1 = '1';
                            $value2 = '2';
                            $value3 = '3';
                            break;
                        case 2:
                            $value1 = '4';
                            $value2 = '5';
                            $value3 = '6';
                            break;
                        case 3:
                            $value1 = '7';
                            $value2 = '8';
                            $value3 = '9';
                            break;
                        case 4:
                            $value1 = '10';
                            $value2 = '11';
                            $value3 = '12';
                            break;
                    }
                $query_append = " AND YEAR(inclusive_from)='$year' AND (MONTH(inclusive_from)='$value1' OR MONTH(inclusive_from)='$value2' OR MONTH(inclusive_from)='$value3') ";
                  break;
                case 6:
                  //semi annual
                    switch($value)
                    {
                        case 1:
                            $value1 = '1';
                            $value2 = '2';
                            $value3 = '3';
                            $value4 = '4';
                            $value5 = '5';
                            $value6 = '6';
                            break;
                        case 2:
                            $value1 = '7';
                            $value2 = '8';
                            $value3 = '9';
                            $value4 = '10';
                            $value5 = '11';
                            $value6 = '12';
                            break; 
                    }

                $query_append = " AND YEAR(inclusive_from)='$year' AND (MONTH(inclusive_from)='$value1' OR MONTH(inclusive_from)='$value2' OR MONTH(inclusive_from)='$value3'OR MONTH(inclusive_from)='$value4' OR MONTH(inclusive_from)='$value5'OR MONTH(inclusive_from)='$value6') ";
                  break;
                case 12:
                  //annual
                $query_append = " AND YEAR(inclusive_from)='$value' ";
                  break;
                }


            $query = $this->db->query(
                "SELECT
                hr_leave.inclusive_from,
                CONCAT(jlr_employees.last_name,', ',jlr_employees.first_name) as fullname,
                jlr_emp_personal_info.company_assigned_div as department,
                hr_leave.reason,
                w_pay,wo_pay,hours
                FROM
                jlr_employees ,
                hr_leave,
                jlr_emp_personal_info
                WHERE
                jlr_employees.o1_id = hr_leave.emp_id AND jlr_employees.o1_id = jlr_emp_personal_info.employee_id". $query_append .
                //AND `inclusive_from`>='{$value}'
                //AND `inclusive_from`<'{$value2}'
                "ORDER BY department,fullname,inclusive_from ASC
                ");
                return $query->result();
        }


        function get_employee_pay_amounts($id,$year)
            {
                $query = $this->db->query("SELECT hr_leave.w_pay,hr_leave.wo_pay FROM hr_leave WHERE hr_leave.emp_id = '{$id}' AND YEAR(hr_leave.inclusive_from) = '{$year}' ");
                return $query->result();
            }


        function update_old_id_leave($inc_id,$new_id)
        {
           
            $query = $this->db->query("UPDATE `hr_leave` SET `emp_id`='{$new_id}' WHERE `emp_id`='{$inc_id}'");

            
        }

    function insert_massleave($id,$reason,$date)
    {
           
        //check if the user has available leaves if non then deduct it to the without pay column
        $calculated = 0;
        $dates = explode('-', $date);


        
        $emp_credits = $this->leaves_model->get_leave_credit($id,$dates[0]);

        foreach ($emp_credits as $credit) {
        }

        $emp_credit = $credit->credits;

        

        if($emp_credit == 0){
            //insert without pay
            $without_pay = 1;
            $with_pay = 0;
        }else{
            //check the user balance
            // try to compare the balance and the credit
            $emp_consume = $this->leaves_model->get_employee_balance($id,$dates[0]);
            foreach ($emp_consume as $consumed) {
            }

            if (is_null($consumed->wpay)){
                $consumed->wpay = 0;
            }

            //var_dump($consumed->wpay); exit();

            $calculated = $emp_credit - $consumed->wpay;
            if ($calculated <= 0){
                //insert to without pay
                $without_pay = 1;
                $with_pay = 0;
            }else{
                //insert to with pay
                $without_pay = 0;
                $with_pay = 1;
            }

        }
        
            $data = array(
                'emp_id' => $id,
                'date_filed' => $date,
                'inclusive_from' => $date,
                'inclusive_to' => $date,
                'time_from' => '07:45',
                'time_to' => '17:00',
                'reason' => $reason,
                'leave_type' => 'mass leave',
                'w_pay' =>  $with_pay,
                'wo_pay' => $without_pay
                
            );

        return $this->db->insert('hr_leave', $data);

    }

    function get_employee_balance($id,$date)
    {
        $query = $this->db->query("SELECT sum(`w_pay`) as wpay FROM `hr_leave` where emp_id = '{$id}' and YEAR(`inclusive_from`) = '{$date}' ");
        return $query->result();
    }
*/

}


