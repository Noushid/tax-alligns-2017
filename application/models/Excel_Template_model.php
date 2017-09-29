<?php
/**
 * Excel_Template_model.php
 * User: psybo-03
 * Date: 29/9/17
 * Time: 12:19 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_Template_model extends MY_Model
{


    function __construct()
    {
        $this->has_one['file'] = array('foreign_model' => 'File_model', 'foreign_table' => 'files', 'foreign_key' => 'id', 'local_key' => 'file_id');
        $this->timestamps = FALSE;
        parent::__construct();
    }
}