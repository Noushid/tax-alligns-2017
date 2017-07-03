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

class Blog_Controller extends Check_Logged
{

    //        public $delete_cache_on_save = TRUE;
    function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model', 'blog');
//        $this->load->model('Gallery_Files_Model', 'blog_files');
        $this->load->model('File_model', 'file');

        $this->load->library(['upload', 'image_lib']);


//        if (!$this->logged) {
//            redirect(base_url('login'));
//        }
    }

    function index()
    {
        $data = $this->blog->with_file()->get_all();
        var_dump($data);
//        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    function get_all()
    {
        $data = $this->blog->with_file()->get_all();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function store()
    {
        $this->form_validation->set_rules('heading', 'Name', 'required');
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

                    $blog_id = $this->blog->insert($post_data);

                    if ($blog_id) {
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
        $this->form_validation->set_rules('heading', 'Heading', 'required');
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

                    if ($this->blog->update($post_data,$id)) {
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
            }else {
                $this->output->set_status_header(500, 'Server Down');
                $this->output->set_content_type('application/json')->set_output(json_encode(['validation_error' => 'Please select images.']));
            }
        }
    }


    function delete_image($id)
    {
        $blog = $this->blog->with_file()->where('file_id',$id)->get();
        if ($blog->file != null and $this->file->delete($blog->file->id)) {
            if (file_exists(getwdir() . 'uploads/' . $blog->file->file_name)) {
                unlink(getwdir() . 'uploads/' . $blog->file->file_name);
            }
            $this->blog->update(['file_id' => null], $blog->id);
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
        $config['file_name'] = 'B_' . rand();
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
        $blog = $this->blog->with_file()->where('id', $id)->get();
        if ($blog) {
            if ($blog->file != null) {
                if ($this->file->delete($blog->file->id)) {
                    if (file_exists(getwdir() . 'uploads/' . $blog->file->file_name)) {
                        unlink(getwdir() . 'uploads/' . $blog->file->file_name);
                        if ($this->blog->delete($id)) {
                            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery Deleted']));
                        } else {
                            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery not deleted but some files are deleted']));
                        }
                    } else {
                        $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery file not exist in directory']));
                    }
                }
            } else {
                $this->blog->delete($id);
                $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Gallery Deleted']));
            }
        } else {
            $this->output->set_status_header(500, 'Validation error');
            $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'The Record Not found']));
        }
    }


}