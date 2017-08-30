<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 1:08 PM
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_message_files_table extends CI_Migration
{
    public function up()
    {

        /**
         * message_files
         *
         * */

        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'message_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'file_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('message_files');
    }

    public function down()
    {
        $this->dbforge->drop_table('message_files');
    }
}