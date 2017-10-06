<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image_model extends CI_Model {

    var $table_name = 'member_images';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /*
    function get_categories($cat=0) {
    	$sql = "SELECT * FROM $this->table_name WHERE pid = ?"; 
		$query = $this->db->query($sql, array($cat));
		return $query->result();
    }
    */
   function insertImage($arr){
        /*$this->member_id = $arr['member_id'];
        $this->inventory_ids  = $arr['inventory'];
        $this->image_name = $arr['image_name'];
        $this->comment  = $arr['comment'];*/
        $this->db->insert('member_images', $arr);
   }
   function countImageByMember($id){
        $query = $this->db->where(array('member_id' => $id));
        return $query->count_all_results('member_images');
    }

}