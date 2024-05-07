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

    public function add_edit_quiz(){
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $postData = file_get_contents("php://input");
            $data = json_decode($postData, true);

            $quiz_id = $this->quiz_model->get_quiz_id($data['quiz']);
            $data['quiz'] = $quiz_id['id'];
            $question_id = $this->quiz_model->add_question($data);
        }
        else{
            $questions = $this->quiz_model->get_questions();
            foreach ($questions as &$question) {
                $quiz_place = $this->quiz_model->get_quiz_place($question['quiz']);
                $str = str_replace('_', ' ', ucwords($quiz_place['place'], '_'));
                $question['quiz'] = $str;
            }
            unset($question);
            $data['questions'] = $questions;
            $this->load->view('add_edit_quiz', $data);
        }
    } 

    public function get_question($questionId) {
        $question = $this->quiz_model->get_question_by_id($questionId);
        $quiz_place = $this->quiz_model->get_quiz_place($question['quiz']);
        $question['quiz'] = $quiz_place['place'];
        // var_dump($question);die;
        echo json_encode($question);
    }

    public function delete_question($questionId) {
        $result = $this->quiz_model->delete_question($questionId);
        // Assuming delete_question() returns a boolean indicating success or failure
        if ($result) {
            echo 'Question deleted successfully';
        } else {
            echo 'Failed to delete question';
        }
    }
    
    
}
