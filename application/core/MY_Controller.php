<?php

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

}

class Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('is_login') == FALSE) {
            $this->session->set_flashdata('message', 'Kamu harus login untuk mengakses halaman admin.');
            redirect('login');
        }
    }
}

?>
