<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	function create($table, $data) 
	{
	    //do insert data into database
	    $this->db->trans_start();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        
        return $insert_id;
	}

	function read() 
	{
	    //do get data into database
	}

	function update($table, $data, $data_where) 
	{
	    //do update data into database
	    $_bool = false;
        $this->db->trans_start();
        $this->db->where($data_where);
        $_bool = $this->db->update($table, $data);
        $this->db->trans_complete();
        
        return $_bool;
	}

	function delete($table, $data) 
	{
	    //do delete data from database
	    $_bool = false;
        $this->db->trans_start();
        $_bool = $this->db->delete($table, $data);
        $this->db->trans_complete();
        
        return $_bool;
	}
	
}