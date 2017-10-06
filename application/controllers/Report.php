<?php
class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index($photo_id = null) {
        $this->load->model('Members_model');
        $is_login_report = $this->session->userdata('is_login_report');
        $data = array();
        if ($is_login_report) {
            $data['list'] = $this->Members_model->get_list_company();
            $this->load->view("report/includes/header", $data);
            $this->load->view("report/index", $data);
        } else {
            $this->load->view("report/includes/header", $data);
            $this->load->view("report/login", $data);
        }
    }

    public function login() {
        $user = $this->input->post('user');
        $pw = $this->input->post('password');
        if ($user == 'admin' && $pw == 'admin123') {
            $this->session->set_userdata('is_login_report', true);
        }
        redirect('/report');
    }

    public function user_conversion() {
        $is_login_report = $this->session->userdata('is_login_report');
        if ($is_login_report) {
            $this->load->model('Members_model');
            $data['list'] = $this->Members_model->get_list_user_conversion();
            $this->load->view("report/includes/header", $data);
            $this->load->view("report/user_conversion", $data);
        } else
            redirect('/report');
    }
    public function edit_user_password (){
        $is_login_report = $this->session->userdata('is_login_report');
         if ($is_login_report) {
            $this->load->model('Members_model');
            $data['list'] = $this->Members_model->get_list_user_conversion();
            $this->load->view("report/includes/header", $data);
            $this->load->view("report/edit_user_password", $data);
        } else
            redirect('/report');
    }
    public function change_password($id = null){
        $is_login_report = $this->session->userdata('is_login_report');
        if ($is_login_report) {
            if($id != null){
                $check = $this->Common_model->get_record("members",["id" => $id]);
                if($check != null){
                    if($this->input->post() ){
                        $password = $this->input->post("password");
                        if( strlen( trim($password) ) < 6){
                            $data["error"] = "Password must be at least 6 characters long";
                        }else{
                            $pwd = md5( strtolower($check["email"]) . ":" . md5(trim($password)) );
                            $this->Common_model->update("members",["pwd" => $pwd],["id" => $id]);
                            $data["error"] = "Change password successfully";
                        }
                    }
                    $data["user"] = $check;
                    $this->load->view("report/includes/header", $data);
                    $this->load->view("report/change_password", $data);
                }else
                    redirect('/report');
            }else
                redirect('/report');
        } else
            redirect('/report');
    }
    public function activity() {
        $is_login_report = $this->session->userdata('is_login_report');
        if ($is_login_report) {
            $this->load->model('Members_model');
            $this->load->model('Photo_model');
            $this->load->model('Common_model');
            
            $data['list'] = $this->Members_model->get_list_activity2();
            if ($data['list'] != null && count($data['list']) > 0) {
                foreach ($data['list'] as $key => $item) {
            		/* Begin: Get photo by member */
			        $photo_id = "";
			        $record_photo = [];
			        $filter = array("name !=" => NULL, 'member_id' => $item['id']);
			        $get_photo = $this->Common_model->get_result("photos", $filter, 0, 500);
			        if ($get_photo != null && count($get_photo) > 0) {
				        foreach ($get_photo as $value) {
				            $photo_id = "," . $value["photo_id"];
				        }
				        if (!empty($photo_id)) {
					        $photo_id = substr($photo_id,1);
		                	$this->db->select("c.*,pt.photo_id");
					        $this->db->from("photos AS pt");
					        $this->db->join("photo_category AS pc", "pc.photo_id =  pt.photo_id AND pt.photo_id IN ({$photo_id})");
					        $this->db->join("categories AS c", "c.id =  pc.category_id");
					        $cat_photo = $this->db->get()->result_array();
					        $this->db->select("k.*,pt.photo_id");
					        $this->db->from("photos AS pt");
					        $this->db->join("photo_keyword AS pk", "pk.photo_id =  pt.photo_id AND pt.photo_id IN ({$photo_id})");
					        $this->db->join("keywords AS k", "k.keyword_id =  pk.keyword_id");
					        $keyword_photo = $this->db->get()->result_array();
					        
		    				foreach ($get_photo as $value_1) {
					            $value_1["style"] = [];
					            $value_1["location"] = [];
					            $value_1["service"] = [];
					            $value_1["category"] = [];
					            $value_1["indoor-outdoor-both"] = [];
					            $value_1["keyword"] = [];
					            $value_1["certifications"] = [];
					            $size = filesize(FCPATH . $value_1["path_file"]);
					            $value_1["size"] = $size;
					            $value_1["created_at"] = $value["created_at"];
					            foreach ($cat_photo as $value_0) {
					                if ($value_0["photo_id"] == $value_1["photo_id"]) {
					                    if ($value_0["parents_id"] == 3) {
					                        $value_1["style"][] = $value_0["title"];
					                    } else if ($value_0["parents_id"] == 346) {
					                        $value_1["indoor-outdoor-both"][] = $value_0["title"];
					                    } else if ($value_0["parents_id"] == 258) {
					                        $value_1["service"][] = $value_0["title"];
					                    } else if ($value_0["parents_id"] == 263) {
					                        $value_1["certifications"][] = $value_0["title"];
					                    }if ($value_0["parents_id"] = 215) {
					                        $value_1["location"][] = $value_0["title"];
					                    } else if($value_0["parents_id"] == 9 || $value_0["parents_id"] == 192) {
					                        $value_1["category"][] = $value_0["title"];
					                    }
					                }
					            }
					            foreach ($keyword_photo as $value_2) {
					                if ($value_2["photo_id"] == $value_1["photo_id"]) {
					                    $value_1["keyword"][] = $value_2["title"];
					                }
					            }
					            $record_photo[] = $value_1;
					        }
	            		}
	            	}
                	$data['list'][$key]['photos'] = $record_photo;
                	/* End: Get photo by member */
                }
            }
            $this->load->view("report/includes/header", $data);
            $this->load->view("report/activity", $data);
        } else
            redirect('/report');
    }

    function initial($page = 0) {
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
          redirect('/report');
        }

        $page = $page > 0 ? ($page - 1) : $page;
        $offset = $page * 20;
        $filter = array(
            "job_title" => "",
            "logo" => "",
            "banner" => NULL,
            "avatar" => ""
        );
        $data["total_page"] = $this->Common_model->count_table("members", $filter);
        $data["paging"] = $page + 1;
        $data["arg_member"] = $this->Common_model->get_result("members", $filter, $offset, 20);
        $this->load->view("report/includes/header", $data);
        $this->load->view("report/initial", $data);
    }

    function return_user($page = 0) {
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
            redirect('/report');
        }
        $page = $page > 0 ? ($page - 1) : $page;
        $offset = $page * 20;
        $this->load->model("Members_model");
        $data["total_page"] = count($this->Members_model->count_member_login());
        $data["paging"] = $page + 1;
        $data["arg_member"] = $this->Members_model->count_member_login($offset, 20);
        $this->load->view("report/includes/header", $data);
        $this->load->view("report/return_user", $data);
    }

    function created_profile($page = 0) {
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
            redirect('/report');
        }

        $page = $page > 0 ? ($page - 1) : $page;
        $offset = $page * 20;
        $this->load->model("Members_model");
        $data["total_page"] = count($this->Members_model->get_member_update_profile());
        $data["paging"] = $page + 1;
        $data["arg_member"] = $this->Members_model->get_member_update_profile(20, $offset);
        $this->load->view("report/includes/header", $data);
        $this->load->view("report/created_profile", $data);
    }

    function engagement($page = 0) {
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
            redirect('/report');
        }

        $page = $page > 0 ? ($page - 1) : $page;
        $offset = $page * 20;
        $this->load->model("Members_model");
        $data["total_page"] = count($this->Members_model->engagement());
        $data["paging"] = $page + 1;
        $data["arg_member"] = $this->Members_model->engagement($offset, 20);
        $this->load->view("report/includes/header", $data);
        $this->load->view("report/engagement", $data);
    }

    function advanced($page = 0) {
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
            redirect('/report');
        }

        $page = $page > 0 ? ($page - 1) : $page;
        $offset = $page * 20;
        $this->load->model("Members_model");
        $data["total_page"] = count($this->Members_model->advanced());
        $data["paging"] = $page + 1;
        $data["arg_member"] = $this->Members_model->advanced(20, $offset);
        $this->load->view("report/includes/header", $data);
        $this->load->view("report/advanced", $data);
    }

    function user_info($page = 0) {
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
            redirect('/report');
        }

        $page = $page > 0 ? ($page - 1) : $page;
        $offset = $page * 20;
        $filter = array();
        $data["total_page"] = $this->Common_model->count_table("members");
        $data["paging"] = $page + 1;
        $data["arg_member"] = $this->Common_model->get_result("members", $filter, $offset, 20);
        $this->load->view("report/includes/header", $data);
        $this->load->view("report/user_info", $data);
    }

    function business_profile_info($page = 0) {
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
            redirect('/report');
        }

        $page = $page > 0 ? ($page - 1) : $page;
        $offset = $page * 20;
        $this->load->model("Members_model");
        $data["total_page"] = count($this->Members_model->get_member_update_profile(null, null, 1));
        $data["paging"] = $page + 1;
        $data["arg_member"] = $this->Members_model->get_member_update_profile(20, $offset, 1);
        $this->load->view("report/includes/header", $data);
        $this->load->view("report/business_profile_info", $data);
    }

    function photo_upload_info($page = 0) {
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
        	redirect('/report');
        }
        $data["curpage"] = $page;
        $page = $page > 0 ? ($page - 1) : $page;
        $offset = $page * 20;
        $filter = array("name !=" => NULL);
        $data["total_page"] = count($this->Common_model->get_result("photos", $filter));
        $data["paging"] = $page + 1;
        $get_photo = $this->Common_model->get_result("photos", $filter, $offset, 20, array(array("field" => "created_at", "sort" => "DESC")));
        $photo_id [] = -1;
        foreach ($get_photo as $value) {
            $photo_id[] = $value["photo_id"];
        }
        $photo_id = implode(",", $photo_id);
        $this->db->select("c.*,pt.photo_id,pt.priority_display,pt.created_at");
        $this->db->from("photos AS pt");
        $this->db->join("photo_category AS pc", "pc.photo_id =  pt.photo_id AND pt.photo_id IN({$photo_id})");
        $this->db->join("categories AS c", "c.id =  pc.category_id");
        $this->db->order_by("pt.created_at", "DESC");
        $cat_photo = ($this->db->get()->result_array());
        $recod_photo = [];
        $this->db->select("k.*,pt.photo_id");
        $this->db->from("photos AS pt");
        $this->db->join("photo_keyword AS pk", "pk.photo_id =  pt.photo_id AND pt.photo_id IN({$photo_id})");
        $this->db->join("keywords AS k", "k.keyword_id =  pk.keyword_id");
        $keyword_photo = ($this->db->get()->result_array());
        foreach ($get_photo as $value_1) {
            $value_1["style"] = [];
            $value_1["location"] = [];
            $value_1["service"] = [];
            $value_1["category"] = [];
            $value_1["indoor-outdoor-both"] = [];
            $value_1["keyword"] = [];
            $value_1["certifications"] = [];
            $size = filesize(FCPATH . $value_1["path_file"]) . " bytes";
            $value_1["size"] = $size;
            foreach ($cat_photo as $value_0) {
                if ($value_0["photo_id"] == $value_1["photo_id"]) {
                    if ($value_0["parents_id"] == 3) {
                        $value_1["style"][] = $value_0["title"];
                    } else if ($value_0["parents_id"] == 346) {
                        $value_1["indoor-outdoor-both"][] = $value_0["title"];
                    } else if ($value_0["parents_id"] == 258) {
                        $value_1["service"][] = $value_0["title"];
                    } else if ($value_0["parents_id"] == 263) {
                        $value_1["certifications"][] = $value_0["title"];
                    }if ($value_0["parents_id"] = 215) {
                        $value_1["location"][] = $value_0["title"];
                    } else if($value_0["parents_id"] == 9 || $value_0["parents_id"] == 192) {
                        $value_1["category"][] = $value_0["title"];
                    }
                }
            }
            foreach ($keyword_photo as $value_3) {
                if ($value_3["photo_id"] == $value_1["photo_id"]) {
                    $value_1["keyword"][] = $value_3["title"];
                }
            }
            $recod_photo [] = $value_1;
        }
        $data["arg_member"] = $recod_photo;
        $this->load->view("report/includes/header", $data);
        $this->load->view("report/photo_upload_info", $data);
    }

    public function priority($id) 
    {
        if ($id != null && is_numeric($id)) {
            // Get photo
            $row = $this->Common_model->get_record("photos", "photo_id='{$id}'");
            if ($row != null && count($row) > 0) {
                $priority = $row["priority_display"] == "low" ? "high" : "low";
                $this->Common_model->update("photos", array("priority_display" => $priority), array("photo_id" => $id));
            }
        }
        $page = $this->input->get("page");
        if ($page == null || !is_numeric($page)) {
            $page = "";
        }
        redirect('report/photo_upload_info/' . $page);
    }
    public function keywords($page = 0){
        $data["page"] = $page;
        $is_login_report = $this->session->userdata('is_login_report');
        if ($is_login_report) {
            $data["record"] = $this->Common_model->get_result("keywords",array("type" => "photo"),$page, 50,array(array("field" => "keyword_id", "sort" => "DESC")));
            $this->load->library('pagination');
            $config['base_url'] = base_url('report/keywords/');
            $config['total_rows'] = count( $this->Common_model->get_result("keywords",array("type" => "photo")) );
            $config['per_page'] = 50; 
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['next_link'] = 'Next &rarr;';
            $config['prev_link'] = '&larr; Previous';
            $config['first_link'] = '<< First';
            $config['last_link'] = 'Last >>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $this->pagination->initialize($config); 
           $this->load->view("report/includes/header");
           $this->load->view("report/keywords",$data);
        } else{
            redirect('/report/login');
        }
    }
    public function updatekeyword(){
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
            redirect('/report/login');
        }else{
            if ($this->input->is_ajax_request()) {
                $data['success'] = "error";
                $id = $this->input->post("id");
                $value = trim($this->input->post("value"));
                if($value != ""){
                    $this->Common_model->update("keywords",array("title" => $value),array("keyword_id" => $id));
                    $data['success'] = "success";
                    $data["record"] =  $this->Common_model->get_record("keywords",array("keyword_id" => $id));
                }
                
                die(json_encode($data));
            }else{
                die("error");
            }
        }
    }
    public function deletekeyword($id = null){
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
            redirect('/report/login');
        }else{
            $page = $this->input->get("page") ? $this->input->get("page") : "";
            if($id != null){
                $this->Common_model->delete("keywords",array("keyword_id" => $id));
            }
            redirect('/report/keywords/'.$page); 
        }
    }
    public function comment($page = 0){
    	$data["page"] = $page;
        $is_login_report = $this->session->userdata('is_login_report');
        if ($is_login_report) {
            $data["record"] = $this->Common_model->get_result("common_comment",null,$page, 50,array(array("field" => "id", "sort" => "DESC")));
            $this->load->library('pagination');
            $config['base_url'] = base_url('report/comment/');
            $config['total_rows'] = count( $this->Common_model->get_result("common_comment"));
            $config['per_page'] = 50; 
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['next_link'] = 'Next &rarr;';
            $config['prev_link'] = '&larr; Previous';
            $config['first_link'] = '<< First';
            $config['last_link'] = 'Last >>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $this->pagination->initialize($config); 
           $this->load->view("report/includes/header");
           $this->load->view("report/comment",$data);
        } else{
            redirect('/report/login');
        }
    }
    public function deletecomment($id = null){
        $is_login_report = $this->session->userdata('is_login_report');
        if (!$is_login_report) {
            redirect('/report/login');
        }else{
            $page = $this->input->get("page") ? $this->input->get("page") : "";
            if($id != null){
                $this->Common_model->delete("common_comment",array("id" => $id));
            }
            redirect('/report/comment/'.$page); 
        }
    }
    public function notification( $page = 0){
        $data["page"] = $page;
        $is_login_report = $this->session->userdata('is_login_report');
        if ($is_login_report){
            $data["record"] = $this->Common_model->get_result("notification",null,$page, 50,array(array("field" => "id", "sort" => "DESC")));
            $this->load->library('pagination');
            $config['base_url'] = base_url('report/conversations/');
            $config['total_rows'] = count( $this->Common_model->get_result("notification"));
            $config['per_page'] = 50; 
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['next_link'] = 'Next &rarr;';
            $config['prev_link'] = '&larr; Previous';
            $config['first_link'] = '<< First';
            $config['last_link'] = 'Last >>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $this->pagination->initialize($config); 
            $this->load->view("report/includes/header");
            $this->load->view("report/notification",$data);

        }else{
            redirect('/report/login');
        }
    }
    public function add_notification(){
        $is_login_report = $this->session->userdata('is_login_report');
        if ($is_login_report){
        	if($this->input->post()){
        		$images= "";
        		$this->load->library('form_validation');
        		$this->form_validation->set_rules('title', 'Title', 'required');
				$this->form_validation->set_rules('summary', 'Summary', 'required');
				if ($this->form_validation->run() == FALSE){
				}else{
	    		    if(isset($_FILES["images"]) && $_FILES["images"]["error"] == 0){
	                    $name = explode(".", $_FILES["images"]["name"]);
	                    $upload_path = FCPATH.'uploads/notification';
	                    if (!is_dir($upload_path)) {
	                        mkdir($upload_path, 0755, TRUE);
	                    }
	                    $config['upload_path'] = $upload_path;
	                    $config['allowed_types'] = 'gif|jpg|png';
	                    $config['max_size'] = '10485760'; // Byte
	                    $config['file_name'] = $name[0] .'-'. time();
	                    $this->load->library('upload', $config);
	                    if($this->upload->do_upload("images")){
	                    	$images = 'uploads/notification/'.$config['file_name'].'.'.$name[count($name) - 1];
	                    }
	                }
	                $title = $this->input->post("title");
	                $summary = $this->input->post("summary");
	                $content = $this->input->post("content");
	                $data_insert = array(
	                	"title" => $title,
	                	"summary" => $summary,
	                	"content" =>$content,
	                	"image"   => $images,
	                	"author"  => "admin",
	                	"created_at" => date("Y-m-d h:i:sa")
	                );
	                $this->Common_model->add("notification",$data_insert);
	                redirect('/report/notification');
	            }
        	}
            $this->load->view("report/includes/header");
            $this->load->view("report/add_notification"); 
        }else{
            redirect('/report/login');
        }
    }
    public function edit_notification($id = null){
    	$is_login_report = $this->session->userdata('is_login_report');
    	if($id !== null && $is_login_report){
    		if($this->input->post()){
        		$images= "";
        		$this->load->library('form_validation');
        		$this->form_validation->set_rules('title', 'Title', 'required');
				$this->form_validation->set_rules('summary', 'Summary', 'required');
				if ($this->form_validation->run() == FALSE){
				}else{
	    		    if(isset($_FILES["images"]) && $_FILES["images"]["error"] == 0){
	                    $row = $this->Common_model->get_record("notification", "id='{$id}'");
	                    $name = explode(".", $_FILES["images"]["name"]);
	                    $upload_path = FCPATH.'uploads/notification';
	                    if (!is_dir($upload_path)) {
	                        mkdir($upload_path, 0755, TRUE);
	                    }
	                    $config['upload_path'] = $upload_path;
	                    $config['allowed_types'] = 'gif|jpg|png';
	                    $config['max_size'] = '10485760'; // Byte
	                    $config['file_name'] = $name[0] .'-'. time();
	                    $this->load->library('upload', $config);
	                    if($this->upload->do_upload("images")){
	                    	$images = '/uploads/notification/'.$config['file_name'].'.'.$name[count($name) - 1];
	                    	if($row['image'] != "" && file_exists(FCPATH . $row['image'])){
	                    		unlink(FCPATH.'/'.$row["image"]);
	                    	}
	                    	
	                    }
	                }
	                $title = $this->input->post("title");
	                $summary = $this->input->post("summary");
	                $content = $this->input->post("content");
	                $data_update = array(
	                	"title" => $title,
	                	"summary" => $summary,
	                	"content" =>$content,
	                	"author"  => "admin"
	                );
	                if($images != ""){
	                	$data_update["image"] = $images;
	                }
	                $this->Common_model->update("notification",$data_update,array("id" => $id));
	            }
        	}
    		$row = $this->Common_model->get_record("notification", "id='{$id}'");
    		$data["record"] = $row;
    		$this->load->view("report/includes/header");
            $this->load->view("report/edit_notification",$data); 
    	}else{
    		redirect('/report/login');
    	}
    }
    public function delete_notification($id = null){
    	$is_login_report = $this->session->userdata('is_login_report');
    	if($id !== null && $is_login_report){
    		$this->Common_model->delete("notification",array("id" => $id));
    		redirect('/report/notification');
    	}else{
    		redirect('/report/login');
    	}
    }

    public function web_setting() {
        $is_login_report = $this->session->userdata('is_login_report');
        if ($is_login_report) {
            if($this->input->post()){
                $post = $_POST;
                foreach ($post as $key => $value) {
                    $this->Common_model->update("web_setting",array('selected_item' => $value), array("key_identify" => $key));
                }
            }

            $data['list'] = $this->Common_model->get_result("web_setting", "", 0, 1000);
            $this->load->view("report/includes/header", $data);
            $this->load->view("report/web_setting", $data);
        } else
            redirect('/report');
    }
    public function members($page = 0){
    	$data["page"] = $page;
    	$is_login_report = $this->session->userdata('is_login_report');
        if ($is_login_report) {
            $data["record"] = $this->Common_model->get_result("members",null,$page,50,array(array("field" => "id", "sort" => "DESC")));
            $this->load->library('pagination');
            $config['base_url'] = base_url('report/members/');
            $config['total_rows'] = count( $this->Common_model->get_result("members"));
            $config['per_page'] = 50; 
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['next_link'] = 'Next &rarr;';
            $config['prev_link'] = '&larr; Previous';
            $config['first_link'] = '<< First';
            $config['last_link'] = 'Last >>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $this->pagination->initialize($config); 
            $this->load->view("report/includes/header");
            $this->load->view("report/members",$data);
        } else
            redirect('/report');
    }
    public function get_category_children(){
        $data["status"] = "error";
        $data["reponse"] = null;
        if ($this->input->is_ajax_request()) {
            $is_login_report = $this->session->userdata('is_login_report');
            if($is_login_report){
                $all_cat = $this->Common_model->get_result("categories");
                $parents_id = $this->input->post("parents_id");
                $parents_id = explode(",", $parents_id);
                $not_show = $this->input->post("notshow"); 
                $not_show = explode(",", $not_show);
                $not_show  = array_diff($not_show,array(""));
                $value_term = $this->input->post("value");
                $all_cat_get = [];
                foreach ($parents_id as $key => $value) {
                    $all_cat_get = array_merge($all_cat_get,$this->get_children_cat($value,$all_cat));
                }
                $get_result_cat = null;
                $this->db->select("*");
                $this->db->from("categories");
                if($all_cat_get != null){
                    $this->db->where_in("id",$all_cat_get);
                }
                $this->db->like("title",$value_term,'after');
                if($not_show != null){
                    $this->db->where_not_in("title",$not_show);
                }
                $this->db->group_by("title");
                $query = $this->db->get();
                $get_result_cat = $query->result_array();
                $data["status"] = "success";
                $data["reponse"] = $get_result_cat;
                die(json_encode($data));
                
            }else{
                redirect('/report');
            }
        }
    }
    public function get_keyword(){
        $data["status"] = "error";
        $data["reponse"] = null;
        $is_login_report = $this->session->userdata('is_login_report');
        if ($this->input->is_ajax_request() && $is_login_report) {
            $not_show = $this->input->post("notshow");
            $not_show = explode(",", $not_show);
            $not_show  = array_diff($not_show,array(""));
            $value_term = $this->input->post("value");
            $this->db->select("*");
            $this->db->from("keywords");
            $this->db->like("title",$value_term,'after');
            if($not_show != null){
                $this->db->where_not_in("title",$not_show);
            }
            $this->db->group_by("title");
            $query = $this->db->get();
            $get_result_cat = $query->result_array();
            $data["status"] = "success";
            $data["reponse"] = $get_result_cat;
            die(json_encode($data));
        }else{
            redirect('/report');
        }
    }
    public function conver_id(){
        $data["status"] = "error";
        $is_login_report = $this->session->userdata('is_login_report');
        if ($this->input->is_ajax_request() && $is_login_report) {
            $arg_cat = [];
            $arg_kw  = [];
            $cat = $this->input->post("category");
            $kw  = $this->input->post("keyword");
            if($cat != null){
                foreach ($cat as $key => $value) {
                    if($value["id"] == "0"){
                        $parents_id = explode(",", $value["root"]);
                        $id = $this->Common_model->add("category",["title" => $value["value"],"pid" => $parents_id[0] ,"parents_id" => $parents_id[0]]);
                        $arg_cat [] = $parents_id[0]."->".$id; 
                    }else{
                        $arg_cat [] = $value["root"]."->".$value["id"]; 
                    }
                }
            }
            if($kw != null){
                foreach ($kw as $key => $value) {
                    if($value["id"] == "0"){
                        $parents_id = explode(",", $value["root"]);
                        $id = $this->Common_model->add("keywords",["title" => $value["value"],"type" => "photo"]);
                        $arg_kw [] = $id; 
                    }else{
                        $arg_kw [] = $value["id"]; 
                    }
                }
            } 
            $data["status"] = "success";
            $data ["category"] = implode(";",$arg_cat);
            die(json_encode($data));
        }else{
            redirect('/report');
        }
    }
    private $children_cat = array();
    private function get_children_cat($cat_id, $arg_full) {
        foreach ($arg_full as $key => $value) {
            if ($cat_id == $value["pid"] || $cat_id == $value["parents_id"]) {
                $this->children_cat[]= $value["id"];
                unset($arg_full[$key]);
                $this->get_children_cat($value["id"], $arg_full);
            }
        }
        return $this->children_cat;
    }
    public function export_member($member_id = null,$page = 0){
    	if($member_id != null){
    		$is_login_report = $this->session->userdata('is_login_report');
    		if ($is_login_report) {
    			$check_user = $this->Common_model->get_record("members",["id" => $member_id ]);
    			$all_cat = $this->Common_model->get_result("categories");
    			if($check_user){
    				$get_all_photo = $this->Common_model->get_result("photos",["member_id" => $member_id]);
    				$new_photo = [];
    				foreach ($get_all_photo as $key => $value) {
    					// get category.
    					$this->db->select("pct.*");
    					$this->db->from("photo_category AS pct");
    					$this->db->where("pct.photo_id",$value["photo_id"]);
    					$query = $this->db->get();
    					$get_category = $query->result_array();
    					$arg_cat = [];
    					$location = 0;
    					if($get_category != null){
    						foreach ($get_category as $key => $value_2) {
	    						$arg_cat [] = $value_2["first_child_category"].'->'.$value_2["category_id"];
	    					}
	    					$location = $value_2["location"];
    					}
    					$value["email_member"] = $check_user["email"];
    					$value["location"] = $location;
    					$value["category"] = implode(";",$arg_cat);
    					
    					//get keyword.
    					$all_keyword = $this->Common_model->get_result("photo_keyword",["photo_id" => $value["photo_id"]]);
    					$value["keyword"] = implode(";",array_column($all_keyword,'keyword_id'));
    					$new_photo []= $value;
    				}
    				$fileName = ''.$check_user["first_name"].' '.$check_user['last_name'].'.csv';
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header('Content-Description: File Transfer');
					header("Content-type: text/csv");
					header("Content-Disposition: attachment; filename={$fileName}");
					header("Expires: 0");
					header("Pragma: public");
					$fh = @fopen( 'php://output', 'w' );
					$headerDisplayed = false;
					foreach ( $new_photo as $data ) {
					    if ( !$headerDisplayed ) {
					        fputcsv($fh, array_keys($data));
					        $headerDisplayed = true;
					    }
					    fputcsv($fh, $data);
					}
					fclose($fh);
    			}		
    		}
    	}
    	exit();
    }
    public function get_category(){
    	$data = [];
    	$is_login_report = $this->session->userdata('is_login_report');
		if ($is_login_report) {
			$this->load->view("report/includes/header");
            $this->load->view("report/get_category",$data);
		}else{
			redirect('/report');
		}
    }
    public function _get_root_cat($data = [] , $id = null){
		foreach ($data as $key => $value) {
			if($value["id"] == $id){
				if($value["parents_id"] == 0){
					return $value["id"];
				}else{
					unset($data[$key]);
					$this->get_root_cat($data,$value["parents_id"]);
				}
			}	
		}
    }
}
