<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ADMIN extends CI_Controller {

	

	var $dateNow;
	var $timeNow;
	var $lvl;

	var $position_id;
	var $item_id;
	var $reorder_level;
	var $req_mos_inv;

	var $stock_onhand;
	var $received;
	var $issued;
	var $transfer;
	var $balance;
	var $new_stock_onhand;

	



	function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->lvl = $this->session->userdata('userlvl');
		$this->dateNow = date("Y-m-d");
		$this->timeNow = date('H:i:s');
		$this->dateYesterday = date('Y-m-d',strtotime("-1 days"));
        
    }


	function index()
	{
		if ($this->session->userdata('is_logged_in')){
			if($this->functionlist->isAdmin($this->lvl)){
				$this->pagemaker->setSoftname('Administration Panel');

				$content['cronlog'] = $this->weigher_model->get_cronhistory();

				$content['status'] = '';
				$content['dateyesterday'] = $this->dateYesterday;

				$this->body['view'] = 'admin/index';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Dashboard');
			}
			else{
				    redirect('welcome/denied');
			}
		}else{
            redirect('main/login_main');
        }	

		
		
		
	
	}

	

	




	/* --------------------------------------------------------------
	|
	|		Display logs here
	|		AUTHOR: RALPH TAN CERIACO
	|
	---------------------------------------------------------------*/

	function display_online_stats(){

	}

	function display_sync_logs(){
		
	}


	/* --------------------------------------------------------------
	|
	|		Cron jobs script fro syncing
	|		AUTHOR: RALPH TAN CERIACO
	|
	---------------------------------------------------------------*/

	function sync_manual($plant,$from_date,$to_date){

	}

	function sync_auto($plant,$date){
		
	}

	//test warehousing
	//
	
	function check_daily_stock_position(){

		$stock_pos_result = $this->warehouse_model->get_stock_position($this->dateYesterday);
	


		foreach ($stock_pos_result as $row)
       	{
          $id = $row->position_id;
          $this->get_position_info($id);
       	}

       	echo 'stock=' . $this->stock_onhand . '<br />';
       	echo 'rec=' . $this->received . '<br />';
       	echo 'issue=' . $this->issued  . '<br />';
       	echo 'trans=' . $this->transfer  . '<br />';
       	echo 'bal=' . $this->balance  . '<br />';


       	$this->output->enable_profiler(TRUE);


	}
	
	function get_position_info($id){
		$position_res = $this->warehouse_model->get_position_info($id);

		//iterate through the records
		foreach ($position_res as $row)
       	{
	      	$this->position_id = $row->id;
			$this->item_id = $row->item_id;
			$this->reorder_level = $row->reorder_level;
			$this->req_mos_inv = $row->req_mos_inv;

			$this->stock_onhand = $row->stock_onhand;
			$this->received = $this->get_receive_count($id);
			$this->issued = $this->get_issue_count($id);
			$this->transfer = $this->get_transfer_count($id);

			//calculate the balance -> get from ither tables
			$this->balance = ($this->stock_onhand + $this->received) - $this->issued;

			//assign the calculated balance to the new stock-on-hand
			$this->new_stock_onhand = $this->balance;

			$res = $this->warehouse_model->check_isin_history($this->position_id,$this->dateYesterday);

			if($res == false){
				//insert the position data to the history table
				$this->insert_position_history($this->dateYesterday);

				//update the
				$this->reset_position($this->position_id,$this->dateNow);
			}else{
				//do nothing just skip it
				echo '<------ not inserting ------>';
			}
			
       	}

	}

	function get_receive_count($id){
		return $this->warehouse_model->get_receive($id);
	}

	function get_issue_count($id){
		return $this->warehouse_model->get_issue($id);
	}

	function get_transfer_count($id){
		return $this->warehouse_model->get_transfer($id);
	}

	function insert_position_history($date){
		$data = array(
			'stock_pos_id'		=> $this->position_id,
			'item_id' 			=> $this->item_id,
			'reorder_level' 	=> $this->reorder_level,
			'stock_onhand' 		=> $this->stock_onhand,
			'req_mos_inv' 		=> $this->req_mos_inv,
			'received' 			=> $this->received,
			'issued' 			=> $this->issued,
			'transfer' 			=> $this->transfer,
			'balance' 			=> $this->balance,
			'position_date' 	=> $date,
			'write_time' 		=> $this->timeNow 
		);

		$this->warehouse_model->insert_position_history($data);
	}

	function reset_position($id,$date){
		$data = array(
			'stock_onhand'		=> $this->new_stock_onhand,
			'received' 			=> 0,
			'issued' 			=> 0,
			'balance_qty' 		=> 0,
			'position_date' 	=> $date,
			'date_encoded' 		=> $date . ' ' . $this->timeNow,
			'author' 			=> 'SYSTEM'
		);

		$this->warehouse_model->reset_position($id,$data);

	}
	
	

}