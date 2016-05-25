<script>
    function once_load() {
        getReportAllYear();
    }

    function getReportAllYear(){
            $("#restore_result").show();
            $.ajax({
            type: "GET",
            url: "<?php echo base_url() . 'report/get_report_allyear'; ?>",
            success: function(resp) {
                $('#luding').hide();
                $("#div_report_allyear").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $('#luding').hide();
                $('#div_report_allyear').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
            }
        });
    }
    
    once_load();
</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">LAPORAN</span> SEMUA TAHUN</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">
    <div class="table-responsive" id="div_report_allyear">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
    </div>
</div>