<?php

/*
  1. LOGIN
  2. PROFILES
  3. PHOTOS
  4. PAGES
  5. PACKAGES
  5. PACKAGES DEZIGNWALL
  6. MENU
  7. CAMPAIGN
  8. CATEGORIES
 */

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array(
            'form',
            'url'
        ));
        $this->load->model('Members_model');
        $this->load->model('Members_model');
        $this->load->model('Post_model');
        $this->load->model('Packages_model');
        $this->load->model('Category_model');
        $this->load->library(array(
            'pagination',
            'form_validation',
            "session"
        ));
    }

    private $modules = array(
        'profile',
        'menu',
        'photo',
        'package',
        'packagedez',
        'campaign',
        'offer',
        'categories'
    );
    private $rules_login = array(
        array(
            'field' => 'user',
            'label' => 'user',
            'rules' => 'valid_email|trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'password',
            'rules' => 'trim|required'
        )
    );
    private $rules_profile_edit = array(
        array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'company_name',
            'label' => 'Company Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password_new',
            'label' => 'New Password',
            'rules' => 'min_length[6]'
        ),
        array(
            'field' => 'password_new_repeat',
            'label' => 'Repeat New Password',
            'rules' => 'matches[password_new]|min_length[6]'
        )
    );
    private $rules_profile_add = array(
        array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'company_name',
            'label' => 'Company Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[6]'
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'matches[password]|min_length[6]'
        )
    );
    private $rules_page = array(
        array(
            'field' => 'page_title',
            'label' => 'Title',
            'rules' => 'trim|required'
        )
    );
    private $rules_photo_edit = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'type',
            'label' => 'Type',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'product_name',
            'label' => 'Product name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'product_no',
            'label' => 'Product no',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'price',
            'label' => 'Price',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'product_note',
            'label' => 'Product note',
            'rules' => 'trim|required'
        )
    );

    public function index() {
        redirect('/admin/dashboard');
    }

    function getGuid() {
        // using micro time as the last 4 digits in base 10 to prevent collision with another request
        list($micro_time, $time) = explode(' ', microtime());
        $id = round((rand(0, 217677) + $micro_time) * 10000);
        $id = base_convert($id, 10, 36);
        return $id;
    }

    public function recursive($parentid = 0, $data = Null, $step = '') {
        if (isset($data) && is_array($data)) {
            foreach ($data as $key => $val) {
                if ($val['parent_id'] == $parentid) {
                    $val['depth'] = $step;
                    $this->recursive[$val['id']] = $val;
                    $this->recursive($val['id'], $data, $step . '-- ');
                }
            }
        }

        return $this->recursive;
    }

    function check_permission($modules = '', $action = Null) { //0=view 1=add 2=edit 3=delete
        $member_current = $this->Members_model->getById($this->session->userdata('user_id'));
        $role_args = json_decode($member_current['role'], true);
        $access = false;
        foreach ($role_args['rules'] as $key => $rule) {
            if ($rule['name'] == $modules && $rule['do'][$action] == 1)
                $access = true;
        }

        return $access;
    }

    function get_permission($modules = '', $action = Null) { //0=view 1=add 2=edit 3=delete
        /* if ($this->check_permission($modules, $action)==false){
          $this->session->set_flashdata('message', '<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> Access Denied<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
          redirect('/admin');
          } */
    }

    /* -------------------------------
      -------------1. LOGIN------------
      --------------------------------- */

    function is_login($modules = '', $action = Null) {
        if ($this->session->userdata('logged_in') == false) {
            redirect('/admin/login');
        }
    }

    public function login() {
        if ($this->session->userdata('logged_in') == FALSE) {
            $data['title'] = 'Login';
            $data['error'] = FALSE;
            $this->form_validation->set_rules($this->rules_login);
            $this->form_validation->set_error_delimiters('<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>', '<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
            if ($this->input->post()) {
                if ($this->form_validation->run() != FALSE) {
                    $user_mail = $this->input->post('user');
                    $password = md5($this->input->post('password'));
                    $result = $this->Members_model->get_admin_login($user_mail, $password);
                    if (count($result) == 1) {
                        $role_args = json_decode($result->role, true);
                        $dataArr = array(
                            'logged_in' => TRUE,
                            'user_id' => $result->id,
                            'name' => $result->first_name,
                            'role' => $role_args['name'],
                            'rules' => $role_args['rules'],
                            'user_email' => $result->email
                        );
                        $this->session->set_userdata($dataArr);
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

    function logout() {
        $this->session->sess_destroy();
        redirect('admin/login');
    }

    public function dashboard() {
        $this->is_login();
        $data['title'] = 'Admin Panel';
        $data['current'] = "admin";
        $data['profiles'] = $this->Members_model->getAllAdmins();
        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    /* -------------------------------
      -------------2. PROFILES------------
      --------------------------------- */

    public function profiles() {
        $this->is_login();
        $this->get_permission('profile', 0);
        $data['title'] = 'Admin Panel';
        $data['current'] = "profile";
        $data['profiles'] = $this->Members_model->getAllNormalMembers();
        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/profile/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function delProfile($id) {
        $this->is_login();
        $this->get_permission('profile', 3);
        if (isset($id) && !empty($id)) {
            $this->Members_model->del($id);
            $this->session->set_flashdata('message', '<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> Successfully.<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
            redirect('admin');
        }
    }

    public function editProfile($id) {
        $this->is_login();
        $this->get_permission('profile', 2);
        $data['title'] = 'Edit Profile';
        $data['profile'] = $this->Members_model->getById($id);
        $data['current'] = "profile";
        if ($this->input->post()) {
            $this->form_validation->set_rules($this->rules_profile_edit);
            $this->form_validation->set_error_delimiters('<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> ', '<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
            if ($this->form_validation->run() != FALSE) {
                $dataUpdate = array(
                    "company_name" => $this->input->post('company_name'),
                    "last_name" => $this->input->post('last_name'),
                    "first_name" => $this->input->post('first_name'),
                    "email" => $this->input->post('email'),
                );
                $pwd_new = @$this->input->post('password_new');
                if (!empty($pwd_new)) {
                    $dataUpdate['pwd'] = md5(strtolower($this->input->post('email')) . ":" . md5($pwd_new));
                }

                if ($this->input->post('role') != 'default') {
                    $rules_args = array();
                    for ($i = 0; $i < count($this->modules); $i++) {
                        $rule_detail = array();
                        for ($j = 0; $j < 4; $j++) {
                            $value = ($this->input->post($this->modules[$i] . '_' . $j) == NULL) ? 0 : 1;
                            array_push($rule_detail, $value);
                        }

                        array_push($rules_args, array(
                            'name' => $this->modules[$i],
                            'do' => $rule_detail
                        ));
                    }

                    $role_args = array(
                        'name' => $this->input->post('role'),
                        'rules' => $rules_args
                    );
                    $dataUpdate['role'] = json_encode($role_args);
                }

                $filter = array(
                    "id" => $id
                );
                $this->Common_model->update("members", $dataUpdate, $filter);
                $this->session->set_flashdata('message', '<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> Your information have been saved successfully.<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
                redirect('admin/editProfile/' . $id);
            }
        }

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/profile/edit', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function addProfile() {
        $this->is_login();
        $this->get_permission('profile', 1);
        $data['title'] = 'Add Profile';
        $data['current'] = "profile";
        if ($this->input->post()) {
            $this->form_validation->set_rules($this->rules_profile_add);
            $this->form_validation->set_error_delimiters('<div class="alert bg-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> ', '<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>');
            if ($this->form_validation->run() != FALSE) {
                $dataAdd = array(
                    "last_name" => $this->input->post('last_name'),
                    "first_name" => $this->input->post('first_name'),
                    "email" => $this->input->post('email'),
                    "pwd" => md5(strtolower($this->input->post('email')) . ":" . md5($this->input->post('password'))),
                    "company_name" => $this->input->post('company_name'),
                    "slug_general" => $this->getGuid(),
                    "enable" => "1",
                );
                if ($this->input->post('role') != 'default') {
                    $rules_args = array();
                    for ($i = 0; $i < count($this->modules); $i++) {
                        $rule_detail = array();
                        for ($j = 0; $j < 4; $j++) {
                            $value = ($this->input->post($this->modules[$i] . '_' . $j) == NULL) ? 0 : 1;
                            array_push($rule_detail, $value);
                        }

                        array_push($rules_args, array(
                            'name' => $this->modules[$i],
                            'do' => $rule_detail
                        ));
                    }

                    $role_args = array(
                        'name' => $this->input->post('role'),
                        'rules' => $rules_args
                    );
                    $dataAdd['role'] = json_encode($role_args);
                }

                $insert_id = $this->Common_model->add("members", $dataAdd);
                $data_session = array(
                    'message' => '<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> Your information have been saved successfully.<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>',
                    'data' => $dataAdd
                );
                $this->session->set_flashdata('data_flash_session', $data_session);
                redirect('admin/editProfile/' . $insert_id);
            }
        }

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/profile/add', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    /* -------------------------------
      -------------3. PHOTOS------------
      --------------------------------- */

    public function photos() {
        $this->is_login();
        $this->get_permission('photo', 0);
        $this->load->model('Photo_model');
        $this->load->model('Common_model');
        $data['title'] = 'Photos';
        $data['current'] = "photo";
        $total_record = $this->Common_model->count_table('photos');

        $data["current_page"] = 0;
        $data["total_rows"] = $total_record;
        $config["base_url"] = base_url("/admin/photos/");
        $segment = 3;
        $config["total_rows"] = $total_record;
        $config["per_page"] = 20;
        $config["uri_segment"] = $segment;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $data["table_photo"] = $this->Common_model->get_result('photos', null, $page, 20);
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/photos/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function editphoto($photo_id) {
        $this->is_login();
        $this->get_permission('photo', 2);
        $this->load->model('Photo_model');
        $data['title'] = 'Edit Photo';
        $data['items_photo'] = $this->Photo_model->get_detail_photo($photo_id);
        $data['current'] = "photo";
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

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/photos/edit', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function delphoto($photo_id, $currentpage = null) {
        $this->is_login();
        $this->get_permission('photo', 3);
        if (isset($photo_id) && !empty($photo_id)) {
            $this->load->model('Common_model');
            $this->Common_model->delete('photos', array('photo_id' => $photo_id));
            if (is_numeric($currentpage)) {
                redirect('/admin/photos/' . $currentpage);
            } else {
                redirect('/admin/photos');
            }
        }
    }

    public function hiddenStatusphoto($photo_id) {
        $this->load->model('Photo_model');
        $this->Photo_model->update_status($photo_id);
        header("location:/admin/photos");
    }

    /* -------------------------------
      -------------4. PAGES------------
      --------------------------------- */

    public function pages() {
        $this->is_login();
        $this->get_permission('page', 0);
        $data['title'] = 'Pages';
        $data['current'] = "page";
        $data['pages'] = $this->recursive(0, $this->Post_model->get_all_by_type('page'), '');

        // $data['pages'] =$this->Post_model->get_all_by_type('page');

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/pages/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function addPage() {
        $this->is_login();
        $this->get_permission('page', 1);
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
                $dataAdd = array(
                    "title" => $this->input->post('page_title'),
                    "content" => $this->input->post('page_content'),
                    "template" => $this->input->post('page_template'),
                    "parent_id" => $this->input->post('page_parent'),
                    "type" => 'page'
                );
                $dataAdd['slug'] = $this->slug->create_uri($dataAdd);
                $insert_id = $this->Post_model->add($dataAdd);
                $data_session = array(
                    'message' => '<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> Your information have been saved successfully.<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>',
                    'data' => $dataAdd
                );
                $this->session->set_flashdata('data_flash_session', $data_session);

                // redirect('admin/editPage/'.$insert_id);
            }
        }

        $data['title'] = 'Add New Page';
        $data['current'] = "page";
        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/pages/addnew', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function editPage($id) {
        $this->is_login();
        $this->get_permission('page', 2);
        $data['title'] = 'Edit Page';
        $data['the_page'] = $this->Post_model->get_by_id($id);
        $data['pages'] = $this->recursive(0, $this->Post_model->get_all_by_type('page'), '');
        $data['current'] = "profile";
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

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/pages/edit', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function delPage($id) {
        $this->is_login();
        $this->get_permission('page', 3);
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

    /* -------------------------------
      -------------5. PACKAGES------------
      --------------------------------- */

    public function packages() {
        $this->is_login();
        $this->get_permission('package', 0);
        $data['title'] = 'Packages';
        $data['current'] = "packages";
        $data['result'] = $this->Packages_model->get_all_table_packages();
        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/packages/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function edit_packages($id = null) {
        $this->is_login();
        $this->get_permission('package', 2);
        $data['title'] = 'Edit Packages';
        $data['current'] = "packages";
        if (isset($id) && $id != null && is_numeric($id)) {
            $data['result'] = $this->Packages_model->get_detail_package($id);
            if ($this->input->post()) {
                $arr = array(
                    'name' => $this->input->post('title_packages'),
                    'summary' => $this->input->post('summary'),
                    'price' => $this->input->post('price'),
                    'max_files' => $this->input->post('max_file')
                );
                $this->Packages_model->update_packages($id, $arr);
                $this->session->set_flashdata('message', 'Your information have been saved successfully.');
                redirect('/admin/edit_packages/' . $id);
            }
        }

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/packages/edit', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function add_packages() {
        $this->is_login();
        $this->get_permission('package', 1);
        $data['title'] = 'Add Packages';
        $data['current'] = "packages";
        if ($this->input->post()) {
            $arr = array(
                'name' => $this->input->post('title_packages'),
                'summary' => $this->input->post('summary'),
                'price' => $this->input->post('price'),
                'enable' => '1',
                'annual' => '1',
                'max_files' => $this->input->post('max_file'),
                'type' => '0'
            );
            $id = $this->Packages_model->add_packages($arr);
            if (isset($id) && $id != null) {
                $this->session->set_flashdata('message', 'Your information have been saved successfully.');
                redirect('/admin/edit_packages/' . $id);
            } else {
                redirect('/admin/packages/');
            }
        }

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/packages/edit', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function del_packages($id = null) {
        $this->is_login();
        $this->get_permission('package', 3);
        if (isset($id) && $id != null && is_numeric($id)) {
            $this->Packages_model->delete_packages($id);
        }

        redirect('/admin/packages/');
    }

    /* -------------------------------
      -------------5.1. PACKAGES DEZIGNWALL------------
      --------------------------------- */

    public function packages_dezig() {
        $this->is_login();
        $this->get_permission('packagedez', 0);
        $data['title'] = 'Packages DEZIGNWALL';
        $data['current'] = "packages_dezig";
        $data['result'] = $this->Packages_model->get_all_table_packages(1);
        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/packages_dezign/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function edit_packages_dezig($id = null) {
        $this->is_login();
        $this->get_permission('packagedez', 2);
        $data['title'] = 'Edit Packages DEZIGNWALL';
        $data['current'] = "packages_dezig";
        if (isset($id) && $id != null && is_numeric($id)) {
            $data['result'] = $this->Packages_model->get_detail_package($id);
            if ($this->input->post()) {
                $arr = array(
                    'name' => $this->input->post('title_packages'),
                    'summary' => $this->input->post('summary'),
                    'price' => $this->input->post('price'),
                    'max_files' => $this->input->post('max_file')
                );
                $this->Packages_model->update_packages($id, $arr);
                $this->session->set_flashdata('message', 'Your information have been saved successfully.');
                redirect('/admin/edit_packages_dezig/' . $id);
            }
        }

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/packages_dezign/edit', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function add_packages_dezig() {
        $this->is_login();
        $this->get_permission('packagedez', 1);
        $data['title'] = 'Add Packages DEZIGNWALL';
        $data['current'] = "packages_dezig";
        if ($this->input->post()) {
            $arr = array(
                'name' => $this->input->post('title_packages'),
                'summary' => $this->input->post('summary'),
                'price' => $this->input->post('price'),
                'enable' => '1',
                'annual' => '1',
                'max_files' => $this->input->post('max_file'),
                'type' => '1'
            );
            $id = $this->Packages_model->add_packages($arr);
            if (isset($id) && $id != null) {
                $this->session->set_flashdata('message', 'Your information have been saved successfully.');
                redirect('/admin/edit_packages_dezig/' . $id);
            } else {
                redirect('/admin/packages_dezig/');
            }
        }

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/packages_dezign/edit', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function del_packages_dezig($id = null) {
        $this->is_login();
        $this->get_permission('packagedez', 3);
        if (isset($id) && $id != null && is_numeric($id)) {
            $this->Packages_model->delete_packages($id);
        }

        redirect('/admin/packages_dezig/');
    }

    /* -------------------------------
      -------------6. MENU------------
      --------------------------------- */

    public function menu($id = null) {
        $this->is_login();
        $this->get_permission('menu', 0);
        $this->load->model('Menu_model');
        $data['title'] = 'Photos';
        $menu_group = $this->Menu_model->getMenuGroup();
        if (!isset($id) || $id == null) {
            $id = @$menu_group[0]['id'];
        }

        $data['menu_group'] = $menu_group;
        $data['id'] = $id;
        $data['current'] = "menu";
        $list_menu = $this->Menu_model->get_list_menu_group($id);
        $data['menu'] = $this->Menu_model->build_menu_admin(0, $list_menu, "easymm");
        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $all_category = $this->Common_model->get_result("categories", array(
            "type" => "system"
        ));

        // die(print_r($all_category));

        $data["menu_category"] = $this->recursive_category_admin($all_category, 0);
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/menu/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function add_menu_of_category() {
        $this->is_login();
        if ($this->input->post('new_text')) {
            $new_text = $this->input->post('new_text');
            $id = $this->input->post('id');
            $data_return = array();
            $sort = $this->Common_model->get_sort($id, 0);
            $sort = $sort['sort_id'];
            foreach ($new_text as $key => $value) {
                $sort++;
                $new_category = array(
                    "pid" => 0,
                    "slug" => $value["slug"],
                    "title" => $value["title"],
                    "code_lang" => "en",
                    "url" => $value["url"],
                    "group_id" => $id,
                    'created_date' => date("Y-m-d H:i:s"),
                    'class' => '',
                    'sort_id' => $sort
                );
                $insert_id = $this->Common_model->add("menu", $new_category);
                $new_category["id_insert"] = $insert_id;
                $data_return[] = $new_category;
            }

            die(json_encode($data_return));
        }
    }

    public function test() {
        $this->is_login();
        if ($this->input->post('easymm') != null) {
            $result = $this->position($this->input->post('easymm'), 0);
            print_r($result);
        }

        die();
    }

    function update_menu() {
        $this->is_login();
        if ($this->input->post('easymm') != null) {
            $this->position($this->input->post('easymm'), 0);
            die('true');
        }

        die('false');
    }

    function delete_menu_item($id = null) {
        $this->is_login();
        $this->load->model('Menu_model');
        if ($this->check_permission('menu', 3) == true) {
            if (isset($id) && $id != null) {
                $this->Menu_model->deleteMenuItem($id);
                die('true');
            }

            die('false');
        } else
            die('denied');
    }

    function update_item_menu($id = null) {
        $this->is_login();
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

    function add_menu_group() {
        $this->is_login();
        $data = array(
            'name' => $this->input->post('name')
        );
        $this->load->model('Menu_model');
        $id = $this->Menu_model->addMenuGroup($data);
        die('' . $id);
    }

    function add_item_menu() {
        $this->is_login();
        $this->get_permission('menu', 1);
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
        $id = $this->Menu_model->addMenuItem($data);
        if (isset($id) && $id != null && $id > 0) {
            die("" . $id);
        }

        die('0');
    }

    function get_item_menu($id = null) {
        $this->is_login();
        $this->load->model('Menu_model');
        $result = array();
        if (isset($id) && $id != null) {
            $result = $this->Menu_model->getItemMenu($id);
        }

        die(json_encode($result));
    }

    function position($data, $parent) {
        $this->is_login();
        $this->load->model('Menu_model');
        foreach ($data as $item => $value) {

            // update position menu item

            $this->Menu_model->updateMenuItem($value['id'], array(
                "pid" => $parent,
                "sort_id" => $item
            ));
            if (isset($value['children']) && $value['children'] != null) {
                $this->position($value['children'], $value['id']);
            }
        }
    }

    function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }

    public function hiddenStatusmember($meber_id) {
        $this->Members_model->update_status($meber_id);
        header("location:/admin/profiles");
    }

    /* 7.CAMPAIGN */

    public function campaign() {
        $this->is_login();
        $this->get_permission('campaign', 0);
        $this->load->model('Members_model');
        $data['current'] = "campaign";
        $data['table_campaign'] = $this->Members_model->get_campaign();
        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/campaign/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function delete_campaign($id = null) {
        $this->is_login();
        $this->get_permission('campaign', 3);
        if (isset($id) && $id != null && is_numeric($id)) {
            $this->load->model('Members_model');
            $this->Members_model->delete_campaign($id);
        }

        redirect('/admin/campaign/');
    }

    public function add_campaign() {
        $this->is_login();
        $this->get_permission('campaign', 1);
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

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $data['package'] = $this->Packages_model->get_all_table_packages();
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/campaign/add', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function offer($type = null, $id = null) {
        $this->is_login();
        $this->get_permission('offer', 0);
        $data['current'] = "offer";
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $this->load->model('Offer_model');
        $this->load->view('backend/includes/header', $data);
        if (($type == "" || $type == null) || ($type != "add_new" && $type != "edit" && $type != "delete")) {
            $data["table_offer"] = $this->Offer_model->get_all();
            $this->load->view('backend/offer/index', $data);
        } else {
            if ($type == "add_new") {
                $this->get_permission('offer', 1);
                if ($this->input->post()) {
                    $arr = array(
                        'title_offer' => $this->input->post('title_offer'),
                        'code' => strtoupper($this->input->post('code')),
                        'number_uses' => $this->input->post('number_uses'),
                        'start_date' => $this->input->post('start_date'),
                        'end_date' => $this->input->post('end_date'),
                        'type' => $this->input->post('type')
                    );
                    $data['post'] = $_POST;
                    $id = $this->Offer_model->add($arr);
                }

                if ($id != null) {
                    redirect('/admin/offer/');
                }
                $get_result_p = $this->Common_model->get_result("packages", array("type" => "0"));
                $data["packages"] = $get_result_p;
                $this->load->view('backend/offer/add', $data);
            }

            if ($type == "edit" && $id != null) {
                $this->get_permission('offer', 2);
                if ($this->input->post()) {
                    $arr = array(
                        'title_offer' => $this->input->post('title_offer'),
                        'code' => $this->input->post('code'),
                        'number_uses' => $this->input->post('number_uses'),
                        'start_date' => $this->input->post('start_date'),
                        'end_date' => $this->input->post('end_date'),
                        'type' => $this->input->post('type')
                    );
                    $data['post'] = $_POST;
                    $id = $this->Offer_model->update($id, $arr, $this->input->post("item_offer"));
                } else {
                    $data['post'] = $this->Offer_model->get_all_byid($id);
                    foreach ($data['post'] as $value) {
                        $data['post'] = $value;
                    }
                }
                $get_result_p = $this->Common_model->get_result("packages", array("type" => "0"));
                $data["packages"] = $get_result_p;
                $this->load->view('backend/offer/edit', $data);
            }

            if ($type == "delete" && $id != null) {
                $this->get_permission('offer', 3);
                $this->Offer_model->delete_offer($id);
                redirect('/admin/offer/');
            }
        }

        $data['user_id'] = $this->session->userdata('user_id');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/footer');
    }

    public function offer_view_code($id = null) {
        $this->is_login();
        $this->get_permission('offer', 0);
        $data = array();
        $this->load->model("Offer_model");
        $data['offer'] = $id;
        if ($id != null) {
            if ($this->input->post()) {
                $data["id_insert"] = 1;
                $data["message"] = "";
                $code = $this->input->post("new_code");
                $offer = $this->input->post("id_offer");
                $recoder = $this->Offer_model->checkrecod_code($code, $offer);
                $number = count($recoder);
                if ($code != "") {
                    if ($number == 0) {
                        $add_code = $this->Offer_model->add_code($code, $offer);
                        $data["message"] = "Add New Offer Code Status.";
                    } else {
                        $data["message"] = "Offer Code Duplication.";
                    }
                } else {
                    $data["message"] = "Offer Code Is Not Empty.";
                }
            }

            $data['table_offer'] = $this->Offer_model->get_all_offercode_byid($id);
            $this->load->view('backend/offer/view', $data);
        }

        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/includes/footer');
    }

    public function offer_view_code_delete($offer, $id) {
        $this->is_login();
        $this->get_permission('offer', 3);
        $this->load->model("Offer_model");
        $delete = $this->Offer_model->delete_offer_code($id, $offer);
        redirect('/admin/offer_view_code/' . $offer);
    }

    function upday_code() {
        $this->is_login();
        $this->get_permission('offer', 2);
        $this->load->model("Offer_model");
        $new_code = $this->input->post('new_code');
        $id_offer = $this->input->post('id_offer');
        $id = $this->input->post('id');
        $this->Offer_model->upday_code($id, array(
            "code" => $new_code
        ));
        redirect('/admin/offer_view_code/' . $id_offer);
    }

    public function edit_campaign($id = null) {
        $this->is_login();
        $this->get_permission('campaign', 3);
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
            $data['record'] = $this->Members_model->get_campaign_id($id);
            $data['user_id'] = $this->session->userdata('user_id');
            $data['name'] = $this->session->userdata('user_email');
            $data['role'] = $this->session->userdata('role');
            $data['rules'] = $this->session->userdata('rules');
            $data['modules'] = $this->modules;
            $this->load->view('backend/includes/header', $data);
            $this->load->view('backend/campaign/edit', $data);
            $this->load->view('backend/includes/footer', $data);
        } else {
            redirect('/admin/campaign/');
        }
    }

    /* -------------------------------------
      -------------8. CATEGORIES ------------
      --------------------------------- */

    public function categories($business_type = "") {
        $this->is_login();
        $this->get_permission('categories', 0);
        $is_business = !isset($business_type) || empty($business_type) ? false : true;
        $this->load->model('Category_model');
        $data['title'] = 'Categories';
        $list_menu = $this->Category_model->get_list_categories($is_business);
        $data['menu'] = $this->Category_model->build_menu_admin(0, $list_menu, "easymm");
        if ($is_business)
            $data['business_type'] = 1;
        $data['user_id'] = $this->session->userdata('user_id');
        $data['name'] = $this->session->userdata('user_email');
        $data['role'] = $this->session->userdata('role');
        $data['rules'] = $this->session->userdata('rules');
        $data['modules'] = $this->modules;
        $this->load->view('backend/includes/header', $data);
        $this->load->view('backend/categories/index', $data);
        $this->load->view('backend/includes/footer', $data);
    }

    public function add_item_category() {
        $this->is_login();
        $this->load->model('Category_model');
        $data = array(
            'title' => $this->input->post('title'),
            'slug' => $this->slug("categories", "slug", $this->input->post('title')),
            'sort' => 0,
            'pid' => 0,
            'enabled' => 0,
            'type' => 'system'
        );
        $business_type = $this->input->post('business_type');
        $is_business = $business_type === FALSE || empty($business_type) ? false : true;
        $id = $this->Category_model->add_item_category($data, $is_business);
        if (isset($id) && $id != null && $id > 0) {
            die(json_encode(array(
                "id" => $id,
                "title" => $data["title"],
                "slug" => $data["slug"],
                "sort" => $data["sort"]
            )));
        }

        die('0');
    }

    private $data_category = array();

    public function category_position($business_type = "") {
        $this->is_login();
        $is_business = $business_type === FALSE || empty($business_type) ? false : true;
        if ($this->input->post('easymm') != null) {
            $this->data_category = $this->input->post('easymm');
            $result = $this->update_category_position($this->input->post('easymm'), 0, $is_business);
            print_r($result);
        }

        die();
    }

    function update_category_position($data, $parent, $is_business = false) {
        $this->load->model('Category_model');
        foreach ($data as $item => $value) {

            // update position menu item

            $parents_id = $this->get_parents_key($this->data_category, $value['id']);
            if (!is_numeric($parents_id)) {
                $parents_id = 0;
            }

            $this->Category_model->update_item_category($value['id'], array(
                "pid" => $parent,
                "parents_id" => $parents_id,
                "sort" => $item
                    ), $is_business);
            if (isset($value['children']) && $value['children'] != null) {
                $this->update_category_position($value['children'], $value['id'], $is_business);
            }
        }
    }

    function delete_item_category($id = null) {
        $business_type = $this->input->post('business_type');
        $is_business = $business_type === FALSE || empty($business_type) ? false : true;
        $this->load->model('Category_model');
        if (isset($id) && is_numeric($id)) {
            $this->Category_model->delete_item_category($id, $is_business);
            die('true');
        }

        die('false');
    }

    function update_item_category($id = null) {
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

    function get_item_category($id = null) {
        $business_type = $this->input->post('business_type');
        $is_business = $business_type === FALSE || empty($business_type) ? false : true;
        $this->load->model('Category_model');
        $result = array();
        if (isset($id) && $id != null) {
            $result = $this->Category_model->get_item_category($id, $is_business);
        }

        die(json_encode($result));
    }

    private function getargslud() {
        $categories = $this->Common_model->get_result("categories");
        $arg = [];
        foreach ($categories as $key => $value) {
            $where = ["id" => $value["id"]];
            $data = ["slug" => $this->slug("categories", "slug", $value["title"])];
            $this->Common_model->update("categories", $data, $where);
        }
    }

    public function tracking() {
        $this->db->select("reference_id");
        $this->db->from("common_tracking");
        $this->db->where("type_object", "photo");
        $arg = $this->db->get()->result_array();
        foreach ($arg as $key => $value) {
            $filter = array(
                "reference_id" => $value["reference_id"],
                "type_object" => "photo"
            );
            $number = $this->Common_model->count_table("common_comment", $filter);
            $data_update = array(
                "qty_comment" => $number
            );
            $this->Common_model->update("common_tracking", $data_update, $filter);
        }
    }

     function set_thumb() {
        $all_photo = $this->Common_model->get_result("photos");
        foreach ($all_photo as $value) {
            if(file_exists(FCPATH.$value["path_file"])){
                list($width,$height) = getimagesize(FCPATH.$value["path_file"]);
                if($width > 400){
                    $sell = 400/$width;
                    $new_w = 400;
                    $new_h  = $height * $sell;
                    $path_file_save = FCPATH."uploads/member/". $value["member_id"] ."/";
                    $n = resize_image_new(FCPATH.$value["path_file"],$new_w,$new_h,$path_file_save);
                    if($n["success"] == "success"){
                        $data_update = array("thumb" => "/uploads/member/" . $value["member_id"] ."/" .$n["reponse"]["name"] );
                        $where = array("photo_id" => $value["photo_id"]);
                        $this->Common_model->update("photos",$data_update,$where);
                        if(file_exists(FCPATH.$value["thumb"])){
                            unlink(FCPATH.$value["thumb"]); 
                        }
                        echo $value["photo_id"]."success !"; 
                    }else{
                        echo $value["photo_id"]." error !<br>";
                    }
                    
                }
            }
        }
    }

    private function get_parents_key($array, $current_id) {
        if (isset($array) && count($array) > 0) {
            for ($i = 0; $i < count($array); $i++) {
                if ($array[$i]['id'] == $current_id) {
                    return true;
                }
                if (isset($array[$i]['children']) && $this->get_parents_key($array[$i]['children'], $current_id)) {
                    return $array[$i]['id'];
                }
            }
        } else {
            return false;
        }
    }

    private $recursive_reponse = '';

    private function recursive_category_admin($arg, $parent) {
        if ($parent != 0) {
            $this->recursive_reponse.= "<ul class='nav nav-list tree'>";
        } else {
            $this->recursive_reponse.= "<ul class='nav'>";
        }

        foreach ($arg as $key => $value) {
            if ($value["pid"] == $parent) {
                $this->recursive_reponse.= "<li id ='" . $value["id"] . "'><label class='tree-toggler nav-header'><input type='checkbox' data-parent = '" . $parent . "' data-title = '" . $value["title"] . "' data-id ='" . $value["id"] . "' value='" . $value["slug"] . "'>" . $value["title"] . "</label>";
                $this->recursive_category_admin($arg, $value["id"]);
                $this->recursive_reponse.= "</li>";
                unset($arg[$key]);
            }
        }

        $this->recursive_reponse.= "</ul>";
        return $this->recursive_reponse;
    }

    private $key_slug = 0;

    private function gen_slug($str) {
        $a = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", " ");
        $b = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o ", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A ", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O ", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "-");
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), str_replace($a, $b, $str)));
    }

    private function check_slug($slug, $arg, $key_slug, $default) {
        if (in_array($slug, $arg) == true) {
            $this->key_slug++;
            $this->check_slug($default . "-" . $this->key_slug, $arg, $this->key_slug, $default);
        }
        return $this->key_slug;
    }

    private function slug($table, $colum, $name) {
        $slug = $this->gen_slug($name);
        $record = $this->Common_model->slug($table, "slug", $slug);
        $arg_slug = array();
        if (count($record) > 0) {
            foreach ($record as $key => $value) {
                $arg_slug[] = $value[$colum];
            }
            $key_slug = $this->check_slug($slug, $arg_slug, $this->key_slug, $slug);
            if ($key_slug != 0) {
                $slug = $slug . "-" . $key_slug;
            }
        }
        $this->key_slug = 0;
        return $slug;
    }
    public function update_last_comment(){
        $this->is_login();
        $sql = "SELECT pt.photo_id,cm.*,cm.id AS cmid,m.company_name,m.avatar,m.first_name,m.last_name,m.logo FROM `photos` AS pt 
        JOIN (SELECT * FROM common_comment WHERE type_object ='photo' ORDER BY created_at DESC) AS cm ON cm.reference_id = pt.photo_id 
        LEFT JOIN members AS m ON m.id = cm.member_id
        GROUP BY cm.reference_id ORDER BY cm.created_at DESC";
        $this->db->select("photo_id");
        $this->db->from("photos");
        $query = $this->db->query($sql);
        $record_photo = $query->result_array();
        foreach ($record_photo as $key => $value) {
            $insert_data = array(
                "id"           => $value["cmid"],
                "avatar"       => $value["avatar"],
                "member_id"    => $value["member_id"],
                "comment"      => $value["comment"],
                "created_at"   => $value["created_at"],
                "company_name" => $value["company_name"],
                "first_name"   => $value["first_name"],
                "last_name"    => $value["last_name"],
                "logo"         => $value["logo"]
            );
            $filter = array(
                "photo_id" => $value["photo_id"]
            );
            $data_update = array(
                "last_comment" => json_encode($insert_data)
            );
            $this->Common_model->update("photos", $data_update, $filter);
        }
        //$this->output->enable_profiler(TRUE);
    }
    public function update_catalog(){
        $this->is_login();
        $members = $this->Common_model->get_result("members");
        if($members != null){
            foreach ($members as $item) {
                $check_catelog = $this->Common_model->get_record("manufacturers",["member_id" => $item["id"]]);
                if($check_catelog == null){
                    //add catelog.
                    $file = FCPATH.'/uploads/manufacturers/Default-Catalog.png';
                    $urlfile = "/uploads/manufacturers/".uniqid().'-default-catalog.png';
                    echo $urlfile ."</br>";
                    $new_file = FCPATH.$urlfile;
                    if (copy($file, $new_file)) {
                        $catelog = array(
                            "name" => "Default catalog",
                            "logo" => $urlfile,
                            "member_id" => $item["id"],
                            "type" => "0"
                        );
                        $id_catelog = $this->Common_model->add("manufacturers",$catelog);
                        if($id_catelog){
                            $this->Common_model->update("photos",["manufacture" => $id_catelog],["member_id" => $item["id"] ,"type" => 2 ,"manufacture" => 0]);
                        }
                    }
                   
                }
            }
        }
    }
    public function update_keyword_set(){
        $this->is_login();
        $this->load->view('images/keyword');
    }
    public function update_keyword(){
        $this->is_login();
        $return = ["success" => "error"];
        $page = $this->input->post("page");
        $limit = 30000;
        $offset = $limit *  $page;
        $this->db->select("photo_id");
        $this->db->from("photos");
        $this->db->where("update_done","0");
        $this->db->limit($limit,$offset);
        $data =  $this->db->get()->result_array();
        if($data != null){
            foreach ($data as $key => $value) {
                $this->db->select("kw.title");
                $this->db->from("keywords AS kw");
                $this->db->join("photo_keyword AS pkw","pkw.keyword_id = kw.keyword_id AND pkw.photo_id = ".$value["photo_id"]." AND kw.type='photo'");
                $this->db->group_by("kw.title");
                $get_record_kw = $this->db->get()->result_array();
                $data_kw_new = [];
                if($get_record_kw != null){
                    foreach ($get_record_kw as $key => $value_1) {
                        $data_kw_new [] = $value_1["title"];
                    }
                }
                if($data_kw_new != null){
                    $data_kw_new = implode(",",$data_kw_new);   
                }else{
                    $data_kw_new = "";
                }
                $this->Common_model->update("photos",["keywords" => $data_kw_new,"update_done" => "1"],["photo_id" => $value["photo_id"]]);
            }
            $return = ["success" => "success", "data-post" => @$_POST];
        }
        die(json_encode($return));
    }
    public function update_category_set (){
        $this->is_login();
        $this->load->view('images/update_category');
    }
    public function update_category (){
        $this->is_login();
        $return = ["success" => "error"];
        $page = $this->input->post("page");
        $limit = 5000;
        $offset = $limit *  $page;
        $this->db->select("photo_id");
        $this->db->from("photos");
        $this->db->where("update_category_done","0");
        $this->db->limit($limit,$offset);
        $data =  $this->db->get()->result_array();
        if($data != null){
            foreach ($data as $key => $value) {
                $this->db->select("kw.category_id");
                $this->db->from("photo_category AS kw");
                $this->db->group_by("kw.category_id");
                $this->db->where("photo_id",$value["photo_id"]);
                $get_record_kw = $this->db->get()->result_array();
                $data_kw_new = [];
                if($get_record_kw != null){
                    foreach ($get_record_kw as $key => $value_1) {
                        $data_kw_new [] = $value_1["category_id"];
                    }
                }
                if($data_kw_new != null){
                    $data_kw_new = implode("/",$data_kw_new);   
                    $data_kw_new="/".$data_kw_new."/";
                }else{
                    $data_kw_new = "";
                }
                $this->Common_model->update("photos",["category" => $data_kw_new,"update_category_done" => "1"],["photo_id" => $value["photo_id"]]);
            }
            $return = ["success" => "success", "data-post" => @$_POST];
        }
       die(json_encode($return));
    }
}

//end controller