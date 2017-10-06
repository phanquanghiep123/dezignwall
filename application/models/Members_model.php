<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Members_model extends CI_Model {

    var $_table_members = "members";
    var $_table_company = "company";
    var $_table_photos = 'photos';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function add($arr) {
        $this->db->trans_start();
        /* $this->first_name        = $arr['first_name'];
          $this->last_name         = $arr['last_name'];
          $this->company_name      = $arr['company_name'];
          $this->email             = $arr['email'];
          $this->title             = $arr['job_title'];
          $this->pwd               = $arr['pwd'];
          $this->enable            = $arr['enable'];
          $this->slug_general      = $arr['slug_general'];
          $this->resource_from     = $arr['resource_from'];
          $this->registration_date = date("Y-m-d H:i:s");
          $this->update_date       = date("Y-m-d H:i:s"); */
        $this->db->insert('members', $arr);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function addall($arr) {
        $this->db->trans_start();
        $this->db->insert('members', $arr);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function forgotMember($data, $slug) {
        $this->db->where('slug_general', $slug);
        $this->db->update('members', $data);
    }

    function update($arr) {
        $this->first_name = $arr['first_name'];
        $this->last_name = $arr['last_name'];
        $this->company_name = $arr['company_name'];
        if (!empty($arr['pwd'])) {
            $this->pwd = $arr['pwd'];
        }
        $this->update_date = date("Y-m-d H:i:s");
        $this->db->update('members', $this, array(
            'email' => $arr['email']
        ));
    }

    function update_member($members, $arg) {
        $this->db->where('id', $members);
        $this->db->update('members', $arg);
    }

    function update_status($member_id) {
        $this->db->select('status_member');
        $this->db->from('members');
        $this->db->where("id", $member_id);
        $query = $this->db->get();
        $value_status = $query->row_array();
        $number_update = 1;
        if ($value_status['status_member'] == 1) {
            $number_update = 0;
        }
        $this->db->where('id', $member_id);
        $this->db->update('members', array(
            'status_member' => $number_update
        ));
        //return  $value_status['status_member'];
    }

    function update_token($arr, $email) {
        $this->db->where('email', $email);
        $this->db->update('members', $arr);
    }

    function update_token_member_forget($arr, $slug, $token) {
        $this->db->where('slug_general', $slug);
        $this->db->where('token', $token);
        $this->db->update('members', $arr);
    }

    function chek_token($token, $slug) {
        $query = $this->db->get_where('members', array(
            'slug_general' => $slug,
            'token' => $token
        ));
        return $query->row_array();
    }

    function updateProfile($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('members', $data);
    }

    function get_record_by_email($email) {
        $query = $this->db->get_where('members', array(
            'email' => $email
        ));
        return $query->row_array();
    }

    function get_record_by_verify($email) {
        $query = $this->db->get_where('members', array(
            'email' => $email
        )); // ,'enable' => 1
        return $query->row_array();
    }

    function get_record_by_verifyID($slug) {
        $query = $this->db->get_where('members', array(
            'slug_general' => $slug
        ));
        return $query->row_array();
    }

    function getById($id) {
        $query = $this->db->get_where('members', array(
            'id' => $id
        ));
        return $query->row_array();
    }

    function listMember() {
        $now = strtotime(date("Y-m-d h:i:s"));
        $day = $now - 24 * 60 * 60;
        $show = date("Y-m-d h:i:s", $day);
        $query = $this->db->get_where('members', array(
            'enable' => 1,
            "registration_date <" => "$show"
        ));
        return $query->result();
    }

    function get_admin_login($email, $password) {
        return $this->db->get_where('sa_users', array(
                    'email' => $email,
                    'pwd' => $password,
                    'role !=' => ''
                ))->row_object();
    }

    public function getTableCount() {
        $this->db->select("id");
        $this->db->from('members');
        $query = $this->db->get();
        $result = $query->result();
        if ($query->num_rows() > 0) {
            return (int) $query->num_rows();
        } else {
            return 0;
        }
    }

    public function get_list_member() {
        $this->db->select('count(p.photo_id) as total_photo, m.company_info,m.update_date,m.id');
        $this->db->from('members as m');
        $this->db->join("photos as p", 'm.id=p.member_id', 'LEFT');
        $this->db->where('m.company_info is not null and m.company_info !=""');
        $this->db->order_by('update_date', 'DESC');
        $this->db->group_by("m.id");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_list_company() {
        $this->db->select('count(p.photo_id) as total_photo, c.company_name, c.business_type, c.business_description, c.main_business_ph, c.contact_email, c.created_at, m.id as member_id, o.code, o.updated_code');
        $this->db->from('members as m');
        $this->db->join("company as c", 'm.id=c.member_id', 'LEFT');
        $this->db->join("photos as p", 'm.id=p.member_id', 'LEFT');
        $this->db->join("(SELECT uo.*, o.code, uo.created_at AS updated_code FROM `uses_offer` AS uo, offer AS o WHERE uo.offer_id = o.id) as o", 'm.id=o.member_id', 'LEFT');
        $this->db->where('m.company_name is not null and m.company_name != ""');
        $this->db->order_by('c.created_at', 'DESC');
        $this->db->group_by("m.id");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_photo_by_member($member_id) {
        $this->db->select('path_file,product_name,product_note,thumb');
        $this->db->from('photos');
        $this->db->where(array('member_id' => $member_id));
        return $this->db->get()->result_array();
    }

    function getAllMembers() {
        return $this->db->get('members')->result_array();
    }

    function getAllNormalMembers() {
        return $this->db->get_where('members', array('role' => ''))->result_array();
    }

    function getAllAdmins() {
        return $this->db->get_where('members', array('role !=' => ''))->result_array();
    }

    function del($id) {
        $this->db->where('id', $id);
        $this->db->delete('members');
        return true;
    }

    function updateDetails($id, $dataArr) {
        $this->db->where('id', $id);
        $this->db->update('members', $dataArr);
        return true;
    }

    function check_type_member($id) {
        $this->db->select('m.id,m.type_member,p.max_files');
        $this->db->from('members as m');
        $this->db->join('packages as p', 'p.id = m.type_member');
        $this->db->join('photos as pt', 'pt.member_id = m.id and pt.type = 3 ');
        $this->db->where('m.id', $id);
        return $this->db->get()->result_array();
    }

    function get_record_setting($member_id) {
        $this->db->select('ms.*');
        $this->db->from('member_setting as ms');
        $this->db->where('ms.member_id', $member_id);
        return $this->db->get()->row_array();
    }

    function add_setting($data) {
        $this->db->insert('member_setting', $data);
    }

    function update_setting($data, $member_id) {
        $this->db->where('member_id', $member_id);
        $this->db->update('member_setting', $data);
    }

    function get_history($member_id, $start, $limit) {
        $this->db->select('*');
        $this->db->from('transaction_history');
        $this->db->where('member_id', $member_id);
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    function get_count_history($member_id) {
        $this->db->select('id');
        $this->db->from('transaction_history');
        $this->db->where('member_id', $member_id);
        return $this->db->get()->num_rows();
    }

    function update_social($member_id, $data) {
        $this->db->where('member_id', $member_id);
        $this->db->update('social_api', $data);
    }

    function get_social($member_id) {
        $this->db->select('*');
        $this->db->from('social_api');
        $this->db->where(array(
            'member_id' => $member_id
        ));
        return $this->db->get()->row_array();
    }

    function add_social($data) {
        $this->db->insert('social_api', $data);
    }

    function get_campaign() {
        $this->db->select('*');
        $this->db->from('campaign');
        return $this->db->get()->result_array();
    }

    function delete_campaign($id) {
        $this->db->where('id', $id);
        $this->db->delete('campaign');
    }

    function add_campaign($data) {
        $this->db->trans_start();
        $this->db->insert('campaign', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function update_campaign($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('campaign', $data);
    }

    function get_campaign_id($id) {
        $this->db->select('*');
        $this->db->from('campaign');
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }

    function get_member_country_id($member_id) {
        $this->db->select('*');
        $this->db->from('member_country');
        $this->db->where('member_id', $member_id);
        return $this->db->get()->row_array();
    }

    function add_member_country($data) {
        $this->db->trans_start();
        $this->db->insert('member_country', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function update_member_country($member_id, $data) {
        $this->db->where('member_id', $member_id);
        $this->db->update('member_country', $data);
    }

    function get_collection_services($arr_where = null, $limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->order_by('m.company_name', 'ASC');
        $this->db->order_by('m.update_date', 'DESC');
        $this->db->select('m.*, mci.member_id, mci.company_name, mci.business_description, mci.web_address, mci.year_est, mci.business_description, mci.main_business_ph, mci.contact_email, mci.license_contractor_no, mci.city, mci.state');
        $this->db->from($this->_table_members . " as m");
        $this->db->join($this->_table_company . " as mci", 'mci.member_id = m.id AND mci.id = m.company_id', 'left');

        if (count($arr_where) > 0) {
            if (isset($arr_where["city"]) && !empty($arr_where["city"])) {
                $this->db->like('mci.city', trim($arr_where["city"]));
            }
            if (isset($arr_where["state"]) && !empty($arr_where["state"])) {
                $this->db->like('mci.state', trim($arr_where["state"]));
            }
            if (isset($arr_where["business_description"]) || !empty($arr_where["business_description"])) {
                if (count($arr_where["parent"]) > 0) {
                    $where = "";

                    foreach ($arr_where["parent"] as $item) {
                        $where .= $where == "" ? "(mci.business_description LIKE '%" . trim($item) . ",%')" : " OR (mci.business_description LIKE '%" . trim($item) . ",%')";
                    }
                    $this->db->where("(" . $where . ")");
                } else {
                    $this->db->where("mci.business_description LIKE '%" . trim($arr_where["business_description"]) . ",%'");
                }
            }
            if (isset($arr_where["business_type"]) && !empty($arr_where["business_type"])) {
                $this->db->where("mci.business_type LIKE '%" . trim($arr_where["business_type"]) . "%'");
            } else {
                $this->db->where("mci.business_type NOT LIKE 'photographer'");
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function count_collection_services($arr_where = null) {
        $this->db->select('m.id');
        $this->db->from($this->_table_members . " as m");
        $this->db->join($this->_table_company . " as mci", 'mci.member_id = m.id AND mci.id = m.company_id', 'left');

        if (count($arr_where) > 0) {
            if (isset($arr_where["city"]) && !empty($arr_where["city"])) {
                $this->db->where('mci.city', trim($arr_where["city"]));
            }
            if (isset($arr_where["state"]) && !empty($arr_where["state"])) {
                $this->db->where('mci.state', trim($arr_where["state"]));
            }
            if (isset($arr_where["business_description"]) || !empty($arr_where["business_description"])) {
                if (count($arr_where["parent"]) > 0) {
                    $where = "";

                    foreach ($arr_where["parent"] as $item) {
                        $where .= $where == "" ? "(mci.business_description LIKE '%" . trim($item) . ",%')" : " OR (mci.business_description LIKE '%" . trim($item) . ",%')";
                    }
                    $this->db->where("(" . $where . ")");
                } else {
                    $this->db->where("mci.business_description LIKE '%" . trim($arr_where["business_description"]) . ",%'");
                }
            }
            if (isset($arr_where["business_type"]) && !empty($arr_where["business_type"])) {
                $this->db->where("mci.business_type LIKE '%" . trim($arr_where["business_type"]) . "%'");
            } else {
                $this->db->where("mci.business_type NOT LIKE 'photographer'");
            }
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_totalphotos_bymember($where_member_id) {
        //$this->db->distinct();
        $this->db->select('count(p.photo_id) as total_photo, p.member_id');
        $this->db->from($this->_table_photos . " as p");
        $this->db->where_in("p.member_id", $where_member_id);
        $this->db->where_in("p.type", array(2, 3));
        $this->db->group_by("p.member_id");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_photo_directories($where_member_id) {
        $this->db->select('p.path_file, p.member_id,p.photo_id,p.thumb');
        $this->db->from($this->_table_photos . " as p");
        $this->db->where_in("p.member_id", $where_member_id);
        $this->db->where_in("p.type", array(2, 3));
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_photo_comment_directories($where_member_id) {
        $this->db->select('cmp.*,m.first_name,m.last_name,m.logo,pt.num_rate');
        $this->db->from("photo_comment as cmp");
        $this->db->join("members as m", "m.id=cmp.member_id");
        $this->db->join("photo_tracking as pt", "cmp.photo_id=pt.photo_id");
        $this->db->where_in("m.id", $where_member_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_comment_member($member_id, $limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->select('mc.*,m.first_name,m.last_name,m.avatar');
        $this->db->from('member_comment as mc');
        $this->db->join('members as m', 'm.id=mc.member_id', '');
        $this->db->where(array('mc.member_owner_id' => $member_id, 'mc.comment_member_id' => '0'));
        return $this->db->get()->result_array();
    }

    function get_row_comment_member_id($comment_id) {
        $this->db->select('mc.*,m.first_name,m.last_name,m.avatar');
        $this->db->from('member_comment as mc');
        $this->db->join('members as m', 'm.id=mc.member_id', '');
        $this->db->where(array('mc.id' => $comment_id, 'mc.comment_member_id' => '0'));
        return $this->db->get()->result_array();
    }

    function get_count_all_comment_member($member_id) {
        $this->db->select('count(mc.member_id) as rowcount');
        $this->db->from('member_comment as mc');
        $this->db->join('members as m', 'm.id=mc.member_id', '');
        $this->db->where(array('mc.member_owner_id' => $member_id, 'mc.comment_member_id' => '0'));
        return $this->db->get()->row()->rowcount;
    }

    function get_comment_by_reply($comment_id) {
        $this->db->select('mc.*,m.first_name,m.last_name,m.avatar');
        $this->db->from('member_comment as mc');
        $this->db->join('members as m', 'm.id=mc.member_id', '');
        $this->db->where(array('mc.comment_member_id' => $comment_id));
        $this->db->order_by("mc.id", "asc");
        return $this->db->get()->result_array();
    }

    function get_comment_by_id($comment_id) {
        $this->db->select('mc.*,m.first_name,m.last_name,m.avatar');
        $this->db->from('member_comment as mc');
        $this->db->join('members as m', 'm.id=mc.member_id', '');
        $this->db->where(array('mc.id' => $comment_id));
        return $this->db->get()->row_array();
    }

    function get_comment_member_by_id($comment_id) {
        $this->db->select('*');
        $this->db->from('member_comment');
        $this->db->where(array('id' => $comment_id));
        return $this->db->get()->row_array();
    }

    function delete_comment_member_by_id($comment_id) {
        $this->db->where('id', $comment_id);
        $this->db->delete('member_comment');
    }

    function delete_comment_member_by_parents($comment_id) {
        $this->db->where('comment_member_id', $comment_id);
        $this->db->delete('member_comment');
    }

    function add_comment_member($data) {
        $this->db->trans_start();
        $this->db->insert('member_comment', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function update_comment_member($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('member_comment', $data);
    }

    function add_sales_rep($data) {
        $this->db->trans_start();
        $this->db->insert('sales_rep', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function delete_sales_rep($member_id) {
        $this->db->where('member_id', $member_id);
        $this->db->delete('sales_rep');
    }

    /* ========================new=============================== */

    function get_information_user($id) {
        $this->db->distinct();
        $this->db->select("mb.id,mb.first_name,mb.last_name,mb.logo,cp.company_name,cp.business_description,cp.business_type");
        $this->db->from("members AS mb");
        $this->db->join("company" . " AS cp", "cp.member_id = mb.id AND cp.member_id = " . $id . " ");
        $this->db->where("mb.id", $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    /* ========================!new=============================== */

    public function get_list_user_conversion1() {
        $this->db->select('m.id, m.first_name, m.last_name, m.company_name, m.email, m.registration_date, m.company_about, m.logo, m.avatar, m.banner, m.update_date, count(ml.member_id) as number_logged, c.business_type, c.business_description, c.main_business_ph, c.contact_email, c.web_address, c.city, c.state, c.country, c.certifications, c.service_area, count(p.photo_id) as number_photos, ms.newslettter, ms.general_updates, ms.promotions, ms.research_emails, ms.image_comment, ms.image_like, ms.dezignwall_comment, ms.dezignwall_like, ms.dezignwall_folder_comment, ms.dezignwall_folder_like');
        $this->db->from('members as m');
        $this->db->join("member_login as ml", 'm.id=ml.member_id', 'LEFT');
        $this->db->join("company as c", 'm.id=c.member_id', 'LEFT');
        $this->db->join("photos as p", 'm.id=p.member_id', 'LEFT');
        $this->db->join("member_setting as ms", 'm.id=ms.member_id', 'LEFT');
        $this->db->order_by('m.registration_date', 'DESC');
        $this->db->group_by("m.id");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_list_user_conversion() 
    {
        $sql = "SELECT `m`.`id`, `m`.`first_name`, `m`.`last_name`, `m`.`company_name`, `m`.`email`, `m`.`registration_date`, `m`.`company_about`, `m`.`logo`, `m`.`avatar`, `m`.`banner`, `m`.`update_date`, nl.number_logged, `c`.`business_type`, `c`.`business_description`, `c`.`main_business_ph`, `c`.`contact_email`, `c`.`web_address`, `c`.`city`, `c`.`state`, `c`.`country`, `c`.`certifications`, `c`.`service_area`, np.number_photos,(np.number_upload + np.number_photos) AS number_upload, `ms`.`newslettter`, `ms`.`general_updates`, `ms`.`promotions`, `ms`.`research_emails`, `ms`.`image_comment`, `ms`.`image_like`, `ms`.`dezignwall_comment`, `ms`.`dezignwall_like`, `ms`.`dezignwall_folder_comment`, `ms`.`dezignwall_folder_like` FROM `members` as `m` 
        LEFT JOIN (
         SELECT phototblall.number_photo AS number_photos, phototblall.number_album AS number_upload , phototblall.member_id FROM (SELECT sum(ROUND (   
            (
                LENGTH(album)- LENGTH( REPLACE ( album, 'path','') )) / LENGTH('path')        
            )) AS number_album , Count(photo_id) AS number_photo, member_id FROM `photos` GROUP BY `member_id`) AS phototblall

        ) AS np ON `m`.`id`= np.`member_id` 
        LEFT JOIN (SELECT count(a.id) as number_logged, a.member_id FROM member_login a INNER JOIN members b ON a.member_id = b.id GROUP BY a.member_id) as nl ON `m`.`id`=nl.`member_id` 
        LEFT JOIN `company` as `c` ON `m`.`id`=`c`.`member_id` 
        LEFT JOIN `member_setting` as `ms` ON `m`.`id`=`ms`.`member_id` GROUP BY `m`.`id` ORDER BY `m`.`registration_date` DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_list_activity() {
        $this->db->select('m.id, m.first_name, m.last_name, m.company_name, m.email, c.business_type, c.business_description, c.main_business_ph, c.contact_email, c.web_address, c.city, c.state, c.country, p.name, p.created_at, p.path_file');
        $this->db->from('photos as p');
        $this->db->join("company as c", 'p.member_id=c.member_id', 'LEFT');
        $this->db->join("members as m", 'p.member_id=m.id', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_list_activity2() {
        $this->db->select('m.id, m.first_name, m.last_name, m.company_name, m.email, c.business_type, c.business_description, c.main_business_ph, c.contact_email, c.web_address, c.city, c.state, c.country');
        $this->db->from('members as m');
        $this->db->join("company as c", 'm.id=c.member_id', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();
    }

    /* Get list member will be expires after 7 days */

    public function get_list_member_upgrade($from_date, $to_date) {
        $this->db->select('m.id, m.first_name, m.last_name, m.email, o.type_offer, o.code, p.name as month');
        $this->db->from('member_upgrade as mu');
        $this->db->join("members as m", 'mu.member_id = m.id');
        $this->db->join("offer as o", 'mu.offer_id=o.id');
        $this->db->join("uses_offer as uo", 'uo.member_id = m.id');
        $this->db->join("packages as p", 'p.id = o.type');
        $this->db->where('DATE_FORMAT(mu.upgrade_date_end ,"%Y-%m-%d")>=', $from_date);
        $this->db->where('DATE_FORMAT(mu.upgrade_date_end ,"%Y-%m-%d")<=', $to_date);
        $query = $this->db->get();
        return $query->result_array();
    }

    function count_member_login($limit = "", $offset = "") {
        $text = "";
        if ($offset != "") {
            $text = "LIMIT {$limit},{$offset}";
        }
        $sql = "SELECT `m`.`id`,`m`.`first_name`,`m`.`last_name`,`m`.`email`,(SELECT COUNT(`l`.`id`) FROM `member_login` AS `l` WHERE `l`.`member_id` = `m`.`id`) AS `number_login` FROM `members` AS `m` " . $text . "";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_member_update_profile($limit = "", $offset = "", $data_use = 0) {
        $this->db->select('m.first_name,m.last_name,m.email,m.update_date,cp.*');
        $this->db->from('members as m');
        $this->db->join("company as cp", 'cp.member_id = m.id');
        if ($data_use == 0) {
            $this->db->where("cp.business_type !=", "");
            $this->db->or_where("cp.business_description !=", "");
        }
        if ($offset != "" || $limit != "") {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function engagement($limit = "", $offset = "") {
        $text = "";
        if ($offset != "") {
            $text = " LIMIT {$limit},{$offset}";
        }
        $sql = "SELECT `m`.*, (SELECT COUNT(`pt`.`photo_id`) FROM `photos` AS `pt` WHERE `pt`.`member_id` = `m`.`id`) AS `number_upload_photo`,`c`.`certifications`,`c`.`service_area` FROM `members` AS `m` JOIN `company` AS `c` ON `c`.`member_id` = `m`.`id` WHERE `m`.`type_member` = 1 ORDER BY `number_upload_photo` DESC" . $text . "";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function advanced($limit = "", $offset = "") {
        $this->db->select('ms.*,cp.country');
        $this->db->from('member_setting as ms');
        $this->db->join("company as cp", 'cp.member_id = ms.member_id');
        if ($offset != "" || $limit != "") {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_share_profile($photo_id = 0,$data_old,$order ="DESC",$order_share = "",$count_order = "",$offset = 0,$limit = 3){
        $sql = "SELECT `cv`.`created_at`,`cv`.`member_id`,`mb`.`first_name`,`mb`.`last_name`,`mb`.`company_name`,`mb`.`avatar`,`mb`.`work_email`, `cm1`.`number_proflie`, `cm1`.`created_at` AS date_click, `cm2`.`number_facebook`, `cm2`.`created_at` AS date_fb, `cm3`.`number_twitter`, `cm3`.`created_at` AS date_tw, `cm4`.`number_linkedin`, `cm4`.`created_at` AS date_li,`cm5`.`number_email`, `cm5`.`created_at` AS date_e FROM common_view AS cv 

			LEFT JOIN 

			(SELECT count(id) AS number_proflie, created_at, member_id, reference_id FROM ( SELECT * FROM common_view WHERE type_object = 'profile' AND type_share_view = 'view' AND created_at >= '{$data_old}' AND reference_id = {$photo_id} ORDER BY created_at DESC) AS tb GROUP BY tb.member_id ORDER BY tb.created_at DESC
			    ) AS cm1 ON cv.member_id = cm1.member_id AND cv.reference_id = cm1.reference_id 

			LEFT JOIN 

			(SELECT count(id) AS number_facebook, created_at, member_id, reference_id FROM( SELECT * FROM common_view WHERE type_object = 'profile' AND type_share_view = 'share' AND type_share = 'facebook' AND created_at >= '{$data_old}' AND reference_id = {$photo_id} ORDER BY created_at DESC ) AS tb1 GROUP BY  tb1.member_id ORDER BY tb1.created_at DESC
			    ) AS cm2 ON cv.member_id = cm2.member_id AND cv.reference_id = cm2.reference_id 

			LEFT JOIN 

			(SELECT count(id) AS number_twitter, created_at, member_id, reference_id FROM ( SELECT * FROM common_view WHERE type_object = 'profile' AND type_share_view = 'share' AND type_share = 'twitter' AND created_at >= '{$data_old}' AND reference_id = {$photo_id} ORDER BY created_at DESC) AS tb2 GROUP BY tb2.member_id ORDER BY tb2.created_at DESC ) AS cm3 ON cv.member_id = cm3.member_id AND cv.reference_id = cm3.reference_id 

			LEFT JOIN 

			(SELECT count(id) AS number_linkedin, created_at, member_id, reference_id FROM (SELECT * FROM common_view WHERE type_object = 'profile' AND type_share_view = 'share' AND type_share = 'linkedin' AND created_at >= '{$data_old}' AND reference_id = {$photo_id} ORDER BY created_at DESC) AS tb3 GROUP BY tb3.member_id ORDER BY tb3.created_at DESC
			    ) AS cm4 ON cv.member_id = cm4.member_id AND cv.reference_id = cm4.reference_id 

			LEFT JOIN 

			(SELECT count(id) AS number_email, created_at, member_id, reference_id FROM (SELECT * FROM common_view WHERE type_object = 'profile' AND type_share_view = 'share' AND type_share = 'email' AND created_at >= '{$data_old}' AND reference_id = {$photo_id} ORDER BY created_at DESC) AS tb4 GROUP BY tb4.member_id ORDER BY tb4.created_at DESC) AS cm5 ON cv.member_id = cm5.member_id AND cv.reference_id = cm5.reference_id 

			JOIN 

			members AS mb ON `mb`.`id` = `cv`.`member_id` WHERE `cv`.`member_owner` = {$photo_id} AND `cv`.`member_id` != 0 AND `cv`.`type_object` = 'profile' AND `cv`.`created_at` >= '{$data_old}' ORDER BY `cv`.`created_at` DESC";
		
        if($order_share == ""){

        	$sql = "SELECT * FROM ({$sql}) AS alltbl GROUP BY `alltbl`.`member_id` ORDER BY `alltbl`.`created_at` DESC LIMIT {$offset} , {$limit}";
           
        }else{
        	$sql = "SELECT * FROM ({$sql}) AS alltbl GROUP BY `alltbl`.`member_id` {$count_order} LIMIT {$offset} , {$limit}";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_click_photo($user_id = 0,$type="photo",$data_old,$order="DESC",$order_share ="",$offset = 0,$limit = 3){
        $join_type = "JOIN photos ON photos.photo_id = common_view.reference_id";
        if($type =="blog"){
            $join_type = "JOIN article ON article.id = common_view.reference_id";
        }
        $sql = "SELECT `mb`.`first_name`,`mb`.`last_name`,`mb`.`company_name`,`mb`.`avatar`,`mb`.`work_email`,`cv`.`created_at`,`cv`.`member_id`,`cm1`.`date_click`,`cm1`.`number_proflie` FROM common_view AS cv 
		
		JOIN 
		
		(SELECT count(id) AS number_proflie, member_id, created_at AS date_click FROM ( SELECT common_view.* FROM common_view {$join_type} WHERE common_view.`type_object` = '{$type}' AND common_view.`type_share_view` = 'view' AND common_view.`created_at` >= '{$data_old}' AND common_view.`member_owner` = {$user_id} ORDER BY common_view.created_at DESC) AS tb GROUP BY tb.member_id ORDER BY tb.created_at DESC
		) AS cm1 ON `cm1`.`member_id` = `cv`.`member_id` 
		
		JOIN 

		members AS mb ON `mb`.`id` = `cv`.`member_id` WHERE `cv`.`member_owner` = {$user_id} AND `cv`.`member_id` != 0 AND `cv`.`type_object` = '{$type}' AND `cv`.`created_at` >= '{$data_old}' ORDER BY `cv`.`created_at` DESC";
        if($order_share == ""){
        	$sql = "SELECT * FROM ({$sql}) AS alltbl GROUP BY `alltbl`.`member_id` ORDER BY alltbl.created_at DESC LIMIT {$offset} , {$limit}";
         }else{
        	$sql = "SELECT * FROM ({$sql}) AS alltbl GROUP BY `alltbl`.`member_id` {$order_share} LIMIT {$offset} , {$limit}";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_all_share_profile($user_id = 0,$data_old){
        $this->db->select("*");
        $this->db->from("common_view");
        $filter = array(
            "member_owner" => $user_id,
            "created_at>=" => $data_old,
            "type_object"  => "profile",
            "type_share_view" => "view",
            "member_id !=" => 0
        );
        $this->db->where($filter);
        $this->db->group_by("member_id");
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_all_click_photo($user_id = 0,$type="photo",$data_old){
        $this->db->select("*");
        $this->db->from("common_view");
        $filter = array(
            "member_owner" => $user_id,
            "created_at>=" => $data_old,
            "type_object"  => $type,
            "type_share_view" => "view",
            "member_id !=" => 0
        );
        $this->db->where($filter);
        $this->db->group_by("member_id");
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_photo_comom_view_by_member($user_id,$type_photo,$data_old,$limit = 0, $offset = 5){
        $filter = array(
            "cm.member_owner" => $user_id,
            "cm.type_object"=> $type_photo,
            "cm.member_id !=" => 0,
            "cm.created_at >="  => $data_old
        );
        if($type_photo == "blog"){
            $this->db->select('cm.*,at.thumbnail AS path_file');
            $this->db->from("common_view AS cm");
            $this->db->join("article AS at","at.id = cm.reference_id");
        }else{
            $this->db->select('cm.*,at.path_file');
            $this->db->from("common_view AS cm");
            $this->db->join("photos AS at","at.photo_id = cm.reference_id");
        }
        $this->db->where($filter);
        $this->db->group_by("cm.reference_id");
        $this->db->order_by('cm.created_at','DESC');
        $this->db->limit($offset,$limit);
        return $this->db->get()->result_array();
    }
    function get_photo_profile($photo_id = 0,$type_photo = "photo",$data_old,$order ="DESC",$order_share = "",$count_order = "",$offset = 0,$limit = 3){
        $sql = "SELECT `cv`.`created_at`,`cv`.`member_id`,`mb`.`first_name`,`mb`.`last_name`,`mb`.`company_name`,`mb`.`avatar`,`mb`.`work_email`, `cm1`.`number_proflie`, `cm1`.`created_at` AS date_click, `cm2`.`number_facebook`, `cm2`.`created_at` AS date_fb, `cm3`.`number_twitter`, `cm3`.`created_at` AS date_tw, `cm4`.`number_linkedin`, `cm4`.`created_at` AS date_li,`cm5`.`number_email`, `cm5`.`created_at` AS date_e FROM common_view AS cv 

		LEFT JOIN 

		(SELECT count(id) AS number_proflie, created_at, member_id, reference_id FROM 
           ( SELECT * FROM  common_view WHERE type_object = '{$type_photo}' AND type_share_view = 'view' AND created_at >= '{$data_old}' AND `reference_id` = {$photo_id} ORDER BY created_at DESC ) AS tb GROUP BY tb.member_id ORDER BY tb.created_at DESC
           ) AS cm1 ON cv.member_id = cm1.member_id AND cv.reference_id = cm1.reference_id  

		LEFT JOIN 

		(SELECT count(id) AS number_facebook, created_at, member_id, reference_id FROM (
			SELECT * FROM  common_view WHERE type_object = '{$type_photo}' AND type_share_view = 'share' AND type_share = 'facebook' AND created_at >= '{$data_old}' AND `reference_id` = {$photo_id} ORDER BY created_at DESC) AS tb1 GROUP BY tb1.member_id ORDER BY tb1.created_at DESC 
			) AS cm2 ON cv.member_id = cm2.member_id AND cv.reference_id = cm2.reference_id 

		LEFT JOIN 

		(SELECT count(id) AS number_twitter, created_at, member_id, reference_id FROM( SELECT * FROM common_view WHERE type_object = '{$type_photo}' AND type_share_view = 'share' AND type_share = 'twitter' AND created_at >= '{$data_old}' AND `reference_id` = {$photo_id} ORDER BY created_at DESC) AS tb2 GROUP BY tb2.member_id ORDER BY tb2.created_at DESC
		) AS cm3 ON cv.member_id = cm3.member_id AND cv.reference_id = cm3.reference_id 

		LEFT JOIN 

		(SELECT count(id) AS number_linkedin, created_at, member_id, reference_id FROM ( SELECT * FROM common_view WHERE type_object = '{$type_photo}' AND type_share_view = 'share' AND type_share = 'linkedin' AND created_at >= '{$data_old}' AND `reference_id` = {$photo_id} ORDER BY created_at DESC ) AS tb3 GROUP BY tb3.member_id ORDER BY tb3.created_at DESC
		) AS cm4 ON cv.member_id = cm4.member_id AND cv.reference_id = cm4.reference_id 

		LEFT JOIN 

		(SELECT count(id) AS number_email, created_at, member_id, reference_id FROM ( SELECT * FROM common_view WHERE type_object = '{$type_photo}' AND type_share_view = 'share' AND type_share = 'email' AND created_at >= '{$data_old}' AND `reference_id` = {$photo_id} ORDER BY created_at DESC) AS tb4 GROUP BY tb4.member_id ORDER BY tb4.created_at DESC) AS cm5 ON cv.member_id = cm5.member_id AND cv.reference_id = cm5.reference_id 
		
		JOIN 

		members AS mb ON `mb`.`id` = `cv`.`member_id` WHERE `cv`.`reference_id` = {$photo_id} AND `cv`.`member_id` != 0 AND `cv`.`type_object` = '{$type_photo}' AND `cv`.`created_at`>= '{$data_old}' ORDER BY cv.created_at DESC";
        
        if($order_share == ""){
        	$sql = "SELECT * FROM ({$sql}) AS alltbl GROUP BY alltbl.member_id ORDER BY alltbl.created_at DESC LIMIT {$offset} ,{$limit}";
        }else{
        	$sql = "SELECT * FROM ({$sql}) AS alltbl GROUP BY alltbl.member_id {$count_order} LIMIT {$offset} ,{$limit}";
        }
		
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_all_photo_profile($photo_id = 0,$type_photo = "photo",$data_old){
        $this->db->select("*");
        $this->db->from("common_view");
        $filter = array(
            "reference_id" => $photo_id,
            "created_at>=" => $data_old,
            "type_object"  => $type_photo,
            "member_id !=" => 0
        );
        $this->db->where($filter);
        $this->db->group_by("member_id");
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_member_designwalls($id){
        $this->db->select("p.*");
        $this->db->from("member_expand AS me");
        $this->db->join("packages AS p", "p.id = me.package_id");
        $this->db->where("me.member_id",$id);
        $query = $this->db->get();
        return $query->row_array();
    }
}

/* Location: ./application/models/member_model.php */