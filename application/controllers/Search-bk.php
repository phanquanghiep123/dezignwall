<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search extends CI_Controller {
	public  $user_id   = 0;
	public  $data;
	private $user_info = null;
    private $is_login  = false;
	public function __construct(){
        parent::__construct();
        $this->data["type_member"] = 0;
        if($this->session->userdata('user_info')){
        	$this->is_login  = true;
        	$this->user_info = $this->session->userdata('user_info');
        	$this->user_id   = $this->user_info["id"];
        	$this->data["type_member"] = $this->user_info["type_member"];
        }
        $this->data["is_login"] = $this->is_login;
    }
	public function index($type = "",$slug = "")
	{   
	    if($type == "projects"){
			$this->project($slug);
			return;
		}elseif($type == "products"){
			$this->product($slug);
			return;
		}elseif($slug == ""){$slug = $type;}{
			$this->data['keyword']       = "";
			$this->data['all_category']  = "";
			$this->data['class_control'] = "seach_page_total";
			$this->data['slug']          = $slug;
			$all_category="";
			$this->load->model("Photo_model");
			$this->data["id_photo_show"] = "";
			if($this->input->get()){
				$this->data['keyword']      = $this->input->get("keyword");
				$this->data['all_category'] = $this->input->get("all_category");
				$this->data['all_category'] = str_replace("%2C",",",$this->data['all_category']);
				$this->data['keyword']      = preg_replace('/[^A-Za-z0-9\- ]/', '',$this->data['keyword']);
				$all_category               = "";
				$category_post				= $this->data['all_category'];
				if(trim($category_post) != ""){
					$all_category  = explode(",",$this->data['all_category']);
				}
				if($this->data['keyword'] == "" && $this->data['all_category'] == ""&& $slug ==""){
					$query_photo = $this->Photo_model->search_index($this->user_id,21,"",$slug);
				}else{
					$query_photo = $this->Photo_model->seach_photo($this->user_id,$this->data['keyword'], $all_category,"",0,21,$slug) ;
				}
				$this->data['all_category'] = $this->data['all_category'].",";
			}else{ 
				$query_photo = $this->Photo_model->search_index($this->user_id,21,"",$slug);
			}
			$photo_id="";
			if(isset($query_photo)&&count($query_photo)>0){
				foreach ($query_photo as $value) {
					$photo_id[]= $value["photo_id"];
					if(!$this->input->get()||($this->data['keyword'] == "" && $this->data['all_category'] == "" && $slug =="") ){
						$this->data["id_photo_show"].= $value["photo_id"].",";
					}  
				}
			}
			$this->data["title_page"] ="Seach Page";
			$this->data["view_wrapper"] = "seach/index";
			$query_comment = $this->Photo_model->get_comment_photobyid($photo_id);
			$recorder = array();
			if(isset($query_photo)&&count($query_photo)>0){
				foreach ($query_photo as $key => $value) {
					foreach ($query_comment as $key => $value_2) {
						if($value["photo_id"] == $value_2["reference_id"]){
							$value["comment_photo"][] = $value_2;
							unset($query_comment[$key]);
						}
					}
					$recorder[]= $value;
				}
			}
			$this->data["class_wrapper"] = "seach_page";
			$this->data["data_wrapper"]["photo"] = $recorder;
			$this->data["photo_count"] = $this->Photo_model->total_page($this->data['keyword'],$all_category,"",$slug);
			$this->load->view('block/header',$this->data);
			$this->load->view('block/wrapper',$this->data);
			$this->load->view('block/footer',$this->data);
			return;
		}
	}
    private function  project($slug  = ""){
    	$this->data['slug']          = $slug;
        $this->data['class_control'] = "seach_page_total";
        $this->data["type_photo"]    = "Projects";
        $this->data["title_page"]    = "Seach Page Projects";
        $this->data["view_wrapper"]  = "seach/index";
        $this->load->model("Photo_model");
        $query_photo = $this->Photo_model->search_index($this->user_id,21,"Projects",$slug);
        $photo_id="";
        $this->data["id_photo_show"] = "";
        if(isset($query_photo)&&count($query_photo)>0){
	        foreach ($query_photo as $value) {
	            $photo_id[]= $value["photo_id"];
	            $this->data["id_photo_show"].= $value["photo_id"].",";  
	        }
	    }
        $query_comment = $this->Photo_model->get_comment_photobyid($photo_id);
        $recorder = array();
        if(isset($query_photo)&&count($query_photo)>0){
	        foreach ($query_photo as $key => $value) {
	            foreach ($query_comment as $key => $value_2) {
	                if($value["photo_id"] == $value_2["reference_id"]){
	                    $value["comment_photo"][] = $value_2;
	                    unset($query_comment[$key]);
	                }
	            }
	            $recorder[]= $value;
	        }
    	}
        $this->data["class_wrapper"] = "seach_page";
        $this->data["data_wrapper"]["photo"] = $recorder;
        $this->data["photo_count"] = $this->Photo_model->total_page("","","Projects",$slug);
        $this->load->view('block/header',$this->data);
        $this->load->view('block/wrapper',$this->data);
        $this->load->view('block/footer',$this->data);
    }
    private function  product($slug  = ""){
    	$this->data['slug']          = $slug;
        $this->data['class_control'] = "seach_page_total";
        $this->data["type_photo"]    ="Products";
        $this->data["title_page"]    ="Seach Page Products";
        $this->data["view_wrapper"]  = "seach/index";
        $this->load->model("Photo_model");
        $query_photo = $this->Photo_model->search_index($this->user_id,21,"Products",$slug);
        $photo_id="";
        $this->data["id_photo_show"] = "";
        if(isset($query_photo)&&count($query_photo)>0){
	        foreach ($query_photo as $value) {
	            $photo_id[]= $value["photo_id"];
	            $this->data["id_photo_show"].= $value["photo_id"].",";  
	        }
	    }
        $query_comment = $this->Photo_model->get_comment_photobyid($photo_id);
        $recorder = array();
        if(isset($query_photo)&&count($query_photo)>0){
	        foreach ($query_photo as $key => $value) {
	            foreach ($query_comment as $key => $value_2) {
	                if($value["photo_id"] == $value_2["reference_id"]){
	                    $value["comment_photo"][] = $value_2;
	                    unset($query_comment[$key]);
	                }
	            }
	            $recorder[]= $value;
	        }
	    }
        $this->data["class_wrapper"] = "seach_page";
        $this->data["data_wrapper"]["photo"] = $recorder;
        $this->data["photo_count"] = $this->Photo_model->total_page("","","Products",$slug);
        $this->load->view('block/header',$this->data);
        $this->load->view('block/wrapper',$this->data);
        $this->load->view('block/footer',$this->data);
    }
}
