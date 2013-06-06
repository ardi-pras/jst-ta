<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of penyebab_model
 *
 * @author desk
 */
class penyebab_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    var $table = 'penyebab';

    function count_all_num_rows() {
        return $this->db->count_all($this->table);
    }

    function get_last_ten_penyebab($limit, $offset) {
        $this->db->select('*');
        $this->db->order_by('nm_penyebab', 'asc');
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    function delete($kd_penyebab) {
        $this->db->where('kd_penyebab', $kd_penyebab);
        $this->db->delete($this->table);
    }

    function add($penyebab) {
        $this->db->insert($this->table, $penyebab);
    }

    function get_penyebab_by_id($kd_penyebab) {
        $this->db->select('*');
        $this->db->where('kd_penyebab', $kd_penyebab);
        return $this->db->get($this->table)->row();
    }

    function update($kd_penyebab, $penyebab) {
        $this->db->where('kd_penyebab', $kd_penyebab);
        $this->db->update($this->table, $penyebab);
    }

}

?>
