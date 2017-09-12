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
        $this->data['password'] = ['type' => 'password', 'id' => 'phone-footer', 'required' => '', 'placeholder' => 'Password*', 'class' => 'tb-my-input', 'name' => 'password', 'tabindex' => 5, 'size' => 32, 'area-required' => 'true', 'pattern' => '^.{' . $this->config->item('min_password_length','ion_auth') . '}.*$'];
        $this->data['confirm_password'] = ['type' => 'password', 'id' => 'phone-footer', 'required' => '', 'placeholder' => 'Confirm Password*', 'class' => 'tb-my-input', 'name' => 'confirm_password', 'tabindex' => 6, 'size' => 32, 'area-required' => 'true', 'pattern' => '^.{' . $this->config->item('min_password_length','ion_auth') . '}.*$'];

        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|is_unique[users.email]',['is_unique' => 'The email already registered!']);
            $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'),
                'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[confirm_password]',
                [
                    'min_length' => 'The password must be at least ' . $this->config->item('min_password_length', 'ion_auth') . 'characters in length.',
                    'max_length' => 'The password cannot exceed ' . $this->config->item('min_password_length', 'ion_auth') . 'characters in length.',
                    'matches'=>'The password does not match.'
                ]);
            $this->form_validation->set_rules('confirm_password', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->load->view($this->header,['current' => 'register']);
                $this->load->view('user/register',$this->data);
                $this->load->view($this->footer);
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
                    redirect(base_url('login'));
                } else {
                    $_SESSION['auth_message'] = $this->ion_auth->errors();
                    $this->session->mark_as_flash('auth_message');
                    redirect('register');
                }
            }
        } else {

            $this->load->view($this->header,['current' => 'register']);
            $this->load->view('user/register',$this->data);
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
            if ($this->session->flashdata('auth_message')) {
                $data['message']=$this->session->flashdata('auth_message');
            }
            $data['current'] = 'login';
            $this->load->view('user/login',$data);
        }
    }

    public function logout()
    {
        $this->ion_auth->logout();
        redirect('user/login');
    }


}