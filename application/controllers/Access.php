<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
    }

    public function index()
    {

        if ($this->session->userdata('logged') == true) {
            redirect(base_url() . 'index.php/home');
        } else {
            $this->load->view('layout/login');
        }
    }

    public function login()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $remember = $this->input->post('remember');
        $password = md5($password);

        $query = $this->db->query("SELECT * FROM users WHERE user_email = '$email' AND user_password = '$password' LIMIT 1");

        if ($query->num_rows() > 0) {
            $this->session->set_userdata('logged', true);

            $user = $query->row_array();
            $this->session->set_userdata('user_session', $user);

            if ($remember == "true") {
                set_cookie("logged", json_encode(array('email' => $email, 'password' => $password)));
            }

            redirect(base_url() . 'index.php/home');
        } else {
            $data['error'] = 'You have wrong email or password!';
            $this->load->view('layout/login', $data);
        }

    }

    public function logout($board_id = null)
    {

        $this->session->sess_destroy();
        $this->index();

    }


}
