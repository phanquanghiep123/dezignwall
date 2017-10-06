<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales_rep extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function get_bymember($member_id = 0){
        $this->db->select("*");
        $this->db->from("sales_rep");
        $this->db->where("member_sale_id",$member_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_services($name,$list_id){
        $this->db->select('*');
        $this->db->from('business_categories');
        $list = explode(',', $list_id);
        $list = array_diff($list, array(''));
        if(isset($list) && count($list)>0 ){
            $this->db->where_not_in('title',$list);
        }
        $this->db->like(array('title'=>$name));
        $this->db->where("type","system");
        $this->db->limit(10,0);
        return $this->db->get()->result_array();
    }
    function get_sales_rep_by_member($id = null){
        $this->db->distinct();
        $this->db->select("sr.*,msr.pwd,msr.avatar");
        $this->db->from(" sales_rep AS sr ");
        $this->db->join("member_sale_rep AS msr","msr.id = sr.member_sale_id","LEFT");
        $this->db->where("sr.member_id",$id);
        return $this->db->get()->result_array();
    }
    function get_sales_rep_by_private_member($id = null){
        $this->db->distinct();
        $this->db->select("sr.*,msr.pwd,msr.avatar");
        $this->db->from(" sales_rep AS sr ");
        $this->db->join("member_sale_rep AS msr","msr.id = sr.member_sale_id");
        $this->db->where("msr.id",$id);
        return $this->db->get()->result_array();
    }
    function get_sales_rep_dowload($id = null){
        $this->db->distinct();
        $this->db->select("sr.first_name,sr.last_name,msr.email,msr.created_at");
        $this->db->from("member_sale_rep AS  msr ");
        $this->db->join("sales_rep AS sr","sr.member_sale_id = msr.id","LEFT");
        $this->db->where("msr.member_id",$id);
        return $this->db->get()->result_array();
    }
    function share_contact_admin($user_id){
        $this->db->distinct();
        $this->db->select("mb.first_name,mb.last_name,mb.work_email AS contact_email,sc.*");
        $this->db->from("share_contacts AS sc ");
        $this->db->join("members AS mb","mb.id = sc.member_id");
        $this->db->where(array("sc.member_id" => $user_id,"sc.type_member" => "admin"));
        return $this->db->get()->result_array();
    }
    function get_share_business($user_id){
        $this->db->distinct();
        $this->db->select("sr.first_name,sr.last_name,sr.contact_email,sc.*");
        $this->db->from("sales_rep AS sr");
        $this->db->join("share_contacts AS sc","sc.member_id = sr.member_sale_id AND sr.member_id = {$user_id}");
        $this->db->where(array("sr.member_id" => $user_id,"sc.type_member" => "business"));
        return $this->db->get()->result_array();
    }
}
