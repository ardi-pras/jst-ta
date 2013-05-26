<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Gejala extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('gejala_model');
    }

    var $limit = 10;
    var $title = 'gejala';

    public function index() {
        $this->session->unset_userdata('kd_gejala');

        if ($this->session->userdata('login') == TRUE) {
            $this->get_all();
        } else {
            redirect('login');
        }
    }

    function get_all($offset = 0) {

    //pemberian title halaman gejala
        $data['title'] = $this->title;
        $data['h2_title'] = 'Gejala';
        $data['main_view'] = 'gejala/gejala';

        // Offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        // Load data dari tabel gejala
        $gejala = $this->gejala_model->get_last_ten_gejala($this->limit, $offset);
        $num_rows = $this->gejala_model->count_all_num_rows();

        if ($num_rows > 0) {

        // Generate pagination
            $config['base_url'] = site_url('gejala/get_all');
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
            $this->table->set_heading('No', 'Kode Gejala', 'Nama Gejala', 'Actions');

            // Penomoran baris data
            $i = 0 + $offset;

            foreach ($gejala as $row) {
                $this->table->add_row(++$i, $row->kd_gejala, $row->nm_gejala, anchor('gejala/update/' . $row->kd_gejala, 'update', array('class' => 'update')) . ' ' .
                    anchor('gejala/delete/' . $row->kd_gejala, 'hapus', array('class' => 'delete', 'onclick' => "return confirm('Anda yakin akan menghapus data ini?')"))
                );
            }
            $data['table'] = $this->table->generate();
        } else {
            $data['message'] = 'Tidak ditemukan satupun data gejala!';
        }

        $data['link'] = array('link_add' => anchor('gejala/add/', 'tambah data', array('class' => 'add'))
        );

        // Load view
        $this->load->view('template', $data);
    }

    function delete($kd_gejala) {
        $this->gejala_model->delete($kd_gejala);
        $this->session->set_flashdata('message', '1 data gejala berhasil dihapus');

        redirect('gejala');
    }

    function add() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Gejala > Tambah Data';
        $data['main_view'] = 'gejala/gejala_form';
        $data['form_action'] = site_url('gejala/add_process');
        $data['link'] = array('link_back' => anchor('gejala', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function add_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Gejala > Tambah Data';
        $data['main_view'] = 'gejala/gejala_form';
        $data['form_action'] = site_url('gejala/add_process');
        $data['link'] = array('link_back' => anchor('gejala', 'kembali', array('class' => 'back'))
        );

        // Set validation rules
        $this->form_validation->set_rules('kd_gejala', 'kd_gejala', 'required');
        $this->form_validation->set_rules('nm_gejala', 'nm_gejala', 'required');

        if ($this->form_validation->run() == TRUE) {
            $gejala = array('kd_gejala' => $this->input->post('kd_gejala'), 'nm_gejala' => $this->input->post('nm_gejala'));

            // Proses simpan data gejala
            $this->gejala_model->add($gejala);

            $this->session->set_flashdata('message', 'Satu data gejala berhasil disimpan!');
            redirect('gejala/add');
        } else {
            $this->load->view('template', $data);
        }
    }

    function update($kd_gejala) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Gejala > Update';
        $data['main_view'] = 'gejala/gejala_form';
        $data['form_action'] = site_url('gejala/update_process');
        $data['link'] = array('link_back' => anchor('gejala', 'kembali', array('class' => 'back'))
        );

        // cari data dari database
        $gejala = $this->gejala_model->get_gejala_by_id($kd_gejala);

        // buat session untuk menyimpan data primary key
        $this->session->set_userdata('kd_gejala', $gejala->kd_gejala);

        // Data untuk mengisi field2 form
        $data['default']['kd_gejala'] = $gejala->kd_gejala;
        $data['default']['nm_gejala'] = $gejala->nm_gejala;

        $this->load->view('template', $data);
    }

    function update_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Gejala > Update';
        $data['main_view'] = 'gejala/gejala_form';
        $data['form_action'] = site_url('gejala/update_process');
        $data['link'] = array('link_back' => anchor('gejala', 'kembali', array('class' => 'back'))
        );

        // Set validation rules
        $this->form_validation->set_rules('kd_gejala', 'kd_gejala', 'required');
        $this->form_validation->set_rules('nm_gejala', 'nm_gejala', 'required');

        if ($this->form_validation->run() == TRUE) {

            $gejala = array('kd_gejala' => $this->input->post('kd_gejala'), 'nm_gejala' => $this->input->post('nm_gejala'));

            $this->gejala_model->update($this->session->userdata('kd_gejala'), $gejala);

            // set pesan
            $this->session->set_flashdata('message', 'Satu data gejala berhasil diupdate!');
            redirect('gejala');
        } else {
            $this->load->view('template', $data);
        }
    }

}

?>
