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
 * Public_Controller
 *
 * Extends the MX_Controller class
 * 
 */

class Public_Controller extends MY_Controller 
{
	/**
	 * Load and set data for some common used libraries.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->_container = $this->config->item('template_public') . "container.php";
	}
}