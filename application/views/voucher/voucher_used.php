<script>
    function once_load() {
        
    }

    function getVoucherUsed(){
            var namavoucher = $('[name="namavoucher"]').val();
            $('#luding').show();
            $.ajax({
            type: "GET",
            url: "<?php echo base_url() . 'voucher/get_voucher_used'; ?>",
            data: "namavoucher=" + namavoucher,
            success: function(resp) {
                $('#luding').hide();
                $("#div_voucher_used").html(resp);
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
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">PENGGUNAAN</span> VOUCHER</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">
    <form class="form-inline" style="margin-bottom:10px;">
        <div class="form-group" style="min-width: 200px">
            <select id="vouchername" name="namavoucher" class="selectpicker" data-live-search="true" title="Nama Voucher" data-width="100%" required onchange="getVoucherUsed()">
                <?php 
                foreach ($vouchername as $row) {
                    $name = $row->voucher_name;
                    echo '<option value="' . $name . '">' . $name . '</option>';
                }
                ?>
            </select>
        </div>
    </form>
    <div class="table-responsive" id="div_voucher_used">
        
    </div>
</div>