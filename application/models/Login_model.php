<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function check_user($data = [])
    {
        $this->db->select('*');
        $this->db->where('shibir_id',$data['shibir_id']);
        $this->db->where('password',$data['password']);
        $this->db->where('deleted_at',null);
        $user = $this->db->get('shibir_users')->row_array();
        
        return $user;
    }

    public function reset_password($data = [])
    {     $this->db->where('shibir_id',$data['shibir_id']);
          $this->db->where('deleted_at',null);
          $user = $this->db->update('shibir_users',$data);
        return $user;
    }
}
