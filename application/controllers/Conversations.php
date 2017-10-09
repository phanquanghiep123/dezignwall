<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class Conversations extends CI_Controller

{

	private $user_id=null;

	private $user_info = null;

    private $is_login = false;

    private $data;

	public function __construct()

    {

        parent::__construct();

        if($this->session->userdata('user_info')){

        	$this->is_login=true;

        	$this->user_info = $this->session->userdata('user_info');

        	$this->user_id   = $this->user_info["id"];
        }
        $this->data['skins']='conversations';

    }

    public function index($id=null){

        $user_id = ($id==null) ? $this->user_id : $id;

        $record= $this->Common_model->get_record("members",array(

            'id'=>$user_id

        ));

        $this->data["is_login"] = $this->is_login;

        $this->data["title_page"] ="Conversations";

        $this->data['user_id']=$user_id;

        if( !(isset($record) && $record!=null) ){

            redirect('/');

        }

        $this->load->view('block/header',$this->data);

        $this->load->view('conversations/index',$this->data);

        $this->load->view('block/footer',$this->data);
    }
}