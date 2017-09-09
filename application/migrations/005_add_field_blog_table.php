<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 1:08 PM
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_field_blog_table extends CI_Migration
{
    public function up()
    {

        /**
         * Blog
         *
         * */

        $this->dbforge->add_column('blogs',[
            'introduction' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'image_url' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE
            ]
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('blogs', 'introduction');
    }
}