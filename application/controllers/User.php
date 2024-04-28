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
            var_dump($users);
            return $users;
        }

        public function get_by_id(){
            $postData = file_get_contents("php://input");
            $id = json_decode($postData, true);
            if(isset($id) && !empty($id)){
                $user = $this->user_model->get_by_id($id);
                return $user;
            }
        }
}
