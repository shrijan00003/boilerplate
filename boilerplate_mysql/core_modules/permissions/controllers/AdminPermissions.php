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

class AdminPermissions extends Project_Controller
{
	public function __construct(){
		parent::__construct();

		control('Permissions');

        $this->load->model('groups/group_model');
        $this->load->model('users/user_model');
		$this->load->model('permissions/permission_model');
        $this->load->model('permissions/group_permission_model');
        $this->load->model('permissions/user_permission_model');
		$this->lang->load('permissions/permission');
	}

	public function index()
	{
		// Display Page
		$data['header'] = lang('permissions');
		$data['page'] = $this->config->item('template_admin') . "index";
		$data['module'] = 'permissions';
		$this->load->view($this->_container,$data);
	}

	public function json()
	{
		$this->_get_search_param();
        if($this->session->userdata('id') != 1) 
        {
            $this->db->where('id > ', 100);
        }
		$total=$this->permission_model->find_count();
		paging('id');
		$this->_get_search_param();
        if($this->session->userdata('id') != 1) 
        {
            $this->db->where('id > ', 100);
        }
		$rows=$this->permission_model->findAll();
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
        	$success = $this->aauth->create_perm($name, $definition);
        }
        else
        {
        	$success = $this->aauth->update_perm($id, $name, $definition);
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
    	$data['name'] = $this->input->post('name');
    	$data['definition'] = $this->input->post('definition');

    	return $data;
    }

    public function delete_permission()
    {
        $this->db->trans_begin();

        $this->aauth->delete_perm($this->input->post('id'));

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

    public function get_permission_groups()
    {
        $jsonArray = array();

        $permission_id = $this->input->post('id');
        
        //following group has permission to $permission_id
        $this->db->where('perm_id', $permission_id);
        $this->db->where_not_in('group_id', array(1,2));
        $this->group_permission_model->_table = 'view_group_permissions';
        $results = $this->group_permission_model->findAll();

        $jsonArray['granted_groups'] = $results;

        $group_permissions_array = array();

        if (count($results) > 0){
            foreach($results as $row) {
                $group_permissions_array[]= $row->group_id;
            }
            $this->db->where_not_in('id', $group_permissions_array);
        }

        //following group has no permission to $permission_id
        $this->db->where_not_in('id', array(1,2));
        $results = $this->group_model->findAll();
        $jsonArray['not_granted_groups'] = $results;

        echo json_encode($jsonArray);
        exit;
    }

    public function save_permission_groups() {
        
        $perm_id = $this->input->post('perm_id');
        $groups = $this->input->post('granted_groups_ids');

        $this->db->trans_begin();

        $this->group_permission_model->delete_by(array('perm_id' => $perm_id));

        if ($groups != '') {
            $groups = explode(",", $groups);
            $insertArray = array();

            foreach ($groups as $group) {
                $temp = array();
                $temp['perm_id'] = $perm_id;
                $temp['group_id'] = $group;
                $insertArray[] = $temp;
            }

            if (count($insertArray) > 0) {
                $this->group_permission_model->insert_many($insertArray);
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

    public function get_permission_users()
    {
        $jsonArray = array();

        $permission_id = $this->input->post('id');
        
        //following users has permission to $permission_id
        $this->db->where('perm_id', $permission_id);
        $this->user_permission_model->_table = 'view_user_permissions';
        $results = $this->user_permission_model->findAll();

        $jsonArray['granted_users'] = $results;

        $user_permissions_array = array();

        if (count($results) > 0){
            foreach($results as $row) {
                $user_permissions_array[]= $row->user_id;
            }
            $this->db->where_not_in('id', $user_permissions_array);
        }

        //following users has no permission to $permission_id
        $this->db->where_not_in('id', array(1));
        $results = $this->user_model->findAll(null, array('id','username','email'));

        $jsonArray['not_granted_users'] = $results;

        echo json_encode($jsonArray);
        exit;
    }

    public function save_permission_users() {
        
        $perm_id = $this->input->post('perm_id');
        $users = $this->input->post('granted_users_ids');

        $this->db->trans_begin();

        $this->user_permission_model->delete_by(array('perm_id' => $perm_id));

        if ($users != '') {
            $users = explode(",", $users);
            $insertArray = array();

            foreach ($users as $user) {
                $temp = array();
                $temp['perm_id'] = $perm_id;
                $temp['user_id'] = $user;
                $insertArray[] = $temp;
            }

            if (count($insertArray) > 0) {
                $this->user_permission_model->insert_many($insertArray);
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