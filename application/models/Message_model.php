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
        $this->has_one['user'] = array('foreign_model' => 'User_model', 'foreign_table' => 'users', 'foreign_key' => 'id', 'local_key' => 'user_id');

        $this->has_many_pivot['files'] = [
            'foreign_model' => 'File_model',
            'pivot_table' => 'message_files',
            'local_key' => 'id',
            'pivot_local_key' => 'message_id',
            'pivot_foreign_key' => 'file_id',
            'foreign_key' => 'id',
            'get_relate' => TRUE
        ];
        parent::__construct();
        $this->timestamps = FALSE;
    }
}