<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project_model extends MY_Model
{
    var $_table_projects = 'projects';
    var $_table_project_category = 'project_categories';
    var $_table_project_invite = 'project_invite';
    var $_table_products = 'products';
    var $_table_project_member = 'project_member';
    var $_table_tracking = 'common_tracking';
    var $_table_members = 'members';
    var $_custom = 'custom';
    var $_auto = 'auto';
    var $_status_project = 'no';
    var $_status_category = 'no';
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function add_project($data)
    {
        return $this->create($this->_table_projects, $data);
    }
    
    function delete_project($project_id, $member_id)
    {
        return $this->delete($this->_table_projects, array(
                    'project_id' => $project_id,
                    'member_id' => $member_id,
                    'type_project' => $this->_custom
                ));
    }
    
    function update_project($data, $project_id, $member_id)
    {
        return $this->update($this->_table_projects, $data, array('project_id' => $project_id, 'member_id' => $member_id));
    }
    
    function get_collection_projects($member_id = null, $keyword = null, $limit, $start)
    {
        $this->db->distinct();
        $this->db->limit($limit, $start);
        $this->db->select('p.*');
        $this->db->from($this->_table_projects . " as p");
        if ($keyword != null) {
            $this->db->like('p.title', $keyword);
        }
        if ($member_id != null) {
            $this->db->where('p.member_id', $member_id);
        }
        $this->db->where('p.status', $this->_status_project);
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    function get_all_projects($member_id = null)
    {
        $this->db->distinct();
        $this->db->select('p.*');
        $this->db->order_by('type_project');
        $this->db->from($this->_table_projects . " as p");
        if ($member_id != null) {
            $this->db->where('p.member_id', $member_id);
        }
        $this->db->where('p.status', $this->_status_project);
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    function count_collection_projects($member_id = null, $keyword = null)
    {
        $this->db->distinct();
        $this->db->select('p.project_id');
        $this->db->from($this->_table_projects . " as p");
        if ($keyword != null) {
            $this->db->like('p.title', $keyword);
        }
        if ($member_id != null) {
            $this->db->where('p.member_id', $member_id);
        }
        $this->db->where('p.status', $this->_status_project);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    function get_project_by_title($member_id, $title)
    {
        $this->db->distinct();
        $this->db->select('p.project_id');
        $this->db->from($this->_table_projects . " as p");
        $this->db->where('p.member_id', $member_id);
        $this->db->where('p.project_name', $title);
        $this->db->where('p.status', $this->_status_project);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    // Get all project for member and project invited
    function get_project_invite_member($member_id = null)
    {
        // My project
        $this->db->distinct();
        $this->db->select('p.*, m.first_name, m.last_name');
        $this->db->from($this->_table_projects . " as p");
        if ($member_id != null) {
            $this->db->where('p.member_id', $member_id);
        }
        $this->db->where('p.status', $this->_status_project);
        $this->db->join($this->_table_members . " as m", 'm.id = p.member_id');
        $query = $this->db->get();
        $result1 = $query->result_array();
        
        // Project invite
        $this->db->distinct();
        $this->db->select('p.*, m.first_name, m.last_name');
        $this->db->from($this->_table_projects . " as p");
        $this->db->join($this->_table_project_member . " as pm", 'pm.project_id = p.project_id');
        $this->db->join($this->_table_members . " as m", 'm.id = p.member_id');
        if ($member_id != null) {
            $this->db->where('pm.member_id', $member_id);
        }
        $this->db->where('p.status', $this->_status_project);
        $query = $this->db->get();
        $result2 = $query->result_array();
        
        $array_return = $result1;
        foreach ($result2 as $item_out) {
            $check = false;
            foreach ($result1 as $item_in) {
                if ($item_out["project_id"] == $item_in["project_id"]) {
                    $check = true;
                }
            }
            if (!$check) {
                array_push($array_return, $item_out);
            }
        }
        
        return $array_return;
    }
    
    function get_project($project_id, $member_id)
    {
        $this->db->select('p.*');
        $this->db->limit(1, 0);
        $this->db->from($this->_table_projects . " as p");
        if ($member_id != null) {
            $this->db->where('p.member_id', $member_id);
        }
        if ($project_id != null) {
            $this->db->where('p.project_id', $project_id);
        }
        $query = $this->db->get();
        $result1 = $query->row_array();
        
        $this->db->select('p.*');
        $this->db->limit(1, 0);
        $this->db->from($this->_table_projects . " as p");
        $this->db->join($this->_table_project_member . " as pm", 'pm.project_id = p.project_id');
        if ($member_id != null) {
            $this->db->where('pm.member_id', $member_id);
        }
        if ($project_id != null) {
            $this->db->where('p.project_id', $project_id);
        }
        $this->db->where('p.status', $this->_status_project);
        $query = $this->db->get();
        $result2 = $query->row_array();

        $array_return = $result1;
        if ($result1 != null && $result2 != null) {
            $array_return = array_merge($result1,$result2);
        } else if ($result1 != null) {
            $array_return = $result1;
        } else if ($result2 != null) {
            $array_return = $result2;
        }
        
        return $array_return;
    }

    function get_project_member($project_id){
        $this->db->select('m.first_name,m.last_name');
        $this->db->from("project_member as p");
        $this->db->join("members as m", 'm.id = p.member_id');
        $this->db->order_by('p.project_id','DESC');
        $this->db->where(array("p.project_id"=>$project_id));
        return $this->db->get()->result_array();
    }
    
    function add_project_category($data)
    {
        $this->db->trans_start();
        $this->db->insert($this->_table_project_category, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    function delete_project_category($project_id, $category_id)
    {
        $return = false;
        $this->db->trans_start();
        $return = $this->db->delete($this->_table_project_category, array(
            'project_id' => $project_id,
            'category_id' => $category_id,
            'type_category' => $this->_custom
        ));
        $this->db->trans_complete();
        
        return $return;
    }
    
    function update_project_category($data, $category_id, $project_id = null)
    {
        $return = false;
        $this->db->trans_start();
        $this->db->where('category_id', $category_id);
        if ($project_id != null) {
            $this->db->where('project_id', $project_id);
        }
        $return = $this->db->update($this->_table_project_category, $data);
        $this->db->trans_complete();
        
        return $return;
    }
    
    function get_collection_project_category($project_id = null, $keyword = null, $limit, $start)
    {
        $this->db->distinct();
        $this->db->limit($limit, $start);
        $this->db->select('p.*, t.*');
        $this->db->from($this->_table_project_category . " as p");
        $this->db->join($this->_table_tracking . " as t", 't.reference_id = p.category_id and t.type_object="category"', 'left');
        if ($project_id != null) {
            $this->db->where('project_id', $project_id);
        }
        if ($keyword != null) {
            $this->db->like('p.title', $keyword);
        }
        $this->db->where('p.status', $this->_status_category);
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    function count_collection_project_category($project_id = null, $keyword = null)
    {
        $this->db->select('p.project_id');
        $this->db->from($this->_table_project_category . " as p");
        if ($project_id != null) {
            $this->db->where('project_id', $project_id);
        }
        if ($keyword != null) {
            $this->db->like('p.title', $keyword);
        }
        $this->db->where('p.status', $this->_status_category);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    function get_category_project_by_title($project_id, $title)
    {
        $this->db->distinct();
        $this->db->select('p.category_id');
        $this->db->from($this->_table_project_category . " as p");
        $this->db->where('p.project_id', $project_id);
        $this->db->where('p.title', $title);
        $this->db->where('p.status', $this->_status_category);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    function get_project_category($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->where('status', $this->_status_category);
        $query = $this->db->get($this->_table_project_category);
        return $query->row_array();
    }
    
    function get_project_category_pj_id($project_id)
    {
        $this->db->where('project_id', $project_id);
        $this->db->where('status', $this->_status_category);
        $query = $this->db->get($this->_table_project_category);
        return $query->result_array();
    }
    
    function get_project_id($member_id)
    {
        $this->db->where('member_id', $member_id);
        $this->db->where('status', $this->_status_project);
        $query = $this->db->get($this->_table_projects);
        return $query->result_array();
    }
    
    function get_favorites_id($member_id)
    {
        $this->db->where('member_id', $member_id);
        $query = $this->db->get('favorites');
        return $query->result_array();
    }
    
    function project_join_project_category($member_id, $photo_id)
    {
        $this->db->distinct();
        $this->db->select('p.project_id,p.project_name,p.member_id,pc.category_id,pc.title,f.product_id,f.photo_id');
        $this->db->from($this->_table_projects . " as p");
        $this->db->join($this->_table_project_category . " as pc", 'pc.project_id = p.project_id');
        $this->db->join($this->_table_products . " as f", 'f.category_id = pc.category_id and f.photo_id =' . $photo_id . '', 'left');
        $this->db->where('p.member_id', $member_id);
        $this->db->where('p.status', $this->_status_project);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function add_project_invite($data)
    {
        $this->db->trans_start();
        $this->db->insert($this->_table_project_invite, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    function check_email_in_project($member_id, $project_id)
    {
        $this->db->select('p.*');
        $this->db->from($this->_table_project_member . " as p");
        if ($project_id != null) {
            $this->db->where('project_id', $project_id);
        }
        if ($member_id != null) {
            $this->db->where('member_id', $member_id);
        }
        $query = $this->db->get();
        
        return $query->result_array();
    }

    function check_record_invite($member_id, $project_id){
        $this->db->select('*');
        $this->db->from("project_invite");
        $this->db->where(array('owner_id'=>$member_id,"project_id"=>$project_id));
        $query = $this->db->get();
        return $query->row_array();
    }

    function getProjectByID($project_id){
        $this->db->select("*");
        $this->db->from('projects');
        $this->db->where('project_id',$project_id);
        return $this->db->get()->row_array();
    }


    function getMemberByProjectId($projectid){
        $this->db->select('pm.project_id,p.project_name,p.project_no,m.id,m.email,m.first_name,m.last_name');
        $this->db->from("project_member as pm");
        $this->db->join("members as m","pm.member_id=m.id","left");
        $this->db->join("projects as p","pm.project_id=p.project_id","left");
        $this->db->where(array("pm.project_id"=>$projectid));
        $this->db->where('p.status', $this->_status_project);
        return $this->db->get()->result_array();
    }
    
    function get_member_project($project){
        $this->db->select('member_id');
        $this->db->where('project_id',$project);
        $this->db->where('status', $this->_status_project);
        $query = $this->db->get('projects');
        return $query->row_array(); 

    }
//======================================new================================//
    function get_list_member_project($project_id){
        $this->db->select('*');
        $this->db->from($this->_table_project_member);
        $this->db->where(array('project_id'=>$project_id));
        return $this->db->get()->result_array();
    }
    function get_all_project_member($member_id){
        $this->db->distinct();
        $this->db->select('pj.project_id AS pr_id,pj.member_id AS member_onew,pj.project_name,pj.created_at,pji.member_id AS member_invite,pji.join_date,mb.first_name,mb.last_name');
        $this->db->from($this->_table_projects." AS pj");
        $this->db->join("project_member AS pji","pji.project_id = pj.project_id","left");
        $this->db->join("members AS mb","mb.id = pj.member_id");
        $this->db->where("pj.member_id",$member_id);
        $this->db->or_where("pji.member_id",$member_id);
        $this->db->group_by("pj.project_id");
        return $this->db->get()->result_array();
    }
	function check_member_project($member,$project){
		$this->db->distinct();
        $this->db->select('*');
        $this->db->from($this->_table_projects." AS pj");
        $this->db->join("project_member AS pji","pji.project_id = pj.project_id AND pj.project_id = ".$project."","left");
		$this->db->where("pj.project_id",$project);
        $this->db->where("pj.member_id",$member);
        $this->db->or_where("pji.member_id",$member);
        return $this->db->get()->result_array();
	}
    function get_packages_use($user_id){
        $this->db->select("p.max_files");
        $this->db->from("member_expand AS mx");
        $this->db->join("packages AS p","p.id = mx.package_id");
        $this->db->where(["mx.member_id"=>$user_id,"type" => "1","mx.status" => "yes"]);
        $query = $this->db->get()->row_array();
        if($query == null){
            return 1;
        }
        return ($query["max_files"] + 1);
    }
    function get_img_cat($id){
        $this->db->select("pt.path_file");
        $this->db->from("products AS pd");
        $this->db->join("photos AS pt","pt.photo_id = pd.photo_id");
        $this->db->where("pd.category_id",$id);
        $query = $this->db->get()->row_array();
        if($query == null){
            return "/skins/images/default-product.jpg";
        }
        return $query["path_file"];
    }
    function get_project_member_on_profile($member_id = null,$offset = 0, $limit = 2)
    {
        $sql = "select `tbl4`.* from  (
                    ( select `tbl1`.`project_id` from `projects` AS tbl1 Where `tbl1`.`member_id` = $member_id )
                    UNION
                    ( select `tbl2`.`project_id` from `project_member` AS tbl2 Where `tbl2`.`member_id` = $member_id )
                ) AS tbl3               
                join `projects` AS tbl4 on `tbl4`.`project_id` = `tbl3`.`project_id` 
                order by `tbl4`.`project_id` DESC
                limit $offset , $limit";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function get_all_member_invite($project_id,$offset = 0, $limit = 2){
        $this->db->select("tbl3.*,tbl2.join_date");
        $this->db->from("project_member AS tbl2");
        $this->db->join("company AS tbl3",'tbl3.member_id = tbl2.member_id');
        $this->db->where("tbl2.project_id",$project_id);
        $this->db->order_by("tbl2.id","DESC");
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }
    function all_folder_for_project ($project_id,$offset = 0, $limit = 2){
        $this->db->select("tbl3.*,tbl1.category_id");
        $this->db->from("project_categories AS tbl1");
        $this->db->join("products AS tbl2","tbl2.category_id = tbl1.category_id");
        $this->db->join("photos AS tbl3","tbl3.photo_id = tbl2.photo_id");
        $this->db->where("tbl1.project_id",$project_id);
        $this->db->order_by('rand()');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();

    }
    function count_folder_for_project($project_id){
        $this->db->select("tbl3.id");
        $this->db->from("project_categories AS tbl1");
        $this->db->join("products AS tbl2","tbl2.category_id = tbl1.category_id");
        $this->db->join("photos AS tbl3","tbl3.photo_id = tbl2.photo_id");
        $this->db->where("tbl1.project_id",$project_id);
        return $this->db->count_all_results();
    }
    function get_last_comment($project_id){
        $this->db->select("tbl3.*,tbl2.comment,tbl2.created_at AS created_at_comment");
        $this->db->from("project_categories AS tbl1");
        $this->db->join("common_comment AS tbl2","tbl2.reference_id = tbl1.category_id AND tbl2.type_object = 'category'");
        $this->db->join("members AS tbl3","tbl3.id = tbl2.member_id");
        $this->db->where("tbl1.project_id",$project_id);
        $this->db->order_by("tbl2.id","DESC");
        $this->db->limit(1);
        $query = $this->db->get()->row_array();
        return $query;
    }
    //======================================!new================================//
    
}





