<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DEU extends CI_Controller {

	

	var $dateNow;
	var $lvl;
	



	function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->lvl = $this->session->userdata('userlvl');
		$this->dateNow = date("Y-m-d");
		
        
    }


	function index()
	{
		
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDEU($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl)){

				$this->pagemaker->setSoftname('Daily Equipment Update');

				$content['status'] = '';

				

				//get QAD summary
				$qad_sum = $this->deu_model->getQADsummary();
				$content['qad_summary'] = $this->load->view('deu/qad_summary_view',$qad_sum, true);

				//var_dump($qad_sum); exit();

				//get RMCD summary
				$rmcd_sum = $this->deu_model->getRMCDsummary();
				$content['rmcd_summary'] = $this->load->view('deu/rmcd_summary_view',$rmcd_sum, true);

				//get PI Summary
				$content['pi'] = $this->deu_model->getPI();

				//get pending majr south
				$pending_major_s = $this->deu_model->get_pending_major('1');
				$content['pendingMajorS'] = $this->load->view('deu/deu_status_table',$pending_major_s, true);
				
				//get pending major north
				$pending_major_n = $this->deu_model->get_pending_major('2');
				$content['pendingMajorN'] = $this->load->view('deu/deu_status_table',$pending_major_n, true);
				
				//get pending running
				$pending_running = $this->deu_model->get_pending_major('3');
				$content['pendingRunning'] = $this->load->view('deu/deu_status_table',$pending_running, true);


		        $this->body['view'] = 'deu/index';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Equipment Status');
			   
	        }else{
			    	redirect('welcome/denied');
		    }
        }else{
            redirect('main/login_deu');
        }
	
	}

	function monthly_repairs()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDEU($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl)){

				$this->pagemaker->setSoftname('Daily Equipment Update');

				$content['status'] = '';

				$content['monthfull'] = date("F");
				$content['month'] = date("m");
				$content['year'] = date("Y");

				//get the list of months/year
				$content['months'] = $this->functionlist->getMonthList();
				$content['years'] = $this->functionlist->getYearList();

				//get monthly repair
				$monthly_repair = $this->deu_model->get_monthly_repair($content['month'],$content['year']);
				$content['monthly_repair'] = $this->load->view($monthly_repair['view'],$monthly_repair, true);
				

		        $this->body['view'] = 'deu/view_monthly_rep';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Monthly Repair');
			   
	        }else{
				    redirect('welcome/denied');
			}
        }else{
            redirect('main/login_deu');
        }
	}

	function perf_report(){
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDEU($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl)){

				$this->pagemaker->setSoftname('Daily Equipment Update');

				$content['status'] = '';


		        $this->body['view'] = 'deu/view_perf_report';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Performance Report');
			   
	        }else{
				    redirect('welcome/denied');
			}
        }else{
            redirect('main/login_deu');
        }
	}




	/* --------------------------------------------------------------
	|
	|		MAINTENANCE MODULES HERE
	|		AUTHOR: RALPH TAN CERIACO
	|
	---------------------------------------------------------------*/

	function maintenance()
	{

		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDEUEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl)){

				$this->pagemaker->setSoftname('Daily Equipment Update');

				$content['status'] = '';


				//get pending repairs
				$pending = $this->deu_model->get_pending_major('4');
				$pending['timelist'] = $this->functionlist->getTimeArrays();
				$content['pending'] = $this->load->view('deu/deu_maintenance_table',$pending, true);
				

		        $this->body['view'] = 'deu/view_maintenance';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Maintenance');
			   
	        }else{
				    redirect('welcome/denied');
			}
        }else{
            redirect('main/login_deu');
        }		
	}

	function add_repair()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDEUEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl)){

				$this->pagemaker->setSoftname('Daily Equipment Update');

				$content['status'] = '';
				$content['time'] = $this->functionlist->getTimeArrays();
				$content['units'] = $this->deu_model->get_unit_list();

		        $this->body['view'] = 'deu/view_addrepair';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Maintenance');
			   
	        }else{
				redirect('welcome/denied');
			}
        }else{
            redirect('main/login_deu');
        }		
	}

	function search_history()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDEU($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl)){

				$this->pagemaker->setSoftname('Daily Equipment Update');

				$content['status'] = '';

				$content['monthfull'] = date("F");
				$content['month'] = date("m");
				$content['year'] = date("Y");

				//get the list of months/year
				$content['units'] = $this->deu_model->get_unit_list();
				//var_dump($content['units']); exit();
				$content['months'] = $this->functionlist->getMonthList();
				$content['years'] = $this->functionlist->getYearList();

				//get monthly repair
				$monthly_repair = $this->deu_model->get_monthly_repair($content['month'],$content['year']);
				$content['monthly_repair'] = $this->load->view($monthly_repair['view'],$monthly_repair, true);
				

		        $this->body['view'] = 'deu/view_search_history';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Search History');
			   
	        }else{
				    redirect('welcome/denied');
			}
        }else{
            redirect('main/login_deu');
        }		
	}

	function equipment_list()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDEU($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl)){

				$this->pagemaker->setSoftname('Daily Equipment Update');

				$content['status'] = '';

				//get monthly repair
				$equip_list = $this->deu_model->get_equipment_list();
				$content['equiplist'] = $this->load->view('deu/deu_equipment_list',$equip_list, true);
				

		        $this->body['view'] = 'deu/view_equip_list';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Equipment List');
	        }
	        else{
				redirect('welcome/denied');
			}
        }else{
            redirect('main/login_deu');
        }	
	}

	function view_units(){
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDEUEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl)){

				$this->pagemaker->setSoftname('Daily Equipment Update');

				$content['status'] = '';

				//get list of units
				$units_list = $this->deu_model->get_units();

				//var_dump($units_list);exit();
				$content['unitlist'] = $this->load->view('deu/deu_units_list',$units_list, true);
				

		        $this->body['view'] = 'deu/view_unit_list';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Units List');
			   
	        }
	        else{
				redirect('welcome/denied');
			}
        }else{
            redirect('main/login_deu');
        }	
	}

	function add_units(){
		if (isset($_FILES['deu-browseupload'])) {
			//GET THE POST DATA
			$unit_code = $_POST['unit-code'];
			$unit_color = $_POST['unit-color'];
			$unit_desc = $_POST['unit-desc'];
			$unit_plateno = $_POST['plateno'];
			$unit_cap = $_POST['capacity'];
			$unit_model = $_POST['model'];
			$unit_serialno = $_POST['serialno'];
			$unit_type = $_POST['type'];
			$unit_make = $_POST['make'];
			$unit_weight = $_POST['weight'];
			$unit_location = $_POST['location'];
			$unit_assignedto = $_POST['assignedto'];
			$unit_status = $_POST['unit-status'];

			
			$tmp_name = $_FILES['deu-browseupload']['tmp_name'];
			
			
			//check if image file is added if not then do not resize
			if($_FILES['deu-browseupload']['tmp_name'] <> ''){
				$dest = "css/images/deu_units/" . $unit_code .".jpg";
				$this->functionlist->resizeImage($tmp_name,$dest,1024,768);
				$unit_imageloc = $dest;
			}else{
				$unit_imageloc = '';
			}

			

			
			$unit_data = array(
               'code'       => $unit_code,
               'desc'       => $unit_desc,
               'capacity'   => $unit_cap,
               'plate_no'   => $unit_plateno,
               'make'       => $unit_make,
               'model'      => $unit_model,
               'serial'     => $unit_serialno,
               'type'       => $unit_type,
               'location'   => $unit_location,
               'weight'     => $unit_weight,
               'assignedto' => $unit_assignedto,
               'status'     => $unit_status,
               'color'      => $unit_color,
               'image'      => $unit_imageloc
            );
            

            //var_dump($unit_data);exit();
            //exit();

            echo $this->deu_model->add_units($unit_data);

            
		    redirect('deu/view_units');
		    //move_uploaded_file($_FILES['deu-browseupload']['tmp_name'], "css/images/deu_units/" . $_FILES['deu-browseupload']['name']);
		}else{
			$this->session->set_userdata('error_msg', 'No Image file,Cannot Continue.');
			redirect('deu/errorPage');
		}
	}

	function update_unit(){
		
			//GET THE POST DATA
			$unit_id = $_POST['unit-id'];
			$unit_code = $_POST['unit-code'];
			$unit_color = $_POST['unit-color'];
			$unit_desc = $_POST['unit-desc'];
			$unit_plateno = $_POST['plateno'];
			$unit_cap = $_POST['capacity'];
			$unit_model = $_POST['model'];
			$unit_serialno = $_POST['serialno'];
			$unit_type = $_POST['type'];
			$unit_make = $_POST['make'];
			$unit_weight = $_POST['weight'];
			$unit_location = $_POST['location'];
			$unit_assignedto = $_POST['assignedto'];
			$unit_status = $_POST['unit-status'];
			//$old_ima = $_POST['oldimage'];

			
			$tmp_name = $_FILES['deu-browseupload']['tmp_name'];
			
			
			//check if image file is added if not then do not resize
			if($_FILES['deu-browseupload']['tmp_name'] <> ''){
				$dest = "css/images/deu_units/" . $unit_code .".jpg";
				$this->functionlist->resizeImage($tmp_name,$dest,1024,768);
				$unit_imageloc = $dest;
				$unit_data = array(
	               'code'       => $unit_code,
	               'desc'       => $unit_desc,
	               'capacity'   => $unit_cap,
	               'plate_no'   => $unit_plateno,
	               'make'       => $unit_make,
	               'model'      => $unit_model,
	               'serial'     => $unit_serialno,
	               'type'       => $unit_type,
	               'location'   => $unit_location,
	               'weight'     => $unit_weight,
	               'assignedto' => $unit_assignedto,
	               'status'     => $unit_status,
	               'color'      => $unit_color,
	               'image'      => $unit_imageloc
	            );
			}else{
				$unit_data = array(
	               'code'       => $unit_code,
	               'desc'       => $unit_desc,
	               'capacity'   => $unit_cap,
	               'plate_no'   => $unit_plateno,
	               'make'       => $unit_make,
	               'model'      => $unit_model,
	               'serial'     => $unit_serialno,
	               'type'       => $unit_type,
	               'location'   => $unit_location,
	               'weight'     => $unit_weight,
	               'assignedto' => $unit_assignedto,
	               'status'     => $unit_status,
	               'color'      => $unit_color
	            );
			}

            

           // var_dump($unit_id);exit();
            //exit();

           $this->deu_model->edit_units($unit_data,$unit_id);

           
		   redirect('deu/view_units');
		    
	}

	function insert_repair()
	{
		//get the POST data
		$scope = $_POST['scope'];
		$field = '';

		foreach ($scope as $scope_list) {
			if($field == ''){
				$field = $scope_list;
			}else{
				$field = $field.','.$scope_list;
			}
			
		}

		$data = array(
               'unit'       	=> $_POST['unit'],
               'datein'       	=> $_POST['date-in'],
               'timein'   		=> $_POST['time-in'],
               'repair_type'    => $_POST['repair-type'],
               'availabilty'    => $_POST['availability'],
               'location'      	=> $_POST['location'],
               'dateout'     	=> $_POST['date-out'],
               'timeout'       	=> $_POST['time-out'],
               'est_days'   	=> $_POST['est-day'],
               'est_time'     	=> $_POST['est-time'],
               'technician' 	=> $_POST['technician'],
               'scope'     		=> trim($field,""),
               'details'      	=> $_POST['details'],
               'additional_works' => $_POST['additional-works']
            );


		$this->deu_model->add_repairs($data);

		redirect('deu/add_repair');
		

		
	}

	function update_maintenance(){
		//get the posted datas and update the mysql database
		$id = $_POST['unit-id'];

		$data = array(
               'datein'       	=> $_POST['datein'],
               'timein'       	=> $_POST['timein'],
               'details'   		=> $_POST['details'],
               'location'    	=> $_POST['location'],
               'est'    		=> $_POST['est'],
               'mechanic'      	=> $_POST['mechanic'],
               'additional_work'=> $_POST['additional_work'],
               'percentage'     => $_POST['percentage'],
               'dateout'   		=> $_POST['dateout'],
               'timeout'     	=> $_POST['timeout'],
               'status' 		=> $_POST['status']
            );

		$this->deu_model->update_maintenance($data,$id);
	}

	/* --------------------------------------------------------------
	|
	|		ALL AJAX FUNCTIONS HERE
	|		AUTHOR: RALPH TAN CERIACO
	|		DATE: APRIL 10, 2013 3:00 PM
	---------------------------------------------------------------*/

	function ajax_searchbutton(){
		$sourcepage = $_POST['source'];

		if($sourcepage == 'equipmentlist'){
			$unit_type = $_POST['unit_type'];
			//query here
			$equip_list = $this->deu_model->ajax_get_equiplist($unit_type);

			if($equip_list['rowcount'] > 0){
				$content['equiplist'] = $this->load->view('deu/deu_equipment_list',$equip_list, true);
				echo "<h1 class='deu-h1'>EQUIPMENT LIST - ($unit_type)</h1>";
				echo $content['equiplist']; 
			}else{
				echo "<h1 class='deu-h1'>No records in the database</h1>";
			}
			
			
		}elseif ($sourcepage == 'searchhistory') {
			$unit = $_POST['unit'];
			$month = $_POST['month'];
			$year = $_POST['year'];
			//query here
			$monthly_repair = $this->deu_model->ajax_get_search_history($unit,$month,$year);
			if($monthly_repair['rowcount'] > 0){
				$content['monthly_repair'] = $this->load->view('deu/deu_monthlyrep_table',$monthly_repair, true);
				echo "<h1 class='deu-h1'>SEARCH HISTORY as of $month/$year for $unit</h1>";
				echo $content['monthly_repair'];
			}else{
				echo "<h1 class='deu-h1'>No Repair records in the database.</h1>";
			}
			
			
		}elseif ($sourcepage == 'monthlyrepairs') {
			$month = $_POST['month'];
			$year = $_POST['year'];
			//query here
			$monthly_repair = $this->deu_model->ajax_get_monthly_repairs($month,$year);
			

			if($monthly_repair['rowcount'] > 0){
				$content['monthly_repair'] = $this->load->view('deu/deu_monthlyrep_table',$monthly_repair, true);
				echo "<h1 class='deu-h1'>Repairs Recorded for $month/$year </h1>";
				echo $content['monthly_repair'];
			}else{
				echo "<h1 class='deu-h1'>No Repairs recorded in the database</h1>";
			}
			
		}
	}

	function ajax_edit_units(){

	}

	function ajax_delete_units(){

	}

	function ajax_insert_units(){
		
	}

	function ajax_query_unitinfo()
	{
		$unit_id = $_POST['unit-id'];
		$res = $this->deu_model->get_unitinfo($unit_id);


		//foreach ($res as $reslist) {
		//}
		//echo $reslist->code;


		//echo $res;

		echo json_encode($res);
	}

	function ajax_perf_report(){
		$selection = $_POST['selection'];
		if($selection == 'daily'){
			$date = $_POST['date'];
			
			$perf_rep_daily = $this->deu_model->get_perfreport_daily($date);
			if($perf_rep_daily['rowcount'] > 0){
				$content['perf_rep'] = $this->load->view('deu/deu_perfrep_table',$perf_rep_daily, true);
				echo "<h1 class='deu-h1'>Performance Report for $date </h1><br />";
				echo $content['perf_rep'];
			}else{
				echo "<h1 class='deu-h1'>No Records in the database.</h1>";
			}


		}else{
			$month = $_POST['month'];
			$year = $_POST['year'];

			switch ($month) {
				case '01':
					$monthname = 'January'; break;
				case '02':
					$monthname = 'February'; break;
				case '03':
					$monthname = 'March'; break;
				case '04':
					$monthname = 'April'; break;
				case '05':
					$monthname = 'May'; break;
				case '06':
					$monthname = 'June'; break;
				case '07':
					$monthname = 'July'; break;
				case '08':
					$monthname = 'August'; break;
				case '09':
					$monthname = 'September'; break;
				case '10':
					$monthname = 'October'; break;
				case '11':
					$monthname = 'November'; break;
				case '12':
					$monthname = 'December'; break;
				
			}

			$perf_rep_monthly = $this->deu_model->get_perfreport_monthly($month,$year);
			if($perf_rep_monthly['rowcount'] > 0){
				$content['perf_rep'] = $this->load->view('deu/deu_perfrep_table',$perf_rep_monthly, true);
				echo "<h1 class='deu-h1'>Monthly Performance Report ($monthname $year)</h1><br />";
				echo $content['perf_rep'];
			}else{
				echo "<h1 class='deu-h1'>No Records in the database.</h1>";
			}
			
		}
		
	}

	// ------------------------- ERROR PAGE --------------
	function errorPage()
	{
		
    	$data['status'] = '';
    	$data['error_msg'] = $this->session->userdata('error_msg');
    	$this->load->view('templates/errorpage', $data);
	}

	function record_daily_deuperf(){
		$date_now = $this->dateNow;

		$qad_sum = $this->deu_model->getQADsummary();
		$rmcd_sum = $this->deu_model->getRMCDsummary();

		//echo $qad_sum['pDT']; exit();

		$pi_target = '12';
		$pi_overall = '15'; 

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
               'qad_average'        => $qad_sum['sAVE'],
               'rmcd_average'       => $rmcd_sum['sAVE'],
               'rmdpi_target'       => $pi_target,
               'rmdpi_overall'   	=> $pi_overall,
               'gen_date'       	=> $date_now
            );

		$res = $this->deu_model->add_deudaily_record($date_now,$data);
		echo $res;

	}
}