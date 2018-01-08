<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PROJECT
 *
 * PACKAGE DESCRIPTION
 *
 * @package         PROJECT
 * @author          <AUTHOR_NAME>
 * @copyright       Copyright (c) 2016
 */

// ---------------------------------------------------------------------------

/**
 * Admin_Controller
 *
 * Extends the MY_Controller class
 * 
 */

class Admin_Controller extends MY_Controller 
{

	var $_container;
	var $_user_id;
	/**
	 * Load and set data for some common used libraries.
	 */
	public function __construct()
	{
		parent::__construct();
		//load aauth_helper
		// if ajax request & not user is logged in 
		// then redirect to login page
		if ( $this->input->is_ajax_request() && !is_loggedin()) {
			$this->output->set_status_header('999', 'ERROR');
			exit;
		}
		// Set container variable
		$this->_container = $this->config->item('template_admin') . "container.php";

		//function of aauth library
		control('Control Panel');

		$this->_user_id = $this->session->userdata('id');
	}
}