<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function add_question($data){ 
        if(isset($data['question_id']) && !empty($data['question_id'])){
            // var_dump($data);die;
            $id = $data['question_id'];
            unset($data['question_id']);
            $this->db->where('id',$id);
            $this->db->update('quiz',$data);
            return ($this->db->affected_rows() > 0);  
        }   
        else{  
          $this->db->insert('quiz',$data);
          return ($this->db->affected_rows() > 0);
        }
    }

    public function get_questions(){      
        $question = $this->db->get('quiz')->result_array();
        return $question;
    }

    public function get_question_by_id($id){
        $this->db->select('*');
        $this->db->where('id',$id);      
        $question = $this->db->get('quiz')->row_array();
        return $question;
    }
    
    public function check_user($data = [])
    {
        $this->db->select('*');
        $this->db->where('shibir_id',$data['shibir_id']);
        $this->db->where('password',$data['password']);
        $user = $this->db->get('shibir_users')->row_array();
        var_dump($user);die;
        return $user;
    }

    public function get_quiz_id($quiz){      
        $this->db->select('*');
        $this->db->where('place',$quiz);
        $quiz = $this->db->get('quiz_place')->row_array();
      return $quiz;
  }

    public function get_quiz_place($quiz){   
        $this->db->select('*');
        $this->db->where('id',$quiz);
        $quiz = $this->db->get('quiz_place')->row_array();
        return $quiz;
    }

    public function delete_question($quiz){ 
        $this->db->where('id',$quiz);
        $this->db->delete('quiz');
        // var_dump($this->db->last_query());die;  
    }
}