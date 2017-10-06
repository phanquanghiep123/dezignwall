<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {
    public $user_id = 0;
    public $data;
    private $user_info = NULL;
    private $is_login = false;
    public function __construct() {
        parent::__construct();
        $this->data["type_member"] = 0;
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->data["type_member"] = $this->user_info["type_member"];
        }
        $this->data["data_current"] = "search";
        $this->data["is_login"] = $this->is_login;
        $this->data["class_page"] = "search-page";
    }
    public function index($type = NULL, $slug = NULL) {
        $offer_product = $this->data['offer_product']  = trim($this->input->get("offer_product"));
        $this->data['keyword']        = $this->input->get("keyword");
        $this->data['catalog']        = $this->input->get("catalog");
        $this->data['all_category']   = $this->input->get("all_category");
        $this->data['location_photo']       = $this->input->get("location");
        $this->data['photo_type']     = NULL;
        $this->data['category_slug']  = ($type != "projects" && $type != "products") ? $type : NULL;
        $this->data['current_page']   = 0;
        $this->data['class_control']  = "seach_page_total";
        $this->load->model('Category_model');
        $this->load->model("Photo_model");
        $all_category = NULL;
        $category_table = $this->Common_model->get_result("categories", array("pid !=" => 0,"type" => "system"));
        if ($slug  == "products") $this->data['photo_type']    =  "Product";
        if ($slug == "inspiration") $this->data['photo_type']  =  "Project"; 
        if ($type == "projects") $this->data['photo_type']     =  "Project";
        elseif ($type == "products") $this->data['photo_type'] = "Product";
        else if($type != NULL){
            $category_slug = $this->Category_model->get_cat_by_slug_title($type);
            foreach ($category_slug as $value) {
                $all_category [] = $this->get_children_cat($value["id"],$category_table);
                $all_category [] = $value["id"];
            }
        }
        if ($this->data['photo_type']  ==  "Product") {
            $this->data["not_id"] = 192;
        };
        if ($this->data['photo_type']  ==  "Project") {
            $this->data["not_id"] = 9;
        };
        // category not emty.
        if($this->data['all_category'] != NULL){
            $all_category = explode(",", $this->data['all_category']);
            $all_category = array_diff($all_category, array(''));
            foreach ($all_category as $key => $value) {
                if (trim($value) != "") {
                    $all_category[] = $this->get_children_cat($value, $category_table);
                    $all_category[] = $value;
                }
            }
        }
        // !category not emty.
        // location not emty.
        $location = NULL;
        if($this->data['location_photo'] != NULL){
            $location = explode(",", $this->data['location_photo']);
            $location = array_diff($location, array(''));
        }
        // !location not emty.
        // keyword not emty.
        $keyword = NULL;
        if($this->data['keyword'] != NULL)
            $keyword = addslashes(trim($this->data['keyword']));
        // !keyword not emty.
        $catalog = NULL;
        if($this->data['catalog'] != NULL && is_numeric($this->data['catalog'])) 
            $catalog = $this->data['catalog'];
        if($all_category != NULL){
            $all_category = implode(",", $all_category);
            $all_category = explode(",", $all_category);
            $all_category = array_unique($all_category);
            $all_category = array_diff($all_category, array(''));
        }
        if ($location == NULL){
        	$location = $keyword;
	         $location = explode(",", $this->data['location_photo']);
            $location = array_diff($location, array(''));
        }
        
        $this->data["photo_count"] = $this->Photo_model->total_page($location,$keyword,$all_category,$this->data['photo_type'],$catalog,null,$offer_product);
        if($this->data["photo_count"]  > 0)
            $photo = $this->Photo_model->seach_photo($location, $this->user_id, $keyword, $all_category,$this->data['photo_type'], 0, 30,$catalog,null,null,$offer_product);
        else
            $photo = NULL;
        // get article.
        $this->load->model('Article_model');

        if($keyword != NULL) 
            $this->data["article"] = $this->Article_model->get_by_keyword($this->data['keyword'],0,3);
        else 
            $this->data["article"] = $this->Article_model->get_article();
        // !get article.
        
        //$sb_qry='"' . $location . '|' . $this->user_id .'|' . $keyword .'|' . $all_category.'|' . $this->data['photo_type'] .'|'. '0' .'|' . '30' .'|' .$catalog .'|' . 'null' .'|' .'null' .'|' . $offer_product . '" ---';
        $this->data["title_page"] = "Search Page - " . trim(trim(@$sb_qry) . trim($keyword) . " " . trim($this->data['category_slug']) . " " . trim($this->data['catalog']) . " " . trim($this->data['all_category']) . " " . trim($this->data['location_photo']) . " " . trim($this->data['photo_type'])) ;
        $this->data["view_wrapper"] = "seach/index";
        $this->data["data_wrapper"]["photo"] = $photo;
        $this->data["class_wrapper"] = "seach_page";
        $this->load->view('block/header', $this->data);
        $this->load->view('block/wrapper', $this->data);
        $this->load->view('block/footer', $this->data);
    }
    private $children_cat = "";
    private function get_children_cat($cat_id, $arg_full) {
        foreach ($arg_full as $key => $value) {
            if ($cat_id == $value["pid"]) {
                $this->children_cat.= $value["id"] . ",";
                unset($arg_full[$key]);
                $this->get_children_cat($value["id"], $arg_full);
            }
        }
        return $this->children_cat;
    }

}
