<?php
/**
 * Created by PhpStorm.
 * User: noushi
 * Date: 18/7/16
 * Time: 5:09 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Check_Logged extends CI_Controller
{
    public $logged = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'image_lib']);

        $this->logged = $this->session_check();
    }


    /*
     * Check the Session status
     * if session exist return true
     * else return false
     * */

    public function session_check()
    {
        if($this->session->userdata('logged_in') != null)
            return TRUE;
        else
            return FALSE;
    }
}