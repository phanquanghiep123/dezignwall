<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Photos extends CI_Controller
{
	public $is_login = false;
	public $user_info = 0;
	public $user_id = 0;
	public $data;
	public function __construct()
	{
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

	public function index($photo_id)
	{
		if ($photo_id != "" && is_numeric($photo_id)) {
			$this->data["title_page"] = "Home Page";
			$this->data["view_wrapper"] = "images/single-image";
			$this->data["class_wrapper"] = "image-page";
			$this->load->model("Members_model");
			$this->load->model("Photo_model");
			$recorder_photo = $this->Common_model->get_record("photos", array(
				"photo_id" => $photo_id
			));
			if (count($recorder_photo) > 0 && $recorder_photo != null) {
				$recorder_user = $this->Members_model->get_information_user($recorder_photo["member_id"]);
				$common_tracking = $this->Common_model->get_record("common_tracking", array(
					"reference_id" => $photo_id,
					"type_object" => "photo"
				));
				$like = $this->Common_model->get_result("common_like", array(
					"reference_id" => $photo_id,
					"status" => 1,
					"type_object" => "photo"
				));
				$record_involve = $this->Photo_model->get_ram_photo(array(
					"member_id" => $recorder_photo["member_id"],
					"photo_id !=" => $photo_id,
					"type" => 2
				) , 4);
				$user_total_like = $this->Common_model->get_record("common_like", array(
					"reference_id" => $photo_id,
					"member_id" => $this->user_id,
					"type_object" => "photo"
				));
				$record_type  = $this->Common_model->get_record("members", array( "id" => $recorder_photo["member_id"]) );
				$this->load->model("Photo_keyword_model");
				$record_keyword = $this->Photo_keyword_model->get_photo_keyword_byid($photo_id);
				$this->data["data_wrapper"]["photo"] = $recorder_photo;
				$this->data["data_wrapper"]["user"] = $recorder_user;
				$this->data["data_wrapper"]["record_pin"] = (isset($common_tracking) && count($common_tracking) > 0) ? $common_tracking["qty_pintowall"] : 0;
				$this->data["data_wrapper"]["comment"] = (isset($common_tracking) && count($common_tracking) > 0) ? $common_tracking["qty_comment"] : 0;
				$this->data["data_wrapper"]["like"] = $like;
				$this->data["data_wrapper"]["user_total_like"] = $user_total_like;
				$this->data["data_wrapper"]["record_involve"] = $record_involve;
				$this->data["data_wrapper"]["keyword"] = $record_keyword;
				$this->data["data_wrapper"]["point"] = $this->Common_model->get_result('images_point', array(
					'photo_id' => $photo_id
				));
				$this->data["record_type"] = $record_type["type_member"];
				$this->load->view('block/header', $this->data);
				$this->load->view('block/wrapper', $this->data);
				$this->load->view('block/footer');
			}
			else {
				redirect(base_url());
			}
		}
		else {
			redirect(base_url());
		}
	}

	public function like($object = null)
	{
		$data["success"] = "error";
		$object_arr = array(
			'photo',
			'product',
			'member'
		);
		if ($this->input->is_ajax_request() && in_array($object, $object_arr)) {
			$photo_id = $this->input->post("photo_id");
			$object_id = $photo_id;
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
				}
				else {
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
						'created_at' => date('Y-m-d H:i:s') ,
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
					if ($value_like == 0 && $num_like > 0) $num_like--;
					else $num_like++;
					if($num_like < 0) $num_like = 0;
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
					'type_object'  => $object
				));
				$data["record_tracking"] = $record_return["qty_like"];
				if ($value_like == 1 )
				{
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
	
	/* Get owner of object */
    private function get_owner_object($type_object, $object_id, $type='comment') 
    {
    	// Get setting by object_id
    	$subject = '';
    	$content = '';
    	$query = null;
    	switch($type_object) {
    		case 'product':
    			$sql = 'SELECT p.product_name, p.member_id as member_id, pt.path_file, pc.category_id, pc.project_id, ct.qty_like FROM products AS p INNER JOIN photos AS pt ON pt.photo_id = p.photo_id INNER JOIN project_categories AS pc ON p.category_id = pc.category_id INNER JOIN common_tracking AS ct ON ct.reference_id = p.product_id  WHERE p.product_id=' . $object_id . ' LIMIT 1';
    			$query = $this->db->query($sql)->row_array();
    			$subject = 'Like Image | ' . @$query['product_name'] . ' | ';
    			$content = '<p>' . @$query['qty_like'] . ' like(s) people Liked your photo this ' . date('d/W/m') . '</p>';
    			$content .= '<img src="' . base_url(@$query['path_file']) . '" width="200px" />
    						<p>Click here to post more images of your work: <a href="' . base_url('/profile/addphotos/' . @$query['project_id'] . '/' . @$query['category_id']) . '" style="color:#37a7a7;text-decoration:none;">Upload Image</a></p>';
    			break;
    		case 'photo':
    			$sql = 'SELECT p.path_file, p.name, p.member_id, p.photo_id, ct.qty_like FROM photos AS p INNER JOIN common_tracking AS ct ON ct.reference_id = p.photo_id WHERE p.photo_id=' . $object_id . ' LIMIT 1';
    			$query = $this->db->query($sql)->row_array();
    			$subject = 'Like Image | ' . @$query['name'] . ' | ';
    			$content = '<p>' . @$query['qty_like'] . ' like(s) people Liked your photo this ' . date('d/W/m') . '</p>';
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
	private function get_allow_by_setting($type_object, $object_id, $type='comment') 
    {
    	return true;
    	// If project or member then return true
    	if ($type_object == 'member' || $type_object == 'project') {
    		return true;
    	}
    	
    	// Get setting by object_id
    	$sql = 'SELECT member_id FROM ';
    	switch($type_object) {
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
    	switch($type_object) {
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

	public function get_project_member()
	{
		if ($this->input->is_ajax_request()) {
			$data["success"] = "error";
			$data["reponse"] = array();
			$record_user = $this->Common_model->get_record("members", array(
				"id" => $this->user_id
			));
			$data["type_designwall"] = 0;
			$number_project_owner = $this->Common_model->get_result("projects", array(
				"member_id" => $this->user_id
			));
			$data["number_project_owner"] = count($number_project_owner);
			$this->load->model("Project_model");
			$record_project_all_member = $this->Project_model->get_all_project_member($this->user_id);
			if ($record_project_all_member != null && count($record_project_all_member) > 0) {
				$data["reponse"] = $record_project_all_member;
				$data["success"] = "success";
				$data["user_id"] = $this->user_id;
			}

			die(json_encode($data));
		}
		else {
			redirect(base_url());
		}
	}

	public function get_project_category()
	{
		if ($this->input->is_ajax_request()) {
			$data["success"] = "success";
			$data["reponse"] = "";
			$project_id = $this->input->post("project_id");
			$record_project_ct = $this->Common_model->get_result("project_categories", array(
				"project_id" => $project_id,
				'status' =>'no'
			));
			if ($record_project_ct != null && count($record_project_ct) > 0) {
				$data["reponse"] = $record_project_ct;
			}

			die(json_encode($data));
		}
		else {
			redirect(base_url());
		}
	}

	public function pin_to_wall()
	{
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

			if ($project_id == 0 && trim($new_project) != "") {
				$record = $this->Common_model->count_table("projects", array(
					"project_name" => trim($new_project)
				));
				if ($record > 0) {
					$data["messenger"] = "Title Dezignwall already exists";
					$check_error++;
					die(json_encode($data));
				}
			}
			else {
				$this->load->model("Project_model");
				$check = $this->Project_model->check_member_project($this->user_id, $project_id);
				if ($check == null || count($check) == 0) {
					$data["messenger"] = "You don’t have permission to access this project";
					$check_error++;
					die(json_encode($data));
				}
			}

			if ($category_id == 0 && trim($new_category) != "") {
				$record = $this->Common_model->count_table("project_categories", array(
					"title" => trim($new_category) ,
					"project_id" => $project_id
				));
				if ($record > 0) {
					$data["messenger"] = "This title folder already exists.";
					$check_error++;
					die(json_encode($data));
				}
			}
			else {
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
						'project_name' => trim($new_project) ,
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
							}
							else {
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
		}
		else {
			redirect(base_url());
		}
	}

	public function seachimages()
	{
		if ($this->input->is_ajax_request()) {
			$keyword 			= $this->input->post("keyword") ? trim($this->input->post("keyword")) : "";
			$all_category       = $this->input->post("all_category") ? $this->input->post("all_category") : "";
			$type_photo 		= $this->input->post("type_photo") ? $this->input->post("type_photo") : "";
			$location_photo		= $this->input->post("location_photo") ? $this->input->post("location_photo") : "";
			$nav 				= $this->input->post("nav") ? $this->input->post("nav") : 0;
			$limit 				= $this->input->post("number_nav_page") ? $this->input->post("number_nav_page") : 21;
			$photo_not_show 	= $this->input->post("id_photo_show") ? $this->input->post("id_photo_show") : "";
			$slug    			= $this->input->post("slug_category") ? $this->input->post("slug_category") : "";
			$offset 			= ($nav) * ($limit);
			$keyword 			= addslashes($keyword);
			$this->load->model("Photo_model");
			if(trim($location_photo) != ""){
				$location_photo = explode(",",$location_photo);
				$location_photo = array_diff($location_photo, array(''));
			}
			$category_full  = array();
			if ($all_category != "") {
				$category_table = $this->Common_model->get_result("categories",array("pid !=" => 0));
				$all_category   = explode(",", $all_category);
				if(count($all_category) > 0){
					foreach ($all_category as $key => $value) {
						if(trim($value) !=""){
							if(trim($value) !=""){
								$category_full []   = $this->get_children_cat($value,$category_table).$value;
								$this->children_cat = "";
							}
						}
					}
				}
			}
			if ($photo_not_show != "") {
				$photo_not_show = explode(",", $photo_not_show);
				$photo_not_show = array_diff($photo_not_show, array(''));
			}
			$data["post"] = $_POST;
			$data["id_photo_show"] = "";
			if ($keyword == "" && $all_category == "" && $photo_not_show == "" && $slug == "" && $location_photo == "") {
				$record = $this->Photo_model->search_index($this->user_id, 21, "", $slug);
				foreach($record as $value) {
					$data["id_photo_show"].= $value["photo_id"] . ",";
				}
			}
			else {
				$record = $this->Photo_model->seach_photo($location_photo,$this->user_id, $keyword, $category_full, $type_photo, $offset, $limit, $photo_not_show, $slug);
			}
			$data["record"] = $record;
			$photo_id = "";
			foreach($record as $value) {
				$photo_id[] = $value["photo_id"];
			}
			$recorder = array();
			if(is_array($record) && count($record) > 0):
			foreach($record as $key => $value) {
				$value["comment_photo"] = $this->Photo_model->get_comment_photo($value["photo_id"]);
				$recorder[] = $value;
			}
			endif;
			$data["total_page"] = $this->Photo_model->total_page($location_photo,$keyword, $category_full, $type_photo, $slug);
			$data["photo"] = $this->view_seach($recorder);
			
			die(json_encode($data));
		}
		else {
			redirect(base_url());
		}
	}

	public function get_photos_like()
	{
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
		}
	}

	private function view_seach($photo)
	{
		if (isset($photo) && count($photo) > 0) {
			$html = "";
			$index = count($photo);
			foreach($photo as $value) {
				$photo_id = $value["photo_id"];
				$images = ($value['thumb'] != "" && file_exists(FCPATH . $value['thumb'])) ? $value['thumb'] : $value['path_file'];
				$html.= '<div class="card">
                            <div class="card-wrapper" id ="wrapper-impormant-image" data-id = "' . $photo_id . '">
                                <div id="redirect-href" data-href="' . base_url("photos/" . $photo_id) . "/" . gen_slug($value["name"]) . '" ><div class="card-image relative" style="background-image:url(\'' . base_url($images) . '\') ">';
				if( $value["images_point"] > 0):
				    $html.= '<div id="point"><img src="'.skin_url("images/rotatingImageTag.png").'"></div>';
				endif;
				$no_bg = "";
				if ($value ["type_member"] == 0) {
					$no_bg = 'not_bg';
				}
				$html.= '<div class="impromation-project ' . $no_bg . '">';
				$no_bg = "";
				if ($value["type_member"] != 0) {
					$business_description = (isset($value['business_description'])) ? trim($value['business_description']) : "";
					$business_description = str_replace(";", "", $business_description);
					$before = strlen($business_description) - 1;
					$after = $before + 1;
					if (substr($business_description, $before, $after) == ",") {
						$business_description = substr($business_description, 0, -1);
					};
					$logo = ($value['logo'] != "" && file_exists(FCPATH . $value['logo'])) ? base_url($value['logo']) : base_url("skins/images/signup.png");
					$html.= '<div class="logo-company">
                                    <img src="' . $logo . '">
                                    <p><strong>' . @$value['company_name'] . '</strong><br />' . @$business_description . '</p>
                        </div>';
				}
				$html.= '<div class="impromation-project-dropdown">
                                <div class="dropdown-impromation relative">
                                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                    <ul class="dropdown-impromation-menu">
                                      <li><a href="#">Residential...</a></li>
                                      <li><a href="#">Inappropriate...</a></li>
                                      <li><a href="#">Wrong category...</a></li>
                                      <li><a href="#">Unauthorized image use...</a></li>
                                    </ul>
                                </div>
                            </div>
                    </div>
                </div></div>';
				$images_like = "";
				$title_like = "Click here to like.";
				if ($value["member_total"] == 1) {
					$images_like = " like";
					$title_like  = "Click here to unlike.";
				}
				$num_comment = ($value['num_comment'] != "") ? $value['num_comment'] : "0";
				$html.= '<div class="commen-like" id="search-home-show">
                            <div class="row">
                                <div class="col-xs-3 col-md-3 text-center"><div class="likes"><p><span id="number-like">' . $value["num_like"] . '</span> Likes</p><h3 id ="like-photo" data-id ="' . $photo_id . '"><i class="fa fa-heart'.$images_like.'" title="'.$title_like.'"></i></h3></div></div>
                                <div class="col-xs-2 col-md-2 text-center remove-l-padding"><div class="microsite"><p style="height:14px"></p><p><a href="' . base_url("profile/index/" . $value["id"]) . '" title="Go to microsite."><h3><i class="fa fa-microsite" title="Click here to comment."></i></h3></a></p></div></div>
                                <div class="col-xs-7 col-md-7 remove-l-padding"><p><span id="num-comment">' .$num_comment. '</span> Comments</p>
                                    <div class="comment">
                                        <h3 id="comment-show"><span class="glyphicon glyphicon-comment" aria-hidden="true" title="Click here to comment."></span> Comment</h3>
                                    </div>
                                </div>
                            </div>
                        </div>';
				$num_like = (trim($value["num_like"]) != "" && trim($value["num_like"]) != null ) ? $value["num_like"] : "0";
				$html.= '<div class="card-info">
				            <div class="close_box">x</div>
				         	<div class="card-top">';
					    	if($num_comment > 3) :
					    		$html.= '<span class="more-comment" data-type="photo"><i class="fa fa-comment"></i> View older comments…</span>';
					    	endif;
			    $html.= '</div><div class="uesr-box-impromation" id="scrollbars-dw">';
				$html.= '<div class="avatar">';
				if (isset($value['comment_photo']) && count($value['comment_photo']) > 0) {
					foreach($value['comment_photo'] as $key => $value) {
						$logo_user = ($value['avatar'] != "" && file_exists(FCPATH . $value['avatar'])) ? base_url($value['avatar']) : base_url("skins/images/signup.png");
						$company_name = "";
						if($value['company_name'] != null && $value['company_name'] != ""){
						    $company_name =" | ".$value['company_name'];
						}
                        $owned_comment = "";
						if($value["member_id"] == $this->user_id){
							$owned_comment = '<span class="action-comment">
								<a data-id="'.$value["member_id"].'" class="edit-comment" href="#"><i class="fa fa-pencil"></i></a>
								<a data-id="'.$value["member_id"].'" class="delete-comment" href="#"><i class="fa fa-times"></i></a>
							</span>';
						}
						$html.= '<div class="row">
                            <div class="col-xs-2 remove-padding"><img src="' . $logo_user . '" class="left"></div>
                            <div class="col-xs-10 box-impromation">
                                <p class="text-comment" data-id="'.$value["id"].'"><a href ="'.base_url("profile/index/".$value["member_id"]).'"><strong>' . $value['first_name'] . '" "' . $value['last_name'] . $company_name . '</strong></a></p>
                                <p>' . $value['comment'] .$owned_comment. '</p>
                            </div>
                        </div>';
					}
				}
				$html.= '</div>';
				$html.= '</div>
							<div class="box-input-comment">
								<div class="relative">
										<textarea id="content-comment"></textarea>
										<div class="action text-right">
											<button  class="btn btn-gray clear button-singin" id="clear-text">Clear Text</button>
											<button class="sign-in btn btn-primary button-singin" data-id = "' . $photo_id . '" id="add-comment">Add Comment</button>
											</div>
										</div>
								</div>
                            </div>';
				$html.= '</div>
				</div>';
				$index--;
			}

			return $html;
		}
	}
	function get_all_comment_photo(){
    	if($this->input->is_ajax_request()) {
    		$photo_id = $this->input->post("photo_id");
    		if(is_numeric($photo_id) && $photo_id > 0){
    			$this->load->model("Photo_model");
    			$get_all_comment = $this->Photo_model->get_comment_photobyid(array($photo_id));
    		    die(json_encode($get_all_comment));
    		} 
    	}else{
			redirect(base_url());
		}
    }
    function get_comment_photo($ojb = null){
    	if($this->input->is_ajax_request()) {
    		$photo_id = $this->input->post("photo_id");
    		if(is_numeric($photo_id) && $photo_id > 0){
    			$this->load->model("Photo_model");
    			$get_all_comment = $this->Photo_model->get_comment_photo($photo_id,0,99,$ojb);
    			$data["user_id"] = $this->user_id;
    			$data["comment"] = $get_all_comment;
    		    die(json_encode($data));
    		} 
    	}else{
			redirect(base_url());
		}
    }
    private $children_cat = "";
    private function get_children_cat ($cat_id,$arg_full){
        foreach ($arg_full as $key => $value) {
       	    if($cat_id == $value["pid"]){
       	   		$this->children_cat.= $value["id"].",";
       	   		unset($arg_full[$key]);
       	   		$this->get_children_cat($value["id"],$arg_full);	
       	    }
       }
       return $this->children_cat;
    }
}