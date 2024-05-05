<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class announcement_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function update_announcement($data = [])
    {
          if(isset($data['id']) && !empty($data['id']))
          {
                    $this->db->select('*');
                    $this->db->where('id',$data['id']);
                    $this->db->update('announcements',$data);
          }
          else{
                    $user = $this->db->insert('announcements',$data);
          }

    }

    public function get_announcement()
    {     
        //   $data['is_password_changed'] = 'yes';
        //   $this->db->where('shibir_id',$data['shibir_id']);
        //   $this->db->where('deleted_at',null);
          $announcements = $this->db->get('announcements')->result_array();
        return $announcements;
    }
}