<?php
class DPS_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}


    function get_recent_pouring()
        {
            $query = $this->db->query(
                "SELECT * FROM `batch_scheduled_sap` WHERE modified_date <= CURDATE() GROUP BY o202_id DESC LIMIT 15 ")->result_array();

            return array(
                    'recentPouring' => $query,
                    'recentPouringCount' => count($query)
                    );
        }

    function generate_formno($form_type){
            switch ($form_type) {
                case 'form1':
                    $query = $this->db->query("SELECT `form_no` FROM `batch_scheduled_sap` WHERE `form_type` = '1' ORDER BY o202_id DESC LIMIT 1 ");
                    break;
                case 'form1a':
                    $query = $this->db->query("SELECT `form_no` FROM `batch_scheduled_sap` WHERE `form_type` = '1A' ORDER BY o202_id DESC LIMIT 1 ");
                    break;
            }

            $res = $query->result();

            foreach ($res as $val) {
            }

            return $val->form_no + 1;
    }

    function get_project_list()
    {
        $query = $this->db->query(
                "SELECT DISTINCT `project_name`,`o8_id` FROM `rmc_project_list` WHERE `status` = 'ACTIVE' ");

            return $query->result();
    }
    function get_landmark_sketch($project_id)
        {
            $query = $this->db->query(
                "SELECT `landmark_sketch` FROM `rmc_project_contacts` WHERE project_id = '{$project_id}' ");
            return $query->result();
        }

    function get_customer_info($id)
        {
            $query = $this->db->query(
                "SELECT * FROM jlr_customers WHERE o5_id = '{$id}' ");

            return $query->result_array();
        }

    function get_project_contact($id)
        {
            $query = $this->db->query(
                "SELECT * FROM rmc_project_contacts WHERE project_id = '{$id}' ");

            return $query->result_array();
        }

    function get_design_strength()
        {
            $query = $this->db->query(
                "SELECT * FROM rmc_strength_list");

            return $query->result_array();
        }

    function get_design_aggregates()
        {
            $query = $this->db->query(
                "SELECT * FROM rmc_msa_list");

            return $query->result_array();
        }

    function get_design_slump()
        {
            $query = $this->db->query(
                "SELECT * FROM rmc_slump_list");

            return $query->result_array();
        }

    function get_design_pouringtype()
        {
            $query = $this->db->query(
                "SELECT * FROM pouring_type_ref WHERE Status = 'ACTIVE' ORDER BY `Type`");

            return $query->result_array();
        }

    function get_design_structure()
        {
            $query = $this->db->query(
                "SELECT * FROM structures_ref ORDER BY `struct_name`");

            return $query->result_array();
        }


    /*
    |   Functions to Insert Form1 and Form1A data in the database
    |
    |   by:Ralph Ceriaco
    */

    function get_salesengg_list()
    {
        //$query = $this->db->query("SELECT * FROM  `reps_sle_ref` ");
        $query = $this->db->query("SELECT * FROM  `reps_sle_ref` where status ='active'");
        return $query->result(); 
    }

    function get_extlab_list()
    {
        $query = $this->db->query("SELECT * FROM  `qc_external_labs` ");
        return $query->result(); 
    }

    function get_old_custinfo($id){
        $query = $this->db->query("SELECT `customer_name` FROM  `jlr_customers` WHERE `o5_id` = '{$id}' ");
        return $query->result(); 
    }

    function insert_project_customer($cust_name,$cust_add)
    {
        $query = $this->db->query("INSERT INTO `jlr_customers` (`customer_name`,`customer_address`) VALUES ('{$cust_name}','{$cust_add}')");
        //return mysql_insert_id();
        return $this->db->insert_id();
    }

    function insert_project_details($data)
    {
        $this->db->insert('rmc_project_list', $data);
        return $this->db->insert_id();
    }

    function insert_project_contacts($project_id,$ownername,$ownercon,$enggname,$enggcon,$acctgname,$acctgcon,$witnessname,$witnesscon)
    {
        $query = $this->db->query("INSERT INTO `rmc_project_contacts` 
                                    (`project_id`,`owner_name`,`owner_contact`,`engineer_name`,`engineer_contact`,`acctg_name`,`acctg_contact`,`witness_name`,`witness_contact`) 
                                    VALUES 
                                    ('{$project_id}','{$ownername}','{$ownercon}','{$enggname}','{$enggcon}','{$acctgname}','{$acctgcon}','{$witnessname}','{$witnesscon}')
                                    ");
    }

    function insert_project_landmark($project_id,$landmark_across,$landmark_right,$landmark_left,$landmark_sketch)
    {
        $query = $this->db->query("UPDATE `rmc_project_contacts` 
                                   SET 
                                   `landmark_across`='{$landmark_across}',
                                   `landmark_right`='{$landmark_right}',
                                   `landmark_left`='{$landmark_left}', 
                                   `landmark_sketch`='{$landmark_sketch}' 
                                   WHERE (`project_id`='{$project_id}')");
    }

    function insert_project_design($data)
    {
        $this->db->insert('batch_scheduled_sap', $data);
    }

    function insert_project_qc($data)
    {
        //$project_id,$samp_standard,$samp_others,$samp_oth_cylinder,$samp_oth_cubic,$curing_atsite,$curing_atjlr,$testing_jlr7,$testing_jlr14,$testing_jlr28,$testing_extlabname,$testing_colab,$testing_ext7,$testing_ext14,$testing_ext28,$client_witness,$consultant_name,$consultant_num
        /*$query = $this->db->query("INSERT INTO `rmc_project_qc` 
                                    (`project_id`,`samp_standard`,
                                     `samp_others`,`oth_cyl`,
                                     `oth_m3`,`curing_asite`,
                                     `curing_ajlr`,`test_jlr_7`,
                                     `test_jlr_14`,`test_jlr_28`,
                                     `ex_lab`,`co_elab`,
                                     `test_elab_7`,`test_elab_14`,
                                     `test_elab_28`,`witness_presence`,
                                     `consultant_name`,`consultant_num`) 
                                    VALUES 
                                    ('{$project_id}','{$samp_standard}',
                                     '{$samp_others}','{$samp_oth_cylinder}',
                                     '{$samp_oth_cubic}','{$curing_atsite}',
                                     '{$curing_atjlr}','{$testing_jlr7}',
                                     '{$testing_jlr14}','{$testing_jlr28}',
                                     '{$testing_extlabname}','{$testing_colab}',
                                     '{$testing_ext7}','{$testing_ext14}',
                                     '{$testing_ext28}','{$client_witness}',
                                     '{$consultant_name}','{$consultant_num}')
                                    ");*/
        $this->db->insert('rmc_project_qc', $data);
    }


    function get_batch_schedule($date,$user){
        //user = coor or smd
        $query = $this->db->query(
                "SELECT * 
                FROM `batch_scheduled_sap`
                WHERE `modified_date` = '{$date}' AND `design_status` <> 'Pending'
                ORDER BY `batching_plant`,`modified_time`");

        
        if($query->num_rows() > 0){
                    $schedule['result'] = $query;
                    $schedule['rowcount'] = $query->num_rows();

                    switch ($user) {
                        case 'coor':
                            $schedule['view'] = 'dps/pouringschedule_coor';

                            $schedule['timerap'] = $this->functionlist->getDPSTimeArrays();
                            $schedule['designstatus'] = $this->functionlist->getDesignStatus();
                            
                            //get the list for the design
                            $schedule['strength'] = $this->dps_model->get_design_strength();
                            $schedule['agg'] = $this->dps_model->get_design_aggregates();
                            $schedule['slump'] = $this->dps_model->get_design_slump();
                            $schedule['pouringtype'] = $this->dps_model->get_design_pouringtype();
                            $schedule['structure'] = $this->dps_model->get_design_structure();
                            $schedule['salesengg'] = $this->dps_model->get_salesengg_list();
                            $schedule['extlab'] = $this->dps_model->get_extlab_list();
                            return $schedule;
                            break;

                        case 'smd':
                            $schedule['view'] = 'dps/pouringschedule_smd';
                            return $schedule;
                            break;

                        case 'mobile':
                            $schedule['view'] = 'dps/mobile_pouringschedule_smd';
                            return $schedule;
                            break;
                    }
               
        }else{
            $schedule['view'] = 'dps/nobookings';
            $schedule['confirmpage'] = 'scheduler';
            return $schedule;
        }
        

    }

    //ADDED BY WBSOLON 12/13/2019
    function get_batch_pourtype($date){
        
        $query = $this->db->query("SELECT * FROM(
            SELECT b.pour_type,(
                SELECT sum(batch_vol) FROM batch_scheduled_sap
                WHERE `modified_date` = '{$date}' 
                AND `design_status` <> 'Pending' 
                AND pour_type = b.pour_type
                ) AS pour_vol
                FROM batch_scheduled_sap b
                WHERE `modified_date` = '{$date}' 
                AND `design_status` <> 'Pending'
                GROUP BY pour_type
                ORDER BY pour_type) AS t1
        UNION ALL SELECT 'OVER ALL',sum(c.batch_vol) FROM batch_scheduled_sap c
        WHERE `modified_date` = '{$date}' 
        AND `design_status` <> 'Pending'");

        if($query->num_rows() > 0){
            
           return $query->result();
        }else {
        }
     }   


    function update_scheddate($id,$data)
    {
        $this->db->where('o202_id', $id);
        $this->db->update('batch_scheduled_sap', $data);
    }

    function update_scheddate_formula($id,$fcode_1,$fcode_2)
    {
        $query = $this->db->query("UPDATE `batch_scheduled_sap` 
                                   SET 
                                   `f_code1`='{$fcode_1}',
                                   `f_code2` = '{$fcode_2}'
                                   WHERE `o202_id`='{$id}' ");
    }

    function insert_approved_schedule($id)
    {
        $query = $this->db->query("INSERT INTO `batch_request`
                                   SELECT *
                                   FROM `batch_scheduled_sap`
                                   WHERE o202_id = '{$id}' ");
    }

    function coor_status_approved($id,$date)
    {
        $query = $this->db->query("UPDATE `batch_scheduled_sap`
                                   SET
                                   `coor_status`='Approved',
                                   `coor_approved_date`='{$date}'
                                   WHERE o202_id = '{$id}' ");
    }

    function smd_status_approved($id,$date)
    {
        $query = $this->db->query("UPDATE `batch_scheduled_sap`
                                   SET
                                   `smd_status`='Approved',
                                   `smd_approved_date`='{$date}'
                                   WHERE o202_id = '{$id}' ");
    }

    function insert_batchsched_history($data)
    {
        $this->db->insert('batch_scheduled_history', $data);
    }

    //form 1a get project by customer id
    function getprojectby_cust($id){
        $query = $this->db->query("SELECT `o8_id`,`project_name`,`project_location` FROM  `rmc_project_list` WHERE client_id = '{$id}' GROUP BY project_name,project_location");
        return $query->result(); 
    }


    /* QUERIES FOR THE PUORING SCHEDULE TODAY AND TOMORROW */
    function fetch_bookings($mode,$date,$batching_plant)
    {
        if($batching_plant == 'Plant 3')
        {
            $string = "AND `batching_plant` in ('{$batching_plant}','Plant 5')";
        }else{
            $string = "AND `batching_plant` = '{$batching_plant}'";
        }

        switch ($mode) {

            case 'bookingpanel':
                $query = $this->db->query("SELECT * FROM `batch_scheduled_sap`
                                           WHERE 
                                           coor_status = 'Approved' 
                                           AND smd_status = 'Approved' 
                                           AND (`design_status` <> 'Insert' AND `design_status` <> 'For Confirmation')
                                           AND `design_status` <> 'Pending' 
                                           AND modified_date = '{$date}'
                                           $string
                                           ORDER BY `modified_time`,`cust_name`");

                if($query->num_rows() > 0){
                    $bookings['result'] = $query;
                    $bookings['rowcount'] = $query->num_rows();
                    $bookings['view'] = 'dps/dps_table_view';
                    $bookings['status'] = 'normal';
                    $bookings['count'] = 'record';
                    $bookings['plant_loc'] = $batching_plant;
                    $bookings['volume'] = $this->getVol($date,1,$batching_plant);
                }
                else{
                    $bookings['confirmpage'] = 'no';
                    $bookings['date'] = $date;
                    $bookings['count'] = 'norecord';
                    $bookings['plant_loc'] = $batching_plant;
                    $bookings['message'] = 'There are NO Scheduled Pourings as of this moment';
                    $bookings['view'] = 'dps/nobookings';
                }
                return $bookings;
                break;

            case 'bookingpanel_insert':
                //    AND `batching_plant` = '{$batching_plant}'
                $query = $this->db->query("SELECT * FROM `batch_scheduled_sap`
                                           WHERE 
                                           coor_status = 'Approved' 
                                           AND smd_status = 'Approved' 
                                           AND design_status = 'Insert' 
                                           AND modified_date = '{$date}'
                                            $string
                                           ORDER BY `modified_time`,`cust_name` ");
               
                if($query->num_rows() > 0){
                    $bookings['result'] = $query;
                    $bookings['rowcount'] = $query->num_rows();
                    $bookings['view'] = 'dps/dps_table_view';
                    $bookings['status'] = 'insert';
                    $bookings['count'] = 'record';
                    $bookings['plant_loc'] = $batching_plant;
                    $bookings['volume'] = $this->getVol($date,2,$batching_plant);
                }else{
                    $bookings['count'] = 'norecord';
                    
                }
    
                return $bookings;
                break;
            
            case 'bookingpanel_confirm':
                $query = $this->db->query("SELECT * FROM `batch_scheduled_sap`
                                           WHERE 
                                           coor_status = 'Approved' 
                                           AND smd_status = 'Approved' 
                                           AND design_status = 'For Confirmation' 
                                           AND modified_date = '{$date}'
                                           ORDER BY `modified_time`,`cust_name`");
                if($query->num_rows() > 0){
                    $bookings['result'] = $query;
                    $bookings['rowcount'] = $query->num_rows();
                    $bookings['view'] = 'dps/dps_table_view';
                    $bookings['status'] = 'normal';
                    $bookings['plant_loc'] = 'both';
                    $dateNow = date("Y-m-d");
                    if($date == $dateNow){
                        $bookings['day'] = 'Today';
                    }else{
                        $bookings['day'] = 'Tomorrow';
                    }
                    $bookings['volume'] = $this->getVol($date,3,$batching_plant);

                }
                else{
                    $bookings['confirmpage'] = 'yes';
                    //$bookings['date'] = $date;
                    $bookings['message'] = 'There are NO Scheduled Pourings as of this moment';
                    $bookings['view'] = 'dps/nobookings';
                }
                return $bookings;
                break;
            
        }
    }

    //MOBILE DPS QUERY
    // FLUID and FIX
    function fetch_bookings_mobile($date,$batching_plant,$layout)
    {
          
        /*$query = $this->db->query("SELECT * FROM `batch_scheduled`
                                   WHERE 
                                   coor_status = 'Approved' 
                                   AND smd_status = 'Approved' 
                                   AND modified_date = '{$date}'
                                   AND `batching_plant` = '{$batching_plant}'
                                   ORDER BY `modified_time`,`cust_name` ");*/
        $query = $this->db->query("SELECT (select s1.termDesc from billing_terms s1 where s1.termsid= b.termsid) as terms,a.* FROM batch_scheduled_sap a 
                            left join jlr_customers b on a.client_id=b.o5_id  
                            WHERE 
                            coor_status = 'Approved' 
                            AND smd_status = 'Approved'
                            AND `design_status` <> 'Pending'  
                            AND modified_date = '{$date}'
                            AND `batching_plant` = '{$batching_plant}'
                            ORDER BY `modified_time`,`cust_name` ");
        

        if($query->num_rows() > 0){
            $bookings['result'] = $query;
            $bookings['rowcount'] = $query->num_rows();
            $bookings['view'] = 'dps/mobiledps-table';
            $bookings['volume'] = $this->getVol($date,5,$batching_plant);
            $bookings['okaycount'] = $this->count_design_status($date,'1',$batching_plant);
            $bookings['insertcount'] = $this->count_design_status($date,'2',$batching_plant);
            $bookings['reschedcount'] = $this->count_design_status($date,'3',$batching_plant);
            switch ($layout) {
                case 'fluid':
                    $bookings['layout'] = 'fluid';
                    break;
                case 'fix':
                    $bookings['layout'] = 'fix';
                    break;
            }
        }
        else{
            $bookings['plant_loc'] = $batching_plant;
            $bookings['message'] = 'There are NO Scheduled Pourings as of this moment';
            $bookings['view'] = 'dps/nobookings';
            $bookings['confirmpage'] = 'mobile';
            $bookings['volume'] = 0;
            $bookings['okaycount'] = 0;
            $bookings['insertcount'] = 0;
            $bookings['reschedcount'] = 0;
        }
        return $bookings;

    }

    function ajax_fetch_booking($date){
        // $query = $this->db->query("SELECT * FROM `batch_scheduled_sap`
        //                                    WHERE modified_date = '{$date}'
        //                                    ORDER BY `design_status` DESC,`modified_time` ");
        $query = $this->db->query("SELECT * FROM `batch_scheduled_sap`
                                           WHERE modified_date = '{$date}'
                                   UNION ALL 
                                   SELECT * FROM `batch_scheduled`
                                           WHERE modified_date = '{$date}'        
                                           ORDER BY `design_status` DESC,`modified_time` ");

                if($query->num_rows() > 0){
                    $bookings['result'] = $query;
                    $bookings['rowcount'] = $query->num_rows();
                    $bookings['volume'] = $this->getVol($date,4,'');
                    $bookings['count'] = 'record';
                }
                else{
                    $bookings['count'] = 'norecord';
                }

                return $bookings;
    }

    function ajax_fetch_booking_cust($cust){
        // $query = $this->db->query("SELECT * FROM `batch_scheduled_sap`
        //                                    WHERE client_id = '{$cust}'
        //                                    ORDER BY `modified_date` DESC ");
        // $query = $this->db->query("SELECT * FROM `batch_scheduled_sap`
        //                                     WHERE client_id = '{$cust}'
                                           
        //                             UNION all
                                    
        //                             SELECT * FROM `batch_scheduled`
        //                                     WHERE client_id = '{$cust}'
        //                                     ORDER BY `modified_date` DESC 
        //                                    ");
         $query = $this->db->query("SELECT * FROM `batch_scheduled_sap`
                                            WHERE cust_name LIKE '%{$cust}%'
                                           
                                    UNION all
                                    
                                    SELECT * FROM `batch_scheduled`
                                            WHERE cust_name LIKE '%{$cust}%'
                                            ORDER BY `modified_date` DESC 
                                           ");

                if($query->num_rows() > 0){
                    $bookings['result'] = $query;
                    $bookings['rowcount'] = $query->num_rows();
                    //$bookings['volume'] = $this->getVol($date,4,'');
                    $bookings['count'] = 'record';
                }
                else{
                    $bookings['count'] = 'norecord';
                }

                return $bookings;
    }
    

    

    function fetch_pouring_tomorrow($plant_location)
    {
        //get tomorrows date
        $tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
        $dateTom = date("Y-m-d", $tomorrow);

        $query = $this->db->query(
                "SELECT * 
                FROM `batch_scheduled_sap`
                WHERE 
                    `modified_date` = '{$dateTom}' AND
                    `coor_status` = 'Approved' AND
                    `smd_status` = 'Approved' AND
                    `design_status` <> 'Cancelled' AND
                    `batching_plant` = '{$plant_location}'
                ORDER BY modified_time
                ")->result_array();;

            return array(
                    'pouringTom' => $query,
                    'pouringCount' => count($query)
                    );
    }

    function getAccountingRem2()
    {
        $query = $this->db->query("SELECT * FROM `billing_terms` 
                                   WHERE 
                                   value <> 0 
                                   ORDER BY value ASC");
    }


    function fetch_edit_data($date,$dept)
    {
        $dateNow = date("Y-m-d");
        if ($dept == 'plant') {
            /*$query = $this->db->query("SELECT * FROM `batch_scheduled` 
                                   WHERE 
                                   coor_status = 'Approved' 
                                   AND (design_status <> 'Cancelled' AND design_status <> 'Pending')
                                   AND modified_date = '{$date}'
                                   ORDER BY `modified_time`");*/
             $query = $this->db->query("SELECT a.*,b.credit_limit as credit,(select s1.termDesc from billing_terms s1 where s1.termsid = b.termsid) as terms
                                    FROM batch_scheduled_sap a left join jlr_customers b on a.client_id = b.o5_id
                                   WHERE 
                                   coor_status = 'Approved' 
                                   AND (design_status <> 'Cancelled' AND design_status <> 'Pending')
                                   AND modified_date = '{$date}'
                                   ORDER BY `modified_time`");
        }else{
           /* $query = $this->db->query("SELECT * FROM `batch_scheduled` 
                                   WHERE 
                                   coor_status = 'Approved' */
                                   /* AND smd_status = 'Approved' */
                                   /*AND (design_status <> 'Cancelled' AND design_status <> 'Pending')
                                   AND modified_date = '{$date}'
                                   ORDER BY `modified_time`");*/
                                   /* AND smd_status = 'Approved' */
             $query = $this->db->query("SELECT a.*,b.credit_limit as credit,(select s1.termDesc from billing_terms s1 where s1.termsid = b.termsid) as terms
                                     FROM batch_scheduled_sap a left join jlr_customers b on a.client_id = b.o5_id 
                                   WHERE 
                                   coor_status = 'Approved' 
                                   
                                   AND (design_status <> 'Cancelled' AND design_status <> 'Pending')
                                   AND modified_date = '{$date}'
                                   ORDER BY `modified_time`");
        }
        

        if($query->num_rows() > 0){
                    $summary['result'] = $query;
                    $summary['rowcount'] = $query->num_rows();
                    switch ($dept) {
                        case 'main':
                            $summary['view'] = 'dps/dpsedit/summary';
                            break;

                        case 'acctg':
                            $summary['view'] = 'dps/dpsedit/acctg';
                            $summary['remarks_acctg'] = $this->functionlist->getAccountingRem();
                            break;
                        
                        case 'plant':
                            $summary['view'] = 'dps/dpsedit/plant';
                            $summary['serviceengr'] = $this->functionlist->getServiceEngr();
                            $summary['timerap'] = $this->functionlist->getDPSTimeArrays();
                            break;

                        case 'qc':
                            $summary['view'] = 'dps/dpsedit/qc';
                            $summary['qareps'] = $this->dps_model->fetch_qareps();
                            $summary['fcode'] = $this->dps_model->fetch_fcode();
                            break;

                        //---> added by ralph may 7, 2014 for mobile implementation
                        case 'm_acctg':
                            $summary['view'] = 'dps/dpsedit/mobile/acctg';
                            $summary['remarks_acctg'] = $this->functionlist->getAccountingRem();
                            break;

                        case 'm_plant':
                            $summary['view'] = 'dps/dpsedit/mobile/plant';
                            $summary['serviceengr'] = $this->functionlist->getServiceEngr();
                            break;

                        case 'm_qc':
                            $summary['view'] = 'dps/dpsedit/mobile/qc';
                            $summary['qareps'] = $this->dps_model->fetch_qareps();
                            $summary['fcode'] = $this->dps_model->fetch_fcode();
                            break;
                            
                    }
                    
                    return $summary;
        }else{
            $summary['view'] = 'dps/nobookings';
            $summary['confirmpage'] = 'editpouring';
            return $summary;
        }
    }

    function get_revisionstatus($id){
        $query = $this->db->query("SELECT `revision_status` FROM `batch_scheduled_sap` WHERE o202_id = '{$id}'");

        return $query->result();
    }

    function update_acctg_remarks($id,$remarks,$notes)
    {
        $rev_status = $this->dps_model->get_revisionstatus($id);

        foreach ($rev_status as $revision) {
        }
        $rev = $revision->revision_status;

        if(is_null($rev) OR $rev == ''){
            $revision_status = '2-';
        }else{
            $rev_arr = explode('-', $rev);

            if(in_array('2', $rev_arr)){
                $revision_status = $rev;
            }else{
                $revision_status = $rev.'2-'; 
            }
        }
       
        $query = $this->db->query("UPDATE `batch_scheduled_sap`
                                   SET
                                   `acctg_remarks`='{$remarks}',
                                   `note_acctg`='{$notes}',
                                   `revision_status` = '{$revision_status}'
                                   WHERE o202_id = '{$id}' ");
    }

    function update_supervisor($id,$servengr,$batchplant,$time,$timestat)
    {
        $rev_status = $this->dps_model->get_revisionstatus($id);

        foreach ($rev_status as $revision) {
        }
        $rev = $revision->revision_status;

        if(is_null($rev) OR $rev == ''){
            $revision_status = '3-';
        }else{
            $rev_arr = explode('-', $rev);

            if(in_array('3', $rev_arr)){
                $revision_status = $rev;
            }else{
                $revision_status = $rev.'3-'; 
            }
        }

        //if time is not change then dont change the coor approve
        switch ($timestat) {
            case '0':
                 $query = $this->db->query("UPDATE `batch_scheduled_sap`
                                   SET
                                   `batching_plant`='{$batchplant}',
                                   `service_engr`='{$servengr}',
                                   `revision_status` = '{$revision_status}',
                                   `modified_time` = '{$time}'
                                   WHERE o202_id = '{$id}' ");
                break;
            case '1':
                 $query = $this->db->query("UPDATE `batch_scheduled_sap`
                                   SET
                                   `batching_plant`='{$batchplant}',
                                   `service_engr`='{$servengr}',
                                   `revision_status` = '{$revision_status}',
                                   `f_code1` = 0,
                                   `f_code2` = 0,
                                   `modified_time` = '{$time}',
                                   `coor_status` = 'Unapproved'
                                   WHERE o202_id = '{$id}' ");
                break;
            
        }
       
    }

    function fetch_qareps()
    {
        $query = $this->db->query("SELECT * FROM `reps_qa_ref` WHERE `status` = 'ACTIVE' ORDER BY `code`");

            return $query->result();
    }

    function fetch_fcode()
    {
        $query = $this->db->query("SELECT * FROM `mix_design` WHERE `Product_Code` <> '0000' ORDER BY code");

            return $query->result();
    }

    function update_qc($id,$fcode1,$fcode2,$qa_rep,$qc_remarks,$qc_remarks_opt)
    {
        $rev_status = $this->dps_model->get_revisionstatus($id);

        foreach ($rev_status as $revision) {
        }
        $rev = $revision->revision_status;

        if(is_null($rev) OR $rev == ''){
            $revision_status = '4-';
        }else{
            $rev_arr = explode('-', $rev);

            if(in_array('4', $rev_arr)){
                $revision_status = $rev;
            }else{
                $revision_status = $rev.'4-'; 
            }
        }

        if($qc_remarks_opt != ''){
            $remarks = $qc_remarks . " & " . $qc_remarks_opt;
        }else
        {
            $remarks = $qc_remarks;
        }
        

        $query = $this->db->query("UPDATE `batch_scheduled_sap`
                                   SET
                                   `f_code1`='{$fcode1}',
                                   `f_code2`='{$fcode2}',
                                   `qa_rep`='{$qa_rep}',
                                   `qc_remarks`='{$remarks}',
                                   `revision_status` = '{$revision_status}'
                                   WHERE o202_id = '{$id}' ");
    }

    function fetch_notify_sched($date,$user)
    {

        switch ($user) {
            case 'acctg':
                    $query_append = "(`acctg_remarks` is null OR `acctg_remarks` = '')";
                break;
            
            case 'ps':
                    $query_append = "(`batching_plant` is null OR `batching_plant` = '' OR`service_engr` is null OR `service_engr` = '')";
                break;

            case 'qc':
                    $query_append = "(`f_code1` is null OR `f_code1` = '' OR`f_code2` is null OR `f_code2` = '' OR`qa_rep` is null OR `qa_rep` = '' OR`qc_remarks` is null OR `qc_remarks` = '')";
                break;
        }

        $query = $this->db->query("SELECT * FROM `batch_scheduled_sap` 
                                   WHERE 
                                   `coor_status` = 'Approved'
                                   AND `smd_status` = 'Approved'
                                   AND " .$query_append." AND `modified_date` = '{$date}'");
        $sched_count = count($query->result());

        return $sched_count;
    }

    function fetch_notify_smdmanager_sched($date)
    {
        $query = $this->db->query("SELECT * FROM `batch_scheduled_sap` 
                                   WHERE 
                                   `coor_status` = 'Approved'
                                   AND (`smd_status` = 'Unapproved' OR isnull(`smd_status`))
                                   AND `design_status` <> 'Pending'
                                   AND `modified_date` = '{$date}'");
        $sched_count = count($query->result());

        return $sched_count;
    }

    function fetch_notify_coor_sched($date)
    {
        $query = $this->db->query("SELECT * FROM `batch_scheduled_sap` 
                                   WHERE 
                                   `coor_status` = 'Unapproved'
                                   AND `design_status` <> 'Pending'
                                   AND `modified_date` = '{$date}'");
        $sched_count = count($query->result());

        return $sched_count;
    }  

    function fetch_notify_notification($mode,$date)
    {

        switch ($mode) {
            case 'value':
                # code...
                break;
            
            default:
                # code...
                break;
        }
        $query = $this->db->query("SELECT * FROM `batch_scheduled_sap` 
                                   WHERE 
                                   `coor_status` = 'Approved'
                                   AND `smd_status` = 'Approved'
                                   AND (
                                    `batching_plant` is null OR 
                                    `batching_plant` = '' OR
                                    `service_engr` is null OR 
                                    `service_engr` = '' OR
                                    `acctg_remarks` is null OR 
                                    `acctg_remarks` = '' OR
                                    `f_code1` is null OR 
                                    `f_code1` = '' OR
                                    `f_code2` is null OR 
                                    `f_code2` = '' OR
                                    `qa_rep` is null OR 
                                    `qa_rep` = '' OR
                                    `qc_remarks` is null OR 
                                    `qc_remarks` = ''
                                    )
                                   AND `modified_date` = '{$date}'
                                   ");
        $sched_count = count($query->result());

            return $sched_count;
    } 


    function getVol($date,$mode,$plant)
    {
        if($mode==1) :          
        $query = "SELECT SUM(`batch_vol`) as t_vol FROM `batch_scheduled_sap`
                                           WHERE 
                                           coor_status = 'Approved' 
                                           AND smd_status = 'Approved' 
                                           AND (`design_status` <> 'Insert' AND `design_status` <> 'For Confirmation' AND `design_status` <> 'Pending') 
                                           AND modified_date = '{$date}'
                                           AND `batching_plant` = '{$plant}'";
        elseif ($mode==2) :
        $query = "SELECT SUM(`batch_vol`) as t_vol FROM `batch_scheduled_sap`
                                           WHERE 
                                           coor_status = 'Approved' 
                                           AND smd_status = 'Approved' 
                                           AND design_status = 'Insert' 
                                           AND modified_date = '{$date}'
                                           AND `batching_plant` = '{$plant}'";
        elseif ($mode==3) :
        $query = "SELECT SUM(`batch_vol`) as t_vol FROM `batch_scheduled_sap`
                                           WHERE 
                                           coor_status = 'Approved' 
                                           AND smd_status = 'Approved' 
                                           AND design_status = 'For Confirmation' 
                                           AND modified_date = '{$date}'";
        //for ajax fetch booking only
        elseif ($mode==4) :
        $query = "SELECT SUM(`batch_vol`) as t_vol FROM `batch_scheduled_sap`
                                           WHERE 
                                           coor_status = 'Approved' 
                                           AND smd_status = 'Approved' 
                                           AND (design_status = 'For Confirmation' OR design_status = 'Okay' OR design_status = 'Insert')
                                           AND modified_date = '{$date}'";
        //For mobile dps query only
        elseif ($mode==5) :
        $query = "SELECT SUM(`batch_vol`) as t_vol FROM `batch_scheduled_sap`
                                           WHERE 
                                           coor_status = 'Approved' 
                                           AND smd_status = 'Approved' 
                                           AND `batching_plant` = '{$plant}'
                                           AND (design_status = 'For Confirmation' OR design_status = 'Okay' OR design_status = 'Insert' OR design_status = 'Re-Sched')
                                           AND modified_date = '{$date}'";
        //for re-sched schedules - added april 28, 2016
        elseif ($mode==6) :
        $query = "SELECT SUM(`batch_vol`) as t_vol FROM `batch_scheduled_sap`
                                           WHERE 
                                           coor_status = 'Approved' 
                                           AND smd_status = 'Approved' 
                                           AND design_status = 'Re-Sched' 
                                           AND modified_date = '{$date}'
                                           AND `batching_plant` = '{$plant}'";
        endif;
        $excquery = $this->db->query($query);
        $vol=0;
        if($excquery->num_rows()>0){
            $row = $excquery->row(); 
            $vol = $row->t_vol;
            
            return $vol;
        }
        else{

            return $vol;
        }
    }

    function get_dpsnotes($id,$user)
    {
        
        $query = $this->db->query(
                "SELECT note_" . $user . " as note FROM `batch_scheduled_sap` WHERE `o202_id` = '{$id}' ");

            return $query->result_array();
    }

    function update_dpsnote($id,$user,$note)
    {
             $query = $this->db->query("UPDATE `batch_scheduled_sap` SET `note_" .$user. "` ='{$note}' WHERE o202_id = '{$id}' ");
    }

    function get_holidate()
    {
        $query = $this->db->query(
                "SELECT `holidate` as hday FROM `holiday_ref` WHERE `status` = 'ACTIVE' ");

            return $query->result();
       
    }

    function get_holidays()
    {
        $query = $this->db->query("SELECT * FROM `holiday_ref` ORDER BY holidate");

            return $query->result();
       
    }

    function update_holiday($id,$status)
    {

        $query = $this->db->query("UPDATE `holiday_ref` SET `status`='{$status}' WHERE `holidate` = '{$id}' ");
    }

    function add_holiday($date)
    {
        $query = $this->db->query("SELECT * FROM `holiday_ref` WHERE `holidate` = '{$date}' ");

        //var_dump($query->num_rows()); exit();
       
        if($query->num_rows() > 0){
            return 'exist';
        }
        if($query->num_rows() == 0){

            $query2 = $this->db->query("INSERT INTO `holiday_ref`
                                   (`holidate`,`status`)
                                   VALUES
                                   ('{$date}','ACTIVE') ");
                                   
            return 'inserted';
        }

        
    }

    function get_customer_names()
    {
        // $query = $this->db->query("SELECT DISTINCT customer_name,`o5_id` FROM `jlr_customers` WHERE `activity_status`='ACTIVE' ORDER BY customer_name ");
        // $query = $this->db->query("SELECT DISTINCT customer_name,`o5_id` FROM `jlr_customers_sap` WHERE `activity_status`='ACTIVE' ORDER BY customer_name ");
        // $query = $this->db->query("SELECT DISTINCT customer_name,cust_code FROM `jlr_customers_sap` WHERE `activity_status`='ACTIVE' ORDER BY customer_name ");
        // $query = $this->db->query("SELECT DISTINCT customer_name,`o5_id` FROM jlr_customers 
        //                             UNION ALL
        //                             SELECT DISTINCT customer_name,`o5_id` FROM jlr_customers_sap GROUP BY customer_name ORDER BY customer_name  ASC");
        $query = $this->db->query("SELECT DISTINCT c.customer_name FROM(
                                    SELECT DISTINCT a.customer_name,a.o5_id FROM jlr_customers a
                                    UNION ALL
                                    SELECT DISTINCT b.customer_name,b.o5_id FROM jlr_customers_sap b) c GROUP BY c.customer_name ORDER BY c.customer_name  ASC");


        return $query->result();
    }

    function get_customer_names2()
    {
       
        $query = $this->db->query("SELECT DISTINCT C.cust_name as customer_name FROM (
                    SELECT a.cust_code,a.cust_name FROM batch_scheduled a GROUP BY a.cust_name 
                    UNION all
                    SELECT b.cust_code,b.cust_name FROM batch_scheduled_sap b GROUP BY b.cust_name )
                    AS C ORDER BY C.cust_name;");


        return $query->result();
    }

    function get_cust_info($cust_id)
    {
        $query = $this->db->query("SELECT * FROM `jlr_customers` WHERE `o5_id` = '{$cust_id}' ");
        if($query->num_rows() > 0){
                    $customer['result'] = $query;
                    $customer['rowcount'] = $query->num_rows();
                    $customer['view'] = 'dps/maintenance/custinfo';
                    $customer['salesengg'] = $this->dps_model->get_salesengg_list();
        }

        return  $customer;
    }

    function update_customer_info($id,$cust_name,$cust_add,$billing_add,$contact_num,$sales_engg)
    {
        $query = $this->db->query("UPDATE `jlr_customers`
                                   SET 
                                   `customer_name`='{$cust_name}',
                                   `customer_address`='{$cust_add}',
                                   `billing_address`='{$billing_add}',
                                   `contact_number`='{$contact_num}',
                                   `sales_id`='{$sales_engg}'
                                   WHERE 
                                   `o5_id` = '{$id}' 
                                   ");
    }

    function insert_customer_info($cust_name,$cust_add,$billing_add,$contact_num,$sales_engg)
    {
        $data = array(
               'customer_name'      => $cust_name,
               'customer_address'   => $cust_add,
               'billing_address'    => $billing_add,
               'contact_number'     => $contact_num,
               'sales_id'     => $sales_engg
            );

            $this->db->insert('jlr_customers', $data);
    }

    function get_proj_info($proj_id)
    {
        $query = $this->db->query("SELECT * FROM `rmc_project_list`,`rmc_project_contacts`,`rmc_project_qc` WHERE `o8_id` = '{$proj_id}' AND rmc_project_contacts.project_id = '{$proj_id}' AND rmc_project_qc.project_id = '{$proj_id}' ");
        if($query->num_rows() > 0){
                    $project['result'] = $query;
                    $project['rowcount'] = $query->num_rows();
                    $project['view'] = 'dps/maintenance/projinfo';
                    //$project['contacts'] = $this->dps_model->get_proj_contacts($proj_id);
        }

        return  $project;
    }

    function get_proj_contacts($id)
    {
        $query = $this->db->query("SELECT * FROM `rmc_project_contacts` WHERE `project_id` = '{$id}' ");
        return $query->result();
    }

    function get_proj_qc($id)
    {
        $query = $this->db->query("SELECT * FROM `rmc_project_qc` WHERE `project_id` = '{$id}' ");
        return $query->result();
    }

    function update_project_info($id,$proj_name,$proj_loc)
    {
        $query = $this->db->query("UPDATE `rmc_project_list`
                                   SET 
                                   `project_name`='{$proj_name}',
                                   `project_location`='{$proj_loc}'
                                   WHERE 
                                   `o8_id` = '{$id}' 
                                   ");
    }

    function update_project_contacts($id,$owner,$owner_num,$engr,$engr_num,$acctg,$acctg_num,$witness,$witness_num)
    {
        $query = $this->db->query("UPDATE `rmc_project_contacts`
                                   SET 
                                   `owner_name`='{$owner}',
                                   `owner_contact`='{$owner_num}',
                                   `engineer_name`='{$engr}',
                                   `engineer_contact`='{$engr_num}',
                                   `acctg_name`='{$acctg}',
                                   `acctg_contact`='{$acctg_num}',
                                   `witness_name`='{$witness}',
                                   `witness_contact`='{$witness_num}'
                                   WHERE 
                                   `project_id` = '{$id}' 
                                   ");
    }

    function update_project_qc($id,$samp_standard,
                               $samp_others,$samp_cylinders,
                               $samp_cubic,$curing_asite,
                               $curing_ajlr,$testing_jlr,
                               $testing_extlab,$testing_jlr7,
                               $testing_jlr14,$testing_jlr28,
                               $testing_colab,$testing_colabname,
                               $testing_extlab7,$testing_extlab14,
                               $testing_extlab28,$witness,
                               $witness_consultant,$witness_consultant_num)
    {
        $query = $this->db->query("UPDATE `rmc_project_qc`
                                   SET 
                                   `samp_standard`='{$samp_standard}',
                                   `samp_others`='{$samp_others}',
                                   `oth_cyl`='{$samp_cylinders}',
                                   `oth_m3`='{$samp_cubic}',
                                   `curing_asite`='{$curing_asite}',
                                   `curing_ajlr`='{$curing_ajlr}',
                                   `test_jlr`='{$testing_jlr}',
                                   `test_extlab`='{$testing_extlab}',
                                   `test_jlr_7`='{$testing_jlr7}',
                                   `test_jlr_14`='{$testing_jlr14}',
                                   `test_jlr_28`='{$testing_jlr28}',
                                   `ex_lab`='{$testing_colab}',
                                   `co_elab`='{$testing_colabname}',
                                   `test_elab_7`='{$testing_extlab7}',
                                   `test_elab_14`='{$testing_extlab14}',
                                   `test_elab_28`='{$testing_extlab28}',
                                   `witness_presence`='{$witness}',
                                   `consultant_name`='{$witness_consultant}',
                                   `consultant_num`='{$witness_consultant_num}'
                                   WHERE 
                                   `project_id` = '{$id}' 
                                   ");
    }   

    function get_clientcount($mode,$date,$plant)
    {
        switch ($mode) {

            //7am to 12 noon schedule
            case '1':
                $time_mode = "(modified_time >= '0600' AND modified_time <= '1245')";
            break;
            
            //1pm to 8 pm schedule
            case '2':
                $time_mode = "(modified_time >= '1300' AND modified_time <= '2045')";
            break;
            
            //9pm to 12 midnight schedule
            case '3':
                $time_mode = "(modified_time >= '2100' AND modified_time <= '2445')";
            break;
        }

        $query =  $query = $this->db->query("SELECT
                                            *
                                            FROM `batch_scheduled_sap` 
                                            WHERE 
                                            modified_date = '{$date}' 
                                            AND batching_plant = '{$plant}' 
                                            AND " . $time_mode .
                                            " AND (design_status = 'Okay' OR design_status = 'Insert' OR design_status = 'Re-Sched')
                                            AND (coor_status = 'Approved' AND smd_status = 'Approved')
                                            ");
        
        
            $client_count['result'] = $query;
            $row = $query->row(); 
            $client_count['count'] = $query->num_rows();
            $client_count['view'] = 'dps/reports/aggsummary';
            return $client_count;
        
        
    } 


    function get_signature($date,$plant)
    {
        $query = $this->db->query("SELECT * FROM `dps_timestamps` WHERE `date` = '{$date}' ");
        return $query->result();

    }

    
    function update_timestamps($date,$initial,$mode)
    {
        //check mode
        $now = date("Y-m-d h:i:s");
        /* MODE
            1 - RMCC  2 - PS  3 - QA   4 - ACCTG   5 - SMD
        */

        switch ($mode) {
                case '1':
                    $append_query = "`rmcc_init` = '{$initial}',`rmcc_time` = '{$now}'";
                    break;
                
                case '2':
                    $append_query = "`ps_init` = '{$initial}',`ps_time` = '{$now}'";
                    break;

                case '3':
                    $append_query = "`qa_init` = '{$initial}',`qa_time` = '{$now}'";
                    break;

                case '4':
                    $append_query = "`acctg_init` = '{$initial}',`acctg_time` = '{$now}'";
                    break;

                case '5':
                    $append_query = "`smd_init` = '{$initial}',`smd_time` = '{$now}'";
                    break;
            }

        //check if date is in the database if there is, then update the fields
        $query = $this->db->query("SELECT * FROM `dps_timestamps` WHERE `date` = '{$date}' ");
        
        if($query->num_rows() > 0){
            //update
            $query1 = $this->db->query("UPDATE `dps_timestamps` 
                                       SET "
                                       . $append_query .
                                       " WHERE
                                       `date` = '{$date}' 
                                       ");
        }else{
            //insert
             $query1 = $this->db->query("INSERT INTO `dps_timestamps` (`date`) VALUES ('{$date}') ");
             $query1 = $this->db->query("UPDATE `dps_timestamps` 
                                       SET "
                                       . $append_query .
                                       " WHERE
                                       `date` = '{$date}' 
                                       ");
        }

        
    }

    function check_form_num($value,$form)
    {
        switch ($form) {
            case 'form1':
                $form_type = '1';
                break;
            case 'form1a':
                $form_type = '1A';
                break;
        }
        
        
        $query = $this->db->query("SELECT `form_no` FROM `batch_scheduled_sap` WHERE `form_no` = '{$value}' AND `form_type` =  '{$form_type}' ");
        return $query->num_rows();
        
    }

    function get_formnum_details($form_num,$form)
    {
        switch ($form) {
            case 'form1':
                $form_type = '1';
                break;
            case 'form1a':
                $form_type = '1A';
                break;
        }

        $query = $this->db->query("SELECT * FROM `batch_scheduled_sap` WHERE `form_no` = '{$form_num}' AND `form_type` = '{$form_type}' ");
        return $query->result();
    }

    function count_design_status($date,$mode,$plant)
    {
        switch ($mode) {
            case '1':
                //query okay design status
                $query = "SELECT * FROM `batch_scheduled_sap`
                           WHERE 
                           coor_status = 'Approved' 
                           AND smd_status = 'Approved' 
                           AND `design_status` = 'Okay' 
                           AND modified_date = '{$date}'
                           AND `batching_plant` = '{$plant}'";
                break;
            
            case '2':
                //query insert design status
                $query = "SELECT * FROM `batch_scheduled_sap`
                           WHERE 
                           coor_status = 'Approved' 
                           AND smd_status = 'Approved' 
                           AND `design_status` = 'Insert' 
                           AND modified_date = '{$date}'
                           AND `batching_plant` = '{$plant}'";
                break;

            case '3':
                //query re-sched design status
                $query = "SELECT * FROM `batch_scheduled_sap`
                           WHERE 
                           coor_status = 'Approved' 
                           AND smd_status = 'Approved' 
                           AND `design_status` = 'Re-Sched' 
                           AND modified_date = '{$date}'
                           AND `batching_plant` = '{$plant}'";
                break;
        }

        $excquery = $this->db->query($query);
        $cnt_status = 0;
        if($excquery->num_rows()>0){
            $cnt_status = $excquery->num_rows(); 
            return $cnt_status;
        }
        else{
            return $cnt_status;
        }
    }

    function fetch_dob($date_tom){
        $query = $this->db->query("SELECT * FROM `batch_scheduled_sap`
                                           WHERE 
                                           coor_status = 'Approved' 
                                           AND smd_status = 'Approved' 
                                           AND (`design_status` = 'Insert' OR `design_status` = 'Okay' OR `design_status` = 'Re-Sched') 
                                           AND modified_date = '{$date_tom}'
                                           ORDER BY `modified_time` ");

                if($query->num_rows() > 0){
                    $dob['result'] = $query;
                    $dob['rowcount'] = $query->num_rows();
                    $dob['volume'] = $this->dps_model->get_dob_vol($date_tom);
                    $dob['view'] = 'dps/reports/dpsreport_dob';
                }
                else{
                    $dob['date'] = $date_tom;
                    $dob['volume'] = 0;
                    $dob['message'] = 'There are NO Scheduled Pourings as of this moment';
                    $dob['view'] = 'dps/nobookings';
                    $dob['confirmpage'] = 'dob';
                }
                return $dob;
    }

    function fetch_dpsfaxable($date){
        $query = $this->db->query("SELECT
                        `project_id` as proj_id,
                        `proj_name`,
                        `proj_address`,
                        `cust_name`,
                        `book_psi` as psi,
                        `book_cd` as cd,
                        `book_msa` as msa,
                        `book_sp` as sp,
                        `batch_vol`,
                        `qa_rep` as q,
                        `f_code1`,
                        `c1`.`description` as f_desc/*,
                        batch_scheduled_sap.f_code2,
                        batch_scheduled.batching_plant*/
                        FROM `batch_scheduled_sap`, `concrete060716` as `c1`
                        WHERE f_code1 = `c1`.`id`
                        AND coor_status = 'Approved' 
                        AND smd_status = 'Approved' 
                        AND (`design_status` = 'Insert' OR `design_status` = 'Okay' OR `design_status` = 'Re-Sched')
                                           AND modified_date = '{$date}'
                                           ORDER BY `modified_time` ");

                if($query->num_rows() > 0){
                    $dob['result'] = $query;
                    $dob['rowcount'] = $query->num_rows();
                    $dob['volume'] = 0;
                    $dob['view'] = 'dps/reports/dpsreport_fax';
                }
                else{
                    $dob['date'] = $date;
                    $dob['volume'] = 0;
                    $dob['message'] = 'There are NO Scheduled Pourings as of this moment';
                    $dob['view'] = 'dps/nobookings';
                    $dob['confirmpage'] = 'dob';
                }
                return $dob;
    }

    function get_dob_vol($date){
        $query = ("SELECT SUM(`batch_vol`) as t_vol FROM `batch_scheduled_sap` 
                    WHERE 
                    coor_status = 'Approved' 
                    AND smd_status = 'Approved' 
                    AND (`design_status` = 'Insert' OR `design_status` = 'Okay' OR `design_status` = 'Re-Sched') 
                    AND modified_date = '{$date}' ORDER BY `modified_time` ");

        $excquery = $this->db->query($query);
        $vol=0;
        if($excquery->num_rows()>0){
            $row = $excquery->row(); 
            $vol = $row->t_vol;
            
            return $vol;
        }else{
            return $vol;
        }
    }

    //FOR DESIGN MAINTENANCE
    function insert_new_strength($value,$unit){
        if($unit == 'flex'){
            $code = $value . ' fx';      
        }else{
            $code = $value;
        }

        $query = $this->db->query("INSERT INTO `rmc_strength_list` (`strength`,`code`,`type`) VALUES ('{$value}','{$code}','{$unit}') ");
        if($query){
            return "success";
        }else{
            return "error";
        }
    }

    function insert_new_aggregates($value,$code){

        $query = $this->db->query("INSERT INTO `rmc_msa_list` (`name`,`code`) VALUES ('{$value}','{$code}') ");
        if($query){
            return "success";
        }else{
            return "error";
        }
    }

    function insert_new_slump($value,$code){

        $query = $this->db->query("INSERT INTO `rmc_slump_list` (`slump`,`code`) VALUES ('{$value}','{$code}') ");
        if($query){
            return "success";
        }else{
            return "error";
        }
    }

    function insert_new_pouringtype($value,$code){

        $query = $this->db->query("INSERT INTO `pouring_type_ref` (`Type`,`Status`) VALUES ('{$value}','{$code}') ");
        if($query){
            return "success";
        }else{
            return "error";
        }
    }

    function insert_new_structures($code){

        $query = $this->db->query("INSERT INTO `structures_ref` (`struct_name`) VALUES ('{$code}') ");
        if($query){
            return "success";
        }else{
            return "error";
        }
    }

    function set_manager_status($id,$status,$plant,$date)
    {
        if($plant == '' AND $date == ''){
            $query = $this->db->query("UPDATE `batch_scheduled_sap` SET `manager_status` = '{$status}' WHERE `o202_id` = '{$id}' ");
        }else{
            $query = $this->db->query("UPDATE `batch_scheduled_sap` SET `manager_status` = '{$status}' WHERE `o202_id` = '{$id}' AND `batching_plant` = '{$plant}' AND `modified_date` = '{$date}' ");
        }
        
    }

    function set_revisionstatus($id){
        $query = $this->db->query("UPDATE `batch_scheduled_sap` SET `revision_status` = '' WHERE `o202_id` = '{$id}' ");
    }

    function check_manager_approval($date,$batching_plant)
    {
        $query = $this->db->query("SELECT * FROM `batch_scheduled_sap` 
                                    WHERE 
                                    coor_status = 'Approved' 
                                    AND smd_status = 'Approved' 
                                    AND (`design_status` = 'Insert' OR `design_status`= 'Okay') 
                                    AND modified_date = '{$date}'
                                    AND `batching_plant` = '{$batching_plant}'
                                    AND `manager_status` = 'Unapproved'
                                    ORDER BY `design_status`,`modified_time` 
                                    ");
        return $query->num_rows();
    }

    function update_schedate_by_searchdesign($id,$date)
    {
        $query = $this->db->query("UPDATE `batch_scheduled_sap` SET `modified_date` = '{$date}', `f_code1` = 0, `f_code2` = 0 WHERE `o202_id` = '{$id}' ");
    }

    function check_import_exist($id)
    {
        $query = $this->db->query("SELECT * FROM `ERP2Plant_Projects` WHERE DpsID = '{$id}' AND DPSid = '{$id}' ");
        if ($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }

    }

    function import_approved_bookings($id)
    {
        /*
        $query = $this->db->query("INSERT INTO Batch_Request (SO_No,DPSid,Product_Code,Cust_Name,Proj_Name,Proj_Address,Batch_Vol,Structure,Pour_Type,ProjLastModiDateTime)
                                SELECT 
                                batch_scheduled.o202_id,
                                batch_scheduled.o202_id,
                                SUBSTRING(batch_scheduled.f_code1,3),
                                batch_scheduled.cust_name,
                                batch_scheduled.proj_name,
                                batch_scheduled.proj_address,
                                batch_scheduled.batch_vol,
                                batch_scheduled.structure,
                                batch_scheduled.pour_type,
                                CONCAT(batch_scheduled.modified_date,' ',MID(batch_scheduled.modified_time,1,2),':',MID(batch_scheduled.modified_time,3,2),':','00')
                                FROM batch_scheduled WHERE batch_scheduled.o202_id = '{$id}' ");
        */
        $query = $this->db->query("INSERT INTO ERP2Plant_Projects (DpsID,CustID,CustName,ProjCode,ProjDesc,Volume,DesignMix,ProjLastModiDateTime,ProjAddr,Structure,PouringType)
                                SELECT 
                                batch_scheduled_sap.o202_id,
                                batch_scheduled_sap.client_id,
                                batch_scheduled_sap.cust_name,
                                batch_scheduled_sap.project_id,
                                batch_scheduled_sap.proj_name,
                                batch_scheduled_sap.batch_vol,
                                SUBSTRING(batch_scheduled_sap.f_code1,3),
                                CONCAT(batch_scheduled_sap.modified_date,' ',MID(batch_scheduled_sap.modified_time,1,2),':',MID(batch_scheduled_sap.modified_time,3,2),':','00'),
                                batch_scheduled_sap.proj_address,
                                batch_scheduled_sap.structure,
                                batch_scheduled_sap.pour_type
                                FROM batch_scheduled_sap WHERE batch_scheduled_sap.o202_id = '{$id}' ");
    }

    function update_imported_bookings($id)
    {
        /*
        $query = $this->db->query("UPDATE Batch_Request
                            INNER JOIN
                            batch_scheduled
                            ON 
                            Batch_Request.SO_No = batch_scheduled.o202_id
                            SET 
                            Batch_Request.Product_Code = SUBSTRING(batch_scheduled.f_code1,3),
                            Batch_Request.Cust_Name = batch_scheduled.cust_name,
                            Batch_Request.Proj_Address = batch_scheduled.proj_address,
                            Batch_Request.Batch_Vol = batch_scheduled.batch_vol,
                            Batch_Request.Structure = batch_scheduled.structure,
                            Batch_Request.Pour_Type = batch_scheduled.pour_type,
                            Batch_Request.ProjLastModiDateTime = CONCAT(batch_scheduled.modified_date,' ',MID(batch_scheduled.modified_time,1,2),':',MID(batch_scheduled.modified_time,3,2),':','00')
                            WHERE Batch_Request.SO_No = '{$id}' ");  
        */
        $query = $this->db->query("UPDATE ERP2Plant_Projects
                            INNER JOIN
                            batch_scheduled_sap
                            ON 
                            ERP2Plant_Projects.DpsID = batch_scheduled_sap.o202_id
                            SET 
                            ERP2Plant_Projects.DesignMix = SUBSTRING(batch_scheduled_sap.f_code1,3),
                            ERP2Plant_Projects.CustID = batch_scheduled_sap.client_id,
                            ERP2Plant_Projects.CustName = batch_scheduled_sap.cust_name,
                            ERP2Plant_Projects.ProjCode = batch_scheduled_sap.project_id,
                            ERP2Plant_Projects.ProjDesc = batch_scheduled_sap.proj_name,
                            ERP2Plant_Projects.Volume = batch_scheduled_sap.batch_vol,
                            ERP2Plant_Projects.ProjAddr = batch_scheduled_sap.proj_address,
                            ERP2Plant_Projects.Structure = batch_scheduled_sap.structure,
                            ERP2Plant_Projects.PouringType = batch_scheduled_sap.pour_type,
                            ERP2Plant_Projects.ProjLastModiDateTime = CONCAT(batch_scheduled_sap.modified_date,' ',MID(batch_scheduled_sap.modified_time,1,2),':',MID(batch_scheduled_sap.modified_time,3,2),':','00')
                            WHERE ERP2Plant_Projects.DpsID = '{$id}' ");  
    }

    function insert_formula($id)
    {
        $this->db->query("INSERT INTO mix_design (Product_Code,code,Specification,Description,Psi,Msa,C_Days,Slump,Slump_Value,Group_Qlt)
                                    SELECT `formID`, `id`,`formulacode`,`description`,`psi`,`msa`,`curing`,`slump`,`cslump`,`concClass`
                                    FROM concrete
                                    WHERE id = '{$id}' ");
        
    }

    function update_user_pass($id,$password){
        $query = $this->db->query("UPDATE `jlr_program_users` SET `user_password` = AES_ENCRYPT('{$password}','jlrmaiev87') WHERE `employee_id` = '{$id}' ");
    }

    function update_user_info($id,$first_name,$last_name){
        $query = $this->db->query("UPDATE `jlr_employees` SET `first_name` = '{$first_name}',`last_name` = '{$last_name}' WHERE `o1_id` = '{$id}' ");
        return $query;
    }

    function unapproved_by_smd($id){
        $query = $this->db->query("UPDATE `batch_scheduled_sap` SET `smd_status` = 'Unapproved' WHERE `o202_id` = '{$id}' ");
        return $query;
    }

    //added by WBSOLON Nov 19,2018
    function prepaid_by_smd($id){
        //$query = $this->db->query("UPDATE `batch_scheduled_sap` SET `proj_code` = '2' WHERE `o202_id` = '{$id}' ");
        $query = $this->db->query("UPDATE `batch_scheduled_sap` SET qc_remarks= concat(qc_remarks,'-Additional Volume'),`proj_code` = '2' WHERE `o202_id` = '{$id}' ");
        return $query;
    }


    function get_pendingscheds(){
        $year_now = date('Y');
        $query = $this->db->query("SELECT * FROM `batch_scheduled_sap`
                                           WHERE `design_status` = 'Pending' AND YEAR(modified_date) = '{$year_now}'
                                           ORDER BY `modified_date` DESC,`modified_time` ");

                if($query->num_rows() > 0){
                    $pendingsched['result'] = $query;
                    $pendingsched['rowcount'] = $query->num_rows();
                    $pendingsched['designstatus'] = $this->functionlist->getDesignStatus();
                    $pendingsched['view'] = 'dps/pendingsched_table';
                }
                else{
                    $pendingsched['rowcount'] = $query->num_rows();
                }
                return $pendingsched;
    }

    function update_pendingscheds($id,$date,$status){
        $query = $this->db->query("UPDATE `batch_scheduled_sap` SET `modified_date` = '{$date}',`design_status` = '{$status}' WHERE `o202_id` = '{$id}' ");
        return $this->db->affected_rows();
    }

    function ajax_fetch_booking_contacts($sched_id){
        $query = $this->db->query("SELECT * FROM `batch_scheduled_sap` WHERE `o202_id` = '{$sched_id}'");
        return $query;
        //$dob['result'] = $query;
    }

    function getadvance_book($sales_code){
        //get tomorrows date
        $today = mktime(0,0,0,date("m"),date("d")+2,date("Y"));
        $dateToday = date("Y-m-d", $today);
        $tomorrow = mktime(0,0,0,date("m"),date("d")+4,date("Y"));
        $dateTom = date("Y-m-d", $tomorrow);

        if ($sales_code == 'M2'){ //'M3 to M2 - request by smd manager - htsesaldo 06/13/19'
            $query = $this->db->query(
                "SELECT * 
                FROM `batch_scheduled_sap`
                WHERE 
                    `modified_date` BETWEEN '{$dateToday}' AND '{$dateTom}' AND
                    `design_status` <> 'Cancelled'
                ORDER BY modified_date,modified_time
                ");
        }else{
            $query = $this->db->query(
                "SELECT * 
                FROM `batch_scheduled_sap`
                WHERE 
                    `modified_date` BETWEEN '{$dateToday}' AND '{$dateTom}' AND
                    `design_status` <> 'Cancelled' AND special_se = '{$sales_code}'
                ORDER BY modified_date,modified_time
                ");
        }
        
        //var_dump($query);exit();

        return $query;
    }

    function get_sales_code($emp_id){
        $query = $this->db->query("SELECT code FROM `reps_sle_ref` WHERE `emp_id` = '{$emp_id}' ");
        if($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return "none";
        }
        
    }

    // function get_priority_num($sched_date,$plant){
    //     $query = $this->db->query("SELECT priority_no FROM `batch_scheduled_sap` WHERE `modified_date` = '{$sched_date}' AND `batching_plant` = '{$plant}' ORDER BY priority_no DESC Limit 1");
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }
    //     else{
    //         return 0;
    //     }
    // }

    function gen_priority($sched_date,$plant){
        $query = $this->db->query("SELECT o202_id FROM `batch_scheduled_sap` WHERE modified_date = '{$sched_date}' AND batching_plant='{$plant}' AND (design_status = 'Okay' OR design_status = 'Insert') ORDER BY design_status DESC,time_encoded");
        if($query->num_rows() > 0){
            $res =  $query->result_array();

            $ctr = 1;
            foreach ($res as $id_val) {
                
                $data = array(
                   'priority_no' => $ctr
                );
                //update the id
                $this->dps_model->update_gen_priority($data,$id_val['o202_id']);

                $ctr ++;
            }

            $last_ok_prio = $ctr;
        }
        else{
            //do nothing
            return 0;
        }

        //generate for the resched status
        $this->gen_resched_priority($sched_date,$plant,$last_ok_prio);
    }

    function update_gen_priority($data,$id){
        $this->db->where('o202_id', $id);
        $this->db->update('batch_scheduled_sap',$data); 
    }

    function gen_resched_priority($sched_date,$plant,$last_prio){
        $query = $this->db->query("SELECT o202_id FROM `batch_scheduled_sap` WHERE modified_date = '{$sched_date}' AND batching_plant='{$plant}' AND design_status = 'Re-sched' ORDER BY time_encoded");
        if($query->num_rows() > 0){
            $res =  $query->result_array();

            $ctr = $last_prio;
            foreach ($res as $id_val) {
                
                $data = array(
                   'priority_no' => $ctr
                );
                //update the id
                $this->dps_model->update_gen_priority($data,$id_val['o202_id']);

                $ctr ++;
            }
            
        }
        else{
            //do nothing
            return 0;
        }
    }

    function ajax_getproject_contract($project_id){
        $query = $this->db->query("SELECT contract_no FROM `rmc_project_list` WHERE o8_id = '{$project_id}'");
        if($query->num_rows() > 0){
           foreach ($query->result() as $row)
            {
               $co_no =  $row->contract_no;
            }

            if($co_no == ''){
                return 0;
            }else{
                return $co_no;
            }
        }
        else{
            //do nothing
            return 0;
        }
    }


    // added by ralph for the weekly scheduler feature --> june 30, 2015

    function get_weekly_sched($sched_date){
        //$query = $this->db->query("SELECT * FROM `batch_scheduled_sap` WHERE modified_date = '{$date}' GROUP BY project_id order by o202_id limit 10 ");
        $query = $this->db->query("SELECT * FROM batch_scheduled_sap WHERE modified_date = '{$sched_date}' AND sched_status = 'waiting' order by batching_plant,queue_order ASC");
        
        if($query->num_rows() > 0){ 
            return $query->result_array();
        }
        else{
            //do nothing
            return $query->result_array();
        }
    }

    function get_w_sched($sched_date,$sales_code){
        //get data by date/sales code group by project and limit to 2 projects
        $query = $this->db->query("SELECT project_id FROM `batch_scheduled_sap` WHERE modified_date = '{$sched_date}' and special_se = '{$sales_code}' GROUP BY project_id order by o202_id limit 2 ");
        if($query->num_rows() > 0){
            foreach ($query->result() as $row)
            {
               $proj_id =  $row->project_id;
               $this->dps_model->get_w_projects($sched_date,$proj_id);
               
            }
        }
        else{
            //do nothing
            return $query->result_array();
        }
    }

    function get_w_projects($sched_date,$project_id)
    {
        $query = $this->db->query("SELECT o202_id as sched_id FROM `batch_scheduled_sap` WHERE modified_date = '{$sched_date}' and project_id ='{$project_id}' order by o202_id");
        foreach ($query->result() as $row)
        {
           $sched_id =  $row->sched_id;

           $this->dps_model->update_w_scheds_status('queued',$sched_id);
           
        }
    }
    
    function update_w_scheds_status($status,$sched_id){
        $data = array(
                'sched_status' => $status
        );

        $this->db->where('o202_id', $sched_id);
        $this->db->update('batch_scheduled_sap', $data);
    }

    function get_sales_rep(){
        $query = $this->db->query("SELECT code FROM `reps_sle_ref` WHERE status = 'active' ORDER BY code");
        return $query->result_array();
    }

    function update_w_scheds_waiting($sched_date){
        $query = $this->db->query("SELECT o202_id as sched_id FROM `batch_scheduled_sap` WHERE modified_date = '{$sched_date}' and sched_status is null");
        foreach ($query->result() as $row)
        {
           $sched_id =  $row->sched_id;

           $data = array(
                'sched_status' => 'waiting'
            );

            $this->db->where('o202_id', $sched_id);
            $this->db->update('batch_scheduled_sap', $data);
        }
    }

    function order_queue_list($sched_date){
        $query = $this->db->query("SELECT o202_id as sched_id FROM batch_scheduled_sap WHERE modified_date = '{$sched_date}' AND sched_status = 'queued' order by batching_plant,modified_time");
        
        $ctr = 1;
        foreach ($query->result() as $row)
        {
           $sched_id =  $row->sched_id;

           $data = array(
                'queue_order' => $ctr
            );

            $this->db->where('o202_id', $sched_id);
            $this->db->update('batch_scheduled_sap', $data);

            $ctr ++;
        }
    }

    function get_sales_rep_sched_count($sched_date,$sales_code){
        $query = $this->db->query("SELECT distinct project_id,special_se FROM `batch_scheduled_sap` WHERE sched_status = 'queued' and modified_date = '{$sched_date}' and special_se='{$sales_code}'");
        if($query->num_rows() < 2){
            return false;
        }else{
            return true;
        }
    }

    function check_if_queued($sched_date){
        $sales_reps = $this->dps_model->get_sales_rep();
        foreach ($sales_reps as $row) {
            $sales_code = $row['code'];
            if($this->dps_model->get_sales_rep_sched_count($sched_date,$sales_code) == true){
                //just do the loop
                return true;
            }else{
                return false;
                break;
            }
                
        }
    }

    function ajax_update_weekly_sched($sched_id,$queue_order,$sched_date){
        $data = array(
                'sched_status' => 'queued',
                'queue_order' => $queue_order,
                'modified_date' => $sched_date,
                'coor_status' => 'Approved'
            );

        $this->db->where('o202_id', $sched_id);
        $this->db->update('batch_scheduled_sap', $data);


        return true;
    }

    function ajax_update_weekly_sched_unapproved($sched_id){
        $data = array(
                'coor_status' => 'Unapproved'
            );

        $this->db->where('o202_id', $sched_id);
        $this->db->update('batch_scheduled_sap', $data);


        return true;
    }


    function ajax_get_weekly_waiting($sched_date){
        $query = $this->db->query("SELECT * FROM batch_scheduled_sap WHERE modified_date = '{$sched_date}' AND sched_status = 'waiting' ORDER BY o202_id DESC");
        return $query->result_array();
    }
    

    function ajax_get_weekly_sched_detail($sched_id){
        $query = $this->db->query("SELECT * FROM batch_scheduled_sap WHERE o202_id = '{$sched_id}'");
        return $query->result_array();
    }

    function ajax_override_waiting_list($sched_id){
        $data = array(
                'waiting_override' => '1'
        );

        $this->db->where('o202_id', $sched_id);
        $this->db->update('batch_scheduled_sap', $data);
    }

    //added by ralph 07-30-2015
    // for the saturday and sunday scheduler
    function isDateHoliday($strdate){
        $query = $this->db->query("SELECT holidate FROM `holiday_ref` WHERE holidate = '{$strdate}' and status = 'ACTIVE'");
        if($query->num_rows() > 0){
            //its a holiday
            return true;
        }else{
            //no its not a holiday
            return false;
        }
    }

    function get_project_list_contracts($year){
        $query = $this->db->query("SELECT * FROM jlr_project_combined WHERE YEAR(date_added) = '{$year}'");
        return $query->result_array();
    }

    function ajax_update_contract($id,$contract){
        $data = array(
                'contract_no' => $contract
        );

        $this->db->where('o8_id', $id);
        $this->db->update('rmc_project_list', $data);

        if($this->db->affected_rows() > 0){
            //success
            return 'ok';
        }else{
            //error
            return 'error';
        }
    }

    function pending_logger($data){
        $this->db->insert('dps_pending_log', $data);
    }

    function scheduler_logger($data){
        $this->db->insert('dps_scheduler_log', $data);
    }

    function check_sched_exist_inlog($sdate,$sid){
        $this->db->select("*",FALSE);
        $this->db->where('sched_date',$sdate);
        $this->db->where('sched_id',$sid);
        $query = $this->db->get('dps_scheduler_log');

        if ($query->num_rows() > 0)
        {
            //it exist
            $this->update_sched_logger_active($sdate,$sid);
            $res = 1;
        }else{
            //it doesnt exist
            $res = 1;
        }

        return $res;
    }

    function update_sched_logger_active($sdate,$sid){
        $this->db->set('active',0);
        $this->db->where('sched_date', $sdate);
        $this->db->where('sched_id', $sid);
        $this->db->update('dps_scheduler_log');

        if($this->db->affected_rows() > 0){
            //success
            return 'ok';
        }else{
            //error
            return 'error';
        }
    }


    /*
        all functions after this is for the contract feature
        author : ralph ceriaco
    */


    

    
    function get_last_contract_no($year,$month){
        $this->db->select("COUNT(contract_id) as contract_cnt",FALSE);
        $this->db->where('con_year', $year);
        $this->db->where('con_month', $month);
        $query = $this->db->get('jlr_contracts');

        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
              $cnt = $row->contract_cnt;
           }
        }else{
        }

        return $cnt;
        
    }

    function insert_contract($data){
        $this->db->insert('jlr_contracts', $data);
        $id = $this->db->affected_rows();

        return $id;
    }

    function insert_contract_details($data){
        $this->db->insert('jlr_contracts_details', $data);
        $id = $this->db->affected_rows();

        return $id;
    }

    function insert_project($data){

    }

    function get_last_project_no(){
        $this->db->select("project_id as last_project_id",FALSE);
        $this->db->order_by("project_id", "desc");
        $this->db->limit(1);
        $query = $this->db->get('jlr_projects');

        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
              $id = $row->last_project_id;
           }
        }else{
        }

        return $id;
    }

    function get_mobile_resched($date,$plant){
        /*SELECT sched_id,(SELECT batch_vol FROM batch_scheduled_sap WHERE o202_id = sched_id) as vol FROM `dps_scheduler_log`
        WHERE
        sched_date = '2016-05-03' AND
        plant = 'Plant 3' AND
        sched_status = 'Re-Sched' AND
        active = 1*/

        $this->db->select("sched_id,(SELECT batch_vol FROM batch_scheduled_sap WHERE o202_id = sched_id) as vol",FALSE);
        $this->db->where("sched_date",$date);
        $this->db->where("plant",$plant);
        $this->db->where("sched_status",'Re-Sched');
        $this->db->where("active",1);
        $query = $this->db->get('dps_scheduler_log');

        // $excquery = $this->db->query($query);
        // $vol=0;
        // if($excquery->num_rows()>0){
        //     $row = $excquery->row(); 
        //     $vol = $row->t_vol;
            
        //     return $vol;
        // }
        // else{

        //     return $vol;
        // }
        // 
        
        $res['count'] = 0;
        $res['volume'] = 0;

        if ($query->num_rows() > 0)
        {
            $res['count'] = $query->num_rows();
           foreach ($query->result() as $row)
           {
              $res['volume'] = $res['volume'] + $row->vol;
           }
        }else{
            $res['count'] = 0;
            $res['volume'] = 0;
        }

        return $res;
    }

    //added by ralph for the pump summary
    function get_clientcount_pump($mode,$date,$plant)
    {
        switch ($mode) {

            //7am to 12 noon schedule
            case '1':
                $time_mode = "(modified_time >= '0600' AND modified_time <= '1259')";
            break;
            
            //1pm to 8 pm schedule
            case '2':
                $time_mode = "(modified_time >= '1300' AND modified_time <= '2059')";
            break;
            
            //9pm to 12 midnight schedule
            case '3':
                $time_mode = "(modified_time >= '2100' AND modified_time <= '2359')";
            break;

            //9pm to 12 midnight schedule
            case '4':
                $time_mode = "(modified_time >= '0000' AND modified_time <= '0559')";
            break;
        }

        $query =  $query = $this->db->query("SELECT
                                            *
                                            FROM `batch_scheduled_sap` 
                                            WHERE 
                                            modified_date = '{$date}' 
                                            AND batching_plant = '{$plant}' 
                                            AND " . $time_mode .
                                            " AND (design_status = 'Okay' OR design_status = 'Insert' OR design_status = 'Re-Sched')
                                            AND (coor_status = 'Approved' AND smd_status = 'Approved')
                                            ");
        
        
            $client_count['result'] = $query;
            $row = $query->row();
            //$client_count['pump_plant'] = $plant;
            $client_count['count'] = $query->num_rows();
            $client_count['view'] = 'dps/reports/pumpsummary';
            return $client_count; 
    } 

    function GetTotalPump($date){
    

        $query = $this->db->query("SELECT SUM(batch_vol) AS overall_pump FROM batch_scheduled_sap 
                                            WHERE 
                                            modified_date = '{$date}' 
                                            AND (design_status = 'Okay' OR design_status = 'Insert' OR design_status = 'Re-Sched')
                                            AND (coor_status = 'Approved' AND smd_status = 'Approved')
                                                                                        AND pour_type IN ('PUMP 1','PUMP 2','PUMP 3','PUMP 4','PUMP 5','PUMP 6','PUMP 7','PUMP 8','PUMP 9','PUMP 10')");

        if ($query->num_rows() > 0){
            foreach($query->result() as $row){
                return $row->overall_pump;
            }
        }
        else {
            return 0;
        }
              
    }    


    //DEPRECATED 2020 -------- DO NOT USE ------------
    function get_for_batching2($date){

    $query = $this->db->query(
                "SELECT * 
                FROM `batch_scheduled_sap`
                WHERE `modified_date` = '{$date}' AND `design_status` <> 'Pending'
                ORDER BY `batching_plant`,`modified_time`");

        
        if($query->num_rows() > 0){
                    $schedule['result'] = $query;
                    $schedule['rowcount'] = $query->num_rows();

                    $schedule['view'] = 'dps/uploadbatching';
                    return $schedule;              
        }else{
            $schedule['view'] = 'dps/nobookings';
            $schedule['confirmpage'] = 'scheduler';
            return $schedule;
        }
    }
//DEPRECATED 2020 -------- DO NOT USE ------------
function get_for_batching($date){
	//$query = $this->db->query("SELECT * FROM `batch_scheduled_sap`");
    $query = $this->db->trans_start();
    /* for North */
    $query = $this->db->query("
        INSERT INTO dbo_batch_request (request_no, product_code, order_date, cust_code, cust_name, project_code, project_name, project_address, so_num, total_order_vol, machine_code, po_no, structure, pouring_type, pump_charge_no, vib_charge_no, contract_desc, status) 
        SELECT o202_id, f_code2, modified_date, client_id, cust_name, project_id, proj_name, proj_address, CONCAT(form_type,form_no), batch_vol, 'DP', po_no, structure, pour_type, pumpcharge_no, vibrator_no, contract_no, 'N'  
        FROM `batch_scheduled_sap` 
        WHERE coor_status = 'Approved' 
           AND smd_status = 'Approved' 
           AND (`design_status` <> 'For Confirmation')
           AND `design_status` <> 'Pending' 
           AND `modified_date` = '{$date}'
           AND batching_plant = 'Plant 3'
           AND plant_upload='F'");
    /* for South */
    $query = $this->db->query("
        INSERT INTO dbo_batch_request (request_no, product_code, order_date, cust_code, cust_name, project_code, project_name, project_address, so_num, total_order_vol, machine_code, po_no, structure, pouring_type, pump_charge_no, vib_charge_no, contract_desc, status) 
        SELECT o202_id, f_code1, modified_date, client_id, cust_name, project_id, proj_name, proj_address, CONCAT(form_type,form_no), batch_vol, 'DP', po_no, structure, pour_type, pumpcharge_no, vibrator_no, contract_no, 'N'  
        FROM `batch_scheduled_sap` 
        WHERE coor_status = 'Approved' 
           AND smd_status = 'Approved' 
           AND (`design_status` <> 'For Confirmation')
           AND `design_status` <> 'Pending' 
           AND modified_date = '{$date}'
           AND batching_plant = 'Plant 4'
           AND plant_upload='F'");
    /*
        $this->db->trans_start();
        $this->db->query("UPDATE `batch_scheduled` SET plant_upload='D' WHERE CONCAT(form_type,form_no)=dbo_batch_request.request_no");
        $this->db->trans_complete();
    */
    $query = $this->db->query("
        UPDATE batch_scheduled_sap SET plant_upload='D' WHERE EXISTS(SELECT request_no FROM dbo_batch_request WHERE modified_date = '{$date}') ");
    
    $query = $this->db->trans_complete();
	return 0;
    }


    
    
    //Added DISPLAY Batch Upload [9/10/2018] by:WBSOLON
    function get_batch_upload($date){
        
        // $query = $this->db->query(
        //         "SELECT * 
        //         FROM `batch_scheduled`
        //         WHERE `modified_date` = '{$date}' AND `design_status` <> 'Pending'
        //         ORDER BY `batching_plant`,`modified_time`");

        $date1 = str_replace('-', '/', $date);
        $date2 = date('Y-m-d',strtotime($date1 . "+2 days"));
        $date3 = date('Y-m-d',strtotime($date1 . "-1 days"));
        $query = $this->db->query(
                "SELECT * 
                FROM `batch_scheduled_sap`
                WHERE `modified_date` BETWEEN '{$date3}' AND '{$date2}' AND `design_status` <> 'Pending'
                ORDER BY `modified_date` ASC,`modified_time`,batching_plant  ");
                // -- ORDER BY `batching_plant` DESC,`modified_date` ASC,`modified_time` ");
                 

        if($query->num_rows() > 0){
            
            $upload['result'] = $query;
            $upload['rowcount'] = $query->num_rows();     
            $upload['view'] = 'dps/batch_view';
          
            return $upload;
                          
        }else{
            $upload['view'] = 'dps/nobookings';
            $upload['confirmpage'] = 'scheduler';

            return $upload;
        }

    }

      
    //For Batch_scheduled RESET Status to 'F'
    function update_upload_status($id){
        
        $query = $this->db->query("UPDATE batch_scheduled_sap SET plant_upload='F' WHERE o202_id = '{$id}'"); 

        return $this->db->affected_rows();
    }

    //FOR dbo_batch_request Insert or Update 
    function upsert_upload_status($id){
    
        //start transaction here
        $query = $this->db->trans_start();

        $query = $this->db->query("UPDATE batch_scheduled_sap SET plant_upload='D' WHERE o202_id = '{$id}' "); 
        
        $search = $this->db->query("SELECT * from dbo_batch_request a where request_no = '{$id}' ");
        //For Insert SELECT or for Update SELECT
        if ($search->num_rows() > 0) {
            $query = $this->db->query("UPDATE dbo_batch_request as t1,batch_scheduled_sap as t2
                SET 
                    t1.product_code     =   t2.f_code1 ,
                    t1.order_date       =   t2.modified_date, 
                    t1.cust_code        =   t2.client_id, 
                    t1.cust_name        =   t2.cust_name, 
                    t1.project_code     =   t2.project_id, 
                    t1.project_name     =   t2.proj_name, 
                    t1.project_address  =   t2.proj_address, 
                    t1.so_num           =   CONCAT(t2.form_type,t2.form_no), 
                    t1.total_order_vol  =   t2.batch_vol, 
                    t1.machine_code     =   'DP', 
                    t1.po_no            =   t2.po_no, 
                    t1.structure        =   t2.structure, 
                    t1.pouring_type     =   t2.pour_type, 
                    t1.pump_charge_no   =   t2.pumpcharge_no, 
                    t1.vib_charge_no    =   t2.vibrator_no, 
                    t1.contract_desc    =   t2.contract_no, 
                    t1.`status`         =   'N'
                WHERE (t1.request_no = t2.o202_id) and t2.o202_id = '{$id}' ");
        }else{
            $query = $this->db->query(" INSERT INTO dbo_batch_request (
                    request_no, product_code, order_date, cust_code, cust_name, project_code, project_name, project_address, so_num, total_order_vol, machine_code, po_no, structure, pouring_type, pump_charge_no, vib_charge_no, contract_desc, status) 
                SELECT o202_id, f_code1, modified_date, client_id, cust_name, project_id, proj_name, proj_address, CONCAT(form_type,form_no), batch_vol, 'DP', po_no, structure, pour_type, pumpcharge_no, vibrator_no, contract_no, 'N'  
                FROM `batch_scheduled_sap` 
                WHERE o202_id = '{$id}' ");

        }
        
        $query  = $this->db->trans_complete(); // if trans complete then it will committed else rollback ! no affected rows       
    }

        function update_schedate_by_searchdesign2($id,$date) {

        $query = $this->db->query("UPDATE batch_scheduled_sap SET
                    modified_date   =  '{$date}',
                    modified_time   = TIME_FORMAT(time(now()),'%H%m'),                                      
                    acctg_remarks   =  null,
                    batching_plant  =  null,
                    service_engr    =  null,
                    f_code1         =  0,
                    f_code2         =  0,
                    qa_rep          =  null,
                    qc_remarks      =  null,
                    coor_status     =  'Unapproved',
                    smd_status      =  'Unapproved',
                    manager_status  =  'Unapproved' 
                    where o202_id   =  '{$id}' ");

        return $this->db->affected_rows();
    }

    
    function update_prepaid($id,$acctg_notes){ 
        // $query = $this->db->query("SELECT * FROM batch_scheduled_sap WHERE o202_id ='{$id}' AND proj_code<>1 ");
         $query = $this->db->query("SELECT * FROM batch_scheduled_sap WHERE o202_id ='{$id}' AND (proj_code<>1 or proj_code is null) ");
            if ($query->num_rows() > 0){
                if($acctg_notes == 'FBP-PAID'){
                    $this->db->query(" UPDATE batch_scheduled_sap SET proj_code=1 WHERE o202_id = '{$id}' ");
                     return true;
                }

            }
   
    }




/*=======================================================================================================================================
    @MODEL
    XML METHOD QUERY
    08-29-2019 WBSOLON
=======================================================================================================================================*/
    function GenerateXML(){

    }

    function get_xml_data($id){

        $this->db->query("call sp_xml_transac_batch($id)");

        $this->db->select('*');
        $query = $this->db->get('rmc_xml_batch_temp');

        return $query->result_array();
    }

    function get_xml_data_details($id){
         //IF RETURN 0 THEN NO FORMULA
        $product_code = $this->GetProductCode($id);
        
        if(isset($product_code)){
             $this->db->query("call sp_xml_transac_batch_details($product_code)");
        }else{
            $this->db->query("call sp_xml_transac_batch_details(0)");
        }
        

        $this->db->select('*');
        $query = $this->db->get('rmc_xml_batch_details_temp');

        return $query->result_array();
    }

    function GetProductCode($id){
        // $this->db->select("IF(batching_plant='Plant 4',f_code1,f_code2) AS product_code");
        // $this->db->where('o202_id',$id);
        // $query  = $this->db->get('batch_scheduled');

        $query = $this->db->query("SELECT IF(batching_plant='Plant 4',f_code1,f_code2) AS product_code FROM batch_scheduled_sap WHERE o202_id = '{$id}' ");

        if ($query->num_rows() > 0){
            foreach($query->result() as $row){
                return $row->product_code;
            }
        }
        else {
            return 0;
        }
              
    }    

    function GetProductCode_f1($id){
        $this->db->select('f_code1');
        $this->db->where('o202_id',$id);
        $query  = $this->db->get('batch_scheduled_sap');

        foreach($query->result() as $row){
            return $row->f_code1;
        }
    }

    function GetProductCode_f2($id){
        $this->db->select('f_code2');
        $this->db->where('o202_id',$id);
        $query  = $this->db->get('batch_scheduled_sap');

        foreach($query->result() as $row){
            return $row->f_code2;
        }
    }

    function GetRemoteFile($id){

        $this->db->select("CONCAT(ftp_path,'/',ftp_filename,'.txt') AS target");
        $this->db->where('id',$id);
        $query = $this->db->get('rmc_xml_path_list');
        
        return $query->result();
    }
    function GetRemotePath($id){

        $this->db->select("ftp_path AS path");
        $this->db->where('id',$id);
        $query = $this->db->get('rmc_xml_path_list');
        
        return $query->result();
    }

    function GetLocalFile($id){

        $this->db->select("CONCAT(path,'/',filename,'.txt') AS target");
        $this->db->where('id',$id);
        $query = $this->db->get('rmc_xml_path_list');

        return $query->result();
    }

    function GetLocalPath($id){

        $this->db->select("path as path");
        $this->db->where('id',$id);
        $query = $this->db->get('rmc_xml_path_list');

        return $query->result();
    }

    function SetBatchTransaction($order_id,$file_name){

        $this->db->set('order_id', $order_id);
        $this->db->set('file_name', $file_name);
        $this->db->set('date', date("Y-m-d H:i:s"));
        $this->db->insert('rmc_xml_batch_transaction');
        
    }

    function SetIsGenerate($order_id,$file_name){
        $this->db->set('is_generate_xml', 1);
        $this->db->where('order_id', $order_id);
        $this->db->where('file_name', $file_name);
        $this->db->update('rmc_xml_batch_transaction');
    }

    function SetIsUpload($order_id,$file_name){
        $this->db->set('is_ftp_upload',1);
        $this->db->where('order_id', $order_id);
        $this->db->where('file_name', $file_name);
        $this->db->update('rmc_xml_batch_transaction');
    }   

    function SetPlantUpload($id){
        $this->db->set('plant_upload','D');
        $this->db->where('o202_id', $id);
        $this->db->update('batch_scheduled_sap');
        // $query = $this->db->query("UPDATE batch_scheduled SET plant_upload='F' WHERE o202_id = '{$id}'"); 
        // return $this->db->affected_rows();
    }

/*=======================================================================================================================================
    @MODEL
    END OF XML METHOD QUERY
=======================================================================================================================================*/







    
}

