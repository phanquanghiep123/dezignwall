<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
        $this->data["head_not_seach"] = true;
        $this->data["is_login"] = $this->is_login;
        if ($this->is_login && !$this->session->userdata('user_sr_info')) {
            // Save to project member if exists
            if (isset($_GET['token']) && $_GET['token'] != null && isset($_GET['project_id']) && $_GET['project_id'] != null) {
                $record_product = $this->Common_model->get_record("project_invite", array(
                    "token" => $_GET['token']
                ));
                if (isset($record_product) && $record_product != null) {
                    if ($record_product['project_id'] == $_GET['project_id']) {
                        $this->Common_model->add("project_member", array(
                            'project_id' => $_GET['project_id'],
                            "member_id" => $this->user_id,
                            "type_role" => "member",
                            "join_date" => date('Y-m-d H:i:s')
                        ));
                        $this->Common_model->delete("project_invite", array(
                            "token" => $_GET['token']
                        ));
                    }
                }
            }
        }
    }
    public function index() {
        $this->data["is_home"]    = true;
        $this->data["title_page"] = "Home Page";
        $this->data["view_wrapper"] = "home/index";
        $this->data["class_page"] = "search-page";
        $this->load->model("Photo_model");
        $this->load->model("Comment_model");
        $recorder = $this->Photo_model->search_index($this->user_id, 30);
        $this->load->model('Article_model');
        $this->data["article"]  = array();
        $this->data["social_post"]  = array();
        $member_id = $this->user_id == null ? 0 : $this->user_id; 
        if($this->data["is_login"] && !$this->session->userdata('user_sr_info'))
            $this->data["article"] = $this->Article_model->get_article(0,2);          
        else
            $this->data["article"] = $this->Article_model->get_article(0,3);   
        $social_post = $this->Article_model->social_post(0,3,null,null,$member_id);
        $n_recorder  = array();
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
            $n_recorder = $recorder;
        }
        $this->data["photo_count"] = $this->Photo_model->total_page();
        $this->data["data_wrapper"]["photo_slider"] = $this->Photo_model->get_photo_slider_image_category("Project", "RANDOM", 10);
        $this->data["class_wrapper"] = "home_page";
        $this->data["is_home"] = "true";
        $this->load->view('block/header', $this->data);
        $this->data["data_wrapper"]["photo"] = $n_recorder;
        $this->load->view('block/wrapper', $this->data);
        $this->load->view('block/footer');
    }
    public function send_digital_card(){
        $data["success"] = "error";
        if ($this->input->is_ajax_request() && $this->is_login){
            $id = $this->input->post("id");
            $record = $this->Common_model->get_record("sales_rep",array("id" => $id));
            $get_member_sr = $this->Common_model->get_record("member_sale_rep",array("id" => $record["member_sale_id"]));
            if(empty($get_member_sr)){
                $data_insert = array(
                    "member_id" => $record["member_id"],
                    "email" => $record["contact_email"],
                    "pwd"  => "Admin123",
                    "created_at" => date('Y-m-d H:i:s')
                );
                $data_id_user = $this->Common_model->add('member_sale_rep',$data_insert);
                $data_update = array("member_sale_id" => $data_id_user);
                $this->Common_model->update("sales_rep",$data_update,array("id" => $id));
                $record = $this->Common_model->get_record("sales_rep",array("id" => $id));
            }
            
            if($record != null && $record["member_id"] == $this->user_id){
              $get_user =  $this->Common_model->get_record("member_sale_rep",array("id" => $record["member_sale_id"]));
              $mail_subject = ''.$this->user_info["full_name"].' of '.$this->user_info["company_name"].' invited you to claim your digital card';
              $mail_content = '
              <p>From: '.$this->user_info["full_name"].'</p>
              <p>'.$this->user_info["company_name"].' is going digital!</p><br>
              <p>We are using Dezignwall to go paperless, with digital business cards and catalogs. Not only will this save on printing cost and the environment, but we will also be able to gain valueable insights into client engagement with the products featured in our catalog.</p>
              <p>We have already set up most of your digital card. Now all you have to do is login, update your contact info and create a custom password.</p>
              <p>Your temporary user name and password is:</p>
                <p>User name: <a style="color:#37a7a7;">'.$get_user["email"].'</a></p>
                <p>Password: <span style="color:#37a7a7;">'.$get_user["pwd"].'</span></p><br>
              <p>Click here to claim your new digital card: <a href="'.base_url("?action=signin&reload=business/edit_rep_info").'" style="color:#fff;padding:5px 10px;background-color:#ff9900;">Claim my card</a></p><br>
              <p>Having trouble viewing the link? Copy and paste the URL to your browser:<br>
                    <a href="'.base_url("?action=signin&reload=business/edit_rep_info").'" style="color:#ff9900;">'.base_url("?action=signin&reload=business/edit_rep_info").'</a>
              </p><br><br>
              <p>Tip: So that you can easily access your digital card, simply bookmark your profile page in your browser on your smart phone and tablet.</p><br>
              <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
              <p>The bold new way to find and share commercial design inspiration.</p>
              <p style="margin:0">&nbsp;</p>
              <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';
              sendmail($record["contact_email"], $mail_subject, $mail_content);
              $data["success"] = "success";
            }
        }
        die(json_encode($data));
    }
    private function confirm_sales_reps($token){
        $check_token = $this->Common_model->get_record("sales_rep",array("token" =>trim($token),"is_confirm" => 0));
        if($check_token != null){
            $data_id = 0;
            $check_member = $this->Common_model->get_record("member_sale_rep",array("email" => $check_token["contact_email"]));
            $member_add = "";
            if($check_member == null){
                $password = $this->randomstring();
                $data_insert = array(
                    "member_id"     =>  $check_token["member_id"],
                    "email"         =>  $check_token["contact_email"],
                    "pwd"           =>  md5(strtolower($check_token["contact_email"]) . ":" . md5($password)),
                    "token"         =>  trim($token),
                    "created_at"    =>  date("Y-m-d H:i:s")
                );
                $data_id = $this->Common_model->add("member_sale_rep",$data_insert); 
                $member_add = '';
            }else{
                $data_id = $check_member["id"];
            }
            if($data_id > 0){   
                $data_update = array("is_confirm" => 1,"member_sale_id" => $data_id);
                $filter = array("id" => $check_token["id"]);
                $this->Common_model->update("sales_rep",$data_update,$filter);
                $mail_subject = ''.$this->user_info["full_name"].' of '.$this->user_info["company_name"].' invited you to claim your digital card';
                $mail_content = '
                  <p>From: '.$this->user_info["full_name"].'</p>
                  <p>'.$this->user_info["company_name"].' is going digital!</p><br>
                  <p>We are using Dezignwall to go paperless, with digital business cards and catalogs. Not only will this save on printing cost and the environment, but we will also be able to gain valueable insights into client engagement with the products featured in our catalog.</p>
                  <p>We have already set up most of your digital card. Now all you have to do is login, update your contact info and create a custom password.</p>
                  '.$member_add.'
                  <p>Click here to signin change your new digital card: <a href="'.base_url("?action=signin&reload=business/edit_rep_info").'" style="color:#fff;padding:5px 10px;background-color:#ff9900;">Claim my card</a></p><br>
                  <p>Having trouble viewing the link? Copy and paste the URL to your browser:<br>
                        <a href="'.base_url("?action=signin&reload=business/edit_rep_info").'" style="color:#ff9900;">'.base_url("?action=signin&reload=business/edit_rep_info").'</a>
                  </p><br><br>
                  <p>Tip: So that you can easily access your digital card, simply bookmark your profile page in your browser on your smart phone and tablet.</p><br>
                  <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
                  <p>The bold new way to find and share commercial design inspiration.</p>
                  <p style="margin:0">&nbsp;</p>
                  <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';
                sendmail($check_token["contact_email"], $mail_subject, $mail_content);
                redirect(base_url("?confirm_sales=success"));
            }
            
        }
        redirect(base_url());
    }
    public function share_your_profile(){
        if ($this->is_login || $this->session->userdata('user_sr_info')) {
            $user_id = $this->user_id;
            $company = $this->user_info["company_name"];
            $sql = "";
            $table = [];
            $type_share = "admin";
            $user_share = $user_id;
            if($this->is_login){
                $sql = "SELECT m.first_name,m.last_name,m.work_email AS email ,m.job_title,
                m.company_name,c.year_est,c.legal_status,c.no_of_employees,c.company_800_number AS toll_free,
                c.main_business_ph AS local_phone,c.contact_email,c.web_address,c.main_address,c.state,c.zip_code,
                c.city,c.country,c.business_type,c.service_area,c.business_description,c.license_contractor_no,c.cellphone FROM company AS c JOIN members AS m ON m.id=c.member_id WHERE c.member_id = {$user_id} LIMIT 1";
            }
            if($this->session->userdata('user_sr_info')){
                $user_info  = $this->session->userdata('user_sr_info');
                $user_id    = $user_info["member_id"];
                $user_share = $user_info["member_id"];
                $company  = $user_info["full_name"];
                $sql = "SELECT c.first_name,c.last_name,c.job_title,c.company_name,c.number_800 AS toll_free,c.main_business_ph AS local_phone,c.cellphone AS cell_phone ,c.contact_email ,c.web_address ,c.main_address,c.state,c.city,c.zip_code,c.country,c.service_area,c.job_title FROM sales_rep AS c WHERE c.member_sale_id = {$user_id} LIMIT 1";
                $user_id  = $user_info["member_owner"];
                $type_share = "business";
            }
            $fromFullname = $this->input->post('name'); // $this->user_info['full_name'];
            $companyName =  $this->input->post('company_name'); // $this->user_info['company_name'];            
            $query = $this->db->query($sql);
            $table = $query->row_array();
            $table["company_name"] = $companyName;
            $attach = "";
            $csv = "";
            $attach_html ="";
            if(isset($_POST) && isset($_POST['email_tag'])){
                $mail_to = $this->input->post("email_tag");
                $arg_mail = explode(",", $mail_to);
                $new_arg_mail = [];
                foreach ($arg_mail  as $key => $value) {
                    $email_new = filter_var($value, FILTER_SANITIZE_EMAIL);
                    if ( !filter_var($email_new, FILTER_VALIDATE_EMAIL) === false ) {
                        $new_arg_mail[] = $email_new;
                    }
                }
                if($new_arg_mail != null && sizeof($new_arg_mail) > 0){
                    if(isset($_FILES["attach"]) && $_FILES["attach"]["error"] == 0){
                        $name = explode(".", $_FILES["attach"]["name"]);
                        $upload_path = FCPATH.'uploads/member/'.$user_id.'/';
                        if (!is_dir($upload_path)) {
                            mkdir($upload_path, 0755, TRUE);
                        }
                        $config['upload_path'] = $upload_path;
                        $config['allowed_types'] = 'text/plain|text/csv|csv|zip|png|jpg';
                        $config['max_size'] = (10*1024); // Byte
                        $config['file_name'] = $this->gen_slug($name[0] .'-'. time());
                        $this->load->library('upload', $config);
                        if($this->upload->do_upload("attach")){
                            $attach = 'uploads/member/'.$user_id.'/'.$config['file_name'].'.'.$name[count($name) - 1];
                            $attach_html = '<p>Click here to Download their Attach file: <a href="'.base_url($attach).'" style="background:#ff9900;color:#fff;display:inline-block;padding:5px 10px" download >Download Attach file</a></p>';       
                        }
                    }
                    $csv_file = $this->csv_demo($user_id,$company,$table); 
                    $csv = '<p>Click here to Download their V-Card file: <a href="'.base_url($csv_file).'" style="background:#ff9900;color:#fff;display:inline-block;padding:5px 10px" download >Download V-Card</a></p>
                                <p>Having trouble viewing the V-Card link? Copy and paste the URL to browser:</p>
                                <p style ="color:#ff9900">'.base_url($csv_file).'</p>';
                    $table_user = $this->Common_model->get_record("members",array("id" => $user_id));
                    $logo = ($table_user['avatar'] != ""&&file_exists(FCPATH . $table_user['avatar'])) ? $table_user['avatar'] : "skins/images/logo-company.png";
                    $banner = ($table_user['banner'] != "" && file_exists(FCPATH . $table_user['banner'])) ? $table_user['banner'] : "skins/images/banner-default.png";
                    $message_sent = $this->input->post("message_sent");
                    $mail_subject = $fromFullname . ' shared their Dezignwall Business card with you on, ' . date("m/d/Y");
                    $mail_content = '<p>&nbsp;</p>
                                <table>
                                    <tr>
                                        <td><img style="border-radius: 50%; max-width: 150px;" src ="'.base_url($logo ).'"></td>
                                        <td><img style = "max-width:517px" src ="'.base_url($banner ).'"></td>
                                    </tr>
                                </table>
                                <p>' . $fromFullname . ' from '. $companyName. ' says: ' . $message_sent . '</p>
                                <p>Click here to go to their business profile: <a href="'.base_url("profile/index/".$user_id).'" style="background:#ff9900;color:#fff;display:inline-block;padding:5px 10px" target="_blank">Go to Profile</a></p>
                                <p>Having trouble viewing the profile link? Copy and paste the URL to browser:</p>
                                <p style ="color:#ff9900">'.base_url("profile/index/".$user_id).'</p>
                                <br>
                                '.$csv.'
                                <br>
                                <br>
                                '.$attach_html.'
                                <br>
                                <br>
                                <br>
                                <br>
                                <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
                                <p>The bold new way to find and share commercial design inspiration.</p>
                                <p style="margin:0">&nbsp;</p>
                                <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';
                    $email_to =implode(",",$new_arg_mail);
                    sendmail($email_to, $mail_subject, $mail_content);
                    $data_insert = [];
                    $date = date('Y-m-d h:i:s a', time());
                    if(!empty($new_arg_mail)){
                        foreach ($new_arg_mail as $key => $value) {
                            $data_insert [] = array(
                                "member_id"   => $user_share,
                                "email_sent"  => $value,
                                "type_member" => $type_share,
                                "created_at"    => $date
                            );
                        }
                        if(!empty($data_insert)){
                            $this->Common_model->insert_batch_data("share_contacts",$data_insert);
                        }
                    }
                    
                    // Save contact list for this profile
                    if($this->input->post("save_multiple") && $this->input->post("save_multiple") == "save"){
                        foreach ($new_arg_mail  as $email_item) {
                            if ($this->Common_model->get_record("contact_list",array("member_id" => $this->user_id, 'email' => $email_item)) == null) {
                                $this->Common_model->add("contact_list",array('member_id' => $this->user_id, 'email' => $email_item, 'created_at' => date('Y-m-d H:i:s')));    
                            }    
                        }
                    }
                    
                    if($this->session->userdata('user_sr_info')){
                        redirect(base_url("business/view_profile?share_profile=success"));
                    }
                    redirect(base_url("profile/edit?share_profile=success"));
                }else{
                    if($this->session->userdata('user_sr_info')){
                        redirect(base_url("business/view_profile?share_profile=error"));
                    }
                    redirect(base_url("profile/edit?share_profile=error"));
                }

            }       
        }
    }
    private function csv_demo($user_id,$company,$table){
            $csv = "BEGIN:VCARD\r\n";
            $csv .="VERSION:3.0\r\n";
            $csv .="N:".@$table['last_name'].";".$table['first_name'].";;;\r\n";
            $csv .="FN:".@$table['first_name']." ".$table['last_name']."\r\n";
            $csv .="ORG:".@$table['company_name'].";\r\n";
            $csv .="TITLE:".@$table['job_title']."\r\n";
            $csv .="EMAIL;type=INTERNET;type=WORK;type=pref:".@$table['contact_email']."\r\n";
            $csv .="TEL;type=WORK:".@$table['toll_free']."\r\n";
            $csv .="TEL;type=CELL:".@$table['cellphone']."\r\n";
            $csv .="TEL;type=HOME:".@$table['local_phone']."\r\n";
            $csv .="item1.ADR;type=WORK:;;".@$table['main_address'].";".@$table['city'].";".@$table['state'].";".@$table['zip_code'].";".@$table['country']."\r\n";
            $csv .="item1.X-ABADR:us\r\n";
            $csv .="item2.ADR;type=HOME;type=pref:;;".@$table['main_address'].";".@$table['city'].";".@$table['state'].";".@$table['zip_code'].";".@$table['country']."\r\n";
            $csv .="item2.X-ABADR:us\r\n";
            $csv .="NOTE:".$table['service_area']."\r\n";
            $csv .="item3.URL;type=pref:".@$table['web_address']."\r\n";
            $csv .="item4.URL:".@$table['web_address']."\r\n";
            $csv .="item4.X-ABLabel:FOAF\r\n";
            $csv .="item5.X-ABRELATEDNAMES;type=pref:".@$table['first_name']." ".$table['first_name']."\r\n";
            $csv .="X-ABUID:5AD380FD-B2DE-4261-BA99-DE1D1DB52FBE\:ABPerson\r\n";
            $csv .="END:VCARD\r\n";
            $upload_path = FCPATH.'uploads/member/'.$user_id.'/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, TRUE);
            }
            $name_path = '/uploads/member/'.$user_id.'/'.$this->gen_slug($company).'.vcf';//'.csv';
            $upload_path = FCPATH.$name_path;
            $csv_handler = fopen ($upload_path,'w');
            fwrite ($csv_handler,trim($csv));
            fclose ($csv_handler);
            return $name_path;
    }
    public function error() {
        $arg_url = explode("/", uri_string());
        if ($arg_url[0] != "skins" && $arg_url[0] != "backend" && $arg_url[0] != "system" && $arg_url[0] != "uploads" && $arg_url[0] != "application") {
            $mail_to = 'noreply@dezignwall.com';
            $mail_subject = 'Error page for your website';
            $mail_content = '<p style="margin:0">&nbsp;</p>
                                <p>Your website has an error on this page:<br/>URL:' . base_url(uri_string()) . '</p>
                                <p style="margin:0">&nbsp;</p>
                                <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
                                <p>The bold new way to find and share commercial design inspiration.</p>
                                <p style="margin:0">&nbsp;</p>
                                <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';

            // Send mail
            sendmail($mail_to, $mail_subject, $mail_content);
        }
        $this->data["title_page"] = "404 page";
        $this->data["responsetracking"] = "Error";
        $this->data["responsemessage"] = "Oops... ". uri_string() ." ... Don't worry, we're on it!";
        //$_h =  $this->load->view("include/datatracking",$data);
        redirect(base_url("?error=404&url=" . uri_string() . ""));
    }
    public function get_project() {
        if ($this->input->is_ajax_request()) {
            $project_id = $this->input->post('project_id');
            $this->load->database();
            $this->load->model('Project_model');
            $data['project'] = $this->Project_model->get_project_id($this->user_id);
            echo json_encode($data['project']);
        } else {
            echo json_encode(array(
                "status" => "error"
            ));
        }
    }

    public function send_mail_flag() {
        if ($this->input->is_ajax_request() && $this->is_login == true) {
            $message_content = $this->input->post('message');
            $photo_id = $this->input->post('id');
            $title = $this->input->post('title');
            $object_reporting = $this->input->post('object_reporting');
            $from_fullname = '';
            $this->load->library('email');
            $this->email->set_mailtype("html");
            $recorder = $this->Common_model->get_record("photos", array(
                "photo_id" => $photo_id
            ));
            $name_sent = "Photo";
            if (!empty($this->user_info) || trim($this->user_info['full_name']) != "") {
                $from_email = $this->user_info['email'];
                $from_fullname = $this->user_info['full_name'];
                $this->email->from($from_email, '');
            }

            if ($object_reporting == "member") {
                $name_sent = "Profile";
                $url_photo = base_url("profile/index/" . $photo_id);
            } else {
                $url_photo = base_url("photos/" . $recorder["photo_id"] . "/" . gen_slug($recorder["name"]));
            }

            $mail_to = 'phanquanghiep123@gmail.com';
            $mail_subject = 'Flagged image - ' . $title;
            $mail_content = '<p style="margin:0">&nbsp;</p>
                            <p>' . $from_fullname . ' have commented at ' . date("Y:m:d h:i:sa") . ': <br /><br />' . $message_content . '<br /><br />URL ' . $name_sent . ': <a href ="' . $url_photo . '">' . $url_photo . '<a></p>
                            <p style="margin:0">&nbsp;</p>
                            <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
                            <p>The bold new way to find and share commercial design inspiration.</p>
                            <p style="margin:0">&nbsp;</p>
                            <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';

            // Send mail
            sendmail($mail_to, $mail_subject, $mail_content);
            die("success");
        } else {
            die("error");
        }
    }

    public function sendmail() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('session');
            $user_info = $this->session->userdata('user_info');
            $subject = $this->input->post('subject');
            $email = $this->input->post('email');
            $photo_id = $this->input->post('photo_id');
            $url = $this->input->post('url');
            $table = "photos";
            $filter = array(
                "photo_id" => $photo_id
            );
            $record_photo = $this->Common_model->get_record($table, $filter);
            if(@$url == null || @$url == ""){
                $url = base_url("photos/" . $record_photo['photo_id'] . "/" . gen_slug($record_photo["name"])); 
            }
            $photo = $record_photo["path_file"];
            $img = ($record_photo["name"] != "") ? $record_photo["name"] : "Image name";
            $slug = strtolower(str_replace(" ", "-", $img));
            $link = $url;
            $type = $this->input->post("type_sent_mail");
            $goto = "Go to Photo";
            $name_share = "photo";
            $fromFullname = 'Your friend';
            $tip = "You can find, share and collaborate with coworkers and colleagues around the images you find on Dezignwall. Find something you like? Share it through social media and directly through email! Enjoy your searches!";
            if (!empty($user_info) || trim($user_info['full_name']) != "") {
                $fromEmail = $user_info['email'];
                $fromFullname = $user_info['full_name'];
                $first_name = $user_info["first_name"];
                $last_name = $user_info["last_name"];
            }
            $click = "Click here to view the image " . $first_name . " is sharing";
            if ($type == "company") {
                $tip = "All project and product images on Dezignwall, are linked to a company profile so that you can always find contact information from the company posting the image. ";
                $link = base_url("profile/index/" . $photo_id);
                $img = $this->input->post("company_name");
                $filter = array("id" => $photo_id);
                $get_profile = $this->Common_model->get_record("members", $filter);
                $photo = $get_profile["banner"];
                $goto = "Go to Profile";
                $name_share = $get_profile["company_name"] . "'s profile page";
                $click = "Click here to view " . $get_profile["company_name"] . "'s profile page " . $first_name . " is sharing";
            }
            $photo_text ="";
            if($photo !== null ){
                $photo_text = '<img src="' . base_url($photo) . '" width="200px" />';
            }
            $message_sent = $this->input->post('message');
            $mail_to = $email;
            $mail_subject = $fromFullname . ' shared a ' . $name_share . ' with you on Dezignwall - ' . date("m/d/Y");
            $mail_content = '<p>&nbsp;</p>
                            <p>' . $fromFullname . ' says: ' . $message_sent . '</p>
                            '.$photo_text.'
                            <p>' . $click . ' <a href="' . $link . '" style="background:#ff9900;color:#FFF;display:inline-block;padding: 5px 10px;">' . $goto . '</a></p>
                        <p>Having trouble viewing the link? Copy and pass the URL to browser:<br>
                        ' . $link . '
                        </p>
                            <br><br>
                            <p style="color: #737373;font-style: italic;">Tip: ' . $tip . '</p>
                            <br><br>
                            <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
                            <p>The bold new way to find and share commercial design inspiration.</p>
                            <p style="margin:0">&nbsp;</p>
                            <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';

            // Send mail
            sendmail($mail_to, $mail_subject, $mail_content);
            die("success");
        } else {
            die("error");
        }
    }

    public function sent_reports(){
        if($this->is_login && $this->input->is_ajax_request()){
            $subject = $this->input->post('subject');
            $email = $this->input->post('email');
            $message_sent = $this->input->post('message');
            if (!empty($this->user_info) || trim($this->user_info['full_name']) != "") {
                $fromEmail = $this->user_info['email'];
                $fromFullname = $this->user_info['full_name'];
                $first_name = $this->user_info["first_name"];
                $last_name = $this->user_info["last_name"];
            }
            $tip = "You can find, share and collaborate with coworkers and colleagues around the images you find on Dezignwall. Find something you like? Share it through social media and directly through email! Enjoy your searches!";
            $mail_subject = $fromFullname . ' sent a email with you on Dezignwall - ' . date("m/d/Y");
            $mail_content = '<p>&nbsp;</p>
                            <p>' . $fromFullname . ' says: ' . $message_sent . '</p>
                        
                            <br><br>
                            <p style="color: #737373;font-style: italic;">Tip: ' . $tip . '</p>
                            <br><br>
                            <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
                            <p>The bold new way to find and share commercial design inspiration.</p>
                            <p style="margin:0">&nbsp;</p>
                            <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';
            sendmail($email, $mail_subject, $mail_content);
            die("success");
        }else {
            die("error");
        }
    }

    public function sendmail_auto_renewal() {
        $from_date = date('Y-m-d',strtotime("-7 days"));
        $to_date = date('Y-m-d');
        $this->load->model("Members_model");
        $collection = $this->Members_model->get_list_member_upgrade($from_date, $to_date);
        if ($collection != null && count($collection) > 0) {
            $mail_subject = 'Your Dezignwall Business Profile Upgrade is set to expire in 7 days';
            foreach ($collection as $item) {
                $mail_to = $item['email'];
                $mail_content = '<p>Hi ' . $item['first_name'] . '!</p>
                                    <p>We hope you’ve benefited from your Dezignwall upgraded profile. As a special thank you,
                                    we’d like to extend your fraa upgrade for ' . $item['month'] . ' more months.</p>
                                    <p>Simply enter your new promotion code: <a href="' . site_url('payment/upgrade') . '" style="text-decoration:none;background:#ff9900;color:#FFF;display:inline-block;padding: 5px 10px;">' . $item['code'] . '</a></p>
                                    <p>Having trouble viewing the link? Copy and paste the URL to browser: <br/>
                                    ' . site_url('payment/upgrade') . ' </p><br/>
                                    <p style="color: #737373;font-style: italic;">Tip: You can find, share and collaborate with coworkers and colleagues arounsd the images
                                    find on Dezignwall. Find something you like? Share it through social media and directly
                                    through email! Enjoy your searches!</p>
                                    <br><br>
                                    <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
                                    <p>The bold new way to find and share commercial design inspiration.</p>
                                    <p style="margin:0">&nbsp;</p>
                                    <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>
                                    ';
                sendmail($mail_to, $mail_subject, $mail_content);
            }
        }
    }

    public function tracking_share(){
        if($this->input->is_ajax_request()){
            $type = $this->input->post("type");
            $type_post = $this->input->post("type_post");
            $id_post = $this->input->post("id_post");
            $data_post = $this->input->post();
            $data_post["member"] = $this->user_id;
            $ip = "";
            $arg_type = ["email","linkedin","twitter","facebook"];
            $arg_type_post = ['photo','profile','blog'];
            if(in_array($type,$arg_type) && in_array($type_post,$arg_type_post)){
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                $data_post["ip"] = $ip;
                $owner_member_id = 0;
                $table = "";
                $record_post = null;
                $new_share = "/".implode(",", $data_post)."/";
                $this->load->helper('cookie');
                $oldshare  = get_cookie("oldshare");
                //if(strpos($oldshare,$new_share) === false){
                    switch ($type_post) {
                        case 'profile':
                            $record_post = $this->Common_model->get_record("members",array("id" => $id_post));
                            $owner_member_id = $record_post["id"];
                            break;
                        case 'blog':
                            $record_post = $this->Common_model->get_record("article",array("id" => $id_post));
                            $owner_member_id = $record_post["member_id"];
                            break;
                        default:
                            $record_post = $this->Common_model->get_record("photos",array("photo_id" => $id_post));
                            $owner_member_id = $record_post["member_id"];
                            break;
                    }
                    switch ($type) {
                        case 'email':
                            $colum_date = "createdat_email";
                            break;
                        case 'linkedin':
                            $colum_date = "createdat_linkedin";
                            break;
                        case 'twitter':
                            $colum_date = "createdat_twitter";
                            break;
                        default:
                            $colum_date = " createdat_facebook";
                            break;
                    }
                    if($record_post != null){
                        $data_insert = array(
                            "reference_id" => $id_post,
                            "member_id" => $this->user_id,
                            "member_owner" => $owner_member_id,
                            "type_object" => $type_post,
                            "type_share" => $type,
                            "type_share_view" => "share",
                            "ip" => $ip,
                            "created_at" => date("Y-m-d h:i:sa"),
                            $colum_date => date("Y-m-d h:i:sa"),
                        );
                        $id_insert = $this->Common_model->add("common_view",$data_insert);
                        if($id_insert){
                            if($oldshare){
                                delete_cookie("oldshare");
                                $new_share.= $oldshare;
                            }
                            set_cookie("oldshare",$new_share,time()+1440);
                        }
                    }    
            //}
            }
        }else{
            redirect(base_url());
        }
    }

    private function randomstring(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring .= $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }
    private function gen_slug($str){
        $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
        $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
    }
    public function createmapxml(){
        error_reporting(E_ERROR | E_PARSE);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '256M');
        include(FCPATH . '/application/libraries/dom_html/simple_html_dom.php');
        $domain = base_url();
        $today  = date("Y-m-d");
        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $xml .= "\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        $xml .= "\n<url>
                    \n<loc>$domain</loc>
                    \n<priority>1.0</priority>
                    \n<changefreq>hourly</changefreq>
                    \n<lastmod>$today</lastmod>
                \n</url>";
        $html = file_get_html(base_url());
        $arrayUrlold = array("","javascript:;","#",base_url());
        $index_look = 1;
        $arrayPage_1 = array("","#","javascript:;");
        $arrayPage_2 = array("","#","javascript:;");
        $arrayPage_3 = array("","#","javascript:;");
        if($html != false){
            foreach ( $html->find('a') as $element ) {
                if(!in_array($element->href,$arrayUrlold) && strpos($element->href,base_url()) !== false && strpos($element->href,".png") === false && strpos($element->href,".jpg") === false){
                    $url  = $element->href;
                    $xml .= "\n<url>
                                \n<loc>$url</loc>
                                \n<priority>0.8</priority>
                                \n<changefreq>daily</changefreq>
                                \n<lastmod>$today</lastmod>
                            \n</url>";
                    $arrayUrlold[] = $element->href;
                    try {
                        $html_1 = file_get_html(str_replace(" ","%20", $element->href));
                    } catch (Exception $e) {
                        $html_1 = false;
                    } 
                    if($html_1 != false){ 
                        foreach ($html_1->find('a') as $element_1) {
                            if(!in_array($element_1->href,$arrayUrlold) && strpos($element_1->href,base_url()) !== false && strpos($element_1->href,".png") === false && strpos($element_1->href,".jpg") === false){
                                $arrayPage_1[] = $element_1->href;
                                $arrayUrlold[] = $element_1->href;
                                try {
                                    $html_2 = file_get_html(str_replace(" ","%20", $element_1->href));
                                } catch (Exception $e) {
                                    $html_2 = false;
                                }   
                                if($html_2 != false){
                                    foreach ($html_2->find('a') as $element_2) {
                                        if( !in_array($element_2->href,$arrayUrlold) && strpos($element_2->href,base_url()) !== false && strpos($element_2->href,".png") === false && strpos($element_2->href,".jpg") === false){
                                            $arrayUrlold[] = $element_2->href;
                                            $arrayPage_2[] = $element_2->href; 
                                            try {
                                                $html_3 = file_get_html(str_replace(" ","%20", $element_2->href));
                                            } catch (Exception $e) {
                                                $html_3 =false;
                                            }
                                            if($html_3 != false){
                                                foreach ($html_3->find('a') as $element_3) {
                                                    if( !in_array($element_3->href,$arrayUrlold) && strpos($element_3->href,base_url()) !== false && strpos($element_3->href,".png") === false && strpos($element_3->href,".jpg") === false){   
                                                        $arrayUrlold[] = $element_3->href;
                                                        $arrayPage_3[] = $element_3->href;
                                                        try {
                                                            $html_4 = file_get_html(str_replace(" ","%20", $element_3->href));
                                                        } catch (Exception $e) {
                                                            $html_4 =false;
                                                        }
                                                        if($html_4 != false){
                                                            foreach ($html_4->find('a') as $element_4) {
                                                                if( !in_array($element_4->href,$arrayUrlold) && strpos($element_4->href,base_url()) !== false ){   
                                                                    $arrayUrlold[] = $element_4->href;
                                                                    $arrayPage_3[] = $element_4->href;   
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
                        }   
                    }
                }   
            }
            
            if($arrayPage_1){
                foreach ( $arrayPage_1 as $element ) {
                    if(!in_array($element, array("","#","javascript:;"))){
                        $url = $element;
                        $xml .= "\n<url>
                                    \n<loc>$url</loc>
                                    \n<priority>0.7</priority>
                                    \n<changefreq>daily</changefreq>
                                    \n<lastmod>$today</lastmod>
                                \n</url>";
                    }
                }
            }
            if($arrayPage_2){
                foreach ( $arrayPage_2 as $element ) {
                    if(!in_array($element, array("","#","javascript:;"))){
                        $url = $element;
                        $xml .= "\n<url>
                                    \n<loc>$url</loc>
                                    \n<priority>0.6</priority>
                                    \n<changefreq>daily</changefreq>
                                    \n<lastmod>$today</lastmod>
                                \n</url>";
                    }
                }
            }
            if($arrayPage_3){
                foreach ( $arrayPage_3 as $element ) {
                    if(!in_array($element, array("","#","javascript:;"))){
                        $url = $element;
                        $xml .= "\n<url>
                                    \n<loc>$url</loc>
                                    \n<priority>0.5</priority>
                                    \n<changefreq>daily</changefreq>
                                    \n<lastmod>$today</lastmod>
                                \n</url>";
                    }   
                }
            }
        }
        $xml .= "\n</urlset>";
        $file = FCPATH ."sitemap.xml";
        file_put_contents($file, $xml);
        header('Content-type: text/xml');
        echo $xml;
    }
    public function getlikes(){
        $data["status"] = "error";
        if($this->input->is_ajax_request()){
            $id = $this->input->post("dataID");
            $postType = $this->input->post("postType");
            $argTable = [
                "photo"  => "photos",
                "blog"   => "article",
                "social" => "social_posts"
            ];
            $key = "id"  ;
            if($argTable[$postType] == "photos") $key = "photo_id"; 
            $check  = $this->Common_model->get_record($argTable[$postType],[$key => $id]);
            if($check){
                $this->db->select('mb.*,cl.created_at,cl.id AS likeid');
                $this->db->from("".$argTable[$postType]." AS pt");
                $this->db->join("common_like AS cl","cl.reference_id = pt.".$key."");
                $this->db->join("members as mb","mb.id = cl.member_id");
                $this->db->where("cl.reference_id",$id);
                $this->db->where("cl.type_object",$postType);
                $this->db->where("cl.status",1);
                $list = $this->db->get();
                $data["result"] = $list->result_array(); 
                $data["status"] = "success";
            }  
        }
        echo(json_encode($data));
        return;
    }

    public function getcomments(){
        $data["status"] = "error";
        if($this->input->is_ajax_request()){
            $id = $this->input->post("dataID");
            $postType = $this->input->post("postType");
            $argTable = [
                "photo"  => "photos",
                "blog"   => "article",
                "social" => "social_posts"
            ];
            $key = "id" ;
            if($argTable[$postType] == "photos") $key = "photo_id"; 
            $check  = $this->Common_model->get_record($argTable[$postType],[$key => $id]);
            if($check){
                $this->db->select('mb.*,cl.created_at,cl.id AS likeid');
                $this->db->from("common_comment AS cl");
                $this->db->join("members as mb","mb.id = cl.member_id");
                $this->db->where("cl.reference_id",$id);
                $this->db->where(["cl.type_object" => $postType,"cl.pid" => 0]);
                $list = $this->db->get();
                $data["result"] = $list->result_array(); 
                $data["status"] = "success";
            }  
        }
        echo(json_encode($data));
        return;
    }
 
}
