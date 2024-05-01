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

class User extends CI_Controller {

        public function __construct(){
                parent::__construct();
                $this->load->model('user_model');
        }

        public function get_all_user(){                
            $users = $this->user_model->get_all_user();
        
            header('Content-Type: application/json');
            echo json_encode($users);
        }


       public function get_by_id(){
    $postData = file_get_contents("php://input");
    $id['shibir_id'] = json_decode($postData, true);
    $response = array();

    if(isset($id) && !empty($id)){
        $user = $this->user_model->get_by_id($id['shibir_id']);
        $user['name'] = $this->user_model->get_yuvak_name($id['shibir_id']);
        $response['user'] = $user;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

        public function get_mandal_id(){
            $postData = file_get_contents("php://input");
            $id['shibir_id'] = json_decode($postData, true);
            if(isset($id) && !empty($id)){
                $user = $this->user_model->get_mandal_id($id['shibir_id']);
                $user_name = $this->user_model->get_yuvak_name($id['shibir_id']);
                var_dump($user_name,$user);
                return $user;
            }
        }
}
