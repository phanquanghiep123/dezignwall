<?php  
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Product_category_model extends MY_Model {
    var $_table_name = 'product_category';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function add_product_cat($data, $product_id)
    {
    	$arrData = array();
    	$i = 0;
    	foreach ($data as $cat_id) {
	        $arrData[$i++] = array('category_id' => $cat_id, 'product_id' => $product_id);
	    }
	    if (count($arrData) != 0) {
	    	$this->db->trans_start();
	    	$this->db->where('product_id', $product_id);
			$this->db->delete($this->_table_name);
			$this->db->insert_batch($this->_table_name, $arrData); 
			$this->db->trans_complete();
		}
    }
    
    public function add_product_cat_photo($photo,$cat_id)
    {
        $data = array(
            'category_id' => $cat_id,
            'product_id' => $photo
        );
        $this->db->trans_start();
        $this->db->insert($this->_table_name,$data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }
    
    public function seclect_product_cat($product_cat_id)
    {
    	$this->db->select('*');
    	$this->db->where("category_id",$product_cat_id);
		$query = $this->db->get($this->_table_name); 
		return $query->num_rows();
    }
    
    public function delete_product_cat($product_cat_id,$photo_id)
    {
    	$return = false;
    	$this->db->trans_start();
		$return = $this->db->delete('product', array('category_id' => $product_cat_id, 'product_id' => $photo_id)); 
		$this->db->trans_complete();
		return $return;
    }
    
    public function seclect_value($photo_id,$category_id)
    {
        $this->db->select('product_id');
        $this->db->where('photo_id',$photo_id);
        $this->db->where('category_id',$category_id);
        $this->db->from($this->_table_name);
        $query = $this->db->get();
        return  $query->row_array();
    }
    
    public function update_cat($photo_id,$cat_id,$cat_update) 
    {
        $arr_update  = array('category_id' => $cat_update);
        $result = $this->seclect_value($photo_id,$cat_id);
        if ($result != null && $result["product_id"] != null) {
            $table = 'products';
            $this->db->where('photo_id', $photo_id);
        } else {
            $this->db->where('product_id', $photo_id);
        }
        $this->db->where('category_id', $cat_id);
        $this->db->update($this->_table_name, $arr_update);
    }

}


