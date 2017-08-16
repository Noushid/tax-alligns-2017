<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 3:00 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Message_Model extends MY_Model
{


    function __construct()
    {
        $this->has_one['file'] = array('foreign_model' => 'File_model', 'foreign_table' => 'files', 'foreign_key' => 'id', 'local_key' => 'file_id');
        $this->has_one['user'] = array('foreign_model' => 'User_model', 'foreign_table' => 'users', 'foreign_key' => 'id', 'local_key' => 'user_id');
        parent::__construct();
        $this->timestamps = FALSE;
    }
}