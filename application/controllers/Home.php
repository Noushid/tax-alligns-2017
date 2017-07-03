<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 11/5/17
 * Time: 4:47 PM
 */
defined('BASEPATH') or exit('No Direct Script Access Allowed');

class Home extends CI_Controller
{
    protected $header = 'templates/header';
    protected $footer = 'templates/footer';
    protected $slider = 'templates/slider';
    
    function __construct()
    {
        parent::__construct();
    }


    public function index($page = 'index')
    {
        $this->load->view($this->header,['current' => 'Home']);
        $this->load->view($this->slider);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    public function about($page = 'about')
    {
        $this->load->view($this->header,['current' => 'About Us']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    public function portfolio($page = 'portfolio')
    {
        $this->load->view($this->header,['current' => 'Portfolio']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    public function portfolioDetails($page = 'portfolioDetails')
    {
        $this->load->view($this->header,['current' => 'Portfolio']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    public function moments($page = 'moments')
    {
        $this->load->view($this->header,['current' => 'Moments']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    public function contact($page = 'contact')
    {
        $this->load->view($this->header,['current' => 'Contact Us']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

}