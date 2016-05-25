<script>
    var chk_auto = "";

    function once_load() {

    }

    function monitoring() {
        chk_auto = $("#chkAutoRefresh").is(':checked');
        if(chk_auto){
            $("#info_baru_saja").css('border-top', '5px solid #77bb77');
        } else {
            $("#info_baru_saja").css('border-top', 'none');
        }
        getBaruSaja();
        getRiwayatJam();
        getStatusTerbaru();
        getHotspotActive();
        getLogHotspot();
    }

    var auto_refresh = setInterval(
            function() {
                if (chk_auto) {
                    monitoring()
                }
            },
<?php echo $this->mikrostator->get('interval'); ?> // Interval auto refresh 1000 = 1 Detik
    );

    function getBaruSaja() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'home/get_baru_saja'; ?>",
            success: function(resp) {
                $("#info_baru_saja").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#info_baru_saja").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }

    function getRiwayatJam() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'home/get_riwayat_jam'; ?>",
            success: function(resp) {
                $("#div_riwayat_jam").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#div_riwayat_jam").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }

    function getStatusTerbaru() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'home/get_status_terbaru'; ?>",
            success: function(resp) {
                $("#container_status").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#container_status").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }

    function getHotspotActive() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'home/get_hotspot_active'; ?>",
            success: function(resp) {
                $("#div_hotspot_active").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#div_hotspot_active").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }

    function getLogHotspot() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . 'home/get_log_hotspot'; ?>",
            success: function(resp) {
                $("#div_log_hotspot").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#div_log_hotspot").html('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            }
        });
    }

    function konfirmasi() {
        var user = $('#txt_selectuser').val();
        var tambah = $('#txt_tambah').val();
        var tipe = $('#txt_selecttype').val();
        var tipejam = $('#txt_selectgadget').val();
        var msg2 = '';

        if (tambah <= 0) {
            alert('PERHATIAN! *Tambah berapa* harus lebih dari 0');
            return false;
        }

        if (tipejam == 'trf') {
            if ($('#txt_selectuser2').val() == '') {
                $('#txt_selectuser2').focus();
                alert('PERHATIAN! Sumber transfer belum dipilih.');
                return false;
            }

            if ($('#txt_selectuser2').val() == $('#txt_selectuser').val()) {
                alert('PERHATIAN! Pengguna dan sumber transfer tidak boleh sama.');
                return false;
            }

            if (tipe == 'rupiah') {
                alert('PERHATIAN! Jika tipenya TRANSFER, penambah harus berupa waktu.');
                return false;
            }
            user2 = $('#txt_selectuser2').val();
            msg2 = 'dan mengurangi ' + user2 + ' sebesar ' + tambah + ' ' + tipe + ' ';
        }
        return confirm('Apa kamu yakin ingin menambahkan ' + user + ' sebesar ' + tambah + ' ' + tipe + ' ' + msg2 + '(' + tipejam + ') ?');
    }

    function cektrf(tipe) {
        if (tipe == 'trf') {
            $('#sel_trf').css({"display": "block"});
        } else {
            $('#sel_trf').css({"display": "none"});
        }
    }

    function hitungrumus() {
        var str = $('#txt_tambah').val();
        var res = str.substring(0, 1);
        var rumus = str.substring(1);
        if (res == "=") {
            if (rumus != '') {
                $("#rumus_result").html('<center><span style="color:#b30000;">' + rumus + '=</span><span style="color:#009988;font-weight:bold;">' + eval(rumus) + '</span></center>');
            }
        } else {
            $("#rumus_result").html('');
            if (str != '') {
                if ($('#txt_selecttype').val() == "menit") {
                    $("#detail_type").html(str + ' menit (' + $('#txt_selectgadget').val() + ')');
                } else {
                    $("#detail_type").html(toRp(str) + ' (' + $('#txt_selectgadget').val() + ')');
                }
            } else {
                $("#detail_type").html('');
            }
        }
    }

    function toRp(angka) {
        //https://faisalman.com/2012/02/27/konversi-angka-ke-format-rupiah-di-javascript/
        var rev = parseInt(angka, 10).toString().split('').reverse().join('');
        var rev2 = '';
        for (var i = 0; i < rev.length; i++) {
            rev2 += rev[i];
            if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                rev2 += '.';
            }
        }
        return 'Rp. ' + rev2.split('').reverse().join('') + ',-';
    }

    function resetForm() {
        $('#txt_selectuser').selectpicker('deselectAll');
        $('#txt_selectgadget').selectpicker('deselectAll');
        $('#txt_selectuser2').selectpicker('deselectAll');
        $('#txt_selecttype').selectpicker('deselectAll');
        $('#txt_tambah').val('');
        $("#detail_type").html('');
        $('#btnTambah').prop('disabled', false);
    }

    $(document).ready(function() {
        $('#frmTambahjam').submit(function() {
            if (konfirmasi()) {
                $('#luding').show();
                $('#lbl_msg').fadeOut('slow');
                $('#btnTambah').prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url('home/tambahJam') ?>",
                    data: $(this).serialize(),
                    success: function(data) {
                        resetForm();
                        $('#luding').hide();
                        $('#lbl_msg').fadeIn('slow');
                        $('#lbl_msg').html(data);
                        getBaruSaja();
                        getRiwayatJam();
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

    once_load();
    monitoring();
    
    function transaksiLain()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //$('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Transaksi Lain'); // Set Title to Bootstrap modal title
        $('#modal_form').modal({
            backdrop: false
        });
        //https://silviomoreto.github.io/bootstrap-select/
        //$('.selectpicker').selectpicker({
        //    size: 4
        //  });

    }
    
    function save() {
        if (save_method == 'add') {
            url = "<?php echo site_url('home/simpan_tambah_transaksi_lain') ?>";
            konfirmasi = confirm('Apa kamu yakin ingin MENAMBAHKAN TRANSAKSI ' + $('[name="trx_username"]').val() + '?');
        } else {
            url = "<?php echo site_url('hotspot/simpan_update_transaksi_lain') ?>";
            konfirmasi = confirm('Apa kamu yakin ingin MENGUBAH data ' + $('[name="trx_username"]').val() + '?');
        }
        if (konfirmasi) {
            $('#luding').show();
            $('#lbl_msg').fadeOut('slow');
            $('#btnTambah').prop('disabled', true);
            user = $('[name="trx_username"]').val();
            nominal = $('[name="trx_nominal"]').val();
            transaksi = $('[name="trx_keterangan"]').val();
            $.ajax({
                type: 'POST',
                url: url,
                data: 'user=' + user + '&nominal=' + nominal + '&transaksi=' + transaksi,
                success: function(data) {
                    //resetForm();
                    $('#modal_form').modal('hide');
                    $('#luding').hide();
                    $('#lbl_msg').fadeIn('slow');
                    $('#lbl_msg').html(data);
                    getBaruSaja();
                    getRiwayatJam();
                },
                error: function(event, textStatus, errorThrown) {
                    //resetForm();
                    $('#modal_form').modal('hide');
                    $('#luding').hide();
                    $('#lbl_msg').fadeIn('slow');
                    $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
                }
            })
        }
        return false;
    }

</script>
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Formulir Hotspot User</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama</label>
                            <div class="col-md-9">
                                <input name="trx_username" placeholder="Nama" class="form-control" type="text" autocomplete="off">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Transaksi</label>
                            <div class="col-md-9">
                                <input name="trx_keterangan" placeholder="Transaksi" class="form-control" type="text" autocomplete="off">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Biaya</label>
                            <div class="col-md-9">
                                <input name="trx_nominal" placeholder="Harga" class="form-control" type="text" autocomplete="off">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<div id="kiri">
    <!--HEADER-->
    <div class="header">
        <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">TAMBAH</span> JAM</span></h1></center><!--END TITLE-->
        <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
    </div>
    <form name="frm_tambah_jam" id="frmTambahjam" method="POST">
        <div class="content">
            <div class="form-group">
                <select id="txt_selectuser" name="selectuser" class="selectpicker" data-live-search="true" title="Pilih pengguna" data-width="100%" required data-style="btn-danger">
                    <?php
                    foreach ($hotspotuser as $row) {
                        $name = $row['name'];
                        $password = $row['password'];
                        $profile = $row['profile'];
                        $limit_uptime = "";
                        if (isset($row['limit-uptime'])) {
                            $limit_uptime = $row['limit-uptime'];
                        }
                        $uptime = $row['uptime'];
                        $bytes_in = $row['bytes-in'];
                        $bytes_out = $row['bytes-out'];
                        $sisa_time = $this->stator->time_elapsed_A($this->stator->get_menit($limit_uptime, 's') - $this->stator->get_menit($uptime, 's'));
                        echo "<option value='" . $name . "' data-subtext='(" . $sisa_time . ")' data-icon='glyphicon-user'>" . $name . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <select id="txt_selectgadget" name="selectgadget" class="selectpicker" data-live-search="true" title="Pilih perangkat" data-width="100%" required data-style="btn-warning" onchange="cektrf(this.value)">
                    <?php
                    foreach ($selectgadget as $row):
                        $list_id = $row->list_id;
                        $list_name = $row->list_name;
                        $list_value = $row->list_value;
                        $list_note = $row->list_note;
                        $list_icon = $row->list_icon;
                        ?>
                        <option value="<?php echo $list_value; ?>" data-subtext="<?php echo $list_note; ?>" data-icon="<?php echo $list_icon; ?>"><?php echo $list_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group" id="sel_trf" style="display:none;">
                <select id="txt_selectuser2" name="selectuser2" class="selectpicker" data-live-search="true" title="Pilih sumber transfer" data-width="100%" data-style="btn-success">
                    <?php
                    foreach ($hotspotuser as $row) {
                        $name = $row['name'];
                        $password = $row['password'];
                        $profile = $row['profile'];
                        $limit_uptime = "";
                        if (isset($row['limit-uptime'])) {
                            $limit_uptime = $row['limit-uptime'];
                        }
                        $uptime = $row['uptime'];
                        $bytes_in = $row['bytes-in'];
                        $bytes_out = $row['bytes-out'];
                        $sisa_time = $this->stator->time_elapsed_A($this->stator->get_menit($limit_uptime, 's') - $this->stator->get_menit($uptime, 's'));
                        echo "<option value='" . $name . "' data-subtext='(" . $sisa_time . ")' data-icon='glyphicon-user'>" . $name . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <select id="txt_selecttype" name="selecttype" class="selectpicker" data-live-search="true" title="Uang atau waktu?  " data-width="100%" required data-style="btn-primary">
                    <?php
                    foreach ($selecttype as $row):
                        $list_id = $row->list_id;
                        $list_name = $row->list_name;
                        $list_value = $row->list_value;
                        $list_note = $row->list_note;
                        $list_icon = $row->list_icon;
                        ?>
                        <option value="<?php echo $list_value; ?>" data-subtext="<?php echo $list_note; ?>" data-icon="<?php echo $list_icon; ?>"><?php echo $list_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <input name="nominal" type="text" id="txt_tambah" placeholder="Tambah berapa?" class="input username" style="font-weight:bold;border-radius:4px;color:red;font-size:22px;text-align:right;"  autocomplete="off" required onkeyup="hitungrumus()"/>
            </div>
            <div id="detail_type" style="text-align:right;font-size:10px;"></div>

        </div>
        <div class="footer">
            <input type="submit" name="submit" value="PROSES" class="button proses" id="btnTambah" style="font-weight:bold;border-radius:4px;" />
            <div style="color:#999;font-size:10px;font-style:italic;text-align:right;">(<a href="javascript:void(0)" onclick="transaksiLain()">transaksi lain</a>)</div>
            <div id="rumus_result"></div>
            <br/>
        </div>
    </form>
</div>

<div id="kanan">
    <!--HEADER-->
    <div class="header">
        <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">ON</span><span>LINE</span> <span id="count_online" style="background:#ff4444;color:#fff;border-radius:4px;padding:0px 10px;text-shadow:none;font-size:44px;">0</span></span></h1></center><!--END TITLE-->
        <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->

    </div>
    <div class="content">
        <div id="container_status">
            <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
        </div>
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>

        <div class="progress" style="height:8px;margin-bottom:0;" id="status_cpu_strip">
            <div class="progress-bar progress-bar-success progress-bar-striped" style="width: 0%" style="min-width: 2em;">
            </div>
        </div>
        <div class="table-responsive" id="div_hotspot_active">
            <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
        </div>

        <div style="font-size:10px;font-style:italic;color:#ff265c;" id="diperbarui_pada"></div>
    </div>

    <!--CONTAINER LOG HOTSPOT.begin-->
    <!--HEADER-->
    <div class="header">
        <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">LOG</span> HOTSPOT</span></h1></center><!--END TITLE-->
        <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
    </div>
    <div class="content">
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive" id="div_log_hotspot">
            <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
        </div>
    </div>
    <!--CONTAINER LOG HOTSPOT.end-->

    <!--CONTAINER RIWAYAT JAM.begin-->
    <!--HEADER-->
    <div class="header">
        <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">RIWAYAT</span> JAM</span></h1></center><!--END TITLE-->
        <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center> --><!--END DESCRIPTION-->
    </div>
    <div class="content">
        <style>
            table td, table th{font-size:11px;}
            .nowrap {white-space:nowrap;}
        </style>
        <div class="table-responsive" id="div_riwayat_jam">
            <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
        </div>
    </div>
    <!--CONTAINER RIWAYAT JAM.end-->
</div>

<script>
    function PlayNow() {
        var url = "<?php echo base_url('home/playNow') ?>";
        url = url;
        window.open(url, "playNOW", "toolbar=no,scrollbars=no,resizable=no,top=200,left=200,width=200,height=200,menubar=no,titlebar=no,location=no");
    }

    var awal_ol = 0;
    function cek_ol(ol) {
        if (ol > awal_ol) {
            awal_ol = ol;
        } else if (ol < awal_ol) {
            PlayNow();
            awal_ol = ol;
        } else {
        }
    }
</script>