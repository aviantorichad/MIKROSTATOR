<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('stator');
        $this->load->model('log');
    }

//***MODEL REPORT.start
    
    function getReportDaily($data = array()) {
        ?>
        <style>
            table td, table th{font-size:11px;text-align: right}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered" id="table_report_daily" data-order='[[ 1, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap">NO</th>
                        <th class="text-nowrap">ID</th>
                        <th class="text-nowrap">WAKTU</th>
                        <th class="text-nowrap">NAMA</th>
                        <th class="text-nowrap">OPERATOR</th>
                        <th class="text-nowrap">JUMLAH</th>
                        <th class="text-nowrap">TOTAL</th>
                        <th class="text-nowrap">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    //Example : /total.php?tahun=2016&bulan=03
                    $grand_total = 0;
                    $tanggal = $data['tanggal'];
                    $bulan = $data['bulan'];
                    $tahun = $data['tahun'];
                    $query = $this->db->query("SELECT user_id, user_name, user_tambah as jumlah, user_operator, user_notes, user_last_update FROM `wk_hotspot_user` WHERE user_last_update like '%$tahun-$bulan-$tanggal%' and user_tipe_tambah='rupiah' and user_status_update != 'dibatalkan' ORDER BY user_id ASC");
                    $i = 0;
                    foreach ($query->result() as $row):
                        $i++;
                        $id = $row->user_id;
                        $nama = $row->user_name;
                        $tgl = $row->user_last_update;
                        $operator = $row->user_operator;
                        $keterangan = $row->user_notes;
                        $jumlah = $row->jumlah;
                        $grand_total = $grand_total + $jumlah;
                        ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $i; ?></td>
                            <td class="text-nowrap"><?php echo $id; ?></td>
                            <td class="text-nowrap"><?php echo $this->stator->replaceDay(date('D', strtotime($tgl))).", ".date('d/m/Y | <b>H:i:s</b>', strtotime($tgl)); ?></td>
                            <td class="text-nowrap"><?php echo $nama; ?></td>
                            <td class="text-nowrap"><?php echo $operator; ?></td>
                            <td class="text-nowrap"><?php echo $jumlah; ?></td>
                            <td class="text-nowrap"><?php echo $grand_total; ?></td>
                            <td class="text-nowrap" style="text-align: left"><?php echo $keterangan; ?></td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <?php echo "<h3>Grand Total : <span style='color:#ff7777'>".  $this->stator->convert_to_rupiah($grand_total)."</span></h3>"; ?>
        </div>
        <script>
                $(document).ready(function() {
                    $('#table_report_daily').DataTable({
                    });
                });
        </script>
        <?php
    }

    function getReportMonthly($data = array()) {
        ?>
        <style>
            table td, table th{font-size:11px;text-align: right}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered" id="table_report_monthly" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap">NO</th>
                        <th class="text-nowrap">TANGGAL</th>
                        <th class="text-nowrap">JUMLAH</th>
                        <th class="text-nowrap">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    //Example : /total.php?tahun=2016&bulan=03
                    $grand_total = 0;
                    $tahun = $data['tahun'];
                    $bulan = $data['bulan'];
                    for ($i = 1; $i <= 31; $i++) {
                        $j = $i < 10 ? '0' . $i : $i;
                        $query = $this->db->query("SELECT sum(user_tambah) as jumlah FROM `wk_hotspot_user` WHERE user_last_update like '%$tahun-$bulan-$j%' and user_tipe_tambah='rupiah' and user_status_update != 'dibatalkan'");
                        foreach ($query->result() as $row):
                            $tgl = $j.'/'.$bulan.'/'.$tahun;
                            $jumlah = $row->jumlah;
                            $grand_total = $grand_total + $jumlah;
                            ?>
                            <tr>
                                <td class="text-nowrap"><?php echo $i; ?></td>
                                <td class="text-nowrap"><?php echo $tgl; ?></td>
                                <td class="text-nowrap"><?php echo $jumlah; ?></td>
                                <td class="text-nowrap"><?php echo $grand_total; ?></td>
                            </tr>
                            <?php
                        endforeach;
                    }
                    ?>
                </tbody>
            </table>
            <?php echo "<h3>Grand Total : <span style='color:#ff7777'>".  $this->stator->convert_to_rupiah($grand_total)."</span></h3>"; ?>
        </div>
        <script>
                $(document).ready(function() {
                    $('#table_report_monthly').DataTable({
                    });
                });
        </script>
        <?php
    }

    function getReportYearly($data = array()) {
        ?>
        <style>
            table td, table th{font-size:11px;text-align: right}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered" id="table_report_yearly" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap">NO</th>
                        <th class="text-nowrap">BULAN</th>
                        <th class="text-nowrap">JUMLAH</th>
                        <th class="text-nowrap">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    //Example : /total.php?tahun=2016&bulan=03
                    $grand_total = 0;
                    $tahun = $data['tahun'];
                    for ($i = 1; $i <= 12; $i++) {
                        $j = $i < 10 ? '0' . $i : $i;
                        $query = $this->db->query("SELECT sum(user_tambah) as jumlah FROM `wk_hotspot_user` WHERE user_last_update like '%$tahun-$j%' and user_tipe_tambah='rupiah' and user_status_update != 'dibatalkan'");
                        foreach ($query->result() as $row):
                            $tgl = $j.'/'.$tahun;
                            $jumlah = $row->jumlah;
                            $grand_total = $grand_total + $jumlah;
                            ?>
                            <tr>
                                <td class="text-nowrap"><?php echo $i; ?></td>
                                <td class="text-nowrap"><?php echo $tgl; ?></td>
                                <td class="text-nowrap"><?php echo $jumlah; ?></td>
                                <td class="text-nowrap"><?php echo $grand_total; ?></td>
                            </tr>
                            <?php
                        endforeach;
                    }
                    ?>
                </tbody>
            </table>
            <?php echo "<h3>Grand Total : <span style='color:#ff7777'>".  $this->stator->convert_to_rupiah($grand_total)."</span></h3>"; ?>
        </div>
        <script>
                $(document).ready(function() {
                    $('#table_report_yearly').DataTable({
                    });
                });
        </script>
        <?php
    }

    function getReportAllYear() {
        ?>
        <style>
            table td, table th{font-size:11px;text-align: right}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered" id="table_report_allyear" data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th class="text-nowrap">TAHUN</th>
                        <th class="text-nowrap">JUMLAH</th>
                        <th class="text-nowrap">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    //Example : /total.php?tahun=2016&bulan=03
                    $grand_total = 0;
                    $query1 = $this->db->query("SELECT DISTINCT DATE_FORMAT(user_last_update, '%Y') as tahun FROM `wk_hotspot_user`");
                    foreach ($query1->result() as $row1):
                        $tahun = $row1->tahun;
                        $query = $this->db->query("SELECT sum(user_tambah) as jumlah FROM `wk_hotspot_user` WHERE user_last_update like '%$tahun-%' and user_tipe_tambah='rupiah' and user_status_update != 'dibatalkan'");
                        foreach ($query->result() as $row):
                            $tgl = $tahun;
                            $jumlah = $row->jumlah;
                            $grand_total = $grand_total + $jumlah;
                            ?>
                            <tr>
                                <td class="text-nowrap"><?php echo $tgl; ?></td>
                                <td class="text-nowrap"><?php echo $jumlah; ?></td>
                                <td class="text-nowrap"><?php echo $grand_total; ?></td>
                            </tr>
                            <?php
                        endforeach;
                    endforeach;
                    ?>
                </tbody>
            </table>
            <?php echo "<h3>Grand Total : <span style='color:#ff7777'>".  $this->stator->convert_to_rupiah($grand_total)."</span></h3>"; ?>
        </div>
        <script>
                $(document).ready(function() {
                    $('#table_report_allyear').DataTable({
                    });
                });
        </script>
        <?php
    }

//***MODEL REPORT.end
}

/* End of file report_model.php */
    /* Location: ./application/models/report_model.php */