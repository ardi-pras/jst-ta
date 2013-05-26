<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_model');
    }

    function index() {
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
                redirect('login/index');
            }
        } else {
            $this->load->view('login/login');
        }
    }

    function process_logout() {
        $this->session->sess_destroy();
        redirect('login', 'refresh');
    }

}

?>
