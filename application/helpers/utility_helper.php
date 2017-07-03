<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 2/1/17
 * Time: 10:43 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get public url
 *change public path,change public path in config.php
 */
if ( ! function_exists('public_url'))
{
    function public_url()
    {
        $CI =& get_instance();
        return base_url().$CI->config->item('public_path');
    }
}

/**
 * Get current working directory instead of getcwd()
 * change current working directory. change working_dir in config.php
 */

if (!function_exists('getwdir')) {
    function getwdir()
    {
        return getcwd() . '/' . get_instance()->config->item('working_dir');
    }
}

