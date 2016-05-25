<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Help extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('stator');
    }

    public function index() {
        $data['title'] = 'Bantuan - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'help/about_mikrostator';

        $this->load->view('header', $data);
        $this->load->view('help', $data);
        $this->load->view('footer');
    }
    
    
    function about_mikrostator(){
        
        $data['title'] = 'Tentang MIKROSTATOR - Bantuan - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'help/about_mikrostator';

        $this->load->view('header', $data);
        $this->load->view('help', $data);
        $this->load->view('footer');
    }
    
    function bookmark(){
        
        $data['title'] = 'Bookmark - Bantuan - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'help/bookmark';

        $this->load->view('header', $data);
        $this->load->view('help', $data);
        $this->load->view('footer');
    }
    
    function icon_list(){
        
        $data['title'] = 'Daftar Icon - Bantuan - MIKROSTATOR';
        $data['listmenu'] = $this->stator->getListMenu();
        
        $data['sub_page'] = 'help/icon_list';

        $this->load->view('header', $data);
        $this->load->view('help', $data);
        $this->load->view('footer');
    }
    
}

/* End of file help.php */
/* Location: ./application/controllers/help.php */