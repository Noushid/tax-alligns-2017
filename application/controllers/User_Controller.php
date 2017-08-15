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
        $data = $this->user->get_all();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    function get_all()
    {
        $data = $this->db->where('`company` IS NULL')->get('users')->result();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function store()
    {
        $this->form_validation->set_rules('content', 'Content', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation Error');
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors()));
        } else {
            $post_data = $this->input->post();
            if ($this->user->insert($post_data)) {
                $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
            } else {
                $this->output->set_status_header(500, 'Server Down');
                $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Add Error.']));
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
        $config['multi'] = 'ignore';
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $data['url'] = base_url() . 'uploads/' . $this->upload->data('file_name');

            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }else{
            $this->output->set_status_header(401, 'File Upload Error');
            $this->output->set_content_type('application/json')->set_output($this->upload->display_errors('',''));
        }
    }



    public function delete($id)
    {
        $user = $this->user->with_file()->where('id', $id)->get();
        if ($user) {
            if ($user->file != null) {
                if ($this->file->delete($user->file->id)) {
                    if (file_exists(getwdir() . 'uploads/' . $user->file->file_name)) {
                        unlink(getwdir() . 'uploads/' . $user->file->file_name);
                        if ($this->user->delete($id)) {
                            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery Deleted']));
                        } else {
                            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery not deleted but some files are deleted']));
                        }
                    } else {
                        $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery file not exist in directory']));
                    }
                }
            } else {
                $this->user->delete($id);
                $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery Deleted']));
            }
        } else {
            $this->output->set_status_header(500, 'Validation error');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'The Record Not found']));
        }
    }


}