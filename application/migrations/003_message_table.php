<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 1:08 PM
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_message_table extends CI_Migration
{
    public function up()
    {

        /**
         * messages
         *
         * */

        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'subject' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'message' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'datetime'=>[
                'type'=>'INT',
                'constraint' => '12',
            ],
            'received' => [
                'type' => 'INT',
                'default' => 0
            ],
            'received_time'=>[
                'type' => 'INT',
                'constraint' => '10'
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('messages');
    }

    public function down()
    {
        $this->dbforge->drop_table('messages');
    }
}