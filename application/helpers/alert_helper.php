<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function  alert($message,$message_type)
{
	$alert = '';
	$type = '';
	if ($message ==='') {
		return;
	}
	switch ($message_type) {
		case 'success':
			$type = 'alert-success';
			break;
		case 'info':
			$type = 'alert-info';
			break;
		case 'warning':
			$type = 'alert-warning';
			break;
		case 'danger':
			$type = 'alert-danger';
			break;
		default:
			'alert-danger';
			break;
	}
	return "<div class='alert ".$type."' >
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			<strong>".$message."</strong>
			</div>";
}

?>
