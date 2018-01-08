<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| APP CONFIG
|--------------------------------------------------------------------------
*/
$config['site_name'] = 'PROJECT';

// Public Template
$config['template_public'] = "public/";

// Admin Template
$config['template_admin'] = "admin/";

// Default Login
$config['default_login_action'] = 'home';

// Admin Login Actin
$config['admin_login_action'] = 'admin';

// Default Logout Action
$config['default_logout_action'] = '';


/*
|--------------------------------------------------------------------------
| APP CONSTANTS
|--------------------------------------------------------------------------
*/
defined('DEFAULT_PASSWORD') OR define('DEFAULT_PASSWORD', 'password');

defined('CACHE_PATH') OR define('CACHE_PATH', APPPATH .'cache'. DIRECTORY_SEPARATOR);