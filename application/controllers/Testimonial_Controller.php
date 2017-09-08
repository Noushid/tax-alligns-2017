<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 2:59 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
//

class Testimonial_Controller extends CI_Controller
{

    //        public $delete_cache_on_save = TRUE;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Testimonial_model', 'testimonial');
//        $this->load->model('Gallery_Files_Model', 'testimonial_files');
        $this->load->model('File_model', 'file');

        $this->load->library(['upload', 'image_lib','ion_auth']);


        if (!$this->ion_auth->logged_in()) {
            redirect(base_url('login'));
        }
    }

    function index()
    {
        $data = $this->testimonial->with_file()->get_all();
        var_dump($data);
//        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    function get_all()
    {
        $data = $this->testimonial->with_file()->get_all();
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
            $uploaded = json_decode($post_data['uploaded']);

            unset($post_data['uploaded']);

            if (!empty($uploaded)) {
                /*INSERT FILE DATA TO DB*/
                foreach ($uploaded as $value) {
                    $file_data['file_name'] = $value->file_name;
                    $file_data['file_type'] = $value->file_type;
                    $file_data['size'] = $value->file_size;
                    $file_data['date'] = date('Y-m-d');
                    $file_id = $this->file->insert($file_data);

                    $post_data['file_id'] = $file_id;

                    $testimonial_id = $this->testimonial->insert($post_data);

                    if ($testimonial_id) {
                        /*****Create Thumb Image****/
                        $img_cfg['source_image'] = getwdir() . 'uploads/' . $value->file_name;
                        $img_cfg['maintain_ratio'] = TRUE;
                        $img_cfg['new_image'] = getwdir() . 'uploads/thumb/thumb_' . $value->file_name;
                        $img_cfg['quality'] = 99;
                        $img_cfg['master_dim'] = 'height';

                        $this->image_lib->initialize($img_cfg);
                        if (!$this->image_lib->resize()) {
                            $resize_error[] = $this->image_lib->display_errors();
                        }
                        $this->image_lib->clear();

                        /********End Thumb*********/

                        /*resize and create thumbnail image*/
                        if ($value->file_size > 1024) {
                            $img_cfg['image_library'] = 'gd2';
                            $img_cfg['source_image'] = getwdir() . 'uploads/' . $value->file_name;
                            $img_cfg['maintain_ratio'] = TRUE;
                            $img_cfg['new_image'] = getwdir() . 'uploads/' . $value->file_name;
                            $img_cfg['height'] = 500;
                            $img_cfg['quality'] = 100;
                            $img_cfg['master_dim'] = 'height';

                            $this->image_lib->initialize($img_cfg);
                            if (!$this->image_lib->resize()) {
                                $resize_error[] = $this->image_lib->display_errors();
                            }
                            $this->image_lib->clear();

                            /********End resize*********/
                        }
                    }
                    $resize_error = [];
                    if (empty($resize_error)) {
                        $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
                    } else {
//                            $this->output->set_status_header(402, 'Server Down');
                        $this->output->set_content_type('application/json')->set_output(json_encode($resize_error));
                    }
                }
            } else {
                if ($this->testimonial->insert($post_data)) {
                    $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
                }
//                $this->output->set_status_header(400, 'Validation Error');
//                $this->output->set_content_type('application/json')->set_output(json_encode(['validation_error' => 'Please select images.']));
            }
        }
    }

    function update($id){
        $this->form_validation->set_rules('name', 'Name', 'required');
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
                foreach ($uploaded as $value) {
                    $file_data['file_name'] = $value->file_name;
                    $file_data['file_type'] = $value->file_type;
                    $file_data['size'] = $value->file_size;
                    $file_data['date'] = $this->input->post('date');
                    $file_id = $this->file->insert($file_data);

                    $post_data['file_id'] = $file_id;

                    if ($this->testimonial->update($post_data,$id)) {
                        /*****Create Thumb Image****/
                        $img_cfg['source_image'] = getwdir() . 'uploads/' . $value->file_name;
                        $img_cfg['maintain_ratio'] = TRUE;
                        $img_cfg['new_image'] = getwdir() . 'uploads/thumb/thumb_' . $value->file_name;
                        $img_cfg['quality'] = 99;
                        $img_cfg['master_dim'] = 'height';

                        $this->image_lib->initialize($img_cfg);
                        if (!$this->image_lib->resize()) {
                            $resize_error[] = $this->image_lib->display_errors();
                        }
                        $this->image_lib->clear();

                        /********End Thumb*********/

                        /*resize and create thumbnail image*/
                        if ($value->file_size > 1024) {
                            $img_cfg['image_library'] = 'gd2';
                            $img_cfg['source_image'] = getwdir() . 'uploads/' . $value->file_name;
                            $img_cfg['maintain_ratio'] = TRUE;
                            $img_cfg['new_image'] = getwdir() . 'uploads/' . $value->file_name;
                            $img_cfg['height'] = 500;
                            $img_cfg['quality'] = 100;
                            $img_cfg['master_dim'] = 'height';

                            $this->image_lib->initialize($img_cfg);
                            if (!$this->image_lib->resize()) {
                                $resize_error[] = $this->image_lib->display_errors();
                            }
                            $this->image_lib->clear();

                            /********End resize*********/
                        }
                    }
                    $resize_error = [];
                    if (empty($resize_error)) {
                        $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
                    } else {
                        $this->output->set_content_type('application/json')->set_output(json_encode($resize_error));
                    }
                }
            } elseif($this->testimonial->update($post_data,$id)) {
                $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
            }else {
                $this->output->set_status_header(500, 'Server Down');
                $this->output->set_content_type('application/json')->set_output(json_encode(['validation_error' => 'Please select images.']));
            }
        }
    }


    function delete_image($id)
    {
        $testimonial = $this->testimonial->with_file()->where('file_id',$id)->get();
        if ($testimonial->file != null and $this->file->delete($testimonial->file->id)) {
            if (file_exists(getwdir() . 'uploads/' . $testimonial->file->file_name)) {
                unlink(getwdir() . 'uploads/' . $testimonial->file->file_name);
            }
            $this->testimonial->update(['file_id' => null], $testimonial->id);
            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Image Delete']));
        }else{
            $this->output->set_status_header(400, 'Server Down');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Try again later']));
        }
    }

    function upload()
    {
        $config['upload_path'] = getwdir() . 'uploads';
        $config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG';
        $config['max_size'] = 4096;
        $config['file_name'] = 'T_' . rand();
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
        $testimonial = $this->testimonial->with_file()->where('id', $id)->get();
        if ($testimonial) {
            if ($testimonial->file != null) {
                if ($this->file->delete($testimonial->file->id)) {
                    if (file_exists(getwdir() . 'uploads/' . $testimonial->file->file_name)) {
                        unlink(getwdir() . 'uploads/' . $testimonial->file->file_name);
                        if ($this->testimonial->delete($id)) {
                            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery Deleted']));
                        } else {
                            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery not deleted but some files are deleted']));
                        }
                    } else {
                        $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery file not exist in directory']));
                    }
                }
            } else {
                $this->testimonial->delete($id);
                $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery Deleted']));
            }
        } else {
            $this->output->set_status_header(500, 'Validation error');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'The Record Not found']));
        }
    }


}