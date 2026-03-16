<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {


	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
			$this->load->model('login_model'); 
	    }


	function index()
		{
			
		}

	function login_leave()
	{
		$content['status']='';
		$content['requestingpage'] = 'leaves';
		$content['action']='checklogin';

		//display the login page to the user
		$this->pagemaker->setSoftname('JLR Software Suite');

	    $this->body['view'] = 'templates/login';
	    $this->body['content'] = $content;
	    $this->pagemaker->basePage($this->body,'Login');
	}

	function login_leavev2()
	{
		$content['status']='';
		$content['requestingpage'] = 'leaves-v2';
		$content['action']='checklogin';

		//display the login page to the user
		$this->pagemaker->setSoftname('JLR Software Suite');

	    $this->body['view'] = 'templates/login';
	    $this->body['content'] = $content;
	    $this->pagemaker->basePage($this->body,'Login');
	}

	function login_warehouse()
	{
		$content['status']='';
		$content['requestingpage'] = 'warehouse';
		$content['action']='checklogin';

		//display the login page to the user
		$this->pagemaker->setSoftname('JLR Software Suite');

	    $this->body['view'] = 'templates/login';
	    $this->body['content'] = $content;
	    $this->pagemaker->basePage($this->body,'Login');
	}


	function login_dps()
	{
		$content['status']='';
		$content['requestingpage'] = 'dps';
		$content['action']='checklogin';
		//display the login page to the user
		$this->pagemaker->setSoftname('JLR Software Suite');

		$this->body['view'] = 'templates/login';
		$this->body['content'] = $content;
		$this->pagemaker->basePage($this->body,'Login');
	}

	function login_deu()
	{
		$content['status']='';
		$content['requestingpage'] = 'deu';
		$content['action']='checklogin';
		//display the login page to the user
		$this->pagemaker->setSoftname('JLR Software Suite');

		$this->body['view'] = 'templates/login';
		$this->body['content'] = $content;
		$this->pagemaker->basePage($this->body,'Login');
	}

	function login_main()
	{
		$content['status']='';
		$content['requestingpage'] = 'mainwelcome';
		$content['action']='checklogin';
		//display the login page to the user
		$this->pagemaker->setSoftname('JLR Software Suite');
		

		$this->body['view'] = 'templates/login';
		$this->body['content'] = $content;
		$this->pagemaker->basePage($this->body,'Login');
	}


	function checklogin()
		{
			//check the login details of the users in the database
			
			$content['status']='';
			$requestingpage = $this->input->post('requestingpage');

			
			$result = $this->login_model->validate();
			
			if($result['operation']){
				$data = array(
					'username' => $this->input->post('username'),
					'nick' => $this->login_model->nick,
					'userinit' => $this->login_model->initial,
					'userlvl' => $this->login_model->lvl,
					'is_logged_in' => true,
					'employee_id' => $this->login_model->id,
					'first_name' => $this->login_model->first,
					'last_name' => $this->login_model->last
				);
				$this->session->set_userdata($data);


				switch ($requestingpage) {
					case 'leaves':
						redirect('leaves');
						break;

					case 'leaves-v2':
						redirect('leavesv2');
						break;

					case 'warehouse':
						redirect('warehouse');
						break;
					
					case 'dps':
						redirect('dps');
						break;

					case 'deu':
						redirect('deu');
						break;

					case 'mainwelcome':
						
						redirect('welcome');
						break;
				}
				
				
			}
			else{
				$content['status'] = $result['message'];
				$content['action']='checklogin';

				switch ($requestingpage) {
					case 'leaves':
						$content['requestingpage'] = $requestingpage;
						$this->pagemaker->setSoftname('Leave Monitoring');
						$this->body['view'] = 'templates/login';
						$this->body['content'] = $content;

						$this->pagemaker->basePage($this->body, 'Login');
						break;

					case 'leavesv2':
						$content['requestingpage'] = $requestingpage;
						$this->pagemaker->setSoftname('Leave Monitoring v2.0');
						$this->body['view'] = 'templates/login';
						$this->body['content'] = $content;

						$this->pagemaker->basePage($this->body, 'Login');
						break;

					case 'warehouse':
						$content['requestingpage'] = $requestingpage;
						$this->pagemaker->setSoftname('Warehouse Inventory');
						$this->body['view'] = 'templates/login';
						$this->body['content'] = $content;

						$this->pagemaker->basePage($this->body, 'Login');
						break;
					
					case 'dps':
						$content['requestingpage'] = $requestingpage;
						$this->pagemaker->setSoftname('JLR Concrete Scheduling System');
						$this->body['view'] = 'templates/login';
						$this->body['content'] = $content;

						$this->pagemaker->basePage($this->body, 'Login');
						break;

					case 'deu':
						$content['requestingpage'] = $requestingpage;
						$this->pagemaker->setSoftname('JLR Concrete Scheduling System');
						$this->body['view'] = 'templates/login';
						$this->body['content'] = $content;

						$this->pagemaker->basePage($this->body, 'Login');
						break;

					case 'mainwelcome':
						$content['requestingpage'] = $requestingpage;
						$this->pagemaker->setSoftname('JLR Software Suite');
						$this->body['view'] = 'templates/login';
						$this->body['content'] = $content;

						$this->pagemaker->basePage($this->body, 'Login');
						break;
				}

				

			}

			
		}


	function logout() 
		{
			$requestingpage = $_GET['requestingpage'];
			$data = array(
					$this->session->unset_userdata('username'),
					$this->session->unset_userdata('userinit'),
					$this->session->unset_userdata('userlvl'),  
	                $this->session->unset_userdata('is_logged_in')
	                );
			$this->session->sess_destroy($data);

			$this->ajax_write_logout();

			switch ($requestingpage) {
				case 'Leave Monitoring':
					redirect('main/login_leave');
					break;

				case 'leavesv2':
					redirect('main/login_leavev2');
					break;

				case 'warehouse':
					redirect('main/login_warehouse');
					break;
				
				case 'JLR Concrete Scheduling System':
					redirect('main/login_dps');
					break;
					
				case 'mobiledps':
					redirect('main/login_dps');
					break;

				case 'Daily Equipment Update':
					redirect('main/login_deu');
					break;

				case 'Client Contracts':
					redirect('main/login_dps','refresh');
					break;

				case 'welcomepage':
					redirect('welcome');
					break;
			}
			
		}

	function ajax_write_logout(){
	    	$filename = "chat/onlineusers.txt";

	    	$fh = fopen( $filename, 'w' );
			fclose($fh);
		}
}
