<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lost_and_found_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function post_lost_and_found($data)
    {
        
        $this->db->insert('lost_and_found',$data);
        return true;
    }
    
    public function get_all()
    {
        $this->db->select('*');
        $sadgun = $this->db->get('lost_and_found')->result_array();
        return $sadgun;
    }


}
