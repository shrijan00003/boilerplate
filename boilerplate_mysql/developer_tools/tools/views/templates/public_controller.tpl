{PHP_TAG} 
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
 * {CONTROLLER_NAME}
 *
 * Extends the Public_Controller class
 * 
 */

class {CONTROLLER_NAME} extends Public_Controller
{
	public function __construct()
	{
    	parent::__construct();

    	control('{MODULE_UCFIRST}');

        $this->load->model('{MODULE}/{MODEL}');
        $this->lang->load('{MODULE}/{LANG}');
    }

    public function index()
	{
		// Display Page
		$data['header'] = lang('{MODULE}');
		$data['page'] = $this->config->item('template_public') . "index";
		$data['module'] = '{MODULE}';
		$this->load->view($this->_container,$data);
	}
}