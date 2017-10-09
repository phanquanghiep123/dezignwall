<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_model extends CI_Model

{
    var $_table_categories = 'categories';
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_categories() {
         $this->db->select('pd.id,pd.title,pd.pid');
         $query = $this->db->get(''.$this->_table_categories.' as pd');
         return $query->result_array(); 
    }
    
    function get_category_by_slug($slug) {
				$this->db->select('*');
        $this->db->where('title', $slug);
		$query = $this->db->get(''.$this->_table_categories);
		return $query->row_array();
    }

}