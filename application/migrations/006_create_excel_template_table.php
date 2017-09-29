<?php
/**
 * 006_create_excel_template_table.php
 * User: psybo-03
 * Date: 29/9/17
 * Time: 12:11 PM
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_excel_template_table extends CI_Migration
{
    public function up()
    {

        /**
         * excel_template
         *
         * */

        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'active' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'name' => [
                'type' => 'LONGTEXT',
                null => true,
            ],
            'file_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('excel_templates');
    }

    public function down()
    {
        $this->dbforge->drop_table('excel_templates');
    }
}