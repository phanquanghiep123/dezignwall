<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keyword_model extends CI_Model {
    var $table_keywords = 'keywords';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_item($name)
    {
        $this->db->where('title', $name);
        $query = $this->db->get($this->table_keywords);
        return $query->row_array();
    }
    
    function add_item($name)
    {
		$data = array(
			'title' => $name
		);
		$this->db->trans_start();
		$this->db->insert($this->table_keywords, $data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		return $insert_id;
    }

    function get_keywords_by_photo_id($id){
        $this->db->select("pk.*,kw.title");
        $this->db->from('photo_keyword as pk');
        $this->db->join('keywords as kw','pk.keyword_id=kw.keyword_id');
        $this->db->where(array("pk.photo_id"=>$id));
        return $this->db->get()->result_array();
    }
	// End: =======================================================
}

