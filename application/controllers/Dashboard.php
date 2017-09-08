<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 1/7/17
 * Time: 12:58 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library(['ion_auth']);
        $this->load->helper(['url', 'language']);

        /**
         * Check loin
         *
         */
        if (!$this->ion_auth->logged_in())
        {
            // Allow some methods?
            $allowed = array(
                'verify',
                'generate_key'
            );
            if ( ! in_array($this->router->fetch_method(), $allowed))
            {
                redirect(base_url('login'));
            }
            // redirect them to the login page
            redirect('login', 'refresh');
        }
    }


    public function generate_key($str)
    {
        var_dump(hash('sha256', $str));
    }

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

    public function users()
    {
        $this->load->view('admin/users');
    }

    public function message()
    {
        $this->load->view('admin/messages');
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
            $result = $this->user->where($where)->get_all();
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
        $data['user_id'] = $this->session->user_id;
        $this->load->view('admin/user_profile',$data);
    }

    public function edit_user($id="")
    {

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect(base_url('login'), 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups=$this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        // validate form input
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_rules('curpassword', 'Current password', 'required');
        $this->form_validation->set_rules('confirmpassword', 'Confirm password', 'required');

        if (isset($_POST) && !empty($_POST))
        {
            /*// do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            {
                var_dump('csrf error');
//                show_error($this->lang->line('error_csrf'));
            }else{
                var_dump('csrf ssuce');
                exit;
            }*/



            // update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', 'Password', 'required|matches[confirmpassword]');
                $this->form_validation->set_rules('confirmpassword', 'Password', 'required');
            }

            if ($this->form_validation->run() === TRUE)
            {
                if ($this->ion_auth->hash_password_db($user->id,$this->input->post('curpassword')) == FALSE) {
                    $this->output->set_status_header(400, 'Validation error');
                    $json_data['cur_password'] = 0;
                    $json_data['error'] = 'Current password can\'t match!';

                    $this->output->set_content_type('application/json')->set_output(json_encode($json_data));
                }else {

                    $data = array(
                        'username' => $this->input->post('username'),
                    );
                    if ($this->input->post('email')) {
                        $data['email'] = $this->input->post('email');
                    }

                    // update the password if it was posted
                    if ($this->input->post('password')) {
                        $data['password'] = $this->input->post('password');
                    }

                    // check to see if we are updating the user
                    if ($this->ion_auth->update($id, $data)) {
                        // redirect them back to the admin page if admin, or to the base url if non admin
                        $this->session->set_flashdata('message', $this->ion_auth->messages());


                        if ($this->ion_auth->is_admin()) {
                            $this->session->set_userdata('identity', $user->username);
                            $this->session->set_userdata('email', $user->email);
                            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Username and password changed']));
                        } else {
                            $this->session->set_userdata('identity', $user->username);
                            $this->session->set_userdata('email', $user->email);
                            $this->output->set_content_type('application/json')->set_output(json_encode(['msg' => 'Username and password changed']));
                        }
                    } else {
                        // redirect them back to the admin page if admin, or to the base url if non admin
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        $this->output->set_status_header(400, 'Server Down');
                        $this->output->set_content_type('application/json')->set_output(json_encode(['error' => $this->ion_auth->errors()]));
                    }
                }
            }else{
                $this->output->set_status_header(400, 'Validation error');
                $this->output->set_content_type('application/json')->set_output(json_encode(['hierror' => validation_errors()]));
            }

        }else {

            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();

            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            // pass the user to the view
            $this->data['user'] = $user;
            $this->data['groups'] = $groups;
            $this->data['currentGroups'] = $currentGroups;

            $this->data['user_id'] = $this->session->user_id;
            $this->load->view('admin/user_profile', $this->data);
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

    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_tempdata('csrfkey', $key, 300);
        $this->session->set_tempdata('csrfvalue', $value, 300);

        return array($key => $value);
    }

    public function _valid_csrf_nonce()
    {
        $csrfkey = $this->input->post($this->session->tempdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->tempdata('csrfvalue'))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
