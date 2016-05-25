<script>
    function once_load() {
        
    }

    function getReportYearly(){
            var tahun = $('[name="year"]').val();
            $("#restore_result").show();
            $('#luding').show();
            $.ajax({
            type: "GET",
            url: "<?php echo base_url() . 'report/get_report_yearly'; ?>",
            data: "&tahun=" + tahun,
            success: function(resp) {
                $('#luding').hide();
                $("#div_report_yearly").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $('#luding').hide();
                $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
            }
        });
    }
    
    once_load();
</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">LAPORAN</span> TAHUNAN</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">
    <form class="form-inline" style="margin-bottom:10px;">
        <div class="form-group" style="min-width: 120px">
            <select id="year" name="year" class="selectpicker" data-live-search="true" title="Tahun" data-width="100%" required>
                <?php for($i=2015;$i<2099;$i++){ ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="button" class="btn btn-danger" onclick="getReportYearly()">PROSES</button>
    </form>
    <div class="table-responsive" id="div_report_yearly">
        
    </div>
</div>