<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 3/7/17
 * Time: 7:14 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends MY_Model
{


    function __construct()
    {
        $this->timestamps = FALSE;
        parent::__construct();
    }

    function insert_dummy()
    {
        $insert_data = array(
            array(
                'username' => 'user',
                'password' => '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918',
            )
        );
        $this->db->insert($this->table, $insert_data);
    }
}