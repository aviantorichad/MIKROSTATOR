<?php

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(0);
        date_default_timezone_set('Asia/Jakarta');
    }

}

?>
