<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function update_announcement($data = [])
    {
          $announcement = [];
          if(isset($data['id']) && !empty($data['id']))
          {
                    $this->db->select('*');
                    $this->db->where('id',$data['id']);
                    $announcement = $this->db->update('announcements',$data);
          }
          else{
                    $user = $this->db->insert('announcements',$data);
          }

        return $user;
    }

    public function get_annoeuncemnt($data = [])
    {     $data['is_password_changed'] = 'yes';
          $this->db->where('shibir_id',$data['shibir_id']);
          $this->db->where('deleted_at',null);
          $user = $this->db->update('shibir_users',$data);
        return $user;
    }
}