<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 1:08 PM
 */

defined('BASEPATH') or exit('No direct script access allowed');

class MIgration_initial_schema extends CI_Migration
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
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('files');


      /*///////////////////////////////////////////////////////////////////
      |                                                                   |
      |               Gallery                                             |
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
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'file_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => TRUE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('galleries');

        /*///////////////////////////////////////////////////////////////////
        |                                                                   |
        |               portfolios                                          |
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
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('portfolios');



       /*///////////////////////////////////////////////////////////////////
       |                                                                   |
       |               portfolio files                                     |
       |                                                                   |
       ///////////////////////////////////////////////////////////////////*/


        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'portfolio_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => TRUE,
            ],
            'file_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => TRUE,
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('portfolio_files');
    }

}