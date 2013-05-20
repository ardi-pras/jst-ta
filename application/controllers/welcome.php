<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
    }

    var $limit = 10;
    var $title = 'penyakit';

    public function index() {
        $this->get_all();
    }

    function get_all($offset = 0) {

        //pemberian title halaman penyakit
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit';
        $data['main_view'] = 'penyakit/penyakit';

        // Offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $num_rows = 10;

        // Generate pagination			
        $config['base_url'] = site_url('welcome/get_all');
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
        $i = 1;

        $this->table->add_row($i, 'P0111', 'Jerawat', anchor('welcome/update/' . $i, 'update', array('class' => 'update')) . ' ' .
                anchor('welcome/delete/' . $i, 'hapus', array('class' => 'delete', 'onclick' => "return confirm('Anda yakin akan menghapus data ini?')"))
        );
        $data['table'] = $this->table->generate();

        $data['link'] = array('link_add' => anchor('welcome/add/', 'tambah data', array('class' => 'add'))
        );

        // Load view
        $this->load->view('template', $data);
    }

    function add() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit > Tambah Data';
        $data['main_view'] = 'penyakit/penyakit_form';
        $data['form_action'] = site_url('siswa/add_process');
        $data['link'] = array('link_back' => anchor('welcome', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function add_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit > Tambah Data';
        $data['main_view'] = 'penyakit/penyakit_form';
        $data['form_action'] = site_url('welcome/add_process');
        $data['link'] = array('link_back' => anchor('welcome', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function update($id) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit > Update';
        $data['main_view'] = 'penyakit/penyakit_form';
        $data['form_action'] = site_url('welcome/update_process');
        $data['link'] = array('link_back' => anchor('welcome', 'kembali', array('class' => 'back'))
        );

        $this->load->view('template', $data);
    }

    function update_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Penyakit > Update';
        $data['main_view'] = 'penyakit/penyakit_form';
        $data['form_action'] = site_url('welcome/update_process');
        $data['link'] = array('link_back' => anchor('welcome', 'kembali', array('class' => 'back'))
        );
        $this->load->view('template', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */