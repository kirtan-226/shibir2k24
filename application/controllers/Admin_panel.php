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



class Admin_panel extends CI_Controller {

          public function __construct(){
                      parent::__construct();
                    $this->load->model('admin_panel_model');
          }

          public function detail_for_bus_leader()
          {
                $postData = file_get_contents("php://input");
                $data = json_decode($postData, true);
                
                $is_leader = $this->admin_panel_model->check_leader($data);
                if($is_leader = true){
                    $yuvaks = $this->admin_panel_model->get_bus_yuvak($data);
                }
                if(isset($yuvaks) && !empty($yuvaks)){
                    $response['yuvaks'] = $yuvaks;
                    $response['status'] = true;
                }
                else{
                    $response['status'] = false;
                }
                echo json_encode($response);
                    
          }


}
