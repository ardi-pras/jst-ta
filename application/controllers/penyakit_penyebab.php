<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class penyakit_penyebab extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('penyakit_penyebab_model');
    }

    var $limit = 10;
    var $title = 'Penyakit dan Penyebab';

    function index() {
        $this->session->unset_userdata('kd_penyakit');

        if ($this->session->userdata('login') == TRUE) {
            $this->get_all();
        } else {
            redirect('login');
        }
    }

    function get_all($offset = 0) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Penyebab';
        $data['main_view'] = 'penyakit_penyebab/penyakit_penyebab';

        // Offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        // Load data dari tabel penyakit dan penyebab
        $penyakit_penyebab = $this->penyakit_penyebab_model->get_last_ten_penyakit_penyebab($this->limit, $offset);
        $num_rows = $this->penyakit_penyebab_model->count_all_num_rows();

        if($num_rows > 0) {
        // Generate pagination
            $config['base_url'] = site_url('penyakit_penyebab/get_all');
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
            $this->table->set_heading('No', 'Nama Penyakit', 'Nama Penyebab', 'Actions');
            $i = 0 + $offset;

            foreach ($penyakit_penyebab as $row) {
                $this->table->add_row(++$i, $row->nm_penyakit, $row->nm_penyebab, anchor('penyakit_penyebab/update/' . $row->kd_penyakit, 'update', array('class' => 'update')) . ' ' .
                    anchor('penyakit_penyebab/delete/' . $row->kd_penyakit, 'hapus', array('class' => 'delete', 'onclick' => "return confirm('Anda yakin akan menghapus data ini?')"))
                );
            }
            $data['table'] = $this->table->generate();
        }else {
            $data['message'] = 'Tidak ditemukan satupun data penyakit dan penyebab!';
        }
        $data['link'] = array('link_add' => anchor('penyakit_penyebab/add/', 'tambah data', array('class' => 'add'))
        );

        // Load view
        $this->load->view('template', $data);
    }

    function delete($kd_penyakit) {
        $this->penyakit_penyebab_model->delete($kd_penyakit);
        $this->session->set_flashdata('message', '1 data penyakit dan penyebab berhasil dihapus');

        redirect('penyakit_penyebab');
    }

    function add() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Penyebab -> Tambah Data';
        $data['main_view'] = 'penyakit_penyebab/penyakit_penyebab_form';
        $data['form_action'] = site_url('penyakit_penyebab/add_process');
        $data['link'] = array('link_back' => anchor('penyakit_penyebab', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function add_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Penyebab -> Tambah Data';
        $data['main_view'] = 'penyakit_penyebab/penyakit_penyebab_form';
        $data['form_action'] = site_url('penyakit_penyebab/add_process');
        $data['link'] = array('link_back' => anchor('penyakit_penyebab', 'kembali', array('class' => 'back'))
        );

        $this->form_validation->set_rules('nm_penyakit','nm_penyakit','required');
        $this->form_validation->set_rules('nm_penyebab','nm_penyebab','required');

        if($this->form_validation->run() == TRUE) {
            $nm_penyakit = $this->input->post('nm_penyakit');
            $nm_penyebab = $this->input->post('nm_penyebab');
            $penyakit = $this->penyakit_penyebab_model->get_kd_penyakit($nm_penyakit);
            $penyebab = $this->penyakit_penyebab_model->get_kd_penyebab($nm_penyebab);

            $penyebab_penyakit = array(
                'kd_penyakit' => $penyakit->kd_penyakit,
                'kd_penyebab' => $penyebab->kd_penyebab
            );

            $this->penyakit_penyebab_model->add($penyebab_penyakit);

            $this->session->set_flashdata('message', 'Satu data penyakit dan penyebab berhasil disimpan!');
            redirect('penyakit_penyebab/add');
        }else {
            $this->load->view('template', $data);
        }
    }

    function update($kd_penyakit) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Solusi > Update';
        $data['main_view'] = 'penyakit_penyebab/penyakit_penyebab_form';
        $data['form_action'] = site_url('penyakit_penyebab/update_process');
        $data['link'] = array('link_back' => anchor('penyakit_penyebab', 'kembali', array('class' => 'back'))
        );

        // cari data dari database
        $penyakit_penyebab = $this->penyakit_penyebab_model->get_penyakit_penyebab_by_id($kd_penyakit);

        // buat session untuk menyimpan data primary key
        $this->session->set_userdata('kd_penyakit', $penyakit_penyebab->kd_penyakit);

        // Data untuk mengisi field2 form
        $data['default']['nm_penyakit'] = $penyakit_penyebab->nm_penyakit;
        $data['default']['nm_penyebab'] = $penyakit_penyebab->nm_penyebab;

        $this->load->view('template', $data);
    }

    function update_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Penyebab > Update';
        $data['main_view'] = 'penyakit_penyebab/penyakit_penyebab_form';
        $data['form_action'] = site_url('penyakit_penyebab/update_process');
        $data['link'] = array('link_back' => anchor('penyakit_penyebab', 'kembali', array('class' => 'back'))
        );

        $this->form_validation->set_rules('nm_penyakit','nm_penyakit','required');
        $this->form_validation->set_rules('nm_penyebab','nm_penyebab','required');

        if ($this->form_validation->run() == TRUE) {

            $nm_penyakit = $this->input->post('nm_penyakit');
            $nm_penyebab = $this->input->post('nm_penyebab');
            $penyakit = $this->penyakit_penyebab_model->get_kd_penyakit($nm_penyakit);
            $penyebab = $this->penyakit_penyebab_model->get_kd_penyebab($nm_penyebab);

            $penyebab_penyakit = array(
                'kd_penyakit' => $penyakit->kd_penyakit,
                'kd_penyebab' => $penyebab->kd_penyebab,
                'nm_penyebab' => $nm_penyebab
            );

            $this->penyakit_penyebab_model->update($this->session->userdata('kd_penyakit'), $penyebab_penyakit);

            // set pesan
            $this->session->set_flashdata('message', 'Satu data penyakit dan penyebab berhasil diupdate!');
            redirect('penyakit_penyebab');
        } else {
            $this->load->view('template', $data);
        }
    }
}
?>
