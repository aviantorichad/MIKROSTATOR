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

        $this->form_validation->set_rules('_username', 'Username', 'required');
        $this->form_validation->set_rules('_password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            $_username = $this->input->post('_username');
            $_password = $this->input->post('_password');

            
            $myfile = file_get_contents($this->mikrostator_login_file_db());
            if($myfile) {
                $myfile = json_decode($myfile, true);
                for ($i=0;$i < count($myfile); $i++){
                    $username = $myfile[$i]['username'];
                    $password = $myfile[$i]['password'];
                    if($username == $_username && $password == $_password) {
                        $array = $myfile[$i];
                        // $result['ok'] = true;
                        // $result['msg'] = $array;

                        $sessionData['user_username'] = $username;
                        $sessionData['is_login'] = TRUE;
                        $this->session->set_userdata($sessionData);

                        if(isset($_SESSION['ref_url'])){
                            $ref = $_SESSION['ref_url'];
                        } else {
                            $ref = site_url();
                        }
                                
                        redirect($ref);
                    } else {
                        // $result['ok'] = false;
                        // $result['msg'] = 'no data';
                        $this->session->set_flashdata('message', $this->rich_model->show_msg_danger('Username or Password not valid.'));
                    }
                }
            } else {
                // $result['ok'] = false;
                // $result['msg'] = 'Fail to load DB. Maybe file permission issue.';            
                $this->session->set_flashdata('message', $this->rich_model->show_msg_danger('Fail to load DB. Maybe file permission issue.'));
            }
        } else {
            // $result['ok'] = false;
            // $result['msg'] = 'no data';
            // $this->session->set_flashdata('message', $this->rich_model->show_msg_danger('Username or Password not valid.'));
        }

        
        $this->load->view('login', $data);
    }

    private function mikrostator_login_file_db() {
        // return "./db/login_mikrotik.json";
        return "./system/database/login_mikrostator.json";
    }

    // public function get_login_by_id_from_file() {
    //     $_username = $this->input->post('_username');
    //     $_password = $this->input->post('_password');

    //     $myfile = file_get_contents($this->mikrostator_login_file_db());
    //     if($myfile) {
    //         $myfile = json_decode($myfile, true);
    //         for ($i=0;$i < count($myfile); $i++){
    //             $username = $myfile[$i]['username'];
    //             $password = $myfile[$i]['password'];
    //             if($username == $_username && $password == $_password) {
    //                 $array = $myfile[$i];
    //                 $result['ok'] = true;
    //                 $result['msg'] = $array;
    //             } else {
    //                 $result['ok'] = false;
    //                 $result['msg'] = 'no data';
    //             }
    //         }
    //     } else {
    //         $result['ok'] = false;
    //         $result['msg'] = 'Fail to load DB. Maybe file permission issue.';            
    //     }
        
    //     echo json_encode($result, JSON_PRETTY_PRINT);
    // }


}
