<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 1:18 PM
 */

defined('BASEPATH') or exit('No Direct Script Access Allowed');

/**
 * Class Migrate
 */

class Migrate extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
    }

    function index($version = "")
    {
        if ($this->migration->latest() == FALSE) {
            show_error('Error :  ' . $this->migration->error_string());
        } else {
            echo 'Migration run success';
        }
    }
}
