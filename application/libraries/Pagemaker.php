<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	/*
		Class for building site pages
			The default views are in the Templates Folder
			Build page specific views as needed
	*/

date_default_timezone_set('Asia/Manila');

class PageMaker {
	
	var $CI;
	var $deftitle =    'JLR Construction and Aggregates Inc.';
	var $defkeyword =  'Construction and General Contractor';
	var $defdescrip =  'JLR Construction and Aggregates Inc.';	
	var $defscripts;
	var $softname =    'JLR Software Suite';
	var $title; // added by ralph
	var $todaydate;
	var $todaydaten;
	var $headerdata;
	var $defcss;
	var $specdata;
	var $navdata;
	var $headerview;
	
	
	/*
		define your base page here
		change appropriate headers for different companies
	*/
	
	function basePage($content, $pagename){
		$CI =& get_instance();
		$this->groupheader();			
		
		$bannerdata['softname'] = $this->softname;
		$bannerdata['pagename'] = $pagename;
		$bannerdata['curdate'] = $this->todaydate;



		switch ($bannerdata['softname']) {
			case 'JLR Software Suite':
				//set the css and javascript here
				$this->headerview = 'header_login';
				$bannerdata['requestingpage'] = 'login_page';
				break;
			case 'Leave Monitoring':
				//set the css and javascript here
				$this->headerview = 'header_leave';
				$nav = 'leave-nav';
				$navdata['activepage'] = $bannerdata['pagename'];
				$bannerdata['requestingpage'] = 'leaves';
				break;

			case 'Leave Monitoring V2.0':
				//set the css and javascript here
				$this->headerview = 'header_leavev2';
				$nav = 'leave-nav2';
				$navdata['activepage'] = $bannerdata['pagename'];
				$navdata['softname'] = 'leavesv2';
				$bannerdata['requestingpage'] = 'leavesv2';
				break;

			case 'JLR Concrete Scheduling System':
				$this->headerview = 'header_dps';
				$nav = 'dps-nav';
				$navdata['activepage'] = $bannerdata['pagename'];
				$bannerdata['requestingpage'] = 'dps';
				break;

			case 'Daily Equipment Update':
				$this->headerview = 'header_deu';
				$nav = 'deu-nav';
				$navdata['activepage'] = $bannerdata['pagename'];
				$bannerdata['requestingpage'] = 'deu';
				break;

			case 'Administration Panel':
				$this->headerview = 'header_admin';
				$nav = 'admin-nav';
				$navdata['activepage'] = $bannerdata['pagename'];
				$bannerdata['requestingpage'] = 'admin';
				break;

			case 'DR Monitoring System':
				$this->headerview = 'header_dps';
				$nav = 'drmon-nav';
				$navdata['activepage'] = $bannerdata['pagename'];
				$bannerdata['requestingpage'] = 'dps';
				break;

			case 'Warehouse Inventory':
				$this->headerview = 'header_warehouse';
				$nav = 'warehouse-nav';
				$navdata['activepage'] = $bannerdata['pagename'];
				$navdata['softname'] = 'warehouse';
				$bannerdata['requestingpage'] = 'warehouse';
				break;
				
			case 'Client Contracts':
				$this->headerview = 'header_contract';
				$nav = 'contract-nav';
				$navdata['activepage'] = $bannerdata['pagename'];
				$navdata['softname'] = 'warehouse';
				$bannerdata['requestingpage'] = 'Client Contract';
				break;
			
			default:
				//default navigation must be provided
				break;
		}

		if($pagename != 'Login'){
			$data['loginpage'] = false;
		}else{
			$data['loginpage'] = true;
		}
		
	
		$bodyview = $content['view'];
		$bodycontent = $content['content'];
		
		//echo '<pre>'. var_dump($bodycontent) .'</pre>';
		
		//pass the data to the header[view]
		$data['header'] = $CI->load->view('templates/'.$this->headerview,$this->headerdata,true);

		
		//---------------edit by ralph for the new banner with bt3
		//------- april 27, 2016 added the warehouse
		if ($bannerdata['requestingpage'] == 'leavesv2' || $bannerdata['requestingpage'] == 'warehouse'){
			//pass the data to the banner[view]
			$data['banner'] = $CI->load->view('templates/banner_view2',$bannerdata,true);
		}else{
			//old banner
			//pass the data to the banner[view]
			$data['banner'] = $CI->load->view('templates/banner_view',$bannerdata,true);
		}


		// conditional for the main login page redirection if login details are false
		if ($bannerdata['softname'] != 'JLR Software Suite') {
		//pass the data to the navigation[view]
		$data['main_navigation'] = $CI->load->view('templates/'. $nav,$navdata,true);
		}
		

		//pass the data to the content[view]
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);

