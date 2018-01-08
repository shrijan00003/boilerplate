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
 * Extends the Project_Controller class
 * 
 */

class Admin{CONTROLLER_NAME} extends Project_Controller
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
		$data['page'] = $this->config->item('template_admin') . "index";
		$data['module'] = '{MODULE}';
		$this->load->view($this->_container,$data);
	}

	public function json()
	{
		search_params();
		
		$total=$this->{MODEL}->find_count();
		
		paging('{PRIMARY_KEY}');
		
		search_params();
		
		$rows=$this->{MODEL}->findAll();
		
		echo json_encode(array('total'=>$total,'rows'=>$rows));
		exit;
	}

	public function save()
	{
        $data=$this->_get_posted_data(); //Retrive Posted Data

        if(!$this->input->post('{PRIMARY_KEY}'))
        {
            $success=$this->{MODEL}->insert($data);
        }
        else
        {
            $success=$this->{MODEL}->update($data['{PRIMARY_KEY}'],$data);
        }

		if($success)
		{
			$success = TRUE;
			$msg=lang('general_success');
		}
		else
		{
			$success = FALSE;
			$msg=lang('general_failure');
		}

		 echo json_encode(array('msg'=>$msg,'success'=>$success));
		 exit;
	}

   private function _get_posted_data()
   {
   		$data=array();
   		if($this->input->post('id')) {
			$data['id'] = $this->input->post('id');
		}
{POSTED_DATA}
        return $data;
   }
}