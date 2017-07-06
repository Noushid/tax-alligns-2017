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

    public function login($page = 'login')
    {
        if ($this->session->userdata('logged_in') == TRUE) {
            redirect(base_url('admin/#/'));
            return FALSE;
        }

        $this->load->view($page);
    }

    public function index($page = 'index')
    {
        $data['testimonial'] = $this->_load_testimonial();
        $data['blog'] = $this->_load_blog(3);
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
        $this->load->view($this->header,['current' => 'IT']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function tds($page = 'tds')
    {
        $this->load->view($this->header,['current' => 'IT']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    /*gst sub-menu end*/

    public function blog($pagnate="")
    {
        $page = 'blog';
        $total_post = $this->blog->count_rows();
        $data['blog'] = $this->blog->with_file()->with_document()->paginate(5, $total_post);
        $data['all_pages'] = $this->blog->all_pages;

        $this->load->view($this->header,['current' => 'Our Blog']);
        $this->load->view($page, $data);
        $this->load->view($this->footer);
    }

    public function blogView($id)
    {
        $data['blog'] = $this->blog->where('id', $id)->with_file()->with_document()->get_all();
        $data['recent'] = $this->blog->with_file()->with_document()->limit(10)->get_all();
        $this->load->view($this->header,['current' => 'Our Blog']);
        $this->load->view("blogView", $data);
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

    public function _load_blog($limit ="")
    {
        if ($limit != "") {
            return $this->blog->with_file()->with_document()->limit($limit)->get_all();
        } else {
            return $this->blog->with_file()->with_document()->get_all();
        }
    }


    function send_message()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation error');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $comments = $this->input->post('message');

            $comments = wordwrap($comments, 70, "<br>");
            $subject = 'Comments from : ' . $name;

            $message = 'name  :  ' . $name . PHP_EOL . PHP_EOL;
            $message .= 'comments from  :   ' . $email . PHP_EOL . PHP_EOL;
            $message .= 'Comments   :   ' . $comments . PHP_EOL . PHP_EOL;

            $message = str_replace("\n.", "\n..", $message);

            $to = 'info@accountsandtax.in';

            $headers = 'From: comments@accountsandtax.in';

            if (mail($to, $subject, $message, $headers)) {
                $this->output->set_output('success');
            } else {
//                $this->output->set_status_header(101, 'Mail server connect error');
                $this->output->set_output('error');
            }
        }
    }


}