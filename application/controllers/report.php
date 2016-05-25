<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stator');
        $this->load->model('report_model');
    }

    public function index() {
        $data['title'] = 'Laporan - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'report/allyear';

        $this->load->view('header', $data);
        $this->load->view('report', $data);
        $this->load->view('footer');
    }
    
    public function daily() {
        $data['title'] = 'Laporan Harian - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'report/daily';

        $this->load->view('header', $data);
        $this->load->view('report', $data);
        $this->load->view('footer');
    }
    
    public function monthly() {
        $data['title'] = 'Laporan Bulanan - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'report/monthly';

        $this->load->view('header', $data);
        $this->load->view('report', $data);
        $this->load->view('footer');
    }
    
    public function yearly() {
        $data['title'] = 'Laporan Tahunan - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'report/yearly';

        $this->load->view('header', $data);
        $this->load->view('report', $data);
        $this->load->view('footer');
    }
    
    public function allyear() {
        $data['title'] = 'Laporan Semua Tahun - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'report/allyear';

        $this->load->view('header', $data);
        $this->load->view('report', $data);
        $this->load->view('footer');
    }
    
    public function get_report_daily() {
        $data = array(
            'tanggal' => $this->input->get('tanggal'),
            'bulan' => $this->input->get('bulan'),
            'tahun' => $this->input->get('tahun'),
        );
        $result = $this->report_model->getReportDaily($data);
        return $result;
    }
    
    public function get_report_monthly() {
        $data = array(
            'bulan' => $this->input->get('bulan'),
            'tahun' => $this->input->get('tahun'),
        );
        $result = $this->report_model->getReportMonthly($data);
        return $result;
    }
    
    public function get_report_yearly() {
        $data = array(
            'tahun' => $this->input->get('tahun'),
        );
        $result = $this->report_model->getReportYearly($data);
        return $result;
    }
    
    public function get_report_allyear() {
        $result = $this->report_model->getReportAllYear();
        return $result;
    }
    
}

/* End of file help.php */
/* Location: ./application/controllers/help.php */