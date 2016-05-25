<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Voucher extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stator');
        $this->load->model('hotspot_model');
        $this->load->model('voucher_model');
    }

    public function index() {
        $data['title'] = 'Generate Voucher - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'voucher/generate_voucher';

        $this->load->view('header', $data);
        $this->load->view('voucher', $data);
        $this->load->view('footer');
    }
    
    public function generate_voucher() {
        $data['title'] = 'Generate Voucher - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $this->mikrostator->set('hotspotuserprofile', $this->hotspot_model->getHotspotUserProfile());
        
        $data['sub_page'] = 'voucher/generate_voucher';
        

        $this->load->view('header', $data);
        $this->load->view('voucher', $data);
        $this->load->view('footer');
    }
    
    public function voucher_list() {
        $data['title'] = 'Daftar Voucher - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
                
        $data['sub_page'] = 'voucher/voucher_list';
        $data['vouchername'] = $this->voucher_model->getVoucherName();

        $this->load->view('header', $data);
        $this->load->view('voucher', $data);
        $this->load->view('footer');
    }
    
    public function voucher_used() {
        $data['title'] = 'Penggunaan Voucher - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
                
        $data['sub_page'] = 'voucher/voucher_used';
        $data['vouchername'] = $this->voucher_model->getVoucherName();

        $this->load->view('header', $data);
        $this->load->view('voucher', $data);
        $this->load->view('footer');
    }
    
    public function do_generate_voucher(){
        $data = array(
            'namavoucher' => $this->input->get('namavoucher'),
            'qty' => $this->input->get('qty'),
            'userprofile' => $this->input->get('userprofile'),
            'limituptime' => $this->input->get('limituptime'),
            'tipepassword' => $this->input->get('tipepassword'),
            'password' => $this->input->get('password'),
        );
        $result = $this->voucher_model->prosesGenerateVoucher($data);
        return $result;
    }
    
    public function get_voucher_list(){
        $data = array(
            'namavoucher' => $this->input->get('namavoucher'),
        );
        $result = $this->voucher_model->getVoucherList($data);
        return $result;
    }
    
    public function hapus_voucher_list(){
        $data = array(
            'namavoucher' => $this->input->get('namavoucher'),
        );
        $result = $this->voucher_model->prosesHapusVoucherList($data);
        echo $result;
    }
    
    
    public function cetak_voucher_list(){
        $data = array(
            'namavoucher' => $this->input->get('namavoucher'),
        );
        $result = $this->voucher_model->prosesCetakVoucherList($data);
        echo $result;
    }
    
    public function cetak_voucher_list2($namavoucher){
        $result = $this->voucher_model->prosesCetakVoucherList2($namavoucher);
        echo $result;
    }
    
    public function get_voucher_used(){
        $data = array(
            'namavoucher' => $this->input->get('namavoucher'),
        );
        $result = $this->voucher_model->getVoucherUsed($data);
        return $result;
    }
}

/* End of file voucher.php */
/* Location: ./application/controllers/voucher.php */