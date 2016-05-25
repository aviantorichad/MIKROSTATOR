<script>
    function once_load() {
        
    }

    function getReportDaily(){
            var tanggal = $('[name="day"]').val();
            var bulan = $('[name="month"]').val();
            var tahun = $('[name="year"]').val();
            $("#restore_result").show();
            $('#luding').show();
            $.ajax({
            type: "GET",
            url: "<?php echo base_url() . 'report/get_report_daily'; ?>",
            data: "tanggal=" + tanggal + "&bulan=" + bulan + "&tahun=" + tahun,
            success: function(resp) {
                $('#luding').hide();
                $("#div_report_daily").html(resp);
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
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">LAPORAN</span> HARIAN</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">
    <form class="form-inline" style="margin-bottom:10px;">
        <div class="form-group" style="min-width: 120px">
            <select id="day" name="day" class="selectpicker" data-live-search="true" title="Tanggal" data-width="100%" required>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
            </select>
        </div>
        <div class="form-group" style="min-width: 120px">
            <select id="month" name="month" class="selectpicker" data-live-search="true" title="Bulan" data-width="100%" required>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>
        <div class="form-group" style="min-width: 120px">
            <select id="year" name="year" class="selectpicker" data-live-search="true" title="Tahun" data-width="100%" required>
                <?php for($i=2015;$i<2099;$i++){ ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="button" class="btn btn-danger" onclick="getReportDaily()">PROSES</button>
    </form>
    <div class="table-responsive" id="div_report_daily">
        
    </div>
</div>