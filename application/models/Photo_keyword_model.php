<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo_keyword_model extends CI_Model {

    var $table_name = 'photo_keyword';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function add_photo_item($data, $photo_id) {
    	$arrData = array();
    	$i = 0;
    	foreach ($data as $item)
	    {
	        $arrData[$i++] = array('keyword_id' => $item, 'photo_id' => $photo_id);
	    }
	    if (count($arrData) != 0) {
	    	$this->db->trans_start();
	    	//$this->db->where('photo_id', $photo_id);
			//$this->db->delete($this->table_name);
			$this->db->insert_batch($this->table_name, $arrData); 
			$this->db->trans_complete();
		}
    }

    function delete_keyword_by_photo_id($photo_id){
    	 $this->db->delete($this->table_name, array('photo_id' => $photo_id)); 
    }
    function get_photo_keyword_byid($photo_id){
		$this->db->select("kw.title");
        $this->db->from("keywords AS kw");
        $this->db->join("photo_keyword AS ptkw", 'ptkw.keyword_id = kw.keyword_id AND ptkw.photo_id = '.$photo_id.'');
        $this->db->where("ptkw.photo_id",$photo_id);
        $query = $this->db->get();
        return $query->result_array();
	}
}