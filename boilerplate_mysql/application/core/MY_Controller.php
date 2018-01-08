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
 * MY_Controller
 *
 * Extends the MX_Controller class
 * 
 */

/* load the MX_Router class */
require APPPATH."libraries/MX/Controller.php";

class MY_Controller extends MX_Controller 
{
	/**
	 * Load and set data for some common used libraries.
	 */
	public function __construct()
	{
		//Load Base Controller Files
		$this->load->config('project');
		$this->load->helper(array('project', 'auth/aauth'));
		$this->load->library(array('auth/Aauth', 'status/Status', 'Project'));
		$this->lang->load(array('project', 'menu'));

		// EMAIL CONFIG
		$email_config = $this->config->item('mail');
		$this->email->initialize($email_config);
	}
}

include_once("Admin_Controller.php");
include_once("Public_Controller.php");
//include_once("REST_Controller.php");
//include_once('Report_Controller.php');
