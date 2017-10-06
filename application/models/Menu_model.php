<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model {

    var $table_name = 'menu';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    
    // Begin: =======================================================
    function get_list_menu()
    {
    	$sql = "SELECT * FROM $this->table_name ORDER BY pid, id, title"; 
		$query = $this->db->query($sql);
		
		// Create a multidimensional array to conatin a list of items and parents
		$menu = array(
		    'items' => array(),
		    'parents' => array()
		);
		// Builds the array lists with data from the menu table
		foreach($query->result_array() as $items)
		{
		    // Creates entry into items array with current menu item id ie. $menu['items'][1]
		    $menu['items'][$items['id']] = $items;
		    // Creates entry into parents array. Parents array contains a list of all items with children
		    $menu['parents'][$items['pid']][] = $items['id'];
		}
		
		return $menu;
    }


    function get_list_menu_group($group_id)
    {
    	$sql = "SELECT * FROM $this->table_name WHERE group_id=$group_id  ORDER BY sort_id, id, title"; 
		$query = $this->db->query($sql);
		
		// Create a multidimensional array to conatin a list of items and parents
		$menu = array(
		    'items' => array(),
		    'parents' => array()
		);
		// Builds the array lists with data from the menu table
		foreach($query->result_array() as $items)
		{
		    // Creates entry into items array with current menu item id ie. $menu['items'][1]
		    $menu['items'][$items['id']] = $items;
		    // Creates entry into parents array. Parents array contains a list of all items with children
		    $menu['parents'][$items['pid']][] = $items['id'];
		}
		
		return $menu;
    }
    
    // Menu builder function, parentId 0 is the root
	function build_menu($parent, $menu,$class="")
	{
	   $html = "";
	   if (isset($menu['parents'][$parent]))
	   {
	   	  $cls='';
	   	  if($parent==0){$cls=$class;}
	      $html .= "<ul class='".$cls."'>\n";
	       foreach ($menu['parents'][$parent] as $itemId)
	       {
	          if(!isset($menu['parents'][$itemId]))
	          {
	             $html .= "<li class='".$menu['items'][$itemId]['class']."'><a href='".base_url($menu['items'][$itemId]['url']."'>".urldecode($menu['items'][$itemId]['title']))."</a>\n</li> \n";
	          }
	          if(isset($menu['parents'][$itemId]))
	          {
	          	 $href='';
	          	 if(isset($menu['items'][$itemId]['url']) && $menu['items'][$itemId]['url']!=null && $menu['items'][$itemId]['url']!=''){
	          	 	$href="href='".base_url($menu['items'][$itemId]['url'])."'";
	          	 }
	             $html .= "<li class='".$menu['items'][$itemId]['class']."'><a ".$href.">".urldecode($menu['items'][$itemId]['title'])."</a> \n";
	             $html .= $this->build_menu($itemId, $menu);
	             $html .= "</li> \n";
	          }
	       }
	       $html .= "</ul> \n";
	   }
	   return $html;
	}

	function build_menu_admin($parent, $menu,$id="")
	{
	   $html = "";
	   if (isset($menu['parents'][$parent]))
	   {
	   	  $cls='';
	   	  if($parent==0){$cls=$id;}
	      $html .= "<ul id='".$cls."'>\n";
	       foreach ($menu['parents'][$parent] as $itemId)
	       {
	          if(!isset($menu['parents'][$itemId]))
	          {
	             $html .= "<li id='menu-".$menu['items'][$itemId]['id']."' class='sortable'>\n  
	          			      <div class='ns-row'>
					            <div class='ns-title'>".$menu['items'][$itemId]['title']."</div>
					            <div class='ns-url'>".$menu['items'][$itemId]['url']."</div>
					            <div class='ns-class'>".@$menu['items'][$itemId]['class']."</div>
					            <div class='ns-actions'>
					               <a href='#' class='edit-menu' data-toggle='modal' data-target='#editModal' title='Edit Menu'><img src='".skin_url('images/edit.png')."' alt='Edit'></a>
                                   <a href='#' class='delete-menu'><img src='".skin_url('images/cross.png')."' alt='Delete'></a>
					               <input type='hidden' id='menu_id' name='menu_id' value='".$menu['items'][$itemId]['id']."'>
					            </div>
					         </div>
	                       </li> \n";
	          }
	          if(isset($menu['parents'][$itemId]))
	          {
	          	 $href='';
	          	 if(isset($menu['items'][$itemId]['url']) && $menu['items'][$itemId]['url']!=null && $menu['items'][$itemId]['url']!=''){
	          	 	$href="href='".$menu['items'][$itemId]['url']."'";
	          	 }
	             $html .= "<li id='menu-".$menu['items'][$itemId]['id']."' class='sortable'>\n
	             			<div class='ns-row'>
					            <div class='ns-title'>".$menu['items'][$itemId]['title']."</div>
					            <div class='ns-url'>".$menu['items'][$itemId]['url']."</div>
					            <div class='ns-class'>".@$menu['items'][$itemId]['class']."</div>
					            <div class='ns-actions'>
					               <a href='#' class='edit-menu' data-toggle='modal' data-target='#editModal' title='Edit Menu'><img src='".skin_url('images/edit.png')."' alt='Edit'></a>
                                   <a href='#' class='delete-menu'><img src='".skin_url('images/cross.png')."' alt='Delete'></a>
					               <input type='hidden' id='menu_id' name='menu_id' value='".$menu['items'][$itemId]['id']."'>
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
	
	function show_menu($parent, $menu, $level, $root_name) 
	{
		$html = "";
	   	if (isset($menu['parents'][$parent]) && $level <= $this->get_max_level())
	   	{
	   		if ($level === 0) 
	   		{
	   			$html .= "<ol id=\"" . $root_name . "\" data-name=\"" . $root_name . "\">";
	   		} 
	   		else 
	   		{
	   			$html .= "<ul>";
	   		}
	      	
	       	foreach ($menu['parents'][$parent] as $itemId)
	       	{
	          	if(!isset($menu['parents'][$itemId]))
	          	{
	             	$html .= "<li data-value=\"" . $menu['items'][$itemId]['id'] . "\"><a href=\"/search/" . $menu['items'][$itemId]['id'] . "\">" .urldecode($menu['items'][$itemId]['title'])."</a></li>";
	          	}
	          	if(isset($menu['parents'][$itemId]))
	          	{
	             	$html .= "<li data-value=\"" . $menu['items'][$itemId]['id'] . "\"><a href=\"/search/" . $menu['items'][$itemId]['id'] . "\">" .urldecode($menu['items'][$itemId]['title'])."</a>";
	             	$html .= $this->get_category_trees($itemId, $menu, ($level + 1), $root_name);
	             	$html .= "</li>";
	          	}
	       	}
	       	if ($level === 0) 
	   		{
	   			$html .= "</ol>";
	   		} 
	   		else
	   		{
	   			$html .= "</ul>";
	   		}
	   	}
	   	return $html;
	}
     

    function updateMenuItem($id,$data){
         $this->db->where(array("id"=>$id));
         $this->db->update("menu",$data);
    }
    function deleteMenuItem($id){
         $this->db->where('id',$id);
         $this->db->delete('menu');
    }
    function addMenuItem($data){
	    $this->db->trans_start();
		$this->db->insert("menu", $data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $insert_id;
    }
    function getItemMenu($id){
    	$this->db->select('*');
    	$this->db->from('menu');
    	$this->db->where(array("id"=>$id));
    	return $this->db->get()->row_array();
    }

    function getMenuGroup(){
    	$this->db->select('*');
    	$this->db->from('menu_group');
    	return $this->db->get()->result_array();
    }
    function addMenuGroup($data){
	    $this->db->trans_start();
		$this->db->insert("menu_group", $data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return $insert_id;
    }
    function getMenuGroupItem($id){
    	$this->db->select('*');
    	$this->db->from('menu_group');
    	$this->db->where(array('id'=>$id));
    	return $this->db->get()->row_array();
    }

	// End: =======================================================
}