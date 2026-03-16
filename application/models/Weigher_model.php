<?php

class Weigher_model extends CI_Model {

  private $south;
  private $north;
  private $central;


	public function __construct()
	{
    $this->dateNow = date("Y-m-d");
    $this->timeNow = date("HH:MM:ll"); 
	}


  public function get_local_records($date_today,$area)
  {
    $query = $this->db->query("SELECT * FROM area_transaction WHERE tare_date='{$date_today}' AND weigh_status='2' ");
    
    $localres = $query->result();

    foreach ($localres as $result) {

              //get initial details
              $tmp_doc = $result->doc_no;
              $tmp_txn = $result->txn_no;
              $tmp_lastedit = $result->last_edited;

              $data = array(
                  'doc_no'              => $result->doc_no,
                  'txn_no'              => $result->txn_no,
                  'delv_date'           => $result->delv_date,
                  'delv_time'           => $result->delv_time,
                  'vech_no'             => $result->vech_no,
                  'vech_std'            => $result->vech_std,
                  'comp_name'           => $result->comp_name,
                  'drvr_name'           => $result->drvr_name,
                  'dr_no'               => $result->dr_no,
                  'mat_type'            => $result->mat_type,
                  'mat_desc'            => $result->mat_desc,
                  'dr_qty'              => $result->dr_qty,
                  'dr_unit'             => $result->dr_unit,
                  'dr_unitwgt'          => $result->dr_unitwgt,
                  'mat_sg'              => $result->mat_sg,
                  'gross'               => $result->gross,
                  'tare'                => $result->tare,
                  'netwgt'              => $result->netwgt,
                  'weigh_status'        => $result->weigh_status,
                  'weigh_user'          => $result->weigh_user,
                  'wgt_ttl'             => $result->wgt_ttl,
                  'wgt_total'           => $result->wgt_total,
                  'variance'            => $result->variance,
                  'vech_hgt'            => $result->vech_hgt,
                  'mat_contr'           => $result->mat_contr,
                  'cs_client'           => $result->cs_client,
                  'supp_code'           => $result->supp_code,
                  'tare_date'           => $result->tare_date,
                  'tare_time'           => $result->tare_time,
                  'weigh_area'          => $result->weigh_area,
                  'unitweight'          => $result->unitweight,
                  'cof'                 => $result->cof,
                  'last_edited'         => $result->last_edited,
		              'supp_gross'          => $result->supp_gross,
                  'supp_tare'           => $result->supp_tare,
                  'supp_netwgt'         => $result->supp_netwgt,
                  'po_no'               => $result->po_no,
                  'variance_status'     => $result->variance_status,
                  'vech_length'         => $result->vech_length,
                  'vech_width'          => $result->vech_width,
                  'cement_temperature'  => $result->cement_temperature
              );
              echo $this->weigher_model->check_doc_txnno($tmp_doc,$tmp_txn,$tmp_lastedit,$data);
    }

  }

  function check_doc_txnno($docno,$txnno,$lastedited,$data){

    $query = $this->db->query("SELECT * FROM transaction WHERE doc_no='{$docno}' AND txn_no='{$txnno}'");
    //check if doc and txn exist
    if($query->num_rows() >= 1){

      //if existing then check if the last_edited date is equal or not
      $query2 = $this->db->query("SELECT * FROM transaction WHERE doc_no='{$docno}' AND txn_no='{$txnno}' AND last_edited='{$lastedited}'");
      if($query2->num_rows() >= 1){
        //do nothing
        $msg = 0;
      }else{
        //not equal then update that record
        // disabled the update june 30 2016 by ralph
        
        //$this->db->where('doc_no', $docno);
        //$this->db->update('transaction', $data);
        //$msg = 2;
        $msg = 'x';
      }

    }else{
      //if not existing then insert
      $this->db->insert('transaction', $data);
      $msg = 1;
    }


    return $msg;
  }


  function get_cronhistory(){
    $query = $this->db->query("SELECT * FROM cron_history WHERE YEAR(date_performed)='2013' AND MONTH(date_performed)='11' ORDER BY id DESC");
    $localres = $query->result();
    return $localres;
  }
   
} 

