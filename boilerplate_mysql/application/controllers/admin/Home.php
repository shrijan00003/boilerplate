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
 * Home
 *
 * Extends the MX_Controller class
 * 
 */
class Home extends Admin_Controller {

	public function index()
	{
		// Display Page
		$data['header'] = lang('menu_home');
		$data['page'] = $this->config->item('template_admin') . "home";
		$this->load->view($this->_container, $data);
	}
}
