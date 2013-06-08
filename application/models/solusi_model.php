<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of solusi_model
 *
 * @author desk
 */
class solusi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    var $table = 'solusi';

    function count_all_num_rows() {
        return $this->db->count_all($this->table);
    }

    function get_last_ten_solusi($limit, $offset) {
        $this->db->select('*');
        $this->db->order_by('nm_solusi', 'asc');
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    function delete($kd_solusi) {
        $this->db->where('kd_solusi', $kd_solusi);
        $this->db->delete($this->table);
    }

    function add($solusi) {
        $this->db->insert($this->table, $solusi);
    }

    function get_solusi_by_id($kd_solusi) {
        $this->db->select('*');
        $this->db->where('kd_solusi', $kd_solusi);
        return $this->db->get($this->table)->row();
    }

    function update($kd_solusi, $solusi) {
        $this->db->where('kd_solusi', $kd_solusi);
        $this->db->update($this->table, $solusi);
    }
    
    function get_kd_solusi($nm_solusi) {
        $this->db->select('kd_solusi');
        $this->db->where('nm_solusi', $nm_solusi);
        return $this->db->get('solusi')->row();
    }

}

?>
