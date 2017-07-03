<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 3:00 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_Model extends MY_Model
{


    function __construct()
    {
//        $this->has_one['file'] = ['File_model','id',''];
        $this->has_one['file'] = array('foreign_model' => 'File_model', 'foreign_table' => 'files', 'foreign_key' => 'id', 'local_key' => 'file_id');
        parent::__construct();
        $this->timestamps = FALSE;
    }
}