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
* Migration_Create_sessions
*
* Extends the CI_Migration class
* 
*/
class Migration_Create_sessions extends CI_Migration {

    function up() 
    {       

        if ( ! $this->db->table_exists('project_sessions'))
        {
            // Setup Keys 
            $this->dbforge->add_key('id', TRUE);

            $this->dbforge->add_field(array(
                'id'            => array('type' => 'varchar',   'constraint' => 40),
                'ip_address'    => array('type' => 'varchar',   'constraint' => '45', 'null' => FALSE),
                'timestamp'     => array('type' => 'int',       'constraint' => '10', 'null' => FALSE),
                'data'          => array('type' => 'text',      'null'       => FALSE)
            ));

            $this->dbforge->create_table('project_sessions', TRUE);
        }

        if ( ! $this->db->table_exists('project_activity_logs'))
        {
            // Setup Keys 
            $this->dbforge->add_key('id', TRUE);

            $this->dbforge->add_field(array(
                'id'            => array('type' => 'serial'),
                'user_id'       => array('type' => 'int',           'constraint' => 11,     'unsigned' => TRUE),
                'table_name'    => array('type' => 'varchar',       'constraint' => '255',  'null'     => TRUE),
                'table_pk'      => array('type' => 'int',           'constraint' => 11,     'unsigned' => TRUE),
                'action'        => array('type' => 'varchar',       'constraint' => '255',  'null'     => TRUE),
                'action_dttime' => array('type' => 'datetime',      'default'    => null),
            ));

            $this->dbforge->create_table('project_activity_logs', TRUE);
        }

        if ( ! $this->db->table_exists('project_audit_logs'))
        {
            // Setup Keys 
            $this->dbforge->add_key('id', TRUE);

            $this->dbforge->add_field(array(
                'id'            => array('type' => 'serial'),
                'user_id'       => array('type' => 'int',           'constraint' => 11,     'unsigned' => TRUE),
                'table_name'    => array('type' => 'varchar',       'constraint' => '255',  'null'     => TRUE),
                'table_pk'      => array('type' => 'int',           'constraint' => 11,     'unsigned' => TRUE),
                'column_name'   => array('type' => 'varchar',       'constraint' => '255',  'null'     => TRUE),
                'old_value'     => array('type' => 'varchar',       'constraint' => '1000', 'null'     => TRUE),
                'new_value'     => array('type' => 'varchar',       'constraint' => '1000', 'null'     => TRUE),
                'action_dttime' => array('type' => 'datetime',      'default'    => null),
            ));

            $this->dbforge->create_table('project_audit_logs', TRUE);
        }
    }

    function down() 
    {
        $this->dbforge->drop_table('project_sessions');
        $this->dbforge->drop_table('project_activity_logs');
        $this->dbforge->drop_table('project_audit_logs');
    }
}