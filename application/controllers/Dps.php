<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', 1);
error_reporting(E_ALL);
class DPS extends CI_Controller {

	
	var $nextpouringdate;
	var $dateNow;
	var $date_tom;
	var $date_Tom = array();
	var $dateTom;
	var $emp_id;
	var $lvl;
	var $initial;
	var $isHaveCount;
	var $timeNow;

	//added by ralph 7-30-2015 to support scheduler for saturday and sunday
	var $dateSat;
	var $dateSun;
	var $dateMon;

	//added by ralph 3-9-2016 for the mcurrent month and year
	var $currentYear;
	var $currentMonth;
	var $contract_no;


	

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->load->library('image_lib');
        $this->lvl = $this->session->userdata('userlvl');
        $this->emp_id = $this->session->userdata('employee_id');

		//Scan for holidays or sundays // initialization of dates star here
		$this->dateNow = date("Y-m-d");
		$this->currentYear = date("Y");
		$this->currentMonth = date("m");				
		$this->date_tom = mktime(0,0,0,date("m"),date("d")+1);
        $this->date_Tom = $this->hdays($this->date_tom);				//next pouring date(tomorrow) in array
        $this->dateTom = $this->date_Tom[1];
		//store date into content array and pass to the view
        $this->nextpouringdate = $this->dateTom;      //changed by MOC 12/29/14 FOR NEXT YEAR POURING
        $this->initial = $this->session->userdata('userinit');
        $this->isHaveCount = "no";
        $this->timeNow = date('H:i:s');

        
    }

	function index()
	{
		//echo date('Y-m-d', strtotime('-9 days', strtotime(date("Y-m-d"))));
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
				$content['status']='';
				$content['action']='main/checklogin';
				//display the login page to the user
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

	    		$content['dateTom'] = $this->nextpouringdate;				//next pouring date format is eg; 2012-12-30
	    		$content['dateTom2'] = $this->date_Tom[0];					//unix timestamp pass for conversion into format eg; December 30, 2012
	    		
	    		//check the userlvl of the user
	    		//accounting

				// echo var_dump($this->functionlist->isDPSacctg($this->lvl));
				// echo var_dump($this->functionlist->isDPSps($this->lvl));
				// echo var_dump($this->functionlist->isDPSqc($this->lvl));
				// echo var_dump($this->functionlist->isDPSsmd($this->lvl));
				// echo var_dump($this->functionlist->isDPSCoordinator($this->lvl));
				
				// die();
			
			
	    		if($this->functionlist->isDPSacctg($this->lvl)){
	    			$content['notify_today'] = $this->dps_model->fetch_notify_sched($this->dateNow,'acctg');
	    			$content['notify_tomorrow'] = $this->dps_model->fetch_notify_sched($this->dateTom,'acctg');
	    			$content['notify_msg'] = 'Hello Accounting! ';
	    		}

	    		//plant supervisor
	    		if($this->functionlist->isDPSps($this->lvl)){
	    			$content['notify_today'] = $this->dps_model->fetch_notify_sched($this->dateNow,'ps');
	    			$content['notify_tomorrow'] = $this->dps_model->fetch_notify_sched($this->dateTom,'ps');
	    			$content['notify_msg'] = 'Hello Plant Supervisor! ';
	    		}

	    		//QC
	    		if($this->functionlist->isDPSqc($this->lvl)){
	    			$content['notify_today'] = $this->dps_model->fetch_notify_sched($this->dateNow,'qc');
	    			$content['notify_tomorrow'] = $this->dps_model->fetch_notify_sched($this->dateTom,'qc');
	    			$content['notify_msg'] = 'Hello QC! ';
	    		}

	    		//SMD Manager
	    		if($this->functionlist->isDPSsmd($this->lvl)){
	    			$content['notify_today_smd'] = $this->dps_model->fetch_notify_smdmanager_sched($this->dateNow);
	    			$content['notify_tomorrow_smd'] = $this->dps_model->fetch_notify_smdmanager_sched($this->dateTom);
	    			$content['notify_msg'] = 'Hello SMD Manager! ';
	    		}

	    		if($this->functionlist->isDPSCoordinator($this->lvl)){
	    			$content['notify_today_smd'] = $this->dps_model->fetch_notify_coor_sched($this->dateNow);
	    			$content['notify_tomorrow_smd'] = $this->dps_model->fetch_notify_coor_sched($this->dateTom);
	    			$content['notify_msg'] = 'Hello Coordinator! ';
	    		}

	    		
	    		

				//query pouring schedule for Today in North Area/South Area
				// today north
				$booking_today_north = $this->dps_model->fetch_bookings('bookingpanel',$this->dateNow,'Plant 3');
				$booking_today_north_insert = $this->dps_model->fetch_bookings('bookingpanel_insert',$this->dateNow,'Plant 3');
				
			

				if($booking_today_north['count'] == 'norecord'){
					if($booking_today_north_insert['count'] == 'norecord'){
						//display the error message
						$content['dps_today_north'] = $this->load->view($booking_today_north['view'], $booking_today_north,true);
						$content['dps_today_north_insert'] = '';
					}else{
						//shift the view to the single insert view
						$content['dps_today_north'] = '';
						$booking_today_north_insert['view'] = 'dps/dps_table_view_insert';
						$content['dps_today_north_insert'] = $this->load->view($booking_today_north_insert['view'], $booking_today_north_insert,true);
						//ADDED BY RALPH 12/2/2013 TO INCLUDE INSERT ONLY IN MANAGER APPROVAL
						$content['manager_status_north'] = $this->dps_model->check_manager_approval($this->dateNow,'Plant 3');
					}
				}else{
					//display it and display the insert also
					if($booking_today_north_insert['count'] == 'norecord'){
						$content['dps_today_north_insert'] = '';
						$content['dps_today_north'] = $this->load->view($booking_today_north['view'], $booking_today_north,true);
					}else{
						$content['dps_today_north'] = $this->load->view($booking_today_north['view'], $booking_today_north,true);
						$content['dps_today_north_insert'] = $this->load->view($booking_today_north_insert['view'], $booking_today_north_insert,true);
					}
					//check if manager status
	    			$content['manager_status_north'] = $this->dps_model->check_manager_approval($this->dateNow,'Plant 3');
					
				}
				
				$content['north_todayvol'] = (isset($booking_today_north['volume'])) ? $booking_today_north['volume'] : "0";
				$content['north_todayvol_insert'] = (isset($booking_today_north_insert['volume'])) ? $booking_today_north_insert['volume'] : "0";
				//total volume for today north
				$content['volume_today_north'] = $content['north_todayvol'] + $content['north_todayvol_insert'];
				
				

				
				// today south
				$booking_today_south = $this->dps_model->fetch_bookings('bookingpanel',$this->dateNow,'Plant 4');
				$booking_today_south_insert = $this->dps_model->fetch_bookings('bookingpanel_insert',$this->dateNow,'Plant 4');

				if($booking_today_south['count'] == 'norecord'){
					if($booking_today_south_insert['count'] == 'norecord'){
						//display the error message
						$content['dps_today_south'] = $this->load->view($booking_today_south['view'], $booking_today_south,true);
						$content['dps_today_south_insert'] = '';
					}else{
						//shift the view to the single insert view
						$content['dps_today_south'] = '';
						$booking_today_south_insert['view'] = 'dps/dps_table_view_insert';
						$content['dps_today_south_insert'] = $this->load->view($booking_today_south_insert['view'], $booking_today_south_insert,true);
						//ADDED BY RALPH 12/2/2013 TO INCLUDE INSERT ONLY IN MANAGER APPROVAL
						$content['manager_status_south'] = $this->dps_model->check_manager_approval($this->dateNow,'Plant 4');
					}
				}else{
					//display it and display the insert also
					if($booking_today_south_insert['count'] == 'norecord'){
						$content['dps_today_south_insert'] = '';
						$content['dps_today_south'] = $this->load->view($booking_today_south['view'], $booking_today_south,true);
					}else{
						$content['dps_today_south'] = $this->load->view($booking_today_south['view'], $booking_today_south,true);
						$content['dps_today_south_insert'] = $this->load->view($booking_today_south_insert['view'], $booking_today_south_insert,true);
					}
					$content['manager_status_south'] = $this->dps_model->check_manager_approval($this->dateNow,'Plant 4');

				}

				$content['south_todayvol'] = (isset( $booking_today_south['volume'])) ?  $booking_today_south['volume'] : "0";
				$content['south_todayvol_insert'] = (isset($booking_today_south_insert['volume'])) ?  $booking_today_south_insert['volume'] : "0";
				//total volume today south
				$content['volume_today_south'] = $content['south_todayvol'] + $content['south_todayvol_insert'];


				// today for confirmation
				$booking_today_forconfirm = $this->dps_model->fetch_bookings('bookingpanel_confirm',$this->dateNow,'');
				$content['dps_today_forconfirm'] = $this->load->view($booking_today_forconfirm['view'], $booking_today_forconfirm,true);
				$content['volume_today_forconfirm'] = (isset($booking_today_forconfirm['volume'])) ? $booking_today_forconfirm['volume'] : "0";

				
	    		
				
				// tomorrow north
				$booking_tom_north = $this->dps_model->fetch_bookings('bookingpanel',$this->dateTom,'Plant 3');
				$booking_tom_north_insert = $this->dps_model->fetch_bookings('bookingpanel_insert',$this->dateTom,'Plant 3');

				if($booking_tom_north['count'] == 'norecord'){
					if($booking_tom_north_insert['count'] == 'norecord'){
						//display the error message
						$content['dps_tom_north'] = $this->load->view($booking_tom_north['view'], $booking_tom_north,true);
						$content['dps_tom_north_insert'] = '';
					}else{
						//shift the view to the single insert view
						$content['dps_tom_north'] = '';
						$booking_tom_north_insert['view'] = 'dps/dps_table_view_insert';
						$content['dps_tom_north_insert'] = $this->load->view($booking_tom_north_insert['view'], $booking_tom_north_insert,true);
						//ADDED BY RALPH 12/2/2013 TO INCLUDE INSERT ONLY IN MANAGER APPROVAL
						$content['manager_status_north2'] = $this->dps_model->check_manager_approval($this->dateTom,'Plant 3');
					}
				}else{
					//display it and display the insert also
					if($booking_tom_north_insert['count'] == 'norecord'){
						$content['dps_tom_north_insert'] = '';
						$content['dps_tom_north'] = $this->load->view($booking_tom_north['view'], $booking_tom_north,true);
					}else{
						$content['dps_tom_north'] = $this->load->view($booking_tom_north['view'], $booking_tom_north,true);
						$content['dps_tom_north_insert'] = $this->load->view($booking_tom_north_insert['view'], $booking_tom_north_insert,true);
					}
					//check if manager status
	    			$content['manager_status_north2'] = $this->dps_model->check_manager_approval($this->dateTom,'Plant 3');
				}
				
				
				
				$content['north_tomvol'] = (isset($booking_tom_north['volume'])) ? $booking_tom_north['volume'] : "0";
				$content['north_tomvol_insert'] = (isset($booking_tom_north_insert['volume'])) ? $booking_tom_north_insert['volume'] : "0";
				$content['volume_tom_north'] = $content['north_tomvol'] + $content['north_tomvol_insert'];


				
				// tomorrow south
				$booking_tom_south = $this->dps_model->fetch_bookings('bookingpanel',$this->dateTom,'Plant 4');
				$booking_tom_south_insert = $this->dps_model->fetch_bookings('bookingpanel_insert',$this->dateTom,'Plant 4');

				if($booking_tom_south['count'] == 'norecord'){
					if($booking_tom_south_insert['count'] == 'norecord'){
						//display the error message
						$content['dps_tom_south'] = $this->load->view($booking_tom_south['view'], $booking_tom_south,true);
						$content['dps_tom_south_insert'] = '';
					}else{
						//shift the view to the single insert view
						$content['dps_tom_south'] = '';
						$booking_tom_south_insert['view'] = 'dps/dps_table_view_insert';
						$content['dps_tom_south_insert'] = $this->load->view($booking_tom_south_insert['view'], $booking_tom_south_insert,true);
						//ADDED BY RALPH 12/2/2013 TO INCLUDE INSERT ONLY IN MANAGER APPROVAL
						$content['manager_status_south2'] = $this->dps_model->check_manager_approval($this->dateTom,'Plant 4');
					}
				}else{
					//display it and display the insert also
					
					if($booking_tom_south_insert['count'] == 'norecord'){
						$content['dps_tom_south_insert'] = '';
						$content['dps_tom_south'] = $this->load->view($booking_tom_south['view'], $booking_tom_south,true);
					}else{
						$content['dps_tom_south'] = $this->load->view($booking_tom_south['view'], $booking_tom_south,true);
						$content['dps_tom_south_insert'] = $this->load->view($booking_tom_south_insert['view'], $booking_tom_south_insert,true);
					}
					$content['manager_status_south2'] = $this->dps_model->check_manager_approval($this->dateTom,'Plant 4');
				}
				
				$content['south_tomvol'] = (isset($booking_tom_south['volume'])) ? $booking_tom_south['volume'] : "0";
				$content['south_tomvol_insert'] = (isset($booking_tom_south_insert['volume'])) ? $booking_tom_south_insert['volume'] : "0";

				$content['volume_tom_south'] = $content['south_tomvol'] + $content['south_tomvol_insert'];

				// tomorrow for confirmation
				$booking_tom_forconfirm = $this->dps_model->fetch_bookings('bookingpanel_confirm',$this->dateTom,'');
				$content['dps_tom_forconfirm'] = $this->load->view($booking_tom_forconfirm['view'], $booking_tom_forconfirm,true);
				$content['volume_tom_forconfirm'] = (isset($booking_tom_forconfirm['volume'])) ? $booking_tom_forconfirm['volume'] : "0";

				
		        //-----------------------------------------------------------------------
		        //	FOR MOBILE DATA HERE
		        //-----------------------------------------------------------------------
		        $mbooking_today_north = $this->dps_model->fetch_bookings_mobile($this->dateNow,'Plant 3','fluid');
		        $mbooking_today_north_resched = $this->dps_model->get_mobile_resched($this->dateNow,'Plant 3');
		        $content['m_today_north'] = $this->load->view($mbooking_today_north['view'], $mbooking_today_north,true);
		        	//volume,schedule and insert count here
		        	$content['mtodaynorth_vol'] = $mbooking_today_north['volume'];
		        	$content['mtodaynorth_okaycount'] = $mbooking_today_north['okaycount'];
		        	$content['mtodaynorth_insertcount'] = $mbooking_today_north['insertcount'];
		        	$content['mtodaynorth_reschedcount'] = $mbooking_today_north_resched['count'];
		        	$content['mtodaynorth_insertvolume'] = $this->dps_model->getVol($this->dateNow,2,'Plant 3');
		        	$content['mtodaynorth_reschedvolume'] = $mbooking_today_north_resched['volume'];
		        $mbooking_today_northfix = $this->dps_model->fetch_bookings_mobile($this->dateNow,'Plant 3','fix');
		        $content['m_today_northfix'] = $this->load->view($mbooking_today_northfix['view'], $mbooking_today_northfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$this->dateNow,'Plant 3');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$this->dateNow,'Plant 3');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$this->dateNow,'Plant 3');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['today_north_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);


		        $mbooking_today_south = $this->dps_model->fetch_bookings_mobile($this->dateNow,'Plant 4','fluid');
		        $mbooking_today_south_resched = $this->dps_model->get_mobile_resched($this->dateNow,'Plant 4');
		        $content['m_today_south'] = $this->load->view($mbooking_today_south['view'], $mbooking_today_south,true);
		       
		        	//volume,schedule and insert count here
		        	$content['mtodaysouth_vol'] = $mbooking_today_south['volume'];
		        	$content['mtodaysouth_okaycount'] = $mbooking_today_south['okaycount'];
		        	$content['mtodaysouth_insertcount'] = $mbooking_today_south['insertcount'];
		        	$content['mtodaysouth_reschedcount'] = $mbooking_today_south_resched['count'];
		        	$content['mtodaysouth_insertvolume'] = $this->dps_model->getVol($this->dateNow,2,'Plant 4');
		        	$content['mtodaysouth_reschedvolume'] = $mbooking_today_south_resched['volume'];

		        	//Total Volume
		        	$content['mtodaytotal_vol'] = $mbooking_today_north['volume'] + $mbooking_today_south['volume'];
		        $mbooking_today_southfix = $this->dps_model->fetch_bookings_mobile($this->dateNow,'Plant 4','fix');
		        $content['m_today_southfix'] = $this->load->view($mbooking_today_southfix['view'], $mbooking_today_southfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$this->dateNow,'Plant 4');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$this->dateNow,'Plant 4');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$this->dateNow,'Plant 4');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['today_south_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);




		        $mbooking_tom_north = $this->dps_model->fetch_bookings_mobile($this->nextpouringdate,'Plant 3','fluid');
		        $mbooking_tom_north_resched = $this->dps_model->get_mobile_resched($this->nextpouringdate,'Plant 3');
		        $content['m_tom_north'] = $this->load->view($mbooking_tom_north['view'], $mbooking_tom_north,true);
		        	//volume,schedule and insert count here
		        	$content['mtomnorth_vol'] = $mbooking_tom_north['volume'];
		        	$content['mtomnorth_okaycount'] = $mbooking_tom_north['okaycount'];
		        	$content['mtomnorth_insertcount'] = $mbooking_tom_north['insertcount'];
		        	$content['mtomnorth_reschedcount'] = $mbooking_tom_north_resched['count'];
		        	$content['mtomnorth_insertvolume'] = $this->dps_model->getVol($this->nextpouringdate,2,'Plant 3');
		        	$content['mtomnorth_reschedvolume'] = $mbooking_tom_north_resched['volume'];

		        $mbooking_tom_northfix = $this->dps_model->fetch_bookings_mobile($this->nextpouringdate,'Plant 3','fix');
		        $content['m_tom_northfix'] = $this->load->view($mbooking_tom_northfix['view'], $mbooking_tom_northfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$this->nextpouringdate,'Plant 3');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$this->nextpouringdate,'Plant 3');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$this->nextpouringdate,'Plant 3');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['tom_north_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);


		        $mbooking_tom_south = $this->dps_model->fetch_bookings_mobile($this->nextpouringdate,'Plant 4','fluid');
		        $mbooking_tom_south_resched = $this->dps_model->get_mobile_resched($this->nextpouringdate,'Plant 4');
		        $content['m_tom_south'] = $this->load->view($mbooking_tom_south['view'], $mbooking_tom_south,true);
		       		//volume,schedule and insert count here
		        	$content['mtomsouth_vol'] = $mbooking_tom_south['volume'];
		        	$content['mtomsouth_okaycount'] = $mbooking_tom_south['okaycount'];
		        	$content['mtomsouth_insertcount'] = $mbooking_tom_south['insertcount'];
		        	$content['mtomsouth_reschedcount'] = $mbooking_tom_south_resched['count'];
		        	$content['mtomsouth_insertvolume'] = $this->dps_model->getVol($this->nextpouringdate,2,'Plant 4');
		        	$content['mtomsouth_reschedvolume'] = $mbooking_tom_south_resched['volume'];

		        	//Total Volume
		        	$content['mtomtotal_vol'] = $mbooking_tom_north['volume'] + $mbooking_tom_south['volume'];
		        $mbooking_tom_southfix = $this->dps_model->fetch_bookings_mobile($this->nextpouringdate,'Plant 4','fix');
		        $content['m_tom_southfix'] = $this->load->view($mbooking_tom_southfix['view'], $mbooking_tom_southfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$this->nextpouringdate,'Plant 4');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$this->nextpouringdate,'Plant 4');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$this->nextpouringdate,'Plant 4');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['tom_south_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);

		        
		        // Weekly scheduling by Ralph
		        if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isDPSCoordinator($this->lvl)){
		        	$content['lock_class'] = '';
		        	$content['waiting_class'] = '';
		        }else{
		        	$content['lock_class'] = 'disable-waiting';
		        	$content['waiting_class'] = 'view-only';
		        }

		        if($this->functionlist->isDPSsmd($this->lvl)){
		        	$content['issmd_man'] = 'yes';
		        }else{
		        	$content['issmd_man'] = 'no';
		        }

		        $this->dtNow = date("Y-m-d");
				$this->dtYesterday = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1));
				$this->dtTommorow = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1));
				$this->dtTommorow2 = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+2));
				$this->dtTommorow3 = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+3));


				$ctr = 1;
				$date_arr = array($this->dtYesterday,$this->dtNow,$this->dtTommorow,$this->dtTommorow2,$this->dtTommorow3);
				foreach ($date_arr as $sched_date) {
					//iterate through dates

					//echo $sched_date . '<br />';
					if($this->dps_model->check_if_queued($sched_date)){
						//
						//update for status=waiting
						$this->dps_model->update_w_scheds_waiting($sched_date);
					}else{
						//generate listing
						//get sales codes
						$sales_reps = $this->dps_model->get_sales_rep();
						foreach ($sales_reps as $row) {
						    $sales_code = $row['code'];
						    $this->dps_model->get_w_sched($sched_date,$sales_code);
						}
						//update for status=waiting
						$this->dps_model->update_w_scheds_waiting($sched_date);
						//update the queue order
						$this->dps_model->order_queue_list($sched_date);
					}


					$content['scheds'.$ctr] = $this->dps_model->get_weekly_sched($sched_date);

					$total_rows = 0;
					$total_north_rows = 0;
					$total_south_rows = 0;
					$total_volume = 0;
					$total_north = 0;
					$total_south = 0;

					foreach ($content['scheds'.$ctr] as $row) {
						if ($row['batching_plant'] == 'Plant 3'){
							$total_north = $total_north + $row['batch_vol'];
							$total_north_rows ++;
						}elseif($row['batching_plant'] == 'Plant 4'){
							$total_south = $total_south + $row['batch_vol'];
							$total_south_rows ++;
						}
					}

					$total_volume = $total_north + $total_south;
					$total_rows = $total_north_rows + $total_south_rows;

					$content['total_rows'][$ctr]= $total_rows;
					$content['total_north_rows'][$ctr]= $total_north_rows;
					$content['total_south_rows'][$ctr]= $total_south_rows;
					$content['total_volume'][$ctr]= $total_volume;
					$content['total_north'][$ctr]= $total_north;
					$content['total_south'][$ctr]= $total_south;
					$content['sched_date'][$ctr]= $sched_date;

					$ctr ++;
				}

				//pump summary 7-8-2016 by ralph ceriaco
				//updated nov 10 2016

				//today schedules
				$pumps1_arr['plant3'] = $this->dps_model->get_clientcount_pump(1,$this->dateNow,'Plant 3');
				$pumps1_arr['plant4'] = $this->dps_model->get_clientcount_pump(1,$this->dateNow,'Plant 4');
				$content['pumps1'] = $this->load->view($pumps1_arr['plant3']['view'],$pumps1_arr,true);

				$pumps2_arr['plant3'] = $this->dps_model->get_clientcount_pump(2,$this->dateNow,'Plant 3');
				$pumps2_arr['plant4'] = $this->dps_model->get_clientcount_pump(2,$this->dateNow,'Plant 4');
				$content['pumps2'] = $this->load->view($pumps2_arr['plant3']['view'],$pumps2_arr,true);

				$pumps3_arr['plant3'] = $this->dps_model->get_clientcount_pump(3,$this->dateNow,'Plant 3');
				$pumps3_arr['plant4'] = $this->dps_model->get_clientcount_pump(3,$this->dateNow,'Plant 4');
				$content['pumps3'] = $this->load->view($pumps3_arr['plant3']['view'],$pumps3_arr,true);

				$pumps4_arr['plant3'] = $this->dps_model->get_clientcount_pump(4,$this->dateNow,'Plant 3');
				$pumps4_arr['plant4'] = $this->dps_model->get_clientcount_pump(4,$this->dateNow,'Plant 4');
				$content['pumps4'] = $this->load->view($pumps4_arr['plant3']['view'],$pumps4_arr,true);



				$pumps1_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(1,$this->nextpouringdate,'Plant 3');
				$pumps1_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(1,$this->nextpouringdate,'Plant 4');
				$content['pumps1_tom'] = $this->load->view($pumps1_tom_arr['plant3']['view'],$pumps1_tom_arr,true);

				$pumps2_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(2,$this->nextpouringdate,'Plant 3');
				$pumps2_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(2,$this->nextpouringdate,'Plant 4');
				$content['pumps2_tom'] = $this->load->view($pumps2_tom_arr['plant3']['view'],$pumps2_tom_arr,true);

				$pumps3_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(3,$this->nextpouringdate,'Plant 3');
				$pumps3_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(3,$this->nextpouringdate,'Plant 4');
				$content['pumps3_tom'] = $this->load->view($pumps3_tom_arr['plant3']['view'],$pumps3_tom_arr,true);

				$pumps4_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(4,$this->nextpouringdate,'Plant 3');
				$pumps4_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(4,$this->nextpouringdate,'Plant 4');
				$content['pumps4_tom'] = $this->load->view($pumps4_tom_arr['plant3']['view'],$pumps4_tom_arr,true);

				// ADDED BY WBSOLON - 2019-12-09
				$content['today_over_all_pump'] = $this->dps_model->GetTotalPump($this->dateNow);
				$content['tom_over_all_pump'] = $this->dps_model->GetTotalPump($this->nextpouringdate);


		        $content['chatname'] = $this->session->userdata('nick');
		        $this->body['view'] = 'dps/index';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Daily Pouring Schedule');
		    }else{
		    	redirect('welcome/denied');
		    }
		    header("Refresh: 100200; URL=dps ");
		    //$this->ajax_write_usersonline();
        }else{
            redirect('main/login_dps');
        }
	}

	function contracts()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPSCoordinator($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl)){
				$content['status']='';
				$data = '';
				
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				//get the list of new contracts

		        $this->body['view'] = 'dps/contracts';
		        $this->body['content'] = $data;
		        $this->pagemaker->basePage($this->body,'Contracts');
		    }else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function newcontract()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPSCoordinator($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl)){
				$content['status']='';
				$data = '';
				
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

		        $this->body['view'] = 'dps/newcontract';
		        $this->body['content'] = $data;
		        $this->pagemaker->basePage($this->body,'New Contracts');
		    }else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}


	function addproject()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPSCoordinator($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
				$content['status']='';
				$data = $this->dps_model->get_recent_pouring();

				//display the login page to the user
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

		        $this->body['view'] = 'dps/addproject';
		        $this->body['content'] = $data;
		        $this->pagemaker->basePage($this->body,'Add Project');
		    }else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function addproject_form1()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
				$dateNow = date("Y-m-d");
				//display the form

				$data['status']='form1';

				//display the login page to the user
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				$data['custnames'] = $this->dps_model->get_customer_names();

				//get the list for the design
				$data['strength'] = $this->dps_model->get_design_strength();
				$data['agg'] = $this->dps_model->get_design_aggregates();
				$data['slump'] = $this->dps_model->get_design_slump();
				$data['pouringtype'] = $this->dps_model->get_design_pouringtype();
				$data['structure'] = $this->dps_model->get_design_structure();
				$data['salesengg'] = $this->dps_model->get_salesengg_list();
				$data['extlab'] = $this->dps_model->get_extlab_list();
				$data['datenow'] = $dateNow;
				$data['time'] = $this->functionlist->getDPSTimeArrays();



		        $this->body['view'] = 'dps/addprojectform1';
		        $this->body['content'] = $data;
		        $this->pagemaker->basePage($this->body,'Form 1');
		    }else{
		    	redirect('welcome/denied');
		    }
    	}else{
            redirect('main/login_dps');
        }
	}


	function addproject_form1a()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
				//set the date
				$dateNow = date("Y-m-d");
				//display the form

				if(isset($_GET['action'])){
					$action = $_GET['action'];

					//check if action is new or old booking

					if($action == 'new1a'){
						//load the page without data
						$data['pagestatus'] = 'new';
						$data['custnames'] = $this->dps_model->get_customer_names();
					}
						
					
				}else{
					//load the page with data
					$data['pagestatus'] = 'old';

					//get the post datas
					$data['client_id'] = $_POST['client_id'];
					$data['project_id'] = $_POST['project_id'];
					$data['project_name'] = $_POST['project_name'];
					$data['project_address'] = $_POST['project_address'];

					//get the data in the jlr customer
					$data['customerinfo'] = $this->dps_model->get_customer_info($data['client_id']);

					//get the data in the rmc_project_contact
					$data['projectcontact'] = $this->dps_model->get_project_contact($data['project_id']);
				}


				$data['status']='';

				//get the list for the design
				$data['strength'] = $this->dps_model->get_design_strength();
				$data['agg'] = $this->dps_model->get_design_aggregates();
				$data['slump'] = $this->dps_model->get_design_slump();
				$data['pouringtype'] = $this->dps_model->get_design_pouringtype();
				$data['structure'] = $this->dps_model->get_design_structure();
				$data['salesengg'] = $this->dps_model->get_salesengg_list();
				$data['extlab'] = $this->dps_model->get_extlab_list();
				$data['datenow'] = $dateNow;
				$data['time'] = $this->functionlist->getDPSTimeArrays();


				//display the login page to the user
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

		        $this->body['view'] = 'dps/addprojectform1a';
		        $this->body['content'] = $data;
		        $this->pagemaker->basePage($this->body,'Form 1A');
		        
		    }else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}


	function process_form1()
	{
		//set the date
		$dateNow = date("Y-m-d");

		$tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
        $dateTom = date("Y-m-d", $tomorrow);

        $form_number = $_POST['form-num'];

        

     	//check if checkboxes are checked or not
		$permit_citom = (isset($_POST['check-citom'])) ? "YES" : "NO";
		$permit_brgy = (isset($_POST['check-brgy'])) ? "YES" : "NO";
		$permit_hasentfee = (isset($_POST['check-hasentfee'])) ? $_POST['check-entfee'] : "NO";
		$permit_hasothers = (isset($_POST['check-hasothers'])) ? $_POST['check-others'] : "NO";

		$add_pipes = (isset($_POST['check-add-pipes'])) ? $_POST['add-pipes-num'] : "NO";
		$add_vibrator = (isset($_POST['check-add-vibrator'])) ? $_POST['add-vibrator-pesos'] : "NO";
		$add_slumpcone = (isset($_POST['check-add-slumpcone'])) ? "YES" : "NO";
		$add_beam = (isset($_POST['check-add-beam'])) ? "YES" : "NO";
		$add_others = (isset($_POST['check-add-others'])) ? $_POST['add-others-value'] : "NO";

		$special_service = ($_POST['check-service'] <> null) ? $_POST['check-service'] : "NO";
		$special_production = ($_POST['check-production'] <> null) ? $_POST['check-production'] : "NO";
		$special_qc = ($_POST['check-qc'] <> null) ? $_POST['check-qc'] : "NO";
		$special_forinspection = (isset($_POST['check-forinspection'])) ? "YES" : "NO";
		$special_forpouring = (isset($_POST['check-forpouring'])) ? "YES" : "NO";
		$special_se = ($_POST['special-sales-engg'] <> null) ? $_POST['special-sales-engg'] : "NO";

		$cust_id = $_POST['cust-name'];
		$project_name = strtoupper($_POST['project-name']);
		$project_location = strtoupper($_POST['project-location']);

		//added by ralph july 15, 2015
		$batchplant = $_POST['batchplant'];

		//added by ralph june 23, 2015
		$contract_no = $_POST['contract-num'];
		$po_no = $_POST['po-num'];

		//added by wbsolon Nov 19,2018
		$proj_code = (isset($_POST['check-prepaid'])) ? "1" : "0";

			//insert the project_customer
			//$client_id = $this->dps_model->insert_project_customer(mysqli_escape_string($_POST['cust-name']),$_POST['office-add']);
			//get the id and name of the customer
			$oldcustomer = $this->dps_model->get_old_custinfo($cust_id);
			foreach ($oldcustomer as $customer) {
				$customer = $customer->customer_name;
			}

		$dateadd = $dateNow;

			//insert the project_details
			$hash_formnum = "1# ". $form_number;

			$project_details_data = array(
			        'client_id' => $cust_id,
			        'form1_no' => $hash_formnum,
			        'project_name' => $project_name,
			        'project_location' => $project_location,
			        'contract_no' => $contract_no,
			        'date_added' => $dateadd
			);
		
			$project_id = $this->dps_model->insert_project_details($project_details_data);

		//insert the project_contacts
		$contacts_acctg = (isset($_POST['accounting'])) ? $_POST['accounting'] : "n/a";
		$contacts_acctgnum = (isset($_POST['accounting-phone'])) ? $_POST['accounting-phone'] : "n/a";
		$contacts_witness = (isset($_POST['witness'])) ? $_POST['witness'] : "n/a";
		$contacts_witnessnum = (isset($_POST['witness-phone'])) ? $_POST['witness-phone'] : "n/a";

		

		//$_POST['accounting'],$_POST['accounting-phone'],$_POST['witness'],$_POST['witness-phone']
		$this->dps_model->insert_project_contacts($project_id,$_POST['owner'],$_POST['owner-phone'],$_POST['engg-foreman'],$_POST['engg-foreman-phone'],$contacts_acctg,$contacts_acctgnum,$contacts_witness,$contacts_witnessnum);

						
		//Landmark Post Datas
		$landmark_across = ($_POST['landmark-across'] <> null) ? $_POST['landmark-across'] : "NA";
		$landmark_right = ($_POST['landmark-right'] <> null) ? $_POST['landmark-right'] : "NA";
		$landmark_left = ($_POST['landmark-left'] <> null) ? $_POST['landmark-left'] : "NA";
		$landmark_sketch = ($_POST['landmark-sketch'] <> null) ? $_POST['landmark-sketch'] : "NA";

			//update the project landmark description
			$this->dps_model->insert_project_landmark($project_id,$landmark_across,$landmark_right,$landmark_left,$landmark_sketch);

						//loop for the project_designs post variables
						$counter = $_POST['designtable-ctr'];

						$ctr = 1;
						while ( $ctr <> $counter+1) {
								$strength = $_POST['strength' . $ctr];
								$agg = $_POST['agg' . $ctr];
								$curing = $_POST['curing' . $ctr];
								$slump = $_POST['slump' . $ctr];
								$pouring = $_POST['pouring' . $ctr];
								$struct = strtoupper($_POST['struct' . $ctr]);
								$remarks = $_POST['remarks' . $ctr];
								$estvolume = $_POST['estvolume' . $ctr];
								$scheddate = $_POST['scheddate' . $ctr];
								$schedtime = $_POST['schedtime' . $ctr];
								$mod_date = $scheddate;
								$mod_time = $schedtime;
								$designstatus = $_POST['designstatus' . $ctr];

								/*

								switch ($slump) {
									case 'S4':
										$slump = '4"-6"';
										break;
									case 'S6':
										$slump = '6"-8"';
										break;
									case 'S8':
										$slump = '8"-10"';
										break;
									case 'Flow':
										$slump = 'Flow';
										break;
									
								}
								*/

							/*
								check design date
								Today-Timebook(0-1200) - pouring date is today - status=insert
								Today-Timebook(1201-2359) - pouring date is today - status=insert
								Today-Timebook(0-1200) - pouring date is tomorrow - status=good
								Today-Timebook(1201-2359) - pouring date is tomorrow - status=insert

								if date is not today/tomorrow(for advanced booking) then
								time is 8-12 ====>
								time is 1-above ===>

								override this options when the design status = for confirmation
							*/
							$timenow = date('Hi');

							if($designstatus != 'For Confirmation'){
								//if not confirmation then check others

								switch ($mod_date) {
									case $dateNow:  //if scheduled pouring date is today
										if($timenow >= '0000' OR $timenow <= '1200'){
											$designstatus = 'Insert';
										}elseif($timenow >= '1201' OR $timenow <= '2359'){
											$designstatus = 'Insert';
										}
										break;

									case $dateTom:  //if scheduled pouring date is tomorrow
										if($timenow >= '0000' OR $timenow <= '1200'){
											$designstatus = 'Okay';
										}elseif($timenow >= '1201' OR $timenow <= '2359'){
											$designstatus = 'Insert';
										}
										break;
									
									default:
										if($mod_date <> $dateNow OR $mod_date <> $dateTom){
											//advance booking
											//all design status is normal/okay
											$designstatus = 'Okay';
										}
										break;
								}

							}
	
							//plant cast added by ralph feb 28, 2014
							$samp_plantcast = (isset($_POST['check-plantcast'])) ? "YES" : "NO";
							//pouring and finishing contacts --> added by ralph feb 28, 2014
							$pouring_engr = (isset($_POST['pour-engg'])) ? $_POST['pour-engg'] : "n/a";
							$pouring_con = (isset($_POST['pour-engg-phone'])) ? $_POST['pour-engg-phone'] : "n/a";
							$finishing_coor = (isset($_POST['fin-coor'])) ? $_POST['fin-coor'] : "n/a";
							$finishing_con = (isset($_POST['fin-coor-phone'])) ? $_POST['fin-coor-phone'] : "n/a";

							$project_design_data = array(
						        'project_id' => $project_id,
						        'client_id' => $cust_id,
						        'form_type' => '1',
						        'form_no' => $form_number,
						        'proj_code' => $proj_code,
						        'cust_name' => $customer,
						        'proj_name' => $project_name,
						        'proj_address' => $project_location,
						        'book_psi' => $strength,
						        'book_msa' => $agg,
			                    'book_cd' => $curing,
			                    'book_sp' => $slump,
			                    'pour_type' => $pouring,
			                    'structure' => $struct,
			                    'remarks' => $remarks,
			                    'batch_vol' => $estvolume,
			                    'sched_date' => $scheddate,
			                    'sched_time' => $schedtime,
			                    'modified_date' => $mod_date,
			                    'modified_time' => $mod_time,
			                    'permit_citom' => $permit_citom,
			                    'permit_brgy' => $permit_brgy,
			                    'permit_entrancefee' => $permit_hasentfee,
			                    'permit_others' => $permit_hasothers,
			                    'add_pipes' => $add_pipes,
			                    'add_vibrator' => $add_vibrator,
			                    'add_slumpcone' => $add_slumpcone,
			                    'add_beam' => $add_beam,
			                    'add_others' => $add_others,
			                    'special_service' => $special_service,
			                    'special_production' => $special_production,
			                    'special_qc' => $special_qc,
			                    'special_forinspection' => $special_forinspection,
			                    'special_forpouring' => $special_forpouring,
			                    'special_se' => $special_se,
			                    'contract_no' => $contract_no,
			                    'po_no' => $po_no,
			                    'coor_status' => 'Unapproved',
			                    'design_status' => $designstatus,
			                    'manager_status' => 'Unapproved',
			                    'plant_cast' => $samp_plantcast,
			                    'pouring_engr' => $pouring_engr,
			                    'pouring_contact' => $pouring_con,
			                    'finishing_coor' => $finishing_coor,
			                    'finishing_contact' => $finishing_con,
			                    'time_encoded' => $this->timeNow,
			                    'batching_plant' => $batchplant
							);
							$this->dps_model->insert_project_design($project_design_data);

							$ctr ++;

							header('location:addproject');  //redirect
						}
						

						//Sampling Procedure Post Datas checking
						$samp_standard = 'NO';
						$samp_others = 'NO';
						switch ($_POST['check-sampling']) {
							case 'standard':
								$samp_standard = 'YES';
								break;
							
							case 'others':
								$samp_others = 'YES';
								break;

						}
						//$samp_standard = ($_POST['check-sampling'] = "standard") ? "YES" : "NO";
						//$samp_others = ($_POST['check-sampling'] = "others") ? "YES" : "NO";
						$samp_oth_cylinder = ($_POST['cylinders'] <> null) ? $_POST['cylinders'] : "NA";
						$samp_oth_cubic = ($_POST['cubic-meters'] <> null) ? $_POST['cubic-meters'] : "NA";

						$samp_standard_cyl_no = ($_POST['samp-standard-cyl'] <> null) ? $_POST['samp-standard-cyl'] : "0";
						$samp_standard_beam_no = ($_POST['samp-standard-beam'] <> null) ? $_POST['samp-standard-beam'] : "0";

						

						//Curing Post Datas
						$curing_atsite = (isset($_POST['check-atsite'])) ? "YES" : "NO";
						$curing_atjlr = (isset($_POST['check-atjlr'])) ? "YES" : "NO";

						//Testing Schedule Post Datas
						$testing_jlr = (isset($_POST['check-testing-jlrlab'])) ? "YES" : "NO";
						$testing_ext = (isset($_POST['check-testing-external'])) ? "YES" : "NO";

						$testing_jlr3 = (isset($_POST['test-jlr-7'])) ? "YES" : "NO";
						$testing_jlr7 = (isset($_POST['test-jlr-7'])) ? "YES" : "NO";
						$testing_jlr14 = (isset($_POST['test-jlr-14'])) ? "YES" : "NO";
						$testing_jlr28 = (isset($_POST['test-jlr-28'])) ? "YES" : "NO";
						$testing_jlrspare = (isset($_POST['test-jlr-spare'])) ? "YES" : "NO";

						$testing_ext7 = (isset($_POST['test-ext-7'])) ? "YES" : "NO";
						$testing_ext14 = (isset($_POST['test-ext-14'])) ? "YES" : "NO";
						$testing_ext28 = (isset($_POST['test-ext-28'])) ? "YES" : "NO";
						$testing_extspare = (isset($_POST['test-ext-spare'])) ? "YES" : "NO";

						$testing_ext7_beam = (isset($_POST['test-ext-beam-7'])) ? "YES" : "NO";
						$testing_ext14_beam = (isset($_POST['test-ext-beam-14'])) ? "YES" : "NO";
						$testing_ext28_beam = (isset($_POST['test-ext-beam-28'])) ? "YES" : "NO";
						$testing_extspare_beam = (isset($_POST['test-ext-beam-spare'])) ? "YES" : "NO";


						$testing_extlabname = (isset($_POST['ext-labname'])) ? $_POST['ext-labname'] : "NA";
						$testing_colab = ($_POST['co_lab'] <> null) ? $_POST['co_lab'] : "NA";
						
						//external lab name insert it

						//Witness Post Datas
						switch ($_POST['client-witness']) {
							case 'with':
								$client_witness = 'YES';
								$consultant_name = ($_POST['consultant-name'] <> null) ? $_POST['consultant-name'] : "NA";
								$consultant_num = ($_POST['consultant-num'] <> null) ? $_POST['consultant-num'] : "NA";
								break;
							case 'without':
								$client_witness = 'NO';
								$consultant_name = ($_POST['consultant-name'] <> null) ? $_POST['consultant-name'] : "NA";
								$consultant_num = ($_POST['consultant-num'] <> null) ? $_POST['consultant-num'] : "NA";
								break;
							case 'sameas':
								$client_witness = 'SAME';
								$consultant_name = ($_POST['witness'] <> null) ? $_POST['witness'] : "NA";
								$consultant_num = ($_POST['witness-num'] <> null) ? $_POST['witness-num'] : "NA";
								break;	
						}

						$qcData = array(
							'project_id' 	=> $project_id,
							'samp_standard' => $samp_standard,
							'samp_standard_cyl_no' => $samp_standard_cyl_no,
							'samp_standard_beam_no' => $samp_standard_beam_no,
                            'samp_others' 	=> $samp_others,
                            'oth_cyl' 		=> $samp_oth_cylinder,
                            'oth_m3' 		=> $samp_oth_cubic,
                            'curing_asite' 	=> $curing_atsite,
                            'curing_ajlr' 	=> $curing_atjlr,
                            'test_jlr' 		=> $testing_jlr,
                            'test_extlab' 	=> $testing_ext,
                            'test_jlr_3' 	=> $testing_jlr3,
                            'test_jlr_7' 	=> $testing_jlr7,
                            'test_jlr_14' 	=> $testing_jlr14,
                            'test_jlr_28' 	=> $testing_jlr28,
                            'test_jlr_spare'=> $testing_jlrspare,
                            'ex_lab' 		=> $testing_extlabname,
                            'co_elab' 		=> $testing_colab,
                            'test_elab_7' 	=> $testing_ext7,
                            'test_elab_14' 	=> $testing_ext14,
                            'test_elab_28' 	=> $testing_ext28,
                            'test_elab_spare' 	=> $testing_extspare,
                            'test_elab_beam_7' 	=> $testing_ext7_beam,
                            'test_elab_beam_14' 	=> $testing_ext14_beam,
                            'test_elab_beam_28' 	=> $testing_ext28_beam,
                            'test_elab_beam_spare' 	=> $testing_extspare_beam,
                            'witness_presence' 	=> $client_witness,
                            'consultant_name' 	=> $consultant_name,
                            'consultant_num' 	=> $consultant_num
						);
						
						$this->dps_model->insert_project_qc($qcData);
	}

	function process_form1a()
	{

		$form_status = $_POST['form1astatus'];
		//get ID post datas
		$form_number = $_POST['form-num'];

		//set the date
		$dateNow = date("Y-m-d");
		//check if checkboxes are checked or not
		$permit_citom = (isset($_POST['check-citom'])) ? "YES" : "NO";
		$permit_brgy = (isset($_POST['check-brgy'])) ? "YES" : "NO";
		$permit_hasentfee = (isset($_POST['check-hasentfee'])) ? $_POST['check-entfee'] : "NO";
		$permit_hasothers = (isset($_POST['check-hasothers'])) ? $_POST['check-others'] : "NO";

		$add_pipes = (isset($_POST['check-add-pipes'])) ? $_POST['add-pipes-num'] : "NO";
		$add_vibrator = (isset($_POST['check-add-vibrator'])) ? $_POST['add-vibrator-pesos'] : "NO";
		$add_slumpcone = (isset($_POST['check-add-slumpcone'])) ? "YES" : "NO";
		$add_beam = (isset($_POST['check-add-beam'])) ? "YES" : "NO";
		$add_others = (isset($_POST['check-add-others'])) ? $_POST['add-others-value'] : "NO";

		$special_service = ($_POST['check-service'] <> null) ? $_POST['check-service'] : "NO";
		$special_production = ($_POST['check-production'] <> null) ? $_POST['check-production'] : "NO";
		$special_qc = ($_POST['check-qc'] <> null) ? $_POST['check-qc'] : "NO";
		$special_forinspection = (isset($_POST['check-forinspection'])) ? "YES" : "NO";
		$special_forpouring = (isset($_POST['check-forpouring'])) ? "YES" : "NO";
		$special_se = ($_POST['special-sales-engg'] <> null) ? $_POST['special-sales-engg'] : "NO";
		$dateadd = $dateNow;

		//added by ralph july 15, 2015
		$batchplant = $_POST['batchplant'];

		//added by ralph june 23, 2015
		$contract_no = $_POST['contract-num'];
		$po_no = $_POST['po-num'];

		//added by wbsolon Nov 19,2018
		$proj_code = (isset($_POST['check-prepaid'])) ? "1" : "0";

		if($form_status == 'new'){
			$project_id = $_POST['project-id'];
			$project_name = strtoupper($_POST['project-name']);
			$project_location = strtoupper($_POST['location']);
			$cust_id = $_POST['cust-name'];
			
			//get the id and name of the customer
			$oldcustomer = $this->dps_model->get_old_custinfo($cust_id);
			foreach ($oldcustomer as $customer) {
				$customer = $customer->customer_name;
			}
			
			
		}else{
			$client_id = (isset($_POST['client-id']))? $_POST['client-id'] : "";
			$project_id = (isset($_POST['project-id']))? $_POST['project-id'] : "";

			$project_name = strtoupper($_POST['project-name']);
			$project_location = strtoupper($_POST['location']);
			$cust_id = $_POST['cust-name'];

			$customer = strtoupper($_POST['customer']);
		}
			
			//insert project list if the project is new but the clinet is not new
			//insert the project_details
			//$project_id = $this->dps_model->insert_project_details($client_id,$form_number,$project_name,$project_address,$dateadd);

			//insert the project_contacts
			//$this->dps_model->insert_project_contacts($project_id,$_POST['owner'],$_POST['owner-phone'],$_POST['engg-foreman'],$_POST['engg-foreman-phone'],$_POST['accounting'],$_POST['accounting-phone'],$_POST['witness'],$_POST['witness-phone']);
		

		

		//loop for the project_designs post variables
		$counter = $_POST['designtable-ctr'];

		$ctr = 1;
		while ( $ctr <> $counter+1) {
				$strength = $_POST['strength' . $ctr];
				$agg = $_POST['agg' . $ctr];
				$curing = $_POST['curing' . $ctr];
				$slump = $_POST['slump' . $ctr];
				$pouring = $_POST['pouring' . $ctr];
				$struct = strtoupper($_POST['struct' . $ctr]);
				$remarks = $_POST['remarks' . $ctr];
				$estvolume = $_POST['estvolume' . $ctr];
				$scheddate = $_POST['scheddate' . $ctr];
				$schedtime = $_POST['schedtime' . $ctr];
				$mod_date = $scheddate;
				$mod_time = $schedtime;
				$designstatus = $_POST['designstatus' . $ctr];

				/*

				switch ($slump) {
					case 'S4':
						$slump = '4"-6"';
						break;
					case 'S6':
						$slump = '6"-8"';
						break;
					case 'S8':
						$slump = '8"-10"';
						break;
					case 'Flow':
						$slump = 'Flow';
						break;
									
				}
				*/

				/*
					check design date
					Today-Timebook(0-1200) - pouring date is today - status=insert
					Today-Timebook(1201-2359) - pouring date is today - status=insert
					Today-Timebook(0-1200) - pouring date is tomorrow - status=good
					Today-Timebook(1201-2359) - pouring date is tomorrow - status=insert

					if date is not today/tomorrow(for advanced booking) then
					time is 8-12 ====>
					time is 1-above ===>

					override this options when the design status = for confirmation
				*/
				$timenow = date('Hi');

				if($designstatus != 'For Confirmation'){
					//if not confirmation then check others

					switch ($mod_date) {
						case $dateNow:  //if scheduled pouring date is today
							if($timenow >= '0000' OR $timenow <= '1200'){
								$designstatus = 'Insert';
							}elseif($timenow >= '1201' OR $timenow <= '2359'){
								$designstatus = 'Insert';
							}
							break;

						case $dateTom:  //if scheduled pouring date is tomorrow
							if($timenow >= '0000' OR $timenow <= '1200'){
								$designstatus = 'Okay';
							}elseif($timenow >= '1201' OR $timenow <= '2359'){
								$designstatus = 'Insert';
							}
							break;
						
						default:
							if($mod_date <> $dateNow OR $mod_date <> $dateTom){
								//advance booking
								//all design status is normal/okay
								$designstatus = 'Okay';
							}
							break;
					}

				}

				//plant cast added by ralph feb 28, 2014
				$samp_plantcast = (isset($_POST['check-plantcast'])) ? "YES" : "NO";
				$pouring_engr = (isset($_POST['pour-engg'])) ? $_POST['pour-engg'] : "n/a";
				$pouring_con = (isset($_POST['pour-engg-phone'])) ? $_POST['pour-engg-phone'] : "n/a";
				$finishing_coor = (isset($_POST['fin-coor'])) ? $_POST['fin-coor'] : "n/a";
				$finishing_con = (isset($_POST['fin-coor-phone'])) ? $_POST['fin-coor-phone'] : "n/a";

				//added by ralph for the priority number
				//$last_num = $this->dps_model->get_priority_num($date,$plant);
				//$priority_num = $last_num + 1;
			
				//insert them into the database
				$project_design_data = array(
			        'project_id' => $project_id,
			        'client_id' => $cust_id,
			        'form_type' => '1A',
			        'form_no' => $form_number,
			        'proj_code' => $proj_code,
			        'cust_name' => $customer,
			        'proj_name' => $project_name,
			        'proj_address' => $project_location,
			        'book_psi' => $strength,
			        'book_msa' => $agg,
                    'book_cd' => $curing,
                    'book_sp' => $slump,
                    'pour_type' => $pouring,
                    'structure' => $struct,
                    'remarks' => $remarks,
                    'batch_vol' => $estvolume,
                    'sched_date' => $scheddate,
                    'sched_time' => $schedtime,
                    'modified_date' => $mod_date,
                    'modified_time' => $mod_time,
                    'permit_citom' => $permit_citom,
                    'permit_brgy' => $permit_brgy,
                    'permit_entrancefee' => $permit_hasentfee,
                    'permit_others' => $permit_hasothers,
                    'add_pipes' => $add_pipes,
                    'add_vibrator' => $add_vibrator,
                    'add_slumpcone' => $add_slumpcone,
                    'add_beam' => $add_beam,
                    'add_others' => $add_others,
                    'special_service' => $special_service,
                    'special_production' => $special_production,
                    'special_qc' => $special_qc,
                    'special_forinspection' => $special_forinspection,
                    'special_forpouring' => $special_forpouring,
                    'special_se' => $special_se,
                    'contract_no' => $contract_no,
                    'po_no' => $po_no,
                    'coor_status' => 'Unapproved',
                    'design_status' => $designstatus,
                    'manager_status' => 'Unapproved',
                    'plant_cast' => $samp_plantcast,
                    'pouring_engr' => $pouring_engr,
                    'pouring_contact' => $pouring_con,
                    'finishing_coor' => $finishing_coor,
                    'finishing_contact' => $finishing_con,
                    'time_encoded' => $this->timeNow,
                    'batching_plant' => $batchplant
				);
				$this->dps_model->insert_project_design($project_design_data);
				$ctr ++;

				header('location:addproject');  //redirect
		}
	}

	function ajax_getprojectby_cust(){
		$id = $_POST['id'];

		$projectlist = $this->dps_model->getprojectby_cust($id);

		
		echo "<option value=''>PLEASE SELECT</option>";
				foreach ($projectlist as $list) {
					$list->project_name;
					$list->project_location;
					echo "<option value='$list->project_location' id='$list->o8_id'>$list->project_name</option>";
				}
	}


	


	// function scheduler()
	// {
	// 	if($this->session->userdata('is_logged_in')){
	// 		if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl)){

	// 			//cache the page
	// 			//$this->output->cache(1);
	// 			$data['status']='';
	// 			$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

	// 			// //today coor
	// 			// $batchsched_today_coor = $this->dps_model->get_batch_schedule($this->dateNow,'coor');
	// 			// $data['batchsched_today_coor'] = $this->load->view($batchsched_today_coor['view'],$batchsched_today_coor,true);

	// 			// //today smd
	// 			// $batchsched_today_smd = $this->dps_model->get_batch_schedule($this->dateNow,'smd');
	// 			// $data['batchsched_today_smd'] = $this->load->view($batchsched_today_smd['view'], $batchsched_today_smd,true);
				

	// 			// if($this->session->userdata('nextpouring') != ''){
	// 			// 	$this->nextpouringdate = $this->session->userdata('nextpouring');
	// 			// 	//unset the session for next pouring
	// 			// 	$this->session->unset_userdata('nextpouring');
	// 			// }
					
	// 			// //next day coor
	// 			// $batchsched_nextday_coor = $this->dps_model->get_batch_schedule($this->nextpouringdate,'coor');
	// 			// $data['batchsched_nextday_coor'] = $this->load->view($batchsched_nextday_coor['view'],$batchsched_nextday_coor,true);

	// 			// //nextday smd
	// 			// $batchsched_nextday_smd = $this->dps_model->get_batch_schedule($this->nextpouringdate,'smd');
	// 			// $data['batchsched_nextday_smd'] = $this->load->view($batchsched_nextday_smd['view'], $batchsched_nextday_smd,true);


	// 		    $this->body['view'] = 'dps/scheduler';
	// 		    $this->body['content'] = $data;
	// 		    $this->pagemaker->basePage($this->body,'Scheduler');
	// 		}else{
	// 	    	redirect('welcome/denied');
	// 	    }
	// 	}else{
 //            redirect('main/login_dps');
 //        }
	// }

	function schedulerweekly()
	{
		
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl)){

				//cache the page
				//$this->output->cache(1);
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				$this->dtNow = date("Y-m-d");
				$this->dtYesterday = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1));
				$this->dtTommorow = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1));
				$this->dtTommorow2 = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+2));
				$this->dtTommorow3 = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+3));


				$ctr = 1;
				$date_arr = array($this->dtYesterday,$this->dtNow,$this->dtTommorow,$this->dtTommorow2,$this->dtTommorow3);
				foreach ($date_arr as $sched_date) {
					//iterate through dates

					//echo $sched_date . '<br />';
					if($this->dps_model->check_if_queued($sched_date)){
						//
						//update for status=waiting
						$this->dps_model->update_w_scheds_waiting($sched_date);
					}else{
						//generate listing
						//get sales codes
						$sales_reps = $this->dps_model->get_sales_rep();
						foreach ($sales_reps as $row) {
						    $sales_code = $row['code'];
						    $this->dps_model->get_w_sched($sched_date,$sales_code);
						}
						//update for status=waiting
						$this->dps_model->update_w_scheds_waiting($sched_date);
						//update the queue order
						$this->dps_model->order_queue_list($sched_date);
					}


					$data['scheds'.$ctr] = $this->dps_model->get_weekly_sched($sched_date);

					$total_rows = 0;
					$total_north_rows = 0;
					$total_south_rows = 0;
					$total_volume = 0;
					$total_north = 0;
					$total_south = 0;

					foreach ($data['scheds'.$ctr] as $row) {
						if ($row['batching_plant'] == 'Plant 3'){
							$total_north = $total_north + $row['batch_vol'];
							$total_north_rows ++;
						}elseif($row['batching_plant'] == 'Plant 4'){
							$total_south = $total_south + $row['batch_vol'];
							$total_south_rows ++;
						}
					}

					$total_volume = $total_north + $total_south;
					$total_rows = $total_north_rows + $total_south_rows;

					$data['total_rows'][$ctr]= $total_rows;
					$data['total_north_rows'][$ctr]= $total_north_rows;
					$data['total_south_rows'][$ctr]= $total_south_rows;
					$data['total_volume'][$ctr]= $total_volume;
					$data['total_north'][$ctr]= $total_north;
					$data['total_south'][$ctr]= $total_south;
					$data['sched_date'][$ctr]= $sched_date;

					$ctr ++;
				}

				

				
				



			    $this->body['view'] = 'dps/schedulerweekly2';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Scheduler Weekly');
			}else{
		    	redirect('welcome/denied');
		    }		
	}

	function schedulertoday()
	{
		
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl) 
					|| $this->functionlist->isRMCMangerSMDView($this->lvl) || $this->functionlist->isCVR($this->lvl) ){

				//cache the page
				//$this->output->cache(1);
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				//ADDED BY WBSOLON 12/13/2019
				$data['pour_result'] = $this->dps_model->get_batch_pourtype($this->dateNow);
				
				if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSCoordinator($this->lvl)
					|| $this->functionlist->isRMCMangerSMDView($this->lvl) ){
					//today coor
					$batchsched_today_coor = $this->dps_model->get_batch_schedule($this->dateNow,'coor');
					$batchsched_today_coor['whatday'] = 'today';
					$batchsched_today_coor['qareps'] = $this->dps_model->fetch_qareps();
					$data['batchsched_today_coor'] = $this->load->view($batchsched_today_coor['view'],$batchsched_today_coor,true);
					// echo '<pre>';
					// var_dump($batchsched_today_coor);
					// echo '</pre>';
							 	
				}

				if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSsmd($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
					//today smd
					$batchsched_today_smd = $this->dps_model->get_batch_schedule($this->dateNow,'smd');
					$batchsched_today_smd['whatday'] = 'today';
					$data['batchsched_today_smd'] = $this->load->view($batchsched_today_smd['view'], $batchsched_today_smd,true);
				}

				//added by ralph april 7, 2014 for the smd approval [mobile version]
				if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSsmd($this->lvl)
					 ){
					//today smd [mobile]
					$batchsched_today_smd_m = $this->dps_model->get_batch_schedule($this->dateNow,'mobile');
					$batchsched_today_smd_m['whatday'] = 'today';
					$data['batchsched_today_smd_m'] = $this->load->view($batchsched_today_smd_m['view'], $batchsched_today_smd_m,true);
				}
				
			    $this->body['view'] = 'dps/schedulertoday';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Scheduler Today');

			    //$this->output->enable_profiler(TRUE);
			}else{
		    	redirect('welcome/denied');
		    }
	}

	function schedulertom()
	{
		
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl) 
				|| $this->functionlist->isRMCMangerSMDView($this->lvl) || $this->functionlist->isCVR($this->lvl) ){

				//cache the page
				//$this->output->cache(1);
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				

				if($this->session->userdata('nextpouring') != ''){
					$this->nextpouringdate = $this->session->userdata('nextpouring');
					//unset the session for next pouring
					$this->session->unset_userdata('nextpouring');
				}
					
				//ADDED BY WBSOLON 12/13/2019
				$data['pour_result'] = $this->dps_model->get_batch_pourtype($this->nextpouringdate);

				if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSCoordinator($this->lvl) 
					|| $this->functionlist->isRMCMangerSMDView($this->lvl) ){
					//next day coor
					$batchsched_nextday_coor = $this->dps_model->get_batch_schedule($this->nextpouringdate,'coor');
					$batchsched_nextday_coor['whatday'] = 'nextday';
					$data['batchsched_nextday_coor'] = $this->load->view($batchsched_nextday_coor['view'],$batchsched_nextday_coor,true);
				}

				if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSsmd($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl) ){
					//nextday smd
					$batchsched_nextday_smd = $this->dps_model->get_batch_schedule($this->nextpouringdate,'smd');
					$batchsched_nextday_smd['whatday'] = 'nextday';
					$data['batchsched_nextday_smd'] = $this->load->view($batchsched_nextday_smd['view'], $batchsched_nextday_smd,true);
				}

				if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSsmd($this->lvl) 
					 ){
					//nextday smd
					$batchsched_nextday_smd_m = $this->dps_model->get_batch_schedule($this->nextpouringdate,'mobile');
					$batchsched_nextday_smd_m['whatday'] = 'nextday';
					$data['batchsched_nextday_smd_m'] = $this->load->view($batchsched_nextday_smd_m['view'], $batchsched_nextday_smd_m,true);
				}


			    $this->body['view'] = 'dps/schedulertom';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Scheduler Next Day');
			}else{
		    	redirect('welcome/denied');
		    }
	}

	function schedulersat()
	{
		
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl) 
				|| $this->functionlist->isRMCMangerSMDView($this->lvl) ){

				//cache the page
				//$this->output->cache(1);
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				$this->dateSat = date('Y-m-d', strtotime('this Saturday'));
				$this->dateSat_1 = date('m-d', strtotime('this Saturday'));

				//ADDED BY WBSOLON 12/13/2019
				$data['pour_result'] = $this->dps_model->get_batch_pourtype($this->dateSat);

				if($this->dps_model->isDateHoliday($this->dateSat_1)){
					//just display a message // its a holiday
					$data['status']='This date is a holiday in the system and considered as No Pouring date.';
					$data['display'] = 'no';
				}else{
					$data['display'] = 'yes';
					if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSCoordinator($this->lvl) 
						|| $this->functionlist->isRMCMangerSMDView($this->lvl) ){
						//next day coor
						$batchsched_nextday_coor = $this->dps_model->get_batch_schedule($this->dateSat,'coor');
						$batchsched_nextday_coor['whatday'] = 'sat';
						$data['batchsched_nextday_coor'] = $this->load->view($batchsched_nextday_coor['view'],$batchsched_nextday_coor,true);
					}

					if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSsmd($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
						//nextday smd
						$batchsched_nextday_smd = $this->dps_model->get_batch_schedule($this->dateSat,'smd');
						$batchsched_nextday_smd['whatday'] = 'sat';
						$data['batchsched_nextday_smd'] = $this->load->view($batchsched_nextday_smd['view'], $batchsched_nextday_smd,true);
					}

					if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSsmd($this->lvl)){
						//nextday smd
						$batchsched_nextday_smd_m = $this->dps_model->get_batch_schedule($this->dateSat,'mobile');
						$batchsched_nextday_smd_m['whatday'] = 'sat';
						$data['batchsched_nextday_smd_m'] = $this->load->view($batchsched_nextday_smd_m['view'], $batchsched_nextday_smd_m,true);
					}
				}
			
			    $this->body['view'] = 'dps/schedulersat';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Scheduler Saturday');
			}else{
		    	redirect('welcome/denied');
		    }
	}

	function schedulersun()
	{
		
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl) 
				|| $this->functionlist->isRMCMangerSMDView($this->lvl) ){

				//cache the page
				//$this->output->cache(1);
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				

				$this->dateSun = date('Y-m-d', strtotime('this Sunday'));

				//ADDED BY WBSOLON 12/13/2019
				$data['pour_result'] = $this->dps_model->get_batch_pourtype($this->dateSun);

				if($this->dps_model->isDateHoliday('SUNDAY')){
					//just display a message // its a holiday
					$data['status']='This date is a holiday in the system and considered as No Pouring date.';
					$data['display'] = 'no';
				}else{
					$data['display'] = 'yes';
					if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSCoordinator($this->lvl) 
						|| $this->functionlist->isRMCMangerSMDView($this->lvl) ){
						//next day coor
						$batchsched_nextday_coor = $this->dps_model->get_batch_schedule($this->dateSun,'coor');
						$batchsched_nextday_coor['whatday'] = 'sun';
						$data['batchsched_nextday_coor'] = $this->load->view($batchsched_nextday_coor['view'],$batchsched_nextday_coor,true);
					}

					if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSsmd($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
						//nextday smd
						$batchsched_nextday_smd = $this->dps_model->get_batch_schedule($this->dateSun,'smd');
						$batchsched_nextday_smd['whatday'] = 'sun';
						$data['batchsched_nextday_smd'] = $this->load->view($batchsched_nextday_smd['view'], $batchsched_nextday_smd,true);
					}

					if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSsmd($this->lvl)){
						//nextday smd
						$batchsched_nextday_smd_m = $this->dps_model->get_batch_schedule($this->dateSun,'mobile');
						$batchsched_nextday_smd_m['whatday'] = 'sun';
						$data['batchsched_nextday_smd_m'] = $this->load->view($batchsched_nextday_smd_m['view'], $batchsched_nextday_smd_m,true);
					}
				}


			    $this->body['view'] = 'dps/schedulersun';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Scheduler Sunday');
			}else{
		    	redirect('welcome/denied');
		    }
	}

	function schedulermon()
	{
		
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl) 
				|| $this->functionlist->isRMCMangerSMDView($this->lvl) ){

				//cache the page
				//$this->output->cache(1);
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				

				$this->dateMon = date('Y-m-d', strtotime('this Monday'));

				//ADDED BY WBSOLON 12/13/2019
				$data['pour_result'] = $this->dps_model->get_batch_pourtype($this->dateMon);

				if($this->dps_model->isDateHoliday($this->dateMon)){
					//just display a message // its a holiday
					$data['status']='This date is a holiday in the system and considered as No Pouring date.';
					$data['display'] = 'no';
				}else{
					$data['display'] = 'yes';
					if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSCoordinator($this->lvl) 
						|| $this->functionlist->isRMCMangerSMDView($this->lvl) ){
						//next day coor
						$batchsched_nextday_coor = $this->dps_model->get_batch_schedule($this->dateMon,'coor');
						$batchsched_nextday_coor['whatday'] = 'mon';
						$data['batchsched_nextday_coor'] = $this->load->view($batchsched_nextday_coor['view'],$batchsched_nextday_coor,true);
					}

					if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSsmd($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
						//nextday smd
						$batchsched_nextday_smd = $this->dps_model->get_batch_schedule($this->dateMon,'smd');
						$batchsched_nextday_smd['whatday'] = 'mon';
						$data['batchsched_nextday_smd'] = $this->load->view($batchsched_nextday_smd['view'], $batchsched_nextday_smd,true);
					}

					if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isCVR($this->lvl) OR $this->functionlist->isDPSsmd($this->lvl)){
						//nextday smd
						$batchsched_nextday_smd_m = $this->dps_model->get_batch_schedule($this->dateMon,'mobile');
						$batchsched_nextday_smd_m['whatday'] = 'mon';
						$data['batchsched_nextday_smd_m'] = $this->load->view($batchsched_nextday_smd_m['view'], $batchsched_nextday_smd_m,true);
					}
				}


			    $this->body['view'] = 'dps/schedulermon';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Scheduler Monday');
			}else{
		    	redirect('welcome/denied');
		    }
	}

	function update_sched_date()
	{
		//get post data
		$id = $_POST['id'];
		$sched_date = $_POST['date'];


		$sched_time = $_POST['time'];
		$old_time = $_POST['oldtime'];

		$smd_status = $_POST['smd_status'];


		if($sched_time <> $old_time ){
			$smd_status = 'Unapproved';
			$manager_status = 'Unapproved';
		}elseif($sched_time == $old_time AND $smd_status == 'Approved')
		{
			$smd_status = 'Approved';
			$manager_status = 'Approved';
		}elseif($sched_time == $old_time AND ($smd_status == '' OR $smd_status == 'null'))
		{
			$smd_status = '';
			$manager_status = 'Approved';
		}

		$design_status = $_POST['status'];

		$proj_name = $_POST['proj_name'];
		$proj_address = $_POST['proj_address'];
		

		//design
		$str = $_POST['str'];
		$agg = $_POST['agg'];
		$curing = $_POST['curing'];
		$slump = $_POST['slump'];
		//old designs
		$tmp_str = $_POST['tmp_str'];
		$tmp_agg = $_POST['tmp_agg'];
		$tmp_curing = $_POST['tmp_curing'];
		$tmp_slump = $_POST['tmp_slump'];

		$pouring = $_POST['pouring'];
		$structure = strtoupper($_POST['structure']);
		$remarks = $_POST['remarks'];
		$estvolume = $_POST['volume'];

		//other remarks
		$pipes = $_POST['pipes'];
		$vibrator = $_POST['vibrator'];
		$slumpcone = $_POST['slumpcone'];
		$beam = $_POST['beam'];
		$others = $_POST['others'];

		//added by ralph june 4, 2015
		$vibrator_no = $_POST['vibrator_no'];
		$pumpcharge_no = $_POST['pumpcharge_no'];

		//added by ralph august 14, 2015
		$po_no = $_POST['po_no'];

		//added by ralph may 3, 2016
		$what_day = $_POST['whatday'];
		$olddate = $_POST['tmpdate'];
		$plant = $_POST['plant'];


		//check if the design had change
		if($str <> $tmp_str OR $agg <> $tmp_agg OR $curing <> $tmp_curing OR $slump <> $tmp_slump){
			//the design has change
			
			// $this->dps_model->update_scheddate_formula($id,'','');
			$smd_status = 'Unapproved';
			$manager_status = 'Unapproved';
		}


		// $sched_date_data = array(
		//        'proj_name' => $proj_name,
  //              'proj_address' => $proj_address,
  //              'modified_date' => $sched_date,
  //              'modified_time' => $sched_time,
  //              'coor_status' => 'Unapproved',
  //              'smd_status' => $smd_status,
  //              'design_status' => $design_status,
  //              'book_psi' => $str,
  //              'book_msa' => $agg,
  //              'book_cd' => $curing,
  //              'book_sp' => $slump,
  //              'pour_type' => $pouring,
  //              'structure' => $structure,
  //              'remarks' => $remarks,
  //              'batch_vol' => $estvolume,
  //              'add_pipes' => $pipes,
  //              'add_vibrator' => $vibrator,
  //              'add_slumpcone' => $slumpcone,
  //              'add_beam' => $beam,
  //              'add_others' => $others,
  //              'vibrator_no' => $vibrator_no,
  //              'pumpcharge_no' => $pumpcharge_no,
  //              'po_no' => $po_no
  //              ,'is_update' => 'N' #ADDED BY WBSOLON SAP INTEGRATION
		// );
		

		//edited by wbsolon 10/29/19 
		$sched_date_data = array(

               'modified_time' => $sched_time,
            //    'coor_status' => 'Unapproved', 
            //    'smd_status' => $smd_status,
			//    'manager_status' => $manager_status, //added by elmer
               'design_status' => $design_status,
               'pour_type' => $pouring,
               'structure' => $structure,
               'remarks' => $remarks,
               'add_pipes' => $pipes,
               'add_vibrator' => $vibrator,
               'add_slumpcone' => $slumpcone,
               'add_beam' => $beam,
               'add_others' => $others,
               'vibrator_no' => $vibrator_no,
               'pumpcharge_no' => $pumpcharge_no,
               'po_no' => $po_no,
               'is_update' => 'Y' #added by wbsolon for SAP
		);

		/** Edit by Elmer 05-26-2025 */ 
		if($olddate <> $sched_date AND ($design_status == 'Re-Sched')){
			$sched_date_data['coor_status'] = 'Unapproved';
			$sched_date_data['smd_status'] = '';
			$sched_date_data['manager_status'] = '';

			$sched_date_data['f_code1'] = '';
			$sched_date_data['f_code2'] = '';
			$sched_date_data['f_code3'] = '';
			$sched_date_data['acctg_remarks'] = '';
		}

		//update query
		$this->dps_model->update_scheddate($id,$sched_date_data);
		// commented by wbsolon 10/31/2019
		// $this->dps_model->set_manager_status($id,$manager_status,'','');

		//put a logger here to see if who is updating the sched
    	$page_url = site_url() . uri_string();
    	$data = array(
    		'initial' => $this->initial,
    		'time_log' => $this->timeNow,
    		'date_log' => $this->dateNow,
    		'url' => $page_url,
    		'order_id' => $id,
    		'design_status' => $design_status
    		);
    	$this->dps_model->pending_logger($data);



    	//put a logger so that the system may determine the re-sched
    	//and insert counts base on the actions from the dps coordinator
    	//added by ralph tan ceriaco may 2, 2016
    	//
    	
    	
    	
    	if($what_day == 'today'){
    		if($olddate <> $sched_date AND ($design_status = 'Re-Sched' OR $design_status = 'Re-Sched')){
    			$active = $this->dps_model->check_sched_exist_inlog($this->dateNow,$id);

		    	$data_scheduler = array(
		    				'sched_date' 	=> $this->dateNow,
		    				'plant' 		=> $plant,
		    				'sched_status' 	=> $design_status,
		    				'sched_id' 		=> $id,
		    				'encoded' 		=> $this->dateNow . ' ' .$this->timeNow,
		    				'encodedby' 	=> $this->initial,
		    				'active' 		=> $active

		    		);
		    	$this->dps_model->scheduler_logger($data_scheduler);
    		}else{
    			//do nothing
    		}
    	}else{
    		//do nothing
    	}
    	
	}

	//added for vibrator use may 09, 2017

	function update_act_vib()
	{
		//get post data
		$id = $_POST['id'];
		$vib_use = $_POST['act_vib'];
		$qa_rep = $_POST['qa_rep'];

		echo $id;

		$vib_data = array(
		       'act_vib_use' => $vib_use,
               'act_vib_qc' => $qa_rep 
               ,'is_update' => 'N' #ADDED BY WBSOLON SAP INTEGRATION
		);


		//update query
		$this->dps_model->update_scheddate($id,$vib_data);

		//put a logger here to see if who is updating the sched
    	$page_url = site_url() . uri_string();
    	$data = array(
    		'initial' => $this->initial,
    		'time_log' => $this->timeNow,
    		'date_log' => $this->dateNow,
    		'url' => $page_url,
    		'order_id' => $id,
    		'design_status' => $design_status
    		);
    	$this->dps_model->pending_logger($data);

	}

	function update_sched_date_advance()
	{
		//get post data
		$id = $_POST['id'];
		$sched_date = $_POST['date'];


		$sched_time = $_POST['time'];
		$old_time = $_POST['oldtime'];

		$smd_status = $_POST['smd_status'];
		$manager_status = 'Unapproved';
		$design_status = $_POST['status'];

		$proj_name = $_POST['proj_name'];
		$proj_address = $_POST['proj_address'];
		

		//design
		$str = $_POST['str'];
		$agg = $_POST['agg'];
		$curing = $_POST['curing'];
		$slump = $_POST['slump'];
		//old designs
		$tmp_str = $_POST['tmp_str'];
		$tmp_agg = $_POST['tmp_agg'];
		$tmp_curing = $_POST['tmp_curing'];
		$tmp_slump = $_POST['tmp_slump'];

		$pouring = $_POST['pouring'];
		$structure = $_POST['structure'];
		$remarks = $_POST['remarks'];
		$estvolume = $_POST['volume'];

		//other remarks
		$pipes = $_POST['pipes'];
		$vibrator = $_POST['vibrator'];
		$slumpcone = $_POST['slumpcone'];
		$beam = $_POST['beam'];
		$others = $_POST['others'];

		//added by ralph june 4, 2015
		$vibrator_no = $_POST['vibrator_no'];
		$pumpcharge_no = $_POST['pumpcharge_no'];

		//added by ralph august 14, 2015
		$po_no = $_POST['po_no'];

		$sched_date_data = array(
		       'proj_name' => $proj_name,
               'proj_address' => $proj_address,
               'modified_date' => $sched_date,
               'modified_time' => $sched_time,
               'coor_status' => 'Unapproved',
               'smd_status' => $smd_status,
               'design_status' => $design_status,
               'book_psi' => $str,
               'book_msa' => $agg,
               'book_cd' => $curing,
               'book_sp' => $slump,
               'pour_type' => $pouring,
               'structure' => $structure,
               'remarks' => $remarks,
               'batch_vol' => $estvolume,
               'add_pipes' => $pipes,
               'add_vibrator' => $vibrator,
               'add_slumpcone' => $slumpcone,
               'add_beam' => $beam,
               'add_others' => $others,
               'vibrator_no' => $vibrator_no,
               'pumpcharge_no' => $pumpcharge_no,
               'po_no' => $po_no
		);


		//update query
		$this->dps_model->update_scheddate($id,$sched_date_data);
		$this->dps_model->set_manager_status($id,$manager_status,'','');

		//put a logger here to see if who is updating the sched
    	$page_url = site_url() . uri_string();
    	$data = array(
    		'initial' => $this->initial,
    		'time_log' => $this->timeNow,
    		'date_log' => $this->dateNow,
    		'url' => $page_url,
    		'order_id' => $id,
    		'design_status' => $design_status
    		);
    	$this->dps_model->pending_logger($data);
	}


		
	function coor_approved_schedule()	
	{
		$lvl = $this->session->userdata('userlvl');
		$datenow = date("Y-m-d h:i:s");
		$scheds=$_POST['selectedsched'];
		$whatday = $_POST['whatday'];

		//test for the selected counter
		//$sched_count = $_POST['selectcounter'];
		


		foreach($scheds as $schedid){
			$id=$schedid;
			$project_name = $_POST['projectname'.$id];

			$sched_date = $_POST['sched-datetime-input'];
			
			//insert it into the new table "batch_request" and update the status to approved
			//$this->dps_model->insert_approved_schedule($id);

			$this->dps_model->coor_status_approved($id,$datenow);

			$data = array(
			        'project_id' => $id,
			        'project_name' => $project_name,
			        'approved_byuserlvl' => $lvl,
			        'approved_by' => $this->initial,
			        'approved_date' => $datenow
			);
			$this->dps_model->insert_batchsched_history($data);
			//update dps timestamp
			$this->dps_model->update_timestamps($sched_date,$this->initial,1);

			//delete the records that has been inserted in the other table
			//$this->dps_model->delete_inbatch_scheduled($id);
			
			
		}
		if($whatday == 'today'){
			header('location:schedulertoday');
		}elseif ($whatday == 'nextday') {
			header('location:schedulertom');
		}elseif ($whatday == 'sat') {
			header('location:schedulersat');
		}elseif ($whatday == 'sun') {
			header('location:schedulersun');
		}elseif ($whatday == 'mon') {
			header('location:schedulermon');
		}
	}	


	function smd_approved_schedule()	
	{
		$lvl = $this->session->userdata('userlvl');
		
		$datenow = date("Y-m-d h:i:s");
		$scheds=$_POST['selectedsched'];
		$whatday = $_POST['whatday'];

		foreach($scheds as $schedid){
			$id=$schedid;
			$project_name = $_POST['projectname'.$id];

			$sched_date = $_POST['sched-datetime-input'];
			//insert it into the new table "batch_request" and update the status to approved
			//$this->dps_model->insert_approved_schedule($id);

			$this->dps_model->smd_status_approved($id,$datenow);

			$data = array(
			        'project_id' => $id,
			        'project_name' => $project_name,
			        'approved_byuserlvl' => $lvl,
			        'approved_by' => $this->initial,
			        'approved_date' => $datenow
			);
			$this->dps_model->insert_batchsched_history($data);
			//update dps timestamp
			$this->dps_model->update_timestamps($sched_date,$this->initial,5);

			//delete the records that has been inserted in the other table
			//$this->dps_model->delete_inbatch_scheduled($id);

			
		}
		if($whatday == 'today'){
			header('location:schedulertoday');
		}elseif ($whatday == 'nextday') {
			header('location:schedulertom');
		}elseif ($whatday == 'sat') {
			header('location:schedulersat');
		}elseif ($whatday == 'sun') {
			header('location:schedulersun');
		}elseif ($whatday == 'mon') {
			header('location:schedulermon');
		}
	}

