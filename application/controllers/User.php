
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

        public function __construct(){
              
                parent::__construct();
                $this->load->model('user_model');
        }

        public function get_all_user(){                
            $users = $this->user_model->get_all_user();
        
            echo json_encode($users);
        }


       public function get_by_id(){
            $postData = file_get_contents("php://input");
            $id['shibir_id'] = json_decode($postData, true);
            $response = array();
        
            if(isset($id) && !empty($id)){
                $user = $this->user_model->get_by_id($id['shibir_id']);
                $name = $this->user_model->get_yuvak_name($id['shibir_id']);
                
                $bus_leader['shibir_id'] = $user['bus_leader'];
                $bus_leader = $this->user_model->get_yuvak_name($bus_leader);
                // var_dump($bus_leader);die;
                $user['name'] = $name['name'];
                $user['bus_leader'] = $bus_leader['name'];
                $response['user'] = $user;
            }
        
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
