<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user');
        $this->load->model('log');
        $this->load->model('stator');

        if ($this->session->userdata('is_login') == TRUE) {
            redirect('home');
        }
    }

    public function index() {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        //$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');

        if ($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $login = $this->user->checkLogin($username, $password);

            if (!empty($login)) {

                foreach ($this->stator->getConfigStator() as $row) {
                    $config_mt_host = $row->config_mt_host;
                    $config_mt_username = $row->config_mt_username;
                    $config_mt_password = $row->config_mt_password;
                    $config_mt_port = $row->config_mt_port;
                    $config_interval = $row->config_wk_interval;
                    $config_autobackup = $row->config_wk_autobackup;
                }
                $this->mikrostator->set('host', $config_mt_host);
                $this->mikrostator->set('port', $config_mt_port);
                $this->mikrostator->set('username', $config_mt_username);
                $this->mikrostator->set('password', $config_mt_password);
                $this->mikrostator->set('debug', FALSE);
                $this->mikrostator->set('attempts', 3);
                $this->mikrostator->set('delay', 2);
                $this->mikrostator->set('timeout', 2);
                $this->mikrostator->set('interval', $config_interval  * 1000); //auto refresh; //interval masih dalam detik sehingga dikali 1000 untuk menghasilkan milidetik
                $this->mikrostator->set('is_configured', TRUE);
                $this->mikrostator->set('autobackup', $config_autobackup);

                $sessionData['member_id'] = $login['member_id'];
                $sessionData['username'] = $login['member_username'];
                $sessionData['name'] = $login['member_name'];
                $sessionData['is_login'] = TRUE;
                $this->session->set_userdata($sessionData);

                $this->user->updateLastLogin($login['member_id']);
                $this->log->writeLog($login['member_username'] . ' BERHASIL MASUK via ' . $ipaddress);

                if ($this->mikrostator->cekKoneksiRouter()) {
                    redirect('home');
                } else {
                    $this->session->set_flashdata('message', 'Login Router belum dikonfigurasi dengan benar.');
                    redirect('setting/login_router');
                }
            } else {
                $this->session->set_flashdata('message', 'Username atau Password tidak benar');
            }
            $this->log->writeLog($login['member_username'] . ' GAGAL MASUK via ' . $ipaddress);
        } else {
            $this->session->set_flashdata('message', 'Kamu harus login untuk mengakses halaman admin.');
        }
        $this->load->view('login');
    }

}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */