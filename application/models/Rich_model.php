<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rich_model extends CI_Model {

    public function get_sessions() {
        // print_r($_SESSION);
        echo"<option value='*'>-- Select Session --</option>";
        if (isset($_SESSION['sessions'])) {
            $array = $_SESSION['sessions'];
            asort($array);
            foreach ($array as $key => $val) {
                echo "<option value='{$key}'>{$val['mikrotik_name']}</option>";
            }
        }
    }

    public function get_mikrotik_sessions() {
        echo"<option value='*'>-- Select Mikrotik --</option>";
        foreach ($this->get_mikrotik_lists() as $val):
            echo '<option value="' . $val['id'] . '">' . $val['mikrotik_name'] . '</option>';
        endforeach;
    }

    public function get_mikrotik_lists() {
        $this->load->database();
        $query = $this->db->get('list_mikrotik');
        return $query->result_array();
    }

    public function get_mikrotik_list_by_id($id = "") {
        $this->load->database();
        $query = $this->db->where('id', $id);
        $query = $this->db->get('list_mikrotik');
        return $query->row_array();
    }

    public function get_session_by_id($session_id, $json = false) {
//         $array = $this->get_mikrotik_list_by_id($session_id);
// //        print_r($array);exit();
//         if (count($array) > 0) {
//             if ($json) {
//                 echo json_encode($array, JSON_PRETTY_PRINT);
//             } else {
//                 return $array;
//             }
//         }

       if (isset($_SESSION['sessions'])) {
           if (isset($_SESSION['sessions'][$session_id])) {
               if ($json) {
                   echo json_encode($_SESSION['sessions'][$session_id], JSON_PRETTY_PRINT);
               } else {
                   return $_SESSION['sessions'][$session_id];
               }
           }
       }
    }

    public function get_logic_label($val = false) {
        return $val == 'true' ? '<small class="label bg-green">' . $val . '</small>' : '<small class="label bg-red">' . $val . '</small>';
    }

    public function debug_array($array, $exit = false) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        $exit ? exit() : '';
    }

    public function make_td_array($array, $th = false, $exit = false) {
        //ref: https://stackoverflow.com/questions/6817262/how-to-display-html-tags-as-plain-text
        echo '<pre>';
        foreach ($array as $key => $val):
            if ($th) {
                echo '&lt;th class="text-nowrap"&gt;' . $key . '&lt;/th&gt;<br/>';
            } else {
                echo '&lt;td class="text-nowrap"&gt;&lt;?=isset($value[\'' . $key . '\'])?$value[\'' . $key . '\']:\'\'?&gt;&lt;/td&gt;<br/>';
            }
        endforeach;
        echo '</pre>';
        $exit ? exit() : '';
    }

    // ref: https://stackoverflow.com/questions/2510434/format-bytes-to-kilobytes-megabytes-gigabytes
    function formatBytes($bytes, $precision = 2) {
        if (!is_numeric($bytes)) {
            return 0;
        }
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    function parse_validity($string = "", $tipe = ""){
        $split = explode('#', $string);
        if(count($split) <= 2) {
            return "";
        }
        switch($tipe) {
            case "validity":
                return $split[1];
                break;
            case "price":
                return $split[2];
                break;
            default:
                return "";
                break;
        }
    }

    function parse_validity_json($string = "", $tipe = ""){
        $split = explode('#', $string);
        if(count($split) <= 2) {
            return "";
        }
        
        return json_decode($split[1], true);
    }

    function show_msg_primary($msg = "") {
        $msg =' <div class="alert alert-primary alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                '.$msg.'
              </div>';
        return $msg;
    }
    
    function show_msg_warning($msg = "") {
        $msg =' <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                '.$msg.'
              </div>';
        return $msg;
    }
    
    function show_msg_danger($msg = "") {
        $msg =' <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                '.$msg.'
              </div>';
        return $msg;
    }
    function show_msg_success($msg = "") {
        $msg =' <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                '.$msg.'
              </div>';
        return $msg;
    }
    function show_msg_info($msg = "") {
        $msg =' <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                '.$msg.'
              </div>';
        return $msg;
    }

    function mikrostator_file_db() {
        return "./system/database/login_mikrotik.json";
    }

    function user_login_file_db() {
        return "./system/database/login_mikrostator.json";
    }

    function mikrostator_template_file_db() {
        // return "./db/login_mikrotik.json";
        return "./system/database/voucher_template.json";
    }
}
