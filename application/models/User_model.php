<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_all_user()
    {
        $this->db->select('*');
        // $this->db->where('deleted_at',null);
        $user = $this->db->get('yuvak_details')->result_array();
        return $user;
    }

    public function get_by_id($id)
    {     
          $this->db->select('*');
          $this->db->where('shibir_id',$id['shibir_id']);
        //   $this->db->where('deleted_at',null);
          $user = $this->db->get('yuvak_details')->row_array();
        return $user;
    }

    public function get_yuvak_name($id)
    {     
        
        $this->db->select("CONCAT(firstname, ' ', middlename, ' ', lastname) AS name", FALSE);
        $this->db->where('shibir_id', $id['shibir_id']);
        // $this->db->where('deleted_at', null);
        
        $user = $this->db->get('shibir_users')->row_array();  
        // var_dump($user);die;
        return $user;
    }

    // public function get_role($id)
    // {     
    //     $this->db->select("CONCAT(firstname, ' ', middlename, ' ', lastname) AS name", FALSE);
    //     $this->db->where('shibir_id', $id['shibir_id']);
    //     // $this->db->where('deleted_at', null);
    //     $user = $this->db->get('shibir_users')->row_array();        
    //     return $user;
    // }

    public function get_mandal_by_id($id)
    {     
        $this->db->select('mandal');
        $this->db->where('shibir_id', $id);
        // $this->db->where('deleted_at', null);
        $user = $this->db->get('yuvak_details')->row();        
        return $user;
    }

}
