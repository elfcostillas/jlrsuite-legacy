<?php defined('BASEPATH') OR exit('No direct script access allowed.');
	
	function peso($val)
	{
		return '&#8369; '.number_format((float)$val,'2','.',',').' ';
	}

	function cubic($val)
	{
		return round($val).'m³ ';
	}

	function hours($val)
	{
		return $val.'/hr';
	}

	function pcs($val)
	{
		return round($val).' pcs ';
	}
?>