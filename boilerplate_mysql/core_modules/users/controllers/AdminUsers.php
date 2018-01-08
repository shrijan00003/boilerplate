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
 * Extends the Project_Controller class
 * 
 */

class AdminUsers extends Project_Controller
{
	public function __construct(){
		parent::__construct();

		control('Users');

        $this->load->model('groups/group_model');
		$this->load->model('users/user_model');
        $this->load->model('users/user_group_model');
		$this->lang->load('users/user');
	}

	public function index()
	{
		// Display Page
		$data['header'] = lang('users');
		$data['page'] = $this->config->item('template_admin') . "index";
		$data['module'] = 'users';

        $this->db->where('id <>', 1);
		$data['groups'] = $this->group_model->findAll();
		$this->load->view($this->_container,$data);
	}

	public function json()
	{
		$this->_get_search_param();
		$this->user_model->_table = 'view_users';

        if($this->session->userdata('id') != 1) 
        {
            $this->db->where('id <>', 1);
        }
        
        $total=$this->user_model->find_count();
		
        paging('id');
		
        $this->_get_search_param();
        
        if($this->session->userdata('id') != 1) 
        {
            $this->db->where('id <>', 1);
        }

        $this->user_model->as_array();
		$rows=$this->user_model->findAll();
		echo json_encode(array('total'=>$total,'rows'=>$rows));
		exit;
	}

	public function save()
	{

        $data=$this->_get_posted_data(); //Retrive Posted Data

        extract($data);

        $this->db->trans_begin();

        if(!$this->input->post('id'))
        {
        	$user_id = $success = $this->aauth->create_user($email, DEFAULT_PASSWORD, $username, $fullname);

            if (is_numeric($success)) {
                if ($this->input->post('groups')) {
                    $groups = $this->input->post('groups');
                    $groupInsertArray = array();
                    foreach($groups as $group) {
                        $temp = array();
                        $temp['user_id'] = $success;
                        $temp['group_id'] = $group;
                        $groupInsertArray[] = $temp;
                    }
                    $this->user_group_model->insert_many($groupInsertArray);
                }
            }
        }
        else
        {
        	$user_id = $success = $this->aauth->update_user($id, $email, FALSE, $username, $fullname );

            if ($success) {
                if ($this->input->post('groups')) {

                    $groups = $this->input->post('groups');

                    if (count($groups) > 0) {
                        $this->user_group_model->delete_by(array('user_id' => $id, 'group_id <>' => 1));
                        $groupInsertArray = array();
                        foreach($groups as $group) {
                            $temp = array();
                            $temp['user_id'] = $id;
                            $temp['group_id'] = $group;
                            $groupInsertArray[] = $temp;
                        }
                        $this->user_group_model->insert_many($groupInsertArray);
                    }
                }
            }
        }

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $success = FALSE;
            $msg=lang('general_failure');
        }
        else
        {
            $this->db->trans_commit();
            $success = TRUE;
            $msg=lang('general_success');
        }

        echo json_encode(array('msg'=>$msg,'success'=>$success));
        exit;

    }

    private function _get_posted_data()
    {
    	$data=array();
    	$data['id'] = $this->input->post('id');
    	$data['email'] = $this->input->post('email');
    	$data['username'] = $this->input->post('username');
        $data['fullname'] = $this->input->post('fullname');
    	return $data;
    }

    public function reset_login_attempts() 
    {
        if ($this->aauth->reset_login_attempts($this->input->post('id')))
            echo json_encode(array('success' => true));
        else
            echo json_encode(array('success' => false));
    }

    public function reset_password() 
    {
        if ($this->aauth->reset_password($this->input->post('id'), 'ADMIN'))
            echo json_encode(array('success' => true));
        else
            echo json_encode(array('success' => false));
    }

    public function toggle_user() 
    {
        if ($this->aauth->toggle_user($this->input->post('id'), $this->input->post('toggle')))
            echo json_encode(array('success' => true));
        else
            echo json_encode(array('success' => false));
    }

    public function verify_user() 
    {
        if ($this->aauth->verify_user($this->input->post('id'), 'ADMIN'))
            echo json_encode(array('success' => true));
        else
            echo json_encode(array('success' => false));
    }

    public function get_user_groups()
    {
        $jsonArray = array();

        $user_id = $this->input->post('id');
        
        //following group has user to $user_id
        $this->db->where('user_id', $user_id);
        $this->db->where_not_in('group_id', array(1,2));
        $this->user_group_model->_table = 'view_user_groups';
        $results = $this->user_group_model->findAll();

        $jsonArray['involved_groups'] = $results;

        $user_groups_array = array();
        
        if (count($results) > 0){
            foreach($results as $row) {
                $user_groups_array[]= $row->group_id;
            }
            $this->db->where_not_in('id', $user_groups_array);
        }

        //following group has no user to $user_id
        $this->db->where_not_in('id', array(1,2));
        $results = $this->group_model->findAll(null, array('id', 'name as group_name'));
        $jsonArray['not_involved_groups'] = $results;

        echo json_encode($jsonArray);
        exit;
    }

    public function save_user_groups() {
        
        $user_id = $this->input->post('user_id');
        $groups = $this->input->post('involved_groups_ids');

        $this->db->trans_begin();

        $this->user_group_model->delete_by(array('user_id' => $user_id, 'group_id <>' => 1));

        if ($groups != '') {
            $groups = explode(",", $groups);
            $insertArray = array();

            foreach ($groups as $group) {
                $temp = array();
                $temp['user_id'] = $user_id;
                $temp['group_id'] = $group;
                $insertArray[] = $temp;
            }

            if (count($insertArray) > 0) {
                $this->user_group_model->insert_many($insertArray);
            }
        }

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            echo json_encode(array('success' => false));
        }
        else
        {
            $this->db->trans_commit();
            echo json_encode(array('success' => true));
        } 
    }
}