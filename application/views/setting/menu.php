<script>
    function once_load() {
        getMainMenu();
    }

    function getMainMenu() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'setting/get_main_menu'; ?>",
            success: function(resp) {
                $("#div_main_menu").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#div_main_menu").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }
    
    once_load();
</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">MAIN</span> MENU</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">
    <div class="table-responsive" id="div_main_menu">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
    </div>
</div>