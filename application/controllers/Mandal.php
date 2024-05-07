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



class Mandal extends CI_Controller {

          public function __construct(){
                    parent::__construct();
                    $this->load->model('attendance_model');
                    $this->load->model('user_model');
          }

          public function get_all_memories(){
                    $postData = file_get_contents("php://input");
                    $data = json_decode($postData, true);
                    // $data = 'at_bharuch';
                    // $currentDateTime = '2024-05-28 21:03:00';
                    $karyakram = $this->attendance_model->get_karyakram($data);
                    foreach($karyakram as $value){
                              if($value['date_time'] && strtotime($value['date_time']) >= strtotime('-15 minutes', strtotime($currentDateTime)) && strtotime($value['date_time']) <= strtotime('+30 minutes', strtotime($currentDateTime))) {
                                        $data[''];
                                        $user_details = $this->attendance_model->post_attendance($postData);
                                        var_dump('kirtan');die;
                              }
                    }
          }

         
}
