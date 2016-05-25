<script>
$(document).ready(function() {
        $('#frmLoginRouter').submit(function() {
            cek = confirm('Apa kamu yakin ingin MENGUPDATE KONFIGURASI Login Router ini?\nPerubahan akan menyebabkan aplikasi logout otomatis dan kamu bisa login kembali.');
            if (cek) {
                $('#luding').show();
                $('#btnUpdate').prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('setting/update_login_router') ?>",
                    data: $(this).serialize(),
                    success: function(data) {
                        resetForm();
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html(data);
                        alert(data);
                        window.location.replace('<?php echo base_url('logout') ?>');
                    },
                    error: function(event, textStatus, errorThrown) {
                        resetForm();
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                    }
                })
            }
            return false;
        });
    });    
    
    function resetForm() {
        $('#btnUpdate').prop('disabled', false);
    }
</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">LOGIN</span> ROUTER</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">

    <?php if ($this->session->flashdata('message')) : ?>
        <div style="background:#ff9999;color:maroon;text-align:center;font-size:12px;padding:5px;margin-bottom:10px;">
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>
    <form class="form-horizontal" role="form" id="frmLoginRouter">
        <div class="form-group">
            <label class="control-label col-sm-2" for="host">Host</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="host" name="host" placeholder="Host" value="<?php echo $ro_host; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="username">Username</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $ro_username; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="password">Password</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $ro_password; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="port">Port</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="port" name="port" placeholder="Port" value="<?php echo $ro_port; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="interval">Interval (detik)</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="interval" name="interval" placeholder="Interval Auto Refresh (detik)" title="Interval Auto Refresh (in second)" value="<?php echo $ro_interval; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="interval">Auto Backup</label>
            <div class="col-sm-10">
                <select id="autobackup" name="autobackup" class="form-control" data-live-search="true" title="Auto Backup Ke DB" value="<?php echo $ro_autobackup; ?>">
                    <option value="1" <?php if($ro_autobackup=='1'){echo 'selected';} ; ?>>Yes</option>
                    <option value="0" <?php if($ro_autobackup=='0'){echo 'selected';} ; ?>>Noo</option>
                </select>
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success" id="btnUpdate">UPDATE</button>
            </div>
        </div>
    </form>
</div>