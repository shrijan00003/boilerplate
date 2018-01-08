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
* Project
*
*/
class Project {

    public $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }
}
?>