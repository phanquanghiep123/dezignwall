<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends MY_Controller {
    private $user_id = null;
    private $is_login = false;
    private $data = null;
    private $is_sale_rep = false;
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->data["view_profile"] = false;
        }
        if ($this->session->userdata('user_sr_info')) {
            $this->is_sale_rep = true;
        }
    }

    public function index($id = null) {
        $user_id = ($id == null) ? $this->user_id : $id;
        $this->data['member_id'] = $user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
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
        if ($id !== null) {
            $use_add = 0;
            if($this->user_id != null){
                $use_add = $this->user_id;
            }
            $datime = date('Y-m-d H:i:s');
            $ip = $this->input->ip_address();
            $datainsert = array(
                "reference_id" => $id,
                "member_owner" => $id,
                "member_id" => $use_add,
                "ip" => $ip,
                "type_object" => "profile",
                "created_at" => $datime,
                "createdat_profile" => $datime,
            );
            $this->Common_model->add("common_view", $datainsert);
        }
        $this->data['member'] = $record;
        $company_info = $this->Common_model->get_record("company", array(
            'member_id' => $user_id
        ));
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

    public function request_quote($photo_id = null, $tag_id = null) {
        if (!$this->is_login) {
            redirect('/');
        }
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Request Quote Form";
        $this->data['user_id'] = $user_id;
        if (!(isset($record) && $record != null)) {
            redirect('/');
        }

        if (!isset($photo_id) && is_numeric($photo_id) ) {
            redirect('/');
        }
        $record_photo = $this->Common_model->get_record('photos', array(
            'photo_id' => $photo_id
        ));
        if (!(isset($record_photo) && count($record_photo) > 0 )) {
            redirect('/');
        }
        $record_tag = $this->Common_model->get_record('images_point', array(
            'photo_id' => $photo_id
        ));
        $this->data['photo'] = $record_photo;
        $this->data['tag'] = $record_tag;
        $this->load->view('block/header', $this->data);
        $this->load->view('profile/request', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function send_request_quote() {
        $data = array('status' => 'error');
        if ($this->input->is_ajax_request()) {
            $photo_id = $this->input->post('photo_id');
            $tag_id = $this->input->post('tag_id');
            if (!(isset($photo_id) && $photo_id != null && is_numeric($photo_id) &&
                    isset($tag_id) && $tag_id != null && is_numeric($tag_id))) {
                die(json_encode($data));
            }

            //check photo
            $record_photo = $this->Common_model->get_record('photos', array(
                'photo_id' => $photo_id
            ));
            if (!(isset($record_photo) && count($record_photo) > 0)) {
                die(json_encode($data));
            }

            //check tag
            $record_tag = $this->Common_model->get_record('images_point', array(
                'photo_id' => $photo_id,
                'id' => $tag_id
            ));
            if (!(isset($record_tag) && count($record_tag) > 0 )) {
                die(json_encode($data));
            }

            //check member
            $member_upload_photo = $this->Common_model->get_record('members', array(
                'id' => $record_photo['member_id']
            ));
            if (!(isset($member_upload_photo) && count($member_upload_photo) > 0)) {
                die(json_encode($data));
            }

            $first_name = strstr($this->user_info["full_name"], ' ', true);

            $arr['country_installed'] = $this->input->post('country_installed');
            $arr['quote_process'] = $this->input->post('quote_process');
            $arr['sample_quantity'] = $this->input->post('sample_quantity');
            $arr['product_quantity'] = $this->input->post('product_quantity');
            $arr['sample_date'] = $this->input->post('sample_date');
            $arr['product_date'] = $this->input->post('product_date');
            $arr['location_check'] = $this->input->post('location_check');
            $arr['height'] = $this->input->post('height');
            $arr['width'] = $this->input->post('width');
            $arr['projection'] = $this->input->post('projection');
            $arr['depth'] = $this->input->post('depth');
            $arr['sqft'] = $this->input->post('sqft');
            $arr['diameter'] = $this->input->post('diameter');
            $arr['email'] = $this->input->post('email');
            $arr['phone'] = $this->input->post('phone');
            $arr['from'] = $this->input->post('from');
            $arr['to'] = $this->input->post('to');
            $arr['reach_check'] = $this->input->post('reach_check');
            $arr['time_check'] = $this->input->post('time_check');
            $arr['country'] = $this->input->post('country');
            $arr['comments'] = $this->input->post('comments');

            $email_to = $member_upload_photo['email'];
            $mail_subject = 'Request for Quote | ' . $record_photo['name'] . ' - ' . date('m/d/Y');
            $mail_content = '
            <p>' . $this->user_info["full_name"] . ' of ' . $this->user_info["company_name"] . '  would like more information regarding the following [Product or Project]:</p>
            <img src="' . base_url($record_photo['path_file']) . '" width="200px" />
            <p>The installation location will be in: ' . $arr['country_installed'] . '<br>
            Sample Qty Requested: ' . $arr['sample_quantity'] . '<br>
            Sample Delivery Date: ' . $arr['sample_date'] . '<br>
            Anticipated Production Qty : ' . $arr['product_quantity'] . '<br>
            Productuction Delivery Date: ' . $arr['product_date'] . '</p>
            <p>This will be for ' . $arr['location_check'] . '.</p>
            <p>' . @$this->user_info["full_name"] . ' requests the following dimensions for this quote:<br>
            Height: ' . $arr['height'] . '<br>
            Width: ' . $arr['width'] . '<br>
            Projection: ' . $arr['projection'] . '<br>
            Depth: ' . $arr['depth'] . '<br>
            Sqft: ' . $arr['sqft'] . '<br>
            Diameter: ' . $arr['diameter'] . '</p>
            <p>' . $first_name . ' also provided the following comments:</p>
            <p>' . $arr['comments'] . '</p>
            <p>' . $first_name . ' is best reached at:</p>
            <p>Phone: <a href="tel:' . $arr['phone'] . '" style="color:#37a7a7;text-decoration:none;">' . $arr['phone'] . '</a><br>
            This is their ' . $arr['reach_check'] . ' number<br>
            Email: <a href="mailto:' . $arr['email'] . '" style="color:#37a7a7;text-decoration:none;">' . $arr['email'] . '</a><br>
            Between ' . $arr['from'] . ' to ' . $arr['to'] . ' in the ' . $arr['time_check'] . '<br>
            ' . $first_name . ' is in: ' . $arr['country'] . '</p>
            <p><a href="tel:' . $arr['phone'] . '"><img src="' . skin_url() . '/images/btn-email-call.png" alt="Call Now"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="mailto:' . $arr['email'] . '"><img src="' . skin_url() . '/images/btn-email-reply.png" alt="Reply Now"></a></p>
            <p style="font-weight:bold;font-style:italic;">The entire Dezignwall team sincerely wishes you the best of luck with this new client
            and the work that this may bring your business!</p>
            <p style="margin:0">&nbsp;</p>

            <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
            <p>The bold new way to find and share commercial design inspiration.</p>
            <p style="margin:0">&nbsp;</p>
            <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>
            ';

            $other = '';
            $copy = $this->input->post('save_multiple');
            if (isset($copy) && $copy == 'save') {
                $other = $arr['email'];
            }
            sendmail($email_to, $mail_subject, $mail_content, $other);

            $this->Common_model->add('request_quote', array(
                'photo_id' => $photo_id,
                'point_id' => $tag_id,
                'data' => json_encode($arr),
                'created_at' => date('Y-m-d H:i:s')
            ));
            $data['status'] = 'success';
            //$data['user']=@$this->user_info;
        }
        die(json_encode($data));
    }

    public function myphoto($user_id = null ) {
        if($this->is_login || $this->session->userdata('user_sr_info')){
            $in_ = "this Catalog";
            $url = ($user_id == null) ? base_url('profile/myphoto') : base_url('profile/myphoto/'.$user_id.'/');
            $current_url = $url;
            $categories_id = null;
            $keyword = null;
            $catalog = null;
            if($this->input->get("product") && $this->input->get("product") != ""){
                $record_cat_get  = $this->Common_model->get_record("categories",array("id"=> $this->input->get("product")));
                if( !empty( $record_cat_get ) ){
                    $url = $url."?product=".$this->input->get("product");
                    $categories_id = [$this->input->get("product")] ;
                    $in_ = $record_cat_get["title"];
                }
            }
            if($this->input->get("keyword_photo") && $this->input->get("keyword_photo") != ""){
                $url = $url."?keyword_photo=".$this->input->get("keyword_photo");
                $in_ = $this->input->get("keyword_photo");
                $keyword = $this->input->get("keyword_photo");
            }
            if(@$this->input->get("catalog") != ""){
                $url = $url."?catalog=".$this->input->get("catalog");
                $catalog_name = $this->Common_model->get_record("manufacturers",["id" => $this->input->get("catalog")]);
                if($catalog_name != null){
                    $in_ = "this Catalog ". @$catalog_name["name"];
                }
                $catalog = $this->input->get("catalog");
            }
            $segment = 4;
            $owner = false;
            if ($user_id == null || $user_id == $this->user_id) {
                $user_id = $this->user_id;
                $segment = 3;
                if ($this->session->userdata('user_info') || $this->session->userdata('user_sr_info')) {
                    $owner = true;
                }
            }
            $this->data["view_profile"] = true;
            $record = $this->Common_model->get_record("members", array('id' => $user_id));
            if ($record == null) {
                redirect(base_url());
            }
            $this->data["is_login"] = $this->is_login;
            $this->data['member_id'] = $user_id;
            $this->data["title_page"] = "My Photo";
            $this->data["in_"] = $in_;
            $this->data['member'] = $record;
            $this->data["company_info"] = $this->Common_model->get_record("company", array(
                'member_id' => $user_id
            ));
            $this->load->model('Photo_model');
            $this->load->model('Comment_model');
            $per_page = 30;
            $total_rows =  $this->Photo_model->total_photo($user_id,$keyword,$categories_id,$catalog);
            $this->data["random_project"] = $this->Photo_model->random_photo_project($user_id);
            $this->data["current_url"] = $current_url;
            $this->data["all_photo"] = $total_rows;
            $this->load->library('pagination');
            $config['base_url'] = $url;
            $config['uri_segment'] = 3;
            $config['num_links'] = 3;
            $config['total_rows'] = $total_rows;
            $config['per_page'] = $per_page; 
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
            $config['first_link'] = false;
            $config['last_link'] = false;
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['enable_query_strings']  = true;
            $config['page_query_string']  = true;
            $config['query_string_segment'] = "page";
            $config['use_page_numbers'] = TRUE;        
            $this->pagination->initialize($config); 
            $page = 0;
            if($this->input->get("page") && is_numeric($this->input->get("page")) && $this->input->get("page") > 1){
                $page = $this->input->get("page");
                $page = $page - 1;
            }
            $offset = $page * $per_page;
            $result_photo = $this->Photo_model->seach_photo(NULL, $user_id, $keyword, $categories_id,NUll, $offset, $per_page, $catalog,$user_id,true);
            $get_cat = $this->Common_model->get_result("categories");
            $this->load->model("Category_model");
            $cat_parent = $this->get_children_cat("9", $get_cat);
            $all_photo_product =  $result_photo;
            foreach ($all_photo_product as $key => $value) {
                $all_id_photo[] = $value["photo_id"];
            }
            if(!empty($all_id_photo) && !empty($cat_parent)){
                $this->data["all_product"] = $this->Category_model->get_cat_by_photo($all_id_photo,$cat_parent);
            }   
            $data_share = '<meta name="og:image" content="' . base_url($record['banner']) . '">
            <meta property="og:title" content="' .  $this->data["company_info"]["company_name"] . '" />
            <meta id ="titleshare" property="og:title" content="'. $this->data["company_info"]["company_name"].' just shared on @Dezignwall TAKE A LOOK" />
            <meta property="og:description" content="' .  $this->data["company_info"]["business_description"] . '" />
            <meta property="og:url" content="' . base_url("profile/index/" .  $this->data["company_info"]["member_id"]) . '" />
            <meta property="og:image" content="' . base_url($record['banner']) . '" />';
            $this->data["data_share"] = $data_share;
            $this->data['results'] = $result_photo;
            $this->data['owner'] = $owner;
            $this->load->view('block/header', $this->data);
            $this->load->view('profile/photos', $this->data);
            $this->load->view('block/footer', $this->data);

        }else{ 
            $CI =& get_instance();
            $url = $CI->config->site_url($CI->uri->uri_string());
            $current_url =   $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
            $current_url = str_replace("&","[]", $current_url);
            redirect(base_url("?action=signin&url=".$current_url));
        }
        
    }
    public function import_photo_by_csv(){
        if($this->is_login == true){
            if( $this->input->post() ){
                if(isset($_FILES["file-csv"])){
                    $path = FCPATH . "/uploads/csv";
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }
                    $path = $path . "/" . $this->user_id;
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }
                    $config['upload_path']   = $path;
                    $config['allowed_types'] = 'csv|xls|xlsx';
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload('file-csv')){
                        $error = array('error' => $this->upload->display_errors());
                        $this->load->view('import_photo_by_csv', $error);
                    }
                    else{
                        $data = $this->upload->data();
                        $csv = array_map('str_getcsv', file($path."/".$data["file_name"]));
                        if($csv != null){
                            foreach ($csv as $key => $value) {                             
                                if($value != null && $value[0] !=null){
                                    if($key > 0){
                                        $arg_insert = [
                                            "path_file" => $value[0],
                                            "name" =>  $value[1],
                                            "description" => $value[2],
                                            "photo_credit" => $value[3],
                                            "image_category" => $value[4],
                                            "offer_product" => $value[5],
                                            "unit_price" => $value[6],
                                            "maximum_price" => $value[7],
                                            "sample_pricing" => $value[8],
                                            "created_at" =>  date('Y-m-d H:i:s'),
                                            "priority_display" => "high",
                                            "type" => "2",
                                            "member_id" => $this->user_id
                                        ];
                                        $id = $this->Common_model->add("photos",$arg_insert);
                                        if($id){
                                            $arg_image_for_id = "346";
                                            $arg_image_for = [
                                                "Indoor" => "1",
                                                "Outdoor" =>"2",
                                                "Both" => "0"
                                            ];
                                            $arg_service = ["Locally" => "260","Nationally"=>"259","Internationally" => "262"];
                                            $style_id = "3";
                                            $category_id = "9";
                                            $location_id ="215";
                                            $service_id = "258";
                                            $certifications_id = "263";
                                            $image_for = @$value[9];
                                            $location_set_cat = @$arg_image_for[$image_for];
                                            $style = @$value[10];
                                            $category = @$value[11];
                                            $location = @$value[12];
                                            $service = @$value[14];
                                            $certifications = @$value[15];
                                            $arg_insert_bac = [];
                                            if(@$category != ""){
                                                $category = array_diff(explode(",", $category),array(""));
                                                if($category != null && is_array($category)){
                                                    foreach ($category as $key_cat => $value_cat ) {
                                                        $check_cat = $this->Common_model->get_record("categories",["parents_id" => $category_id,"title" => $value_cat]);
                                                        if($check_cat == null){
                                                            $id_insert =  $this->Common_model->add("categories",
                                                                [
                                                                    "pid" => $category_id ,
                                                                    "parents_id" => $category_id ,
                                                                    "title" => $value_cat,
                                                                    "slug"  => $this->gen_slug($value_cat)
                                                                ]
                                                            );
                                                        }else{
                                                            $id_insert = $check_cat["id"];
                                                        }

                                                        $arg_insert_bac [] = [
                                                            "category_id" => $id_insert,
                                                            "photo_id" => $id,
                                                            "first_child_category" => $category_id,
                                                            "location" => $location_set_cat
                                                        ];
                                                    }
                                                }
                                            }
                                            if(@$style != ""){
                                                $style = array_diff(explode(",", $style),array(""));
                                                if($style != null && is_array($style) ){
                                                    foreach ($style as $key_cat => $value_cat) {
                                                        $check_cat = $this->Common_model->get_record("categories",["parents_id" => $style_id,"title" => $value_cat]);
                                                        if($check_cat == null){
                                                            $id_insert =  $this->Common_model->add("categories",
                                                                [
                                                                    "pid" => $style_id ,
                                                                    "parents_id" => $style_id ,
                                                                    "title" => $value_cat,
                                                                    "slug"  => $this->gen_slug($value_cat)
                                                                ]
                                                            );
                                                        }else{
                                                            $id_insert = $check_cat["id"];
                                                        }     
                                                        $arg_insert_bac [] = [
                                                            "category_id" => $id_insert,
                                                            "photo_id" => $id,
                                                            "first_child_category" => $style_id,
                                                            "location" => $location_set_cat
                                                        ];
                                                    }
                                                }
                                            }
                                            if(@$location != ""){
                                                $location = array_diff(explode(",", $location),array(""));
                                                if($location != null && is_array($location) ){
                                                    foreach ($location as $key_cat => $value_cat) {
                                                        $check_cat = $this->Common_model->get_record("categories",["parents_id" => $location_id,"title" => $value_cat]);
                                                        if($check_cat == null){
                                                            $id_insert =  $this->Common_model->add("categories",
                                                                [
                                                                    "pid" => $location_id ,
                                                                    "parents_id" => $location_id ,
                                                                    "title" => $value_cat,
                                                                    "slug"  => $this->gen_slug($value_cat)
                                                                ]
                                                            );
                                                        }else{
                                                            $id_insert = $check_cat["id"];
                                                        }
                                                        $arg_insert_bac [] = [
                                                            "category_id" => $id_insert,
                                                            "photo_id" => $id,
                                                            "first_child_category" => $location_id,
                                                            "location" => $location_set_cat
                                                        ];
                                                    }
                                                }
                                            }
                                            if(@$service != ""){
                                                $id_insert = $arg_service[$service];
                                                $arg_insert_bac [] = [
                                                    "category_id" => $id_insert,
                                                    "photo_id" => $id,
                                                    "first_child_category" => $service_id,
                                                    "location" => $location_set_cat
                                                ];
                                            }
                                            if(@$certifications != ""){
                                                $certifications = array_diff(explode(",", $certifications),array(""));
                                                if($certifications != null && is_array($certifications) ){
                                                    foreach ($certifications as $key_cat => $value_cat) {
                                                        $check_cat = $this->Common_model->get_record("categories",["parents_id" => $certifications_id,"title" => $value_cat]);
                                                        if($check_cat == null){
                                                            $id_insert =  $this->Common_model->add("categories",
                                                                [
                                                                    "pid" => $certifications_id ,
                                                                    "parents_id" => $certifications_id ,
                                                                    "title" => $value_cat,
                                                                    "slug"  => $this->gen_slug($value_cat)
                                                                ]
                                                            );
                                                        }else{
                                                            $id_insert = $check_cat["id"];
                                                        }
                                                        $arg_insert_bac [] = [
                                                            "category_id" => $id_insert,
                                                            "photo_id" => $id,
                                                            "first_child_category" => $certifications_id,
                                                            "location" => $location_set_cat
                                                        ];
                                                    }
                                                }
                                            }
                                            if($location_set_cat != null){
                                                if($location_set_cat == "0"){
                                                    $arg_insert_bac [] = [
                                                        "category_id" => 1,
                                                        "photo_id" => $id,
                                                        "first_child_category" => "346",
                                                        "location" => $location_set_cat
                                                    ];
                                                    $arg_insert_bac [] = [
                                                        "category_id" => 2,
                                                        "photo_id" => $id,
                                                        "first_child_category" => "346",
                                                        "location" => $location_set_cat
                                                    ];
                                                }else{
                                                    $arg_insert_bac [] = [
                                                        "category_id" => $location_set_cat,
                                                        "photo_id" => $id,
                                                        "first_child_category" => "346",
                                                        "location" => $location_set_cat
                                                    ];
                                                }   
                                            } 
                                            $this->Common_model->insert_batch_data("photo_category",$arg_insert_bac);
                                            $kw = @$value[13];
                                            if(@$kw != ""){
                                                $kw = array_diff(explode(",", $kw),array(""));
                                                if($kw && $kw != null && is_array($kw)){
                                                    $kw_bac = [];
                                                    foreach ($kw as $key => $value) {
                                                        $check_kw = $this->Common_model->get_record("keywords",["title" => $value,"type" => "photo"]);
                                                        if( $check_kw == null){
                                                            $id_kw = $this->Common_model->add("keywords",["title" => $value,"type" => "photo"]);
                                                        }else{
                                                            $id_kw = $check_kw["keyword_id"];
                                                        }
                                                        $kw_bac[] = [
                                                            "keyword_id" => $id_kw,
                                                            "photo_id" => $id
                                                        ];
                                                    }
                                                    $this->Common_model->insert_batch_data("photo_keyword",$kw_bac);
                                                }
                                            }    
                                        }
                                    } 
                                }    
                                
                            }
                        }
                    }

                }
            }
            $user_id = $this->user_id;
            $record = $this->Common_model->get_record("members", array('id' => $user_id));
            $this->data["is_login"] = $this->is_login;
            $this->data['user_id'] = 0;
            $this->data["title_page"] = "Import photo";
            $this->data['member'] = $record;
            $this->load->view('block/header', $this->data);
            $this->load->view("profile/import_photo_by_csv");
            $this->load->view('block/footer', $this->data);
        }else{
            redirect(base_url());
        }
        
    }
    public function get_category_children(){
        $data["status"] = "error";
        $data["reponse"] = null;
        if ($this->input->is_ajax_request()) {
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
        }
    }
    public function get_keyword(){
        $data["status"] = "error";
        $data["reponse"] = null;
        if ($this->input->is_ajax_request()) {
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
        $arg_cat = [];
        $arg_kw  = [];
        $cat = $this->input->post("category");
        $kw  = $this->input->post("keyword");
        if ( $this->input->is_ajax_request() ) {
            if($cat != null){
                foreach ($cat as $key => $value) {
                    if($value["id"] == "0"){
                        $parents_id = explode(",", $value["root"]);
                        $id = $this->Common_model->add("categories",["title" => $value["value"],"slug" => gen_slug( $value["value"]),"pid" => $parents_id[0] ,"parents_id" => $parents_id[0]]);
                        $arg_cat [] = $parents_id[0]."->".$id; 
                    }else{
                        $arg_cat [] = $value["root"]."->".$value["id"]; 
                    }
                }
            }
            if($kw != null){
                foreach ($kw as $key => $value) {
                    if($value["id"] == "0"){
                        $id = $this->Common_model->add("keywords",["title" => $value["value"],"type" => "photo"]);
                        $arg_kw [] = $id; 
                    }else{
                        $arg_kw [] = $value["id"]; 
                    }
                }
            } 
            $data["status"] = "success";
            $data ["category"] = implode(";",$arg_cat);
            $data ["keyword"] = implode(";",$arg_kw);
            die(json_encode($data));
        }

    }
    public function conversations() {
        if ($this->is_login || $this->session->userdata('user_sr_info')) {
            if($this->is_login){
                $user_id = $this->user_id;
                $is_blog = (isset($this->user_info["is_blog"])) ?  $this->user_info["is_blog"] : "no";
            }else{
                $user_info =$this->session->userdata('user_sr_info');
                $user_id = $user_info["member_owner"];
                $is_blog = (isset($user_info["is_blog"])) ?  $user_info["is_blog"] : "no";
            }
            $record = $this->Common_model->get_record("members", array('id' => $user_id));
            if ($record == null) {
                redirect('/');
            }
            $this->load->library("pagination");
            $this->data["is_login"] = $this->is_login;
            $this->data['user_id'] = 0;
            $this->data["title_page"] = "Your conversations";
            $this->data['member'] = $record;
            $this->data["company_info"] = $this->Common_model->get_record("company", array(
                'member_id' => $user_id
            ));
            $this->load->model('Photo_model');
            $this->load->model('Comment_model');
            $per_page = 6;
            $segment = 3;
            $config_init = array(
                "base_url" => "/profile/conversations",
                "segment" => $segment,
                "total_rows" => $this->Photo_model->count_photo_by_comment($user_id, 'photo'),
                "per_page" => $per_page
            );
            $config = $this->get_config_paging($config_init);
            $this->pagination->initialize($config);
            $page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
            $this->data["links"] = $this->pagination->create_links();
            $datatype = "photo";
            if($is_blog == "no"){
                $result_photo = $this->Photo_model->get_photo_by_comment($user_id, 'photo', $page, $per_page);
            }else{
                $this->load->model("Article_model");
                $result_photo = $this->Article_model->get_comment($user_id,$page,$per_page);
                $datatype = "blog";
            }
            
            if (isset($result_photo) && count($result_photo) > 0) {
                foreach ($result_photo as $key => $value) {
                    $type = "photo";
                    if($is_blog == "yes"){
                        $type = "blog";
                    }
                    $result_photo[$key]['photo_comment'] = $this->Photo_model->get_comment_photo($value['photo_id'],0,2,$type);
                    $common_tracking = $this->Common_model->get_record("common_tracking", array(
                        "reference_id" => $value['photo_id'],
                        "type_object" => $type
                    ));
                    $result_photo[$key]['qty_comment'] = (isset($common_tracking) && count($common_tracking) > 0) ? $common_tracking["qty_comment"] : 0;
                }
            }
            $this->data['results'] = $result_photo;
            $this->data['datatype'] = $datatype;
            $this->load->view('block/header', $this->data);
            $this->load->view('profile/conversations', $this->data);
            $this->load->view('block/footer', $this->data);
        }else{
            redirect('/');
        }
    }

    public function delete_photo($photo_id) {
        if (!$this->is_login || $this->is_sale_rep) {
            redirect('/');
        }

        if (!(isset($photo_id) && $photo_id != null && is_numeric($photo_id))) {
            redirect('/profile/myphoto');
        }

        $record = $this->Common_model->get_record('photos', array(
            'photo_id' => $photo_id,
            'member_id' => $this->user_id
        ));
        if (!(isset($record) && $record != null)) {
            redirect('/profile/myphoto');
        }
        $this->Common_model->delete('photos', array('photo_id' => $photo_id));
        return true;
    }
    public function api_callback($param) {
        if ($param === 'google') {
            if (isset($_GET['code'])) {
                $auth_code = $_GET["code"];
                $_SESSION['google_code'] = $auth_code;
                header('Location: ' . base_url('profile/edit/google'));
            }
        } else if ($param === 'yahoo' && isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
            require_once(APPPATH.'libraries/social/yahoo_api/globals.php'); 
            require_once(APPPATH.'libraries/social/yahoo_api/oauth_helper.php');
            // Fill in the next 3 variables.
            $request_token = $_SESSION['request_token'];
            $request_token_secret = $_SESSION['request_token_secret'];
            $oauth_verifier = $_GET['oauth_verifier'];

            // Get the access token using HTTP GET and HMAC-SHA1 signature
            $retarr = get_access_token_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $request_token, $request_token_secret, $oauth_verifier, false, true, true);
            if (!empty($retarr)) {
                list($info, $headers, $body, $body_parsed) = $retarr;
                if ($info['http_code'] == 200 && !empty($body)) {
                    $guid = $body_parsed['xoauth_yahoo_guid'];
                    $access_token = rfc3986_decode($body_parsed['oauth_token']);
                    $access_token_secret = $body_parsed['oauth_token_secret'];

                    // Call Contact API
                    $retarrs = callcontact_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $guid, $access_token, $access_token_secret, false, true);
                    if (isset($_SESSION['yahoo_contact'])) {
                        unset($_SESSION['yahoo_contact']);
                    }
                    $_SESSION['yahoo_contact'] = $retarrs;
                    header('Location: ' . base_url('profile/edit/yahoo/?oauth_token='.$_GET['oauth_token'].'&oauth_verifier='.$_GET['oauth_verifier']));
                }
            }
        } else if ($param === 'outlook') {
            if (isset($_GET['code'])) {
                require_once(APPPATH.'libraries/social/outlook_api/oauth.php');
                $auth_code = $_GET['code'];
                $redirectUri = base_url('profile/api_callback/outlook');
                $tokens = oAuthService::getTokenFromAuthCode($auth_code, $redirectUri);
                if ($tokens['access_token']) {
                    //$_SESSION['access_token'] = $tokens['access_token'];
                    // Get the user's email from the ID token
                    $user_email = oAuthService::getUserEmailFromIdToken($tokens['id_token']);
                    // $_SESSION['user_email'] = $user_email;
                    $outlook_contact = OutlookService::getContacts($tokens['access_token'], $user_email);
                    $return = array();
                    if ($outlook_contact != null && $outlook_contact['value'] != null) {
                        foreach($outlook_contact['value'] as $contact) {
                            $return[] = array(
                                    'name'=> $contact['GivenName'] . ' ' . $contact['Surname'],
                                    'email' => $contact['EmailAddresses'][0]['Address'],
                                    'image' => ''
                                );
                        }
                    }
                    usort($return, function($a, $b) {
                        $tmp1 = strtolower($a["name"]);
                        $tmp2 = strtolower($b["name"]);
                        return strcmp($tmp1,$tmp2); 
                    });
                    
                    if (isset($_SESSION['outlook_contact'])) {
                        unset($_SESSION['outlook_contact']);
                    }
                    $_SESSION['outlook_contact'] = $return;

                    // Redirect back to home page
                    header('Location: ' . base_url('profile/edit/outlook'));
                }
            }
        }
    }

    function curl($url, $post = "") {
        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        curl_setopt($curl, CURLOPT_URL, $url);
        //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        //The number of seconds to wait while trying to connect.
        if ($post != "") {
            curl_setopt($curl, CURLOPT_POST, 5);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        //The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        //To stop cURL from verifying the peer's certificate.
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }

    public function edit($param_social="") {
        if (!$this->is_login || $this->is_sale_rep) {
            redirect('/');
        }
        // Include social for yahoo, google
        // Get Contact google by API
        //include google api library
        require_once(APPPATH.'libraries/social/google_api/src/Google/autoload.php');
        $google_client_id = GOOGLE_CLIENT_ID;
        $google_client_secret = GOOGLE_CLIENT_SECRET;
        $google_redirect_uri = base_url('profile/api_callback/google');

        //setup new google client
        $client = new Google_Client();
        $client->setApplicationName('DezignWall');
        $client->setClientid($google_client_id);
        $client->setClientSecret($google_client_secret);
        $client->setRedirectUri($google_redirect_uri);
        $client->setAccessType('offline');
        $client->setScopes('https://www.google.com/m8/feeds');
        $googleImportUrl = $client->createAuthUrl();
        $this->data['googleImportUrl'] = $googleImportUrl;

        // Include yahoo api library
        require_once(APPPATH.'libraries/social/yahoo_api/globals.php'); 
        require_once(APPPATH.'libraries/social/yahoo_api/oauth_helper.php');
        $yahoo_redirect_uri = base_url('profile/api_callback/yahoo/');
        // Get the request token using HTTP GET and HMAC-SHA1 signature 
        $yahoo_retarr = get_request_token(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $yahoo_redirect_uri, false, true, true);

        $yahooImportUrl = '';
        if (!empty($yahoo_retarr)) {
            list($info, $headers, $body, $body_parsed) = $yahoo_retarr;
            if ($info['http_code'] == 200 && !empty($body)) { 
                $_SESSION['request_token'] = $body_parsed['oauth_token'];
                $_SESSION['request_token_secret'] = $body_parsed['oauth_token_secret']; 
                $_SESSION['oauth_verifier'] = $body_parsed['oauth_token'];
                $yahooImportUrl = urldecode($body_parsed['xoauth_request_auth_url']);
            } 
        }
        $this->data['yahooImportUrl'] = $yahooImportUrl;

        // Include outlook api library
        require_once(APPPATH.'libraries/social/outlook_api/oauth.php');
        require_once(APPPATH.'libraries/social/outlook_api/outlook.php');
        $this->data['outlookImportUrl'] = oAuthService::getLoginUrl(base_url('profile/api_callback/outlook'));

        /*
        // Include facebook api library
        require_once(APPPATH.'libraries/social/facebook_api/src/facebook.php');
        $facebook = new Facebook(array(
            'appId' => FACEBOOK_ID,
            'secret' => FACEBOOK_SECRET,
            'cookie' => true,
        ));

        $userFacebook = $facebook->getUser();
        $facebookImportUrl = $facebook->getLoginUrl(
                array(
                    'scope' => 'email'
                )
        );
        $this->data['facebookImportUrl'] = $facebookImportUrl;
        if ($userFacebook) {
            try {
                $user_friends = $facebook->api('/me/friends');//taggable_friends
                $access_token = $facebook->getAccessToken();

                $return = array();
                if ($user_friends != null && $user_friends['data'] != null && count($user_friends['data']) > 0) {
                    foreach ($user_friends['data'] as $user_item) {
                        $return[] = array (
                            'name'=> $user_item['name'],
                            'email' => $user_item['name'],
                            'image' => 'http://graph.facebook.com/'.$user_item['id'].'/picture'
                        );
                    }
                }
                // Sort return array
                usort($return, function($a, $b) {
                    $tmp1 = strtolower($a["name"]);
                    $tmp2 = strtolower($b["name"]);
                    return strcmp($tmp1,$tmp2); 
                });
                
                if (isset($_SESSION['facebook_contact'])) {
                    unset($_SESSION['facebook_contact']);
                }
                $_SESSION['facebook_contact'] = $return;
            } catch (FacebookApiException $e) {
                $userFacebook = null;
            }
        }
        */

        /* Check session in */
        if ($param_social === 'google' && !isset($_SESSION['google_contact'])) {
            if (isset($_SESSION['google_code'])) {
                $auth_code = $_SESSION['google_code'];
                $max_results = 200;
                $fields = array(
                    'code'=>  urlencode($auth_code),
                    'client_id'=>  urlencode($google_client_id),
                    'client_secret'=>  urlencode($google_client_secret),
                    'redirect_uri'=>  urlencode($google_redirect_uri),
                    'grant_type'=>  urlencode('authorization_code')
                );
                $post = '';
                foreach($fields as $key=>$value)
                {
                    $post .= $key.'='.$value.'&';
                }
                $post = rtrim($post,'&');
                $result = $this->curl('https://accounts.google.com/o/oauth2/token',$post);
                $response =  json_decode($result);
                $accesstoken = $response->access_token;
                $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&alt=json&v=3.0&oauth_token='.$accesstoken;
                $xmlresponse =  $this->curl($url);
                $contacts = json_decode($xmlresponse,true);
                $return = array();
                if (!empty($contacts['feed']['entry'])) {
                    foreach($contacts['feed']['entry'] as $contact) {
                        //retrieve Name and email address  
                        $object_item = array (
                            'name'=> @$contact['title']['$t'],
                            'email' => @$contact['gd$email'][0]['address'],
                            'image' => ''
                        );
                        if (empty($object_item['name'])) {
                            $object_item['name'] = $object_item['email'];
                        }
                        //retrieve user photo
                        if (isset($contact['link'][0]['href'])) {
                            $url = $contact['link'][0]['href'] . '&access_token=' . urlencode($accesstoken);
                            $curl = curl_init($url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($curl, CURLOPT_TIMEOUT, 15);
                            curl_setopt($curl, CURLOPT_VERBOSE, true);
                            $image = curl_exec($curl);
                            curl_close($curl);
                        }
                        $imgData = base64_encode($image);
                        $pro_image = 'data:image/jpeg;base64,'.$imgData .'';
                        $object_item['image'] = $pro_image;
                        $return[] = $object_item;
                    }   
                }
                // Sort return array
                usort($return, function($a, $b) {
                    $tmp1 = strtolower($a["name"]);
                    $tmp2 = strtolower($b["name"]);
                    return strcmp($tmp1,$tmp2); 
                });
                if (isset($_SESSION['google_contact'])) {
                    unset($_SESSION['google_contact']);
                }
                $_SESSION['google_contact'] = $return;
                unset($_SESSION['google_code']);
            }
        }
        // Merge 3 session
        $contacts_list = array();
        if (isset($_SESSION['google_contact']) && sizeof($_SESSION['google_contact']) > 0) {
            $contacts_list = array_merge($contacts_list, $_SESSION['google_contact']);
        }
        if (isset($_SESSION['yahoo_contact']) && sizeof($_SESSION['yahoo_contact']) > 0) {
            $contacts_list = array_merge($contacts_list, $_SESSION['yahoo_contact']);
        }
        if (isset($_SESSION['outlook_contact']) && sizeof($_SESSION['outlook_contact']) > 0) {
            $contacts_list = array_merge($contacts_list, $_SESSION['outlook_contact']);
        }
        if (sizeof($contacts_list) > 0) {
            usort($contacts_list, function($a, $b) {
                $tmp1 = strtolower($a["name"]);
                $tmp2 = strtolower($b["name"]);
                return strcmp($tmp1,$tmp2); 
            });
        }
        $_SESSION['contacts'] = $contacts_list;
        
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data["param_social"] = $param_social;
        $this->data["type_post"] = "profile";
        $this->data["id_post"] = $user_id;
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
        $this->data['member'] = $record;
        $this->data["company_info"] = $this->Common_model->get_record("company", array(
            'member_id' => $user_id
        ));
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
        $this->load->view('block/header', $this->data);
        $this->load->view('include/share-profile', $this->data);
        $this->load->view('profile/edit', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function sales_reps($id = null) {
        $user_id = ($id == null) ? $this->user_id : $id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Sales Reps";
        $this->data['user_id'] = $user_id;
        if (!(isset($record) && $record != null)) {
            redirect('/profile/');
        }

        $this->data['member'] = $record;
        $this->data["company_info"] = $this->Common_model->get_record("company", array(
            'member_id' => $user_id
        ));
        $this->data["sales_reps"] = $this->Common_model->get_result("sales_rep", array(
            'member_id' => $user_id,
            'is_public' => 1
        ));
        $this->data["data_id"] = $id;
        $this->data["data_type"] ="company";
        $this->data["type_post"] = "profile";
        $this->data["id_post"] = $id;
        $this->data["is_blog"] = $record["is_blog"];
        $this->load->view('block/header', $this->data);
        $this->load->view('profile/sales_reps', $this->data);
        $this->load->view("include/share", $this->data);
        $this->load->view('block/footer', $this->data);
    }
    
    public function suggest_business() {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Category_model');
            $keyword = $this->input->post('keyword');
            $business_type = $this->input->post('business_type');
            if ($keyword === FALSE || $business_type === FALSE || empty($business_type))
                die(json_encode(array(
                    $keyword,
                    $business_type
                )));
            $results = $this->Category_model->get_category_by_business($business_type, $keyword);
            die(json_encode($results));
        }
        else {
            die(json_encode(array(
                "status" => "error"
            )));
        }
    }

    public function edit_sales_reps($id = null) {
        if ($this->is_sale_rep) {
            redirect('/');
        }

        $user_id = ($id == null) ? $this->user_id : $id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data["type_member"] = $record["type_member"];
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Sales Reps";
        $this->data['user_id'] = $user_id;
        $this->data["data_id"] = $user_id;
        $this->data["data_type"] ="company";
        $this->data["type_post"] = "profile";
        $this->data["id_post"] = $user_id;
        $this->data["is_blog"] = $record["is_blog"];
        if (!(isset($record) && $record != null)) {
            redirect('/profile/');
        }
        $this->data['member'] = $record;
        $this->data["company_info"] = $this->Common_model->get_record("company", array(
            'member_id' => $user_id
        ));
        $this->load->model("Sales_rep");
        $this->data["sales_reps"] = $this->Sales_rep->get_sales_rep_by_member($user_id);
        $this->load->view('block/header', $this->data);
        $this->load->view('profile/edit-sales-reps', $this->data);
        $this->load->view("include/share", $this->data);
        $this->load->view('block/footer', $this->data);
    }
    public function download_impormation(){
        $user_info = $this->user_info;
        if(!empty($user_info)){
            $this->load->model("Sales_rep");
            $record_owner = $this->Sales_rep->share_contact_admin($user_info["id"]);
            $record_business= $this->Sales_rep->get_share_business($user_info["id"]);
            $record = array_merge($record_owner,$record_business);
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename="'.$this->gen_slug($user_info["full_name"]).'.csv";');
            $f = fopen('php://output', 'w');
            $array = array(
                ["First Name","Last Name","Sales Rep email","Contact Email","Sent Date"],
            );
            if(!empty($record)){
                foreach ($record  as $key => $value) {
                    $timestamp = strtotime($value["created_at"]);
                    $created_at = date('l\,M d\,Y', $timestamp);
                    $array [] = [$value["first_name"],$value["last_name"],$value["contact_email"],$value["email_sent"],$created_at];
                }
            }
            foreach ($array as $line) {
                fputcsv($f, $line,",");
            }
        }      
    }
    private function gen_slug($str){

        $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');

        $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');

        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
    }
    public function addphotos($project_id = null, $category_id = null) {
        $this->data["wall"] = false;
        if($project_id != null && $category_id != null){
            $this->data["wall"] = true;
        }
        if (!$this->is_login || $this->is_sale_rep) {
            redirect('/');
        }
        $data_share = '<meta id ="titleshare" property="og:title" content="'.$this->user_info["company_name"].' just shared on @Dezignwall TAKE A LOOK" />';
        $this->data["data_share"] = $data_share;
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Upload Photo";
        $this->data['project_id'] = $project_id;
        $this->data['category_id'] = $category_id;
        if (!(isset($record) && $record != null)) {
            redirect('/profile/');
        }
        // Warning upload image when user is incomplete their profile.
        $is_update_profile = true;
        if (@$this->user_info['company_info'] != null && $this->user_info['company_info']['business_type'] != null && !empty($this->user_info['company_info']['business_type'])) {
            $is_update_profile = false;
        }
        $this->data['is_update_profile'] = $is_update_profile;

        if (isset($project_id) && is_numeric($project_id) && isset($category_id) && is_numeric($category_id)) {
            $this->load->model('Project_model');
            $this->load->model('Photo_model');
            $result = $this->Project_model->get_project($project_id, $this->user_info["id"]);
            if ($result == null) {
                redirect('/profile/');
            }

            // Check category
            $result_cat = $this->Project_model->get_project_category($category_id);
            if ($result_cat == null) {
                redirect('/profile/');
            }

        }
        $this->load->helper('cookie');
        $photo_id = 0;
        if (isset($_COOKIE['save_multi'])) {
            $photo_id = $_COOKIE['save_multi'];
        }
        $record_photos = $this->Common_model->get_record('photos', array(
            'photo_id' => @$photo_id,
            'member_id' => $user_id
        ));
        $this->load->model('Category_model');
        if ($photo_id == 0) {
            $this->data['category'] = null;
            $this->data['keywords'] = null;
            $this->data['photo'] = null;
        } else {
            $this->data['category'] = $this->Category_model->get_category_by_photo($photo_id);
            $this->data['keywords'] = $this->Category_model->get_keyword_by_photo($photo_id);
            $this->data['photo'] = $record_photos;
        }
        $manufacturers = $this->Common_model->get_result("manufacturers",["member_id" => $this->user_id],null,null,array(["field" => "id","sort" =>"DESC"]));
        $this->data['manufacturers'] = $manufacturers;
        $this->data['is_upload_image'] = true;
        $this->load->view('block/header', $this->data);
        $this->load->view('profile/upload', $this->data);
        $this->load->view('block/footer', $this->data);
    }
    public function delete_salep_rep() {
        $data = array(
            'status' => 'error'
        );
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }

        $id = $this->input->post('id');
        $record = $this->Common_model->get_record('sales_rep', array(
            'member_id' => $this->user_id,
            'id' => $id
        ));
        if (isset($record) && count($record) > 0) {
            if ($this->Common_model->delete('sales_rep', array(
                    'member_id' => $this->user_id,
                    'id' => $id
                ))) {
                $this->Common_model->delete('member_sale_rep',array("id"=>$record["member_sale_id"],"member_id" => $this->user_id));
                $data['status'] = 'success';
            }
        }

        die(json_encode($data));
    }

    public function save_salep_rep() {
        $data = array(
            'status' => 'error'
        );
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $item = $this->input->post('rep');
        $password = (isset($item["password"]) && $item["password"] != "") ? $item["password"] : "Admin123";
        $data_insert = array(
            "first_name" => @$item["first_name"],
            "last_name" => @$item["last_name"],
            "job_title" => @$item["job_title"],
            "company_name" => @$item["company_name"],
            "number_800" => @$item["number_800"],
            "main_business_ph" => @$item["main_business_ph"],
            "contact_email" => @$item["contact_email"],
            "web_address" => @$item["web_address"],
            "main_address" => @$item["main_address"],
            "city" => @$item["city"],
            "state" => @$item["state"],
            "zip_code" => @$item["zip_code"],
            "country" => @$item["country"],
            "service_area" => @$item["service_area"],
            "is_public"    =>  0
        );
        if($this->input->post("public") && $this->input->post("public") == 1){
            $data_insert["is_public"] = 1;
        }
        $id = @$item['id'];
        $record = $this->Common_model->get_record('sales_rep', array(
            'member_id' => $this->user_id,
            'id' => $id
        ));
        if (isset($record) && count($record) > 0) {
            $this->Common_model->update('sales_rep',$data_insert, array(
                'member_id' => $this->user_id,
                'id' => $id
            ));
            $check_user_ = $this->Common_model->get_record('member_sale_rep', array( 'id' => $record["member_sale_id"]));
            if($check_user_ != null){
                $data_update = array(
                    "email" => @$item["contact_email"],
                    "pwd"   => $password
                );
                $this->Common_model->update("member_sale_rep",$data_update,array("id" => $record["member_sale_id"]));
            }else{
                $data_user_add = array(
                    "member_id" => $this->user_id,
                    "email"     => @$item["contact_email"],
                    "pwd"       => $password,
                    "created_at" => date('Y-m-d H:i:s')
                );
                $data_id_user = $this->Common_model->add('member_sale_rep',$data_user_add);
                $data_update = array("member_sale_id" => $data_id_user);
                $this->Common_model->update("sales_rep",$data_update,array("id" => $id));
            }
        } else {
            $data_insert['member_id'] = $this->user_id;
            $data_insert[' created_at'] = date('Y-m-d H:i:s');
            $data_id_add = $this->Common_model->add('sales_rep',$data_insert);
            $data_user_add = array(
                "member_id" => $this->user_id,
                "email"     => @$item["contact_email"],
                "pwd"       => $password,
                "created_at" => date('Y-m-d H:i:s')
            );
            $data_id_user = $this->Common_model->add('member_sale_rep',$data_user_add);
            $data_update = array("member_sale_id" => $data_id_user);
            $this->Common_model->update("sales_rep",$data_update,array("id" => $data_id_add));
        }
        $data['status'] = 'success';
        die(json_encode($data));
    }

    public function save() {
        $data = array(
            'status' => 'error'
        );
        if ($this->input->is_ajax_request()) {
            $this->load->model('Category_model');
            $user_id = $this->user_id;
            $record = $this->Common_model->get_record("members", array(
                'id' => $user_id
            ));
            $company_info = $this->Common_model->get_record("company", array(
                'member_id' => $user_id
            ));

            // Personal Profile Info
            if ($this->input->post('personal')) {
                $personal = $this->input->post('personal');
                $arr = array(
                    "first_name" => $personal['first_name'],
                    "last_name" => $personal['last_name'],
                    "work_email" => $personal['work_email'],
                    "job_title" => $personal['job_title'],
                    'cellphone' => $personal['cellphone']
                );
                if ($personal['password'] != null && strlen($personal['password']) >= 6 && $personal['password'] == $personal['confirmpassword']) {
                    $arr['pwd'] = md5(strtolower($record['email']) . ':' . md5($personal['password']));
                }

                $this->Common_model->update('members', $arr, array(
                    'id' => $user_id
                ));
                $new_user_info = $this->user_info;
                $new_user_info["job_title"] = $personal['job_title'];
                $this->session->unset_userdata('user_info');
                $this->session->set_userdata('user_info', $new_user_info);
                $data['status'] = 'success';
            }

            // Advanced Settings
            if ($this->input->post('settings')) {
                $settings = $this->input->post('settings');
                $general_updates = $promotions = $research_emails = $newslettter = 'no';
                if (isset($settings['newslettter']) && $settings['newslettter'] != null) {
                    $newslettter = 'yes';
                }

                if (isset($settings['general_updates']) && $settings['general_updates'] != null) {
                    $general_updates = 'yes';
                }

                if (isset($settings['promotions']) && isset($settings['promotions']) != null) {
                    $promotions = 'yes';
                }

                if (isset($settings['research_emails']) && $settings['research_emails'] != null) {
                    $research_emails = 'yes';
                }

                $arr = array(
                    "newsletter_edition" => $settings['newsletter_edition'],
                    "newslettter" => $newslettter,
                    "general_updates" => $general_updates,
                    "promotions" => $promotions,
                    "research_emails" => $research_emails,
                    "image_comment" => $settings['image_comment'],
                    "image_like" => $settings['image_like'],
                    "dezignwall_comment" => $settings['dezignwall_comment'],
                    "dezignwall_like" => $settings['dezignwall_like'],
                    "dezignwall_folder_comment" => $settings['dezignwall_folder_comment'],
                    "dezignwall_folder_like" => $settings['dezignwall_folder_like']
                );
                $check_setting = $this->Common_model->get_record('member_setting', array(
                    'member_id' => $user_id
                ));
                if (isset($check_setting) && count($check_setting) > 0) {
                    $this->Common_model->update('member_setting', $arr, array(
                        'member_id' => $user_id
                    ));
                } else {
                    $arr['member_id'] = $user_id;
                    $this->Common_model->add('member_setting', $arr);
                }
                // Get record again to update session
                $setting = $this->Common_model->get_record('member_setting', array(
                    'member_id' => $user_id
                ));
                // modify session data

                $_SESSION['user_info']['setting'] = $setting;
                $data['status'] = 'success';
            }

            // Contact Info
            if ($this->input->post('contact')) {
                $contact = $this->input->post('contact');
                $business_description = explode(',', $contact['business_description']);
                if (isset($business_description) && count($business_description) > 0) {
                    $pid = $this->Category_model->get_business_category_by_slug($contact['business_type']);
                    foreach ($business_description as $key => $value) {
                        if (isset($pid) && count($pid) > 0 && isset($value) && $value != null && trim($value) != '') {
                            $record_check = $this->Category_model->get_business_category(trim($value));
                            if (!(isset($record_check) && count($record_check))) {
                                $data = array(
                                    'pid' => $pid['id'],
                                    'title' => $value,
                                    'slug' => $this->to_slug(trim($value)),
                                    'type' => 'custom',
                                    'enabled' => '0',
                                    'sort' => '0'
                                );
                                $this->Common_model->add('business_categories', $data);
                            }
                        }
                    }
                }

                $arr = array(
                    'company_name' => $contact['company_name'],
                    'business_type' => @$contact['business_type'],
                    'business_description' => @$contact['business_description'],
                    'company_800_number' => @$contact['company_800_number'],
                    'main_business_ph' => @$contact['main_business_ph'],
                    'contact_email' => @$contact['contact_email'],
                    'web_address' => @$contact['web_address'],
                    'main_address' => @$contact['main_address'],
                    'city' => @$contact['city'],
                    'state' => @$contact['state'],
                    'zip_code' => @$contact['zip_code'],
                    'country' => @$contact['country']
                );
                $this->Common_model->update('members', array(
                    'company_name' => @$contact['company_name']
                        ), array(
                    'id' => $user_id
                ));
                if (isset($company_info) && count($company_info) > 0) {
                    $this->Common_model->update('company', $arr, array(
                        'member_id' => $user_id
                    ));
                    $data['status'] = 'success';

                    // Update company info to this profile
                    $this->session->unset_userdata('user_info');
                    
                    $record = $this->Common_model->get_record("members", array("id" => $user_id));
                    $recorder_company = $this->Common_model->get_record("company", array("member_id" => $user_id));
                    $setting = $this->Common_model->get_record("member_setting", array("member_id" => $user_id));
                    $this->session->set_userdata('user_info', array(
                        'email' => $record["email"],
                        'id' => $record["id"],
                        'full_name' => @$record["first_name"] . ' ' . @$record["last_name"],
                        'company_name' => @$recorder_company["company_name"],
                        'business_type' => @$record["business_type"],
                        'type_member' => @$record["type_member"],
                        'avatar' => @$record["avatar"],
                        'setting' => $setting,
                        'first_name' => @$record["first_name"],
                        'last_name'  =>  @$record["last_name"],
                        'job_title'  =>  @$record["job_title"],
                        'company_info'  =>  $recorder_company,
                        'is_blog' => $record["is_blog"]
                    ));
                    // Update all status photo from 0 to 1
                    $this->Common_model->update('photos', array('status_photo' => 1), array(
                        'member_id' => $user_id
                    ));

                    if (isset($_SESSION['last_photo_id'])) {
                        $data['last_photo_id'] = $_SESSION['last_photo_id'];
                    }
                } else {
                    $arr['member_id'] = $user_id;
                    $this->Common_model->add('company', $arr);
                    $data['status'] = 'success';
                }
            }

            // About
            if ($this->input->post('about')) {
                $about = $this->input->post('about');
                $arr = array(
                    'company_about' => $about['company_about']
                );
                $this->Common_model->update('members', $arr, array(
                    'id' => $user_id
                ));
                $data['status'] = 'success';
            }

            // Certifications, Service Areas
            if ($this->input->post('company')) {
                $company = $this->input->post('company');
                $certifications_image = json_decode($this->input->post('certifications_image'), true);
                $arr_file = array();
                if (isset($certifications_image) && count($certifications_image) > 0) {
                    $arr_file = $certifications_image;
                }
                if (isset($_FILES['certification'])) {
                    $path = FCPATH . "/uploads/certifications";
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }
                    $path = $path . "/" . $this->user_id;
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }
                    $folder = "/uploads/certifications/" . $this->user_id . '/';
                    $this->load->library('upload');
                    $config = array();
                    $config['upload_path'] = '.' . $folder;
                    $config['allowed_types'] = 'jpg|png|gif';
                    $config['max_size'] = '500';
                    $config['max_width'] = '1028';
                    $config['max_height'] = '1028';
                    $file = $_FILES;
                    $count = count($file['certification']['name']);
                    for ($i = 0; $i <= $count - 1; $i++) {
                        $_FILES['image']['name'] = $file['certification']['name'][$i];
                        $_FILES['image']['type'] = $file['certification']['type'][$i];
                        $_FILES['image']['tmp_name'] = $file['certification']['tmp_name'][$i];
                        $_FILES['image']['error'] = $file['certification']['error'][$i];
                        $_FILES['image']['size'] = $file['certification']['size'][$i];
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('image')) {
                            $upload_data = $this->upload->data();
                            $arr_file[] = $folder . $upload_data['file_name'];
                        }
                    }
                }
                // Sync image
			        	exec('aws s3 sync  /dw_source/dezignwall/uploads/certifications/ s3://dwsource/dezignwall/uploads/certifications/ --acl public-read'); 
                $arr = array(
                    'certifications' => json_encode(array(
                        'text' => $company['certifications'],
                        'image' => json_encode($arr_file)
                    )),
                    'service_area' => $company['service_area']
                );
                if (isset($company_info) && count($company_info) > 0) {
                    $this->Common_model->update('company', $arr, array(
                        'member_id' => $user_id
                    ));
                    $data['status'] = 'success';
                } else {
                    $arr['member_id'] = $user_id;
                    $this->Common_model->add('company', $arr);
                    $data['status'] = 'success';
                }
            }
        }

        die(json_encode($data));
    }

    private function to_slug($string) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }

    public function logout() {
        $this->session->unset_userdata('user_info');
        $this->session->unset_userdata('user_sr_info');
        $this->session->unset_userdata('ci_session');
        $request = '';
        if ($_SERVER['QUERY_STRING']) {
            $request = "?" . @$_SERVER['QUERY_STRING'];
        }
        redirect(base_url() . $request);
    }

    public function save_media() {
        $data = array(
            'status' => 'error'
        );
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        if ($this->input->is_ajax_request() && isset($record) && count($record) > 0) {
            $choose = $this->input->post('choose');
            if (isset($_FILES['fileupload']) && is_uploaded_file($_FILES['fileupload']['tmp_name'])) {
                $output_dir = "./uploads/company/";
                $output_url = "/uploads/company/";
                $filename = $_FILES['fileupload']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION); //type image
                $RandomNum = time();
                $ImageName = str_replace(' ', '-', strtolower($_FILES['fileupload']['name']));
                $ImageType = $_FILES['fileupload']['type']; //"image/png", image/jpeg etc.
                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt = str_replace('.', '', $ImageExt);
                $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                if (isset($choose) && ($choose == 'logo' || $choose == 'avatar' || $choose == 'banner')) {
                    if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $output_dir . $NewImageName)) {
                        $data = crop_image($NewImageName, $ext, $output_url);
                        
                        // Sync image company
                        exec('aws s3 sync  /dw_source/dezignwall'.$output_url.' s3://dwsource/dezignwall'.$output_url.' --acl public-read --cache-control max-age=86400,public --expires 2034-01-01T00:00:00Z'); 
                        $choose = $this->input->post('choose');
                        if ($data["status"] == "success") {
                            if ($choose == 'avatar') {
                                if (isset($record['avatar']) && file_exists('.' . $record['avatar'])) {
                                    unlink('.' . $record['avatar']);
                                }

                                $arr = array(
                                    'avatar' => $output_url . $data["name"]
                                );
                                $arrs = $this->session->userdata('user_info');
                                $arrs['avatar'] = $output_url . $data["name"];
                                $this->session->set_userdata('user_info', $arrs);

                                $this->Common_model->update('members', $arr, array(
                                    'id' => $user_id
                                ));
                                $data['name'] = $output_url . $data["name"];
                            } else
                            if ($choose == 'logo') {
                                if (isset($record['logo']) && file_exists('.' . $record['logo'])) {
                                    unlink('.' . $record['logo']);
                                }

                                $arr = array(
                                    'logo' => $output_url . $data["name"]
                                );
                                $this->Common_model->update('members', $arr, array(
                                    'id' => $user_id
                                ));
                                $data['name'] = $output_url . $data["name"];
                            } else
                            if ($choose == 'banner') {
                                if (isset($record['banner']) && file_exists('.' . $record['banner'])) {
                                    unlink('.' . $record['banner']);
                                }

                                $arr = array(
                                    'banner' => $output_url . $data["name"]
                                );
                                $this->Common_model->update('members', $arr, array(
                                    'id' => $user_id
                                ));
                                $data['name'] = $output_url . $data["name"];
                            }
                        }
                    }
                }
            }
        }

        die(json_encode($data));
    }

    public function get_by_category() {
        $data = array(
            'status' => 'error'
        );
        if ($this->input->is_ajax_request()) {
            $slug = $this->input->post('slug');
            $parents_id = explode(',', $this->input->post('parents_id'));
            $list_id = $this->input->post('list_id');
            if (isset($slug) && $slug != null && isset($parents_id) && count($parents_id) > 0) {
                $this->load->model('Category_model');
                $data['status'] = 'success';
                $data['reponse'] = $this->Category_model->get_by_category_name_like($slug, $parents_id, $list_id);
            }
        }
        die(json_encode($data));
    }

    public function get_keywords() {
        $data = array(
            'status' => 'error'
        );
        if ($this->input->is_ajax_request()) {
            $slug = $this->input->post('slug');
            $list_id = $this->input->post('list_id');
            if (isset($slug) && $slug != null) {
                $this->load->model('Category_model');
                $data['status'] = 'success';
                $data['reponse'] = $this->Category_model->get_by_keywords_name_like($slug, $list_id);
            }
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

    private function add_other_category($name, $photo_id, $parents_id = null, $location_number = 0, $category_id = 0) {
        $this->load->model('Category_model');
        $cate_id = 0;
        if (intval($category_id) == 0) {
            $record = $this->Category_model->get_by_name($name, $parents_id);
            if (isset($record) && count($record)) {
                $cate_id = $record['id'];
            } else {
                $cate_id = $this->Common_model->add('categories', array(
                    'title' => $name,
                    'parents_id' => $parents_id[0],
                    'parents_id' => $parents_id[0],
                    'slug' => $this->slug_category($name),
                    'sort' => 0,
                    'type' => 'custom'
                ));
            }
        } else {
            $cate_id = intval($category_id);
        }

        $check = $this->Common_model->get_record('photo_category', array(
            'category_id' => intval($cate_id),
            'photo_id' => $photo_id,
        ));
        if (!(isset($check) && count($check) > 0)) {
            $this->Common_model->add('photo_category', array(
                'category_id' => intval($cate_id),
                'photo_id' => $photo_id,
                'location' => $location_number,
                'first_child_category' => $parents_id[0],
            ));
        }
    }

    private function add_other_keywords($name, $photo_id, $keywords_id = 0) {
        $key_id = 0;
        if (intval($keywords_id) == 0) {
            $record = $this->Common_model->get_record('keywords', array(
                'title' => $name,
                'type'  =>'photo'
            ));
            if (isset($record) && count($record)) {
                //print_r($record);
                $key_id = $record['keyword_id'];
            } else {
                //echo $key_id . '<br />';
                $key_id = $this->Common_model->add('keywords', array(
                    'title' => $name,
                    'type'  =>'photo'
                ));
            }
        } else {
            $key_id = intval($keywords_id);
        }

        $check = $this->Common_model->get_record('photo_keyword', array(
            'keyword_id' => intval($key_id),
            'photo_id' => $photo_id,
        ));
        // print_r($check);
        if (!(isset($check) && count($check) > 0)) {
            $this->Common_model->add('photo_keyword', array(
                'keyword_id' => $key_id,
                'photo_id' => $photo_id
            ));
        }
    }

    private function slug_category($tring) {
        strtolower($tring);
        str_replace(" ", "-", $tring);
        str_replace("/", "-", $tring);
        str_replace("_", "-", $tring);
        return $tring;
    }

    private function save_custom_category($category_system, $category_custom, $photo_id, $location_number, $id) {
        // category system
        $category = explode(',', $category_system);
        if (isset($category) && count($category) > 0) {
            foreach ($category as $key => $value) {
                if (isset($value) && $value != null && is_numeric($value)) {
                    $this->add_other_category('', $photo_id, $id, $location_number, $value);
                }
            }
        }

        // category custom
        $custom = explode(',', $category_custom);
        if (isset($custom) && count($custom) > 0) {
            foreach ($custom as $key => $value) {
                if (isset($value) && $value != null && trim($value) != '') {
                    $this->add_other_category($value, $photo_id, $id, $location_number);
                }
            }
        }
    }

    private function save_category_check($value, $location_number, $photo_id) {
        if (isset($value) && count(explode('|', $value)) == 2) {
            $locally = explode('|', $value);
            $this->Common_model->add('photo_category', array(
                'category_id' => $locally[0],
                'photo_id' => $photo_id,
                'location' => $location_number,
                'first_child_category' => $locally[1]
            ));
        }
    }

    private function save_custom_keywords($keywords_system, $keywords_custom, $photo_id) {
        /* Keyword System */
        $keywords = explode(',', $keywords_system);
        if (isset($keywords) && count($keywords) > 0) {
            foreach ($keywords as $key => $value) {
                if (isset($value) && $value != null && is_numeric($value)) {
                    $this->add_other_keywords('', $photo_id, $value);
                }
            }
        }

        /* Keyword Custom */
        $keywords_other = explode(',', $keywords_custom);
        if (isset($keywords_other) && count($keywords_other) > 0) {
            foreach ($keywords_other as $key => $value) {
                if (isset($value) && $value != null && trim($value) != '') {
                    $this->add_other_keywords($value, $photo_id);
                }
            }
        }
    }

    public function save_image_photo($project_id = null, $category_id = null) {
        $data = array(
            'status' => 'error'
        );
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));

        // Warning upload image when user is incomplete their profile.
        $is_update_profile = true;
        if ($this->user_info['company_info'] != null && $this->user_info['company_info']['business_type'] != null 
            && !empty($this->user_info['company_info']['business_type'])) {
            $is_update_profile = false;
        }
        //if ($is_update_profile) {
        //    die(json_encode($data));
        //}
        // ----------------------------------------------------
        
        if ($this->input->is_ajax_request() && isset($record) && count($record) > 0) {
            if (isset($_FILES['fileupload']) && is_uploaded_file($_FILES['fileupload']['tmp_name'])) {
                $path = FCPATH . "/uploads/member";
                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE);
                }

                $path = $path . "/" . $this->user_id;
                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE);
                }
                $filename = $_FILES['fileupload']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION); //type image
                $output_dir = "./uploads/member/" . $this->user_id . "/";
                $output_url = "/uploads/member/" . $this->user_id . "/";
                $config_upload['upload_path'] = $path;
                $config_upload['allowed_types'] = 'jpg|png|jpeg|gif';
                $this->load->library('upload', $config_upload);
                $this->upload->initialize($config_upload);
                $image = $this->upload->do_upload("fileupload");
                $image_data = $this->upload->data();
                //die(json_encode($image_data));
                if ($image) {
                    $data1 = crop_image($image_data['file_name'], $ext, $output_url);
                    if ($data1["status"] == "success") {
                        // thumb
                        $this->load->library('image_lib');
                        $size = getimagesize($output_dir . $data1['name']);
                        $w_current = $size[0];
                        $h_current = $size[1];
                        if ($w_current > 1020) {
                            // resize
                            $config['source_image'] = $output_dir . $data1['name'];
                            $config['source_image'] = $output_dir . $data1['name'];
                            $config['maintain_ratio'] = FALSE;
                            $config['width'] = 1020;
                            $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                            $config['height'] = $size_ratio['height'];
                            $config['quality'] = 100;
                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                        }
                        $config['source_image'] = $output_dir . $data1['name'];
                        $config['new_image'] = $output_dir . "thumbs_" . $data1['name'];
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 400;
                        $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                        $config['height'] = $size_ratio['height'];
                        $config['quality'] = 100;
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
						            $output_url = "/uploads/member/" . $this->user_id . "/";
                        $thumb = $output_url . "thumbs_" . $data1['name'];
                        $path = $output_url . $data1['name']; 
                        //send since photo amz            
	                      exec('aws s3 sync  /dw_source/dezignwall' . $output_url . '/ s3://dwsource/dezignwall' . $output_url . '/ --acl public-read --cache-control max-age=86400,public --expires 2034-01-01T00:00:00Z');               
                        $type = 2;
                        if (isset($project_id) && is_numeric($project_id) && isset($category_id) && is_numeric($category_id)) {
                            $this->load->model('Project_model');
                            $this->load->model('Photo_model');
                            $result = $this->Project_model->get_project($project_id, $this->user_info["id"]);
                            if ($result == null) {
                                die(json_encode($data));
                            }

                            // Check category
                            $result_cat = $this->Project_model->get_project_category($category_id);
                            if ($result_cat == null) {
                                die(json_encode($data));
                            }
                            $type = 4;
                        }
                        $photo_id = $this->Common_model->add('photos', array(
                            'path_file' => $path,
                            'thumb' => $thumb,
                            'member_id' => $user_id,
                            'type' => $type,
                            'created_at' => date('Y-m-d H:i:s')
                        ));
                        if (isset($photo_id) && $photo_id > 0) {
                            $data['status'] = "success";
                            $data['name'] = base_url($path);
                            $data['photo_id'] = $photo_id;
                        }
                    }
                }
            }
        }
        die(json_encode($data));
    }

    public function upload_images($project_id = null, $category_id = null) {
        $is_dezignwall = false;
        $data_result = array(
            'status' => 'error',
            'message' => ''
        );
        $user_id = @$this->user_id;
        $owner_member_id = $user_id;
        // Warning upload image when user is incomplete their profile.
        $is_update_profile = true;
        if ($this->user_info['company_info'] != null && $this->user_info['company_info']['business_type'] != null 
            && !empty($this->user_info['company_info']['business_type'])) {
            $is_update_profile = false;
        }
        if ($this->input->is_ajax_request() && isset($user_id) && $user_id != null && is_numeric($user_id)) {
            // Check project and category
            if (isset($project_id) && is_numeric($project_id) && isset($category_id) && is_numeric($category_id)) {
                $this->load->model('Project_model');
                $this->load->model('Photo_model');
                $result = $this->Project_model->get_project($project_id, $this->user_info["id"]);
                if ($result == null) {
                    die(json_encode($data));
                }
                // Check category
                $result_cat = $this->Project_model->get_project_category($category_id);
                if ($result_cat == null) {
                    die(json_encode($data));
                }
                $owner_member_id = $result["member_id"];
                $is_dezignwall = true;
                $is_update_profile = false;
            }

            $project_image = $this->input->post('project_image');
            $product_type = $this->input->post('product_type');
            $photo_credit = $this->input->post('photo_credit');
            $location_check = $this->input->post('location_check');
            $style = $this->input->post('style');
            $style_other = $this->input->post('style_other');
            $category = $this->input->post('category');
            $category_other = $this->input->post('category_other');
            $location = $this->input->post('location');
            $location_other = $this->input->post('location_other');
            $compliance = $this->input->post('compliance');
            $compliance_other = $this->input->post('compliance_other');
            $keywords = $this->input->post('keywords');
            $keywords_other = $this->input->post('keywords_other');
            $source = $this->input->post('source');
            $point_tag = json_decode($this->input->post('point_tag'), true);
            $crop_data = json_decode($this->input->post('cropper_data'), true);
            $photo_id = $this->input->post('photo_id');
            $offer_product = $this->input->post('offer_product');
            $unit_price = $this->input->post('unit_price');
            $max_unit_price = $this->input->post('max_unit_price');
            $sample_apply = $this->input->post('sample_apply');
            $description = $this->input->post('description');
            $manufacture = @$this->input->post('manufacturers');
            $file_name = $this->input->post('file_name');
            $file_name = time().trim($file_name);
            //new input.
            $number_code_input = @$this->input->post('number_code');
            $width_input = @$this->input->post('width');
            $height_input = @$this->input->post('height');
            $weight_in_input = @$this->input->post('weight-in');
            $weight_kg_input = @$this->input->post('weight-kg');
            $depth_projection_input = @$this->input->post('depth_projection');

            if($photo_id != null){
              	$pathsync = "/uploads/member";
                $path = FCPATH . "uploads/member";
                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE);
                }

                $path = $path . "/" . $this->user_id;
                $pathsync = $pathsync . "/" . $this->user_id;
                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE);
                }
                $file = $path ."/". $file_name;
                $front_content = substr($photo_id, strpos($photo_id, ",")+1);
                $decodedData = base64_decode($front_content);
                $fp = fopen( $file, 'wb' ) ;
                fwrite( $fp, $decodedData);
                fclose( $fp ); 
                if (file_exists($file)) {
                    $this->load->library('image_lib');
                    $size = getimagesize($file);
                    $w_current = $size[0];
                    $h_current = $size[1];
                    if ($w_current > 1020) {
                        // resize
                        $config['source_image'] = $file;
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 1020;
                        $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                        $config['height'] = $size_ratio['height'];
                        $config['quality'] = 100;
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                    }
                    $config['source_image'] = $file;
                    $config['new_image'] = $path . "/thumbs_" . $file_name;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 400;
                    $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                    $config['height'] = $size_ratio['height'];
                    $config['quality'] = 100;
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $thumb = "/uploads/member/".$this->user_id."/thumbs_".$file_name;
                    $path = "/uploads/member/".$this->user_id."/".$file_name;
                    exec('aws s3 sync /dw_source/dezignwall' . $pathsync . '/ s3://dwsource/dezignwall' . $pathsync . '/ --acl public-read --cache-control max-age=86400,public --expires 2034-01-01T00:00:00Z');    
                    $type = 2;
                    if (isset($project_id) && is_numeric($project_id) && isset($category_id) && is_numeric($category_id)) {
                        $this->load->model('Project_model');
                        $this->load->model('Photo_model');
                        $result = $this->Project_model->get_project($project_id, $this->user_info["id"]);
                        if ($result == null) {
                            die(json_encode($data));
                        }
                        // Check category
                        $result_cat = $this->Project_model->get_project_category($category_id);
                        if ($result_cat == null) {
                            die(json_encode($data));
                        }
                        $type = 4;
                    }
                    $photo_id = $this->Common_model->add('photos', array(
                        'path_file' => $path,
                        'thumb' => $thumb,
                        'member_id' => $this->user_id,
                        'type' => $type 
                    ));
                    if (isset($photo_id) && $photo_id != null && is_numeric($photo_id) && $photo_id != 0) {
                        $record_photo = $this->Common_model->get_record('photos', array(
                            'photo_id' => $photo_id,
                            'member_id' => $user_id
                        ));
                        if (!(isset($record_photo) && count($record_photo) > 0 )) {
                            die(json_encode($data));
                        }
                        $this->Common_model->delete('photo_category', array(
                            'photo_id' => $photo_id
                        ));
                        $this->Common_model->delete('photo_keyword', array(
                            'photo_id' => $photo_id
                        ));

                        $arr = array(
                            'name' => $product_type,
                            "description"       => $description,
                            'image_category'    => $project_image,
                            'note'              => '',
                            'status_photo'      => $is_update_profile ? 0 : 1,
                            'photo_credit'      => $photo_credit,
                            'offer_product'     => $offer_product,
                            'unit_price'        => $unit_price,
                            'maximum_price'     => $max_unit_price,
                            'sample_pricing'    => $sample_apply,
                            "manufacture"       => $manufacture,
                            "number_item"       => $number_code_input,
                            "width"             => $width_input,
                            "height"            => $height_input,
                            "weight_lbs"        => $weight_in_input,
                            "weight_kg"         => $weight_kg_input,
                            "depth_proj"        => $depth_projection_input
                        );
                        $check = $this->Common_model->update('photos', $arr, array(
                            'photo_id' => $photo_id,
                            'member_id' => $user_id
                        ));
                        if ($check) {
                            if (isset($_SESSION['last_photo_id'])) {
                                unset($_SESSION['last_photo_id']);
                            }
                            if ($is_update_profile) {
                                $_SESSION['last_photo_id'] = $photo_id;
                            }

                            $save_multi = $this->input->post('save_multiple');
                            if (isset($save_multi) && $save_multi != null) {
                                setcookie('save_multi', $photo_id, time() + (86400 * 30), '/');
                            } else {
                                if (isset($_COOKIE['save_multi'])) {
                                    setcookie("save_multi", "", time() - 3600, '/');
                                }
                            }

                            $location_number = 0;
                            $both = explode(',', $location_check);
                            if (isset($both[0]) && $both[0] != null) {
                                $temp = explode('|', $both[0]);
                                if (isset($temp[0]) && $temp[0] != null && is_numeric($temp[0])) {
                                    $location_number = $temp[0];
                                }
                                $location_both = $both[0];
                                if (count($both) > 1) {
                                    $location_both = 0;
                                }
                                $this->save_category_check($both[0], $location_both, $photo_id);
                            }

                            if (isset($both[1]) && $both[1] != null) {
                                $location_both = $both[1];
                                if (count($both) > 1) {
                                    $location_both = 0;
                                }
                                $location_number = 0;
                                $this->save_category_check($both[1], $location_both, $photo_id);
                            }
                            $data_album = null;
                            if (isset($_FILES["album"])){
                                $file_album = $_FILES["album"];
                                $lengt_file = count($file_album["name"]);
                                $file_data  = null;
                                for($i=1; $i < $lengt_file; $i++){
                                    if($file_album["error"][$i] == 0){
                                        $file_data["name"] = $file_album["name"][$i];
                                        $file_data["type"] = $file_album["type"][$i];
                                        $file_data["tmp_name"] = $file_album["tmp_name"][$i];
                                        $file_data["error"] = $file_album["error"][$i];
                                        $file_data["size"] = $file_album["size"][$i];
                                        $path = FCPATH . "uploads/member";
                                        if (!is_dir($path)) {
                                            mkdir($path, 0777, TRUE);
                                        }

                                        $path = $path . "/" . $this->user_id;
                                        if (!is_dir($path)) {
                                            mkdir($path, 0777, TRUE);
                                        }
                                        $allowed_types = "jpg|png";
                                        $upload = upload_flie($path, $allowed_types, $file_data);
                                        if($upload["success"] == "success"){
                                            $file_name = $upload["message"]["upload_data"]["file_name"];
                                            $this->load->library('image_lib');
                                            $file = $upload["message"]["upload_data"]["full_path"];
                                            $size = getimagesize($file);
                                            $w_current = $size[0];
                                            $h_current = $size[1];
                                            if ($w_current > 1020) {
                                                // resize
                                                $config['source_image'] = $file;
                                                $config['maintain_ratio'] = FALSE;
                                                $config['width'] = 1020;
                                                $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                                                $config['height'] = $size_ratio['height'];
                                                $config['quality'] = 100;
                                                $this->image_lib->clear();
                                                $this->image_lib->initialize($config);
                                                $this->image_lib->resize();
                                            }
                                            $config['source_image'] = $file;
                                            $config['new_image'] = $path . "/thumbs_" . $file_name;
                                            $config['maintain_ratio'] = FALSE;
                                            $config['width'] = 400;
                                            $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                                            $config['height'] = $size_ratio['height'];
                                            $config['quality'] = 100;
                                            $this->image_lib->clear();
                                            $this->image_lib->initialize($config);
                                            $this->image_lib->resize();
                                            $thumb = "/uploads/member/".$this->user_id."/thumbs_".$file_name;
                                            $path = "/uploads/member/".$this->user_id."/".$file_name;
                                            $type = 2;
                                            $data_album []= array(
                                                "title" => "Item photo album",
                                                "path"  => $path,
                                                "thumb" => $thumb
                                            );
                                        }   
                                    }                                    
                                }
                                exec('aws s3 sync /dw_source/dezignwall/uploads/'.$this->user_id.'/ s3://dwsource/dezignwall/uploads/'.$this->user_id.'/ --acl public-read --cache-control max-age=86400,public --expires 2034-01-01T00:00:00Z');
                                $data_album = json_encode($data_album);
                                $this->Common_model->update("photos",["album" => $data_album],["photo_id" => $photo_id]);
                            }
                            $this->save_category_check($source, $location_number, $photo_id);

                            $this->save_custom_category($category, $category_other, $photo_id, $location_number, array(
                                $this->Common_model->_CAT_PRODUCT,
                                $this->Common_model->_CAT_PROJECT
                            ));

                            $this->save_custom_category($location, $location_other, $photo_id, $location_number, array(
                                $this->Common_model->_CAT_AREA
                            ));

                            $this->save_custom_category($style, $style_other, $photo_id, $location_number, array(
                                $this->Common_model->_CAT_STYLE
                            ));

                            $this->save_custom_category($compliance, $compliance_other, $photo_id, $location_number, array(
                                $this->Common_model->_CAT_COMPLIANCE
                            ));

                            $this->save_custom_keywords($keywords, $keywords_other, $photo_id);

                            if (isset($crop_data) && count($crop_data) > 0) {
                                $this->load->library('image_lib');
                                if (isset($crop_data['rotate']) && intval($crop_data['rotate']) > 0) {
                                    $degrees = intval($crop_data['rotate']);
                                    $config['library_path'] = '/usr/bin/convert';
                                    $config['image_library'] = 'imagemagick';
                                    $config['quality'] = "100%";
                                    $config['rotation_angle'] = $degrees;
                                    $config['maintain_ratio'] = FALSE;
                                    $config['source_image'] = '.' . $record_photo['path_file'];
                                    $config['new_image'] = '.' . $record_photo['path_file'];
                                    $this->image_lib->clear();
                                    $this->image_lib->initialize($config);
                                    $this->image_lib->rotate();
                                }

                                if (isset($crop_data['height']) && intval($crop_data['height']) > 0) {
                                    // cropper
                                    $config['image_library'] = 'gd2';
                                    $config['source_image'] = '.' . $record_photo['path_file'];
                                    $config['new_image'] = '.' . $record_photo['path_file'];
                                    $config['maintain_ratio'] = FALSE;
                                    $config['x_axis'] = floatval($crop_data['x']);
                                    $config['y_axis'] = floatval($crop_data['y']);
                                    $config['width'] = floatval($crop_data['width']);
                                    $config['height'] = floatval($crop_data['height']);
                                    $config['quality'] = 100;
                                    $this->image_lib->clear();
                                    $this->image_lib->initialize($config);
                                    $this->image_lib->crop();
                                }

                                $size = getimagesize('.' . $record_photo['path_file']);
                                $w_current = $size[0];
                                $h_current = $size[1];
                                $config['source_image'] = '.' . $record_photo['thumb'];
                                $config['new_image'] = '.' . $record_photo['thumb'];
                                $config['maintain_ratio'] = FALSE;
                                $config['width'] = 400;
                                $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                                $config['height'] = $size_ratio['height'];
                                $config['quality'] = 100;
                                $this->image_lib->clear();
                                $this->image_lib->initialize($config);
                                $this->image_lib->resize();
                            }
                            //tag image
                            $data_result['tag'] = $point_tag;
                            if (isset($point_tag) && count($point_tag) > 0) {
                                $this->Common_model->delete('images_point', array(
                                    'photo_id' => $photo_id
                                ));
                                $size_new = getimagesize('.' . $record_photo['path_file']);
                                $w_current_new = $size_new[0];
                                $h_current_new = $size_new[1];
                                $w_box = $this->input->post('w_box');
                                $h_box = $this->input->post('h_box');
                                $ratio_w_new = floatval($w_current_new / $w_box);
                                $ratio_h_new = floatval($h_current_new / $h_box);
                                foreach ($point_tag as $key => $value) {
                                    $this->Common_model->add('images_point', array(
                                        'photo_id' => $photo_id,
                                        'top' => floatval($value['top']) * $ratio_h_new,
                                        'left' => floatval($value['left']) * $ratio_w_new,
                                        'product_in' => $value['product_in'],
                                        'one_off' => $value['one_off'],
                                        'max_qty' => $value['max_qty']
                                    ));
                                }
                            }//end tag image
							              exec('aws s3 sync /dw_source/dezignwall' . $pathsync . '/ s3://dwsource/dezignwall' . $pathsync . '/ —-acl public-read --cache-control max-age=86400,public --expires 2034-01-01T00:00:00Z');							
                            $data_result['status'] = 'success';
                            $data_result['message'] = 'Image uploaded successfully.';
                            $data_result['photo_id'] = $photo_id;
                            $data_result['photo_name'] = $product_type;
                            $data_result['url_photo_public'] = base_url() . 'photos/' . $photo_id . '/' . slugify($product_type) . '.html';
                            $data_result['url'] = "/profile/myphoto/";
                            if ($is_dezignwall) {
                                $result = $this->Project_model->get_project($project_id, $this->user_info["id"]);
                                $product = $this->input->post('product');
                                $arr = array(
                                    'product_name' => @$product['product_name'],
                                    'product_no' => @$product['product_no'],
                                    'price' => @$product['price'],
                                    'qty' => @$product['qty'],
                                    'fob' => @$product['fob'],
                                    'product_note' => @$product['product_notes'],
                                );
                                $arr['photo_id'] = $photo_id;
                                $arr['category_id'] = $category_id;
                                $arr['created_at'] = date('Y-m-d H:i:s');
                                $arr['member_id'] = $owner_member_id;
                                $arr['member_updated_id'] = $this->user_id;
                                $this->Common_model->add('products', $arr);
                                $data_result['url'] = "/designwalls/photos/{$project_id}/{$category_id}";
                            }
                            $this->db->select("kw.title");
                            $this->db->from("keywords AS kw");
                            $this->db->join("photo_keyword AS pkw","pkw.keyword_id = kw.keyword_id AND pkw.photo_id = ".$photo_id." AND kw.type='photo'");
                            $this->db->group_by("kw.title");
                            $get_record_kw = $this->db->get()->result_array();
                            $data_kw_new = [];
                            if($get_record_kw != null){
                                foreach ($get_record_kw as $key => $value_1) {
                                    $data_kw_new [] = $value_1["title"];
                                }
                            }
                            if($data_kw_new != null){
                                $data_kw_new = implode(",",$data_kw_new);   
                            }else{
                                $data_kw_new = "";
                            }
                            $this->Common_model->update("photos",["keywords" => $data_kw_new,"update_done" => "1"],["photo_id" => $photo_id]);
                            $this->db->select("kw.category_id");
                            $this->db->from("photo_category AS kw");
                            $this->db->group_by("kw.category_id");
                            $this->db->where("photo_id",$photo_id);
                            $get_record_kw = $this->db->get()->result_array();
                            $data_kw_new = [];
                            if($get_record_kw != null){
                                foreach ($get_record_kw as $key => $value_1) {
                                    $data_kw_new [] = $value_1["category_id"];
                                }
                            }
                            if($data_kw_new != null){
                                $data_kw_new = implode("/",$data_kw_new);   
                                $data_kw_new="/".$data_kw_new."/";
                            }else{
                                $data_kw_new = "";
                            }
                            $this->Common_model->update("photos",["category" => $data_kw_new,"update_category_done" => "1"],["photo_id" => $photo_id]);
                        } //end photo id
                    }
                }
                
            }
            
            
        }
        
        die(json_encode($data_result));
    }

    public function editphoto($id, $category_id = null, $project_id = null) {
        if (!$this->is_login || $this->is_sale_rep) {
            redirect('/');
        }
        if (!$this->is_login || !(isset($id) && $id != null && is_numeric($id))) {
            redirect('/');
        }
        $this->data["type_post"] = "photo";
        $this->data["id_post"] = $id;
        $user_id = $this->user_id;
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Edit Photo";
        $record = $this->Common_model->get_record('photos', array(
            'photo_id' => @$id,
            'member_id' => $user_id
        ));
        if (!(isset($record) && count($record) > 0)) {
            redirect('/profile/addphotos');
        }
        // Warning upload image when user is incomplete their profile.
        $is_update_profile = true;
        if ($this->user_info['company_info'] != null && $this->user_info['company_info']['business_type'] != null 
            && !empty($this->user_info['company_info']['business_type'])) {
            $is_update_profile = false;
        }

        $this->load->model('Category_model');
        if ($record['type'] == 4) {
            $this->data['c_id'] = $category_id;
            $this->data['product_info'] = $this->Common_model->get_record('products', array(
                'photo_id' => $id,
                'category_id' => $category_id
            ));
            $is_update_profile = false;
        }
        $this->data['is_update_profile'] = $is_update_profile;
        $this->data['category'] = $this->Category_model->get_category_by_photo($id);
        $this->data['point'] = $this->Common_model->get_result('images_point', array(
            'photo_id' => $id
        ));
        $this->data['keywords'] = $this->Category_model->get_keyword_by_photo($id);
        $this->data['photo'] = $record;
        $this->data['is_upload_image'] = true;
        $this->data['url_photo_public'] = base_url() . 'photos/' . $id . '/' . slugify($record['name']) . '.html';
        $data_share = '<meta id ="titleshare" property="og:title" content="'.$this->user_info["company_name"].' just shared on @Dezignwall TAKE A LOOK" />';
        $manufacturers = $this->Common_model->get_result("manufacturers",["member_id" => $this->user_id],null,null,array(["field" => "id","sort" =>"DESC"]));
        $this->data['manufacturers'] = $manufacturers;
        $this->data["data_share"] = $data_share;
        $this->load->view('block/header', $this->data);
        $this->load->view('profile/editphoto', $this->data);
        $this->load->view('block/footer', $this->data);
    }
    public function get_manufacture(){
        if ($this->is_login && $this->input->is_ajax_request()) {
            $manufacture = $this->input->post("manufacture");
            if($manufacture != ""){
                $this->db->select("manufacture");
                $this->db->from("photos");
                $this->db->like("manufacture",$manufacture);
                $this->db->where("member_id",$this->user_id);
                $data = $this->db->get()->result_array();
                $data = array_column($data, 'manufacture');
                die(json_encode($data));                
            }  
        }
    }
    public function save_edit_photo() {
        $data = array(
            'status' => 'error',
            'message' => ''
        );
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }

        // Warning upload image when user is incomplete their profile.
        $is_update_profile = true;
        if ($this->user_info['company_info'] != null && $this->user_info['company_info']['business_type'] != null 
            && !empty($this->user_info['company_info']['business_type'])) {
            $is_update_profile = false;
        }

        $photo_id = $this->input->post('photo_id');
        $project_image = $this->input->post('project_image');
        $product_type = $this->input->post('product_type');
        $photo_credit = $this->input->post('photo_credit');
        $location_check = $this->input->post('location_check');
        $style = $this->input->post('style');
        $style_other = $this->input->post('style_other');
        $category = $this->input->post('category');
        $category_other = $this->input->post('category_other');
        $location = $this->input->post('location');
        $location_other = $this->input->post('location_other');
        $compliance = $this->input->post('compliance');
        $compliance_other = $this->input->post('compliance_other');
        $keywords = $this->input->post('keywords');
        $keywords_other = $this->input->post('keywords_other');
        $source = $this->input->post('source');
        $point_tag = json_decode($this->input->post('point_tag'), true);
        $number_code_input = @$this->input->post('number_code');
        $width_input = @$this->input->post('width');
        $height_input = @$this->input->post('height');
        $weight_in_input = @$this->input->post('weight-in');
        $weight_kg_input = @$this->input->post('weight-kg');
        $depth_projection_input = @$this->input->post('depth_projection');

        $user_id = $this->user_id;
        $record = $this->Common_model->get_record('photos', array(
            'photo_id' => @$photo_id,
            'member_id' => $user_id
        ));
        if (!(isset($record) && count($record) > 0)) {
            die(json_encode($data));
        }
        if ($record['type'] == 4) {
            $is_update_profile = false;
        }

        $image_category = '';
        if (isset($project_image) && $project_image != null) {
            $image_category = $project_image;
        } else {
            $image_category = $product_image;
        }

        if (isset($product_image) && $product_image != null && isset($project_image) && $project_image != null) {
            $image_category = $project_image . ',' . $product_image;
        }

        $offer_product = $this->input->post('offer_product');
        $unit_price = $this->input->post('unit_price');
        $max_unit_price = $this->input->post('max_unit_price');
        $sample_apply = $this->input->post('sample_apply');
        $description = $this->input->post('description');
        $manufacture = $this->input->post('manufacturers');
        if ($sample_apply == 'on') {
            $unit_price = '';
            $max_unit_price = '';
        }
        $arr = array(
            'name'              => $product_type,
            "description"       => $description,
            'image_category'    => $image_category,
            'photo_credit'      => $photo_credit,
            'status_photo'      => $is_update_profile ? 0 : 1,
            'offer_product'     => $offer_product,
            'unit_price'        => $unit_price,
            'maximum_price'     => $max_unit_price,
            'sample_pricing'    => $sample_apply,
            'manufacture'       => $manufacture ,
            "number_item"       => $number_code_input,
            "width"             => $width_input,
            "height"            => $height_input,
            "weight_lbs"        => $weight_in_input,
            "weight_kg"         => $weight_kg_input,
            "depth_proj"        => $depth_projection_input
        );
        $this->Common_model->update('photos', $arr, array(
            'photo_id' => @$photo_id
        ));
        $this->Common_model->delete('photo_category', array(
            'photo_id' => $photo_id
        ));
        $this->Common_model->delete('photo_keyword', array(
            'photo_id' => $photo_id
        ));
        $location_number = 0;
        $both = explode(',', $location_check);

        if (isset($both[0]) && $both[0] != null) {
            $temp = explode('|', $both[0]);
            $location_both = $both[0];
            if (count($both) > 1) {
                $location_both = 0;
            }
            if (isset($temp[0]) && $temp[0] != null && is_numeric($temp[0])) {
                $location_number = $temp[0];
            }
            $this->save_category_check($both[0], $location_both, $photo_id);
        }

        if (isset($both[1]) && $both[1] != null) {
            $location_both = $both[1];
            if (count($both) > 1) {
                $location_both = 0;
            }
            $location_number = 0;
            $this->save_category_check($both[1], $location_both, $photo_id);
        }

        $this->save_category_check($source, $location_number, $photo_id);

        $this->save_custom_category($category, $category_other, $photo_id, $location_number, array(
            $this->Common_model->_CAT_PRODUCT,
            $this->Common_model->_CAT_PROJECT
        ));

        $this->save_custom_category($location, $location_other, $photo_id, $location_number, array(
            $this->Common_model->_CAT_AREA
        ));

        $this->save_custom_category($style, $style_other, $photo_id, $location_number, array(
            $this->Common_model->_CAT_STYLE
        ));

        $this->save_custom_category($compliance, $compliance_other, $photo_id, $location_number, array(
            $this->Common_model->_CAT_COMPLIANCE
        ));

        $this->save_custom_keywords($keywords, $keywords_other, $photo_id);
        $size_new = getimagesize(base_url($record['path_file']));
        $w_current_new = $size_new[0];
        $h_current_new = $size_new[1];

        // tag image
        $this->Common_model->delete('images_point', array(
            'photo_id' => $photo_id
        ));

        if (isset($point_tag) && count($point_tag) > 0) {
            $w_box = $this->input->post('w_box');
            $h_box = $this->input->post('h_box');
            $ratio_w = floatval($w_current_new / $w_box);
            $ratio_h = floatval($h_current_new / $h_box);
            $this->Common_model->delete('images_point', array(
                'photo_id' => $photo_id
            ));
            foreach ($point_tag as $key => $value) {
                $this->Common_model->add('images_point', array(
                    'photo_id' => $photo_id,
                    'top' => $value['top'] * $ratio_h,
                    'left' => $value['left'] * $ratio_w,
                    'product_in' => @$value['product_in'],
                    'one_off' => $value['one_off'],
                    'max_qty' => $value['max_qty']
                ));
            }
        } //end tag image
        //save product info
        if ($record['type'] == 4) {
            $product = $this->input->post('product');
            if (isset($product['category_id']) && $product['category_id'] != null && is_numeric($product['category_id'])) {
                $record = $this->Common_model->get_record('products', array(
                    'photo_id' => @$photo_id,
                    'category_id' => $product['category_id']
                ));
                $arr = array(
                    'product_name' => @$product['product_name'],
                    'product_no' => @$product['product_no'],
                    'price' => @$product['price'],
                    'qty' => @$product['qty'],
                    'fob' => @$product['fob'],
                    'product_note' => @$product['product_notes']
                );
                if (isset($record) && count($record) > 0) {
                    $this->Common_model->update('products', $arr, array(
                        'photo_id' => $photo_id,
                        'category_id' => $product['category_id']
                    ));
                } else {
                    $arr['photo_id'] = $photo_id;
                    $arr['category_id'] = $product['category_id'];
                    $arr['created_at'] = date('Y-m-d H:i:s');
                    $arr['member_id'] = $this->user_id;
                    $arr['member_updated_id'] = $this->user_id;
                    $this->Common_model->add('products', $arr);
                }
            }
        }
        $data['status'] = 'success';
        $data['message'] = 'Image saved successfully.';
        $data['photo_id'] = $photo_id;
        $data['photo_name'] = $product_type;
        $data['url_photo_public'] = base_url() . 'photos/' . $photo_id . '/' . slugify($product_type) . '.html';
        die(json_encode($data));
    }

    public function upgrade() {
        redirect('/payment/upgrade');
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data['package'] = $this->Common_model->get_result('packages', array(
            'type' => 0
        ));
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Upgrade";
        $this->data['skins'] = 'upgrade';
        $this->load->view('block/header', $this->data);
        $this->load->view('profile/upgrade-main', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function plan($id = null) {
        if ($id == null || !is_numeric($id)) {
            redirect('/profile/upgrade');
        }

        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data['package'] = $this->Common_model->get_result('packages', array(
            'type' => 0, 'id' => $id
        ));
        if ($this->data['package'] == null || count($this->data['package']) <= 0) {
            redirect('/profile/upgrade');
        }

        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Upgrade";
        $this->data['skins'] = 'upgrade';
        $this->load->view('block/header', $this->data);
        $this->load->view('profile/upgrade', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function offer_code() {
        if ($this->input->is_ajax_request()) {
            $data["success"] = "error";
            $code = $this->input->post("code");
            $datime = date("Y-m-d");
            $filter = array(
                "code" => $code,
                "start_date <=" => $datime,
                "end_date   >=" => $datime,
                "number_uses >" => 0
            );
            $record = $this->Common_model->get_record("offer", $filter);
            $filter = array(
                "offer_id" => @$record["id"],
                "member_id" => $this->user_id
            );
            $uses_offer = $this->Common_model->get_record("uses_offer", $filter);
            if (count($record) > 0 && count($uses_offer) == 0) {
                $data["success"] = "success";
                $data["message"] = "Promo code successfully.";
                $update = $this->Common_model->update("members", array(
                    "type_member" => 1
                        ), array(
                    "id" => $this->user_id
                ));
                if ($update) {
                    $this->Common_model->update("offer", array(
                        "number_uses" => ($record["number_uses"] - 1)
                            ), array(
                        "id" => $record["id"]
                    ));
                    $this->Common_model->add("uses_offer", array(
                        "offer_id" => $record["id"],
                        "member_id" => $this->user_id
                    ));
                    $filter = array(
                        "member_id" => $this->user_id
                    );
                    $member_upgrade = $this->Common_model->get_record("member_upgrade", $filter);
                    $filter = array(
                        "id" => $record["type"]
                    );
                    $get_packages = $this->Common_model->get_record("packages", $filter);
                    $number_day = $get_packages["max_files"] * 30;
                    if (count($member_upgrade) > 0) {
                        $date_plus = date("Y-m-d", strtotime("" . $member_upgrade["upgrade_date_end"] . " +" . $number_day . " day"));
                        $this->Common_model->update("member_upgrade", array(
                            "upgrade_date_end" => $date_plus
                                ), array(
                            "member_id" => $this->user_id
                        ));
                    } else {
                        $date_plus = date("Y-m-d", strtotime("" . $datime . " +" . $number_day . " day"));
                        $this->Common_model->add("member_upgrade", array(
                            "member_id" => $this->user_id,
                            "upgrade_date_start" => $datime,
                            "upgrade_date_end" => $date_plus
                        ));
                    }
                }

                $this->session->unset_userdata('user_info');
                $this->user_info["type_member"] = 1;
                $this->session->set_userdata('user_info', $this->user_info);
            } else {
                if (count($record) == 0) {
                    $data["message"] = "Promo code is incorrect.";
                }

                if (count($uses_offer) > 0) {
                    $data["message"] = "Promo code has been used.";
                }
            }

            die(json_encode($data));
        }
    }

    public function check_promo_code() {
        if ($this->input->is_ajax_request()) {
            $data["success"] = "error";
            $code = $this->input->post("promo_code");
            $datime = date("Y-m-d");
            $filter = array(
                "code" => $code,
                "start_date <=" => $datime,
                "end_date   >=" => $datime,
                "number_uses >" => 0
            );
            $record = $this->Common_model->get_record("offer", $filter);
            $filter = array(
                "offer_id" => $record["id"],
                "member_id" => $this->user_id
            );
            $uses_offer = $this->Common_model->get_record("uses_offer", $filter);
            if (count($record) > 0 && count($uses_offer) == 0) {
                $data["success"] = "success";
                $data["message"] = "Promo code is correct.";
            } else {
                if (count($record) == 0) {
                    $data["message"] = "Promo code is incorrect.";
                }
                if (count($uses_offer) > 0) {
                    $data["message"] = "Promo code has been used.";
                }
            }

            die(json_encode($data));
        }
    }
    public function your_reports(){
        if ($this->is_login  || $this->session->userdata('user_sr_info')) {
            $user_info = array();
            if($this->is_login){
                $user_id = $this->user_id;
            }else{
                $user_info = $this->session->userdata('user_sr_info');
                $user_id   = $user_info["member_owner"];
            }
            $get_company_up = $this->Common_model->get_record("members",array("id"=>$user_id));
            if(!empty($get_company_up) && @$get_company_up["type_member"]=="1"){
                $this->data["is_login"] = $this->is_login;
                $this->data["title_page"] = "Your Reports";
                $web_setting = $this->Common_model->get_web_setting('setting_report','c.title');
                $type_date = 'w';
                if ($web_setting != null && $web_setting[0] != null) {
                    $type_date = $web_setting[0]['title'];
                }
                $date_old = date('m-d-Y', strtotime('-'.date('w').' days'));
                if ($type_date != 'w') {
                    $date_old = date('Y-m-d',strtotime($type_date));
                }
                
                //$days = ['Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6];
               // $get_date = getdate();
                //$month = $get_date["weekday"];
                //$date_old  = date( "Y-m-d", strtotime( "".date('Y-m-d')." - ".$days[$month]." day" ));

				//SB: last 30 days
				$date_old = date('c', strtotime('-30 days'));
				
                $this->data["number_view_profile"] = $this->Common_model->get_result_distinct($user_id,"profile",$date_old,"createdat_profile");
                $type_photo = "photo";
                if($this->user_info["is_blog"] == "yes" || @$user_info["is_blog"] == "yes"){
                    $type_photo ="blog";
                }
                $this->load->model("Members_model");
                $this->data["number_view_photo"] = $this->Common_model->get_result_distinct($user_id,$type_photo,$date_old,"createdat_photo_blog");
                $this->data["items_user"] = $this->Members_model->get_share_profile($user_id,$date_old);
                $this->data["items_user"]["all"] = $this->Members_model->get_all_share_profile($user_id,$date_old);
                $this->data["items_photo_click"] = $this->Members_model->get_click_photo($user_id,$type_photo,$date_old);
                $this->data["items_photo_click"]["all"] = $this->Members_model->get_all_click_photo($user_id,$type_photo,$date_old);
                $owner_recod_type = $this->Members_model->get_photo_comom_view_by_member($user_id,$type_photo,$date_old);
                if($owner_recod_type != null){
                    $data_photo_share = [];
                    foreach ($owner_recod_type as $key => $value) {
                        $value["items"] = $this->Members_model->get_photo_profile($value["reference_id"],$type_photo,$date_old);    
                        $value["all"]  = $this->Members_model->get_all_photo_profile($value["reference_id"],$type_photo,$date_old);
                        $data_photo_share[] = $value;
                    }
                    $this->data["data_photo_share"]= $data_photo_share;
                }
                $total_photo = $this->Members_model->get_photo_comom_view_by_member($user_id,$type_photo,$date_old,-1,0);
                $this->data["total_photo"] = count($total_photo);
                $this->load->view('block/header', $this->data);
                $this->load->view('profile/your_reports', $this->data);
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
            $data_type  = $this->input->post("data_type");
            $data_order = $this->input->post("data_order");
            $data_colum = $this->input->post("data_colum");
            $limit_box  = $this->input->post("limit_box");
            $post_id    = @$this->input->post("post_id");
            $data["orderby"] = json_encode($this->input->post());
            $arg_data_type  = ["profile","photo-blog-view","photo-blog"];
            $arg_data_colum = ["clicks","facebook","email","twitter","linkedin"];
            $arg_data_order = ["newest","oldest","most-shared","least-shared"];
            if(in_array($data_type, $arg_data_type) && in_array($data_colum, $arg_data_colum) && in_array($data_order, $arg_data_order)){
                $arg_od = ["newest" => "DESC","oldest" => "ASC","most-shared" => "DESC","least-shared" => "ASC"];
                $type_photo = "photo";
                if($this->user_info["is_blog"] == "yes" || @$user_info["is_blog"] == "yes")
                    $type_photo ="blog";
                $this->load->model("Members_model");
                $order_text = "";
                if($data_order == "newest" || $data_order == "oldest")
                    $arg_colum = [ "clicks" => "alltbl.date_click", "facebook" => "alltbl.date_fb", "twitter" => "alltbl.date_tw", "linkedin" => "alltbl.date_li" ,"email" => "alltbl.date_e"];                 
                else
                    $arg_colum = [ "clicks" => "alltbl.number_proflie", "facebook" => "alltbl.number_facebook", "email" => "alltbl.number_email", "twitter" => "alltbl.number_twitter", "linkedin" => "alltbl.number_linkedin" ]; 
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
                switch ($data_type) {
                    case 'profile':  
                       $record = $this->Members_model->get_share_profile($user_id,$date_old,$arg_od[$data_order],$data_colum,$order_text,0,$limit_box);
                       break;
                    case 'photo-blog-view': 
                       $record = $this->Members_model->get_click_photo($user_id,$type_photo,$date_old,$arg_od[$data_order],$order_text,0,$limit_box);
                       break;
                   default:
                       $record = $this->Members_model->get_photo_profile($post_id,$type_photo,$date_old,$arg_od[$data_order],$data_colum,$order_text,0,$limit_box);
                       break;
                }
                $html = "";
                if($record != null){
                    foreach ($record as $key => $value) {
                        if($data_type != "photo-blog-view"){
                            $number_email = ($value["number_email"] != "") ? $value["number_email"] : 0;
                            $number_twitter = ($value["number_twitter"] != "") ? $value["number_twitter"] : 0;
                            $number_facebook = ($value["number_facebook"] != "") ? $value["number_facebook"] : 0;
                            $number_linkedin = ($value["number_linkedin"] != "") ? $value["number_linkedin"] : 0; 
                        }
                        $number_proflie = ($value["number_proflie"] != "") ? $value["number_proflie"] : 0; 
                        $timestamp = strtotime($value["created_at"]);
                        $logo = ($value['avatar'] != "" && file_exists(FCPATH . $value['avatar'])) ? base_url($value['avatar']) : base_url("skins/images/avatar-full.png"); 
                        $html.='<div class="row items">';
                            $html.='<div class="col-xs-9 col-md-7">';
                                $html.='<div class="row">';
                                    $html.='<div id="reports-email" data-email ="'.$value["work_email"].'">';
                                        $html.='<div class="col-xs-2 text-center"><div class="logo-user"><img src="'.$logo.'"></div></div>';
                                        $html.='<div class="col-xs-10"><p>'.$value["first_name"].' '.$value["last_name"].' | '.$value["company_name"].' - '.date('F j \a\t h:i A', $timestamp).'</p></div>';
                                    $html.='</div>';
                                $html.='</div>';
                            $html.='</div>';
                            $html.='<div class="col-xs-2 col-md-1 col-md-1 text-center">';
                                $html.='<p>'.$number_proflie.'</p>';
                            $html.='</div>';
                            if($data_type != "photo-blog-view"){
                                $html.='<div class="col-xs-1 text-center">';
                                    $html.='<p>'.$number_email.'</p>';
                                $html.='</div>';
                                $html.='<div class="col-xs-1 xs-none text-center">';
                                    $html.='<p>'.$number_facebook.'</p>';
                                $html.='</div>';
                                $html.='<div class="col-xs-1 xs-none text-center">';
                                    $html.='<p>'.$number_twitter.'</p>';
                                $html.='</div>';
                                $html.='<div class="col-xs-1 xs-none text-center">';
                                    $html.='<p>'.$number_linkedin.'</p>';
                                $html.='</div>';
                            }
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
            $this->load->model("Members_model");
            $type_photo = "photo";
            if($this->user_info["is_blog"] == "yes" || @$user_info["is_blog"] == "yes")
                $type_photo ="blog";
            if($data_post == null){
                switch ($data_type) {
                    case 'profile':  
                       $record = $this->Members_model->get_share_profile($user_id,$date_old,"DESC","","",$limit_box,3);
                       $all = $this->Members_model->get_all_share_profile($user_id,$date_old);
                       break;
                    case 'photo-blog-view': 
                       $record = $this->Members_model->get_click_photo($user_id,$type_photo,$date_old,"DESC","",$limit_box,3);
                       $all = $this->Members_model->get_all_click_photo($user_id,$type_photo,$date_old);
                       break;
                   default:
                       $record = $this->Members_model->get_photo_profile($post_id,$type_photo,$date_old,"DESC","","",$limit_box,3);
                       $all = $this->Members_model->get_all_photo_profile($post_id,$type_photo,$date_old);
                       break;
                }
            }else{
                $arg_data_type  = ["profile","photo-blog-view","photo-blog"];
                $arg_data_colum = ["clicks","facebook","email","twitter","linkedin"];
                $arg_data_order = ["newest","oldest","most-shared","least-shared"];
                $data_order = @$data_post["data_order"];
                $data_colum = @$data_post["data_colum"];
                if(in_array($data_type, $arg_data_type) && in_array($data_colum, $arg_data_colum) && in_array($data_order, $arg_data_order)){
                    $arg_od = ["newest" => "DESC","oldest" => "ASC","most-shared" => "DESC","least-shared" => "ASC"];
                    $order_text = "";
                    if($data_order == "newest" || $data_order == "oldest")
                        $arg_colum = [ "clicks" => "alltbl.date_click", "facebook" => "alltbl.date_fb", "twitter" => "alltbl.date_tw", "linkedin" => "alltbl.date_li" ,"email" => "alltbl.date_e"];                 
                    else
                        $arg_colum = [ "clicks" => "alltbl.number_proflie", "facebook" => "alltbl.number_facebook", "email" => "alltbl.number_email", "twitter" => "alltbl.number_twitter", "linkedin" => "alltbl.number_linkedin" ];
                    $order_text = "ORDER BY ".$arg_colum[$data_colum]." ".$arg_od[$data_order]."";
                    switch ($data_type) {
                        case 'profile':  
                           $record = $this->Members_model->get_share_profile($user_id,$date_old,$arg_od[$data_order],$data_colum,$order_text,$limit_box,3);
                           $all = $this->Members_model->get_all_share_profile($user_id,$date_old);
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
            if($record != null){
                foreach ($record as $key => $value) {
                    if($data_type != "photo-blog-view"){
                        $number_email = ($value["number_email"] != "") ? $value["number_email"] : 0;
                        $number_twitter = ($value["number_twitter"] != "") ? $value["number_twitter"] : 0;
                        $number_facebook = ($value["number_facebook"] != "") ? $value["number_facebook"] : 0;
                        $number_linkedin = ($value["number_linkedin"] != "") ? $value["number_linkedin"] : 0; 
                    }
                    $number_proflie = ($value["number_proflie"] != "") ? $value["number_proflie"] : 0; 
                    $timestamp = strtotime($value["created_at"]);
                    $logo = ($value['avatar'] != "" && file_exists(FCPATH . $value['avatar'])) ? base_url($value['avatar']) : base_url("skins/images/avatar-full.png"); 
                    $html.='<div class="row items">';
                        $html.='<div class="col-xs-9 col-md-7">';
                            $html.='<div class="row">';
                                $html.='<div id="reports-email" data-email ="'.$value["work_email"].'">';
                                    $html.='<div class="col-xs-2 text-center"><div class="logo-user"><img src="'.$logo.'"></div></div>';
                                    $html.='<div class="col-xs-10"><p>'.$value["first_name"].' '.$value["last_name"].' | '.$value["company_name"].' - '.date('F j \a\t h:i A', $timestamp).'</p></div>';
                                $html.='</div>';
                            $html.='</div>';
                        $html.='</div>';
                        $html.='<div class="col-xs-2 col-md-1 text-center">';
                            $html.='<p>'.$number_proflie.'</p>';
                        $html.='</div>';
                        if($data_type != "photo-blog-view"){
                            $html.='<div class="col-xs-1 text-center">';
                                $html.='<p>'.$number_email.'</p>';
                            $html.='</div>';
                            $html.='<div class="col-xs-1 xs-none text-center">';
                                $html.='<p>'.$number_facebook.'</p>';
                            $html.='</div>';
                            $html.='<div class="col-xs-1 xs-none text-center">';
                                $html.='<p>'.$number_twitter.'</p>';
                            $html.='</div>';
                            $html.='<div class="col-xs-1 xs-none text-center">';
                                $html.='<p>'.$number_linkedin.'</p>';
                            $html.='</div>';
                        }
                    $html.='</div>';
                }
                $data["reponse"] = $html;  
            }
            $data["success"] = "success";
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
                    $data_photo_share[] = $value;
                }
                $html = "";
                if($data_photo_share != null){
                    foreach ($data_photo_share as $key => $value) {
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
                                                <div class="col-xs-9 col-md-7"></div>
                                                <div class="col-xs-2 col-md-1 relative text-center box-click">
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
                                                <div class="col-xs-1 text-center relative box-email">
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
                                                <div class="col-xs-1 text-center relative box-facebook xs-none">
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
                                                <div class="col-xs-1 text-center relative box-twitter xs-none">
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
                                                <div class="col-xs-1 text-center relative box-in xs-none">
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
                                            <div id="list-items">';
                                            if (isset($value["items"])) {
                                                foreach ($value["items"] as $key_items => $value_items) {
                                                    $number_proflie = ($value_items["number_proflie"] != null) ? $value_items["number_proflie"] : 0; 
                                                    $number_email = ($value_items["number_email"] != null) ? $value_items["number_email"] : 0; 
                                                    $number_facebook = ($value_items["number_facebook"] != null) ? $value_items["number_facebook"] : 0; 
                                                    $number_twitter = ($value_items["number_twitter"] != null) ? $value_items["number_twitter"] : 0; 
                                                    $number_linkedin = ($value_items["number_linkedin"] != null) ? $value_items["number_linkedin"] : 0; 
                                                    $timestamp = strtotime($value_items["created_at"]);
                                                    $logo = ($value_items['avatar'] != "" && file_exists(FCPATH . $value_items['avatar'])) ? base_url($value_items['avatar']) : base_url("skins/images/avatar-full.png");                         
                                                    $html.='<div class="row items">
                                                                <div class="col-xs-9 col-md-7">
                                                                    <div class="row">
                                                                        <div class="col-xs-2 text-center"><div class="logo-user"><img src="'.$logo.'"></div></div>
                                                                        <div class="col-xs-10"><p><a id="reports-email" href="#" data-email ="'.$value_items["work_email"].'">'.$value_items["first_name"]. " ".$value_items["last_name"].' | '.$value_items["company_name"].' - '.date('F j \a\t h:i A', $timestamp).'</a></p></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-2 col-md-1 text-center">
                                                                    <p>'.$number_proflie.'</p>
                                                                </div>
                                                                <div class="col-xs-1 text-center">
                                                                    <p>'.$number_email.'</p>
                                                                </div>
                                                                <div class="col-xs-1 text-center xs-none">
                                                                    <p>'.$number_facebook.'</p>
                                                                </div>
                                                                <div class="col-xs-1 text-center xs-none">
                                                                    <p>'.$number_twitter.'</p>
                                                                </div>
                                                                <div class="col-xs-1 text-center xs-none">
                                                                    <p>'.$number_linkedin.'</p>
                                                                </div> 
                                                            </div>';
                                                }
                                            }
                                            $html.='</div>
                                            <input type="hidden" id="order_set" name="">
                                            <p class="text-right" id="more-your-reports"><a href="#">MORE</a></p>
                                        </div> 
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
    public function get_services(){
        $data = array(
            'status' => 'error'
        );
        if ($this->input->is_ajax_request()) {
            $slug = $this->input->post('slug');
            $list_id = $this->input->post('list_id');
            if (isset($slug) && $slug != null) {
                $this->load->model('Sales_rep');
                $data['status'] = 'success';
                $data['reponse'] = $this->Sales_rep->get_services($slug, $list_id);
            }
        }
        die(json_encode($data));
    }
    public function add_catalog(){
        $data = array( 'status' => 'error' );
        if ($this->input->is_ajax_request()) {
            if($this->input->post("title") != null && trim($this->input->post("title")) != ""){
                if($this->input->post("logo")){
                    $upload_path = FCPATH.'uploads/manufacturers/';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }
                    $img = $this->input->post("logo");
                    $name = trim($this->input->post("logo_name"));
                    $file = FCPATH . 'uploads/manufacturers/' . $this->user_id .'-'. time() .'-' . $name;
                    $front_content = substr($img, strpos($img, ",")+1);
                    $decodedData = base64_decode($front_content);
                    $fp = fopen( $file, 'wb' );
                    fwrite( $fp, $decodedData);
                    fclose( $fp );
                    $logo = '/uploads/manufacturers/' . $this->user_id .'-'. time() .'-' . $name;
                    $data = array('status' => 'status',"logo" => $logo);
                    $data_id = $this->Common_model->add("manufacturers",
                        ["name" => @$this->input->post("title"),"logo" => @$logo,"description" => @$this->input->post("description"),"member_id" => $this->user_id,"createat" =>date('Y-m-d H:i:s')]
                    );
                    // Sync image
					          exec('aws s3 sync  /dw_source/dezignwall/uploads/manufacturers/ s3://dwsource/dezignwall/uploads/manufacturers/ --acl public-read --cache-control max-age=86400,public --expires 2034-01-01T00:00:00Z'); 
                    exec('aws s3 sync  /dw_source/dezignwall/uploads/certifications/ s3://dwsource/dezignwall/uploads/certifications/ --acl public-read --cache-control max-age=86400,public --expires 2034-01-01T00:00:00Z'); 
                    $data = array('status' => 'status',"logo" => $logo,"url" => base_url("profile/addphotos?catalog=".$data_id)); 
                    $data["reponse"] = $this->Common_model->get_record("manufacturers",["id" =>  $data_id]);
                } 
            }else{
                $data["message"] = "Please enter title";

            }
        }
        die(json_encode($data));
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
    public function more_manufacturers(){
        if ($this->input->is_ajax_request() && $this->is_login) {
            if(is_numeric(@$this->input->post("page"))){
                $limit = $this->input->post("limit");;
                $offset = $limit  *  $this->input->post("page");
                $manufacturers1 = $this->Common_model->get_result("manufacturers",["member_id" => $this->user_id],$offset,$limit,[["field" => "createat","sort" =>"DESC"]]);
                $count_manufacturers = $this->Common_model->get_result("manufacturers",["member_id" => $this->user_id]);
                $data_show_more = false;
                if(count($count_manufacturers ) > ($offset  + $limit)){  $data_show_more = true; }
                die(json_encode([
                    "data" => $_POST,
                    "status" => true,
                    "data_more" => $data_show_more,
                    "data_reponse" => $manufacturers1
                ]));

            }
        }   
    }
    public function action_manufacturers(){
        $data = ["status" => "error","reponse" => null];
        if ($this->input->is_ajax_request()) {
            if(is_numeric(@$this->input->post("id")) && $this->is_login){
                $id = $this->input->post("id");
                $this->Common_model->delete("manufacturers",["id" => $id,"member_id" => $this->user_id]);
                $data = ["status" => "success","reponse" => null];
            }
        }
        die(json_encode($data));
    }
    public function search_manufacturers(){
        $data = ["status" => "error","reponse" => null];
        if ($this->input->is_ajax_request()) {
            if($this->is_login){
                $value = $this->input->post("value");
                $this->db->select("*");
                $this->db->from("manufacturers");
                $this->db->where(["member_id" => $this->user_id]);
                $this->db->like("name",$value);
                $this->db->limit(10);
                $result_data = $this->db->get();
                $data = ["status" => "success","reponse" => $result_data->result_array()];
            }
        }
        die(json_encode($data));
    }
    public function get_manufacturers(){
        $data = ["status" => "error","reponse" => null];
        if ($this->input->is_ajax_request()) {
            if(is_numeric(@$this->input->post("id")) && $this->is_login){
                $id = $this->input->post("id");
                $reponse = $this->Common_model->get_record("manufacturers",["id" => $id]);
                $this->load->model("Photo_model");
                $data_number  =  $this->Photo_model->total_photo(null,null,null,$id);
                $reponse["number_photo"] = $data_number;
                $data = ["status" => "success","reponse" => $reponse];
            }
        }
        die(json_encode($data));
    }
    public function edit_catalog(){
        $data = array( 'status' => 'error' );
        if ($this->input->is_ajax_request()) {
            if(@$this->input->post("id") != null){
                if($this->input->post("title") != null && trim($this->input->post("title")) != ""){
                    $logo = null;
                    if($this->input->post("logo") && trim($this->input->post("logo") != "")){
                        $upload_path = FCPATH.'uploads/manufacturers/';
                        if (!is_dir($upload_path)) {
                            mkdir($upload_path, 0777, TRUE);
                        }
                        $img = $this->input->post("logo");
                        $name = trim($this->input->post("logo_name"));
                        $file = FCPATH . 'uploads/manufacturers/' . $this->user_id .'-'. time() .'-' . $name;
                        $front_content = substr($img, strpos($img, ",")+1);
                        $decodedData = base64_decode($front_content);
                        $fp = fopen( $file, 'wb' );
                        fwrite( $fp, $decodedData);
                        fclose( $fp );
                        $logo = 'uploads/manufacturers/' . $this->user_id .'-'. time() .'-' . $name;
                        $data = array('status' => 'status',"logo" => $logo); 
                        
                        // Sync image
						            exec('aws s3 sync  /dw_source/dezignwall/uploads/manufacturers/ s3://dwsource/dezignwall/uploads/manufacturers/ --acl public-read'); 
                    } 
                    if($logo == null){
                        $this->Common_model->update("manufacturers",
                            ["name" => @$this->input->post("title"),"description" => @$this->input->post("description")],
                            ["id" => $this->input->post("id"),"member_id" => $this->user_id]
                        );
                    }else{
                        $this->Common_model->update("manufacturers",
                            ["name" => @$this->input->post("title"),"logo" => $logo,"description" => @$this->input->post("description")],
                            ["id" => @$this->input->post("id"),"member_id" => $this->user_id]
                        );
                    }
                    $data = array('status' => 'status',"logo" => $logo);
                }else{
                    $data["message"] = "Please enter title";

                }
            }
           
        }
        die(json_encode($data));
    }
    public function change_logo_catalog(){
        $data = array( 'status' => 'error' );
        if ($this->input->is_ajax_request()) {
            if(@$this->input->post("id") != null){
                if(isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0){
                    $user_info = $this->user_info;
                    $upload_path = FCPATH.'uploads/manufacturers/';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }
                    $name = explode(".", $_FILES["logo"]["name"]);
                    $config['upload_path'] = $upload_path;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = (10*1024); // Byte
                    $config['file_name'] = $this->gen_slug($name[0] .'-'. time());
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload("logo")){
                    	 // Sync image
					            	exec('aws s3 sync  /dw_source/dezignwall/uploads/manufacturers/ s3://dwsource/dezignwall/uploads/manufacturers/ --acl public-read'); 
                        $logo = 'uploads/manufacturers/'.$config['file_name'].'.'.$name[count($name) - 1];
                        $this->Common_model->update("manufacturers",
                            ["logo" => $logo],
                            ["id" => @$this->input->post("id"),"member_id" => $this->user_id]
                        );
                        $data = array('status' => 'status',"logo" => $logo);
                    }else{
                        $data["message"] = "Something went wrong when saving the file, please try again.!";
                    }
                }   
            }
        }  
        die(json_encode($data));   
    }  
    public function batch_upload_file(){
        $data2 = [];
        $datavv = [];
        $data_return =  array( 'status' => 'error' );
        if($this->input->is_ajax_request() && $this->is_login && $this->input->post()){
            $manufacturers = $this->input->post("manufacturers");
            // upload manufacturers.
            if($manufacturers == "" || $manufacturers == null ){
                if($this->input->post("logo")){
                    $upload_path = FCPATH.'uploads/manufacturers/';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }
                    $img = $this->input->post("logo");
                    $name = trim($this->input->post("logo_name"));
                    $file = FCPATH . 'uploads/manufacturers/' . $this->user_id .'-'. time() .'-' . $name;
                    $front_content = substr($img, strpos($img, ",")+1);
                    $decodedData = base64_decode($front_content);
                    $fp = fopen( $file, 'wb' );
                    fwrite( $fp, $decodedData);
                    fclose( $fp );
                    $logo = 'uploads/manufacturers/' . $this->user_id .'-'. time() .'-' . $name;
                    $data = array('status' => 'status',"logo" => $logo);
                    $manufacturers =  $this->Common_model->add("manufacturers",
                        ["name" => @$this->input->post("title"),"logo" => @$logo,"description" => @$this->input->post("description"),"member_id" => $this->user_id,"createat" =>date('Y-m-d H:i:s')]
                    );
                    $data = array('status' => 'status',"logo" => $logo);    
                }
                else{
                    $manufacturers = $this->Common_model->get_record("manufacturers",["member_id" => $this->user_id ,"type" => "0"]) ;
                    if($manufacturers != null){
                        $manufacturers = $manufacturers["id"];
                    }else{
                        $file = FCPATH.'/uploads/manufacturers/Default-Catalog.png';
                        $urlfile = "/uploads/manufacturers/".uniqid().'-default-catalog.png';
                        $new_file = FCPATH.$urlfile;
                        if (copy($file, $new_file)) {
                            $catelog = array(
                                "name" => "Default catalog",
                                "logo" => $urlfile,
                                "member_id" => $this->user_id,
                                "type" => "0"
                            );
                            $id_catelog = $this->Common_model->add("manufacturers",$catelog);
                            if($id_catelog){
                                $this->Common_model->update("photos",["manufacture" => $id_catelog],["member_id" => $this->user_id ,"type" => 2 ,"manufacture" => 0]);
                            }
                        }
                    }
                }
                
                // Sync image
				        exec('aws s3 sync  /dw_source/dezignwall/uploads/manufacturers/ s3://dwsource/dezignwall/uploads/manufacturers/ --acl public-read --cache-control max-age=86400,public --expires 2034-01-01T00:00:00Z'); 
            }
            $data = $this->input->post("data_file_exl");
            $data = json_decode($data,true);
            $data_check_key = [
                'Item Number'                   => "null",
                'image URL 1'                   => "null",
                'Image Title'                   => "null",
                'Image Description'             => "null",
                'Photographer'                  => "null",
                'Image Type'                    => "null",
                'Service type'                  => "null",
                'Single Unit Price'             => "null",
                'Maximum Units at this price'   => "null",
                'Sample pricing does not apply' => "null",
                'Usage'                         => "null",
                'Style'                         => "null",
                'Category'                      => "null",
                'Location'                      => 'null',
                'Keywords'                      => "null",
                'Service Area'                  => "null",
                'Certifications'                => "null",
                'Height'                        => "null",
                'Width'                         => "null",
                'Depth/Proj'                    => "null",
                'Weight (lbs.)'                 => "null",
                'Weight (kg.)'                  => "null",
                'Dims Not Applicable'           => "null",
                'image URL 2'                   => "null",
                'Image Title 2'                 => "null",
                'image URL 3'                   => "null",
                'Image Title 3'                 => "null",
                'image URL 4'                   => "null",
                'Image Title 4'                 => "null",
                'image URL 5'                   => "null",
                'Image Title 5'                 => "null",
                'image URL 6'                   => "null",
                'Image Title 6'                 => "null",
                'image URL 7'                   => "null",
                'Image Title 7'                 => "null",
                'image URL 8'                   => "null",
                'Image Title 8'                 => "null",
                'image URL 9'                   => "null",
                'Image Title 9'                 => "null",
                'image URL 10'                  => "null",
                'Image Title 10'                => "null",
                'image URL 11'                  => "null",
                'Image Title 11'                => "null",
                'image URL 12'                  => "null",
                'Image Title 12'                => "null"
            ];
            // upload photo.
            if(is_array($data)){
                foreach ($data as $key => $value) {
                    $i_in = 1;
                    $hhh = "high";
                    foreach ($value as $key_1 => $value_1) {
                        if($i_in > 10){
                            $hhh  = "low";
                        }
                        $i_in ++;
                        if($value_1 != null && array_diff_key($value_1, $data_check_key) == null){
                            $token = uniqid ();
                            $data_logo = @$value_1['image URL 1'];
                            $path_info = pathinfo($data_logo);
                            $basename  = $path_info['basename'];
                            if($data_logo != null){
                                $basename = get_extension_url($data_logo);
                                try{
                                    $img = file_get_contents($data_logo,true);
                                } catch (Exception $e) {
                                    $img = false;
                                }
                                if($img){
                                    ini_set("log_errors", true);
                                    ini_set("error_log", "log/error.txt");
                                    $name = $token.$basename;
                                    $data_upload = $this->upload_file_from_url($img,$name); 
                                    $data_album = null;
                                    for ($i = 2; $i < 13; $i++) { 
                                        $album_photo = @$value_1['image URL '.$i.''];
                                        $album_title = @$value_1['Image Title '.$i.''];
                                        if(@$album_photo != null && @$album_title != null){
                                            try{
                                                $img = @file_get_contents($album_photo,true);
                                            } catch (Exception $e) {
                                                $img = false;
                                            }
                                            if($img){
                                                $basename = get_extension_url($value_1['image URL '.$i.'']);
                                                $name = uniqid().'_'.gen_slug_st($album_title).$basename;
                                                $data_reponse = $this->upload_file_from_url($img,$name); 
                                                if($data_reponse["status"] == "success"){
                                                    $data_album [] = array(
                                                        "title" => $album_title,
                                                        "path"  => $data_reponse["response"]["Path"],
                                                        "thumb" => $data_reponse ["response"]["Thumb"]
                                                    );
                                                }                       
                                            }   
                                        }  
                                    }
                                    ini_set("log_errors", false);
                                    $data_album = json_encode($data_album);
                                    if(@$data_upload["status"] == "success"){
                                        $arg_insert = [
                                            "path_file"        => @$data_upload["response"]["Path"],
                                            "name"             => @$value_1['Image Title'],
                                            "number_item"      => @$value_1['Item Number'],
                                            "description"      => @$value_1['Image Description'],
                                            "thumb"            => @$data_upload["response"]["Thumb"],
                                            "photo_credit"     => @$value_1['Photographer'],
                                            "image_category"   => @$value_1['Image Type'],
                                            "offer_product"    => @$value_1['Service type'],
                                            "unit_price"       => @$value_1['Single Unit Price'],
                                            "maximum_price"    => @$value_1['Maximum Units at this price'],
                                            "sample_pricing"   => @$value_1['Sample pricing does not apply'],
                                            "manufacture"      => @$manufacturers,
                                            "created_at"       => date('Y-m-d H:i:s'),
                                            "priority_display" => @$hhh,
                                            "type"             => "2",
                                            "member_id"        => @$this->user_id,
                                            "album"            => $data_album,
                                            "width"            => addslashes (@$value_1['Width']),
                                            "height"           => addslashes (@$value_1['Height']),
                                            "weight_lbs"       => addslashes (@$value_1['Weight (lbs.)']),
                                            "weight_kg"        => addslashes (@$value_1['Weight (kg.)']),
                                            "depth_proj"       => addslashes (@$value_1['Depth/Proj'])
                                        ];
                                        $id = $this->Common_model->add("photos",$arg_insert);
                                        if(@$id != null){
                                            $arg_image_for_id = "346";
                                            $arg_image_for = [
                                                "Indoor" => "1",
                                                "Outdoor" =>"2",
                                                "Both" => "0"
                                            ];
                                            $arg_service = ["Locally" => "260","Nationally"=>"259","Internationally" => "262"];
                                            $style_id = "3";
                                            $category_id = "9";
                                            $location_id ="215";
                                            $service_id = "258";
                                            $certifications_id = "263";
                                            $image_for = @$value_1["Usage"];
                                            $location_set_cat = @$arg_image_for[$image_for];
                                            $style = @$value_1['Style'];
                                            $category = @$value_1['Category'];
                                            $location = @$value_1['Location'];
                                            $service = @$value_1['Service Area'];
                                            $certifications = @$value_1['Certifications'];
                                            $arg_insert_bac = [];
                                            if(@$category != ""){
                                                $category = array_diff(array_map('trim',explode(",", $category)),array(""));
                                                $category = array_unique($category);
                                                if($category != null && is_array($category)){
                                                    foreach ($category as $key_cat => $value_cat ) {
                                                        $check_cat = $this->Common_model->get_record("categories",["parents_id" => $category_id,"title" => $value_cat]);
                                                        if($check_cat == null){
                                                            $id_insert =  $this->Common_model->add("categories",
                                                                [
                                                                    "pid" => $category_id ,
                                                                    "parents_id" => $category_id ,
                                                                    "title" => $value_cat,
                                                                    "slug"  => $this->gen_slug($value_cat)
                                                                ]
                                                            );
                                                        }else{
                                                            $id_insert = $check_cat["id"];
                                                        }

                                                        $arg_insert_bac [] = [
                                                            "category_id" => $id_insert,
                                                            "photo_id" => $id,
                                                            "first_child_category" => $category_id,
                                                            "location" => $location_set_cat
                                                        ];
                                                    }
                                                }
                                            }
                                            if(@$style != ""){
                                                $style = array_diff(array_map('trim',explode(",", $style)),array(""));
                                                $style = array_unique($style);
                                                if($style != null && is_array($style) ){
                                                    foreach ($style as $key_cat => $value_cat) {
                                                        $check_cat = $this->Common_model->get_record("categories",["parents_id" => $style_id,"title" => $value_cat]);
                                                        if($check_cat == null){
                                                            $id_insert =  $this->Common_model->add("categories",
                                                                [
                                                                    "pid" => $style_id ,
                                                                    "parents_id" => $style_id ,
                                                                    "title" => $value_cat,
                                                                    "slug"  => $this->gen_slug($value_cat)
                                                                ]
                                                            );
                                                        }else{
                                                            $id_insert = $check_cat["id"];
                                                        }     
                                                        $arg_insert_bac [] = [
                                                            "category_id" => $id_insert,
                                                            "photo_id" => $id,
                                                            "first_child_category" => $style_id,
                                                            "location" => $location_set_cat
                                                        ];
                                                    }
                                                }
                                            }
                                            if(@$location != ""){
                                                $location = array_diff(array_map('trim',explode(",", $location)),array(""));
                                                $location = array_unique($location);
                                                if($location != null && is_array($location) ){
                                                    foreach ($location as $key_cat => $value_cat) {
                                                        $check_cat = $this->Common_model->get_record("categories",["parents_id" => $location_id,"title" => $value_cat]);
                                                        if($check_cat == null){
                                                            $id_insert =  $this->Common_model->add("categories",
                                                                [
                                                                    "pid" => $location_id ,
                                                                    "parents_id" => $location_id ,
                                                                    "title" => $value_cat,
                                                                    "slug"  => $this->gen_slug($value_cat)
                                                                ]
                                                            );
                                                        }else{
                                                            $id_insert = $check_cat["id"];
                                                        }
                                                        $arg_insert_bac [] = [
                                                            "category_id" => $id_insert,
                                                            "photo_id" => $id,
                                                            "first_child_category" => $location_id,
                                                            "location" => $location_set_cat
                                                        ];
                                                    }
                                                }
                                            }
                                            if(@$service != ""){
                                                $id_insert = $arg_service[$service];
                                                $arg_insert_bac [] = [
                                                    "category_id" => $id_insert,
                                                    "photo_id" => $id,
                                                    "first_child_category" => $service_id,
                                                    "location" => $location_set_cat
                                                ];
                                            }
                                            if(@$certifications != ""){
                                                $certifications = array_diff(array_map('trim',explode(",", $certifications)),array(""));
                                                $certifications = array_unique($certifications);
                                                if($certifications != null && is_array($certifications) ){
                                                    foreach ($certifications as $key_cat => $value_cat) {
                                                        $check_cat = $this->Common_model->get_record("categories",["parents_id" => $certifications_id,"title" => $value_cat]);
                                                        if($check_cat == null){
                                                            $id_insert =  $this->Common_model->add("categories",
                                                                [
                                                                    "pid" => $certifications_id ,
                                                                    "parents_id" => $certifications_id ,
                                                                    "title" => $value_cat,
                                                                    "slug"  => $this->gen_slug($value_cat)
                                                                ]
                                                            );
                                                        }else{
                                                            $id_insert = $check_cat["id"];
                                                        }
                                                        $arg_insert_bac [] = [
                                                            "category_id" => $id_insert,
                                                            "photo_id" => $id,
                                                            "first_child_category" => $certifications_id,
                                                            "location" => $location_set_cat
                                                        ];
                                                    }
                                                }
                                            }
                                            if($location_set_cat != null){
                                                if($location_set_cat == "0"){
                                                    $arg_insert_bac [] = [
                                                        "category_id" => 1,
                                                        "photo_id" => $id,
                                                        "first_child_category" => "346",
                                                        "location" => $location_set_cat
                                                    ];
                                                    $arg_insert_bac [] = [
                                                        "category_id" => 2,
                                                        "photo_id" => $id,
                                                        "first_child_category" => "346",
                                                        "location" => $location_set_cat
                                                    ];
                                                }else{
                                                    $arg_insert_bac [] = [
                                                        "category_id" => $location_set_cat,
                                                        "photo_id" => $id,
                                                        "first_child_category" => "346",
                                                        "location" => $location_set_cat
                                                    ];
                                                }   
                                            } 
                                            $this->Common_model->insert_batch_data("photo_category",$arg_insert_bac);
                                            $kw = @$value_1["Keywords"];
                                            $text_kw = "";
                                            if(@$kw != ""){
                                                $kw = array_diff(array_map('trim',explode(",", $kw)),array(""));
                                                $kw = array_unique($kw);
                                                if($kw && $kw != null && is_array($kw)){
                                                    $text_kw = implode(",", $kw);
                                                    $kw_bac = [];
                                                    foreach ($kw as $key_2 => $value_2) {
                                                        $check_kw = $this->Common_model->get_record("keywords",["title" => $value_2,"type" => "photo"]);
                                                        if( $check_kw == null){
                                                            $id_kw = $this->Common_model->add("keywords",["title" => $value_2,"type" => "photo"]);
                                                        }else{
                                                            $id_kw = $check_kw["keyword_id"];
                                                        }
                                                        $kw_bac[] = [
                                                            "keyword_id" => $id_kw,
                                                            "photo_id" => $id
                                                        ];
                                                    }
                                                    $this->Common_model->insert_batch_data("photo_keyword",$kw_bac);
                                                }
                                            } 
                                            $this->Common_model->update("photos",["keywords" => $text_kw,"update_done" => "1"],["photo_id" =>  $id]);   
                                            $this->db->select("kw.category_id");
                                            $this->db->from("photo_category AS kw");
                                            $this->db->group_by("kw.category_id");
                                            $this->db->where("photo_id",$id);
                                            $get_record_kw = $this->db->get()->result_array();
                                            $data_kw_new = [];
                                            if($get_record_kw != null){
                                                foreach ($get_record_kw as $key => $value_1) {
                                                    $data_kw_new [] = $value_1["category_id"];
                                                }
                                            }
                                            if($data_kw_new != null){
                                                $data_kw_new = implode("/",$data_kw_new);   
                                                $data_kw_new="/".$data_kw_new."/";
                                            }else{
                                                $data_kw_new = "";
                                            }
                                            $this->Common_model->update("photos",["category" => $data_kw_new,"update_category_done" => "1"],["photo_id" =>  $id]);
                                        } 
                                    }                     
                                }     
                            }
                            
                        }
                    }
                }
            }
            $data_return =  array( 'status' => 'success' );
            exec('aws s3 sync  /dw_source/dezignwall/uploads/member/' .  $this->user_id . '/ s3://dwsource/dezignwall/uploads/member/' .  $this->user_id . '/ --acl public-read --cache-control max-age=86400,public --expires 2034-01-01T00:00:00Z'); 
        }
        die(json_encode($data_return));
    }
    public function get_photo_same_catalog(){
        $data = array( 'status' => 'error' );
        if($this->input->is_ajax_request() && $this->is_login && $this->input->post()){
            $photo_id   =  $this->input->post("photo_id");
            $data_photo = $this->Common_model->get_record("photos",array("photo_id" => $photo_id,"member_id" => $this->user_id));
            if($data_photo){
                $list_photo = $this->Common_model->get_result("photos",array("manufacture" => @$data_photo["manufacture"],"member_id" => $this->user_id,"photo_id != " =>  $photo_id));
                $data["list_photo"] = $list_photo;
                $data["status"]     = "success";
            }
        }
        die(json_encode($data));
    }
    public function delete_image_discontinued(){
        $data = array( 'status' => 'error' );
        if($this->input->is_ajax_request() && $this->is_login && $this->input->post()){
            $month      = $this->input->post("month");
            $photo_sam  = $this->input->post("photo_sam");
            $type       = $this->input->post("type");
            $photo_id   = $this->input->post("photo_id"); 
            $photo_data = "";
            if($type == "2"){
                if($photo_sam){
                    $photo_sam  = array_diff(explode(",", $photo_sam),array(""));
                    $photo_data = $this->Common_model->get_result_in("photos","photo_id",$photo_sam);
                    $data_add = array();
                    foreach ( $photo_data as $key => $value) {
                        if($value["photo_id"] != $photo_id){
                            $data_add[] = $value;
                        }
                    }
                    $photo_data =(json_encode($data_add));
                }            
            }
            $date =  date('Y-m-d', strtotime("+".$month." months"));
            $this->Common_model->add("photo_bin",array(
                "photo_id" => $photo_id ,
                "datime_remove" => $date,
                "data_status" => $type,
            ));
            $this->Common_model->update("photos",array("status_photo" => @$type,"same_photo" => @$photo_data),array("photo_id" => @$photo_id,"member_id" => $this->user_id));
            $data = array( 'status' => 'success' );
        }
        die(json_encode($data));
    }
    private function upload_file_from_url($content = null,$name = null){
        $data = array("status" => "error","message" => null,"reponse" => null);
        try{
            if($content != null && $name != null){
                $path = FCPATH . 'uploads/member/';
                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE);
                }
                $path =  FCPATH . 'uploads/member/' . $this->user_id . '/';
                if (!is_dir($path)) {
                    mkdir($path, 0777, TRUE);
                }
                $file = $path.$name;
                if(file_put_contents($file,$content)){
                    $this->load->library('image_lib');
                    $size = getimagesize($file);
                    $w_current = $size[0];
                    $h_current = $size[1];
                    if ($w_current > 1020) {
                        $config['source_image'] = $file;
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 1020;
                        $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                        $config['height'] = $size_ratio['height'];
                        $config['quality'] = 100;
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                    }
                    $config['source_image'] = $file;
                    $config['new_image'] = $path . "thumbs_".$name;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 400;
                    $size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
                    $config['height'] = $size_ratio['height'];
                    $config['quality'] = 100;
                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $photo   = '/uploads/member/' .  $this->user_id . '/' . $name;
                    $thumb   = '/uploads/member/' .  $this->user_id . '/thumbs_'. $name;
                    $response = array(
                        "Path"  => $photo,
                        "Thumb" => $thumb
                    );
                    $data["response"] = $response;
                    $data["status"]  = "success";
                }
            }
        } catch (Exception $e){
             $data ["message"] = $e->getMessage();
        }
        return $data;
    }
}