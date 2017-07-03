<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 3/7/17
 * Time: 3:15 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Document_model extends MY_Model
{


    function __construct()
    {
        $this->has_one['file'] = array('foreign_model' => 'File_model', 'foreign_table' => 'files', 'foreign_key' => 'id', 'local_key' => 'file_id');
        $this->timestamps = FALSE;
        parent::__construct();
    }
}