		if ($bannerdata['requestingpage'] == 'leavesv2'){
			//pass the data to the footer[view]
			$data['footer'] = $CI->load->view('templates/footer_view2','',true);
		}elseif($bannerdata['requestingpage'] == 'warehouse'){
			$data['footer'] = $CI->load->view('templates/footer_warehouse_view','',true);
		}else{
			//pass the data to the footer[view]
			$data['footer'] = $CI->load->view('templates/footer_view','',true);
		}
		
		//pass the all the data to the main[view] which combines the 3 views into 1 main view
		$page = $CI->load->view('templates/main_view',$data,true);
			
		//ouput the main[view] using the CI core classes	
		$CI->output->set_output($page);
	}

	
	function appbasePage($content, $pagename){
		$CI =& get_instance();
		$this->groupheader();
			
		$bannerdata['softname'] = $this->softname;
		$bannerdata['pagename'] = $pagename;
		$bannerdata['curdate'] = $this->todaydate;
		
		$bodyview = $content['view'];
		$bodycontent = $content['content'];
		
		$data['header'] = $CI->load->view('Templates/header_view',$this->headerdata,true);
		$data['menu'] = $CI->load->view('Templates/menu_view','',true);
		$data['banner'] = $CI->load->view('Templates/banner_view',$bannerdata,true);
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);
		$data['footer'] = $CI->load->view('Templates/footer_view','',true);
		$page = $CI->load->view('Templates/app_main_view',$data,true);
		
		$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$CI->output->set_header("Pragma: no-cache"); 		
		$CI->output->set_output($page);
	}

	function welcomePage($content, $pagename){
		$CI =& get_instance();
		$this->groupheader();
			
		$bannerdata['softname'] = $this->softname;
		$bannerdata['pagename'] = $pagename;
		$bannerdata['curdate'] = $this->todaydate;
		
		$bodyview = $content['view'];
		$bodycontent = $content['content'];
		
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);
		$page = $CI->load->view('templates/welcome_view',$data,true);
			
		$CI->output->set_output($page);
	}

	function ajaxPage($content,$headerchoice){
		$CI =& get_instance();

		$bodyview = $content['view'];
		$bodycontent = $content['content'];
		
		switch ($headerchoice) {
			case 'yes':
				//pass the data to the header[view]
				$data['header'] = $CI->load->view('templates/ajax-header',$this->headerdata,true);
				$data['headerchoice'] = 'yes';
				break;
			case 'no':
				$data['headerchoice'] = 'no';
				break;
		}
		

		//pass the data to the content[view]
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);

		//pass the all the data to the main[view] which combines the 3 views into 1 main view
		$page = $CI->load->view('templates/ajax_view',$data,true);
			
		//ouput the main[view] using the CI core classes	
		$CI->output->set_output($page);
	}

	function printPage($content){
		$CI =& get_instance();

		$bodyview = $content['view'];
		$bodycontent = $content['content'];

		$data['header'] = $CI->load->view('templates/print-header','',true);
		//pass the data to the content[view]
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);

		//pass the all the data to the main[view] which combines the 3 views into 1 main view
		$page = $CI->load->view('templates/print_view',$data,true);
			
		//ouput the main[view] using the CI core classes	
		$CI->output->set_output($page);
	}
	
	function appbaserefPage($content, $pagename, $refreshrate){
		$CI =& get_instance();
		$this->groupheader();
		$this->headerdata['refrate'] = $refreshrate;
			
		$bannerdata['softname'] = $this->softname;
		$bannerdata['pagename'] = $pagename;
		$bannerdata['curdate'] = $this->todaydate;
		
		$bodyview = $content['view'];
		$bodycontent = $content['content'];
		
		$data['header'] = $CI->load->view('Templates/headerref_view',$this->headerdata,true);
		$data['menu'] = $CI->load->view('Templates/menu_view','',true);
		$data['banner'] = $CI->load->view('Templates/banner_view',$bannerdata,true);
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);
		$data['footer'] = $CI->load->view('Templates/footer_view','',true);
		$page = $CI->load->view('Templates/app_main_view',$data,true);
		
		$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$CI->output->set_header("Pragma: no-cache"); 		
		$CI->output->set_output($page);
	}
	
	function custPage($custcss, $bodydata, $pagename){
		$CI =& get_instance();
			if(empty($custcss)){ $this->groupheader();}
			else {$this->custcss($custcss);}
		$bannerdata['softname'] = $this->softname;
		$bannerdata['pagename'] = $pagename;
		$bannerdata['curdate'] = $this->todaydate;
		
		$bodyview = $bodydata['view'];
		$bodycontent = $bodydata['content'];
		
		$data['header'] = $CI->load->view('header_view',$custheader,true);
		$data['banner'] = $CI->load->view('banner_view',$bannerdata,true);
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);
		$data['footer'] = $CI->load->view('footer_view','',true);
		$page = $CI->load->view('main_view',$data,true);
		
		$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$CI->output->set_header("Pragma: no-cache"); 	
		$CI->output->set_output($page);
	}

	function noBannerpage($content, $pagename){
		$CI =& get_instance();
		$this->groupheader();

		$bodyview = $content['view'];
		$bodycontent = $content['content'];
		
		$data['header'] = $CI->load->view('templates/header_view',$this->headerdata,true);
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);
		//$data['footer'] = $CI->load->view('templates/footer_view','',true);
		$page = $CI->load->view('templates/main_view_nobanner',$data,true);
		 	
		$CI->output->set_output($page);
	}
	
	function defHeader($bodydata, $pagename){
		$CI =& get_instance();
		$this->groupheader();
		
		$bannerdata['softname'] = $this->softname;
		$bannerdata['pagename'] = $pagename;
		$bannerdata['curdate'] = $this->todaydate;			
		$bodyview = $bodydata['view'];
		$bodycontent = $bodydata['content'];				
		
		$data['header'] = $CI->load->view('Templates/header_view',$this->headerdata,true);
		$data['banner'] = $CI->load->view('Templates/banner_view',$bannerdata,true);
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);
		$data['footer'] = $CI->load->view('main_footer_view','',true);
		$page = $CI->load->view('main_view',$data,true);
		
		$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$CI->output->set_header("Pragma: no-cache"); 	
		$CI->output->set_output($page);
	}
	
	function imagePage($bodydata){
		$CI =& get_instance();
			$this->groupheader();
			
			$bodyview = $bodydata['view'];
			$bodycontent = $bodydata['content'];				
			
			$data['header'] = $CI->load->view('Templates/header_view',$this->headerdata,true);
			$data['banner'] = '';
			$data['content'] = $CI->load->view($bodyview,$bodycontent,true);
			$data['footer'] = '';
			$page = $CI->load->view('main_view',$data,true);
			
			$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$CI->output->set_header("Pragma: no-cache"); 	
			$CI->output->set_output($page);
	}
	
	function printShort($bodydata){
		$CI =& get_instance();
		$this->printheader("short");
		$bodyview = $bodydata['view'];
		$bodycontent = $bodydata['content'];
		
		$data['header'] = $CI->load->view('templates/print_header_view',$this->headerdata,true);
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);
		$page = $CI->load->view('templates/print_view',$data,true);
		
		$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$CI->output->set_header("Pragma: no-cache"); 	
		$CI->output->set_output($page);
	}
	
	function printLong($bodydata){
		$CI =& get_instance();
		$this->printheader("long");
		$bodyview = $bodydata['view'];
		$bodycontent = $bodydata['content'];
		
		$data['header'] = $CI->load->view('templates/print_header_view',$this->headerdata,true);
		$data['content'] = $CI->load->view($bodyview,$bodycontent,true);
		$page = $CI->load->view('templates/print_view',$data,true);
		
		$CI->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$CI->output->set_header("Pragma: no-cache"); 	
		$CI->output->set_output($page);
	}
	
	function activeFooter($pagename, $bodydata, $footerdata){
		
	}
	
	private function groupheader(){
		//css and scripts are in the header[view]
		$this->todaydate = date("F d, Y");
		$this->todaydaten = date("Y-m-d");		
		//$this->headerdata['css'] = $this->defcss;
		$this->headerdata['title'] = $this->deftitle;
		$this->headerdata['scripts'] = $this->defscripts;
		$this->headerdata['keywords'] = $this->defkeyword;
		$this->headerdata['description'] = $this->defdescrip;

		
	}
	
	private function printheader($size){
		
		#set default stylesheet here
		$this->defcss = '<link rel="stylesheet" type="text/css" href="'.base_url().'printstyle'.$size.'.css" media="screen, print" />';
		$this->todaydate = date("F d, Y");
		$this->todaydaten = date("Y-m-d");		
		$this->headerdata['css'] = $this->defcss;
		$this->headerdata['title'] = $this->deftitle;
		$this->headerdata['scripts'] = '';
		$this->headerdata['keywords'] = $this->defkeyword;
		$this->headerdata['description'] = $this->defdescrip;
	}
	
	private function custcss($css){
		$this->todaydate = date("F d, Y");
		$this->headerdata['css'] = $custheader['css'];
		$this->headerdata['title'] = $this->deftitle;
		$this->headerdata['scripts'] = $this->defscripts;
		$this->headerdata['keywords'] = $this->defkeyword;
		$this->headerdata['description'] = $this->defdescrip;
	}
	
	
	function setSoftname($software){
		$this->softname = $software;
	}
	
	function addSpecdata($key, $data){
		$this->specdata[$key] = $data;
	}
	
	function getSpecdata($key){
		return $this->specdata[$key];
	}
	
	function setSytlesheet($sytlesheet){
		$this->softname = $stylesheet;
	}

	
	
}

?>