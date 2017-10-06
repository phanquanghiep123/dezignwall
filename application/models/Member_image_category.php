<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_image_category extends CI_Model {

    var $table_name = 'member_image_category';
   
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_img_cat($cat=0, $img=0) {
    	return $this->db->get_where($this->table_name, array('image_id' => $img, 'category_id' => $cat))->result_array();
    }
    

}