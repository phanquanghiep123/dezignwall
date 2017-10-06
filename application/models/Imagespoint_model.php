<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Imagespoint_model extends CI_Model
{
     public $table = "images_point";
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function add($data){
    	$this->db->trans_start();
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function get_record($id,$photo_id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $filter = array("id"=>$id,"photo_id"=>$photo_id);
        $this->db->where($filter);
        return $this->db->get()->row_array();
    }
    function update($data,$filter){
        $this->db->trans_start();
        $this->db->where($filter);
        $this->db->update($this->table,$data);
        $this->db->trans_complete();
    }
    function get_point_byptid($photo_id) {
        $this->db->select('pp.*,pt.path_file');
        $this->db->from("images_point AS pp");
        $this->db->join('photos AS pt', 'pt.photo_id = pp.photo_child_id','left');
        $filter = array("pp.photo_id"=>$photo_id);
        $this->db->where($filter);
        return $this->db->get()->result_array();
    }
    function delete($filter){
    	$this->db->delete($this->table,$filter); 
    }
}

