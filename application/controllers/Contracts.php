<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contracts extends CI_Controller {

	var $lvl;
	var $user_name;
	protected $_action_state;


	function __construct()
	{
		parent::__construct();
		// load model
		$this->load->model('contract_model');
		$this->load->model('pump_model');
		// helper
		$this->load->helper('alert');
		$this->load->helper('unit');
		// init
		$this->lvl = $this->session->userdata('userlvl');
		// check user credentials if not return to main
		$this->credentials();
	}

	function credentials()
	{
		if(!$this->session->userdata('is_logged_in') === TRUE)
		{
			redirect('main/login_main');
		}

		$userlvl = (int)$this->session->userdata('userlvl');
		
		if(($userlvl < 40 || $userlvl > 50) && $userlvl !== 150 && $userlvl !== 1 && $userlvl !== 45)
		{
			redirect('main/login_main');
		}
	}


	// ajax-contractlist
	function ajax_contract_list()
	{
		$from = nice_date($this->input->post('fromDate'),'Y-m-d');
		$to = nice_date($this->input->post('toDate'),'Y-m-d');

		$date_range = array(
			'date_range' => array( 'from' => $from, 'to' => $to)
		);

		$this->session->set_userdata($date_range);

		$search = $this->input->post('search');
		$to = date('Y-m-d',strtotime($to.'+1 day'));

		echo json_encode($this->contract_model->get($from,$to,$search));
	}

	// get user_rights
	function ajax_user_rights()
	{
		if($this->lvl == 40 || $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isCVR($this->lvl))
		{
			echo 1;//if true
		}
		else
		{
			echo 0; //if false
		}
	}

	function ajax_client_details()
	{
		$id = $this->input->post('id');
		echo json_encode($this->contract_model->get_client_byid($id));
	}

	function ajax_sales_details()
	{
		$id = $this->input->post('id');
		echo json_encode($this->contract_model->get_sales_contact($id));
	}

	function ajax_contract_details()
	{	
		$id = (int)$this->input->post('id');
		echo json_encode($this->contract_model->get_contract_details_byid($id));
	}

	function ajax_charges()
	{
		$data['pump_id'] 		= $this->input->post('pump_id');
		$data['pump_charges'] 	= $this->session->pump;
		$data['charges'] 		= $this->pump_model->get_particulars();

		$this->load->view('contracts/contract_charges', $data);
	}

	function ajax_assign_in_pump()
	{
		$pump_id 					= $this->input->post('pump_id');
		$pump_charges 				= $this->session->pump;
		$pump_charges[$pump_id] 	= $this->input->post('pump_charges');
		
		$newData = array(
			'pump' => $pump_charges
		);
		
		$this->session->set_userdata($newData);
	}

	function ajax_unassigned_pump_charges()
	{
		$pump_id = $this->input->post('pump_id');
		$pump_charges = $this->session->pump;

		if ($pump_charges[$pump_id] !== null) 
		{
			unset($pump_charges[$pump_id]);
		}
		$newPump = array('pump' => $pump_charges);
		$this->session->set_userdata($newPump);
	}

	function ajax_pump_charges()
	{
		$cntr_id 			= $this->input->post('cntr_id');
		$data['pump_id'] 	= $this->input->post('pump_id');
		$project_storey		= intval($this->input->post('project'));
		$data['charges'] 	= $this->pump_model->get_particulars();
		$is_high_rise 		= $this->pump_model->is_high_rise($data['pump_id'],$project_storey);

		if($this->session->pump === null)
		{
			$pump_array = array();

			$pump_charges = array(
				'pump' => $this->pump_model->get_default_charges($data['pump_id'],$is_high_rise)
			);

			$this->session->set_userdata($pump_charges);
		}
		else
		{
			$exist = FALSE;

			$pump_charges = $this->session->pump;

			foreach ($pump_charges as $key => $value) 
			{
				if ($key == $data['pump_id']) 
				{
					$exist = TRUE;
					break;
				}
			}
			
			if ($exist === FALSE) 
			{
				$newdata = array(
					'pump' => $this->pump_model->get_default_charges($data['pump_id'],$is_high_rise)
				);
				
				$this->session->set_userdata($newdata);
			}
		}

		$data['pump_charges'] = $this->session->pump;

		$this->load->view('contracts/contract_pump_charges',$data);
	}

	function ajax_load_pump_charges()
	{
		$cntr_id = $this->input->post('cntr_id');
		echo json_encode($this->pump_model->load_pump_charges($cntr_id));
	}

	function ajax_set_pump_charges()
	{
		$cc_id 				= $this->input->post('cntr_id');
		$data['pump_id'] 	= $this->input->post('pump_id');
		$data['charges'] 	= $this->pump_model->get_particulars();
		$newData 	= array('pump' => $this->pump_model->set_pump_charges($cc_id,$data['pump_id']));

		$this->session->set_userdata($newData);

		$data['pump_charges'] = $this->session->pump;

		$this->load->view('contracts/contract_pump_charges',$data);
	}

	// form prerequisite 

	function prerequisite()
	{
		$data['name_prefix'] 		  	 = $this->contract_model->get_prefix();
		$data['cust_position'] 		  	 = $this->contract_model->get_position();
		$data['sales'] 				  	 = $this->contract_model->get_sales_rep();
		$data['client_list']			 = $this->contract_model->get_client();
		$data['cntr_child_conditions']	 = $this->contract_model->cntr_child_condition();	
		$data['cntr_conditions']		 = $this->contract_model->cntr_condition();
		$data['strength']				 = $this->contract_model->get_strength();
		$data['cntr_opt'] 				 = $this->contract_model->get_contract_type();
		$data['pumps'] 					 = $this->pump_model->get();
		
		return $data;
	}

	function load_contracts($id)
	{
		$data 						= $this->prerequisite();
		$data['lvl'] 				= $this->lvl;
		$data['data'] 				= $this->contract_model->get_byid($id);
		$data['data_conditions'] 	= $this->contract_model->get_conditions_byid($id);
		$data['add_conditions'] 	= $this->contract_model->get_additional_conditions($id);

		$this->pump_model->floor_surcharge($id);
		return $data;
	}

	function load_view($view,$data,$title)
	{
		$this->pagemaker->setSoftname('Client Contracts');
		$this->body['view'] 	= $view;
		$this->body['content'] 	= $data;
		$this->pagemaker->basePage($this->body,$title);
	}

    function index($msg = '',$msg_type = '')
	{
		$this->credentials();

		$content['from'] = date('m/d/Y');
		$content['to'] = date('m/d/Y');

		//alert message for index
		if($this->session->date_range != null)
		{
			$range 				= $this->session->date_range;
			$content['from'] 	= nice_date($range['from'],'m/d/Y');
			$content['to'] 		= nice_date($range['to'],'m/d/Y');
		}

		$this->session->unset_userdata('pump');
		
		$content['message'] = alert($msg,$msg_type);

		$this->pagemaker->setSoftname('Client Contracts');
		$this->body['view'] = 'contracts/index';
		$this->body['content'] = $content;
		$this->pagemaker->basePage($this->body,'List of Contracts');
	}

	function contract_add()
	{
		// view,form prerequisite,title
		$this->load_view('contracts/contract_add',$this->prerequisite(),'New Contracts');
	}

	function contract_insert()
	{
		if ($this->contract_model->insert()) 
		{
			//if success back to index...
			$this->index('Successfully Saved!','success');
		}
		else 
		{
			//if not valid back to view and prompt an error here
			// view,form prerequisite,title
			$this->load_view('contracts/contract_add',$this->prerequisite(),'New Contracts');
		}
	}

	function contract_view()
	{
		// prerequisite with contracts by id
		$data = $this->load_contracts($this->input->get('id'));
		// view,data,title
		$this->load_view('contracts/contract_view',$data,'Contract Details');
	}

	function contract_approve()
	{	
		$id = $this->input->post('key');

		if($this->contract_model->contract_approve($id))
		{
			//if success back to index...
			$this->index('Successfully approved!','success');
		}
		else
		{
			// back to view
			$this->contract_view();
		}
	}

	function contract_edit()
	{
		// prerequisite with contract by id
		$data = $this->load_contracts($this->input->get('id'));

		// view, data, title
		$this->load_view('contracts/contract_edit',$data,'Edit Contracts');
	}

	function contract_update()
	{
		//validate the form
		if ($this->contract_model->update() === TRUE)
		{
			//if success back to index...
			$this->index('Successfully Updated!','success');
		}
		else
		{
			// prerequisite
			$data = $this->load_contracts($this->input->get('id'));

			// view,data,title
			$this->load_view('contracts/contract_edit',$data,'Edit Contract');
		}
	}

	function contract_delete()
	{
		if($this->contract_model->delete($this->input->get('id')))
		{
			//if success back to index...
			$this->index('Contract has been deleted!','success');
		}
		else
		{
			$this->index('unable to deleted contracts','warning');
		}
	}

	function contract_print()
	{
		//verify credential first
		$this->credentials();

		// Load tcpdf library
		$this->load->helper('tcpdf');

		$id = $this->input->get('id');

		$data['contract'] 			= $this->contract_model->get_byid($id);
		$data['conditions'] 	  	= $this->contract_model->get_conditions_byid($id);
		$data['child_conditions'] 	= $this->contract_model->cntr_child_condition($id);
		$data['add_conditions']		= $this->contract_model->get_additional_conditions($id);
		$data['details'] 			= $this->contract_model->get_contract_details_byid($id);

		#Pump Charges
		$data['pumps']	= $this->pump_model->get();
		$data['particulars'] = $this->pump_model->get_particulars();
		$data['pump_charges'] = $this->pump_model->get_pump_charges($id);
		$data['floor_surcharge'] = $this->pump_model->floor_surcharge($id);

		$sales_id = $data['contract']['sales_rep'];

		foreach ($this->contract_model->get_sales_contact($sales_id) as $key) 
		{
			$data['sales_name'] = $key->prefix." ".$key->fname." ".substr($key->mname, 0,1).". ".$key->lname." ".$key->suffix;
			$data['sales_position'] = $key->position;
		}
		$this->load->view('contracts/contract_print', $data);
	}
	
	function contract_revision()
	{
		// get cc_id
		$id = $this->input->get('id');

		if($this->contract_model->revision($id))
		{
			$this->index("Successfully revised!",'success');
		}
		else
		{
			$this->index("Unable to revised contract.","warning");
		}
	}
	
}


/* End of file Contracts.php */
/* Location: ./application/controllers/Contracts.php */

