<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_Model {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model('stator');
        $this->load->model('log');
    }

//***MODEL HOME.start
    
    function getSelectPicker($type) {
        $query = $this->db->query("SELECT * FROM wk_list WHERE list_type = '$type' ORDER BY list_order ASC");
        return $query->result();
    }

    function getMacColor($macaddr) {
        $query = $this->db->query("SELECT * FROM wk_mac WHERE mac_address = '" . $macaddr . "'");
        $result = $query->result();
        foreach ($result as $row) {
            $mac_id = $row->mac_id;
            $mac_address = $row->mac_address;
            $mac_bgcolor = $row->mac_bgcolor;
            $mac_note = $row->mac_note;
        }
        if (count($result) > 0) {
            return 'style="background:' . $mac_bgcolor . ';font-weight:bold;"';
        } else {
            return '';
        }
    }

    function getBaruSaja() {
        $query = $this->db->query("SELECT * FROM wk_log ORDER BY log_id DESC LIMIT 1");
        foreach ($query->result() as $row) {
            $log_notes = $row->log_notes;
            $log_last_update = $row->log_last_update;
            $pesan_baru = $log_notes . " (" . date('d/m/Y H:i:s', strtotime($log_last_update)) . ")";

            echo "** <b>baru saja :</b> $pesan_baru **";
        }
    }

    function getRiwayatJam() {
        ?>

        <script>
            function batalkanRiwayatJam(id, user, waktuAwal, waktuAkhir) {
                //// cek=confirm(\'Apa kamu yakin ingin MEMBATALKAN JAM ' . $nama . ' ini dan mengubah jamnya dari ' . $waktu_akhir . ' menjadi ' . $waktu_awal . '?\');if(cek){window.location.href=\'proses_batal_jam.php?id=' . $uid . '&u=' . $nama . '&s=' . $waktu_akhir . '&j=' . $waktu_awal . '\'}"
                if(waktuAwal != '*'){
                    cek = confirm('Apa kamu yakin ingin MEMBATALKAN JAM ' + user + ' ini dan mengubah jamnya dari ' + waktuAkhir + ' menjadi ' + waktuAwal + '?');
                    link = "<?php echo base_url('home/batalkanRiwayatJam') ?>";
                } else {
                    cek = confirm('Apa kamu yakin ingin MEMBATALKAN TRANSAKSI ini?');
                    link = "<?php echo base_url('home/batalkanTransaksiLain') ?>";
                }
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: link,
                        dataType: 'HTML',
                        data: 'id=' + id + '&user=' + user + '&waktu_awal=' + waktuAwal + '&waktu_akhir=' + waktuAkhir,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            monitoring();
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
        <table class="table table-hover table-striped table-condensed table-bordered" id="table_riwayat_jam" data-order='[[ 6, "desc" ]]'>
            <thead>
                <tr>
                    <th class="text-nowrap" title="nama pengguna">NAMA</th>
                    <th class="text-nowrap" title="jumlah">JUMLAH</th>
                    <th class="text-nowrap" title="waktu">DIPERBARUI</th>
                    <th class="text-nowrap" title="awal">AWAL</th>
                    <th class="text-nowrap" title="akhir">AKHIR</th>
                    <th class="text-nowrap" title="catatan">CATATAN</th>
                    <th class="text-nowrap" title="id">ID</th>
                    <th class="text-nowrap" title="aksi"><center><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></center></th>
        </tr>
        </thead>
        <tbody>
            <?php
            date_default_timezone_set('Asia/Jakarta');
            $tgl_sekarang = date('Y-m-d');
            $query = $this->db->query("SELECT * FROM wk_hotspot_user WHERE user_last_update like '%" . $tgl_sekarang . "%' ORDER BY user_id DESC");
            foreach ($query->result() as $row):
                $uid = $row->user_id;
                $nama = $row->user_name;
                $tambah = $row->user_tambah;
                $satuan = $row->user_tipe_tambah;
                $waktu = $row->user_last_update;
                $status = $row->user_status_update;
                $waktu_awal = $row->user_waktu_awal;
                $waktu_akhir = $row->user_waktu_akhir;
                $notes = $row->user_notes;
                $status_msg = "title='sukses'";
                $link_batal = '<center><a href="javascript:void(0)" onclick="batalkanRiwayatJam(\'' . $uid . '\',\'' . $nama . '\',\'' . $waktu_awal . '\',\'' . $waktu_akhir . '\')" title="Batalkan jam ini?"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></a></center>';
                if ($status != "" && $status != "sukses") {
                    $status_msg = "style='color:#aaa;' title='$status'";
                    $link_batal = '<center><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></center>';
                }
                ?>
                <tr <?php echo $status_msg; ?>>
                    <td class="text-nowrap" title="<?php echo $waktu_awal . " -> " . $waktu_akhir; ?>"><?php echo $nama; ?></td>
                    <td class="text-nowrap" title="<?php echo $notes; ?>"><?php echo $tambah . " " . $satuan; ?></td>
                    <td class="text-nowrap"><?php echo date('d/m/Y H:i:s', strtotime($waktu)); ?></td>
                    <td class="text-nowrap"><?php echo $waktu_awal; ?></td>
                    <td class="text-nowrap"><?php echo $waktu_akhir; ?></td>
                    <td class="text-nowrap"><?php echo $notes; ?></td>
                    <td class="text-nowrap"><?php echo $uid; ?></td>
                    <td class="text-nowrap">
                        <?php echo $link_batal; ?>
                    </td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $('#table_riwayat_jam').DataTable({
                });
            });
        </script>

        <?php
    }

    function getRiwayatJam2() {
        $tgl_sekarang = date('Y-m-d');
        $query = $this->db->query("SELECT * FROM wk_hotspot_user WHERE user_last_update like '%" . $tgl_sekarang . "%' ORDER BY user_id DESC");
        return $query->result();
    }

    function getRiwayatJam3() {
        date_default_timezone_set('Asia/Jakarta');
        $tgl_sekarang = date('Y-m-d');
        $query = $this->db->query("SELECT * FROM wk_hotspot_user WHERE user_last_update like '%" . $tgl_sekarang . "%' ORDER BY user_id DESC");
        foreach ($query->result() as $row):
            $uid = $row->user_id;
            $nama = $row->user_name;
            $tambah = $row->user_tambah;
            $satuan = $row->user_tipe_tambah;
            $waktu = $row->user_last_update;
            $status = $row->user_status_update;
            $waktu_awal = $row->user_waktu_awal;
            $waktu_akhir = $row->user_waktu_akhir;
            $notes = $row->user_notes;
            $status_msg = "title='sukses'";
            $link_batal = '<center><a href="javascript:void(0)" onclick="cek=confirm(\'Apa kamu yakin ingin MEMBATALKAN JAM ' . $nama . ' ini dan mengubah jamnya dari ' . $waktu_akhir . ' menjadi ' . $waktu_awal . '?\');if(cek){window.location.href=\'proses_batal_jam.php?id=' . $uid . '&u=' . $nama . '&s=' . $waktu_akhir . '&j=' . $waktu_awal . '\'}" title="Batalkan jam ini?"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></a></center>';
            if ($status != "" && $status != "sukses") {
                $status_msg = "style='color:#aaa;' title='$status'";
                $link_batal = '<center><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></center>';
            }
            ?>
            <tr <?php echo $status_msg; ?>>
                <td class="text-nowrap" title="<?php echo $waktu_awal . " -> " . $waktu_akhir; ?>"><?php echo $nama; ?></td>
                <td class="text-nowrap" title="<?php echo $notes; ?>"><?php echo $tambah . " " . $satuan; ?></td>
                <td class="text-nowrap"><?php echo date('d/m/Y H:i:s', strtotime($waktu)); ?></td>
                <td class="text-nowrap"><?php echo $waktu_awal; ?></td>
                <td class="text-nowrap"><?php echo $waktu_akhir; ?></td>
                <td class="text-nowrap"><?php echo $notes; ?></td>
                <td class="text-nowrap"><?php echo $uid; ?></td>
                <td class="text-nowrap">
                    <?php echo $link_batal; ?>
                </td>
            </tr>
            <?php
        endforeach;
    }

    function getStatusTerbaru() {
        date_default_timezone_set('Asia/Jakarta');
        echo "<div style='text-align:center;width:100%;padding:0;'>";
        $query = $this->db->query("
            (SELECT 'KELUAR' as status,concat(left(log_mikrotik_last_update,10), ' ', right(log_mikrotik_time,8)) as waktu, SUBSTRING_INDEX(SUBSTRING_INDEX(log_mikrotik_message,' ',1),'|',1) as user, SUBSTRING_INDEX(SUBSTRING_INDEX(log_mikrotik_message,'logged out: ',-1),'|',1) as note from wk_log_mikrotik where log_mikrotik_message REGEXP 'logged out' order by log_mikrotik_id desc limit 1)
            UNION
            (SELECT 'MASUK' as status,concat(left(log_mikrotik_last_update,10), ' ', right(log_mikrotik_time,8)) as waktu, SUBSTRING_INDEX(SUBSTRING_INDEX(log_mikrotik_message,' ',1),'|',1) as user, SUBSTRING_INDEX(SUBSTRING_INDEX(log_mikrotik_message,' ',-2),'|',1) as note from wk_log_mikrotik where log_mikrotik_message REGEXP 'logged in' order by log_mikrotik_id desc limit 1)
            UNION
            (SELECT 'PESAN' as status,forum_date as waktu, forum_user as user, forum_message as note from wk_forum order by forum_id desc limit 1)
            UNION
            (SELECT 'OFF' as status,concat(left(log_mikrotik_last_update,10), ' ', right(log_mikrotik_time,8)) as waktu, 'cpu' as user, concat(SUBSTRING_INDEX(SUBSTRING_INDEX(log_mikrotik_message,' ',99),'|',1),' at ',log_mikrotik_time) as note from wk_log_mikrotik where log_mikrotik_message REGEXP 'shutdown' order by log_mikrotik_id desc limit 1);
            ");
        foreach ($query->result() as $row):
            $status = $row->status;
            $waktu = date('d/m H:i:s', strtotime($row->waktu));
            $nama = $row->user;
            $note = $row->note;
            $style_color = 'style="display:inline-block;margin-right:10px;"';
            if ($status == 'MASUK') {
                $style_color = 'style="display:inline-block;margin:0 5px 10px 0;color:#fff;background:#77bb77;padding:5px;border-radius:3px;"';
                $status_icon = '<span class="glyphicon glyphicon-play" title="' . $status . '"></span>';
                $waktu_detail = $this->stator->timeAgo(strtotime($row->waktu));
            }

            if ($status == 'KELUAR') {
                $style_color = 'style="display:inline-block;margin:0 5px 10px 0;color:#fff;background:#ff7777;padding:5px;border-radius:3px;"';
                $status_icon = '<span class="glyphicon glyphicon-question-sign" title="' . $status . '"></span>';
                if ($note == 'session timeout') { //waktu habis
                    $status_icon = '<span class="glyphicon glyphicon-stop" title="' . $status . '"></span>';
                } else if ($note == 'user request') { //logout request
                    $status_icon = '<span class="glyphicon glyphicon-pause" title="' . $status . '"></span>';
                } else if ($note == 'keepalive timeout') { //wifi mati
                    $status_icon = '<span class="glyphicon glyphicon-signal" title="' . $status . '"></span>';
                } else if ($note == 'admin reset') {
                    $status_icon = '<span class="glyphicon glyphicon-remove" title="' . $status . '"></span>';
                }
                $waktu_detail = $this->stator->timeAgo(strtotime($row->waktu));
            }

            if ($status == 'PESAN') {
                $style_color = 'style="display:inline-block;margin:0 5px 10px 0;color:#fff;background:#7777ff;padding:5px;border-radius:3px;"';
                $status_icon = '<span class="glyphicon glyphicon-comment" title="' . $status . '"></span>';
                $waktu_detail = $this->stator->timeAgo(strtotime($row->waktu));
            }

            if ($status == 'OFF') {
                $style_color = 'style="display:inline-block;margin:0 5px 10px 0;color:#fff;background:#EC971F;padding:5px;border-radius:3px;min-width:100px;"';
                $status_icon = '<span class="glyphicon glyphicon-stats" title="' . $status . '"></span>';
                $waktu_detail = '<span id="cpuload" style="width:50px"></span>';
            }

            echo "<div " . $style_color . ">" . $status_icon . "&nbsp;&nbsp;<span style='font-weight:bold;font-size:18px' title='" . $note . "'>" . substr($nama, 0, 10) . "</span> <span style='font-size:10px;' title='" . $waktu . "'> " . $waktu_detail . "</span></div>";
        endforeach;
        echo "</div>";
    }

    function getHotspotActive() {
        ?>
        <script>
            function matikanActive(id, user) {
                cek = confirm('Apa kamu yakin ingin MEMATIKAN ' + user);
                if (cek) {
                    $('#lbl_msg').fadeOut('slow');
                    $('#luding').show();
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo base_url('home/matikanActive') ?>",
                        dataType: 'HTML',
                        data: 'id=' + id + '&user=' + user,
                        success: function(data) {
                            $('#luding').hide();
                            $('#lbl_msg').fadeIn('slow');
                            $('#lbl_msg').html(data);
                            monitoring();
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
        <table class="table table-hover table-striped table-condensed table-bordered"  id="hotspot_aktif" data-order='[[ 10, "asc" ]]'>
            <thead>
                <tr>
                    <th class="text-nowrap" title="nama pengguna">NAMA</th>
                    <th class="text-nowrap" title="sisa waktu" style="background:#ffcc99;">SISA</th>
                    <th class="text-nowrap" title="waktu aktif">AKTIF</th>
                    <th class="text-nowrap" title="biaya aktif 2500/jam">BIAYA</th>
                    <th class="text-nowrap" title="batas waktu">BATAS</th>
                    <th class="text-nowrap" title="waktu dipakai">DIPAKAI</th>
                    <th class="text-nowrap" title="alamat ip">IP</th>
                    <th class="text-nowrap" title="alamat mac">MAC</th>
                    <th class="text-nowrap" title="UPLOAD">UP</th>
                    <th class="text-nowrap" title="DOWNLOAD">DOWN</th>
                    <th class="text-nowrap" title="nyawa"><center><span class="glyphicon glyphicon-time" aria-hidden="true"></span></center></th>
                    <th class="text-nowrap" title="aksi"><center><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></center></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $waktu_sekarang = date('d/m/Y H:i:s');
            $IPActive = $this->mikrostator->baca('/ip/hotspot/active/print');
            $COUNT_ACTIVE = count($IPActive);
            foreach ($IPActive as $row_active) {
                //.list hotspot active.begin
                $active_id = $row_active['.id'];
                $user = $row_active['user'];
                $address = $row_active['address'];
                $mac_address = $row_active['mac-address'];

                $mac_pilihan = $this->getMacColor($mac_address);
                $uptime = $row_active['uptime'];
                $session_time_left = '';
                if (isset($row_active['session-time-left'])) {
                    $session_time_left = $row_active['session-time-left'];
                }
                $bytes_in = $row_active['bytes-in'];
                $bytes_out = $row_active['bytes-out'];

                //limit uptime diambil dari /ip/hotspot/user
                $IPUser = $this->mikrostator->baca('/ip/hotspot/user/print', array(
                    ".proplist" => "uptime,limit-uptime",
                    "?name" => $user,
                ));
                //print_r($IPUser);
                $user_uptime = '';
                $user_limit_uptime = '';
                if (count($IPUser)) {
                    $user_uptime = $IPUser[0]['uptime'];
                    if (isset($IPUser[0]['limit-uptime'])) {
                        $user_limit_uptime = $IPUser[0]['limit-uptime'];
                    }
                }
                //.list hotspot active.end
                //.list hotspot active.end
                //catat ke database.begin
                if($this->mikrostator->get('autobackup') == 1){
                    if ($COUNT_ACTIVE > 0) {
                        $query_i = $this->db->query("INSERT INTO wk_hotspot_active(
                                                                            `active_user`,
                                                                            `active_address`,
                                                                            `active_mac_address`,
                                                                            `active_uptime_batas`,
                                                                            `active_uptime_dipakai`,
                                                                            `active_uptime_aktif`,
                                                                            `active_session_time_left_sisa`,
                                                                            `active_bytes_in`,
                                                                            `active_bytes_out`,
                                                                            `active_last_seen`
                                                                    ) VALUES(
                                                                            '$user',
                                                                            '$address',
                                                                            '$mac_address',
                                                                            '$user_limit_uptime',
                                                                            '$user_uptime',
                                                                            '$uptime',
                                                                            '$session_time_left',
                                                                            '$bytes_in',
                                                                            '$bytes_out',
                                                                            '$waktu_sekarang'
                                                                    )");
                        if ($query_i) {
                            //.sukses query insert
                        } else {
                            //echo "GAGAL QUERY INSERT! errmsg : ".mysql_error();
                        }
                    }
                }
                //catat ke database.end
                ?>
                <tr <?php echo $mac_pilihan; ?>>
                    <td class="text-nowrap"><?php echo $user; ?></td>
                    <td class="text-nowrap" style="background:#ffdfbf;" title="<?php echo "PC:Rp." . floor(($this->stator->get_menit($session_time_left, 's') / 3600) * 2500) . "|" . "HP:Rp." . floor(($this->stator->get_menit($session_time_left, 's') / 3600) * 2000); ?>"><?php echo $session_time_left; ?></td>
                    <td class="text-nowrap" title="<?php echo "PC:Rp." . floor(($this->stator->get_menit($uptime, 's') / 3600) * 2500) . "|" . "HP:Rp." . floor(($this->stator->get_menit($uptime, 's') / 3600) * 2000); ?>"><?php echo $uptime; ?></td>
                    <td class="text-nowrap" title="<?php echo "PC:Rp." . floor(($this->stator->get_menit($uptime, 's') / 3600) * 2500) . "|" . "HP:Rp." . floor(($this->stator->get_menit($uptime, 's') / 3600) * 2000); ?>"><?php echo "Rp." . floor(($this->stator->get_menit($uptime, 's') / 3600) * 2500); ?></td>
                    <td class="text-nowrap"><?php echo $user_limit_uptime; ?></td>
                    <td class="text-nowrap"><?php echo $user_uptime; ?></td>
                    <td class="text-nowrap"><?php echo $address; ?></td>
                    <td class="text-nowrap"><?php echo $mac_address; ?></td>                    
                    <td class="text-nowrap" title="<?php echo $bytes_in; ?>"><?php echo number_format($bytes_in / 1024 / 1024, 2) . " MB"; ?></td>
                    <td class="text-nowrap" title="<?php echo $bytes_out; ?>"><?php echo number_format($bytes_out / 1024 / 1024, 2) . " MB"; ?></td>
                    <td class="text-nowrap"><?php echo $this->stator->get_menit($session_time_left, 's'); ?></td>
                    <td class="text-nowrap"><center><a href="javascript:void(0)" onclick="matikanActive('<?php echo $active_id; ?>', '<?php echo $user; ?>')" title="MATIKAN <?php echo $user; ?>!"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></center></td>
            </tr>
            <?php
        }

        $ARRAYA = $this->mikrostator->baca('/system/resource/print');
        $first = $ARRAYA['0']; //cpu-load
        ?>
        </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $('#hotspot_aktif').DataTable({
                    searching: false,
                    paging: false
                });
            });
        </script>
        <script>
            $('#count_online').html('<?php echo $COUNT_ACTIVE; ?>');
            $('#diperbarui_pada').html('*diperbarui pada <?php echo $waktu_sekarang; ?> <span style="color:#999">(<a href="javascript:void(0)" onclick="this.innerHTML=\'tunggu..\';monitoring()">refresh</a>)</span>');

            valuse = <?php echo $first['cpu-load']; ?>;
            if (valuse > 50 && valuse <= 75) {
                $('#status_cpu_strip').html('<div class="progress-bar progress-bar-warning progress-bar-striped" title="CPU LOAD: ' + valuse + '%" style="width: ' + valuse + '%;"></div>');
            } else if (valuse > 75) {
                $('#status_cpu_strip').html('<div class="progress-bar progress-bar-danger progress-bar-striped" title="CPU LOAD: ' + valuse + '%" style="width: ' + valuse + '%;"></div>');
            } else {
                $('#status_cpu_strip').html('<div class="progress-bar progress-bar-success progress-bar-striped" title="CPU LOAD: ' + valuse + '%" style="width: ' + valuse + '%;"></div>');
            }
            cek_ol(<?php echo $COUNT_ACTIVE; ?>);

            setTimeout(function() {
                $('#cpuload').html(valuse + '%')
            }, 1500);
        </script>
        <?php
    }

    function getLogHotspot() {
        $LOGpr = $this->mikrostator->baca('/log/print');
        foreach ($LOGpr as $row_log) {
//.list hotspot active.begin
//$log_id = $row_log['.id'];
            $log_time = $row_log['time'];
            $log_topics = $row_log['topics'];
            $log_message = $row_log['message'];
            if ($this->stator->cek_pesan($log_topics, array("hotspot", "script", "error", "ppp"))) {
                $q_sama = $this->db->query("SELECT log_mikrotik_id FROM wk_log_mikrotik WHERE log_mikrotik_time = '" . $log_time . "' AND log_mikrotik_message = '" . $log_message . "'");
                if ($q_sama->num_rows == 0) {
                    $query_ilog = $this->db->query("INSERT INTO wk_log_mikrotik(
						`log_mikrotik_time`,
						`log_mikrotik_topics`,
						`log_mikrotik_message`
						) VALUES(
						'$log_time',
						'$log_topics',
						'$log_message'
					)");
                }
            }
        }
        ?>
        <table class="table table-hover table-striped table-condensed table-bordered"  id="log_mikrotik_hotspot" data-order='[[ 3, "desc" ]]'>
            <thead>
                <tr>
                    <th class="text-nowrap" title="time">JAM</th>
                    <th class="text-nowrap" title="topics">TOPIK</th>
                    <th class="text-nowrap" title="message">CATATAN</th>
                    <th class="text-nowrap" title="id">ID</th>
                    <th class="text-nowrap" title="last seen">DIPERBARUI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tgl_sekarang = date('Y-m-d');
                $query = $this->db->query("SELECT * FROM wk_log_mikrotik WHERE log_mikrotik_last_update like '%" . $tgl_sekarang . "%' ORDER BY log_mikrotik_id DESC");
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
                        <td class="text-nowrap"><?php echo $log_mikrotik_time; ?></td>
                        <td class="text-nowrap"><?php echo $log_mikrotik_topics; ?></td>
                        <td class="text-nowrap"><?php echo $log_mikrotik_message; ?></td>
                        <td class="text-nowrap"><?php echo $log_mikrotik_id; ?></td>
                        <td class="text-nowrap"><?php echo date('d/m/Y H:i:s', strtotime($log_mikrotik_last_update)); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $('#log_mikrotik_hotspot').DataTable({
                });
            });
        </script>
        <?php
    }

    function getHotspotUser() {
        return $this->mikrostator->baca("/ip/hotspot/user/print");
    }

    function getHotspotUserSession() {
        if ($this->session->userdata('hotspot_user_notnull') == TRUE) {
            return $this->session->userdata('hotspot_user');
        } else {
            $sessionStator['hotspot_user'] = $this->mikrostator->baca("/ip/hotspot/user/print");
            $sessionStator['hotspot_user_notnull'] = TRUE;
            $this->session->set_userdata($sessionStator);
            return $this->session->userdata('hotspot_user');
        }
    }
    
    function prosesTambahJam($data = array()) {
        $_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
        $_PERINTAH = "arp -a $_IP_ADDRESS";
        ob_start();
        system($_PERINTAH);
        $_HASIL = ob_get_contents();
        ob_clean();
        $_PECAH = strstr($_HASIL, $_IP_ADDRESS);
        $_PECAH_STRING = explode($_IP_ADDRESS, str_replace(" ", "", $_PECAH));
        $_HASIL = substr($_PECAH_STRING[1], 0, 17);
        $mac_anda = $_HASIL;
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        $usernameku = $this->session->userdata('username');
        $user = $data['user']; //user
        $gadget = $data['gadget']; //hp, laptop, transfer
        $user2 = $data['user2']; //sumber transfer
        $type = $data['type']; //rupiah, menit
        $nominal = $data['nominal']; //tambah berapa
        date_default_timezone_set('Asia/Jakarta');

//cek tipe jam.begin
        $tipejam = "";
        if ($gadget != "trf") {
            $query = $this->db->query("SELECT list_etc FROM wk_list WHERE list_value = '" . $gadget . "' AND list_type = 'select_gadget' LIMIT 1");
            if ($query) {
                foreach ($query->result() as $row) {
                    $tipejam = $row->list_etc;
                }
            } else {
                $msg = "GAGAL! Query mengambil tipe jam tidak berhasil";
                $this->log->writeLog($msg);
                return $msg;
            }
        }

        $tambah = $nominal; //..jika tipenya menit

        if ($type == 'rupiah') { //..jika tipenya bayar uang
//..konversi.begin
            $tambah2 = ceil($nominal / $tipejam * 60);
            $tambah = $tambah2;
//..konversi.end
        }

        $tambah = $tambah * 60; //pengurang dalam menit dikonversi ke detik
        $tambahin = $this->stator->time_elapsed_A($tambah);
        $akhir = "";
//cek tipe jam.end

        $IPUser = $this->mikrostator->baca("/ip/hotspot/user/print", array(
            "?name" => $user,
        ));
        $i = 0;
        $name = $IPUser[$i]['name'];
        $password = $IPUser[$i]['password'];
        $profile = $IPUser[$i]['profile'];
        $limit_uptime = isset($IPUser[$i]['limit-uptime']) ? $IPUser[$i]['limit-uptime'] : 0; //batas
        $uptime = $IPUser[$i]['uptime']; //dipakai
        $bytes_in = $IPUser[$i]['bytes-in'];
        $bytes_out = $IPUser[$i]['bytes-out'];

        $awal = $limit_uptime;


        if ($gadget == 'trf') {
//ambil user mikrotik sumber pengguna .begin
            $IPUser2 = $this->mikrostator->baca("/ip/hotspot/user/print", array(
                "?name" => $user2,
            ));
            $i = 0;
            $name2 = $IPUser2[$i]['name'];
            $password2 = $IPUser2[$i]['password'];
            $profile2 = $IPUser2[$i]['profile'];
            $limit_uptime2 = isset($IPUser2[$i]['limit-uptime']) ? $IPUser2[$i]['limit-uptime'] : 0; //batas
            $uptime2 = $IPUser2[$i]['uptime']; //dipakai
            $bytes_in2 = $IPUser2[$i]['bytes-in'];
            $bytes_out2 = $IPUser2[$i]['bytes-out'];
            $sumber_sisa2 = $this->stator->time_elapsed_A($this->stator->get_menit($limit_uptime2, 's') - $this->stator->get_menit($uptime2, 's')); //penambah
            $sumber_sisa_menit = $this->stator->get_menit($sumber_sisa2, 'm');
            $sumber2 = $this->stator->get_menit($sumber_sisa2, 's') - $tambah;
            if ($sumber2 < 0 || $this->stator->get_menit($limit_uptime2, 's') <= 0 || $limit_uptime2 == '') {
                $msg = "GAGAL! Jam $name2 tidak mencukupi untuk ditransfer " . $nominal . " menit (" . $this->stator->time_elapsed_A($tambah) . "). Sisa waktu " . $name2 . " : " . $sumber_sisa_menit . " menit (" . $sumber_sisa2 . ").";
                $this->log->writeLog($msg);
                return $msg;
            } else {
//..bisa ditransfer
                $kahir = $this->stator->time_elapsed_A($this->stator->get_menit($awal, 's') + $tambah);
                $sumber_batas = $this->stator->time_elapsed_A($this->stator->get_menit($limit_uptime2, 's') - $tambah);
            }
        } else {
//..perhitungan waktu.begin
            $kahir = $this->stator->time_elapsed_A($this->stator->get_menit($awal, 's') + $tambah);
//..perhitungan waktu.end	
        }

        $akhir = $kahir;

//..cek dulu apakah sudah ada isi sama sebelumnya
        $b_name = $name;
        $b_uptime = $uptime;
        $b_tambah = $nominal;
        $b_tipe_tambah = $type;
        $b_last_update = date('d/m/Y H:i');
        $b_semua = $b_name . "-" . $b_tambah . "-" . $b_tipe_tambah . "-" . $b_last_update;

        $query = $this->db->query("SELECT * FROM wk_hotspot_user ORDER BY user_id DESC LIMIT 1");
//.cek agar tidak dobel
        if ($query) {
            foreach ($query->result() as $row) {
                $c_name = $row->user_name;
                $c_uptime = $row->user_uptime;
                $c_tambah = $row->user_tambah;
                $c_tipe_tambah = $row->user_tipe_tambah;
                $c_last_update = date('d/m/Y H:i', strtotime($row->user_last_update));
                $c_semua = $c_name . "-" . $c_tambah . "-" . $c_tipe_tambah . "-" . $c_last_update;
            }
//echo $b_semua."<br/>".$c_semua;
            if ($b_semua != $c_semua) {
//..tulis ke sumber pengguna jika transfer
                $msg2 = "";
                if ($gadget == 'trf') {

                    $ARRAY = $this->mikrostator->tulis(array(
                        '/ip/hotspot/user/set' => FALSE,
                        '=.id=' . $user2 => FALSE,
                        '=name=' . $user2 => FALSE,
                        '=limit-uptime=' . $sumber_batas => true,
                            )
                    );
                    if (count($ARRAY) == 0) { //.0 berarti tidak ada pesan tambahan/sukses
                        $awal2 = $this->stator->time_elapsed_A($this->stator->get_menit($limit_uptime2, 's'));
                        $akhir2 = $this->stator->time_elapsed_A($this->stator->get_menit($sumber_batas, 's'));
                        $sisa2 = $this->stator->time_elapsed_A($this->stator->get_menit($sumber_batas, 's') - $this->stator->get_menit($uptime2, 's'));
                        $query = $this->db->query("INSERT INTO wk_hotspot_user(`user_name`,`user_profile`,`user_limit_uptime`,`user_uptime`,`user_bytes_in`,`user_bytes_out`,`user_waktu_awal`,`user_waktu_akhir`,`user_operator`,`user_tipe_tambah`,`user_tambah`,`user_notes`) 
													VALUES('$user2','$profile2','$limit_uptime2','$uptime2','$bytes_in2','$bytes_out2','$awal2','$akhir2','$usernameku','$type','$nominal','IP:$iptujuan|MAC:$mac_anda|KURANG:$tambahin|TIPEJAM:$gadget')");
                        if ($query) {
//.sukses query
                            $msg2 = " dan $user2 BERHASIL DIKURANGI dari $limit_uptime2 jadi $sumber_batas (sisa: $sisa2)";
                        } else {
//.gagal query
                            $msg2 = " dan $user2 BERHASIL DIKURANGI dari $limit_uptime2 jadi $sumber_batas (sisa: $sisa2) (no db)";
                        }
                    } else {
//.gagal menambahkan di mikrotik
                        if ($ARRAY['!trap'][0]['message']) {
                            $msg = "GAGAL MENTRANSFER, SILAHKAN COBA LAGI!. msg: " . $ARRAY['!trap'][0]['message'];
                        } else {
                            $msg = "GAGAL MENTRANSFER, SILAHKAN COBA LAGI!. msg: unknown error";
                        }
                        $this->log->writeLog($msg);
                        return $msg;
                        //break;
                    }
                }

//..tulis ke pengguna
                $ARRAY = $this->mikrostator->tulis(array(
                    '/ip/hotspot/user/set' => FALSE,
                    '=.id=' . $name => FALSE,
                    '=name=' . $name => FALSE,
                    '=limit-uptime=' . $akhir => true,
                        )
                );
//if($READ[0] == "!done"){
                if (count($ARRAY) == 0) { //.0 berarti tidak ada pesan tambahan/sukses
//.sukses menambakan di mikrotik
                    $awal = $this->stator->time_elapsed_A($this->stator->get_menit($awal, 's'));
                    $akhir = $this->stator->time_elapsed_A($this->stator->get_menit($akhir, 's'));
                    $sisa = $this->stator->time_elapsed_A($this->stator->get_menit($akhir, 's') - $this->stator->get_menit($uptime, 's'));
                    $this->mikrostator->baca("/log/info", array(
                        "message" => "$name BERHASIL DITAMBAHKAN $nominal $type ($gadget: $tambahin) via $iptujuan dari $awal jadi $akhir (sisa: $sisa)" . $msg2,
                    ));

//.tulis log ke db.begin
                    $query = $this->db->query("INSERT INTO wk_hotspot_user(`user_name`,`user_profile`,`user_limit_uptime`,`user_uptime`,`user_bytes_in`,`user_bytes_out`,`user_waktu_awal`,`user_waktu_akhir`,`user_operator`,`user_tipe_tambah`,`user_tambah`,`user_notes`) 
													VALUES('$name','$profile','$limit_uptime','$uptime','$bytes_in','$bytes_out','$awal','$akhir','$usernameku','$type','$nominal','IP:$iptujuan|MAC:$mac_anda|TAMBAH:$tambahin|TIPEJAM:$gadget')");
                    if ($query) {
//.sukses query
//echo "<script>alert('$name BERHASIL DITAMBAHKAN $nominal $type');</script>";

                        $msg = $name . " BERHASIL DITAMBAHKAN " . $nominal . " " . $type . " (" . $gadget . ": " . $tambahin . ") dari $awal jadi $akhir (sisa: $sisa)" . $msg2;
                        $this->log->writeLog($msg);
                        return $msg;
                    } else {
//.gagal query
                        $msg = $name . " BERHASIL DITAMBAHKAN " . $nominal . " " . $type . " (" . $gadget . ": " . $tambahin . ") dari $awal jadi $akhir (sisa: $sisa)" . $msg2 . " tapi tidak bisa ditulis ke db";
                        $this->log->writeLog($msg);
                        return $msg;
                    }
//.tulis log ke db.end
                } else {
//.gagal menambakan di mikrotik
                    if ($ARRAY['!trap'][0]['message']) {
                        $msg = "GAGAL MENAMBAHKAN, SILAHKAN COBA LAGI!. msg: " . $ARRAY['!trap'][0]['message'];
                    } else {
                        $msg = "GAGAL MENAMBAHKAN, SILAHKAN COBA LAGI!. msg: unknown error";
                    }
                    $this->log->writeLog($msg);
                    return $msg;
                }
            } else {
//.gagal karena pengulangan
                $msg = "Hanya boleh sekali yang masuk karena terjadi pengulangan dalam waktu dekat. , " . $name . " TIDAK DITAMBAHKAN LAGI " . $nominal . " " . $type . ". JAM sekarang $awal";
                $this->log->writeLog($msg);
                return $msg;
            }
        } else {
//.gagal query
            $msg = "Gagal membaca query tabel!";
            return $msg;
        }
    }

    function prosesTambahJam2($data = array()) {
        $user = $data['user'];
        $gadget = $data['gadget'];
        $user2 = $data['user2'];
        $type = $data['type'];
        $nominal = $data['nominal'];
//return $user . '|' . $gadget . '|' . $user2 . '|' . $type . '|' . $nominal;
//cek tipe jam.begin
        $tipejam = "";
        if ($gadget != "trf") {
            $query = $this->db->query("SELECT list_etc FROM wk_list WHERE list_value = '" . $gadget . "' AND list_type = 'select_gadget' LIMIT 1");
            if ($query) {
                foreach ($query->result() as $row) {
                    $tipejam = $row->list_etc;
                }
            } else {
                $msg = "GAGAL! Query mengambil tipe jam tidak berhasil";
                $this->log->writeLog($msg);
                return $msg;
            }
        }

//return $tipejam;


        $IPUser = $this->mikrostator->baca("/ip/hotspot/user/print", array(
            "?name" => $user,
        ));

        $i = 0;
        $name = $IPUser[$i]['name'];
        $password = $IPUser[$i]['password'];
        $profile = $IPUser[$i]['profile'];
        $limit_uptime = isset($IPUser[$i]['limit-uptime']) ? $IPUser[$i]['limit-uptime'] : 0; //batas
        $uptime = $IPUser[$i]['uptime']; //dipakai
        $bytes_in = $IPUser[$i]['bytes-in'];
        $bytes_out = $IPUser[$i]['bytes-out'];

        $awal = $limit_uptime;

//return $i.'|'.$name.'|'.$password.'|'.$profile.'|'.$limit_uptime.'|'.$uptime.'|'.$bytes_in.'|'.$bytes_out.'|'.$awal;

        if ($gadget == 'trf') {
//ambil user mikrotik sumber pengguna .begin
            $IPUser2 = $this->mikrostator->baca("/ip/hotspot/user/print", array(
                "?name" => $user2,
            ));
            $i = 0;
            $name2 = $IPUser2[$i]['name'];
            $password2 = $IPUser2[$i]['password'];
            $profile2 = $IPUser2[$i]['profile'];
            $limit_uptime2 = isset($IPUser2[$i]['limit-uptime']) ? $IPUser2[$i]['limit-uptime'] : 0; //batas
            $uptime2 = $IPUser2[$i]['uptime']; //dipakai
            $bytes_in2 = $IPUser2[$i]['bytes-in'];
            $bytes_out2 = $IPUser2[$i]['bytes-out'];
            $sumber_sisa2 = $this->stator->time_elapsed_A($this->stator->get_menit($limit_uptime2, 's') - $this->stator->get_menit($uptime2, 's')); //penambah
            $sumber_sisa_menit = $this->stator->get_menit($sumber_sisa2, 'm');
            $sumber2 = $this->stator->get_menit($sumber_sisa2, 's') - $tambah;
            if ($sumber2 < 0 || $this->stator->get_menit($limit_uptime2, 's') <= 0 || $limit_uptime2 == '') {
                $msg = "GAGAL! Jam $name2 tidak mencukupi untuk ditransfer " . $nominal . " menit (" . $this->stator->time_elapsed_A($tambah) . "). Sisa waktu " . $name2 . " : " . $sumber_sisa_menit . " menit (" . $sumber_sisa2 . ").";
                $this->log->writeLog($msg);
                return $msg;
            } else {
//..bisa ditransfer
                $kahir = $this->stator->time_elapsed_A($this->stator->get_menit($awal, 's') + $tambah);
                $sumber_batas = $this->stator->time_elapsed_A($this->stator->get_menit($limit_uptime2, 's') - $tambah);
            }
        } else {
//..perhitungan waktu.begin
            $kahir = $this->stator->time_elapsed_A($this->stator->get_menit($awal, 's') + $tambah);
//..perhitungan waktu.end	
        }
    }

    function prosesMatikanActive($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $id = $data['id'];
        $user = $data['user'];

        $ARRAY = $this->mikrostator->tulis2('/ip/hotspot/active/remove', array(
            ".id" => $id,
        ));

        if (count($ARRAY) == 0) { //.0 berarti tidak ada pesan tambahan/sukses
            $msg = "$user BERHASIL DIMATIKAN via $iptujuan";
            $this->mikrostator->tulis2("/log/info", array(
                "message" => "$msg",
            ));
            $this->log->writeLog($msg);
            return $msg;
        } else {
//.gagal menambakan di mikrotik
            if ($ARRAY['!trap'][0]['message']) {
                $msg = "GAGAL MEMATIKAN $user, SILAHKAN COBA LAGI!. msg: " . $ARRAY['!trap'][0]['message'];
            } else {
                $msg = "GAGAL MEMATIKAN $user, SILAHKAN COBA LAGI!. msg: unknown error";
            }
            $this->log->writeLog($msg);
            return $msg;
        }
    }

    function prosesBatalkanRiwayatJam($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $uid = $data['id'];
        $name = $data['user'];
        $waktu_awal = $data['waktu_awal'];
        $waktu_akhir = $data['waktu_akhir'];

        $ARRAY = $this->mikrostator->tulis(array(
            '/ip/hotspot/user/set' => FALSE,
            '=.id=' . $name => FALSE,
            '=name=' . $name => FALSE,
            '=limit-uptime=' . $waktu_awal => true,
                )
        );
        if (count($ARRAY) == 0) { //.0 berarti tidak ada pesan tambahan/sukses
            $msg = "JAM $name BERHASIL DIBATALKAN via $iptujuan dari $waktu_akhir jadi $waktu_awal";
//.sukses menambakan di mikrotik
            $this->mikrostator->tulis2("/log/info", array(
                "message" => "$msg",
            ));

//.tulis log ke db.begin
            $query = $this->db->query("UPDATE wk_hotspot_user SET `user_status_update` = 'dibatalkan' WHERE user_id = '$uid' ");
            if ($query) {
//.sukses query
                $this->log->writeLog($msg);
                return $msg;
            } else {
//.gagal query
                $msg = "JAM " . $name . " BERHASIL DIBATALKAN via $iptujuan dari $waktu_akhir jadi $waktu_awal tapi tidak bisa ditulis ke db";
                $this->log->writeLog($msg);
                return $msg;
            }
//.tulis log ke db.end
        } else {
//.gagal menambakan di mikrotik
            if ($ARRAY['!trap'][0]['message']) {
                $msg = "GAGAL MEMBATALKAN, SILAHKAN COBA LAGI!. msg: " . $ARRAY['!trap'][0]['message'];
            } else {
                $msg = "GAGAL MEMBATALKAN, SILAHKAN COBA LAGI!. msg: unknown error";
            }
            $this->log->writeLog($msg);
            return $msg;
        }
    }
    
    
    function prosesTambahTransaksiLain($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $nama = $data['user'];
        $transaksi = $data['transaksi'];
        $nominal = $data['nominal'];
        $profile = '*';
        $limit_uptime = '*'; //batas
        $uptime = '*'; //dipakai
        $bytes_in = '*';
        $bytes_out = '*';
        $awal = '*';
        $akhir = '*';
        $type = 'rupiah';
        $usernameku = $this->session->userdata('username');
        $this->db->query("INSERT INTO wk_hotspot_user(`user_name`,`user_profile`,`user_limit_uptime`,`user_uptime`,`user_bytes_in`,`user_bytes_out`,`user_waktu_awal`,`user_waktu_akhir`,`user_operator`,`user_tipe_tambah`,`user_tambah`,`user_notes`) 
													VALUES('$nama','$profile','$limit_uptime','$uptime','$bytes_in','$bytes_out','$awal','$akhir','$usernameku','$type','$nominal','$transaksi')");
        if($this->db->affected_rows() > 0) {
            $msg = "TRANSAKSI $nama ($transaksi) BERHASIL DITAMBAHKAN via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENAMBAHKAN TRANSAKSI $nama ($transaksi), SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }

    function prosesBatalkanTransaksiLain($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $uid = $data['id'];
        $nama = $data['user'];
        $waktu_awal = $data['waktu_awal'];
        $waktu_akhir = $data['waktu_akhir'];
        
	$this->db->query("UPDATE wk_hotspot_user SET `user_status_update` = 'dibatalkan' WHERE user_id = '$uid'");
        if($this->db->affected_rows() > 0) {
            $msg = "TRANSAKSI $nama BERHASIL DIBATALKAN via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MEMBATALKAN TRANSAKSI $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }


//***MODEL HOME.end

}

/* End of file home_model.php */
    /* Location: ./application/models/home_model.php */
