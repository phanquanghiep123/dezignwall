<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Business extends CI_Controller {

    private $user_id = null;
    private $is_login = false;
    public $data = null;
    private $is_sale_rep = false;
    public function __construct() {

        parent::__construct();

        $this->data["view_profile"] = false;

        if ( $this->session->userdata('user_sr_info') ) {
            $this->user_info = $this->session->userdata('user_sr_info');
            if($this->user_info["type_member"] == "1"){
                $this->data["view_profile"] = true;
            }
            $this->is_login         = true;
            $this->data["is_login"] = true ;   
        }else{

            redirect(base_url());

        }

    }

    public function index() {

    }

    public function edit_rep_info() {

        $this->load->model("Sales_rep");

        $record = $this->Sales_rep->get_sales_rep_by_private_member($this->user_info["member_id"]);

        if($record != null){
            $this->data["sales_reps"] = $record;
            $this->data['user_id'] = $record[0]["member_id"];
            $this->data["type_member"] = $this->user_info["type_member"];
            $record_contact = $this->Common_model->get_record("sales_rep", array(
                'member_sale_id' => $this->user_info["member_id"]
            ));
            $record = $this->Common_model->get_record("members", array(

                'id' => $record[0]["member_id"]

            ));
            $record["main_business_ph"] = $record_contact["main_business_ph"];
            $record["web_address"] = $record_contact["web_address"];
            $record["first_name"] = $record_contact["first_name"];
            $record["last_name"] = $record_contact["last_name"];
            $record["job_title"] = $record_contact["job_title"];
            $record["contact_email"] = $record_contact["contact_email"];
            $record["cellphone"] = $record_contact["cellphone"];
            $this->data["company_info"] = $record;
            $this->data['not_edit'] = true;
            $this->data['member'] = $record;
            $this->data["title_page"] = "Edit sales reps private";
            $this->data['user_id'] = $this->user_info["member_id"];
        }
        $this->data["allow_edit"]= false; 
        
        $this->data["show_reports"] = true;

        $this->data["download_url"] = base_url("business/download_impormation");

        $this->load->view('block/header', $this->data);

        $this->load->view('business/edit_sales_reps', $this->data);

        $this->load->view('include/share-profile', $this->data);

        $this->load->view('block/footer', $this->data);

    }

    public function view_profile($id = null){

        if($id == null)

        $id = $this->user_info["member_id"];   

        $record_active = $this->Common_model->get_record("member_sale_rep",array("id" => $id ));

        $owner_id = $record_active["member_id"];

        $user_id  = $owner_id;

        $record = $this->Common_model->get_record("members", array(

            'id' => $user_id

        ));

        $this->data["data_id"] = $owner_id;

        $this->data["data_type"] ="company";

        $this->data["type_post"] = "profile";

        $this->data["id_post"]   = $owner_id;

        $this->data["is_blog"]   = $record["is_blog"];

        if($this->data["is_blog"] == "yes"){

            $this->load->model("Article_model");

            $this->data["article"] = $this->Article_model->get_public_by_member($user_id); 

        }

        $this->data["title_page"] = "Profile";

        $this->data['user_id'] = $user_id;

        if (!(isset($record) && $record != null)) {

            redirect(base_url());

        }

        $record_contact = $this->Common_model->get_record("sales_rep", array(

            'member_sale_id' => $id

        ));

        $record["first_name"] = $record_contact["first_name"];

        $record["last_name"] = $record_contact["last_name"];

        $record["job_title"] = $record_contact["job_title"];

        $record["contact_email"] = $record_contact["contact_email"];
        
        $record["cellphone"] = $record_contact["cellphone"];
        
        $this->data['member'] = $record;

        $company_info = $this->Common_model->get_record("company", array(

            'member_id' => $user_id

        ));
        $record["main_business_ph"] = $record_contact["main_business_ph"];

        $record["web_address"] = $record_contact["web_address"];
        $this->data['not_edit'] = true;

        $this->data["company_info"] = $record;

        $this->data["company_info_sr"] = $this->Common_model->get_record("sales_rep", array(

            'member_sale_id' => $id

        ));

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

        $this->load->view('block/header', $this->data);

        $this->load->view('business/index', $this->data);

        $this->load->view('include/share-profile', $this->data);

        $this->load->view("include/report-images");

        $this->load->view('block/footer', $this->data);

    }

    public function save_sales_reps(){

        $data = array('status' => 'error');

        if($this->session->userdata('user_sr_info') && $this->input->is_ajax_request()){

            $user_info = $this->user_info;

            $id = @$this->input->post("id");

            $item = $this->input->post();

            if(!empty($id)){

                $data_update = array(

                    "first_name" => @$item["first_name"],

                    "last_name" => @$item["last_name"],

                    "job_title" => @$item["job_title"],

                    "company_name" => @$item["company_name"],

                    "number_800" => @$item["number_800"],

                    "cellphone" => @$item["cellphone"],

                    "main_business_ph" => @$item["main_business_ph"],

                    "web_address" => @$item["web_address"],

                    "main_address" => @$item["main_address"],

                    "city" => @$item["city"],

                    "state" => @$item["state"],

                    "zip_code" => @$item["zip_code"],

                    "country" => @$item["country"],

                    "service_area" => @$item["service_area"],

                );

                $data_filter = array(

                    "id" => $id,

                    "member_sale_id" => $user_info["member_id"] 

                );

                $this->Common_model->update("sales_rep",$data_update,$data_filter);

                $data_update = array(

                    "pwd"    => @$item["password"]

                );

                $user_info["full_name"] = @$item["first_name"]." ".@$item["last_name"];

                $this->Common_model->update("member_sale_rep",$data_update,array("id" => $user_info["member_id"]));

                $this->session->unset_userdata('user_sr_info');

                $this->session->set_userdata('user_sr_info',$user_info);

                $data['status'] = 'success';

            }

        }

        die(json_encode($data));

    }
    public function download_impormation(){
        
        $user_info = $this->user_info;
        $record = $this->Common_model->get_result("share_contacts",array("member_id"=>$user_info["member_id"],"type_member"=>"business"));
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$this->gen_slug($user_info["full_name"]).'.csv";');
        $f = fopen('php://output', 'w');
        $array [] =["Contact Email","Sent Date"];
        if(!empty($record)){
            foreach ($record as $key => $value) {
                $email = $value["email_sent"];
                $timestamp = strtotime($value["created_at"]);
                $created_at = date('l\,M d\,Y', $timestamp);
                $array [] = [$email,$created_at];
            }
        }
        foreach ($array as $line) {
            fputcsv($f, $line,",");
        }
        
    }

    public function save_logo(){

        $data = array('status' => 'error');

        if( $this->input->is_ajax_request() ){

            if(isset($_FILES["fileupload"]) && $_FILES["fileupload"]["error"] == 0){

                $user_info = $this->user_info;

                $upload_path = FCPATH.'uploads/business/'.$user_info["member_id"].'/';

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
                    $logo = 'uploads/business/'.$user_info["member_id"].'/'.$config['file_name'].'.'.$name[count($name) - 1];

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
                    
                    exec('aws s3 sync  /dw_source/dezignwall/uploads/business/'.$user_info["member_id"].'/ s3://dwsource/dezignwall/uploads/business/'.$user_info["member_id"].'/ --acl public-read'); 

                    $data_update =  array('avatar' => $logo);

                    $user_info["avatar"] =  $logo;

                    $this->Common_model->update("member_sale_rep",$data_update,array("id" => $user_info["member_id"]));

                    $this->session->unset_userdata('user_sr_info');

                    $this->session->set_userdata('user_sr_info',$user_info);

                    $data = array('status' => 'status',"logo" => $logo);

                }

            } 

        }else{

            redirect(base_url());

        }

        die(json_encode($data));

       

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

}

