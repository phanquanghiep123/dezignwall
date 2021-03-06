<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company_model extends CI_Model {

    var $table = 'company';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_row($arr_where) {
        $this->db->where($arr_where);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function add($arr) {
        $this->db->trans_start();
        $this->db->insert($this->table, $arr);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function update($arr, $arr_where) {
        $this->db->trans_start();
        $this->db->where($arr_where);
        $this->db->update($this->table, $arr);
        $this->db->trans_complete();
    }

    function delete($arr_where) {
        $this->db->trans_start();
        $this->db->delete($this->table, $arr_where);
        $this->db->trans_complete();
    }

    /* ------------------------new-------------------------------- */

    function get_record_by_business_type($business_type = array()) {
        $this->db->select('cp.*');
        $this->db->from("company");
        $this->db->where_in("business_type", $business_type);
        return $this->db->get()->result_array();
    }

    function get_business_type_all($where = null, $slug = null) {
        $this->db->distinct();
        $this->db->select("cp.*,bc.title AS title_business_categories,mb.company_about,mb.logo,mb.id AS member_id,mb.email");
        $this->db->from("company" . " AS cp");
        $this->db->join("business_categories" . " AS bc", 'bc.slug = cp.business_type');
        $this->db->join("members" . " AS mb", 'mb.id = cp.member_id');
        if ($where != null) {
            $this->db->where($where);
        }
        if ($slug != null) {
            $this->db->like('cp.business_description', $slug);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_business_seach($where_in = null, $slug = null, $city = null, $state = null, $country = null, $offset = null, $limit = null) {
        $sql_where_in = "";
        $sql_slug = "";
        $sql_city = "";
        $sql_state = "";
        $sql_country = "";
        $sql_limit = "";
        if ($where_in != null && is_array($where_in)) {
            $text = "";
            $where_in = array_diff($where_in,array(""));
            foreach ($where_in as $key => $value) {
                if (trim($value) != "") {
                    $text.= '"' . trim($value) . '",';
                }
            }
            $text = substr($text, 0, -1);
            $sql_where_in = " WHERE ( `cp`.`business_type` IN (" . $text . ") )";
        }
        if ($slug != null && is_array($slug)) {
            $slug = array_diff($slug,array(""));
            foreach ($slug as $key => $value) {
                if (trim($value) != "") {
                    if ($key == 0) {
                        $sql_slug.=" AND (`cp`.`business_description` LIKE '%" . trim($value) . "%'";
                    } else {
                        $sql_slug.=" OR `cp`.`business_description` LIKE '%" . trim($value) . "%')";
                    }
                }
            }
            $sql_slug.=")";
        }
        if ($city != null) {
            $sql_city = " AND  (`cp`.`city` LIKE '%" . trim($city) . "%' )";
        }
        if ($state != null) {
            $sql_state = " AND  (`cp`.`state` LIKE '%" . trim($state) . "%' )";
        }
        if ($country != null) {
            $sql_country = " AND  (`cp`.`country` LIKE '%" . trim($country) . "%' )";
        }
        if ($limit != null) {
            $sql_limit = " limit " . $offset . "," . $limit . "";
        }
        $sql = "SELECT DISTINCT `cp`.*, `bc`.`title` AS `title_business_categories`, `mb`.`company_about`, `mb`.`logo`, `mb`.`id` AS `member_id`, `mb`.`email` FROM `company` AS `cp` JOIN `business_categories` AS `bc` ON `bc`.`slug` = `cp`.`business_type` JOIN `members` AS `mb` ON `mb`.`id` = `cp`.`member_id` " . $sql_where_in . $sql_slug . $sql_city . $sql_state . $sql_country . $sql_limit . "";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_business_seach_all($where_in = null, $slug = null, $city = null, $state = null, $country = null) {
        $sql_services = "";
        $sql_where_in = "";
        $sql_slug = "";
        $sql_city = "";
        $sql_state = "";
        $sql_country = "";
        if ($where_in != null) {
            $text = "";
            foreach ($where_in as $key => $value) {
                if (trim($value) != "") {
                    $text.= '"' . trim($value) . '",';
                }
            }
            $text = substr($text, 0, -1);
            $sql_where_in = " WHERE ( `cp`.`business_type` IN(" . $text . ") )";
        }
        if ($slug != null) {
            foreach ($slug as $key => $value) {
                if (trim($value) != "") {
                    if ($key == 0) {
                        $sql_slug.=" AND (`cp`.`business_description` LIKE '%" . trim($value) . "%'";
                    } else {
                        $sql_slug.=" OR `cp`.`business_description` LIKE '%" . trim($value) . "%'";
                    }
                }
            }
            $sql_slug.=")";
        }
        if ($city != null) {
            $sql_city = " AND  (`cp`.`city` LIKE '%" . trim($city) . "%' )";
        }
        if ($state != null) {
            $sql_state = " AND  (`cp`.`state` LIKE '%" . trim($state) . "%' )";
        }
        if ($country != null) {
            $sql_country = " AND  (`cp`.`country` LIKE '%" . trim($country) . "%' )";
        }
        $sql = "SELECT DISTINCT `cp`.*, `bc`.`title` AS `title_business_categories`, `mb`.`company_about`, `mb`.`logo`, `mb`.`id` AS `member_id`, `mb`.`email` FROM `company` AS `cp` JOIN `business_categories` AS `bc` ON `bc`.`slug` = `cp`.`business_type` JOIN `members` AS `mb` ON `mb`.`id` = `cp`.`member_id` " . $sql_where_in . $sql_slug . $sql_city . $sql_state . $sql_country . "AND `mb`.`is_blog` != 'yes'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function get_comment_member($reference_id) {
        $this->db->distinct();
        $this->db->select("cm.*,mb.first_name ,mb.last_name,mb.logo,mb.email,cp.company_name");
        $this->db->from("common_comment" . " AS cm");
        $this->db->join("members" . " AS mb", 'mb.id = cm.member_id AND cm.reference_id = ' . $reference_id . '');
        $this->db->join("company" . " AS cp", 'cp.member_id = mb.id AND cm.reference_id = ' . $reference_id . '');
        $this->db->where("cm.reference_id", $reference_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function or_like_business_description($arg_like = array()) {
        $this->db->distinct();
        $this->db->select("cp.*,bc.title AS title_business_categories,mb.company_about,mb.logo,mb.id AS member_id,mb.email");
        $this->db->from("company" . " AS cp");
        $this->db->join("business_categories" . " AS bc", 'bc.slug = cp.business_type');
        $this->db->join("members" . " AS mb", 'mb.id = cp.member_id');
        if (is_array($arg_like) && count($arg_like) > 0) {
            foreach ($arg_like AS $key => $value) {
                if ($key == 0) {
                    $this->db->like('business_description', $value);
                } else {
                    $this->db->or_like('business_description', $value);
                }
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_like_business($keyword, $where = null) {
        $sql_where = "";
        if ($where != null) {
            $sql_where = " AND (pid = {$where})";
        }
        $sql = 'SELECT * FROM `business_categories` WHERE (title LIKE "%' . $keyword . '%"  OR slug like "%' . $keyword . '%")' . $sql_where . ' LIMIT 0,10';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function another_services($service = array(), $not_service = array(), $not_id = array(), $city = "", $state = "", $country = "") {
        $this->db->distinct();
        $this->db->select("cp.*, bc.title AS title_business_categories, mb.company_about, mb.logo, mb.id AS member_id, mb.email");
        $this->db->from("company AS cp");
        $this->db->join("business_categories AS bc", "bc.slug = cp.business_type");
        $this->db->join("members AS mb", "mb.id = cp.member_id");
        if (is_array($service) && count($service) > 0) {
            $this->db->where_in("cp.business_type", $service);
        }
        if (is_array($not_service) && count($not_service) > 0) {
            $this->db->where_not_in("cp.business_type", $not_service);
        }
        if (is_array($not_id) && count($not_id) > 0) {
            $this->db->where_not_in("cp.id", $not_id);
        }
        if ($city != "") {
            $this->db->where("cp.city", $city);
        }
        if ($state != "") {
            $this->db->where("cp.state", $state);
        }
        if ($country != "") {
            $this->db->where("cp.country", $country);
        }
        $this->db->order_by("cp.created_at", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_company_follow_company ($member_id,$offset = 0,$limit = 8,$order_by ="company_name"){
        $this->db->select("tbl1.*,tbl2.id AS follow_id");
        $this->db->from("company AS tbl1");
        $this->db->join("common_follow AS tbl2","tbl2.owner_id = tbl1.member_id");
        $this->db->where(["tbl2.type_object"=>"company","tbl2.member_id" => $member_id]);
        $this->db->limit($limit,$offset);
        if($order_by == "created_at"){
            $this->db->order_by("tbl2.id","DESC");
        }else{
            $this->db->order_by("tbl1.company_name","ASC");
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    public function count_company_follow_company ($member_id){
        $this->db->select("tbl1.id");
        $this->db->from("company AS tbl1");
        $this->db->join("common_follow AS tbl2","tbl2.owner_id = tbl1.member_id");
        $this->db->where(["tbl2.type_object"=>"company","tbl2.member_id" => $member_id]);
        return $this->db->count_all_results();
    }
    
    public function get_my_follow_company ($member_id,$offset = 0,$limit = 8,$order_by ="company_name"){
        $this->db->select("tbl1.*,tbl2.id AS follow_id");
        $this->db->from("company AS tbl1");
        $this->db->join("common_favorite AS tbl2","tbl2.owner_id = tbl1.member_id");
        $this->db->where(["tbl2.type_object"=>"company","tbl2.member_id" => $member_id]);
        $this->db->limit($limit,$offset);
        if($order_by == "created_at"){
            $this->db->order_by("tbl2.id","DESC");
        }else{
            $this->db->order_by("tbl1.company_name","ASC");
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_my_follow_company ($member_id){
        $this->db->select("tbl1.id");
        $this->db->from("company AS tbl1");
        $this->db->join("common_favorite AS tbl2","tbl2.reference_id = tbl1.id");
        $this->db->where(["tbl2.type_object"=>"company","tbl2.member_id" => $member_id]);
        return $this->db->count_all_results();
    }
    function get_all_30_day_photo_by_company($member_id,$day = null){
        $this->db->select("tbl1.*");
        $this->db->from("photos AS tbl1");
        $this->db->where(["tbl1.member_id" => $member_id ,"tbl1.created_at >=" => $day]);
        $this->db->limit(5);
        $this->db->group_by("tbl1.photo_id");
        $this->db->order_by("tbl1.photo_id","DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    function count_all_30_day_photo_by_company($member_id,$day = null){
        $this->db->select("tbl1.*");
        $this->db->from("photos AS tbl1");
        $this->db->where(["tbl1.member_id" => $member_id ,"tbl1.created_at >=" => $day]);
        return $this->db->count_all_results();
    }
    public function get_active($member_id , $offset = 0 ,$limit = 6){
        $this->db->select("tbl2.*,tbl3.thumb AS photo_thumb,tbl1.type_object,tbl1.type,tbl1.created_at AS enter_active,tbl3.name,tbl3.photo_id,tbl4.company_name,tbl4.member_id,tbl4.logo,tbl3.created_at AS photo_created,tbl4.created_at AS company_created");
        $this->db->from("notifications_common AS tbl1");
        $this->db->join("company AS tbl2","tbl1.member_id = tbl2.member_id AND tbl1.type = 'company'","left");
        $this->db->join('photos AS tbl3',"tbl3.photo_id = tbl1.reference_id AND tbl1.type ='photo'","left");
        $this->db->join("company AS tbl4","tbl1.member_id = tbl4.member_id","left");
        $this->db->where('tbl1.member_owner' ,$member_id);
        $this->db->group_by("tbl1.id");
        $this->db->order_by("tbl1.id","DESC");
        $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }
}
