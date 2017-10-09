<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_order extends CI_Model {

    var $table_name = 'transaction_history';    
	
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function insert($data)
    {
        $this->db->trans_start();
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function update($arrData)
    {
        $this->first_name = $arrData['first_name'];
        $this->update_date = date("Y-m-d H:i:s");
        $this->db->update('members', $this, array('email' => $arrData['email']));
    }

	function getByMemberid($member_id)
    {
    	$query = $this->db->get_where($this->table_name, array('member_id' => $member_id));
        //return $query->row_array();
        return $query->result_array();
    }

    function getAll()
    {
    	$query = $this->db->get($this->table_name);
    	return $query->result_array();
    }
	// End: =======================================================
}