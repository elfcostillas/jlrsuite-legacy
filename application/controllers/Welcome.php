<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	var $lvl;

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->lvl = $this->session->userlvl;
    }

	function index()
	{
		if($this->session->userdata('is_logged_in')){
			$data['status'] = '';
			$data['level'] = $this->lvl;
		 	$this->body['view'] = 'mainmenu';
		   	$this->body['content'] = $data;
		    $this->pagemaker->welcomePage($this->body,'JLRegner | Main Page');
	    }else{
            redirect('main/login_main');
        }
	}

	function denied()
    {
    	$data['level'] = $this->lvl;
    	$data['status'] = '';
    	$this->load->view('templates/denied', $data);
    }
}
