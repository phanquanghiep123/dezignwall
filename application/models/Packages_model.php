<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Packages_model extends CI_Model {
	var $_table_campaign = "campaign";
    var $_table_packages = 'packages';
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    } 
    
    function get_all_table_packages($type=null)
    {
        if($type==null){
            $this->db->where(array('type'=>0));
        }
        else{
            $this->db->where(array('type'=>1));
        }
    	$query = $this->db->get($this->_table_packages);
    	return $query->result_array();
    }
    
    function get_all_page_packages($package_id=null)
    {
    	$where = array('id' => $package_id);
    	$query = $this->db->get_where($this->_table_packages,$where);
    	return $query->result_array();
    }

    function update_packages($package_id=null,$data){
        $this->db->trans_start();
        $this->db->where(array("id" => $package_id));
        $this->db->update($this->_table_packages, $data);
        $this->db->trans_complete();
    }

    function add_packages($data){
        $this->db->trans_start();
        $this->db->insert($this->_table_packages, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function delete_packages($package_id=null){
        $this->db->where('id',$package_id);
        $this->db->delete($this->_table_packages);
    }
    
    function get_detail_package($package_id=null)
    {
    	$where = array('id' => $package_id);
    	$query = $this->db->get_where($this->_table_packages, $where);
    	return $query->row_array();
    }
    function get_campaign_exist(){
        $this->db->select('*');
        $present_day = date("Y-m-d");
        $this->db->where(array("end_date >="=>$present_day,"start_date <="=> $present_day));
        $query = $this->db->get($this->_table_campaign);
        return $query->row_array();
    }
}
/* Location: ./application/models/member_model.php */