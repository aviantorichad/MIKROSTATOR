<script>
    $(document).ready(function() {
        $('#btnReboot').click(function() {
            cek = confirm('Apa kamu yakin ingin MENGHIDUPKAN ULANG Router ini?');
            if (cek) {
                $('#luding').show();
                $('#btnReboot').prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('setting/reboot_router') ?>",
                    data: $(this).serialize(),
                    success: function(data) {
                        resetForm();
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html(data);
                    },
                    error: function(event, textStatus, errorThrown) {
                        resetForm();
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    },
                    timeout: 30000
                })
            }
            return false;
        });

        $('#btnTurnOff').click(function() {
            cek = confirm('Apa kamu yakin ingin MEMATIKAN Router ini?');
            if (cek) {
                $('#luding').show();
                $('#btnTurnOff').prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('setting/turnoff_router') ?>",
                    data: $(this).serialize(),
                    success: function(data) {
                        resetForm();
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html(data);
                    },
                    error: function(event, textStatus, errorThrown) {
                        resetForm();
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    },
                    timeout: 30000
                })
            }
            return false;
        });
    });
    
    function resetForm() {
        $('#btnReboot').prop('disabled', false);
        $('#btnTurnOff').prop('disabled', false);
    }
</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">TENTANG</span> ROUTER</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label class="control-label col-sm-2" for="platform">Platform</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="platform" placeholder="Platform" value="<?php echo $res_platform; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="boardname">Board name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="boardname" placeholder="Board name" value="<?php echo $res_board_name; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="rosversion">Ros Version</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="platform" placeholder="Ros version" value="<?php echo $res_version; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="cpu">CPU</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="cpu" placeholder="CPU" value="<?php echo $res_cpu; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="cores">CPU Freq</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="cores" placeholder="Core(s)" value="<?php echo $res_cpu_frequency; ?>" readonly>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="cores">Core(s)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="cores" placeholder="Core(s)" value="<?php echo $res_cpu_count; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="cpuload">CPU Load</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="cpuload" placeholder="CPU Load" value="<?php echo $res_cpu_load; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="uptime">Uptime</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="uptime" placeholder="Uptime" value="<?php echo $res_uptime; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="memory">Memory</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="memory" placeholder="Memory" value="<?php echo $res_memory; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="disk">Disk</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="disk" placeholder="Disk" value="<?php echo $res_disk; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="sector">Sectors</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="sector" placeholder="Sector" value="<?php echo $res_sector; ?>" readonly>
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-warning" id="btnReboot">REBOOT</button>
                <button type="button" class="btn btn-danger" id="btnTurnOff">SHUT DOWN</button>
            </div>
        </div>
    </form>
</div>