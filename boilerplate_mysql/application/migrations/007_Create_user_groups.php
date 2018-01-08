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
* Migration_Create_user_groups
*
* Extends the CI_Migration class
* 
*/
class Migration_Create_user_groups extends CI_Migration {

    function up() 
    {       

        if ( ! $this->db->table_exists('aauth_user_groups'))
        {
            // Setup Keys 
            $this->dbforge->add_key('user_id', TRUE);
            $this->dbforge->add_key('group_id', TRUE);

            $this->dbforge->add_field(array(
                'user_id'    => array('type' => 'int', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE),
                'group_id'   => array('type' => 'int', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE),
            ));

            $this->dbforge->create_table('aauth_user_groups', TRUE);


        }
    }

    function down() 
    {
        $this->dbforge->drop_table('aauth_user_groups');
    }
}