<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comments extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $cookie = array(
            'name' => 'member_id',
            'value' => $this->user_info["id"],
            'expire' => '86500'
        );
        $this->input->set_cookie($cookie);
        $this->load->model('Category_model');
        $this->load->model('Members_model');
        $data["is_login"] = true;
    }

    /* Add comment or update comment */

    public function add($object_id = null, $type_object = null) {
        $array_type_comment = array('member', 'project', 'category', 'photo', 'product','blog');
        if ($this->input->is_ajax_request() && isset($object_id) && is_numeric($object_id) && $type_object != null && in_array($type_object, $array_type_comment)) {
            $this->load->model('Comment_model');
            $this->load->model('Tracking_model');
            // Check setting of this user?
            //$is_allow_comment = $this->get_allow_by_setting($type_object, $object_id);
            $is_allow_comment = true;
            if (!$is_allow_comment) {
                die(json_encode(array("status" => "false", "message" => "Disallow comment at the moment")));
            }
            $date = date('Y-m-d H:i:s');
            $data = array(
                "member_id" => $this->user_info["id"],
                "reference_id" => $object_id,
                "comment" => $this->input->post('text'),
                "created_at" => $date,
                "type_object" => $type_object,
                "pid" => 0
            );
            $comment_id = $this->Comment_model->add($data);
            if (is_numeric($comment_id)) {
                $row = $this->Tracking_model->get_tracking_row($object_id, $type_object);
                $qty_comment = 1;
                if ($row != null && is_numeric($row["id"])) { // Update record
                    $qty_comment = $row['qty_comment'];
                    $qty_comment = is_numeric($qty_comment) ? ++$qty_comment : 1;
                    $this->Tracking_model->pupdate(array("qty_comment" => $qty_comment), array("reference_id" => $object_id, "type_object" => $type_object));
                } else { // Add new record
                    $this->Tracking_model->add(array("qty_comment" => $qty_comment, "qty_like" => 0, "qty_rating" => 0, "qty_pintowall" => 0, "reference_id" => $object_id, "type_object" => $type_object));
                }
                $filter = array("member_id" => $this->user_info["id"]);
                $company = $this->Common_model->get_record("company", $filter);
                $filter = array("id" => $this->user_info["id"]);
                $user = $this->Common_model->get_record("members", $filter);
                $result = array(
                    "status" => "true",
                    "date" => $date,
                    "created_at" => $date,
                    "comment_id" => $comment_id,
                    "num_comment" => $qty_comment,
                    "logo" => @$user["logo"],
                    "full_name" => @$this->session->userdata['user_info']['full_name'],
                    "avatar" => @$this->session->userdata['user_info']['avatar'],
                    "company" => @$this->session->userdata['user_info']["company_name"],
                    "member_id" => @$this->user_info["id"]
                );
                if($type_object == "photo"){
                    $insert_data = array(
                        "id"           => $comment_id,
                        "avatar"       => @$this->session->userdata['user_info']['avatar'],
                        "member_id"    => @$this->user_info["id"],
                        "comment"      => $this->input->post('text'),
                        "created_at"   => $date,
                        "company_name" => @$this->session->userdata['user_info']["company_name"],
                        "first_name"   => @$this->session->userdata['user_info']["first_name"],
                        "last_name"    => @$this->session->userdata['user_info']["last_name"],
                        "logo"         => @$user["logo"]
                    );
                    $filter = array(
                        "photo_id" => $object_id
                    );
                    $data_update = array(
                        "last_comment" => json_encode($insert_data)
                    );
                    $this->Common_model->update("photos", $data_update, $filter);
                }
                // Get info from object_id
                $member_owner = $this->get_owner_object($type_object, $object_id);
                // Send mail
                $mail_subject = $member_owner["subject"];
                $mail_content = $member_owner["content"] . '<p style="margin:0">&nbsp;</p>
									<p style="font-style:italic;color:#7f7f7f">Tip: Responding to comments directly improves your engagement with potential clients.</p>
									<p style="margin:0">&nbsp;</p>
    								<img src="' . skin_url() . '/images/logo-email.png" alt="Dezignwall">
    								<p>The bold new way to find and share commercial design inspiration.</p>
    								<p style="margin:0">&nbsp;</p>
    								<p>Dezignwall, Inc. | 1621 Alton Pkwy #250 Irvine, CA 92606 | (949) 988-0604 | <a href="http://www.dezignwall.com">www.dezignwall.com</a></p>';
                $mail_to = $member_owner["mailto"];
                sendmail($mail_to, $mail_subject, $mail_content);
                $number_like_comment = $this->Common_model->get_record("common_tracking", array(
                    "reference_id" => $object_id,
                    "type_object" => $type_object
                ));
                $qty_comment = 0;
                if(is_array($number_like_comment) && count($number_like_comment) > 0){
                     $qty_comment = $number_like_comment["qty_comment"];
                }
                $result["number_like_comment"] = $qty_comment;
                die(json_encode($result));
            }
        }
        die(json_encode(array("status" => "false")));
    }

    /* Get owner of object */

    private function get_owner_object($type_object, $object_id, $type = 'comment') {
        // Get setting by object_id
        $subject = '';
        $content = '';
        $query = null;
        switch ($type_object) {
            case 'member':
                $sql = 'SELECT company_name, id as member_id FROM members WHERE id=' . $object_id . ' LIMIT 1';
                $query = $this->db->query($sql)->row_array();
                $subject = 'Company Comment | ' . @$query['company_name'] . ' | ';
                $content = '<p>' . $this->user_info["full_name"] . ', of ' . $this->user_info["company_name"] . ' posted a comment about your company:</p>
    						<p>Click here to respond to the comment: <a href="' . base_url('/profile/index/' . @$query['member_id']) . '" style="color:#37a7a7;text-decoration:none;">Respond to comment</a></p>';
                break;
            case 'project':
                $sql = 'SELECT * FROM projects WHERE project_id=' . $object_id . ' LIMIT 1';
                $query = $this->db->query($sql)->row_array();
                $subject = 'Project Comment | ' . @$query['project_name'] . ' | ';
                $content = '<p>' . $this->user_info["full_name"] . ', of ' . $this->user_info["company_name"] . ' posted a comment about your project:</p>
    						<p>Click here to respond to the comment: <a href="' . base_url('/designwalls/index/' . @$query['project_id']) . '" style="color:#37a7a7;text-decoration:none;">Respond to comment</a></p>';
                break;
            case 'product':
                $sql = 'SELECT p.product_name, p.member_id as member_id, pt.path_file, pc.category_id, pc.project_id FROM products AS p, photos AS pt, project_categories AS pc WHERE pt.photo_id = p.photo_id AND p.category_id = pc.category_id AND p.product_id=' . $object_id . ' LIMIT 1';
                $query = $this->db->query($sql)->row_array();
                $subject = 'Image Comment | ' . @$query['product_name'] . ' | ';
                $content = '<p>' . $this->user_info["full_name"] . ', of ' . $this->user_info["company_name"] . ' posted a comment about your photo:</p>';
                $content .= '<img src="' . base_url(@$query['path_file']) . '" width="200px" />
    						<p>Click here to respond to the comment: <a href="' . base_url('/designwalls/photos/' . @$query['project_id'] . '/' . @$query['category_id']) . '" style="color:#37a7a7;text-decoration:none;">Respond to comment</a></p>';
                break;
            case 'photo':
                $sql = 'SELECT path_file, name, member_id, photo_id FROM photos WHERE photo_id=' . $object_id . ' LIMIT 1';
                $query = $this->db->query($sql)->row_array();
                $subject = 'Image Comment | ' . @$query['name'] . ' | ';
                $content = '<p>' . $this->user_info["full_name"] . ', of ' . $this->user_info["company_name"] . ' posted a comment about your photo:</p>';
                $content .= '<img src="' . base_url(@$query['path_file']) . '" width="200px" />
    						<p>Click here to respond to the comment: <a href="' . base_url('/photos/' . @$query['photo_id'] . '/' . gen_slug(@$query['name'])) . '" style="color:#37a7a7;text-decoration:none;">Respond to comment</a></p>';
                break;
            case 'category':
                $sql = 'SELECT b.member_id as member_id, a.title, b.project_id FROM project_categories a, projects b WHERE a.project_id = b.project_id AND category_id=' . $object_id . ' LIMIT 1';
                $query = $this->db->query($sql)->row_array();
                $subject = 'Folder Comment | ' . @$query['title'] . ' | ';
                $content = '<p>' . $this->user_info["full_name"] . ', of ' . $this->user_info["company_name"] . ' posted a comment about your folder:</p>
    						<p>Click here to respond to the comment: <a href="' . base_url('/designwalls/index/' . @$query['project_id']) . '" style="color:#37a7a7;text-decoration:none;">Respond to comment</a></p>';
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

    /* Add reply comment */

    public function reply($object_id = null, $type_object = null) {
        $array_type_comment = array('member', 'project', 'category', 'photo', 'product');
        $reply_id = $this->input->post('reply_id');
        if ($this->input->is_ajax_request() && isset($object_id) && is_numeric($object_id) &&
                isset($reply_id) && is_numeric($reply_id) && $type_object != null && in_array($type_object, $array_type_comment)) {
            $this->load->model('Comment_model');
            $this->load->model('Tracking_model');

            $data = array(
                "member_id" => $this->user_info["id"],
                "reference_id" => $object_id,
                "comment" => $this->input->post('text'),
                "created_at" => date('Y-m-d H:i:s'),
                "type_object" => $type_object,
                "pid" => $reply_id
            );
            $comment_id = $this->Comment_model->add($data);
            if (is_numeric($comment_id)) {
                $row = $this->Tracking_model->get_tracking_row($object_id, $type_object);
                $qty_comment = 1;
                if ($row != null && is_numeric($row["id"])) { // Update record
                    $qty_comment = $row['qty_comment'];
                    $qty_comment = is_numeric($qty_comment) ? ++$qty_comment : 1;
                    $this->Tracking_model->pupdate(array("qty_comment" => $qty_comment), array("reference_id" => $object_id, "type_object" => $type_object));
                } else { // Add new record
                    $this->Tracking_model->add(array("qty_comment" => $qty_comment, "qty_like" => 0, "qty_rating" => 0, "qty_pintowall" => 0, "reference_id" => $object_id, "type_object" => $type_object));
                }
                $filter = array("member_id" => $this->user_info["id"]);
                $company = $this->Common_model->get_record("company", $filter);
                $reulst = array(
                    "status" => "true",
                    "date" => date('Y-m-d H:i:s'),
                    "comment_id" => $comment_id,
                    "num_comment" => $qty_comment,
                    "full_name" => @$this->session->userdata['user_info']['full_name'],
                    "avatar" => @$this->session->userdata['user_info']['avatar'],
                    "company" => @$this->session->userdata['user_info']["company_name"]
                );
                die(json_encode($reulst));
            }
        }
        die(json_encode(array("status" => "false")));
    }

    /* Update comment */

    public function update($type_object = null) {
        $comment_id = $this->input->post('data_id');
        $array_type_comment = array(
            'member',
            'project',
            'category',
            'photo',
            'product',
            'blog'
        );
        if ($this->input->is_ajax_request() && isset($comment_id) && is_numeric($comment_id) && $type_object != null && in_array($type_object, $array_type_comment)) {
            $this->load->model('Comment_model');
            $data = array(
                "comment" => $this->input->post('text')
            );
            if ($this->Comment_model->pupdate($data, array(
                        'id' => $comment_id,
                        'member_id' => $this->user_info["id"],
                        'type_object' => $type_object
                    ))) {
                die(json_encode(array(
                    "status" => "true"
                )));
            }
        }

        die(json_encode(array(
            "status" => "false"
        )));
    }

    /* Delete comment */

    public function delete($object = 'photo', $object_id = null) {
        if ($this->input->is_ajax_request() && isset($object_id) && is_numeric($object_id)) {
            $comment_id = $this->input->post('comment_id');
            $array_type_comment = array(
                'member',
                'project',
                'category',
                'photo',
                'product',
                'blog'
            );
            if (isset($comment_id) && is_numeric($comment_id) && isset($object) && in_array($object, $array_type_comment)) {
                $this->load->model('Comment_model');
                $delete = $this->Comment_model->pdelete(array(
                    'id' => $comment_id,
                    'member_id' => $this->user_info["id"]
                ));
                if ($delete) {
                    $record = $this->Common_model->get_record('common_tracking', array(
                        'type_object' => $object,
                        'reference_id' => $object_id
                    ));
                    $number_comment = @$record['qty_comment'] == null ? 0 : $record['qty_comment'];
                    if (isset($record['qty_comment']) && $record['qty_comment'] > 0) {
                        $arr = array(
                            'qty_comment' => $record['qty_comment'] - 1
                        );
                        $number_comment = @$record['qty_comment'] - 1;
                        $this->Common_model->update('common_tracking', $arr, array(
                            'type_object' => $object,
                            'reference_id' => $object_id
                        ));
                    }
                    $number_like_comment = $this->Common_model->get_record("common_tracking", array(
                        'type_object' => $object,
                        'reference_id' => $object_id
                    ));
                    $qty_comment = 0;
                    if(is_array($number_like_comment) && count($number_like_comment) > 0){
                         $qty_comment = $number_like_comment["qty_comment"];
                    }
                    die(json_encode(array(
                        "status" => "true",
                        'number_comment' => $number_comment,
                        "number_like_comment" => $qty_comment
                    )));
                }
            }
        }

        die(json_encode(array(
            "status" => "false"
        )));
    }

}
