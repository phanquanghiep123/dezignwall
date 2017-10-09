<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company extends MY_Controller {
    private $user_id = null;
    private $is_login = false;
    public $data = null;
    private $is_sale_rep = false;
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->data["view_profile"] = false;
            $this->data["is_login"] = $this->is_login;
        }
        if ($this->session->userdata('user_sr_info')) {
            $this->is_sale_rep = true;
        }
        if($this->session->userdata('user_info') == null && $this->session->userdata('user_sr_info') == null){
            redirect (base_url("/"));
        }
        $this->load->helper(array('url', 'form'));
    }
    public function view($id = null) {
        $this->data['action'] = "view";
        $user_id = ($id == null) ? $this->user_id : $id;
        $this->data['activer_user'] = ($user_id ==  $this->user_id) ? false : true;
        $this->data['member_id'] = $user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data['is_owner'] = $this->user_id == $user_id ? false : true;
        $this->data["view_profile"] = true;
        $this->data["data_id"] = $id;
        $this->data["data_type"] ="company";
        $this->data["type_post"] = "profile";
        $this->data["id_post"] = $user_id;
        $this->data["is_login"] = $this->is_login;
        $this->data["is_blog"] = $record["is_blog"];
        if($this->data["is_blog"] == "yes"){
            $this->load->model("Article_model");
            $this->data["article"] = $this->Article_model->get_public_by_member($user_id);           
        }
        $this->data["title_page"] = "Profile";
        $this->data['user_id'] = $user_id;
        if (!(isset($record) && $record != null)) {
            redirect('/');
        }
        $company_info = $this->Common_model->get_record("company", array(
            'member_id' => $user_id
        ));
        if ($company_info !== null) {
            $use_add = 0;
            if($this->user_id != null){
                $use_add = $this->user_id;
            }
            $datime = date('Y-m-d H:i:s');
            $ip = $this->input->ip_address();
            $datainsert = array(
                "reference_id" => $company_info["id"],
                "member_owner" => $company_info["member_id"],
                "member_id"    => $use_add,
                "ip"           => $ip,
                "type_object"  => "company",
                "created_at"   => $datime,
                "createdat_profile" => $datime,
            );
            $this->Common_model->add("common_view", $datainsert);
            $common_tracking = $this->Common_model->get_record("common_tracking",["reference_id" => $company_info["id"],"type_object"=>"company"]);
            if($common_tracking){
                $qty_common_tracking = $common_tracking ["qty_view"] + 1;
                $this->Common_model->update("common_tracking",["qty_view" =>  $qty_common_tracking ],["reference_id" => $company_info["id"],"type_object"=>"company"]);
            }else{
                $data_insert = [
                    "reference_id" => $company_info["id"],
                    "type_object"  =>"company",
                    "qty_view"     => 1
                ];
                $this->Common_model->add("common_tracking",$data_insert);
            }
        }
        
        $record["is_follow"]  =  ($this->Common_model->get_record("common_follow",array("reference_id" => @$company_info["id"] ,"member_id" => $this->user_id,"type_object"   => "company")) != null);
        $record["is_favorite"]  =  ($this->Common_model->get_record("common_favorite",array("reference_id" => @$company_info["id"] ,"member_id" => $this->user_id,"type_object"   => "company")) != null);
        $record["company_id"] = @$company_info["id"];
        $record["company_name"] = @$company_info["company_name"];
        $record["business_type"] = @$company_info["business_type"];
        $record["business_description"] = @$company_info["business_description"];
        $record["logo"] = @$company_info["logo"];
        $record["banner"] = @$company_info["banner"];
        $this->data['member'] = $record;
        
        $this->data["company_info"] = $company_info;
        $this->data['photos'] = $this->Common_model->get_result('photos', array(
            'member_id' => $user_id,
            'type' => 2
                ), 0, 10);
        $data_share = ' <meta name="og:image" content="' . base_url($record['banner']) . '">
                        <meta property="og:title" content="' . $company_info["company_name"] . '" />
                        <meta id ="titleshare" property="og:title" content="'.$company_info["company_name"].' just shared on @Dezignwall TAKE A LOOK" />
                        <meta property="og:description" content="' . $company_info["business_description"] . '" />
                        <meta property="og:url" content="' . base_url("profile/index/" . $company_info["member_id"]) . '" />
                        <meta property="og:image" content="' . base_url($record['banner']) . '" />';
        $this->data["data_share"] = $data_share;
        $this->data["title_page"] = $company_info["company_name"];
        $this->data["description_page"] = $company_info["business_description"];
        $manufacturers1 = $this->Common_model->get_result("manufacturers",["member_id" => $user_id],null,null,[["field" => "createat","sort" =>"DESC"]]);
        $count_manufacturers = $this->Common_model->get_result("manufacturers",["member_id" => $user_id]);
        $this->data['manufacturers'] = $manufacturers1;
        $this->data['sow_manufacturers'] = (count($count_manufacturers) > 8) ? true : false;
        $this->load->view('block/header', $this->data);
        $this->load->view('profile/index', $this->data);
        $this->load->view("include/share", $this->data);
        $this->load->view("include/report-images");
        $this->load->view('block/footer', $this->data);
    }
    public function edit($param_social="") {
        $this->data['is_owner'] = false;
        $this->data['activer_user'] =  false;
        $this->data['action'] = "edit";
        if (!$this->is_login || $this->is_sale_rep) {
            redirect('/');
        } 
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data["type_post"] = "profile";
        $this->data["id_post"]   = $user_id;
        $this->data["status_member"] = $record["status_member"];
        $this->data["is_blog"] = $record["is_blog"];
        if($this->data["is_blog"] == "yes"){
            $this->load->model("Article_model");
            $this->data["article"] = $this->Article_model->get_public_by_member($user_id);        }
        if ($record["status_member"] == 0) {
            $this->Common_model->update("members", array("status_member" => 1), array("id" => $record["id"]));
        }
        $this->data["is_login"] = $this->is_login;
        $this->data["type_member"] = $this->user_info["type_member"];
        if($this->data["type_member"] == "1"){
            $this->data["show_reports"] = true;
            $this->data["view_profile"] = true;
        }else{
            $this->data["show_reports"] = false;
        }
        $this->data["title_page"] = "Edit Profile";
        
        $this->data["company_info"] = $this->Common_model->get_record("company", array(
            'member_id' => $user_id
        ));
        $record["is_favorite"]  =  ($this->Common_model->get_record("common_favorite",array("reference_id" => @$company_info["id"] ,"member_id" => $this->user_id,"type_object"   => "company")) != null);
        $record["is_follow"]  =  ($this->Common_model->get_record("common_follow",array("reference_id" => @$company_info["id"] ,"member_id" => $this->user_id,"type_object"   => "company")) != null);
        $record["company_id"] = @$this->data["company_info"]["id"];
        $record["company_name"] = @$this->data["company_info"]["company_name"];
        $record["business_type"] = @$this->data["company_info"]["business_type"];
        $record["business_description"] = @$this->data["company_info"]["business_description"];
        $record["logo"] = @$this->data["company_info"]["logo"];
        $record["banner"] = @$this->data["company_info"]["banner"];
        $this->data['member'] = $record;
        $this->data['photos'] = $this->Common_model->get_result('photos', array(
            'member_id' => $user_id,
            'type' => 2
        ), 0, 10);
        $this->data['setting'] = $this->Common_model->get_record('member_setting', array(
            'member_id' => $user_id
        ));
        $this->data["download_url"] = base_url("profile/download_impormation");
        $manufacturers1 = $this->Common_model->get_result("manufacturers",["member_id" => $this->user_id],null,null,[["field" => "createat","sort" =>"DESC"]]);
        $count_manufacturers = $this->Common_model->get_result("manufacturers",["member_id" => $this->user_id]);
        $this->data['manufacturers'] = $manufacturers1;
        $this->data['sow_manufacturers'] = (count($count_manufacturers)  > 4) ? true : false;
        $date_old = date('c', strtotime('-30 days'));      
        $this->data["number_view_profile"] = $this->Common_model->get_result_distinct($user_id,"profile",$date_old,"createdat_profile");
        $type_photo = "photo";
        if($this->user_info["is_blog"] == "yes" || @$user_info["is_blog"] == "yes"){
            $type_photo ="blog";
        }
        $this->data["number_view_photo"] = $this->Common_model->get_result_distinct($user_id,$type_photo,$date_old,"createdat_photo_blog");
        $this->load->view('block/header', $this->data);
        $this->load->view('include/share-profile', $this->data);
        $this->load->view('profile/edit', $this->data);
        $this->load->view('block/footer', $this->data);
    }
    public function update_media(){
        $data ["state"] = 404;
        $data ["result"] = null;
        $data ["post"] = $this->input->post();
        if($this->is_login && $this->input->is_ajax_request() && ($this->input->post("colum_change") =="logo") || $this->input->post("colum_change") == "banner"){
            $img    = $this->input->post("string_img");
            $name   = $this->input->post("colum_change").'-'. time() .'.png';
            $folder = 'uploads/member/' . $this->user_id .'/';
            $file   = $folder.$name; 
            $path   = FCPATH . $file;
            $front_content = substr($img, strpos($img, ",")+1);
            $decodedData = base64_decode($front_content);
            try {
                $fp = fopen( $path, 'wb' );
                fwrite($fp,$decodedData);
                fclose($fp);
                $data_update = [
                    $this->input->post("colum_change") => '/'.$file
                ];
                $this->Common_model->update("company",$data_update,["member_id" => $this->user_id]);
                $data ["state"] = 200;
                $data ["result"] = base_url( $file);
                $data ["colum_change"] = $this->input->post("colum_change");
            } catch (Exception $e) {
                $data ["state"] = 500;
                $data ["result"] = null;
            }
        }
        die(json_encode($data));
    }
    public function follow(){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->is_login && $this->input->is_ajax_request()){
            $company_id = $this->input->post('id');
            $company = $this->Common_model->get_record("company",array("id" => $company_id));
            if($company != null){
                $company_id = $company["id"];
                $ch_data = $this->Common_model->get_record("common_follow",array("reference_id" => $company_id ,"member_id" => $this->user_id,"type_object"   => "company"));
                if($ch_data ==  null){
                    $data_insert = [
                        "member_id"     => $this->user_id,
                        "owner_id"      => $company["member_id"],
                        "type_object"   => "company",
                        "reference_id"  => $company_id ,
                        "status"        => 1,
                        "allow"         => 0
                    ];
                    $this->Common_model->add("common_follow",$data_insert);
                    $data_insert = array(
                        "reference_id" => $company_id,
                        "member_id"    => $company["member_id"],
                        "member_owner" => $this->user_id,
                        "type"         => "company",
                        "type_object"  => "follow",
                        "status"       => 0,
                        "allow"        => 0
                    );
                    $this->Common_model->add("notifications_common",$data_insert);
                    $data = array("status" => "success","message" => null,"response" => "add");
                    $common_tracking = $this->Common_model->get_record("common_tracking",["reference_id" => $company_id,"type_object"=>"company"]);
                    if($common_tracking){
                        $qty_common_tracking = $common_tracking ["qty_follow"] + 1;
                        $this->Common_model->update("common_tracking",["qty_follow" =>  $qty_common_tracking ],["reference_id" => $company_id,"type_object"=>"company"]);
                    }else{
                        $data_insert = [
                            "reference_id" => $company_id,
                            "type_object"  =>"company",
                            "qty_follow"     => 1
                        ];
                        $this->Common_model->add("common_tracking",$data_insert);
                    }
                }else{
                    $this->Common_model->delete("common_follow",array("id" => $ch_data["id"]));
                    $this->Common_model->delete("notifications_common",array("reference_id" => $company_id,"member_id" => $this->user_id,"type" => "company","type_object" => "follow"));
                    $this->Common_model->delete("common_follow",["type_object" => "photo","owner_id" => $company["member_id"] ,"member_id" => $this->user_id]);
                    $this->Common_model->delete("notifications_common",array("member_id" => $this->user_id,"member_owner" => $company["member_id"] ,"type" => "photo","type_object" => "follow"));
                    $common_tracking = $this->Common_model->get_record("common_tracking",["reference_id" => $company_id,"type_object"=>"company"]);
                    if($common_tracking){
                        $qty_common_tracking = $common_tracking ["qty_follow"] - 1;
                        $qty_common_tracking = $qty_common_tracking < 0 ? 0 : $qty_common_tracking ;
                        $this->Common_model->update("common_tracking",["qty_follow" =>  $qty_common_tracking ],["reference_id" => $company_id,"type_object"=>"company"]);
                    }

                    $data = array("status" => "success","message" => null,"response" => "delete");
                }   
            } 
            $data["post"] = $this->input->post();
        } 
        die(json_encode($data));        
    }
    public function favorite(){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->is_login && $this->input->is_ajax_request()){
            $company_id = $this->input->post('id');
            $company = $this->Common_model->get_record("company",array("id" => $company_id));
            if($company != null){
                $company_id = $company["id"];
                $ch_data = $this->Common_model->get_record("common_favorite",array("reference_id" => $company_id ,"member_id" => $this->user_id,"type_object"   => "company"));
                if($ch_data ==  null){
                    $data_insert = [
                        "member_id"     => $this->user_id,
                        "owner_id"      => $company["member_id"],
                        "type_object"   => "company",
                        "reference_id"  => $company_id ,
                        "status"        => 1,
                        "allow"         => 0
                    ];
                    $this->Common_model->add("common_favorite",$data_insert);
                    $data_insert = array(
                        "reference_id" => $company_id,
                        "member_id"    => $company["member_id"],
                        "member_owner" => $this->user_id,
                        "type"         => "company",
                        "type_object"  => "favorite",
                        "status"       => 0,
                        "allow"        => 0
                    );
                    $this->Common_model->add("notifications_common",$data_insert);
                    $data = array("status" => "success","message" => null,"response" => "add");
                    $common_tracking = $this->Common_model->get_record("common_tracking",["reference_id" => $company_id,"type_object"=>"company"]);
                    if($common_tracking){
                        $qty_common_tracking = $common_tracking ["qty_favorite"] + 1;
                        $this->Common_model->update("common_tracking",["qty_favorite" =>  $qty_common_tracking ],["reference_id" => $company_id,"type_object"=>"company"]);
                    }else{
                        $data_insert = [
                            "reference_id" => $company_id,
                            "type_object"  =>"company",
                            "qty_favorite"     => 1
                        ];
                        $this->Common_model->add("common_tracking",$data_insert);
                    }
                }else{
                    $this->Common_model->delete("common_favorite",array("id" => $ch_data["id"]));
                    $this->Common_model->delete("notifications_common",array("reference_id" => $company_id,"member_id" => $this->user_id,"type" => "company","type_object" => "favorite"));
                    $common_tracking = $this->Common_model->get_record("common_tracking",["reference_id" => $company_id,"type_object"=>"company"]);
                    if($common_tracking){
                        $qty_common_tracking = $common_tracking ["qty_favorite"] - 1;
                        $qty_common_tracking = $qty_common_tracking < 0 ? 0 : $qty_common_tracking ;
                        $this->Common_model->update("common_tracking",["qty_favorite" =>  $qty_common_tracking ],["reference_id" => $company_id,"type_object"=>"company"]);
                    }
                    $data = array("status" => "success","message" => null,"response" => "delete");
                }   
            } 
            $data["post"] = $this->input->post();
        } 
        die(json_encode($data));        
    }
    public function reports(){
        if ($this->is_login  || $this->session->userdata('user_sr_info')) {
            $user_info = array();
            if($this->is_login){
                $user_id = $this->user_id;
            }else{
                $user_info = $this->session->userdata('user_sr_info');
                $user_id   = $user_info["member_owner"];
            }
            $get_company_up = $this->Common_model->get_record("members",array("id"=>$user_id));

            if(!empty($get_company_up)){
                $this->data["is_login"] = $this->is_login;
                $this->data["title_page"] = "Company Reports";
                $web_setting = $this->Common_model->get_web_setting('setting_report','c.title');
                $type_date = 'w';
                if ($web_setting != null && $web_setting[0] != null) {
                    $type_date = $web_setting[0]['title'];
                }
                $date_old = date('m-d-Y', strtotime('-'.date('w').' days'));
                if ($type_date != 'w') {
                    $date_old = date('Y-m-d',strtotime($type_date));
                }
                //SB: last 30 days
                $date_old = date('c', strtotime('-30 days'));
                $company  = $this->Common_model->get_record("company",["member_id" => $user_id]);
                $this->data["number_view_profile"] = $this->Common_model->get_result_distinct($company["member_id"],"company",$date_old,"created_at");
                $type_photo = "photo";
                if($this->user_info["is_blog"] == "yes" || @$user_info["is_blog"] == "yes"){
                    $type_photo ="blog";
                }
                $this->load->model("Members_model");
                $this->data["number_view_photo"] = $this->Common_model->get_result_distinct($user_id,$type_photo,$date_old,"created_at");
                $this->data["items_user"] = $this->Members_model->get_share_profile($company["id"],$date_old,"","","",0,3,"company");        
                $this->data["items_user"]["all"] = $this->Members_model->get_all_share_profile($company["id"],$date_old,"company");
                $this->data["items_photo_click"] = $this->Members_model->get_click_photo($user_id,$type_photo,$date_old);
                $this->data["items_photo_click"]["all"] = $this->Members_model->get_all_click_photo($user_id,$type_photo,$date_old);
                $owner_recod_type = $this->Members_model->get_photo_comom_view_by_member($user_id,$type_photo,$date_old);
                if($owner_recod_type != null){
                    $data_photo_share = [];
                    foreach ($owner_recod_type as $key => $value) {
                        $value["items"] = $this->Members_model->get_photo_profile($value["reference_id"],$type_photo,$date_old);    
                        $value["all"]  = $this->Members_model->get_all_photo_profile($value["reference_id"],$type_photo,$date_old);
                        $value["tracking"] = $this->Common_model->get_record("common_tracking",["reference_id" => $value["reference_id"],"type_object" => $type_photo]);
                        if($type_photo == "photo")
                        	$value["photo"] = $this->Common_model->get_record("photos",["photo_id" => $value["reference_id"]]);
                        else
                        	$value["photo"] = $this->Common_model->get_record("article",["id" => $value["reference_id"]]);
                        $data_photo_share[] = $value;
                    }
                    $this->data["data_photo_share"]= $data_photo_share;
                }
                $total_photo = $this->Members_model->get_photo_comom_view_by_member($user_id,$type_photo,$date_old,-1,0);
                $this->data["total_photo"] = count($total_photo);
                $this->load->view('block/header', $this->data);
                $this->load->view('company/reports', $this->data);
                $this->load->view('block/footer', $this->data);
            }else{
                redirect(base_url());
            }
        }else{
            redirect(base_url());
        }
        
    }
    public function order_reports(){
        $data["success"] = "error";
        if ($this->input->is_ajax_request() && ($this->is_login || $this->session->userdata('user_sr_info'))) {
            $user_info = array();
            if($this->is_login){
                $user_id = $this->user_id;
            }else{
                $user_info = $this->session->userdata('user_sr_info');
                $user_id   = $user_info["member_owner"];
            }
            $company= $this->Common_model->get_record("company",["member_id" => $user_id]);
            $data_type  = $this->input->post("data_type");
            $data_order = $this->input->post("data_order");
            $data_colum = $this->input->post("data_colum");
            $limit_box  = $this->input->post("limit_box");
            $post_id    = @$this->input->post("post_id");
            $data["orderby"] = json_encode($this->input->post());
            $arg_data_type  = ["profile","photo-blog-view","photo-blog","company"];
            $arg_data_colum = ["clicks","facebook","email","twitter","linkedin","follow","favorite","like","pin","pdf","rqf","jpg"];
            $arg_data_order = ["newest","oldest","most-shared","least-shared"];
            if(in_array($data_type, $arg_data_type) && in_array($data_colum, $arg_data_colum) && in_array($data_order, $arg_data_order)){
                
                $arg_od = ["newest" => "DESC","oldest" => "ASC","most-shared" => "DESC","least-shared" => "ASC"];
                $type_photo = "photo";
                if($this->user_info["is_blog"] == "yes" || @$user_info["is_blog"] == "yes")
                    $type_photo ="blog";
                $this->load->model("Members_model");
                $order_text = "";
                if($data_order == "newest" || $data_order == "oldest")
                    $arg_colum = [ 
                		"clicks" => "alltbl.date_click", 
                		"facebook" => "alltbl.date_fb", 
                		"twitter" => "alltbl.date_tw", 
                		"linkedin" => "alltbl.date_li" ,
                		"email" => "alltbl.date_e",
                		"follow" => "alltbl.date_fl",
                		"favorite" => "alltbl.date_fa",
                		"like" => "alltbl.date_like",
                		"pin" => "alltbl.date_pin",
                		"pdf" => "alltbl.date_pdf",
                		"jpg" => "alltbl.date_jpg",
                		"rqf" => "alltbl.date_rqf",
                	];                 
                else
                    $arg_colum = [ 
                		"clicks" => "alltbl.number_proflie", 
                		"facebook" => "alltbl.number_facebook", 
                		"email" => "alltbl.number_email", 
                		"twitter" => "alltbl.number_twitter", 
                		"linkedin" => "alltbl.number_linkedin",
                		"follow" => "alltbl.number_follow",
                		"favorite" => "alltbl.number_favorite",
                		"like" => "alltbl.number_like",
                		"pin" => "alltbl.number_pin",
                		"pdf" => "alltbl.number_pdf",
                		"jpg" => "alltbl.number_jpg",
                		"rqf" => "alltbl.number_rfq",
                	];
                $order_text = "ORDER BY ".$arg_colum[$data_colum]." ".$arg_od[$data_order]."";
                $web_setting = $this->Common_model->get_web_setting('setting_report','c.title');
                $type_date = 'w';
                if ($web_setting != null && $web_setting[0] != null) {
                    $type_date = $web_setting[0]['title'];
                }
                $date_old = date('m-d-Y', strtotime('-'.date('w').' days'));
                if ($type_date != 'w') {
                    $date_old = date('Y-m-d',strtotime($type_date));
                }
                $date_old = date('c', strtotime('-30 days'));
                $colums_left = 6;
                $colums_left_parent = 4;
                switch ($data_type) {
                    case 'profile':  
                       $colums_left = 6;
                       $record = $this->Members_model->get_share_profile($company["id"],$date_old,$arg_od[$data_order],$data_colum,$order_text,0,$limit_box,"company");
                       break;
                    case 'photo-blog-view': 
                       $colums_left = 7;
                       $record = $this->Members_model->get_click_photo($user_id,$type_photo,$date_old,$arg_od[$data_order],$order_text,0,$limit_box);
                       break;
                   default:
                       $colums_left = 7;
                       $colums_left_parent = 2;
                       $record = $this->Members_model->get_photo_profile($post_id,$type_photo,$date_old,$arg_od[$data_order],$data_colum,$order_text,0,$limit_box);
                       break;
                }
                $html = "";
                $colums_right = 12 - $colums_left;
                if($record != null){
                    foreach ($record as $key => $value) {
                        if($data_type != "photo-blog-view"){
                            $number_email = (@$value["number_email"] != "") ? $value["number_email"] : 0;
                            $number_twitter = (@$value["number_twitter"] != "") ? $value["number_twitter"] : 0;
                            $number_facebook = (@$value["number_facebook"] != "") ? $value["number_facebook"] : 0;
                            $number_linkedin = (@$value["number_linkedin"] != "") ? $value["number_linkedin"] : 0; 
                            $number_follow = (@$value["number_follow"] != "") ? $value["number_follow"] : 0;
                            $number_favorite = (@$value["number_favorite"] != "") ? $value["number_favorite"] : 0;
                            $number_like = (@$value["number_like"] != null) ? $value["number_like"] : 0;
                            $number_pin = (@$value["number_pin"] != null) ? $value["number_pin"] : 0; 
                            $number_jpg = (@$value["number_jpg"] != null) ? $value["number_jpg"] : 0;
                            $number_pdf = (@$value["number_pdf"] != null) ? $value["number_pdf"] : 0;
                            $number_rfq = (@$value["number_rfq"] != null) ? $value["number_rfq"] : 0;
                        }

                        $number_proflie = ($value["number_proflie"] != "") ? $value["number_proflie"] : 0; 
                        $timestamp = strtotime($value["created_at"]);
                        $logo = ($value['avatar'] != "" && file_exists(FCPATH . $value['avatar'])) ? base_url($value['avatar']) : base_url("skins/images/avatar-full.png"); 
                        $html.='<div class="row items">';
                            $html.='<div class="col-xs-9 col-md-7">';
                                $html.='<div class="row">
								    <div id="reports-email" data-email ="'.$value["work_email"].'">
								        <div class="col-lg-2 text-center"><div class="logo-user"><img src="'.$logo.'"></div></div>
								        <div class="col-lg-6">
								            <p>'.$value["first_name"]. " ".$value["last_name"] .' | '.$value["company_name"] .'</p>
								            <p>'. date('F j \a\t h:i A', $timestamp).'</p>
								        </div>
								        <div class="col-sm-4">
								            <ul class="list-inline action-img">
								                <li><a href="javascript:;"><img src="'.skin_url("icon/icon-user.png").'"></a></li>
								                <li><a href="javascript:;"><img src="'.skin_url("/icon/icon-message.png").'"></a></li>
								            </ul>
								        </div>
								    </div>
								</div>';
                            $html.='</div>';
                            $html.='<div class="col-xs-3 col-md-5 show-number">';
                                $html.='<div class="row">';
                                    $html.='<div class="col-xs-'.$colums_left.'">';
                                        $html.='<div class="row">';
                                            $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                                $html.='<p>'.$number_proflie.'</p>';
                                            $html.='</div>';
                                            if($data_type == "profile"){
                                                $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                                    $html.='<p>'.$number_follow.'</p>';
                                                $html.='</div>';
                                                $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                                    $html.='<p>'.$number_favorite.'</p>';
                                                $html.='</div>';
                                            }else{

                                            	if(isset($number_like)){
                                            		$html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
	                                                    $html.='<p>'.$number_like.'</p>';
	                                                $html.='</div>';
	                                                $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
	                                                    $html.='<p>'.$number_pin.'</p>';
	                                                $html.='</div>';

	                                                $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
	                                                    $html.='<p>'.$number_jpg.'</p>';
	                                                $html.='</div>';
	                                                $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
	                                                    $html.='<p>'.$number_pdf.'</p>';
	                                                $html.='</div>';
	                                                $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
	                                                    $html.='<p>'.$number_rfq.'</p>';
	                                                $html.='</div>';
	                                            }	
                                            }
                                        $html.='</div>'; 
                                    $html.='</div>';  
                                    $html.='<div class="col-xs-'.$colums_right.'">';
                                        $html.='<div class="row">';
                                            if($data_type != "photo-blog-view"){
                                                $html.='<div class="col-xs-3 text-center">';
                                                    $html.='<p>'.$number_email.'</p>';
                                                $html.='</div>';
                                                $html.='<div class="col-xs-3 xs-none text-center">';
                                                    $html.='<p>'.$number_facebook.'</p>';
                                                $html.='</div>';
                                                $html.='<div class="col-xs-3 xs-none text-center">';
                                                    $html.='<p>'.$number_twitter.'</p>';
                                                $html.='</div>';
                                                $html.='<div class="col-xs-3 xs-none text-center">';
                                                    $html.='<p>'.$number_linkedin.'</p>';
                                                $html.='</div>';
                                            }
                                        $html.='</div>';
                                    $html.='</div>';  
                                $html.='</div>';
                            $html.='</div>';                                               
                        $html.='</div>';
                    }
                    $data["reponse"] = $html; 
                    $data["success"] = "success";
                }                  
            }
            die(json_encode($data));
        }
    }
    public function more_reports(){
        $data["success"] = "error";
        if ($this->input->is_ajax_request() &&  ( $this->is_login || $this->session->userdata('user_sr_info') ) ) {
            $user_info = array();
            if($this->is_login){
                $user_id = $this->user_id;
            }else{
                $user_info = $this->session->userdata('user_sr_info');
                $user_id   = $user_info["member_owner"];
            }
            $company = $this->Common_model->get_record("company",["member_id" => $user_id]);
            $data_post = $this->input->post("data");
            $data_post = json_decode($data_post,true);
            $data_type  = @$this->input->post("data_type");
            $limit_box  = $this->input->post("limit_box");
            $post_id    = @$this->input->post("post_id");
            $record = null;
            $days = ['Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6];
            $get_date = getdate();
            $month = $get_date["weekday"];
            $web_setting = $this->Common_model->get_web_setting('setting_report','c.title');
            $type_date = 'w';
            if ($web_setting != null && $web_setting[0] != null) {
                $type_date = $web_setting[0]['title'];
            }
            $date_old = date('m-d-Y', strtotime('-'.date('w').' days'));
            if ($type_date != 'w') {
                $date_old = date('Y-m-d',strtotime($type_date));
            }
            $date_old = date('c', strtotime('-30 days'));
            $this->load->model("Members_model");
            $type_photo = "photo";
            if($this->user_info["is_blog"] == "yes" || @$user_info["is_blog"] == "yes")
                $type_photo ="blog";
            $colums_left = 6;
            $colums_left_parent = 4;
            if($data_post == null){
                switch ($data_type) {
                    case 'profile': 
                       $colums_left = 6; 
                       $record = $this->Members_model->get_share_profile($company["id"],$date_old,"DESC","","",$limit_box,3,"company");
                       $all = $this->Members_model->get_all_share_profile($company["id"],$date_old,"company");
                       break;
                    case 'photo-blog-view': 
                       $colums_left = 7;
                       $record = $this->Members_model->get_click_photo($user_id,$type_photo,$date_old,"DESC","",$limit_box,3);
                       $all = $this->Members_model->get_all_click_photo($user_id,$type_photo,$date_old);
                       break;
                   default:
                       $colums_left = 7;
                       $colums_left_parent = 2;
                       $record = $this->Members_model->get_photo_profile($post_id,$type_photo,$date_old,"DESC","","",$limit_box,3);
                       $all = $this->Members_model->get_all_photo_profile($post_id,$type_photo,$date_old);
                       break;
                }
            }else{
                $arg_data_type  = ["profile","photo-blog-view","photo-blog","company"];
            	$arg_data_colum = ["clicks","facebook","email","twitter","linkedin","follow","favorite","like","pin","pdf","rqf","jpg"];
            	$arg_data_order = ["newest","oldest","most-shared","least-shared"];
                $data_order = @$data_post["data_order"];
                $data_colum = @$data_post["data_colum"];
                if(in_array($data_type, $arg_data_type) && in_array($data_colum, $arg_data_colum) && in_array($data_order, $arg_data_order)){
                    $arg_od = ["newest" => "DESC","oldest" => "ASC","most-shared" => "DESC","least-shared" => "ASC"];
                    $order_text = "";
                    if($data_order == "newest" || $data_order == "oldest")
	                    $arg_colum = [ 
	                		"clicks" => "alltbl.date_click", 
	                		"facebook" => "alltbl.date_fb", 
	                		"twitter" => "alltbl.date_tw", 
	                		"linkedin" => "alltbl.date_li" ,
	                		"email" => "alltbl.date_e",
	                		"follow" => "alltbl.date_fl",
	                		"favorite" => "alltbl.date_fa",
	                		"like" => "alltbl.date_like",
	                		"pin" => "alltbl.date_pin",
	                		"pdf" => "alltbl.date_pdf",
	                		"jpg" => "alltbl.date_jpg",
	                		"rqf" => "alltbl.date_rqf",
	                	];                 
	                else
	                    $arg_colum = [ 
	                		"clicks" => "alltbl.number_proflie", 
	                		"facebook" => "alltbl.number_facebook", 
	                		"email" => "alltbl.number_email", 
	                		"twitter" => "alltbl.number_twitter", 
	                		"linkedin" => "alltbl.number_linkedin",
	                		"follow" => "alltbl.number_follow",
	                		"favorite" => "alltbl.number_favorite",
	                		"like" => "alltbl.number_like",
	                		"pin" => "alltbl.number_pin",
	                		"pdf" => "alltbl.number_pdf",
	                		"jpg" => "alltbl.number_jpg",
	                		"rqf" => "alltbl.number_rfq",
	                	];
                	$order_text = "ORDER BY ".$arg_colum[$data_colum]." ".$arg_od[$data_order]."";
                    switch ($data_type) {
                        case 'profile':  
                           $record = $this->Members_model->get_share_profile($company["id"],$date_old,$arg_od[$data_order],$data_colum,$order_text,$limit_box,3,"company");
                           $all = $this->Members_model->get_all_share_profile($company["id"],$date_old,"company");
                           break;
                        case 'photo-blog-view': 
                           $record = $this->Members_model->get_click_photo($user_id,$type_photo,$date_old,$arg_od[$data_order],$order_text,$limit_box,3);
                           $all = $this->Members_model->get_all_click_photo($user_id,$type_photo,$date_old);
                           break;
                       default:
                           $record = $this->Members_model->get_photo_profile($post_id,$type_photo,$date_old,$arg_od[$data_order],$data_colum,$order_text,$limit_box,3);
                           $all = $this->Members_model->get_all_photo_profile($post_id,$type_photo,$date_old);
                           break;
                    }
                } 
            }
            if($all <= $limit_box + 3){
                $data["hidden_more"] = "true";
            }else{
                $data["hidden_more"] = "false";
            }
            $html = "";
            $colums_right = 12 - $colums_left;
            if($record != null){
                foreach ($record as $key => $value) {
                    if($data_type != "photo-blog-view"){
                        $number_email = ($value["number_email"] != "") ? $value["number_email"] : 0;
                        $number_twitter = ($value["number_twitter"] != "") ? $value["number_twitter"] : 0;
                        $number_facebook = ($value["number_facebook"] != "") ? $value["number_facebook"] : 0;
                        $number_linkedin = ($value["number_linkedin"] != "") ? $value["number_linkedin"] : 0; 
                        $number_follow = (@$value["number_follow"] != null && @$value["number_follow"] != "") ? $value["number_follow"] : 0;
                        $number_favorite = (@$value["number_favorite"] != null && @$value["number_follow"] != "") ? $value["number_favorite"] : 0;
                        $number_like = (@$value["number_like"] != null && @$value["number_like"] != "") ? $value["number_like"] : 0;
                        $number_pin = (@$value["number_pin"] != null && @$value["number_pin"] != "") ? $value["number_pin"] : 0; 
                        $number_jpg = (@$value["number_jpg"] != null && @$value["number_jpg"] != "") ? $value["number_jpg"] : 0;
                        $number_pdf = (@$value["number_pdf"] != null && @$value["number_pdf"] != "") ? $value["number_pdf"] : 0;
                        $number_rfq = (@$value["number_rfq"] != null && @$value["number_rfq"] != "") ? $value["number_rfq"] : 0;
                    }

                    $number_proflie = ($value["number_proflie"] != "") ? $value["number_proflie"] : 0; 
                    $timestamp = strtotime($value["created_at"]);
                    $logo = ($value['avatar'] != "" && file_exists(FCPATH . $value['avatar'])) ? base_url($value['avatar']) : base_url("skins/images/avatar-full.png"); 
                    $html.='<div class="row items">';
                        $html.='<div class="col-xs-9 col-md-7">';
                            $html.='<div class="row">
							    <div id="reports-email" data-email ="'.$value["work_email"].'">
							        <div class="col-lg-2 text-center"><div class="logo-user"><img src="'.$logo.'"></div></div>
							        <div class="col-lg-6">
							            <p>'.$value["first_name"]. " ".$value["last_name"] .' | '.$value["company_name"] .'</p>
							            <p>'. date('F j \a\t h:i A', $timestamp).'</p>
							        </div>
							        <div class="col-sm-4">
							            <ul class="list-inline action-img">
							                <li><a href="javascript:;"><img src="'.skin_url("icon/icon-user.png").'"></a></li>
							                <li><a href="javascript:;"><img src="'.skin_url("/icon/icon-message.png").'"></a></li>
							            </ul>
							        </div>
							    </div>
							</div>';
                        $html.='</div>';
                        $html.='<div class="col-xs-3 col-md-5 show-number">';
                            $html.='<div class="row">';
                                $html.='<div class="col-xs-'.$colums_left.'">';
                                    $html.='<div class="row">';
                                        $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                            $html.='<p>'.$number_proflie.'</p>';
                                        $html.='</div>';
                                        if($data_type == "profile"){
                                            $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                                $html.='<p>'.$number_follow.'</p>';
                                            $html.='</div>';
                                            $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                                $html.='<p>'.$number_favorite.'</p>';
                                            $html.='</div>';
                                        }else{

                                        	if(isset($number_like)){
                                        		$html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                                    $html.='<p>'.$number_like.'</p>';
                                                $html.='</div>';
                                                $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                                    $html.='<p>'.$number_pin.'</p>';
                                                $html.='</div>';

                                                $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                                    $html.='<p>'.$number_jpg.'</p>';
                                                $html.='</div>';
                                                $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                                    $html.='<p>'.$number_pdf.'</p>';
                                                $html.='</div>';
                                                $html.='<div class="col-xs-'.$colums_left_parent.' text-center">';
                                                    $html.='<p>'.$number_rfq.'</p>';
                                                $html.='</div>';
                                            }	
                                        }
                                    $html.='</div>'; 
                                $html.='</div>';  
                                $html.='<div class="col-xs-'.$colums_right.'">';
                                    $html.='<div class="row">';
                                        if($data_type != "photo-blog-view"){
                                            $html.='<div class="col-xs-3 text-center">';
                                                $html.='<p>'.$number_email.'</p>';
                                            $html.='</div>';
                                            $html.='<div class="col-xs-3 xs-none text-center">';
                                                $html.='<p>'.$number_facebook.'</p>';
                                            $html.='</div>';
                                            $html.='<div class="col-xs-3 xs-none text-center">';
                                                $html.='<p>'.$number_twitter.'</p>';
                                            $html.='</div>';
                                            $html.='<div class="col-xs-3 xs-none text-center">';
                                                $html.='<p>'.$number_linkedin.'</p>';
                                            $html.='</div>';
                                        }
                                    $html.='</div>';
                                $html.='</div>';  
                            $html.='</div>';
                        $html.='</div>';                                               
                    $html.='</div>';
                }
                $data["reponse"] = $html; 
                $data["success"] = "success";
            }  

            //$this->output->enable_profiler(TRUE);
           die(json_encode($data));
        }
    }
    public function paging_reports(){
        if ($this->input->is_ajax_request() && ( $this->is_login || $this->session->userdata('user_sr_info') ) ){
            $user_info = array();
            if($this->is_login){
                $user_id = $this->user_id;
            }else{
                $user_info = $this->session->userdata('user_sr_info');
                $user_id   = $user_info["member_owner"];
            }
            $data["success"] = "error";
            $next_page = $this->input->post("next_page");
            $item_total = $this->input->post("item_total");
            $days = ['Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6];
            $get_date = getdate();
            $month = $get_date["weekday"];
            $web_setting = $this->Common_model->get_web_setting('setting_report','c.title');
            $type_date = 'w';
            if ($web_setting != null && $web_setting[0] != null) {
                $type_date = $web_setting[0]['title'];
            }
            $date_old = date('m-d-Y', strtotime('-'.date('w').' days'));
            if ($type_date != 'w') {
                $date_old = date('Y-m-d',strtotime($type_date));
            }
            
            //SB: last 30 days
            $date_old = date('c', strtotime('-30 days'));
            
            $type_photo = "photo";
            if($this->user_info["is_blog"] == "yes" || @$user_info["is_blog"] == "yes")
                $type_photo ="blog";
            $offset = ($next_page) * $item_total;
            $this->load->model("Members_model");
            $owner_recod_type = $this->Members_model->get_photo_comom_view_by_member($user_id,$type_photo,$date_old,$offset,$item_total); 
            if($owner_recod_type != null){
                $data_photo_share = [];
                foreach ($owner_recod_type as $key => $value) {
                    $value["items"] = $this->Members_model->get_photo_profile($value["reference_id"],$type_photo,$date_old);
                    $value["all"]   = $this->Members_model->get_all_photo_profile($value["reference_id"],$type_photo,$date_old);  
                    $value["tracking"] = $this->Common_model->get_record("common_tracking",["reference_id" => $value["reference_id"],"type_object" => $type_photo]);
                    if($type_photo == "photo")
                    	$value["photo"] = $this->Common_model->get_record("photos",["photo_id" => $value["reference_id"]]);
                    else
                    	$value["photo"] = $this->Common_model->get_record("article",["id" => $value["reference_id"]]);
                    $data_photo_share[] = $value;
                }
                $html = "";
                if($data_photo_share != null){
                    foreach ($data_photo_share as $key => $value) {
                    	$tracking = @$value["tracking"];
                    	$photo    = @$value["photo"];
                    	$qty_view = (@$tracking != null) ? $tracking["qty_view"] : 0;
                        $html .='<div class="content-your-reports" data-id="'.$value["reference_id"].'">
                            <div class="row">
                                <div class="col-md-3 col-3-cutoms">
                                    <div class="box-left-your-reports">
                                        <div class="img-share" style="background-image: url('.base_url($value["path_file"]).');"></div>
                                    </div>
                                </div>
                                <div class="col-md-9 col-9-cutoms">
                                    <div class="panel panel-default relative not-border">
                                        <div class="box-right-your-reports" data-type = "photo-blog">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <h3 style="margin-top: 0"><span class="number_view_photo">'.$qty_view.'</span><span style="font-size: 30px;"> Image Views</span></h3>
                                                    <h3>'.@$photo["name"].''.@$photo["title"].'</h3>
                                                 </div>
                                                <div class="col-xs-9 col-md-7"></div>
												<div class="col-xs-3 col-md-5 show-number">
												    <div class="row">
												        <div class="col-md-7">
												            <div class="row">
												                <div class="col-xs-2 col-md-2 relative text-center box-click">
												                    <p class="icon">Clicks</p>
												                    <div class="box-sort-by">
												                        <h4>Sort by:</h4>
												                        <div class="list-chose" data-colum="clicks">
												                            <ul class="list-item">
												                                <li><a href="#" data-order="newest">Newest</a></li>
												                                <li><a href="#" data-order="oldest">Oldest</a></li>
												                                <li><a href="#" data-order="most-shared">Most shared</a></li>
												                                <li><a href="#" data-order="least-shared">Least shared</a></li>
												                            </ul>
												                        </div>
												                    </div>
												                </div>
												                <div class="col-xs-2 col-md-2 relative text-center box-click">
												                    <img class="icon" src="'.skin_url("images/heart.png").'">
												                    <div class="box-sort-by">
												                        <h4>Sort by:</h4>
												                        <div class="list-chose" data-colum="like">
												                            <ul class="list-item">
												                                <li><a href="#" data-order="newest">Newest</a></li>
												                                <li><a href="#" data-order="oldest">Oldest</a></li>
												                                <li><a href="#" data-order="most-shared">Most shared</a></li>
												                                <li><a href="#" data-order="least-shared">Least shared</a></li>
												                            </ul>
												                        </div>
												                    </div>
												                </div>
												                <div class="col-xs-2 col-md-2 relative text-center box-click">
												                    <img class="icon" src="'.skin_url("images/pushpin-myphoto.png").'">
												                    <div class="box-sort-by">
												                        <h4>Sort by:</h4>
												                        <div class="list-chose" data-colum="pin">
												                            <ul class="list-item">
												                                <li><a href="#" data-order="newest">Newest</a></li>
												                                <li><a href="#" data-order="oldest">Oldest</a></li>
												                                <li><a href="#" data-order="most-shared">Most shared</a></li>
												                                <li><a href="#" data-order="least-shared">Least shared</a></li>
												                            </ul>
												                        </div>
												                    </div>
												                </div>
												                <div class="col-xs-2 col-md-2 relative text-center box-jpg">
												                    <p class="icon">JPG</p>
												                    <div class="box-sort-by">
												                        <h4>Sort by:</h4>
												                        <div class="list-chose" data-colum="clicks">
												                            <ul class="list-item">
												                                <li><a href="#" data-order="newest">Newest</a></li>
												                                <li><a href="#" data-order="oldest">Oldest</a></li>
												                                <li><a href="#" data-order="most-shared">Most shared</a></li>
												                                <li><a href="#" data-order="least-shared">Least shared</a></li>
												                            </ul>
												                        </div>
												                    </div>
												                </div>
												                <div class="col-xs-2 col-md-2 relative text-center box-click">
												                    <p class="icon">PDF</p>
												                    <div class="box-sort-by">
												                        <h4>Sort by:</h4>
												                        <div class="list-chose" data-colum="pdf">
												                            <ul class="list-item">
												                                <li><a href="#" data-order="newest">Newest</a></li>
												                                <li><a href="#" data-order="oldest">Oldest</a></li>
												                                <li><a href="#" data-order="most-shared">Most shared</a></li>
												                                <li><a href="#" data-order="least-shared">Least shared</a></li>
												                            </ul>
												                        </div>
												                    </div>
												                </div>
												                <div class="col-xs-2 col-md-2 relative text-center box-click">
												                    <p class="icon">RQF</p>
												                    <div class="box-sort-by">
												                        <h4>Sort by:</h4>
												                        <div class="list-chose" data-colum="rqf">
												                            <ul class="list-item">
												                                <li><a href="#" data-order="newest">Newest</a></li>
												                                <li><a href="#" data-order="oldest">Oldest</a></li>
												                                <li><a href="#" data-order="most-shared">Most shared</a></li>
												                                <li><a href="#" data-order="least-shared">Least shared</a></li>
												                            </ul>
												                        </div>
												                    </div>
												                </div>
												            </div>
												        </div>
												        <div class="col-md-5">
												            <div class="row"> 
												                <div class="col-xs-3 text-center relative box-email">
												                    <img class="icon" src="'.skin_url("images/email1.png").'">
												                    <div class="box-sort-by">
												                        <h4>Sort by:</h4>
												                        <div class="list-chose" data-colum="email">
												                            <ul class="list-item">
												                                <li><a href="#" data-order="newest">Newest</a></li>
												                                <li><a href="#" data-order="oldest">Oldest</a></li>
												                                <li><a href="#" data-order="most-shared">Most shared</a></li>
												                                <li><a href="#" data-order="least-shared">Least shared</a></li>
												                            </ul>
												                        </div>
												                    </div>
												                </div> 
												                <div class="col-xs-3 text-center relative box-facebook xs-none">
												                    <img class="icon" src="'.skin_url("images/facebook.png").'">
												                    <div class="box-sort-by">
												                        <h4>Sort by:</h4>
												                        <div class="list-chose" data-colum="facebook">
												                            <ul class="list-item">
												                                <li><a href="#" data-order="newest">Newest</a></li>
												                                <li><a href="#" data-order="oldest">Oldest</a></li>
												                                <li><a href="#" data-order="most-shared">Most shared</a></li>
												                                <li><a href="#" data-order="least-shared">Least shared</a></li>
												                            </ul>
												                        </div>
												                    </div>
												                </div>
												                <div class="col-xs-3 text-center relative box-twitter xs-none">
												                    <img class="icon" src="'.skin_url("images/twitter.png").'">
												                    <div class="box-sort-by">
												                        <h4>Sort by:</h4>
												                        <div class="list-chose" data-colum="twitter">
												                            <ul class="list-item">
												                                <li><a href="#" data-order="newest">Newest</a></li>
												                                <li><a href="#" data-order="oldest">Oldest</a></li>
												                                <li><a href="#" data-order="most-shared">Most shared</a></li>
												                                <li><a href="#" data-order="least-shared">Least shared</a></li>
												                            </ul>
												                        </div>
												                    </div>
												                </div>
												                <div class="col-xs-3 text-center relative box-in xs-none">
												                    <img class="icon" src="'.skin_url("images/in.png").'">
												                    <div class="box-sort-by">
												                        <h4>Sort by:</h4>
												                        <div class="list-chose" data-colum="linkedin">
												                            <ul class="list-item">
												                                <li><a href="#" data-order="newest">Newest</a></li>
												                                <li><a href="#" data-order="oldest">Oldest</a></li>
												                                <li><a href="#" data-order="most-shared">Most shared</a></li>
												                                <li><a href="#" data-order="least-shared">Least shared</a></li>
												                            </ul>
												                        </div>
												                    </div>
												                </div>
												            </div>
												        </div>
												    </div>
												</div>
											</div>
                                            <div id="list-items">';
                                            if (isset($value["items"])) {
                                                foreach ($value["items"] as $key_items => $value_items) {
                                                    $number_proflie = ($value_items["number_proflie"] != null) ? $value_items["number_proflie"] : 0; 
                                                    $number_email = ($value_items["number_email"] != null) ? $value_items["number_email"] : 0; 
                                                    $number_facebook = ($value_items["number_facebook"] != null) ? $value_items["number_facebook"] : 0; 
                                                    $number_twitter = ($value_items["number_twitter"] != null) ? $value_items["number_twitter"] : 0; 
                                                    $number_linkedin = ($value_items["number_linkedin"] != null) ? $value_items["number_linkedin"] : 0; 
                                                    $number_like= ($value_items["number_like"] != null) ? $value_items["number_like"] : 0;
                                                    $number_pin= ($value_items["number_pin"] != null) ? $value_items["number_pin"] : 0;
                                                    $number_pdf= ($value_items["number_pdf"] != null) ? $value_items["number_pdf"] : 0;
                                                    $number_jpg= ($value_items["number_jpg"] != null) ? $value_items["number_jpg"] : 0;
                                                    $number_rfq= ($value_items["number_rfq"] != null) ? $value_items["number_rfq"] : 0;
                                                    $timestamp = strtotime($value_items["created_at"]);
                                                    $logo = ($value_items['avatar'] != "" && file_exists(FCPATH . $value_items['avatar'])) ? base_url($value_items['avatar']) : base_url("skins/images/avatar-full.png");                         
                                                    $html.='<div class="row items">
                                                                <div class="col-xs-9 col-md-7">
                                                                    <div class="row">
																	    <div id="reports-email" data-email ="'.$value_items["work_email"].'">
																	        <div class="col-lg-2 text-center"><div class="logo-user"><img src="'.$logo.'"></div></div>
																	        <div class="col-lg-6">
																	            <p>'.$value_items["first_name"]. " ".$value_items["last_name"] .' | '.$value_items["company_name"] .'</p>
																	            <p>'. date('F j \a\t h:i A', $timestamp).'</p>
																	        </div>
																	        <div class="col-sm-4">
																	            <ul class="list-inline action-img">
																	                <li><a href="javascript:;"><img src="'.skin_url("icon/icon-user.png").'"></a></li>
																	                <li><a href="javascript:;"><img src="'.skin_url("/icon/icon-message.png").'"></a></li>
																	            </ul>
																	        </div>
																	    </div>
																	</div>
                                                                </div>
                                                                <div class="col-xs-3 col-md-5 show-number">
                                                                	<div class="row">
                                                                		<div class="col-md-7">
                                                                			<div class="row">
                                                                				<div class="col-xs-2 col-md-2 text-center">
				                                                                    <p>'.$number_proflie.'</p>
				                                                                </div>
				                                                                <div class="col-xs-2 col-md-2 text-center xs-none">
				                                                                    <p>'.$number_like.'</p>
				                                                                </div>
				                                                                <div class="col-xs-2 col-md-2 text-center xs-none">
				                                                                    <p>'.$number_pin.'</p>
				                                                                </div>
				                                                                <div class="col-xs-2 col-md-2 text-center xs-none">
				                                                                    <p>'.$number_jpg.'</p>
				                                                                </div>
				                                                                <div class="col-xs-2 col-md-2 text-center xs-none">
				                                                                    <p>'.$number_pdf.'</p>
				                                                                </div>
				                                                                <div class="col-xs-2 col-md-2 text-center xs-none">
				                                                                    <p>'.$number_rfq.'</p>
				                                                                </div>
                                                                			</div>
                                                                		</div>
                                                                		<div class="col-md-5">
                                                                			<div class="row">
                                                                				<div class="col-md-3 text-center">
				                                                                    <p>'.$number_email.'</p>
				                                                                </div>
				                                                                <div class="col-xs-3 text-center xs-none">
				                                                                    <p>'.$number_facebook.'</p>
				                                                                </div>
				                                                                <div class="col-xs-3 text-center xs-none">
				                                                                    <p>'.$number_twitter.'</p>
				                                                                </div>
				                                                                <div class="col-xs-3 text-center xs-none">
				                                                                    <p>'.$number_linkedin.'</p>
				                                                                </div> 
                                                                			</div>
                                                                		</div>
                                                                	</div>
                                                                </div>
                                                            </div>';
                                                }
                                            }
                                            $html.='</div><input type="hidden" id="order_set" name="">';
                                            if($value["all"] > 3)
                                            	$html.='<p class="text-right" id="more-your-reports"><a href="#">MORE</a></p>';
                                        $html.='</div> 
                                    </div>
                                </div>   
                            </div>
                        </div>';
                    }
                }
                $data["reponse"] = $html;
                $data["success"] = "success";
                $data["data"] = $this->input->post();
            }
            die(json_encode($data));
        }
    }  
}
