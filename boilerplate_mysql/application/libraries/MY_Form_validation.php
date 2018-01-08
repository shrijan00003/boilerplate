<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* PROJECT
*
* @package         PROJECT
* @author          <AUTHOR_NAME>
* @copyright       Copyright (c) 2016
*/

// ---------------------------------------------------------------------------

/**
* MY_Form_validation
*
* Extends the CI_Form_validation class
* 
*/
class MY_Form_validation extends CI_Form_validation
{
	function run($module = '', $group = '') {
		(is_object($module)) AND $this->CI =& $module;
		return parent::run($group);
	}	
}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */
