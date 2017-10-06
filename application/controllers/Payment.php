<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends CI_Controller {

    private $user_id = null;
    private $user_info = null;
    private $is_login = false;
    private $data = null;

    public function __construct() {
        parent::__construct();
        // Check login
        $this->load->helper('url');
        if ($this->session->userdata('user_info')) {
            $this->is_login = true;
            $this->data['is_login'] = true;
            $this->user_info = $this->session->userdata('user_info');
            $this->user_id = $this->user_info["id"];
        } 
        $this->base_url = base_url();
    }

    public function upgrade() {
        //redirect('/payment/plan/13'); // Test

        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data['package'] = $this->Common_model->get_result('packages', array(
            'type' => 0
        ));
        $this->session->unset_userdata('info_credit');
        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Upgrade";
        $this->data['skins'] = 'upgrade';
        $this->load->view('block/header', $this->data);
        $this->load->view('payment/upgrade-main', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function plan($id = null) {
        $this->check_login(base_url ("?action=signin&url=".base_url(uri_string())));
        if ($id == null || !is_numeric($id)) {
            redirect('/payment/upgrade');
        }

        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("members", array(
            'id' => $user_id
        ));
        $this->data['package'] = $this->Common_model->get_result('packages', array(
            'type' => 0, 'id' => $id
        ));
        if ($this->data['package'] == null || count($this->data['package']) <= 0) {
            redirect('/payment/upgrade');
        }

        $this->data["is_login"] = $this->is_login;
        $this->data["title_page"] = "Upgrade";
        $this->data['skins'] = 'upgrade';
        $this->load->view('block/header', $this->data);
        $this->load->view('payment/upgrade', $this->data);
        $this->load->view('block/footer', $this->data);
    }

    public function cancel() {
        $this->check_login(base_url ("?action=signin&url=".base_url(uri_string())));
        $this->load->view('payment/cancel', array());
    }

    public function complete() {
        $this->check_login(base_url ("?action=signin&url=".base_url(uri_string())));
        $this->load->view('payment/finish', array());
    }

    public function finish() {
        $this->check_login(base_url ("?action=signin&url=".base_url(uri_string())));
        $id = 13; // package 1 month
        $arr = array(
            'upgrade_date_start' => date('Y-m-d'),
            'upgrade_date_end' => date('Y-m-d', strtotime('+1 month'))
        );
        $record = $this->Common_model->get_record('member_upgrade', array(
            'member_id' => $this->user_id
        ));
        if (isset($record) && count($record) > 0) {
            $this->Common_model->update('member_upgrade', $arr, array(
                'member_id' => $this->user_id
            ));
        } else {
            $arr['member_id'] = $this->user_id;
            $this->Common_model->add('member_upgrade', $arr);
        }
        //update database
        $order_slug = substr(md5($this->getGuid()), 0, 19);
        $id_insert_ht = $this->Common_model->add('history', array(
            'order' => $order_slug,
            'member_id' => $this->user_id,
            'packages_id' => $id,
            'date_create' => date('Y-m-d H:i:s')
        ));
        if ($id_insert_ht) {
            $id_member_update = $this->user_id;
            $this->Common_model->update("members", array("type_member" => 1), array("id" => $id_member_update));
            $this->session->unset_userdata('user_info');
            $this->session->unset_userdata('type_member');
            $record_user = $this->Common_model->get_record("members", array("id" => $id_member_update));
            $record_company = $this->Common_model->get_record("company", array("member_id" => $id_member_update));
            $new_session = array(
                'email' => $record_user["email"],
                'id' => $record_user["id"],
                'full_name' => @$record_user["first_name"] . ' ' . @$record_user["last_name"],
                'company_name' => @$record_company["company_name"],
                'business_type' => @$record_company["business_type"],
                'type_member' => @$record_user["type_member"],
                'avatar' => @$record_user["avatar"]
            );
            $this->session->set_userdata('type_member',$record_user["type_member"]);
            $this->session->set_userdata('user_info', $new_session);
        }
        $this->load->view('payment/finish', array());
    }

    private function getGuid() {
        list($micro_time, $time) = explode(' ', microtime());
        $id = round((rand(0, 217677) + $micro_time) * 10000);
        $id = base_convert($id, 10, 36);
        return $id;
    }

    public function check_promo_code() {

        if ($this->input->is_ajax_request()) {
            $data["success"] = "error";
            $code = $this->input->post("promo_code");
            $datime = date("Y-m-d");
            $filter = array(
                "code" => $code,
                "start_date <=" => $datime,
                "end_date   >=" => $datime,
                "number_uses >" => 0
            );
            $record = $this->Common_model->get_record("offer", $filter);
            $filter = array(
                "offer_id" => $record["id"],
                "member_id" => $this->user_id
            );
            $uses_offer = $this->Common_model->get_record("uses_offer", $filter);
            if (count($record) > 0 && count($uses_offer) == 0) {
                $data["success"] = "success";
                $data["message"] = "Promo code is correct.";
                $data["offer_code"] = $record["code"];
                $data["offer_summary"] = $record["summary"];
                $data["type_offer"] = $record["type_offer"];
            } else {
                if (count($record) == 0) {
                    $data["message"] = "Promo code is incorrect.";
                }
                if (count($uses_offer) > 0) {
                    $data["message"] = "Promo code has been used.";
                }
            }

            die(json_encode($data));
        }else{
             $this->check_login(base_url ("?action=signin&url=".base_url(uri_string())));
        }
    }
    private function check_login($url = ""){
        if(!$this->session->userdata('user_info')){
            redirect($url);
        }
    }

}

/* End of file payment.php */
/* Location: ./application/controllers/payment.php */