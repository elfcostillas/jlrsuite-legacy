<?php

define("TBL_LOGIN", "jlr_program_users");
define("TBL_EMPLOYEES", "jlr_employees");


class login_model extends CI_Model {
	//model file for the login

	var $lvl;
	var $id;
	var $first;
	var $last;
	var $nick;
	var $middle;	
	var $initial;
	var $username;

	function __construct()
		{
			$this->load->database('login_model');
		}

	function validate()
		{
			//get the post data save it to array
			$result;
			$u_name = $this->input->post('username');
			$u_pass = $this->input->post('password');

			// revising the logic here

			$key = 'jlrmaiev87';

			$this->db->where('user_name', $u_name);
			$pass = $this->db->escape($u_pass);
			$this->db->where('user_password', "AES_ENCRYPT(".$pass.",'".$key."')",FALSE);
			$this->db->where('user_status', 'ACTIVE');
			$query = $this->db->get('jlr_program_users');
			
			if($query->num_rows() >= 1){
				//there is a user,get his details
				$row = $query->row();
				$this->lvl = $row->user_level;
				$this->id = $row->employee_id;

				//get more user details
				$this->db->where('o1_id', $this->id);
				$query_details = $this->db->get('jlr_employees');

				if($query_details->num_rows() >= 1){
					$row = $query_details->row();

					$this->nick = $row->nick_name;
					$this->first = $row->first_name;
					$this->middle = $row->middle_name;
					$this->last = $row->last_name;
					$this->initial = $row->initials;
				}else{
					$this->nick = '';
					$this->first = '';
					$this->middle = '';
					$this->last = '';
					$this->initial = '';
				}

				//update the status of the user
				$data = array(
				        'user_logged_in' => 'YES',
				        'user_last_login' => date("Y-m-d H:i:s")
				);

				$this->db->where('employee_id', $this->id);
				$this->db->update('jlr_program_users', $data);
				$result['operation'] = TRUE;

			}else{
				//there is no user
				//display the error message
				$result['message'] = "<p><i class='fa fa-exclamation-triangle' id='login-error'></i> Incorrect Username or Password </p><br />";
				$result['operation'] = FALSE;
			}
			return $result;
		}
}
