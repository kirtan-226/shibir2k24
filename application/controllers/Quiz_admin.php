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
          $currentDateTime = date('Y-m-d H:i:s');
          $hour = date('H', strtotime($currentDateTime));
        var_dump($currentDateTime);die;
          
          // if ($currentDateTime == '2024-05-28 21:00:') {
          // } elseif (strtotime($currentDateTime) > ) {
          // } elseif (strtotime($currentDateTime) > $timestamp) {
          // } elseif (strtotime($currentDateTime) > $timestamp) {
          // } elseif (strtotime($currentDateTime) > $timestamp) {
          // } elseif (strtotime($currentDateTime) > $timestamp) {
          // } elseif (strtotime($currentDateTime) > $timestamp) {
          // } elseif (strtotime($currentDateTime) > $timestamp) {
          // } elseif (strtotime($currentDateTime) > $timestamp) {
          // } elseif (strtotime($currentDateTime) > $timestamp) {
          // }
        $question = $this->quiz_model->get_questions();
        count($quesitons);
        $random_keys = array_rand($question, 5); 
        $random_questions = array_intersect_key($question, array_flip($random_keys));
        var_dump($random_questions);die;
        $quiz_place = $this->quiz_model->get_quiz_place($question['quiz']);
        $question['quiz'] = $quiz_place['place'];
        var_dump($question);die;
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
