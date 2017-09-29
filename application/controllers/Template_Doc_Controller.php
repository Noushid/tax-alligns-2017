<?php
/**
 * Template_Doc_Controller.php
 * User: psybo-03
 * Date: 29/9/17
 * Time: 12:18 PM
 */


defined('BASEPATH') OR exit('No direct script access allowed');
//

class Template_Doc_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Excel_Template_model', 'template');
        $this->load->model('File_model', 'file');

        $this->load->library(['upload', 'image_lib','ion_auth']);


        if (!$this->ion_auth->logged_in()) {
            redirect(base_url('login'));
        }
    }

    function index()
    {
        $data = $this->template->with_file()->get_all();
        var_dump($data);
//        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    function get_all()
    {
        $data = $this->template->with_file()->get_all();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function store()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation Error');
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors()));
        } else {
            $post_data = $this->input->post();
            $post_data['active'] = 1;
            $uploaded = json_decode($post_data['uploaded']);

            unset($post_data['uploaded']);

            if (!empty($uploaded)) {
                /*INSERT FILE DATA TO DB*/
                $file_data['file_name'] = $uploaded->file_name;
                $file_data['file_type'] = $uploaded->file_type;
                $file_data['size'] = $uploaded->file_size;
                $file_data['date'] = date('Y-m-d');
                $file_id = $this->file->insert($file_data);

                $post_data['file_id'] = $file_id;

                if ($this->template->insert($post_data)) {
                    $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
                } else {
                    $this->output->set_status_header(500, 'Server Down');
                    $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Server Down']));
                }
            } else {
                $this->output->set_status_header(400, 'Validation Error');
                $this->output->set_content_type('application/json')->set_output(json_encode(['validation_error' => 'Please select images.']));
            }
        }
    }

    function update($id){
        $this->form_validation->set_rules('name', 'Heading', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation Error');
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors()));
        } else {
            $post_data = $this->input->post();
            $uploaded = json_decode($post_data['uploaded']);

            unset($post_data['uploaded']);
            unset($post_data['file']);

            if (!empty($uploaded)) {
                /*INSERT FILE DATA TO DB*/
                $file_data['file_name'] = $uploaded->file_name;
                $file_data['file_type'] = $uploaded->file_type;
                $file_data['size'] = $uploaded->file_size;
                $file_data['date'] = $this->input->post('date');
                $file_id = $this->file->insert($file_data);

                $post_data['file_id'] = $file_id;

                if ($this->template->update($post_data,$id)) {
                    $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
                } else {
                    $this->file->delete($file_id);
                    $this->output->set_status_header(400, 'Server Down');
                    $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'server down']));
                }
            }else {
                $this->template->update($post_data, $id);
                $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
            }
        }
    }


    function delete_image($id)
    {
        $template = $this->template->with_file()->where('file_id',$id)->get();
        if ($template->file != null and $this->file->delete($template->file->id)) {
            if (file_exists(getwdir() . 'files/' . $template->file->file_name)) {
                unlink(getwdir() . 'files/' . $template->file->file_name);
            }
            $this->template->update(['file_id' => null], $template->id);
            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Image Delete']));
        }else{
            $this->output->set_status_header(400, 'Server Down');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Try again later']));
        }
    }

    function upload()
    {
        $config['upload_path'] = getwdir() . 'files';
        $config['allowed_types'] = 'docx|doc|xlsx|word|csv|odt|odp|ods|xml';
        $config['max_size'] = 4096;
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $this->output->set_content_type('application/json')->set_output(json_encode($this->upload->data()));
        }else{
            $this->output->set_status_header(401, 'File Upload Error');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' =>$this->upload->display_errors('', '')]));
        }
    }



    public function delete($id)
    {
        $template = $this->template->with_file()->where('id', $id)->get();
        if ($template) {
            if ($template->file != null) {
                if ($this->file->delete($template->file->id)) {
                    if (file_exists(getwdir() . 'files/' . $template->file->file_name)) {
                        unlink(getwdir() . 'files/' . $template->file->file_name);
                        if ($this->template->delete($id)) {
                            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery Deleted']));
                        } else {
                            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery not deleted but some files are deleted']));
                        }
                    } else {
                        $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery file not exist in directory']));
                    }
                }
            } else {
                $this->template->delete($id);
                $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery Deleted']));
            }
        } else {
            $this->output->set_status_header(500, 'Validation error');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'The Record Not found']));
        }
    }

    public function enable($id)
    {
        if ($this->template->update(['active' => 1],$id)) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Enabled']));
        } else {
            $this->output->set_status_header(500, 'Server error');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'The Record Not found']));
        }
    }

    public function disable($id)
    {
        if ($this->template->update(['active' => 0],$id)) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Disabled']));
        } else {
            $this->output->set_status_header(500, 'Server error');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'The Record Not found']));
        }
    }

}