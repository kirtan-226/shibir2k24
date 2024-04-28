<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {

          public function __construct(){
                    parent::__construct();
                    $this->load->model('admin_panel_model');
                    $this->load->model('Announcement_model');
          }

          public function update_announcement($data){
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
