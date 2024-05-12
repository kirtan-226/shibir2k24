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



class Quiz extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('admin_panel_model');
        $this->load->model('login_model');
        $this->load->model('quiz_model');

    }

    public function get_questions() {
          date_default_timezone_set('Asia/Kolkata');
          $currentDateTime = date('Y-m-d H:i:s');
          $hour = date('H', strtotime($currentDateTime));
          // var_dump($currentDateTime);die;
          
          if ($currentDateTime >= '2024-05-28 21:00:00' && $currentDateTime <= '2024-05-29 6:00:00') {
                    //bharuch
                    $quiz = 'bharuch';
          } elseif ($currentDateTime >= '2024-05-29 09:30:00' && $currentDateTime <= '2024-05-29 13:30:00') {
                    //dhule
                    $quiz = 'dhule';
          } elseif ($currentDateTime >= '2024-05-30 18:30:00' && $currentDateTime <= '2024-05-29 20:30:00') {
                    //nashik
                    $quiz = 'nashik';
          } elseif ($currentDateTime >= '2024-05-30 12:30:00' && $currentDateTime <= '2024-05-29 15:30:00') {
                    //session 1
                    $quiz = 'shibir_session_1';
          } elseif ($currentDateTime >= '2024-05-28 18:30:00' && $currentDateTime <= '2024-05-29 20:30:00') {
                    //session 2
                    $quiz = 'shibir_session_2';
          } elseif ($currentDateTime >= '2024-05-28 22:00:00' && $currentDateTime <= '2024-05-29 23:00:00') {
                    //session 3
                    $quiz = 'shibir_session_3';
          } elseif ($currentDateTime >= '2024-05-31 12:00:00' && $currentDateTime <= '2024-05-31 13:00:00') {
                    //nashik darshan
                    $quiz = 'nashik_darshan';
          } elseif ($currentDateTime >= '2024-05-31 15:00:00' && $currentDateTime <= '2024-05-29 18:00:00') {
                    //trambakeshwar
                    $quiz = 'trambakeshwar';
          } elseif ($currentDateTime >= '2024-06-01 08:30:00' && $currentDateTime <= '2024-06-01 11:30:00') {
                    //pune
                    $quiz = 'pune';
          } elseif ($currentDateTime >= '2024-06-01 19:30:00' && $currentDateTime <= '2024-06-01 20:30:00') {
                    //imagica
                    $quiz = 'imagica';
          } elseif ($currentDateTime >= '2024-06-02 12:00:00' && $currentDateTime <= '2024-06-02 13:00:00') {
                    //session 4
                    $quiz = 'shibir_session_4';
          }
          
        $quiz_id = $this->quiz_model->get_quiz_id($quiz);
        $questions = $this->quiz_model->get_question_by_quiz_id($quiz_id['id']);
//         $total_questions = count($questions);
//         $random_keys = array_rand($questions, $total_questions); 
//         $random_questions = array_intersect_key($questions, array_flip($random_keys));
        shuffle($questions);
        
        foreach ($questions as &$question) {
                    $options = array($question['option_1'], $question['option_2'], $question['option_3'], $question['option_4']);
                    shuffle($options);
                    $question['option_1'] = $options[0];
                    $question['option_2'] = $options[1];
                    $question['option_3'] = $options[2];
                    $question['option_4'] = $options[3];
          }
          unset($question); 
          $response['status'] = true;
          $reponse['$questions'] = $questions; 
//         $questions['quiz'] = $quiz_id['place'];
          echo json_encode($response);
    }
    
    public function post_answers(){
          $postData = file_get_contents("php://input");
          $answers = json_decode($postData, true);

          $shibir_id = $answers['shibir_id'];
          

    }
}
