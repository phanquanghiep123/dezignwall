<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Photo_model extends CI_Model {

    var $_table_photos = 'photos';
    var $_table_members = 'members';
    var $_table_photo_comment = 'photo_comment';
    var $_table_product_category = 'product_category';
    var $_table_products = 'products';
    private $type_photo_top = 3;
    private $type_photo_middle = 2;
    private $type_photo_for_design = 4;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_my_photo($member_id,$keyword = null,$cat_id = null,$catelog = null,$offet = 0, $limit = 30) {
        $sql_limit = "";
        if ($limit != 0) {
            $sql_limit = "limit {$offet},{$limit}";
        }
        $sql_keyword = "";
        if($keyword != null){
            $sql_keyword = "AND `pt`.name LIKE '%{$keyword}%'";
        }
        $cat_sql = "";
        if($catelog != null){
            $cat_sql = " AND `pt`.`manufacture` = {$catelog}";
        }
        $sql ="SELECT `p`.*, `l`.`status`, `t`.`qty_like`, `t`.`qty_comment`
        FROM (SELECT * FROM photos AS pt WHERE `pt`.`type` IN(2, 3) AND `pt`.`member_id` = {$member_id} {$sql_keyword} {$cat_sql} ORDER BY `pt`.`photo_id` DESC {$sql_limit}) as `p`
        LEFT JOIN `common_tracking` as `t` ON `t`.`type_object`='photo' AND `t`.`reference_id` = `p`.`photo_id`
        LEFT JOIN `common_like` as `l` ON `l`.`type_object`='photo' AND `l`.`reference_id` = `t`.`reference_id`";
        if($cat_id != null){
            $sql .=" LEFT JOIN `photo_category` as `ptc` ON `ptc`.`photo_id`= p.`photo_id` AND `ptc`.`category_id` = {$cat_id}";
        }

        $sql .=" GROUP BY `p`.`photo_id`
        ORDER BY `p`.`photo_id` DESC ";
        $query = $this->db->query($sql);

        return $query->result_array();
    }
    function total_photo($member_id,$keyword = null,$cat_id = null,$catelog = null){
        $this->db->select('p.photo_id');
        $this->db->from($this->_table_photos . ' as p');
        if($cat_id != null){
            $this->db->like("p.category", "/".@$cat_id[0]."/");
        }
        if($member_id != null){
            $this->db->where(array(
                'p.member_id' => $member_id,
            ));
        }
        if($keyword != null){
            $this->db->group_start();
            $this->db->like('p.name',$keyword);
            $this->db->or_like('p.keywords',$keyword);
            $this->db->group_end();
        }
        if($catelog != null){
            $this->db->where("p.manufacture",$catelog);
        }
        $this->db->where_in('p.type', array(2, 3));
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_count_my_photo($member_id) {
        $this->db->select('*');
        $this->db->from($this->_table_photos);
        if(isset($_GET['keyword']) && $_GET['keyword']!=null){
            $this->db->like('name',$_GET['keyword']);
        }
        $this->db->where(array(
            'member_id' => $member_id,
        ));
        $this->db->where_in('type', array(2, 3));
        return $this->db->get()->num_rows();
    }

    function count_photo_by_comment($member_id, $type_object='photo') 
    {
        $sql = "SELECT DISTINCT p.photo_id
                FROM `common_comment` AS `ptc` JOIN photos as p ON p.photo_id = ptc.reference_id
                WHERE `ptc`.`type_object` = '" . $type_object . "' 
                AND (`ptc`.`member_id` = '" . $member_id . "' OR `ptc`.`member_id` IN (SELECT cc.member_id from photos as p JOIN common_comment as cc ON cc.reference_id = p.photo_id AND cc.type_object='" . $type_object . "' WHERE p.member_id='" . $member_id . "')) 
                GROUP BY p.photo_id";
        
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function get_photo_by_comment($member_id, $type_object='photo', $limit=2, $start=0) 
    {
        $sql = "SELECT DISTINCT `mb`.`avatar`, MAX(`ptc`.`created_at`), `mb`.`logo`, `mb`.`first_name`, `mb`.`last_name`, `mb`.`company_name`, `pt`.`photo_id`, `pt`.`path_file`, `pt`.`thumb`,`pt`.`name`
        FROM `common_comment` AS `ptc`
        JOIN `photos` AS `pt` ON `pt`.`photo_id` = `ptc`.`reference_id`
        JOIN `members` AS `mb` ON `mb`.`id` = `ptc`.`member_id`
        WHERE `ptc`.`type_object` = '" . $type_object . "' 
        AND (`ptc`.`member_id` = '" . $member_id . "' OR `pt`.`photo_id` IN (SELECT DISTINCT cc.reference_id from photos as p JOIN common_comment as cc ON
                           cc.reference_id = p.photo_id AND cc.type_object='" . $type_object . "' WHERE p.member_id='" . $member_id . "'))
        GROUP BY `pt`.`photo_id` 
        ORDER BY MAX(`ptc`.`created_at`) DESC"; // pt.photo_id DESC

        if ($limit != -1) {
            $sql .= " LIMIT $limit, $start";
        }
 
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    /* ===================================new==================================== */

    public function get_photo_slider($type, $order_by, $limit) {
        $this->db->select("pt.photo_id,pt.path_file,pt.name,mb.company_name,mb.first_name,mb.last_name");
        $this->db->from($this->_table_photos . " AS pt");
        $this->db->join($this->_table_members . " AS mb", 'mb.id = pt.member_id AND pt.type = ' . $type . '');
        $this->db->where("type", $type);
        $this->db->order_by("id", $order_by);
        $this->db->group_by("mb.id");
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_photo_slider_image_category($type = 'projects', $order_by, $limit) {
        $this->db->select("pt.photo_credit,pt.photo_id,pt.path_file,pt.name,mb.company_name,mb.first_name,mb.last_name");
        $this->db->from($this->_table_photos . " AS pt");
        $this->db->join($this->_table_members . " AS mb", 'mb.id = pt.member_id');
        $this->db->like("image_category", $type);
        $this->db->where("pt.status_photo > ", 0);
        $this->db->where("pt.priority_display", "high");
        $this->db->order_by("id", $order_by);
        $this->db->group_by("mb.id");
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_photo_home($member_id = 0, $offset = 0, $limit = 29) {
        $this->db->select('mb.avatar,pt.photo_id,pt.name,pt.thumb,pt.path_file,pt.type,mb.logo,mb.type_member,mb.id,cp.business_type,cp.company_name,cp.business_description,(SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`status` = 1 AND `ptl`.`type_object` = "photo" ) AS `num_like`,(SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`member_id` = ' . $member_id . ' AND `ptl`.`type_object` = "photo") AS `user_exits`,(SELECT COUNT(`ptl`.`id`) FROM `common_like` AS `ptl` WHERE `ptl`.`reference_id` = `pt`.`photo_id` AND `ptl`.`status` = 1 AND `ptl`.`member_id` = ' . $member_id . ' AND `ptl`.`type_object` = "photo") AS `member_total`,(SELECT `cmtk`.`qty_comment` FROM `common_tracking` AS `cmtk` WHERE `cmtk`.`reference_id` = `pt`.`photo_id` AND `cmtk`.`type_object` = "photo" LIMIT 0,1 ) AS `num_comment`,(SELECT COUNT(`imgp`.`id`) FROM `images_point` AS `imgp` WHERE `imgp`.`photo_id` = `pt`.`photo_id`) AS `images_point`');
        $this->db->from($this->_table_photos . " AS pt");
        $this->db->join($this->_table_members . ' AS mb', 'mb.id = pt.member_id ');
        $this->db->join('company AS cp', 'cp.member_id = mb.id ');
        $this->db->where("pt.name !=", null);
        $this->db->where("pt.type =", 2);
        $this->db->where("pt.status_photo > ", 0);
        $this->db->order_by("pt.created_at", "DESC");
        $this->db->limit($limit);
        //$this->db->group_by("mb.id");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_comment_photobyid($arg_id = array(), $filter = null) {
        $this->db->distinct();
        $this->db->select('mb.avatar,ptc.*,mb.logo,mb.first_name,mb.last_name,mb.company_name');
        $this->db->from("common_comment AS ptc");
        $this->db->join($this->_table_members . ' AS mb', 'mb.id = ptc.member_id AND ptc.type_object = "photo"');
        $this->db->where_in('ptc.reference_id', $arg_id);
        if($filter != null){
            $this->db->where($filter);
        }else{
            $this->db->where('ptc.type_object', 'photo');
        }
        $this->db->order_by("ptc.created_at", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_comment_photo($photos_id, $offset = 0, $limit = 2, $ojb = null) {
        $type = "photo";
        if ($ojb != null) {
            $type = $ojb;
        }
        $this->db->distinct();
        $this->db->select('mb.avatar,`ptc`.comment, `ptc`.id, DATE_FORMAT(`ptc`.created_at, "%Y %M %d %l:%i%p") AS created_at, `ptc`.member_id,mb.logo,mb.first_name,mb.last_name,mb.company_name');
        $this->db->from("common_comment AS ptc");
        $this->db->join($this->_table_members . ' AS mb', 'mb.id = ptc.member_id');
        $this->db->where('ptc.reference_id', $photos_id);
        $this->db->where('ptc.type_object', $type);
        $this->db->order_by("ptc.created_at", "DESC");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_comment_by_member($member = null, $type = "photo") {
        $sql = "SELECT DISTINCT `mb`.`avatar`, `ptc`.*, `mb`.`logo`, `mb`.`first_name`, `mb`.`last_name`, `mb`.`company_name`, `pt`.`photo_id`, `pt`.`path_file`, `pt`.`thumb`,`pt`.`name`
        FROM `common_comment` AS `ptc`
        JOIN `members` AS `mb` ON `mb`.`id` = `ptc`.`member_id`
        JOIN `photos` AS `pt` ON `pt`.`photo_id` = `ptc`.`reference_id`
        WHERE `pt`.`member_id` = '" . $member . "'
        AND `ptc`.`type_object` = 'photo'
        AND ptc.id IN (SELECT id FROM (SELECT DISTINCT id, reference_id FROM `common_comment` WHERE `type_object` = 'photo' ORDER by `created_at` DESC limit 0, 3) as b)
        GROUP BY `ptc`.`reference_id`,`ptc`.`member_id`
        ORDER BY `ptc`.`created_at` DESC";
 
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function search_index($member_id = 0, $count_record,$type = NULL,$cat_id="") {
    	return $this->seach_photo(NULL, $member_id, NULL, NULL, $type, 0, 30, NULL);
    }
    public function total_page($location = NULL, $keyword = NULL, $categories = NULL, $type = NULL,$catalog = null,$owner = null,$offer_product = null) {
        $where = " WHERE (`pt`.`type`= 2) AND (pt.status_photo > 0) AND (`pt`.`name` IS NOT NULL) ";
        $text_in_location = "";
        $join_table_keyword = "";
        $keyword = trim($keyword);
        if($keyword != null || $keyword != ""){
            $where.=" AND (pt.keywords LIKE '%{$keyword}%' OR pt.name LIKE '%{$keyword}%')";
        }
        if($categories != NULL && count($categories) > 0){
            $i = 0;
            foreach ($categories as $key => $value) {
                if($i == 0){
                    $where.= " AND ( pt.category like '%/{$value}/%'";
                }else{
                    $where.= " OR pt.category like '%/{$value}/%'";
                }
                $i++;
            }
            $where.= ")";
        }         
        if ( isset($location) && count($location) > 0 && $location != ""){
            foreach ($location as $key => $value) {
                if($key == 0){
                    $where.= " AND ( pt.category like '%/{$value}/%'";
                }else{
                    $where.= " OR pt.category like '%/{$value}/%'";
                }
            }
            $where.= ")";
        }
        if($catalog != null && $catalog != ""){
             $where.= " AND (pt.manufacture = {$catalog})";
        }
        if ($type != "") {
            $where.= " AND (`pt`.`image_category` = '{$type}' OR `pt`.`image_category` = 'Projects,Products' OR `pt`.`image_category` = '')";
        }
        if($owner != null){
            $where.=" AND pt.member_id = {$owner}";
        }
        if($offer_product != null){
            $where.=" AND pt.offer_product = '{$offer_product}'";
        }
        $sql = "SELECT COUNT(`pt`.`photo_id`) AS Number_Photo FROM `photos` AS pt INNER JOIN `members` AS `mb` ON `mb`.`id` = `pt`.`member_id` {$where} ";           
        $query = $this->db->query($sql,true);
        $query = $query->row_array();
        return $query["Number_Photo"];
    }
    public function seach_photo($location = NULL, $member_id = NULL, $keyword = NULL, $categories = NULL, $type = NULL, $offset = 0, $limit = 21,$catalog = NULL,$owner = null, $myphoto = false,$offer_product=null) {
        $CI =& get_instance();
        $user_info = $CI->session->userdata('user_info');
        $member_current_id = 0;
        if($user_info != null && @$user_info["id"] != null){
            $member_current_id  = @$user_info["id"];
        }
        $where = "";
        if(!$myphoto){
            $where = " WHERE (`pt`.`type`= 2) AND (pt.status_photo > 0) AND (`pt`.`name` IS NOT NULL)";
        }else{
            $where = " WHERE 1 = 1  AND `pt`.`type` IN(2, 3)";
        }
        $keyword = trim($keyword);
        if($keyword != null || $keyword != ""){
            $where.=" AND (pt.keywords LIKE '%{$keyword}%' OR pt.name LIKE '%{$keyword}%')";
        }
        if($categories != null && count($categories) > 0){
            $i = 0;
            foreach ($categories as $key => $value) {
                if($i == 0){
                    $where.= " AND ( pt.category like '%/{$value}/%'";
                }else{
                    $where.= " OR pt.category like '%/{$value}/%'";
                }
                $i++;
            }
            $where.= ")";
        }
        if ( isset($location) && count($location) > 0 && $location != ""){
            foreach ($location as $key => $value) {
                if($key == 0){
                    $where.= " AND ( pt.category like '%/{$value}/%'";
                }else{
                    $where.= " OR pt.category like '%/{$value}/%'";
                }
            }
            $where.= ")";
        }
        if($catalog != null && $catalog != ""){
             $where.= " AND (pt.manufacture = '{$catalog}')";
        }
        if ($type != "") {
            $where.= " AND (`pt`.`image_category` = '{$type}' OR `pt`.`image_category` = 'Projects,Products' OR `pt`.`image_category` = '')";
        }
        if($owner != null){
            $where.=" AND pt.member_id = {$owner}";
        }
        if($offer_product != null){
            $where.=" AND pt.offer_product = '{$offer_product}'";
        }
        $sql = "SELECT `cp`.`id` AS company_id, `cf`.`member_id` AS follow, `ptl`.`id` AS member_total,`pt2`.`album`, `tk`.`qty_like` AS num_like, `tk`.`qty_comment` AS num_comment, 
                `pt2`.`photo_id`,`pt2`.`same_photo`,`pt2`.`status_photo`, `pt2`.`description`,`pt2`.`name`,`pt2`.`image_category`,`pt2`.`path_file`,
                `pt2`.`thumb`,`pt2`.`last_comment`, `pt2`.`member_id` AS id,`cp`.`logo`,`pt2`.`type_member`,`cp`.`business_type`,`pt2`.`is_type_post`,
                `cp`.`company_name`,`cp`.`business_description`,`pt2`.`created_at`,`pt2`.`manufacture`,`pt2`.`is_story`
                FROM (SELECT pt.*,mb.* FROM `photos` AS pt INNER JOIN `members` AS `mb` ON `mb`.`id` = `pt`.`member_id` {$where} ORDER BY `pt`.`priority_display` ASC,`pt`.`photo_id` DESC LIMIT $offset, $limit) AS `pt2` 
                LEFT JOIN common_tracking AS tk ON tk.reference_id = pt2.photo_id AND `tk`.`type_object`= 'photo' 
                LEFT JOIN common_like AS ptl ON ptl.reference_id = pt2.photo_id AND `ptl`.`member_id` = '{$member_current_id}' AND `ptl`.`type_object` = 'photo' AND `ptl`.`status` = 1                        
                LEFT JOIN `company` AS `cp` ON `cp`.`member_id`=`pt2`.`id`
                LEFT JOIN common_follow AS cf on cf.reference_id =`pt2`.`photo_id` AND cf.member_id ='{$member_current_id}' AND `cf`.`status` = 1  AND `cf`.`type_object` = 'photo' AND `cf`.`allow` < 2
                GROUP BY `pt2`.`photo_id` ORDER BY `pt2`.`priority_display` ASC,`pt2`.`photo_id` DESC";
        $query = $this->db->query($sql,true);
        return $query->result_array();
    }
    
    public function search_photo($location = "", $member_id = 0, $keyword = "", $categories = "", $type = "", $offset = 0, $limit = 21, $id_photo_show = "", $slug = "", $cat_id = "") {
        $where_main = " WHERE (`pt`.`type`= 2) AND (pt.status_photo > 0) AND (`pt`.`name` is not null) ";
        
        /* WHERE follow category */
        $join_table_category = "";
        $str_where_category = "";
        if ((isset($categories) && count($categories) > 0 && $categories != "") || ($location != "" && is_array($location) && count($location) > 0)) {
            foreach ($categories as $key => $value) {
                if (trim($value) != "") {
                    $str_where_category .= " AND pt.photo_id IN (SELECT ptct3.photo_id FROM photo_category AS ptct3 WHERE ptct3.category_id IN ('" . $value . "'))";
                }
            }
            if (is_array($location) && count($location) > 0) {
                $str_where_category .= " AND (ptct.location IN (0," . implode(",", $location) . ") )";
            }
            $join_table_category = " INNER JOIN photo_category AS ptct ON ptct.photo_id = pt.photo_id 
                                     INNER JOIN categories AS ct ON ct.id = ptct.category_id ";

        }
        if ($type != "") {
            $str_where_category .= " AND (pt.image_category = '{$type}' OR pt.image_category = 'Projects,Products' OR pt.image_category = '') ";
        }
        if (count($id_photo_show) > 0 && $id_photo_show != "" && is_array($id_photo_show)) {
            $where_main .= " AND pt.photo_id NOT IN (" . implode(',', $id_photo_show) . ")";
            $str_where_category .= " AND pt.photo_id NOT IN (" . implode(',', $id_photo_show) . ")";
        }
        
        if ($slug != "") {
            if (is_array($location) && count($location) == 1) {
                $str_where_category .= " AND (ptct.location IN (0," . implode(",", $location) . ") )";
            }
            $join_table_category = " JOIN photo_category AS ptct ON ptct.photo_id = pt.photo_id 
                                     JOIN categories AS ct ON ct.id = ptct.category_id ";

            $where .= " AND ((ct.slug = '{$slug}')";
            if ($cat_id != "") {
                $str_where_category .= " OR (ct.id IN  (" . $cat_id . ") )";
            }
            $str_where_category .= ") ";
        }
        
        $keyword = trim($keyword);
        $str_where_by_keyword = "";
        if ($keyword != "") {
            $str_where_by_keyword = 
                " AND pt2.photo_id IN (
                SELECT pt.photo_id FROM (
                    SELECT photo_id FROM photos WHERE name LIKE '%{$keyword}%'

                    UNION

                    SELECT DISTINCT pt.photo_id FROM keywords AS k
                        INNER JOIN photo_keyword AS pt
                        ON pt.keyword_id = k.keyword_id
                        AND k.type='photo' AND k.title LIKE '%a{$keyword}%'
                    GROUP BY pt.photo_id

                    UNION
                    
                    SELECT DISTINCT p.photo_id FROM photos AS p
                        INNER JOIN company AS c
                        ON p.member_id = c.id AND c.company_name LIKE '%{$keyword}%'
                    GROUP BY p.photo_id
                    
                ) AS pt 
                    {$join_table_category} WHERE 1=1 {$str_where_category}
                ) ";
        }
        
        $sql = "SELECT `fc`.`id` AS follow, `ptl`.`id` AS member_total, tk.qty_like AS num_like, tk.qty_comment AS num_comment, 
                `pt2`.`photo_id`, `pt2`.`description`,`pt2`.`name`,`pt2`.`image_category`,`pt2`.`path_file`,
                `pt2`.`thumb`,`pt2`.`last_comment`, `mb`.`id`,`mb`.`logo`,`mb`.`type_member`,`cp`.`business_type`,
                `cp`.`company_name`,`cp`.`business_description`,`pt2`.`created_at`
                FROM photos AS pt2 
                INNER JOIN `members` AS `mb` ON `mb`.`id` = `pt2`.`member_id`
                LEFT JOIN `company` AS `cp` ON `cp`.`member_id`=`mb`.`id` 
                LEFT JOIN common_tracking AS tk ON tk.reference_id = pt2.photo_id AND `tk`.`type_object`= 'photo' 
                LEFT JOIN common_like AS ptl ON ptl.reference_id = pt2.photo_id AND `ptl`.`member_id` = '{$member_id}' AND `ptl`.`type_object` = 'photo' AND `ptl`.`status` = 1 
                LEFT JOIN `follow_companies` as fc on `fc`.`owner_company` = `pt2`.`member_id` AND `fc`.`member_id` = '{$member_id}'
                {$where_main} {$str_where_by_keyword}
                GROUP BY `pt2`.`photo_id` 
                ORDER BY `pt2`.`priority_display` ASC,`pt2`.`created_at` DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_photo($photo_id) {
        $this->db->select("*");
        $this->db->from("photos");
        $this->db->where("photo_id", $photo_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_photo_single($photo_id) {
        $this->db->select("*");
        $this->db->from("photo_keyword AS ptk");
        $this->db->join("keywords" . " AS kw", "kw.keyword_id = ptk.keyword_id AND ptk.photo_id =" . $photo_id . "", "LEFT");
        $this->db->where("ptk.photo_id", $photo_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_ram_photo($filter, $limit) {
        $this->db->select('*');
        $this->db->from($this->_table_photos);
        $this->db->where($filter);
        $this->db->where("name !=", null);
        $this->db->limit($limit);
        $this->db->order_by("photo_id", "RANDOM");
        return $this->db->get()->result_array();
    }

    function delete_photo($photo_id, $member_id) {
        return $this->db->delete($this->_table_photos, array(
                    'photo_id' => $photo_id,
                    'member_id' => $member_id
        ));
    }

    function get_photos_like($keyword) {
        $this->db->select("pt.name,pt.created_at");
        $this->db->from($this->_table_photos . " AS pt");
        $this->db->join("members" . " AS mb", "mb.id = pt.member_id");
        $this->db->where(array("pt.type" => 2,"pt.status_photo > " => 0));
        $this->db->like("pt.name", $keyword);
        $this->db->or_like("pt.keywords", $keyword);
        $this->db->group_by("pt.name");
        $this->db->order_by("pt.created_at","DESC");
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }

    /* ===================================!new==================================== */

    // ======================================================
    // ============ Clone for DESIGN WALL ===================
    function get_collection_design_wall_photos($category_id = "", $owner_member_id = "", $member_id = "", $keyword = "", $limit = - 1, $start = 0) {
        $this->db->distinct();
        if ($limit != - 1) {
            $this->db->limit($limit, $start);
        }
        $this->db->select('p.*,m.company_name,m.business_type,t.qty_like,t.qty_comment,pc.product_id,l.status');
        $this->db->from($this->_table_photos . " as p");
        $this->db->join($this->_table_members . " as m", 'p.member_id = m.id');
        $this->db->join("products as pc", 'p.photo_id = pc.photo_id');
        $this->db->join("common_tracking as t", "t.type_object='product' AND t.reference_id = pc.product_id", 'left');
        $this->db->join("common_like as l", "l.type_object='product' AND l.member_id='" . $member_id . "' AND l.reference_id = pc.product_id", 'left');
        $this->db->where('p.type', $this->type_photo_for_design);
        if (!empty($keyword)) {
            $this->db->like('p.name', $keyword);
        }
        if (!empty($category_id)) {
            $this->db->where('pc.category_id', $category_id);
        }
        if (!empty($member_id)) {
            $this->db->where('pc.member_id', $owner_member_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function count_collection_design_wall_photos($category_id, $member_id, $keyword = "") {
        $this->db->distinct();
        $this->db->select('p.photo_id');
        $this->db->from($this->_table_photos . " as p");
        $this->db->join("products as pc", 'p.photo_id = pc.photo_id');
        $this->db->where('p.type', $this->type_photo_for_design); // Design Wall
        if (!empty($keyword)) {
            $this->db->like('p.name', $keyword);
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
    function get_collection_design_wall_favorite_photos($category_id = "", $owner_member_id = "", $member_id = "", $keyword = "", $limit = - 1, $start = 0) {
        $this->db->distinct();
        if ($limit != - 1) {
            $this->db->limit($limit, $start);
        }
        $this->db->select('p.*,m.company_name,m.business_type,pr.product_id,t.qty_like,t.qty_comment,l.status');
        $this->db->from($this->_table_photos . " as p");
        $this->db->join($this->_table_products . " as pr", 'p.photo_id = pr.photo_id');
        $this->db->join($this->_table_members . " as m", 'pr.member_id = m.id');
        $this->db->join("common_tracking as t", "t.type_object='product' AND t.reference_id = pr.product_id", 'left');
        $this->db->join("common_like as l", "l.type_object='product' AND l.member_id=" . $member_id . " AND l.reference_id = pr.product_id", 'left');
        $this->db->where_in('p.type', array(
            $this->type_photo_middle,
            $this->type_photo_top
        ));
        if (!empty($keyword)) {
            $this->db->like('p.name', $keyword);
        }
        if (!empty($category_id)) {
            $this->db->where('pr.category_id', $category_id);
        }
        if (!empty($member_id)) {
            $this->db->where('pr.member_id', $owner_member_id);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function count_collection_design_wall_favorite_photos($category_id, $member_id, $keyword = "") {
        $this->db->distinct();
        $this->db->select('p.photo_id');
        $this->db->from($this->_table_photos . " as p");
        $this->db->join($this->_table_products . " as pr", 'p.photo_id = pr.photo_id');
        $this->db->where('p.type', $this->type_photo_middle); // Upload photos
        if (!empty($keyword)) {
            $this->db->like('p.name', $keyword);
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
    function random_photo_project($user_id){
        $this->db->select("*");
        $this->db->from("photos");
        $this->db->where("member_id",$user_id);
        $this->db->where("image_category","Project");
        $this->db->limit(30);
        $this->db->order_by("photo_id", "RANDOM");
        return $this->db->get()->result_array();
    }

}