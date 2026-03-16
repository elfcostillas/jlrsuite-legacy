<?php
class Leaves_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}


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
            $query = $this->db->query("SELECT DISTINCT dept as department FROM  `jlr_employees` ORDER BY department ");
            return $query->result();    
        }
	function get_employee_list()
    	{
           
    		$query = $this->db->query("SELECT * FROM jlr_employees WHERE `company_status` <> 'resigned' AND `company_status` <> 'retired' ORDER BY jlr_employees.last_name ")->result_array();
    		
    		return array(
        			'employee' => $query,
        			'employee_count' => count($query)
    				);
    	
    	}

    function get_employeelist()
        {
            $query = $this->db->query("SELECT 
                                    CONCAT(last_name,', ',first_name) as fullname,
                                    o1_id,
                                    dept as department
                                    FROM jlr_employees
                                    WHERE company_status <> 'resigned' AND company_status <> 'retired'
                                    ORDER BY dept,fullname")->result_array();
            
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
           $query = $this->db->query("SELECT company_status as status FROM `jlr_employees` WHERE o1_id = '{$id}' ");
            if ($query->num_rows() > 0) {
                return $query->result();
            } 
        }
	function get_employee_search_result($id,$year) 
        {
            $query = $this->db->query("SELECT * FROM `hr_leave` WHERE emp_id = '{$id}' AND YEAR(date_filed) = '{$year}' ORDER BY `date_filed` ");
             
            //var_dump($query->num_rows);exit();
            if ($query->num_rows() > 0) {
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
                /* am/pm ==================-*/
                $type  = '';
                $dfrom = (int)(str_replace(':','', $_POST['timefrom']));
               
                switch ($this->what_type($dfrom,$withoutpay,$withpay)) {
                    case 'am':
                        $type = 'am';
                     break;
                    case 'pm':
                        $type = 'pm';
                     break;                   
                    default:
                        $type = '';
                }
               /*============================*/

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
                    't_type' => $type
                );
            }



        	

    		return $this->db->insert('hr_leave', $data);

            
            

        }

    function what_type($dfrom,$wop,$wp) {
        if($wop == 0.5 or $wp == 0.5 ){
                if($dfrom < 1200) {
                     return 'am';
                }else{
                   return 'pm';
                }
        }
    }    
        
        
    function set_leave_zero_balance($id,$year,$pay3)
    {
              /* am/pm ==================-*/
                $type  = '';
                $dfrom = (int)(str_replace(':','', $_POST['timefrom']));
               
                switch ($this->what_type($dfrom,$withoutpay,$withpay)) {
                    case 'am':
                        $type = 'am';
                     break;
                    case 'pm':
                        $type = 'pm';
                     break;                   
                    default:
                        $type = '';
                }
               /*============================*/

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
                't_type' => $type
                
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
                    CONCAT(last_name,', ',first_name) as fullname,
                    o1_id as id,
                    dept as department
                    FROM  `jlr_employees`
                    WHERE last_name LIKE '{$sort_value}%' AND company_status <> 'resigned' AND company_status <> 'retired'
                    ORDER BY department,last_name");
             
                if ($query->num_rows() > 0) {
                    return $query->result();
                }
        }
    function search_by_filter($filter,$filterValue)
        {
        	if ($filter == 'department'){
        		//search by department
        		$query = $this->db->query("SELECT
                     CONCAT(last_name,', ',first_name) as fullname,
                    o1_id as id,
                    dept as department
                    FROM  `jlr_employees`
                    WHERE dept = '{$filterValue}' AND company_status <> 'resigned' AND company_status <> 'retired'
                    ORDER BY fullname ASC");
             
    	        if ($query->num_rows() > 0) {
    	            return $query->result();
    	        }
        	}
        	else{
        		//search by status
                //$query = $this->db->query("SELECT * FROM  `jlr_employees` WHERE status = '{$filterValue}'");
             
                //if ($query->num_rows() > 0) {
                //    return $query->result();
                //}
        	}
        }
    function get_leave_records()
        {
        	$year = date('Y');
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
                    hr_leave.status,
                    hr_leave.w_pay,
                    hr_leave.wo_pay
        		FROM  `hr_leave`,`jlr_employees` 
        		WHERE jlr_employees.o1_id = hr_leave.emp_id 
        		AND year(date_filed) = '{$year}' ORDER BY `date_filed`
        		");
             
    	        if ($query->num_rows() > 0) {
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
        			jlr_employees.last_name,
                    hr_leave.w_pay,
                    hr_leave.wo_pay
        		FROM  `hr_leave`,`jlr_employees` 
        		WHERE jlr_employees.o1_id = hr_leave.emp_id 
        		AND (hr_leave.o200_id = '{$id}' AND hr_leave.emp_id = '{$emp_id}')
        		");
             
    	        if ($query->num_rows() > 0) {
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
    	    		hr_leave.leave_type = '{$_POST['leave_type']}',
                    hr_leave.w_pay = '{$_POST['pay_amount1']}',
                    hr_leave.wo_pay = '{$_POST['pay_amount2']}'
    	    		WHERE 
    	    		hr_leave.o200_id = '{$id}' 
    	    		 
        		");
        	
        }

    function get_real_emp_leaves($id,$year){
        $query = $this->db->query("SELECT SUM(w_pay) as leave_wpay FROM `hr_leave` where emp_id = '{$id}' AND (YEAR(inclusive_from) = '{$year}' OR YEAR(inclusive_to) = '{$year}')");
        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
              return $row->leave_wpay;
           }
        }else{
            return 0;
        }
    }
    function get_real_leave_credit($id,$year)
        {
            $query = $this->db->query(
                "SELECT credits
                FROM hr_leavecredits 
                WHERE 
                hr_leavecredits.o201_id = '{$id}' 
                AND hr_leavecredits.year = '{$year}'");

            if ($query->num_rows() > 0)
            {
               foreach ($query->result() as $row)
               {
                  return $row->credits;
               }
            }else{
                return 0;
            }
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

             if ($query->num_rows() > 0) {
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
            //$year = '2014';

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
                jlr_employees.dept as department,
                hr_leave.reason,
                w_pay,wo_pay,hours
                FROM
                jlr_employees ,
                hr_leave
                WHERE
                jlr_employees.o1_id = hr_leave.emp_id". $query_append .
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


}


