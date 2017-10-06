<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favorites_model extends CI_Model
{	
    var $_table_favorites = 'favorites';
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }   
    function add_favorites($data)
    {
		$this->db->insert($this->_table_favorites, $data);
    }
    function delete_favorites($favorites_id)
    {
    	$return = false;
    	$this->db->trans_start();
        $arr = array(
            'id' => $favorites_id, 
        );
		$return = $this->db->delete($this->_table_favorites,$arr); 
		$this->db->trans_complete();
		return $return;
    }
	function update_favorites($data, $favorites_id, $member_id)
	{
		$return = false;
        $this->db->trans_start();
    	$this->db->where('id', $favorites_id);
    	$this->db->where('member_id', $member_id);
		$return = $this->db->update($this->_table_favorites, $data);
		$this->db->trans_complete();
		return $return;
    } 
    function get_favorites_id($member_id)
    {
    	$this->db->where('member_id', $member_id);
        $query = $this->db->get($this->_table_favorites);
        return $query->result_array();
    }
}


