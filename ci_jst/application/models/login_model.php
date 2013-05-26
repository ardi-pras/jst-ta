<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login_model
 *
 * @author desk
 */
class login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    var $table = 'login';

    function check_user($username, $password) {
        $query = $this->db->get_where($this->table, array('username' => $username, 'password' => $password), 1, 0);

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
