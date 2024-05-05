<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_yuvaks extends CI_Controller {

          public function __construct(){
                    parent::__construct();
                    $this->load->model('import_yuvaks_model');
                    $this->load->model('user_model');
          }

          public function index(){
                    $data = [];
                    $file_lines = file('F:\we.csv', FILE_IGNORE_NEW_LINES);

                    foreach ($file_lines as $line){
                              $data[] = str_getcsv($line);
                    }
                    $keys = array_shift($data);
                    $result = [];
                    foreach ($data as $values) {
                              $x = array_combine($keys, $values);
                              $result [] = $x;
                    }
                    $shibir_users = [];
                    $yuvak_details = [];
                    foreach($result as $value){
                              $shibir_users['firstname'] = $value['First Name'];
                              $shibir_users['middlename'] = $value['Middle Name'];
                              $shibir_users['lastname'] = $value['Last Name'];
                    }
                    var_dump($shibir_users);
          }

          public function get_attendance_by_mandal($data){
                    $postData = file_get_contents("php://input");
                    $data = json_decode($postData, true);
                    // $karyakar_id = $this->session->userdata('user_id');
                    if($data){
                              $attendance = $this->attendance_model->get_attendance_by_mandal($data);
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
}
