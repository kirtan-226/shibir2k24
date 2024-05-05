<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('admin_panel_model');
        $this->load->model('login_model');
    }

    public function import_question(){
        $postData = file_get_contents("php://input");
        $data = json_decode($postData, true);   
        $user_details = $this->login_model->check_user($data);
        $status;
        if(isset($user_details) && !empty($user_details)){
            // $this->session->set_userdata('user_id', $data['shibir_id']);
            return true;
        }
        else{
            return false;
        }
    }
        

    public function reset(){
        $postData = file_get_contents("php://input");
        $data = json_decode($postData, true);
        if(isset($data) && !empty($data)){
            $data['is_password_changed'] = 'yes';
            $user = $this->login_model->reset_password($post_data);
            if(isset($user) && !empty($user)){
                    return true;
            }
            else{
                    return false;
            }
        }
    }
}
