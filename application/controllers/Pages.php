<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Pages extends CI_Controller
{
	private $user_id=null;
	private $user_info = null;
    private $is_login = false;
    
	public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_info')){
        	$this->is_login=true;
        	$this->user_info = $this->session->userdata('user_info');
        	$this->user_id   = $this->user_info["id"];
        }
        $this->data["is_login"] = $this->is_login;
        $this->data['skins']='pages';
    }
    
    public function index($slug = "") {
    	// Get page from db
    	$result_page = $this->Common_model->get_record("post",array("slug" => $slug));
    	
    	if ($result_page == null) {
			if (!file_exists(APPPATH . '/views/pages/' . $slug . '.php')) {
	            // Whoops, we don't have a page for that!
	            // show_404();
                redirect('/');
	        }
	        $this->data["title_page"] = str_replace("-", ' ', ucfirst($slug));
        } else {
        	$slug = 'index';
        	$this->data["title_page"] = $result_page['title'];
        	$this->data["content"] = $result_page['content'];
        }
        
		$this->data["user_id"] = $this->user_id;
        $this->data["is_login"] = $this->is_login;
        $this->load->view('block/header',$this->data);
        $this->load->view('pages/'.$slug,$this->data);
        $this->load->view('block/footer',$this->data);
    }

    public function contact()
    {
        if (isset($_POST) && $_POST != null) {
            $email   = $this->input->post('email');
            $name    = $this->input->post('name');
            $phone   = $this->input->post('phone');
            $country = $this->input->post("country");
            $subject = 'Contact Us';
            $address = $this->input->post('address');
            $message = "Name: " . $name . '<br/>';
            if (isset($phone)) {
                $message .= "Phone: " . $phone . "<br/>";
            }
            if (isset($address)) {
                $message .= "Address: " . $address . "<br/>";
            }
            if (isset($email)) {
                $email .= "Email: " . $email . "<br/>";
            }
            if (isset($country)) {
                $country .= "Country: " . $country . "<br/>";
            }
            $message .= "Message:" . $this->input->post('message');       
            if ($this->input->post('subject') != null) {
                $subject = $this->input->post('subject');
            }
            $mail_subject = $subject;
      			$mail_content = $message;
      			$mail_to = 'info@dezignwall.com';
      			sendmail($mail_to, $mail_subject, $mail_content);
            if($this->input->post("email")){
                $mail_to = $this->input->post("email");
                sendmail($mail_to, $mail_subject, $mail_content);
            }
            $data['message'] = "Email sent successfully.";
            $this->session->set_flashdata('success', 'Email sent successfully.');
        }
        else{
             $this->session->set_flashdata('error', 'Email sent error.');
        }
        redirect('/page/contact');
    }
    
}