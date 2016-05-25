<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stator');
        $this->load->model('setting_model');
    }

    public function index() {
        $data['title'] = 'Konfigurasi - MIKROSTATOR';
        
        $row = $this->stator->getMikrotikResource();
        $data['listmenu'] = $this->stator->getListMenu();
        
        $memperc = ($row[0]['free-memory']/$row[0]['total-memory']);
        $hddperc = ($row[0]['free-hdd-space']/$row[0]['total-hdd-space']);
        $mem = ($memperc*100);
        $hdd = ($hddperc*100);
        
        $data['res_platform'] = $row[0]['platform'];
        $data['res_board_name'] = $row[0]['board-name'];
        $data['res_version'] = $row[0]['version'];
        $data['res_cpu'] = $row[0]['cpu'];
        $data['res_cpu_frequency'] = $row[0]['cpu-frequency'].' Mhz';
        $data['res_cpu_count'] = $row[0]['cpu-count'];
        $data['res_uptime'] = $row[0]['uptime'];
        $data['res_cpu_load'] = $row[0]['cpu-load'].'%';
        $data['res_memory'] = 'Free: '.number_format($row[0]['free-memory'] / 1024 / 1024, 2).' MB / Total: '.number_format($row[0]['total-memory'] / 1024 / 1024, 2).' MB ('.number_format($mem,2) . '%)';
        $data['res_disk'] = 'Free: '.number_format($row[0]['free-hdd-space'] / 1024 / 1024, 2).' MB / Total: '.number_format($row[0]['total-hdd-space'] / 1024 / 1024, 2).' MB ('.number_format($hdd,2) . '%)';
        $data['res_sector'] = 'Write: '.$row[0]['write-sect-total'].' | Since: '.$row[0]['write-sect-since-reboot'].' | Bad Blocks: '.$row[0]['bad-blocks'].'%';
        
        $data['sub_page'] = 'setting/about_router';

        $this->load->view('header', $data);
        $this->load->view('setting', $data);
        $this->load->view('footer');
    }
    
    function login_router(){
        
        $data['title'] = 'Login Router - Konfigurasi - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['ro_host'] = $this->mikrostator->get('host');
        $data['ro_username'] = $this->mikrostator->get('username');
        $data['ro_password'] = $this->mikrostator->get('password');
        $data['ro_port'] = $this->mikrostator->get('port');
        $data['ro_interval'] = $this->mikrostator->get('interval')/1000;
        $data['ro_autobackup'] = $this->mikrostator->get('autobackup');
        
        $data['sub_page'] = 'setting/login_router';

        $this->load->view('header', $data);
        $this->load->view('setting', $data);
        $this->load->view('footer');
    }
    
    function background_mac(){
        
        $data['title'] = 'Background MAC - Konfigurasi - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'setting/background_mac';

        $this->load->view('header', $data);
        $this->load->view('setting', $data);
        $this->load->view('footer');
    }
    
    function menu(){
        
        $data['title'] = 'Main Menu - Konfigurasi - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'setting/menu';

        $this->load->view('header', $data);
        $this->load->view('setting', $data);
        $this->load->view('footer');
    }
    
    function update_login_router(){
        $data = array(
            'host' => $this->input->post('host'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'port' => $this->input->post('port'),
            'interval' => $this->input->post('interval'),
            'autobackup' => $this->input->post('autobackup'),
        );
        echo $this->setting_model->prosesUpdateLoginRouter($data);
    }
    
    function gadget_list(){
        
        $data['title'] = 'Pilihan Gadget - Konfigurasi - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'setting/gadget_list';

        $this->load->view('header', $data);
        $this->load->view('setting', $data);
        $this->load->view('footer');
    }
    
    function user_admin(){
        
        $data['title'] = 'Administrator - Konfigurasi - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'setting/user_admin';

        $this->load->view('header', $data);
        $this->load->view('setting', $data);
        $this->load->view('footer');
    }
    
    function reboot_router(){
        $this->mikrostator->tulis2('/system/reboot');
        echo "ROUTER dihidupkan ulang";
    }
    
    function turnoff_router(){
        $this->mikrostator->tulis2('/system/shutdown');
        echo "ROUTER dimatikan!";
    }
    
    public function get_background_mac() {
        $result = $this->setting_model->getBackgroundMac();
        return $result;
    }
    
    public function get_main_menu() {
        $result = $this->setting_model->getMainMenu();
        return $result;
    }
    
    public function get_gadget_list() {
        $result = $this->setting_model->getGadgetList();
        return $result;
    }
    
    public function get_user_admin() {
        $result = $this->setting_model->getUserAdmin();
        return $result;
    }
    
    public function show_all_table_from_router() {
        $myfinal = $this->mikrostator->baca('/ip/hotspot/active/print');
        //return print_r($query);
        //$COUNT_ACTIVE = count($IPActive);
        // Top row
        echo '<table border="1">';
        /*
        echo '<tr>';
        foreach ($myfinal as $key => $value) {
            if (is_array($value)) {
                echo '<th colspan="' . sizeof($value) . '">' . $key . '</th>';
            } else {
                echo '<th colspan="1">' . $key . '</th>';
            }
        }
        echo '</tr>';
         * 
         */
        //Middle row
        echo '<tr>';
        foreach ($myfinal as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $column) {
                    echo '<th colspan="1">' . $key . '</th>';
                }
            } else {
                echo '<th colspan="1">No subcat</th>';
            }
        }
        echo '</tr>';
        //Data
        echo '<tr>';
        foreach ($myfinal as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $column) {
                    echo '<td>' . $column . '</td>';
                }
            } else {
                echo '<td>' . $value . '</td>';
            }
        }
        echo '</tr>';
        echo '</table>';
    }
    
    
    
    public function edit_main_menu($id){
        echo json_encode($this->setting_model->getMainMenuById($id));
    }
        
    function simpan_tambah_main_menu() {
        $data = array(
            'nama' => $this->input->post('nama'),
            'link' => $this->input->post('link'),
            'icon' => $this->input->post('icon'),
            'atribut' => $this->input->post('atribut'),
            'keterangan' => $this->input->post('keterangan'),
            'urutan' => $this->input->post('urutan'),
        );
        echo $this->setting_model->prosesTambahMainMenu($data);
    }
    
    function simpan_update_main_menu() {
        $data = array(
            'id' => $this->input->post('id'),
            'nama' => $this->input->post('nama'),
            'link' => $this->input->post('link'),
            'icon' => $this->input->post('icon'),
            'atribut' => $this->input->post('atribut'),
            'keterangan' => $this->input->post('keterangan'),
            'urutan' => $this->input->post('urutan'),
        );
        echo $this->setting_model->prosesUpdateMainMenu($data);
    }
    
    function hapus_main_menu() {
        $data = array(
            'id' => $this->input->get('id'),
            'nama' => $this->input->get('nama'),
        );
        echo $this->setting_model->prosesHapusMainMenu($data);
    }
    
    
    
    public function edit_background_mac($id){
        echo json_encode($this->setting_model->getBackgroundMacById($id));
    }
        
    function simpan_tambah_background_mac() {
        $data = array(
            'nama' => $this->input->post('nama'),
            'bgcolor' => $this->input->post('bgcolor'),
            'keterangan' => $this->input->post('keterangan'),
        );
        echo $this->setting_model->prosesTambahBackgroundMac($data);
    }
    
    function simpan_update_background_mac() {
        $data = array(
            'id' => $this->input->post('id'),
            'nama' => $this->input->post('nama'),
            'bgcolor' => $this->input->post('bgcolor'),
            'keterangan' => $this->input->post('keterangan'),
        );
        echo $this->setting_model->prosesUpdateBackgroundMac($data);
    }
    
    function hapus_background_mac() {
        $data = array(
            'id' => $this->input->get('id'),
            'nama' => $this->input->get('nama'),
        );
        echo $this->setting_model->prosesHapusBackgroundMac($data);
    }
    
    
    
    public function edit_gadget_list($id){
        echo json_encode($this->setting_model->getGadgetListById($id));
    }
        
    function simpan_tambah_gadget_list() {
        $data = array(
            'nama' => $this->input->post('nama'),
            'value' => $this->input->post('value'),
            'icon' => $this->input->post('icon'),
            'atribut' => $this->input->post('atribut'),
            'keterangan' => $this->input->post('keterangan'),
            'urutan' => $this->input->post('urutan'),
        );
        echo $this->setting_model->prosesTambahGadgetList($data);
    }
    
    function simpan_update_gadget_list() {
        $data = array(
            'id' => $this->input->post('id'),
            'nama' => $this->input->post('nama'),
            'value' => $this->input->post('value'),
            'icon' => $this->input->post('icon'),
            'atribut' => $this->input->post('atribut'),
            'keterangan' => $this->input->post('keterangan'),
            'urutan' => $this->input->post('urutan'),
        );
        echo $this->setting_model->prosesUpdateGadgetList($data);
    }
    
    function hapus_gadget_list() {
        $data = array(
            'id' => $this->input->get('id'),
            'nama' => $this->input->get('nama'),
        );
        echo $this->setting_model->prosesHapusGadgetList($data);
    }
    
    
    
    public function edit_user_admin($id){
        echo json_encode($this->setting_model->getUserAdminById($id));
    }
        
    function simpan_tambah_user_admin() {
        $data = array(
            'nama' => $this->input->post('nama'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'keterangan' => $this->input->post('keterangan'),
        );
        echo $this->setting_model->prosesTambahUserAdmin($data);
    }
    
    function simpan_update_user_admin() {
        $data = array(
            'id' => $this->input->post('id'),
            'nama' => $this->input->post('nama'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'keterangan' => $this->input->post('keterangan'),
        );
        echo $this->setting_model->prosesUpdateUserAdmin($data);
    }
    
    function hapus_user_admin() {
        $data = array(
            'id' => $this->input->get('id'),
            'nama' => $this->input->get('nama'),
        );
        echo $this->setting_model->prosesHapusUserAdmin($data);
    }
}

/* End of file setting.php */
/* Location: ./application/controllers/setting.php */