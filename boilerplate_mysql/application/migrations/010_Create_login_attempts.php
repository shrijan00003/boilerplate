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
* Migration_Create_login_attempts
*
* Extends the CI_Migration class
* 
*/
class Migration_Create_login_attempts extends CI_Migration {

    function up() 
    {       

        if ( ! $this->db->table_exists('aauth_login_attempts'))
        {
            // Setup Keys 
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key(array('id','sender_id','receiver_id','date_read'));

            $this->dbforge->add_field(array(
                'id'                    => array('type' => 'int',           'constraint' => 11,      'unsigned' => TRUE, 'auto_increment' => TRUE),
                'ip_address'            => array('type' => 'varchar',       'constraint' => '40',    'default' => 0),
                'timestamp'             => array('type' => 'datetime',      'null'       => FALSE,   'default'  => null),
                'login_attempts'        => array('type' => 'int',           'constraint' => '2',    'default' => 0),
            ));

            $this->dbforge->create_table('aauth_login_attempts', TRUE);
        }
    }

    function down() 
    {
        $this->dbforge->drop_table('aauth_login_attempts');
    }
}