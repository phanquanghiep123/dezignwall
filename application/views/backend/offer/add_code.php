<?php
/*
1. LOGIN
2. PROFILES
3. PHOTOS
4. PAGES
5. PACKAGES
6. MENU
7. CAMPAIGN
8. CATEGORIES
*/
class Admin extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'form',
            'url'
        ));
        $this->load->model('Members_model');
        $this->load->model('Post_model');
        $this->load->library(array(
            'pagination',
            'form_validation',
            "session"
        ));
    }
    
    private $rules_login = array(array('field' => 'user', 'label' => 'user', 'rules' => 'valid_email|trim|required'), array('field' => 'password', 'label' => 'password', 'rules' => 'trim|required'));
    private $rules_profile_edit = array(array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'trim|required'), array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'trim|required'), array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email'), array('field' => 'company_name', 'label' => 'Company Name', 'rules' => 'trim|required'));
    private $rules_profile_add = array();
    private $rules_page = array(array('field' => 'page_title', 'label' => 'Title', 'rules' => 'trim|required'));
    private $rules_photo_edit = array(array('field' => 'name', 'label' => 'Name', 'rules' => 'trim|required'), array('field' => 'type', 'label' => 'Type', 'rules' => 'trim|required'), array('field' => 'product_name', 'label' => 'Product name', 'rules' => 'trim|required'), array('field' => 'product_no', 'label' => 'Product no', 'rules' => 'trim|required'), array('field' => 'price', 'label' => 'Price', 'rules' => 'trim|required'), array('field' => 'product_note', 'label' => 'Product note', 'rules' => 'trim|required'));
    
    function getGuid()
    {
        // using micro time as the last 4 digits in base 10 to prevent collision with another request
        list($micro_time, $time) = explode(' ', microtime());
        $id = round((rand(0, 217677) + $micro_time) * 10000);
        $id = base_convert($id, 10, 36);
        
        return $id;
    }
    
    public function recursive($parentid = 0, $data = Null, $step = '')
    {
        if (isset($data) && is_array($data)) {
            foreach ($data as $key => $val) {
                if ($val['parent_id'] == $parentid) {
                    $val['depth']                = $step;
                    $this->recursive[$val['id']] = $val;
                    $this->recursive($val['id'], $data, $step . '-- ');
                    
                    
                }
            }
        }
        
        return $this->recursive;
    }
    
    
    /*-------------------------------
    -------------1. LOGIN------------
    ---------------------------------*/
    
    function is_login()
    {
        if ($this->session->userdata('logged_in') == false) {
            redirect('/admin/login');
        }
    }
    
    public function login()
    {
        if ($this->session->userdata('logged_in') == FALSE) {
            $data['title'] = 'Login';
            $data['error'] = FALSE;
            $this->form_validation->set_rules($this->rules_login);
            $this->form_validation->set_error_delimiters('<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>', '<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
            if ($this->input->post()) {
                if ($this->form_validation->run() != FALSE) {
                    $user_mail = $this->input->post('user');
                    $password  = $this->input->post('password');
                    $result    = $this->Members_model->get_admin_login($user_mail, $password);
                    if (count($result) == 1) {
                        $dataArr = array(
                            'logged_in' => TRUE,
                            'user_id' => $result->id,
                            'name' => $result->name,
                            'role' => $result->role,
                            'user_email' => $result->email
                        );
                        
                        $this->session->set_userdata($dataArr);
                        print_r($dataArr);
                        redirect('admin');
                        
                    } else {
                        $data['error'] = TRUE;
                        $this->session->set_flashdata('error_data', '<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>Please check email and password again.<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
                        redirect('admin/login');
                    }
                } else {
                    $data['error'] = TRUE;
                }
            }
            $this->load->view("backend/login", $data);
        } else {
            redirect('admin');
        }
        
        return true;
    }
    
    
    function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/login');
    }
    
    public function dashboard()
    {
        //$this->is_login();
        $data['title']    = 'Admin Panel';
        $data['current']  = "profile";
        $data['profiles'] = $this->Members_model->getAllMembers();
        
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    /*-------------------------------
    -------------2. PROFILES------------
    ---------------------------------*/
    public function profiles()
    {
        //$this->is_login();
        $data['title']    = 'Admin Panel';
        $data['current']  = "profile";
        $data['profiles'] = $this->Members_model->getAllMembers();
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function delProfile($id)
    {
        if (isset($id) && !empty($id)) {
            $this->Members_model->del($id);
            $this->session->set_flashdata('message', 'Del message.');
            redirect('admin');
        }
    }
    
    public function editProfile($id)
    {
        //$this->is_login();
        $data['title']   = 'Edit Profile';
        $data['profile'] = $this->Members_model->getById($id);
        $data['current'] = "profile";
        if ($this->input->post()) {
            $this->form_validation->set_rules($this->rules_profile_edit);
            $this->form_validation->set_error_delimiters('<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> ', '<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
            if ($this->form_validation->run() != FALSE) {
                $dataUpdate = array(
                    "last_name" => $this->input->post('last_name'),
                    "first_name" => $this->input->post('first_name'),
                    "email" => $this->input->post('email'),
                    "company_name" => $this->input->post('company_name'),
                    "title" => $this->input->post('title'),
                    "years_employed" => $this->input->post('years_employed'),
                    "work_ph" => $this->input->post('work_ph'),
                    "work_email" => $this->input->post('work_email'),
                    "facebook" => $this->input->post('facebook'),
                    "houzz" => $this->input->post('houzz'),
                    "linkedin" => $this->input->post('linkedin'),
                    "instagram" => $this->input->post('instagram'),
                    "google" => $this->input->post('google'),
                    "youtube" => $this->input->post('youtube'),
                    "twitter" => $this->input->post('twitter'),
                    "vimeo" => $this->input->post('vimeo')
                );
                $this->Members_model->updateDetails($id, $dataUpdate);
                $this->session->set_flashdata('message', '<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> Your information have been saved successfully.<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
                redirect('admin/editProfile/' . $id);
            }
        }
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/profile/edit', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function addProfile()
    {
        //$this->is_login();
        $data['title']   = 'Add Profile';
        $data['current'] = "profile";
        if ($this->input->post()) {
            $this->form_validation->set_rules($this->rules_profile_add);
            $this->form_validation->set_error_delimiters('<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> ', '<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
            if ($this->form_validation->run() != FALSE) {
                $dataAdd      = array(
                    "last_name" => $this->input->post('last_name'),
                    "first_name" => $this->input->post('first_name'),
                    "email" => $this->input->post('email'),
                    "pwd" => md5($this->input->post('password')),
                    "pwd_temp" => $this->input->post('password'),
                    "company_name" => $this->input->post('company_name'),
                    "slug_general" => $this->getGuid(),
                    "enable" => "1",
                    "resource_from" => "regular"
                );
                $insert_id    = $this->Members_model->add($dataAdd);
                $data_session = array(
                    'message' => '<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> Your information have been saved successfully.<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>',
                    'data' => $dataAdd
                );
                
                $this->session->set_flashdata('data_flash_session', $data_session);
                //redirect('admin/editProfile/'.$insert_id);
            }
        }
        
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/profile/add', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    
    /*-------------------------------
    -------------3. PHOTOS------------
    ---------------------------------*/
    public function photos()
    {
        //$this->is_login();
        $this->load->model('Photo_model');
        $data['title']       = 'Photos';
        $data['current']     = "photo";
        $data['table_photo'] = $this->Photo_model->getallphoto();
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/photos/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function editphoto($photo_id)
    {
        //$this->is_login();
        $this->load->model('Photo_model');
        $data['title']       = 'Edit Photo';
        $data['items_photo'] = $this->Photo_model->get_detail_photo($photo_id);
        $data['current']     = "photo";
        if ($this->input->post()) {
            $this->form_validation->set_rules($this->rules_photo_edit);
            $this->form_validation->set_error_delimiters('<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> ', '<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
            if ($this->form_validation->run() != FALSE) {
                $dataUpdate = array(
                    "name" => $this->input->post('name'),
                    "type" => $this->input->post('type'),
                    "product_name" => $this->input->post('product_name'),
                    "product_no" => $this->input->post('product_no'),
                    "price" => $this->input->post('price'),
                    "qty" => $this->input->post('qty'),
                    "product_note" => $this->input->post('product_note'),
                    "fob" => $this->input->post('fob')
                );
                $this->Photo_model->updatePhotoInfo($photo_id, $dataUpdate);
                $this->session->set_flashdata('message', '<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> Your information have been saved successfully.<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
                redirect('admin/editphoto/' . $photo_id);
            }
        }
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/photos/edit', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function delphoto($photo_id)
    {
        if (isset($photo_id) && !empty($photo_id)) {
            $this->load->model('Photo_model');
            $this->Photo_model->deletemyphotoid($photo_id);
            redirect('/admin/photos');
        }
    }
    
    public function hiddenStatusphoto($photo_id)
    {
        $this->load->model('Photo_model');
        $this->Photo_model->update_status($photo_id);
        header("location:/admin/photos");
    }
    
    /*-------------------------------
    -------------4. PAGES------------
    ---------------------------------*/
    public function pages()
    {
        //$this->is_login();
        
        $data['title']   = 'Pages';
        $data['current'] = "page";
        $data['pages']   = $this->recursive(0, $this->Post_model->get_all_by_type('page'), '');
        //$data['pages'] =$this->Post_model->get_all_by_type('page');
        
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/pages/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function addPage()
    {
        $data['pages'] = $this->recursive(0, $this->Post_model->get_all_by_type('page'), '');
        if ($this->input->post()) {
            $this->form_validation->set_rules($this->rules_page);
            $this->form_validation->set_error_delimiters('<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> ', '<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
            if ($this->form_validation->run() != FALSE) {
                
                $config = array(
                    'field' => 'slug',
                    'title' => 'title',
                    'table' => 'post',
                    'id' => 'id'
                );
                $this->load->library('slug', $config); //http://ericlbarnes.com/codeigniter-slug-library/
                
                $dataAdd         = array(
                    "title" => $this->input->post('page_title'),
                    "content" => $this->input->post('page_content'),
                    "template" => $this->input->post('page_template'),
                    "parent_id" => $this->input->post('page_parent'),
                    "type" => 'page'
                    
                );
                $dataAdd['slug'] = $this->slug->create_uri($dataAdd);
                $insert_id       = $this->Post_model->add($dataAdd);
                $data_session    = array(
                    'message' => '<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> Your information have been saved successfully.<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>',
                    'data' => $dataAdd
                );
                
                $this->session->set_flashdata('data_flash_session', $data_session);
                //redirect('admin/editPage/'.$insert_id);
            }
        }
        
        $data['title']   = 'Add New Page';
        $data['current'] = "page";
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/pages/addnew', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function editPage($id)
    {
        //$this->is_login();
        $data['title']    = 'Edit Page';
        $data['the_page'] = $this->Post_model->get_by_id($id);
        $data['pages']    = $this->recursive(0, $this->Post_model->get_all_by_type('page'), '');
        $data['current']  = "profile";
        
        if ($this->input->post()) {
            $this->form_validation->set_rules($this->rules_page);
            $this->form_validation->set_error_delimiters('<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> ', '<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
            if ($this->form_validation->run() != FALSE) {
                $dataUpdate = array(
                    "title" => $this->input->post('page_title'),
                    "content" => $this->input->post('page_content'),
                    "template" => $this->input->post('page_template'),
                    "parent_id" => $this->input->post('page_parent')
                );
                $this->Post_model->update($dataUpdate, array(
                    'id' => $id
                ));
                $this->session->set_flashdata('message', '<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> Your page have been saved successfully.<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
                redirect('admin/editPage/' . $id);
            }
        }
        
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/pages/edit', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function delPage($id)
    {
        if (isset($id) && !empty($id)) {
            $page = $this->Post_model->get_by_id($id);
            if ($this->Post_model->del($id)) {
                $this->Post_model->update(array(
                    'parent_id' => 0
                ), array(
                    'parent_id' => $page['id']
                ));
            }
            $this->session->set_flashdata('message', 'Del message.');
            
            redirect('admin/pages');
        }
    }
    
    /*-------------------------------
    -------------6. MENU------------
    ---------------------------------*/
    public function menu($id = null)
    {
        
        $this->load->model('Menu_model');
        $data['title'] = 'Photos';
        $menu_group    = $this->Menu_model->getMenuGroup();
        if (!isset($id) || $id == null) {
            $id = @$menu_group[0]['id'];
        }
        $data['menu_group'] = $menu_group;
        $data['id']         = $id;
        $data['current']    = "menu";
        $list_menu          = $this->Menu_model->get_list_menu_group($id);
        $data['menu']       = $this->Menu_model->build_menu_admin(0, $list_menu, "easymm");
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/menu/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function test()
    {
        if ($this->input->post('easymm') != null) {
            $result = $this->position($this->input->post('easymm'), 0);
            print_r($result);
        }
        die();
    }
    
    function update_menu()
    {
        if ($this->input->post('easymm') != null) {
            $this->position($this->input->post('easymm'), 0);
            die('true');
        }
        die('false');
    }
    
    function delete_menu_item($id = null)
    {
        $this->load->model('Menu_model');
        if (isset($id) && $id != null) {
            $this->Menu_model->deleteMenuItem($id);
            die('true');
        }
        die('false');
    }
    
    function update_item_menu($id = null)
    {
        $this->load->model('Menu_model');
        if (isset($id) && $id != null) {
            $data = array(
                'title' => $this->input->post('title'),
                'slug' => $this->create_slug($this->input->post('title')),
                'url' => $this->input->post('url'),
                'class' => $this->input->post('class')
            );
            $this->Menu_model->updateMenuItem($id, $data);
            die('true');
        }
        die('false');
    }
    
    function add_menu_group()
    {
        $data = array(
            'name' => $this->input->post('name')
        );
        $this->load->model('Menu_model');
        $id = $this->Menu_model->addMenuGroup($data);
        die('' . $id);
    }
    
    function add_item_menu()
    {
        $this->load->model('Menu_model');
        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $this->create_slug($this->input->post('title')),
            'url' => $this->input->post('url'),
            'class' => $this->input->post('class'),
            'group_id' => $this->input->post('group_id'),
            'code_lang' => 'es',
            'created_date' => date("Y-m-d H:i:s")
        );
        $id   = $this->Menu_model->addMenuItem($data);
        if (isset($id) && $id != null && $id > 0) {
            die("" . $id);
        }
        die('0');
    }
    
    function get_item_menu($id = null)
    {
        $this->load->model('Menu_model');
        $result = array();
        if (isset($id) && $id != null) {
            $result = $this->Menu_model->getItemMenu($id);
            
        }
        die(json_encode($result));
    }
    
    function position($data, $parent)
    {
        $this->load->model('Menu_model');
        foreach ($data as $item => $value) {
            //update position menu item
            $this->Menu_model->updateMenuItem($value['id'], array(
                "pid" => $parent,
                "sort_id" => $item
            ));
            if (isset($value['children']) && $value['children'] != null) {
                $this->position($value['children'], $value['id']);
            }
        }
    }
    
    function create_slug($string)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }
    
    public function hiddenStatusmember($meber_id)
    {
        $this->Members_model->update_status($meber_id);
        header("location:/admin/profiles");
    }
    
    /*7.CAMPAIGN*/
    public function campaign()
    {
        $this->load->model('Members_model');
        $data['current']        = "campaign";
        $data['table_campaign'] = $this->Members_model->get_campaign();
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/campaign/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function delete_campaign($id = null)
    {
        if (isset($id) && $id != null && is_numeric($id)) {
            $this->load->model('Members_model');
            $this->Members_model->delete_campaign($id);
        }
        redirect('/admin/campaign/');
    }
    
    public function add_campaign()
    {
        $this->load->model('Packages_model');
        $this->load->model('Members_model');
        $data['current'] = "campaign";
        if ($this->input->post()) {
            $arr = array(
                'title' => $this->input->post('title'),
                'summary' => $this->input->post('summary'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'package_id' => $this->input->post('package_id'),
                'num_days' => $this->input->post('num_days')
            );
            
            $id = $this->Members_model->add_campaign($arr);
            if (isset($id) && $id > 0) {
                $this->session->set_flashdata('message', 'Your information have been saved successfully.');
                redirect('/admin/edit_campaign/' . $id);
            } else {
                redirect('/admin/campaign/');
            }
        }
        $data['package'] = $this->Packages_model->get_all_table_packages();
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/campaign/add', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function offer($type = null, $id = null)
    {
        
        $data = array();
        $this->load->model('Offer_model');
        $this->load->view('backend/includes/header');
        if (($type == "" || $type == null) || ($type != "add_new" && $type != "edit" && $type != "delete")) {
            $data["table_offer"] = $this->Offer_model->get_all();
            $this->load->view('backend/offer/index', $data);
        } else {
            if ($type == "add_new") {
                if ($this->input->post()) {
                    $arr = array(
                        'title_offer' => $this->input->post('title'),
                        'start_date' => $this->input->post('start_date'),
                        'end_date' => $this->input->post('end_date'),
                        'item_offer' => $this->input->post("item_code"),
                        'num_day' => $this->input->post('num_days'),
                        'type' => $this->input->post('type')
                    );
                    
                    $data['post'] = $_POST;
                    $id           = $this->Offer_model->add($arr);
                }
                if ($id != null) {
                    $id_offer_code = $this->Offer_model->add_offer_code($id, $this->input->post("item_code"));
                    if ($id_offer_code != null) {
                        redirect('/admin/offer/');
                    }
                    
                }
                $this->load->view('backend/offer/add', $data);
            }
            if ($type == "edit" && $id != null) {
                if ($this->input->post()) {
                    $arr          = array(
                        'title_offer' => $this->input->post('title_offer'),
                        'start_date' => $this->input->post('start_date'),
                        'end_date' => $this->input->post('end_date'),
                        'item_offer' => $this->input->post("item_offer"),
                        'num_day' => $this->input->post('num_day'),
                        'type' => $this->input->post('type')
                    );
                    $data['post'] = $_POST;
                    $id           = $this->Offer_model->update($id, $arr, $this->input->post("item_offer"));
                } else {
                    $data['post'] = $this->Offer_model->get_all_byid($id);
                    foreach ($data['post'] as $value) {
                        $data['post'] = $value;
                    }
                }
                $this->load->view('backend/offer/edit', $data);
            }
            if ($type == "delete" && $id != null) {
                $this->Offer_model->delete_offer($id);
                redirect('/admin/offer/');
            }
        }
        $this->load->view('backend/includes/footer');
        
    }
    
    public function offer_view_code($id = null)
    {
        $data = array();
        
        $this->load->view('backend/includes/header');
        $this->load->model("Offer_model");
        $data['offer'] = $id;
        if ($id != null) {
            if($this->input->post()){
                $data["id_insert"] = 0;
                $data["message"]   = "";
                $code = $this->input->post("new_code");
                $offer = $this->input->post("id_offer");
                $recoder = $this->Offer_model->checkrecod_code($code,$offer);
                $number = count($recoder);
                if($number==0){
                   $add_code  = $this->Offer_model->add_code($code,$offer);
                   $data["id_insert"] = $add_code;
                   $data["message"]   ="Add New Offer Code Status.";
                }else{
                   $data["id_insert"]  = 0;
                   $data["message"] ="Offer Code Duplication.";
                }
            }
            $data['table_offer'] = $this->Offer_model->get_all_offercode_byid($id);
            $this->load->view('backend/offer/view', $data);
        }
        $this->load->view('backend/includes/footer');
    }
    
    public function offer_view_code_delete($offer, $id)
    {
        $this->load->model("Offer_model");
        $delete = $this->Offer_model->delete_offer_code($id, $offer);
        redirect('/admin/offer_view_code/' . $offer);
        
    }
    
    public function edit_campaign($id = null)
    {
        $this->load->model('Packages_model');
        $this->load->model('Members_model');
        $data['current'] = "campaign";
        if (isset($id) && $id != null && is_numeric($id)) {
            if ($this->input->post()) {
                $arr = array(
                    'title' => $this->input->post('title'),
                    'summary' => $this->input->post('summary'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'package_id' => $this->input->post('package_id'),
                    'num_days' => $this->input->post('num_days')
                );
                $this->Members_model->update_campaign($id, $arr);
                $this->session->set_flashdata('message', 'Your information have been saved successfully.');
                redirect('/admin/edit_campaign/' . $id);
            }
            
            $data['package'] = $this->Packages_model->get_all_table_packages();
            $data['record']  = $this->Members_model->get_campaign_id($id);
            $this->load->view('backend/includes/header', $data);
            $this->load->view('backend/campaign/edit', $data);
            $this->load->view('backend/includes/footer', $data);
        } else {
            redirect('/admin/campaign/');
        }
    }
    
    /*-------------------------------------
    -------------8. CATEGORIES ------------
    ---------------------------------*/
    public function categories($business_type = "")
    {
    	$is_business = !isset($business_type) || empty($business_type) ? false : true;
        $this->load->model('Category_model');
        $data['title'] = 'Categories';
        $list_menu          = $this->Category_model->get_list_categories($is_business);
        $data['menu']       = $this->Category_model->build_menu_admin(0, $list_menu, "easymm");
        if ($is_business)
        	$data['business_type'] = 1;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/categories/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }
    
    public function add_item_category() 
    {
        $this->load->model('Category_model');
        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $this->create_slug($this->input->post('title')),
            'sort' => 0,
            'pid'  => 0,
            'enabled'  => 0,
            'type' => 'system'
        );
        $business_type = $this->input->post('business_type');
        $is_business = $business_type === FALSE || empty($business_type) ? false : true;
        
        $id   = $this->Category_model->add_item_category($data, $is_business);
        if (isset($id) && $id != null && $id > 0) {
            die(json_encode(array("id" => $id, "title" => $data["title"], "slug" => $data["slug"], "sort" => $data["sort"])));
        }
        die('0');
    }
    
    public function category_position($business_type="")
    {
        $is_business = $business_type === FALSE || empty($business_type) ? false : true;
        
        if ($this->input->post('easymm') != null) {
            $result = $this->update_category_position($this->input->post('easymm'), 0, $is_business);
            print_r($result);
        }
        die();
    }
    
    function update_category_position($data, $parent, $is_business=false)
    {
        $this->load->model('Category_model');
        foreach ($data as $item => $value) {
            //update position menu item
            $this->Category_model->update_item_category($value['id'], array("pid" => $parent,"sort" => $item), $is_business);
            if (isset($value['children']) && $value['children'] != null) {
                $this->update_category_position($value['children'], $value['id'], $is_business);
            }
        }
    }
    
    function delete_item_category($id = null)
    {
    	$business_type = $this->input->post('business_type');
        $is_business = $business_type === FALSE || empty($business_type) ? false : true;
        
        $this->load->model('Category_model');
        if (isset($id) && is_numeric($id)) {
            $this->Category_model->delete_item_category($id, $is_business);
            die('true');
        }
        die('false');
    }
    
    function update_item_category($id = null)
    {
    	$business_type = $this->input->post('business_type');
        $is_business = $business_type === FALSE || empty($business_type) ? false : true;
    	
        $this->load->model('Category_model');
        if (isset($id) && $id != null) {
            $data = array(
                'title' => $this->input->post('title'),
                'slug' => $this->create_slug($this->input->post('title')),
            );
            $this->Category_model->update_item_category($id, $data, $is_business);
            die('true');
        }
        die('false');
    }
    
    function get_item_category($id = null)
    {
    	$business_type = $this->input->post('business_type');
        $is_business = $business_type === FALSE || empty($business_type) ? false : true;
    	
        $this->load->model('Category_model');
        $result = array();
        if (isset($id) && $id != null) {
            $result = $this->Category_model->get_item_category($id, $is_business);
        }
        die(json_encode($result));
    }
    
    
    
} //end controller