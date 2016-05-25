<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log extends CI_Model {

    function writeLog($msg) {
        $query = $this->db->query("INSERT INTO wk_log(`log_notes`) VALUES('$msg')");
    }

}

/* End of file log.php */
/* Location: ./application/models/log.php */