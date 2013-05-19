<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gejala
 *
 * @author ardi
 */
class Gejala extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    var $limit = 10;
    var $title = 'gejala';
    
    public function index() {
        $this->get_all();
    }
    
    function get_all($offset = 0) {
    
    //pemberian title halaman penyakit
        $data['title'] = $this->title;
        $data['h2_title'] = 'Gejala';
        $data['main_view'] = 'gejala/gejala';
        
        // Offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $num_rows = 10;
        
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
        $i = 1;
        
        $this->table->add_row($i, 'P0111', 'gatal-gatal', anchor('gejala/update/' . $i, 'update', array('class' => 'update')) . ' ' .
            anchor('gejala/delete/' . $i, 'hapus', array('class' => 'delete', 'onclick' => "return confirm('Anda yakin akan menghapus data ini?')"))
        );
        $data['table'] = $this->table->generate();
        
        $data['link'] = array('link_add' => anchor('gejala/add/', 'tambah data', array('class' => 'add'))
        );
        
        // Load view
        $this->load->view('template', $data);
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
        
        $this->load->view('template', $data);
    }
    
    function update($id) {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Gejala > Update';
        $data['main_view'] = 'gejala/gejala_form';
        $data['form_action'] = site_url('gejala/update_process');
        $data['link'] = array('link_back' => anchor('gejala', 'kembali', array('class' => 'back'))
        );
        
        $this->load->view('template', $data);
    }
    
    function update_process() {
        $data['title'] = $this->title;
        $data['h2_title'] = 'Gejala > Update';
        $data['main_view'] = 'gejala/gejala_form';
        $data['form_action'] = site_url('gejala/update_process');
        $data['link'] = array('link_back' => anchor('gejala', 'kembali', array('class' => 'back'))
        );
        $this->load->view('template', $data);
    }

}
?>
