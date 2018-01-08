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
* Migration_Create_groups
*
* Extends the CI_Migration class
* 
*/
class Migration_Create_groups extends CI_Migration {

    function up() 
    {       

        if ( ! $this->db->table_exists('aauth_groups'))
        {
            // Setup Keys 
            $this->dbforge->add_key('id', TRUE);

            $this->dbforge->add_field(array(
                'id'            => array('type' => 'int',       'constraint' => 11,     'unsigned' => TRUE, 'auto_increment' => TRUE),
                'name'          => array('type' => 'varchar',   'constraint' => '100',  'null'     => TRUE),
                'definition'    => array('type' => 'text',      'null'       => TRUE),
            ));

            $this->dbforge->create_table('aauth_groups', TRUE);
        }
    }

    function down() 
    {
        $this->dbforge->drop_table('aauth_groups');
    }
}