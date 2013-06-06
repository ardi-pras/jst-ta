<?php

class Penyakit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('penyakit_model');
    }

    var $limit = 10;
    var $title = 'penyakit';

    public function index() {
        $this->session->unset_userdata('kd_penyakit');

        if ($this->session->userdata('login') == TRUE) {
            $this->get_all();
        } else {
            redirect('login');
        }
    }

    function get_all($offset = 0) {

        //pemberian title halaman penyakit
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit';
        $data['main_view'] = 'penyakit/penyakit';

        // Offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);

        // Load data dari tabel penyakit
        $penyakit = $this->penyakit_model->get_last_ten_penyakit($this->limit, $offset);
        $num_rows = $this->penyakit_model->count_all_num_rows();

        if ($num_rows > 0) {
            // Generate pagination			
            $config['base_url'] = site_url('penyakit/get_all');
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
            $this->table->set_heading('No', 'Kode Penyakit', 'Nama Penyakit', 'Actions');

            // Penomoran baris data
            $i = 0 + $offset;

            foreach ($penyakit as $row) {

                $this->table->add_row(++$i, $row->kd_penyakit, $row->nm_penyakit, anchor('penyakit/update/' . $row->kd_penyakit, 'update', array('class' => 'update')) . ' ' .
                        anchor('penyakit/delete/' . $row->kd_penyakit, 'hapus', array('class' => 'delete', 'onclick' => "return confirm('Anda yakin akan menghapus data ini?')"))
                );
            }
            $data['table'] = $this->table->generate();
        } else {
            $data['message'] = 'Tidak ditemukan satupun data penyakit!';
        }


        $data['link'] = array('link_add' => anchor('penyakit/add/', 'tambah data', array('class' => 'add'))
        );

        // Load view
        $this->load->view('template', $data);
    }

    function delete($kd_penyakit) {
        $this->penyakit_model->delete($kd_penyakit);
        $this->session->set_flashdata('message', '1 data penyakit berhasil dihapus');

        redirect('penyakit');
    }

    function add() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit > Tambah Data';
        $data['main_view'] = 'penyakit/penyakit_form';
        $data['form_action'] = site_url('penyakit/add_process');
        $data['link'] = array('link_back' => anchor('penyakit/', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function add_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit > Tambah Data';
        $data['main_view'] = 'penyakit/penyakit_form';
        $data['form_action'] = site_url('penyakit/add_process');
        $data['link'] = array('link_back' => anchor('penyakit', 'kembali', array('class' => 'back'))
        );

        // Set validation rules
        $this->form_validation->set_rules('kd_penyakit', 'kd_penyakit', 'required');
        $this->form_validation->set_rules('nm_penyakit', 'nm_penyakit', 'required');

        if ($this->form_validation->run() == TRUE) {
            $penyakit = array('kd_penyakit' => $this->input->post('kd_penyakit'), 'nm_penyakit' => $this->input->post('nm_penyakit'));

            // Proses simpan data penyakit
            $this->penyakit_model->add($penyakit);

            $this->session->set_flashdata('message', 'Satu data penyakit berhasil disimpan!');
            redirect('penyakit/add');
        } else {
            $this->load->view('template', $data);
        }
    }

    function update($kd_penyakit) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit > Update';
        $data['main_view'] = 'penyakit/penyakit_form';
        $data['form_action'] = site_url('penyakit/update_process');
        $data['link'] = array('link_back' => anchor('penyakit', 'kembali', array('class' => 'back'))
        );

        // cari data dari database
        $penyakit = $this->penyakit_model->get_penyakit_by_id($kd_penyakit);

        // buat session untuk menyimpan data primary key 
        $this->session->set_userdata('kd_penyakit', $penyakit->kd_penyakit);

        // Data untuk mengisi field2 form
        $data['default']['kd_penyakit'] = $penyakit->kd_penyakit;
        $data['default']['nm_penyakit'] = $penyakit->nm_penyakit;

        $this->load->view('template', $data);
    }

    function update_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit > Update';
        $data['main_view'] = 'penyakit/penyakit_form';
        $data['form_action'] = site_url('penyakit/update_process');
        $data['link'] = array('link_back' => anchor('penyakit', 'kembali', array('class' => 'back'))
        );

        // Set validation rules
        $this->form_validation->set_rules('kd_penyakit', 'kd_penyakit', 'required');
        $this->form_validation->set_rules('nm_penyakit', 'nm_penyakit', 'required');

        if ($this->form_validation->run() == TRUE) {

            $penyakit = array('kd_penyakit' => $this->input->post('kd_penyakit'), 'nm_penyakit' => $this->input->post('nm_penyakit'));

            $this->penyakit_model->update($this->session->userdata('kd_penyakit'), $penyakit);

            // set pesan
            $this->session->set_flashdata('message', 'Satu data penyakit berhasil diupdate!');
            redirect('penyakit');
        } else {
            $this->load->view('template', $data);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */