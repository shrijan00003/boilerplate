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


if( ! function_exists('control'))
{
	function control($permission,$redirect=TRUE)
	{
		$CI = & get_instance();
		return $CI->aauth->control($permission,$redirect);
	}
}

if( ! function_exists('is_allowed'))
{
	function is_allowed($permission)
	{
		$CI = & get_instance();
		return $CI->aauth->is_allowed($permission);
	}
}


if( ! function_exists('is_loggedin'))
{
	function is_loggedin()
	{
		$CI = & get_instance();
		return $CI->aauth->is_loggedin();
	}
}

if( ! function_exists('is_admin'))
{
	function is_admin()
	{
		$CI = & get_instance();
		return $CI->aauth->is_admin();
	}
}

if( ! function_exists('generate_recaptcha_field'))
{
	function generate_recaptcha_field()
	{
		$CI = & get_instance();
		return $CI->aauth->generate_recaptcha_field();
	}
}

if( ! function_exists('get_system_var'))
{
	function get_system_var($key)
	{
		$CI = & get_instance();
		return $CI->aauth->get_system_var($key);
	}
}

/* End of file aauth_helper.php */
/* Location: ./core_modules/helpers/aauth_helper.php */