<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('rich_model');
    }

    public function index() {
        // try {
        //     //write log to file
        //     $myfile = fopen("logs/logfile_" . date("Ymd") . ".txt", "a");
        //     $ua = $this->getBrowser();
        //     $yourbrowser = $ua['name'] . " " . $ua['version'] . " on " . $ua['platform'] . "|" . $ua['userAgent'];
        //     $yourbrowser = $ua['name'] . " " . $ua['version'] . " on " . $ua['platform'] . "|" . $ua['userAgent'];

        //     $ip = $this->get_client_ip();
        //     $details = json_decode(@file_get_contents("http://ipinfo.io/{$ip}/json"));
        //     $hostname = isset($details->hostname) ? $details->hostname : "";
        //     $city = isset($details->city) ? $details->city : "";
        //     $region = isset($details->region) ? $details->region : "";
        //     $country = isset($details->country) ? $details->country : "";
        //     $loc = isset($details->loc) ? $details->loc : "";
        //     $org = isset($details->org) ? $details->org : "";

        //     $txt = "[" . date("Y-m-d H:i:s") . "] home|" . $this->get_client_ip2() . "|" . $hostname . "|" . $city . "|" . $region . "|" . $country . "|" . $loc . "|" . $org . "|" . $yourbrowser . "\n";
        //     fwrite($myfile, $txt);
        //     fclose($myfile);
        // } catch (Exception $e) {
        //     //echo 'Caught exception: ',  $e->getMessage(), "\n";
        // }

        $data['title'] = 'MIKROSTATOR';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/content', $data);
        $this->load->view('template/rich_js', $data);
        $this->load->view('template/footer', $data);
    }

    public function save_session() {
        $this->load->database();
        $data['mikrotik_name'] = $this->input->post('mikrotik_name');
        $data['mikrotik_host'] = $this->input->post('mikrotik_host');
        $data['mikrotik_port'] = $this->input->post('mikrotik_port');
        $data['mikrotik_username'] = $this->input->post('mikrotik_username');
        $data['mikrotik_password'] = $this->input->post('mikrotik_password');
        $data['pin'] = $this->input->post('security_pin');
        $this->db->insert('login_mikrotik', $data);
        $afftectedRows = $this->db->affected_rows();
        if ($afftectedRows) {
            $result['ok'] = true;
            $result['msg'] = 'Saved.';
        } else {
            $result['ok'] = false;
            $result['msg'] = $this->db->error()['message'];
        }
        echo json_encode($result);
    }

    public function insert_session() {

        // pakai session
        // $data[$this->input->post('session_id')]['mikrotik_name'] = $this->input->post('mikrotik_name');
        // $data[$this->input->post('session_id')]['mikrotik_host'] = $this->input->post('mikrotik_host');
        // $data[$this->input->post('session_id')]['mikrotik_port'] = $this->input->post('mikrotik_port');
        // $data[$this->input->post('session_id')]['mikrotik_username'] = $this->input->post('mikrotik_username');
        // $data[$this->input->post('session_id')]['mikrotik_password'] = $this->input->post('mikrotik_password');
        $data['mikrotik_name'] = $this->input->post('mikrotik_name');
        $data['mikrotik_host'] = $this->input->post('mikrotik_host');
        $data['mikrotik_port'] = $this->input->post('mikrotik_port');
        $data['mikrotik_username'] = $this->input->post('mikrotik_username');
        $data['mikrotik_password'] = $this->input->post('mikrotik_password');

        $_SESSION['sessions'][$this->input->post('session_id')] = $data;
        
        // //uji coba simpan ke db sqlite
        // $this->load->database();
        // $data['mikrotik_name'] = $this->input->post('mikrotik_name');
        // $data['mikrotik_host'] = $this->input->post('mikrotik_host');
        // $data['mikrotik_port'] = $this->input->post('mikrotik_port');
        // $data['mikrotik_username'] = $this->input->post('mikrotik_username');
        // $data['mikrotik_password'] = $this->input->post('mikrotik_password');
        // $this->db->insert('list_mikrotik', $data);
        // $afftectedRows = $this->db->affected_rows();
        // if ($afftectedRows) {
        //     $result['ok'] = true;
        //     $result['msg'] = 'Saved.';
        // } else {
        //     $result['ok'] = false;
        //     $result['msg'] = $this->db->error()['message'];
        // }
        // echo json_encode($result);
    }


    //dengan database sql.begin
    public function is_security_mikrotik() {
        $id = $this->input->post('id');

        $this->load->database();
        $this->db->where('id', $id);
        $query = $this->db->get('login_mikrotik');
        $array = $query->row_array();
        if (count($array) > 0) {
            $result['ok'] = true;
            if($array['pin'] != "") {
                $result['msg'] = 'pin';
            } else {
                $result['msg'] = 'nopin';
            }
                
        } else {
            $result['ok'] = false;
            $result['msg'] = 'no data';
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    
    public function check_security_mikrotik() {
        $id = $this->input->post('id');
        $pin = $this->input->post('pin');

        $this->load->database();
        $this->db->where('id', $id);
        $this->db->where('pin', $pin);
        $query = $this->db->get('login_mikrotik');
        $array = $query->row_array();
        if (count($array) > 0) {
            $result['ok'] = true;
            $result['msg'] = $array;
        } else {
            $result['ok'] = false;
            $result['msg'] = 'Invalid PIN.';
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function get_session_logins() {
        $this->load->database();
        $query = $this->db->get('login_mikrotik');
        $array = $query->result();
        if (count($array) > 0) {
            $result['ok'] = true;
            $result['msg'] = $array;
        } else {
            $result['ok'] = false;
            $result['msg'] = 'no data';
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function get_session_login_by_id() {
        $id = $this->input->post('id');

        $this->load->database();
        $this->db->where('id', $id);
        $query = $this->db->get('login_mikrotik');
        $array = $query->row();
        if (count($array) > 0) {
            $result['ok'] = true;
            $result['msg'] = $array;
        } else {
            $result['ok'] = false;
            $result['msg'] = 'no data';
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    
    public function get_session_lists() {
        $this->load->database();
        $this->db->select('id, mikrotik_name');
        $query = $this->db->get('login_mikrotik');
        $array = $query->result();
        if (count($array) > 0) {
            $result['ok'] = true;
            $result['msg'] = $array;
        } else {
            $result['ok'] = false;
            $result['msg'] = 'no data';
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function get_session_list_by_id() {
        $id = $this->input->post('id');

        $this->load->database();
        $this->db->where('id', $id);
        $query = $this->db->get('login_mikrotik');
        $array = $query->row();
        if (count($array) > 0) {
            $result['ok'] = true;
            $result['msg'] = $array;
        } else {
            $result['ok'] = false;
            $result['msg'] = 'no data';
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function del_session_list_by_id() {
        $id = $this->input->post('id');

        $this->load->database();
        $this->db->where('id', $id);
        $this->db->delete('login_mikrotik');
        $afftectedRows = $this->db->affected_rows();
        if ($afftectedRows > 0) {
            $result['ok'] = true;
            $result['msg'] = 'Mikrotik deleted.';
        } else {
            $result['ok'] = false;
            $result['msg'] = 'Fail deleting Mikrotik.';
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    //dengan database sql.end

    
    //dengan database file json.begin
    
    public function get_session_logins_from_file() {
        $myfile = file_get_contents($this->rich_model->mikrostator_file_db());
        if($myfile) {
            $myfile = json_decode($myfile, true);
            $array = [];
            foreach($myfile as $key => $val) {
                $arr['id'] = $key;
                $arr['ext_id'] = $val['id'];
                $arr['mikrotik_name'] = $val['mikrotik_name'];
                // $arr['mikrotik_host'] = $val['mikrotik_host'];
                // $arr['mikrotik_port'] = $val['mikrotik_port'];
                // $arr['mikrotik_username'] = $val['mikrotik_username'];
                // $arr['mikrotik_password'] = $val['mikrotik_password'];
                // $arr['pin'] = $val['pin'];
                array_push($array, $arr);
            }

            if(count($array) > 0){
                $result['ok'] = true;
                $result['msg'] = $array;
            } else {
                $result['ok'] = false;
                $result['msg'] = "no data";
            }
        } else {
            $result['ok'] = false;
            $result['msg'] = 'Fail to load DB. Maybe file permission issue.';            
        }
        
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function get_session_login_by_id_from_file() {
        $id = $this->input->post('id');

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

    public function is_security_mikrotik_from_file() {
        $id = $this->input->post('id');

        $myfile = file_get_contents($this->rich_model->mikrostator_file_db());
        if($myfile) {
            $myfile = json_decode($myfile, true);
            $myfile = $myfile[$id];
            $array = $myfile;
            if (count($array) > 0) {
                $result['ok'] = true;
                if($array['pin'] != "") {
                    $result['msg'] = 'pin';
                } else {
                    $result['msg'] = 'nopin';
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

    public function check_security_mikrotik_from_file() {
        $id = $this->input->post('id');
        $pin = $this->input->post('pin');

        $myfile = file_get_contents($this->rich_model->mikrostator_file_db());
        if($myfile) {
            $myfile = json_decode($myfile, true);
            $myfile = $myfile[$id];
            if($myfile['pin'] != $pin){
                $result['ok'] = false;
                $result['msg'] = 'Invalid PIN.';
            } else {
                $array = $myfile;
                if (count($array) > 0) {
                    $result['ok'] = true;
                    $result['msg'] = $array;
                } else {
                    $result['ok'] = false;
                    $result['msg'] = 'no data';
                }
            }
        } else {
            $result['ok'] = false;
            $result['msg'] = 'Fail to load DB. Maybe file permission issue.';            
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function save_session_to_file() {
        $data['id'] = date('YmdHis');
        $data['mikrotik_name'] = $this->input->post('mikrotik_name');
        $data['mikrotik_host'] = $this->input->post('mikrotik_host');
        $data['mikrotik_port'] = $this->input->post('mikrotik_port');
        $data['mikrotik_username'] = $this->input->post('mikrotik_username');
        $data['mikrotik_password'] = $this->input->post('mikrotik_password');
        $data['pin'] = $this->input->post('security_pin');
        $myfile = file_get_contents($this->rich_model->mikrostator_file_db());
        if($myfile) {
            $myfile = json_decode($myfile, true);
            if(array($myfile) > 0) {
                array_push($myfile, $data);
            } else {
                $myfile = [];
                array_push($myfile, $data);
            }
            if (file_put_contents($this->rich_model->mikrostator_file_db(), json_encode($myfile))) {
                $result['ok'] = true;
                $result['msg'] = 'Saved.';
            } else {
                $result['ok'] = false;
                $result['msg'] = 'Failed to save session. Maybe file permission issue.';
            }
        } else {
            $result['ok'] = false;
            $result['msg'] = 'Fail to load DB. Maybe file permission issue.';            
        }
        echo json_encode($result);
    }

    public function del_session_list_by_id_from_file() {
        $id = $this->input->post('id');

        $myfile = file_get_contents($this->rich_model->mikrostator_file_db());
        if($myfile) {
            $myfile = json_decode($myfile, true);
            unset($myfile[$id]);
            $array = $myfile;
            // print_r($array);exit(0);
            if (file_put_contents($this->rich_model->mikrostator_file_db(), json_encode($array))) {
                $result['ok'] = true;
                $result['msg'] = 'Mikrotik deleted.';
            } else {
                $result['ok'] = false;
                $result['msg'] = 'Fail deleting Mikrotik. Maybe file permission issue.';
            }
        } else {
            $result['ok'] = false;
            $result['msg'] = 'Fail to load DB. Maybe file permission issue.';            
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    //dengan database file json.end


    public function sessions() {
       return $this->rich_model->get_sessions();
        // return $this->rich_model->get_mikrotik_sessions();
    }

    public function session_id($session_id, $json = false) {
        return $this->rich_model->get_session_by_id($session_id, $json);
    }

    public function logout() {
       session_destroy(); // destroy all session
        
        // $this->load->database();
        // $this->db->truncate('list_mikrotik');
        // $afftectedRows = $this->db->affected_rows();
        // if ($afftectedRows > 0) {
            $result['ok'] = true;
            $result['msg'] = 'All Sessions deleted.';
        // } else {
        //     $result['ok'] = false;
        //     $result['msg'] = 'Fail deleting All Mikrotiks.';
        // }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function logout_one($session_id) {
       unset($_SESSION['sessions'][$session_id]);
        
        // $id = $session_id;

        // $this->load->database();
        // $this->db->where('id', $id);
        // $this->db->delete('list_mikrotik');
        // $afftectedRows = $this->db->affected_rows();
        // if ($afftectedRows > 0) {
            $result['ok'] = true;
            $result['msg'] = 'Selected Session deleted.';
        // } else {
        //     $result['ok'] = false;
        //     $result['msg'] = 'Fail deleting Mikrotik.';
        // }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function insert_section($session_id, $cmd) {
       if (!isset($_SESSION['sessions'][$session_id])) {
        //    echo "Session not found!";
           return false;
       }
        ?>
        <!-- quick email widget -->
        <div class="box box-success" id="mikrostator-box-<?= $session_id ?>-<?= $cmd ?>">
            <div class="box-header with-border" style="cursor: move;">
                <i class="fa fa-clipboard"></i>

                <h3 class="box-title">
                    Header
                </h3>
                <small>Description</small>
                <!-- tools box -->
                <div class="box-tools pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-th"></i></button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="javascript:void(0)"><input type="checkbox" value="" id="autorefresh-<?= $session_id ?>-<?= $cmd ?>"> Auto Refresh</a></li>
                            <li><a href="javascript:void(0)"><input type="number" min="1000" value="1000" id="autorefresh_interval-<?= $session_id ?>-<?= $cmd ?>"> ms</a></li>
                            <li class="divider"></li>
                            <li><a href="javascript:void(0)" class="updated-at"></a></li>
                        </ul>
                    </div>
                    <button type="button" id="mikrostator-box-<?= $session_id ?>-<?= $cmd ?>-btnrefresh" class="btn btn-xs" data-widget="refresh" title="Reload section" onclick="window['freqAjax-<?= $session_id ?>-<?= $cmd ?>']()"><i class="fa fa-refresh"></i></button>
                    <button type="button" id="mikrostator-box-<?= $session_id ?>-<?= $cmd ?>-btnminmaximize" class="btn btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" id="mikrostator-box-<?= $session_id ?>-<?= $cmd ?>-btnclose" class="btn btn-danger btn-xs" data-widget="remove" onclick="try{window['reqAjax-<?= $session_id ?>-<?= $cmd ?>'].abort()}catch(e){console.log(e);alert(e)};$('#mikrostator-box-<?= $session_id ?>-<?= $cmd ?>').remove();"><i class="fa fa-times"></i></button>
                </div>
                <!-- /. tools -->
            </div>
            <div class="box-body">
                content
            </div>
        </div>
        <script>
            $(function () {
                $('#mikrostator-box-<?= $session_id ?>-<?= $cmd ?>-btnminmaximize').on('click', function () {
                    $('#mikrostator-box-<?= $session_id ?>-<?= $cmd ?> .box-body').toggle();
                    if ($('#mikrostator-box-<?= $session_id ?>-<?= $cmd ?> .box-body').is(":visible")) {
                        $('#mikrostator-box-<?= $session_id ?>-<?= $cmd ?>-btnminmaximize i').removeClass('fa-plus')
                        $('#mikrostator-box-<?= $session_id ?>-<?= $cmd ?>-btnminmaximize i').addClass('fa-minus')
                    } else {
                        $('#mikrostator-box-<?= $session_id ?>-<?= $cmd ?>-btnminmaximize i').removeClass('fa-minus')
                        $('#mikrostator-box-<?= $session_id ?>-<?= $cmd ?>-btnminmaximize i').addClass('fa-plus')
                    }
                });
            });
        </script>
        <?php
    }


    //user login.begin
    public function modal_user_login_config($session_id, $msid = "") {
        $myfile = file_get_contents($this->rich_model->user_login_file_db());
        if($myfile) {
            $myfile = json_decode($myfile, true);
            $array = [];
            foreach($myfile as $key => $val) {
                $arr['username'] = $val['username'];
                $arr['password'] = $val['password'];
                array_push($array, $arr);
            }
            // print_r($array);
        ?>
            <div class="notifikasi"></div>
            <form>
                <div class="form-group">
                    <label>User Login:</label>
                    <textarea id="input_user_login_config" class="form-control" rows="15"><?= isset($array) ? json_encode($array, JSON_PRETTY_PRINT) : '' ?></textarea>
                    <small class="help-block" id="help-session-list"><i class="fa fa-info-circle"></i> don't use enter.</small>
                </div>
            </form>
        <?php
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Fail to load DB. Maybe file permission issue.</h4>                    
            </div>
            <?php
        }
    }

    public function get_user_login_from_file() {
        $myfile = file_get_contents($this->rich_model->user_login_file_db());
        if($myfile) {
            $myfile = json_decode($myfile, true);
            $array = [];
            foreach($myfile as $key => $val) {
                $arr['username'] = $val['username'];
                $arr['password'] = $val['password'];
                array_push($array, $arr);
            }

            if(count($array) > 0){
                $result['ok'] = true;
                $result['msg'] = $array;
            } else {
                $result['ok'] = false;
                $result['msg'] = "no data";
            }
        } else {
            $result['ok'] = false;
            $result['msg'] = 'Fail to load DB. Maybe file permission issue.';            
        }
        
        echo json_encode($result, JSON_PRETTY_PRINT);
    }
    public function save_user_login_to_file() {
        $data['input_user_login_config'] = $this->input->post('input_user_login_config');
        $myfile = file_get_contents($this->rich_model->user_login_file_db());
        if($myfile) {
            // $myfile = json_decode($myfile, true);
            // if(array($myfile) > 0) {
            //     array_push($myfile, $data);
            // } else {
            //     $myfile = [];
            //     array_push($myfile, $data);
            // }
            if (file_put_contents($this->rich_model->user_login_file_db(), $data['input_user_login_config'])) {
                $result['ok'] = true;
                $result['msg'] = 'Saved.';
            } else {
                $result['ok'] = false;
                $result['msg'] = 'Failed to save session. Maybe file permission issue.';
            }
        } else {
            $result['ok'] = false;
            $result['msg'] = 'Fail to load DB. Maybe file permission issue.';            
        }
        echo json_encode($result);
    }
    //user login.end

    /*
     * *******************************
     * KUMPULAN FUNCTION.begin
     * *******************************
     */

    // Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        $ipadsplit = explode(",", $ipaddress);
        if (count($ipadsplit) > 1) {
            $ipaddress = trim($ipadsplit[1]);
        }
        return $ipaddress;
    }

    // Function to get the client IP address
    public function get_client_ip2() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    public function getip() {
        echo $this->get_client_ip2();
    }

    public function convertBytes($val = 0) {
        echo $this->rich_model->formatBytes($val);
    }

    /*
     * *******************************
     * KUMPULAN FUNCTION.end
     * *******************************
     */
}
