<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_yuvaks_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function insert_users($data = [])
    {
        $user = $this->db->insert('shibir_users',$data);
        var_dump($user);
        return $user;
    }

}
