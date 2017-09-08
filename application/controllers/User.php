<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    protected $header = 'templates/header';
    protected $footer = 'templates/footer';

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function create_user()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
//            $this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
//        $this->form_validation->set_rules('username','Username','trim|required|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[2]|max_length[20]|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|matches[password]|required');

            if ($this->form_validation->run() === FALSE) {
//                var_dump(validation_errors());
                $this->load->view('user/register');
            } else {
                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $username = $this->input->post('email');
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $additional_data = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'phone' => $this->input->post('phone')
                );

                if ($this->ion_auth->register($username, $password, $email, $additional_data)) {
                    $_SESSION['auth_message'] = 'The account has been created. You may now login.';
                    $this->session->mark_as_flash('auth_message');
                    redirect('user/login');
                } else {
                    $_SESSION['auth_message'] = $this->ion_auth->errors();
                    $this->session->mark_as_flash('auth_message');
                    redirect('register');
                }
            }
        } else {
            $this->load->view($this->header,['current' => 'login']);
            $this->load->view('user/register');
            $this->load->view($this->footer);
        }
    }

    public function login()
    {
        if($this->input->post())
        {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
//            $this->form_validation->set_rules('remember','Remember me','integer');
            if($this->form_validation->run() === TRUE)
            {
                $remember = (bool) $this->input->post('remember');
                if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
                {
                    if (!$this->ion_auth->is_admin()) {
                        redirect(base_url(), 'refresh');
                    } else {
                        $this->session->set_flashdata('message', 'Incorrect Login');
                        redirect(base_url('login'), 'refresh');
                    }
                }
                else
                {
                    $this->session->set_flashdata('message',$this->ion_auth->errors());
                    redirect(base_url('login'), 'refresh');
                }
            }
        }else{
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->load->view('user/login',$data);
        }
    }

    public function logout()
    {
        $this->ion_auth->logout();
        redirect('user/login');
    }


}