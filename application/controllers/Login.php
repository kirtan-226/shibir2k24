<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_panel_model');
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('admin_panel_model');
        
        $this->session = $this->session;
    }

    public function login() {
        // Make sure no output is sent before this point
        $postData = file_get_contents("php://input");
        $data = json_decode($postData, true);   
        $user_details = $this->login_model->check_user($data);
        $response = array();

        if (isset($user_details) && !empty($user_details)) {
            $response['status'] = true;
            // $response['data'] = array();
            
            $user = $this->user_model->get_by_id($data);
            $name = $this->user_model->get_yuvak_name($data);
            $firstname = $this->user_model->get_yuvak_first_name($data);
            $last_name = $this->user_model->get_yuvak_last_name($data);
            // var_dump($user['role']);die;
            $response['status'] = 'true';
            $shibir_id['shibir_id'] = $user['bus_leader_1'] ?? '';
            $bus_leader_1 = $this->user_model->get_yuvak_name($shibir_id);
            $bus_leader_1_no = $this->user_model->get_phone_number($shibir_id);
            $shibir_id['shibir_id'] = $user['bus_leader_2'] ?? '';
            $bus_leader_2 = $this->user_model->get_yuvak_name($shibir_id);
            $bus_leader_2_no = $this->user_model->get_phone_number($shibir_id);
            $role = $this->admin_panel_model->get_role($user['role']);
            
            $user['name'] = $name['name'] ?? '';
            $user['role'] = $role['role'] ?? '';
            $user['firstname'] = $firstname['firstname'] ?? '';
            $user['lastname'] = $last_name['lastname'] ?? '';
            $user['bus_leader_1'] = $bus_leader_1['name'] ?? '';
            $user['bus_leader_2'] = $bus_leader_2['name'] ?? '';
            $user['bus_leader_1_no'] = $bus_leader_1_no['phone_number'] ?? '';
            $user['bus_leader_2_no'] = $bus_leader_2_no['phone_number'] ?? '';
            $api = $this->user_model->get_qr($data);
            $user['qr_code'] = $api['api'];
            $response['user'] = $user ?? '';
            
            $this->session->set_userdata('user_id', $data['shibir_id']);
            $response['user']['permission'] = $this->admin_panel_model->get_permission($data['shibir_id']);
                if(($user['bus_leader_1'] == $user['name']) || ($user['bus_leader_2'] == $user['name']))
                {
                    $response['user']['permission']['view_bus_details'] = 'yes'; 
                }
                else{
                    $response['user']['permission']['view_bus_details'] = 'no'; 
                }
                $resgitrar = $this->user_model->check_registrar($data);
                if($resgitrar == true)
                {
                    $response['user']['permission']['edit_mandal_attendance'] = 'yes'; 
                }
                else{
                    $response['user']['permission']['edit_mandal_attendance'] = 'no'; 
                }
        
            $response['message'] = 'Login successful';
        }

        else {
            $response['status'] = false;
            $response['message'] = 'Login failed';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function reset() {
        // Make sure no output is sent before this point

        $postData = file_get_contents("php://input");
        $data = json_decode($postData, true);
        // $x = $this->session->userdata('user_id') ?? '';
        // if($x != ''){
        //     // $data['shibir_id'] = $this->session->userdata('user_id');
        // }
        $response = array();

        if(isset($data) && !empty($data)){
            $data['is_password_changed'] = 'yes';
            $user = $this->login_model->reset_password($data);
            if(isset($user) && !empty($user)){
                $response['status'] = true;
                $response['message'] = 'Password reset successful';
            }
            else{
                $response['status'] = false;
                $response['message'] = 'Password reset failed';
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = 'Invalid request';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function forgot_password() {
        // Make sure no output is sent before this point

        $postData = file_get_contents("php://input");
        $data = json_decode($postData, true);
        // $x = $this->session->userdata('user_id') ?? '';
        // if($x != ''){
        //     // $data['shibir_id'] = $this->session->userdata('user_id');
        // }
        $response = array();

        if(isset($data) && !empty($data)){
            $data['is_password_changed'] = 'yes';
            $user = $this->login_model->forgot_password($data);
            // var_dump($user);die;
            if(isset($user) && !empty($user) && ($user!=3) && ($user!=2)){
                $response['status'] = true;
                $response['message'] = 'Password reset successful';
            }
            else if($user == 3){
                $response['status'] = false;
                $response['message'] = 'Try another password';
            }
            else if($user == 2){
                $response['status'] = false;
                $response['message'] = 'Phone Number or Shibir ID is wrong ';
            }
            else{
                $response['status'] = false;
                $response['message'] = 'Password reset failed';
            }
        }
        else{
            $response['status'] = false;
            $response['message'] = 'Invalid request';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

}
