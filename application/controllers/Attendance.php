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



class Attendance extends CI_Controller {

          public function __construct(){
                    parent::__construct();
                    $this->load->model('attendance_model');
                    $this->load->model('user_model');
          }

          public function post_attendance(){
                    $postData = file_get_contents("php://input");
                    $data = json_decode($postData, true);
                    // $karyakar_id = $this->session->userdata('user_id');
                    $karyakar_mandal = $this->user_mode->get_mandal_by_id($karyakar);
                    $yuvak_mandal = $this->user_model->get_mandal_by_id($data['shibir_id']);
                    if($karyakar_mandal == $yuvak_mandal){
                              $data = $yuvak_mandal;
                              $data = $postData;
                              foreach($karyakram as $value){
                                        if($karyakram = 'at_bharuch'){
                                                  $user_details = $this->attendance_model->post_attendance($postData);
                                        }
                                        else{
                                                  if($value['date_time'] && strtotime($value['date_time']) >= strtotime('-15 minutes', strtotime($currentDateTime)) && strtotime($value['date_time']) <= strtotime('+30 minutes', strtotime($currentDateTime))) {
                                                            $karyakram = $this->attendance_model->get_karyakram($value['date_time']);
                                                            $postData['karyakram'] = $karyakram;
                                                            $user_details = $this->attendance_model->post_attendance($postData);
                                                  }
                                        }
                              }
                    }
          }

          public function get_attendance_by_mandal(){
                    $postData = file_get_contents("php://input");
                    $data = json_decode($postData, true);
                    // $karyakar_id = $this->session->userdata('user_id');
                    if($karyakar_id){
                              $attendance = $this->attendance_model->get_attendance_by_mandal($karyakar_id);
                              foreach($attendance as $value){
                                        $user_name = $this->user_model->get_yuvak_name($value['shibir_id']);
                                        unset($value['shibir_id']);
                                        $value['name'] = $user_name;
                              }
                              return $attendance;
                    }
          }

          public function get_all_attendance(){
                    $postData = file_get_contents("php://input");
                    $data = json_decode($postData, true);
                    if($data){
                              $attendance = $this->attendance_model->get_all_attendance();
                              foreach($attendance as $value){
                                        $user_name = $this->user_model->get_yuvak_name($value['shibir_id']);
                                        unset($value['shibir_id']);
                                        $value['name'] = $user_name;
                              }
                              return $attendance;
                    }
          }
          

          public function get_attendance_by_kshetra(){
                    $postData = file_get_contents("php://input");
                    $data = json_decode($postData, true);
                    if($data){
                              $attendance = $this->attendance_model->get_all_attendance();
                              foreach($attendance as $value){
                                        $user_name = $this->user_model->get_yuvak_name($value['shibir_id']);
                                        unset($value['shibir_id']);
                                        $value['name'] = $user_name;
                              }
                              return $attendance;
                    }
          }
}
