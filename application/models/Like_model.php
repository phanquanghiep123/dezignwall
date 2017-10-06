<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Like_model extends MY_Model
{
    var $_table_name = 'common_like';
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function add($data)
    {
        return $this->create($this->_table_name, $data);
    }
    
    function delete($data)
    {
        return $this->delete($this->_table_name, $data);
    }
    
    function update($data, $data_where)
    {
        return $this->update($this->_table_name, $data, $data_where);
    }
    
    function get_collection($object_id = null, $type_object = null, $limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->order_by('created_at');
        $this->db->select('p.*');
        $this->db->from($this->_table_name . " as p");
        if ($object_id != null) {
            $this->db->where('p.reference_id', $object_id);
        }
        if ($type_object != null) {
            $this->db->where('p.type_object', $type_object);
        }
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
}