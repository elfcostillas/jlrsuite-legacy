<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//for client contracts module
$route['contract-add'] 		= 'contracts/contract_add';
$route['contract-insert'] 	= 'contracts/contract_insert';
$route['contract-edit'] 	= 'contracts/contract_edit';
$route['contract-update'] 	= 'contracts/contract_update';
$route['contract-view'] 	= 'contracts/contract_view';
$route['contract-approve'] 	= 'contracts/contract_approve';
$route['contract-delete'] 	= 'contracts/contract_delete';
$route['contract-print'] 	= 'contracts/contract_print';
$route['contract-rev'] 		= 'contracts/contract_revision';


// ajax
$route['ajax-clientdetails'] 			= 'contracts/ajax_client_details';
$route['ajax-salescontact'] 			= 'contracts/ajax_sales_details';
$route['ajax-cntrdetails'] 				= 'contracts/ajax_contract_details';
$route['ajax-contractlist'] 			= 'contracts/ajax_contract_list';
$route['ajax-user-rights'] 				= 'contracts/ajax_user_rights';
$route['ajax-pumps'] 					= 'contracts/ajax_pump_charges';
$route['ajax-charges'] 					= 'contracts/ajax_charges';
$route['ajax-assign-in-pump'] 			= 'contracts/ajax_assign_in_pump';
$route['ajax-pump-charges'] 			= 'contracts/ajax_load_pump_charges';
$route['ajax-unassign-pump-charges'] 	= 'contracts/ajax_unassigned_pump_charges';
$route['ajax-set-pump-charges'] 		= 'contracts/ajax_set_pump_charges';