/*
	 ADDED BY WBSOLON SEPTEMBER 25, 2019
	 ACCNTG REQUEST
	 EDIT POURING YESTERDAY
	*/

	function edit_pouring_yesterday()
	{
		$dateyes = date("Y-m-d",strtotime( '-1 days' ));
		if($this->session->userdata('is_logged_in')){	
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isFIDCollection($this->lvl) 
				|| $this->functionlist->isCVR($this->lvl) ){
				$data['status']='';

				//$data = $this->dps_model->get_recent_pouring();

				//display the login page to the user
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');
				//query for the dps panel display

				
				 $dps_summary = $this->dps_model->fetch_edit_data($dateyes,'main');
				$data['dps_summary'] = $this->load->view($dps_summary['view'],$dps_summary,true);

				// acctg
				$acctg = $this->dps_model->fetch_edit_data($dateyes,'acctg');
				$data['acctg'] = $this->load->view($acctg['view'],$acctg,true);
				//-----> mobile
				$m_acctg = $this->dps_model->fetch_edit_data($dateyes,'m_acctg');
				$data['m_acctg'] = $this->load->view($m_acctg['view'],$m_acctg,true);
				
				/*
				// plant
				$plant = $this->dps_model->fetch_edit_data($this->dateNow,'plant');
				$data['plant'] = $this->load->view($plant['view'],$plant,true);
				//-----> mobile
				$m_plant = $this->dps_model->fetch_edit_data($this->dateNow,'m_plant');
				$data['m_plant'] = $this->load->view($m_plant['view'],$m_plant,true);

				// qc
				$qc = $this->dps_model->fetch_edit_data($this->dateNow,'qc');
				$data['qc'] = $this->load->view($qc['view'],$qc,true);
				//-----> mobile
				$m_qc = $this->dps_model->fetch_edit_data($this->dateNow,'m_qc');
				$data['m_qc'] = $this->load->view($m_qc['view'],$m_qc,true);
				*/

		        $this->body['view'] = 'dps/editpouringyesterday';
		        $this->body['content'] = $data;
		        $this->pagemaker->basePage($this->body,'Pouring Summary Today');
		    }else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}	

	

	function edit_pouring_today()
	{
		if($this->session->userdata('is_logged_in')){	
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isCVR($this->lvl) ){
				$data['status']='';

				//$data = $this->dps_model->get_recent_pouring();

				//display the login page to the user
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');
				//query for the dps panel display

				
				$dps_summary = $this->dps_model->fetch_edit_data($this->dateNow,'main');
				$data['dps_summary'] = $this->load->view($dps_summary['view'],$dps_summary,true);

				// acctg
				$acctg = $this->dps_model->fetch_edit_data($this->dateNow,'acctg');
				$data['acctg'] = $this->load->view($acctg['view'],$acctg,true);
				//-----> mobile
				$m_acctg = $this->dps_model->fetch_edit_data($this->dateNow,'m_acctg');
				$data['m_acctg'] = $this->load->view($m_acctg['view'],$m_acctg,true);
				
				// plant
				$plant = $this->dps_model->fetch_edit_data($this->dateNow,'plant');
				$data['plant'] = $this->load->view($plant['view'],$plant,true);
				//-----> mobile
				$m_plant = $this->dps_model->fetch_edit_data($this->dateNow,'m_plant');
				$data['m_plant'] = $this->load->view($m_plant['view'],$m_plant,true);

				// qc
				$qc = $this->dps_model->fetch_edit_data($this->dateNow,'qc');
				$data['qc'] = $this->load->view($qc['view'],$qc,true);
				//-----> mobile
				$m_qc = $this->dps_model->fetch_edit_data($this->dateNow,'m_qc');
				$data['m_qc'] = $this->load->view($m_qc['view'],$m_qc,true);
				

		        $this->body['view'] = 'dps/editpouringtoday';
		        $this->body['content'] = $data;
		        $this->pagemaker->basePage($this->body,'Pouring Summary Today');
		    }else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}	

	/* ----------------- NEXT POURING SCHEDULE ----------------- */

	function next_pouring_sched()
	{
		if($this->session->userdata('is_logged_in')){	
			if($this->functionlist->isDPSEditor($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isCVR($this->lvl) ){
				$data['status']='';
				if($this->session->userdata('nextpouring') != ''){
					$this->nextpouringdate = $this->session->userdata('nextpouring');
					//unset the session for next pouring
					$this->session->unset_userdata('nextpouring');
				}

				//display the login page to the user
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');
				//query for the dps panel display

				$dps_summary = $this->dps_model->fetch_edit_data($this->nextpouringdate,'main');
				$data['dps_summary'] = $this->load->view($dps_summary['view'],$dps_summary,true);

				// acctg
				$acctg = $this->dps_model->fetch_edit_data($this->nextpouringdate,'acctg');
				$data['acctg'] = $this->load->view($acctg['view'],$acctg,true);
				//-----> mobile
				$m_acctg = $this->dps_model->fetch_edit_data($this->nextpouringdate,'m_acctg');
				$data['m_acctg'] = $this->load->view($m_acctg['view'],$m_acctg,true);
				
				// plant
				$plant = $this->dps_model->fetch_edit_data($this->nextpouringdate,'plant');
				$data['plant'] = $this->load->view($plant['view'],$plant,true);
				//-----> mobile
				$m_plant = $this->dps_model->fetch_edit_data($this->nextpouringdate,'m_plant');
				$data['m_plant'] = $this->load->view($m_plant['view'],$m_plant,true);

				// qc
				$qc = $this->dps_model->fetch_edit_data($this->nextpouringdate,'qc');
				$data['qc'] = $this->load->view($qc['view'],$qc,true);
				//-----> mobile
				$m_qc = $this->dps_model->fetch_edit_data($this->nextpouringdate,'m_qc');
				$data['m_qc'] = $this->load->view($m_qc['view'],$m_qc,true);

				
		        $this->body['view'] = 'dps/editpouringnextday';
		        $this->body['content'] = $data;
		        $this->pagemaker->basePage($this->body,'Pouring Summary Next Day');
		    }else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function update_acctg_remarks()
	{
		$id = $_POST['id'];
		$remarks = $_POST['remarks'];
		$date = $_POST['date'];
		$acctg_notes = $_POST['notes'];
		//update the revision status
		
		$this->dps_model->update_acctg_remarks($id,$remarks,$acctg_notes);
		$this->dps_model->update_timestamps($date,$this->initial,4);
		$this->dps_model->set_manager_status($id,'Unapproved','','');

		//added by wbsolon 2019-08-02
		// $this->dps_model->update_prepaid($id,$remarks);
		if ($this->dps_model->update_prepaid($id,$remarks)) {
			echo 'prepaid';
		}
	}

	function update_supervisor()
	{
		$id = $_POST['id'];
		$servengr = $_POST['servengr'];
		$batchplant = $_POST['batchplant'];
		$date = $_POST['date'];
		$time = $_POST['time'];
		$timestat = $_POST['timestat'];

		$this->dps_model->update_supervisor($id,$servengr,$batchplant,$time,$timestat);
		$this->dps_model->update_timestamps($date,$this->initial,2);
		$this->dps_model->set_manager_status($id,'Unapproved','','');

		// update the priority list
		// added by ralph april 23, 2015

		$this->gen_priority_nos();
	}

	function update_qc()
	{
		$id = $_POST['id'];
		$fcode1 = $_POST['fcode1'];
		$fcode2 = $_POST['fcode2'];
		$qa_rep = $_POST['qa_rep'];
		$qc_remarks = $_POST['qc_remarks'];
		$date = $_POST['date'];
		$qcrem_optional = $_POST['qcoptrem'];
		

		$this->dps_model->update_qc($id,$fcode1,$fcode2,$qa_rep,$qc_remarks,$qcrem_optional);
		$this->dps_model->update_timestamps($date,$this->initial,3);
		$this->dps_model->set_manager_status($id,'Unapproved','','');
	}

	function process_addnote()
	{
		//id of the design
		//the note
		//the user that encoded the note

		$id = $_POST['id'];
	    $note = $_POST['note'];
	    $user = $_POST['user'];

	    $this->dps_model->update_dpsnote($id,$user,$note);
	}

	function hdays($date_tom)
	{
        //initialize dates
        //$date_tom = mktime(0,0,0,date("m"),date("d")+1);
		$nextpouringday = date("m-d", $date_tom);

		//initialize counter
		$ctr = 0;

		//query for the holiday dates list in the database
        $holiday_date = $this->dps_model->get_holidate();

        //store the result in an array
       	$dates = array();
       	foreach ($holiday_date as $holidate) {
       			$dates[] = $holidate->hday;
       		}

       	//loop through the array list
       	$is_nextday = 'FALSE';
       	$is_sunday = 'FALSE';


       	//this code check the array if the nextpuoring date is in the holidays with sunday as holiday
       	//revision by ralph sept 13, 2014

       	/*
       	while ($is_nextday != 'TRUE') {
			//if holiday then skip
			// if sunday then skip
			if (in_array($nextpouringday,$dates) OR date("l",$date_tom) == 'Sunday'){
				//skip go to next date -> increment the dates
				$date_tom = mktime(0,0,0,date("m"),date("d")+$ctr+1);
				$nextpouringday = date("m-d", $date_tom);
				$is_nextday = 'FALSE';
			}
			else{
				//$nextpouringday = $nextpouringday;
			      $nextpouringday = date("Y") ."-". $nextpouringday;
				$is_nextday = 'TRUE';
			}

			$ctr ++;
		}
		*/

		if (in_array('SUNDAY',$dates)){
			$is_sunday = 'TRUE';
		}else{
			$is_sunday = 'FALSE';
		}

		//var_dump($dates); exit();
		while ($is_nextday != 'TRUE') {
			//if holiday then skip
			// if sunday = holiday(active) then skip
			
			if ($is_sunday == 'TRUE'){
				if (in_array($nextpouringday,$dates) OR date("l",$date_tom) == 'Sunday'){
					//skip go to next date -> increment the dates
					$date_tom = mktime(0,0,0,date("m"),date("d")+$ctr+1);
					$nextpouringday = date("m-d", $date_tom);
					$is_nextday = 'FALSE';
				}
				else{
					//$nextpouringday = $nextpouringday;
				      $nextpouringday = date("Y") ."-". $nextpouringday;
					$is_nextday = 'TRUE';
				}
			}else{
				if (in_array($nextpouringday,$dates)){
					//skip go to next date -> increment the dates
					$date_tom = mktime(0,0,0,date("m"),date("d")+$ctr+1);
					$nextpouringday = date("m-d", $date_tom);
					$is_nextday = 'FALSE';
				}
				else{
					//$nextpouringday = $nextpouringday;
				      $nextpouringday = date("Y") ."-". $nextpouringday;
					$is_nextday = 'TRUE';
				}
			}


			

			$ctr ++;
		}
		$nextpouringday = date("Y-m-d", $date_tom);
		$date_result[0] = $date_tom;
		$date_result[1] = $nextpouringday;
		return $date_result;
	}

	function ajax_nextpouring(){
		

		$this->nextpouringdate = $_POST['date'];

		$sessnextpouring = array(
                   'nextpouring'  => $this->nextpouringdate,
               );

		$this->session->set_userdata($sessnextpouring);

		$dateTom = $_POST['date'];
		$pieces = explode("-",$dateTom);


		$dateTom2 = date("F d, Y", mktime(0, 0, 0, $pieces[1], $pieces[2], $pieces[0]));

		$content['dateTom'] = $dateTom;
		$content['dateTom2'] = $dateTom2;

		// tomorrow north
		$booking_tom_north = $this->dps_model->fetch_bookings('bookingpanel',$dateTom,'Plant 3');
		$booking_tom_north_insert = $this->dps_model->fetch_bookings('bookingpanel_insert',$dateTom,'Plant 3');
		
			if($booking_tom_north['count'] == 'norecord'){
				if($booking_tom_north_insert['count'] == 'norecord'){
					//display the error message
					$content['dps_tom_north'] = $this->load->view($booking_tom_north['view'], $booking_tom_north,true);
					$content['dps_tom_north_insert'] = '';
				}else{
					//shift the view to the single insert view
					$content['dps_tom_north'] = '';
					$booking_tom_north_insert['view'] = 'dps/dps_table_view_insert';
					$content['dps_tom_north_insert'] = $this->load->view($booking_tom_north_insert['view'], $booking_tom_north_insert,true);
				}
			}else{
				//display it and display the insert also
				if($booking_tom_north_insert['count'] == 'norecord'){
					$content['dps_tom_north_insert'] = '';
					$content['dps_tom_north'] = $this->load->view($booking_tom_north['view'], $booking_tom_north,true);
				}else{
					$content['dps_tom_north'] = $this->load->view($booking_tom_north['view'], $booking_tom_north,true);
					$content['dps_tom_north_insert'] = $this->load->view($booking_tom_north_insert['view'], $booking_tom_north_insert,true);
				}
			}
		
		$content['north_tomvol'] = (isset($booking_tom_north['volume'])) ? $booking_tom_north['volume'] : "0";
		$content['north_tomvol_insert'] = (isset($booking_tom_north_insert['volume'])) ? $booking_tom_north_insert['volume'] : "0";
		$content['volume_tom_north'] = $content['north_tomvol'] + $content['north_tomvol_insert'];

		
		// tomorrow south
		$booking_tom_south = $this->dps_model->fetch_bookings('bookingpanel',$dateTom,'Plant 4');
		$booking_tom_south_insert = $this->dps_model->fetch_bookings('bookingpanel_insert',$dateTom,'Plant 4');
		
			if($booking_tom_south['count'] == 'norecord'){
					if($booking_tom_south_insert['count'] == 'norecord'){
						//display the error message
						$content['dps_tom_south'] = $this->load->view($booking_tom_south['view'], $booking_tom_south,true);
						$content['dps_tom_south_insert'] = '';
					}else{
						//shift the view to the single insert view
						$content['dps_tom_south'] = '';
						$booking_tom_south_insert['view'] = 'dps/dps_table_view_insert';
						$content['dps_tom_south_insert'] = $this->load->view($booking_tom_south_insert['view'], $booking_tom_south_insert,true);
					}
				}else{
					//display it and display the insert also
					if($booking_tom_south_insert['count'] == 'norecord'){
						$content['dps_tom_south_insert'] = '';
						$content['dps_tom_south'] = $this->load->view($booking_tom_south['view'], $booking_tom_south,true);
					}else{
						$content['dps_tom_south'] = $this->load->view($booking_tom_south['view'], $booking_tom_south,true);
						$content['dps_tom_south_insert'] = $this->load->view($booking_tom_south_insert['view'], $booking_tom_south_insert,true);
					}
			}

		$content['south_tomvol'] = (isset($booking_tom_south['volume'])) ? $booking_tom_south['volume'] : "0";
		$content['south_tomvol_insert'] = (isset($booking_tom_south_insert['volume'])) ? $booking_tom_south_insert['volume'] : "0";
		$content['volume_tom_south'] = $content['south_tomvol'] + $content['south_tomvol_insert'];

		// tomorrow for confirmation
		$booking_tom_forconfirm = $this->dps_model->fetch_bookings('bookingpanel_confirm',$dateTom,'');
		$content['dps_tom_forconfirm'] = $this->load->view($booking_tom_forconfirm['view'], $booking_tom_forconfirm,true);
		$content['volume_tom_forconfirm'] = (isset($booking_tom_forconfirm['volume'])) ? $booking_tom_forconfirm['volume'] : "0";

		$this->body['view'] = 'dps/ajax_nextpouring';
		$this->body['content'] = $content;
		$this->pagemaker->ajaxPage($this->body,'yes');
	}


	/* ------------------ MAINTENANCE FUNCTIONS --------------------- */

	function maintain_holidays()
	{
		if($this->session->userdata('is_logged_in')){	
			if($this->functionlist->isDPSCoordinator($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl)){
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');
				$data['holiday_date'] = $this->dps_model->get_holidays();

				$this->body['view'] = 'dps/maintenance/holidays';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Holidays');
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function maintain_customers()
	{
		if($this->session->userdata('is_logged_in')){	
			if($this->functionlist->isDPSCoordinator($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				//query for the customer names
				$data['custnames'] = $this->dps_model->get_customer_names();
				$data['salesengg'] = $this->dps_model->get_salesengg_list();

				$this->body['view'] = 'dps/maintenance/customers';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Customers');
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function maintain_projects()
	{
		if($this->session->userdata('is_logged_in')){	
			if($this->functionlist->isDPSCoordinator($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl)){
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');
				$data['project_list'] = $this->dps_model->get_project_list();

				$this->body['view'] = 'dps/maintenance/projects';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Projects');
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}


	function maintain_design()
	{
		if($this->session->userdata('is_logged_in')){	
			if($this->functionlist->isDPSCoordinator($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl)){
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');
				
				$data['strength'] = $this->dps_model->get_design_strength();
				$data['agg'] = $this->dps_model->get_design_aggregates();
				$data['slump'] = $this->dps_model->get_design_slump();
				$data['pouringtype'] = $this->dps_model->get_design_pouringtype();
				$data['structure'] = $this->dps_model->get_design_structure();

				$this->body['view'] = 'dps/maintenance/design';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Add Designs');
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function maintain_sketch()
	{
		if($this->session->userdata('is_logged_in')){	
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl)){
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');
				
				

				$this->body['view'] = 'dps/maintenance/sketch';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Upload Location Sketch');
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function ajax_uploadsketch()
	{
		
		$temp_img = $_FILES["file"]["tmp_name"];
		ini_set('gd.jpeg_ignore_warning', 1);

	


		//check if temporary name is okay
		if($temp_img != ''){
			//check if image is of jpeg format
			if(mime_content_type($temp_img) == 'image/jpeg'){
				$custname = $_POST['cust'];
				$projname = $_POST['proj'];
				$address = $_POST['address'];

				$img_name = $custname .'-'. $projname .'.jpg';

				$location_temp = './location_sketch/temp/'.$img_name;

				//move th temp file to the location_sketch/temp folder
				if (move_uploaded_file($temp_img, $location_temp))
				{
					//resize the image
					//copy($location_temp, './location_sketch/temp/toink.jpg');
					
					$this->functionlist->resizeImage($location_temp,$location_temp,'600','800');

					//write the watermark to the image
					$this->generateWatermark($img_name,$custname,$projname,$address);

					//create a thumbnail
					$img_url = './location_sketch/' . $img_name;
					$dest_thumbnails = './location_sketch/thumbnails/' . $img_name;

					$this->functionlist->resizeImage($img_url,$dest_thumbnails,'175','234');

					//delete the temp files
					unlink($location_temp);

					//send the result image to the ajax
					echo "<center><img src='../location_sketch/$img_name' /></center>";
					
				}else{
					//redirect to error page
					$this->session->set_userdata('error_msg', 'Image not uploaded,Try again.');
					redirect('dps/errorPage');
				}

				

			}else{
				//redirect to error page
				$this->session->set_userdata('error_msg', 'Image file format is not supported.(jpeg/jpg only).');
				redirect('dps/errorPage');
			}
			
		}else{
			//redirect to error page
			$this->session->set_userdata('error_msg', 'Image file is corrupted,Cannot read filename.');
			redirect('dps/errorPage');
		}

		
	
	}

	function generateWatermark($image_name,$cust_name,$proj_name,$proj_address){

		$SourceFile = './location_sketch/temp/'.$image_name;
		$DestinationFile = './location_sketch/'. $image_name;
		$WaterMarkText = 'CUSTOMER : ' . strtoupper($cust_name);
		$WaterMarkText2 ='PROJECT : ' . strtoupper($proj_name);
		$WaterMarkText3 ='LOCATION : ' . strtoupper($proj_address);
		 
		$this->functionlist->watermarkImage($SourceFile, $WaterMarkText,$WaterMarkText2, $WaterMarkText3, $DestinationFile);
		
	}

	

	function ajax_update_holiday(){
		$id = $_POST['id'];
		$status = $_POST['status'];

		$this->dps_model->update_holiday($id,$status);
	}

	function ajax_add_holiday(){
		$date = $_POST['date'];

		$result = $this->dps_model->add_holiday($date);
		echo $result;
	}

	function ajax_get_cust_info()
	{
		$cust_id = $_POST['id'];

		$cust_info = $this->dps_model->get_cust_info($cust_id);
		$data['customer_info'] = $this->load->view($cust_info['view'], $cust_info,true);

		$this->body['view'] = 'dps/maintenance/ajax_customerinfo';
		$this->body['content'] = $data;
		$this->pagemaker->ajaxPage($this->body,'no');
	}

	function process_editcust(){
		$id = $_POST['selected-custname'];
		$cust_name = $_POST['cust_name'];
		$cust_add = $_POST['cust_add'];
		$billing_add = $_POST['billing_add'];
		$contact_num = $_POST['contact_num'];
		$sales_engg = $_POST['sales_engg'];

		$this->dps_model->update_customer_info($id,$cust_name,$cust_add,$billing_add,$contact_num,$sales_engg);
		redirect('dps/maintain_customers');
	}

	function process_add_customer(){
		$cust_name = $_POST['cust_name'];
		$cust_add = $_POST['cust_add'];
		$billing_add = $_POST['billing_add'];
		$contact_num = $_POST['contact_num'];
		$sales_engg = $_POST['sales_engg'];
		
		$this->dps_model->insert_customer_info($cust_name,$cust_add,$billing_add,$contact_num,$sales_engg);
		redirect('dps/maintain_customers');
	}

	function ajax_get_proj_info()
	{
		$proj_id = $_POST['id'];

		$proj_info = $this->dps_model->get_proj_info($proj_id);
		$data['project_info'] = $this->load->view($proj_info['view'], $proj_info,true);

		$this->body['view'] = 'dps/maintenance/ajax_projectinfo';
		$this->body['content'] = $data;
		$this->pagemaker->ajaxPage($this->body,'yes');
	}

	function process_update_project(){

		//project info
		$id = $_POST['proj_id'];
		$proj_name = $_POST['proj_name'];
		$proj_loc = $_POST['proj_loc'];

		//project contacts
		$owner = $_POST['proj_owner'];
		$owner_num = $_POST['proj_owner_num'];
		$engr = $_POST['proj_engr'];
		$engr_num = $_POST['proj_engr_num'];
		$acctg = $_POST['proj_acctg'];
		$acctg_num = $_POST['proj_acctg_num'];
		$proj_witness = $_POST['proj_witness'];
		$witness_num = $_POST['proj_witness_num'];

		//project sampling
		$samp_standard = 'NO';
		$samp_others = 'NO';
		switch ($_POST['sampling']) {
			case 'standard':
				$samp_standard = 'YES';
				break;
			case 'others':
				$samp_others = 'YES';
				break;
		}

		$samp_cylinders = $_POST['sampling_cylinders'];
		$samp_cubic = $_POST['sampling_cubic'];

		//project testing
		$testing_jlr = (isset($_POST['testing_standard'])) ? "YES" : "NO";
		$testing_extlab = (isset($_POST['testing_others'])) ? "YES" : "NO";

		$testing_jlr7 = (isset($_POST['test_std_7'])) ? "YES" : "NO";
		$testing_jlr14 = (isset($_POST['test_std_14'])) ? "YES" : "NO";
		$testing_jlr28 = (isset($_POST['test_std_28'])) ? "YES" : "NO";

		$testing_extlab7 = (isset($_POST['test_oth_7'])) ? "YES" : "NO";
		$testing_extlab14 = (isset($_POST['test_oth_14'])) ? "YES" : "NO";
		$testing_extlab28 = (isset($_POST['test_oth_28'])) ? "YES" : "NO";

		$testing_colab = $_POST['test_oth_colab'];
		$testing_colabname = $_POST['test_oth_colabname'];


		//project curing
		$curing_asite = (isset($_POST['curing_atsite'])) ? "YES" : "NO";
		$curing_ajlr = (isset($_POST['curing_atjlr'])) ? "YES" : "NO";

		//project witness

		$witness = $_POST['witnessradio'];
		$witness_consultant = $_POST['witness_consultant'];
		$witness_consultant_num = $_POST['witness_consultant_num'];
		

		$this->dps_model->update_project_info($id,$proj_name,$proj_loc);
		$this->dps_model->update_project_contacts($id,$owner,$owner_num,$engr,$engr_num,$acctg,$acctg_num,$proj_witness,$witness_num);
		$this->dps_model->update_project_qc($id,$samp_standard,
                               $samp_others,$samp_cylinders,
                               $samp_cubic,$curing_asite,
                               $curing_ajlr,$testing_jlr,
                               $testing_extlab,$testing_jlr7,
                               $testing_jlr14,$testing_jlr28,
                               $testing_colab,$testing_colabname,
                               $testing_extlab7,$testing_extlab14,
                               $testing_extlab28,$witness,
                               $witness_consultant,$witness_consultant_num);
		redirect('dps/maintain_projects');
	}

	/* ----------------- REPORTING (PRINTING) FUNCTIONS ----------------- */
	function print_today_south()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl)){
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				//check if manager status
	    		$manager_approval = $this->dps_model->check_manager_approval($this->dateNow,'Plant 4');
	    		if($manager_approval <= 0){
	    			//get the count summary
					$clientcnt1 = $this->dps_model->get_clientcount(1,$this->dateNow,'Plant 4');
					$data['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

					$clientcnt2 = $this->dps_model->get_clientcount(2,$this->dateNow,'Plant 4');
					$data['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

					$clientcnt3 = $this->dps_model->get_clientcount(3,$this->dateNow,'Plant 4');
					$data['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);
					
					//query data
					$booking = $this->dps_model->fetch_bookings('bookingpanel',$this->dateNow,'Plant 4');
					$booking_insert = $this->dps_model->fetch_bookings('bookingpanel_insert',$this->dateNow,'Plant 4');

					//calculate volumes/total volume
					$data['vol1'] = (isset( $booking['volume'])) ?  $booking['volume'] : "0";
					$data['vol2'] = (isset( $booking_insert['volume'])) ?  $booking_insert['volume'] : "0";
					$data['volume_total'] = $data['vol1'] + $data['vol2'];

					//display the result to another view
					$data['dps_rept_normal'] = $this->load->view('dps/dps_table_print', $booking,true);
					$data['dps_rept_insert'] = $this->load->view('dps/dps_table_print', $booking_insert,true);

					//check if booking has record if no then do not display signature
					if($booking['count'] != 'norecord' OR $booking_insert['count'] != 'norecord'){
						$signatures['siggy'] = $this->dps_model->get_signature($this->dateNow,'Plant 4');
						$data['signature'] = $this->load->view('dps/reports/reportsig', $signatures,true);

					}else{
						$data['warning'] = "<div class='dpspanel-warning'>No Record as of this moment</div>";
					}

					//parameters for conditional statement
					$data['printparam'] = 'todaysouth';
					$data['scheddate'] = $this->dateNow;

					$this->body['view'] = 'dps/reports/dpsreport';
				    $this->body['content'] = $data;
				    $this->pagemaker->printPage($this->body);
	    		}else{
	    			redirect('dps/deniedprint');
	    		}

				
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function print_today_north()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl)){
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				//check if manager status
	    		$manager_approval = $this->dps_model->check_manager_approval($this->dateNow,'Plant 3');
	    		if($manager_approval <= 0){
	    			//get the count summary
					$clientcnt1 = $this->dps_model->get_clientcount(1,$this->dateNow,'Plant 3');
					$data['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

					$clientcnt2 = $this->dps_model->get_clientcount(2,$this->dateNow,'Plant 3');
					$data['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

					$clientcnt3 = $this->dps_model->get_clientcount(3,$this->dateNow,'Plant 3');
					$data['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);
					
					//query data
					$booking = $this->dps_model->fetch_bookings('bookingpanel',$this->dateNow,'Plant 3');
					$booking_insert = $this->dps_model->fetch_bookings('bookingpanel_insert',$this->dateNow,'Plant 3');
					
					
					//calculate volumes/total volume
					$data['vol1'] = (isset( $booking['volume'])) ?  $booking['volume'] : "0";
					$data['vol2'] = (isset( $booking_insert['volume'])) ?  $booking_insert['volume'] : "0";
					$data['volume_total'] = $data['vol1'] + $data['vol2'];

					//display the result to another view
					$data['dps_rept_normal'] = $this->load->view('dps/dps_table_print', $booking,true);
					$data['dps_rept_insert'] = $this->load->view('dps/dps_table_print', $booking_insert,true);

					//check if booking has record if no then do not display signature
					if($booking['count'] != 'norecord' OR $booking_insert['count'] != 'norecord'){
						$signatures['siggy'] = $this->dps_model->get_signature($this->dateNow,'Plant 3');
						$data['signature'] = $this->load->view('dps/reports/reportsig', $signatures,true);
					}else{
						$data['warning'] = "<div class='dpspanel-warning'>No Record as of this moment</div>";
					}

					//parameters for conditional statement
					$data['printparam'] = 'todaynorth';
					$data['scheddate'] = $this->dateNow;

					$this->body['view'] = 'dps/reports/dpsreport';
				    $this->body['content'] = $data;
				    $this->pagemaker->printPage($this->body);
	    		}else{
	    			redirect('dps/deniedprint');
	    		}

				
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	
	function print_tom_south()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl)){
				if($this->session->userdata('nextpouring') != ''){
						$this->nextpouringdate = $this->session->userdata('nextpouring');
						//unset the session for next pouring
						$this->session->unset_userdata('nextpouring');
				}

				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				//check if manager status
	    		$manager_approval = $this->dps_model->check_manager_approval($this->dateTom,'Plant 4');
	    		if($manager_approval <= 0){
	    			//get the count summary
					$clientcnt1 = $this->dps_model->get_clientcount(1,$this->nextpouringdate,'Plant 4');
					$data['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

					$clientcnt2 = $this->dps_model->get_clientcount(2,$this->nextpouringdate,'Plant 4');
					$data['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

					$clientcnt3 = $this->dps_model->get_clientcount(3,$this->nextpouringdate,'Plant 4');
					$data['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);
					
					//query data
					$booking = $this->dps_model->fetch_bookings('bookingpanel',$this->nextpouringdate,'Plant 4');
					$booking_insert = $this->dps_model->fetch_bookings('bookingpanel_insert',$this->nextpouringdate,'Plant 4');
				

					//calculate volumes/total volume
					$data['vol1'] = (isset( $booking['volume'])) ?  $booking['volume'] : "0";
					$data['vol2'] = (isset( $booking_insert['volume'])) ?  $booking_insert['volume'] : "0";
					$data['volume_total'] = $data['vol1'] + $data['vol2'];

					//display the result to another view
					$data['dps_rept_normal'] = $this->load->view('dps/dps_table_print', $booking,true);
					$data['dps_rept_insert'] = $this->load->view('dps/dps_table_print', $booking_insert,true);

					//check if booking has record if no then do not display signature
					if($booking['count'] != 'norecord' OR $booking_insert['count'] != 'norecord'){
						$signatures['siggy'] = $this->dps_model->get_signature($this->nextpouringdate,'Plant 4');
						$data['signature'] = $this->load->view('dps/reports/reportsig', $signatures,true);
					}else{
						$data['warning'] = "<div class='dpspanel-warning'>No Record as of this moment</div>";
					}

					//parameters for conditional statement
					$data['printparam'] = 'tomsouth';
					$data['scheddate'] = $this->nextpouringdate;

					$this->body['view'] = 'dps/reports/dpsreport';
				    $this->body['content'] = $data;
				    $this->pagemaker->printPage($this->body);
	    		}else{
	    			redirect('dps/deniedprint');
	    		}

				
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function print_tom_north()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl)){
				if($this->session->userdata('nextpouring') != ''){
						$this->nextpouringdate = $this->session->userdata('nextpouring');
						//unset the session for next pouring
						$this->session->unset_userdata('nextpouring');
				}

				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				//check if manager status
	    		$manager_approval = $this->dps_model->check_manager_approval($this->dateTom,'Plant 3');
	    		if($manager_approval <= 0){
	    			//get the count summary
					$clientcnt1 = $this->dps_model->get_clientcount(1,$this->nextpouringdate,'Plant 3');
					$data['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

					$clientcnt2 = $this->dps_model->get_clientcount(2,$this->nextpouringdate,'Plant 3');
					$data['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

					$clientcnt3 = $this->dps_model->get_clientcount(3,$this->nextpouringdate,'Plant 3');
					$data['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);
					
					//query data
					$booking = $this->dps_model->fetch_bookings('bookingpanel',$this->nextpouringdate,'Plant 3');
					$booking_insert = $this->dps_model->fetch_bookings('bookingpanel_insert',$this->nextpouringdate,'Plant 3');
					

					//calculate volumes/total volume
					$data['vol1'] = (isset( $booking['volume'])) ?  $booking['volume'] : "0";
					$data['vol2'] = (isset( $booking_insert['volume'])) ?  $booking_insert['volume'] : "0";
					$data['volume_total'] = $data['vol1'] + $data['vol2'];

					//display the result to another view
					$data['dps_rept_normal'] = $this->load->view('dps/dps_table_print', $booking,true);
					$data['dps_rept_insert'] = $this->load->view('dps/dps_table_print', $booking_insert,true);

					//check if booking has record if no then do not display signature
					if($booking['count'] != 'norecord' OR $booking_insert['count'] != 'norecord'){
						$signatures['siggy'] = $this->dps_model->get_signature($this->nextpouringdate,'Plant 3');
						$data['signature'] = $this->load->view('dps/reports/reportsig', $signatures,true);
					}else{
						$data['warning'] = "<div class='dpspanel-warning'>No Record as of this moment</div>";
					}

					//parameters for conditional statement
					$data['printparam'] = 'tomnorth';
					$data['scheddate'] = $this->nextpouringdate;

					$this->body['view'] = 'dps/reports/dpsreport';
				    $this->body['content'] = $data;
				    $this->pagemaker->printPage($this->body);
	    		}else{
	    			redirect('dps/deniedprint');
	    		}

				
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}


	function print_dob(){
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl)){
				//query here
				$data['scheddate'] = $this->nextpouringdate;
				$data['status'] ='';

				$dob_result = $this->dps_model->fetch_dob($this->nextpouringdate);
				$data['dob_items'] = $this->load->view($dob_result['view'], $dob_result,true);

				$data['volume'] = $dob_result['volume'];
				$this->body['view'] = 'dps/reports/dob';
			    $this->body['content'] = $data;
			    $this->pagemaker->printPage($this->body);
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function print_dpfaxable(){
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl)){
				//query here
				$data['scheddate'] = $this->dateNow;
				$data['status'] ='';

				$dpsfax_result = $this->dps_model->fetch_dpsfaxable($this->dateNow);
				$data['dpfax_items'] = $this->load->view($dpsfax_result['view'], $dpsfax_result,true);

				$data['volume'] = $dpsfax_result['volume'];
				$this->body['view'] = 'dps/reports/dpfax';
			    $this->body['content'] = $data;
			    $this->pagemaker->printPage($this->body);
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}


	function ajax_check_formnum()
	{
		$value = $_POST['value'];
		$form = $_POST['form'];

		$formquery_res =  $this->dps_model->check_form_num($value,$form);
		//var_dump($formquery_res);exit();
		echo $formquery_res;
	}

	function searchproject()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPSCoordinator($this->lvl) OR $this->lvl == 75 OR $this->lvl == 71 OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl) 
				OR $this->functionlist->isFIDCollection($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl) || $this->functionlist->isPurchasing($this->lvl)){

				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				$data['status'] ='';
				// $data['custnames'] = $this->dps_model->get_customer_names();
				$data['custnames'] = $this->dps_model->get_customer_names2();
				$data['pour_result'] = $this->dps_model->get_batch_pourtype($this->dateNow);

	
				$this->body['view'] = 'dps/searchproject';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Search Project');
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function ajax_searchbyform()
	{
		$form = $_POST['form'];
		$form_num = $_POST['form_num'];

		$result =  $this->dps_model->check_form_num($form_num,$form);

		//if 1 then get the details of the form
		if($result > 0){
			$res = $this->dps_model->get_formnum_details($form_num,$form);
			foreach ($res as $form_info) {
				$cust_name = $form_info->cust_name;
				$proj_name = $form_info->proj_name;
				$proj_add = $form_info->proj_address;
				$date = $form_info->modified_date;
				$form_num = $form_info->form_no;
			}

			echo "<h1>Details of the project with the specified form.</h1>";

			switch ($form) {
				case 'form1':
					echo "<p><span>Form number : </span>1 $form_num</p>";
					break;
				case 'form1a':
					echo "<p><span>Form number : </span>$form_num</p>";
					break;
				
			}

			echo "<p><span>Date : </span>$date</p>";
			echo "<p><span>Customer Name : </span>$cust_name</p>";
			echo "<p><span>Project Name : </span>$proj_name</p>";
			echo "<p><span>Project Location : </span>$proj_add</p>";

			
			
		}else{
			echo "<h1>This form number is not yet encoded in the Database.</h1>";
		}
	}

	function ajax_searchbydate()
	{
		$date = $_POST['date'];
		$ajaxpour_result = $this->dps_model->get_batch_pourtype($date);

		$ajaxfetch = $this->dps_model->ajax_fetch_booking($date);

		$ajaxfetch;

		if($ajaxfetch['count'] == 'record'){
			$rows = $ajaxfetch['result']->num_rows();
			$i = 0;

			echo "<center><h1>Pouring Schedule for this date : $date</h1></center>";

			/*edit by MOC 02022021*/
			echo '<table  style="border-collapse: collapse;width: 100%;font-size: 1em;border-bottom: 2px solid #ddd; " >			
			<tr style="color:white; background-color: #3581c5;">';
				foreach ($ajaxpour_result as $row){
				echo "<th>";
				echo "$row->pour_type";
				echo "</th>";
				}
			echo "</tr><tr>";
				foreach ($ajaxpour_result as $row){
				echo '<td align="center">';
				echo "$row->pour_vol m³";
				echo "</td>";
				}
			
			echo "</tr></table>";

			
			echo "<table id='mytable'>";
						
						echo "<tr id='heading'>";
							
							echo "<th width='220'>CUSTOMER NAME / PROJECT / LOCATION</th>";
							echo "<th>OTHER<br />REMARKS</th>";
							echo "<th>ACCTG<br />REMARKS</th>";
							echo "<th>TIME<br />(hours)</th>";
							echo "<th>REMARKS</th>";
							echo "<th>VOLUME</th>";
							echo "<th align='center'>CONCRETE DESIGN";
								echo "<div id='condes-header'>";
									echo "<span class='alt'><a>PSI</a></span>";
									echo "<span class='alt2'><a>MSA</a></span>";
									echo "<span class='alt'><a>C</a></span>";
									echo "<span class='alt2'><a>S</a></span>";
								echo "</div>";
							echo "</th>";
							echo "<th>POURING<br />TYPE</th>";
							echo "<th>STRUCTURE</th>";
							echo "<th>BATCHING<br />PLANT</th>";
							echo "<th>SALES<br />ENGR</th>";
							echo "<th>FORM</th>";
							echo "<th>UPDATE</th>";
						echo "</tr>";
			
			while ( $i < $rows) {
					
					$row = $ajaxfetch['result']->row($i);
					

					$id = $row->o202_id;
					$project_id = $row->project_id;
					$client_id = $row->client_id;
					$form_no = $row->form_no;
					$project_name = strtoupper($row->proj_name);
					$project_address = strtoupper($row->proj_address);
					$cust_name = strtoupper($row->cust_name);


					//get the design status and batching plant location
					$smd_status = $row->smd_status;
					$design_status = $row->design_status;
					$batching_plant = $row->batching_plant;

					// get design values
					$book_psi = $row->book_psi;
					$book_msa = $row->book_msa;
					$book_cd = $row->book_cd;
					$book_sp = $row->book_sp;

					//get values of other fields
					$qc_remarks = $row->qc_remarks;
					$acctg_remarks = $row->acctg_remarks;
					$design_time = $row->modified_time;
					$design_date = $row->modified_date;
					$remarks = $row->remarks;
					$design_volume = $row->batch_vol;
					$pouring = $row->pour_type;
					$structure = $row->structure;
					$service_engr = $row->service_engr;
					$qa_rep = $row->qa_rep;
					$sales_engr = $row->special_se;
					$f_code1 = $row->f_code1;
					$f_code2 = $row->f_code2;
					$po = $row->po_no;

					//get the notes value
					$notes_admin = $row->note_admin;
					$notes_acctg = $row->note_acctg;
					$notes_smd = $row->note_smd;
					$notes_dispatch = $row->note_dispatch;
					$notes_qa = $row->note_qa;


					//decide the bgcolor according to design status
					switch ($design_status) {
						case 'Re-Sched':
							$myClass = 'resched-schedule';
							break;

						case 'Insert':
							$myClass = 'insert-schedule';
							break;

						case 'For Confirmation':
							$myClass = 'forconfirm-schedule';
							break;

						default:
							$myClass = 'normal-schedule';
							break;
					}

					echo "<tr class='items'>";
						echo "<td align='left' class='$myClass'>";
							echo "<p class='info'><strong><a href='' class='dpscust-item'>$cust_name</a></strong></p>";
							echo "<p class='info'><strong><a href=''>$project_name</a></strong></p>";
							echo "<p class='info'>$project_address</p>";
						echo "</td>";

						echo "<td align='center'>$qc_remarks</td>";
						//echo "<td align='center'>$po_no</td>";
						echo "<td align='center' class='altcol'>$acctg_remarks</td>";

						echo "<td align='center'>";
							echo "$design_time<br />";
							if ($this->lvl == 75) {
								echo "$design_date";
							}else{
								echo "<input type='text' class='searchbydate-date' name='design-date' id='$id' value='$design_date' readonly/>";
							}
							
						echo "</td>";

						echo "<td align='center' class='altcol'>$remarks</td>";
						echo "<td align='center'>$design_volume</td>";

						echo "<td align='center' id='designtd' width='160'>";
							echo "<div id='tdwrapper'>";
								echo "<div id='design'>";
									echo "<span class='alt'><a>$book_psi</a></span>";
									echo "<span class='alt2'><a>$book_msa</a></span>";
									echo "<span class='alt'><a>$book_cd</a></span>";
									echo "<span class='alt2'><a>$book_sp</a></span>";
								echo "</div>";

								echo "<div id='code'>";
									echo "<span id='code1'><a>$f_code1</a></span>";
									echo "<span id='code2'><a>$f_code2</a></span>";
								echo "</div>";
							echo "</div>";
						echo "</td>";


						echo "<td align='center'>$pouring</td>";
						echo "<td align='center' class='altcol'>$structure</td>";
						echo "<td align='center'>$batching_plant</td>";
						echo "<td align='center' class='altcol'>$sales_engr</td>";						
						echo "<td align='center'>$form_no</td>";
						if ($this->lvl == 75) {
							echo "<td align='center' id='left' class='altcol' ></td>";
						}else{
							echo "<td align='center' id='left' class='altcol' ><a href='#' id='$id' class='searchbydate-updatebut'>UPDATE</a></td>";
						}
						





					echo "</tr>";
				$i++;
			}

			echo "</table>";
			echo "<br />";

			

		}else{
			echo "<center><h1>No Schedule pouring for this date : $date</h1></center>";
		}
	}
	/*
	For Finance View search only 
	added by wbsolon 04/24/19
	*/
	function ajax_searchbydate_FID()
	{
		$date = $_POST['date'];

		$ajaxfetch = $this->dps_model->ajax_fetch_booking($date);

		$ajaxfetch;

		if($ajaxfetch['count'] == 'record'){
			$rows = $ajaxfetch['result']->num_rows();
			$i = 0;

			echo "<center><h1>Pouring Schedule for this date : $date</h1></center>";

			echo "<table id='mytablefid'>";
						
						echo "<tr id='heading'>";
							
							echo "<th width='220'>CUSTOMER NAME / PROJECT / LOCATION</th>";
							echo "<th>OTHER<br />REMARKS</th>";
							echo "<th>ACCTG<br />REMARKS</th>";
							echo "<th>TIME<br />(hours)</th>";
							echo "<th>REMARKS</th>";
							echo "<th>VOLUME</th>";
							echo "<th align='center'>CONCRETE DESIGN";
								echo "<div id='condes-header'>";
									echo "<span class='alt'><a>PSI</a></span>";
									echo "<span class='alt2'><a>MSA</a></span>";
									echo "<span class='alt'><a>C</a></span>";
									echo "<span class='alt2'><a>S</a></span>";
								echo "</div>";
							echo "</th>";
							echo "<th>POURING<br />TYPE</th>";
							echo "<th>STRUCTURE</th>";
							echo "<th>BATCHING<br />PLANT</th>";
							echo "<th>SALES<br />ENGR</th>";
							echo "<th>FORM</th>";
							
						echo "</tr>";

			while ( $i < $rows) {
					
					$row = $ajaxfetch['result']->row($i);
					

					$id = $row->o202_id;
					$project_id = $row->project_id;
					$client_id = $row->client_id;
					$form_no = $row->form_no;
					$project_name = strtoupper($row->proj_name);
					$project_address = strtoupper($row->proj_address);
					$cust_name = strtoupper($row->cust_name);


					//get the design status and batching plant location
					$smd_status = $row->smd_status;
					$design_status = $row->design_status;
					$batching_plant = $row->batching_plant;

					// get design values
					$book_psi = $row->book_psi;
					$book_msa = $row->book_msa;
					$book_cd = $row->book_cd;
					$book_sp = $row->book_sp;

					//get values of other fields
					$qc_remarks = $row->qc_remarks;
					$acctg_remarks = $row->acctg_remarks;
					$design_time = $row->modified_time;
					$design_date = $row->modified_date;
					$remarks = $row->remarks;
					$design_volume = $row->batch_vol;
					$pouring = $row->pour_type;
					$structure = $row->structure;
					$service_engr = $row->service_engr;
					$qa_rep = $row->qa_rep;
					$sales_engr = $row->special_se;
					$f_code1 = $row->f_code1;
					$f_code2 = $row->f_code2;
					$po = $row->po_no;

					//get the notes value
					$notes_admin = $row->note_admin;
					$notes_acctg = $row->note_acctg;
					$notes_smd = $row->note_smd;
					$notes_dispatch = $row->note_dispatch;
					$notes_qa = $row->note_qa;


					//decide the bgcolor according to design status
					switch ($design_status) {
						case 'Re-Sched':
							$myClass = 'resched-schedule';
							break;

						case 'Insert':
							$myClass = 'insert-schedule';
							break;

						case 'For Confirmation':
							$myClass = 'forconfirm-schedule';
							break;

						default:
							$myClass = 'normal-schedule';
							break;
					}

					echo "<tr class='items'>";
						echo "<td align='left' class='$myClass'>";
							echo "<p class='info'><strong><a href='' class='dpscust-item'>$cust_name</a></strong></p>";
							echo "<p class='info'><strong><a href=''>$project_name</a></strong></p>";
							echo "<p class='info'>$project_address</p>";
						echo "</td>";

						echo "<td align='center'>$qc_remarks</td>";
						//echo "<td align='center'>$po_no</td>";
						echo "<td align='center' class='altcol2'>$acctg_remarks</td>";

						echo "<td align='center'>";
							echo "$design_time<br />";
							if ($this->lvl == 75) {
								echo "$design_date";
							}else{
								/*echo "<input type='text' class='searchbydate-date' name='design-date' id='$id' value='$design_date' style='width:100%;'/>";*/
								echo "<input class='searchbydate-date-fid' name='design-date' id='$id' value='$design_date' readonly />";
							}
							
						echo "</td>";

						echo "<td align='center' class='altcol2'>$remarks</td>";
						echo "<td align='center'>$design_volume</td>";

						echo "<td align='center' id='designtd' width='160'>";
							echo "<div id='tdwrapper'>";
								echo "<div id='design'>";
									echo "<span class='alt'><a>$book_psi</a></span>";
									echo "<span class='alt2'><a>$book_msa</a></span>";
									echo "<span class='alt'><a>$book_cd</a></span>";
									echo "<span class='alt2'><a>$book_sp</a></span>";
								echo "</div>";

								echo "<div id='code'>";
									echo "<span id='code1'><a>$f_code1</a></span>";
									echo "<span id='code2'><a>$f_code2</a></span>";
								echo "</div>";
							echo "</div>";
						echo "</td>";


						echo "<td align='center'>$pouring</td>";
						echo "<td align='center' class='altcol2'>$structure</td>";
						echo "<td align='center'>$batching_plant</td>";
						echo "<td align='center' class='altcol2'>$sales_engr</td>";						
						echo "<td align='center'>$form_no</td>";
						if ($this->lvl == 75) {
							//echo "<td align='center' id='left' class='altcol' ></td>";
						}else{
							//echo "<td align='center' id='left' class='altcol' ><a href='#' id='$id' class='searchbydate-updatebut'>UPDATE</a></td>";
						}
						





					echo "</tr>";
				$i++;
			}

			echo "</table>";
			echo "<br />";

			

		}else{
			echo "<center><h1>No Schedule pouring for this date : $date</h1></center>";
		}
	}

	//search by cutomer added by ralph September 9, 2013
	function ajax_searchbycust()
	{
		$cust = $_POST['cust'];
		$cust_name = $_POST['name'];

		$ajaxfetch = $this->dps_model->ajax_fetch_booking_cust($cust_name);

		$ajaxfetch;

		if($ajaxfetch['count'] == 'record'){
			$rows = $ajaxfetch['result']->num_rows();
			$i = 0;

			echo "<center><h1>Pouring Schedules of $cust_name</h1></center>";

			echo "<table id='mytable'>";
						
						echo "<tr id='heading'>";
							
							echo "<th width='220'>CUSTOMER NAME / PROJECT / LOCATION</th>";
							echo "<th>P.O. #</th>";
							echo "<th>ACCTG<br />REMARKS</th>";
							echo "<th>Original Date<br />(time)</th>";
							echo "<th>Modified Date<br />(time)</th>";
							echo "<th>REMARKS</th>";
							echo "<th>VOLUME</th>";
							echo "<th align='center'>CONCRETE DESIGN";
								echo "<div id='condes-header'>";
									echo "<span class='alt'><a>PSI</a></span>";
									echo "<span class='alt2'><a>MSA</a></span>";
									echo "<span class='alt'><a>C</a></span>";
									echo "<span class='alt2'><a>S</a></span>";
								echo "</div>";
							echo "</th>";
							echo "<th>POURING<br />TYPE</th>";
							echo "<th>STRUCTURE</th>";
							echo "<th>BATCHING<br />PLANT</th>";
							echo "<th>SALES<br />ENGR</th>";
							echo "<th>FORM</th>";
							//echo "<th>UPDATE</th>";
						echo "</tr>";

			while ( $i < $rows) {
					
					$row = $ajaxfetch['result']->row($i);
					

					$id = $row->o202_id;
					$project_id = $row->project_id;
					$client_id = $row->client_id;
					$form_no = $row->form_no;
					$project_name = strtoupper($row->proj_name);
					$project_address = strtoupper($row->proj_address);
					$cust_name = strtoupper($row->cust_name);


					//get the design status and batching plant location
					$smd_status = $row->smd_status;
					$design_status = $row->design_status;
					$batching_plant = $row->batching_plant;

					// get design values
					$book_psi = $row->book_psi;
					$book_msa = $row->book_msa;
					$book_cd = $row->book_cd;
					$book_sp = $row->book_sp;

					//get values of other fields
					$qc_remarks = $row->qc_remarks;
					$acctg_remarks = $row->acctg_remarks;

					$design_time = $row->modified_time;
					$design_date = $row->modified_date;

					$orig_time = $row->sched_time;
					$orig_date = $row->sched_date;

					$remarks = $row->remarks;
					$design_volume = $row->batch_vol;
					$pouring = $row->pour_type;
					$structure = $row->structure;
					$service_engr = $row->service_engr;
					$qa_rep = $row->qa_rep;
					$sales_engr = $row->special_se;
					$f_code1 = $row->f_code1;
					$f_code2 = $row->f_code2;
					$po = $row->po_no;

					//get the notes value
					$notes_admin = $row->note_admin;
					$notes_acctg = $row->note_acctg;
					$notes_smd = $row->note_smd;
					$notes_dispatch = $row->note_dispatch;
					$notes_qa = $row->note_qa;


					//decide the bgcolor according to design status
					switch ($design_status) {
						case 'Re-Sched':
							$myClass = 'resched-schedule';
							break;

						case 'Insert':
							$myClass = 'insert-schedule';
							break;

						case 'For Confirmation':
							$myClass = 'forconfirm-schedule';
							break;

						default:
							$myClass = 'normal-schedule';
							break;
					}

					echo "<tr class='items'>";
						echo "<td align='left' class='$myClass'>";
							echo "<p class='info'><strong><a href='' class='dpscust-item'>$cust_name</a></strong></p>";
							echo "<p class='info'><strong><a href=''>$project_name</a></strong></p>";
							echo "<p class='info'>$project_address</p>";
						echo "</td>";

						//echo "<td align='center'>$qc_remarks</td>";
						echo "<td align='center'>$po</td>";
						echo "<td align='center' class='altcol'>$acctg_remarks</td>";

						echo "<td align='center'>";
							echo "$orig_date<br />";
							echo "$orig_time";
						echo "</td>";

						echo "<td align='center'>";
							echo "$design_date<br />";
							echo "$design_time";
						echo "</td>";

						echo "<td align='center' class='altcol'>$remarks</td>";
						echo "<td align='center'>$design_volume</td>";

						echo "<td align='center' id='designtd' width='160'>";
							echo "<div id='tdwrapper'>";
								echo "<div id='design'>";
									echo "<span class='alt'><a>$book_psi</a></span>";
									echo "<span class='alt2'><a>$book_msa</a></span>";
									echo "<span class='alt'><a>$book_cd</a></span>";
									echo "<span class='alt2'><a>$book_sp</a></span>";
								echo "</div>";

								echo "<div id='code'>";
									echo "<span id='code1'><a>$f_code1</a></span>";
									echo "<span id='code2'><a>$f_code2</a></span>";
								echo "</div>";
							echo "</div>";
						echo "</td>";


						echo "<td align='center'>$pouring</td>";
						echo "<td align='center' class='altcol'>$structure</td>";
						echo "<td align='center'>$batching_plant</td>";
						echo "<td align='center' class='altcol'>$sales_engr</td>";						
						echo "<td align='center'>$form_no</td>";
						//echo "<td align='center' id='left' class='altcol' ><a href='#' id='$id' class='searchbydate-updatebut'>UPDATE</a></td>";





					echo "</tr>";
				$i++;
			}

			echo "</table>";
			echo "<br />";

			

		}else{
			echo "<center><h1>No Schedule pouring for this customer.</h1></center>";
		}
	}

	function ajax_design_insert()
	{
		$property = $_POST['property'];
		$value = $_POST['value'];
		$unit = $_POST['code'];

		switch ($property) {
			case 'strength':
				$result = $this->dps_model->insert_new_strength($value,$unit);
				break;
			
			case 'aggregates':
				$result = $this->dps_model->insert_new_aggregates($value,$unit);
				break;

			case 'slump':
				$result = $this->dps_model->insert_new_slump($value,$unit);
				break;

			case 'pouringtype':
				$result = $this->dps_model->insert_new_pouringtype($value,$unit);
				break;

			case 'structures':
				$result = $this->dps_model->insert_new_structures($unit);
				break;
		}

		echo $result;
	}

	function mngr_approved()
	{
		$plant = $_POST['plant'];
		$date = $_POST['date'];
		foreach ($_POST['dps-summary-checkitems'] as $val) {
            $id = $val;
        
        	$this->dps_model->set_manager_status($id,'Approved',$plant,$date);
        	$this->dps_model->set_revisionstatus($id);
        }
        redirect('dps');
		
	}

	function deniedprint()
    {
    	$data['level'] = $this->lvl;
    	$data['status'] = '';
    	$this->load->view('templates/denied_print', $data);
    }

    function ajax_editsearchdesign_date(){
    	$id = $_POST['id'];
		$date = $_POST['date'];


		/*
		$this->dps_model->update_schedate_by_searchdesign($id,$date);
		*/
		$this->dps_model->update_schedate_by_searchdesign2($id,$date);
    }

    function ajax_importbatch()
    {
    	$id = $_POST['id'];

    	$checkexist = $this->dps_model->check_import_exist($id);
    	if($checkexist){
    		//update only
    		$this->dps_model->update_imported_bookings($id);
    		echo "existing";

    	}else{
    		//insert
    		$this->dps_model->import_approved_bookings($id);
    		echo "imported";
    	}
    }

    function ajax_write_chatmsg()
    {
    	$username = $this->session->userdata('nick');
    	$message = $_POST['message'];

    	

    	$filename = "chat/log.txt";
		

		$msg_time = date('h:i a');
		$msg_date = date('F/d/Y');		
		$msg = $msg_date . "-".$msg_time . "-" . $message . "\n";
		//$msg = $message . "\n";

		
		if (!$handle = fopen($filename, 'a')) {
		}

		// Write $somecontent to our opened file.
		if (fwrite($handle, $msg) === FALSE) {
		}


		fclose($handle);

    }

    function ajax_write_usersonline()
    {
    	$username = $this->session->userdata('nick');
    	$filename = "chat/onlineusers.txt";

    	//check if user exist in the textfile
    		$search = $username;
			$lines = file($filename);
			// Store true when the text is found
			$found = false;
			foreach($lines as $line)
			{
			  if(strpos($line, $search) !== FALSE)
			  {
			    $found = true;
			  }
			}

			// If the text was not found, show a message
			if(!$found)
			{
			  	$users = $username . "\n";

				if (!$handle = fopen($filename, 'a')) {
				}

				// Write $somecontent to our opened file.
				if (fwrite($handle, $users) === FALSE) {
				}

				fclose($handle);
			}
    }

    function ajax_get_onlineusers(){
    		$filename = "chat/onlineusers.txt";

    	//check if user exist in the textfile
    		$search = $username;
			$lines = file($filename);
			// Store true when the text is found
			$found = false;
			foreach($lines as $line)
			{
			  if(strpos($line, $search) !== FALSE)
			  {
			    $found = true;
			  }
			}

			// If the text was not found, show a message
			if(!$found)
			{
			  	$users = $username . "\n";

				if (!$handle = fopen($filename, 'a')) {
				}

				// Write $somecontent to our opened file.
				if (fwrite($handle, $users) === FALSE) {
				}

				fclose($handle);
			}
    }

    function errorPage()
	{
		$data['level'] = $this->lvl;
    	$data['status'] = '';
    	$data['error_msg'] = $this->session->userdata('error_msg');
    	$this->load->view('templates/errorpage', $data);
	}

	function process_formula(){

    	$init_num = 809;
    	$last_count = 856;
    	$i = $init_num;

    	while ($i <= $last_count) {
    		# code...
    		//echo "record number = " .$i;
    		//echo "<br />";

    		//insert the concrete table alues to mix_design table values
    		$this->dps_model->insert_formula($i);
    

    		$i++;
    	}
    }

    function useredit(){
    	
    	$data['status'] = '';
    	
    	$this->load->view('templates/useredit', $data);
    }


    function ajax_updateprofile(){
    	$id = $_POST['id'];
    	$password = $_POST['password'];
    	$first_name = $_POST['fname'];
    	$last_name = $_POST['lname'];

    	if($password <> ''){
    		$this->dps_model->update_user_pass($id,$password);
    	}
    	$result = $this->dps_model->update_user_info($id,$first_name,$last_name);
    	
    	if($result){
    		echo "success";
    	}else{
    		echo "error";
    	}
    	

    }

    function ajax_unapproved_smd(){
    	$id = $_POST['id'];

    	$res = $this->dps_model->unapproved_by_smd($id);
    	echo $res;
    }
    
    //added by WBSOLON Nov 19,2018
    function ajax_prepaid_smd(){
    	$id = $_POST['id'];

    	$res = $this->dps_model->prepaid_by_smd($id);
    	echo $res;
    }

    function view_pendings(){
    	if($this->session->userdata('is_logged_in')){	
			if($this->functionlist->isDPSCoordinator($this->lvl) OR $this->functionlist->isAdmin($this->lvl)){
				$data['status']='';
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				$pendings = $this->dps_model->get_pendingscheds();
				if($pendings['rowcount'] > 0){
					$data['pendings_table'] = $this->load->view($pendings['view'], $pendings,true);
				}else{
					$data['pendings_table'] = 'No Pending Schedules';
				}
				

				$this->body['view'] = 'dps/pendingsched';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Pending Schedules');
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
    }

    function ajax_updatepending(){
    	$id = $_POST['id'];
    	$date = $_POST['date'];
    	$status = $_POST['status'];
    	
		

    	$res = $this->dps_model->update_pendingscheds($id,$date,$status);
    	
    	

    	if($res > 0){
    		echo "okay";
    	}else{
    		echo "error";
    	}


    	//put a logger here to see if who is updating the sched
    	$page_url = site_url() . uri_string();
    	$data = array(
    		'initial' => $this->initial,
    		'time_log' => $this->timeNow,
    		'date_log' => $this->dateNow,
    		'url' => $page_url,
    		'order_id' => $id,
    		'design_status' => $status
    		);
    	$this->dps_model->pending_logger($data);
    }


    function testgen_form1(){
    	$lol = $this->dps_model->generate_formno('form1');


    	var_dump($lol);
    }

    function testgen_form1a(){
    	$lol = $this->dps_model->generate_formno('form1a');


    	var_dump($lol);
    }

    function ajax_search_contacts(){
    	$sched_id = $_POST['schedid'];

		$ajaxfetch = $this->dps_model->ajax_fetch_booking_contacts($sched_id);

		$rows = $ajaxfetch->num_rows();
			$i = 0;

			while ( $i < $rows) {
					
					$row = $ajaxfetch->row($i);
					

					$pouring_engr = $row->pouring_engr;
					$pouring_contact = $row->pouring_contact;
					$finishing_coor = $row->finishing_coor;
					$finishing_contact = $row->finishing_contact;

					echo "<div class='contacts-wrapper'>";
						echo "<p id='title'><strong>CONTACTS</strong></p>";
						
						echo "<p id='admin' class='items'><span>Pouring Engg. : </span> " . $pouring_engr . "</p>";
						echo "<p id='admin' class='items'><span>Contact : </span> " . $pouring_contact . "</p>";
						echo "<p id='admin' class='items'><span>Finishing Coor : </span> " . $finishing_coor . "</p>";
						echo "<p id='admin' class='items'><span>Contact : </span> " . $finishing_contact . "</p>";
						
						echo "<br />";
					echo "</div>";
					


					
				$i++;
			}
    }

    //added by ralph nov 19, 2014
    function bookprojects()
	{
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl) ){

				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				$data['status'] ='';

				//get the employee id and search it to the sales ref table
				//var_dump($this->dps_model->get_sales_code($this->emp_id));exit();
				$empcode_result = $this->dps_model->get_sales_code($this->emp_id);
				if ($empcode_result <> "none"){
					$sales_code = $empcode_result[0]->code;
					$data['result']=$this->dps_model->getadvance_book($sales_code);
				}else{
					//override for the admin
					$sales_code = 'M2';  //'M3 to M2 request by smd manager - htsesaldo 06/13/19'
					$data['result']=$this->dps_model->getadvance_book($sales_code);
				}
				
				
				$data['sales_code'] =$sales_code;

				$data['timerap'] = $this->functionlist->getDPSTimeArrays();
        		$data['designstatus'] = $this->functionlist->getDesignStatus();

				$data['strength'] = $this->dps_model->get_design_strength();
				$data['agg'] = $this->dps_model->get_design_aggregates();
		        $data['slump'] = $this->dps_model->get_design_slump();
		        $data['pouringtype'] = $this->dps_model->get_design_pouringtype();
		        $data['structure'] = $this->dps_model->get_design_structure();
		        $data['salesengg'] = $this->dps_model->get_salesengg_list();
		        $data['extlab'] = $this->dps_model->get_extlab_list();

				

				
	
				$this->body['view'] = 'dps/bookprojects';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Book Projects');
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function gen_priority_nos(){

		$today = $this->dateNow;
		$nextday = $this->nextpouringdate;

		//generate for Plant 3 - SIMEM
		$this->dps_model->gen_priority($today,'Plant 3');
		$this->dps_model->gen_priority($nextday,'Plant 3');

		//generate for Plant 4 - BATCHTEC
		$this->dps_model->gen_priority($today,'Plant 4');
		$this->dps_model->gen_priority($nextday,'Plant 4');
		
	}

	function ajax_getproject_contract(){
		$project_id = $this->input->post('id');

		echo $this->dps_model->ajax_getproject_contract($project_id);
	}

	function ajax_update_weekly_sched(){
		$sched_ids = $this->input->post('sched-ids');
		$sched_date = $this->input->post('sched-date');

		$id_arr = json_decode($sched_ids);

		for($i=0;$i< count($id_arr);$i++)
		{
		  	$this->dps_model->ajax_update_weekly_sched($id_arr[$i],$i+1,$sched_date);
		}

		//get the waiting list and update them to UNAPPROVED
		$lol = $this->dps_model->ajax_get_weekly_waiting($sched_date);
		foreach ($lol as $row) {
			$this->dps_model->ajax_update_weekly_sched_unapproved($row['o202_id']);
		}


		echo "success";

	}

	function ajax_get_weekly_waiting(){
		$sched_date = $this->input->post('sched-date');


		echo json_encode($this->dps_model->ajax_get_weekly_waiting($sched_date));
	}

	function ajax_get_weekly_sched_detail(){
		$sched_id = $this->input->post('sched-id');
		echo json_encode($this->dps_model->ajax_get_weekly_sched_detail($sched_id));
	}

	function ajax_override_waiting_list(){
		$sched_id = $this->input->post('sched-id');
		echo $this->dps_model->ajax_override_waiting_list($sched_id);
	}

	//added by ralph so that smd can update the contract numbers
	function updatecontracts(){
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){

				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				$data['status'] ='';

				
		        $data['projects'] = $this->dps_model->get_project_list_contracts('2015');

	
				$this->body['view'] = 'dps/updatecontracts';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Update Contracts');
			}else{
		    	redirect('welcome/denied');
		    }
	    }else{
            redirect('main/login_dps');
        }
	}

	function ajax_update_contract(){
		$proj_id = $this->input->post('id');
		$contract_no = $this->input->post('contract');
		echo $this->dps_model->ajax_update_contract($proj_id,$contract_no);
	}


	/*
		Lines after this is for the contract feature
	*/


	function generate_contract_no(){
		
		/*
			yy-mm-ssss
			year-month-series
			generate contract no. using
			year / month / series of contract on the database
		*/

		$con_cnt = $this->dps_model->get_last_contract_no($this->currentYear,$this->currentMonth);
		$contract_count = sprintf('%04u', $con_cnt + 1);
		
		$this->contract_no = substr($this->currentYear, -2) . '-' . $this->currentMonth . '-' . $contract_count;
		return $this->contract_no;

	}

	function process_contract(){


		//contract
		$contract_no = $this->generate_contract_no();
		// $contract_date = $this->input->post('contract-date');
		$contract_date = $this->dateNow;

		// first party
		$first_party = $this->input->post('first-party');
		$sales_engr = $this->input->post('sales-engr');
		$sales_phone = $this->input->post('sales-phone');
		$sales_mobile = $this->input->post('sales-mobile');
		$first_signee = $this->input->post('first-signee');
		
		// second party

		$cust_name = $this->input->post('customer-name');
		$cust_address = $this->input->post('cust-address');
		$cust_contact = $this->input->post('cust-contact');
		$attn_person = $this->input->post('attn-person');
		$second_signee = $this->input->post('second-signee');

		// contract details
		$proj_name = $this->input->post('proj-name');
		$location = $this->input->post('location');
		$est_volume = $this->input->post('est-volume');
		$proj_duration = $this->input->post('proj-duration');
		$payment_terms = $this->input->post('payment-terms');
		$sales_invoice = $this->input->post('sales-invoice');
		$collection_bill = $this->input->post('collection-bill');

		// design details

		//notes
		$contract_notes = $this->input->post('contract-notes');

		
		
		//insert contract
		$contract_data = array(
				'contract_id'	=>	'',
				'contract_no'	=>	$contract_no,
				'contract_date'	=>	$contract_date,
				'con_month'		=>	$this->currentMonth,
				'con_year'		=>	$this->currentYear
		);
		$contract_id = $this->dps_model->insert_contract($contract_data);
		

		//insert contract details
		$contract_details_data = array(
				'contract_id'	=>	$contract_id,
				'first_party'	=>	$first_party,
				'sales_engr'	=>	$sales_engr,
				'sales_phone'	=>	$sales_phone,
				'sales_mobile'	=>	$sales_mobile,
				'first_signee'	=>	$first_signee,
				'cust_name'		=>	$cust_name,
				'cust_address'	=>	$cust_address,
				'attn_person'	=>	$attn_person,
				'second_signee'	=>	$second_signee,
				'proj_name'		=>	$proj_name,
				'proj_location'	=>	$location,
				'est_volume'	=>	$est_volume,
				'proj_duration'	=>	$proj_duration,
				'payment_terms'	=>	$payment_terms,
				'sales_invoice'	=>	$sales_invoice,
				'collection_bill'	=>	$collection_bill,
				'contract_notes'	=>	$contract_notes
		);
		

		$q_res = $this->dps_model->insert_contract_details($contract_details_data);
		if($q_res > 0){
			echo 'success created: ' . $contract_no ;
		}else
		{
			echo 'error';
		}

	}

	function generate_project_code(){
		//
	}

	function process_test(){
		$cons = 6;
		$sprintf_chars = '%0' . $cons . 'u';
		$project_no = $this->dps_model->get_last_project_no();
		$project_code = 'P' . sprintf($sprintf_chars, $project_no + 1);
		echo $project_code;
	}

	/*
		For BATCHTEC Integration added 11/05/2016 by M.O.Cinco
	*/


	function uploadbatching(){
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isSMD($this->lvl)){

				$this->dateSun = date('Y-m-d', strtotime('this Sunday'));

			    $this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				$data['status'] ='';
				$data['result']=$this->dps_model->get_for_batching($this->dateNow); //
				//echo $this->dateSun;
			    $this->body['view'] = 'dps/schedulertoday';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Upload Batching');
			}
			else{
		    	redirect('welcome/denied');
		    	}
	    	}
		else{
            	redirect('main/login_dps');
		}

	}
	


	//Added Batch Upload 9/10/2018 by:WBSOLON
	function upload_batch(){
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isDPSps($this->lvl) OR $this->functionlist->isDPSCoordinator($this->lvl) ){

			
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				$fdata =  $this->dps_model->get_batch_upload($this->dateNow);
				$fdata['whatday'] = 'today';
			    $data['status'] ='';
			    $data['result'] = $this->load->view($fdata['view'],$fdata,true);
				
			    $this->body['view'] = 'dps/batchupload';
			    $this->body['content'] = $data;
			    $this->pagemaker->basePage($this->body,'Upload Batching');


			}
			else{
		    	redirect('welcome/denied');
		    	}
	    	}
		else{
            	redirect('main/login_dps');
		}

	}
	//batch_view form action
	function batch_upload(){
	
		$batchuploads = $_POST['upselected'];
	
		foreach($batchuploads as $upid){
			//$this->dps_model->upsert_upload_status($upid);
			$this->GenerateXML($upid);
		}

		header('location:upload_batch');
	}

	function update_upload_stat(){
		
		$id = $this->input->post('id');
		$result=$this->dps_model->update_upload_status($id);

	}


/* ===================================================================================================================================
/	@CONTROLLER
/	XML METHOD EXECUTION
/	08/29/2019 - WBSOLON
======================================================================================================================================*/
	
	function UploadXML($filename,$id){
		
			//$this->load->library('ftp');
			//'./location_sketch/'
        	//$local_target = $this->GetLocalPath() ."/".$filename.".txt" ;
        	
        	// $local_target = "/var/www/jlregner.com/public_html/regner/XML_ORDER" ."/" .$filename .".txt";
        	$local_target = "/var/www/html/regner/XML_ORDER" ."/" .$filename .".txt";

        	//$local_target = $this->GetDIR() ."/XML_ORDER"."/" .$filename .".txt";
        	//$local_target = './location_sketch/' .$filename .".txt";
			
			//$remote_target = $this->GetRemotePath()."/".$filename.".txt";
			$remote_target = "/south_plant4/orders/" .$filename.".txt";
        	// $this->ftp->connect($this->functionlist->XMLConfig());							
        	// $this->ftp->upload($local_target,$remote_target , 'auto', 0775);    	
        	// $this->ftp->close();
    
 			$hostname = "172.17.56.117";
 			$username = "SAP-Trans";
			$password = "557ftp+30jlr"; 			

 			$connection = ftp_connect($hostname, 21) or die("can't connect");
 			$log = ftp_login($connection, $username, $password) or die("Wrong username or password.");

  			ftp_pasv($connection, true);
  
  			$upload = ftp_put($connection, $remote_target, $local_target, FTP_BINARY);
  			//if($upload) echo 'Error.';	
  			ftp_close($connection);

  			//UPDATE BATCH TRANSACTION IF UPLOADED TO FTP
  			$this->dps_model->SetIsUpload($id,$filename);
  			$this->dps_model->SetPlantUpload($id);
	}

	function GenerateXML1($id)
	{
		
		$file_name = $this->GenerateFilename();
		//$local_target = $this->GetLocalPath() ."/" .$file_name .".txt" ;
		//$local_target = '../XML_ORDER/' .$file_name .'.txt';

		//$local_target = $this->GetDIR() ."/XML_ORDER"."/" .$file_name .".txt";
		//$local_target = '/var/www/jlregner.com/public_html/regner/XML_ORDER/' .$file_name .'.txt';
		$local_target = "/var/www/html/regner/XML_ORDER" ."/" .$filename .".txt";
		//INSERT TO BATCH TRANSACTION
		//$this->dps_model->SetBatchTransaction($id,$file_name);

		//$this->FindFile();
		//$this->FindFile2($file_name);

		$xml = new XMLWriter();

		//$xml->openURI($local_target);
		$xml->openMemory();

		$xml->setIndent(true);

		$xml->startElement('Document');							//START DOCUMENT

			$xml->startElement('Transaction');					//START TRANSACTION	
			
				foreach ($this->dps_model->get_xml_data($id) as $row)
				{
    				foreach($row as $key=>$val)
    				{    			
    					//$xml->startElement($key);
    					//$xml->writeRaw($val);
   						//$xml->endElement();
   						
   						$xml->startElement($key);
						$xml->text($val);
						$xml->endElement();
    				}
				}
				
			$xml->endElement(); 								//END TRANSACTION
			
			$transaction_details = $this->dps_model->get_xml_data_details($id);
			
			if (count($transaction_details) > 0)
			{
				$xml->startElement('TransactionDetails');		//START TRANSACTION DETAIL

					foreach($transaction_details as $row)
					{	
						$xml->startElement('Ingredient');		//START INGREDIENT						
							
							foreach($row as $key=>$val)
							{
								//$xml->startElement($key);
								//$xml->writeRaw($val);
								//$xml->endElement();

								$xml->startElement($key);
								$xml->text($val);
								$xml->endElement();
							}

						$xml->endElement(); 					//END INGREDIENT
					}				

				$xml->endElement(); 							//END TRANSACTION DETAILS

			}

		$xml->endElement(); 									//END DOCUMENT
		
		//$xml->flush();
		$oXMLWriter  = $xml->outputMemory ();

		$myfile = fopen($local_target, "w") or die("Unable to open file!");
 		fwrite($myfile, $oXMLWriter);
 		fclose($myfile);

		//UPDATE BATCH TRANSACTION IF GNERATE TO LOCAL
		//$this->dps_model->SetIsGenerate($id,$file_name);
			
		//$this->UploadXML($file_name,$id);						//UPLOAD XML TO FTP
	}
	function GenerateXML($id)
	{
		
		$file_name = $this->GenerateFilename();
		// $local_target = '/var/www/jlregner.com/public_html/regner/XML_ORDER/' .$file_name .'.txt';

		// $local_target = '/var/www/jlregner.com/public_html/regner/XML_ORDER/' .$file_name .'.txt';
		$local_target = "/var/www/html/regner/XML_ORDER" ."/" .$file_name .".txt";

		$myfile = fopen($local_target, "w") or die("Unable to open file!");		
		fwrite($myfile, "<Document>");
			fwrite($myfile, "\n\t<Transaction>"); 
				foreach ($this->dps_model->get_xml_data($id) as $row)
					{
    					foreach($row as $key=>$val)
    					{    			
    						fwrite($myfile, "\n\t\t<".$key .">" .$val ."</".$key .">");
    						//fwrite($myfile, "\t\t");
    					}
				}		
			fwrite($myfile, "\n\t</Transaction>");

			$transaction_details = $this->dps_model->get_xml_data_details($id);
			
			if (count($transaction_details) > 0)
			{
				fwrite($myfile, "\n\t<TransactionDetails>");
				//$xml->startElement('TransactionDetails');		//START TRANSACTION DETAIL

					foreach($transaction_details as $row)
					{	
						fwrite($myfile, "\n\t\t<Ingredient>");
						//$xml->startElement('Ingredient');		//START INGREDIENT						
							foreach($row as $key=>$val)
							{
								fwrite($myfile, "\n\t\t\t<".$key .">" .$val ."</".$key .">");
    							//fwrite($myfile, "\t\t\t");
							}
						fwrite($myfile, "\n\t\t</Ingredient>");
						//$xml->endElement(); 					//END INGREDIENT
					}				
				fwrite($myfile, "\n\t</TransactionDetails>");
				//$xml->endElement(); 							//END TRANSACTION DETAILS
		}				
		fwrite($myfile, "\n</Document>");		 
		fclose($myfile);
		
		//UPDATE BATCH TRANSACTION IF GNERATE TO LOCAL
		$this->dps_model->SetIsGenerate($id,$file_name);			
		$this->UploadXML($file_name,$id);						//UPLOAD XML TO FTP
	}


	function GetRemoteFile()
	{
		$data = $this->dps_model->GetRemoteFile(6);

		foreach ($data as $row){      
            return str_replace('ftp://172.17.56.117', '', $row->target);
        }
	}

	function GetRemotePath()
	{
		$data = $this->dps_model->GetRemotePath(6);

		foreach ($data as $row){      
            return str_replace('ftp://172.17.56.117', '', $row->path);
        }
	}

	function GetLocalFile()
	{
		$data = $this->dps_model->GetLocalFile(6);
		
        foreach ($data as $row){
            return $row->target;
        }	
	}

	function GetLocalPath()
	{
		$data = $this->dps_model->GetLocalPath(6);

        foreach ($data as $row){
            return $row->path;
        }	
	}

	function FindFile(){
		//file exist nothing to do else make directory 
		if(file_exists($this->GetLocalPath()) || file_exists($this->GetLocalFile())){

		}else{
			mkdir($this->GetLocalPath());		
		}		
	}

	function FindFile2($file_name){
		//file exist nothing to do else make directory 
		if(file_exists("".$this->GetDIR() ."/XML_ORDER") || file_exists("".$this->GetDIR() ."/XML_ORDER/".$file_name .".txt")){

		}else{
			mkdir($this->GetDIR() ."/XML_ORDER");		
		}		
	}

	function GenerateFilename(){
		date_default_timezone_set('Asia/Manila');
		
		$microtime = microtime(true);
		$time = sprintf("%04d",($microtime - floor($microtime)) * 10000);	

		return "".date("YmdHis") .$time;
	}

	function GetDIR(){

		$cnt_dir = pathinfo(dirname(__FILE__));
		$dir = pathinfo($cnt_dir['dirname']);
		$root = pathinfo($dir['dirname']);
		
		return str_replace("\\","/",$root['dirname']);
	}

	//TRIGGERED FROM mngr_approved
	function ajax_generateXML($id)
	{	
    	$this->GenerateXML($id);
 
	}

	function ajax_generateXML1()
	{	
		$id = $_POST['id'];
    	//$this->GenerateXML($id);

 
	}

/* ===================================================================================================================================
	END OF XML METHOD EXECUTION
======================================================================================================================================*/

	function dpsYesterDay()
	{
		//echo date('Y-m-d', strtotime('-9 days', strtotime(date("Y-m-d"))));
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
				
				
        		$date_yesterday = date("Y-m-d",strtotime( '-1 days' ));
        		$date_yesterday2 = date("Y-m-d",strtotime( '-2 days' ));

				$content['status']='';
				$content['action']='main/checklogin';
				//display the login page to the user
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				

	    		 $content['dateTom'] = $date_yesterday;				
	    		//$content['dateTom'] = $dtYesterday;
	    		$content['dateTom2'] = $this->date_Tom[0];					//unix timestamp pass for conversion into format eg; December 30, 2012
	    		
				
		        //-----------------------------------------------------------------------
		        //	FOR MOBILE DATA HERE
		        //-----------------------------------------------------------------------
		        $mbooking_today_north = $this->dps_model->fetch_bookings_mobile($date_yesterday,'Plant 3','fluid');
		        $mbooking_today_north_resched = $this->dps_model->get_mobile_resched($date_yesterday,'Plant 3');
		        $content['m_today_north'] = $this->load->view($mbooking_today_north['view'], $mbooking_today_north,true);
		        	//volume,schedule and insert count here
		        	$content['mtodaynorth_vol'] = $mbooking_today_north['volume'];
		        	$content['mtodaynorth_okaycount'] = $mbooking_today_north['okaycount'];
		        	$content['mtodaynorth_insertcount'] = $mbooking_today_north['insertcount'];
		        	$content['mtodaynorth_reschedcount'] = $mbooking_today_north_resched['count'];
		        	$content['mtodaynorth_insertvolume'] = $this->dps_model->getVol($date_yesterday,2,'Plant 3');
		        	$content['mtodaynorth_reschedvolume'] = $mbooking_today_north_resched['volume'];
		        $mbooking_today_northfix = $this->dps_model->fetch_bookings_mobile($date_yesterday,'Plant 3','fix');
		        $content['m_today_northfix'] = $this->load->view($mbooking_today_northfix['view'], $mbooking_today_northfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$date_yesterday,'Plant 3');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$date_yesterday,'Plant 3');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$date_yesterday,'Plant 3');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['today_north_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);


		        $mbooking_today_south = $this->dps_model->fetch_bookings_mobile($date_yesterday,'Plant 4','fluid');
		        $mbooking_today_south_resched = $this->dps_model->get_mobile_resched($date_yesterday,'Plant 4');
		        $content['m_today_south'] = $this->load->view($mbooking_today_south['view'], $mbooking_today_south,true);
		       
		        	//volume,schedule and insert count here
		        	$content['mtodaysouth_vol'] = $mbooking_today_south['volume'];
		        	$content['mtodaysouth_okaycount'] = $mbooking_today_south['okaycount'];
		        	$content['mtodaysouth_insertcount'] = $mbooking_today_south['insertcount'];
		        	$content['mtodaysouth_reschedcount'] = $mbooking_today_south_resched['count'];
		        	$content['mtodaysouth_insertvolume'] = $this->dps_model->getVol($date_yesterday,2,'Plant 4');
		        	$content['mtodaysouth_reschedvolume'] = $mbooking_today_south_resched['volume'];

		        	//Total Volume
		        	$content['mtodaytotal_vol'] = $mbooking_today_north['volume'] + $mbooking_today_south['volume'];
		        $mbooking_today_southfix = $this->dps_model->fetch_bookings_mobile($date_yesterday,'Plant 4','fix');
		        $content['m_today_southfix'] = $this->load->view($mbooking_today_southfix['view'], $mbooking_today_southfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$date_yesterday,'Plant 4');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$date_yesterday,'Plant 4');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$tdate_yesterday,'Plant 4');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['today_south_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);




		        $mbooking_tom_north = $this->dps_model->fetch_bookings_mobile($date_yesterday2,'Plant 3','fluid');
		        $mbooking_tom_north_resched = $this->dps_model->get_mobile_resched($date_yesterday2,'Plant 3');
		        $content['m_tom_north'] = $this->load->view($mbooking_tom_north['view'], $mbooking_tom_north,true);
		        	//volume,schedule and insert count here
		        	$content['mtomnorth_vol'] = $mbooking_tom_north['volume'];
		        	$content['mtomnorth_okaycount'] = $mbooking_tom_north['okaycount'];
		        	$content['mtomnorth_insertcount'] = $mbooking_tom_north['insertcount'];
		        	$content['mtomnorth_reschedcount'] = $mbooking_tom_north_resched['count'];
		        	$content['mtomnorth_insertvolume'] = $this->dps_model->getVol($date_yesterday2,2,'Plant 3');
		        	$content['mtomnorth_reschedvolume'] = $mbooking_tom_north_resched['volume'];

		        $mbooking_tom_northfix = $this->dps_model->fetch_bookings_mobile($date_yesterday2,'Plant 3','fix');
		        $content['m_tom_northfix'] = $this->load->view($mbooking_tom_northfix['view'], $mbooking_tom_northfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$date_yesterday2,'Plant 3');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$date_yesterday2,'Plant 3');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$date_yesterday2,'Plant 3');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['tom_north_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);


		        $mbooking_tom_south = $this->dps_model->fetch_bookings_mobile($date_yesterday2,'Plant 4','fluid');
		        $mbooking_tom_south_resched = $this->dps_model->get_mobile_resched($date_yesterday2,'Plant 4');
		        $content['m_tom_south'] = $this->load->view($mbooking_tom_south['view'], $mbooking_tom_south,true);
		       		//volume,schedule and insert count here
		        	$content['mtomsouth_vol'] = $mbooking_tom_south['volume'];
		        	$content['mtomsouth_okaycount'] = $mbooking_tom_south['okaycount'];
		        	$content['mtomsouth_insertcount'] = $mbooking_tom_south['insertcount'];
		        	$content['mtomsouth_reschedcount'] = $mbooking_tom_south_resched['count'];
		        	$content['mtomsouth_insertvolume'] = $this->dps_model->getVol($date_yesterday2,2,'Plant 4');
		        	$content['mtomsouth_reschedvolume'] = $mbooking_tom_south_resched['volume'];

		        	//Total Volume
		        	$content['mtomtotal_vol'] = $mbooking_tom_north['volume'] + $mbooking_tom_south['volume'];
		        $mbooking_tom_southfix = $this->dps_model->fetch_bookings_mobile($date_yesterday2,'Plant 4','fix');
		        $content['m_tom_southfix'] = $this->load->view($mbooking_tom_southfix['view'], $mbooking_tom_southfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$date_yesterday2,'Plant 4');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$date_yesterday2,'Plant 4');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$date_yesterday2,'Plant 4');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['tom_south_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);

		        
		        // Weekly scheduling by Ralph
		        if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isDPSCoordinator($this->lvl)){
		        	$content['lock_class'] = '';
		        	$content['waiting_class'] = '';
		        }else{
		        	$content['lock_class'] = 'disable-waiting';
		        	$content['waiting_class'] = 'view-only';
		        }

		        if($this->functionlist->isDPSsmd($this->lvl)){
		        	$content['issmd_man'] = 'yes';
		        }else{
		        	$content['issmd_man'] = 'no';
		        }

		        $this->dtNow = date("Y-m-d");
				$this->dtYesterday = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1));
				$this->dtTommorow = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1));
				$this->dtTommorow2 = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+2));
				$this->dtTommorow3 = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+3));


				$ctr = 1;
				$date_arr = array($this->dtYesterday,$this->dtNow,$this->dtTommorow,$this->dtTommorow2,$this->dtTommorow3);
				foreach ($date_arr as $sched_date) {
					//iterate through dates

					//echo $sched_date . '<br />';
					if($this->dps_model->check_if_queued($sched_date)){
						//
						//update for status=waiting
						$this->dps_model->update_w_scheds_waiting($sched_date);
					}else{
						//generate listing
						//get sales codes
						$sales_reps = $this->dps_model->get_sales_rep();
						foreach ($sales_reps as $row) {
						    $sales_code = $row['code'];
						    $this->dps_model->get_w_sched($sched_date,$sales_code);
						}
						//update for status=waiting
						$this->dps_model->update_w_scheds_waiting($sched_date);
						//update the queue order
						$this->dps_model->order_queue_list($sched_date);
					}


					$content['scheds'.$ctr] = $this->dps_model->get_weekly_sched($sched_date);

					$total_rows = 0;
					$total_north_rows = 0;
					$total_south_rows = 0;
					$total_volume = 0;
					$total_north = 0;
					$total_south = 0;

					foreach ($content['scheds'.$ctr] as $row) {
						if ($row['batching_plant'] == 'Plant 3'){
							$total_north = $total_north + $row['batch_vol'];
							$total_north_rows ++;
						}elseif($row['batching_plant'] == 'Plant 4'){
							$total_south = $total_south + $row['batch_vol'];
							$total_south_rows ++;
						}
					}

					$total_volume = $total_north + $total_south;
					$total_rows = $total_north_rows + $total_south_rows;

					$content['total_rows'][$ctr]= $total_rows;
					$content['total_north_rows'][$ctr]= $total_north_rows;
					$content['total_south_rows'][$ctr]= $total_south_rows;
					$content['total_volume'][$ctr]= $total_volume;
					$content['total_north'][$ctr]= $total_north;
					$content['total_south'][$ctr]= $total_south;
					$content['sched_date'][$ctr]= $sched_date;

					$ctr ++;
				}

				//pump summary 7-8-2016 by ralph ceriaco
				//updated nov 10 2016

				//today schedules
				$pumps1_arr['plant3'] = $this->dps_model->get_clientcount_pump(1,$date_yesterday,'Plant 3');
				$pumps1_arr['plant4'] = $this->dps_model->get_clientcount_pump(1,$date_yesterday,'Plant 4');
				$content['pumps1'] = $this->load->view($pumps1_arr['plant3']['view'],$pumps1_arr,true);

				$pumps2_arr['plant3'] = $this->dps_model->get_clientcount_pump(2,$date_yesterday,'Plant 3');
				$pumps2_arr['plant4'] = $this->dps_model->get_clientcount_pump(2,$date_yesterday,'Plant 4');
				$content['pumps2'] = $this->load->view($pumps2_arr['plant3']['view'],$pumps2_arr,true);

				$pumps3_arr['plant3'] = $this->dps_model->get_clientcount_pump(3,$date_yesterday,'Plant 3');
				$pumps3_arr['plant4'] = $this->dps_model->get_clientcount_pump(3,$date_yesterday,'Plant 4');
				$content['pumps3'] = $this->load->view($pumps3_arr['plant3']['view'],$pumps3_arr,true);

				$pumps4_arr['plant3'] = $this->dps_model->get_clientcount_pump(4,$date_yesterday,'Plant 3');
				$pumps4_arr['plant4'] = $this->dps_model->get_clientcount_pump(4,$date_yesterday,'Plant 4');
				$content['pumps4'] = $this->load->view($pumps4_arr['plant3']['view'],$pumps4_arr,true);



				$pumps1_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(1,$date_yesterday2,'Plant 3');
				$pumps1_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(1,$date_yesterday2,'Plant 4');
				$content['pumps1_tom'] = $this->load->view($pumps1_tom_arr['plant3']['view'],$pumps1_tom_arr,true);

				$pumps2_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(2,$date_yesterday2,'Plant 3');
				$pumps2_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(2,$date_yesterday2,'Plant 4');
				$content['pumps2_tom'] = $this->load->view($pumps2_tom_arr['plant3']['view'],$pumps2_tom_arr,true);

				$pumps3_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(3,$date_yesterday2,'Plant 3');
				$pumps3_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(3,$date_yesterday2,'Plant 4');
				$content['pumps3_tom'] = $this->load->view($pumps3_tom_arr['plant3']['view'],$pumps3_tom_arr,true);

				$pumps4_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(4,$date_yesterday2,'Plant 3');
				$pumps4_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(4,$date_yesterday2,'Plant 4');
				$content['pumps4_tom'] = $this->load->view($pumps4_tom_arr['plant3']['view'],$pumps4_tom_arr,true);

				// ADDED BY WBSOLON - 2019-12-09
				$content['today_over_all_pump'] = $this->dps_model->GetTotalPump($date_yesterday);
				$content['tom_over_all_pump'] = $this->dps_model->GetTotalPump($date_yesterday2);


		        $content['chatname'] = $this->session->userdata('nick');
		        $this->body['view'] = 'dps/dps_yesterday';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Daily Pouring Schedule');
		    }else{
		    	redirect('welcome/denied');
		    }
		    header("Refresh: 100200; URL=dps ");
		    //$this->ajax_write_usersonline();
        }else{
            redirect('main/login_dps');
        }
	}


	function dpsNextDay()
	{
		//echo date('Y-m-d', strtotime('-9 days', strtotime(date("Y-m-d"))));
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl) || $this->functionlist->isSMDCoordinator($this->lvl)){
				$content['status']='';
				$content['action']='main/checklogin';
				//display the login page to the user
				$this->pagemaker->setSoftname('JLR Concrete Scheduling System');

				$date_nextday = date("Y-m-d",strtotime( '1 days' ));
				$date_nextnextday = date("Y-m-d",strtotime( '2 days' ));

	    		$content['dateTom'] = $this->nextpouringdate;				//next pouring date format is eg; 2012-12-30
	    		$content['dateTom2'] = $this->date_Tom[0];					//unix timestamp pass for conversion into format eg; December 30, 2012
	    		
				
		        //-----------------------------------------------------------------------
		        //	FOR MOBILE DATA HERE
		        //-----------------------------------------------------------------------
		        $mbooking_today_north = $this->dps_model->fetch_bookings_mobile($date_nextday,'Plant 3','fluid');
		        $mbooking_today_north_resched = $this->dps_model->get_mobile_resched($date_nextday,'Plant 3');
		        $content['m_today_north'] = $this->load->view($mbooking_today_north['view'], $mbooking_today_north,true);
		        	//volume,schedule and insert count here
		        	$content['mtodaynorth_vol'] = $mbooking_today_north['volume'];
		        	$content['mtodaynorth_okaycount'] = $mbooking_today_north['okaycount'];
		        	$content['mtodaynorth_insertcount'] = $mbooking_today_north['insertcount'];
		        	$content['mtodaynorth_reschedcount'] = $mbooking_today_north_resched['count'];
		        	$content['mtodaynorth_insertvolume'] = $this->dps_model->getVol($date_nextday,2,'Plant 3');
		        	$content['mtodaynorth_reschedvolume'] = $mbooking_today_north_resched['volume'];
		        $mbooking_today_northfix = $this->dps_model->fetch_bookings_mobile($date_nextday,'Plant 3','fix');
		        $content['m_today_northfix'] = $this->load->view($mbooking_today_northfix['view'], $mbooking_today_northfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$date_nextday,'Plant 3');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$date_nextday,'Plant 3');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$date_nextday,'Plant 3');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['today_north_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);


		        $mbooking_today_south = $this->dps_model->fetch_bookings_mobile($date_nextday,'Plant 4','fluid');
		        $mbooking_today_south_resched = $this->dps_model->get_mobile_resched($date_nextday,'Plant 4');
		        $content['m_today_south'] = $this->load->view($mbooking_today_south['view'], $mbooking_today_south,true);
		       
		        	//volume,schedule and insert count here
		        	$content['mtodaysouth_vol'] = $mbooking_today_south['volume'];
		        	$content['mtodaysouth_okaycount'] = $mbooking_today_south['okaycount'];
		        	$content['mtodaysouth_insertcount'] = $mbooking_today_south['insertcount'];
		        	$content['mtodaysouth_reschedcount'] = $mbooking_today_south_resched['count'];
		        	$content['mtodaysouth_insertvolume'] = $this->dps_model->getVol($date_nextday,2,'Plant 4');
		        	$content['mtodaysouth_reschedvolume'] = $mbooking_today_south_resched['volume'];

		        	//Total Volume
		        	$content['mtodaytotal_vol'] = $mbooking_today_north['volume'] + $mbooking_today_south['volume'];
		        $mbooking_today_southfix = $this->dps_model->fetch_bookings_mobile($date_nextday,'Plant 4','fix');
		        $content['m_today_southfix'] = $this->load->view($mbooking_today_southfix['view'], $mbooking_today_southfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$date_nextday,'Plant 4');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$date_nextday,'Plant 4');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$date_nextday,'Plant 4');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['today_south_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);




		        $mbooking_tom_north = $this->dps_model->fetch_bookings_mobile($date_nextnextday,'Plant 3','fluid');
		        $mbooking_tom_north_resched = $this->dps_model->get_mobile_resched($date_nextnextday,'Plant 3');
		        $content['m_tom_north'] = $this->load->view($mbooking_tom_north['view'], $mbooking_tom_north,true);
		        	//volume,schedule and insert count here
		        	$content['mtomnorth_vol'] = $mbooking_tom_north['volume'];
		        	$content['mtomnorth_okaycount'] = $mbooking_tom_north['okaycount'];
		        	$content['mtomnorth_insertcount'] = $mbooking_tom_north['insertcount'];
		        	$content['mtomnorth_reschedcount'] = $mbooking_tom_north_resched['count'];
		        	$content['mtomnorth_insertvolume'] = $this->dps_model->getVol($date_nextnextday,2,'Plant 3');
		        	$content['mtomnorth_reschedvolume'] = $mbooking_tom_north_resched['volume'];

		        $mbooking_tom_northfix = $this->dps_model->fetch_bookings_mobile($date_nextnextday,'Plant 3','fix');
		        $content['m_tom_northfix'] = $this->load->view($mbooking_tom_northfix['view'], $mbooking_tom_northfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$date_nextnextday,'Plant 3');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$date_nextnextday,'Plant 3');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$date_nextnextday,'Plant 3');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['tom_north_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);


		        $mbooking_tom_south = $this->dps_model->fetch_bookings_mobile($date_nextnextday,'Plant 4','fluid');
		        $mbooking_tom_south_resched = $this->dps_model->get_mobile_resched($date_nextnextday,'Plant 4');
		        $content['m_tom_south'] = $this->load->view($mbooking_tom_south['view'], $mbooking_tom_south,true);
		       		//volume,schedule and insert count here
		        	$content['mtomsouth_vol'] = $mbooking_tom_south['volume'];
		        	$content['mtomsouth_okaycount'] = $mbooking_tom_south['okaycount'];
		        	$content['mtomsouth_insertcount'] = $mbooking_tom_south['insertcount'];
		        	$content['mtomsouth_reschedcount'] = $mbooking_tom_south_resched['count'];
		        	$content['mtomsouth_insertvolume'] = $this->dps_model->getVol($date_nextnextday,2,'Plant 4');
		        	$content['mtomsouth_reschedvolume'] = $mbooking_tom_south_resched['volume'];

		        	//Total Volume
		        	$content['mtomtotal_vol'] = $mbooking_tom_north['volume'] + $mbooking_tom_south['volume'];
		        $mbooking_tom_southfix = $this->dps_model->fetch_bookings_mobile($date_nextnextday,'Plant 4','fix');
		        $content['m_tom_southfix'] = $this->load->view($mbooking_tom_southfix['view'], $mbooking_tom_southfix,true);

		        // added april 28, 2016
		        $clientcnt1 = $this->dps_model->get_clientcount(1,$date_nextnextday,'Plant 4');
				$aggsummary['clientcnt1'] = $this->load->view($clientcnt1['view'], $clientcnt1,true);

				$clientcnt2 = $this->dps_model->get_clientcount(2,$date_nextnextday,'Plant 4');
				$aggsummary['clientcnt2'] = $this->load->view($clientcnt2['view'], $clientcnt2,true);

				$clientcnt3 = $this->dps_model->get_clientcount(3,$date_nextnextday,'Plant 4');
				$aggsummary['clientcnt3'] = $this->load->view($clientcnt3['view'], $clientcnt3,true);

				$content['tom_south_aggsummary'] = $this->load->view('dps/reports/mobile_aggsummary', $aggsummary,true);

		        
		        // Weekly scheduling by Ralph
		        if($this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isDPSCoordinator($this->lvl)){
		        	$content['lock_class'] = '';
		        	$content['waiting_class'] = '';
		        }else{
		        	$content['lock_class'] = 'disable-waiting';
		        	$content['waiting_class'] = 'view-only';
		        }

		        if($this->functionlist->isDPSsmd($this->lvl)){
		        	$content['issmd_man'] = 'yes';
		        }else{
		        	$content['issmd_man'] = 'no';
		        }

		        $this->dtNow = date("Y-m-d");
				$this->dtYesterday = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1));
				$this->dtTommorow = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1));
				$this->dtTommorow2 = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+2));
				$this->dtTommorow3 = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+3));


				$ctr = 1;
				$date_arr = array($this->dtYesterday,$this->dtNow,$this->dtTommorow,$this->dtTommorow2,$this->dtTommorow3);
				foreach ($date_arr as $sched_date) {
					//iterate through dates

					//echo $sched_date . '<br />';
					if($this->dps_model->check_if_queued($sched_date)){
						//
						//update for status=waiting
						$this->dps_model->update_w_scheds_waiting($sched_date);
					}else{
						//generate listing
						//get sales codes
						$sales_reps = $this->dps_model->get_sales_rep();
						foreach ($sales_reps as $row) {
						    $sales_code = $row['code'];
						    $this->dps_model->get_w_sched($sched_date,$sales_code);
						}
						//update for status=waiting
						$this->dps_model->update_w_scheds_waiting($sched_date);
						//update the queue order
						$this->dps_model->order_queue_list($sched_date);
					}


					$content['scheds'.$ctr] = $this->dps_model->get_weekly_sched($sched_date);

					$total_rows = 0;
					$total_north_rows = 0;
					$total_south_rows = 0;
					$total_volume = 0;
					$total_north = 0;
					$total_south = 0;

					foreach ($content['scheds'.$ctr] as $row) {
						if ($row['batching_plant'] == 'Plant 3'){
							$total_north = $total_north + $row['batch_vol'];
							$total_north_rows ++;
						}elseif($row['batching_plant'] == 'Plant 4'){
							$total_south = $total_south + $row['batch_vol'];
							$total_south_rows ++;
						}
					}

					$total_volume = $total_north + $total_south;
					$total_rows = $total_north_rows + $total_south_rows;

					$content['total_rows'][$ctr]= $total_rows;
					$content['total_north_rows'][$ctr]= $total_north_rows;
					$content['total_south_rows'][$ctr]= $total_south_rows;
					$content['total_volume'][$ctr]= $total_volume;
					$content['total_north'][$ctr]= $total_north;
					$content['total_south'][$ctr]= $total_south;
					$content['sched_date'][$ctr]= $sched_date;

					$ctr ++;
				}

				//pump summary 7-8-2016 by ralph ceriaco
				//updated nov 10 2016

				//today schedules
				$pumps1_arr['plant3'] = $this->dps_model->get_clientcount_pump(1,$date_nextday,'Plant 3');
				$pumps1_arr['plant4'] = $this->dps_model->get_clientcount_pump(1,$date_nextday,'Plant 4');
				$content['pumps1'] = $this->load->view($pumps1_arr['plant3']['view'],$pumps1_arr,true);

				$pumps2_arr['plant3'] = $this->dps_model->get_clientcount_pump(2,$date_nextday,'Plant 3');
				$pumps2_arr['plant4'] = $this->dps_model->get_clientcount_pump(2,$date_nextday,'Plant 4');
				$content['pumps2'] = $this->load->view($pumps2_arr['plant3']['view'],$pumps2_arr,true);

				$pumps3_arr['plant3'] = $this->dps_model->get_clientcount_pump(3,$date_nextday,'Plant 3');
				$pumps3_arr['plant4'] = $this->dps_model->get_clientcount_pump(3,$date_nextday,'Plant 4');
				$content['pumps3'] = $this->load->view($pumps3_arr['plant3']['view'],$pumps3_arr,true);

				$pumps4_arr['plant3'] = $this->dps_model->get_clientcount_pump(4,$date_nextday,'Plant 3');
				$pumps4_arr['plant4'] = $this->dps_model->get_clientcount_pump(4,$date_nextday,'Plant 4');
				$content['pumps4'] = $this->load->view($pumps4_arr['plant3']['view'],$pumps4_arr,true);



				$pumps1_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(1,$date_nextnextday,'Plant 3');
				$pumps1_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(1,$date_nextnextday,'Plant 4');
				$content['pumps1_tom'] = $this->load->view($pumps1_tom_arr['plant3']['view'],$pumps1_tom_arr,true);

				$pumps2_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(2,$date_nextnextday,'Plant 3');
				$pumps2_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(2,$date_nextnextday,'Plant 4');
				$content['pumps2_tom'] = $this->load->view($pumps2_tom_arr['plant3']['view'],$pumps2_tom_arr,true);

				$pumps3_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(3,$date_nextnextday,'Plant 3');
				$pumps3_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(3,$date_nextnextday,'Plant 4');
				$content['pumps3_tom'] = $this->load->view($pumps3_tom_arr['plant3']['view'],$pumps3_tom_arr,true);

				$pumps4_tom_arr['plant3'] = $this->dps_model->get_clientcount_pump(4,$date_nextnextday,'Plant 3');
				$pumps4_tom_arr['plant4'] = $this->dps_model->get_clientcount_pump(4,$date_nextnextday,'Plant 4');
				$content['pumps4_tom'] = $this->load->view($pumps4_tom_arr['plant3']['view'],$pumps4_tom_arr,true);

				// ADDED BY WBSOLON - 2019-12-09
				$content['today_over_all_pump'] = $this->dps_model->GetTotalPump($date_nextday);
				$content['tom_over_all_pump'] = $this->dps_model->GetTotalPump($date_nextnextday);


		        $content['chatname'] = $this->session->userdata('nick');
		        $this->body['view'] = 'dps/dps_nextday';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Daily Pouring Schedule');
		    }else{
		    	redirect('welcome/denied');
		    }
		    header("Refresh: 100200; URL=dps ");
		    //$this->ajax_write_usersonline();
        }else{
            redirect('main/login_dps');
        }
	}






}
