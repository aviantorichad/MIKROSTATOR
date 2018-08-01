<?php

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(0);
        date_default_timezone_set('Asia/Jakarta');
    }

}


class Admin_Controller extends MY_Controller {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('is_login') == FALSE) {
            $this->load->model('rich_model');
            $this->session->set_flashdata('message', $this->rich_model->show_msg_info('Please login first.'));

            redirect('login');
        }
    }

}

?>
