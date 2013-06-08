<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of penyakit_penyebab_model
 *
 * @author ardi
 */
class penyakit_penyebab_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    var $table = 'penyebab_penyakit';

    function count_all_num_rows() {
        return $this->db->count_all($this->table);
    }

    function get_last_ten_penyakit_penyebab($limit, $offset) {
        $this->db->select('penyebab_penyakit.kd_penyakit, penyakit.nm_penyakit, penyebab.nm_penyebab');
        $this->db->from('penyakit, penyebab_penyakit,penyebab');
        $this->db->where('penyebab_penyakit.kd_penyakit = penyakit.kd_penyakit AND penyebab_penyakit.kd_penyebab = penyebab.kd_penyebab');
        $this->db->order_by('penyebab_penyakit.kd_penyakit', 'asc');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    function delete($kd_penyakit) {
        $this->db->where('kd_penyakit', $kd_penyakit);
        $this->db->delete($this->table);
    }

    function add($penyebab_penyakit) {
        $this->db->insert($this->table, $penyebab_penyakit);
    }

    function get_kd_penyakit($nm_penyakit) {
        $this->db->select('kd_penyakit');
        $this->db->where('nm_penyakit', $nm_penyakit);
        return $this->db->get('penyakit')->row();
    }

    function get_kd_penyebab($nm_penyebab) {
        $this->db->select('kd_penyebab');
        $this->db->where('nm_penyebab', $nm_penyebab);
        return $this->db->get('penyebab')->row();
    }

    function get_penyakit_penyebab_by_id($kd_penyakit) {
        $this->db->select('penyebab_penyakit.kd_penyakit, penyakit.nm_penyakit, penyebab.nm_penyebab');
        $this->db->from('penyakit, penyebab_penyakit,penyebab');
        $this->db->where('penyebab_penyakit.kd_penyakit = penyakit.kd_penyakit');
        $this->db->where('penyebab_penyakit.kd_penyakit', $kd_penyakit);
        return $this->db->get()->row();
    }

    function update($kd_penyakit, $penyebab_penyakit) {
        $this->db->where('kd_penyakit', $kd_penyakit);
        $this->db->update($this->table, $penyebab_penyakit);
    }
}
?>
