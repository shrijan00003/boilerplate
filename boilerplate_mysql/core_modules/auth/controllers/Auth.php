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
 * Auth
 *
 * Extends the Public_Controller class
 * 
 */

class Auth extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		// First lets see if they are logged in, if so run action for that user
		if ( is_loggedin() )
		{

			// If they have access to the control panel panel send them there
			if( is_allowed('Control Panel'))
			{
				log_message('debug','Auth Controller: Access to Control Panel. Redirecting Admin Home');
				redirect($this->config->item('admin_login_action'),'location');
			}
			// Otherwise run user action
			log_message('debug','Auth Controller: No Access to Control Panel. Redirecting Public Home');
			redirect($this->config->item('default_login_action'),'location');
		}
		
		// $rules = array();
		// $rules['email']  = 'trim|required';
		// $rules['pass'] = 'trim|required';

		// $this->form_validation->set_rules($rules);

		$this->form_validation->set_rules('email', 'Email', 'required|trim');
		$this->form_validation->set_rules('pass', 'Password', 'required|trim');

		if ( $this->form_validation->run() === FALSE )
		{
			$e = $this->form_validation->error_array();
			if (count($e) > 0) {
				flashMsg('error',implode("<br  />", $e));
			}

			if($this->session->flashdata('requested_page') != "")
			{
				// Only remember the flashData if there was some in the first place
				$this->session->keep_flashdata('requested_page');
			}

			// Display page
			$data['view_page'] =  'auth/form_login';
			$data['module'] = 'auth';
			//$container = '';
			$page = 'auth/auth/form_login';
			$this->load->view($page,$data);

			
		} else {
			
			// Fetch what they entered in the login
			$email = $this->input->post('email');
			$pass  = $this->input->post('pass');

			// See if a user exists with the given credentials
			$result = $this->aauth->login($email, $pass);
			// print_r($this->aauth->print_errors());exit;
			if ( $result )
			{

				if(NULL !== ($page = $this->session->flashdata('requested_page')))
				{
					redirect($page,'location');
				}

				if( control('Control Panel'))
				{ 
					log_message('debug','Auth Controller: Access to Control Panel. Redirecting Admin Home');
					redirect($this->config->item('admin_login_action'),'location');
				}
				// Otherwise run user action
				log_message('debug','Auth Controller: No Access to Control Panel. Redirecting Public Home');
				show_404();
			}

			redirect('login','location');
		}
	}

	public function logout()
	{
		$this->aauth->logout();
		redirect($this->config->item('default_logout_action'),'location');
	}

	public function forgot_password()
	{
		$rules = array();

		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

		if ( $this->form_validation->run() === FALSE )
		{

			$e = $this->form_validation->error_array();
			if (count($e) > 0) {
				flashMsg('error',implode("<br  />", $e));
			}

			// Display page
			$data['view_page'] =  'auth/form_forgot_password';
			$data['module'] = 'auth';
			//$container = '';
			$page = 'auth/auth/form_forgot_password';
			$this->load->view($page,$data);

			
		} else {
			
			// Fetch what they entered in the login
			$email = $this->input->post('email');
			if ($this->aauth->user_exist_by_email($email)) {
				if($this->aauth->remind_password($email)) {
					flashMsg('info', 'Password Reset Instruction is sent in your email. Please check the mail');		
				}
			} else {
				flashMsg('error', 'The email address does not exists in our database');		
				redirect('forgot_password','location');
			}
			

			redirect('login','location');
		}
	}

	public function activate($user_id, $ver_code)
	{

		if ($this->aauth->verify_user($user_id, $ver_code)) {
			flashMsg('success', 'Please login with your username and password.');
		} else {
			flashMsg('error', 'Invalid Actiation Code.');
		}

		redirect($this->config->item('default_logout_action'),'location');
	}

	public function reset_password($user_id, $ver_code)
	{

		if ($this->aauth->reset_password($user_id, $ver_code)) {
			flashMsg('success', 'Please check your email for new password.');
		} else {
			flashMsg('error', 'Invalid Password Reset Code.');
		}

		redirect($this->config->item('default_logout_action'),'location');
	}
}
/* End of file auth.php */
/* Location: ./core_modules/Auth/controllers/auth.php */