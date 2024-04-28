<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_panel_model extends CI_Model {

          public function __construct(){
                    parent::__construct();
                    $this->load->database();
          }

          public function get_user($id = '')
          {
                    if(isset($id) && !empty($id)){
                              $this->db->select('*');
                              $this->db->where('yuak_id',$id);
                              $this->db->get('yuvak_details')->row_array();
                    }
                    else{
                              $this->db->select('*');
                              $this->db->get('yuvak_details')->result_array();   
                    }
          }

          public function update_user($id = '' , $data = [])
          {         
                    if(isset($id) && !empty($id)){
                              $this->db->where('yuak_id',$id);
                              $this->db->update('yuvak_details',$data);
                    }
                    else{
                              $this->db->insert('yuvak_details',$data);   
                    }
          }

          public function get_memories($place = '')
          {         
                    if(isset($place) && !empty($place)){
                              $this->db->where('place',$place);
                              $this->db->get('memories')->result_array();
                    }
                    else{
                              $this->db->select('*');
                              $this->db->get('memories')->result_array();   
                    }
          }

          public function update_memories($place = '',$data = [])
          {         
                    if(isset($place) && !empty($place)){
                              $this->db->where('place',$place);
                              $this->db->update('memories',$data);
                    }
                    else{
                              $this->db->insert('memories',$data);   
                    }
          }

          public function get_announcement()
          {     
                    $this->db->select('*');
                    $this->db->get('announcements')->result_array();   
          }

          public function update_announcement($id = '',$data = [])
          {         
                    if(isset($id) && !empty($id)){
                              if(isset($data['role']) && !empty($data['role'])){
                                        $this->db->where('for_role',$data['role']);
                              }
                             $this->db->where('id',$id);
                             $this->db->update('memories',$data);
                    }
                    else{
                              $this->db->insert('memories',$data);   
                    }
          }

          

}