<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: false');
    header('Access-Control-Max-Age: 3600');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }

    exit(0);
}
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_panel_model');
        $this->load->model('login_model');
        $this->session = $this->session;
    }

    public function login() {
        // Make sure no output is sent before this point
        $postData = file_get_contents("php://input");
        $data = json_decode($postData, true);   
        $user_details = $this->login_model->check_user($data);
        $response = array();

        if(isset($user_details) && !empty($user_details)) {
            $this->session->set_userdata('user_id', $data['shibir_id']);
            $response['status'] = true;
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
        $x = $this->session->userdata('user_id') ?? '';
        if($x != ''){
            $data['shibir_id'] = $this->session->userdata('user_id');
        }
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
        $x = $this->session->userdata('user_id') ?? '';
        if($x != ''){
            $data['shibir_id'] = $this->session->userdata('user_id');
        }
        $response = array();

        if(isset($data) && !empty($data)){
            $data['is_password_changed'] = 'yes';
            $user = $this->login_model->forgot_pasword($data);
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

}
