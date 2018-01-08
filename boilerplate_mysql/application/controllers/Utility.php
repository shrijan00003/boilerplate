<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends MY_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function delete_user($user_id) 
	{

	 	$this->load->library('auth/Aauth');

        echo "Result: Delete User<BR>";
    
        var_dump($this->aauth->delete_user($user_id));
	}
}
