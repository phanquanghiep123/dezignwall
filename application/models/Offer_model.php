<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Offer_model extends CI_Model
{
    var $_table_photos = 'offer';
    var $_table_tag_photos = 'offer_code';
    
    function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }
    function add($arg){
        $this->db->trans_start();
        $this->db->insert($this->_table_photos,$arg);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function update($id,$arg){
        $this->db->where('id', $id);
        $this->db->update($this->_table_photos,$arg); 
    }
    function add_offer_code($id,$number_item){
    	$this->db->trans_start();
        $data = $this->random_code($id,$number_item);
        $this->db->insert_batch($this->_table_tag_photos,$data); 
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;	
    }
    function get_all(){
        $this->db->select("of.*,pk.max_files");
        $this->db->from($this->_table_photos ." AS of");
        $this->db->join("packages AS pk" ,"pk.id = of.type" );
        $this->db->order_by("of.start_date","DESC");
        $this->db->order_by("of.id","ASC");
    	$query = $this->db->get();
        return $query->result_array();
    }
    function get_all_offercode_byid($id){
        $this->db->select("*");
        $this->db->where( "id_offer",$id);
        $this->db->order_by("id","DESC");
        $query = $this->db->get("offer_code");
        //$query = $this->db->get($this->_table_tag_photos);
        return $query->result_array();
    }
    function checkrecod_code($code,$offer){
    	$this->db->select("*");
        $this->db->where( "code",$code);
        $this->db->where( "id_offer",$offer);
        $query = $this->db->get("offer_code");
        return $query->result_array();
    }
    function user_code_status($code,$user){
        $this->db->select("*");
        $this->db->where( "id_code",$code);
        $this->db->where( "id_user",$user);
        $query = $this->db->get("code_user");
        return $query->result_array();
    }
    function user_code_insert($arg){
        $this->db->trans_start();
        $this->db->insert("code_user",$arg);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function add_code($code,$offer){
    	$arg = array(
    		"code" 		=>$code,
    		"id_offer"	=>$offer,
    		"status"	=>0
    	);
    	$this->db->trans_start();
        $this->db->insert("offer_code",$arg);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function get_all_byid($id){
        $this->db->select("*");
        $this->db->where( "id",$id);
        $query = $this->db->get($this->_table_photos);
        return $query->result_array();
    }
    function delete_offer($id){
         $delete = $this->db->delete($this->_table_photos, array('id' => $id));
         if( $delete){
            $this->db->delete($this->_table_tag_photos, array('id_offer' => $id));
         }
    }
    function delete_offer_code($id,$offer){
        $this->db->delete("offer_code", array('id' => $id));
        //$off_update = count($this->get_all_offercode_byid($offer));
       // $this->db->where('id', $offer);
        //$arg = array("item_offer"=>$off_update);
        //$this->db->update($this->_table_photos,$arg);
       
    }
    function upday_code($id,$arg){
    	$this->db->where('id',$id);
    	$this->db->update("offer_code",$arg);
    }
    function set_code_offer_user($code){
        $check_recoder = $this->check_code($code);
        $date = date("Y-m-d");
        if(count($check_recoder) == 1){
            $id_code = $check_recoder[0]['id'];
            $id_offer = $check_recoder[0]['id_offer'];
            $this->db->select('of.*,oc.id AS id_code');
            $this->db->from($this->_table_photos." AS of");
            $this->db->join("offer_code AS oc", " oc.id_offer = of.id AND of.id = $id_offer ");
            $this->db->where( "oc.id",$id_code);
            $this->db->where( "of.start_date <=",$date);  
            $this->db->where( "of.end_date >=",$date);
            $query = $this->db->get();
            return $query->result_array();
        }  
    }
    function check_code($code){
        $this->db->select("id,id_offer");
        $this->db->where( "code",$code);
        $query = $this->db->get("offer_code");
        return $query->result_array();
    }
    function random_code($id,$number_item = 10,$number_code = 10){
        $arg = array();
        for ( $i=1; $i <= $number_item ; $i++) { 
            $code = substr(md5(($id.uniqid())),0,$number_code);
            if($i==0){
                $arg[]= array("id_offer"=>$id,"code"=>$code);
            }else{
                if($i%20==0){
                    $code = substr(md5($id.$i.uniqid()),0,$number_code);
                }else{
                    $code = substr(md5(($id.$i.$code)),0,$number_code);
                }
                $arg[]= array("id_offer"=>$id,"code"=>$code);
            }
        }
        return $arg;
    }

}
