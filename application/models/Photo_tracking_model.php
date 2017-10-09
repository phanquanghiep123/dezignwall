<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo_tracking_model extends CI_Model {
    var $table = 'photo_tracking';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_row($arr_where)
    {
        $this->db->where($arr_where);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
    
    function add($arr)
    {
		$this->db->trans_start();
		$this->db->insert($this->table, $arr);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		return $insert_id;
    }
    
    function update($arr, $arr_where)
    {
    	$this->db->trans_start();
    	$this->db->where($arr_where);
        $this->db->update($this->table, $arr); 
		$this->db->trans_complete();
    }
    
}



