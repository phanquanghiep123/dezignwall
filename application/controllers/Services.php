<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Services extends CI_Controller
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
        }else if(!$this->session->userdata('user_sr_info')){
        	redirect('/');
        }
        $this->data["is_login"] = $this->is_login;
        $this->data['skins']='services';
    }
    public function index($type ="",$slug = ""){
		$this->load->model("Company_model");
	    $arg_record = array();
    	if($type == ""){$type = "services";}
		if($slug != ""){$slug = str_replace(array('-','%20'),array(' ',' '),$slug);}
		$number_items = 0;
		$business_type        = null;
		$business_description = null;
		$city                 = null; 
		$state                = null;
		$country              = null;
		$filter = array("slug" => $type);
		$recoder_type = $this->Common_model->get_record("business_categories",$filter);
		$limit = 20;
		$ofsset = 0;
		if(!$this->input->post()){
			$filter = array("pid" => $recoder_type["id"]);
			$recoder_all = $this->Common_model->get_result("business_categories",$filter);
			if($recoder_type["pid"] == 0){
				if(is_array($recoder_all)&&$recoder_all != null){
					foreach ($recoder_all AS $value){$record_slug[] = $value["slug"];}
					$business_type = $record_slug;
				}
				
			}else{
				foreach ($recoder_all AS $value){$record_slug[] = $value["title"];}
				$record_type[]        = $type;
				$business_type        = $record_type;
				if($slug != ""){ $business_description[] = $slug;}
				$ofsset = 0;
			}
			if($slug != ''){$this->data["slug"] = $slug;}
			$number_items = $this->Company_model->get_business_seach_all($business_type,$business_description,$city,$state,$country);
		    $this->data["total_rows"] = $number_items;
		    $this->data["perpage"] = 1;
		}else{
			$this->data["perpage"] = 1;
			$this->data["slug"]   = "";
			$service_search       = $this->input->post("search-service");
			$service_search       = str_replace("All Services","service",$service_search);
			$service_city         = $this->input->post("search-city");
			$service_city         = explode(",",$service_city);
			$record_slug          = array();
			$ofsset				  = ( is_numeric($this->input->post("perpage")) && $this->input->post("perpage") != ""  ) ? ($this->input->post("perpage") -1) : 0;
			if(isset($service_city[0])){$city    = $service_city[0];}
			if(isset($service_city[1])){$state   = $service_city[1];}
			if(isset($service_city[2])){$country = $service_city[2];}
			if($service_search == "Search all ".$type."" || trim($service_search) == ""){
				$filter = array("pid" => $recoder_type["id"]);
				$recoder_all = $this->Common_model->get_result("business_categories",$filter);
				if($recoder_type["pid"] == 0 ){
					foreach ($recoder_all AS $value){$record_slug[] = strtolower($value["slug"]);}
					$business_type = $record_slug;
				}else{
					foreach ($recoder_all AS $value){$record_slug[] = strtolower($value["title"]);}
					$record_type[]        = $type;
					$business_type        = $record_type;	
				}	
			}else{
				$record_slug = explode(",",$service_search);
				$record_slug = array_diff($record_slug,array(""));
				$recoder_parent = array();
				foreach ($record_slug as $key => $value) {
					$filter = array("slug" => strtolower($value));
					$recoder_type  = $this->Common_model->get_record("business_categories",$filter);
					$filter = array("pid" => $recoder_type["id"]);
				    $recoder_business_categories = $this->Common_model->get_record("business_categories",$filter);
				    if($recoder_business_categories!=null){$recoder_parent[] = $recoder_business_categories;}
				}
				if(count($recoder_parent)>0){
					$business_type = $record_slug;	
				}else{
					$record_type[]        = $type;
					$business_type        = $record_type;
					$business_description = $record_slug;
				}
			}
			$this->data["perpage"] = $ofsset + 1;
			$this->data["service_search"] = ucwords(str_replace("service","All Services",str_replace(",","",$service_search)));
			$this->data["city"]  = $city;
			$this->data["state"] = $state;
		}
		$filter = array("slug" => $type);
		$recoder_type = $this->Common_model->get_record("business_categories",$filter);
		$recoder_company = $this->Company_model->get_business_seach($business_type,$business_description,$city,$state,$country,($ofsset*$limit),$limit);
		$arg_id = array();
		foreach ($recoder_company AS $key => $value){
			$arg_record[$key]["record"][$key]["company"]  = $value;
			$filter = array("member_id" => $value["member_id"],"name !=" => null,"type" => 2);
			$arg_record[$key]["record"][$key]["photo"]	 = $this->Common_model->get_result("photos",$filter,0,6);	
			$filter = array("type_object" => "member","reference_id" => $value["member_id"]);
			$arg_record[$key]["record"][$key]["comment"] = $this->Company_model->get_comment_member($value["member_id"]);
			$filter = array("reference_id" => $value["member_id"],"type_object"=>"member","status" => 1);
			$arg_record[$key]["record"][$key]["like"] = $this->Common_model->get_result("common_like",$filter);	
			$arg_id[] = $value["id"];		
		}
		$number_items = $this->Company_model->get_business_seach_all($business_type,$business_description,$city,$state,$country);
		$this->data["total_rows"] = $number_items;
		if($this->input->post()){
			$filter = array("pid" => $recoder_type["id"]);
			$recoder_all = $this->Common_model->get_result("business_categories",$filter);
			$record_slug = array();
			if(is_array($recoder_all)&&$recoder_all != null){
				foreach ($recoder_all AS $value){$record_slug[] = $value["slug"];}
			}
			$another_services = $this->Company_model->another_services($record_slug,$business_type,$arg_id,$city,$state,$country);
			$filter = array("pid" => $recoder_type["id"]);
			$recoder_all = $this->Common_model->get_result("business_categories",$filter);
			$all_slug  = array();
			$all_title = array();
			$new_arg   = array();
			foreach ($recoder_all AS $value){$all_title[] = $value;}
			foreach($all_title AS $value_1){
				$key_i = 0;
				foreach ($another_services AS $key => $value){
					if(strtolower($value["business_type"]) == strtolower($value_1["slug"])){
						if($key_i < 3){
							$new_arg[$value_1["title"]]["record"][$key]["company"]  = $value;
							$new_arg[$value_1["title"]]["slug"]    = $value_1["slug"];
							$filter = array("member_id" => $value["member_id"],"name !=" => null,"type" => 2);
							$new_arg[$value_1["title"]]["record"][$key]["photo"]	 = $this->Common_model->get_result("photos",$filter,0,6);	
							$filter = array("type_object" => "member","reference_id" => $value["member_id"]);
							$new_arg[$value_1["title"]]["record"][$key]["comment"] = $this->Company_model->get_comment_member($value["member_id"]);
							$filter = array("reference_id" => $value["member_id"],"type_object"=>"member","status" => 1);
							$new_arg[$value_1["title"]]["record"][$key]["like"] = $this->Common_model->get_result("common_like",$filter);
							$key_i ++;
						}
					}					
				}	
			}
			$this->data["another_services"] = $new_arg;
	    }
	    $number_items = $this->Company_model->get_business_seach_all($business_type,$business_description,$city,$state,$country);
		$this->data["total_rows"] = $number_items;
		$this->data["user_id"]          = $this->user_id;
        $this->data["number_items"]     = $number_items;
		$this->data["business_type"]    = $type;
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = ucfirst($type);
		$this->data["arg_record"] = $arg_record;
        $this->load->view('block/header',$this->data);
        $this->load->view('services/index',$this->data);
        $this->load->view('block/footer',$this->data);
    }
    public function get_business_categories(){
    	if ($this->input->is_ajax_request()) {
    		$data = array();
    		if($this->input->post()){
    			$keyword       = $this->input->post("keyword");
    			$business_type = $this->input->post("business_type");
    			$this->load->model("Company_model");
				$record        = $this->Common_model->get_record("business_categories",array("slug" => trim($business_type)));
				$data_record   = $this->Company_model->get_like_business($keyword,$record["id"]);
				foreach ($data_record as $key => $value) {
					$data[] = $value["title"];
				}
				$data[] = "Search all ".$business_type."";
    			die(json_encode($data));
    			
    		}
    	}
    }
	private function get_children($record = array(),$id){
		if(is_array($record) && count($record)>0){
			foreach ($record AS $key => $value ){
				if($value["pid"] == $id){
					$this->record_get_children[] = $value["slug"];
					unset($record[$key]);
					$this->get_children($record,$value["id"]);
				}
			}
		}
		return $this->record_get_children;
	}
	
}