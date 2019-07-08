<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Description of Mikrostator
 *
 * @author aviantorichad
 * revision: 20180104/1811/mikrostator-2018
 * 
 * comm : menggunakan = read(parse=true), tidak pakai !done, !trap, dsb
 */
require_once 'routeros_api.class.php';

class Mikrostator Extends RouterosAPI {

    private $mikrotik_host = "";
    private $mikrotik_port = "";
    private $mikrotik_username = "";
    private $mikrotik_password = "";
    
    //put your code here
    public function __construct($data = null) {
        //...
    }
    
    function konek($data){
        $this->mikrotik_host = $data['mikrotik_host'];
        $this->mikrotik_port = $data['mikrotik_port'];
        $this->mikrotik_username = $data['mikrotik_username'];
        $this->mikrotik_password = $data['mikrotik_password'];
        return $this->connect2($this->mikrotik_host, $this->mikrotik_username, $this->mikrotik_password, $this->mikrotik_port);        
    }

    function disableIpHotspotUser($user) {
        if ($this->konek()) {
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
        return false;
    }

    function enableIpHotspotUser($user) {
        if ($this->konek()) {
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
        return false;
    }

    function addHotspotUser($data = array()) {
        if ($this->konek()) {
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
        return false;
    }

    function editHotspotUser($data = array()) {
        if ($this->konek()) {
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
        return false;
    }

    function monitoringHome() {
        if ($this->konek()) {
            $this->set('hotspot_active', $this->comm('/ip/hotspot/active/print'));
            $this->set('hotspot_log', $this->comm('/log/print'));
        }
    }

    function addHotspotUserVoucher($data = array()) {
        if ($this->konek()) {
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
        return false;
    }

    function delHotspotUserByName($name) {
        if ($this->konek()) {
            $IPUser2 = $this->comm("/ip/hotspot/user/print", array(
                "?name" => $name,
            ));
            $ARRAY = $this->comm('/ip/hotspot/user/remove', array(
                ".id" => $IPUser2[0]['.id'],
            ));
            return $ARRAY;
        }
        return false;
    }

    function restoreActive($data = array()) {
        if ($this->konek()) {
            $user = $data['user'];
            $batas_aktif = $data['batas_aktif'];

            $this->write('/ip/hotspot/user/set', false);
            $this->write('=.id=' . $user, false);
            $this->write('=name=' . $user, false);
            $this->write('=limit-uptime=' . $batas_aktif);
            $READ = $this->read(false);
            //$ARRAY = $this->parse_response($READ);
            return $READ;
        }
        return false;
    }

}

?>
