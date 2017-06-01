<script>
    function once_load() {

    }

    function getVoucherList() {
        var namavoucher = $('[name="namavoucher"]').val();
        $('#luding').show();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() . 'voucher/get_voucher_list'; ?>",
            data: "namavoucher=" + namavoucher,
            success: function(resp) {
                $('#luding').hide();
                $("#div_voucher_list").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $('#luding').hide();
                $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
            }
        });
    }


    function printVoucherList() {
        var namavoucher = $('[name="namavoucher"]').val();
        $('#luding').show();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() . 'voucher/cetak_voucher_list'; ?>",
            data: "namavoucher=" + namavoucher,
            success: function(resp) {
                $('#luding').hide();
                $("#div_voucher_list").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $('#luding').hide();
                $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
            }
        });
    }

    function printVoucherList2() {
        var namavoucher = $('[name="namavoucher"]').val();
        window.open("<?php echo base_url('voucher/cetak_voucher_list2'); ?>/" + namavoucher, "_blank");
    }

    function deleteVoucherList() {

        konfirmasi = confirm('Apa kamu yakin ingin menghapus VOUCHER ini (semua user pada VOUCHER tersebut akan dihapus)?');
        if (konfirmasi) {
            var namavoucher = $('[name="namavoucher"]').val();
            $('#luding').show();
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() . 'voucher/hapus_voucher_list'; ?>",
                data: "namavoucher=" + namavoucher,
                success: function(resp) {
                    $('#luding').hide();
                    $('#vouchername').selectpicker('deselectAll');
                    $('#lbl_msg').fadeIn('slow');
                    $('#lbl_msg').html(resp);
                    $("#div_voucher_list").html(resp);
                    getBaruSaja();
                },
                error: function(event, textStatus, errorThrown) {
                    $('#luding').hide();
                    $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                }
            });
        }
    }

    once_load();
</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">DAFTAR</span> VOUCHER</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
</div>
<div class="content">
    <form class="form-inline" style="margin-bottom:10px;">
        <div class="form-group" style="min-width: 200px">
            <select id="vouchername" name="namavoucher" class="selectpicker" data-live-search="true" title="Nama Voucher" data-width="100%" required onchange="getVoucherList()">
                <?php
                foreach ($vouchername as $row) {
                    $name = $row->voucher_name;
                    echo '<option value="' . $name . '">' . $name . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="button" class="btn btn-info" onclick='printVoucherList2()'>CETAK</button>
        <button type="button" class="btn btn-danger" onclick="deleteVoucherList()">HAPUS</button>
    </form>
    <div class="table-responsive" id="div_voucher_list">

    </div>
</div>