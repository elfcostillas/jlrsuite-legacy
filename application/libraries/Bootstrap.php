<?php defined('BASEPATH') OR exit('No direct script access allowed.');

	/**
	* Added By: Rodren S. Gil
	* Added Date: 2017-07-05
	* Purpose: Pre-compiled code for Bootstrap Layout 
	*/
	class Bootstrap
	{
		var $bs_input_class = 'form-control';

		function textbox($name,$id,$value,$size='normal',$class='',$maxlength='100',$style='')
		{
			return array(
				'name' 		=> $name,
				'id' 		=> $id,
				'value' 	=> $value,
				'maxlength' => $maxlength,
				'class' 	=> $this->construct_class($class,$size)
			);
		}

		function construct_class($class,$size)
		{
			$additional_class = ' '.$class;
		
			if($size === 'small')
			{
				$additional_class .= ' input_sm';
			}

			return $this->bs_input_class.$additional_class;

		}
	}
 ?>