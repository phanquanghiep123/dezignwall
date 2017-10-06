<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Photolike_model extends CI_Model{
    var $_table        = 'photo_like';
    var $_table_photo  = 'photos';
    var $_table_member = 'members';
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
}