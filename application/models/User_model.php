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
        
        $this->db->select("CONCAT(firstname,' ', lastname) AS name", FALSE);
        $this->db->where('shibir_id', $id['shibir_id']);
        // $this->db->where('deleted_at', null);
        
        $user = $this->db->get('shibir_users')->row_array();  
        // var_dump($user);die;
        return $user;
    }
    
    public function get_yuvak_first_name($id)
    {     
        
        $this->db->select("firstname");
        $this->db->where('shibir_id', $id['shibir_id']);
        // $this->db->where('deleted_at', null);
        
        $firstname = $this->db->get('shibir_users')->row_array();  
        // var_dump($user);die;
        return $firstname;
    }
    public function get_yuvak_last_name($id)
    {     
        
        $this->db->select("lastname");
        $this->db->where('shibir_id', $id['shibir_id']);
        // $this->db->where('deleted_at', null);
        
        $lastname = $this->db->get('shibir_users')->row_array();  
        // var_dump($lastname);die;
        return $lastname;
    }

    // public function get_role($id)
    // {     
    //     $this->db->select("CONCAT(firstname, ' ', middlename, ' ', lastname) AS name", FALSE);
    //     $this->db->where('shibir_id', $id['shibir_id']);
    //     // $this->db->where('deleted_at', null);
    //     $user = $this->db->get('shibir_users')->row_array();        
    //     return $user;
    // }
    
     public function get_phone_number($id){
        $this->db->select('phone_number');
        $this->db->where('shibir_id', $id['shibir_id']);
        // $this->db->where('deleted_at', null);
        $user = $this->db->get('yuvak_details')->row_array();        
        return $user;
     }
     
     public function check_registrar($id){
        $this->db->select('*');
        $this->db->where('shibir_id', $id['shibir_id']);
        // $this->db->where('deleted_at', null);
        $user = $this->db->get('registrar')->row_array();        
        return $user ? true : false;
     }
     
     public function get_qr($id){
        $this->db->select('api');
        $this->db->where('qr_code', $id['shibir_id']);
        // $this->db->where('deleted_at', null);
        $user = $this->db->get('qr_code')->row_array();        
        return $user;
     }

    public function get_mandal_by_id($id)
    {     
        $this->db->select('mandal');
        $this->db->where('shibir_id', $id);
        // $this->db->where('deleted_at', null);
        $user = $this->db->get('yuvak_details')->row_array();        
        return $user;
    }

}
