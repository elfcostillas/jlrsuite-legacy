<?php

class Warehouse_model extends CI_Model {

  private $south;
  private $north;
  private $central;


	public function __construct()
	{
    $this->dateNow = date("Y-m-d");
    $this->timeNow = date("HH:MM:ll"); 
	}


  function get_pending_requests(){
    $this->db->select("*",FALSE);
    $this->db->where('status','PENDING');
    $this->db->group_by('ws_code');
    $query = $this->db->get('whs_withdrawal');

    return $query->result();
  }


  function ajax_approved_withdrawal_request($ws_code,$approver){

    $this->db->set('status','APPROVED');
    $this->db->set('app_by',$approver);
    $this->db->where('ws_code',$ws_code);
    $this->db->update('whs_withdrawal'); 


       
    if ($this->db->affected_rows() > 0){
        //success
        echo "success";
    }else{
        echo "error";
    }

   
  }

  function ajax_get_ws_items($ws_code){
    $this->db->select("item_desc,item_um,qty_req",FALSE);
    $this->db->where('ws_code',$ws_code);
    $query = $this->db->get('whs_withdrawal');

    return json_encode($query->result());
  }









  /*
    methods for the cron job




   */

  function get_stock_position($dateYesterday){
    $this->db->select("id as position_id",FALSE);
    $this->db->where('position_date', $dateYesterday);
    $query = $this->db->get('whs_stock_pos');

    return $query->result();
  }

  function get_position_info($id){
    $this->db->select("*",FALSE);
    $this->db->where('id', $id);
    $query = $this->db->get('whs_stock_pos');

    return $query->result();
  }

  function get_receive($id,$date){
    $this->db->select("SUM(quantity) as receive_cnt",FALSE);
    $this->db->where('stock_pos_id', $id);
    $this->db->where('date_receive', $date);
    $query = $this->db->get('whs_stock_receive');

    if($query->result()[0]->receive_cnt > 0){
      return $query->result()[0]->receive_cnt;
    }else{
      return 0;
    }

  }

  function get_issue($id,$date){
    $this->db->select("SUM(qty) as issue_cnt",FALSE);
    $this->db->where('stock_pos_id', $id);
    $this->db->where('date_issued', $date);
    $query = $this->db->get('whs_stock_issue');

    if($query->result()[0]->issue_cnt > 0){
      return $query->result()[0]->issue_cnt;
    }else{
      return 0;
    }

  }

  function get_transfer($id,$date){
    $this->db->select("SUM(quantity) as transfer_cnt",FALSE);
    $this->db->where('stock_pos_id', $id);
    $this->db->where('date_transfer', $date);
    $query = $this->db->get('whs_stock_transfer');

    if($query->result()[0]->transfer_cnt > 0){
      return $query->result()[0]->transfer_cnt;
    }else{
      return 0;
    }

  }
  
  function check_isin_history($id,$date){
    $this->db->select("*",FALSE);
    $this->db->where('stock_pos_id', $id);
    $this->db->where('position_date', $date);
    $query = $this->db->get('whs_stock_pos_history');

    if ($query->num_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  function insert_position_history($data){
    $this->db->insert('whs_stock_pos_history', $data);
    $id = $this->db->affected_rows();

    return $id;
  }

  function reset_position($pos_id,$data){
    $this->db->where('id', $pos_id);
    $this->db->update('whs_stock_pos', $data); 
   
    if ($this->db->affected_rows() > 0){
        //success
        echo "1";
    }else{
        echo "0";
    }
  }
   
} 

