<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
          // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one you want to allow, and if so:
          header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
          header('Access-Control-Allow-Credentials: true');
          header('Access-Control-Max-Age: 86400');    // cache for 1 day
      }
      
      // Access-Control headers are received during OPTIONS requests
      if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
          if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
              header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
      
          if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
              header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
      
          exit(0);
      }

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('admin_panel_model');
        $this->load->model('login_model');
    }

    public function login(){
        $postData = file_get_contents("php://input");
        $data = json_decode($postData, true);   
        $user_details = $this->login_model->check_user($data);
        $status;
        if(isset($user_details) && !empty($user_details)){
            $this->session->set_userdata('user_id', $data['shibir_id']);
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
