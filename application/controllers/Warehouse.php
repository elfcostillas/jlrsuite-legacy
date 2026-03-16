<?php
class Warehouse extends CI_Controller {

    var $current_year;
    var $email_recipient;

	 public function __construct()
	 {
		   parent::__construct();
           $this->load->library('email');
           $this->current_year = date("Y");
           $this->dateNow = date("Y-m-d H:m:s");

           //get the id of the employee who is currently logged
           $this->emp_id = $this->session->userdata('employee_id');
           $this->lvl = $this->session->userdata('userlvl');
           $this->firstname = $this->session->userdata('first_name');
           $this->lastname = $this->session->userdata('last_name');

           $this->email_recipient = 'ceriacoralph@gmail.com';
	 }

	function index()
    {

        //check if logged in
        if($this->session->userdata('is_logged_in')){

            if($this->functionlist->isLeaveSup($this->emp_id) OR $this->functionlist->isLeaveMngr($this->emp_id) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isLeaveViewer($this->lvl)){
                $data['status'] = "test";

                $this->pagemaker->setSoftname('Warehouse Inventory');


                //$data['onleaves'] = $this->leaves_model2->get_on_leaves();

                $this->body['view'] = 'warehouse/index';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Home');
                
            }     
            else{ redirect('welcome/denied'); }

        }
        else{ redirect('main/login_warehouse'); }
	}

    function approved_withdrawals()
    {

        //check if logged in
        if($this->session->userdata('is_logged_in')){

            if($this->functionlist->isLeaveSup($this->emp_id) OR $this->functionlist->isLeaveMngr($this->emp_id) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isLeaveViewer($this->lvl)){
                $data['status'] = "test";

                $this->pagemaker->setSoftname('Warehouse Inventory');


                //$data['onleaves'] = $this->leaves_model2->get_on_leaves();

                $this->body['view'] = 'warehouse/index';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Home');
                
            }     
            else{ redirect('welcome/denied'); }

        }
        else{ redirect('main/login_warehouse'); }
    }

    function pending_withdrawals()
    {

        //check if logged in
        if($this->session->userdata('is_logged_in')){

            if($this->functionlist->isLeaveSup($this->emp_id) OR $this->functionlist->isLeaveMngr($this->emp_id) OR $this->functionlist->isAdmin($this->lvl) OR $this->functionlist->isLeaveViewer($this->lvl)){
                $data['status'] = "test";

                $this->pagemaker->setSoftname('Warehouse Inventory');

               // $this->output->enable_profiler(TRUE);


                $data['pending_list'] = $this->warehouse_model->get_pending_requests();

                $this->body['view'] = 'warehouse/pending_requests';
                $this->body['content'] = $data;
                $this->pagemaker->basePage($this->body,'Home');
                
            }     
            else{ redirect('welcome/denied'); }

        }
        else{ redirect('main/login_warehouse'); }
    }




    /*
    some ajax

     */

    function ajax_approved_withdrawal_request(){
        $ws_code = $this->input->post('ws_code');
        $approver = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');

        $res = $this->warehouse_model->ajax_approved_withdrawal_request($ws_code,$approver);        
    }

    function ajax_get_ws_items(){
        $ws_code = $this->input->post('ws_code');

        echo $this->warehouse_model->ajax_get_ws_items($ws_code); 
    }



} 
