<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class demo_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get(){
          $this->db->select('*');
          $user = $this->db->get('shibir_users')->result_array();
        return $user;
    }
}