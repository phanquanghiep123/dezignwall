<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo_category_model extends CI_Model {

    var $table_name = 'photo_category';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function add_photo_cat($data, $photo_id) {
    	$arrData = array();
    	$i = 0;
    	foreach ($data as $cat_id)
	    {
	    	if (!empty($cat_id)) {
	        	$arrData[$i++] = array('category_id' => $cat_id, 'photo_id' => $photo_id);
	        }
	    }
	    if (count($arrData) != 0) {
	    	$this->db->trans_start();
			$this->db->insert_batch($this->table_name, $arrData); 
			$this->db->trans_complete();
		}
    }
    
    public function get_all_photo_category() {
    	$this->db->select('*');
    	$this->db->from($this->table_name);
    	return $this->db->get()->result_array();
    }
    
    public function update_first_category($item) {
    	$sql = $this->db->query("UPDATE {$this->table_name} SET first_child_category = 
    			(SELECT T2.id FROM ( SELECT @r AS _id, (SELECT @r := pid FROM categories WHERE id = _id) AS pid, 
    				@l := @l + 1 AS lvl FROM (SELECT @r := " . $item["category_id"] . ", @l := 0) vars, categories h WHERE @r <> 0) 
    				T1 JOIN categories T2 ON T1._id = T2.id ORDER BY T1.lvl DESC LIMIT 1) 
    			WHERE category_id = " . $item["category_id"] . " AND photo_id = " . $item["photo_id"] . "");
    }

   public function add_photo_cat_batch($data){
        $this->db->trans_start();
        $this->db->insert_batch($this->table_name, $data); 
        $this->db->trans_complete();
    }
    function delete_category_by_photo_id($photo_id){
    	$this->db->delete($this->table_name, array('photo_id' => $photo_id)); 
    }
    public function get_all_byphoto_id($photo_id){
        $this->db->select('ctp.*,ct.title,ct.pid');
        $this->db->from($this->table_name." AS ctp");
        $this->db->join('categories AS ct', 'ct.id = ctp.category_id AND ctp.photo_id = '.$photo_id.'');
        $query = $this->db->get();
        return $query->result_array();
    }


}