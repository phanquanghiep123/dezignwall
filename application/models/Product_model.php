<?php
if (!defined('BASEPATH')) 
	exit('No direct script access allowed');

class Product_model extends MY_Model
{
    var $_table_product = 'products';
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function seclect_product($photo_id,$member_id) 
    {
    	$this->db->select('*');
    	$this->db->where('photo_id',$photo_id);
    	$this->db->where('member_id',$member_id);
		$query = $this->db->get($this->_table_product); 
		return $query->result_array();
    }

    public function get_record($photo_id,$member_id) 
    {
        $this->db->select('*');
        $this->db->where('photo_id',$photo_id);
        $this->db->where('member_id',$member_id);
        $query = $this->db->get($this->_table_product); 
        return $query->row_array();
    }

    public function get_record_photo($photo_id,$memberupdate_id=null,$member_id)
    {
        $this->db->select('*');
        $this->db->where('photo_id',$photo_id);
        if ($member_updated_id != null) {
            $this->db->where('member_updated_id !=', $memberupdate_id);
        }
        $this->db->where('member_id',$member_id);
        $query = $this->db->get($this->_table_product); 

        return $query->row_array();
    }

    public function get_member_product($photo_id,$category)
    {
        $this->db->select('member_id');
        $this->db->where('photo_id',$photo_id);
        $this->db->where('category_id',$category);
        $query = $this->db->get($this->_table_product);
        return $query->row_array(); 
    }
    
    public function get_product_exists($photo_id, $category_id)
    {
        $this->db->select('*');
        $this->db->where('photo_id',$photo_id);
        $this->db->where('category_id',$category_id);
        $query = $this->db->get($this->_table_product); 

        return $query->row_array();
    }

    public function delete_product($product_id,$member_id)
    {
    	$return = false;
    	$this->db->trans_start();
		$return = $this->db->delete($this->_table_product, array('product_id' => $product_id, 'member_id' => $member_id)); 
		$this->db->trans_complete();

		return $return;
    }


    public function delete_product_c($photo_id,$category_id)
    {
        $return = false;
        $this->db->trans_start();
        $return = $this->db->delete($this->_table_product, array('photo_id' => $photo_id, 'category_id' =>$category_id)); 
        $this->db->trans_complete();
        
        return $return;
    }
    
    public function get_product_c($photo_id,$category_id)
    {
        $this->db->select('*');
        $this->db->from($this->_table_product);
        $this->db->where(array("photo_id" => $photo_id, "category_id" => $category_id));
        
        return $this->db->get()->row_array();
    }
    
    public function add_product($data)
    {
        return $this->db->insert("products",$data);
    }

    public function update_product($photo_id,$member_id,$memberupdate_id,$data)
    {
        $this->db->where(array("photo_id"=>$photo_id,"member_id"=>$member_id,"member_updated_id"=>$memberupdate_id));
        $this->db->update('products', $data); 
    }

    public function get_project_invite($token)
    {
        $this->db->select("*");
        $this->db->from("project_invite");
        $this->db->where(array("token"=>$token));
        return $this->db->get()->row_array();
    }

    public function delete_invite_project($token)
    {
        return $this->db->delete("project_invite", array("token" => $token));
    }
    
    public function add_project_member($data)
    {
        return $this->db->insert("project_member",$data);
    }
    
    public function get_product_photo($photo_id,$member_id)
    {
         $table =  array();
         $this->db->select('pt.path_file,pd.product_id,pd.product_name,pd.product_no,pd.price,pd.qty,pd.fob');
         $this->db->from('products as pd');
         $this->db->join('photos as pt', 'pt.photo_id = pd.photo_id AND pt.photo_id='.$photo_id.'','left');
         $this->db->where(array('pd.photo_id'=>$photo_id));
         $table['products_member'] = $this->db->get()->result_array(); 
         $this->db->select('mb.first_name,mb.last_name,pmc.comment,pmc.member_id');
         $this->db->from('product_member_comment as pmc');
         $this->db->join('members as mb','mb.id = pmc.member_id','left');
         $this->db->where(array('pmc.photo_id'=>$photo_id));
         $table['comment'] = $this->db->get()->result_array();
         
         return $table;
    }

    public function delete_product_category($category_id,$photo_id)
    {
         $this->db->delete("product_category",array("category_id"=>$category_id,"product_id"=>$photo_id));
    }
    
    public function get_record_photo_not_mb($photo_id,$category_id)
    {
        $this->db->select('product_name,product_no,price,qty,fob,product_note');
        $this->db->where('photo_id',$photo_id);
        $this->db->where('category_id',$category_id);
        $query = $this->db->get($this->_table_product); 
        return $query->result_array();

    }

}