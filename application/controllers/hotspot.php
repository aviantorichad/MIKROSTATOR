<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hotspot extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stator');
        $this->load->model('hotspot_model');
    }

    public function index() {
        $data['title'] = 'Hotspot - MIKROSTATOR';
        
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'hotspot/user';
        $this->mikrostator->set('hotspotuserprofile', $this->hotspot_model->getHotspotUserProfile());

        $this->load->view('header', $data);
        $this->load->view('hotspot', $data);
        $this->load->view('footer');
    }
        
    public function user() {
        $data['title'] = 'Pengguna - Hotspot - MIKROSTATOR';
        
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'hotspot/user';
        $this->mikrostator->set('hotspotuserprofile', $this->hotspot_model->getHotspotUserProfile());

        $this->load->view('header', $data);
        $this->load->view('hotspot', $data);
        $this->load->view('footer');
    }
    
    public function user_profile() {
        $data['title'] = 'Profil Pengguna - Hotspot - MIKROSTATOR';
        
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'hotspot/user_profile';

        $this->load->view('header', $data);
        $this->load->view('hotspot', $data);
        $this->load->view('footer');
    }
    
    public function queue_simple() {
        $data['title'] = 'Queue Simple - Hotspot - MIKROSTATOR';
        
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'hotspot/queue_simple';

        $this->load->view('header', $data);
        $this->load->view('hotspot', $data);
        $this->load->view('footer');
    }
        
    public function restore_active() {
        $data['title'] = 'Pulihkan/Restore Active - Hotspot - MIKROSTATOR';
        
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'hotspot/restore_active';

        $this->load->view('header', $data);
        $this->load->view('hotspot', $data);
        $this->load->view('footer');
    }
    
    public function history() {
        $data['title'] = 'Riwayat/Log - Hotspot - MIKROSTATOR';
        
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'hotspot/history';

        $this->load->view('header', $data);
        $this->load->view('hotspot', $data);
        $this->load->view('footer');
    }
    
    public function dhcp_server_leases() {
        $data['title'] = 'DHCP Server > Leases - Hotspot - MIKROSTATOR';
        
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'hotspot/dhcp_server_leases';

        $this->load->view('header', $data);
        $this->load->view('hotspot', $data);
        $this->load->view('footer');
    }
    
    public function generate_voucher() {
        $data['title'] = 'Generate Voucher - Hotspot - MIKROSTATOR';
        
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'hotspot/generate_voucher';

        $this->load->view('header', $data);
        $this->load->view('hotspot', $data);
        $this->load->view('footer');
    }
    
    public function get_ip_hotspot_user() {
        $result = $this->hotspot_model->getIpHotspotUser();
        return $result;
    }
    
    public function get_ip_hotspot_user_profile() {
        $result = $this->hotspot_model->getIpHotspotUserProfile();
        return $result;
    }
    
    public function get_queue_simple() {
        $result = $this->hotspot_model->getQueueSimple();
        return $result;
    }
    
    
    public function get_dhcp_server_leases() {
        $result = $this->hotspot_model->getDhcpServerLeases();
        return $result;
    }
    
    public function edit_ip_hotspot_user($username){
        $data = $this->hotspot_model->get_ip_hotspot_user_by_username($username);
        echo json_encode($data);
    }
    
    function disable_ip_hotspot_user() 
    {
        $data = array(
            'user' => $this->input->get('user'),
        );
        //$user = $data['user'];
        //echo $this->mikrostator->disableIpHotspotUser($user);
        echo $this->hotspot_model->prosesDisableIpHotspotUser($data);
    }
    
    function enable_ip_hotspot_user() 
    {
        $data = array(
            'user' => $this->input->get('user'),
        );
        //$user = $data['user'];
        //echo $this->mikrostator->disableIpHotspotUser($user);
        echo $this->hotspot_model->prosesEnableIpHotspotUser($data);
    }
    
    function hapus_queue_simple() {
        $data = array(
            'id' => $this->input->get('id'),
            'user' => htmlentities($this->input->get('user')),
        );
        echo $this->hotspot_model->prosesHapusQueueSimple($data);
    }
    
    function simpan_tambah_hotspot_user() {
        $data = array(
            'user' => $this->input->post('user'),
            'password' => $this->input->post('password'),
            'userprofile' => $this->input->post('userprofile'),
            'server' => 'all',
        );
        echo $this->hotspot_model->prosesTambahHotspotUser($data);
    }
    
    function simpan_update_hotspot_user() {
        $data = array(
            'user' => $this->input->post('user'),
            'password' => $this->input->post('password'),
            'userprofile' => $this->input->post('userprofile'),
        );
        echo $this->hotspot_model->prosesUpdateHotspotUser($data);
        //echo $this->mikrostator->editHotspotUser($data);
        //echo print_r($data);
    }
    
    function hapus_ip_hotspot_user() {
        $data = array(
            'id' => $this->input->get('id'),
            'user' => $this->input->get('user'),
        );
        echo $this->hotspot_model->prosesHapusIpHotspotUser($data);
    }
    
    public function get_restore_active() {
        $result = $this->hotspot_model->getRestoreActive();
        return $result;
    }
    
    public function get_restore_table_jam($jam){
        return $this->hotspot_model->getRestoreTableJam($jam);
    }
    
    public function proses_restore_table_jam($jam){
        return $this->hotspot_model->prosesRestoreTableJam($jam);
    }
    
    public function get_history_mikrotik() {
        $result = $this->hotspot_model->getHistoryMikrotik();
        return $result;
    }
    
    public function get_history_jam() {
        $result = $this->hotspot_model->getHistoryJam();
        return $result;
    }
}

/* End of file hotspot.php */
/* Location: ./application/controllers/hotspot.php */