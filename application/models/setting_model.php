<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('stator');
        $this->load->model('log');
    }

//***MODEL SETTING.start
    function prosesUpdateLoginRouter($data = array()) {
        $host = $data['host'];
        $username = $data['username'];
        $password = $data['password'];
        $port = $data['port'];
        $interval = $data['interval'];
        $autobackup = $data['autobackup'];
        $query = $this->db->query("UPDATE wk_config SET config_mt_host = '" . $host . "', config_mt_username = '" . $username . "', config_mt_password = '" . $password . "', config_mt_port= '" . $port . "', config_wk_interval= '" . $interval . "', config_wk_autobackup= '" . $autobackup . "'");
        if ($query) {
            $this->mikrostator->set('host', $host);
            $this->mikrostator->set('port', $port);
            $this->mikrostator->set('username', $username);
            $this->mikrostator->set('password', $password);
            $this->mikrostator->set('interval', $interval);
            $this->mikrostator->set('autobackup', $autobackup);
            return 'KONFIGURASI Login Router BERHASIL diupdate.';
        } else {
            return 'Error: ' . $this->db->_error_message();
        }
    }

    function getBackgroundMac() {
        ?>
        <script>
            function add_background_mac()
            {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //$('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Tambah Background MAC'); // Set Title to Bootstrap modal title
                $('#modal_form').modal({
                    backdrop: false
                });
                //https://silviomoreto.github.io/bootstrap-select/
                //$('.selectpicker').selectpicker({
                //    size: 4
                //  });
            }
            
            function editBackgroundMacById(id)
            {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url : "<?php echo base_url('setting/edit_background_mac'); ?>/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="id"]').val(data.mac_id);
                        $('[name="nama"]').val(data.mac_address);
                        $('[name="bgcolor"]').val(data.mac_bgcolor);
                        $('[name="keterangan"]').val(data.mac_note);
                        //$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Edit Background MAC'); // Set title to Bootstrap modal title
                        $('#modal_form').modal({
                                backdrop: false
                            });
                    },
                    error: function(event, textStatus, errorThrown) {
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    },
                });
            }
                        
        function save() {
            if(save_method == 'add') {
                url = "<?php echo site_url('setting/simpan_tambah_background_mac')?>";
                konfirmasi = confirm('Apa kamu yakin ingin MENAMBAHKAN WARNA MAC baru?');
            } else {
                url = "<?php echo site_url('setting/simpan_update_background_mac')?>";
                konfirmasi = confirm('Apa kamu yakin ingin MENGUBAH data MAC tersebut?');
            }
            if (konfirmasi) {
                $('#luding').show();
                $('#lbl_msg').fadeOut('slow');
                $('#btnTambah').prop('disabled', true);
                id = $('[name="id"]').val();
                nama = $('[name="nama"]').val();
                bgcolor = $('[name="bgcolor"]').val();
                keterangan = $('[name="keterangan"]').val();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: 'id='+id+'&nama='+nama+'&bgcolor='+bgcolor+'&keterangan='+keterangan,
                    success: function(data) {
                        //resetForm();
                        $('#modal_form').modal('hide');
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html(data);
                        getBaruSaja();
                        getBackgroundMac();
                    },
                    error: function(event, textStatus, errorThrown) {
                        //resetForm();
                        $('#modal_form').modal('hide');
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    }
                })
            }
            return false;
        }
        
        function hapusBackgroundMac(id, nama) {
                cek = confirm('Apa kamu yakin ingin MENGHAPUS WARNA MAC ' + nama);
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo base_url('setting/hapus_background_mac') ?>",
                        dataType: 'HTML',
                        data: 'id='+id+'&nama=' + nama,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            getBaruSaja();
                            getBackgroundMac();
                        },
                        error: function(event, textStatus, errorThrown) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                        },
                        timeout: 30000
                    })
                }
                return false;
            }
        </script>
