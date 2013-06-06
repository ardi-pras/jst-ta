<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of penyakit_model
 *
 * @author desk
 */
class penyakit_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    var $table = 'penyakit';

    function count_all_num_rows() {
        return $this->db->count_all($this->table);
    }

    function get_last_ten_penyakit($limit, $offset) {
        $this->db->select('*');
        $this->db->order_by('nm_penyakit', 'asc');
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    function delete($kd_penyakit) {
        $this->db->where('kd_penyakit', $kd_penyakit);
        $this->db->delete($this->table);
    }

    function add($penyakit) {
        $this->db->insert($this->table, $penyakit);
    }

    function get_penyakit_by_id($kd_penyakit) {
        $this->db->select('*');
        $this->db->where('kd_penyakit', $kd_penyakit);
        return $this->db->get($this->table)->row();
    }

    function update($kd_penyakit, $penyakit) {
        $this->db->where('kd_penyakit', $kd_penyakit);
        $this->db->update($this->table, $penyakit);
    }

}

?>
