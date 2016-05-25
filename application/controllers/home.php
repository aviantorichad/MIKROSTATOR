<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->mikrostator->get('is_configured')) {
            //$this->session->set_flashdata('message', 'Kamu harus login untuk mengakses halaman admin.');
            //redirect('logout');
            echo "<script>alert('Sesi kamu habis, silahkan login kembali');</script>";
            echo "<script>window.location.href='".base_url()."/logout';</script>";
        }
        $this->load->model('stator');
        $this->load->model('home_model');
    }

    public function index() {
        $data['title'] = 'MIKROSTATOR - Simple Billing Mikrotik Administrator';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['selectgadget'] = $this->home_model->getSelectPicker('select_gadget');
        $data['selecttype'] = $this->home_model->getSelectPicker('select_type');
        $data['hotspotuser'] = $this->home_model->getHotspotUser();
        $data['configinterval'] = $this->mikrostator->get('interval');
        $data['display_autorefresh'] = 'display:block';

        $this->load->view('header', $data);
        $this->load->view('home', $data);
        $this->load->view('footer');
    }
    
    public function get_monitoring_home(){
        
    }

    public function get_baru_saja() {
//http://gubugkoding.com/tutorial-codeigniter-realtime-monitoring-pengguna-aplikasi/
        $result = $this->home_model->getBaruSaja();
        return $result;
    }

    public function get_riwayat_jam() {
        $result = $this->home_model->getRiwayatJam();
        return $result;
    }

    public function get_status_terbaru() {
        $result = $this->home_model->getStatusTerbaru();
        return $result;
    }

    public function get_hotspot_active() {
        $result = $this->home_model->getHotspotActive();
        return $result;
    }

    public function get_log_hotspot() {
        $result = $this->home_model->getLogHotspot();
        return $result;
    }

    public function get_hotspot_user() {
        $result = $this->home_model->getHotspotUser();
        return $result;
    }


    function cekKoneksiRouter2() {
        var_dump($this->mikrostator->cekKoneksiRouter());
    }

    function showHotspotUser() {
        $user = 'operator';
        $IPUser = $this->mikrostator->baca('/ip/hotspot/user/print', array(
            ".proplist" => "uptime,limit-uptime",
            "?name" => $user,
        ));

        print_r($IPUser);
    }

    function cekcek() {

        $nama_sumber = 'rtpapat';
        $sumber_batas = '1w2d3h';
        $this->kecek(array(
            '/ip/hotspot/user/set' => FALSE,
            '=.id=' . $nama_sumber => FALSE,
            '=name=' . $nama_sumber => FALSE,
            '=limit-uptime=' . $sumber_batas => true,
                )
        );
    }

    function kecek($arr = array()) {
        //$arr = $this->kecek();
        foreach ($arr as $k => $v) {
            echo $k . "=" . $v;
        }
    }

    function playNow() {
        $this->load->view('play');
    }

    function tambahJam() {
        $data = array(
            'user' => $this->input->post('selectuser'),
            'gadget' => $this->input->post('selectgadget'),
            'user2' => $this->input->post('selectuser2'),
            'type' => $this->input->post('selecttype'),
            'nominal' => $this->input->post('nominal'),
        );
        echo $this->home_model->prosesTambahJam($data);
    }

    function matikanActive() {
        $data = array(
            'id' => $this->input->get('id'),
            'user' => $this->input->get('user'),
        );
        echo $this->home_model->prosesMatikanActive($data);
    }

    function batalkanRiwayatJam() {
        $data = array(
            'id' => $this->input->get('id'),
            'user' => $this->input->get('user'),
            'waktu_awal' => $this->input->get('waktu_awal'),
            'waktu_akhir' => $this->input->get('waktu_akhir'),
        );
        echo $this->home_model->prosesBatalkanRiwayatJam($data);
    }

    function simpan_tambah_transaksi_lain() {
        $data = array(
            'user' => $this->input->post('user'),
            'transaksi' => $this->input->post('transaksi'),
            'nominal' => $this->input->post('nominal'),
        );
        echo $this->home_model->prosesTambahTransaksiLain($data);
    }
    
    function batalkanTransaksiLain() {
        $data = array(
            'id' => $this->input->get('id'),
            'user' => $this->input->get('user'),
            'waktu_awal' => $this->input->get('waktu_awal'),
            'waktu_akhir' => $this->input->get('waktu_akhir'),
        );
        echo $this->home_model->prosesBatalkanTransaksiLain($data);
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */