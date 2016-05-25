<script>
    function once_load() {

    }

    function doGenerateVoucher() {

        konfirmasi = confirm('Apa kamu yakin ingin meng-GENERATE VOUCHER ini?');
        if (konfirmasi) {
            var namavoucher = $('[name="namavoucher"]').val();
            var qty = $('[name="qty"]').val();
            var userprofile = $('[name="userprofile"]').val();
            var limituptime = $('[name="limituptime"]').val();
            var tipepassword = $('[name="tipepassword"]').val();
            var password = '';
            if (tipepassword == 'mt') {
                var password = $('[name="password"]').val();
            }
            $('#luding').show();
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() . 'voucher/do_generate_voucher'; ?>",
                data: "namavoucher=" + namavoucher + "&qty=" + qty + "&userprofile=" + userprofile + "&limituptime=" + limituptime + "&tipepassword=" + tipepassword + "&password=" + password,
                success: function(resp) {
                    $('#luding').hide();
                    $("#div_generate_voucher").html(resp);
                    resetForm();
                },
                error: function(event, textStatus, errorThrown) {
                    $('#luding').hide();
                    $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                }
            });
        }
    }

    function togglePasswordType() {
        if ($('#tipepassword').val() == 'at') {
            $('#password').hide();
        } else {
            $('#password').show();
        }
    }

    function resetForm() {
        $('#tipepassword').selectpicker('deselectAll');
        $('#userprofile').selectpicker('deselectAll');
        $('#namavoucher').val('');
        $('#password').val('');
        $('#qty').val('');
        $('#limituptime').val('');
    }

    once_load();</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">GENERATE</span> VOUCHER</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label class="control-label col-sm-2">Nama Voucher</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="namavoucher" name="namavoucher" placeholder="Nama Voucher" autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Password</label>
            <div class="col-sm-10">
                <select id="tipepassword" name="tipepassword" class="selectpicker" title="Tipe Password" data-width="100%" required onchange="togglePasswordType()">
                    <option value="at">Otomatis</option>
                    <option value="mt">Manual</option>
                </select>
                <input type="text" class="form-control" id="password" name="password" placeholder="Password" style="display:none;margin-top:10px;" autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">User Profile</label>
            <div class="col-sm-10">
                <select id="userprofile" name="userprofile" class="form-control selectpicker" data-live-search="true" title="Pilih profil pengguna">
                    <?php
                    foreach ($this->mikrostator->get('hotspotuserprofile') as $row) {
                        $name = $row['name'];
                        echo '<option value="' . $name . '">' . $name . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Qty</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="qty" name="qty" placeholder="Qty" autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Limit Uptime</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="limituptime" name="limituptime" placeholder="Limit Uptime. Ex: 7d12h59m59s">
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-danger" onclick="doGenerateVoucher()">PROSES</button>
            </div>
        </div>
    </form>
    <div class="table-responsive" id="div_generate_voucher">

    </div>
</div>