<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 2:59 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Message_Controller extends CI_Controller
{

    //        public $delete_cache_on_save = TRUE;
    function __construct()
    {
        parent::__construct();
        $this->load->model('File_model', 'file');
        $this->load->model('Message_model', 'message');
        $this->load->model('Message_file_model', 'message_file');

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
        $data = $this->message->with_files()->with_user()->get_all();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function get($id)
    {
        $data = $this->message->with_files()->with_user()->where('user_id', $id)->order_by('id','DESC')->get_all();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_where($id,$param1)
    {
        $data = $this->message->with_files()->with_user()->where('user_id', $id)->where('type', $param1)->order_by('id','DESC')->get_all();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function send($user_id)
    {
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation Error');
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors()));
        } else {
            $error = 0;
            $post_data = $this->input->post();
            $uploaded = json_decode($post_data['uploaded']);
            unset($post_data['uploaded']);
            $post_data['type'] = 'sent';
            $post_data['datetime'] = now();
            $post_data['user_id'] = $user_id;
            $message_id = $this->message->insert($post_data);

            if ($message_id) {
                if (!empty($uploaded)) {
                    foreach ($uploaded as $file) {
                        $data = [];
                        $data['file_name'] = $file->file_name;
                        $data['file_type'] = $file->file_type;
                        $data['size'] = $file->file_size;
                        $data['path'] = $file->full_path;
                        $data['date'] = date('Y-m-d');
                        $data['url'] = base_url('uploads/') . $file->file_name;
                        $file_id = $this->file->insert($data);
                        if ($file_id) {
                            $message_file['file_id'] = $file_id;
                            $message_file['message_id'] = $message_id;
                            if (!$this->message_file->insert($message_file)) {
                                $error = 1;
                                $this->file->delete($file_id);
                            }
                        }
                    }
                }

                if ($error == 0) {
                    $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
                } else {
                    $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Some files are Can\'t sent!']));
                }
            }
        }
    }

    function upload()
    {
        $config['upload_path'] = getwdir() . 'uploads';
        $config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG|pdf';
        $config['max_size'] = 4096;
        $config['file_name'] = rand(100, 999) . 'FILE' . now();
        $config['multi'] = 'ignore';
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $this->output->set_content_type('application/json')->set_output(json_encode($this->upload->data()));
        }else{
            $this->output->set_status_header(401, 'File Upload Error');
            $this->output->set_content_type('application/json')->set_output($this->upload->display_errors('',''));
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

    public function delivered($id)
    {
        $data['received'] = 1;
        $data['received_time'] = now();

        if ($this->message->update($data,$id)) {
            $this->output->set_content_type('application/json')->set_output(true);
        } else {
            $this->output->set_status_header(400, 'Server Down');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Something Went wrong']));
        }
    }
}