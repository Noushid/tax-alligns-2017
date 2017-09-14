<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 2:59 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class User_Controller extends CI_Controller
{

    //        public $delete_cache_on_save = TRUE;
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->model('File_model', 'file');
        $this->config->load('ion_auth', TRUE);

        $this->load->library(['upload', 'image_lib','ion_auth']);

        /**
         * Check loin
         *
         */
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('login', 'refresh');
        }
    }

    function index()
    {
        $data = $this->user->where('`company` IS NULL',FALSE,FALSE,FALSE,FALSE,TRUE)->get_all();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    function get_all()
    {
        $data = $this->user->where('`company` IS NULL',FALSE,FALSE,FALSE,FALSE,TRUE)->with_message('where:received=0 AND type=\'received\'','fields:*count*')->get_all();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function store()
    {
        $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[2]|max_length[20]|required');

        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation Error');
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors()));
        } else {
            if ($this->input->post('email')) {
                if ($this->user->where('email',$this->input->post('email'))->get() != FALSE) {
                    $this->output->set_status_header(500, 'email exist');
                    exit;
                }
            }
            $first_name = $this->input->post('first_name', TRUE);
            $last_name = $this->input->post('last_name', TRUE);
            $username = $this->input->post('email', TRUE);
            $email = $this->input->post('email', TRUE);
            $phone = $this->input->post('phone', TRUE);
            $password = $this->input->post('password', TRUE);

            $additional_data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $phone,
                'temp_password' => $password,
                'active' => TRUE
            );

            if ($this->ion_auth->register($username, $password, $email, $additional_data)) {
                $name = $first_name . '  ' . $last_name;

                $subject = 'Account Details: ' ;

                $message = 'Hi ' . $name . PHP_EOL . PHP_EOL;
                $message .= 'Username  :  ' . $name . PHP_EOL . PHP_EOL;
                $message .= 'Password  :  ' . $password . PHP_EOL . PHP_EOL;

                $to = $email;

                $headers  = 'MIME-Version: 1.0' . "\r\n";

                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                $headers .= 'From: info@accountsandtax.in';

                if (mail($to, $subject, $message, $headers)) {
                    $this->output->set_content_type('application/json')->set_output(json_encode($this->input->post(NULL, TRUE)));
                } else {
                    $this->output->set_status_header(400, 'Mail server error');
                    $this->output->set_content_type('application/json')->set_output(json_encode($this->input->post(NULL, TRUE)));
                }
            } else {
                $this->output->set_status_header(500, 'Server Down');
                $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'user Create Error']));
            }
        }
    }

    function update($id){
        $this->form_validation->set_rules('heading', 'Heading', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation Error');
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors()));
        } else {
            $post_data = $this->input->post();
            if ($this->user->update($post_data,$id)) {
                $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
            } else {
                $this->output->set_status_header(500, 'Server Down');
                $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Update error.']));
            }
        }
    }


    function delete_image($id)
    {
        $user = $this->user->with_file()->where('file_id',$id)->get();
        if ($user->file != null and $this->file->delete($user->file->id)) {
            if (file_exists(getwdir() . 'uploads/' . $user->file->file_name)) {
                unlink(getwdir() . 'uploads/' . $user->file->file_name);
            }
            $this->user->update(['file_id' => null], $user->id);
            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Image Delete']));
        }else{
            $this->output->set_status_header(400, 'Server Down');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Try again later']));
        }
    }

    function upload()
    {
        $config['upload_path'] = getwdir() . 'uploads';
        $config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG|pdf';
        $config['max_size'] = 4096;
        $config['file_name'] = 'B_' . rand();
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $data['url'] = base_url() . 'uploads/' . $this->upload->data('file_name');

            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }else{
            $this->output->set_status_header(401, 'File Upload Error');
            $this->output->set_content_type('application/json')->set_output($this->upload->display_errors('',''));
        }
    }

    public function activate($id)
    {
        if ($this->user->update(['active' => 1],$id)) {
            $this->output->set_content_type('application/json')->set_output(json_encode('Activated'));
        } else {
            $this->output->set_status_header(400, 'Server Down');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Something Went wrong']));
        }
    }

    public function de_activate($id)
    {
        if ($this->user->update(['active' => 0],$id)) {
            $this->output->set_content_type('application/json')->set_output(json_encode('De-activated'));
        } else {
            $this->output->set_status_header(400, 'Server Down');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Something Went wrong']));
        }
    }


    public function delete($id)
    {
        if ($this->ion_auth->delete_user($id)) {
            $this->output->set_content_type('application/json')->set_output(json_encode('Deleted'));
        } else {
            $this->output->set_status_header(400, 'Server Down');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Something Went wrong']));
        }
    }

    public function check_email()
    {
        if ($this->user->where('email', $this->input->post('email'))->get() != FALSE) {
            $this->output->set_status_header(400, 'email exist');
            exit;
        }
    }
}