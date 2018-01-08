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
 * Admin
 *
 * Extends the Public_Controller class
 * 
 */

class Home extends Public_Controller
{
	public function __construct(){
		parent::__construct();

        $this->lang->load('home/home');

	}

	public function index()
	{
		// Display Page
		$data['header'] = lang('home');
		$data['page'] = $this->config->item('template_public') . "index";
		$data['module'] = 'home';
		$this->load->view($this->_container,$data);
	}
}