<?php  defined('BASEPATH') OR exit('No direct script access allowed.');
	
	if (!function_exists('rankNum')) 
	{

		function rankNum($num)
		{
			switch (substr($num,-1)) 
			{
				case 1: 
					return $num.(tenth($num)?'<sup>st</sup>':'<sup>th</sup>');	
					break;

				case 2: 
					return $num.(tenth($num)?'<sup>nd</sup>':'<sup>th</sup>');	
					break;

				case 3: 
					return $num.(tenth($num)?'<sup>rd</sup>':'<sup>th</sup>');	
					break;

				default:
					return $num.'<sup>th</sup>';
					break;
			}
		}

		function tenth($num)
		{
			
			if (strlen($num)>1) 
			{
				return (int)substr($num, -2,1) != 1;
			}
			else
			{
				return true;
			}
		}
	}

 ?>