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
        <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">KONFIGURASI</span></h1></center><!--END TITLE-->
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
                    <a href="<?php echo base_url('setting'); ?>" title="About Router"><li <?php if($sub_page=='setting/about_router'){echo $aktive;} ?>>Tentang Router</li></a>
                    <a href="<?php echo base_url('setting/login_router'); ?>" title="Login Router"><li <?php if($sub_page=='setting/login_router'){echo $aktive;} ?>>Login Router</li></a>
                    <a href="<?php echo base_url('setting/background_mac'); ?>" title="Background MAC"><li <?php if($sub_page=='setting/background_mac'){echo $aktive;} ?>>Background MAC</li></a>
                    <a href="<?php echo base_url('setting/menu'); ?>" title="Menu"><li <?php if($sub_page=='setting/menu'){echo $aktive;} ?>>Main Menu</li></a>
                    <a href="<?php echo base_url('setting/gadget_list'); ?>" title="Pilihan Gadget"><li <?php if($sub_page=='setting/gadget_list'){echo $aktive;} ?>>Pilihan Gadget</li></a>
                    <a href="<?php echo base_url('setting/user_admin'); ?>" title="User Admin"><li <?php if($sub_page=='setting/user_admin'){echo $aktive;} ?>>Administrator</li></a>
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