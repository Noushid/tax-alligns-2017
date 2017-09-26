<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 3:00 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * {@inheritDoc}
 */
class Message_Model extends MY_Model
{


    function __construct()
    {
        /*Third array value is updated value for current page*/
        $this->pagination_delimiters = array('<li>','</li>','<li class="active">');
        $this->pagination_arrows = array('previous','next');
        $this->pagination_prefix = '#filter=' . $this->session->userdata('filter_hash');

        $this->has_one['user'] = array('foreign_model' => 'User_model', 'foreign_table' => 'users', 'foreign_key' => 'id', 'local_key' => 'user_id');
        $this->has_one['reference'] = array('foreign_model' => 'Message_model', 'foreign_table' => 'messages', 'foreign_key' => 'id', 'local_key' => 'reference_id');

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