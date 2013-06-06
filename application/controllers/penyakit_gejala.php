<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class penyakit_gejala extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('penyakit_gejala_model');
    }

    var $limit = 10;
    var $title = 'Penyakit dan Gejala';

    public function index() {
        $this->session->unset_userdata('kd_penyakit');

        if ($this->session->userdata('login') == TRUE) {
            $this->get_all();
        } else {
            redirect('login');
        }
    }

    function get_all($offset = 0) {

    //pemberian title halaman penyakit dan gejala
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Gejala';
        $data['main_view'] = 'penyakit_gejala/penyakit_gejala';

        // Offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        // Load data dari tabel penyakit dan gejala
        $penyakit_gejala = $this->penyakit_gejala_model->get_last_ten_penyakit_gejala($this->limit, $offset);
        $num_rows = $this->penyakit_gejala_model->count_all_num_rows();

        if($num_rows > 0) {
        // Generate pagination
            $config['base_url'] = site_url('penyakit_gejala/get_all');
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
            $this->table->set_heading('No', 'Nama Penyakit', 'Nama Gejala', 'Actions');
            $i = 0 + $offset;

            foreach($penyakit_gejala as $row) {
                $this->table->add_row(++$i, $row->nm_penyakit, $row->nm_gejala, anchor('penyakit_gejala/update/' . $row->kd_penyakit, 'update', array('class' => 'update')) . ' ' .
                    anchor('penyakit_gejala/delete/' . $row->kd_penyakit, 'hapus', array('class' => 'delete', 'onclick' => "return confirm('Anda yakin akan menghapus data ini?')"))
                );
            }
            $data['table'] = $this->table->generate();
        }else {
            $data['message'] = 'Tidak ditemukan satupun data penyakit dan gejala!';
        }

        $data['link'] = array('link_add' => anchor('penyakit_gejala/add/', 'tambah data', array('class' => 'add'))
        );

        // Load view
        $this->load->view('template', $data);
    }

    function delete($kd_penyakit) {
        $this->penyakit_gejala_model->delete($kd_penyakit);
        $this->session->set_flashdata('message', '1 data penyakit dan gejala berhasil dihapus');

        redirect('penyakit_gejala');
    }

    function add() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Gejala > Tambah Data';
        $data['main_view'] = 'penyakit_gejala/penyakit_gejala_form';
        $data['form_action'] = site_url('penyakit_gejala/add_process');
        $data['link'] = array('link_back' => anchor('penyakit_gejala', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function add_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Gejala > Tambah Data';
        $data['main_view'] = 'penyakit_gejala/penyakit_gejala_form';
        $data['form_action'] = site_url('penyakit_gejala/add_process');
        $data['link'] = array('link_back' => anchor('penyakit_gejala', 'kembali', array('class' => 'back'))
        );

        // Set validation rules
        $this->form_validation->set_rules('nm_penyakit', 'nm_penyakit', 'required');
        $this->form_validation->set_rules('nm_gejala', 'nm_gejala', 'required');

        if ($this->form_validation->run() == TRUE) {

            $nm_penyakit = $this->input->post('nm_penyakit');
            $nm_gejala = $this->input->post('nm_gejala');

            $penyakit = $this->penyakit_gejala_model->get_kd_penyakit($nm_penyakit);
            $gejala = $this->penyakit_gejala_model->get_kd_gejala($nm_gejala);

            $penyakit_gejala = array('kd_penyakit' => $penyakit->kd_penyakit,
                'kd_gejala' => $gejala->kd_gejala, 'nm_gejala' => $nm_gejala);

            // Proses simpan data penyakit dan gejala
            $this->penyakit_gejala_model->add($penyakit_gejala);

            $this->session->set_flashdata('message', 'Satu data penyakit dan gejala berhasil disimpan!');
            redirect('penyakit_gejala/add');
        } else {
            $this->load->view('template', $data);
        }
    }

    function update($kd_penyakit) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Gejala > Update';
        $data['main_view'] = 'penyakit_gejala/penyakit_gejala_form';
        $data['form_action'] = site_url('penyakit_gejala/update_process');
        $data['link'] = array('link_back' => anchor('penyakit_gejala', 'kembali', array('class' => 'back'))
        );

        // cari data dari database
        $penyakit_gejala = $this->penyakit_gejala_model->get_penyakit_gejala_by_id($kd_penyakit);

        // buat session untuk menyimpan data primary key
        $this->session->set_userdata('kd_penyakit', $penyakit_gejala->kd_penyakit);

        // Data untuk mengisi field2 form
        $data['default']['nm_penyakit'] = $penyakit_gejala->nm_penyakit;
        $data['default']['nm_gejala'] = $penyakit_gejala->nm_gejala;

        $this->load->view('template', $data);
    }

    function update_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Gejala > Update';
        $data['main_view'] = 'penyakit_gejala/penyakit_gejala_form';
        $data['form_action'] = site_url('penyakit_gejala/update_process');
        $data['link'] = array('link_back' => anchor('penyakit_gejala', 'kembali', array('class' => 'back'))
        );

        // Set validation rules
        $this->form_validation->set_rules('nm_penyakit', 'nm_penyakit', 'required');
        $this->form_validation->set_rules('nm_gejala', 'nm_gejala', 'required');

        if ($this->form_validation->run() == TRUE) {

            $nm_penyakit = $this->input->post('nm_penyakit');
            $nm_gejala = $this->input->post('nm_gejala');

            $penyakit = $this->penyakit_gejala_model->get_kd_penyakit($nm_penyakit);
            $gejala = $this->penyakit_gejala_model->get_kd_gejala($nm_gejala);

            $penyakit_gejala = array('kd_penyakit' => $penyakit->kd_penyakit,
                'kd_gejala' => $gejala->kd_gejala, 'nm_gejala' => $nm_gejala);

            $this->penyakit_gejala_model->update($this->session->userdata('kd_penyakit'), $penyakit_gejala);

            // set pesan
            $this->session->set_flashdata('message', 'Satu data penyakit dan gejala berhasil diupdate!');
            redirect('penyakit_gejala');
        } else {
            $this->load->view('template', $data);
        }
    }

}

?>
