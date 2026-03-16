<?php
/**
 * CodeIgniter DB Helpers
 * 
 * @package CodeIgniter
 * @category Helpers
 * @author Rodren S. Gil (grodren@gmail.com)
 * @version 1.0
 */

if (!function_exists('rec_exist')) 
{
	// check if record exist in database
	function rec_exist($tbl,$find)
	{
		$CI =& get_instance();
		$CI->db->where($find);
		$query = $CI->db->get($tbl);

		return $query->num_rows > 0;
	}
}



/* End of file db_helper.php */
/* Location: ./application/helpers/db_helper.php */