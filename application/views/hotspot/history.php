<script>
    function once_load() {
        getHistoryJam();
        getHistoryMikrotik();
    }

    function getHistoryJam() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'hotspot/get_history_jam'; ?>",
            success: function(resp) {
                $("#div_history_jam").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#div_history_jam").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }

    function getHistoryMikrotik() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'hotspot/get_history_mikrotik'; ?>",
            success: function(resp) {
                $("#div_history_mikrotik").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#div_history_mikrotik").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }

    once_load();
</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">LOG</span> MIKROSTATOR</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->

</div>
<div class="content">
    <style>
        table td, table th{font-size:11px;}
        .nowrap {white-space:nowrap;}
    </style>
    <div class="table-responsive" id="div_history_jam">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
    </div>
</div>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">LOG</span> MIKROTIK</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">
    <div class="table-responsive" id="div_history_mikrotik">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
    </div>
</div>