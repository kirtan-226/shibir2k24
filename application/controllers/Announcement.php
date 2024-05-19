

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


class Announcement extends CI_Controller {

          public function __construct(){
                    parent::__construct();
                    $this->load->model('admin_panel_model');
                    $this->load->model('announcement_model');
                    $this->load->model('user_model');
          }

              public function add_edit_announcement($data =[]){
                        $postData = file_get_contents("php://input");
                        $postData = json_decode($postData, true);
                        // $yuvak_id = $this->session->userdata('user_id');
                        date_default_timezone_set('Asia/Kolkata');
                        $permission = $this->admin_panel_model->get_permission($postData['shibir_id']);
                        if(isset($permission) && !empty($permission) && $permission['edit_announcement'] == 'yes'){
                            $new_data['by_user'] = $postData['shibir_id'];
                            $new_data['announcement'] = $postData['announcement'];
                            $new_data['date_time'] = date('Y-m-d G:i:s');
                            $this->announcement_model->update_announcement($new_data);
                            $response['status'] = true;
                        }
                        else{
                                  $response['status'] = false ;
                        }
                        header('Content-Type: application/json');
                        echo json_encode($response);
              }

          public function get_announcement($data = []) {
            $announcements = $this->announcement_model->get_announcement();
            $response = [];
        
            // Sort announcements by date_time in descending order
            usort($announcements, function($a, $b) {
                return strtotime($b['date_time']) - strtotime($a['date_time']);
            });
            
            foreach ($announcements as &$value) {
                $datetime = new DateTime($value['date_time']);
                $value['date'] = $datetime->format('Y-m-d');
                $value['time'] = $datetime->format('H:i:s');
                unset($value['date_time']);
            }
            unset($value);
        
            foreach ($announcements as $announcement) {
                $responseItem = [];
                $responseItem['announcement'] = $announcement['announcement'];
                $responseItem['status'] = true;
                $id['shibir_id'] = $announcement['by_user'];
                
                $user = $this->user_model->get_yuvak_name($id);
                // var_dump($user);die;
                $responseItem['by'] = $user;
                $responseItem['time'] = $announcement['time'];
                $responseItem['date'] = $announcement['date'];
                $response[] = $responseItem;
            }
                
            header('Content-Type: application/json');
            echo json_encode($response);
        }


}
