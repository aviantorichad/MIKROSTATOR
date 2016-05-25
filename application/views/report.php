<script>
    function once_load() {
        getBaruSaja();
    }

    function getBaruSaja() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'home/get_baru_saja'; ?>",
            success: function(resp) {
                $("#info_baru_saja").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#info_baru_saja").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }

    once_load();
</script>

<div id="kiri">
    <!--HEADER-->
    <div class="header">
        <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">LAPORAN</span></h1></center><!--END TITLE-->
        <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
    </div>
    <form name="frm_tambah_jam" id="frmTambahjam" method="POST">
        <div class="content">
            <div style="background:#f0f0f0;width:100%;margin-right:20px;border-right:8px solid #008899;">
                <style>
                    #ulmaster{list-style:none;padding:0;margin:0;}
                    #ulmaster a{text-decoration:none;}
                    #ulmaster li{padding:10px;border-bottom:1px solid #f9f9f9;}
                    #ulmaster li:hover{background:#ddd;color:#222;}
                    #ulmasterliactive {background:#73B9FF;color:#fff;font-weight:bold;}
                </style>
                <ul id="ulmaster">		
                    <?php
                    $aktive = "id='ulmasterliactive'";
                    ?>
                    <a href="<?php echo base_url('report/daily'); ?>" title="Laporan Harian"><li <?php if($sub_page=='report/daily'){echo $aktive;} ?>>Harian</li></a>
                    <a href="<?php echo base_url('report/monthly'); ?>" title="Laporan Bulanan"><li <?php if($sub_page=='report/monthly'){echo $aktive;} ?>>Bulanan</li></a>
                    <a href="<?php echo base_url('report/yearly'); ?>" title="Laporan Tahunan"><li <?php if($sub_page=='report/yearly'){echo $aktive;} ?>>Tahunan</li></a>
                    <a href="<?php echo base_url('report/allyear'); ?>" title="Laporan Semua Tahun"><li <?php if($sub_page=='report/allyear'){echo $aktive;} ?>>Semua Tahun</li></a>
                </ul>
            </div>
        </div>
    </form>
</div>

<div id="kanan">
    <?php
    $this->load->view($sub_page);
    ?>
</div>