<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DRMON extends CI_Controller {

	
	var $lvl;
	var $initial;
	


	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->lvl = $this->session->userdata('userlvl');
       
    }

	function index()
	{
		
		if($this->session->userdata('is_logged_in')){
			if($this->functionlist->isDPS($this->lvl) OR $this->functionlist->isAdmin($this->lvl)){
				$content['status']='';
				$content['action']='main/checklogin';
				//display the login page to the user
				$this->pagemaker->setSoftname('DR Monitoring System');

                
		        $this->body['view'] = 'drmon/index';
		        $this->body['content'] = $content;
		        $this->pagemaker->basePage($this->body,'Delivery Receipt');
		    }else{
		    	redirect('welcome/denied');
		    }
		    
        }else{
            redirect('main');
        }
	}



}