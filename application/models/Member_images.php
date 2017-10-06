<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_images extends CI_Model {

    var $table_name = 'member_images';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_image($img=0) {
        return $this->db->get_where($this->table_name, array('id' => $img))->result_array();
    }

    function get_image_by_member($mem=0) {
        return $this->db->get_where($this->table_name, array('member_id' => $mem))->result_array();
    }

    function add($arr){
        $this->db->insert($this->table_name, $arr); 
        $flag = $this->db->affected_rows();
        if(flag>0){
            return  array('type' => 'successful', 'message' => 'The image was added' );
        }else{
            return  array('type' => 'error', 'message' => 'The image was not added' );
        }
    }

    function update($arr=NULL){
        $this->db->update($this->table_name, $arr); 
        $flag = $this->db->affected_rows();
        if($flag>0){
            return  array('type' => 'successful', 'message' => 'The image was updated' );
        }else{
            return  array('type' => 'error', 'message' => 'The image was not updated' );
        }
    }

    function update_in($arr=NULL,$arr_in=NULL){
        $this->db->where_in('id',$arr_in)->update($this->table_name, $arr); 
        $flag = $this->db->affected_rows();
        if($flag>0){
            return  array('type' => 'successful', 'message' => 'The image was updated' );
        }else{
            return  array('type' => 'error', 'message' => 'The image was not updated' );
        }
    }

    function del($img=0){
        $this->db->delete($this->table_name, array('id' => $id)); 
        $flag = $this->db->affected_rows();
        if(flag>0){
            return  array('type' => 'successful', 'message' => 'The image was del' );
        }else{
            return  array('type' => 'error', 'message' => 'The image was not del' );
        }
    }

    function delete($arr=NULL){
        $this->db->where_in('id',$arr)->delete($this->table_name); 
        $flag = $this->db->affected_rows();
        if(flag>0){
            return  array('type' => 'successful', 'message' => 'The images were delete' );
        }else{
            return  array('type' => 'error', 'message' => 'The images were not delete' );
        }
    }


        

}