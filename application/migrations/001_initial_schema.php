<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 1:08 PM
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_initial_schema extends CI_Migration
{
    public function up()
    {

      /*///////////////////////////////////////////////////////////////////
      |                                                                   |
      |                 USERS                                             |
      |                                                                   |
      /////////////////////////////////////////////////////////////////////*/

        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '56',
                'unique' => TRUE,
            ],
            'password' => [
                'type' => 'LONGTEXT'
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');


       /*///////////////////////////////////////////////////////////////////
       |                                                                   |
       |                 FILES                                             |
       |                                                                   |
       ///////////////////////////////////////////////////////////////////*/


        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'file_type' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'size' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => TRUE
            ],
            'date' => [
                'type' => 'DATE',
                'null' => TRUE
            ],
            'path' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('files');


      /*///////////////////////////////////////////////////////////////////
      |                                                                   |
      |               testimonial                                         |
      |                                                                   |
      ///////////////////////////////////////////////////////////////////*/


        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'organisation' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'description' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'file_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => TRUE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('testimonials');

        /*///////////////////////////////////////////////////////////////////
        |                                                                   |
        |               Blog                                                |
        |                                                                   |
        ///////////////////////////////////////////////////////////////////*/


        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'heading' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'content' => [
                'type' => 'LONGTEXT',
                'null' => TRUE
            ],
            'date' => [
                'type' => 'DATE',
                'null' => TRUE
            ],
            'file_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => TRUE,
            ],
            'document_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => TRUE,
            ]

        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('blogs');



       /*///////////////////////////////////////////////////////////////////
       |                                                                   |
       |               Documents                                           |
       |                                                                   |
       ///////////////////////////////////////////////////////////////////*/


        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'LONGTEXT',
                'null' => TRUE,
            ],
            'description' => [
                'type' => 'LONGTEXT',
                'null' => TRUE,
            ],
            'file_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => TRUE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('documents');
    }

    public function down()
    {
        $this->dbforge->drop_table('users');
        $this->dbforge->drop_table('files');
        $this->dbforge->drop_table('testimonils');
        $this->dbforge->drop_table('blogs');
        $this->dbforge->drop_table('documents');
    }
}