<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Penyebab extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('penyebab_model');
    }

    var $limit = 10;
    var $title = 'Penyebab';

    public function index() {
        $this->session->unset_userdata('kd_penyebab');

        if ($this->session->userdata('login') == TRUE) {
            $this->get_all();
        } else {
            redirect('login');
        }
    }

    function get_all($offset = 0) {

    //pemberian title halaman Penyebab
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyebab';
        $data['main_view'] = 'penyebab/penyebab';

        // Offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        // Load data dari tabel Penyebab
        $penyebab = $this->penyebab_model->get_last_ten_penyebab($this->limit, $offset);
        $num_rows = $this->penyebab_model->count_all_num_rows();

        if ($num_rows > 0) {
        // Generate pagination
            $config['base_url'] = site_url('penyebab/get_all');
            $config['total_rows'] = $num_rows;
            $config['per_page'] = $this->limit;
            $config['uri_segment'] = $uri_segment;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            // Table
            /* Set table template for alternating row 'zebra' */
            $tmpl = array('table_open' => '<table border="0" cellpadding="0" cellspacing="0">',
                'row_alt_start' => '<tr class="zebra">',
                'row_alt_end' => '</tr>'
            );
            $this->table->set_template($tmpl);

            /* Set table heading */
            $this->table->set_empty("&nbsp;");
            $this->table->set_heading('No', 'Kode Penyebab', 'Nama Penyebab', 'Actions');

            $i = 0 + $offset;

            foreach ($penyebab as $row) {
                $this->table->add_row(++$i, $row->kd_penyebab, $row->nm_penyebab, anchor('penyebab/update/' . $row->kd_penyebab, 'update', array('class' => 'update')) . ' ' .
                    anchor('penyebab/delete/' . $row->kd_penyebab, 'hapus', array('class' => 'delete', 'onclick' => "return confirm('Anda yakin akan menghapus data ini?')"))
                );
            }
            $data['table'] = $this->table->generate();
        } else {
            $data['message'] = 'Tidak ditemukan satupun data penyebab!';
        }

        $data['link'] = array('link_add' => anchor('penyebab/add/', 'tambah data', array('class' => 'add'))
        );

        // Load view
        $this->load->view('template', $data);
    }

    function delete($kd_penyebab) {
        $this->penyakit_model->delete($kd_penyebab);
        $this->session->set_flashdata('message', '1 data penyebab berhasil dihapus');

        redirect('penyebab');
    }

    function add() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyebab > Tambah Data';
        $data['main_view'] = 'penyebab/penyebab_form';
        $data['form_action'] = site_url('penyebab/add_process');
        $data['link'] = array('link_back' => anchor('penyebab', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function add_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyebab > Tambah Data';
        $data['main_view'] = 'penyebab/penyebab_form';
        $data['form_action'] = site_url('penyebab/add_process');
        $data['link'] = array('link_back' => anchor('penyebab', 'kembali', array('class' => 'back'))
        );

        // Set validation rules
        $this->form_validation->set_rules('kd_penyebab', 'kd_penyebab', 'required');
        $this->form_validation->set_rules('nm_penyebab', 'nm_penyebab', 'required');

        if ($this->form_validation->run() == TRUE) {
            $penyebab = array('kd_penyebab' => $this->input->post('kd_penyebab'), 'nm_penyebab' => $this->input->post('nm_penyebab'));

            // Proses simpan data penyebab
            $this->penyebab_model->add($penyebab);

            $this->session->set_flashdata('message', 'Satu data penyebab berhasil disimpan!');
            redirect('penyebab/add');
        } else {
            $this->load->view('template', $data);
        }
    }

    function update($id) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyebab > Update';
        $data['main_view'] = 'penyebab/penyebab_form';
        $data['form_action'] = site_url('penyebab/update_process');
        $data['link'] = array('link_back' => anchor('penyebab', 'kembali', array('class' => 'back'))
        );

        // cari data dari database
        $penyebab = $this->penyebab_model->get_penyebab_by_id($kd_penyebab);

        // buat session untuk menyimpan data primary key
        $this->session->set_userdata('kd_penyebab', $penyebab->kd_penyebab);

        // Data untuk mengisi field2 form
        $data['default']['kd_penyebab'] = $penyebab->kd_penyebab;
        $data['default']['nm_penyebab'] = $penyebab->nm_penyebab;

        $this->load->view('template', $data);
    }

    function update_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyebab > Update';
        $data['main_view'] = 'penyebab/penyebab_form';
        $data['form_action'] = site_url('penyebab/update_process');
        $data['link'] = array('link_back' => anchor('penyebab', 'kembali', array('class' => 'back'))
        );

        // Set validation rules
        $this->form_validation->set_rules('kd_penyebab', 'kd_penyebab', 'required');
        $this->form_validation->set_rules('nm_penyebab', 'nm_penyebab', 'required');

        if ($this->form_validation->run() == TRUE) {

            $penyebab = array('kd_penyebab' => $this->input->post('kd_penyebab'), 'nm_penyebab' => $this->input->post('nm_penyebab'));

            $this->penyebab_model->update($this->session->userdata('kd_penyebab'), $penyebab);

            // set pesan
            $this->session->set_flashdata('message', 'Satu data penyebab berhasil diupdate!');
            redirect('penyebab');
        } else {
            $this->load->view('template', $data);
        }
    }

}

?>
