<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sadgun_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function post_sadgun($data)
    {
        
        $this->db->insert('sadgun',$data);
        return true;
    }
    
    public function get_all()
    {
        $this->db->select('*');
        $sadgun = $this->db->get('sadgun')->result_array();
        return $sadgun;
    }


}
