<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hotspot_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('stator');
        $this->load->model('log');
    }

//***MODEL HOTSPOT.start
    function getIpHotspotUser() {
        ?>
        <script>
            function add_ip_hotspot_user()
            {
                save_method = 'add';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //$('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Tambah Pengguna'); // Set Title to Bootstrap modal title
                $('#modal_form').modal({
                    backdrop: false
                });
                $('[name="username"]').prop("readonly", false);
                //https://silviomoreto.github.io/bootstrap-select/
                //$('.selectpicker').selectpicker({
                //    size: 4
                //  });

            }

            function editIpHotspotUserByUsername(username)
            {
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                //Ajax Load data from ajax
                $.ajax({
                    url: "<?php echo base_url() ?>hotspot/edit_ip_hotspot_user/" + username,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        var json_obj = $.parseJSON(data);
                        $('[name="username"]').val(json_obj[0].name);
                        $('[name="password"]').val(json_obj[0].password);
                        $('[name="userprofile"]').val(json_obj[0].profile);
                        //$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Edit Pengguna'); // Set title to Bootstrap modal title
                        $('#modal_form').modal({
                            backdrop: false
                        });
                        $('[name="username"]').prop("readonly", true);

                    },
                    error: function(event, textStatus, errorThrown) {
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    },
                });
            }
            function editIpHotspotUserById(id)
            {
                alert(id);
                save_method = 'update';
                $('#form')[0].reset(); // reset form on modals
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string

                //Ajax Load data from ajax
                $.ajax({
                    url: "<?php echo base_url('hotspot/edit_ip_hotspot_user/') ?>" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {
                        var json_obj = $.parseJSON(data);
                        $('[name="username"]').val(json_obj[0].name);
                        $('[name="password"]').val(json_obj[0].password);
                        //$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                        $('.modal-title').text('Edit Pengguna'); // Set title to Bootstrap modal title
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

            function disable_ip_hotspot_user(user)
            {
                cek = confirm('Apa kamu yakin ingin MEMATIKAN (DISABLE) ' + user);
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo base_url('hotspot/disable_ip_hotspot_user') ?>",
                        dataType: 'HTML',
                        data: 'user=' + user,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            once_load();
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

            function enable_ip_hotspot_user(user)
            {
                cek = confirm('Apa kamu yakin ingin MENGHIDUPKAN (ENABLE) ' + user);
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo base_url('hotspot/enable_ip_hotspot_user') ?>",
                        dataType: 'HTML',
                        data: 'user=' + user,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            getIpHotspotUser();
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

            function save() {
                if (save_method == 'add') {
                    url = "<?php echo site_url('hotspot/simpan_tambah_hotspot_user') ?>";
                    konfirmasi = confirm('Apa kamu yakin ingin MENAMBAHKAN ' + $('[name="username"]').val() + '?');
                } else {
                    url = "<?php echo site_url('hotspot/simpan_update_hotspot_user') ?>";
                    konfirmasi = confirm('Apa kamu yakin ingin MENGUBAH data ' + $('[name="username"]').val() + '?');
                }
                if (konfirmasi) {
                    $('#luding').show();
                    $('#lbl_msg').fadeOut('slow');
                    $('#btnTambah').prop('disabled', true);
                    user = $('[name="username"]').val();
                    password = $('[name="password"]').val();
                    userprofile = $('[name="userprofile"]').val();
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: 'user=' + user + '&password=' + password + '&userprofile=' + userprofile,
                        success: function(data) {
                            //resetForm();
                            $('#modal_form').modal('hide');
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            getBaruSaja();
                            getIpHotspotUser();
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

            function hapusIpHotspotUser(id, user) {
                cek = confirm('Apa kamu yakin ingin MENGHAPUS ' + user);
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo base_url('hotspot/hapus_ip_hotspot_user') ?>",
                        dataType: 'HTML',
                        data: 'id=' + id + '&user=' + user,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            getIpHotspotUser();
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
                        <h3 class="modal-title">Formulir Hotspot User</h3>
                    </div>
                    <div class="modal-body form">
                        <form action="#" id="form" class="form-horizontal">
                            <input type="hidden" value="" name="id"/>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nama</label>
                                    <div class="col-md-9">
                                        <input name="username" placeholder="Username" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Sandi</label>
                                    <div class="col-md-9">
                                        <input name="password" placeholder="Password" class="form-control" type="text" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Profil</label>
                                    <div class="col-md-9">
                                        <select id="userprofile" name="userprofile" class="form-control selectpicker" data-live-search="true" title="Pilih profil pengguna">
                                            <?php
                                            foreach ($this->mikrostator->get('hotspotuserprofile') as $row) {
                                                $uid = $row['.id'];
                                                $name = $row['name'];
                                                echo '<option value="' . $name . '">' . $name . '</option>';
                                            }
                                            ?>
                                        </select>
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
            <button type="button" class="btn btn-primary" onclick="add_ip_hotspot_user()"><i class="glyphicon glyphicon-plus"></i>  TAMBAH</button>
            <button class="btn btn-default" onclick="getIpHotspotUser()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        </div>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>

        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered"  id="table_ip_hotspot_user" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap" title="name">NAMA</th>
                        <th class="text-nowrap" title="password">SANDI</th>
                        <th class="text-nowrap" title="profile">PROFIL</th>
                        <th class="text-nowrap" title="sisa" style="background:#ffcc99;">SISA</th>
                        <th class="text-nowrap" title="limit-uptime">BATAS</th>
                        <th class="text-nowrap" title="uptime">DIPAKAI</th>
                        <th class="text-nowrap" title="bytes-in">UP (MB)</th>
                        <th class="text-nowrap" title="bytes-out">DOWN (MB)</th>
                        <th class="text-nowrap" title="comment">KOMENTAR</th>
                        <th class="text-nowrap" title="sisa menit">SM</th>
                        <th class="text-nowrap" title="nyawa"><center><span class="glyphicon glyphicon-time" aria-hidden="true"></span></center></th>
                <th class="text-nowrap" title="status">STATUS</th>
                <th class="text-nowrap" title="aksi"><center><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $query = $this->mikrostator->baca("/ip/hotspot/user/print");
                    $count_user = count($query);
                    foreach ($query as $row):
                        $uid = $row['.id'];
                        $name = $row['name'];
                        $password = $row['password'];
                        $profile = $row['profile'];
                        $limit_uptime = "";
                        if (isset($row['limit-uptime'])) {
                            $limit_uptime = $row['limit-uptime'];
                        }
                        $uptime = $row['uptime'];
                        $bytes_in = $row['bytes-in'];
                        $bytes_out = $row['bytes-out'];
                        $comment = isset($row['comment'])?$row['comment']:'';
                        $disabled = $row['disabled'];
                        $sisa_time = $this->stator->time_elapsed_A($this->stator->get_menit($limit_uptime, 's') - $this->stator->get_menit($uptime, 's'));
                        $status = 'hidup';
                        $status_msg = '';
                        $hidup_mati = 'hidup / <a href="javascript:void(0)" onclick="disable_ip_hotspot_user(\'' . $name . '\')" title="MATIKAN ' . $name . '!"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
                        if ($disabled == 'true') {
                            $status = 'mati';
                            $status_msg = "style='background-color:#ffaaaa;color:#aaa;' title='tidak aktif (mati)'";
                            $hidup_mati = 'mati / <a href="javascript:void(0)" onclick="enable_ip_hotspot_user(\'' . $name . '\', \'no\')" title="HIDUPKAN ' . $name . '!"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>';
                        }
                        //.list hotspot user.end
                        ?>
                        <tr <?php echo $status_msg; ?>>
                            <td class="text-nowrap"><?php echo $name; ?></td>
                            <td class="text-nowrap" title="<?php echo $password; ?>">***</td>
                            <td class="text-nowrap"><?php echo $profile; ?></td>
                            <td class="text-nowrap" style="background:#ffdfbf;" title="<?php echo "PC:Rp." . floor(($this->stator->get_menit($sisa_time, 's') / 3600) * 2500) . "|" . "HP:Rp." . floor(($this->stator->get_menit($sisa_time, 's') / 3600) * 2000); ?>"><?php echo $sisa_time; ?></td>
                            <td class="text-nowrap"><?php echo $limit_uptime; ?></td>
                            <td class="text-nowrap"><?php echo $uptime; ?></td>
                            <td class="text-nowrap" title="<?php echo $bytes_in; ?>"><?php echo number_format($bytes_in / 1024 / 1024, 2); ?></td>
                            <td class="text-nowrap" title="<?php echo $bytes_out; ?>"><?php echo number_format($bytes_out / 1024 / 1024, 2); ?></td>
                            <td class="text-nowrap"><?php echo $comment; ?></td>
                            <td class="text-nowrap"><?php echo $this->stator->get_menit($sisa_time, 'm'); ?></td>
                            <td class="text-nowrap"><?php echo $this->stator->get_menit($sisa_time, 's'); ?></td>
                            <td class="text-nowrap" title="<?php echo $status; ?>"><?php echo $hidup_mati; ?></td>
                            <td class="text-nowrap"><center><a href="javascript:void(0)" onclick="editIpHotspotUserByUsername('<?php echo $name; ?>')"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="hapusIpHotspotUser('<?php echo $uid; ?>', '<?php echo $name; ?>')" title="HAPUS <?php echo $name; ?>!"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></center></td>
                    </tr>
                    <?php
                endforeach;
                ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_ip_hotspot_user').DataTable({
                });
                $('#count_ip_hotspot_user').html('<?php echo $count_user; ?> ');
            });
        </script>
        <?php
    }

    function getIpHotspotUserProfile() {
        ?>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered"  id="table_ip_hotspot_user_profile" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap" >NAME</th>
                        <th class="text-nowrap" >ADDRESS POOL</th>
                        <th class="text-nowrap" >IDLE TIMEOUT</th>
                        <th class="text-nowrap" >KEEPALIVE TIMEOUT</th>
                        <th class="text-nowrap" >STATUS AUTOREFRESH</th>
                        <th class="text-nowrap" >SHARED USERS</th>
                        <th class="text-nowrap" >ADD MAC COOKIE</th>
                        <th class="text-nowrap" >RATE LIMIT</th>
                        <th class="text-nowrap" >ADDRESS LIST</th>
                        <th class="text-nowrap" >TRANSPARENT PROXY</th>
                        <th class="text-nowrap" >DEFAULT</th>
                        <th class="text-nowrap" >ON LOGIN</th>
                        <th class="text-nowrap" >ON LOGOUT</th>
                        <th class="text-nowrap" >STATUS</th>
                        <th class="text-nowrap" title="aksi"><center><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $query = $this->mikrostator->baca("/ip/hotspot/user/profile/print");
                    foreach ($query as $row):
                        $uid = isset($row['.id']) ? $row['.id'] : '';
                        $name = isset($row['name']) ? $row['name'] : '';
                        $address_pool = isset($row['address-pool']) ? $row['address-pool'] : '';
                        $idle_timeout = isset($row['idle-timeout']) ? $row['idle-timeout'] : '';
                        $keepalive_timeout = isset($row['keepalive-timeout']) ? $row['keepalive-timeout'] : '';
                        $status_autorefresh = isset($row['status-autorefresh']) ? $row['status-autorefresh'] : '';
                        $shared_users = isset($row['shared-users']) ? $row['shared-users'] : '';
                        $add_mac_cookie = isset($row['add-mac-cookie']) ? $row['add-mac-cookie'] : '';
                        $rate_limit = isset($row['rate-limit']) ? $row['rate-limit'] : '';
                        $address_list = isset($row['address-list']) ? $row['address-list'] : '';
                        $transparent_proxy = isset($row['transparent-proxy']) ? $row['transparent-proxy'] : '';
                        $default = isset($row['default']) ? $row['default'] : '';
                        $on_login = isset($row['on-login']) ? $row['on-login'] : '';
                        $on_logout = isset($row['on-logout']) ? $row['on-logout'] : '';
                        ;
                        ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $name; ?></td>
                            <td class="text-nowrap"><?php echo $address_pool; ?></td>
                            <td class="text-nowrap"><?php echo $idle_timeout; ?></td>
                            <td class="text-nowrap"><?php echo $keepalive_timeout; ?></td>
                            <td class="text-nowrap"><?php echo $status_autorefresh; ?></td>
                            <td class="text-nowrap"><?php echo $shared_users; ?></td>
                            <td class="text-nowrap"><?php echo $add_mac_cookie; ?></td>
                            <td class="text-nowrap"><?php echo $rate_limit; ?></td>
                            <td class="text-nowrap"><?php echo $address_list; ?></td>
                            <td class="text-nowrap"><?php echo $transparent_proxy; ?></td>
                            <td class="text-nowrap"><?php echo $default; ?></td>
                            <td class="text-nowrap" title="<?php echo $on_login; ?>"><?php echo substr($on_login, 0, 10); ?></td>
                            <td class="text-nowrap" title="<?php echo $on_logout; ?>"><?php echo substr($on_logout, 0, 10); ?></td>
                            <td class="text-nowrap">hidup</td>
                            <td class="text-nowrap">aksi</td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_ip_hotspot_user_profile').DataTable({
                });
            });
        </script>

        <?php
    }

    function getQueueSimple() {
        ?>
        <script>
            function hapusQueueSimple(id, user) {
                cek = confirm('Apa kamu yakin ingin MENGHAPUS ' + user);
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo base_url('hotspot/hapus_queue_simple') ?>",
                        dataType: 'HTML',
                        data: 'id=' + id + '&user=' + user,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            once_load();
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
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered"  id="table_queue_simple" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap">NAMA</th>
                        <th class="text-nowrap">TARGET</th>
                        <th class="text-nowrap">LIMIT AT</th>
                        <th class="text-nowrap">MAX LIMIT</th>
                        <th class="text-nowrap">BURST LIMIT</th>
                        <th class="text-nowrap">BYTES</th>
                        <th class="text-nowrap">RATE</th>
                        <th class="text-nowrap" title="aksi"><center><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $query = $this->mikrostator->baca("/queue/simple/print");
                    foreach ($query as $row):
                        $uid = $row['.id'];
                        $name = htmlentities($row['name']);
                        $target = $row['target'];
                        $limit_at = $row['limit-at'];
                        $max_limit = $row['max-limit'];
                        $burst_limit = $row['burst-limit'];
                        $bytes = $row['bytes'];
                        $rate = $row['rate'];
                        ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $name; ?></td>
                            <td class="text-nowrap"><?php echo $target; ?></td>
                            <td class="text-nowrap"><?php echo $limit_at; ?></td>
                            <td class="text-nowrap"><?php echo $max_limit; ?></td>
                            <td class="text-nowrap"><?php echo $burst_limit; ?></td>
                            <td class="text-nowrap"><?php echo $bytes; ?></td>
                            <td class="text-nowrap"><?php echo $rate; ?></td>
                            <td class="text-nowrap"><center><a href="javascript:void(0)" onclick="hapusQueueSimple('<?php echo $uid; ?>', '<?php echo $name; ?>')" title="HAPUS <?php echo $name; ?>!"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></center></td>
                    </tr>
                    <?php
                endforeach;
                ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_queue_simple').DataTable({
                });
            });
        </script>

        <?php
    }

    
    function getDhcpServerLeases() {
        ?>
        <script>
            function hapusDhcpServerLeases(id, user) {
                cek = confirm('Apa kamu yakin ingin MENGHAPUS ' + user);
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo base_url('hotspot/hapus_dhcp_server_leases') ?>",
                        dataType: 'HTML',
                        data: 'id=' + id + '&user=' + user,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            once_load();
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
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered"  id="table_dhcp_server_leases" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap">ADDRESS</th>
                        <th class="text-nowrap">MAC</th>
                        <th class="text-nowrap">HOST NAME</th>
                        <th class="text-nowrap">SERVER</th>
                        <th class="text-nowrap">EXPIRES AFTER</th>
                        <th class="text-nowrap">LAST SEEN</th>
                        <th class="text-nowrap">ACTIVE ADDRESS</th>
                        <th class="text-nowrap">ACTIVE MAC ADDRESS</th>
                        <th class="text-nowrap" title="aksi"><center><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    //{".id":"*48","address":"192.168.64.113","mac-address":"00:1A:96:49:84:DE",
                    //"address-lists":"","server":"rt.dhcp","dhcp-option":"",
                    //"status":"bound","expires-after":"59m34s",
                    //"last-seen":"26s","active-address":"192.168.64.113",
                    //"active-mac-address":"00:1A:96:49:84:DE",
                    //"active-server":"rt.dhcp","host-name":"android-570d7aade7c461a6",
                    //"radius":"false","dynamic":"true","blocked":"false","disabled":"false"},
                    $query = $this->mikrostator->baca("/ip/dhcp-server/lease/print");
                    foreach ($query as $row):
                        $id = $row['.id'];
                        $address = $row['address'];
                        $mac = $row['mac-address'];
                        $host_name = $row['host-name'];
                        $server = $row['server'];
                        $expires_after = $row['expires-after'];
                        $last_seen = $row['last-seen'];
                        $active_address = $row['active-address'];
                        $active_mac_address = $row['active-mac-address'];
                        ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $address; ?></td>
                            <td class="text-nowrap"><?php echo $mac; ?></td>
                            <td class="text-nowrap"><?php echo $host_name; ?></td>
                            <td class="text-nowrap"><?php echo $server; ?></td>
                            <td class="text-nowrap"><?php echo $expires_after; ?></td>
                            <td class="text-nowrap"><?php echo $last_seen; ?></td>
                            <td class="text-nowrap"><?php echo $active_address; ?></td>
                            <td class="text-nowrap"><?php echo $active_mac_address; ?></td>
                            <td class="text-nowrap"><center><a href="javascript:void(0)" onclick="hapusDhcpServerLeases('<?php echo $id; ?>', '<?php echo $address; ?>')" title="HAPUS <?php echo $address; ?>!"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></center></td>
                    </tr>
                    <?php
                endforeach;
                ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_dhcp_server_leases').DataTable({
                });
            });
        </script>

        <?php
    }

    
    public function get_ip_hotspot_user_by_username($username) {
        $query = $this->mikrostator->baca("/ip/hotspot/user/print", array(
            "?name" => $username,
        ));
        return json_encode($query);
    }

    public function get_ip_hotspot_user_by_id($id) {
        $query = $this->mikrostator->baca("/ip/hotspot/user/print", array(
            "?.id" => $id,
        ));
        return json_encode($query);
    }

    function prosesDisableIpHotspotUser($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $user = $data['user'];

        $ARRAY = $this->mikrostator->disableIpHotspotUser($user);

        if (count($ARRAY) == 0) { //.0 berarti tidak ada pesan tambahan/sukses
            $msg = "$user BERHASIL DI-DISABLE via $iptujuan";
            $this->mikrostator->tulis2("/log/info", array(
                "message" => "$msg",
            ));
            $this->log->writeLog($msg);
            return $msg;
        } else {
//.gagal menambakan di mikrotik
            if ($ARRAY['!trap'][0]['message']) {
                $msg = "GAGAL MEN-DISABLE $user, SILAHKAN COBA LAGI!. msg: " . $ARRAY['!trap'][0]['message'];
            } else {
                $msg = "GAGAL MEN-DISABLE $user, SILAHKAN COBA LAGI!. msg: unknown error";
            }
            $this->log->writeLog($msg);
            return $msg;
        }
    }

    function prosesEnableIpHotspotUser($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $user = $data['user'];

        $ARRAY = $this->mikrostator->enableIpHotspotUser($user);

        if (count($ARRAY) == 0) { //.0 berarti tidak ada pesan tambahan/sukses
            $msg = "$user BERHASIL DI-ENABLE via $iptujuan";
            $this->mikrostator->tulis2("/log/info", array(
                "message" => "$msg",
            ));
            $this->log->writeLog($msg);
            return $msg;
        } else {
//.gagal menambakan di mikrotik
            if ($ARRAY['!trap'][0]['message']) {
                $msg = "GAGAL MENG-ENABLE $user, SILAHKAN COBA LAGI!. msg: " . $ARRAY['!trap'][0]['message'];
            } else {
                $msg = "GAGAL MENG-ENABLE $user, SILAHKAN COBA LAGI!. msg: unknown error";
            }
            $this->log->writeLog($msg);
            return $msg;
        }
    }

    function prosesHapusQueueSimple($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $id = $data['id'];
        $user = htmlentities($data['user']);

        $ARRAY = $this->mikrostator->tulis2('/queue/simple/remove', array(
            ".id" => $id,
        ));

        if (count($ARRAY) == 0) { //.0 berarti tidak ada pesan tambahan/sukses
            $msg = "QUEUE SIMPLE $user BERHASIL DIHAPUS via $iptujuan";
            $this->mikrostator->tulis2("/log/info", array(
                "$msg",
            ));
            $this->log->writeLog($msg);
            return $msg;
        } else {
//.gagal menambakan di mikrotik
            if ($ARRAY['!trap'][0]['message']) {
                $msg = "GAGAL MENGHAPUS QUEUE SIMPLE $user, SILAHKAN COBA LAGI!. msg: " . $ARRAY['!trap'][0]['message'];
            } else {
                $msg = "GAGAL MENGHAPUS QUEUE SIMPLE $user, SILAHKAN COBA LAGI!. msg: unknown error";
            }
            $this->log->writeLog($msg);
            return $msg;
        }
    }

    function getHotspotUserProfile() {
        return $this->mikrostator->baca("/ip/hotspot/user/profile/print");
    }

    function prosesTambahHotspotUser($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $user = $data['user'];
        $password = $data['password'];
        $userprofile = $data['userprofile'];
        $server = $data['server'];

        $ARRAY = $this->mikrostator->addHotspotUser($data);
        if ($ARRAY[0] == "!done") { //.0 berarti tidak ada pesan tambahan/sukses
            $msg = "PENGGUNA $user BERHASIL DITAMBAHKAN via $iptujuan";
            $this->mikrostator->tulis2("/log/info", array(
                "message" => "$msg",
            ));
            $this->log->writeLog($msg);
            return $msg;
        } else {
//.gagal menambakan di mikrotik
            $msg = "GAGAL MENAMBAHKAN PENGGUNA $user, SILAHKAN COBA LAGI!. msg: " . $ARRAY[1];
            $this->log->writeLog($msg);
            return $msg;
        }
    }

    function prosesUpdateHotspotUser($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $user = $data['user'];
        $password = $data['password'];
        $userprofile = $data['userprofile'];
        $server = 'all';

        $ARRAY = $this->mikrostator->editHotspotUser($data);
//return print_r($ARRAY);
        if ($ARRAY[0] == "!done") {
            $msg = "PENGGUNA $user BERHASIL DIUPDATE via $iptujuan";
            $this->mikrostator->tulis2("/log/info", array(
                "message" => "$msg",
            ));
            $this->log->writeLog($msg);
            return $msg;
        } else {
//.gagal menambakan di mikrotik
            $msg = "GAGAL MENGUPDATE PENGGUNA $user, SILAHKAN COBA LAGI!. msg: " . $ARRAY[1];
            $this->log->writeLog($msg);
            return $msg;
        }
    }

    function prosesHapusIpHotspotUser($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $id = $data['id'];
        $user = $data['user'];
//return print_r($data);

        $ARRAY = $this->mikrostator->tulis2('/ip/hotspot/user/remove', array(
            ".id" => $id,
        ));

        if (count($ARRAY) == 0) { //.0 berarti tidak ada pesan tambahan/sukses
            $msg = "PENGGUNA $user BERHASIL DIHAPUS via $iptujuan";
            $this->mikrostator->tulis2("/log/info", array(
                "message" => "$msg",
            ));
            $this->log->writeLog($msg);
            return $msg;
        } else {
//.gagal menambakan di mikrotik
            if ($ARRAY['!trap'][0]['message']) {
                $msg = "GAGAL MENGHAPUS PENGGUNA $user, SILAHKAN COBA LAGI!. msg: " . $ARRAY['!trap'][0]['message'];
            } else {
                $msg = "GAGAL MENGHAPUS PENGGUNA $user, SILAHKAN COBA LAGI!. msg: unknown error";
            }
            $this->log->writeLog($msg);
            return $msg;
        }
    }

    function getRestoreTableJam($jam) {
        date_default_timezone_set('Asia/Jakarta');
        ?>
        <script>
            function pulihkanJam() {
                konfirmasi = confirm('Apa kamu yakin ingin memulihkan semua jam tersebut ?');
                if (konfirmasi) {
                    var jam = $("#txt_selecttime").val();
                    $("#restore_result").show();
                    $('#luding').show();
                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url() . 'hotspot/proses_restore_table_jam'; ?>/" + jam,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            once_load();
                        },
                        error: function(event, textStatus, errorThrown) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                        },
                    });
                }
                return false;
            }
        </script>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <table class="table table-hover table-striped table-condensed table-bordered"  id="hotspot_aktif_restore" data-order='[[ 9, "asc" ]]'>
            <thead>
                <tr>
                    <th class="text-nowrap" title="nama pengguna">NAMA</th>
                    <th class="text-nowrap" title="sisa waktu" style="background:#ffcc99;">SISA</th>
                    <th class="text-nowrap" title="waktu batas-aktif" style="background:#b3ff99;">BATAS-AKTIF</th>
                    <th class="text-nowrap" title="batas waktu">BATAS</th>
                    <th class="text-nowrap" title="waktu dipakai">DIPAKAI</th>
                    <th class="text-nowrap" title="waktu aktif">AKTIF</th>
                    <th class="text-nowrap" title="biaya aktif 2500/jam">BIAYA</th>
                    <th class="text-nowrap" title="alamat ip">IP</th>
                    <th class="text-nowrap" title="alamat mac">MAC</th>
                    <th class="text-nowrap" title="nyawa"><center><span class="glyphicon glyphicon-time" aria-hidden="true"></span></center></th>
        </tr>
        </thead>
        <tbody>
            <?php
            $query = $this->db->query("SELECT * FROM wk_hotspot_active WHERE DATE_FORMAT(active_last_update,'%d%m%Y%H%i%s') = '$jam' LIMIT 100");
            foreach ($query->result() as $row) {
                $user = $row->active_user;
                $address = $row->active_address;
                $mac_address = $row->active_mac_address;
                $uptime_batas = $row->active_uptime_batas;
                $uptime_dipakai = $row->active_uptime_dipakai;
                $uptime_aktif = $row->active_uptime_aktif;
                $session_time_left_sisa = $row->active_session_time_left_sisa;
                $bytes_in = $row->active_bytes_in;
                $bytes_out = $row->active_bytes_out;
                $last_seen = $row->active_last_update;
                ?>
                <tr>
                    <td class="text-nowrap"><?php echo $user; ?></td>
                    <td class="text-nowrap" style="background:#ffdfbf;" title="<?php echo "PC:Rp." . floor(($this->stator->get_menit($session_time_left_sisa, 's') / 3600) * 2500) . "|" . "HP:Rp." . floor(($this->stator->get_menit($session_time_left_sisa, 's') / 3600) * 2000); ?>"><?php echo $session_time_left_sisa; ?></td>
                    <td class="text-nowrap" style="background:#e1ffe1;"><?php echo $this->stator->time_elapsed_A($this->stator->get_menit($uptime_batas, 's') - $this->stator->get_menit($uptime_aktif, 's')); ?></td>
                    <td class="text-nowrap"><?php echo $uptime_batas; ?></td>
                    <td class="text-nowrap"><?php echo $uptime_dipakai; ?></td>
                    <td class="text-nowrap" title="<?php echo "PC:Rp." . floor(($this->stator->get_menit($uptime_aktif, 's') / 3600) * 2500) . "|" . "HP:Rp." . floor(($this->stator->get_menit($uptime_aktif, 's') / 3600) * 2000); ?>"><?php echo $uptime_aktif; ?></td>
                    <td class="text-nowrap" title="<?php echo "PC:Rp." . floor(($this->stator->get_menit($uptime_aktif, 's') / 3600) * 2500) . "|" . "HP:Rp." . floor(($this->stator->get_menit($uptime_aktif, 's') / 3600) * 2000); ?>"><?php echo "Rp." . floor(($this->stator->get_menit($uptime_aktif, 's') / 3600) * 2500); ?></td>
                    <td class="text-nowrap"><?php echo $address; ?></td>
                    <td class="text-nowrap"><?php echo $mac_address; ?></td>
                    <td class="text-nowrap"><?php echo $this->stator->get_menit($session_time_left_sisa, 's'); ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $('#hotspot_aktif_restore').DataTable({
                    searching: false,
                    paging: false
                });
            });
        </script>
        <script>
            $('#waktu_pilihan').html('<?php echo date('d/m/Y H:i:s', strtotime($last_seen)); ?>');
        </script>

        <?php
    }

    function prosesRestoreTableJam($jam) {
        //echo $jam;
        $msg = "";
        $query = $this->db->query("SELECT * FROM wk_hotspot_active WHERE DATE_FORMAT(active_last_update,'%d%m%Y%H%i%s') = '$jam'");
        
        foreach ($query->result() as $row){
                $user = $row->active_user;
                $address = $row->active_address;
                $mac_address = $row->active_mac_address;
                $uptime_batas = $row->active_uptime_batas;
                $uptime_dipakai = $row->active_uptime_dipakai;
                $uptime_aktif = $row->active_uptime_aktif;
                $session_time_left_sisa = $row->active_session_time_left_sisa;
                $bytes_in = $row->active_bytes_in;
                $bytes_out = $row->active_bytes_out;
                $last_seen = $row->active_last_update;
                $batas_aktif = $this->stator->time_elapsed_A($this->stator->get_menit($uptime_batas,'s')-$this->stator->get_menit($uptime_aktif,'s')); //batas dikurangi aktif

                $data = array(
                    'user' => $user,
                    'batas_aktif' => $batas_aktif,
                );
                
                $ARRAY = $this->mikrostator->restoreActive($data);
                if ($ARRAY[0] == "!done") {
                //if(count($ARRAY) == 0){ //.0 berarti tidak ada pesan tambahan/sukses
                        //.sukses menambakan di mikrotik
                        $msg .= "<li>JAM ".$user." BERHASIL DIPULIHKAN menjadi ".$batas_aktif." (".$uptime_batas."-".$uptime_aktif.")</li>";
                } else {
                        //.gagal menambakan di mikrotik
                        $msg .= "<li>JAM ".$user." GAGAL DIPULIHKAN menjadi ".$batas_aktif." (".$uptime_batas."-".$uptime_aktif.")</li>";
                }
        }
        $msg .= "<li>DIPULIHKAN ke waktu ".date('d/m/Y H:i:s', strtotime($last_seen))."</li>";
        $this->log->writeLog($msg);
        echo $msg;
    }

    function getHistoryMikrotik() {
        ?>
        <script>

        </script>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered"  id="history_mikrotik" data-order='[[ 4, "desc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap" title="last seen">DIPERBARUI</th>
                        <th class="text-nowrap" title="time">JAM</th>
                        <th class="text-nowrap" title="topics">TOPIK</th>
                        <th class="text-nowrap" title="message">CATATAN</th>
                        <th class="text-nowrap" title="id">ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //$waktu_sekarang = date('d/m/Y H:i:s');
                    //$query = mysql_query("SELECT * FROM wk_log_mikrotik WHERE DATE_FORMAT(log_mikrotik_last_update,'%d%m%Y%H') = '$jam'");
                    $query = $this->db->query("SELECT * FROM wk_log_mikrotik ORDER BY log_mikrotik_id DESC LIMIT 5000");
                    foreach ($query->result() as $row) {
                        $log_mikrotik_id = $row->log_mikrotik_id;
                        $log_mikrotik_time = $row->log_mikrotik_time;
                        $log_mikrotik_topics = $row->log_mikrotik_topics;
                        $log_mikrotik_message = $row->log_mikrotik_message;
                        $log_mikrotik_last_update = $row->log_mikrotik_last_update;
                        $inout = "";
                        if ($this->stator->cek_pesan($log_mikrotik_message, array("MASUK "))) {
                            $inout = 'style="color:#7777ff;font-weight:bold;"';
                        }
                        if ($this->stator->cek_pesan($log_mikrotik_message, array("KELUAR "))) {
                            $inout = 'style="color:#ff7777;font-weight:bold;"';
                        }
                        ?>
                        <tr <?php echo $inout; ?>>
                            <td class="text-nowrap"><?php echo date('d/m/Y H:i:s', strtotime($log_mikrotik_last_update)); ?></td>
                            <td class="text-nowrap"><?php echo $log_mikrotik_time; ?></td>
                            <td class="text-nowrap"><?php echo $log_mikrotik_topics; ?></td>
                            <td class="text-nowrap"><?php echo $log_mikrotik_message; ?></td>
                            <td class="text-nowrap"><?php echo $log_mikrotik_id; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <script>
                $(document).ready(function() {
                    $('#history_mikrotik').DataTable({
                    });
                });
            </script>

            <?php
        }

    function getHistoryJam() {
        ?>
        <script>

        </script>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered" id="history_jam" data-order='[[ 2, "desc" ]]'>
            <thead>
                <tr>
                    <th class="text-nowrap" title="waktu update">DIPERBARUI</th>
                    <th class="text-nowrap" title="log">CATATAN</th>
                    <th class="text-nowrap" title="id">ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $this->db->query("SELECT * FROM wk_log ORDER BY log_id DESC LIMIT 5000");
                foreach ($query->result() as $row) {
                    $log_id = $row->log_id;
                    $log_notes = $row->log_notes;
                    $log_last_update = date('d/m/Y H:i', strtotime($row->log_last_update));
                    ?>
                    <tr>
                        <td class="text-nowrap"><?php echo $log_last_update; ?></td>
                        <td class="text-nowrap"><?php echo $log_notes; ?></td>
                        <td class="text-nowrap"><?php echo $log_id; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $('#history_jam').DataTable({
                });
            });
        </script>
            <?php
        }

//***MODEL HOTSPOT.start
    }

    /* End of file hotspot_model.php */
/* Location: ./application/models/hotspot_model.php */