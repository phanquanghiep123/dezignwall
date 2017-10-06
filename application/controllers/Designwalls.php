<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Designwalls extends MY_Controller {

    private $_per_page = 4;
    private $_owner_id_project = null;
    private $_uploadedthumb = array();
    private $user_id;
    private $is_login = false;
    private $data;
    public function __construct() {
        parent::__construct();
        if ($this->user_info == null && !$this->session->userdata('user_sr_info')) {
            redirect("/search?action=signin");
        }
        $cookie = array(
            'name' => 'member_id',
            'value' => $this->user_info["id"],
            'expire' => '86500'
        );
        $this->user_id = $this->user_info["id"];
        $this->load->helper(array(
            'slugify'
        ));
        $this->input->set_cookie($cookie);
        $this->load->model('Category_model');
        $this->load->model('Members_model');
        $this->is_login = $data["is_login"] = true;
        $this->data["view_profile"] = false;
    }

    // Get list folder of current project. Required: exists project
    

    public function index($project_id = null) {
        $this->load->model('Project_model');
        $this->load->model('Photo_model');
        $this->load->model('Comment_model');
        $data["title_page"] = "Your Wall";
        $data['title'] = 'My DEZIGNWALL';
        $data['component'] = 'banner';
        $data['title_banner'] = 'The home for commmercial design professionals';
        $data['title_des'] = 'Your FREE DEZIGNWALL Microsite!';
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $user_id = $this->user_info["id"];
        $record_member = $this->Members_model->getById($user_id);
        $data['record_member'] = $record_member;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $upgrade = $this->Project_model->get_packages_use($user_id);
        $all_project = $this->Common_model->count_table("projects",["member_id" => $user_id]);
        $data["upgrade"] = false;
        if($all_project <  $upgrade){
        	$data["upgrade"] = true;
        }
        $data['user_id'] = $user_id;
        if (!(isset($record) && $record != null)) {
            redirect('/');
        }
        $record["id"] = 0;
        $data["view_profile"] = false;
        $data['member'] = $record;
        $data["company_info"] = $this->Common_model->get_record("company", array(
            'member_id' => $user_id
        ));
        $invite_project = $this->Project_model->get_project_invite_member($user_id);
        if($invite_project != null){
            $new_project = [];
            foreach ($invite_project as $key => $value) {
                $folder = $this->Common_model->get_result("project_categories",array("project_id"=>$value["project_id"],'status' => 'no'));
                if($folder != null){
                	foreach ($folder as $key_1 => $value_1) {
                		$value_1["path_file"] = $this->Project_model->get_img_cat($value_1["category_id"]);
                		$value["folder"] [] = $value_1;
                	}
                }
                $new_project [] = $value;
            }
            $data["project"] = $new_project;
        }
        $data["is_login"] = true;
        $data["user_id"] = $user_id;
        $this->load->view('block/header', $data);
        $this->load->view("include/share");
        $this->load->view('designwalls/new_index', $data);
        $this->load->view('block/footer', $data);
    }
    public function view($project_id = null) {
        $data["not_edit_logo"] = true;
        $data["view_profile"] = false;
        $this->load->model('Project_model');
        $this->load->model('Photo_model');
        $this->load->model('Comment_model');
        $data["title_page"] = "Your Wall";
        $data['title'] = 'My DEZIGNWALL';
        $data['component'] = 'banner';
        $data['title_banner'] = 'The home for commmercial design professionals';
        $data['title_des'] = 'Your FREE DEZIGNWALL Microsite!';
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $user_id = $this->user_info["id"];
        if($this->session->userdata('user_sr_info')){
            $user_sr_info = $this->session->userdata('user_sr_info');
            $user_id = $user_sr_info["member_owner"];
        }
        // Count project to add new the first project for this user

        if ($this->Project_model->count_collection_projects($user_id, null) == 0) {
            // Add new Default Project
            $new_projects = array(
                "project_name" => "Name your Design Wall",
                "created_at" => date("Y-m-d H:i:s"),
                "member_id" => $user_id,
                "type_project" => "auto"
            );
            $project_id = $this->Project_model->add_project($new_projects);
            $new_projects_cat = array(
                "project_id" => $project_id,
                "title" => "Default Category",
                "type_category" => "auto",
                "path_file" => "/skins/images/default-product.jpg"
            );

            // Insert projects cat
            $projects_cat_id = $this->Project_model->add_project_category($new_projects_cat);
        }

        $owner_member_id = $user_id;
        $result = $this->Project_model->get_project($project_id, $user_id);
        $data["project_id"] = $result['project_id'];
        $data["type_project"] = $result['type_project'];
        $project_id = $result['project_id'];
        $data['team_member'] = $this->Project_model->get_project_member($project_id);
        $data['owner'] = false;
        if ($result != null) {
            $owner_member_id = $result["member_id"];
            $data["title_project"] = "Project Info: ";
            if ($result['member_id'] == $user_id && $result['type_project'] == "custom") {
                $data['owner'] = true;
            }
        } else { // Not exists project then redirect to homepage
            redirect("/");
        }

        $this->form_validation->set_rules('project_name', 'Project Name', 'trim|required');

        // $this->form_validation->set_rules('project_no', 'Project No', 'trim|required');
        // Save to database
        if ($this->form_validation->run() !== FALSE) {
            $array = array(
                'project_name' => $this->input->post('project_name'),
                'project_no' => 0, //$this->input->post('project_no'),
                'start_date' => $this->input->post('start_date'),
                'due_date' => $this->input->post('due_date'),
                'project_specs' => $this->input->post('project_specs'),
                'team_member' => $this->input->post('team_member'),
                'changed_date' => date("Y-m-d H:i:s")
            );
            $data["project_id"] = $project_id;
            if ($this->Project_model->update_project($array, $project_id, $owner_member_id)) {
                $data['message'] = "Project information has been updated successfully.";
                $data["title_project"] = "Project Info: ";
                $data['result'] = $result = $this->Project_model->get_project($project_id, $this->user_info["id"]);
            }
        } else {
            if (isset($_POST)) {
                $data['message'] = validation_errors();
                $data["result"] = (count($_POST) > 0) ? $_POST : $result;
                $data["result"]['member_id'] = $result['member_id'];
            } else {
                $data["result"] = $result;
            }
        }

        // Load category and some image for this category
        if ($project_id != null && is_numeric($project_id)) {
            // Get all category of project
            $this->load->helper("url");
            $this->load->library("pagination");

            // Load all photos random to show
            $segment = 4;
            $config_init = array(
                "base_url" => "/designwalls/view/" . $project_id,
                "segment" => $segment,
                "total_rows" => $this->Project_model->count_collection_project_category($project_id, null),
                "per_page" => $this->_per_page
            );
            $config = $this->get_config_paging($config_init);
            $this->pagination->initialize($config);
            $page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
            $arr_cats = $this->Project_model->get_collection_project_category($project_id, null, $config["per_page"], $page);
            $i = 0;
            foreach ($arr_cats as $key => $value) {
                $value['photos'] = array_merge($this->Photo_model->get_collection_design_wall_photos($value['category_id'], $owner_member_id,$user_id, "", 20, ""), $this->Photo_model->get_collection_design_wall_favorite_photos($value['category_id'], $owner_member_id, $user_id, "", 20, ""));
                $value['comments'] = $this->Comment_model->get_collection($value['category_id'], "category", -1, 0);
                $arr_cats[$i] = $value;
                $i++;
            }
         
            $data["result_categories"] = $arr_cats;
            $data["links"] = $this->pagination->create_links();
            $data["curpage"] = $page;
            $data["allow_delete_category"] = intval($config_init["total_rows"]) <= 1 ? false : true;
        }

        // Get all design wall
        $data["left_projects"] = $this->Project_model->get_project_invite_member($user_id);
        $data["view_member_id"] = $user_id;
        $record_member = $this->Members_model->getById($user_id);
        $data['record_member'] = $record_member;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $data['user_id'] = $user_id;
        if (!(isset($record) && $record != null)) {
            redirect('/');
        }
        $logo_company = $this->Common_model->get_record("members", array(
            'id' => $result['member_id']
        ));
        $record["banner"] = $result["path_file"];
        $record["id"] =  $result['member_id']; 
        $record["logo"] =  @$logo_company['logo'];
        $record["company_name"] =  @$logo_company['company_name']; 
        $data['member'] = $record;
        $data["company_info"] = $this->Common_model->get_record("company", array(
            'member_id' => $result['member_id']
        ));
        $data["is_login"] = true;
        $data["change_media"] = base_url("designwalls/update_media_designwalls/".$project_id);
        $this->load->view('block/header', $data);
        $this->load->view("include/share");
        $this->load->view('designwalls/index', $data);
        $this->load->view('block/footer', $data);
    }
    public function add(){
    	$this->load->model('Project_model');
        $user_id = $this->user_info["id"];
        $upgrade = $this->Project_model->get_packages_use($user_id);
        $all_project = $this->Common_model->count_table("projects",["member_id" => $user_id]);
        $data["upgrade"] = false;
        if($all_project >=  $upgrade){
        	redirect(base_url("designwalls/upgrade"));
        }
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('project_name', 'Project Name', 'required');
            if($this->form_validation->run()){
                $logo = "";
                if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
                    $user_info = $this->user_info;
                    $upload_path = FCPATH.'uploads/wall';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = $upload_path.'/'.$user_id.'/';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $name = explode(".", $_FILES["image"]["name"]);
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = (10*1024); // Byte
                    $config['file_name'] = $this->gen_slug($name[0] .'-'. time());
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload("image")){
                        $logo = '/uploads/wall/'.$user_id.'/'.$config['file_name'].'.'.$name[count($name) - 1];
                        if ($this->input->post('w') && intval($this->input->post('w')) > 0 && $this->input->post('h') && intval($this->input->post('h')) > 0) {
                            $this->load->library('image_lib');
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = FCPATH."/".$logo;
                            $config['new_image'] = FCPATH."/".$logo;
                            $config['maintain_ratio'] = FALSE;
                            $config['x_axis'] = floatval($this->input->post('x'));
                            $config['y_axis'] = floatval($this->input->post('y'));
                            $config['width'] = floatval($this->input->post('w'));
                            $config['height'] = floatval($this->input->post('h'));
                            $config['quality'] = 100;
                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->crop();
                        }
                    }
                } 
                $data_insert = [
                    "project_name" => $this->input->post("project_name"),
                    "project_specs" => @$this->input->post("project_specs"),
                    "start_date" => @$this->input->post("start_date"),
                    "due_date" => @$this->input->post("due_date"),
                    "path_file" => $logo,
                    "member_id" => $user_id
                ];
                $id = $this->Common_model->add("projects",$data_insert);
                
                // --------------------------------------------------------------
                // media.dezignwall.com
                // exec('rsync -azv ' . $logo . ' /s3source/dezignwall/uploads/');
                // Sync image
				exec('aws s3 sync  /dw_source/dezignwall/uploads/wall/'.$user_id.'/ s3://dwsource/dezignwall/uploads/wall/'.$user_id.'/ --acl public-read'); 
				                    
                if($id){
                	$data_insert = [
                		"project_id" => $id,
                		"title" => "Default Category",
                		"type_category" => "auto",
                		"status"   => "no",
                		"path_file" => "/skins/images/default-product.jpg"
                	];
                	$this->Common_model->add("project_categories",$data_insert);
                }
                redirect(base_url("designwalls/view/".$id));
            }  
        }
        $data["title_page"] = "Your Wall";
        $data['title'] = 'My DEZIGNWALL';
        $data['component'] = 'banner';
        $data['title_banner'] = 'The home for commmercial design professionals';
        $data['title_des'] = 'Your FREE DEZIGNWALL Microsite!';
        $this->load->library('form_validation');
        $this->load->library("pagination");
        
        $record_member = $this->Members_model->getById($user_id);
        $data['record_member'] = $record_member;
        $record = $this->Common_model->get_record("members", array('id' => $user_id));
        $data['user_id'] = $user_id;
        if (!(isset($record) && $record != null)) {
            redirect('/');
        }

        $data["view_profile"] = true;
        $data['member'] = $record;
        $data["company_info"] = $this->Common_model->get_record("company", array('member_id' => $user_id)); 
        $data["is_login"] = true;
        $data["user_id"] = $user_id;
        $this->load->view('block/header', $data);
        $this->load->view("include/share");
        $this->load->view('designwalls/add', $data);
        $this->load->view('block/footer', $data);
    }
    public function update_media_designwalls($id=null ){
    	$data = array(
            'status' => 'error'
        );
    	if($id != null && is_numeric($id)){
    		$user_id = $this->user_info["id"];
    		$wall = $this->Common_model->get_record("projects",["project_id" => $id ,"member_id" => $user_id]);
    		if($wall != null){

    			$logo = "";
                if(isset($_FILES["fileupload"]) && $_FILES["fileupload"]["error"] == 0){

                    $upload_path = FCPATH.'uploads/wall';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = $upload_path.'/'.$user_id.'/';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $name = explode(".", $_FILES["fileupload"]["name"]);
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = (10*1024); // Byte
                    $config['file_name'] = $this->gen_slug($name[0] .'-'. time());
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload("fileupload")){
                    	//die(json_encode($wall));
                        $logo = '/uploads/wall/'.$user_id.'/'.$config['file_name'].'.'.$name[count($name) - 1];
                        if ($this->input->post('w') && intval($this->input->post('w')) > 0 && $this->input->post('h') && intval($this->input->post('h')) > 0) {
                            $this->load->library('image_lib');
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = FCPATH."/".$logo;
                            $config['new_image'] = FCPATH."/".$logo;
                            $config['maintain_ratio'] = FALSE;
                            $config['x_axis'] = floatval($this->input->post('x'));
                            $config['y_axis'] = floatval($this->input->post('y'));
                            $config['width'] = floatval($this->input->post('w'));
                            $config['height'] = floatval($this->input->post('h'));
                            $config['quality'] = 100;
                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->crop();
                        }
                        // --------------------------------------------------------------
	                	// media.dezignwall.com
	                	// exec('rsync -azv ' . $logo . ' /s3source/dezignwall/uploads/');
	                	// Sync image
						exec('aws s3 sync  /dw_source/dezignwall/uploads/wall/'.$user_id.'/ s3://dwsource/dezignwall/uploads/wall/'.$user_id.'/ --acl public-read'); 
	                	
                        $data['name'] = $logo;
                        $data['status'] = "success";
                    }
                    $this->Common_model->update('projects',["path_file" => $logo],["project_id" => $id ]);
                }

    		}
    	}
    	die(json_encode($data));

    }
    public function get_info_prouct($category_id, $photo_id) {
        if ($this->input->is_ajax_request() && isset($category_id) && $category_id != null && is_numeric($category_id) && isset($photo_id) && $photo_id != null && is_numeric($photo_id)) {
            $record = $this->Common_model->get_record('products', array(
                'photo_id' => $photo_id,
                'category_id' => $category_id
            ));
            if (isset($record) && count($record) > 0) {
                die(json_encode(array(
                    'status' => 'success',
                    'reponse' => $record
                )));
            }
        }

        die(json_encode(array(
            'status' => 'error'
        )));
    }

    public function save_info_prouct() {
        $data = array(
            'status' => 'error'
        );
        $product = $this->input->post('product');
        $category_id = $product['category_id'];
        $photo_id = $product['photo_id'];
        if ($this->input->is_ajax_request() && isset($category_id) && $category_id != null && is_numeric($category_id) && isset($photo_id) && $photo_id != null && is_numeric($photo_id)) {
            $record = $this->Common_model->get_record('products', array(
                'photo_id' => $photo_id,
                'category_id' => $category_id
            ));
            $arr = array(
                'product_name' => @$product['product_name'],
                'product_no' => @$product['product_no'],
                'price' => @$product['price'],
                'qty' => @$product['qty'],
                'fob' => @$product['fob'],
                'product_note' => @$product['product_note'],
                'member_updated_id' => @$this->user_info["id"]
            );
            if (isset($record) && count($record) > 0) {
                $this->Common_model->update('products', $arr, array(
                    'photo_id' => $photo_id,
                    'category_id' => $category_id
                ));
            } else {
                $arr['member_id'] = $this->user_info["id"];
                $arr['category_id'] = $category_id;
                $arr['photo_id'] = $photo_id;
                $this->Common_model->add('products', $arr);
            }

            $data['status'] = 'success';
        }

        die(json_encode($data));
    }

    /* Get list photos of a folder */

    function photos($project_id = null, $category_id = null, $type = "") {
        // Load model  
        $this->data["class_page"]   = "search-page";
        $this->load->model('Photo_model');
        $this->load->model('Category_model');
        $this->load->model('Project_model');
        $this->load->model('Comment_model');
        $this->load->library("pagination");
        $data['project_id'] = $project_id;
        $data['category_id'] = $category_id;
        $data["title_page"] = "Your Wall";
        $user_id = $this->user_info["id"];
        if($this->session->userdata('user_sr_info')){
            $user_sr_info = $this->session->userdata('user_sr_info');
            $user_id = $user_sr_info["member_owner"];
        }
        // Check project
        $result = $this->Project_model->get_project($project_id, $user_id);
        $owner_member_id = null;
        if ($result == null) {
            redirect("/designwalls/");
        }
        $owner_member_id = $result["member_id"];
        $data['view_member_id'] = $this->user_info["id"];
        $data['result'] = $result;
        $data['title_project'] = $result["project_name"];
        // Check category
        $result_cat = $this->Project_model->get_project_category($category_id);
        if ($result_cat == null) {
            // Create default folder
            if ($this->Project_model->count_collection_project_category($project_id, null) == 0) {
                $new_projects_cat = array(
                    "project_id" => $project_id,
                    "title" => "Default Category",
                    "type_category" => "auto",
                    "path_file" => "/skins/images/default-product.jpg"
                );
                // Insert projects cat
                $category_id = $this->Project_model->add_project_category($new_projects_cat);
            }
        }
        $data['cat_name'] = $result_cat['title'];
        $data["project_id"] = $project_id;
        $data["category_id"] = $category_id;

        // Load all photos random to show
        $segment = 6;
        $this->_per_page = 24;
        $config_init = array(
            "base_url" => "/designwalls/designphotos/{$project_id}/{$category_id}/{$type}",
            "segment" => $segment,
            "total_rows" => ($type != 'favorite') ? $this->Photo_model->count_collection_design_wall_photos($category_id, $owner_member_id, "") : $this->Photo_model->count_collection_design_wall_favorite_photos($category_id, "", ""),
            "per_page" => $this->_per_page
        );
        $config = $this->get_config_paging($config_init);
        $this->pagination->initialize($config);
        $page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $result_photos = array_merge($this->Photo_model->get_collection_design_wall_photos($category_id, $owner_member_id, $user_id, "", -1, $page), $this->Photo_model->get_collection_design_wall_favorite_photos($category_id, $owner_member_id, $user_id, "", -1, $page));
        $data["links"] = $this->pagination->create_links();
        $data["curpage"] = $page;
        $data["show_upload"] = ($type != 'favorite') ? true : false;
        $i = 0;
        foreach ($result_photos as $key => $value) {
            $value['photo_comment'] = $this->Comment_model->get_collection($value['product_id'], "product", -1, 0);
            $result_photos[$i] = $value;
            $i++;
        }
        $data["results"] = $result_photos;

        // ============================================================================
        
        $record_member = $this->Members_model->getById($user_id);
        $data['record_member'] = $record_member;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $data['user_id'] = $user_id;
        if (!(isset($record) && $record != null)) {
            redirect('/');
        }
        $data["view_profile"] = false;
        $record["id"] = 0;
        $data['member'] = $record;
        $data["company_info"] = $this->Common_model->get_record("company", array(
            'member_id' => $user_id
        ));
        $data["is_login"] = true;
        $this->load->view('block/header', $data);
        $this->load->view('designwalls/photos', $data);
        $this->load->view('block/footer', $data);
    }

    /* Delete photo */

    public function delete_photo($project_id = null, $category_id = null, $photo_id = null) {
        if (isset($this->user_info["id"]) && is_numeric($project_id) && is_numeric($category_id) && is_numeric($photo_id)) {
            $record_product = $this->Common_model->get_record('products', array(
                'photo_id' => $photo_id,
                'category_id' => $category_id
            ));
            if (!(isset($record_product) && count($record_product) > 0)) {
                redirect('/designwalls/photos/' . $project_id . '/' . $category_id . '/');
            }

            $this->Common_model->delete('products', array(
                'photo_id' => $photo_id,
                'category_id' => $category_id
            ));

            // Get physical file image to delete it.
            $record_photo = $this->Common_model->get_record('photos', array(
                'photo_id' => $photo_id,
                'member_id' => $this->user_info["id"],
                'type' => 4
            ));
            if ($record_photo != null) {
                @unlink(FCPATH . $result_photo["path_file"]);
                @unlink(FCPATH . $result_photo["thumb"]);
                $this->Common_model->delete('photos', array(
                    'photo_id' => $photo_id,
                    'member_id' => $this->user_info["id"],
                    'type' => 4
                ));
                $this->Common_model->delete('photo_category', array(
                    'photo_id' => $photo_id
                ));
                $this->Common_model->delete('photo_keyword', array(
                    'photo_id' => $photo_id
                ));
                $this->Common_model->delete('common_comment', array(
                    'reference_id' => $photo_id
                ));
                $this->Common_model->delete('images_point', array(
                    'photo_id' => $photo_id
                ));
            }
        }

        redirect('/designwalls/photos/' . $project_id . '/' . $category_id . '/');
    }

    /* Delete category in project */

    public function delete_category($project_id = null, $category_id = null) {
        if (isset($project_id) && is_numeric($project_id) && isset($category_id) && is_numeric($category_id)) {
            $this->load->model('Project_model');
            $result_project = $this->Project_model->get_project($project_id, $this->user_info["id"]);
            $owner_member_id = null;
            if ($result_project == null) {
                redirect("/designwalls/");
            }

            // Change status to yes, it will be hidden (dont delete direct database)

            $this->Project_model->update_project_category(array(
                'status' => 'yes'
                    ), $category_id, $project_id);
        }

        redirect("/designwalls/view/$project_id/");
    }

    /* Rename folder */

    function update_category() {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Project_model');
            $project_id = (isset($_POST["project_id"]) && is_numeric($_POST["project_id"])) ? $_POST["project_id"] : null;
            $category_id = (isset($_POST["category_id"]) && is_numeric($_POST["category_id"])) ? $_POST["category_id"] : 0;
            if ($project_id == null) {
                die("error");
            }

            $result = $this->Project_model->get_project($project_id, $this->user_info["id"]);
            if ($result == null) {
                die("error");
            }

            $this->load->helper(array(
                'form',
                'url'
            ));
            $this->load->library('form_validation');
            $this->load->library('session');
            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
            if ($this->form_validation->run() !== FALSE) {
                $filter = array(
                    "title" => $this->input->post('category_name'),
                    "project_id" => $this->input->post('project_id'),
                    "status" => "no"
                );
                $count_query = $this->Common_model->count_table("project_categories", $filter);
                if (($category_id == 0 && $count_query > 0) || ($category_id != 0 && $count_query > 1)) {
                    die("This title folder already exists");
                }

                if ($category_id == 0) {
                    $array = array(
                        'title' => $this->input->post('category_name'),
                        'specs' => $this->input->post('category_description'),
                        'project_id' => $this->input->post('project_id'),
                        'type_category' => 'custom',
                        'path_file' => '/skins/images/default-product.jpg'
                    );
                    $category_id = $this->Project_model->add_project_category($array);
                    die("ok");
                } else {
                    $array = array(
                        'title' => $this->input->post('category_name'),
                        'specs' => $this->input->post('category_description')
                    );
                    if ($this->Project_model->update_project_category($array, $category_id)) {
                        die("ok");
                    }
                }
            }
        }

        die("Error message");
    }

    /* Invite member */

    public function invite_member() {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Project_model');
            $this->load->model('Members_model');
            $user_info = $this->session->userdata('user_info');
            $from_email = $user_info['email'];
            $full_name = @$user_info["full_name"];
            foreach ($this->input->post('add_tems') as $key) {
                // Save to database
                $token = uniqid(mt_rand(), true);
                $array = array(
                    'project_id' => $key['designwall'],
                    'owner_id' => $user_info['id'],
                    'email' => $key['email'],
                    'first_name' => $key['first_name'],
                    'last_name' => $key['last_name'],
                    'invite_date' => date("Y-m-d H:i:s"),
                    'status' => '0',
                    'token' => $token
                );
                // Check email exists in system?
                $member = $this->Members_model->get_record_by_email($key['email']);
                $action = "signup";
                $member_id = null;
                if ($member != null) {
                    $action = "signin";
                    $member_id = $member["id"];
                }
                // Check email exists in this project if not then add to database
                $is_sent_mail = false;
                $project_member = $this->Project_model->check_email_in_project($member_id, $key['designwall']);
                if ($member == null || ($member_id != $user_info['id'] && $project_member == null)) {
                    $this->Project_model->add_project_invite($array);
                }

                $accept_url = base_url() . "?action=" . $action . "&project_id=" . $key['designwall'] . "&token=" . $token . "&email=" . $key['email'];
                if ($action == "signup") {
                    $accept_url.= "&first_name=" . $key['first_name'] . "&last_name=" . $key['last_name'];
                }

                $report_url = base_url() . "page/contact-us";
                $message = "
                <table>
                <tr><td colspan='2' style='margin-bottom: 20px;float: left;'>" . $full_name . " invited you to join the DEZIGNWALL | " . $key['project_name'] . " - #" . $key['project_no'] . "</td></tr>
                <tr>
                    <td style='margin-bottom:20px;float:left;width: 270px;vertical-align: text-bottom;'colspan='2'>Note: " . $key['messenger_inver'] . "</td>
                </tr>   
                <tr>
                    <td style='margin-bottom:20px;float:left;width: 270px;vertical-align: text-bottom;'>To join and view comments, simply click here: </td>
                    <td style='margin-bottom: 20px;float: left;vertical-align: text-bottom;'><a href='{$accept_url}' style='background-color: #FF9900;padding: 5px 0px;border-radius: 5px;color: #fff;cursor: pointer;margin-left: 20px;  text-decoration: blink;width: 160px; float:left;text-align: center;'>Accept Invite</td></tr>
                <tr><td colspan='2'>Having trouble viewing the link? Copy and paste URL to browser:<br /><p style='color: #F90;'>{$accept_url}</p></td></tr>
                <tr><td colspan='2'style='height: 20px;'></td></tr>
                <tr><td colspan='2' style='margin-bottom: 20px;float: left;'><a href='" . base_url() . "'><img src='" . base_url() . "skins/images/new-logo.png'></a></td></tr>
                <tr><td colspan='2' style='margin-bottom: 20px;float: left;'>DEZIGNWALL, Inc. | 'The entire commercial design and products industry, at your fingertips'</td></tr>
                <tr><td colspan='2' style='margin-bottom: 20px;float: left;'>DEZIGNWALL, Inc. | Irvine CA | www.DEZIGNWALL.com | (949) 988-0604</td></tr>
                </table>";
                $subject = "" . $full_name . " invited you to join the DEZIGNWALL | " . $key['project_name'] . " - #" . $key['designwall'] . "";
                $this->send_mail($key['email'], $subject, $message, $from_email);
            }

            echo "done";
        } else {
            echo 'error';
        }
    }

    /* Copy folder */

    public function copy_category($project_id = null, $category_id = null) {
        if (isset($project_id) && is_numeric($project_id) && isset($category_id) && is_numeric($category_id)) {
            $this->load->model('Project_model');
            $this->load->model('Photo_model');
            $result = $this->Project_model->get_project($project_id, $this->user_info["id"]);
            if ($result != null) {
                // Check category
                $result_cat = $this->Project_model->get_project_category($category_id);
                if ($result_cat != null) {
                    $this->load->helper(array(
                        'form',
                        'url'
                    ));
                    // Copy category
                    $array = array(
                        'title' => $result_cat['title'] . " - Copy",
                        'specs' => $result_cat['specs'],
                        'project_id' => $project_id,
                        'type_category' => 'custom',
                        'path_file' => '/skins/images/default-product.jpg'
                    );
                    $category_new_id = $this->Project_model->add_project_category($array);
                    // Copy photos in this category
                    $owner_member_id = $result["member_id"];
                    $result_photos = array_merge($this->Photo_model->get_collection_design_wall_photos($category_id, $owner_member_id, $owner_member_id, "", -1, 0), $this->Photo_model->get_collection_design_wall_favorite_photos($category_id, $owner_member_id, $owner_member_id, "", -1, 0));
                    if ($result_photos != "") {
                        foreach ($result_photos as $photo_item) {
                            $this->copy_photo($photo_item, $owner_member_id, $category_new_id);
                        }
                    }
                }
            }
        }

        redirect("/designwalls/view/$project_id/");
    }

    /* Copy photo */

    private function copy_photo($record_photo, $owner_member_id, $category_id) {
        $photo_id = $record_photo["photo_id"];
        $data_insert = array(
            "photo_id" => $photo_id,
            "member_id" => $owner_member_id,
            "member_updated_id" => $this->user_info["id"],
            "product_name" => $record_photo['name'],
            "category_id" => $category_id,
            "created_at" => date("Y-m-d")
        );
        $id_product = $this->Common_model->add("products", $data_insert);
        if ($id_product) {
            $data_insert = array(
                "reference_id" => $photo_id,
                "qty_pintowall" => 1,
                "type_object" => "photo",
                "qty_comment" => 0
            );
            $this->Common_model->add("common_tracking", $data_insert);
        }

        return $id_product;
    }

    // now the callback validation that deals with the upload of files
    function fileupload_check() {
        // we retrieve the number of files that were uploaded
        $number_of_files = sizeof($_FILES['fileImages']['tmp_name']);

        // considering that do_upload() accepts single files, we will have to do a small hack so that we can upload multiple files. For this we will have to keep the data of uploaded files in a variable, and redo the $_FILE.
        $files = $_FILES['fileImages'];

        // first make sure that there is no error in uploading the files
        for ($i = 0; $i < $number_of_files; $i++) {
            if ($_FILES['fileImages']['error'][$i] != 0) {
                // save the error message and return false, the validation of uploaded files failed
                $this->form_validation->set_message('fileupload_check', 'Couldn\'t upload the file(s)');
                return FALSE;
            }
        }

        // create the folder if it's not already exists
        $path = FCPATH . "/uploads/member";
        if (!is_dir($path)) {
            mkdir($path, 0755, TRUE);
        }

        $member_id = $this->_owner_id_project == null ? $this->user_info["id"] : $this->_owner_id_project;
        $path = $path . "/" . $member_id;
        if (!is_dir($path)) {
            mkdir($path, 0755, TRUE);
        }

        // we first load the upload library
        $this->load->library('upload');

        // next we pass the upload path for the images
        $config['upload_path'] = FCPATH . '/uploads/member/' . $member_id . '/';
        // also, we make sure we allow only certain type of images

        $config['allowed_types'] = 'gif|jpg|png';
        $fname_temp = "";

        // now, taking into account that there can be more than one file, for each file we will have to do the upload
        for ($i = 0; $i < $number_of_files; $i++) {
            $arr = explode(".", $files['name'][$i]);
            $fname_temp = $arr[0] . "_" . uniqid() . "." . $arr[sizeof($arr) - 1];
            $_FILES['file']['name'] = $fname_temp;
            $_FILES['file']['type'] = $files['type'][$i];
            $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['file']['error'] = $files['error'][$i];
            $_FILES['file']['size'] = $files['size'][$i];

            // now we initialize the upload library

            $this->upload->initialize($config);
            if ($this->upload->do_upload('file')) {
                $this->_uploaded[$i] = $this->upload->data();
                $this->_uploadedthumb[$i] = $this->resize_image($fname_temp, 300, 195);
            } else {
                $this->form_validation->set_message('fileupload_check', $this->upload->display_errors());
                return FALSE;
            }
        }
        
        // Sync image
		exec('aws s3 sync  /dw_source/dezignwall/uploads/member/'.$member_id.'/ s3://dwsource/dezignwall/uploads/member/'.$member_id.'/ --acl public-read'); 

        return TRUE;
    }

    function resize_image($file_path, $width, $height) {
        $member_id = $this->_owner_id_project == null ? $this->user_info["id"] : $this->_owner_id_project;
        $path_upload = FCPATH . '/uploads/member/' . $member_id . '/';
        $this->load->library('image_lib');
        $img_cfg['image_library'] = 'gd2';
        $img_cfg['source_image'] = $path_upload . $file_path;
        $img_cfg['maintain_ratio'] = TRUE;
        $img_cfg['create_thumb'] = FALSE; //ex: filename_thumb.ext
        $img_cfg['new_image'] = $path_upload . "thumbs_" . $file_path;
        $img_cfg['width'] = $width;
        $img_cfg['quality'] = 100;
        $img_cfg['height'] = $height;
        $this->image_lib->initialize($img_cfg);
        $this->image_lib->resize();
        
        // --------------------------------------------------------------
        // media.dezignwall.com
        // exec('rsync -azv ' . $path_upload . "thumbs_" . $file_path . ' /s3source/dezignwall/uploads/');
        // Sync image
		exec('aws s3 sync  /dw_source/dezignwall/uploads/member/'.$member_id.'/ s3://dwsource/dezignwall/uploads/member/'.$member_id.'/ --acl public-read'); 

        
        return '/uploads/member/' . $path_upload . "thumbs_" . $file_path . '/' . "thumbs_" . $file_path;
    }

    public function deletePhoto($id = 0) {
        if (isset($this->user_info["id"])) {
            $this->load->model('Photo_model');
            $this->Photo_model->deletePhoto($id, $this->user_info["id"]);
            redirect("/profile/myphoto");
        }
    }

    public function deletePhoto_type($id = 0) {
        if (isset($this->user_info["id"])) {
            $this->load->model('Photo_model');
            $arr = array(
                'type' => 2
            );
            $this->Photo_model->saveAttributePhoto($id, $this->user_info["id"], $arr);
            redirect("/profile/myphoto");
        }
    }

    // get photo by paging
    public function getPhotoByPaging() {
        if ($this->input->is_ajax_request()) {
            $pageIndex = 1;
            $pageSize = 12;
            $this->load->model('Photo_model');
            $this->load->model('Packages_model');
            $lstID = $this->input->post("catid");
            if (isset($_POST["pg_num"])) {
                if ($_POST["pg_num"] == 1) {
                    $pageSize = 11;
                }

                $pageIndex = $_POST["pg_num"];
            }

            $package = $this->Packages_model->get_detail_package($this->session->userdata('type_member'));
            $max_files = 0;
            if ($package != null && is_numeric($package["max_files"])) {
                $max_files = intval($package["max_files"]);
            }

            $data['max_files'] = $max_files;
            $lstPhoto = $this->Photo_model->getPhotoByPaging($lstID, $pageIndex, $pageSize, $this->user_info["id"]);
            $data['photos'] = $lstPhoto;
            $data['catids'] = $lstID;
            $data['pageIndex'] = $pageIndex;
            $this->load->view('profile/grid_photos', $data);
        }
    }

    public function savePhoto() {
        $this->load->model('Photo_model');
        $allPhoto = $_POST;
        $allName = $allPhoto['photos'];
        foreach ($allName as $key => $value) {
            $this->Photo_model->savePhoto($allPhoto['photo_id'][$key], addslashes($allPhoto['photos'][$key]));
        }

        // Check if this account is member ship
        $type_member = $this->session->userdata('type_member');
        if (intval($type_member) > 0) {
            if (isset($_POST["list_id"])) {
                $this->load->model('Packages_model');
                $package = $this->Packages_model->get_detail_package($this->session->userdata('type_member'));
                $max_files = 0;
                if ($package != null && is_numeric($package["max_files"])) {
                    $max_files = intval($package["max_files"]);
                }

                $arr = explode(",", $_POST["list_id"]);
                if ($max_files > 0) {
                    $i = 0;

                    // Remove old active photo

                    $this->Photo_model->backOriginalTypePhoto($this->user_info["id"]);
                    foreach ($arr as $item) {
                        if ($i <= $max_files) {
                            $i++;
                            $this->Photo_model->saveAttributePhoto($item, $this->user_info["id"], array(
                                "type" => "3"
                            ));
                        }
                    }
                }
            }
        }

        redirect("/profile/myphoto");
    }

    public function deletedesignfavorite($project_id = null, $category_id = null, $photo_id = null) {
        $this->load->model('Photo_model');
        $this->Photo_model->deletemyFavorite($photo_id, $this->user_info["id"]);
        redirect("/designwalls/designphotos/{$project_id}/{$category_id}/favorite");
    }

    public function deletefavorite($photo_id = null) {
        $this->load->model('Photo_model');
        $this->Photo_model->deletemyFavorite($photo_id, $this->user_info["id"]);
        redirect("/profile/myfavorite");
    }

    public function pagingfavorite($offset) {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Photo_model');
            $html = '';
            $photoMyfavorite = $this->Photo_model->getmyFavorite($this->user_info["id"], ($offset - 1) * 30, 30);
            if (count($photoMyfavorite) > 0) {
                foreach ($photoMyfavorite as $value) {
                    $html.= '<div class="large-4 medium-6 small-12 columns" data-equalizer-watch>
                            <div class="photo-item">
                                <a rel="gallery1" class="fancybox-image" href="' . $value->path_file . '"><img style="height:200px;width:100%;" src="' . $value->path_file . '"></a>
                                <div class="photo-action my_photo">
                                    <div>
                                      <a class="delete-photo button radius" href="/profile/deletefavorite/' . $value->photo_id . '" onclick="return confirm(\'Are you sure you want to delete this image?\');"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                          </div>';
                }

                echo $html;
            }
        }
    }

    public function hidden_projects($projects) {
        $array = array(
            "status" => "yes"
        );
        $this->load->model('Project_model');
        $this->Project_model->update_project($array, $projects, $this->user_info["id"]);
        redirect(base_url() . "designwalls/index/");
    }

    public function deletecategory() {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Project_model');
            $project_id = (isset($_POST["project_id"]) && is_numeric($_POST["project_id"])) ? $_POST["project_id"] : null;
            $category_id = (isset($_POST["category_id"]) && is_numeric($_POST["category_id"])) ? $_POST["category_id"] : null;
            if ($project_id != null && $category_id != null) {
                $result = $this->Project_model->get_project($project_id, $this->user_info["id"]);
                if ($result != null) {
                    $this->Project_model->delete_project_category($project_id, $category_id);
                    die("ok");
                }
            }
        }

        die("error");
    }

    function save_product($project_id = null, $category_id = null) {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Photo_model');
            $id_use = $this->session->userdata('user_info');
            $photo = $this->Photo_model->getPhotoProduct($this->input->post('id_photo'), $id_use['id']);
            if (isset($_POST) && $_POST != null) {
                $record = $this->Photo_model->get_product($_POST['id_photo'], $id_use['id']);
                if ($record == null) {
                    $arrs = array(
                        "member_id" => $id_use['id'],
                        "product_name" => $this->input->post('product_name'),
                        "created_at" => date('Y-m-d H:i:s'),
                        "product_no" => $this->input->post('product_no'),
                        "photo_id" => $this->input->post('id_photo'),
                        "comments" => $this->input->post('comments'),
                        "price" => $this->input->post('price'),
                        "qty" => $this->input->post('qty'),
                        "product_note" => $this->input->post('product_notes'),
                        "fob" => $this->input->post('fob'),
                        "category_id" => $category_id,
                        "point" => $this->input->post('review')
                    );
                    $id = $this->Photo_model->add_productmyphoto($arrs);
                } else {
                    $arrs = array(
                        "product_name" => $this->input->post('product_name'),
                        "product_no" => $this->input->post('product_no'),
                        "comments" => $this->input->post('comments'),
                        "price" => $this->input->post('price'),
                        "qty" => $this->input->post('qty'),
                        "product_note" => $this->input->post('product_notes'),
                        "fob" => $this->input->post('fob'),
                        "category_id" => $category_id,
                        "point" => $this->input->post('review')
                    );
                    $this->Photo_model->update_product($record['product_id'], $arrs, $this->input->post('id_photo'));
                    $record = $this->Photo_model->get_product($this->input->post('id_photo'), $id_use['id']);
                }
            }
        }
    }

    public function deletePhoto_product($product_id = null, $category_id = null, $photo_id = null) {
        if (isset($this->user_info["id"])) {
            $this->load->model('Product_model');
            $this->load->model('Photo_model');
            $this->load->model('Product_category_model');
            $this->Photo_model->deletePhoto($photo_id, $this->user_info["id"]);
            $product = $this->Product_model->seclect_product($photo_id, $this->user_info["id"]);
            if ($product != null) {
                foreach ($product as $key) {
                    $this->Product_model->delete_product($key['product_id'], $this->user_info["id"]);
                }
            }

            $product_cat = $this->Product_category_model->seclect_product_cat($category_id);
            if ($product_cat > 0) {
                $this->Product_category_model->delete_product_cat($category_id, $photo_id);
            }

            redirect('/designwalls/designphotos/' . $product_id . '/' . $category_id . '');
        }
    }
     
    public function upgrade() {
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data['package'] = $this->Common_model->get_result('packages', array(
            'type' => 1
        ),null,null,[["field"=>"max_files" ,"sort" => "ASC"]]);
        $this->session->unset_userdata('info_credit');
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Upgrade";
        $this->data['skins'] = 'upgrade';
        $this->load->view('block/header', $this->data);
        $this->load->view('designwalls/upgrade', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function plan($id = null) {
        if ($id == null || !is_numeric($id)) {
            redirect('/designwalls/upgrade');
        }

        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data['package'] = $this->Common_model->get_result('packages', array(
            'type' => 1, 'id' => $id
        ));
        if ($this->data['package'] == null || count($this->data['package']) <= 0) {
            redirect('/designwalls/upgrade');
        }

        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Upgrade";
        $this->data['skins'] = 'upgrade';
        $this->load->view('block/header', $this->data);
        $this->load->view('designwalls/plan', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    function designaddphotos($project_id = null, $category_id = null) {
        // Load model
        $this->load->model('Photo_model');
        $this->load->model('Category_model');
        $this->load->model('Project_model');
        $this->load->model('Keyword_model');
        $this->load->helper('form');
        $data['title'] = 'Add Photos';

        // Check project and category
        $back_url = "";
        // Check project

        $result = $this->Project_model->get_project($project_id, $this->user_info["id"]);
        $owner_member_id = null;
        if ($result == null) {
            redirect("/designwalls/designwall/");
        }

        $this->_owner_id_project = $result["member_id"];
        $owner_member_id = $result["member_id"];
        $back_url.= '<a href="/designwalls/designwall/">' . $result["project_name"] . '</a>';

        // Check category
        $result_cat = $this->Project_model->get_project_category($category_id);
        if ($result_cat == null) {
            redirect("/designwalls/designform/" . $project_id);
        }

        $back_url.= ' >> <a href="/designwalls/designform/' . $project_id . '">' . $result_cat["title"] . '</a>';
        $back_url.= ' >> <a href="/designwalls/designphotos/' . $project_id . '/' . $category_id . '">Photos</a> >> Add Photos';
        $data["title_header"] = $back_url;
        $data["project_id"] = $project_id;
        $data["category_id"] = $category_id;
        $data["url_microsite"] = microsite_company(0, @$this->user_info["id"], @$this->user_info['business_type'], @$this->user_info["company_name"]);

        // let's consider that the form would come with more fields than just the files to be uploaded. If this is the case, we would need to do some sort of validation. If we are talking about images, the only method of validation for us would be to put the upload process inside a validation callback;
        $this->load->library('form_validation');
        // now we set a callback as rule for the upload field

        $this->form_validation->set_rules('fileImages[]', 'Upload image', 'callback_fileupload_check');
        if ($this->input->post()) {
            // run the validation
            if ($this->form_validation->run()) {
                /* Save to database */
                $this->load->model('Photo_keyword_model');
                $this->load->model('Photo_category_model'); // Select multi categories in trees
                $catids = $this->input->post('catids'); // Select multi categories in trees
                $product_type = $this->input->post('product_type');
                $keywords = $this->input->post('keywords');
                $product_name = $this->input->post('product_name');
                $product_no = $this->input->post('product_no');
                $product_url = $this->input->post('product_url');
                $product_manufacture = $this->input->post('product_manufacture');
                $comments = $this->input->post('comments');
                $social_network = $this->input->post('social_network');
                $image_category = $this->input->post('image_category');
                $social_message = $this->input->post('social_message');
                $product_contact_rep = $this->input->post('product_contact_rep');
                $product_contact_email = $this->input->post('product_contact_email');
                $product_contact_phone = $this->input->post('product_contact_phone');
                $photo_cat_parent = $this->input->post("photo_cat_parent");
                $other_img = $this->input->post('other_photo');
                $cat_sever = $this->input->post('cat_sever');
                $other_img = json_decode($other_img, true);
                $photo_cat_parent = json_decode($photo_cat_parent, true);
                $cat_sever = json_decode($cat_sever, true);
                $arr_categories = json_decode($catids, true);

                // Save database for keyword with keywords

                $keywordids = "";
                if (!empty($keywords)) {
                    $keywords = explode(',', $keywords);
                    foreach ($keywords as $keyword) {
                        $keyword = trim($keyword);

                        // If exists then get id

                        $result = $this->Keyword_model->get_item($keyword);
                        if ($result != null && !empty($result["keyword_id"])) {
                            $keywordids.= empty($keywordids) ? $result["keyword_id"] : "," . $result["keyword_id"];
                        } else {
                            $keyword_id = $this->Keyword_model->add_item($keyword);
                            $keywordids.= empty($keywordids) ? $keyword_id : "," . $keyword_id;
                        }
                    }
                }

                $arr_keywords = array();
                if (!empty($keywordids)) {
                    $arr_keywords = explode(',', $keywordids);
                }

                if (sizeof($this->_uploaded) > 0) {
                    $is_update = false;
                    foreach ($this->_uploaded as $key => $file_item) {
                        $arr = array(
                            'member_id' => $owner_member_id, // $this->user_info["id"],
                            'name' => empty($product_name) ? "Image Name" : $product_name,
                            'created_at' => date("Y-m-d H:i:s"),
                            'type' => '4', // Design wall
                            'path_file' => '/uploads/member/' . $owner_member_id . '/' . $file_item["file_name"], // $this->user_info["id"]
                            'product_name' => $product_name,
                            'product_no' => $product_no,
                            'product_title' => $product_type,
                            'product_note' => $comments,
                            'product_url' => $product_url,
                            'product_manufacture' => $product_manufacture,
                            'product_contact_rep' => $product_contact_rep,
                            'product_contact_email' => $product_contact_email,
                            'product_contact_phone' => $product_contact_phone,
                            'social_network' => $social_network,
                            'image_category' => $image_category,
                            'social_message' => $social_message,
                            'thumb' => $this->_uploadedthumb[$key],
                        );
                        $photo_id = $this->Photo_model->add_photo($arr);
                        if ($photo_id !== "") {
                            $new_recoder = array();
                            $data_inser = array();
                            $data_inser_items = array();
                            $data_inser_new = array();
                            $data_inser_photo_cay = "";
                            $data_inser_photo_cay_new = "";
                            $arg = "";
                            if (!empty($photo_cat_parent) && count($photo_cat_parent) > 0 && $photo_cat_parent != null) {
                                foreach ($photo_cat_parent as $value) {
                                    $value['id_photo'] = $photo_id;
                                    $new_recoder[] = $value;
                                }

                                $this->Photo_model->inser_other_categore($new_recoder);
                            }

                            $new_table = "";
                            if (!empty($cat_sever) && $cat_sever != null) {
                                foreach ($cat_sever as $key => $value) {
                                    $value['photo_id'] = $photo_id;
                                    $new_table[] = $value;
                                }

                                if (!empty($new_table) && $new_table != null && count($new_table) > 0) {
                                    $this->Photo_category_model->add_photo_cat_batch($new_table);
                                }
                            }

                            if (!empty($other_img) && $other_img != null && count($other_img) > 0) {
                                foreach ($other_img as $key => $value) {
                                    $data_inser = array(
                                        'pid' => $value['pid'],
                                        'title' => $value['title'],
                                        'slug' => $this->slug_category($value['title']),
                                        'type' => "custom"
                                    );
                                    $id_cat_insert = $this->Category_model->add_category($data_inser, true);
                                    $data_inser_photo_cay['category_id'] = $id_cat_insert;
                                    $data_inser_photo_cay['photo_id'] = $photo_id;
                                    $data_inser_photo_cay['first_child_category'] = $value['first_child_category'];
                                    $data_inser_photo_cay_new[] = $data_inser_photo_cay;
                                }

                                if (!empty($data_inser_photo_cay_new) && $data_inser_photo_cay_new != null && count($data_inser_photo_cay_new) > 0) {
                                    $this->Photo_category_model->add_photo_cat_batch($data_inser_photo_cay_new);
                                }
                            }

                            $arr_categories_new = "";
                            if (!empty($arr_categories)) {
                                foreach ($arr_categories as $key => $value) {
                                    $value['photo_id'] = $photo_id;
                                    $arr_categories_new[] = $value;
                                }
                            }
                            if (count($arr_categories_new) != 0) {
                                $this->Photo_category_model->add_photo_cat_batch($arr_categories_new);
                            }
                        }
                        // Update for category with path_file
                        if (!$is_update) {
                            $array = array(
                                'path_file' => '/uploads/member/' . $owner_member_id . '/' . $file_item["file_name"]
                            );
                            $this->Project_model->update_project_category($array, $category_id);
                            $is_update = true;
                        }
                        // Add photo_id and category_id into table Product_Category (Relative: 1-1)
                        $this->Photo_model->add_photo_product_category(array(
                            'product_id' => $photo_id,
                            'category_id' => $category_id
                        ));
                        // Add keyword
                        if (count($arr_keywords) > 0) {
                            $this->Photo_keyword_model->add_photo_item($arr_keywords, $photo_id);
                        }
                    }

                    redirect("/designwalls/designphotos/" . $project_id . "/" . $category_id . "");
                }
            }
        }

        // Get all photo to display in grid
        $data['categories'] = $this->Category_model->getAll();
        // Get all design wall
        $data['item'] = $this->Members_model->getById($this->user_info['id']);
        $data['categories'] = $this->Category_model->getAll();
        $data['photos'] = $this->Photo_model->getAllPhotos($this->user_info["id"]);
        $data['categories_mt'] = $this->Category_model->get_cat_perant();
        $data['categories_type'] = $this->Category_model->get_cat_checkradio();
        $categories_type = array();
        foreach ($data['categories_type'] as $value) {
            $categories_type[] = $value['id'];
        }

        $data['categories_type'] = $this->Category_model->get_lits_cat_parents($categories_type);
        $data["left_projects"] = $this->Project_model->get_project_invite_member($this->user_info["id"]);
        $this->load->view('include/header', $this->data);
        $this->load->view('include/left-profile', $data);
        $this->load->view('profile/designaddphotos', $data);
        $this->load->view('include/right', $data);
        $this->load->view('include/footer', $data);
    }

    function slug_category($tring) {
        strtolower($tring);
        str_replace(" ", "-", $tring);
        str_replace("/", "-", $tring);
        return $tring;
    }

    function success($package_id = null) {
        if (isset($package_id) && is_numeric($package_id)) {
            // Update type member
            $this->load->model('Members_model');
            $array = array(
                "type_member" => $package_id
            );
            $this->load->library("session");
            $this->session->set_userdata("type_member", $package_id);
            // update profile for user
            $data['categories'] = $this->Category_model->getAll();
            $this->Members_model->updateProfile($array, $this->user_info["id"]);
            $data["messages"] = "You have successfully paid for package " . $package_id;
            $this->load->view('include/header', $this->data);
            $this->load->view('include/left', $data);
            $this->load->view('profile/success', $data);
            $this->load->view('include/right', $data);
            $this->load->view('include/footer', $data);
        } else {
            redirect("/profile");
        }
    }

    function cancel($package_id = null) {
        // Redirect to profile
        redirect("/profile");
    }

    // Define a callback and pass the format of date
    function valid_date($date) {
        $format = 'Y-m-d';
        $d = DateTime::createFromFormat($format, $date);
        // Check for valid date in given format
        if ($d && $d->format($format) == $date) {
            return TRUE;
        } else {
            $this->form_validation->set_message('valid_date', '%s date is not valid it should match this (' . $format . '::' . $field_name . ') format');
            return FALSE;
        }
    }

    function date_compare($value, $field_name) {
        if (!$this->valid_date($value)) {
            return FALSE;
        }

        if (strtotime($value) < strtotime($this->input->post($field_name))) {
            $this->form_validation->set_message('date_compare', 'Due Date must be greater than Start Date');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // Project
    function project() {
        $data['title'] = 'Project Info';
        $this->load->view('include/header', $this->data);
        $this->load->view('include/left', $data);
        $this->load->view('profile/project', $data);
        $this->load->view('include/right', $data);
        $this->load->view('include/footer', $data);
    }

    public function addComment($id = null) {
        $this->load->model('Photo_model');
        if ($this->input->is_ajax_request() && isset($id) && $id != null) {
            $text = $this->input->post('text');
            $text = preg_replace('~<div>~', '<br />', $text);
            $text = preg_replace('~</div>~', '', $text);
            $data = array(
                "member_id" => $this->user_info["id"],
                "photo_id" => $id,
                "comment" => $text,
                'created_at' => date('Y-m-d H:i:s')
            );
            $id_comment = $this->Photo_model->addComment($data);
            if (isset($id_comment) && $id_comment != null) {
                $result = $this->Photo_model->getComment($id);
                $record = $this->Photo_model->getPhotoProduct($id, $this->user_info["id"]);
                $list_email = '';
                foreach ($result as $value) {
                    $list_email.= $value['email'] . ",";
                }

                $message = "
            <table>
            <tr><td style='margin-bottom: 20px;float: left;'>If you do not know " . @$this->session->userdata['user_info']['full_name'] . ", click here:</td> </tr>
            <tr><td  style='margin-bottom: 20px;float: left;'>To view comments, simply click here:<a href='" . base_url() . "/designwalls/designphotos/" . $_POST['project_id'] . "/" . $_POST['category_id'] . "/?token=" . $id . "' style='padding:5px 10px;color:#fff;background:#ffa100;'>View Comment</a></td></tr>
            <tr><td  style='margin-bottom: 20px;float: left;'><a href='" . base_url() . "'><img src='" . base_url() . "skins/images/logo-design-wall.png'></a></td></tr>
            <tr><td  style='margin-bottom: 20px;float: left;'>DEZIGNWALL, Inc. | \"The entire commercial design and products industry, at your fingertips\"<br /></td></tr>
            </table>";
                $subject = "DEZIGNWALL, Inc.";
                $from = @$this->session->userdata['user_info']['full_name'] . ' posted a comment to ' . @$record['product_name'] . ' - #' . @$record['product_no'];
                $this->sendmail_invite($list_email, $subject, $message, $from);
                die('true');
            }
        }

        die('false');
    }

    function sendmail_invite($email, $subject, $message, $from) {
        $this->load->library('email');
        $this->email->from('noreply@dezignwall.com', $from);
        $this->email->to($email);
        $this->email->set_mailtype("html");
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    public function getComment($photo_id = null) {
        $this->load->model('Photo_model');
        $result = array(
            "status" => "error"
        );
        if ($this->input->is_ajax_request() && isset($photo_id) && $photo_id != null) {
            $result = $this->Photo_model->getComment($photo_id);
            die(json_encode($result));
        }

        die(json_encode($result));
    }

    public function getRate($photo_id = null) {
        $result = 0;
        $this->load->model('Photo_model');
        if ($this->input->is_ajax_request() && isset($photo_id) && $photo_id != null) {
            $record = $this->Photo_model->getRate($photo_id);
            $result = $record['rate_num'];
        }

        die($result);
    }

    public function add_photo_type($photo_id) {
        $member_id = $this->user_info["id"];
        $this->load->model('Photo_model');
        $this->load->model('Members_model');
        $tbale = $this->Members_model->check_type_member($member_id);
        $maxfile = 6;
        if ($tbale) {
            foreach ($tbale[0] as $key) {
                $maxfile = $key['max_files'];
            }
        }

        $value = count($tbale);
        if ($value >= $maxfile) {
            redirect('' . base_url() . 'packages/');
        } else {
            $arr = array(
                'type' => 3
            );
            $this->Photo_model->saveAttributePhoto($photo_id, $member_id, $arr);
            redirect('' . base_url() . 'profile/myphoto/');
        }
    }

    public function addRate($photo_id = null) {
        $result = "false";
        $this->load->model('Photo_model');
        if ($this->input->is_ajax_request() && isset($photo_id) && $photo_id != null) {
            $record = $this->Photo_model->getFind($this->user_info["id"], $photo_id);
            if (isset($record) && $record != null) {
                $this->Photo_model->updateRate(array(
                    "num" => $this->input->post('num')
                        ), $this->user_info["id"], $photo_id);
            } else {
                $arr = array(
                    "photo_id" => $photo_id,
                    "member_id" => $this->user_info["id"],
                    "num" => $this->input->post('num'),
                    "created_at" => date('Y-m-d H:i:s')
                );
                $this->Photo_model->addRate($arr);
            }

            $result = "true";
        }

        die($result);
    }

    public function emailnotification() {
        $this->load->model('Project_model');
        $data['title'] = 'Email notification';
        $data['categories'] = $this->Category_model->getAll();
        $data["left_projects"] = $this->Project_model->get_project_invite_member($this->user_info["id"]);
        $this->load->view('include/header', $this->data);
        $this->load->view('include/left', $data);
        $this->load->view('profile/email_notification', $data);
        $this->load->view('include/right', $data);
        $this->load->view('include/footer', $data);
    }

    public function moving_img($photo_id, $categorie_id, $cat_id_update, $project_id) {
        $this->load->model("Product_category_model");
        try {
            $this->Product_category_model->update_cat($photo_id, $categorie_id, $cat_id_update);
            die("ok");
        } catch (Exception $e) {
            die("error");
        }
    }
    public function delete($id = null){
        if($id != null){
            $filter = ["project_id" => $id,"member_id"=> $this->user_id];
            $check = $this->Common_model->get_record('projects',$filter);
            if($check != null && $check["type_project"] =="custom"){
                $this->Common_model->delete("projects",$filter);
            }
        }
        redirect(base_url("designwalls"));
    }
    public function view_photos($product_id = null){
        if (empty($product_id) || !is_numeric($product_id)) {
            redirect(base_url());
        }
        $record_product = $this->Common_model->get_record("products",array("product_id"=>$product_id));
        $photo_id = "";
        if($record_product != null){
            $photo_id = $record_product["photo_id"];
        } else {
            redirect(base_url());
        }
        if ($photo_id != "" && is_numeric($photo_id)) {
            $this->data["view_wrapper"] = "designwalls/single-image";
            $this->data["class_wrapper"] = "image-page";
            $this->load->model("Members_model");
            $this->load->model("Photo_model");
            $recorder_photo = $this->Common_model->get_record("photos", array(
                "photo_id" => $photo_id, "status_photo" => 1
            ));
            $record = $this->Common_model->get_record("members", array( 'id' =>$this->user_id));
            $this->data['member'] = $record;
            $this->data["company_info"] = $this->Common_model->get_record("company", array(
                'member_id' => $this->user_id
            ));
            $this->data["is_login"] = true;
            if (count($recorder_photo) > 0 && $recorder_photo != null) {
                $recorder_user = $this->Members_model->get_information_user($recorder_photo["member_id"]);
                $data_share = '<meta name="og:image" content="' . base_url($recorder_photo['path_file']) . '">
                            <meta id ="titleshare" property="og:title" content="'.$recorder_user["company_name"].' just shared '. $recorder_photo["name"] . ' on @Dezignwall TAKE A LOOK" />
                            <meta property="og:description" content="' . $recorder_photo["description"] . '" />
                            <meta property="og:url" content="' . base_url("designwalls/view_photos/" .$product_id). '" />
                            <meta property="og:image" content="' . base_url($recorder_photo['thumb']) . '" />';
                $this->data["data_share"] = $data_share;
                $this->data["description_page"] = $recorder_photo["description"];
                // Get comment of this photo
                $record_comment = $this->Photo_model->get_comment_photo($product_id,0,10,"product");
                $datime = date('Y-m-d H:i:s');
                $ip = $this->input->ip_address();
                $common_tracking = $this->Common_model->get_record("common_tracking", array(
                    "reference_id" => $product_id,
                    "type_object" => "product"
                ));
                $like = $this->Common_model->get_result("common_like", array(
                    "reference_id" => $product_id,
                    "status" => 1,
                    "type_object" => "product"
                ));
                $record_involve = $this->Photo_model->get_ram_photo(array(
                    "member_id" => $recorder_photo["member_id"],
                    "photo_id !=" => $product_id,
                    "type" => 2
                        ), 4);
                $user_total_like = $this->Common_model->get_record("common_like", array(
                    "reference_id" => $product_id,
                    "member_id" => $this->user_id,
                    "type_object" => "product"
                ));
                $record_type = $this->Common_model->get_record("members", array("id" => $record_product["member_id"]));
                $this->load->model("Photo_keyword_model");
                $this->data["product_id"] = $product_id;
                $record_keyword = $this->Photo_keyword_model->get_photo_keyword_byid($photo_id);
                $this->data["data_wrapper"]["view_product"] = TRUE;
                $this->data["data_wrapper"]["photo"] = $recorder_photo;
                $this->data["data_wrapper"]["user"] = $recorder_user;
                $this->data["data_wrapper"]["record_pin"] = (isset($common_tracking) && count($common_tracking) > 0) ? $common_tracking["qty_pintowall"] : 0;
                $this->data["data_wrapper"]["comment"] = (isset($common_tracking) && count($common_tracking) > 0) ? $common_tracking["qty_comment"] : 0;
                $this->data["data_wrapper"]["record_comment"] = $record_comment;
                $this->data["data_wrapper"]["like"] = $like;
                $this->data["data_wrapper"]["user_total_like"] = $user_total_like;
                $this->data["data_wrapper"]["record_involve"] = $record_involve;
                $this->data["data_wrapper"]["keyword"] = $record_keyword;
                $this->data["data_wrapper"]["point"] = $this->Common_model->get_result('images_point', array(
                    'photo_id' => $photo_id
                ));
                $this->data["record_type"] = $record_type["type_member"];
                $this->data["title_page"] = $recorder_photo["name"];
                $this->load->view('block/header', $this->data);
                $this->load->view('block/wrapper', $this->data);
                $this->load->view('block/footer');
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }
    private function gen_slug($str){
        $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
        $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
    }
    public function get_slider(){
        $data = array("status" => "error","message" => null,"response" => null);
        if( $this->input->is_ajax_request() ){
            $id = $this->input->post("id");
            $this->db->select("tb3.path_file AS path,tb3.name,tb2.product_id");
            $this->db->from("project_categories AS tb1");
            $this->db->join("products AS tb2","tb1.category_id = tb2.category_id");
            $this->db->join("photos AS tb3","tb2.photo_id = tb3.photo_id");
            $this->db->where("tb1.category_id",$id );
            $query = $this->db->get();
            $data["response"] = $query->result_array();
            $data["status"]   = "success";
        }
        die(json_encode($data));
    }
}

/* End of file profile.php */
/* Location: ./application/controllers/DesignWalls.php */