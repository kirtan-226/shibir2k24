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



class Quiz_admin_1191820114 extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('admin_panel_model');
        $this->load->model('login_model');
        $this->load->model('quiz_model');

    }

    public function add_edit_quiz(){
        $perPage = 20; // Number of questions per page
    
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Handle form submission
            $postData = file_get_contents("php://input");
            $data = json_decode($postData, true);
    
            if(isset($data['question_id']) && !empty($data['question_id'])){
                // Edit question
                $quiz_id = $this->quiz_model->get_quiz_id($data['quiz']);
                $data['quiz'] = $quiz_id['id'];
                $question_id = $this->quiz_model->add_question($data);
            }
            else{
                // Add new question
                $quiz_id = $this->quiz_model->get_quiz_id($data['quiz']);
                $data['quiz'] = $quiz_id['id'];
                $question_id = $this->quiz_model->add_question($data);
            }
            return true; // Assuming this is a success response
        }
        else{
            // Display paginated list of questions
            $page = $this->input->get('page') ?? 1;
            $offset = ($page - 1) * $perPage;
            $quizId = '';
            $questions = $this->quiz_model->pagination($quizId, $perPage, $offset);
    
            foreach ($questions as &$question) {
                $quiz_place = $this->quiz_model->get_quiz_place($question['quiz']);
                $str = str_replace('_', ' ', ucwords($quiz_place['place'], '_'));
                $question['quiz'] = $str;
            }
            unset($question);
            
            $quiz_place = $this->quiz_model->get_all_quiz_place();
            // var_dump($quiz_place);die;
            $totalQuestions = $this->quiz_model->get_total_questions();
            $totalPages = ceil($totalQuestions / $perPage);
    
            $data['questions'] = $questions;
            $data['totalPages'] = $totalPages;
            $data['currentPage'] = $page;
            $data['quiz_place'] = $quiz_place;
            $this->load->view('add_edit_quiz', $data);
        }
    }
    

    public function get_question($questionId) {
        // var_dump($questionId);die;
        $question = $this->quiz_model->get_question_by_id($questionId);
        $quiz_place = $this->quiz_model->get_quiz_place($question['quiz']);
        $question['quiz'] = $quiz_place['place'];
        echo json_encode($question);
    }

    public function filter_question() {
        $quizId = $this->input->get('quiz');
        if($quizId == ''){ 
            $questions = $this->quiz_model->get_questions($quizId);
        }
        else{
            $questions = $this->quiz_model->get_question_by_quiz_id($quizId);
        }
        // Assuming $questions is the array of questions and $totalPages is the total number of pages
        foreach ($questions as &$question) {
            $quiz_place = $this->quiz_model->get_quiz_place($question['quiz']);
            $str = str_replace('_', ' ', ucwords($quiz_place['place'], '_'));
            $question['quiz'] = $str;
        }
        unset($question);
        $response = array(
            'questions' => $questions,
        );
        header('Content-Type: application/json');
        echo json_encode($response);

    }

    // public function pagination() {
    //     $quizId = $this->input->get('quiz_id');
    //     $page = $this->input->get('page') ?? 1;
    //     $perPage = 20;
    //     $offset = ($page - 1) * $perPage;
    
    //     $questions = $this->quiz_model->pagination($quizId, $perPage, $offset);
    //     $totalQuestions = $this->quiz_model->get_total_questions($quizId);
    //     $totalPages = ceil($totalQuestions / $perPage);
    //     foreach ($questions as &$question) {
    //         $quiz_place = $this->quiz_model->get_quiz_place($question['quiz']);
    //         $str = str_replace('_', ' ', ucwords($quiz_place['place'], '_'));
    //         $question['quiz'] = $str;
    //     }
    //     unset($question);
    //     $data['questions'] = $questions;
    //     $data['totalPages'] = $totalPages;
    //     $data['currentPage'] = $page;
    
    //     $this->load->view('question_listing', $data);
    // }
    
    
    
    

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
