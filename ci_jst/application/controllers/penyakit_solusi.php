<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Penyakit_Solusi
 *
 * @author ardi
 */
class Penyakit_Solusi extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    var $limit = 10;
    var $title = 'Penyakit dan Solusi';

    public function index() {
        $this->get_all();
    }

    function get_all($offset = 0) {

    //pemberian title halaman penyakit
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Solusi';
        $data['main_view'] = 'penyakit_solusi/penyakit_solusi';

        // Offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $num_rows = 10;

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
        $this->table->set_heading('No', 'Nama Penyakit', 'Kode Solusi', 'Solusi', 'Actions');
        $i = 1;

        $this->table->add_row($i, 'Jerawat', 'P001', 'Mandi', anchor('penyakit_solusi/update/' . $i, 'update', array('class' => 'update')) . ' ' .
            anchor('penyakit_solusi/delete/' . $i, 'hapus', array('class' => 'delete', 'onclick' => "return confirm('Anda yakin akan menghapus data ini?')"))
        );
        $data['table'] = $this->table->generate();

        $data['link'] = array('link_add' => anchor('penyakit_solusi/add/', 'tambah data', array('class' => 'add'))
        );

        // Load view
        $this->load->view('template', $data);
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

        $this->load->view('template', $data);
    }

    function update($id) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Solusi > Update';
        $data['main_view'] = 'penyakit_solusi/penyakit_solusi_form';
        $data['form_action'] = site_url('penyakit_solusi/update_process');
        $data['link'] = array('link_back' => anchor('penyakit_solusi', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function update_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit dan Solusi > Update';
        $data['main_view'] = 'penyakit_solusi/penyakit_solusi_form';
        $data['form_action'] = site_url('penyakit_solusi/update_process');
        $data['link'] = array('link_back' => anchor('penyakit_solusi', 'kembali', array('class' => 'back'))
        );
        $this->load->view('template', $data);
    }
}
?>
