<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Directories_model extends CI_Model {

 	
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function add($table, $data)
    {
        $this->db->insert($table, $data);
    }
    
    function delete($table, $where)
    {
        $return = false;
        $this->db->trans_start();
        $return = $this->db->delete($table, $where);
        $this->db->trans_complete();
        return $return;
    }
    
    function update($table, $data, $where)
    {
        $return = false;
        $this->db->trans_start();
        $this->db->where($where);
        $return = $this->db->update($table, $data);
        $this->db->trans_complete();
        return $return;
    }

    function get_record($table,$where){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    function get_result($table,$where){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get()->result_array();
    }
    
    function get_rate($member_owner_id){
        $this->db->select('AVG(num) as rate_num');
        $this->db->from('member_rate');
        $this->db->where(array('member_owner_id'=>$member_owner_id));
        return $this->db->get()->row_array();
    }

    function get_rate_comment($member_owner_id){
        $this->db->select('AVG(num_rate) as num_rate');
        $this->db->from('member_comment');
        $this->db->where(array('member_owner_id'=>$member_owner_id,'num_rate !='=>0));
        return $this->db->get()->row_array();
    }

    function get_all_rate($list_member_id){
        $this->db->select('*');
        $this->db->from('member_tracking');
        $this->db->where_in('member_id',$list_member_id);
        return $this->db->get()->result_array();
    }

    function get_all_comment_company($list_member_id){
        $this->db->select('mc.*,m.first_name,m.last_name,m.logo,m.avatar');
        $this->db->from('member_comment as mc');
        $this->db->join('members as m','m.id=mc.member_id');
        $this->db->where(array('mc.comment_member_id'=>0));
        $this->db->where_in('mc.member_owner_id',$list_member_id);
        $this->db->order_by("mc.id", "desc");
        return $this->db->get()->result_array();
    }

}