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
                    $karyakar_mandal = $this->user_model->get_mandal_by_id($data['shibir_id']);
                    $yuvak_mandal = $this->user_model->get_mandal_by_id($data['yuvak_id']);

                    // if ($currentDateTime >= '2024-05-28 21:00:00' && $currentDateTime <= '2024-05-29 6:00:00') {
                    //     //bharuch
                    //     $quiz = 'bharuch';
                    // } elseif ($currentDateTime >= '2024-05-29 09:30:00' && $currentDateTime <= '2024-05-29 13:30:00') {
                    //             //dhule
                    //             $quiz = 'dhule';
                    // } elseif ($currentDateTime >= '2024-05-30 18:30:00' && $currentDateTime <= '2024-05-29 20:30:00') {
                    //             //nashik
                    //             $quiz = 'nashik';
                    // } elseif ($currentDateTime >= '2024-05-30 12:30:00' && $currentDateTime <= '2024-05-29 15:30:00') {
                    //             //session 1
                    //             $quiz = 'shibir_session_1';
                    // } elseif ($currentDateTime >= '2024-05-28 18:30:00' && $currentDateTime <= '2024-05-29 20:30:00') {
                    //             //session 2
                    //             $quiz = 'shibir_session_2';
                    // }

                    $karyakram = 'at_bharuch';
                    if($karyakar_mandal == $yuvak_mandal){
                        $new_data['mandal'] = $yuvak_mandal;
                        $new_data['shibir_id'] = $data['yuvak_id'];
                        $new_data['attendance_for'] = $karyakram;
                        $user_details = $this->attendance_model->post_attendance($new_data);
                        if($user_details == true){
                            $response['status'] = 'true';
                            $response['message'] = 'Thank you for attendance';
                        }
                        else{
                            $response['status'] = 'false';
                            $response['message'] = 'Attendance already done';
                        }
                    }
                    else{
                        $response['status'] = 'false';
                        $response['message'] = ['Yuvak is not of the mandal'.$karyakar_mandal];
                    }
                    echo json_encode($response);
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
