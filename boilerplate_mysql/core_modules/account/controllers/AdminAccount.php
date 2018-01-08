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
 * Extends the MX_Controller class
 * 
 */
class AdminAccount extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}	

	public function index()
	{
		// Display Page
		$data['header'] = lang('home');
		$data['page'] = $this->config->item('template_admin') . "home";
		$this->load->view($this->_container, $data);
	}

	public function change_password()
	{
		$max_length = $this->config->item('max', 'aauth');
		$min_length = $this->config->item('min', 'aauth');

		$this->form_validation->set_rules('password', 'Old Password', 'required|min_length['.$min_length.']|max_length['.$max_length.']|callback_password_check');
		$this->form_validation->set_rules('new_password', 'New Confirmation', 'required|min_length['.$min_length.']|max_length['.$max_length.']');
		$this->form_validation->set_rules('conf_password', 'Password Confirmation', 'required|min_length['.$min_length.']|max_length['.$max_length.']|matches[new_password]');

		if ($this->form_validation->run($this) == FALSE)
		{
			$user_id=$this->session->userdata('id');

			$data['header'] = "Change Password";
			$data['page'] = $this->config->item('template_admin') .  'change_password';
			$data['module'] = 'account';

			flashMsg('warning', validation_errors());

			$this->load->view($this->_container,$data);
		}
		else
		{
			$user_id=$this->session->userdata('id');
			$pass=$this->input->post('new_password');
			
			if ( !$this->aauth->update_user($user_id, FALSE, $pass, FALSE)){
				flashMsg('error', 'Something went wrong. Please try again');
			} 

			// Email the new password to the user
			$row = $this->aauth->get_user($user_id);

			if ( !is_object($row)){
				flashMsg('error', 'Something went wrong. Please try again');
			} 

			$data['site_name'] = $this->config->item('site_name');
			$data['username'] = $row->username;
			$data['password'] = $pass;
			$data['email'] = $row->email;
			$data['year'] = date('Y');
			$message_body = $this->parser->parse('account/email_templates/change_password', $data, TRUE);

			$this->email->from( $this->config->item('email','aauth'), $this->config->item('name','aauth'));
			$this->email->to($row->email);
			$this->email->subject('Password Changed');
			$this->email->message($message_body);
			$this->email->send();

			$this->aauth->logout();
			flashMsg('success','You have successfully changed your password. Please login again.');
			redirect('/login');
			//redirect(site_url('home'));
		}
	}

	function password_check($str)
	{
		$user_id=$this->session->userdata('id');
		if (!$this->aauth->check_old_password($user_id, $str))
		{
			$this->form_validation->set_message('password_check', 'Password did not matches with our database');
			return FALSE;
		}
		return TRUE;
	}
}
