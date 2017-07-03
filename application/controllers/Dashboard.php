<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 12:58 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'core/Check_Logged.php');

class Dashboard extends Check_Logged
{
    public function __construct()
    {
        parent::__construct();

        /*
         * Check loin and logout
         * */
//        $this->load->model('Users_Model', 'user');


//        if ( ! $this->logged)
//        {
//            // Allow some methods?
//            $allowed = array(
//                'verify'
//            );
//            if ( ! in_array($this->router->fetch_method(), $allowed))
//            {
//                redirect(base_url('login'));
//            }
//        }
    }


    public function generate_key($str)
    {
        var_dump(hash('sha256', $str));
    }

//////////////////////////////////////////////

    public function index()
    {
        $this->load->view('admin/index');
    }

    public function dashboard()
    {
        $this->load->view('admin/dashboard');
    }

    public function testimonial()
    {
        $this->load->view('admin/testimonial');
    }

    public function blog()
    {
        $this->load->view('admin/blog');
    }

    public function document()
    {
        $this->load->view('admin/document');
    }


    public function verify()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->output->set_status_header(400, 'Validation error');
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors()));
        } else {
            $username = $this->input->post('username');
            $password = hash('sha256', $this->input->post('password'));
            $where = [
                'username' => $username,
                'password' => $password
            ];
            $result = $this->user->get($where);
            if ($result) {
                $login_data = [
                    'username' => $result[0]->username,
                    'logged' => true,
                ];
                $this->session->set_userdata('logged_in', $login_data);
                $this->output->set_content_type('application/json')->set_output(json_encode($login_data));
            } else {
                $this->output->set_status_header(400, 'Unauthorised access');
                $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'invalid username or password']));
            }
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect(base_url('login'), 'refresh');
    }

    public function change_profile()
    {
        $data['username'] = $this->session->logged_in['username'];
        $this->load->view('admin/user_profile',$data);
    }

    public function edit_profile()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('curpassword', 'Current password', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirmpassword', 'Password', 'required|matches[password]');
        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation error');
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors()));
        } else {
            $cur_user = $this->session->logged_in['username'];
            $cur_pass = hash('sha256', $this->input->post('curpassword'));

            $data['username'] = $this->input->post('username');
            $data['password'] = hash('sha256', $this->input->post('password'));
            $where = [
                'username' => $cur_user,
                'password' => $cur_pass,
            ];
            if ($result = $this->user->get($where)) {
                $id = $result[0]->id;
                if ($edit = $this->user->edit($data, $id)) {
                    $_SESSION['logged_in']['username'] = $data['username'];
                    $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Username and password changed']));
                }
            }else{
                $this->output->set_status_header(400, 'Validation error');
                $error['msg'] = 'Current username and password did not match';
                $this->output->set_content_type('application/json')->set_output(json_encode($error));
            }
        }
    }

    public function get_user()
    {
        $user = $this->session->logged_in;
        $this->output->set_content_type('application/json')->set_output(json_encode($user));
    }

    public function thumbnail_check()
    {
        $resize_error = [];
        $uploads = $this->_list_files(getwdir() . 'uploads');
        $upload_count = sizeof($uploads);
        $thumbs = $this->_list_files(getwdir() . 'uploads/thumb');
        $thumbs_count = sizeof($thumbs);
        if ($thumbs_count > $upload_count) {
            $temp = $thumbs;
            foreach ($temp as $key => $value) {
                $temp[$key] = str_replace('thumb_', '', $value);
            }
            $diff = array_diff($temp, $uploads);
            if (!empty($diff)) {
                foreach ($diff as $value) {
                    if (file_exists(getwdir() . '/uploads/thumb/thumb_' . $value)) {
                        unlink(getwdir() . 'uploads/thumb/thumb_' . $value);
                    }
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'thumbnail refresh complete']));
        } elseif ($thumbs_count < $upload_count) {

            $temp = $thumbs;
            foreach ($temp as $key => $value) {
                $temp[$key] = str_replace('thumb_', '', $value);
            }
            $diff = array_diff($uploads, $temp);
            if (!empty($diff)) {
                foreach ($diff as $image) {
                    $img_cfg['image_library'] = 'gd2';
                    $img_cfg['maintain_ratio'] = TRUE;
                    $img_cfg['height'] = 300;
                    $img_cfg['width'] = 300;
                    $img_cfg['quality'] = 80;
                    $img_cfg['master_dim'] = 'height';
                    $img_cfg['source_image'] = realpath(getwdir() . 'uploads/' . $image);
                    $img_cfg['new_image'] = getwdir() . 'uploads/thumb/thumb_' . $image;
                    $this->image_lib->initialize($img_cfg);
//                    list($width, $height, $type) = getimagesize(getwdir() . '/uploads/' . $image);
                    if (!$this->image_lib->resize()) {
                        array_push($resize_error, $this->image_lib->display_errors());
                    }
                    $this->image_lib->clear();
                }
            }
            if (empty($resize_error)) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'thumbnail refresh complete']));
            }else{
                $this->output->set_status_header(500, 'Server Down');
                $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'please refresh page']));
            }

        } else {
            $temp = $thumbs;
            foreach ($temp as $key => $value) {
                $temp[$key] = str_replace('thumb_', '', $value);
            }
            if ($diff_temp = array_diff($temp, $uploads)) {
                foreach ($diff_temp as $image) {
                    if (file_exists(getwdir() . '/uploads/thumb/thumb_' . $image)) {
                        unlink(getwdir() . '/uploads/thumb/thumb_' . $image);
                    }
                }
                $this->thumbnail_check();
            }
        }
    }


    /**
     * @param directory
     * @return array files
     */
    function _list_files($dir)
    {
        $files = [];
        if ($handle = opendir($dir)) {
            $count = 0;
            while (false !== ($images = readdir($handle))) {

                if ($images != "." && $images != "..") {
                    if (is_file($dir."/".$images)) {
                        $count++;
                        array_push($files, $images);
                    }
                }
            }
            closedir($handle);
            return $files;
        }
    }

}
