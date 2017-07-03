<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 2:59 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
//
require_once(APPPATH . 'core/Check_Logged.php');

class Gallery_Controller extends Check_Logged
{

    //        public $delete_cache_on_save = TRUE;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Gallery_model', 'gallery');
//        $this->load->model('Gallery_Files_Model', 'gallery_files');
        $this->load->model('File_model', 'file');

        $this->load->library(['upload', 'image_lib']);


//        if (!$this->logged) {
//            redirect(base_url('login'));
//        }
    }

    function index()
    {
        $data = $this->gallery->with_file()->get_all();
        var_dump($data);
//        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    function get_all()
    {
        $data = $this->gallery->with_file()->get_all();
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

            if (!empty($uploaded) ) {
                /*INSERT FILE DATA TO DB*/
                foreach ($uploaded as $value) {
                    $file_data['file_name'] = $value->file_name;
                    $file_data['file_type'] = $value->file_type;
                    $file_data['size'] = $value->file_size;
                    $file_data['date'] = date('Y-m-d');
                    $file_id = $this->file->insert($file_data);

                    $post_data['file_id'] = $file_id;

                    $gallery_id = $this->gallery->insert($post_data);

                    if ($gallery_id) {
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
                $this->output->set_status_header(400, 'Validation Error');
                $this->output->set_content_type('application/json')->set_output(json_encode(['validation_error' => 'Please select images.']));
            }
        }
    }

    function update($id){
        $this->form_validation->set_rules('gallery_name', 'Name', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation Error');
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors()));
        } else {
            $post_data = $this->input->post();
            $uploaded = json_decode($post_data['uploaded']);
            unset($post_data['uploaded']);
            unset($post_data['files']);

            if ($this->gallery->edit($post_data,$id)) {
                if (!empty($uploaded)) {
                    /*INSERT FILE DATA TO DB*/
                    foreach ($uploaded as $value) {
                        $file_data['file_name'] = $value->file_name;
                        $file_data['file_type'] = $value->file_type;
                        $file_data['size'] = $value->file_size;
                        $file_data['date'] = $this->input->post('date');
                        $file_id = $this->file->add($file_data);

                        $gallery_files_data['gallery_id'] = $id;
                        $gallery_files_data['file_id'] = $file_id;

                        if ($this->gallery_files->add($gallery_files_data)) {
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
                } else {
                    $this->output->set_content_type('application/json')->set_output(json_encode($post_data));
                }
            } else {
                $this->output->set_status_header(500, 'Server Down');
                $this->output->set_content_type('application/json')->set_output(json_encode(['validation_error' => 'Please select images.']));
            }
        }
    }


    function delete_image($id)
    {

        $gallery_files = $this->gallery_files->select_gl_fl_where(['gallery_files.id' => $id]);

        if ($this->file->remove($gallery_files[0]->file_id) AND $this->gallery_files->remove($gallery_files[0]->id)) {
            if (file_exists(getwdir() . 'uploads/' . $gallery_files[0]->file_name)) {
                unlink(getwdir() . 'uploads/' . $gallery_files[0]->file_name);
            }
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
        $config['file_name'] = 'G_' . rand();
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
        $gallery_files = $this->gallery_files->select_where($id);
        if ($gallery_files) {
            if (!empty($gallery_files[0]->files)) {
                foreach ($gallery_files[0]->files as $file) {
                    if ($this->gallery_files->remove($file->id)) {
                        if ($this->file->remove($file->file_id) && file_exists(getwdir() . 'uploads/' . $file->file_name)) {
                            unlink(getwdir() . 'uploads/' . $file->file_name);
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                    }
                }
                if ($status == 1) {
                    if ($this->gallery->remove($id)) {
                        $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery Deleted']));
                    }
                } elseif ($status == 0) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery not deleted but some files are deleted']));
                }

            } else {
                if ($this->gallery->remove($id)) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery Deleted']));
                } else {
                    $this->output->set_status_header(500, 'Server Down');
                    $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Delete Error']));
                }
            }
        } else {
            $this->output->set_status_header(500, 'Server Down');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'The Record Not found']));
        }
    }


}