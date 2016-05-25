<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Voucher_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('stator');
        $this->load->model('log');
    }

//***MODEL VOUCHER.start
    function prosesGenerateVoucher($data = array()) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }
        
        $namavoucher = $data['namavoucher'];
        $qty = $data['qty'];
        $userprofile = $data['userprofile'];
        $limituptime = $data['limituptime'];
        $tipepassword = $data['tipepassword'];
        $password = $data['password'];
        //$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $chars = "0123456789abcdefghijklmnopqrstuvwxyz";
        ?>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <h3 style="color:#008899;">Voucher <span style="color:#ff7777"><?php echo $namavoucher; ?></span></h3>
            <table class="table table-hover table-striped table-condensed table-bordered" id="table_generate_voucher" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap" title="menu order">NO</th>
                        <th class="text-nowrap" title="menu name">USERNAME</th>
                        <th class="text-nowrap" title="menu link">PASSWORD</th>
                        <th class="text-nowrap" title="menu link">USER PROFILE</th>
                        <th class="text-nowrap" title="menu link">LIMIT UPTIME</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    for ($n = 1; $n <= $qty; $n++) {
                        $res1 = '';
                        $res2 = '';
                        for ($i = 0; $i < 6; $i++) {
                            $res1 .= $chars[mt_rand(0, strlen($chars) - 1)];
                        }
                        if ($tipepassword == 'at') {
                            for ($i = 0; $i < 6; $i++) {
                                $res2 .= $chars[mt_rand(0, strlen($chars) - 1)];
                            }
                        } else {
                            $res2 = $password;
                        }
                        

                        $user = $res1;
                        $password = $res2;
                        $userprofile = $userprofile;
                        $limit_uptime = $limituptime;
                        $server = 'all';
                        
                        $data = array(
                            'user' => $user,
                            'password' => $password,
                            'userprofile' => $userprofile,
                            'limit_uptime' => $limit_uptime,
                            'server' => $server,
                            'comment' => $namavoucher,
                        );

                        $ARRAY = $this->mikrostator->addHotspotUserVoucher($data);
                        if ($ARRAY[0] == "!done") { //.0 berarti tidak ada pesan tambahan/sukses
                            $msg = "sukses";
                        } else {
                            $msg = "gagal";
                        }
                        
                        //.insert to db.begin
                        $datax = array(
                            'voucher_name' => $namavoucher,
                            'voucher_username' => $res1,
                            'voucher_password_type' => $tipepassword,
                            'voucher_password' => $res2,
                            'voucher_qty' => $qty,
                            'voucher_user_profile' => $userprofile,
                            'voucher_limit_uptime' => $limituptime,
                            'voucher_status' => $msg,
                        );
                        $this->db->insert('wk_voucher', $datax);
                        //.insert to db.end
                        ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $n; ?></td>
                            <td class="text-nowrap"><?php echo $res1; ?></td>
                            <td class="text-nowrap"><?php echo $res2; ?></td>
                            <td class="text-nowrap"><?php echo $userprofile; ?></td>
                            <td class="text-nowrap"><?php echo $limituptime; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_generate_voucher').DataTable({
                });
            });
        </script>
        <?php
    }

    function getVoucherList($data = array()) {
        $namavoucher = $data['namavoucher'];
        ?>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <h3 style="color:#008899;">Voucher <span style="color:#ff7777"><?php echo $namavoucher; ?></span></h3>
            <table class="table table-hover table-striped table-condensed table-bordered" id="table_generate_voucher" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap">NO</th>
                        <th class="text-nowrap">USERNAME</th>
                        <th class="text-nowrap">PASSWORD</th>
                        <th class="text-nowrap">USER PROFILE</th>
                        <th class="text-nowrap">LIMIT UPTIME</th>
                        <th class="text-nowrap">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $this->db->select('*');
                    $this->db->from('wk_voucher');
                    $this->db->where('voucher_name', $namavoucher);
                    $query = $this->db->get();
                    $n = 0;
                    foreach ($query->result() as $row) {
                        $n++;
                        $res1 = $row->voucher_username;
                        $res2 = $row->voucher_password;
                        $userprofile = $row->voucher_user_profile;
                        $limituptime = $row->voucher_limit_uptime;
                        $status = $row->voucher_status;
                        ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $n; ?></td>
                            <td class="text-nowrap"><?php echo $res1; ?></td>
                            <td class="text-nowrap"><?php echo $res2; ?></td>
                            <td class="text-nowrap"><?php echo $userprofile; ?></td>
                            <td class="text-nowrap"><?php echo $limituptime; ?></td>
                            <td class="text-nowrap"><?php echo $status; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_generate_voucher').DataTable({
                });
            });
        </script>
        <?php
    }
    
    function getVoucherUsed($data = array()) {
        $namavoucher = $data['namavoucher'];
        ?>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <h3 style="color:#008899;">Voucher <span style="color:#ff7777"><?php echo $namavoucher; ?></span></h3>
            <table class="table table-hover table-striped table-condensed table-bordered"  id="table_voucher_used" data-order='[[ 0, "asc" ]]'>
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
                </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $query = $this->mikrostator->baca("/ip/hotspot/user/print", array(
                        "?comment" => $namavoucher,
                    ));
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
                        $hidup_mati = 'hidup';
                        if ($disabled == 'true') {
                            $status = 'mati';
                            $status_msg = "style='background-color:#ffaaaa;color:#aaa;' title='tidak aktif (mati)'";
                            $hidup_mati = 'mati';
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
                    </tr>
                    <?php
                endforeach;
                ?>
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_voucher_used').DataTable({
                });
            });
        </script>
        <?php
    }

    function getVoucherName() {
        $this->db->select('voucher_name');
        $this->db->from('wk_voucher');
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }

    function getVoucherByName($nama) {
        $this->db->select('voucher_name');
        $this->db->from('wk_voucher');
        $this->db->where('voucher_name', $nama);
        return $this->db->count_all_results();
    }

    function prosesHapusVoucherList($data = array()) {

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //.cek paka proxy atau tidak?
            $iptujuan = $_SERVER['HTTP_X_FORWARDED_FOR']; //pakai proxy
        } else {
            $iptujuan = $_SERVER['REMOTE_ADDR']; //tanpa proxy
        }

        $namavoucher = $data['namavoucher'];

        $this->db->select('*');
        $this->db->from('wk_voucher');
        $this->db->where('voucher_name', $namavoucher);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $nama = $row->voucher_username;
            $ARRAY = $this->mikrostator->delHotspotUserByName($nama);
            /*
            return count($ARRAY);
            if (count($ARRAY) == 0) { //.0 berarti tidak ada pesan tambahan/sukses
                $msg = "dihapus";
                //.update to db.begin
                $datax = array(
                    'voucher_status' => $msg,
                );
                $this->db->where('voucher_username', $user);
                $this->db->update('wk_voucher', $data);
                //.update to db.end
            } else {
                $msg = "gagal dihapus";
                //.update to db.begin
                $datax = array(
                    'voucher_status' => $msg,
                );
                $this->db->where('voucher_username', $user);
                $this->db->update('wk_voucher', $data);
                //.update to db.end
            }
             * 
             */
            $this->db->where('voucher_username', $row->voucher_username);
            $this->db->delete('wk_voucher');
        }
        
        if ($this->getVoucherByName($nama) == 0) {
            $msg = "VOUCHER $nama BERHASIL DIHAPUS via $iptujuan";
            $this->log->writeLog($msg);
            return $msg;
        } else {
            $msg = "GAGAL MENGHAPUS VOUCHER $nama, SILAHKAN COBA LAGI!. msg: " . $this->db->_error_message();
            $this->log->writeLog($msg);
            return $msg;
        }
    }

    function prosesCetakVoucherList($data = array()) {
        $namavoucher = $data['namavoucher'];
        ?>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <h3 style="color:#008899;">Voucher <span style="color:#ff7777"><?php echo $namavoucher; ?></span></h3>
            <?php
            date_default_timezone_set('Asia/Jakarta');
            $this->db->select('*');
            $this->db->from('wk_voucher');
            $this->db->where('voucher_name', $namavoucher);
            $query = $this->db->get();
            $n = 0;
            foreach ($query->result() as $row) {
                $n++;
                $res1 = $row->voucher_username;
                $res2 = $row->voucher_password;
                $userprofile = $row->voucher_user_profile;
                $limituptime = $row->voucher_limit_uptime;
                ?>

                <table style="display: inline-block; border: 1px solid #ccc; font-family: arial; font-size: 12px; margin: 1px;">
                    <tr style="border-bottom:1px solid #ccc;background:#ddd;">
                        <th style="text-align: center" colspan="2"><span style="padding:10px;font-size:15px;">VOUCHER HOTSPOT</span></th>
                    </tr>
                    <tr>
                        <td><span style="padding:5px;">USERNAME</span></td><td><span style="padding:5px;"><b><?php echo $res1; ?></b></span></td>
                    </tr>
                    <tr>
                        <td><span style="padding:5px;">PASSWORD</span></td><td><span style="padding:5px;"><b><?php echo $res2; ?></b></span></td>
                    </tr>
                    <tr style="border-bottom:1px solid #ccc;">
                        <td style="text-align: center" colspan="2"><span style="padding:50px;">Voucher : <?php echo $namavoucher; ?></span></td>
                    </tr>
                </table>
                <?php
            }
            ?>
            <?php
        }

        function prosesCetakVoucherList2($namavoucher) {
            $namavoucher = rawurldecode($namavoucher);
            ?>
            <script>
                window.onload = function() {
                    window.print();
                }
            </script>
            <style>
                table td, table th{font-size:11px;}
                .nowrap {white-space:nowrap;}
            </style>
            <div class="table-responsive">
                <?php
                date_default_timezone_set('Asia/Jakarta');
                $this->db->select('*');
                $this->db->from('wk_voucher');
                $this->db->where('voucher_name', $namavoucher);
                $this->db->where('voucher_status', 'sukses');
                $query = $this->db->get();
                $n = 0;
                foreach ($query->result() as $row) {
                    $n++;
                    $res1 = $row->voucher_username;
                    $res2 = $row->voucher_password;
                    $userprofile = $row->voucher_user_profile;
                    $limituptime = $row->voucher_limit_uptime;
                    ?>

                    <table style="display: inline-block; border: 1px solid #ccc; font-family: arial; font-size: 12px; margin: 2px;">
                        <tr style="border-bottom:1px solid #ccc;background:#ddd;">
                            <th style="text-align: center" colspan="2"><span style="padding:10px;font-size:15px;">** VOUCHER HOTSPOT **</span></th>
                        </tr>
                        <tr>
                            <td><span style="padding:5px;">USERNAME</span></td><td><span style="padding:5px;"><b><?php echo $res1; ?></b></span></td>
                        </tr>
                        <tr>
                            <td><span style="padding:5px;">PASSWORD</span></td><td><span style="padding:5px;"><b><?php echo $res2; ?></b></span></td>
                        </tr>
                        <tr>
                            <td><span style="padding:5px;">LIMIT</span></td><td><span style="padding:5px;"><b><?php echo $limituptime; ?></b></span></td>
                        </tr>
                        <tr>
                            <td colspan='2'><span style="padding:5px;font-size:9px;">Ket: w=minggu, d=hari, h=jam, m=menit, s=detik</span></td></td>
                        </tr>
                        <tr style="border-bottom:1px solid #ccc;background:#eee;">
                            <td style="text-align: center" colspan="2"><span style="color:#008899;">Voucher <span style="color:#ff7777"><?php echo $namavoucher; ?></span></span></td>
                        </tr>
                    </table>
                    <?php
                }
                ?>
                <?php
            }

//***MODEL VOUCHER.end
        }

        /* End of file voucher_model.php */
    /* Location: ./application/models/voucher_model.php */