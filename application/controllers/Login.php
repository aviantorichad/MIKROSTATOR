<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('rich_model');
    }

    public function index() {
        $data['title'] = 'Login MIKROSTATOR';
//         $data['website'] = $this->rich_model->get_general_config();

//         $this->form_validation->set_rules('username', 'Username', 'required');
//         $this->form_validation->set_rules('password', 'Password', 'required');

//         if ($this->form_validation->run() == TRUE) {
//             $username = $this->input->post('username');
//             $password = $this->input->post('password');

//             $login = $this->user_model->check_login($username, $password);

//             if (!empty($login)) {

//                 $sessionData['user_id'] = $login['id'];
//                 $sessionData['user_username'] = $login['username'];
//                 $sessionData['user_full_name'] = $login['nama'];
//                 $sessionData['user_level'] = $login['level_id'];
//                 $sessionData['is_login'] = TRUE;
//                 $this->session->set_userdata($sessionData);
//                 if(isset($_SESSION['ref_url'])){
//                     $ref = $_SESSION['ref_url'];
//                 } else {
//                     $ref = site_url();
//                 }
                
// //                $this->rich_model->debug_array($ref, true);

//                 redirect($ref);
//             } else {
//                 $this->session->set_flashdata('message', $this->rich_model->show_msg_danger('Username atau Password tidak benar!'));
//             }
//         } else {
//             $this->session->set_flashdata('message', $this->rich_model->show_msg_info('Silakan login terlebih dahulu!'));
//         }
        
        $this->load->view('login', $data);
    }

}
