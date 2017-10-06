<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comment_model extends MY_Model
{
    var $_table_name = 'common_comment';
    var $_table_photo_like = 'common_like';
    var $_table_members = 'members';
    var $_table_tracking ='common_tracking';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function add($data)
    {
        return $this->create($this->_table_name, $data);
    }
    
    function pdelete($data)
    {
        return $this->delete($this->_table_name, $data);
    }
    
    function pupdate($data, $data_where)
    {
        return $this->update($this->_table_name, $data, $data_where);
    }
    
    function get_collection($object_id = null, $type_object = null, $limit=2, $start=0)
    {
        
        $this->db->order_by('created_at','DESC');
        $this->db->select('p.*, m.first_name, m.last_name, m.avatar,m.company_name,m.job_title');
        $this->db->from($this->_table_name . " as p");
        $this->db->join($this->_table_members . " as m", 'm.id = p.member_id');
        if ($object_id != null) {
            $this->db->where('p.reference_id', $object_id);
        }
        if ($type_object != null) {
            $this->db->where('p.type_object', $type_object);
        }
        if ($limit != -1) {
            $this->db->limit($limit, $start);    
        }
        $query = $this->db->get();
        
        return $query->result_array();
    }

    function count_conversation_comment($member_id, $type_object='photo') 
    {
        $sql = "SELECT `ptc`.id
                FROM `common_comment` AS `ptc`
                WHERE `ptc`.`type_object` = '" . $type_object . "' 
                AND (`ptc`.`member_id` = '" . $member_id . "' OR `ptc`.`member_id` IN (SELECT cc.member_id from photos as p JOIN common_comment as cc ON cc.reference_id = p.photo_id AND cc.type_object='" . $type_object . "' WHERE p.member_id='" . $member_id . "')) ";
        
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function get_conversation_comment($member_id, $type_object='photo', $limit=2, $start=0) 
    {
        $sql = "SELECT DISTINCT `mb`.`avatar`, `ptc`.*, `mb`.`logo`, `mb`.`first_name`, `mb`.`last_name`, `mb`.`company_name`, `pt`.`photo_id`, `pt`.`path_file`, `pt`.`thumb`,`pt`.`name`
        FROM `common_comment` AS `ptc`
        JOIN `members` AS `mb` ON `mb`.`id` = `ptc`.`member_id`
        JOIN `photos` AS `pt` ON `pt`.`photo_id` = `ptc`.`reference_id`
        WHERE `ptc`.`type_object` = '" . $type_object . "' 
        AND (`ptc`.`member_id` = '" . $member_id . "' OR `ptc`.`member_id` IN (SELECT cc.member_id from photos as p JOIN common_comment as cc ON
                           cc.reference_id = p.photo_id AND cc.type_object='" . $type_object . "' WHERE p.member_id='" . $member_id . "'))
        ORDER BY `ptc`.`created_at` DESC";

        if ($limit != -1) {
            $sql .= " LIMIT $start, $limit";
        }
 
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
}