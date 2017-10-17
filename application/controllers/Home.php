<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 11/5/17
 * Time: 4:47 PM
 */
defined('BASEPATH') or exit('No Direct Script Access Allowed');

class Home extends CI_Controller
{
    protected $header = 'templates/header';
    protected $footer = 'templates/footer';
    protected $slider = 'templates/slider';
    protected $allinaccounting = 'accounting/all';
    protected $bsall = 'services/bsall';
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Testimonial_model', 'testimonial');
        $this->load->model('Blog_model', 'blog');
        $this->load->model('User_model', 'user');
        $this->load->model('Message_model', 'message');
        $this->load->model('Message_file_model', 'message_file');
        $this->load->model('File_model', 'file');
        $this->load->library(['ion_auth','upload']);
        $this->load->helper(['language']);

        $this->lang->load('auth');
    }

    public function login($page = 'login')
    {
        if ($this->session->userdata('logged_in') == TRUE) {
            redirect(base_url('admin/#/'));
            return FALSE;
        }

        $this->load->view($page);
    }

    public function index($page = 'index')
    {
        $data['testimonial'] = $this->_load_testimonial();
        $data['blog'] = $this->_load_blog(3);
        $this->load->view($this->header,['current' => 'Home']);
        $this->load->view($this->slider);
        $this->load->view($page, $data);
        $this->load->view($this->footer);
    }

    public function about($page = 'about')
    {
        $this->load->view($this->header,['current' => 'About Us']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    public function practice()
    {
        $page = 'user/dashboard';
        if (!$this->ion_auth->logged_in() or $this->ion_auth->is_admin($this->session->userdata('user_id'))) {
            redirect(base_url('login'));
        } else {
            $page = $page;
            $this->config->set_item('pagination_prefix', '#filter=.inbox');
            $total_post_received = $this->message->where('user_id', $this->session->userdata('user_id'))->where('type', 'sent')->count_rows();
            $data['received'] = $this->message->where('user_id', $this->session->userdata('user_id'))->where('type', 'sent')->with_files()->with_reference()->order_by('id', 'desc')->paginate(5, $total_post_received);

            $data['all_pages_received'] = $this->message->all_pages;

            $this->config->set_item('pagination_prefix', '#filter=.sent');
            $total_post_sentitem = $this->message->where('user_id', $this->session->userdata('user_id'))->where('type', 'received')->count_rows();
            $data['sent_item'] = $this->message->where('user_id', $this->session->userdata('user_id'))->where('type', 'received')->with_files()->with_reference()->order_by('id', 'desc')->paginate(5, $total_post_sentitem);
            $data['all_pages_sentitem'] = $this->message->all_pages;

            $data['all_inbox'] = $this->message->where('user_id', $this->session->userdata('user_id'))->where('type', 'sent')->with_files()->with_reference()->order_by('id', 'desc')->get_all();

            $this->load->view($this->header,['current' => 'practice']);
            $this->load->view($page, $data);
            $this->load->view($this->footer);
        }
    }

    public function compose()
    {
        if (!$this->ion_auth->logged_in() or $this->ion_auth->is_admin($this->session->userdata('user_id'))) {
            redirect(base_url('login'), 'refresh');
            exit;
        }
        if ($this->input->post()) {
            $user_id = $this->session->userdata('user_id');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            if ($this->form_validation->run() == FALSE) {
//                var_dump(validation_errors());
                redirect(base_url('practice#filter=.sent'));
            } else {
                $error = 0;
                $config['upload_path'] = getwdir() . 'files';
                $config['allowed_types'] = 'jpg|png|jpeg|JPG|JPEG|pdf|pdf|docx|doc|xlsx|word|csv|odt|odp|ods|xml';
                $config['max_size'] = 4096;
//                $config['file_name'] = rand(100, 999) . 'FILE' . now();
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $upload_data = $this->upload->data();
                }else{
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect(base_url('practice#filter=.sent'));
                }
                if ($upload_data) {
                    $post_data = $this->input->post();
                    unset($post_data['file']);
                    $post_data['type'] = 'received';
                    $post_data['datetime'] = now();
                    $post_data['user_id'] = $user_id;
                    $message_id = $this->message->insert($post_data);

                    if ($message_id) {
                        if (!empty($upload_data)) {
                            $data = [];
                            $data['file_name'] = $upload_data['file_name'];
                            $data['file_type'] = $upload_data['file_type'];
                            $data['size'] = $upload_data['file_size'];
                            $data['path'] = $upload_data['full_path'];
                            $data['date'] = date('Y-m-d');
                            $data['url'] = base_url('uploads/') . $upload_data['file_name'];
                            $file_id = $this->file->insert($data);
                            if ($file_id) {
                                $message_file['file_id'] = $file_id;
                                $message_file['message_id'] = $message_id;
                                if (!$this->message_file->insert($message_file)) {
                                    $error = 1;
                                    $this->file->delete($file_id);
                                    $this->message->delete($message_id);
                                }
                            }
                        }
                    }
                    if ($error == 0) {
                        $this->session->set_flashdata('message', 'Message sent.');
                        redirect(base_url('practice#filter=.compose'));
                    } else {
                        $this->session->set_flashdata('error', 'Message sent.');
                        redirect(base_url('practice#filter=.compose'), 'refresh', 400);
                    }
                }
            }
        } else
            show_error('something went wrong', 500);
    }

    public function services($page = 'services')
    {
        $this->load->view($this->header,['current' => 'services']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }

    /*gst sub-menu start*/
    public function gst($page = 'gst')
    {
        $this->load->view($this->header,['current' => 'taxation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function whatisgst($page = 'whatisgst')
    {
        $this->load->view($this->header,['current' => 'taxation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gstaccounting($page = 'gstaccounting')
    {
        $this->load->view($this->header,['current' => 'taxation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gstfiling($page = 'gstfiling')
    {
        $this->load->view($this->header,['current' => 'taxation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gstinvoice($page = 'gstinvoice')
    {
        $this->load->view($this->header,['current' => 'taxation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function returns($page = 'returns')
    {
        $this->load->view($this->header,['current' => 'taxation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function tds($page = 'tds')
    {
        $this->load->view($this->header,['current' => 'taxation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    /*gst sub-menu end*/

    public function blog($id="")
    {
        if ($id != "") {
            $data['blog'] = $this->blog->where('id', $id)->with_file()->with_document()->get();
            $data['recent'] = $this->blog->with_file()->with_document()->limit(10)->order_by('id','DESC')->get_all();
            $page = 'blogView';
        }else{
            $page = 'blog';
            $total_post = $this->blog->count_rows();
            $data['blog'] = $this->blog->order_by('id', 'desc')->paginate(5, $total_post);
            $data['all_pages'] = $this->blog->all_pages;
        }

        $this->load->view($this->header,['current' => 'Our Blog']);
        $this->load->view($page, $data);
        $this->load->view($this->footer);
    }

    public function blogView($param)
    {
        $param = str_replace('-', ' ', $param);
        $data['blog'] = $this->blog->where('heading', $param)->with_file()->with_document()->get();
        $data['recent'] = $this->blog->with_file()->with_document()->limit(10)->order_by('id','DESC')->get_all();
        $this->load->view($this->header,['current' => 'Our Blog']);
        $this->load->view("blogView", $data);
        $this->load->view($this->footer);
    }

    public function contact($page = 'contact')
    {
        $this->load->view($this->header,['current' => 'Contact Us']);
        $this->load->view($page);
        // $this->load->view($this->footer);
    }

    public function _load_testimonial()
    {
        return $this->testimonial->with_file()->order_by('id','desc')->get_all();
    }

    public function _load_blog($limit ="")
    {
        if ($limit != "") {
            return $this->blog->with_file()->with_document()->limit($limit)->order_by('id','DESC')->get_all();
        } else {
            return $this->blog->with_file()->with_document()->order_by('id','desc')->get_all();
        }
    }


    function send_message()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation error');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $comments = $this->input->post('message');

            $comments = wordwrap($comments, 70, "<br>");
            $subject = 'Comments from : ' . $name;

            $message = 'name  :  ' . $name . PHP_EOL . PHP_EOL;
            $message .= 'comments from  :   ' . $email . PHP_EOL . PHP_EOL;
            $message .= 'Comments   :   ' . $comments . PHP_EOL . PHP_EOL;

            $message = str_replace("\n.", "\n..", $message);

            $to = 'info@accountsandtax.in';

            $headers = 'From: comments@accountsandtax.in';

            if (mail($to, $subject, $message, $headers)) {
                $this->output->set_output('success');
            } else {
//                $this->output->set_status_header(101, 'Mail server connect error');
                $this->output->set_output('error');
            }
        }
    }

    function send_comment()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone', 'Email', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->output->set_status_header(400, 'Validation error');
        } else {
            $name = $this->input->post('name');
            $phone = $this->input->post('phone');
            $service = $this->input->post('service');

            $service = wordwrap($service, 70, "<br>");
            $subject = 'Comments from : ' . $name;

            $message = 'name  :  ' . $name . PHP_EOL . PHP_EOL;
            $message .= 'Request from  :   ' . $phone . PHP_EOL . PHP_EOL;
            $message .= 'Requested Service   :   ' . $service . PHP_EOL . PHP_EOL;

            $message = str_replace("\n.", "\n..", $message);

            $to = 'info@accountsandtax.in';

            $headers = 'From: comments@accountsandtax.in';

            if (mail($to, $subject, $message, $headers)) {
                $this->output->set_output('success');
            } else {
                $this->output->set_status_header(101, 'Mail server connect error');
                $this->output->set_output('error');
            }
        }
    }

    public function delivered($id)
    {
        if (!$this->ion_auth->logged_in() or $this->ion_auth->is_admin($this->session->userdata('user_id'))) {
            show_error('something went wrong', 500);
            log_message('error', 'Anonymous attack from.' . $this->input->ip_address());
        }
        $data['received'] = 1;
        $data['received_time'] = now();
        if ($this->message->update($data,$id)) {
            $this->output->set_output(true);
        } else {
            log_message('error', 'Delivered function did not work.');
        }
    }

    public function encodeid($id)
    {
        $key = $this->config->item('id_enc_key');
        var_dump($key);
        var_dump(strlen($key));
        var_dump($key . '&' . $id);
        exit;
        var_dump($encode);

    }

    public function session_write()
    {
        var_dump($this->ion_auth->logged_in());
        if (!$this->ion_auth->logged_in() or $this->ion_auth->is_admin($this->session->userdata('user_id'))) {

            $request_data = 'Server protocol ->  ' . $this->input->server('SERVER_PROTOCOL').' : ';
            $request_data .= 'Request URI ->  ' . $this->input->server('REQUEST_URI');
            log_message('error', 'Anonymous attack from.' . $this->input->ip_address() . '  :  ' . $request_data);
            show_error('something went wrong', 500);
            exit;
        }
        $value = $this->input->get('filter_hash');
        $this->session->set_userdata('filter_hash', $value);
    }


    /*--------new update route start here-----*/

    public function gst1($page = 'gst/gst1')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gst2($page = 'gst/gst2')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gst3($page = 'gst/gst3')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gst4($page = 'gst/gst4')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gst5($page = 'gst/gst5')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gst6($page = 'gst/gst6')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gst7($page = 'gst/gst7')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gst8($page = 'gst/gst8')
    {
        $this->load->view($this->header,['current' => 'GST']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    // Accounting
    public function accounting1($page = 'accounting/accounting1')
    {
        $this->load->view($this->header,['current' => 'Accounting']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function accounting2($page = 'accounting/accounting2')
    {
        $this->load->view($this->header,['current' => 'Accounting']);
        $this->load->view($page);
        $this->load->view($this->allinaccounting);
        $this->load->view($this->footer);
    }
    public function accounting3($page = 'accounting/accounting3')
    {
        $this->load->view($this->header,['current' => 'Accounting']);
        $this->load->view($page);
        $this->load->view($this->allinaccounting);
        $this->load->view($this->footer);
    }
    public function accounting4($page = 'accounting/accounting4')
    {
        $this->load->view($this->header,['current' => 'Accounting']);
        $this->load->view($page);
        $this->load->view($this->allinaccounting);
        $this->load->view($this->footer);
    }
    public function accounting5($page = 'accounting/accounting5')
    {
        $this->load->view($this->header,['current' => 'Accounting']);
        $this->load->view($page);
        $this->load->view($this->allinaccounting);
        $this->load->view($this->footer);
    }
    public function accounting6($page = 'accounting/accounting6')
    {
        $this->load->view($this->header,['current' => 'Accounting']);
        $this->load->view($page);
        $this->load->view($this->allinaccounting);
        $this->load->view($this->footer);
    }
    //INCOME TAX
    public function it1($page = 'incometax/it1')
    {
        $this->load->view($this->header,['current' => 'IT']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function it2($page = 'incometax/it2')
    {
        $this->load->view($this->header,['current' => 'IT']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function it3($page = 'incometax/it3')
    {
        $this->load->view($this->header,['current' => 'IT']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function it4($page = 'incometax/it4')
    {
        $this->load->view($this->header,['current' => 'IT']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function it5($page = 'incometax/it5')
    {
        $this->load->view($this->header,['current' => 'IT']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function it6($page = 'incometax/it6')
    {
        $this->load->view($this->header,['current' => 'IT']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function it7($page = 'incometax/it7')
    {
        $this->load->view($this->header,['current' => 'IT']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function it8($page = 'incometax/it8')
    {
        $this->load->view($this->header,['current' => 'IT']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    // START A BUSINESS
    public function business1($page = 'services/bs1')
    {
        $this->load->view($this->header,['current' => 'StartUp']);
        $this->load->view($page);
        $this->load->view($this->bsall);
        $this->load->view($this->footer);
    }
    public function business2($page = 'services/bs2')
    {
        $this->load->view($this->header,['current' => 'StartUp']);
        $this->load->view($page);
        $this->load->view($this->bsall);
        $this->load->view($this->footer);
    }
    public function business3($page = 'services/bs3')
    {
        $this->load->view($this->header,['current' => 'StartUp']);
        $this->load->view($page);
        $this->load->view($this->bsall);
        $this->load->view($this->footer);
    }
    public function business4($page = 'services/bs4')
    {
        $this->load->view($this->header,['current' => 'StartUp']);
        $this->load->view($page);
        $this->load->view($this->bsall);
        $this->load->view($this->footer);
    }
    public function business5($page = 'services/bs5')
    {
        $this->load->view($this->header,['current' => 'StartUp']);
        $this->load->view($page);
        $this->load->view($this->bsall);
        $this->load->view($this->footer);
    }
    public function business6($page = 'services/bs6')
    {
        $this->load->view($this->header,['current' => 'StartUp']);
        $this->load->view($page);
        $this->load->view($this->bsall);
        $this->load->view($this->footer);
    }
    public function business7($page = 'services/bs7')
    {
        $this->load->view($this->header,['current' => 'StartUp']);
        $this->load->view($page);
        $this->load->view($this->bsall);
        $this->load->view($this->footer);
    }
    public function business8($page = 'services/bs8')
    {
        $this->load->view($this->header,['current' => 'StartUp']);
        $this->load->view($page);
        $this->load->view($this->bsall);
        $this->load->view($this->footer);
    }
    //DOCUMENTATION
    public function documentation1($page = 'services/doc1')
    {
        $this->load->view($this->header,['current' => 'Documentation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function documentation2($page = 'services/doc2')
    {
        $this->load->view($this->header,['current' => 'Documentation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function documentation3($page = 'services/doc3')
    {
        $this->load->view($this->header,['current' => 'Documentation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function documentation4($page = 'services/doc4')
    {
        $this->load->view($this->header,['current' => 'Documentation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function documentation5($page = 'services/doc5')
    {
        $this->load->view($this->header,['current' => 'Documentation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function documentation6($page = 'services/doc6')
    {
        $this->load->view($this->header,['current' => 'Documentation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function documentation7($page = 'services/doc7')
    {
        $this->load->view($this->header,['current' => 'Documentation']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    // CUNSULTING
    public function cunsolting1($page = 'services/con1')
    {
        $this->load->view($this->header,['current' => 'Cunsolting']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function cunsolting2($page = 'services/con2')
    {
        $this->load->view($this->header,['current' => 'Cunsolting']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function cunsolting3($page = 'services/con3')
    {
        $this->load->view($this->header,['current' => 'Cunsolting']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function cunsolting4($page = 'services/con4')
    {
        $this->load->view($this->header,['current' => 'Cunsolting']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    //REGISTRATION
    public function registration1($page = 'services/reg1')
    {
        $this->load->view($this->header,['current' => 'Registration']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function registration2($page = 'services/reg2')
    {
        $this->load->view($this->header,['current' => 'Registration']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function registration3($page = 'services/reg3')
    {
        $this->load->view($this->header,['current' => 'Registration']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function registration4($page = 'services/reg4')
    {
        $this->load->view($this->header,['current' => 'Registration']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function registration5($page = 'services/reg5')
    {
        $this->load->view($this->header,['current' => 'Registration']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    // UAE
    public function uae1($page = 'uae/uae1')
    {
        $this->load->view($this->header,['current' => 'UAE']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function uae2($page = 'uae/uae2')
    {
        $this->load->view($this->header,['current' => 'UAE']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function uae3($page = 'uae/uae3')
    {
        $this->load->view($this->header,['current' => 'UAE']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function uae4($page = 'uae/uae4')
    {
        $this->load->view($this->header,['current' => 'UAE']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function uae5($page = 'uae/uae5')
    {
        $this->load->view($this->header,['current' => 'UAE']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function uae6($page = 'uae/uae6')
    {
        $this->load->view($this->header,['current' => 'UAE']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function uae7($page = 'uae/uae7')
    {
        $this->load->view($this->header,['current' => 'UAE']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function uae8($page = 'uae/uae8')
    {
        $this->load->view($this->header,['current' => 'UAE']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function uae9($page = 'uae/uae9')
    {
        $this->load->view($this->header,['current' => 'UAE']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function uae10($page = 'uae/uae10')
    {
        $this->load->view($this->header,['current' => 'UAE']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    // KSA
    public function ksa1($page = 'ksa/ksa1')
    {
        $this->load->view($this->header,['current' => 'KSA']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function ksa2($page = 'ksa/ksa2')
    {
        $this->load->view($this->header,['current' => 'KSA']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function ksa3($page = 'ksa/ksa3')
    {
        $this->load->view($this->header,['current' => 'KSA']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function ksa4($page = 'ksa/ksa4')
    {
        $this->load->view($this->header,['current' => 'KSA']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    // GCC
    public function gcc1($page = 'gcc/gcc1')
    {
        $this->load->view($this->header,['current' => 'GCC']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    public function gcc2($page = 'gcc/gcc2')
    {
        $this->load->view($this->header,['current' => 'GCC']);
        $this->load->view($page);
        $this->load->view($this->footer);
    }
    /*--------new update route end here-----*/
}