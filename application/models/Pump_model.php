<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pump_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	//get all list of pump that currently active
	function get()
	{
		$this->db->where('is_active',TRUE);
		$query = $this->db->get(TBL_PUMP);

		return $query->result();
	}

	//find specific pump
	function find($id)
	{
		$this->db->where('pump_id', $id);
		$query = $this->db->get(TBL_PUMP);

		$this->_result = $query;
	}

	//get default charges of pump for no high rise
	function get_default_charges($pump_id,$is_high_rise = FALSE)
	{

		if ($is_high_rise === FALSE) 
		{
			$this->db->where('high_storey', FALSE);
		}

		$this->db->select('pump_id,charge_id,value,additional_desc');
		$this->db->where('pump_id', $pump_id);
		$query = $this->db->get(TBL_PUMP_DEFAULT);
	
		$array_result = $this->session->pump === null?array():$this->session->pump;

		foreach($query->result() as $key => $row)
		{

			$res = array(
				'charge_id' => $row->charge_id,
				'value' =>  $row->value,
				'desc' => $row->additional_desc
			);

			$array_result[$pump_id][$key] = $res;
		}

		return $array_result;
	}

	function set_pump_charges($cc_id,$pump_id)
	{
		$this->db->where('cc_id', $cc_id);
		$this->db->where('pump_id', $pump_id);
		$query = $this->db->get(TBL_PUMP_CHARGES);

		$array_result = $this->session->pump === null?array():$this->session->pump;
		
		foreach ($query->result() as $key => $row) 
		{
			$res = array(
				'charge_id' => $row->charge_id,
				'value' =>  $row->value,
				'desc' => $row->additional_desc
			);

			$array_result[$row->pump_id][$key] = $res;
		}

		return $array_result;
	}

	//get pump charges 
	function get_pump_charges($id)
	{
		$this->db->where('cc_id', $id);
		$query = $this->db->get(TBL_PUMP_CHARGES);

		return $query->result();
	}

	// load pump charges
	function load_pump_charges($id)
	{
		$this->db->where('cc_id', $id);
		$this->db->group_by('pump_id');
		$this->db->order_by('pump_id', 'asc');
		$query = $this->db->get(TBL_PUMP_CHARGES);

		return $query->result();
	}

	//get available charges
	function get_particulars()
	{
		$this->db->where('is_active', TRUE);
		$this->db->order_by('line_no', 'asc');
		$query = $this->db->get(TBL_PARTICULARS);

		return $query->result();
	}

	//check if number of storey is high rise by pump type
	function is_high_rise($pump_id,$project_storey)
	{
		$this->db->where('pump_id', $pump_id);
		$query = $this->db->get(TBL_PUMP);

		foreach($query->result() as $row)
		{
			return $project_storey >= $row->high_level;
		}
	}

	function floor_surcharge($cc_id)
	{
		

		#get contract project
		$project = '';
		$this->db->select('project_name');
		$this->db->where('cc_id', $cc_id);
		$query = $this->db->get(TBL_CLIENT_CONTRACTS);

		foreach ($query->result() as $row) 
		{
			$project = $row->project_name;
		}

		#get floor surcharge details
		$this->db->select(TBL_PUMP.'.pump_id,value,high_level,minimum_amt');
		$this->db->where('cc_id', $cc_id);
		$this->db->where('charge_id', 39);
		$this->db->from(TBL_PUMP_CHARGES);
		$this->db->join(TBL_PUMP, TBL_PUMP_CHARGES.'.pump_id = '.TBL_PUMP.'.pump_id', 'both');
		$this->db->group_by(TBL_PUMP.'.pump_id');
		$query = $this->db->get();

		$pump = $query->result();


		
		$arr_floor 		= array();

		$stry_current 	= 0;
		$stry_prev 		= 0;
		$amt 			= 0;
		$amt_addend		= 0;
		$desc 			='';
		

		foreach ($pump as $p) 
		{
			$this->load->helper('rank');
			$arr_surcharge 	= array();

			$stry_current 	= $p->high_level;
			$amt 			= $p->minimum_amt;
			$amt_addend 	= $p->value;
			$plus			= 0;
			do 
			{
				$stry_prev = $stry_current;
				$stry_current += $plus;
				$amt += $amt_addend;

				$desc = /*rankNum($stry_prev).'-'.*/rankNum($stry_current);
				array_push($arr_surcharge,array($amt,$desc));
				$plus = 1;
			} while ($stry_current < (int)$project);

			$arr_floor[$p->pump_id] = $arr_surcharge;
			unset($arr_surcharge);
		}

		return $arr_floor;
	}

}

/* End of file Pump_model.php */
/* Location: ./application/models/Pump_model.php */