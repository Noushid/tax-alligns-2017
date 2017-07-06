<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 3:00 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_Model extends MY_Model
{



    function __construct()
    {

        /*Third array value is updated value for current page*/
        $this->pagination_delimiters = array('<li>','</li>','<li class="active">');
        $this->pagination_arrows = array('previous','next');

        $this->has_one['file'] = array('foreign_model' => 'File_model', 'foreign_table' => 'files', 'foreign_key' => 'id', 'local_key' => 'file_id');
        $this->has_one['document'] = array('foreign_model' => 'File_model', 'foreign_table' => 'files', 'foreign_key' => 'id', 'local_key' => 'document_id');
        $this->timestamps = FALSE;
        parent::__construct();
    }
}