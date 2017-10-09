<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Photographer extends CI_Controller
{
	private $user_id=null;
	private $user_info = null;
    private $is_login = false;
    private $data;
	private $record_get_children = array();
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
    public function index($slug = ""){
		$this->load->model("Company_model");
	    $arg_record = array();
    	$type = "photographer";
    	$this->data["slug"]   = $slug;
		$number_items = 0;
		$business_type        = null;
		$business_description = null;
		$city                 = null; 
		$state                = null;
		$country              = null;
		$limit = 20;
		$ofsset = 0;
		$filter = array("slug" => $type);
		$recoder_type = $this->Common_model->get_record("business_categories",$filter);
		if(!$this->input->post() ){
	    	if($slug == null){
				if($recoder_type["pid"] == 0){ $business_type[] = $type ;}
	    	}else{
	    		$filter      = array("pid" => $recoder_type["id"]);
				$recoder_all = $this->Common_model->get_result("business_categories",$filter);
				$slug        = str_replace("-","/",$slug);
				$business_description[] = $slug;
	    	}
	    	$this->data["perpage"] = 1;
    	}else{
			$service_search       = $this->input->post("search-service");
			$service_search       = str_replace("All Services","service",$service_search);
			$service_city         = $this->input->post("search-city");
			$service_city         = explode(",",$service_city);
			$record_slug          = array();
			$ofsset				  = ( is_numeric($this->input->post("perpage")) && $this->input->post("perpage") != ""  ) ? ($this->input->post("perpage") -1) : 0;
			if(isset($service_city[0])){$city    = $service_city[0];}
			if(isset($service_city[1])){$state   = $service_city[1];}
			if(isset($service_city[2])){$country = $service_city[2];}
			if($service_search == "" || $service_search == "Search all ".$type.""){
				$business_type[] = $type ;
			}else{
				$business_description = explode(",",$service_search);
			}
			$this->data["perpage"] = $ofsset + 1;
			$this->data["city"] = $this->input->post("search-city") ;
    	}
    	$recoder_company = $this->Company_model->get_business_seach($business_type,$business_description,$city,$state,$country,($ofsset*$limit),$limit);
    	foreach ($recoder_company AS $key => $value){
			$arg_record[$key]["record"][$key]["company"]  = $value;
			$filter = array("member_id" => $value["member_id"]);
			$arg_record[$key]["record"][$key]["photo"]	 = $this->Common_model->get_result("photos",$filter,0,6);	
			$filter = array("type_object" => "member","reference_id" => $value["member_id"]);
			$arg_record[$key]["record"][$key]["comment"] = $this->Company_model->get_comment_member($value["member_id"]);
			$filter = array("reference_id" => $value["member_id"],"type_object"=>"member","status" => 1);
			$arg_record[$key]["record"][$key]["like"] = $this->Common_model->get_result("common_like",$filter);				
		}
		$this->data["user_id"]    = $this->user_id;
		$this->data["total_rows"] =  $this->data["number_items"] = $this->Company_model->get_business_seach_all($business_type,$business_description,$city,$state,$country);
		$this->data["arg_record"] = $arg_record;
		$this->data["business_type"] = $type;
		$this->data["title_page"] = ucfirst($type);
        $this->load->view('block/header',$this->data);
        $this->load->view('services/index',$this->data);
        $this->load->view('block/footer',$this->data);

    }
}