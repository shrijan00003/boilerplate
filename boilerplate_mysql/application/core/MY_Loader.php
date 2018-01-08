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
 * MY_Router
 *
 * Extends the MX_Router class
 * 
 */

/* load the MX_Loader class */
require APPPATH."libraries/MX/Loader.php";

class MY_Loader extends MX_Loader 
{
	/** Load the database drivers **/
	public function database($params = '', $return = FALSE, $query_builder = NULL) 
	{
		if ($return === FALSE && $query_builder === NULL && 
			isset(CI::$APP->db) && is_object(CI::$APP->db) && ! empty(CI::$APP->db->conn_id))
		{
			return FALSE;
		}

		require_once BASEPATH.'database/DB'.EXT;

		$db = DB($params, $query_builder);
		$subdriver = '';
		if ( ! empty($db->subdriver)) {
			$subdriver = '_'.$db->subdriver;
		}
		$my_driver = config_item('subclass_prefix').'DB_'.$db->dbdriver.$subdriver.'_driver';
		$my_driver_file = APPPATH.'libraries/'.$my_driver.EXT;

		if (file_exists($my_driver_file))
		{
		    require_once($my_driver_file);
		    $db = new $my_driver(get_object_vars($db));
		}

		if ($return === TRUE) return $db;
	
		CI::$APP->db = $db;//DB($params, $query_builder);
		
		//return $this;
	}
}