<?php

define("TGT_DT",80);
define("TGT_PL",80);
define("TGT_BH",85);
define("TGT_BD",80);
define("TGT_TM",80);
define("TGT_PLR",95);
define("TGT_PUMP",95);
define("TGT_OA",85);
define("TGT_RG",85);

class DEU_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    function get_pending_major($mode)
    {
        /* MODE
            1 = pending major south
            2 = pending major north
            3 = pending running

        */

        switch ($mode) {
            case '1':
                $query = $this->db->query("SELECT * FROM deu_rep WHERE status!='COMPLETE' AND type='Major' AND location = 'S' ORDER BY date_in DESC, location ASC");
                
                if($query->num_rows() > 0){
                    $res['result'] = $query;
                    $res['rowcount'] = $query->num_rows();
                    return $res;
                }
                break;

            case '2':
                $query = $this->db->query("SELECT * FROM deu_rep WHERE status!='COMPLETE' AND type='Major' AND location ='N' ORDER BY date_in DESC");
                
                if($query->num_rows() > 0){
                    $res['result'] = $query;
                    $res['rowcount'] = $query->num_rows();
                    return $res;
                }
                break;
            
            case '3':
                $query = $this->db->query("SELECT * FROM deu_rep WHERE status!='COMPLETE' AND type='Running' ORDER BY date_in DESC, type ASC");
                
                if($query->num_rows() > 0){
                    $res['result'] = $query;
                    $res['rowcount'] = $query->num_rows();
                    return $res;
                }
                break;

            case '4':
                $query = $this->db->query("SELECT * FROM deu_rep WHERE STATUS!='COMPLETE' ORDER BY date_in, type, location ASC");
                
                if($query->num_rows() > 0){
                    $res['result'] = $query;
                    $res['rowcount'] = $query->num_rows();
                    return $res;
                }
                break;

            return $res;
            
        }
        
    } 

    function getQADsummary()
    {

        $qtDT = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'DT%' AND ( unit_cond != 'SOLD' AND unit_cond != 'JUNK' )";
        
        $qtPLQAD = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'PL%' AND (dept='QAD' OR dept='RMD') AND unit_cond!='SOLD'";
        $qtBH = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'BH%' AND (dept='QAD' OR dept='RMD') AND unit_cond!='SOLD'";
        $qtBD = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'BD%' AND unit_cond!='SOLD'";
        
        $qaDT = "SELECT unitcode FROM deu_units WHERE (unit_cond='OK' OR unit_cond='AV') AND unitcode LIKE 'DT%'";
        $qaPLQAD = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'PL%' AND (dept='QAD' OR dept='RMD') AND (unit_cond='OK' OR unit_cond='AV')";
        $qaBH = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'BH%' AND (dept='QAD' OR dept='RMD') AND (unit_cond='OK' OR unit_cond='AV')";
        $qaBD = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'BD%' AND (unit_cond='OK' OR unit_cond='AV')";
        
        $qdDT = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'DT%' AND unit_cond='DOWN'";
        $qdPLQAD = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'PL%' AND (dept='QAD'  OR dept='RMD') AND unit_cond='DOWN'";
        $qdBH = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'BH%' AND (dept='QAD' OR dept='RMD') AND unit_cond='DOWN'";
        $qdBD = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'BD%' AND unit_cond='DOWN'";
        


        $rtDT = $this->db->query($qtDT);
        $rtPLQAD = $this->db->query($qtPLQAD);
        $rtBH = $this->db->query($qtBH);
        $rtBD = $this->db->query($qtBD);
        $raDT = $this->db->query($qaDT);
        $raPLQAD = $this->db->query($qaPLQAD);
        $raBH = $this->db->query($qaBH);
        $raBD = $this->db->query($qaBD);
        $rdDT = $this->db->query($qdDT);
        $rdPLQAD = $this->db->query($qdPLQAD);
        $rdBH = $this->db->query($qdBH);
        $rdBD = $this->db->query($qdBD);
        

        $qad['nDT'] = $rtDT->num_rows();
        $qad['nPLQAD'] = $rtPLQAD->num_rows();
        $qad['nBH'] = $rtBH->num_rows();
        $qad['nBD'] = $rtBD->num_rows();
        $qad['aDT'] = $raDT->num_rows();
        $qad['aPLQAD'] = $raPLQAD->num_rows();
        $qad['aBH'] = $raBH->num_rows();
        $qad['aBD'] = $raBD->num_rows();
        $qad['dDT'] = $rdDT->num_rows();
        $qad['dPLQAD'] = $rdPLQAD->num_rows();
        $qad['dBH'] = $rdBH->num_rows();
        $qad['dBD'] = $rdBD->num_rows();
        

        $pDT = ($qad['aDT']/$qad['nDT'])*100;
        $pPL = ($qad['aPLQAD']/$qad['nPLQAD'])*100;
        $pBH = ($qad['aBH']/$qad['nBH'])*100;
        $pBD = ($qad['aBD']/$qad['nBD'])*100;
        $pAVE = ($pDT+$pPL+$pBH+$pBD)/4;
        
        $pfDT = number_format($pDT,0,',','.');
        $pfPL = number_format($pPL,0,',','.');
        $pfBH = number_format($pBH,0,',','.');
        $pfBD = number_format($pBD,0,',','.');
        $qad['sAVE'] =  number_format($pAVE,0,',','.');
        
        $cDT = '';
        $cPLQAD = '';
        $cBH = '';
        $cBD = '';
        if($pDT<TGT_DT){    $cDT = 'color="#990000"';}
        if($pPL<TGT_PL){    $cPLQAD = 'color="#990000"';}
        if($pBH<TGT_BH){    $cBH = 'color="#990000"';}
        if($pBD<TGT_BD){    $cBD = 'color="#990000"';}
        
        $qad['pDT'] = "<font $cDT>$pfDT</font> ";
        $qad['pPLQAD'] = "<font $cPLQAD>$pfPL</font> ";
        $qad['pBH'] = "<font $cBH>$pfBH</font> ";
        $qad['pBD'] = "<font $cBD>$pfBD</font> ";

        $qad['perc_DT'] = $pfDT;
        $qad['perc_PLQAD'] = $pfPL;
        $qad['perc_BH'] = $pfBH;
        $qad['perc_BD'] = $pfBD;

        return $qad;
    }

    function getRMCDsummary(){
        $qtTM = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'TM%' AND (unit_cond!='SOLD' AND unit_cond!='JUNK')";
        $qtPL = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'PL%' AND dept='RMCD' AND unit_cond!='SOLD'";
        $qtPUMP = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'PUMP%' AND unit_cond!='SOLD'";
        $qtSS = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'SS%' AND unit_cond!='SOLD'";
        
        $qaTM = "SELECT unitcode FROM deu_units WHERE (unit_cond='OK' OR unit_cond='AV') AND unitcode LIKE 'TM%'";
        $qaPL = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'PL%' AND dept='RMCD' AND (unit_cond='OK' OR unit_cond='AV')";
        $qaPUMP = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'PUMP%' AND (unit_cond='OK' OR unit_cond='AV')";
        $qaSS = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'SS%' AND (unit_cond='OK' OR unit_cond='AV')";
        
        $qdTM = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'TM%' AND unit_cond='DOWN'";
        $qdPL = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'PL%' AND dept='RMCD' AND unit_cond='DOWN'";
        $qdPUMP = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'PUMP%' AND unit_cond='DOWN'";
        $qdSS = "SELECT unitcode FROM deu_units WHERE unitcode LIKE 'SS%' AND unit_cond='DOWN'";
        
        $rtTM = $this->db->query($qtTM);
        $rtPL = $this->db->query($qtPL);
        $rtPUMP = $this->db->query($qtPUMP);
        $rtSS = $this->db->query($qtSS);
        $raTM = $this->db->query($qaTM);
        $raPL = $this->db->query($qaPL);
        $raPUMP = $this->db->query($qaPUMP);
        $raSS = $this->db->query($qaSS);
        $rdTM = $this->db->query($qdTM);
        $rdPL = $this->db->query($qdPL);
        $rdPUMP = $this->db->query($qdPUMP);
        $rdSS = $this->db->query($qdSS);
        
        $rmcd['nTM'] = $rtTM->num_rows();
        $rmcd['nPL'] = $rtPL->num_rows();
        $rmcd['nPUMP'] = $rtPUMP->num_rows();
        $rmcd['nSS'] = $rtSS->num_rows();
        $rmcd['aTM'] = $raTM->num_rows();
        $rmcd['aPL'] = $raPL->num_rows();
        $rmcd['aPUMP'] = $raPUMP->num_rows();
        $rmcd['aSS'] = $raSS->num_rows();
        $rmcd['dTM'] = $rdTM->num_rows();
        $rmcd['dPL'] = $rdPL->num_rows();
        $rmcd['dPUMP'] = $rdPUMP->num_rows();
        $rmcd['dSS'] = $rdSS->num_rows();
        
        $pTM = ($rmcd['aTM']/$rmcd['nTM'])*100;
        $pPL = ($rmcd['aPL']/$rmcd['nPL'])*100;
        $pPUMP = ($rmcd['aPUMP']/$rmcd['nPUMP'])*100;
        $pSS = ($rmcd['aSS']/$rmcd['nSS'])*100;
        $pAVE = ($pTM+$pPL+$pPUMP)/3;
        
        $pfTM = number_format($pTM,0,',','.');
        $pfPL = number_format($pPL,0,',','.');
        $pfPUMP = number_format($pPUMP,0,',','.');
        $pfSS = number_format($pSS,0,',','.');
        $rmcd['sAVE'] =  number_format($pAVE,0,',','.');
        
        $cTM = '';
        $cPL = '';
        $cPUMP = '';
        if($pTM<TGT_TM){    $cTM = 'color="#990000"';}
        if($pPL<TGT_PLR){   $cPL = 'color="#990000"';}
        if($pPUMP<TGT_PUMP){    $cPUMP = 'color="#990000"';}
        
        
        $rmcd['pTM'] = "<font $cTM>$pfTM</font> ";
        $rmcd['pPL'] = "<font $cPL>$pfPL</font> ";
        $rmcd['pPUMP'] = "<font $cPUMP>$pfPUMP</font> ";
        $rmcd['pSS'] = $pfSS;

        $rmcd['perc_TM'] = $pfTM;
        $rmcd['perc_PUMP'] = $pfPUMP;
        $rmcd['perc_PL'] = $pfPL;
        $rmcd['perc_SS'] = $pfSS;

        return $rmcd;
    }

    function getPI(){
    $qad = $this->getQADsummary();  
    $rmcd = $this->getRMCDsummary();  
    $coVA = '';
    $oAT = TGT_OA;
    $oVA = number_format(($qad['sAVE']+$rmcd['sAVE'])/2,0)."%";
    if($oVA<$oAT){ $coVA= 'color="#990000"';}
    $PI['oat'] = $oAT;
    $PI['ova'] = "<font $coVA>$oVA</font>";

    $PI['o_at'] = $oAT;
    $PI['o_va'] = $oVA;
    return $PI;
  }

    function get_monthly_repair($month,$year)
    {
        $query = $this->db->query("SELECT * FROM deu_rep WHERE MONTH(date_in) = $month AND YEAR(date_in) = $year ORDER BY date_in ASC");
        if($query->num_rows() > 0){
                $res['result'] = $query;
                $res['rowcount'] = $query->num_rows();
                $res['view'] = 'deu/deu_monthlyrep_table';
        }else{
                $res['view'] = 'deu/deu_monthlyrep_error';
        }
        return $res;
    }

    function get_equipment_list()
    {
        $query = $this->db->query("SELECT *
                                 FROM 
                                `deu_units_info` 
                                ORDER BY `unit_id` ");
        
        if($query->num_rows() > 0){
                $res['result'] = $query;
                $res['rowcount'] = $query->num_rows();
        }
        return $res;
    }

    function get_unit_list(){
        $query = $this->db->query("SELECT * FROM deu_units WHERE unit_cond = 'OK' ORDER BY unitcode ASC");
        if($query->num_rows() > 0){
                
            return $query->result();
        }
        
    }

    function get_units()
    {
        $query = $this->db->query("SELECT * FROM deu_units_info  ORDER BY code ASC");
        if($query->num_rows() > 0){
                $res['result'] = $query;
                $res['rowcount'] = $query->num_rows();
        }
        return $res;
    }

    function get_unitinfo($unit_id){
        $query = $this->db->query("SELECT * FROM deu_units_info WHERE unit_id = '{$unit_id}' ");
        return $query->result();;
    }

    function add_units($unitdata)
    {

        //echo $unitdata;exit();
        $data = array(
               'code'       => $unitdata['code'],
               'desc'       => $unitdata['desc'],
               'capacity'   => $unitdata['capacity'],
               'plateno'    => $unitdata['plate_no'],
               'make'       => $unitdata['make'],
               'model'      => $unitdata['model'],
               'serial'     => $unitdata['serial'],
               'type'       => $unitdata['type'],
               'location'   => $unitdata['location'],
               'weight'     => $unitdata['weight'],
               'assignedto' => $unitdata['assignedto'],
               'status'     => $unitdata['status'],
               'color'      => $unitdata['color'],
               'image'      => $unitdata['image']
            );

        

        $result = $this->db->insert('deu_units_info', $data);
        return $result;
    }

    function edit_units($unitdata,$id)
    {

        if(isset($unitdata['image'])){
            $data = array(
               'code'       => $unitdata['code'],
               'desc'       => $unitdata['desc'],
               'capacity'   => $unitdata['capacity'],
               'plateno'    => $unitdata['plate_no'],
               'make'       => $unitdata['make'],
               'model'      => $unitdata['model'],
               'serial'     => $unitdata['serial'],
               'type'       => $unitdata['type'],
               'location'   => $unitdata['location'],
               'weight'     => $unitdata['weight'],
               'assignedto' => $unitdata['assignedto'],
               'status'     => $unitdata['status'],
               'color'      => $unitdata['color'],
               'image'      => $unitdata['image']
            );
        }else{
            $data = array(
               'code'       => $unitdata['code'],
               'desc'       => $unitdata['desc'],
               'capacity'   => $unitdata['capacity'],
               'plateno'    => $unitdata['plate_no'],
               'make'       => $unitdata['make'],
               'model'      => $unitdata['model'],
               'serial'     => $unitdata['serial'],
               'type'       => $unitdata['type'],
               'location'   => $unitdata['location'],
               'weight'     => $unitdata['weight'],
               'assignedto' => $unitdata['assignedto'],
               'status'     => $unitdata['status'],
               'color'      => $unitdata['color']
            );
        }
        

        
        $this->db->where('unit_id', $id);
        $this->db->update('deu_units_info', $data);

        
        
    }

    function update_maintenance($data,$id)
    {
        $maint_data = array(
               'date_in'    => $data['datein'],
               'time_in'    => $data['timein'],
               'details'    => $data['details'],
               'location'   => $data['location'],
               'est_days'   => $data['est'],
               'mech'       => $data['mechanic'],
               'ex_details' => $data['additional_work'],
               'comptage'   => $data['percentage'],
               'date_out'   => $data['dateout'],
               'time_out'   => $data['timeout'],
               'status'     => $data['status']
            );

        $this->db->where('rmdID', $id);
        $this->db->update('deu_rep', $maint_data);
    }

    function add_repairs($repairs){
        $last_edit = $this->session->userdata('nick');
        $final_date = date('Y-m-d');

        //echo $unitdata;exit();
        $data = array(
               'unit'       => $repairs['unit'],
               'type'       => $repairs['repair_type'],
               'details'    => $repairs['details'],
               'location'   => $repairs['location'],
               'date_in'    => $repairs['datein'],
               'time_in'    => $repairs['timein'],
               'est_days'   => $repairs['est_days'],
               'est_hours'  => $repairs['est_time'],
               'mech'       => $repairs['technician'],
               'ex_details' => $repairs['additional_works'],
               'comptage'   => '',
               'date_out'   => $repairs['dateout'],
               'time_out'   => $repairs['timeout'],
               'status'     => $repairs['availabilty'],
               'scope'      => $repairs['scope'],
               'final_date' => $final_date,
               'last_edit_by' => $last_edit
            );

        

        $result = $this->db->insert('deu_rep', $data);
        return $result;
    }
    function update_repairs(){
        $last_edit = $this->session->userdata('nick');
    }




    /*
    |   AJAX FUNCTIONS STARTS HERE
    |   AUTHOR : RALPH TAN CERIACO
    |   DATE : APRIL 10, 2013
    |
    |   ----------------------------------------------------------------(())
    */

    function ajax_get_equiplist($unit_type){
        $query = $this->db->query("SELECT *
                                 FROM 
                                `deu_units_info` 
                                WHERE
                                `code` like '{$unit_type}%' ORDER BY code");
        
        if($query->num_rows() > 0){
                $res['result'] = $query;
                $res['rowcount'] = $query->num_rows();
        }else{
                $res['rowcount'] = $query->num_rows();
        }
        return $res;
    }

    function ajax_get_search_history($unit,$month,$year)
    {
        $query = $this->db->query("SELECT * FROM deu_rep WHERE MONTH(date_in) = $month AND YEAR(date_in) = $year AND unit = '{$unit}' ORDER BY date_in ASC");
        if($query->num_rows() > 0){
                $res['result'] = $query;
                $res['rowcount'] = $query->num_rows();
        }else{
                $res['rowcount'] = $query->num_rows();
        }
        return $res;
    }

    function ajax_get_monthly_repairs($month,$year)
    {
        $query = $this->db->query("SELECT * FROM deu_rep WHERE MONTH(date_in) = $month AND YEAR(date_in) = $year  ORDER BY date_in ASC");
        if($query->num_rows() > 0){
                $res['result'] = $query;
                $res['rowcount'] = $query->num_rows();
        }else{
                $res['rowcount'] = $query->num_rows();
        }
        return $res;
    }

    function ajax_ongoingrepaitrs()
    {
        $query = $this->db->query("UPDATE `rmc_project_qc`
                                   SET 
                                   `samp_standard`='{$samp_standard}',
                                   `samp_others`='{$samp_others}',
                                   `oth_cyl`='{$samp_cylinders}',
                                   `oth_m3`='{$samp_cubic}'
                                   WHERE 
                                   `project_id` = '{$id}' 
                                   ");
    }

    /* ajax for the units page */

    
    function add_deudaily_record($date,$recs){

      //echo "lol " . $recs['qad_dt_perca']; exit();
      //check if there is a record for the corresponding date
        $query = $this->db->query("SELECT `id` FROM deu_records WHERE `record_date` = '{$date}' ");
        $res = $query->num_rows();


        

        if($res > 0){
            //if yes then update
            foreach ($query->result() as $deu_recs) {
            }
            $id = $deu_recs->id;

            $data = array(
               'qad_dt_u'         => $recs['qad_dt_u'],
               'qad_pl_u'         => $recs['qad_pl_u'],
               'qad_bh_u'         => $recs['qad_bh_u'],
               'qad_bd_u'         => $recs['qad_bd_u'],
               'qad_dt_a'         => $recs['qad_dt_a'],
               'qad_pl_a'         => $recs['qad_pl_a'],
               'qad_bh_a'         => $recs['qad_bh_a'],
               'qad_bd_a'         => $recs['qad_bd_a'],
               'qad_dt_d'         => $recs['qad_dt_d'],
               'qad_pl_d'         => $recs['qad_pl_d'],
               'qad_bh_d'         => $recs['qad_bh_d'],
               'qad_bd_d'         => $recs['qad_bd_d'],
               'qad_dt_perca'     => $recs['qad_dt_perca'],
               'qad_pl_perca'     => $recs['qad_pl_perca'],
               'qad_bh_perca'     => $recs['qad_bh_perca'],
               'qad_bd_perca'     => $recs['qad_bd_perca'],
               'qad_dt_perct'     => $recs['qad_dt_perct'],
               'qad_pl_perct'     => $recs['qad_pl_perct'],
               'qad_bh_perct'     => $recs['qad_bh_perct'],
               'qad_bd_perct'     => $recs['qad_bd_perct'],
               'rmcd_tm_u'        => $recs['rmcd_tm_u'],
               'rmcd_pump_u'      => $recs['rmcd_pump_u'],
               'rmcd_pl_u'        => $recs['rmcd_pl_u'],
               'rmcd_ss_u'        => $recs['rmcd_ss_u'],
               'rmcd_tm_a'        => $recs['rmcd_tm_a'],
               'rmcd_pump_a'      => $recs['rmcd_pump_a'],
               'rmcd_pl_a'        => $recs['rmcd_pl_a'],
               'rmcd_ss_a'        => $recs['rmcd_ss_a'],
               'rmcd_tm_d'        => $recs['rmcd_tm_d'],
               'rmcd_pump_d'      => $recs['rmcd_pump_d'],
               'rmcd_pl_d'        => $recs['rmcd_pl_d'],
               'rmcd_ss_d'        => $recs['rmcd_ss_d'],
               'rmcd_tm_perca'    => $recs['rmcd_tm_perca'],
               'rmcd_pump_perca'  => $recs['rmcd_pump_perca'],
               'rmcd_pl_perca'    => $recs['rmcd_pl_perca'],
               'rmcd_ss_perca'    => $recs['rmcd_ss_perca'],
               'rmcd_tm_perct'    => $recs['rmcd_tm_perct'],
               'rmcd_pump_perct'  => $recs['rmcd_pump_perct'],
               'rmcd_pl_perct'    => $recs['rmcd_pl_perct'],
               'rmcd_ss_perct'    => $recs['rmcd_ss_perct'],
               'qad_average'      => $recs['qad_average'],
               'rmcd_average'     => $recs['rmcd_average'],
               'rmdpi_target'     => $recs['rmdpi_target'],
               'rmdpi_overall'    => $recs['rmdpi_overall'],
               'gen_date'         => $recs['gen_date']
            );
            

            $this->db->where('id', $id);
            $result = $this->db->update('deu_records', $data);

        }else{
            //if no then insert
            $data = array(
               'record_date'      => $date,
               'qad_dt_u'         => $recs['qad_dt_u'],
               'qad_pl_u'         => $recs['qad_pl_u'],
               'qad_bh_u'         => $recs['qad_bh_u'],
               'qad_bd_u'         => $recs['qad_bd_u'],
               'qad_dt_a'         => $recs['qad_dt_a'],
               'qad_pl_a'         => $recs['qad_pl_a'],
               'qad_bh_a'         => $recs['qad_bh_a'],
               'qad_bd_a'         => $recs['qad_bd_a'],
               'qad_dt_d'         => $recs['qad_dt_d'],
               'qad_pl_d'         => $recs['qad_pl_d'],
               'qad_bh_d'         => $recs['qad_bh_d'],
               'qad_bd_d'         => $recs['qad_bd_d'],
               'qad_dt_perca'     => $recs['qad_dt_perca'],
               'qad_pl_perca'     => $recs['qad_pl_perca'],
               'qad_bh_perca'     => $recs['qad_bh_perca'],
               'qad_bd_perca'     => $recs['qad_bd_perca'],
               'qad_dt_perct'     => $recs['qad_dt_perct'],
               'qad_pl_perct'     => $recs['qad_pl_perct'],
               'qad_bh_perct'     => $recs['qad_bh_perct'],
               'qad_bd_perct'     => $recs['qad_bd_perct'],
               'rmcd_tm_u'        => $recs['rmcd_tm_u'],
               'rmcd_pump_u'      => $recs['rmcd_pump_u'],
               'rmcd_pl_u'        => $recs['rmcd_pl_u'],
               'rmcd_ss_u'        => $recs['rmcd_ss_u'],
               'rmcd_tm_a'        => $recs['rmcd_tm_a'],
               'rmcd_pump_a'      => $recs['rmcd_pump_a'],
               'rmcd_pl_a'        => $recs['rmcd_pl_a'],
               'rmcd_ss_a'        => $recs['rmcd_ss_a'],
               'rmcd_tm_d'        => $recs['rmcd_tm_d'],
               'rmcd_pump_d'      => $recs['rmcd_pump_d'],
               'rmcd_pl_d'        => $recs['rmcd_pl_d'],
               'rmcd_ss_d'        => $recs['rmcd_ss_d'],
               'rmcd_tm_perca'    => $recs['rmcd_tm_perca'],
               'rmcd_pump_perca'  => $recs['rmcd_pump_perca'],
               'rmcd_pl_perca'    => $recs['rmcd_pl_perca'],
               'rmcd_ss_perca'    => $recs['rmcd_ss_perca'],
               'rmcd_tm_perct'    => $recs['rmcd_tm_perct'],
               'rmcd_pump_perct'  => $recs['rmcd_pump_perct'],
               'rmcd_pl_perct'    => $recs['rmcd_pl_perct'],
               'rmcd_ss_perct'    => $recs['rmcd_ss_perct'],
               'qad_average'      => $recs['qad_average'],
               'rmcd_average'     => $recs['rmcd_average'],
               'rmdpi_target'     => $recs['rmdpi_target'],
               'rmdpi_overall'    => $recs['rmdpi_overall'],
               'gen_date'         => $recs['gen_date']
            );
            $result = $this->db->insert('deu_records', $data);
            
        }

        return $result;
        
      
      
    }



    function get_perfreport_daily($date){
      $query = $this->db->query("SELECT * FROM deu_records WHERE record_date = '{$date}' ORDER BY record_date ASC ");
        if($query->num_rows() > 0){
                $res['result'] = $query;
                $res['rowcount'] = $query->num_rows();
        }else{
                $res['rowcount'] = $query->num_rows();
        }
        return $res;
    }

    function get_perfreport_monthly($month,$year){
      $query = $this->db->query("SELECT * FROM deu_records WHERE YEAR(`record_date`) = '{$year}' AND MONTH(`record_date`) = '{$month}' ORDER BY record_date ASC ");
        if($query->num_rows() > 0){
                $res['result'] = $query;
                $res['rowcount'] = $query->num_rows();
        }else{
                $res['rowcount'] = $query->num_rows();
        }
        return $res;
    } 
   
} 

