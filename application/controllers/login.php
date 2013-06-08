<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Login extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
	$this->load->library('../controllers/pembelajaran');
    }
	
    public function index() {
        if ($this->session->userdata('login') == TRUE) {
            redirect('penyakit');
        } else {
		/*Set default data*/
		$save_data = $this->pembelajaran->loadFromDatabase();
		$data['error_control'] = $save_data['error'];
		/*Set default data*/
	
		$data['title'] = 'Diagnosa';
		$data['gejala'] = $this->db->get('gejala');
		$data['h2_title'] = 'Pembelajaran';
		$data['main_view'] = 'diagnosa';
		$this->load->view('template_diagnosa', $data);	
        }
    }
    
    public function signin() {
	if ($this->session->userdata('login') == TRUE) {
            redirect('penyakit');
        } else {
		$this->load->view('login');
        }
    }

    function process_login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {

            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($this->login_model->check_user($username, md5($password)) == TRUE) {
                $data = array('username' => $username, 'login' => TRUE);
                $this->session->set_userdata($data);
                redirect('penyakit');
            } else {
                $this->session->set_flashdata('message', 'Maaf, username dan atau password Anda salah');
                redirect('login/signin');
            }
        } else {
            $this->load->view('login/login');
        }
    }

    function process_logout() {
        $this->session->sess_destroy();
	redirect('login/signin', 'refresh');
    }

}

?>
