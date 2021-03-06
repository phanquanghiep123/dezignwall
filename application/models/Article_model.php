<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article_model extends CI_Model
{
    var $_table_photos = 'article';
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }
    function get_public_by_member($member_id = null){
        $this->db->select("a.*,m.avatar,m.company_name,m.first_name,m.last_name");
        $this->db->from($this->_table_photos." AS a");
        $this->db->join("members AS m","m.id = a.member_id");
        $this->db->where("a.member_id",$member_id);
        $this->db->order_by("a.id","DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_keyword_by_id($id = null){
        $this->db->select("k.*");
        $this->db->from("keywords"." AS k");
        $this->db->join("article_keyword AS ak","ak.keyword_id = k.keyword_id");
        $this->db->where("ak.article_id",$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_by_keyword($keyword,$offset = 0,$limit = 3,$not_show = array()){
        $this->db->select("a.*,m.first_name,m.last_name,m.company_name,m.avatar");
        $this->db->from("keywords"." AS k");
        $this->db->join("article_keyword AS ak","ak.keyword_id = k.keyword_id");
        $this->db->join("article AS a","a.id = ak.article_id");
        $this->db->join("members AS m","m.id = a.member_id");
        $this->db->like("k.title",$keyword);
        $this->db->where("k.type","article");
        $this->db->group_by("a.id");
        if($not_show != null){
            $this->db->where_not_in("a.id",$not_show);
        }
        $this->db->where("m.is_blog","yes");
        $this->db->order_by("a.date_create","DESC");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_article($offset = 0,$limit = 3,$not_show = NULL){
        $this->db->select("a.*,m.first_name,m.last_name,m.company_name,m.avatar");
        $this->db->from("article"." AS a");
        $this->db->join("members AS m","m.id = a.member_id");
        $this->db->group_by("a.id");
        if($not_show != null){
            $this->db->where_not_in("a.id",$not_show);
        }
        $this->db->where("m.is_blog","yes");
        $this->db->order_by("a.id","DESC");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }
    function social_post($offset = 0,$limit = 3,$not_show = NULL,$where = null,$member_id = 0,$public = -1){
        $this->db->select("tbl1.*,tbl2.first_name,tbl2.last_name,tbl2.job_title,tbl2.avatar,tbl3.company_name,tbl4.qty_like,tbl4.qty_comment,tbl5.id AS is_like");
        $this->db->from("social_posts AS tbl1");
        $this->db->join("members AS tbl2","tbl2.id = tbl1.member_id");
        $this->db->join("company AS tbl3","tbl3.member_id = tbl2.id");
        $this->db->join("common_tracking AS tbl4","tbl4.reference_id = tbl1.id AND tbl4.type_object='social'","LEFT");
        $this->db->join("common_like AS tbl5","tbl5.reference_id = tbl1.id AND tbl5.member_id = ".$member_id." AND tbl5.status = 1","LEFT");
        if($public == -1){
            $this->db->where("tbl1.public",1);
        }
        if($where != null){
            $this->db->where($where);
        }
        $this->db->group_by("tbl1.id");
        if($not_show != null){
            $this->db->where_not_in("tbl1.id",$not_show);
        }
        $this->db->order_by("tbl1.id","DESC");
        $this->db->limit($limit, $offset);
        $current_post = $this->db->get()->result_array();
        return $current_post;
    }
    function social_post_count($not_show = NULL,$where = null){
        $this->db->select("tbl1.*,tbl2.first_name,tbl2.last_name,tbl2.job_title,tbl2.avatar,tbl3.company_name,tbl4.qty_like,tbl4.qty_comment,tbl5.id AS is_like");
        $this->db->from("social_posts AS tbl1");
        $this->db->join("members AS tbl2","tbl2.id = tbl1.member_id");
        if($where != null){
            $this->db->where($where);
        }
        if($not_show != null){
            $this->db->where_not_in("tbl1.id",$not_show);
        }
        $current_post = $this->db->count_all_results();
        return $current_post;
    }
    function get_comment($member_id,$limit,$start){
        $sql = "SELECT DISTINCT `mb`.`avatar`, MAX(`ptc`.`created_at`), `mb`.`logo`, `mb`.`first_name`, `mb`.`last_name`, `mb`.`company_name`, `pt`.`id` AS photo_id, `pt`.`thumbnail` AS path_file,`pt`.`title` AS name
        FROM `common_comment` AS `ptc`
        JOIN `article` AS `pt` ON `pt`.`id` = `ptc`.`reference_id`
        JOIN `members` AS `mb` ON `mb`.`id` = `ptc`.`member_id`
        WHERE `ptc`.`type_object` = 'blog' 
        AND (`ptc`.`member_id` = '" . $member_id . "' OR `pt`.`id` IN (SELECT DISTINCT cc.reference_id from article as p JOIN common_comment as cc ON
        cc.reference_id = p.id AND cc.type_object='blog' WHERE p.member_id='" . $member_id . "'))
        GROUP BY `pt`.`id` 
        ORDER BY MAX(`ptc`.`created_at`) DESC"; // pt.photo_id DESC
        if ($limit != -1) {
            $sql .= " LIMIT $limit, $start";
        }
 
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
