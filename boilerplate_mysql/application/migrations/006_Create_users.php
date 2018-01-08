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
* Migration_Create_users
*
* Extends the CI_Migration class
* 
*/
class Migration_Create_users extends CI_Migration {

    function up() 
    {       

        if ( ! $this->db->table_exists('aauth_users'))
        {
            // Setup Keys 
            $this->dbforge->add_key('id', TRUE);

            $this->dbforge->add_field(array(
                'id'                    => array('type' => 'int',           'constraint' => 11,     'unsigned' => TRUE, 'auto_increment' => TRUE),
                'email'                 => array('type' => 'varchar',       'constraint' => '100'),
                'pass'                  => array('type' => 'varchar',       'constraint' => '255'),
                'username'              => array('type' => 'varchar',       'constraint' => '100',  'null'     => TRUE),
                'fullname'              => array('type' => 'varchar',       'constraint' => '255',  'null'      => TRUE),
                'banned'                => array('type' => 'int',           'constraint' => 1,      'default'  => 0),
                'last_login'            => array('type' => 'datetime',      'default'    => null),
                'last_activity'         => array('type' => 'datetime',      'default'    => null),
                'date_created'          => array('type' => 'datetime',      'default'    => null),
                'forgot_exp'            => array('type' => 'text',          'null'       => TRUE),
                'remember_time'         => array('type' => 'datetime',      'default'    => null,   'null'     => TRUE),
                'remember_exp'          => array('type' => 'text',          'null'       => TRUE),
                'verification_code'     => array('type' => 'text',          'null'       => TRUE),
                'totp_secret'           => array('type' => 'varchar',       'constraint' => '16',  'default'   => null ),
                'ip_address'            => array('type' => 'varchar',       'constraint' => '40',  'null'      => TRUE),
            ));

            $this->dbforge->create_table('aauth_users', TRUE);
        }
    }

    function down() 
    {
        $this->dbforge->drop_table('aauth_users');
    }
}