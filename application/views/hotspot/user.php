<script>
    function once_load() {
        getIpHotspotUser();
    }

    function getIpHotspotUser() {
        $('#luding').show();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'hotspot/get_ip_hotspot_user'; ?>",
            success: function(resp) {
                $('#luding').hide();
                $("#div_ip_hotspot_user").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $('#luding').hide();
                $("#div_ip_hotspot_user").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }
    
    once_load();
</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;" id="count_ip_hotspot_user"></span>PENGGUNA</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center><!--END DESCRIPTION-->
</div>
<div class="content">
    <div class="table-responsive" id="div_ip_hotspot_user">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
    </div>
</div>