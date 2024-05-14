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

class Announcement extends CI_Controller {

          public function __construct(){
                    parent::__construct();
                    $this->load->model('admin_panel_model');
                    $this->load->model('Announcement_model');
          }

          public function add_edit($data){
                    $postData = file_get_contents("php://input");
                    $yuvak_id = $this->session->userdata('user_id');
                    $yuvak_id ='BHYK001';
                    $permission = $this->admin_model->get_role($yuvak_id);
                    dd($permission);
                    // if()
                    if($_POST){
                              $post_data = $this->input->post();
                              $user_details = $this->login_model->check_user($post_data);
                              if(isset($user_details) && !empty($user_details)){
                                        $this->load->view('hi');
                              }
                              else{
                                        var_dump  ('login unsuccessful');
                              }
                    }
                    else{
                              
                              $this->load->view('login');
                    }
          }

          public function reset(){
                    if($_POST){
                              $post_data = $this->input->post();
                              $user = $this->login_model->reset_password($post_data);
                              if($user == true){
                                        $this->load->view('hi');
                              }
                              else{
                                        var_dump('login unsuccessful');
                              }
                    }
                    else{
                              $this->load->view('reset_password');
                    }
          }
}
