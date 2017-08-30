<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 3:10 PM
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Message_file_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->timestamps = false;
    }
}
