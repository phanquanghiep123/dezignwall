<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_model extends CI_Model
{
    
    var $table_name = 'categories';
    var $table_business = 'business_categories';
    var $table_tags_name = 'tags';
    var $_max_level = 6;
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_cat_by_slug_title($text = ""){
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where("title",$text);
        $this->db->or_where('slug',$text);
        return $this->db->get()->result_array();
    }
    function get_max_level()
    {
        return $this->_max_level;
    }
    
    
    
    function get_category_by_business($business_type, $keyword)
    {
        $sql = "SELECT id, title, slug FROM " . $this->table_business . " WHERE pid IN (SELECT id FROM " . $this->table_business . " WHERE slug LIKE '%{$business_type}%')";
        if (!empty($keyword)) {
            $sql .= " AND title LIKE '%$keyword%'";
        }
        $sql .= " ORDER BY title";
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    function get_list_title_by_slug($list_slug)
    {
        $this->db->select('*');
        $this->db->from($this->table_business);
        $this->db->where_in('slug', $list_slug);
        return $this->db->get()->result_array();
    }
    
    function get_business_category_by_slug($slug)
    {
        $this->db->select('*');
        $this->db->where('slug', strtolower($slug));
        $query = $this->db->get('' . $this->table_business);
        
        return $query->row_array();
    }
    
    function get_business_category($name)
    {
        $this->db->where('title', $name);
        $query = $this->db->get($this->table_business);
        return $query->row_array();
    }
    
    function add_business_category($data)
    {
        $this->db->trans_start();
        $this->db->insert($this->table_business, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    function get_category_by_slug($slug)
    {
        $this->db->select('*');
        $this->db->where('slug', strtolower($slug));
        $query = $this->db->get('' . $this->table_name);
        return $query->row_array();
    }
    
    function get_category($name)
    {
        $this->db->where('title', $name);
        $query = $this->db->get($this->table_name);
        return $query->row_array();
    }
    
    function get_item_category($id, $business_type = false)
    {
        $table = !$business_type ? $this->table_name : $this->table_business;
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        return $query->row_array();
    }
    
    function add_category($name,$is_frontend = false)
    {
        if (!$is_frontend) {
            $data = array(
                'pid' => '0',
                'title' => $name,
                'enabled' => '0',
                'type' => 'custom'
            );
        } else {
            $data = $name;
        } 
        $this->db->trans_start();
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    function add_item_category($data, $business_type = false)
    {
        $table = !$business_type ? $this->table_name : $this->table_business;
        $this->db->trans_start();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    function update_item_category($id, $data, $business_type = false)
    {
        $table = !$business_type ? $this->table_name : $this->table_business;
        $this->db->trans_start();
        $this->db->where(array(
            "id" => $id
        ));
        $this->db->update($table, $data);
        $this->db->trans_complete();
    }
    
    function delete_item_category($id, $business_type = false)
    {
        $table = !$business_type ? $this->table_name : $this->table_business;
        $this->db->where('id', $id);
        $this->db->delete($table);
    }
    
    function getAll($type = "system")
    {
        $this->db->order_by("sort", "asc");
        $this->db->where('type', $type);
        $query = $this->db->get($this->table_name);
        return $query->result();
    }
    
    function get_cat_all()
    {
        $this->db->where('pid !=', 0);
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }
    
    function get_category_title_by_slug($str_slug, $type="", $business_type = false)
    {
        $table = !$business_type ? $this->table_name : $this->table_business;
        
        $this->db->where("slug IN ({$str_slug})");
        if ($type == "services") {
            $this->db->where("pid NOT IN (SELECT id FROM " . $this->table_business . " WHERE slug = 'photographer')");
        } else {
            $this->db->where("pid IN (SELECT id FROM " . $this->table_business . " WHERE slug = '{$type}')");
        }
        $query = $this->db->get($table);
        return $query->result();
    }
    
    function get_business_categories($cat = 0)
    {
        $this->db->where('pid', $cat);
        $query = $this->db->get($this->table_business);
        return $query->result();
    }
    
    function get_categories($cat = 0, $business_type = false)
    {
        $table = !$business_type ? $this->table_name : $this->table_business;
        $this->db->where('pid', $cat);
        $query = $this->db->get($table);
        return $query->result();
    }
    
    function get_types()
    {
        $sql   = "SELECT * FROM $this->table_tags_name";
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    function get_trees($cat = 0, $level = 0)
    {
        $result = $this->get_categories($cat);
        $str    = '';
        if ($result != null) {
            foreach ($result as $item) {
                $str .= "<option value=\"{$item->id}\">" . str_repeat(".", $level * 10) . "{$item->name}</option>";
                $str .= $this->get_trees($item->id, ($level + 1));
            }
        }
        
        return $str;
    }
    
    function build_menu_admin($parent, $menu, $id = "")
    {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            $cls = '';
            if ($parent == 0) {
                $cls = $id;
            }
            $html .= "<ul id='" . $cls . "'>\n";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $html .= "<li id='menu-" . $menu['items'][$itemId]['id'] . "' class='sortable'>\n  
                              <div class='ns-row'>
                                <div class='ns-title'>" . $menu['items'][$itemId]['title'] . "</div>
                                <div class='ns-url'>" . $menu['items'][$itemId]['slug'] . "</div>
                                <div class='ns-class'>" . @$menu['items'][$itemId]['sort'] . "</div>
                                <div class='ns-actions'>
                                   <a href='#' class='edit-menu' data-toggle='modal' data-target='#editModal' title='Edit'><img src='" . skin_url('images/edit.png') . "' alt='Edit'></a>
                                   <a href='#' class='delete-menu'><img src='" . skin_url('images/cross.png') . "' alt='Delete'></a>
                                   <input type='hidden' id='menu_id' name='menu_id' value='" . $menu['items'][$itemId]['id'] . "'>
                                   <input type='hidden' id='parents_id' name='parents_id' value='". @$menu['items'][$itemId]['parents_id'] ."'>
                                </div>
                             </div>
                           </li> \n";
                }
                if (isset($menu['parents'][$itemId])) {
                    $href = '';
                    if (isset($menu['items'][$itemId]['url']) && $menu['items'][$itemId]['url'] != null && $menu['items'][$itemId]['url'] != '') {
                        $href = "href='" . $menu['items'][$itemId]['url'] . "'";
                    }
                    $html .= "<li id='menu-" . $menu['items'][$itemId]['id'] . "' class='sortable'>\n
                            <div class='ns-row'>
                                <div class='ns-title'>" . $menu['items'][$itemId]['title'] . "</div>
                                <div class='ns-url'>" . $menu['items'][$itemId]['slug'] . "</div>
                                <div class='ns-class'>" . @$menu['items'][$itemId]['sort'] . "</div>
                                <div class='ns-actions'>
                                   <a href='#' class='edit-menu' data-toggle='modal' data-target='#editModal' title='Edit'><img src='" . skin_url('images/edit.png') . "' alt='Edit'></a>
                                   <a href='#' class='delete-menu'><img src='" . skin_url('images/cross.png') . "' alt='Delete'></a>
                                   <input type='hidden' id='menu_id' name='menu_id' value='" . $menu['items'][$itemId]['id'] . "'>
                                   <input type='hidden' id='parents_id' name='parents_id' value='". @$menu['items'][$itemId]['pid'] ."'>
                                </div>
                             </div>";
                    $html .= $this->build_menu_admin($itemId, $menu);
                    $html .= "</li> \n";
                }
            }
            $html .= "</ul> \n";
        }
        return $html;
    }
    
    // Begin: =======================================================
    function get_array_categories($business_type = false, $type = "", $keyword = "")
    {
        $table = !$business_type ? $this->table_name : $this->table_business;
        $where = "";
        if ($type != "") {
            $where .= " AND type='{$type}'";
        }
        if ($keyword != "") {
            $where .= " AND title LIKE '%{$keyword}%'";
        }
        $sql   = "SELECT * FROM $table WHERE id IS NOT NULL {$where} ORDER BY pid, sort, title";
        $query = $this->db->query($sql);
        
        // Create a multidimensional array to conatin a list of items and parents
        $menu = array(
            'items' => array(),
            'parents' => array()
        );
        // Builds the array lists with data from the menu table
        foreach ($query->result_array() as $items) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menu['items'][$items['id']]      = $items;
            // Creates entry into parents array. Parents array contains a list of all items with children
            $menu['parents'][$items['pid']][] = $items['id'];
        }
        
        return $menu;
    }
    
    function get_array_categories_by_parent($business_type=false, $type="", $keyword="", $parent=0) 
    {
        $categories = $this->get_array_categories($business_type, $type, "");
        return $this->get_recursive_trees($categories, $parent, $keyword);
    }
    
    function get_recursive_trees($menu, $parent=0, $keyword="")
    {
        $branch = array();
        
        if (isset($menu['parents'][$parent])) {
            foreach ($menu['parents'][$parent] as $key_id) {
                if (!isset($menu['parents'][$key_id])) { // Leaf
                    if (!empty($keyword) && strpos($menu['items'][$key_id]["title"],$keyword) !== FALSE) {
                        $branch[] = $menu['items'][$key_id];
                    }
                } else { // Folder
                    if (!empty($keyword) && strpos($menu['items'][$key_id]["title"],$keyword) !== FALSE) {
                        $branch[] = array("title" => $menu['items'][$key_id]['title'], "slug" => $menu['items'][$key_id]['slug'], "class_icon" => $menu['items'][$key_id]['class_icon'], "id" => $menu['items'][$key_id]['id'], "children" => $this->get_recursive_trees($menu, $menu['items'][$key_id]['id'], $keyword));
                    } else {
                        $branch[] = array("title" => "", "slug" => "", "class_icon" => $menu['items'][$key_id]['class_icon'], "id" => "-1", "children" => $this->get_recursive_trees($menu, $menu['items'][$key_id]['id'], $keyword));
                    }
                }
            }
        }
        return $branch;
    }
    
    // =================================================
    function get_list_categories($business_type = false)
    {
        $table = !$business_type ? $this->table_name : $this->table_business;
        $sql   = "SELECT * FROM $table WHERE type='system' ORDER BY pid, sort, title";
        $query = $this->db->query($sql);
        
        // Create a multidimensional array to conatin a list of items and parents
        $menu = array(
            'items' => array(),
            'parents' => array()
        );
        // Builds the array lists with data from the menu table
        foreach ($query->result_array() as $items) {
            // Creates entry into items array with current menu item id ie. $menu['items'][1]
            $menu['items'][$items['id']]      = $items;
            // Creates entry into parents array. Parents array contains a list of all items with children
            $menu['parents'][$items['pid']][] = $items['id'];
        }
        
        return $menu;
    }
    
    // Menu builder function, parentId 0 is the root
    function build_menu($parent, $menu)
    {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            $html .= "<ul>\n";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $html .= "<li>\n  <a href='" . $menu['items'][$itemId]['id'] . "'>" . $menu['items'][$itemId]['title'] . "</a>\n</li> \n";
                }
                if (isset($menu['parents'][$itemId])) {
                    $html .= "<li>\n  <a href='" . $menu['items'][$itemId]['id'] . "'>" . $menu['items'][$itemId]['title'] . "</a> \n";
                    $html .= $this->build_menu($itemId, $menu);
                    $html .= "</li> \n";
                }
            }
            $html .= "</ul> \n";
        }
        return $html;
    }
    
    // Checkbox
    function build_menu_checkbox($parent, $menu, $level)
    {
        $html = "";
        if (isset($menu['parents'][$parent]) && $level <= $this->get_max_level()) {
            $html .= "<ul>\n";
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $html .= "<li>\n  <label for=\"lbl-chk-tree-" . $menu['items'][$itemId]['id'] . "\"><input type=\"checkbox\" value=\"\" />" . $menu['items'][$itemId]['title'] . "</label>\n</li> \n";
                }
                if (isset($menu['parents'][$itemId])) {
                    $html .= "<li>  <label for=\"lbl-chk-tree-" . $menu['items'][$itemId]['id'] . "\"><input type=\"checkbox\" value=\"\" />" . $menu['items'][$itemId]['title'] . "</label>\n";
                    $html .= $this->build_menu_checkbox($itemId, $menu, ($level + 1));
                    $html .= "</li> \n";
                }
            }
            $html .= "</ul> \n";
        }
        return $html;
    }
    
    function get_cat_perant()
    {
        $this->db->select('*');
        $this->db->where('pid', 0);
        $this->db->where('type', 'system');
        $this->db->order_by("sort", "ASC");
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }
    
    function get_cat_checkradio()
    {
        $this->db->select('id');
        $this->db->where('type_show', "checkbox");
        $this->db->or_where('type_show', 'radio');
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }
    
    function get_lits_cat_parents($arg)
    {
        $this->db->select('*');
        $this->db->where_in('pid', $arg);
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }
    
    function get_cat_perant_like($arg,$like,$data_select)
    {
        $this->db->select('ct1.*,(SELECT `ct2`.`title` FROM `categories` as ct2 WHERE `ct2`.`id` = `ct1`.`pid`) as title_pr');
        $this->db->where_in("id",$arg);
        $this->db->like("title", $like);
        $this->db->where_not_in("title", $data_select);
        $this->db->limit(7, 0);
        $query = $this->db->get($this->table_name." AS ct1");
        return $query->result_array();
    }
     function get_cat_parent_single($arg,$title){
        $this->db->select('*');
        $this->db->where_in("id",$arg);
        $this->db->where("title",$title);
        $query = $this->db->get($this->table_name);
        if($query->num_rows()==0){
             return $query->num_rows();
        }else{
            return $query->row_array();
        }
    }
    function get_category_trees($parent, $menu, $level, $root_name)
    {
        $html = "";
        if (isset($menu['parents'][$parent]) && $level <= $this->get_max_level()) {
            if ($level === 0) {
                $html .= "<ol id=\"" . $root_name . "\" data-name=\"" . $root_name . "\">";
            } else {
                $html .= "<ul>";
            }
            
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $html .= "<li data-value=\"" . $menu['items'][$itemId]['id'] . "\"><a href=\"/search/" . $menu['items'][$itemId]['id'] . "\">" . $menu['items'][$itemId]['title'] . "</a></li>";
                }
                if (isset($menu['parents'][$itemId])) {
                    $html .= "<li data-value=\"" . $menu['items'][$itemId]['id'] . "\"><a href=\"/search/" . $menu['items'][$itemId]['id'] . "\">" . $menu['items'][$itemId]['title'] . "</a>";
                    $html .= $this->get_category_trees($itemId, $menu, ($level + 1), $root_name);
                    $html .= "</li>";
                }
            }
            if ($level === 0) {
                $html .= "</ol>";
            } else {
                $html .= "</ul>";
            }
        }
        return $html;
    }
    function get_by_category_name_like($name,$parents_id,$list_id){
        $this->db->select('*');
        $this->db->from('categories');
        $list=explode(',', $list_id);
        if(isset($parents_id) && count($parents_id)>0){
            $this->db->where_in('parents_id',$parents_id);
        }
        if(isset($list) && count($list)>0 ){
            $this->db->where_not_in('id',$list);
        }
        $this->db->like(array('title'=>$name));
        $this->db->limit(10,0);
        return $this->db->get()->result_array();
    }
    function get_by_keywords_name_like($name,$list_id,$type ="photo"){
        $this->db->select('*');
        $this->db->from('keywords');
        $list=explode(',', $list_id);
        if(isset($list) && count($list)>0 ){
            $this->db->where_not_in('keyword_id',$list);
        }
        $this->db->like(array('title'=>$name));
        $this->db->where("type", $type);
        $this->db->limit(10,0);
        return $this->db->get()->result_array();
    }
    function get_by_keywords_name_like_a($name,$list_id,$type ="article"){
        $this->db->select('*');
        $this->db->from('keywords');
        $list = explode(',', $list_id);
        $list = array_diff($list, array(''));
        if(isset($list) && count($list)>0 ){
            $this->db->where_not_in('title',$list);
        }
        $this->db->like(array('title'=>$name));
        $this->db->where("type", $type);
        $this->db->limit(10,0);
        return $this->db->get()->result_array();
    }
    function get_by_name($name,$parents_id=null){
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where(array('title'=>trim($name)));
        if(isset($parents_id) && count($parents_id)>0){
            $this->db->where_in('parents_id',$parents_id);
        }
        return $this->db->get()->row_array();
    }

    function get_category_by_photo($photo_id){
        $this->db->select('p.*,c.title,c.slug');
        $this->db->from('photo_category as p');
        $this->db->join('categories as c','p.category_id=c.id','');
        $this->db->where(array('p.photo_id'=>$photo_id));
        return $this->db->get()->result_array();
    }

    function get_keyword_by_photo($photo_id){
        $this->db->select('p.*,k.title');
        $this->db->from('photo_keyword as p');
        $this->db->join('keywords as k','k.keyword_id=p.keyword_id','');
        $this->db->where(array('p.photo_id'=>$photo_id));
        return $this->db->get()->result_array();
    }
    function get_cat_by_photo($photo_id,$in_id){
        $this->db->select("c.id,c.title");
        $this->db->from("categories AS c");
        $this->db->join("photo_category AS pc","c.id = pc.category_id");
        $this->db->where_in("pc.photo_id",$photo_id);
        $this->db->where_in("pc.category_id",$in_id);
        $this->db->group_by("c.id");
        return $this->db->get()->result_array();
    }
    function random_photo_project($user_id){
        $this->db->select("*");
        $this->db->from("photos");
        $this->db->where("member_id",$user_id);
        $this->db->order_by('id', 'RANDOM');
        $this->db->limit(5);
        return $this->db->get()->result_array();
    }
    // End: =======================================================
}