<!-- Bootstrap modal -->
        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Formulir Background MAC</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="id"/>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nama</label>
                                    <div class="col-md-9">
                                        <input name="nama" placeholder="MAC Address" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Warna Background</label>
                                    <div class="col-md-9">
                                        <input name="bgcolor" placeholder="Warna Background" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Keterangan</label>
                                    <div class="col-md-9">
                                        <input name="keterangan" placeholder="Keterangan" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal -->
        <div class="form-group"> 
            <button type="button" class="btn btn-primary" onclick="add_background_mac()"><i class="glyphicon glyphicon-plus"></i>  TAMBAH</button>
            
        </div>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered" id="table_background_mac" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap" title="mac address">MAC ADDRESS</th>
                        <th class="text-nowrap" title="background color">BG COLOR</th>
                        <th class="text-nowrap" title="notes">KETERANGAN</th>
                        <th class="text-nowrap" title="aksi"><center><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $query = $this->db->query("SELECT * FROM wk_mac ORDER BY mac_id DESC");
                    foreach ($query->result() as $row):
                        $mac_id = $row->mac_id;
                        $mac_address = $row->mac_address;
                        $mac_bgcolor = $row->mac_bgcolor;
                        $mac_note = $row->mac_note;
                        ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $mac_address; ?></td>
                            <td class="text-nowrap" style="background-color: <?php echo $mac_bgcolor; ?>"><?php echo $mac_bgcolor; ?></td>
                            <td class="text-nowrap"><?php echo $mac_note; ?></td>
                            <td class="text-nowrap"><center><a href="javascript:void(0)" onclick="editBackgroundMacById('<?php echo $mac_id; ?>')" title="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="hapusBackgroundMac('<?php echo $mac_id; ?>', '<?php echo $mac_address; ?>')" title="HAPUS <?php echo $mac_address; ?>!"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></center></td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_background_mac').DataTable({
                });
            });
        </script>
        <?php
    }

    function getMainMenu() {
        ?>
        <script>
            function add_main_menu()
            {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //$('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Tambah Menu'); // Set Title to Bootstrap modal title
                $('#modal_form').modal({
                    backdrop: false
                });
                //https://silviomoreto.github.io/bootstrap-select/
                //$('.selectpicker').selectpicker({
                //    size: 4
                //  });

            }
            
            function editMainMenuById(id)
            {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url : "<?php echo base_url('setting/edit_main_menu'); ?>/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="id"]').val(data.menu_id);
                        $('[name="nama"]').val(data.menu_name);
                        $('[name="link"]').val(data.menu_link);
                        $('[name="icon"]').val(data.menu_icon);
                        $('[name="atribut"]').val(data.menu_etc);
                        $('[name="keterangan"]').val(data.menu_note);
                        $('[name="urutan"]').val(data.menu_order);
                        //$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Edit Main Menu'); // Set title to Bootstrap modal title
                        $('#modal_form').modal({
                                backdrop: false
                            });
                    },
                    error: function(event, textStatus, errorThrown) {
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    },
                });
            }
                        
        function save() {
            if(save_method == 'add') {
                url = "<?php echo site_url('setting/simpan_tambah_main_menu')?>";
                konfirmasi = confirm('Apa kamu yakin ingin MENAMBAHKAN MENU baru?');
            } else {
                url = "<?php echo site_url('setting/simpan_update_main_menu')?>";
                konfirmasi = confirm('Apa kamu yakin ingin MENGUBAH data MENU tersebut?');
            }
            if (konfirmasi) {
                $('#luding').show();
                $('#lbl_msg').fadeOut('slow');
                $('#btnTambah').prop('disabled', true);
                id = $('[name="id"]').val();
                nama = $('[name="nama"]').val();
                link = $('[name="link"]').val();
                icon = $('[name="icon"]').val();
                atribut = $('[name="atribut"]').val();
                keterangan = $('[name="keterangan"]').val();
                urutan = $('[name="urutan"]').val();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: 'id='+id+'&nama='+nama+'&link='+link+'&icon='+icon+'&atribut='+atribut+'&keterangan='+keterangan+'&urutan='+urutan,
                    success: function(data) {
                        //resetForm();
                        $('#modal_form').modal('hide');
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html(data);
                        getBaruSaja();
                        getMainMenu();
                    },
                    error: function(event, textStatus, errorThrown) {
                        //resetForm();
                        $('#modal_form').modal('hide');
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    }
                })
            }
            return false;
        }
        
        function hapusMainMenu(id, nama) {
                cek = confirm('Apa kamu yakin ingin MENGHAPUS MENU ' + nama);
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo base_url('setting/hapus_main_menu') ?>",
                        dataType: 'HTML',
                        data: 'id='+id+'&nama=' + nama,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            getBaruSaja();
                            getMainMenu();
                        },
                        error: function(event, textStatus, errorThrown) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                        },
                        timeout: 30000
                    })
                }
                return false;
            }
        </script>
        <!-- Bootstrap modal -->
        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Formulir Main Menu</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="id"/>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nama</label>
                                    <div class="col-md-9">
                                        <input name="nama" placeholder="Nama Menu" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Link</label>
                                    <div class="col-md-9">
                                        <input name="link" placeholder="Link/Tautan" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Icon</label>
                                    <div class="col-md-9">
                                        <input name="icon" placeholder="Icon" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Atribut</label>
                                    <div class="col-md-9">
                                        <input name="atribut" placeholder="Atribut Tambahan" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Keterangan</label>
                                    <div class="col-md-9">
                                        <input name="keterangan" placeholder="Keterangan" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Urutan</label>
                                    <div class="col-md-9">
                                        <input name="urutan" placeholder="Urutan" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal -->
        <div class="form-group"> 
            <button type="button" class="btn btn-primary" onclick="add_main_menu()"><i class="glyphicon glyphicon-plus"></i>  TAMBAH</button>
            
        </div>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered" id="table_main_menu" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap" title="menu order">URUTAN</th>
                        <th class="text-nowrap" title="menu name">NAMA</th>
                        <th class="text-nowrap" title="menu link">LINK</th>
                        <th class="text-nowrap" title="menu icon">ICON - NAME</th>
                        <th class="text-nowrap" title="menu attribute">ATRIBUT</th>
                        <th class="text-nowrap" title="menu notes">KETERANGAN</th>
                        <th class="text-nowrap" title="aksi"><center><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $query = $this->db->query("SELECT * FROM wk_menu ORDER BY menu_order ASC");
                    foreach ($query->result() as $row):
                        $menu_id = $row->menu_id;
                        $menu_name = $row->menu_name;
                        $menu_link = $row->menu_link;
                        $menu_note = $row->menu_note;
                        $menu_icon = $row->menu_icon;
                        $menu_etc = $row->menu_etc;
                        $menu_order = $row->menu_order;
                        ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $menu_order; ?></td>
                            <td class="text-nowrap"><?php echo $menu_name; ?></td>
                            <td class="text-nowrap"><?php echo $menu_link; ?></td>
                            <td class="text-nowrap"><span class="glyphicon ' . <?php echo $menu_icon; ?> . '" aria-hidden="true"/> - <?php echo $menu_icon; ?></td>
                            <td class="text-nowrap"><?php echo $menu_etc; ?></td>
                            <td class="text-nowrap"><?php echo $menu_note; ?></td>
                            <td class="text-nowrap"><center><a href="javascript:void(0)" onclick="editMainMenuById('<?php echo $menu_id; ?>')" title="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="hapusMainMenu('<?php echo $menu_id; ?>', '<?php echo $menu_name; ?>')" title="HAPUS <?php echo $menu_name; ?>!"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></center></td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_main_menu').DataTable({
                });
            });
        </script>
        <?php
    }
    
    function getGadgetList() {
        ?>
        <script>
            function add_gadget_list()
            {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //$('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Tambah Pilihan Gadget'); // Set Title to Bootstrap modal title
                $('#modal_form').modal({
                    backdrop: false
                });
                //https://silviomoreto.github.io/bootstrap-select/
                //$('.selectpicker').selectpicker({
                //    size: 4
                //  });

            }
            
            function editGadgetListById(id)
            {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url : "<?php echo base_url('setting/edit_gadget_list'); ?>/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="id"]').val(data.list_id);
                        $('[name="nama"]').val(data.list_name);
                        $('[name="value"]').val(data.list_value);
                        $('[name="keterangan"]').val(data.list_note);
                        $('[name="icon"]').val(data.list_icon);
                        $('[name="atribut"]').val(data.list_etc);
                        $('[name="urutan"]').val(data.list_order);
                        //$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Edit Pilihan Gadget'); // Set title to Bootstrap modal title
                        $('#modal_form').modal({
                                backdrop: false
                            });
                    },
                    error: function(event, textStatus, errorThrown) {
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    },
                });
            }
                        
        function save() {
            if(save_method == 'add') {
                url = "<?php echo site_url('setting/simpan_tambah_gadget_list')?>";
                konfirmasi = confirm('Apa kamu yakin ingin MENAMBAHKAN PILIHAN GADGET baru?');
            } else {
                url = "<?php echo site_url('setting/simpan_update_gadget_list')?>";
                konfirmasi = confirm('Apa kamu yakin ingin MENGUBAH data PILIHAN GADGET tersebut?');
            }
            if (konfirmasi) {
                $('#luding').show();
                $('#lbl_msg').fadeOut('slow');
                $('#btnTambah').prop('disabled', true);
                id = $('[name="id"]').val();
                nama = $('[name="nama"]').val();
                value = $('[name="value"]').val();
                keterangan = $('[name="keterangan"]').val();
                icon = $('[name="icon"]').val();
                atribut = $('[name="atribut"]').val();
                urutan = $('[name="urutan"]').val();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: 'id='+id+'&nama='+nama+'&value='+value+'&keterangan='+keterangan+'&icon='+icon+'&atribut='+atribut+'&urutan='+urutan,
                    success: function(data) {
                        //resetForm();
                        $('#modal_form').modal('hide');
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html(data);
                        getBaruSaja();
                        getGadgetList();
                    },
                    error: function(event, textStatus, errorThrown) {
                        //resetForm();
                        $('#modal_form').modal('hide');
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    }
                })
            }
            return false;
        }
        
        function hapusGadgetList(id, nama) {
                cek = confirm('Apa kamu yakin ingin MENGHAPUS PILIHAN GADGET ' + nama);
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo base_url('setting/hapus_gadget_list') ?>",
                        dataType: 'HTML',
                        data: 'id='+id+'&nama=' + nama,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            getBaruSaja();
                            getGadgetList();
                        },
                        error: function(event, textStatus, errorThrown) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                        },
                        timeout: 30000
                    })
                }
                return false;
            }
        </script>
        <!-- Bootstrap modal -->
        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Formulir Pilihan Gadget</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="id"/>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nama</label>
                                    <div class="col-md-9">
                                        <input name="nama" placeholder="Nama" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Value</label>
                                    <div class="col-md-9">
                                        <input name="value" placeholder="Value" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Keterangan</label>
                                    <div class="col-md-9">
                                        <input name="keterangan" placeholder="Keterangan" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Icon</label>
                                    <div class="col-md-9">
                                        <input name="icon" placeholder="Icon" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Atribut</label>
                                    <div class="col-md-9">
                                        <input name="atribut" placeholder="Atribut Tambahan" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Urutan</label>
                                    <div class="col-md-9">
                                        <input name="urutan" placeholder="Urutan" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal -->
        <div class="form-group"> 
            <button type="button" class="btn btn-primary" onclick="add_gadget_list()"><i class="glyphicon glyphicon-plus"></i>  TAMBAH</button>
            
        </div>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered" id="table_gadget_list" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap">NAMA</th>
                        <th class="text-nowrap">VALUE</th>
                        <th class="text-nowrap">ICON - NAME</th>
                        <th class="text-nowrap">ATRIBUT</th>
                        <th class="text-nowrap">KETERANGAN</th>
                        <th class="text-nowrap">URUTAN</th>
                        <th class="text-nowrap" title="aksi"><center><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $query = $this->db->query("SELECT * FROM wk_list WHERE list_type='select_gadget' ORDER BY list_order ASC");
                    foreach ($query->result() as $row):
                        $list_id = $row->list_id;
                        $list_name = $row->list_name;
                        $list_value = $row->list_value;
                        $list_note = $row->list_note;
                        $list_icon = $row->list_icon;
                        $list_etc = $row->list_etc;
                        $list_order = $row->list_order;
                        ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $list_name; ?></td>
                            <td class="text-nowrap"><?php echo $list_value; ?></td>
                            <td class="text-nowrap"><span class="glyphicon ' . <?php echo $list_icon; ?> . '" aria-hidden="true"/> - <?php echo $list_icon; ?></td>
                            <td class="text-nowrap"><?php echo $list_etc; ?></td>
                            <td class="text-nowrap"><?php echo $list_note; ?></td>
                            <td class="text-nowrap"><?php echo $list_order; ?></td>
                            <td class="text-nowrap"><center><a href="javascript:void(0)" onclick="editGadgetListById('<?php echo $list_id; ?>')" title="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="hapusGadgetList('<?php echo $list_id; ?>', '<?php echo $list_name; ?>')" title="HAPUS <?php echo $list_name; ?>!"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></center></td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_gadget_list').DataTable({
                });
            });
        </script>
        <?php
    }
    
    function getUserAdmin() {
        ?>
        <script>
            function add_user_admin()
            {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //$('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Tambah Administator'); // Set Title to Bootstrap modal title
                $('#modal_form').modal({
                    backdrop: false
                });
                $('[name="ad_username"]').prop("readonly", false);
                //https://silviomoreto.github.io/bootstrap-select/
                //$('.selectpicker').selectpicker({
                //    size: 4
                //  });

            }
            
            function editUserAdminById(id)
            {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url : "<?php echo base_url('setting/edit_user_admin'); ?>/" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        $('[name="id"]').val(data.member_id);
                        $('[name="nama"]').val(data.member_name);
                        $('[name="ad_username"]').val(data.member_username);
                        $('[name="ad_password"]').val(atob(data.member_password));
                        $('[name="keterangan"]').val(data.member_notes);
                        //$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Edit Administrator'); // Set title to Bootstrap modal title
                        $('#modal_form').modal({
                                backdrop: false
                            });
                        $('[name="ad_username"]').prop("readonly", true);
                    },
                    error: function(event, textStatus, errorThrown) {
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    },
                });
            }
                        
        function save() {
            if(save_method == 'add') {
                url = "<?php echo site_url('setting/simpan_tambah_user_admin')?>";
                konfirmasi = confirm('Apa kamu yakin ingin MENAMBAHKAN ADMIN baru?');
            } else {
                url = "<?php echo site_url('setting/simpan_update_user_admin')?>";
                konfirmasi = confirm('Apa kamu yakin ingin MENGUBAH data ADMIN tersebut?');
            }
            if (konfirmasi) {
                $('#luding').show();
                $('#lbl_msg').fadeOut('slow');
                $('#btnTambah').prop('disabled', true);
                id = $('[name="id"]').val();
                nama = $('[name="nama"]').val();
                username = $('[name="ad_username"]').val();
                password = $('[name="ad_password"]').val();
                keterangan = $('[name="keterangan"]').val();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: 'id='+id+'&nama='+nama+'&username='+username+'&password='+password+'&keterangan='+keterangan,
                    success: function(data) {
                        //resetForm();
                        $('#modal_form').modal('hide');
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html(data);
                        getBaruSaja();
                        getUserAdmin();
                    },
                    error: function(event, textStatus, errorThrown) {
                        //resetForm();
                        $('#modal_form').modal('hide');
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    }
                })
            }
            return false;
        }
        
        function hapusUserAdmin(id, nama) {
                cek = confirm('Apa kamu yakin ingin MENGHAPUS ADMIN ' + nama);
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo base_url('setting/hapus_user_admin') ?>",
                        dataType: 'HTML',
                        data: 'id='+id+'&nama=' + nama,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            getBaruSaja();
                            getUserAdmin();
                        },
                        error: function(event, textStatus, errorThrown) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                        },
                        timeout: 30000
                    })
                }
                return false;
            }
        </script>
        <!-- Bootstrap modal -->
        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Formulir Administrator</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="id"/>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nama</label>
                                    <div class="col-md-9">
                                        <input name="nama" placeholder="Nama" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Username</label>
                                    <div class="col-md-9">
                                        <input name="ad_username" placeholder="Username" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Password</label>
                                    <div class="col-md-9">
                                        <input name="ad_password" placeholder="Password" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Keterangan</label>
                                    <div class="col-md-9">
                                        <input name="keterangan" placeholder="Keterangan" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal -->
        <div class="form-group"> 
            <button type="button" class="btn btn-primary" onclick="add_user_admin()"><i class="glyphicon glyphicon-plus"></i>  TAMBAH</button>
            
        </div>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered" id="table_gadget_list" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap">NAMA</th>
                        <th class="text-nowrap">USERNAME</th>
                        <th class="text-nowrap">PASSWORD</th>
                        <th class="text-nowrap">KETERANGAN</th>
                        <th class="text-nowrap">TERAKHIR MASUK</th>
                        <th class="text-nowrap">TERDAFTAR</th>
                        <th class="text-nowrap" title="aksi"><center><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $query = $this->db->query("SELECT * FROM wk_member ORDER BY member_name ASC");
                    foreach ($query->result() as $row):
                        $member_id = $row->member_id;
                        $member_name = $row->member_name;
                        $member_username = $row->member_username;
                        $member_password = $row->member_password;
                        $member_note = $row->member_notes;
                        $member_registered = date('d/m/Y H:i:s', strtotime($row->member_registered));
                        $member_lastlogin = date('d/m/Y H:i:s', strtotime($row->member_lastlogin));
                        $delete_user_admin = '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                        if($member_username != $this->session->userdata('username')){
                            $delete_user_admin = '<a href="javascript:void(0)" onclick="hapusUserAdmin(\''.$member_id.'\', \''.$member_name.'\')" title="HAPUS '.$member_name.'!"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                        }
                        ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $member_name; ?></td>
                            <td class="text-nowrap"><?php echo $member_username; ?></td>
                            <td class="text-nowrap"><?php echo $member_password; ?></td>
                            <td class="text-nowrap"><?php echo $member_note; ?></td>
                            <td class="text-nowrap" title="<?php echo $member_lastlogin; ?>"><?php echo $this->stator->timeAgo(strtotime($row->member_lastlogin)); ?></td>
                            <td class="text-nowrap"><?php echo $member_registered; ?></td>
                            <td class="text-nowrap"><center><a href="javascript:void(0)" onclick="editUserAdminById('<?php echo $member_id; ?>')" title="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $delete_user_admin; ?></center></td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_gadget_list').DataTable({
                });
            });
        </script>
        <?php
    }
    
    
    function prosesTambahMainMenu($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        //$id = $data['id'];
        $nama = $data['nama'];
        $link = $data['link'];
        $icon = $data['icon'];
        $atribut = $data['atribut'];
        $keterangan = $data['keterangan'];
        $urutan = $data['urutan'];
        
        $data = array(
                'menu_name' => $nama,
                'menu_link' => $link,
                'menu_icon' => $icon,
                'menu_note' => $keterangan,
                'menu_etc' => $atribut,
                'menu_order' => $urutan,
            );
        $this->db->insert('wk_menu', $data);
        if($this->db->affected_rows() > 0) {
            $msg = "MENU $nama BERHASIL DITAMBAHKAN via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENAMBAHKAN MENU $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }
    
    function prosesUpdateMainMenu($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        $id = $data['id'];
        $nama = $data['nama'];
        $link = $data['link'];
        $icon = $data['icon'];
        $atribut = $data['atribut'];
        $keterangan = $data['keterangan'];
        $urutan = $data['urutan'];
        
        $data = array(
                'menu_name' => $nama,
                'menu_link' => $link,
                'menu_icon' => $icon,
                'menu_note' => $keterangan,
                'menu_etc' => $atribut,
                'menu_order' => $urutan,
            );
        
        $this->db->where('menu_id', $id);
        $this->db->update('wk_menu', $data);

        if($this->db->affected_rows() > 0) {
            $msg = "MENU $nama BERHASIL DIUPDATE via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENGUPDATE MENU $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }
        
    function getMainMenuById($id){
        $query = $this->db->query("SELECT * FROM wk_menu WHERE menu_id = '".$id."'");
        return $query->row();
    }
    
    function prosesHapusMainMenu($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        $id = $data['id'];
        $nama = $data['nama'];
        //return print_r($data);

        $this->db->where('menu_id', $id);
        $this->db->delete('wk_menu');

        if($this->db->affected_rows() > 0) {
            $msg = "MENU $nama BERHASIL DIHAPUS via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENGHAPUS MENU $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }
    
    
    
    function prosesTambahBackgroundMac($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        //$id = $data['id'];
        $nama = $data['nama'];
        $bgcolor = $data['bgcolor'];
        $keterangan = $data['keterangan'];
        
        $data = array(
                'mac_address' => $nama,
                'mac_bgcolor' => $bgcolor,
                'mac_note' => $keterangan,
            );
        $this->db->insert('wk_mac', $data);
        if($this->db->affected_rows() > 0) {
            $msg = "BACKGROUND MAC $nama BERHASIL DITAMBAHKAN via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENAMBAHKAN BACKGROUND MAC $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }
    
    function prosesUpdateBackgroundMac($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        $id = $data['id'];
        $nama = $data['nama'];
        $bgcolor = $data['bgcolor'];
        $keterangan = $data['keterangan'];
        
        $data = array(
                'mac_address' => $nama,
                'mac_bgcolor' => $bgcolor,
                'mac_note' => $keterangan,
            );
        
        $this->db->where('mac_id', $id);
        $this->db->update('wk_mac', $data);

        if($this->db->affected_rows() > 0) {
            $msg = "BACKGROUND MAC $nama BERHASIL DIUPDATE via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENGUPDATE BACKGROUND MAC $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }
        
    function getBackgroundMacById($id){
        $query = $this->db->query("SELECT * FROM wk_mac WHERE mac_id = '".$id."'");
        return $query->row();
    }
    
    function prosesHapusBackgroundMac($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        $id = $data['id'];
        $nama = $data['nama'];
        //return print_r($data);

        $this->db->where('mac_id', $id);
        $this->db->delete('wk_mac');

        if($this->db->affected_rows() > 0) {
            $msg = "BACKGROUND MAC $nama BERHASIL DIHAPUS via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENGHAPUS BACKGROUND MAC $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }


    
    function prosesTambahGadgetList($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        //$id = $data['id'];
        $nama = $data['nama'];
        $value = $data['value'];
        $icon = $data['icon'];
        $atribut = $data['atribut'];
        $keterangan = $data['keterangan'];
        $urutan = $data['urutan'];
        
        $data = array(
                'list_name' => $nama,
                'list_value' => $value,
                'list_icon' => $icon,
                'list_note' => $keterangan,
                'list_etc' => $atribut,
                'list_order' => $urutan,
                'list_type' => 'select_gadget',
            );
        $this->db->insert('wk_list', $data);
        if($this->db->affected_rows() > 0) {
            $msg = "PILIHAN GADGET $nama BERHASIL DITAMBAHKAN via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENAMBAHKAN PILIHAN GADGET $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }
    
    function prosesUpdateGadgetList($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        $id = $data['id'];
        $nama = $data['nama'];
        $value = $data['value'];
        $icon = $data['icon'];
        $atribut = $data['atribut'];
        $keterangan = $data['keterangan'];
        $urutan = $data['urutan'];
        
        $data = array(
                'list_name' => $nama,
                'list_value' => $value,
                'list_icon' => $icon,
                'list_note' => $keterangan,
                'list_etc' => $atribut,
                'list_order' => $urutan,
                'list_type' => 'select_gadget',
            );
        
        $this->db->where('list_id', $id);
        $this->db->update('wk_list', $data);

        if($this->db->affected_rows() > 0) {
            $msg = "PILIHAN GADGET $nama BERHASIL DIUPDATE via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENGUPDATE PILIHAN GADGET $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }
        
    function getGadgetListById($id){
        $query = $this->db->query("SELECT * FROM wk_list WHERE list_id = '".$id."'");
        return $query->row();
    }
    
    function prosesHapusGadgetList($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        $id = $data['id'];
        $nama = $data['nama'];
        //return print_r($data);

        $this->db->where('list_id', $id);
        $this->db->delete('wk_list');

        if($this->db->affected_rows() > 0) {
            $msg = "PILIHAN GADGET $nama BERHASIL DIHAPUS via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENGHAPUS PILIHAN GADGET $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }

    
    
    function prosesTambahUserAdmin($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        //$id = $data['id'];
        $nama = $data['nama'];
        $username = $data['username'];
        $password = $data['password'];
        $keterangan = $data['keterangan'];
        
        $data = array(
                'member_name' => $nama,
                'member_username' => $username,
                'member_password' => base64_encode($password),
                'member_notes' => $keterangan,
            );
        $this->db->insert('wk_member', $data);
        if($this->db->affected_rows() > 0) {
            $msg = "ADMIN $nama BERHASIL DITAMBAHKAN via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENAMBAHKAN ADMIN $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }
    
    function prosesUpdateUserAdmin($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        $id = $data['id'];
        $nama = $data['nama'];
        $username = $data['username'];
        $password = $data['password'];
        $keterangan = $data['keterangan'];
        
        $data = array(
                'member_name' => $nama,
                'member_username' => $username,
                'member_password' => base64_encode($password),
                'member_notes' => $keterangan,
            );
        
        $this->db->where('member_id', $id);
        $this->db->update('wk_member', $data);

        if($this->db->affected_rows() > 0) {
            $msg = "ADMIN $nama BERHASIL DIUPDATE via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENGUPDATE ADMIN $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }
        
    function getUserAdminById($id){
        $query = $this->db->query("SELECT * FROM wk_member WHERE member_id = '".$id."'");
        return $query->row();
    }
    
    function prosesHapusUserAdmin($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        $id = $data['id'];
        $nama = $data['nama'];
        //return print_r($data);

        $this->db->where('member_id', $id);
        $this->db->delete('wk_member');

        if($this->db->affected_rows() > 0) {
            $msg = "ADMIN $nama BERHASIL DIHAPUS via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENGHAPUS ADMIN $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }
    

//***MODEL SETTING.end

}

/* End of file setting_model.php */
    /* Location: ./application/models/setting_model.php */