<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Photos extends CI_Controller {

    public $is_login = false;
    public $user_info = 0;
    public $user_id = 0;
    public $data;
    public function __construct() {
        parent::__construct();
        $this->data["type_member"] = 0;
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->data["type_member"] = $this->user_info["type_member"];
        }

        $this->data["is_login"] = $this->is_login;
    }
    public function index($photo_id) {
        if ($photo_id != "" && is_numeric($photo_id)) {
            $this->data["view_wrapper"] = "images/single-image";
            $this->data["class_wrapper"] = "image-page";
            $this->data["type_post"] = "photo";
            $this->data["id_post"] = $photo_id;
            $this->load->model("Members_model");
            $this->load->model("Photo_model");
            $recorder_photo = $this->Common_model->get_record("photos", array(
                "photo_id" => $photo_id, "status_photo" => 1
            ));
            if($this->input->get("number")){
                $index_item = base64_decode($this->input->get("number"));
                $allbum = json_decode($recorder_photo["album"],true);
                if(isset($allbum[$index_item]) && isset($allbum[$index_item]["path"])){
                    $recorder_photo["path_file"] = $allbum[$index_item]["path"];
                }
            }
            if (count($recorder_photo) > 0 && $recorder_photo != null) {
                $recorder_user = $this->Members_model->get_information_user($recorder_photo["member_id"]);
                $data_share = ' <meta name="og:image" content="' . base_url($recorder_photo['path_file']) . '">
                <meta id ="titleshare" property="og:title" content="'.$recorder_user["company_name"].' just shared '. $recorder_photo["name"] . ' on @Dezignwall TAKE A LOOK" />
                <meta property="og:description" content="' . $recorder_photo["description"] . '" />
                <meta property="og:url" content="' . base_url("photos/" . $recorder_photo["photo_id"] . "/" . gen_slug($recorder_photo["name"])) . '" />
                <meta property="og:image" content="' . base_url($recorder_photo['thumb']) . '" />';
                $this->data["data_share"] = $data_share;
                $this->data["description_page"] = $recorder_photo["description"];
                // Get comment of this photo
                $record_comment = $this->Photo_model->get_comment_photo($recorder_photo['photo_id']);
                $datime = date('Y-m-d H:i:s');
                $ip = $this->input->ip_address();
                $datainsert = array(
                    "reference_id" => $photo_id,
                    "member_owner" => $recorder_photo["member_id"],
                    "member_id" => @$this->user_id,
                    "ip" => $ip,
                    "created_at" => $datime,
                    "createdat_photo_blog" => $datime
                );
                $this->Common_model->add("common_view", $datainsert);
                $common_tracking = $this->Common_model->get_record("common_tracking", array(
                    "reference_id" => $photo_id,
                    "type_object" => "photo"
                ));
                if( $common_tracking  == null){
                    $data_insert = [
                        "reference_id" => $photo_id,
                        "type_object" => "photo",
                        "qty_view"   => $this->Common_model->count_table("common_view",[
                            "reference_id" => $photo_id,
                            "type_share_view" => "view",
                            "type_object" => "photo",
                            "member_id !=" => 0
                            ]
                        )
                    ];
                    $this->Common_model->add("common_tracking", $data_insert);
                }else{
                    $data_insert = [
                        "qty_view"   => $this->Common_model->count_table("common_view",["reference_id" => $photo_id,"type_share_view" => "view","type_object" => "photo","member_id !=" => 0])
                    ];
                    $this->Common_model->update("common_tracking", $data_insert,[ "id" => $common_tracking["id"] ]);
                }
                $like = $this->Common_model->get_result("common_like", array(
                    "reference_id" => $photo_id,
                    "status" => 1,
                    "type_object" => "photo"
                ));
                $record_involve = $this->Photo_model->get_ram_photo(array(
                    "member_id" => $recorder_photo["member_id"],
                    "photo_id !=" => $photo_id,
                    "type" => 2
                        ), 4);
                $user_total_like = $this->Common_model->get_record("common_like", array(
                    "reference_id" => $photo_id,
                    "member_id" => $this->user_id,
                    "type_object" => "photo"
                ));
                $record_type = $this->Common_model->get_record("members", array("id" => $recorder_photo["member_id"]));
                $this->load->model("Photo_keyword_model");
                $record_keyword = $this->Photo_keyword_model->get_photo_keyword_byid($photo_id);
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
                $this->data["title_page"] = "View photo | ". $recorder_photo["name"];
                $this->data["company"] = $this->Common_model->get_record("company",array("member_id" => $recorder_photo["member_id"])); 
                $this->data["manufacturers"] = $this->Common_model->get_record("manufacturers",array("id" => $recorder_photo["manufacture"]));
                $indoor_outdoor = "";
                $arg_category = explode("/",$recorder_photo["category"]);
                $arg_category = array_diff($arg_category,array(""));
                if(strpos($recorder_photo["category"], '/1/') !== false){
                    $indoor_outdoor = '<a href="'.base_url("search?location=1").'">Indoor</a>';
                }
                if(strpos($recorder_photo["category"], '/2/')!== false){
                    $indoor_outdoor = '<a href="'.base_url("search?location=2").'">Outdoor</a>';
                }
                if(strpos($recorder_photo["category"], '/1/') !== false && strpos($recorder_photo["category"], '/2/') !== false){
                    $indoor_outdoor = '<a href="'.base_url("search?location=1,2").'">Indoor, Outdoor</a>';
                }
                $available = "";
                if(strpos($recorder_photo["category"], '/260/') !== false){
                    $available = "Locally";
                }
                if(strpos($recorder_photo["category"], '/259/')!== false){
                    $available = "Nationally";
                }
                if(strpos($recorder_photo["category"], '/262/') !== false ){
                    $available = "Internationally";
                }
                if($arg_category != null){
                    $this->db->select("title,id");
                    $this->db->from("categories");
                    $this->db->where_in("id",$arg_category);
                    $this->db->where("parents_id",3);
                    $styles = $this->db->get();
                    $styles = $styles->result_array();
                    $this->data["styles"] = "";
                    foreach ($styles as $key => $value) {
                        $this->data["styles"][] = '<a href="'.base_url("search?all_category=".$value["id"]).'">'.$value['title'].'</a>';
                    }
                    $this->data["styles"] = ( $this->data["styles"] != null) ? implode(', ',$this->data["styles"]) : "";

                    //get children category category.
                    $this->db->select("title,id");
                    $this->db->from("categories");
                    $this->db->where_in("id",$arg_category);
                    $this->db->where("parents_id",9);
                    $category = $this->db->get();
                    $category = $category->result_array();
                    $this->data["category"] = "";
                    foreach ($category as $key => $value) {
                        if($value['title'] != null){
                            $this->data["category"][] = '<a href="'.base_url("search?all_category=".$value["id"]).'">'.$value['title'].'</a>';
                        }
                       
                    }
                    $this->data["category"] = ($this->data["category"] != null) ? implode(', ',$this->data["category"]) : "";
                    //get children localtion category.
                    $this->db->select("title,id");
                    $this->db->from("categories");
                    $this->db->where_in("id",$arg_category);
                    $this->db->where("parents_id",215);
                    $localtion = $this->db->get();
                    $localtion = $localtion->result_array();
                    $this->data["localtion"] = "";
                    foreach ($localtion as $key => $value) {
                        $this->data["localtion"][] = '<a href="'.base_url("search?all_category=".$value["id"]).'">'.$value['title'].'</a>';
                    }
                    $this->data["localtion"] = ($this->data["localtion"] != null) ?  implode(', ',$this->data["localtion"]) : "";

                    //get children certifications category.

                    $this->db->select("title,id");
                    $this->db->from("categories");
                    $this->db->where_in("id",$arg_category);
                    $this->db->where("parents_id",263);
                    $certifications = $this->db->get();
                    $certifications = $certifications->result_array();
                    $this->data["certifications"] = "";
                    foreach ($certifications as $key => $value) {
                        $this->data["certifications"][] = '<a href="'.base_url("search?all_category=".$value["id"]).'">'.$value['title'].'</a>';
                    }
                    $this->data["certifications"] = ($this->data["certifications"] != null) ?  implode(', ',$this->data["certifications"]) : "";
                }
                $this->data["indoor_outdoor"] = $indoor_outdoor;
                $this->data["photo_catalog"]  = $this->Common_model->get_result("photos",array("manufacture" => $recorder_photo["manufacture"],"member_id" => $recorder_photo["member_id"]),0,20);
                $this->data["photo_count_catalog"] =  $this->Common_model->count_table("photos",array("manufacture" => $recorder_photo["manufacture"],"member_id" => $recorder_photo["member_id"]));
                $this->data["all_catalog"] = $this->Common_model->get_result("manufacturers",array("member_id" => $recorder_photo["member_id"]));
                $keyword_photo = explode(",",$recorder_photo["keywords"]);
                $this->data["photo_kw_like"] = null;
                $this->data["photo_kw_like_count"] = 0;
                if($keyword_photo != null){
                    $this->db->select("*");
                    $this->db->from("photos");
                    foreach ($keyword_photo as $key => $value) {
                       $this->db->like("keywords",$value);
                    }
                    $this->db->where("member_id",$recorder_photo["member_id"]);
                    $this->data["photo_kw_like_count"] = $this->db->count_all_results();
                    $this->db->select("*");
                    $this->db->from("photos");
                    foreach ($keyword_photo as $key => $value) {
                       $this->db->like("keywords",$value);
                    }
                    $this->db->where("member_id",$recorder_photo["member_id"]);
                    $this->db->limit("10");
                    $this->data["photo_kw_like"] = $this->db->get()->result_array();
                }
               
                $this->load->view('block/header', $this->data);
                $this->load->view('block/wrapper', $this->data);
                $this->load->view('block/footer',$this->data);
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url());
        }
    }
    public function like($object = null) {
        $data["success"] = "error";
        $object_arr = array(
            'photo',
            'product',
            'member',
            'blog',
            'social',
            'category',
            'project'
        );
        if ($this->input->is_ajax_request() && in_array($object, $object_arr)) {
            $photo_id = $this->input->post("photo_id");
            $object_id = $photo_id;
            $rephoto = null;
            if($object == "product"){
                $rephoto = $this->Common_model->get_record("products",["product_id" => $photo_id]) ;
            }
            if($object == "photo"){
                $rephoto = $this->Common_model->get_record("photos",["photo_id" => $photo_id]) ;
            }
            if($object == "social"){
                $rephoto = $this->Common_model->get_record("social_posts",["id" => $photo_id]) ;
            }
            if (isset($photo_id) && $photo_id != null && is_numeric($photo_id)) {
                $recorder_like = $this->Common_model->get_record("common_like", array(
                    "reference_id" => $photo_id,
                    "member_id" => $this->user_id,
                    "type_object" => $object
                ));
                $value_like = 1;
                if ($recorder_like != null && count($recorder_like) > 0) {
                    $value_like = ($recorder_like["status"] == 0) ? 1 : 0;
                    $data1 = array(
                        "status" => $value_like
                    );
                    $where = array(
                        "id" => $recorder_like["id"]
                    );
                    $this->Common_model->update("common_like", $data1, $where);
                   
                    $data["success"] = "success";
                } else {
                    // Check allow like by user's setting
                    $is_allow_comment = $this->get_allow_by_setting($object, $photo_id, "like");
                    if (!$is_allow_comment) {
                        die(json_encode(array(
                            "status" => "false",
                            "message" => "Disallow like at the moment"
                        )));
                    }
                    $data1 = array(
                        "member_id" => $this->user_id,
                        "status" => $value_like,
                        "reference_id" => $photo_id,
                        "type_object" => $object,
                        'created_at' => date('Y-m-d H:i:s'),
                        'pid' => 0
                    );
                    $this->Common_model->add("common_like", $data1);
                    $data["success"] = "success";
                }
                $record_tracking = $this->Common_model->get_record('common_tracking', array(
                    'reference_id' => $photo_id,
                    'type_object' => $object
                ));
                if (isset($record_tracking) && count($record_tracking) > 0) {
                    $num_like = $record_tracking['qty_like'];
                    if ($value_like == 0 && $num_like > 0)
                        $num_like--;
                    else
                        $num_like++;
                    if ($num_like < 0)
                        $num_like = 0;
                    $arr = array(
                        'qty_like' => $num_like
                    );
                    $this->Common_model->update('common_tracking', $arr, array(
                        'reference_id' => $photo_id,
                        'type_object' => $object
                    ));
                }
                else {
                    $arr = array(
                        'reference_id' => $photo_id,
                        'type_object' => $object,
                        'qty_like' => 1,
                        'qty_comment' => 0,
                        'qty_rating' => 0,
                        'qty_pintowall' => 0
                    );
                    $this->Common_model->add('common_tracking', $arr);
                }
                $data["like"] = ($value_like == 0) ? -1 : 1;
                $record_return = $this->Common_model->get_record('common_tracking', array(
                    'reference_id' => $photo_id,
                    'type_object' => $object
                ));
                $common_nofication = $this->Common_model->get_record("notifications_common",["type" => $object,"type_object" => "like","reference_id" => $photo_id ,"member_owner" => $this->user_id]);
                if($common_nofication == null){
                    $data_insert = array(
                        "reference_id"  => $photo_id,
                        "member_owner"  => $this->user_id,
                        "member_id"     => $rephoto["member_id"],
                        "status"        => 0,
                        "type"          => $object,
                        "type_object"   => "like"
                    );
                    $this->Common_model->add("notifications_common",$data_insert);  
                }else{
                    $this->Common_model->delete("notifications_common",["id" => $common_nofication["id"]]);
                }
                $data["record_tracking"] = $record_return["qty_like"];
                if ($value_like == 1) {
                    // Get info from object_id
                    $member_owner = $this->get_owner_object($object, $object_id);
                    // Send mail
                    $mail_subject = $member_owner["subject"];
                    $mail_content = $member_owner["content"] . '<p style="margin:0">&nbsp;</p>
                                        <p style="font-style:italic;color:#7f7f7f">Tip: People are contextual. Post images of your product or project from different angles and
                                            in different settings. This will help buyers visualize your work in multiple applications.</p>
                                        <p style="margin:0">&nbsp;</p>
                                        <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
                                        <p>The bold new way to find and share commercial design inspiration.</p>
                                        <p style="margin:0">&nbsp;</p>
                                        <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';
                    $mail_to = $member_owner["mailto"];
                    sendmail($mail_to, $mail_subject, $mail_content);
                }
            }
        }
        die(json_encode($data));
    }
    public function savejpg($photo_id){
        $photo = $this->Common_model->get_record("photos",["photo_id" => $photo_id]);
        if($photo != null){
            $data_insert = [
                "reference_id"    => $photo_id,
                "member_owner"    => $photo["member_id"],
                "member_id"       => $this->user_id,
                "type_object"     => "photo",
                "type_share_view" => "jpg",
                "created_at"      => date("Y-m-d H:i:s")
            ];
            $url = str_replace(" ","%20",base_url($photo["path_file"]));
            $this->Common_model->add("common_view",$data_insert);
            $exe = explode(".", $photo["path_file"]);
            $type_object = $exe[count($exe) - 1];
            $data_insert = array(
                "reference_id" => $photo_id,
                "member_id"    => $photo["member_id"],
                "member_owner" => $this->user_id,
                "type"         => "photo",
                "type_object"  => "jpg"
            );
            $this->Common_model->add("notifications_common",$data_insert);
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename='.$photo["name"] .'.'.$type_object);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header("Content-type: image/".$type_object."");
            readfile ($url);
        }
        
    }
    /* Get owner of object */

    private function get_owner_object($type_object, $object_id, $type = 'comment') {
        // Get setting by object_id
        $subject = '';
        $content = '';
        $query = null;
        switch ($type_object) {
            case 'product':
                $sql = 'SELECT p.product_name, p.member_id as member_id, pt.path_file, pc.category_id, pc.project_id, ct.qty_like FROM products AS p INNER JOIN photos AS pt ON pt.photo_id = p.photo_id INNER JOIN project_categories AS pc ON p.category_id = pc.category_id INNER JOIN common_tracking AS ct ON ct.reference_id = p.product_id  WHERE p.product_id=' . $object_id . ' LIMIT 1';
                $query = $this->db->query($sql)->row_array();
                $subject = 'Like Image | ' . @$query['product_name'] . ' | ';
                $content = '<p>' . @$query['qty_like'] . ' like(s) people Liked your photo this ' . date('m/d/Y') . '</p>';
                $content .= '<img src="' . base_url(@$query['path_file']) . '" width="200px" />
                            <p>Click here to post more images of your work: <a href="' . base_url('/profile/addphotos/' . @$query['project_id'] . '/' . @$query['category_id']) . '" style="color:#37a7a7;text-decoration:none;">Upload Image</a></p>';
                break;
            case 'photo':
                $sql = 'SELECT p.path_file, p.name, p.member_id, p.photo_id, ct.qty_like FROM photos AS p INNER JOIN common_tracking AS ct ON ct.reference_id = p.photo_id WHERE p.photo_id=' . $object_id . ' LIMIT 1';
                $query = $this->db->query($sql)->row_array();
                $subject = 'Like Image | ' . @$query['name'] . ' | ';
                $content = '<p>' . @$query['qty_like'] . ' like(s) people Liked your photo this ' . date('m/d/Y') . '</p>';
                $content .= '<img src="' . base_url(@$query['path_file']) . '" width="200px" />
                            <p>Click here to post more images of your work: <a href="' . base_url('/profile/addphotos') . '" style="color:#37a7a7;text-decoration:none;">Upload Image</a></p>';
                break;
            case 'member':
                $sql = 'SELECT company_name, id as member_id FROM members WHERE id=' . $object_id . ' LIMIT 1';
                $query = $this->db->query($sql)->row_array();
                $subject = 'Company Comment | ' . @$query['company_name'] . ' | ';
                $content = '<p>' . $this->user_info["full_name"] . ', of ' . $this->user_info["company_name"] . ' posted a comment about your company:</p>
                            <p>Click here to respond to the comment: <a href="' . base_url('/profile/index/' . @$query['member_id']) . '" style="color:#37a7a7;text-decoration:none;">Respond to comment</a></p>';
                break;
        }
        $subject .= ' ' . date('m/d/Y');
        if (!isset($query['member_id']) || $query['member_id'] == null) {
            return null;
        }
        $member = $this->Common_model->get_record('members', array('id' => $query['member_id']));

        return array("subject" => $subject, "content" => $content, "mailto" => $member["email"]);
    }

    /* Check allow comment, like by setting of this member */

    private function get_allow_by_setting($type_object, $object_id, $type = 'comment') {
        return true;
        // If project or member then return true
        if ($type_object == 'member' || $type_object == 'project') {
            return true;
        }

        // Get setting by object_id
        $sql = 'SELECT member_id FROM ';
        switch ($type_object) {
            case 'product':
                $sql .= ' products WHERE product_id=';
                break;
            case 'photo':
                $sql .= ' photos WHERE photo_id=';
                break;
            case 'category':
                $sql .= ' project_categories a, projects b WHERE a.project_id = b.project_id AND category_id=';
                break;
        }
        $sql .= '' . $object_id . ' LIMIT 1';
        $member_query = $this->db->query($sql)->row_array();
        if ($member_query == null) {
            return false;
        }
        $setting = $this->Common_model->get_record('member_setting', array('member_id' => $member_query['member_id']));
        if ($setting == null) {
            return true;
        }

        $duration = 'every';
        switch ($type_object) {
            case 'product':
                $duration = ($type == 'comment') ? $setting['dezignwall_comment'] : $setting['dezignwall_like'];
                break;
            case 'photo':
                $duration = ($type == 'comment') ? $setting['image_comment'] : $setting['image_like'];
                break;
            case 'category':
                $duration = ($type == 'comment') ? $setting['dezignwall_folder_comment'] : $setting['dezignwall_folder_like'];
                break;
        }

        if ($setting == null || $duration == 'every') {
            return true;
        }

        if ($duration == 'never') {
            return false;
        }

        // Get last record
        $table = ($type == 'comment') ? "common_comment" : "common_like";
        $last_record = $this->Common_model->get_record($table, array("reference_id" => $object_id, "pid" => "0"), array(array("field" => "created_at", "sort" => "desc")));
        if ($last_record == null) {
            return true;
        }

        $datetime1 = strtotime('-1 ' . $duration);
        $datetime2 = strtotime($last_record['created_at']);
        $secs = $datetime2 - $datetime1;
        if ($secs < 0)
            return true;
        return false;
    }

    public function get_project_member() {
        if ($this->input->is_ajax_request()) {
            $this->load->model("Members_model");
            $this->load->model("Project_model");
            $check_member_expand = $this->Members_model->get_member_designwalls($this->user_id);
            $data["success"] = "error";
            $data["reponse"] = array();
            $data["type_designwall"] = 0;
            if($check_member_expand != null){
                $data["type_designwall"] = $this->Project_model->get_packages_use($this->user_id);
            }
            $data["type_designwall"] = 999999999;
            $record_user = $this->Common_model->get_record("members", array(
                "id" => $this->user_id
            ));
           
            $number_project_owner = $this->Common_model->get_result("projects", array(
                "member_id" => $this->user_id
            ));
            $data["number_project_owner"] = count($number_project_owner);
            $record_project_all_member = $this->Project_model->get_all_project_member($this->user_id);
            if ($record_project_all_member != null) {
                $data["reponse"] = $record_project_all_member;
                $data["success"] = "success";
                $data["user_id"] = $this->user_id;
            }
            die(json_encode($data));
        } else {
            redirect(base_url());
        }
    }

    public function get_project_category() {
        if ($this->input->is_ajax_request()) {
            $data["success"] = "success";
            $data["reponse"] = "";
            $project_id = $this->input->post("project_id");
            $record_project_ct = $this->Common_model->get_result("project_categories", array(
                "project_id" => $project_id,
                'status' => 'no'
            ));
            if ($record_project_ct != null && count($record_project_ct) > 0) {
                $data["reponse"] = $record_project_ct;
            }

            die(json_encode($data));
        } else {
            redirect(base_url());
        }
    }

    public function pin_to_wall() {
        if ($this->input->is_ajax_request()) {
            $check_error = 0;
            $photo_id = @$this->input->post('photo_id');
            $project_id = @$this->input->post('project_id');
            $new_project = @$this->input->post('new_project');
            $category_id = @$this->input->post('category_id');
            $new_category = @$this->input->post('new_category');
            $pin_comment = @$this->input->post('pin_comment');
            $data["success"] = "error";
            $data["reponse"] = array();
            if ($this->Common_model->count_table("photos", array(
                        "photo_id" => $photo_id
                    )) < 1) {
                $data["messenger"] = "Image not exist";
                $check_error++;
                die(json_encode($data));
            }
            $this->load->model('Project_model');
            $user_id = $this->user_info["id"];
            $upgrade = $this->Project_model->get_packages_use($user_id);
            $all_project = $this->Common_model->count_table("projects",["member_id" => $user_id]);
            $data["upgrade"] = false;
            if($all_project >=  $upgrade && trim($new_project) != "" && $project_id == ""){
                $data["messenger"] = "Upgrade your Wall";
                die(json_encode($data));
            }
 
            if ($project_id == 0 && trim($new_project) != "") {
                $record = $this->Common_model->count_table("projects", array(
                    "project_name" => trim($new_project),
                    "member_id"    => $this->user_id
                ));
                if ($record > 0) {
                    $data["messenger"] = "Title Dezignwall already exists";
                    $check_error++;
                    die(json_encode($data));
                }
            } else {
                $check = $this->Project_model->check_member_project($this->user_id, $project_id);
                if ($check == null || count($check) == 0) {
                    $data["messenger"] = "You don’t have permission to access this project";
                    $check_error++;
                    die(json_encode($data));
                }
            }

            if ($category_id == 0 && trim($new_category) != "") {
                $record = $this->Common_model->count_table("project_categories", array(
                    "title" => trim($new_category),
                    "project_id" => $project_id
                ));
                if ($record > 0) {
                    $data["messenger"] = "This title folder already exists.";
                    $check_error++;
                    die(json_encode($data));
                }
            } else {
                $record = $this->Common_model->count_table("products", array(
                    "category_id" => $category_id,
                    "photo_id" => $photo_id
                ));
                if ($record > 0) {
                    $data["messenger"] = "Image already exists in this folder";
                    $check_error++;
                    die(json_encode($data));
                }
            }

            if ($check_error == 0) {
                $date = date('Y-m-d H:i:s');
                if ($project_id == 0 && trim($new_project) != "") {
                    $data_insert = array(
                        'project_name' => trim($new_project),
                        'created_at' => $date,
                        'member_id' => $this->user_id
                    );
                    $project_id = $this->Common_model->add("projects", $data_insert);
                }

                if ($category_id == 0 && trim($new_category) != "" && $project_id != 0) {
                    $data_insert = array(
                        'project_id' => $project_id,
                        'title' => trim($new_category)
                    );
                    $category_id = $this->Common_model->add("project_categories", $data_insert);
                }

                if ($project_id != 0 && $category_id != 0) {
                    $record_photo = $this->Common_model->get_record("photos", array(
                        "photo_id" => $photo_id
                    ));
                    $record_project = $this->Common_model->get_record("projects", array(
                        "project_id" => $project_id
                    ));
                    if ($record_photo != null) {
                        $data_insert = array(
                            "photo_id" => $record_photo["photo_id"],
                            "member_id" => $record_project["member_id"],
                            "member_updated_id" => $this->user_id,
                            "product_name" => @$record_photo['name'],
                            "category_id" => $category_id,
                            "created_at" => $date
                        );
                        $id_product = $this->Common_model->add("products", $data_insert);
                        if ($id_product) {
                            $record_user = $this->Common_model->get_record("members", array(
                                "id" => $record_photo["member_id"]
                            ));
                            if (isset($record_user) && count($record_user) > 0 && $pin_comment != "") {
                                // Insert db
                                $data_insert = array(
                                    "reference_id" => $photo_id,
                                    "member_id" => $this->user_id,
                                    "comment" => $pin_comment,
                                    "created_at" => $date,
                                    "type_object" => "photo"
                                );
                                $this->Common_model->add("common_comment", $data_insert);
                            }

                            $record_photo_tracking = $this->Common_model->get_record("common_tracking", array(
                                "reference_id" => $photo_id,
                                "type_object" => "photo"
                            ));
                            if ($record_photo_tracking != null) {
                                $data_update["qty_pintowall"] = $record_photo_tracking["qty_pintowall"] + 1;
                                if ($pin_comment != "") {
                                    $data_update["qty_comment"] = $record_photo_tracking["qty_comment"] + 1;
                                }

                                $this->Common_model->update("common_tracking", $data_update, array(
                                    "id" => $record_photo_tracking["id"]
                                ));
                            } else {
                                $data_insert = array(
                                    "reference_id" => $photo_id,
                                    "qty_pintowall" => 1,
                                    "type_object" => "photo"
                                );
                                if ($pin_comment != "") {
                                    $data_insert["qty_comment"] = 1;
                                }

                                $this->Common_model->add("common_tracking", $data_insert);
                            }
                            //create notification 
                            $data_insert = array(
                                "type"          => "photo",
                                "member_owner"  => $this->user_id,
                                "member_id"     => $record_photo["member_id"],
                                "type_object"   => "pin",
                                "reference_id"  => $photo_id,
                                "status"        => 1,
                                "allow"         => 1
                            );
                            $this->Common_model->add("notifications_common",$data_insert );


                            $data_insert = array(
                                "reference_id"      => $photo_id,
                                "member_owner"      => $record_photo["member_id"],
                                "member_id"         => $this->user_id,
                                "type_share_view"   => "pin",
                                "type_object"       => "photo",
                                "created_at"        => date('Y-m-d H:i:s')
                            ); 
                            $this->Common_model->add("common_view",$data_insert );
                            // Send mail
                            $sql = 'SELECT p.path_file, p.name, p.member_id, p.photo_id, ct.qty_pintowall FROM photos AS p INNER JOIN common_tracking AS ct ON ct.reference_id = p.photo_id WHERE p.photo_id=' . $photo_id . ' LIMIT 1';
                            $query = $this->db->query($sql)->row_array();
                            $member = $this->Common_model->get_record('members', array('id' => @$query['member_id']));
                            $mail_subject = 'Pin Results | ' . @$query['name'] . ' | ' . date('m/d/Y');
                            $mail_content = '<p>' . @$query['qty_pintowall'] . ' people Pinned your photo to their Design Walls this ' . date('d/W/m') . '</p>';
                            $mail_content .= '<img src="' . base_url(@$query['path_file']) . '" width="200px" />
                                                <p>Click here to post more images of your work: <a href="' . base_url('/profile/addphotos') . '" style="color:#37a7a7;text-decoration:none;">Upload Image</a></p>';
                            $mail_content .= '<p style="margin:0">&nbsp;</p>
                                                <p style="font-style:italic;color:#7f7f7f">Tip: Help buyers find your product or service easier, by tagging your image with keywords for other applications (example: office, lobby, lounge, restaurant, club, retail, etc.).</p>
                                                <p style="margin:0">&nbsp;</p>
                                                <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
                                                <p>The bold new way to find and share commercial design inspiration.</p>
                                                <p style="margin:0">&nbsp;</p>
                                                <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';
                            sendmail(@$member["email"], $mail_subject, $mail_content);
                        }
                    }
                }

                $data["success"] = "success";
                $data["project_id"] = $project_id;
            }

            die(json_encode($data));
        } else {
            redirect(base_url());
        }
    }

    public function seachimages() {
        if ($this->input->is_ajax_request()) {
            $pkeyword         = (trim($this->input->post("keyword")) != "") ? trim($this->input->post("keyword")) : NULL;
            $pcatalog         = (trim($this->input->post("catalog")) != "") ? trim($this->input->post("catalog")) : NULL;
            $pall_category    = (trim($this->input->post("all_category")) != "") ? trim($this->input->post("all_category")) : NULL;
            $plocation        = (trim($this->input->post("location_photo")) != "") ? trim($this->input->post("location_photo")) : NULL;
            $photo_type      = (trim($this->input->post("type_photo")) != "") ? trim($this->input->post("type_photo")) : NULL;
            $pcategory_slug   = (trim($this->input->post("slug_category")) != "") ? trim($this->input->post("slug_category")) : NULL;
            $nav              =  $this->input->post("nav");
            $limit            =  $this->input->post("number_nav_page");
            $is_home          =  $this->input->post("is_home");
            $offer_product    =  (trim($this->input->post("offer_product")) != "") ? trim($this->input->post("offer_product")) : NULL;
            $offset = ($nav) * ($limit);
            $post_social_show = ($this->input->post("post_social_show") != null) ? $this->input->post("post_social_show") : NULL;
            $this->load->model('Category_model');
            $this->load->model("Photo_model");
            $all_category = NULL;
            $category_table = $this->Common_model->get_result("categories", array("pid !=" => 0,"type" => "system"));
            if($pcategory_slug != NULL){
                $category_slug = $this->Category_model->get_cat_by_slug_title($pcategory_slug);
                foreach ($category_slug as $value) {
                    $all_category [] = $this->get_children_cat($value["id"],$category_table);
                    $all_category [] = $value["id"];
                }
            }
            // category not emty.
            if($pall_category != NULL){
                $all_category = explode(",", $pall_category);
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
            if($plocation != NULL){
                $location = explode(",", $plocation);
                $location = array_diff($location, array(''));
            }
            // !location not emty.
            // keyword not emty.
            $keyword = NULL;
            if($pkeyword != NULL)
                $keyword = addslashes(trim($pkeyword));
            // !keyword not emty.
            $catalog = NULL;
            if($pcatalog != NULL && is_numeric($pcatalog)) 
                $catalog = $pcatalog;
            if($all_category != NULL){
                $all_category = implode(",", $all_category);
                $all_category = explode(",", $all_category);
                $all_category = array_unique($all_category);
                $all_category = array_diff($all_category, array(''));
            }
            $recorder = $this->Photo_model->seach_photo($location, $this->user_id, $keyword, $all_category,$photo_type, $offset, $limit,$catalog,null,null,$offer_product);
            // get article.
            $this->load->model('Article_model');
            $article = [];
            if($keyword != NULL){
                $offset = $nav * 3;
                $article = $this->Article_model->get_by_keyword($keyword,$offset,3,NULL); 
            }else{
                $offset = $nav * 2;
                if($this->data["is_login"] && $is_home == "true")
                    $article = $this->Article_model->get_article($offset,2,NULL);
                else
                    $article = $this->Article_model->get_article($offset,3,NULL);
            }
            $member_id = $this->user_id == null ? 0 : $this->user_id; 
            $social_post = array();
            if($photo_type != "projects" && $photo_type != "products"){
                if($pkeyword == null && $pcatalog == null && $all_category == null && $photo_type == null && $offer_product == null){
                    if($this->data["is_login"] && $is_home == "true")
                        $social_post = $this->Article_model->social_post(($offset * 10),10,null,null,$member_id);
                    else
                        $social_post = $this->Article_model->social_post(($offset * 12),12,null,null,$member_id);
                }
               
                // !get article.
            }
            $data["photo"] = [];
            if($this->data["is_login"] && $is_home == "true")
                $set_count = ceil(count($recorder)/2);
            else    
                $set_count = ceil(count($recorder)/3);
            $rand_items = rand(1,$set_count);
            $i_offset_photo = 0;
            $i_article = 0;
            $i_social = 0;
            try {
                if($social_post != null || $recorder != null)
                    $n_recorder = array_merge($social_post, $recorder);
                if($n_recorder != null){
                    usort($n_recorder, function($a, $b) {
                      $ad = new DateTime($a['created_at']);
                      $bd = new DateTime($b['created_at']);
                      if ($ad == $bd) {
                        return 0;
                      }
                      return $ad > $bd ? -1 : 1;
                    });
                }
            }
            catch (Exception $e){
                $n_recorder = $photo;
            }
            foreach ($n_recorder as $key => $value) {
                if($value["is_type_post"] == "photo"){
                    $photo["photo"] = $value;
                    $data["photo"][] = $this->load->view('seach/seach_result_ajax', $photo, true);
                }else if($value["is_type_post"] == "social"){
                    $photo["social"] = $value;
                    $data["photo"][] = $this->load->view('seach/social-post', $photo, true);
                }

                if(isset($article) && isset($article[$i_article])  && $i_offset_photo == $rand_items){
                    $data_a["article"] = $article[$i_article];
                    $data["photo"][] = $this->load->view('seach/article',$data_a, true);
                    $i_article++;  
                }
                if($set_count == $i_offset_photo){
                    $i_offset_photo = 0;
                    $rand_items = rand(1,$set_count);
                } 
                $i_offset_photo++;
            }
            $data["login"] = $this->is_login;
            $data["post"] = $this->input->post();
            die(json_encode($data));
        }
    }
 
    public function get_photos_like() {
        if ($this->input->is_ajax_request()) {
            $data["success"] = "error";
            $keyword = $this->input->post("keyword");
            if (trim($keyword) != "") {
                $this->load->model("Photo_model");
                $record_photo = $this->Photo_model->get_photos_like($keyword);
                $data["success"] = "success";
                $data["record"] = $record_photo;
                die(json_encode($data));
            }
        }else{
            redirect(base_url());
        }
    }

    function get_all_comment_photo() {
        if ($this->input->is_ajax_request()) {
            $photo_id = $this->input->post("photo_id");
            if (is_numeric($photo_id) && $photo_id > 0) {
                $this->load->model("Photo_model");
                $get_all_comment = $this->Photo_model->get_comment_photobyid(array($photo_id));
                die(json_encode($get_all_comment));
            }
        } else {
            redirect(base_url());
        }
    }

    function new_imgaes() {
        $data["success"] = "error";
        if ($this->input->is_ajax_request()) {
            $get_record = $this->Common_model->get_record("photos", array("name !=" => null), array(["field" => "photo_id", "sort" => "DESC"]));
            if ($get_record != null) {
                $data["success"] = "success";
                $data["id"] = $get_record["photo_id"];
            }
        }
        die(json_encode($data));
    }

    function get_count_new_imgaes() {
        $data["success"] = "error";
        if ($this->input->is_ajax_request()) {
            if ($this->input->post("id") > 0 && is_numeric($this->input->post("id"))) {
                $id = $this->input->post("id");
                $get_record = $this->Common_model->count_table("photos", array("photo_id > " => $id, "name !=" => null));
                $data["success"] = "success";
                $data["count"] = $get_record;
            }
        }
        die(json_encode($data));
    }

    function get_comment_photo($ojb = null) {
        if ($this->input->is_ajax_request()) {
            $photo_id = $this->input->post("photo_id");
            $item = $this->input->post("item");
            if (is_numeric($photo_id) && $photo_id > 0 && is_numeric($item)) {
                $item = intval($item) + 1;
                $this->load->model("Photo_model");
                $get_all_comment = $this->Photo_model->get_comment_photo($photo_id, 0, $item, $ojb);
                $data["user_id"] = $this->user_id;
                $data["comment"] = $get_all_comment;
                $number_like_comment = $this->Common_model->get_record("common_tracking", array(
                    "reference_id" => $photo_id,
                    "type_object" => $ojb
                ));
                $qty_comment = 0;
                if (is_array($number_like_comment) && count($number_like_comment) > 0) {
                    $qty_comment = $number_like_comment["qty_comment"];
                }
                $data["all_comment"] = $qty_comment;
                die(json_encode($data));
            }
        } else {
            redirect(base_url());
        }
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
    public function genenator_qr($photo_id){
        $photos = $this->Common_model->get_record("photos",array("photo_id" => $photo_id));
        if($photos != null){
            include(FCPATH . '/application/libraries/phpqrcode/qrlib.php'); 
            $codeContents = base_url("photos/".$photos ["photo_id"]."/" .gen_slug($photos ["name"])); 
            QRcode::png($codeContents,false, "L", 4, 2); 
        }
        
    }
    public function print_pdf($photo_id){
        $photos = $this->Common_model->get_record("photos",array("photo_id" => $photo_id));
        if(!$this->is_login )die("error");
        if($photos != null){
            $members  = $this->Common_model->get_record("members",array("id" => $photos["member_id"]));
            $company  = $this->Common_model->get_record("company",array("member_id" => $photos["member_id"]));
            $logo     = $members["logo"];
            if($logo == ""){
               $logo = base_url("skins/images/logo-company.png"); 
            }
            $photo    = base_url($photos["path_file"]);
            $indoor_outdoor = "";
            $arg_category = explode("/",$photos["category"]);
            $arg_category = array_diff($arg_category,array(""));
            if(strpos($photos["category"], '/1/') !== false){
                $indoor_outdoor = "Indoor Use";
            }
            if(strpos($photos["category"], '/2/')!== false){
                $indoor_outdoor = "Outdoor Use";
            }
            if(strpos($photos["category"], '/1/') !== false && strpos($photos["category"], '/2/') !== false){
                $indoor_outdoor = "Indoor, Outdoor Use";
            }
            $description = "";
            if (strlen($photos['description']) <= 65) {
                $description =  trim($photos['description']) ;
            } else {
                $description = trim(substr($photos['description'], 0, 65)). "...";
            }
            $certifications = json_decode(@$company["certifications"],true);
            $t_certifications = "";
            if(@$certifications != null){
                $t_certifications = "<p>".@$certifications["text"]."</p>";
            }
            $styles = $category = $localtion = "";
            if($arg_category != null){
                $this->db->select("title");
                $this->db->from("categories");
                $this->db->where_in("id",$arg_category);
                $this->db->where("parents_id",3);
                $styles = $this->db->get();
                $styles = $styles->result_array();
                $styles = implode(', ', array_column($styles, 'title'));
                //get children category category.
                $this->db->select("title");
                $this->db->from("categories");
                $this->db->where_in("id",$arg_category);
                $this->db->where("parents_id",9);
                $category = $this->db->get();
                $category = $category->result_array();
                $category = implode(', ', array_column($category, 'title'));
                //get children localtion category.
                $this->db->select("title");
                $this->db->from("categories");
                $this->db->where_in("id",$arg_category);
                $this->db->where("parents_id",215);
                $localtion = $this->db->get();
                $localtion = $localtion->result_array();
                $localtion = implode(', ', array_column($localtion, 'title'));
            }
          
            $type_photo = '
                <tr>
                  <td>Photo info:</td>
                  <td>
                    <img style="margin-right:5px;float;left" src="'.skin_url("images/pdf_photo_not_activer.png").'"> <span style="float;left">Project</span>
                  </td>
                  <td>
                    <img style="margin-right:5px;float;left" src="'.skin_url("images/pdf_photo_activer.png").'"> <span style="float;left">Product</span>
                  </td>
                </tr>';
            if($photos["image_category"] == "Project"){
                $type_photo = '
                <tr>
                  <td>Photo info:</td>
                  <td>
                    <img style="margin-right:5px; float;left" src="'.skin_url("images/pdf_photo_activer.png").'"> <span style="float;left">Project</span>
                  </td>
                  <td>
                    <img style="margin-right:5px; float;left" src="'.skin_url("images/pdf_photo_not_activer.png").'"> <span style="float;left">Product</span>
                  </td>
                </tr>';
            }
            if($members != null){
                include(FCPATH . 'application/libraries/MPDF_6_0/mpdf.php'); 
                $mpdf = new mPDF('','A4');
                $html = '
                <style>
                    @page {
                        margin: 20px;
                    }
                    a{color:#37a7a7 ;text-decoration: none;}
                    p,td{font-size:13px; color:#000;}
                    table{padding-left:10px;}
                    img{max-width:100%}                 
                </style>

                <div style="background-color: rgba(0, 0, 0, 0.49);height: 51px;z-index:2;position: relative;padding: 10px;">
                  <div style="width:50px; height:50px;float:left">
                      <img class="logo-company" style="border-radius: 100%;width: 50px;height: 50px;float: left;" src="'.@$logo.'"> 
                  </div>
                  <div style="float:left;margin-left: 20px;">
                    <p style="display:block;margin: 0;padding: 0;color: #fff;line-height: 1.5;font-size: 20px;font-weight: bold;">'.@$photos["name"].'</p>
                    <p style="display:block;margin: 0;padding: 0;color: #fff;font-size: 16px;">'.@$description.'</p>
                  </div>
                </div>
                <div style="z-index:99999;position:relative;text-align:right;margin-top:-70px; margin-right:0px;"><img style="width:100px;height:100px;border:1px solid #000;" src="'.base_url("/photos/genenator_qr/".@$photo_id."").'"></div>
                <div style="position:relative;margin-top: -102px; z-index: -1; float: left; width: 100%; text-align: center;">
                  <img style="max-height:970px;" src="'.@$photo.'">
                </div>

                <div style="float: left;width: 100%;">
                    <p style="text-align: right;">Photo by: '.@$photos["photo_credit"].'</p>
                </div>
                <div style="float: left;width: 100%;">
                  <h4 style="font-size: 18px;margin-bottom: 0;">'.@$members["company_name"].' | '. @$company["business_type"].'</h4>
                  <p style="margin: 5px 0;">'.@$company["business_description"].'</p>
                </div>
                <h4 style="border: 1px solid #ccc"></h4>
                <div style="width: 47%;float: left;border-right: 2px solid #ccc; padding-right:3%">
                  <p><strong>Photo info</strong></p>
                  <table style="padding-left:0;float:left;width:100%;">
                    '.@$type_photo.'
                  </table>
                  <div>
                    <table>
                        <tr>
                            <td valign="top" style="text-align:right">This is for:</td>
                            <td valign="top">'.@$indoor_outdoor .'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Style:</td>
                            <td valign="top">'.@$styles.'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Category:</td>
                            <td valign="top">'.@$category.'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Location:</td>
                            <td valign="top">'.@$localtion.'</td>
                        </tr>
                    </table>
                  </div>
                  <h4 style="border: 1px solid #ccc"></h4>
                  <p><strong>Desription: </strong></p>
                  <p>'.@$photos["description"].'</p>';
                  if($photos["image_category"] == "Product"){
                      $html .='<h4 style="border: 1px solid #ccc"></h4>
                      <p><strong>Product info: </strong></p>
                      <div>
                        <table>
                            <tr>
                                <td valign="top" style="text-align:right">Avalible in:</td>
                                <td valign="top">'.@$photos["offer_product"].'</td>
                            </tr>
                            <tr>
                                <td valign="top" style="text-align:right">Sample Qty:</td>
                                <td valign="top">'.$photos["unit_price"].'</td>
                            </tr>
                            <tr>
                                <td valign="top" style="text-align:right">Sample Price:</td>
                                <td valign="top">'.$photos["sample_pricing"].'</td>
                            </tr>
                       
                        </table>
                      </div>';
                  }
                  $html .='<p><strong>Ceritifcations: </strong></p>
                  '.$t_certifications.'
                </div>
                <div style="width: 46% ;float: left; padding-left:3%">
                    <p><strong>Company info: </strong></p>
                     <table>
                        <tr>
                            <td valign="top" style="text-align:right">Toll free:</td>
                            <td valign="top" >'.$members["cellphone"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Local phone:</td>
                            <td valign="top">'.$company["main_business_ph"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Email:</td>
                            <td valign="top">'.$company["contact_email"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Website:</td>
                            <td valign="top" ><a href="'.$company["web_address"].'">'.$company["web_address"].'</a></td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Address:</td>
                            <td valign="top" >'.$company["main_address"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">City, State:</td>
                            <td valign="top" >'.$company["city"].', '.$company["state"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Zipcode:</td>
                            <td valign="top" >'.$company["zip_code"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Country:</td>
                            <td valign="top">'.$company["country"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Profile URL:</td>
                            <td valign="top"><a href="'.base_url("profile/index/".$members["id"]).'">'.$members["company_name"].'</a></td>
                        </tr>
                    </table>
                    <p style="text-align:center;"><a style="color:#37a7a7 ;width:100%;text-decoration: none;" href ="'.base_url("profile/sales_reps/".$members["id"]).'">Click to find a local rep</a></p>
                    <h4 style="border: 1px solid #ccc"></h4>
                    <p><strong>About: </strong></p>
                    <p>'.$company["company_about"].'<a href ="'.base_url("profile/index/".$members["id"]).'" style="color:#37a7a7;text-decoration: none;">...MORE</a></p>
                    <h4 style="border: 1px solid #ccc"></h4>
                    <p><strong>Service Area: </strong></p>
                    <p>'.$company["service_area"].'</p>
                </div>';
                if($photos["image_category"] == "Project"){
                    $html .='<div style="width:100%; float:left ;margin-top:30px;">
                        <div style="width:50%;float:left; text-align:center">
                            <a href="'.base_url("photos/".$photos ["photo_id"]."/" .gen_slug($photos ["name"])).'" style="text-align:center; font-size:18px;text-decoration: none;"><img src="'.skin_url("images/this-view-image.png").'"></a>
                        </div>
                        <div style="width:50%;float:left;text-align:center">
                            <a href="'.base_url("/profile/myphoto/".$members["id"]."?catalog=".$photos["manufacture"]."").'" style="text-align:center text-decoration: none;"><img src ="'.skin_url("images/this-view-catalog.png").'"></a>
                        </div>
                    </div>';
                }else{                
                    $html .='<div style="width:100%; float:left ;margin-top:30px;">
                        <div style="width:33.3%;float:left; text-align:center">
                            <a href="'.base_url("photos/".$photos ["photo_id"]."/" .gen_slug($photos ["name"])).'" style="text-align:center; font-size:18px;text-decoration: none;"><img src="'.skin_url("images/this-view-image.png").'"></a>
                        </div>
                        <div style="width:33.3%;float:left;text-align:center">
                            <a href="'.base_url("/profile/myphoto/".$members["id"]."?catalog=".$photos["manufacture"]."").'" style="text-align:center text-decoration: none;"><img src ="'.skin_url("images/this-view-catalog.png").'"></a>
                        </div>
                        <div style="width:33.3%;float:left;text-align:center">
                            <a href="'.base_url("profile/request_quote/".$photos["photo_id"]).'" style="text-align:center;text-decoration: none;"><img src ="'.skin_url("images/request-a-quote.png").'"></a>
                        </div>
                    </div>';
                }               
                $html .= '<div style="width:100%; float:left ;margin-top:30px; font-size:12px;">
                    <div style="width:20%; float:left ;text-align:left;">&copy; Dezignwall Inc.</div>
                    <div style="width:25%; float:left ;text-align:center;">2014 All Right Reserved</div>
                    <div style="width:25%; float:left ;text-align:center;">WWW.Dezignwall.com</div>
                    <div style="width:15%; float:left ;text-align:center;">&copy; Dezignwall</div>
                    <div style="width:15%; float:left;text-align:right">#Dezignwall</div>
                </div>
                ';
                $mpdf->SetJS('this.print();');
                $mpdf->WriteHTML($html);
                $mpdf->Output("photo.pdf","I");
                
                exit();    
            }
                 
        }
    }
    public function download_pdf($photo_id){
        if(!$this->is_login )die("error");
        $photos = $this->Common_model->get_record("photos",array("photo_id" => $photo_id));
        if($photos != null){
            $data_insert = [
                "reference_id"    => $photo_id,
                "member_owner"    => $photos["member_id"],
                "member_id"       => $this->user_id,
                "type_object"     => "photo",
                "type_share_view" => "pdf",
                "created_at"      => date("Y-m-d H:i:s")
            ];
            $this->Common_model->add("common_view",$data_insert);
            $members  = $this->Common_model->get_record("members",array("id" => $photos["member_id"]));
            $company  = $this->Common_model->get_record("company",array("member_id" => $photos["member_id"]));
            $logo     = $members["logo"];
            if($logo == null ){
                $logo = base_url("skins/images/logo-company.png");
            }
            $photo    = base_url($photos["path_file"]);
            $indoor_outdoor = "";
            $arg_category = explode("/",$photos["category"]);
            $arg_category = array_diff($arg_category,array(""));
            if(strpos($photos["category"], '/1/') !== false){
                $indoor_outdoor = "Indoor Use";
            }
            if(strpos($photos["category"], '/2/')!== false){
                $indoor_outdoor = "Outdoor Use";
            }
            if(strpos($photos["category"], '/1/') !== false && strpos($photos["category"], '/2/') !== false){
                $indoor_outdoor = "Indoor, Outdoor Use";
            }
            $description = "";
            if (strlen($photos['description']) <= 65) {
                $description =  trim($photos['description']) ;
            } else {
                $description = trim(substr($photos['description'], 0, 65)). "...";
            }
            $certifications = json_decode(@$company["certifications"],true);
            $t_certifications = "";
            if(@$certifications != null){
                $t_certifications = "<p>".@$certifications["text"]."</p>";
            }
            $styles = $category = $localtion = "";
            if($arg_category != null){
                $this->db->select("title");
                $this->db->from("categories");
                $this->db->where_in("id",$arg_category);
                $this->db->where("parents_id",3);
                $styles = $this->db->get();
                $styles = $styles->result_array();
                $styles = implode(', ', array_column($styles, 'title'));
                //get children category category.
                $this->db->select("title");
                $this->db->from("categories");
                $this->db->where_in("id",$arg_category);
                $this->db->where("parents_id",9);
                $category = $this->db->get();
                $category = $category->result_array();
                $category = implode(', ', array_column($category, 'title'));
                //get children localtion category.
                $this->db->select("title");
                $this->db->from("categories");
                $this->db->where_in("id",$arg_category);
                $this->db->where("parents_id",215);
                $localtion = $this->db->get();
                $localtion = $localtion->result_array();
                $localtion = implode(', ', array_column($localtion, 'title'));
            }
            $data_insert = array(
                "reference_id" => $photo_id,
                "member_id"    => $photos["member_id"],
                "member_owner" => $this->user_id,
                "type"         => "photo",
                "type_object"  => "pdf"
            );
            $this->Common_model->add("notifications_common",$data_insert);
            $type_photo = '
                <tr>
                  <td>Photo info:</td>
                  <td>
                    <img style="margin-right:5px;float;left" src="'.skin_url("images/pdf_photo_not_activer.png").'"> <span style="float;left">Project</span>
                  </td>
                  <td>
                    <img style="margin-right:5px;float;left" src="'.skin_url("images/pdf_photo_activer.png").'"> <span style="float;left">Product</span>
                  </td>
                </tr>';
            if($photos["image_category"] == "Project"){
                $type_photo = '
                <tr>
                  <td>Photo info:</td>
                  <td>
                    <img style="margin-right:5px; float;left" src="'.skin_url("images/pdf_photo_activer.png").'"> <span style="float;left">Project</span>
                  </td>
                  <td>
                    <img style="margin-right:5px; float;left" src="'.skin_url("images/pdf_photo_not_activer.png").'"> <span style="float;left">Product</span>
                  </td>
                </tr>';
            }
            if($members != null){
                include(FCPATH . 'application/libraries/MPDF_6_0/mpdf.php'); 
                $mpdf = new mPDF('','A4');
                $html = '
                <style>
                    @page {
                        margin: 20px;
                    }
                    a{color:#37a7a7 ;text-decoration: none;}
                    p,td{font-size:13px; color:#000;}
                    table{padding-left:10px;}
                    img{max-width:100%}                 
                </style>

                <div style="background-color: rgba(0, 0, 0, 0.49);height: 51px;z-index:2;position: relative;padding: 10px;">
                  <div style="width:50px; height:50px;float:left">
                      <img class="logo-company" style="border-radius: 100%;width: 50px;height: 50px;float: left;" src="'.@$logo.'"> 
                  </div>
                  <div style="float:left;margin-left: 20px;">
                    <p style="display:block;margin: 0;padding: 0;color: #fff;line-height: 1.5;font-size: 20px;font-weight: bold;">'.@$photos["name"].'</p>
                    <p style="display:block;margin: 0;padding: 0;color: #fff;font-size: 16px;">'.@$description.'</p>
                  </div>
                </div>
                <div style="z-index:99999;position:relative;text-align:right;margin-top:-70px; margin-right:0px;"><img style="width:100px;height:100px;border:1px solid #000;" src="'.base_url("/photos/genenator_qr/".@$photo_id."").'"></div>
                <div style="position:relative;margin-top: -102px; z-index: -1; float: left; width: 100%; text-align: center;">
                  <img style="max-height:970px;" src="'.@$photo.'">
                </div>

                <div style="float: left;width: 100%;">
                    <p style="text-align: right;">Photo by: '.@$photos["photo_credit"].'</p>
                </div>
                <div style="float: left;width: 100%;">
                  <h4 style="font-size: 18px;margin-bottom: 0;">'.@$members["company_name"].' | '. @$company["business_type"].'</h4>
                  <p style="margin: 5px 0;">'.@$company["business_description"].'</p>
                </div>
                <h4 style="border: 1px solid #ccc"></h4>
                <div style="width: 47%;float: left;border-right: 2px solid #ccc; padding-right:3%">
                  <p><strong>Photo info</strong></p>
                  <table style="padding-left:0;float:left;width:100%;">
                    '.@$type_photo.'
                  </table>
                  <div>
                    <table>
                        <tr>
                            <td valign="top" style="text-align:right">This is for:</td>
                            <td valign="top">'.@$indoor_outdoor .'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Style:</td>
                            <td valign="top">'.@$styles.'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Category:</td>
                            <td valign="top">'.@$category.'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Location:</td>
                            <td valign="top">'.@$localtion.'</td>
                        </tr>
                    </table>
                  </div>
                  <h4 style="border: 1px solid #ccc"></h4>
                  <p><strong>Desription: </strong></p>
                  <p>'.@$photos["description"].'</p>';
                  if($photos["image_category"] == "Product"){
                      $html .='<h4 style="border: 1px solid #ccc"></h4>
                      <p><strong>Product info: </strong></p>
                      <div>
                        <table>
                            <tr>
                                <td valign="top" style="text-align:right">Avalible in:</td>
                                <td valign="top">'.@$photos["offer_product"].'</td>
                            </tr>
                            <tr>
                                <td valign="top" style="text-align:right">Sample Qty:</td>
                                <td valign="top">'.$photos["unit_price"].'</td>
                            </tr>
                            <tr>
                                <td valign="top" style="text-align:right">Sample Price:</td>
                                <td valign="top">'.$photos["sample_pricing"].'</td>
                            </tr>
                       
                        </table>
                      </div>';
                  }
                  $html .='<p><strong>Ceritifcations: </strong></p>
                  '.$t_certifications.'
                </div>
                <div style="width: 46% ;float: left; padding-left:3%">
                    <p><strong>Company info: </strong></p>
                     <table>
                        <tr>
                            <td valign="top" style="text-align:right">Toll free:</td>
                            <td valign="top" >'.$members["cellphone"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Local phone:</td>
                            <td valign="top">'.$company["main_business_ph"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Email:</td>
                            <td valign="top">'.$company["contact_email"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Website:</td>
                            <td valign="top" ><a href="'.$company["web_address"].'">'.$company["web_address"].'</a></td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Address:</td>
                            <td valign="top" >'.$company["main_address"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">City, State:</td>
                            <td valign="top" >'.$company["city"].', '.$company["state"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Zipcode:</td>
                            <td valign="top" >'.$company["zip_code"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Country:</td>
                            <td valign="top">'.$company["country"].'</td>
                        </tr>
                        <tr>
                            <td valign="top" style="text-align:right">Profile URL:</td>
                            <td valign="top"><a href="'.base_url("profile/index/".$members["id"]).'">'.$members["company_name"].'</a></td>
                        </tr>
                    </table>
                    <p style="text-align:center;"><a style="color:#37a7a7 ;width:100%;text-decoration: none;" href ="'.base_url("profile/sales_reps/".$members["id"]).'">Click to find a local rep</a></p>
                    <h4 style="border: 1px solid #ccc"></h4>
                    <p><strong>About: </strong></p>
                    <p>'.$company["company_about"].'<a href ="'.base_url("profile/index/".$members["id"]).'" style="color:#37a7a7;text-decoration: none;">...MORE</a></p>
                    <h4 style="border: 1px solid #ccc"></h4>
                    <p><strong>Service Area: </strong></p>
                    <p>'.$company["service_area"].'</p>
                </div>';
                if($photos["image_category"] == "Project"){
                    $html .='<div style="width:100%; float:left ;margin-top:30px;">
                        <div style="width:50%;float:left; text-align:center">
                            <a href="'.base_url("photos/".$photos ["photo_id"]."/" .gen_slug($photos ["name"])).'" style="text-align:center; font-size:18px;text-decoration: none;"><img src="'.skin_url("images/this-view-image.png").'"></a>
                        </div>
                        <div style="width:50%;float:left;text-align:center">
                            <a href="'.base_url("/profile/myphoto/".$members["id"]."?catalog=".$photos["manufacture"]."").'" style="text-align:center text-decoration: none;"><img src ="'.skin_url("images/this-view-catalog.png").'"></a>
                        </div>
                    </div>';
                }else{                
                    $html .='<div style="width:100%; float:left ;margin-top:30px;">
                        <div style="width:33.3%;float:left; text-align:center">
                            <a href="'.base_url("photos/".$photos ["photo_id"]."/" .gen_slug($photos ["name"])).'" style="text-align:center; font-size:18px;text-decoration: none;"><img src="'.skin_url("images/this-view-image.png").'"></a>
                        </div>
                        <div style="width:33.3%;float:left;text-align:center">
                            <a href="'.base_url("/profile/myphoto/".$members["id"]."?catalog=".$photos["manufacture"]."").'" style="text-align:center text-decoration: none;"><img src ="'.skin_url("images/this-view-catalog.png").'"></a>
                        </div>
                        <div style="width:33.3%;float:left;text-align:center">
                            <a href="'.base_url("profile/request_quote/".$photos["photo_id"]).'" style="text-align:center;text-decoration: none;"><img src ="'.skin_url("images/request-a-quote.png").'"></a>
                        </div>
                    </div>';
                }               
                $html .= '<div style="width:100%; float:left ;margin-top:30px; font-size:12px;">
                    <div style="width:20%; float:left ;text-align:left;">&copy; Dezignwall Inc.</div>
                    <div style="width:25%; float:left ;text-align:center;">2014 All Right Reserved</div>
                    <div style="width:25%; float:left ;text-align:center;">WWW.Dezignwall.com</div>
                    <div style="width:15%; float:left ;text-align:center;">&copy; Dezignwall</div>
                    <div style="width:15%; float:left;text-align:right">#Dezignwall</div>
                </div>
                ';
                $mpdf->WriteHTML($html);
                $mpdf->Output("photo.pdf","I");
                
                exit();    
            }
                 
        }
    }
    private function corner_radius ($id){
        $url_save = FCPATH."/uploads/company/rounded_logo_company.png";
        $images   = base_url("/photos/resize_photo_company/".$id."");
        $image    = new Imagick($images);
        $image->setImageFormat("png");
        $image->roundCorners(200,200);
        $image->writeImage($url_save);
        return base_url("/uploads/company/rounded_logo_company.png");
    }   
    public function resize_photo_company($id){
        $members  = $this->Common_model->get_record("members",array("id" => $id));
        $logo     = @$members["logo"];
        if(@$members["logo"] == null )
            $logo = "/skins/images/logo-company.png";
        $filename =  FCPATH . $logo;
        $info = getimagesize($filename);
        $mime = $info['mime'];
        switch ($mime) {
                case 'image/jpeg':
                    header('Content-Type: image/jpeg');
                    $image_create_func = 'imagecreatefromjpeg';
                    $image_save_func = 'imagejpeg';
                    $new_image_ext = 'jpg';
                    break;
                case 'image/png':
                    header('Content-Type: image/png');
                    $image_create_func = 'imagecreatefrompng';
                    $image_save_func = 'imagepng';
                    $new_image_ext = 'png';
                    break;
                case 'image/gif':
                    header('Content-Type: image/gif');
                    $image_create_func = 'imagecreatefromgif';
                    $image_save_func = 'imagegif';
                    $new_image_ext = 'gif';
                    break;
                default: 
                    throw new Exception('Unknown image type.');
        }
        // Get new sizes
        list($width, $height) = getimagesize($filename);
        $scell = 200/$width;
        $newwidth = 200;
        $newheight = $height * $scell;
        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = $image_create_func($filename);
        // Resize
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        // Output
        $image_save_func($thumb);
    }
    public function get_album(){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->input->is_ajax_request()){
            $photo_id = $this->input->post("photo_id");
            if(is_numeric($photo_id)){
                $photo = $this->Common_model->get_record("photos",array("photo_id" => $photo_id));
                if($photo != null){
                    $photo["album"] = json_decode($photo["album"],true);
                    $data = array("status" => "success","message" => null,"response" => $photo);
                }
            }
        }
        die(json_encode($data));
    }
    public function get_same(){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->input->is_ajax_request()){
            $photo_id = $this->input->post("photo_id");
            if(is_numeric($photo_id)){
                $photo = $this->Common_model->get_record("photos",array("photo_id" => $photo_id));
                if($photo != null){
                    $photo["same"] = json_decode($photo["same_photo"],true);
                    $data = array("status" => "success","message" => null,"response" => $photo);
                }
            }
        }
        die(json_encode($data));
    }
    public function auto_reset_status (){
        $today = date("Y-m-d");
        $photo_av = $this->Common_model->get_result("photo_bin",array("datime_remove <=" => $today));
        if($photo_av != null){
            $filtered = array_column($photo_av, 'photo_id');
            if($filtered != null){
                $this->db->set('status_photo',1, FALSE);
                $this->db->where_in('photo_id',$filtered);
                $this->db->update('photos'); 
            }
        }
        sendmail("phanquanghiep123@gmail.com","sdfsdfsdfsdf","sdfsfdsf");
    }   
    public function get_story(){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->input->is_ajax_request()){
            $photo_id = $this->input->post("id");
            $html     = "";
            if(is_numeric($photo_id)){
                $stories = $stories = $this->Common_model->get_result("stories",array("photo_id" => $photo_id),null,null,array(["field" => "sort","sort" => "ASC"]));
                if($stories != null){
                    $html  = '';
                    foreach ($stories as $key => $value) {
                        $html .= '<li data-type="'.$value["story_type"].'"><div class="box-story-slider">';
                        if ($value ["story_type"] == "0") {
                            $html .=  '
                                <div class="profile ">
                                    <div class="top-slider">
                                        <div class="media_url"><img src="'.base_url($value["media_url"]).'"></div>
                                    </div>
                                    <div class="bottom-slider">
                                        <h3><strong>'.$value["profile_name"].'</strong></h3>
                                        <p>'.$value["title"].'</p>
                                    </div>
                                </div>
                            ';
                        }elseif ($value ["story_type"] == "1") {
                            $html .=  '
                                <div class="editorinal">
                                    <div class="top-slider">
                                        <h3><strong>'.$value["title"].'</strong></h3>
                                    </div>
                                    <div class="bottom-slider">
                                        <div class="story_content">'.$value["story_content"].'</div>
                                    </div>
                                </div>
                            ';
                        }else{
                            $content = "";
                            if($value["type"] == "image/png" || $value["type"] == "image/jpeg" ||  $value["type"] == "image/jpg" || $value["type"] == "image/gif"){
                                $content = '<img src="'.base_url($value["media_url"]).'">';
                            }else{
                                $content = '<video width="100%" controls><source src="'.base_url($value["media_url"]).'" type="'.$value["type"].'"></video>';
                            }
                            $html .=  '
                                <div class="image-video">
                                    <div class="top-slider">
                                        <div class="media_url">'.$content.'</div>
                                    </div>
                                    <div class="bottom-slider">
                                        <h3><strong>'.$value["profile_name"].'</strong></h3>
                                        <p>'.$value["title"].'</p>
                                    </div>
                                </div>
                            ';
                        }
                        $html .= "</div></li>";
                    }
                    $data = array("status" => "success","message" => null,"response" => $html);
                }
            }
        }
        die(json_encode($data));
    }
    public function follow_company (){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->is_login && $this->input->is_ajax_request()){
            $photo_id = $this->input->post('photo_id');
            $photo = $this->Common_model->get_record("photos",array("photo_id" => $photo_id));
            if($photo != null){
                $member_id = $photo["member_id"];
                $company = $this->Common_model->get_record("company",array("member_id" => $member_id));
                $ch = $this->Common_model->get_record("common_follow",array("reference_id" => $photo_id ,"member_id" => $this->user_id,"type_object"   => "photo"));
                if($ch == null){
                    $data_insert = [
                        "member_id"     => $this->user_id,
                        "owner_id"      => $member_id,
                        "type_object"   => "photo",
                        "reference_id"  => $photo_id ,
                        "status"        => 1,
                        "allow"         => 0
                    ];
                    $this->Common_model->add("common_follow",$data_insert);
                    $data_insert = array(
                        "reference_id" => $photo_id,
                        "member_id"    => $photo["member_id"],
                        "member_owner" => $this->user_id,
                        "type"         => "photo",
                        "type_object"  => "follow",
                        "status"       => 0,
                        "allow"        => 0
                    );
                    $this->Common_model->add("notifications_common",$data_insert);                  
                    if($company != null){
                        $company_id = $company["id"];
                        $ch_data = $this->Common_model->get_record("common_follow",array("reference_id" => $company_id ,"member_id" => $this->user_id,"type_object"   => "company"));
                        if($ch_data ==  null){
                            $data_insert = [
                                "member_id"     => $this->user_id,
                                "owner_id"      => $member_id,
                                "type_object"   => "company",
                                "reference_id"  => $company_id ,
                                "status"        => 1,
                                "allow"         => 0
                            ];
                            $this->Common_model->add("common_follow",$data_insert);
                            $data_insert = array(
                                "reference_id" => $company_id,
                                "member_id"    => $photo["member_id"],
                                "member_owner" => $this->user_id,
                                "type"         => "company",
                                "type_object"  => "follow",
                                "status"       => 0,
                                "allow"        => 0
                            );
                            $this->Common_model->add("notifications_common",$data_insert);
                        }
                    } 
                    $data = array("status" => "success","message" => null,"response" => "add");
                }
                else{
                    $this->Common_model->delete("common_follow",array("id" => $ch["id"]));
                    $this->Common_model->delete("notifications_common",array("reference_id" => $photo_id,"member_id" => $photo["member_id"],"type" => "photo","type_object" => "follow"));
                    $check_data = $this->Common_model->get_record("common_follow",array("owner_id" =>  $photo["member_id"] ,"member_id" => $this->user_id,"type_object" => "photo"));
                    if($check_data == null){
                        $this->Common_model->delete("common_follow",array("owner_id" => $photo["member_id"],"member_id" => $this->user_id,"type_object" => "company"));
                        $this->Common_model->delete("notifications_common",array("reference_id" => $company["id"],"member_owner" => $this->user_id,"type" => "company","type_object" => "follow","status" => 0));
                    }
                    $data = array("status" => "success","message" => null,"response" => "delete");
                }              
            }
        }
        die(json_encode($data));
    }
    public function get_comment (){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->is_login && $this->input->is_ajax_request()){
            $id             = $this->input->post("id");
            $type           = $this->input->post("type");
            $this->load->model("Comment_model");
            $all            = $this->Comment_model->get_result($id ,$type,$this->user_id);
            $cotent_comment = $this->create_content_comment($all,0);
            $data           = array("status" => "success","message" => null,"response" => $cotent_comment);
            $sql = "SELECT (count(tbl1.id) - 1)  AS numberComment , tbl1.first_name,tbl1.last_name, tbl1.created_at 
            FROM  (SELECT mb.id, mb.first_name,mb.last_name, cm.created_at
            FROM `common_like` AS cm
            JOIN members AS mb ON mb.id = cm.member_id
            WHERE cm.`reference_id` = $id
            AND cm.`type_object` = '$type'
            GROUP BY mb.`id` ORDER BY cm.created_at DESC)  AS tbl1 ORDER BY tbl1.created_at DESC";
            $query = $this->db->query($sql);
            $dataComment = $query->row_array();
            if($dataComment["numberComment"] > -1 ){
                $dataComment["full_name"] = trim($dataComment["first_name"] . " " . $dataComment["last_name"]);
            }
            $data["dataComment"] = $dataComment;
            $data["post"]        = $this->input->post();
        }
        die(json_encode($data));
    }
    private $html_modules = "";
    private $index_look    = 0;
    private $for_look      = 0;
    private function create_content_comment ($result,$pid,$index_look =0){
        $current_avater = isset($this->user_info["avatar"]) && $this->user_info["avatar"]!= "" ? base_url(@$this->user_info["avatar"]) : skin_url("images/avatar-full.png");
        if ($result != null) { 
            $new_listdata = $termsList = null;
            foreach ($result AS $key => $item )
            {
                if ($item["pid"] == $pid)
                {
                    $termsList[] = $item;
                }
                else
                {
                    $new_listdata[] = $item;
                }
            }
            if ($termsList != null)
            {
                foreach ($termsList AS $key => $item_2 )
                {
 
                    
                   if($pid == 0){
                        $index_look ++;
                        $this->for_look = 0;
                        if($index_look == 1) $stOrder = $index_look."st";
                        if($index_look == 2) $stOrder = $index_look."nd";
                        if($index_look == 3) $stOrder = $index_look."rd";
                        if($index_look > 3 ) $stOrder = $index_look."th" ;
                    }else{
                        $this->for_look ++;
                        if($this->for_look == 1) $stOrder = $this->for_look."st";
                        if($this->for_look == 2) $stOrder = $this->for_look."nd";
                        if($this->for_look == 3) $stOrder = $this->for_look."rd";
                        if($this->for_look > 3 ) $stOrder = $this->for_look."th" ;
                    }
                    if($pid == 0){
                        $this->index_look ++;
                    }
                    $infor  = ($item_2["job_title"] != null) ? $item_2["job_title"] . " | " : "";
                    $infor  = @$infor . '<a href="'.base_url("company/view/".$item_2["member_id"]).'">'.@$item_2["company_name"]."</a>";
                    $avatar = isset($item_2["avatar"]) && $item_2["avatar"]!= "" ? base_url(@$item_2["avatar"]) : skin_url("images/avatar-full.png");
                    $comment = "";
                    if (strlen($item_2['comment']) <= 250) {
                        $comment = "<span>" . $item_2['comment'] . "</span>";
                    } else {
                        $comment = "<span class='comment-item-text default-show block'>" . trim(substr($item_2['comment'], 0, 250)) . "<span class='more btn btn-link' id='more-comment'>... MORE</span></span> 
                        <span class='comment-item-text default-hie'>" . $item_2['comment'] . "<span class='more btn btn-link' id='more-comment'>LESS</span></span>";
                    }
                    $none = "show";
                    if($this->index_look > 3 && $pid == 0){
                        $none = "none";
                    }else{
                      $none = "show";  
                    }
                    $class_member_like = "not-like";
                    $title_like = "Like comment";
                    if($item_2["allowlike"] != null){
                        $class_member_like = "allow-like";
                        $title_like = "Unlike comment";
                    }
                    $class_member_follow = "not-follow";
                    $title_follow = "Follow comment";
                    $title_follow_click = "Follow";
                    if(@$item_2["allowfollow"] != null){
                        $class_member_follow = "allow-follow";
                        $title_like = "Unfollow comment";
                        $title_follow_click = "Unfollow";
                    }
                    $this->html_modules .= '<div class="media remove-padding '.$none.'">
                        <div class="media-left">
                            <a href="'.base_url("profile/view/".$item_2["member_id"]).'"><img class="img-circle media-object" src="'.$avatar.'" width="40px"></a>
                        </div>';
                        $this->html_modules .='<div class="media-body">
                            <a href="'.base_url("profile/view/".$item_2["member_id"]).'" class="media-heading">'.$item_2["first_name"].' '.$item_2["last_name"].'  <span><i class="fa fa-circle icon-xs"></i> <span id="order_post">'.$stOrder.'</span></span></a>
                            <p>'.$infor.'</p>';
                            if($item_2["media"] != null && trim($item_2["media"]) != "")
                                $this->html_modules .= '<p><img src="'.base_url($item_2["media"]).'" alt="image"></p>';
                            $this->html_modules .= '<p class="text-comment">'.$comment.'</p>';
                            if($pid == 0){
                                $this->html_modules .= '<ul class="list-inline">
                                    <li><a href="#" class="Date_Time_Posted">'.date(DW_FORMAT_DATETIME, strtotime($item_2["created_at"])).'</a></li>
                                    <li><a data-id="'.$item_2["id"].'" id ="like-comment-now" class="'.$class_member_like.'" href="#" title="'.$title_like.'"><i class="fa fa-circle icon-xs"></i> '.$item_2["numlive"].' Like</a></li>
                                    <li><a href="#" class="btn-write-comment"><i class="fa fa-circle icon-xs"></i> Reply</a></li>
                                    <li><a data-id="'.$item_2["id"].'" id ="like-follow-now"  href="#" title="'.$title_follow.'" class="'.$class_member_follow.'"><i class="fa fa-circle icon-xs"></i> '.$title_follow_click.'</a></li>
                                </ul> 
                                <form class="form-comment" action="'.base_url("photos/postcomment").'" method="post" id="post_comment">
                                    <div class="media remove-padding">
                                        <div class="media-left">
                                            <a href=""><img class="img-circle media-object" src="'. $current_avater .'" width="40px"></a>
                                        </div>
                                        <div class="media-body">
                                            <div class="form-group">
                                                <textarea name="comment" class="form-control border-input-style" rows="3" placeholder="Write a reply"></textarea>
                                            </div>
                                            <div class="form-group text-right">
                                                <input type="hidden" name="id" value="'.$item_2["reference_id"].'">
                                                <input type="hidden" name="type" value="'.$item_2["type_object"].'">
                                                <input type="hidden" name="pid" value="'.$item_2["id"].'">
                                                <input class="btn btn-gray btn-write-comment" type="reset" name="" value="Cancel">
                                                <button class="btn btn-primary relative" type="submit" name="submit-comment">Post</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>';
                            }
                            if($new_listdata != null)
                                $this->create_content_comment($new_listdata,$item_2["id"],$index_look);
                        $this->html_modules .= '</div>';
                    $this->html_modules .= '</div>';

                }
            }
        }
        return $this->html_modules;
    }
    public function postcomment(){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->is_login && $this->input->is_ajax_request()){
            $id             = $this->input->post("id");
            $type           = $this->input->post("type");
            $record = null;
            if($type == "photo"){
                $record = $this->Common_model->get_record("photos",["photo_id" => $id]);
            }
            if($type == "social"){
                $record = $this->Common_model->get_record("social_posts",["id" => $id]);
            }
            if($type == "blog"){
                $record = $this->Common_model->get_record("article",["id" => $id]);
            }
            if($type == "product"){
                $record = $this->Common_model->get_record("products",["product_id" => $id]);
            }
            if($record != null && $this->input->post("comment") != null){
                $data_insert = array(
                    "memner_owner_id"   =>  $record["member_id"],
                    "member_id"         =>  $this->user_id,
                    "reference_id"      =>  @$id,
                    "comment"           =>  @$this->input->post("comment"),
                    "type_object"       =>  @$type,
                );
                if(isset($_FILES["media"])){
                    $path = FCPATH . "/uploads/member";
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }
                    $path = $path . "/" . $this->user_id."/";
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }
                    $folder = "/uploads/member/". $this->user_id."/";
                    $allowed_types = "gif|jpg|png";
                    $upload = upload_flie($path,$allowed_types,$_FILES["media"]) ;
                    if($upload["success"] == "success"){
                        $this->load->library('image_lib');
                        $file = $path.$upload["reponse"]["name"];
                        $size = getimagesize($file );
                        $w_current = $size[0];
                        $h_current = $size[1];
                        $config['source_image'] = $file;
                        $config['new_image'] = $path . "thumbs_".$upload["reponse"]["name"];
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 400;
                        $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                        $config['height'] = $size_ratio['height'];
                        $config['quality'] = 100;
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        $thumb = $folder."thumbs_".$upload["reponse"]["name"];
                        $data_insert["media"] = $thumb;              
                    }          
                }
                if(@$this->input->post("pid") != null){
                    $data_insert["pid"] = $this->input->post("pid");
                }         
                $id_data = $this->Common_model->add("common_comment",$data_insert);
                $commentcurrent = $this->Common_model->get_record("common_comment",["id" =>$id_data]);
                $tlrecord = $this->Common_model->get_record("common_tracking",["reference_id" => $id ,"type_object" => $type]);
                if($commentcurrent["pid"] == 0){
                    if($tlrecord == null){
                        $data_insert_tk = array(
                            "reference_id" => $id,
                            "qty_comment"  => 1,
                            "type_object"  => $type
                        );
                        $this->Common_model->add("common_tracking",$data_insert_tk);
                    }else{
                        $data_update_tk = array(
                            "qty_comment" => ($tlrecord["qty_comment"] + 1)
                        );
                        $this->Common_model->update("common_tracking",$data_update_tk,["reference_id" => $id ,"type_object" => $type]);
                    }
                }

                $company = $this->Common_model->get_record("company",["member_id" => $this->user_id]);
                $members = $this->Common_model->get_record("members",["id" => $this->user_id]);
                $infor  = ($members["job_title"] != null) ? $members["job_title"] . " | " : "";
                $infor  = @$infor . @$company["company_name"];
                $avatar = isset($members["avatar"]) && $members["avatar"]!= "" ? base_url(@$members["avatar"]) : skin_url("images/avatar-full.png");
                $comment = "";

                if (strlen($commentcurrent['comment']) <= 250) {
                    $comment = "<span>" . $commentcurrent['comment'] . "</span>";
                } else {
                    $comment = "<span class='comment-item-text default-show block'>" . trim(substr($data_insert['comment'], 0, 250)) . "<span class='more btn btn-link' id='more-comment'>... MORE</span></span> 
                    <span class='comment-item-text default-hie'>" . $commentcurrent['comment'] . "<span class='more btn btn-link' id='more-comment'>LESS</span></span>";
                }
                $reponse  = '<div class="media remove-padding">';
                $reponse .= '<div class="media-left">
                                <a href=""><img class="img-circle media-object" src="'.$avatar.'" width="40px"></a>
                            </div>';
                $reponse .= '<div class="media-body"> <a href="#" class="media-heading">'.$this->user_info["first_name"].' '.$this->user_info["last_name"].' <span><i class="fa fa-circle icon-xs"></i> <span id="order_post">1st</span></span></a>
                            <p>Decor Components, Inc</p>';
                            if($commentcurrent["media"] != null && $commentcurrent["media"] != "")
                                $reponse .= '<p><img src="'.base_url($commentcurrent["media"]).'" alt="image"></p>';
                            $reponse .= '<p class="text-comment"> '.$comment.'</p>';
                            if($commentcurrent["pid"] == 0){
                                $reponse .= '<ul class="list-inline">
                                    <li><p class="Date_Time_Posted">'.date(DW_FORMAT_DATETIME, strtotime($commentcurrent["created_at"])).'</p></li>
                                    <li><a class="not-like" id="like-comment-now" title="Like comment" data-id="'.$commentcurrent["id"].'" href="#"><i class="fa fa-circle icon-xs"></i> 0 Like</a></li>
                                    <li><a href="#" class="btn-write-comment" href="#"><i class="fa fa-circle icon-xs"></i> Reply</a></li>
                                    <li><a href="#" class="not-follow" id="like-follow-now" data-id="'.$commentcurrent["id"].'"><i class="fa fa-circle icon-xs"></i> Follow</a></li>
                                </ul>
                                <form class="form-comment" action="'.base_url ("photos/postcomment").'" method="post" id="post_comment">
                                    <div class="media remove-padding">
                                        <div class="media-left"> <a href=""><img class="img-circle media-object" src="'.$avatar.'" width="40px"></a> </div>
                                        <div class="media-body">
                                            <div class="form-group"> <textarea name="comment" class="form-control border-input-style" rows="3" placeholder="Write a reply"></textarea> </div>
                                            <div class="form-group text-right"> 
                                                <input type="hidden" name="id" value="'.$commentcurrent["reference_id"].'"> 
                                                <input type="hidden" name="type" value="'.$commentcurrent["type_object"].'"> 
                                                <input type="hidden" id="follow_comment" name="pid" value="'.$commentcurrent["id"].'"> 
                                                <input class="btn btn-gray btn-write-comment" type="reset" name="" value="Cancel">
                                                <button class="btn btn-primary relative" type="submit" name="submit-comment">Post</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>';
                            }
                $reponse .= '</div>';  
                $reponse .= '</div>';
                $tlrecord = $this->Common_model->get_record("common_tracking",["reference_id" => $id ,"type_object" => $type]);
                $this->Common_model->add("notifications_common",
                    array(
                        "reference_id" => $id,
                        "member_id"    => $record["member_id"],
                        "type"         => $type,
                        "type_object"  => "comment",
                        "status"       => 0,
                        "member_owner" => $this->user_id
                    ) 
                );
                $data = array("status" => "success","message" => null,"response" => $reponse,"tkrecord" => $tlrecord);  
            }   
            $data["post"] = $this->input->post();
        }
        die(json_encode($data));
    }
    private function ratio_image($original_width, $original_height, $new_width = 0, $new_heigh = 0) {
        $size['width'] = $new_width;
        $size['height'] = $new_heigh;
        if ($new_heigh != 0) {
            $size['width'] = intval(($original_wdith / $original_height) * $new_height);
        }

        if ($new_width != 0) {
            $size['height'] = intval(($original_height / $original_width) * $new_width);
        }

        return $size;
    }
    public function like_comment(){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->is_login && $this->input->is_ajax_request()){
            $id = $this->input->post("id");
            $record = $this->Common_model->get_record("common_comment",["id" => $id]);
            if($record != null){
                $rclike = $this->Common_model->get_record("common_like",["reference_id" => $record["id"],"type_object" => "comment","member_id" => $this->user_id]);
                $status = 0;
                if($rclike == null){
                    $data_insert = array(
                        "member_id" => $this->user_id,
                        "reference_id" =>$record["id"],
                        "status"       => 1,
                        "type_object"  => "comment",
                        "owner"        => $record["memner_owner_id"]
                    );
                    $this->Common_model->add("common_like",$data_insert);
                    $status = 1;
                }else{
                    $status = !$rclike["status"];
                    $update = array(
                        "status"   => $status    
                    );
                    $this->Common_model->update("common_like",$update,["id" => $rclike["id"]]);
                    
                }
                $numlive = $record["numlive"];
                if($status == 1){
                    $numlive = $record["numlive"] + 1; 
                }else{
                    $numlive = $record["numlive"] - 1; 
                }
                
                $data_update = array(
                    "numlive" => $numlive
                );
                $check_record = $this->Common_model->get_record("notifications_common",["reference_id" => $id,"type_object" => "comment","type" => "like" ,"member_owner" => $this->user_id]);
                if($check_record == null){
                    $this->Common_model->add("notifications_common",
                        array(
                            "reference_id" => $record["id"],
                            "member_id"    => $record["memner_owner_id"],
                            "type"         => "comment",
                            "type_object"  => "like",
                            "status"       => 0,
                            "member_owner" => $this->user_id
                        ) 
                    );
                }else{
                    $this->Common_model->delete("notifications_common",["id" => $check_record["id"]]);
                }
                
                $this->Common_model->update("common_comment",$data_update,["id" => $record["id"]]);
                $data = array("status" => "success","message" => null,"response" => ["numlive" => $numlive ,"status" => $status]);
                
            }
        }
        die(json_encode($data));
    }
    public function follow_comment(){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->is_login && $this->input->is_ajax_request()){
            $id = $this->input->post("id");
            $record = $this->Common_model->get_record("common_comment",["id" => $id]);
            if($record != null){
                $rclike = $this->Common_model->get_record("common_follow",["reference_id" => $record["id"],"type_object" => "comment","member_id" => $this->user_id]);
                $status = 0;
                if($rclike == null){
                    $data_insert = array(
                        "member_id"    => $this->user_id,
                        "reference_id" => $record["id"],
                        "status"       => 1, 
                        "type_object"  => "comment",
                        "owner_id"     => $record["memner_owner_id"]
                    ); 
                    $this->Common_model->add("common_follow",$data_insert);
                    $status = 1;
                }else{
                    $status = !$rclike["status"];
                    $update = array(
                        "status"   => $status    
                    );
                    $this->Common_model->update("common_follow",$update,["id" => $rclike["id"]]);
                    
                }
                $numfollow = $record["numfollow"];
                if($status == 1){
                    $numfollow = $record["numfollow"] + 1; 
                }else{
                    $numfollow = $record["numfollow"] - 1; 
                }
                
                $data_update = array(
                    "numfollow" => $numfollow
                );
                $this->Common_model->update("common_comment",$data_update,["id" => $record["id"]]);

                $check_record = $this->Common_model->get_record("notifications_common",["reference_id" => $record["id"],"type_object" => "comment","type" => "follow" ,"member_owner" => $this->user_id]);
                if($check_record == null){
                    $this->Common_model->add("notifications_common",
                        array(
                            "reference_id" => $record["id"],
                            "member_id"    => $record["member_id"],
                            "type"         => "comment",
                            "type_object"  => "follow",
                            "status"       => 0,
                            "member_owner" => $this->user_id
                        ) 
                    );
                }else{
                    $this->Common_model->delete("notifications_common",["id" => $check_record["id"]]);
                }
                $data = array("status" => "success","message" => null,"response" => ["numfollow" => $numfollow ,"status" => $status]);
                
            }
        }
        die(json_encode($data));
    }
    public function view_notifications(){
        $this->Common_model->update("notifications_common",["status" => 1],["member_id" => $this->user_id]);
    }
    public function more_nofication(){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->is_login && $this->input->is_ajax_request()){
            $type            = $this->input->post("type");
            $object          = $this->input->post("object");
            $number_items    = $this->input->post("number_items");
            $offset          = $number_items - 1;
            $html_data = "";
            if($object == "follow"){
                $get_next = get_follow_by_user($this->user_id,$object,$type,$offset);
                $check_item_next = get_follow_by_user($this->user_id,$object,$type,($offset + 6) , 1);
                $html_data = "";
                if($get_next != null){
                    foreach ($get_next as $key => $value) {
                        if($value["typeSuccess"] == "company")
                            $avatar = (isset($value["avatar"]) && $value["avatar"]!= "") ? base_url(@$value["avatar"]) : skin_url("images/avatar-full.png");
                        if($value["typeSuccess"] == "photo")
                            $avatar = (isset($value["thumb"]) && $value["thumb"]!= "") ? base_url(@$value["thumb"]) : base_url(@$value["path_file"]);
                        $job_title = $value["job_title"];
                        if($value["company_name"] != null)
                        $job_title .= $job_title != "" ? " | ". $value["company_name"] : $value["company_name"];
                        $created_at = date(DW_FORMAT_DATETIME, strtotime($value["created_at"]));
                        $allow = $allow_2 = "disabled";
                        if($value["allow"] != 2){
                            $allow = "";
                        }
                        if($value["allow"] != 1){
                            $allow_2 = "";
                        }
                        $html_data .= '<div class="media">
                                <div class="media-left"> <img class="'.$value["typeSuccess"].' img-circle notification-avatar"  src="'.$avatar.'" > </div>
                                <div class="media-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h5 class="media-heading remove-margin"><a href="'.base_url("profile/view/".$value["member_owner"]).'">'.$value["first_name"].' '.$value["last_name"] .'"</a> <span><i class="fa fa-circle icon-xs"></i> 2nd</span></h5>
                                            <h5 class="title">'.$job_title.'</h5>
                                        </div>
                                        <div class="col-sm-6">
                                            <ul class="list-inline button-dw-event">
                                                <li><button id="delete-follow" data-id ="'.$value["id"].'" class="btn btn-default ignore" '.$allow.'>Delete</button></li>
                                                <li><a href="'.base_url("profile/view/".$value["member_owner"]).'" class="btn btn-default maybe">Profile</a></li>
                                                <li><button id="confirm-follow" data-id ="'.$value["id"].'" class="btn btn-default going" '.$allow_2.'>Confirm</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>  ';
                    } 
                    $data = array("status" => "success","message" => null,"response" => $html_data); 
                    if($check_item_next != null){
                        $data["next"] = true;
                    }else{
                        $data["next"] = false;
                    }  
                }
            }else{
                $get_next = get_notifications_by_user($this->user_id,$object,$type,$offset);
                $check_item_next = get_notifications_by_user($this->user_id,$object,$type,($offset + 7) , 1);
                $html_data = "";
                if($get_next != null){
                    foreach ($get_next as $key => $value) {
                        $number_data = @$value["number_data"];
                        $tow_member = [];
                        $avatar     = "";
                        $created_at = "";
                        $job_title  = "";
                        $reference_id = $value["reference_id"];
                        $type         =  $value["type"];
                        $count_like   = "";
                        $list_record  = get_notifications_by_type($this->user_id,$value["reference_id"],$object,$type );
                        if($list_record != null){
                            foreach ($list_record as $key => $value_1) {
                                if($key  == 0) {
                                    $created_at = date(DW_FORMAT_DATETIME, strtotime($value_1["created_at"]));
                                    if($value_1["typeSuccess"] == "company")
                                        $avatar = (isset($value_1["avatar"]) && $value_1["avatar"]!= "") ? base_url(@$value_1["avatar"]) : skin_url("images/avatar-full.png");
                                    if($value_1["typeSuccess"] == "photo" || $value_1["typeSuccess"] == "product"){
                                        $value["name"] = $value_1["name"];
                                        $avatar = (isset($value_1["thumb"]) && $value_1["thumb"]!= "") ? base_url(@$value_1["thumb"]) : base_url(@$value_1["path_file"]);
                                    }   
                                    if($value_1["typeSuccess"] == "social")
                                        $avatar = (isset($value_1["thumb"]) && $value_1["thumb"]!= "") ? base_url(@$value_1["thumb"]) : base_url(@$value_1["path"]);
                                    if($number_data > 2){
                                        $count_like = "and ".($number_data - 2)." other ";
                                    }
                                    $value["typeSuccess"] = $value_1["typeSuccess"];
                                }
                                $tow_member [] =  '<a href="'.base_url("profile/view/".$value_1["member_owner"]."").'">'.$value_1["first_name"]." " .$value_1["last_name"] ."</a>";
                            }
                            $url = "";
                            if($value["type"] == "social"){
                                $url = base_url("socialposts/".$value["reference_id"]);
                            }
                            if($value["type"] == "photo" || $value["type"] == "product"){
                                if($value["type"] == "product"){
                                    $url = base_url("designwalls/view_photos/".$value["reference_id"]."").'/'.gen_slug($value["name"]);
                                }else{
                                    $url = base_url("photos/".$value["reference_id"]."").'/'.gen_slug($value["name"]);
                                }     
                            }
                            $html_data .= '
                            <div class="media">
                                <div class="media-left"> <a href="'.$url.'"><img src="'.$avatar.'" class="'.$value["typeSuccess"].' img-circle notification-avatar"></a> </div>
                                <div class="media-body">
                                    <h5 class="media-heading remove-margin">'.implode(", ", $tow_member).'</h5>
                                    <h5 class="remove-margin">'.$count_like.'people '.$value["type_object"].' <a href="'.$url.'">your '.$value["type"].'</a></h5> <span class="remove-margin color-blue">'.$created_at.'</span> 
                                </div>
                            </div>';
                        }
                        
                    }
                    $data = array("status" => "success","message" => null,"response" => $html_data); 
                    if($check_item_next != null){
                        $data["next"] = true;
                    }else{
                        $data["next"] = false;
                    }  
                }
            }
        }
        $data["post"] = $this->input->post();
        die(json_encode($data));   
    }
    public function confirm_follow(){ 
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->is_login && $this->input->is_ajax_request()){
            $id = $this->input->post("id");
            $check = $this->Common_model->get_record("notifications_common",["member_id" => $this->user_id,"type" => "company","type_object" => "follow","allow" => 0]);
            if($check != null){
                $this->Common_model->update("notifications_common",["allow" => 1],["id" => $check["id"]]);
                $this->Common_model->update("common_follow",["allow" => 1],["owner_id" => $this->user_id,"member_id" => $check["member_owner"],"type_object" => "company","allow" => 0]);
                $data = array("status" => "success","message" => null,"response" => null); 
            }
        }
        die(json_encode($data));
    }
    public function delete_follow(){
        $data = array("status" => "error","message" => null,"response" => null);
        if($this->is_login && $this->input->is_ajax_request()){
            $id = $this->input->post("id");
            $check = $this->Common_model->get_record("notifications_common",["member_id" => $this->user_id,"type" => "company","type_object" => "follow"]);
            if($check != null){
                $this->Common_model->delete("notifications_common",["id" => $check["id"]]);
                $this->Common_model->delete("common_follow",["owner_id" => $this->user_id,"member_id" => $check["member_owner"],"type_object" => "company"]);
                $data = array("status" => "success","message" => null,"response" => null);
            }
        }
        die(json_encode($data));
    }
    public function info (){
        $data = array("status" => "error","message" => null,"response" => null,'post' => $this->input->post());
        if($this->input->is_ajax_request()){
            $id = $this->input->post("id");
            $type_post = $this->input->post("type_post");
            $r = null;
            if ($type_post == "social") {
                $r = $this->Common_model->get_record("social_posts",["id" => $id]);
                if($r != null){
                    $c = $this->Common_model->get_record("company",["member_id" => $r["member_id"]]);
                    $r["url"] = base_url("/socialposts/$id");
                    $r["content"] = $c["company_name"].' just shared social post on @Dezignwall TAKE A LOOK';                  
                } 
            } else if($type_post == "photo"){
                $r = $this->Common_model->get_record("photos",["photo_id" => $id]);
                if($r != null){
                    $c = $this->Common_model->get_record("company",["member_id" => $r["member_id"]]);
                    $r["url"] = base_url("photos/" . $r['photo_id'] . "/" . gen_slug($r["name"]));
                    $r["content"] = $c["company_name"].' just shared '. $r["name"] . ' on @Dezignwall TAKE A LOOK';
                } 
            }      
            $data["status"] =  "success";
            $data["response"] = $r;        
        }
        die(json_encode($data));
    }
}
