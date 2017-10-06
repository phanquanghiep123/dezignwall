<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Post_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
       
    }


    function get_all_by_type($type=null){

         $this->db->select('*');
        $this->db->order_by("id", "desc");
        $query=$this->db->get_where('post',array('type'=>$type));
    
        return $query->result_array();
    }

    function add($arr){
    	$this->db->trans_start();
        $this->title 		    = $arr['title'];
        $this->slug  		    = $arr['slug'];
        $this->type 		    = $arr['type'];
        $this->content  	    = $arr['content'];
        $this->parent_id 		= $arr['parent_id'];
        $this->template         = $arr['template'];
        $this->created_at  	    = date("Y-m-d H:i:s");
        $this->db->insert('post', $this);
        $insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $insert_id;
    }

    function del($id=nul){
        $this->db->where('id',$id);
        $this->db->delete('post');
        return true;
    }

    function update($arr=nul, $where=null){
       if (array_key_exists('title', $arr)) {
        $this->title = $arr['title'];}

        if (array_key_exists('slug', $arr)) {
        $this->slug = $arr['slug'];}

        if (array_key_exists('content', $arr)) {
        $this->content = $arr['content'];}

        if (array_key_exists('parent_id', $arr)) {
        $this->parent_id = $arr['parent_id'];}

        if (array_key_exists('template', $arr)) {
        $this->template = $arr['template'];}

        $this->db->update('post', $this, $where);
    }

    function get_by_id($id){
        return $this->db->get_where('post',  array('id' => $id))->row_array();
    }

    function count_by_slug($slug=null){
        $this->db->distinct();
        $this->db->from('post');
        $this->db->where('slug', $slug);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

}
