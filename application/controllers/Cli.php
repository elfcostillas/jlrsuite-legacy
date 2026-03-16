<?php
   class CLI extends CI_Controller {
   	var $dateNow;
      var $timeNow;
      var $dateYesterday;

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

      /*-------------------------------------------------------------------------------------------------------------------------------
      |
      |     Created by : Ralph Tan Ceriaco   -- Used by the cron daemon of unix to automatically record daily performance of DEU
      |     added functions for the weigher data automatic data import/export - 9-27-2013   
      |  
      |------------------------------------------------------------------------------------------------------------------------------*/
   	
   	function __construct()
       {
         // Call the Model constructor
         parent::__construct();
	 $this->dateNow = date("Y-m-d");  
         $this->dateYesterday = date('Y-m-d', strtotime('-1 days', strtotime(date("Y-m-d"))));
         //$this->dateYesterday = date('Y-m-d', strtotime('-10 days', strtotime(date("Y-m-d"))));     //for correction
         $this->timeNow = date("H:i:s"); 
       }

      function record_daily_deuperf(){
   		$date_now = date('Y-m-d H:i:s');
   		//echo $date_now; exit();



   		$qad_sum = $this->deu_model->getQADsummary();
   		$rmcd_sum = $this->deu_model->getRMCDsummary();
        $pi = $this->deu_model->getPI();


   		$data = array(
                  'qad_dt_u'       	=> $qad_sum['nDT'],
                  'qad_pl_u'       	=> $qad_sum['nPLQAD'],
                  'qad_bh_u'   		=> $qad_sum['nBH'],
                  'qad_bd_u'       	=> $qad_sum['nBD'],
                  'qad_dt_a'       	=> $qad_sum['aDT'],
                  'qad_pl_a'       	=> $qad_sum['aPLQAD'],
                  'qad_bh_a'   		=> $qad_sum['aBH'],
                  'qad_bd_a'       	=> $qad_sum['aBD'],
                  'qad_dt_d'       	=> $qad_sum['dDT'],
                  'qad_pl_d'       	=> $qad_sum['dPLQAD'],
                  'qad_bh_d'   		=> $qad_sum['dBH'],
                  'qad_bd_d'       	=> $qad_sum['dBD'],
                  'qad_dt_perca'       => $qad_sum['perc_DT'],
                  'qad_pl_perca'       => $qad_sum['perc_PLQAD'],
                  'qad_bh_perca'   	=> $qad_sum['perc_BH'],
                  'qad_bd_perca'       => $qad_sum['perc_BD'],
                  'qad_dt_perct'       => '80',
                  'qad_pl_perct'       => '80',
                  'qad_bh_perct'   	=> '85',
                  'qad_bd_perct'       => '80',
                  'rmcd_tm_u'       	=> $rmcd_sum['nTM'],
                  'rmcd_pump_u'       	=> $rmcd_sum['nPUMP'],
                  'rmcd_pl_u'   		=> $rmcd_sum['nPL'],
                  'rmcd_ss_u'       	=> $rmcd_sum['nSS'],
                  'rmcd_tm_a'       	=> $rmcd_sum['aTM'],
                  'rmcd_pump_a'       	=> $rmcd_sum['aPUMP'],
                  'rmcd_pl_a'   		=> $rmcd_sum['aPL'],
                  'rmcd_ss_a'       	=> $rmcd_sum['aSS'],
                  'rmcd_tm_d'       	=> $rmcd_sum['dTM'],
                  'rmcd_pump_d'       	=> $rmcd_sum['dPUMP'],
                  'rmcd_pl_d'   		=> $rmcd_sum['dPL'],
                  'rmcd_ss_d'       	=> $rmcd_sum['dSS'],
                  'rmcd_tm_perca'      => $rmcd_sum['perc_TM'],
                  'rmcd_pump_perca'    => $rmcd_sum['perc_PUMP'],
                  'rmcd_pl_perca'   	=> $rmcd_sum['perc_PL'],
                  'rmcd_ss_perca'      => $rmcd_sum['perc_SS'],
                  'rmcd_tm_perct'      => '80',
                  'rmcd_pump_perct'    => '95',
                  'rmcd_pl_perct'   	=> '80',
                  'rmcd_ss_perct'      => '',
                  'qad_average'      => $qad_sum['sAVE'],
                  'rmcd_average'     => $rmcd_sum['sAVE'],
                  'rmdpi_target'       => $pi['o_at'],
                  'rmdpi_overall'   	=> $pi['o_va'],
                  'gen_date'       	=> $date_now
               );
       

   		$res = $this->deu_model->add_deudaily_record($date_now,$data);
   		echo $res;
   	}

      function sync_weigherdata_auto(){

         $day='today';
         echo $this->weigher_model->get_local_records($this->dateNow,'NORTH') ;
         $data1 = array(
               'date_performed'  => $this->dateNow,
               'time_performed'  => $this->timeNow,
               'mode'            => 'auto',
               'area'            => 'NORTH',
               'day'             => $day,
               'status'          => 'done'
           );
         $this->db->insert('cron_history', $data1);


         $day='yesterday';
         echo $this->weigher_model->get_local_records($this->dateYesterday,'NORTH') ;
         $data1 = array(
               'date_performed'  => $this->dateNow,
               'time_performed'  => $this->timeNow,
               'mode'            => 'auto',
               'area'            => 'NORTH',
               'day'             => $day,
               'status'          => 'done'
           );
         $this->db->insert('cron_history', $data1);
      }



      // ================================================================
      // function to automatically backup first
      // the stock position and then reset the
      // values and the date for another date
      // 
      // 
      //  author - ralph tan ceriaco
      //  date - april 12, 2016
      //  ===============================================================


      function check_daily_stock_position(){

         //echo '<br />testing';

         $stock_pos_result = $this->warehouse_model->get_stock_position($this->dateYesterday);
         foreach ($stock_pos_result as $row)
         {
          $id = $row->position_id;
          $this->get_position_info($id);
         }

            // echo 'stock=' . $this->stock_onhand . '<br />';
            // echo 'rec=' . $this->received . '<br />';
            // echo 'issue=' . $this->issued  . '<br />';
            // echo 'trans=' . $this->transfer  . '<br />';
            // echo 'bal=' . $this->balance  . '<br />';


            // $this->output->enable_profiler(TRUE);
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
         return $this->warehouse_model->get_receive($id,$this->dateYesterday);
      }

      function get_issue_count($id){
         return $this->warehouse_model->get_issue($id,$this->dateYesterday);
      }

      function get_transfer_count($id){
         return $this->warehouse_model->get_transfer($id,$this->dateYesterday);
      }

      function insert_position_history($date){
         $data = array(
            'stock_pos_id'    => $this->position_id,
            'item_id'         => $this->item_id,
            'reorder_level'   => $this->reorder_level,
            'stock_onhand'       => $this->stock_onhand,
            'req_mos_inv'     => $this->req_mos_inv,
            'received'        => $this->received,
            'issued'          => $this->issued,
            'transfer'        => $this->transfer,
            'balance'         => $this->balance,
            'position_date'   => $date,
            'write_time'      => $this->timeNow 
         );

         $this->warehouse_model->insert_position_history($data);
      }

      function reset_position($id,$date){
         $data = array(
            'stock_onhand'    => $this->new_stock_onhand,
            'received'        => 0,
            'issued'          => 0,
            'balance_qty'     => 0,
            'position_date'   => $date,
            'date_encoded'       => $date . ' ' . $this->timeNow,
            'author'          => 'SYSTEM'
         );

         $this->warehouse_model->reset_position($id,$data);
      }

   }
?>