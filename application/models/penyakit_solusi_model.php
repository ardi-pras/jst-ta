<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of penyakit_solusi_model
 *
 * @author ardi
 */
class penyakit_solusi_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    var $table = 'solusi_penyakit';

    function count_all_num_rows() {
        return $this->db->count_all($this->table);
    }

    function get_last_ten_penyakit_solusi($limit, $offset) {
        $this->db->select('solusi_penyakit.kd_solusi, solusi_penyakit.kd_penyakit, penyakit.nm_penyakit, solusi.nm_solusi');
        $this->db->from('penyakit, solusi_penyakit,solusi');
        $this->db->where('solusi_penyakit.kd_penyakit = penyakit.kd_penyakit AND solusi_penyakit.kd_solusi = solusi.kd_solusi');
        $this->db->order_by('solusi_penyakit.kd_penyakit', 'asc');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    function delete($kd_penyakit) {
        $this->db->where('kd_penyakit', $kd_penyakit);
        $this->db->delete($this->table);
    }

    function add($penyakit_solusi) {
        $this->db->insert($this->table, $penyakit_solusi);
    }


    function get_kd_penyakit($nm_penyakit) {
        $this->db->select('kd_penyakit');
        $this->db->where('nm_penyakit', $nm_penyakit);
        return $this->db->get('penyakit')->row();
    }

    function get_penyakit_solusi_by_id($kd_penyakit) {
        $this->db->select('solusi_penyakit.kd_solusi, solusi_penyakit.kd_penyakit, penyakit.nm_penyakit, solusi.nm_solusi');
        $this->db->from('penyakit, solusi_penyakit,solusi');
        $this->db->where('solusi_penyakit.kd_penyakit = penyakit.kd_penyakit AND solusi_penyakit.kd_solusi = solusi.kd_solusi');
        $this->db->where('solusi_penyakit.kd_penyakit', $kd_penyakit);
        return $this->db->get()->row();
    }

    function update($kd_penyakit, $penyakit_solusi) {
        $this->db->where('kd_penyakit', $kd_penyakit);
        $this->db->update($this->table, $penyakit_solusi);
    }
}
?>
