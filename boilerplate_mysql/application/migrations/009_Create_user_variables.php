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
* Migration_Create_user_variables
*
* Extends the CI_Migration class
* 
*/
class Migration_Create_user_variables extends CI_Migration {

    function up() 
    {       

        if ( ! $this->db->table_exists('aauth_user_variables'))
        {
            // Setup Keys 
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key(array('user_id'));

            $this->dbforge->add_field(array(
                'id'        => array('type' => 'int',       'constraint' => 11,     'unsigned' => TRUE, 'auto_increment' => TRUE),
                'user_id'   => array('type' => 'int',       'constraint' => 11,     'unsigned' => TRUE, 'null' => FALSE),
                'data_key'  => array('type' => 'varchar',   'constraint' => '100',  'null'     => FALSE),
                'value'     => array('type' => 'text',      'null'       => TRUE),
            ));

            $this->dbforge->create_table('aauth_user_variables', TRUE);
        }
    }

    function down() 
    {
        $this->dbforge->drop_table('aauth_user_variables');
    }
}