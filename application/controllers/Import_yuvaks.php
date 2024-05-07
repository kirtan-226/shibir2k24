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
