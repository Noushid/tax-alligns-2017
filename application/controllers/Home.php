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
        $this->load->model('Testimonial_model', 'testimonial');
        $this->load->model('Blog_model', 'blog');
    }


    public function index($page = 'index')
    {
        $data['testimonial'] = $this->_load_testimonial();
        $data['blog'] = $this->_load_blog();
        $this->load->view($this->header,['current' => 'Home']);
        $this->load->view($this->slider);
        $this->load->view($page, $data);
        $this->load->view($this->footer);
    }

    public function about($page = 'about')
    {
        $this->load->view($this->header,['current' => 'About Us']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    public function services($page = 'services')
    {
        $this->load->view($this->header,['current' => 'Our Services']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    /*gst sub-menu start*/
    public function gst($page = 'gst')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function whatisgst($page = 'whatisgst')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gstaccounting($page = 'gstaccounting')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gstfiling($page = 'gstfiling')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gstinvoice($page = 'gstinvoice')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function returns($page = 'returns')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function tds($page = 'tds')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    /*gst sub-menu end*/

    public function blog($page = 'blog')
    {
        $this->load->view($this->header,['current' => 'Our Blog']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    public function blogView($page = 'blogView')
    {
        $this->load->view($this->header,['current' => 'Our Blog']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    public function contact($page = 'contact')
    {
        $this->load->view($this->header,['current' => 'Contact Us']);
        $this->load->view($page);
        // $this->load->view($this->footer);
    }

    public function _load_testimonial()
    {
        return $this->testimonial->with_file()->get_all();
    }

    public function _load_blog()
    {
        return $this->blog->with_file()->get_all();
    }

}