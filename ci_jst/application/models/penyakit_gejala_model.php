<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of penyakit_gejala_model
 *
 * @author desk
 */
class penyakit_gejala_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    var $table = 'gejala_penyakit';

    function count_all_num_rows() {
        return $this->db->count_all($this->table);
    }

    function get_last_ten_penyakit_gejala($limit, $offset) {
        $this->db->select('gejala_penyakit.kd_penyakit, penyakit.nm_penyakit, gejala_penyakit.nm_gejala');
        $this->db->from('penyakit, gejala_penyakit');
        $this->db->where('gejala_penyakit.kd_penyakit = penyakit.kd_penyakit');
        $this->db->order_by('kd_penyakit', 'asc');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    function delete($kd_penyakit) {
        $this->db->where('kd_penyakit', $kd_penyakit);
        $this->db->delete($this->table);
    }

    function add($penyakit_gejala) {
        $this->db->insert($this->table, $penyakit_gejala);
    }


    function get_kd_penyakit($nm_penyakit) {
        $this->db->select('kd_penyakit');
        $this->db->where('nm_penyakit', $nm_penyakit);
        return $this->db->get('penyakit')->row();
    }

    function get_kd_gejala($nm_gejala) {
        $this->db->select('*');
        $this->db->where('nm_gejala', $nm_gejala);
        return $this->db->get('gejala')->row();
    }

    function get_penyakit_gejala_by_id($kd_penyakit) {
        $this->db->select('gejala_penyakit.kd_penyakit, penyakit.nm_penyakit, gejala_penyakit.nm_gejala');
        $this->db->from('penyakit, gejala_penyakit');
        $this->db->where('gejala_penyakit.kd_penyakit = penyakit.kd_penyakit');
        $this->db->where('gejala_penyakit.kd_penyakit', $kd_penyakit);
        return $this->db->get()->row();
    }

    function update($kd_penyakit, $penyakit_gejala) {
        $this->db->where('kd_penyakit', $kd_penyakit);
        $this->db->update($this->table, $penyakit_gejala);
    }

}

?>
