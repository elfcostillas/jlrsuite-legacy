<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Leaveclass {

    public function convert_name($fname,$mname,$lname)
    {
    	$fname = ucfirst(strtolower($fname));
    	$mname = ucfirst(strtolower($mname));
    	$lname = ucfirst(strtolower($lname));
    	return $fname . " " . $mname . " " . $lname;

    }

    public function convert_Big_Ntilde($string)
    {
    	return str_replace('Ñ','&Ntilde',$string);

    }

    function days_in_month($month, $year) 
    { 
    // calculate number of days in a month 
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
    }
}

/* End of file Leaveclass.php */