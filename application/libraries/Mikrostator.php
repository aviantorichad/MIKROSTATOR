<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Description of Mikrostator
 *
 * @author aviantorichad
 */
require_once 'routeros_api.class.php';

class Mikrostator Extends routeros_api {

    //put your code here
    public function __construct() {
        session_start();
    }

    //http://www.moreofless.co.uk/using-native-php-sessions-with-codeigniter/
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function delete($key) {
        unset($_SESSION[$key]);
    }

    function cekKoneksiRouter() {
        try {
            $host = $this->get('host');
            $username = $this->get('username');
            $password = $this->get('password');
            $port = $this->get('port');
            return $this->connect2($host, $username, $password, $port);
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

    function baca($command, array $param = null) {
        try {
            if ($this->cekKoneksiRouter()) {
                return $this->comm($command, $param);
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

    //alternatif menulis ke router
    function tulis2($command, array $param = null) {
        try {
            if ($this->cekKoneksiRouter()) {
                return $this->comm($command, $param);
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

    function tulis($arr = array()) {
        /*
          $API->write('/ip/hotspot/user/set', false);
          $API->write('=.id=' . $nama_sumber, false);
          $API->write('=name=' . $nama_sumber, false);
          $API->write('=limit-uptime=' . $sumber_batas);

          $READ = $API->read(false);
          $ARRAY = $API->parse_response($READ);
         */
        try {
            if ($this->cekKoneksiRouter()) {
                foreach ($arr as $k => $v) {
                    //echo $k . "=" . $v;
                    $this->write($k, $v);
                }

                $READ = $this->read(false);
                return $ARRAY = $this->parse_response($READ);
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

    function disableIpHotspotUser($user) {
        try {
            if ($this->cekKoneksiRouter()) {
                $this->write('/ip/hotspot/user/print', false);
                $this->write('=.proplist=.id', false);
                $this->write('?name=' . $user);

                $A = $this->read();
                $A = $A[0];
                $this->write('/ip/hotspot/user/set', false);
                $this->write('=.id=' . $A['.id'], false);
                $this->write('=disabled=yes');
                return $this->read();
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

    function enableIpHotspotUser($user) {
        try {
            if ($this->cekKoneksiRouter()) {
                $this->write('/ip/hotspot/user/print', false);
                $this->write('=.proplist=.id', false);
                $this->write('?name=' . $user);

                $A = $this->read();
                $A = $A[0];
                $this->write('/ip/hotspot/user/set', false);
                $this->write('=.id=' . $A['.id'], false);
                $this->write('=disabled=no');
                return $this->read();
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

    function addHotspotUser($data = array()) {
        try {
            if ($this->cekKoneksiRouter()) {
                $name = $data['user'];
                $password = $data['password'];
                $userprofile = $data['userprofile'];
                $server = $data['server'];

                $this->write('/ip/hotspot/user/add', false);
                $this->write('=name=' . $name, false);
                $this->write('=password=' . $password, false);
                $this->write('=profile=' . $userprofile, false);
                $this->write('=server=' . $server);
                $READ = $this->read(false);
                //$ARRAY = $this->parse_response($READ);
                return $READ;
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

    function editHotspotUser($data = array()) {
        try {
            if ($this->cekKoneksiRouter()) {
                $name = $data['user'];
                $password = $data['password'];
                $userprofile = $data['userprofile'];

                $this->write('/ip/hotspot/user/set', false);
                $this->write('=.id=' . $name, false);
                $this->write('=name=' . $name, false);
                $this->write('=password=' . $password, false);
                $this->write('=profile=' . $userprofile);
                $READ = $this->read(false);
                //$ARRAY = $this->parse_response($READ);
                return $READ;
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

    function monitoringHome() {
        try {
            if ($this->cekKoneksiRouter()) {
                $this->set('hotspot_active', $this->comm('/ip/hotspot/active/print'));
                $this->set('hotspot_log', $this->comm('/log/print'));
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

    function addHotspotUserVoucher($data = array()) {
        try {
            if ($this->cekKoneksiRouter()) {
                $name = $data['user'];
                $password = $data['password'];
                $userprofile = $data['userprofile'];
                $limit_uptime = $data['limit_uptime'];
                $comment = $data['comment'];
                $server = $data['server'];

                $this->write('/ip/hotspot/user/add', false);
                $this->write('=name=' . $name, false);
                $this->write('=password=' . $password, false);
                $this->write('=profile=' . $userprofile, false);
                $this->write('=limit-uptime=' . $limit_uptime, false);
                $this->write('=comment=' . $comment, false);
                $this->write('=server=' . $server);
                $READ = $this->read(false);
                //$ARRAY = $this->parse_response($READ);
                return $READ;
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

    function delHotspotUserByName($name) {
        try {
            if ($this->cekKoneksiRouter()) {
                $IPUser2 = $this->comm("/ip/hotspot/user/print", array(
                    "?name" => $name,
                ));
                $ARRAY = $this->comm('/ip/hotspot/user/remove', array(
                    ".id" => $IPUser2[0]['.id'],
                ));
                return $ARRAY;
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }
    
    function restoreActive($data = array()) {
        try {
            if ($this->cekKoneksiRouter()) {
                $user = $data['user'];
                $batas_aktif = $data['batas_aktif'];

                $this->write('/ip/hotspot/user/set',false);
                $this->write('=.id='.$user ,false);
                $this->write('=name='.$user ,false);
                $this->write('=limit-uptime='.$batas_aktif);
                $READ = $this->read(false);
                //$ARRAY = $this->parse_response($READ);
                return $READ;
            }
        } catch (Exception $e) {
            return "Error: " . $e;
        }
    }

}

?>
