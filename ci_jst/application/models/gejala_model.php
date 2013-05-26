<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gejala_model
 *
 * @author desk
 */
class gejala_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    var $table = 'gejala';

    function count_all_num_rows() {
        return $this->db->count_all($this->table);
    }

    function get_last_ten_gejala($limit, $offset) {
        $this->db->select('*');
        $this->db->order_by('nm_gejala', 'asc');
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    function delete($kd_gejala) {
        $this->db->where('kd_gejala', $kd_gejala);
        $this->db->delete($this->table);
    }

    function add($gejala) {
        $this->db->insert($this->table, $gejala);
    }

    function get_gejala_by_id($kd_gejala) {
        $this->db->select('*');
        $this->db->where('kd_gejala', $kd_gejala);
        return $this->db->get($this->table)->row();
    }

    function update($kd_gejala, $gejala) {
        $this->db->where('kd_gejala', $kd_gejala);
        $this->db->update($this->table, $gejala);
    }

}

?>
