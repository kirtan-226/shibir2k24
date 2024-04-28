<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qr_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function store_qr($data = [])
    {
        $qr = $this->db->insert('data')->row_array();
    }
}
