<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends MY_Controller
{
	private $user_id = null;
	// private $user_info = null;
	private $is_login = false;
	private $data = null;
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('user_info')) {
			$this->is_login = true;
			$this->user_info = $this->session->userdata('user_info');
			$this->user_id = $this->user_info["id"];
		}
	}

	public function index($id = null)
	{
		if (!$this->is_login) {
			redirect('/');
		}
		$user_id = ($id == null) ? $this->user_id : $id;
		$record = $this->Common_model->get_record("members", array(
			'id' => $user_id
		));
		$this->data["is_login"] = $this->is_login;
		$this->data["title_page"] = "Profile";
		$this->data['user_id'] = $user_id;
		if (!(isset($record) && $record != null)) {
			redirect('/');
		}

		$this->data['member'] = $record;
		$this->data["company_info"] = $this->Common_model->get_record("company", array(
			'member_id' => $user_id
		));
		$this->data['photos'] = $this->Common_model->get_result('photos', array(
			'member_id' => $user_id,
			'type' => 2
		) , 0, 10);
		$this->load->view('block/header', $this->data);
		$this->load->view('profile/index', $this->data);
		$this->load->view('block/footer', $this->data);
	}

	public function myphoto($user_id = null)
	{
		$segment = 4;
		$owner = false;
        if($user_id == null){
        	$user_id = $this->user_id;
        	$segment = 3;
        	$owner = true;
        }
		$record = $this->Common_model->get_record("members", array('id' => $user_id));
		if($record == null){redirect('/');}
		$this->load->library("pagination");
		$this->data["is_login"] = $this->is_login;
		$this->data['user_id'] =$user_id;
		$this->data["title_page"] = "My Photo";
		$this->data['member'] = $record;
		$this->data["company_info"] = $this->Common_model->get_record("company", array(
			'member_id' => $user_id
		));
		$this->load->model('Photo_model');
		$this->load->model('Comment_model');
		
		$per_page = 24;
		$config_init = array(
			"base_url" => "/profile/myphoto",
			"segment" => $segment,
			"total_rows" => $this->Photo_model->get_count_my_photo($user_id) ,
			"per_page" => $per_page
		);
		$config = $this->get_config_paging($config_init);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
		$this->data["links"] = $this->pagination->create_links();
		$result_photo = $this->Photo_model->get_my_photo($user_id, $page , $per_page);
		if (isset($result_photo) && count($result_photo) > 0) {
			foreach($result_photo as $key => $value) {
				$result_photo[$key]['photo_comment'] = $this->Comment_model->get_collection($value['photo_id'], 'photo', -1, 0);
			}
		}

		$this->data['results'] = $result_photo;
		$this->data['owner']   = $owner;
		$this->load->view('block/header', $this->data);
		$this->load->view('profile/photos', $this->data);
		$this->load->view('block/footer', $this->data);
	}

	public function conversations(){
		if (!$this->is_login) {
			redirect('/');
		}
		$user_id=$this->user_id;
		$record = $this->Common_model->get_record("members", array('id' => $user_id));
		if($record == null){
			redirect('/');
		}
		$this->load->library("pagination");
		$this->data["is_login"] = $this->is_login;
		$this->data['user_id'] =$user_id;
		$this->data["title_page"] = "Your conversations";
		$this->data['member'] = $record;
		$this->data["company_info"] = $this->Common_model->get_record("company", array(
			'member_id' => $user_id
		));
		$this->load->model('Photo_model');
		$this->load->model('Comment_model');
		
		$per_page = 10;
		$segment = 3;
		$config_init = array(
			"base_url" => "/profile/conversations",
			"segment" => $segment,
			"total_rows" => $this->Photo_model->get_count_my_photo($user_id) ,
			"per_page" => $per_page
		);
		$config = $this->get_config_paging($config_init);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
		$this->data["links"] = $this->pagination->create_links();
		$result_photo = $this->Photo_model->get_my_photo($user_id, $page , $per_page);
		if (isset($result_photo) && count($result_photo) > 0) {
			foreach($result_photo as $key => $value) {
				$result_photo[$key]['photo_comment'] = $this->Comment_model->get_collection($value['photo_id'], 'photo', -1, 0);
			}
		}

		$this->data['results'] = $result_photo;
		$this->load->view('block/header', $this->data);
		$this->load->view('profile/conversations', $this->data);
		$this->load->view('block/footer', $this->data);
	}

	public function delete_photo($photo_id)
	{
		if (!$this->is_login) {
			redirect('/');
		}

		if (!(isset($photo_id) && $photo_id != null && is_numeric($photo_id))) {
			redirect('/profile/myphoto');
		}

		$record = $this->Common_model->get_record('photos', array(
			'photo_id' => $photo_id,
			'member_id' => $this->user_id
		));
		if (!(isset($record) && count($record) > 0)) {
			redirect('/profile/myphoto');
		}

		if ($this->Common_model->delete('photos', array(
			'photo_id' => $photo_id
		))) {
			if (isset($record['path_file']) && $record['path_file'] != null && file_exists('.' . $record['path_file'])) {
				unlink('.' . $record['path_file']);
			}

			if (isset($record['thumb']) && $record['thumb'] != null && file_exists('.' . $record['thumb'])) {
				unlink('.' . $record['thumb']);
			}

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

		redirect('/profile/myphoto');
	}

	public function edit()
	{
		if (!$this->is_login) {
			redirect('/');
		}

		$user_id = $this->user_id;
		$record = $this->Common_model->get_record("members", array(
			'id' => $user_id
		));
		$this->data["is_login"] = $this->is_login;
		$this->data["title_page"] = "Edit Profile";
		$this->data['member'] = $record;
		$this->data["company_info"] = $this->Common_model->get_record("company", array(
			'member_id' => $user_id
		));
		$this->data['photos'] = $this->Common_model->get_result('photos', array(
			'member_id' => $user_id,
			'type' => 2
		) , 0, 10);
		$this->data['setting'] = $this->Common_model->get_record('member_setting', array(
			'member_id' => $user_id
		));
		$this->load->view('block/header', $this->data);
		$this->load->view('profile/edit', $this->data);
		$this->load->view('block/footer', $this->data);
	}

	public function sales_reps($id = null)
	{
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
			'member_id' => $user_id
		));
		$this->load->view('block/header', $this->data);
		$this->load->view('profile/sales_reps', $this->data);
		$this->load->view('block/footer', $this->data);
	}

	public function suggest_business()
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('Category_model');
			$keyword = $this->input->post('keyword');
			$business_type = $this->input->post('business_type');
			if ($keyword === FALSE || $business_type === FALSE || empty($business_type)) die(json_encode(array(
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

	public function edit_sales_reps($id = null)
	{
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
			'member_id' => $user_id
		));
		$this->load->view('block/header', $this->data);
		$this->load->view('profile/edit-sales-reps', $this->data);
		$this->load->view('block/footer', $this->data);
	}

	public function addphotos($project_id = null, $category_id = null)
	{
		if (!$this->is_login) {
			redirect('/');
		}

		$user_id = $this->user_id;
		$record = $this->Common_model->get_record("members", array(
			'id' => $user_id
		));
		$this->data["is_login"] = $this->is_login;
		$this->data["title_page"] = "Upload Photo";
		$this->data['project_id']=$project_id;
		$this->data['category_id']=$category_id;
		if (!(isset($record) && $record != null)) {
			redirect('/profile/');
		}

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
		$photo_id=0;
		if(isset($_COOKIE['save_multi'])){
			$photo_id=$_COOKIE['save_multi'];
		}
		$record_photos = $this->Common_model->get_record('photos', array(
			'photo_id' => @$photo_id,
			'member_id' => $user_id
		));

		$this->load->model('Category_model');
		if($photo_id==0){
			$this->data['category'] = null;
			$this->data['keywords'] = null;
			$this->data['photo'] = null;
		}
		else{
			$this->data['category'] = $this->Category_model->get_category_by_photo($photo_id);
			$this->data['keywords'] = $this->Category_model->get_keyword_by_photo($photo_id);
			$this->data['photo'] = $record_photos;
		}
		

		$this->load->view('block/header', $this->data);
		$this->load->view('profile/upload', $this->data);
		$this->load->view('block/footer', $this->data);
	}

	public function delete_salep_rep()
	{
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
				$data['status'] = 'success';
			}
		}

		die(json_encode($data));
	}

	public function save_salep_rep()
	{
		$data = array(
			'status' => 'error'
		);
		if (!$this->input->is_ajax_request()) {
			die(json_encode($data));
		}

		$item = $this->input->post('rep');
		if (!count($item) > 0) {
			die(json_encode($data));
		}

		$id = @$item['id'];
		$record = $this->Common_model->get_record('sales_rep', array(
			'member_id' => $this->user_id,
			'id' => $id
		));
		if (isset($record) && count($record) > 0) {
			$this->Common_model->update('sales_rep', $item, array(
				'member_id' => $this->user_id,
				'id' => $id
			));
		}
		else {
			$item['id'] = null;
			$item['member_id'] = $this->user_id;
			$item['	created_at'] = date('Y-m-d H:i:s');
			$this->Common_model->add('sales_rep', $item);
		}

		$data['status'] = 'success';
		die(json_encode($data));
	}

	public function save()
	{
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
					"work_email" => $personal['work_email']
				);
				if ($personal['password'] != null && strlen($personal['password']) >= 6 && $personal['password'] == $personal['confirmpassword']) {
					$arr['pwd'] = md5($record['email'] . ':' . md5($personal['password']));
				}

				$this->Common_model->update('members', $arr, array(
					'id' => $user_id
				));
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
				}
				else {
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
					foreach($business_description as $key => $value) {
						if (isset($pid) && count($pid) > 0 && isset($value) && $value != null && trim($value) != '') {
							$record_check = $this->Category_model->get_business_category(trim($value));
							if (!(isset($record_check) && count($record_check))) {
								$data = array(
									'pid' => $pid['id'],
									'title' => $value,
									'slug' => $this->to_slug(trim($value)) ,
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
				) , array(
					'id' => $user_id
				));
				if (isset($company_info) && count($company_info) > 0) {
					$this->Common_model->update('company', $arr, array(
						'member_id' => $user_id
					));
					$data['status'] = 'success';
				}
				else {
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
				$certifications_image=json_decode($this->input->post('certifications_image'),true);
				$arr_file=array();
				if(isset($certifications_image) && count($certifications_image) > 0 ){
					$arr_file=$certifications_image;
				}
				if (isset($_FILES['certification'])){
					$path = FCPATH . "/uploads/certifications";
					if (!is_dir($path)) {
						mkdir($path, 0755, TRUE);
					}
					$path = $path . "/" . $this->user_id;
					if (!is_dir($path)) {
						mkdir($path, 0755, TRUE);
					}
					$folder="/uploads/certifications/".$this->user_id.'/';
					$this->load->library('upload');
					$config = array();
			        $config['upload_path']   = '.'.$folder;
			        $config['allowed_types'] = 'jpg|png|gif';
			        $config['max_size']      = '500';
			        $config['max_width']     = '1028';
			        $config['max_height']    = '1028';
					$file=$_FILES;
					$count = count($file['certification']['name']);
			        for($i=0; $i<=$count-1; $i++) {
			              $_FILES['image']['name']= $file['certification']['name'][$i];
				          $_FILES['image']['type']= $file['certification']['type'][$i];
				          $_FILES['image']['tmp_name']= $file['certification']['tmp_name'][$i];
				          $_FILES['image']['error']= $file['certification']['error'][$i];
				          $_FILES['image']['size']= $file['certification']['size'][$i];    
			              $this->upload->initialize($config);
			              if($this->upload->do_upload('image')){
			              	  $upload_data = $this->upload->data();
			              	  $arr_file[] = $folder.$upload_data['file_name']; 
			              }
			        }
			    }

				$arr = array(
					'certifications' => json_encode(array(
						'text'=>$company['certifications'],
						'image'=>json_encode($arr_file)
					)),
					'service_area' => $company['service_area']
				);
				if (isset($company_info) && count($company_info) > 0) {
					$this->Common_model->update('company', $arr, array(
						'member_id' => $user_id
					));
					$data['status'] = 'success';
				}
				else {
					$arr['member_id'] = $user_id;
					$this->Common_model->add('company', $arr);
					$data['status'] = 'success';
				}
			}
		}

		die(json_encode($data));
	}

	private function to_slug($string)
	{
		return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
	}

	public function logout()
	{
		$this->session->unset_userdata('user_info');
		$this->session->unset_userdata('ci_session');
		$request='';
  		if ($_SERVER['QUERY_STRING']) {
            $request = "?" . @$_SERVER['QUERY_STRING'];
        }
		redirect(base_url().$request);
	}

	public function save_media()
	{
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
						$choose = $this->input->post('choose');
						if ($data["status"] = "success") {
							if ($choose == 'avatar') {
								if (isset($record['avatar']) && file_exists('.' . $record['avatar'])) {
									unlink('.' . $record['avatar']);
								}

								$arr = array(
									'avatar' => $output_url . $data["name"]
								);
								$arrs=$this->session->userdata('user_info');
								$arrs['avatar']=$output_url . $data["name"];
								$this->session->set_userdata('user_info',$arrs);

								$this->Common_model->update('members', $arr, array(
									'id' => $user_id
								));
								$data['name'] = $output_url . $data["name"];
							}
							else
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
							}
							else
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

	public function get_by_category()
	{
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

	public function get_keywords()
	{
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

	private function ratio_image($original_width, $original_height, $new_width = 0, $new_heigh = 0)
	{
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

	private function add_other_category($name, $photo_id, $parents_id = null, $category_id = 0)
	{
		$this->load->model('Category_model');
		$cate_id = 0;
		if (intval($category_id) == 0) {
			$record = $this->Category_model->get_by_name($name, $parents_id);
			if (isset($record) && count($record)) {
				$cate_id = $record['id'];
			}
			else {
				$cate_id = $this->Common_model->add('categories', array(
					'title' => $name,
					'parents_id' => $parents_id[0],
					'parents_id' => $parents_id[0],
					'slug' => $this->slug_category($name) ,
					'sort' => 0,
					'type' => 'custom'
				));
			}
		}
		else {
			$cate_id = intval($category_id);
		}

		$check = $this->Common_model->get_record('photo_category', array(
			'category_id' => intval($cate_id) ,
			'photo_id' => $photo_id,
		));
		if (!(isset($check) && count($check) > 0)) {
			$this->Common_model->add('photo_category', array(
				'category_id' => intval($cate_id) ,
				'photo_id' => $photo_id,
				'first_child_category' => $parents_id[0],
			));
		}
	}

	private function add_other_keywords($name, $photo_id, $keywords_id = 0)
	{
		$key_id = 0;
		if (intval($keywords_id) == 0) {
			$record = $this->Common_model->get_record('keywords', array(
				'title' => $name
			));
			if (isset($record) && count($record)) {
				//print_r($record);
				$key_id = $record['keyword_id'];
			}
			else {
				//echo $key_id . '<br />';
				$key_id = $this->Common_model->add('keywords', array(
					'title' => $name
				));
			}
		}
		else {
			$key_id = intval($keywords_id);
		}

		$check = $this->Common_model->get_record('photo_keyword', array(
			'keyword_id' => intval($key_id) ,
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

	private function slug_category($tring)
	{
		strtolower($tring);
		str_replace(" ", "-", $tring);
		str_replace("/", "-", $tring);
		str_replace("_", "-", $tring);
		return $tring;
	}

	private function save_custom_category($category_system, $category_custom, $photo_id, $id)
	{
		// category system
		$category = explode(',', $category_system);
		if (isset($category) && count($category) > 0) {
			foreach($category as $key => $value) {
				if (isset($value) && $value != null && is_numeric($value)) {
					$this->add_other_category('', $photo_id, $id, $value);
				}
			}
		}

		// category custom
		$custom = explode(',', $category_custom);
		if (isset($custom) && count($custom) > 0) {
			foreach($custom as $key => $value) {
				if (isset($value) && $value != null && trim($value) != '') {
					$this->add_other_category($value, $photo_id, $id);
				}
			}
		}
	}

	private function save_category_check($value, $photo_id)
	{
		if (isset($value) && count(explode('|', $value)) == 2) {
			$locally = explode('|', $value);
			$this->Common_model->add('photo_category', array(
				'category_id' => $locally[0],
				'photo_id' => $photo_id,
				'first_child_category' => $locally[1]
			));
		}
	}

	private function save_custom_keywords($keywords_system, $keywords_custom, $photo_id)
	{
		/*Keyword System*/
		$keywords = explode(',', $keywords_system);
		if (isset($keywords) && count($keywords) > 0) {
			foreach($keywords as $key => $value) {
				if (isset($value) && $value != null && is_numeric($value)) {
					$this->add_other_keywords('', $photo_id, $value);
				}
			}
		}

		/*Keyword Custom*/
		$keywords_other = explode(',', $keywords_custom);
		if (isset($keywords_other) && count($keywords_other) > 0) {
			foreach($keywords_other as $key => $value) {
				if (isset($value) && $value != null && trim($value) != '') {
					$this->add_other_keywords($value, $photo_id);
				}
			}
		}
	}

	public function upload_images($project_id=null, $category_id=null)
	{
		$is_dezignwall = false;
		$data_result = array(
			'status' => 'error',
			'message' => ''
		);
		if ($this->input->is_ajax_request()) {
			// Check project and category
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
				$is_dezignwall = true;
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
			$point_tag = json_decode($this->input->post('point_tag'),true);

			$crop_data = json_decode($this->input->post('crop_data') , true);
			if (isset($_FILES['file_upload']) && is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
				$path = FCPATH . "/uploads/member";
				if (!is_dir($path)) {
					mkdir($path, 0755, TRUE);
				}

				$path = $path . "/" . $this->user_id;
				if (!is_dir($path)) {
					mkdir($path, 0755, TRUE);
				}

				$output_dir = "./uploads/member/" . $this->user_id . "/";
				$output_url = "/uploads/member/" . $this->user_id . "/";
				$config_upload['upload_path'] = $path;
				$config_upload['allowed_types'] = 'jpg|png|jpeg|gif';
				$this->load->library('upload', $config_upload);
				$this->upload->initialize($config_upload);
				$image = $this->upload->do_upload("file_upload");
				$image_data = $this->upload->data();
				if ($image) {
					$this->load->library('image_lib');
					$new_image = $image_data['file_name'];
					if (isset($crop_data) && count($crop_data) > 0) {
						if (isset($crop_data['rotate']) && intval($crop_data['rotate']) > 0) {
							// rotate
							// $degrees=180+intval($crop_data['rotate']);
							// if($degrees>=360){$degrees=$degrees-360;}
							// $degrees=(0-intval($crop_data['rotate']));
							$degrees = intval($crop_data['rotate']);
							$config['library_path'] = '/usr/bin/convert';
							$config['image_library'] = 'imagemagick';
							$config['quality'] = "100%";
							$config['rotation_angle'] = $degrees;
							$config['maintain_ratio'] = FALSE;
							$config['source_image'] = $output_dir . $image_data['file_name'];
							$config['new_image'] = $output_dir . 'new_' . $image_data['file_name'];
							$this->image_lib->clear();
							$this->image_lib->initialize($config);
							if ($this->image_lib->rotate()) {
								unlink($output_dir . $new_image);
								$new_image = 'new_' . $image_data['file_name'];
							}
						}

						if (isset($crop_data['height']) && intval($crop_data['height']) > 0) {
							// cropper
							$config['image_library'] = 'gd2';
							$config['source_image'] = $output_dir . $new_image;
							$config['new_image'] = $output_dir . $new_image;
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
					}

					$size = getimagesize($output_dir . $new_image);
					$w_current = $size[0];
					$h_current = $size[1];
					if ($w_current > 1100) {
						// resize
						$config['source_image'] = $output_dir . $new_image;
						$config['new_image'] = $output_dir . $new_image;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 1100;
						$size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
						$config['height'] = $size_ratio['height'];
						$config['quality'] = 100;
						$this->image_lib->clear();
						$this->image_lib->initialize($config);
						$this->image_lib->resize();
					}

					// thumb
					$config['source_image'] = $output_dir . $new_image;
					$config['new_image'] = $output_dir . "thumbs_" . $new_image;
					$config['maintain_ratio'] = FALSE;
					$config['width'] = 320;
					$size_ratio = $this->ratio_image($w_current, $h_current, $config['width']);
					$config['height'] = $size_ratio['height'];
					$config['quality'] = 100;
					$this->image_lib->clear();
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					$thumb = $output_url . "thumbs_" . $new_image;
					$path = $output_url . $new_image;


					$offer_product = $this->input->post('offer_product');
					$unit_price = $this->input->post('unit_price');
					$max_unit_price = $this->input->post('max_unit_price');
					$sample_apply = $this->input->post('sample_apply');
					$arr = array(
						'name' => $product_type,
						'path_file' => $path,
						'type' => ($is_dezignwall ? 4 : 2),
						'image_category' => $project_image,
						'member_id' => $this->user_id,
						'note' => '',
						'thumb' => $thumb,
						'status_photo' => 1,
						'photo_credit' => $photo_credit,
						'offer_product' =>$offer_product,
						'unit_price'	=>$unit_price,
						'maximum_price'=>$max_unit_price,
						'sample_pricing'=>$sample_apply,
						'created_at' => date('Y-m-d H:i:s')
					);
					$photo_id = $this->Common_model->add('photos', $arr);
					if (isset($photo_id) && $photo_id > 0) {

						$save_multi=$this->input->post('save_multiple');
						if(isset($save_multi) && $save_multi!=null){
							setcookie('save_multi', $photo_id,time() + (86400 * 30),'/');
						}
						else{
							if(isset($_COOKIE['save_multi'])){
								setcookie("save_multi", "", time() - 3600,'/');
							}
						}

						$both = explode(',', $location_check);
						if(isset($both[0]) && $both[0]!=null){
							$this->save_category_check($both[0], $photo_id);
						}

						if(isset($both[1]) && $both[1]!=null){
							$this->save_category_check($both[1], $photo_id);
						}

						$this->save_category_check($source, $photo_id);
	
						$this->save_custom_category($category, $category_other, $photo_id, array(
							$this->Common_model->_CAT_PRODUCT,
							$this->Common_model->_CAT_PROJECT
						));

						$this->save_custom_category($location, $location_other, $photo_id, array(
							$this->Common_model->_CAT_AREA
						));

						$this->save_custom_category($style, $style_other, $photo_id, array(
							$this->Common_model->_CAT_STYLE
						));

						$this->save_custom_category($compliance, $compliance_other, $photo_id, array(
							$this->Common_model->_CAT_COMPLIANCE
						));

						$this->save_custom_keywords($keywords, $keywords_other, $photo_id);
						

						//tag image
						if(isset($point_tag) && count($point_tag)>0){
							$size_new = getimagesize($output_dir .$new_image);
							$w_current_new=$size_new[0];
							$h_current_new=$size_new[1];
							$ratio_w_new=floatval($w_current_new/$w_current);
							$ratio_h_new=floatval($h_current_new/$h_current);
							foreach ($point_tag as $key => $value) {
								$this->Common_model->add('images_point',array(
									'photo_id'=>$photo_id,
									'top' =>floatval($value['top'])*$ratio_h_new,
									'left'=>floatval($value['left'])*$ratio_w_new,
									'product_in'=>$value['product_in'],
									'one_off' => $value['one_off'],
									'max_qty' => $value['max_qty']
								));
							}
						}//end tag image


						$data_result['status'] = 'success';
						$data_result['message'] = 'Upload successfully';
						$data_result['url'] = "/profile/myphoto/";
						if ($is_dezignwall) {
							$product=$this->input->post('product');
							$arr=array(
								'product_name'=>@$product['product_name'],
								'product_no'=>@$product['product_no'],
								'price'=>@$product['price'],
								'qty'=>@$product['qty'],
								'fob'=>@$product['fob'],
								'product_note'=>@$product['product_notes'],
							);
							$arr['photo_id']=$photo_id;
							$arr['category_id']=$category_id;
							$arr['created_at']=date('Y-m-d H:i:s');
							$arr['member_id']=$this->user_id;
							$arr['member_updated_id']=$this->user_id;
							$this->Common_model->add('products',$arr);
							$data_result['url'] = "/designwalls/photos/{$project_id}/{$category_id}";
							$photo_id = $this->Common_model->add('product_category', array('product_id' => $photo_id, 'category_id' => $category_id));
						}
					} //end photo id
				}
			}
		}

		die(json_encode($data_result));
	}

	public function editphoto($id,$category_id=null,$project_id=null)
	{
		if (!$this->is_login || !(isset($id) && $id != null && is_numeric($id))) {
			redirect('/');
		}

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

		$this->load->model('Category_model');
		if($record['type']==4){
			$this->data['c_id']=$category_id;
			$this->data['product_info']=$this->Common_model->get_record('products',array(
				'photo_id'=> $id,
				'category_id'=>$category_id
			));
		}
		$this->data['category'] = $this->Category_model->get_category_by_photo($id);
		$this->data['point'] = $this->Common_model->get_result('images_point', array(
			'photo_id' => $id
		));
		$this->data['keywords'] = $this->Category_model->get_keyword_by_photo($id);
		$this->data['photo'] = $record;
		$this->load->view('block/header', $this->data);
		$this->load->view('profile/editphoto', $this->data);
		$this->load->view('block/footer', $this->data);
	}

	public function save_edit_photo()
	{
		$data = array(
			'status' => 'error',
			'message' => ''
		);
		if (!$this->input->is_ajax_request()) {
			die(json_encode($data));
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
		$point_tag = json_decode($this->input->post('point_tag') , true);

		// $crop_data=json_decode($this->input->post('crop_data'),true);

		$user_id = $this->user_id;
		$record = $this->Common_model->get_record('photos', array(
			'photo_id' => @$photo_id,
			'member_id' => $user_id
		));
		if (!(isset($record) && count($record) > 0)) {
			die(json_encode($data));
		}

		$image_category = '';
		if (isset($project_image) && $project_image != null) {
			$image_category = $project_image;
		}
		else {
			$image_category = $product_image;
		}

		if (isset($product_image) && $product_image != null && isset($project_image) && $project_image != null) {
			$image_category = $project_image . ',' . $product_image;
		}


		$offer_product = $this->input->post('offer_product');
		$unit_price = $this->input->post('unit_price');
		$max_unit_price = $this->input->post('max_unit_price');
		$sample_apply = $this->input->post('sample_apply');
		$arr = array(
			'name' => $product_type,
			'image_category' => $image_category,
			'photo_credit' => $photo_credit,
			'offer_product' =>$offer_product,
			'unit_price'	=>$unit_price,
			'maximum_price'=>$max_unit_price,
			'sample_pricing'=>$sample_apply
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
		$both = explode(',', $location_check);
		if(isset($both[0]) && $both[0]!=null){
			$this->save_category_check($both[0], $photo_id);
		}

		if(isset($both[1]) && $both[1]!=null){
			$this->save_category_check($both[1], $photo_id);
		}

		$this->save_category_check($source, $photo_id);

		$this->save_custom_category($category, $category_other, $photo_id, array(
			$this->Common_model->_CAT_PRODUCT,
			$this->Common_model->_CAT_PROJECT
		));

		$this->save_custom_category($location, $location_other, $photo_id, array(
			$this->Common_model->_CAT_AREA
		));

		$this->save_custom_category($style, $style_other, $photo_id, array(
			$this->Common_model->_CAT_STYLE
		));

		$this->save_custom_category($compliance, $compliance_other, $photo_id, array(
			$this->Common_model->_CAT_COMPLIANCE
		));
		$this->save_custom_keywords($keywords, $keywords_other, $photo_id);
		$size_new = getimagesize('.' . $record['path_file']);
		$w_current_new = $size_new[0];
		$h_current_new = $size_new[1];

		// tag image
		$this->Common_model->delete('images_point',array(
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
			foreach($point_tag as $key => $value) {
				$this->Common_model->add('images_point', array(
					'photo_id' => $photo_id,
					'top' => $value['top'] * $ratio_h,
					'left' => $value['left'] * $ratio_w,
					'product_in'=>$value['product_in'],
					'one_off' => $value['one_off'],
					'max_qty' => $value['max_qty']
				));
			}
		} //end tag image


		//save product info
		if($record['type']==4){
			$product=$this->input->post('product');
			if(isset($product['category_id']) && $product['category_id']!=null && is_numeric($product['category_id'])){
				$record=$this->Common_model->get_record('products',array(
					'photo_id'=> @$photo_id,
					'category_id'=>$product['category_id']
				));
				$arr=array(
					'product_name'=>@$product['product_name'],
					'product_no'=>@$product['product_no'],
					'price'=>@$product['price'],
					'qty'=>@$product['qty'],
					'fob'=>@$product['fob'],
					'product_note'=>@$product['product_notes']
				);
				if(isset($record) && count($record)>0){
					$this->Common_model->update('products',$arr,array(
						'photo_id'=> $photo_id,
						'category_id'=>$product['category_id']
					));
				}
				else{
					$arr['photo_id']=$photo_id;
					$arr['category_id']=$product['category_id'];
					$arr['created_at']=date('Y-m-d H:i:s');
					$arr['member_id']=$this->user_id;
					$arr['member_updated_id']=$this->user_id;
					$this->Common_model->add('products',$arr);
				}
			}
		}
		$data['status'] = 'success';
		$data['message'] = 'Save successfully';
		die(json_encode($data));
	}

	public function upgrade()
	{
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

	public function plan($id=null)
	{
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
}