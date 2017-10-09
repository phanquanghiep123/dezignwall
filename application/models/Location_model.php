<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_model extends CI_Model {

    var $table_name = 'locations';
    var $table_category_name = 'categories';
    var $table_tag_name = 'tags';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_result($params) {
    	$where_sql = "";
		if (isset($params["main-category"]) && !empty($params["main-category"])) {
			$where_sql .= " AND (L.cat_pid=" . $this->db->escape($params["main-category"]) . ") ";
		}
		if (isset($params["type-category"]) && !empty($params["type-category"])) {
			$where_sql .= " AND (L.cat_id=" . $this->db->escape($params["type-category"]) . ") ";
		}
		if (isset($params["name"]) && !empty($params["name"])) {
			$where_sql .= " AND (L.name LIKE '%".$this->db->escape_like_str($params["name"])."%') ";
		}
		if (isset($params["zipcode"]) && !empty($params["zipcode"])) {
			$where_sql .= " AND (L.zipcode LIKE '%".$this->db->escape_like_str($params["zipcode"])."%') ";
		}
		if (isset($params["city"]) && !empty($params["city"])) {
			$where_sql .= " AND (L.city LIKE '%".$this->db->escape_like_str($params["city"])."%') ";
		}
		// Test
		$where_sql = "";
		
		$sql = "SELECT L.*, C.name as cat_name, T.title as tag_name FROM $this->table_name as L 
					LEFT JOIN $this->table_category_name as C ON C.id = L.cat_id 
					LEFT JOIN $this->table_tag_name as T ON T.id = L.cat_pid 
		  			WHERE 1=1 " . $where_sql; 
		$query = $this->db->query($sql);
		
		return $query->result();
    }

}