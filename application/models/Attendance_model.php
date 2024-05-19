<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function post_attendance($data = [])
    {   
        $this->db->select('*');
        $this->db->where('shibir_id',$data['shibir_id']);
        $attendance = $this->db->get('attendance')->result_array();

        if(isset($attendance) && !empty($attendance)){
            
            foreach($attendance as $value){
                
                if($value['attendance_for'] == $data['attendance_for']){
                    return false;
                }
            }
            $attendance = $this->db->insert('attendance',$data);
            return true;
        }
        else{
            $attendance = $this->db->insert('attendance',$data);
            return true;
        }
        return $attendance;
    }

    public function get_attendance_by_mandal($data = [])
    {     
          $this->db->select('*');
          $this->db->where('mandal',$data['mandal']);
          $user = $this->db->get('attendance',$data);
        return $user;
    }

    public function get_all_attendance()
    {     
          $this->db->select('*');
          $users = $this->db->get('attendance');
        return $users;
    }

    public function get_karyakram($data)
    {    
          $this->db->select('*');
          $this->db->where('karyakram',$data);
          $karyakram = $this->db->get('karyakram')->row();
        return $karyakram;
    }

    public function get_by_karyakar($karyakar_id){
          $this->db->select('*');
          $this->db->where('karyakram',$data);
          $karyakram = $this->db->get('karyakram')->result_array();
        return $karyakram;
    }
}