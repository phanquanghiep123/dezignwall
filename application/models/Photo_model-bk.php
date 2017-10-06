<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Photo_model extends CI_Model
{
    var $_table_photos = 'photos';
    var $_table_members = 'members';
    var $_table_photo_comment = 'photo_comment';
    var $_table_product_category = 'product_category';
    var $_table_products = 'products';
    private $type_photo_top = 3;
    private $type_photo_middle = 2;
    private $type_photo_for_design = 4;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_my_photo($member_id,$offet=0,$limit=0){
        $this->db->select('p.*,l.status,t.qty_like');
        $this->db->from($this->_table_photos.' as p');
        $this->db->join("common_tracking as t", "t.type_object='photo' AND t.reference_id = p.photo_id",'left');
        $this->db->join("common_like as l", "l.type_object='photo' AND l.reference_id = t.reference_id",'left');
        $this->db->where(array(
            'p.member_id'=>$member_id,
        ));
        $this->db->where_in('p.type',array(2,3));
        $this->db->group_by('p.photo_id');
        if($limit!=0){
            $this->db->limit($limit,$offet);
        }
        return $this->db->get()->result_array();
    }

    function get_count_my_photo($member_id){
        $this->db->select('*');
        $this->db->from($this->_table_photos);
        $this->db->where(array(
            'member_id'=>$member_id,
        ));
        $this->db->where_in('type',array(2,3));
        return $this->db->get()->num_rows();
    }
    /*===================================new====================================*/
    public function get_photo_slider($type,$order_by,$limit)
    {
        $this->db->select("pt.photo_id,pt.path_file,pt.name,mb.company_name,mb.first_name,mb.last_name");
        $this->db->from($this->_table_photos." AS pt");
        $this->db->join($this->_table_members." AS mb", 'mb.id = pt.member_id AND pt.type = '.$type.'');
        $this->db->where("type",$type);
        $this->db->order_by("id",$order_by);
        $this->db->group_by("mb.id");
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_photo_home($member_id = 0,$offset = 0, $limit = 21)
    {
        $this->db->select('mb.avatar,pt.photo_id,pt.name,pt.thumb,pt.path_file,pt.type,mb.logo,mb.id,cp.business_type,cp.company_name,cp.business_description,(SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`status` = 1 AND `ptl`.`type_object` = "photo" ) AS `num_like`,(SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`member_id` = '.$member_id.' AND `ptl`.`type_object` = "photo") AS `user_exits`,(SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`status` = 1 AND `ptl`.`member_id` = '.$member_id.' AND `ptl`.`type_object` = "photo") AS `member_total`');
        $this->db->from($this->_table_photos . " AS pt");
        $this->db->join($this->_table_members . ' AS mb', 'mb.id = pt.member_id ');
        $this->db->join('company AS cp', 'cp.member_id = mb.id ');
        $this->db->order_by("pt.created_at", "DESC");
        $this->db->group_by("mb.id");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_comment_photobyid($arg_id = array())
    {
        $this->db->distinct();
        $this->db->select('mb.avatar,ptc.*,mb.logo,mb.first_name,mb.last_name,mb.company_name');
        $this->db->from("common_comment AS ptc");
        $this->db->join($this->_table_members . ' AS mb', 'mb.id = ptc.member_id AND ptc.type_object = "photo"');
        $this->db->where_in('ptc.reference_id', $arg_id);
        $this->db->where('ptc.type_object','photo');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function total_page($keyword = "", $categories = "", $type = "",$slug ="")
    {
        $text_category = "";
        $text_select   = "";
        $where         = "WHERE (`pt`.`type`= 2)";
        if ($keyword != "") {
            $where .= " AND (`pt`.`name` LIKE '%{$keyword}%' OR `cp`.`company_name` LIKE '%{$keyword}%' OR `kw`.`title` LIKE '%{$keyword}%')";
        }
        if (isset($categories) && count($categories) > 0 && $categories != "") {
            foreach ($categories as $key => $value) {
                $text_category .= '"' . $value . '",';
            }
            $text_category = substr($text_category, 0, -1);
        }
        if ($text_category != "") {
            $where .= " AND `ptct`.`category_id` IN(" . $text_category . ")";
        }
        if ($type != "") {
            $where .= " AND (`pt`.`image_category` = '{$type}' OR `pt`.`image_category` = 'Projects,Products' OR `pt`.`image_category` = '')";
        }
        if($slug!=""){
            $where .= " AND (`ct`.`slug` = '{$slug}' OR `ptct`.`category_id` = ( SELECT `ct1`.`pid` FROM `categories` AS `ct1` WHERE  `ct1`.`slug` = '{$slug}' ) )";
        }
        $sql   = "SELECT `pt`.`photo_id` FROM `photos` AS `pt` JOIN `members` AS `mb` ON `mb`.`id` = `pt`.`member_id` LEFT JOIN `company` AS `cp` ON `cp`.`member_id`=`mb`.`id` LEFT JOIN `photo_category` AS `ptct` ON `ptct`.photo_id = `pt`.`photo_id` LEFT JOIN `categories` AS `ct` ON `ct`.`id` = `ptct`.`category_id` LEFT JOIN `photo_keyword` AS `ptkw` ON `ptkw`.`photo_id` = `pt`.`photo_id` LEFT JOIN `keywords` AS `kw` ON `kw`.`keyword_id` = `ptkw`.`keyword_id` " . $where . " GROUP BY `pt`.`photo_id` ORDER BY `pt`.`created_at` DESC";
        $query = $this->db->query($sql);
        return count($query->result_array());
    }
    
    public function search_index($member_id = 0,$count_record,$type = "",$slug = "")
    {
        $where = "";
        if($type!== "" ){
            $where .= " AND (`pt`.`image_category` = '{$type}' OR `pt`.`image_category` = 'Projects,Products' OR `pt`.`image_category` = '')";
        } 
        if($slug != ""){
            $where .= " AND (`ct`.`slug` = '{$slug}' OR `ptct`.`category_id` = (SELECT `ct1`.`pid` FROM `categories` AS `ct1` WHERE  `ct1`.`slug` = '{$slug}') )";
        }       
        $sql = "SELECT `pt`.`photo_id`, `pt`.`name`,`pt`.`thumb`, `pt`.`path_file`, `pt`.`type`,`pt`.`image_category`, `mb`.`logo`, `mb`.`id`,`cp`.`business_type`,`cp`.`company_name`,`cp`.`business_description`,
        (SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`status` = 1 AND `ptl`.`type_object` = 'photo') AS `num_like`,
        (SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`member_id` = ".$member_id." AND `ptl`.`type_object` = 'photo' ) AS `user_exits`,
        (SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`status` = 1 AND `ptl`.`member_id` = ".$member_id." AND `ptl`.`type_object` = 'photo') AS `member_total` 
        FROM `photos` AS `pt` JOIN `members` AS `mb` ON `mb`.`id` = `pt`.`member_id` LEFT JOIN `company` AS `cp` ON `cp`.`member_id`=`mb`.`id` LEFT JOIN `photo_category` AS `ptct` ON `ptct`.`photo_id` = `pt`.`photo_id` LEFT JOIN `categories` AS `ct` ON `ct`.`id` = `ptct`.`category_id` WHERE (`pt`.`type` = 2) ".$where." GROUP BY `mb`.`id` ORDER BY `pt`.`created_at` DESC ";
        $query = $this->db->query($sql);
        
        if (count($query->result_array()) < $count_record) {
            $where_not_in = "";
            foreach ($query->result_array() as $value) {
                $where_not_in .= '"' . $value["photo_id"] . '",';
               
            }
            $where_not_in = substr($where_not_in, 0, -1);
            if ($where_not_in!="") {
                $sql ="SELECT `pt`.`photo_id`,`pt`.`name`,`pt`.`thumb`, `pt`.`path_file`, `pt`.`type`,`pt`.`image_category`, `mb`.`logo`, `mb`.`id`,`cp`.`business_type`,`cp`.`company_name`,`cp`.`business_description`,
                (SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`status` = 1 AND `ptl`.`type_object` = 'photo') AS `num_like`,
                (SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`member_id` = ".$member_id." AND `ptl`.`type_object` = 'photo' ) AS `user_exits`,
                (SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`status` = 1 AND `ptl`.`member_id` = ".$member_id." AND `ptl`.`type_object` = 'photo') AS `member_total`
                FROM `photos` AS `pt` JOIN `members` AS `mb` ON `mb`.`id` = `pt`.`member_id` LEFT JOIN `company` AS `cp` ON `cp`.`member_id`=`mb`.`id` LEFT JOIN `photo_category` AS `ptct` ON `ptct`.`photo_id` = `pt`.`photo_id` LEFT JOIN `categories` AS `ct` ON `ct`.`id` = `ptct`.`category_id` WHERE (`pt`.`type` = 2) ".$where ." AND `pt`.`photo_id` NOT IN (".$where_not_in.") GROUP BY `pt`.`photo_id`  ORDER BY `pt`.`created_at` DESC LIMIT ".($count_record - count( $query->result_array() ) )."";
                $query2 = $this->db->query($sql);
                $result = array_merge($query->result_array(), $query2->result_array());
                return $result;
            }
        }else {
            return $query->result_array();
        }
    }
    
    public function seach_photo($member_id = 0,$keyword = "", $categories = "", $type = "", $offset = 0, $limit = 21, $id_photo_show = "",$slug = "")
    {
        $text_category      = "";
        $text_select        = "";
        $text_id_photo_show = "";
        $where              = "WHERE (`pt`.`type`= 2)";
        if ($keyword != "") {
           $where .= " AND (`pt`.`name` LIKE '%{$keyword}%' OR `cp`.`company_name` LIKE '%{$keyword}%' OR `kw`.`title` LIKE '%{$keyword}%')";
        }
        if (count($categories) > 0 && $categories != "") {
            foreach ($categories as $key => $value) {
                if(trim($value) != ""){
                    $text_category .= '"' . $value . '",';
                }   
            }
            $text_category = substr($text_category, 0, -1);
            if ($text_category != "") {
                $where .= " AND `ptct`.`category_id` IN(" . $text_category . ")";
            }
        }
        if ($type != "") {
            $where .= " AND (`pt`.`image_category` = '{$type}' OR `pt`.`image_category` = 'Projects,Products' OR `pt`.`image_category` = '')";
        }
        if (count($id_photo_show) > 0 && $id_photo_show != "") {
            foreach($id_photo_show as $key => $value) {
                if(trim($value) != ""){
                    $text_id_photo_show .= '"' . $value . '",';
                }
               
            }
            $text_id_photo_show = substr($text_id_photo_show, 0, -1);
            if ($text_id_photo_show != "") {
                $where .= " AND `pt`.`photo_id` NOT IN(" . $text_id_photo_show . ")";
            }
        }
        if($slug != ""){
            $where .= " AND (`ct`.`slug` = '{$slug}' OR `ptct`.`category_id` = (SELECT `ct1`.`pid` FROM `categories` AS `ct1` WHERE  `ct1`.`slug` = '{$slug}') )";
        }
        $sql   = "SELECT `pt`.`photo_id`,`pt`.`name`,`pt`.`image_category`,`pt`.`path_file`,`pt`.`thumb`,`mb`.`id`,`mb`.`logo`,`ptct`.`category_id`,`ptct`.`first_child_category`,`cp`.`business_type`,`cp`.`company_name`,`cp`.`business_description`,
        (SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`status` = 1 AND `ptl`.`type_object` = 'photo') AS `num_like`,
        (SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`member_id` = ".$member_id." AND `ptl`.`type_object` = 'photo' ) AS `user_exits`,
        (SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`status` = 1 AND `ptl`.`member_id` = ".$member_id." AND `ptl`.`type_object` = 'photo') AS `member_total`
        FROM `photos` AS `pt` JOIN `members` AS `mb` ON `mb`.`id` = `pt`.`member_id` LEFT JOIN `company` AS `cp` ON `cp`.`member_id`=`mb`.`id` LEFT JOIN `photo_category` AS `ptct` ON `ptct`.photo_id = `pt`.`photo_id` LEFT JOIN `categories` AS `ct` ON `ct`.`id` = `ptct`.`category_id` LEFT JOIN `photo_keyword` AS `ptkw` ON `ptkw`.`photo_id` = `pt`.`photo_id` LEFT JOIN `keywords` AS `kw` ON `kw`.`keyword_id` = `ptkw`.`keyword_id` " . $where . " GROUP BY `pt`.`photo_id` ORDER BY `pt`.`created_at` DESC LIMIT {$offset},{$limit}";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_photo($photo_id)
    {
        $this->db->select("*");
        $this->db->from("photos");
        $this->db->where("photo_id", $photo_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_photo_single($photo_id)
    {
        $this->db->select("*");
        $this->db->from("photo_keyword AS ptk");
        $this->db->join("keywords"." AS kw","kw.keyword_id = ptk.keyword_id AND ptk.photo_id =".$photo_id."","LEFT");
        $this->db->where("ptk.photo_id",$photo_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_ram_photo($filter,$limit)
    {
        $this->db->select('*');
        $this->db->from($this->_table_photos);
        $this->db->where($filter);
        $this->db->limit($limit);
        $this->db->order_by("pt.photo_id", "RANDOM");
        return $this->db->get()->result_array();
    }
    
    function delete_photo($photo_id, $member_id)
    {
        return $this->db->delete($this->_table_photos, array(
            'photo_id' => $photo_id,
            'member_id' => $member_id
        ));
    }

    function get_photos_like($keyword){
        $this->db->select("pt.name");
        $this->db->from($this->_table_photos." AS pt");
        $this->db->join("members"." AS mb","mb.id = pt.member_id");
        $this->db->like("pt.name",$keyword);
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*===================================!new====================================*/
    
    // ======================================================
    // ============ Clone for DESIGN WALL ===================
    function get_collection_design_wall_photos($category_id = "", $member_id = "", $keyword = "", $limit=-1, $start=0)
    {
        $this->db->distinct();
		if ($limit != -1) {
			$this->db->limit($limit, $start);
		}
        $this->db->select('p.*,m.company_name,m.business_type,t.qty_like,pc.product_id,l.status');
        $this->db->from($this->_table_photos . " as p");
        $this->db->join($this->_table_members . " as m", 'p.member_id = m.id');
        $this->db->join("products as pc", 'p.photo_id = pc.photo_id');
        $this->db->join("common_tracking as t", "t.type_object='product' AND t.reference_id = pc.product_id",'left');
        $this->db->join("common_like as l", "l.type_object='product' AND l.reference_id = pc.product_id",'left');
        $this->db->where('p.type', $this->type_photo_for_design); // Design Wall
        
        if (!empty($keyword)) {
            $this->db->like('p.product_name', $keyword);
        }
        if (!empty($category_id)) {
            $this->db->where('pc.category_id', $category_id);
        }
        if (!empty($member_id)) {
            $this->db->where('p.member_id', $member_id);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function count_collection_design_wall_photos($category_id, $member_id, $keyword = "")
    {
        $this->db->distinct();
        $this->db->select('p.photo_id');
        $this->db->from($this->_table_photos . " as p");
        $this->db->join("products as pc", 'p.photo_id = pc.photo_id');
        $this->db->where('p.type', $this->type_photo_for_design); // Design Wall
        
        if (!empty($keyword)) {
            $this->db->like('p.product_name', $keyword);
        }
        if (!empty($category_id)) {
            $this->db->where('pc.category_id', $category_id);
        }
        if (!empty($member_id)) {
            $this->db->where('p.member_id', $member_id);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    // ======================================================
    // ============ Clone for DESIGN WALL Favorite===========
    function get_collection_design_wall_favorite_photos($category_id = "", $member_id = "", $keyword = "", $limit=-1, $start=0)
    {
        $this->db->distinct();
        if ($limit != -1) {
        	$this->db->limit($limit, $start);
        }
        $this->db->select('p.*,m.company_name,m.business_type,pr.product_id,t.qty_like,l.status');
        $this->db->from($this->_table_photos . " as p");
        $this->db->join($this->_table_products . " as pr", 'p.photo_id = pr.photo_id');
        $this->db->join($this->_table_members . " as m", 'pr.member_id = m.id');
        $this->db->join("common_tracking as t", "t.type_object='product' AND t.reference_id = pr.product_id",'left');
        $this->db->join("common_like as l", "l.type_object='product' AND l.reference_id = pr.product_id",'left');
        $this->db->where_in('p.type', array(
            $this->type_photo_middle,
            $this->type_photo_top
        )); // Upload photos
        
        if (!empty($keyword)) {
            $this->db->like('p.product_name', $keyword);
        }
        if (!empty($category_id)) {
            $this->db->where('pr.category_id', $category_id);
        }
        if (!empty($member_id)) {
            $this->db->where('pr.member_id', $member_id);
        }
        
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    function count_collection_design_wall_favorite_photos($category_id, $member_id, $keyword = "")
    {
        $this->db->distinct();
        $this->db->select('p.photo_id');
        $this->db->from($this->_table_photos . " as p");
        $this->db->join($this->_table_products . " as pr", 'p.photo_id = pr.photo_id');
        $this->db->where('p.type', $this->type_photo_middle); // Upload photos
        
        if (!empty($keyword)) {
            $this->db->like('p.product_name', $keyword);
        }
        if (!empty($category_id)) {
            $this->db->where('pr.category_id', $category_id);
        }
        if (!empty($member_id)) {
            $this->db->where('pr.member_id', $member_id);
        }
        
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    
}