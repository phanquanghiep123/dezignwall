<?php
/**
* 
*/
class Text extends CI_Controller
{
	
	function __construct()
	{
		  parent::__construct();
	}
	public function index(){
		$this->load->model("Category_model");
		$this->Category_model->get_category_by_business("dfvdfgd","zsdaszcd");
		$this->output->enable_profiler(TRUE);
	}
}