
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


class Lost_and_found extends CI_Controller {

        public function __construct(){
              
                parent::__construct();
                $this->load->model('user_model');
                $this->load->model('lost_and_found_model');
        }

        public function get_all(){                
            $item = $this->lost_and_found_model->get_all();
            usort($item, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
            foreach($item as $value){
                $responseItem['description'] = $value['description'];
                $id['shibir_id'] = $value['shibir_id'];
                $yuvak_name = $this->user_model->get_yuvak_name($id);
                $responseItem['by'] = $yuvak_name;
                $datetime = new DateTime($value['created_at']);
                $responseItem['date'] = $datetime->format('Y-m-d');
                $responseItem['time'] = $datetime->format('H:i:s');
                $response[] = $responseItem;
            }
            
            echo json_encode($response);
        }


       public function post_lost_and_found(){
            $postData = file_get_contents("php://input");
            $data = json_decode($postData, true);
            $response = array();
            date_default_timezone_set('Asia/Kolkata');
            if(isset($data) && !empty($data)){
                $data['created_at'] = date('Y-m-d G:i:s');
                $this->lost_and_found_model->post_lost_and_found($data);
                $response['status'] = true;
            }
            echo json_encode($response);
        }

}
