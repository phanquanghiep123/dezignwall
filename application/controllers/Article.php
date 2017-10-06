<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {

    private $user_id = 0;
    private $is_login = false;
    private $data = null;

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
            $this->data['user_info'] = $this->user_info;
        }
    }

    public function print_resize() {
    	$this->load->helper('directory');
    	$directories = directory_map(FCPATH . "/uploads", FALSE, TRUE);
    	$this->show_dir_files($directories,'');
    }

	function show_dir_files($in,$path)
	{
        $this->load->library('upload');
		foreach ($in as $k => $v) {
			if (!is_array($v)) {
				$file_image = FCPATH . 'uploads/' . str_replace('//','/',$path.$v);
				if (@getimagesize($file_image)) {
					// Resize
					$config = array();
                    // Resize
                    $config['image_library'] = 'gd2';
			        $config['source_image'] = $file_image;
			        $config['maintain_ratio'] = TRUE;
			        $config['width']     = 1028;
			        $config['height']   = 1028;
			        $config['overwrite'] = TRUE;
			        $this->load->library('image_lib', $config); 
			        $this->image_lib->initialize($config);
			        if ( !$this->image_lib->resize()){
                		echo $this->image_lib->display_errors('', '');
              		} else {
              			echo $file_image.'<br/>';
              		}
				}
			} else {
				$this->show_dir_files($v,$path.$k.DIRECTORY_SEPARATOR);			
			}
		}
	}

    public function index($member = null) {
        if( !isset($this->user_info["is_blog"]) || $this->user_info["is_blog"] != "yes"){
             redirect(base_url());
             die();
        }
        $member_id = isset($member) && $member!=null && is_numeric($member) ? $member : $this->user_id;
        $record = $this->Common_model->get_record('members',array(
            'id' => $member_id
        ));
        
        if( !(isset($record) && $record!=null) ) {
            redirect(base_url().'article/');
            die;
        }
        $this->load->model("Article_model");
        $article =  $this->Article_model->get_public_by_member($member_id);
        
        if($article != null){
            $this->load->model("Article_model");
            $newpost_keyword = $this->Article_model->get_keyword_by_id($article[0]["id"]);
            foreach ( $newpost_keyword as $key => $value) {
               $this->data["newpost_keyword"][] = $value["title"];
            }
        }
        if(!(isset($article) && $article!=null)){
            redirect(base_url().'article/add/');
            die;
        }
        
        $this->load->model('Comment_model');
        $this->data['comment'] = $this->Comment_model->get_collection($article[0]['id'],'blog',3,0);
        $this->data['user_info'] = array(
            'avatar' => $record['avatar'],
            'full_name' => $record['first_name'].' '.$record['last_name'],
            'company_name' => $record['company_name'],
            'job_title' => $record['job_title'],
            'member_id' => $record['id']
        );
        $this->data['tracking'] = $this->Common_model->get_record('common_tracking',array(
            'type_object' => 'blog',
            'reference_id' => $article[0]['id']
        ));
        $this->data['like'] = $this->Common_model->get_record('common_like',array(
            'type_object' => 'blog',
            'reference_id' => $article[0]['id']
        ));
        $this->data['count_comment'] = $this->Common_model->count_table('common_comment',array(
            'reference_id' => $article[0]['id'],
            'type_object' => 'blog'
        ));
        $this->data["type_post"] = "blog";
        $this->data["id_post"] = $article[0]['id'];
        $data_share = ' <meta name="og:image" content="'.base_url($article[0]['thumbnail']).'">
                        <meta id ="titleshare" property="og:title" content="'.$article[0]["company_name"].'\'s just shared '.strip_tags($article[0]['title']) . ' on @Dezignwall TAKE A LOOK" />
                        <meta property="og:description" content="'.strip_tags($article[0]['sub_title']).'" />
                        <meta property="og:url" content="'.base_url("article/post/".$article[0]['id']).'" />
                        <meta property="og:image" content="'.base_url($article[0]['thumbnail']).'" />';

        $this->data["data_share"] = $data_share;
        $this->data['article'] = $article;
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Article | " .$article[0]["company_name"]. ' | ' .strip_tags($article[0]['title']) ;
        $this->data['user_id'] = $this->user_id;
        $this->load->view('block/header', $this->data);
        $this->load->view('blog/index', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function post($article_id = null){
        if( !(isset($article_id) && $article_id!=null && is_numeric($article_id)) ){
            redirect(base_url().'article');
            die;
        }
        $this->data["type_post"] = "blog";
        $this->data["id_post"] = $article_id;
        $article_item = $this->Common_model->get_record('article',array(
            'id' => $article_id
        ));
        if(!(isset($article_item) && $article_item!=null)){
            redirect(base_url().'article');
            die;
        }
        $member_id = @$article_item['member_id'];

        $record = $this->Common_model->get_record('members',array(
            'id' => $member_id
        ));

        if( !(isset($record) && $record!=null) ) {
            redirect(base_url().'article/');
            die;
        }
        $record_tracking = $this->Common_model->get_record('common_tracking',array(
            'reference_id' => $article_item['id'],
            'type_object'  => 'blog'
        ));
        if ($article_id != null) {
            $datime = date('Y-m-d H:i:s');
            $ip = $this->input->ip_address();
            $datainsert = array(
                "reference_id" => $article_id,
                "member_owner" => @$article_item['member_id'],
                "member_id" => @$this->user_id,
                "ip" => $ip,
                "type_object" => "blog",
                "created_at" => $datime,
                "createdat_photo_blog" => $datime
            );
            $this->Common_model->add("common_view", $datainsert);
        }
        if($article_id != null){
            $this->load->model("Article_model");
            $newpost_keyword = $this->Article_model->get_keyword_by_id($article_id);
            foreach ( $newpost_keyword as $key => $value) {
               $this->data["newpost_keyword"][] = $value["title"];
            }
        }
        if(isset($record_tracking) && $record_tracking!=null && is_numeric($record_tracking['qty_view'])){
            $view = $record_tracking['qty_view']+1;
            $arr = array(
                'qty_view' => $view
            );
            $this->Common_model->update('common_tracking',$arr,array(
                'reference_id' => $article_item['id'],
                'type_object'  => 'blog'
            ));
        }
        else{
            $arr = array(
                'qty_view' => 1,
                'qty_comment' => 0,
                'qty_pintowall' => 0,
                'qty_rating' => 0,
                'type_object' => 'blog',
                'reference_id' => $article_item['id']
            );
            $this->Common_model->add('common_tracking',$arr);
        }
        $this->load->model("Article_model");
        $articles =  $this->Article_model->get_public_by_member($member_id);
        $article = array();
        $article_item["company_name"] = $articles[0]["company_name"];
        $article_item["first_name"] = $articles[0]["first_name"];
        $article_item["last_name"] = $articles[0]["last_name"];
        $article[0] = $article_item;
        $i = 1;
        foreach ($articles as $key => $value) {
              if($value['id'] != $article_item['id']){
                    $article[$i] = $value;
                    $i++;
              }
        }
       
        $this->load->model('Comment_model');
        $this->data['comment'] = $this->Comment_model->get_collection($article[0]['id'],'blog',3,0);
        $this->data['count_comment'] = $this->Common_model->count_table('common_comment',array(
            'reference_id' => $article[0]['id'],
            'type_object' => 'blog'
        ));
        $this->data['user_info'] = array(
            'avatar' => $record['avatar'],
            'full_name' => $record['first_name'].' '.$record['last_name'],
            'company_name' => $record['company_name'],
            'job_title' => $record['job_title'],
            'member_id' => $this->user_id
        );
        $this->data['tracking'] = $this->Common_model->get_record('common_tracking',array(
            'type_object' => 'blog',
            'reference_id' => $article[0]['id']
        ));
        $this->data['like'] = $this->Common_model->get_record('common_like',array(
            'type_object' => 'blog',
            'reference_id' => $article[0]['id']
        ));
        $this->data['article'] = $article;
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Post Article | " .$article[0]["company_name"]. ' | ' .strip_tags($article[0]['title']) ;
        $this->data['user_id'] = $this->user_id;
        $titleshare = '<meta id ="titleshare" property="og:title" content="'.strip_tags($article[0]['title']) . ' on @Dezignwall TAKE A LOOK" />';
        if($this->is_login == true){
            $titleshare = '<meta id ="titleshare" property="og:title" content="'.$this->user_info["full_name"].'\'s just shared '.strip_tags($article[0]['title']) . ' on @Dezignwall TAKE A LOOK" />';
        }
        $data_share = ' <meta name="og:image" content="'.base_url($article[0]['thumbnail']).'">
                        '.$titleshare.'
                        <meta property="og:description" content="'.strip_tags($article[0]['sub_title']).'" />
                        <meta property="og:url" content="'.base_url("article/post/".$article[0]['id']).'" />
                        <meta property="og:image" content="'.base_url($article[0]['thumbnail']).'" />';

        $this->data["data_share"] = $data_share;
        $this->load->view('block/header', $this->data);
        $this->load->view('blog/index', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function add() {
        if( !isset($this->user_info["is_blog"]) || $this->user_info["is_blog"] != "yes"){
             redirect(base_url());
             die();
        }
        if($this->input->post()){
            if (isset($_FILES['file'])) {
                $path = FCPATH . "/uploads/blog";
                if (!is_dir($path)) {
                    mkdir($path, 0755, TRUE);
                }
                $path = $path . "/" . $this->user_id;
                if (!is_dir($path)) {
                    mkdir($path, 0755, TRUE);
                }
                $folder = "/uploads/blog/" . $this->user_id . '/';
                $this->load->library('upload');
                $config = array();
                $config['upload_path'] = '.' . $folder;
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
                    $upload_data = $this->upload->data();
                    // Resize
                    $config['image_library'] = 'gd2';
			        $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
			        $config['maintain_ratio'] = TRUE;
			        $config['width']     = 1028;
			        $config['height']   = 1028;
			        $this->load->library('image_lib', $config); 
			        $this->image_lib->resize();
			        
			        // Sync image
					exec('aws s3 sync  /dw_source/dezignwall/uploads/blog/'.$this->user_id.'/ s3://dwsource/dezignwall/uploads/blog/'.$this->user_id.'/ --acl public-read'); 

                    $path_upload = $folder . $upload_data['file_name'];
                    $title = $this->input->post('title');
                    $sub_title = $this->input->post('sub_title');
                    $content = str_replace("<img>","",$this->input->post('content'));
                    $content = str_replace("<img alt>","",$content);
                    $content = str_replace("<img alt >","",$content);
                    $keyword = $this->input->post('keyword');
                    $status =  $this->input->post('type');
                    $arr = array(
                        'title' => $title,
                        'sub_title' => $sub_title,
                        'content' => $content,
                        'thumbnail' => $path_upload,
                        'member_id' => $this->user_id,
                        'status'  => $status,
                        'date_create' => date('Y-m-d H:i:s')
                    );
                    $article_id = $this->Common_model->add('article',$arr);
                    $data_insert_a_k = [];
                    if(is_array($keyword) && count($keyword) > 0){
                        $id_kw = 0;
                        foreach ($keyword as $key => $value) {
                            $filter = array(
                                "title" => $value,
                                "type"  => "article"
                            );
                            $check_keyword = $this->Common_model->get_record("keywords",$filter);
                            if($check_keyword == null){
                                $id_kw  = $this->Common_model->add("keywords",$filter);
                            }else{
                               $id_kw = $check_keyword["keyword_id"];
                            }
                            $data = array(
                                "keyword_id" => $id_kw,
                                "article_id" => $article_id,
                                'created_at' => date('Y-m-d H:i:s')
                            );
                            $data_insert_a_k[] = $data;
                        }
                        if(count($data_insert_a_k) > 0)
                            $this->Common_model->insert_batch_data("article_keyword", $data_insert_a_k);
                    }
                    redirect(base_url().'article/edit/'.$article_id.'/?share=1');
                }else{
                    $this->data["error"] = $this->upload->display_errors();
                }
            }
        }
        $this->data['action'] = base_url().'article/add/';
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Add Article";
        $this->data['current'] = 'add';
        $this->data['user_id'] = $this->user_id;

        $this->load->view('block/header', $this->data);
        $this->load->view('blog/add', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function edit($article_id = null) {
        if( !isset($this->user_info["is_blog"]) || $this->user_info["is_blog"] != "yes"){
             redirect(base_url());
             die();
        }
        if(!(isset($article_id) && $article_id!=null && is_numeric($article_id))){
            redirect(base_url().'article/');
            die;
        }
        $record = $this->Common_model->get_record('article',array(
            'id' => $article_id,
            'member_id' => $this->user_id
        )); 
        $this->data["type_post"] = "blog";
        $this->data["id_post"] = $article_id;   
        if(!(isset($record) && $record!=null)){
            redirect(base_url().'article/');
            die;
        }
        $this->load->model("Article_model");
        $record["keywords"] = $this->Article_model->get_keyword_by_id($article_id);
        $this->data['article'] = $record;
        $this->data['current'] = 'edit';
        $this->data['action'] = base_url().'article/edit/'.$article_id.'/?share=1';
        if($this->input->post()){
            $thumbnail= '';
            if (isset($_FILES['file']) && $_FILES['file']) {
                $path = FCPATH . "/uploads/blog";
                if (!is_dir($path)) {
                    mkdir($path, 0755, TRUE);
                }
                $path = $path . "/" . $this->user_id;
                if (!is_dir($path)) {
                    mkdir($path, 0755, TRUE);
                }
                $folder = "/uploads/blog/" . $this->user_id . '/';
                $this->load->library('upload');
                $config = array();
                $config['upload_path'] = '.' . $folder;
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file')) {
                    $upload_data = $this->upload->data();
                    $config['image_library'] = 'gd2';
			        $config['source_image'] = $config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
			        $config['maintain_ratio'] = TRUE;
			        $config['width']     = 1028;
			        $config['height']   = 1028;
			        $this->load->library('image_lib', $config); 
			        $this->image_lib->resize();
			        //add to the DB

                    $thumbnail = $folder . $upload_data['file_name'];
                    if (isset($record['thumbnail']) && $record['thumbnail']!=null && file_exists('.'.$record['thumbnail'])) {
                        unlink('.'.$record['thumbnail']);
                    }
                    
                    // Sync image
					exec('aws s3 sync  /dw_source/dezignwall/uploads/blog/'.$this->user_id.'/ s3://dwsource/dezignwall/uploads/blog/'.$this->user_id.'/ --acl public-read'); 
                }
            } 

            $title = $this->input->post('title');
            $content = $this->input->post('content');
            $keyword = $this->input->post('keyword');
            $sub_title = $this->input->post('sub_title');
            $arr = array(
                'title' => $title,
                'sub_title' => $sub_title,
                'content' => $content,
                'status'  => $this->input->post('type')
            );
            if(isset($thumbnail) && $thumbnail!=''){
                $arr['thumbnail'] = $thumbnail;
            }
            $this->Common_model->update('article',$arr,array(
                'id' => $article_id,
                'member_id' => $this->user_id
            ));
            $data_insert_a_k = [];
            $this->Common_model->delete("article_keyword",array("article_id" => $article_id));
            if(is_array($keyword) && count($keyword) > 0){
                $id_kw = 0;
                foreach ($keyword as $key => $value) {
                    $filter = array(
                        "title" => $value,
                        "type"  => "article"
                    );
                    $check_keyword = $this->Common_model->get_record("keywords",$filter);
                    if($check_keyword == null){
                        $id_kw  = $this->Common_model->add("keywords",$filter);
                    }else{
                       $id_kw = $check_keyword["keyword_id"];
                    }
                    $data = array(
                        "keyword_id" => $id_kw,
                        "article_id" => $article_id,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $data_insert_a_k[] = $data;
                }
                $this->Common_model->insert_batch_data("article_keyword", $data_insert_a_k);
            }
            redirect($this->data['action']);
            die;
        }
        $company_name = $this->Common_model->get_record("members",array("id" => $record["member_id"]));
        $data_share = ' <meta name="og:image" content="'.base_url($record['thumbnail']).'">
                        <meta id ="titleshare" property="og:title" content="'.@$company_name["company_name"].'\'s just shared '.strip_tags($record['title']) . ' on @Dezignwall TAKE A LOOK" />
                        <meta property="og:description" content="'.strip_tags($record['sub_title']).'" />
                        <meta property="og:url" content="'.base_url("article/post/".$record['id']).'" />
                        <meta property="og:image" content="'.base_url($record['thumbnail']).'" />';
        $this->data["data_share"] = $data_share;
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Edit Article";
        $this->data['user_id'] = $this->user_id;

        $this->load->view('block/header', $this->data);
        $this->load->view('blog/add', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function delete($article_id = null) {
        if( !isset($this->user_info["is_blog"]) || $this->user_info["is_blog"] != "yes"){
             redirect(base_url());
             die();
        }
        if(!(isset($article_id) && $article_id!=null && is_numeric($article_id))){
            redirect(base_url().'article/');
            die;
        }
        $record = $this->Common_model->delete('article',array(
            'id' => $article_id,
            'member_id' => $this->user_id
        ));
        
        redirect(base_url().'article/');
        die;
    }

    function get_more_comment(){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $article_id = $this->input->post('data_id');
        $paging = $this->input->post('paging');
        $number_item = $this->input->post('number_item');
        if(is_numeric($number_item)){
            $number_item = $number_item + 3;
        }else{
            $number_item = 3;
        }
        if( !(isset($article_id) && $article_id!=null && is_numeric($article_id) &&
            isset($paging) && $paging!=null && is_numeric($paging)) ){
            die(json_encode($data));
        }
        $data['status'] = 'success';
        $this->load->model('Comment_model');
        $data['reponse'] = $this->Comment_model->get_collection($article_id,'blog',$number_item,0);
        die(json_encode($data));
    }

    function get_keywords(){
        $data = array(
            'status' => 'error'
        );
        if ($this->input->is_ajax_request()) {
            $slug = $this->input->post('slug');
            $list_id = $this->input->post('list_id');
            if (isset($slug) && $slug != null) {
                $this->load->model('Category_model');
                $data['status'] = 'success';
                $data['reponse'] = $this->Category_model->get_by_keywords_name_like_a($slug, $list_id);
            }
        }

        die(json_encode($data));
    }

    public function upload_file_content(){
        $data = array( 'status' => 'error' ,'src' => "");
        if ($this->input->is_ajax_request()) {
            if(isset($_FILES["file"])){
                $path = FCPATH . "/uploads/blog";
                if (!is_dir($path)) {
                    mkdir($path, 0755, TRUE);
                }
                $path = $path . "/" . $this->user_id."/";
                if (!is_dir($path)) {
                    mkdir($path, 0755, TRUE);
                }
                $folder = "/uploads/blog/". $this->user_id."/";
                $allowed_types = "gif|jpg|png";
                $upload = upload_flie($path,$allowed_types,$_FILES["file"]);
                if($upload["success"] == "success"){
                    $src = base_url($folder.$upload["reponse"]["name"]);
                    $data = array( 'status' => 'success' ,'src' => $src);
                }
                exec('aws s3 sync  /dw_source/dezignwall/uploads/blog/' .  $this->user_id . '/ s3://dwsource/dezignwall/uploads/blog/' .  $this->user_id . '/ --acl public-read --cache-control max-age=86400,public --expires 2034-01-01T00:00:00Z');
            }
        }
        die(json_encode($data));
    }
    function get_all_like($id){
        $data = array( 'status' => 'error');
        if ($this->input->is_ajax_request()) {
            $this->db->select("tbl2.*,tbl3.business_description,tbl1.created_at,tbl1.id AS aID,tbl2.id AS member_id");
            $this->db->from("common_like AS tbl1");
            $this->db->join("members AS tbl2","tbl1.member_id = tbl2.id");
            $this->db->join("company AS tbl3","tbl2.id = tbl3.member_id");
            $this->db->where(["reference_id" => $id,"type_object" => "blog","status" => 1]);
            $r = $this->db->get()->result_array();
            $this->output->enable_profiler(TRUE);
            $html = "";
            foreach ($r as $key => $value) {
                $avatar = ($value["avatar"] != null) ? base_url($value["avatar"]) : skin_url("images/avatar-full.png");
                $html .= '<div class="user-like">
                    <div class="row">
                      <div class="col-sm-2">
                        <a href ="'.base_url("profile/view/".$value["member_id"]).'"><img class="image-user-like circle" width="60px" height="60px" src="'.$avatar.'"></a>
                      </div>
                      <div class="col-sm-7">
                        <h4 class="name"><a href ="'.base_url("profile/view/".$value["member_id"]).'"><b>'.$value["first_name"].' '.$value["last_name"].'</b></a></h4>
                        <p class="description">'.$value["business_description"].' | '.$value["created_at"].'</p>
                      </div>
                      <div class="col-sm-3">
                        <button type="button" data-member-id = "'.$value["member_id"].'" data-id="'.$value["aID"].'" class="btn btn-default">Send Message</button>
                      </div>
                    </div>
                  </div>';
            }
            $data = array( 'status' => 'success' ,"html" => $html);
        }
        die(json_encode($data));
    }
}