<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Solusi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('solusi_model');
    }

    var $limit = 10;
    var $title = 'Solusi';

    public function index() {
        $this->session->unset_userdata('kd_solusi');

        if ($this->session->userdata('login') == TRUE) {
            $this->get_all();
        } else {
            redirect('login');
        }
    }

    function get_all($offset = 0) {

    //pemberian title halaman solusi
        $data['title'] = $this->title;
        $data['h2_title'] = 'Solusi';
        $data['main_view'] = 'solusi/solusi';

        // Offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        // Load data dari tabel solusi
        $solusi = $this->solusi_model->get_last_ten_solusi($this->limit, $offset);
        $num_rows = $this->solusi_model->count_all_num_rows();

        if ($num_rows > 0) {
        // Generate pagination
            $config['base_url'] = site_url('solusi/get_all');
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
            $this->table->set_heading('No', 'Kode Solusi', 'Solusi', 'Actions');
            $i = 0 + $offset;

            foreach ($solusi as $row) {
                $this->table->add_row(++$i, $row->kd_solusi, $row->nm_solusi, anchor('solusi/update/' . $row->kd_solusi, 'update', array('class' => 'update')) . ' ' .
                    anchor('solusi/delete/' . $row->kd_solusi, 'hapus', array('class' => 'delete', 'onclick' => "return confirm('Anda yakin akan menghapus data ini?')"))
                );
            }
            $data['table'] = $this->table->generate();
        } else {
            $data['message'] = 'Tidak ditemukan satupun data solusi!';
        }

        $data['link'] = array('link_add' => anchor('solusi/add/', 'tambah data', array('class' => 'add'))
        );

        // Load view
        $this->load->view('template', $data);
    }

    function delete($kd_solusi) {
        $this->penyakit_model->delete($kd_solusi);
        $this->session->set_flashdata('message', '1 data solusi berhasil dihapus');

        redirect('solusi');
    }

    function add() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Solusi > Tambah Data';
        $data['main_view'] = 'solusi/solusi_form';
        $data['form_action'] = site_url('solusi/add_process');
        $data['link'] = array('link_back' => anchor('solusi', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function add_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Solusi > Tambah Data';
        $data['main_view'] = 'solusi/solusi_form';
        $data['form_action'] = site_url('solusi/add_process');
        $data['link'] = array('link_back' => anchor('solusi', 'kembali', array('class' => 'back'))
        );

        // Set validation rules
        $this->form_validation->set_rules('kd_solusi', 'kd_solusi', 'required');
        $this->form_validation->set_rules('nm_solusi', 'nm_solusi', 'required');

        if ($this->form_validation->run() == TRUE) {
            $solusi = array('kd_solusi' => $this->input->post('kd_solusi'), 'nm_solusi' => $this->input->post('nm_solusi'));

            // Proses simpan data solusi
            $this->solusi_model->add($solusi);

            $this->session->set_flashdata('message', 'Satu data solusi berhasil disimpan!');
            redirect('solusi/add');
        } else {
            $this->load->view('template', $data);
        }
    }

    function update($kd_solusi) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Solusi > Update';
        $data['main_view'] = 'solusi/solusi_form';
        $data['form_action'] = site_url('solusi/update_process');
        $data['link'] = array('link_back' => anchor('solusi', 'kembali', array('class' => 'back'))
        );

        // cari data dari database
        $solusi = $this->solusi_model->get_solusi_by_id($kd_solusi);

        // buat session untuk menyimpan data primary key
        $this->session->set_userdata('kd_solusi', $solusi->kd_solusi);

        // Data untuk mengisi field2 form
        $data['default']['kd_solusi'] = $solusi->kd_solusi;
        $data['default']['nm_solusi'] = $solusi->nm_solusi;

        $this->load->view('template', $data);
    }

    function update_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Solusi > Update';
        $data['main_view'] = 'solusi/solusi_form';
        $data['form_action'] = site_url('solusi/update_process');
        $data['link'] = array('link_back' => anchor('solusi', 'kembali', array('class' => 'back'))
        );

        // Set validation rules
        $this->form_validation->set_rules('kd_solusi', 'kd_solusi', 'required');
        $this->form_validation->set_rules('nm_solusi', 'nm_solusi', 'required');

        if ($this->form_validation->run() == TRUE) {

            $solusi = array('kd_solusi' => $this->input->post('kd_solusi'), 'nm_solusi' => $this->input->post('nm_solusi'));

            $this->solusi_model->update($this->session->userdata('kd_solusi'), $solusi);

            // set pesan
            $this->session->set_flashdata('message', 'Satu data solusi berhasil diupdate!');
            redirect('solusi');
        } else {
            $this->load->view('template', $data);
        }
    }

}

?>
