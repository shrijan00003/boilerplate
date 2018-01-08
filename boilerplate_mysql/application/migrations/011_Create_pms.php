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
* Migration_Create_pms
*
* Extends the CI_Migration class
* 
*/
class Migration_Create_pms extends CI_Migration {

    function up() 
    {       

        if ( ! $this->db->table_exists('aauth_pms'))
        {
            // Setup Keys 
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key(array('id','sender_id','receiver_id','date_read'));

            $this->dbforge->add_field(array(
                'id'                    => array('type' => 'int',           'constraint' => 11,      'unsigned' => TRUE, 'auto_increment' => TRUE),
                'sender_id'             => array('type' => 'int',           'constraint' => 11,      'unsigned' => TRUE, 'null' => FALSE),
                'receiver_id'           => array('type' => 'int',           'constraint' => 11,      'unsigned' => TRUE, 'null' => FALSE),
                'title'                 => array('type' => 'varchar',       'constraint' => 255,     'null'     => FALSE),
                'message'               => array('type' => 'text',          'null'       => TRUE),
                'date_sent'             => array('type' => 'datetime',      'null'       => FALSE,   'default'  => null),
                'date_read'             => array('type' => 'datetime',      'null'       => FALSE,   'default'  => null),
                'pm_deleted_sender'     => array('type' => 'int',           'default'    => 0 ),
                'pm_deleted_receiver'   => array('type' => 'int',           'default'    => 0 )
             ));

            $this->dbforge->create_table('aauth_pms', TRUE);
        }
    }

    function down() 
    {
        $this->dbforge->drop_table('aauth_pms');
    }
}