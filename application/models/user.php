<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Model {

    function checkLogin($username, $password) {
        $password = base64_encode($password);
        $query = $this->db->query("SELECT * FROM wk_member
                                WHERE member_username='$username'
                                AND member_password='$password'
			");

        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
    }
    
    function updateLastLogin($id) {
        $query = $this->db->query("UPDATE wk_member SET member_lastlogin = now() WHERE member_id = '$id'");
    }
}

/* End of file login.php */
/* Location: ./application/models/login.php */