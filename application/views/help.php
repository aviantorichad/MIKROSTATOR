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
        <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">BANTUAN</span></h1></center><!--END TITLE-->
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
                    <a href="<?php echo base_url('help/icon_list'); ?>" title="Daftar Icon"><li <?php if($sub_page=='help/icon_list'){echo $aktive;} ?>>Daftar Icon</li></a>
                    <a href="<?php echo base_url('help/bookmark'); ?>" title="Bookmark"><li <?php if($sub_page=='help/bookmark'){echo $aktive;} ?>>Web Favorit</li></a>
                    <a href="<?php echo base_url('help/about_mikrostator'); ?>" title="Tentang MIKROSTATOR"><li <?php if($sub_page=='help/about_mikrostator'){echo $aktive;} ?>>Tentang MIKROSTATOR</li></a>
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