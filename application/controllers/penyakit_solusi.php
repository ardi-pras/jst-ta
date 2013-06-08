<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Penyakit_Solusi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('penyakit_solusi_model');
	$this->load->model('solusi_model');
    }

    var $limit = 10;
    var $title = 'Penyakit dan Solusi';

    public function index() {
        $this->session->unset_userdata('kd_penyakit');

        if ($this->session->userdata('login') == TRUE) {
            $this->get_all();
        } else {
            redirect('login/signin');
        }
    }

    function get_all($offset = 0) {

    //pemberian title halaman penyakit dan solusi
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Solusi';
        $data['main_view'] = 'penyakit_solusi/penyakit_solusi';

        // Offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        // Load data dari tabel penyakit dan solusi
        $penyakit_solusi = $this->penyakit_solusi_model->get_last_ten_penyakit_solusi($this->limit, $offset);
        $num_rows = $this->penyakit_solusi_model->count_all_num_rows();

        if($num_rows > 0) {
        // Generate pagination
            $config['base_url'] = site_url('penyakit_solusi/get_all');
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
            $this->table->set_heading('No', 'Nama Penyakit', 'Solusi', 'Actions');
            $i = 0 + $offset;

            foreach ($penyakit_solusi as $row) {
                $this->table->add_row(++$i, $row->nm_penyakit, $row->nm_solusi, anchor('penyakit_solusi/update/' . $row->kd_penyakit, 'update', array('class' => 'update')) . ' ' .
                    anchor('penyakit_solusi/delete/' . $row->kd_penyakit, 'hapus', array('class' => 'delete', 'onclick' => "return confirm('Anda yakin akan menghapus data ini?')"))
                );
            }

            $data['table'] = $this->table->generate();
        }else {
            $data['message'] = 'Tidak ditemukan satupun data penyakit dan solusi!';
        }


        $data['link'] = array('link_add' => anchor('penyakit_solusi/add/', 'tambah data', array('class' => 'add'))
        );

        // Load view
        $this->load->view('template', $data);
    }

    function delete($kd_penyakit) {
        $this->penyakit_solusi_model->delete($kd_penyakit);
        $this->session->set_flashdata('message', '1 data penyakit dan solusi berhasil dihapus');

        redirect('penyakit');
    }

    function add() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Solusi > Tambah Data';
        $data['main_view'] = 'penyakit_solusi/penyakit_solusi_form';
        $data['form_action'] = site_url('penyakit_solusi/add_process');
        $data['link'] = array('link_back' => anchor('penyakit_solusi', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function add_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Solusi > Tambah Data';
        $data['main_view'] = 'penyakit_solusi/penyakit_solusi_form';
        $data['form_action'] = site_url('penyakit_solusi/add_process');
        $data['link'] = array('link_back' => anchor('penyakit_solusi', 'kembali', array('class' => 'back'))
        );

        $this->form_validation->set_rules('nm_penyakit','nm_penyakit','required');
        $this->form_validation->set_rules('solusi','solusi','solusi');

        if($this->form_validation->run() == TRUE) {
            $nm_penyakit = $this->input->post('nm_penyakit');
	    $nm_solusi = $this->input->post('solusi');

            $penyakit = $this->penyakit_solusi_model->get_kd_penyakit($nm_penyakit);
	    $solusi = $this->solusi_model->get_kd_solusi($nm_solusi);

            $penyakit_solusi = array('kd_penyakit' => $penyakit->kd_penyakit,
                'kd_solusi' => $solusi->kd_solusi
            );

            $this->penyakit_solusi_model->add($penyakit_solusi);

            $this->session->set_flashdata('message', 'Satu data penyakit dan solusi berhasil disimpan!');
            redirect('penyakit_solusi/add');
        }else {
            $this->load->view('template', $data);
        }
    }

    function update($kd_penyakit) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Solusi > Update';
        $data['main_view'] = 'penyakit_solusi/penyakit_solusi_form';
        $data['form_action'] = site_url('penyakit_solusi/update_process');
        $data['link'] = array('link_back' => anchor('penyakit_solusi', 'kembali', array('class' => 'back'))
        );

        // cari data dari database
        $penyakit_solusi = $this->penyakit_solusi_model->get_penyakit_solusi_by_id($kd_penyakit);

        // buat session untuk menyimpan data primary key
        $this->session->set_userdata('kd_penyakit', $penyakit_solusi->kd_penyakit);

        // Data untuk mengisi field2 form
        $data['default']['nm_penyakit'] = $penyakit_solusi->nm_penyakit;
        $data['default']['kd_gejala'] = $penyakit_solusi->kd_solusi;
        $data['default']['nm_gejala'] = $penyakit_solusi->nm_gejala;

        $this->load->view('template', $data);
    }

    function update_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Solusi > Update';
        $data['main_view'] = 'penyakit_solusi/penyakit_solusi_form';
        $data['form_action'] = site_url('penyakit_solusi/update_process');
        $data['link'] = array('link_back' => anchor('penyakit_solusi', 'kembali', array('class' => 'back'))
        );

        $this->form_validation->set_rules('nm_penyakit','nm_penyakit','required');
        $this->form_validation->set_rules('kd_solusi','kd_solusi','required');
        $this->form_validation->set_rules('solusi','solusi','solusi');

        if ($this->form_validation->run() == TRUE) {

            $nm_penyakit = $this->input->post('nm_penyakit');
            $penyakit = $this->penyakit_solusi_model->get_kd_penyakit($nm_penyakit);

            $penyakit_solusi = array('kd_penyakit' => $penyakit->kd_penyakit,
                'kd_solusi' => $this->input->post('kd_solusi'),
                'nm_solusi' => $this->input->post('solusi')
            );

            $this->penyakit_solusi_model->update($this->session->userdata('kd_penyakit'), $penyakit_solusi);

            // set pesan
            $this->session->set_flashdata('message', 'Satu data penyakit dan solusi berhasil diupdate!');
            redirect('penyakit_solusi');
        } else {
            $this->load->view('template', $data);
        }
    }
}
?>
