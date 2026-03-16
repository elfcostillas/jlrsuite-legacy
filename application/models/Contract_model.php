<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_model extends CI_Model {

	protected $user_completename;
	protected $user_id;
	protected $user_lvl;

	protected $form_control;

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->library('form_validation');

		// Bootstrap form library
		$this->load->library('bootstrap');

		// set rules for form validations
		$this->form_rules();

		// get complete employee name of the user
		$this->set_user();
	}

	// remove comma from string
	private function num($num)
	{
		return str_replace(',', '', $num);
	}

	function get($fromdate,$todate,$search='')
	{
		$this->db->select('cc_id,revision,doc_date,contract_no,contract_type,client_name,project_name,created_date,created_by,is_approved');

		if(!$this->functionlist->isAdmin($this->user_lvl) && !$this->functionlist->isCVR($this->user_lvl) && $this->user_lvl !== 40)
		{
			$this->db->where('user_id', $this->user_id);
		}

		if ($search === '')
		{
			$this->db->where('created_date >=', $fromdate);
			$this->db->where('created_date <=', $todate);
		}
		else
		{
			$this->db->like('contract_no', $search, 'BOTH');
			$this->db->or_like('client_name', $search, 'BOTH');
			$this->db->or_like('project_name', $search, 'BOTH');
		}

		$this->db->where('cc_id > 0');
		$this->db->order_by('created_date', 'desc');
		$this->db->from(TBL_CLIENT_CONTRACTS);
		$query = $this->db->get();

		return $query->result();
	}

	function get_byid($id)
	{
		$this->db->where('cc_id', $id);
		$query = $this->db->get(TBL_CLIENT_CONTRACTS);

		return ($query->num_rows() > 0 ) ? $query->row_array():null;

	}

	function get_conditions_byid($id)
	{
		$this->db->where('cc_id', $id);
		$this->db->join(
			TBL_CONTRACT_CONDITIONS, TBL_CLIENT_CONDITIONS.'.cd_id = '.
			TBL_CONTRACT_CONDITIONS.'.cd_id', 'inner'
		);
		$this->db->order_by('line_order', 'asc');
		$query = $this->db->get(TBL_CLIENT_CONDITIONS);	

		return $query->result();
	}

	function get_additional_conditions($id)
	{
		$this->db->where('cc_id', $id);
		$query  = $this->db->get(TBL_ADDITIONAL_CONDITIONS);
		return $query->result();
	}

	function get_contract_details_byid($id)
	{
		$this->db->where('cc_id', $id);
		$query = $this->db->get(TBL_CONTRACT_DETAILS);

		return $query->result();
	}
	
	function get_client()	
	{
		$this->db->select('o5_id,customer_name');
		$this->db->where('activity_status', 'ACTIVE');
		$this->db->where_not_in('customer_type', 'QAD');
		$this->db->from(TBL_CLIENT);
		$this->db->order_by('customer_name', 'asc');
		$query = $this->db->get();
		
		return $query->result();
	}

	function get_cntr_pump_charges($id)
	{
		$this->db->where('cc_id', $id);
		$this->db->from('cntr_pump_charges');
		$query = $this->db->get();

		return $query->result();
	}

	function get_client_byid($id)
	{
		$this->db->select('customer_name,customer_address,contact_number,termDesc');
		$this->db->join('billing_terms', TBL_CLIENT.'.termsid = billing_terms.termsid', 'left');
		$this->db->where('o5_id', $id);
		$query = $this->db->get(TBL_CLIENT);
		
		return $query->result();
	}

	function cntr_condition()
	{
		$this->db->select('*');
		$this->db->where('is_active', 1)->where('parent',0);
		$this->db->order_by('line_order', 'asc');
		$query = $this->db->get(TBL_CONTRACT_CONDITIONS);
		
		return $query->result();
	}

	function cntr_child_condition()	
	{
		$this->db->select('condition_desc,parent');
		$this->db->where('is_active', 1)->where_not_in('parent',0);
		$this->db->order_by('line_order', 'asc');
		$query = $this->db->get(TBL_CONTRACT_CONDITIONS);
		
		return $query->result();
	}

	function get_sales_rep()
	{
		$this->db->select("prefix,suffix,fname, lname, mname,sales_id");
		$this->db->where('is_active', 1);
		$query = $this->db->get(TBL_SALES_REP);

		return $query->result();
	}

	function get_sales_contact($id)
	{
		$this->db->where('sales_id', $id);
		$query = $this->db->get(TBL_SALES_REP);
		
		return $query->result();
	}

	function set_user()
	{
		$emp_id = $this->session->userdata('employee_id');

		$this->db->select('o4_id,first_name,last_name,middle_name');
		$this->db->from('jlr_program_users');
		$this->db->join('jlr_employees', 'jlr_program_users.employee_id = jlr_employees.o1_id', 'BOTH');
		$this->db->where('o1_id', $emp_id);
		$query = $this->db->get();
		
		foreach($query->result() as $key)
		{
			$this->user_id = $key->o4_id; //user_id
			if ($key->middle_name !== null && $key->middle_name !== '') 
			{
				$this->user_completename = $key->first_name.' '.substr($key->middle_name,0,1).'. '.$key->last_name; 
			}
			else 
			{
				$this->user_completename = $key->first_name.' '.$key->last_name;
			}
		}
	}

	function get_contract_type()
	{
		return array(
			'Straight Contract' => 'Straight Contract',
			'Cement Supplied'   => 'Cement Supplied',
			'Pick-Up'     		=> 'Pick-Up'
		);
	}

	function get_strength()
	{
		$this->db->where_not_in('type', '');
		$this->db->order_by('code', 'asc');
		$query = $this->db->get('rmc_strength_list');
		
		return $query->result();
	}

	function get_prefix(){

		$this->db->where('used_for', 'name_prefix');
		$this->db->order_by('line_no', 'asc');
		$query = $this->db->get('cntr_enum');

		return $query->result();
		
	}

	function get_position()
	{
		$this->db->where('used_for', 'cust_position');
		$this->db->order_by('line_no', 'asc');
		$query = $this->db->get('cntr_enum');

		return $query->result();
	}

	// GET VALUE OF CHARGES BY PUMP
	function generate_contract_code($doc_id)
	{
		$LastFormat = '';

		//Update prefix
		$this->db->update('system_document_format', array('PREFIX' => date('y-m').'-'),'DOCID = '.$doc_id);

		//select form system_document_format
		$this->db->where('DOCID',$doc_id);
		$query = $this->db->get('system_document_format');

		foreach ($query->result() as $value) 
		{
			$LastFormat = $value->LAST_FORMAT;	
		}

		//check if lastformat alreay exists
		$this->db->where('contract_no', $LastFormat);
		$count = $this->db->count_all_results(TBL_CLIENT_CONTRACTS);
		if($count === 0)
		{
			return $LastFormat;	
		}
		else
		{
			//get new code in Stored Procedure
			$this->db->query('CALL sp_CodeGenerator('.$doc_id.',@Format)');
			$query = $this->db->query('SELECT @Format');

			foreach ($query->result() as $value) 
			{
				return $value->{'@Format'};
			}
		}
	}

	function insert()
	{
		$cc_id = 0;

		if ($this->form_validation->run() === FALSE) 
		{
			return FALSE;
		}

		$data = $this->form_to_array();
		$data['contract_no'] = $this->contract_model->generate_contract_code(700);


		// push 2 more element in the array

		$data['created_date'] = date('Y-m-d');
		$data['created_by'] =  $this->user_completename;
		
		// // begin transaction
		// $this->db->trans_start();

		// save contract
		$this->db->insert(TBL_CLIENT_CONTRACTS, $data);
			
		$this->db->select_max('cc_id');
		$query = $this->db->get(TBL_CLIENT_CONTRACTS);

		foreach ($query->result() as $key) 
		{
			$cc_id = $key->cc_id;
		}

		// //save contract conditions
		$conditions = $this->input->post('conditions');
		$this->insert_contract_conditions($cc_id,$conditions);

		// save additional contract conditions
		$this->insert_additional_conditions($cc_id);

		// //save contract details
		$details = $this->input->post('contract');
		$this->insert_contract_details($cc_id,$details);

		// save pump charges
		$pump_charges = $this->session->pump;
		$this->insert_pump_charges($cc_id,$pump_charges);

		return TRUE;
	}


	
	function update()
	{
		if($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		$data = $this->form_to_array();

		$cc_id = $this->input->post("key");

		// push to more element in the array
		$data['updated_date'] = date('Y-m-d');
		$data['updated_by'] = $this->user_completename;

		// // begin transaction
		// $this->db->trans_start();

		$this->db->set($data);
		$this->db->where('cc_id',$cc_id);
		$this->db->update(TBL_CLIENT_CONTRACTS);
			
		// delete existing conditions
		$this->delete_conditions($cc_id);

		//save contract conditions
		$conditions = $this->input->post('conditions');
		$this->insert_contract_conditions($cc_id,$conditions);
		
		// delete existing additional contracts
		$this->delete_additional_conditions($cc_id);

		// save additional contract conditions
		$this->insert_additional_conditions($cc_id);

		// delete existing contract details
		$this->delete_details($cc_id);

		//save contract details
		$details = $this->input->post('contract');
		$this->insert_contract_details($cc_id,$details);

		// delete existing pump charges
		$this->delete_pump_charges($cc_id);

		// save pump charges
		$pump_charges = $this->session->pump;
		$this->insert_pump_charges($cc_id,$pump_charges);

		return TRUE;
	}

	function insert_contract_conditions($cc_id,$conditions)
	{
		if(count($conditions) <= 0 )
		{
			return FALSE;
		}
		#assign sampling procedure
		$conditions[count($conditions)] = '5';
		foreach ($conditions as $key => $value) 
		{
			$data = array('cc_id' => $cc_id, 'cd_id' => $value);

			//save contract conditions
			$this->db->insert(TBL_CLIENT_CONDITIONS,$data);
		}

		return TRUE;
	}

	function insert_contract_details($cc_id,$details)
	{	
		if(count($details) <= 0)
		{
			return FALSE;
		}

		for($i = 0 ;$i<count($details['id']);$i++)
		{
			$data = array(
				'cc_id'			=> $cc_id,
				'cement_supp' 	=> (float)$this->num($details['cement_supp'][$i]),
				'psi_strength' 	=> $this->num($details['strength'][$i]),
				'size_of_agg' 	=> $details['size_of_agg'][$i],
				'slump' 		=> $details['slump'][$i],
				'curing_days' 	=> $details['curing'][$i],
				'pickup_price' 	=> (float)$this->num($details['pickup_price'][$i]),
				'deliv_price' 	=> (float)$this->num($details['deliv_price'][$i]),
				'remarks' 		=> $details['remarks'][$i]	
			);

			//save contract details
			$this->db->insert(TBL_CONTRACT_DETAILS,$data);
		}

		return TRUE;
	}

	// save pump_charges
	function insert_pump_charges($cc_id,$pump_charges)
	{
		if (count($pump_charges) > 0 ) 
		{
			foreach ($pump_charges as $key => $pump_charge) 
			{
				foreach ($pump_charge as $value) 
				{
					$data = array(
						'cc_id' 			=> $cc_id,
						'pump_id' 			=> $key,
						'charge_id' 		=> $value['charge_id'],
						'value' 			=> $value['value'],
						'additional_desc' 	=> $value['desc'] 
					);

					$this->db->insert(TBL_PUMP_CHARGES, $data);
				}
			}
		}
	}

	function insert_additional_conditions($cc_id)
	{
		if ((int)$this->input->post("has_content") == 1) 
		{
			$data = array(
				'cc_id' => $cc_id,
				'has_preferred' => (int)$this->input->post("has_preferred"),
				'additional_condition' => $this->input->post('add_condition')
			);
			$this->db->insert(TBL_ADDITIONAL_CONDITIONS, $data);
		}
	}

	function contract_approve($id)
	{
		$set = array('is_approved' => 1,'approved_by' => $this->user_completename, 'approved_date' => date('Y-m-d'));

		$this->db->set($set);
		$this->db->where('cc_id', $id);

		if($this->db->update(TBL_CLIENT_CONTRACTS)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function revision($id)
	{

		// get_base_info.
		$base = $this->get_byid($id);

		// get_details_info
		$details = $this->get_contract_details_byid($id);

		// get_condition_info
		$conditions = $this->get_conditions_byid($id);

		// get_additional_conditions_info
		$add_condition = $this->get_additional_conditions($id);

		// get_condition_info
		$pump_charge = $this->get_cntr_pump_charges($id);

		// select all revision of contract and count
		$rev_no = 0;
		
		$this->db->select_max('revision');
		$this->db->where('contract_no', $base['contract_no']);
		$query = $this->db->get(TBL_CLIENT_CONTRACTS);

		foreach($query->result() as $row)
		{
			$rev_no = $row->revision + 1;
		}

		// // // insert revised contract
		unset($base['cc_id']);

		$base['doc_date'] 		= date("Y-m-d h:m:s");
		$base['from_duration'] 	= $base['from_duration'];
		$base['to_duration'] 	= $base['to_duration'];
		$base['created_date'] 	= date("Y-m-d");
		$base['created_by'] 	= $this->user_completename;
		$base['is_approved'] 	= FALSE;
		$base['updated_by'] 	= '';
		$base['updated_date'] 	= null;
		$base['revision'] 		= $rev_no;

		$this->db->insert(TBL_CLIENT_CONTRACTS, $base);

		$this->db->select_max('cc_id');
		$query = $this->db->get(TBL_CLIENT_CONTRACTS);

		$key = 0;
		foreach ($query->result() as $row) 
		{
			$key = $row->cc_id;
		}

		// insert details
		$data = array();
		foreach ($details as $row) 
		{
			$data = array(
				'cc_id'		 	=> $key,
				'cement_supp' 	=> $row->cement_supp,
				'psi_strength' 	=> $row->psi_strength,
				'size_of_agg' 	=> $row->size_of_agg,
				'slump'			=> $row->slump,
				'curing_days' 	=> $row->curing_days,
				'pickup_price' 	=> $row->pickup_price,
				'deliv_price' 	=> $row->deliv_price,
				'remarks' 		=> $row->remarks	
			);
			$this->db->insert(TBL_CONTRACT_DETAILS, $data);
		}

		// insert conditions
		$data = array();
		foreach ($conditions as $row) 
		{
			$data = array(
				'cc_id' => $key,
				'cd_id' => $row->cd_id
			);
			$this->db->insert(TBL_CLIENT_CONDITIONS, $data);
		}

		// insert additional conditions
		$data = array();
		foreach ($add_condition as $row) 
		{
			$data = array(
				'cc_id' 				=> $key,
				'has_preferred' 		=> (int)$row->has_preferred,
				'additional_condition' 	=> $row->additional_condition
			);
			$this->db->insert(TBL_ADDITIONAL_CONDITIONS, $data);
		}

		// insert pump charge
		$data = array();
		foreach($pump_charge as $row)
		{
			$data = array(
				'cc_id'				=> $key,
				'pump_id' 			=> $row->pump_id,
				'charge_id' 		=> $row->charge_id,
				'value' 			=> $row->value,
				'additional_desc' 	=> $row->additional_desc  
			);
			$this->db->insert('cntr_pump_charges', $data);
		}

		return TRUE;
	}

	function delete_conditions($id)
	{
		$this->db->where('cc_id', $id);
		return $this->db->delete(TBL_CLIENT_CONDITIONS);
	}

	function delete_additional_conditions($id)
	{
		$this->db->where('cc_id', $id);
		return $this->db->delete(TBL_ADDITIONAL_CONDITIONS);
	}

	function delete_details($id)
	{
		$this->db->where('cc_id', $id);
		return $this->db->delete(TBL_CONTRACT_DETAILS);
	}

	function delete_pump_charges($id)
	{
		$this->db->where('cc_id', $id);
		return $this->db->delete(TBL_PUMP_CHARGES);
	}

	function delete($id)
	{
		// begin transactions
		// $this->db->trans_start();

		$this->to_nigative($id,TBL_CLIENT_CONTRACTS);
		$this->to_nigative($id,TBL_CLIENT_CONDITIONS);
		$this->to_nigative($id,TBL_CONTRACT_DETAILS);
		$this->to_nigative($id,TBL_PUMP_CHARGES);
		$this->to_nigative($id,TBL_ADDITIONAL_CONDITIONS);
		/*// delete contract conditions

		$this->delete_conditions($id);
		
		// delete contract details
		$this->delete_details($id);

		// delete pump_details
		$this->delete_pump_charges($id);
		
		// then delete base contract
		$this->db->where('cc_id', $id);
		$this->db->delete(TBL_CLIENT_CONTRACTS);*/

		return TRUE;
	}

	private function to_nigative($id,$tbl)
	{
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0');
		$data = array('cc_id' => $id*-1);

		$this->db->set($data);
		$this->db->where('cc_id', $id);
		$this->db->update($tbl);
		$this->db->query('SET FOREIGN_KEY_CHECKS = 1');
	}

	// form field rules
	function form_rules()
	{
		//contract form rules
		$this->form_validation->set_rules('doc_date', 'Date', 'required');
		$this->form_validation->set_rules('client_address', 'Address', 'required');
		$this->form_validation->set_rules('client_contact', 'Tel. no.', 'required|max_length[15]');
		$this->form_validation->set_rules('client_terms', 'Terms', 'required');
		$this->form_validation->set_rules('project', 'project', 'required');
		$this->form_validation->set_rules('location', 'Location', 'required');
		$this->form_validation->set_rules('sales_rep', 'Sales rep.', 'required');
		$this->form_validation->set_rules('sales_contct_no1', 'Contact No. 1', 'required');
		$this->form_validation->set_rules('sample_proc', 'Sample Procedure', 'required');
	}

	function form_to_array()
	{
		$client_id = $this->input->post('client');

		foreach($this->get_client_byid($client_id) as $key)
		{
			$client_name = $key->customer_name;
		}

		//assign parameter value from form
		return array(
			'doc_date' 				=> nice_date($this->input->post('doc_date'),'Y-m-d h:m:s'),
			'contract_type' 		=> $this->input->post('contract_type'),
			'client_id' 			=> $client_id,
			'client_name' 			=> $client_name,
			'client_address' 		=> $this->input->post('client_address'),
			'client_contct_no' 		=> $this->input->post('client_contact'),
			'project_name' 			=> $this->input->post('project'),
			'project_loc' 			=> $this->input->post('location'),
			'est_vol' 				=> $this->input->post('est_volume'),
			'from_duration' 		=> $this->input->post('fromDate'),
			'to_duration' 			=> $this->input->post('toDate'),
			'sales_rep' 			=> $this->input->post('sales_rep'),
			'sales_contct_no1' 		=> $this->input->post('sales_contct_no1'),
			'sales_contct_no2' 		=> $this->input->post('sales_contct_no2'),
			'client_rep_prefix' 	=> $this->input->post('client_rep_prefix'),
			'client_rep'		  	=> $this->input->post('client_rep'),
			'client_rep_position' 	=> $this->input->post('client_pos'),
			'additional_info' 		=> $this->input->post('add_condition'),
			'sample_proc' 			=> $this->input->post('sample_proc'),  
			'terms' 				=> $this->input->post('client_terms'),
			'sales_sign_by' 		=> $this->input->post('sales_rep'),
			'client_sign_by'	 	=> $this->input->post('client_sign_by'),
			'client_sign_position' 	=> $this->input->post('client_sign_pos'),
			'client_rep_no' 		=> $this->input->post('client_rep_no'),
			'user_id'				=> $this->user_id
		);
	}

	function array_to_form($res)
	{
		if(count($res) > 0)
		{
			return array(
				'doc_date' => $this->bootstrap->textbox('doc_date','doc_date',$res['doc_date'],'small','dtpicker')
			);
		}
	}

}

/* End of file modelName.php */
/* Location: ./application/models/modelName.php */