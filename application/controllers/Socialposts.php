<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Socialposts extends CI_Controller
{
	private $user_id=null;
	private $user_info = null;
    private $is_login = false;
    private $data;
	public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_info')){
        	$this->is_login=true;
        	$this->user_info = $this->session->userdata('user_info');
        	$this->user_id   = $this->user_info["id"];
        }
        $this->data["is_login"] = $this->is_login;
        $this->data['skins']='services';
    }
    public function index($id){
        $record = $this->Common_model->get_record("social_posts",["id" => $id]);
        if($record == null) redirect('/');     
        $company = $this->Common_model->get_record("company",["member_id" => $record["member_id"]]);
        if($company == null) redirect('/');
        $data_share = ' <meta name="og:image" content="' . base_url($record['path']) . '">
        <meta id ="titleshare" property="og:title" content="'.$company["company_name"].' just shared social post on @Dezignwall TAKE A LOOK" />
        <meta property="og:description" content="' . $record["content"] . '" />
        <meta property="og:url" content="' . base_url("socialposts/" . $record["id"]) . '" />
        <meta property="og:image" content="' . base_url($record['path']) . '" />';
        $this->data["data_share"] = $data_share;
        $this->data["description_page"] = $record["content"];
        $this->data["title_page"] = "View social";
        $this->data["record"]      = $record;
        $this->data["company"]     = $company;
        $this->data["tracking"]    = $this->Common_model->get_record("common_tracking",["reference_id" => $id ,"type_object" => "social"]);
        $this->data["member"]      = $this->Common_model->get_record("members",["id" => $record["member_id"]]);
        $this->data["is_like"]     = $this->Common_model->get_record("common_like",["member_id" => @$this->user_id ,"reference_id" => $id,"type_object" => "social"]) == null ? null : 1;
        $this->load->view('block/header',$this->data);
        $this->load->view('socialposts/index',$this->data);
        $this->load->view('block/footer',$this->data);
    }      
}