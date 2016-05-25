<script>
    function once_load() {
        getDhcpServerLeases();
    }

    function getDhcpServerLeases() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'hotspot/get_dhcp_server_leases'; ?>",
            success: function(resp) {
                $("#div_dhcp_server_leases").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#div_dhcp_server_leases").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }
    
    once_load();
</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">DHCP SERVER</span> > LEASES</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">
    <div class="table-responsive" id="div_dhcp_server_leases">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
    </div>
</div>