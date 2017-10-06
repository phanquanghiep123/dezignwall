<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $user_info = null;
	
	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $is_login = $this->session->userdata('is_login');
        $data["is_login"] = true;
        $data["type_member"] = $this->session->userdata('type_member');
        $this->user_info = $this->session->userdata('user_info');
    }
    
    function logout()
    {
        $this->session->sess_destroy();
        $request = "";
        if (isset($_SERVER['QUERY_STRING'])) {
            $request = "?" . $_SERVER['QUERY_STRING'];
        }
        redirect('/' . $request);
    }

    public function get_config_paging($array_init) 
    {
        $config                = array();
        $config["base_url"]    = $array_init["base_url"];
        $config["total_rows"]  = $array_init["total_rows"];
        $config["per_page"]    = $array_init["per_page"];
        $config["uri_segment"] = $array_init["segment"];
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        return $config;
    }

    public function send_mail($email, $subject, $message, $from_email)
    {
        $this->load->library('email');
        $this->email->from($from_email, 'DEZIGNWALL, Inc.');
        $this->email->to($email);
        $this->email->set_mailtype("html");
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }
}

