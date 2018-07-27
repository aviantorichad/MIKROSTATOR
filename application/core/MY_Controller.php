<?php

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        
        //global
        define('KODE_UNIK','@aviantorichad');
        define('PILIHAN_ITEM','Silakan pilih');
        define('INTERNAL_ERROR','Kesalahan internal.');
        define('NO_ORIGIN_HEADER','Ilegal operation.');
        define('CSRF_TOKEN','@aviantorichad');
        define('PILIH_SESSION','Please select session.');
                
        //login
        define('VALIDASI_LOGIN_BELUM_INPUT','Silakan masuk untuk mengakses menu utama.');
        define('VALIDASI_LOGIN_SALAH','Username/Email atau Password tidak benar.');
        
        //data
        define('SIMPAN_DATA_SUKSES','Data berhasil disimpan.');
        define('SIMPAN_DATA_GAGAL','Gagal menyimpan data.');
        define('UBAH_DATA_SUKSES','Data berhasil diubah.');
        define('UBAH_DATA_GAGAL','Gagal mengubah data.');
        define('HAPUS_DATA_SUKSES','Item terpilih berhasil dihapus.');
        define('HAPUS_DATA_GAGAL','Gagal menghapus item terpilih.');
        define('TANYA_HAPUS_DATA','Apa anda yakin menghapus item ini?');
        define('TANYA_KELUAR_APLIKASI','Apa anda yakin ingin keluar?');
        define('TIDAK_ADA_DATA','Data tidak ada.');
        
        //email
        define('EMAIL_TERKIRIM','Email terkirim.');
        define('EMAIL_TIDAK_TERKIRIM','Email tidak terkirim.');
        define('EMAIL_TIDAK_TERDAFTAR','Email tidak terdaftar.');
        define('EMAIL_BELUM_INPUT','Silakan isi email anda.');
    }

}

class Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('is_login') == FALSE) {
            $this->session->set_flashdata('message', $this->rich_model->show_msg_info('Silakan login terlebih dahulu!'));
            redirect('login');
        }
    }

}

?>
