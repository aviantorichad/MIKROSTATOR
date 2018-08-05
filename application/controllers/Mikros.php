<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mikros extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('rich_model');
    }

    public function index() {
        $data['title'] = 'MIKROSTATOR';
        echo "kula robot :)";
    }

    public function user_status($id) {

        $myfile = file_get_contents($this->rich_model->mikrostator_file_db());
        if($myfile) {
            $myfile = json_decode($myfile, true);
            if(count($myfile) > 0) {
                $myfile = $myfile[$id];
                $array = $myfile;
                if (count($array) > 0) {
                    $result['ok'] = true;
                    $result['msg'] = $array;
                } else {
                    $result['ok'] = false;
                    $result['msg'] = 'no data';
                }
            } else {
                $result['ok'] = false;
                $result['msg'] = 'no data';
            }
        } else {
            $result['ok'] = false;
            $result['msg'] = 'Fail to load DB. Maybe file permission issue.';            
        }
        
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

}
