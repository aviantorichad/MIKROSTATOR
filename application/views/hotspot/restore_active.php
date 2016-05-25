<script>
    function once_load() {
        
    }
    
    function getRestoreTableJam(){
            var jam = $("#txt_selecttime").val();
            $("#restore_result").show();
            $('#luding').show();
            $.ajax({
            type: "GET",
            url: "<?php echo base_url() . 'hotspot/get_restore_table_jam'; ?>/" + jam,
            success: function(resp) {
                $('#luding').hide();
                $("#div_restore_table_jam").html(resp);
            },
            error: function(event, textStatus, errorThrown) {
                $("#restore_result").hide();
                $('#luding').hide();
                $('#luding').hide();
                $('#lbl_msg').html('Terjadi kesalahan pada sistem ajax. Saran: Refresh halaman dan ulangi kembali. (Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown + ')');
            }
        });
    }
    
    once_load();
</script>
<!--HEADER-->
<div class="header">
    <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;" id="count_ip_hotspot_user">PULIHKAN/</span>RESTORE</span></h1></center><!--END TITLE-->
    <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center><!--END DESCRIPTION-->
</div>
<div class="content">
    <form class="form-inline">
        <?php
        echo '<div class="form-group" style="width:200px">';
                echo '<select id="txt_selecttime" name="selecttime" class="selectpicker" data-live-search="true" title="Pilih jam" data-width="100%" required onchange="getRestoreTableJam()">';
                        $query = $this->db->query("SELECT DISTINCT active_last_update FROM `wk_hotspot_active` ORDER BY active_id DESC LIMIT 0,300");
                        foreach ($query->result() as $row) {
                                $active_last_update = $row->active_last_update;
                                echo "<option value='".date('dmYHis', strtotime($active_last_update))."' data-icon='glyphicon-time'>".date('d/m/Y H:i:s', strtotime($active_last_update))."</option>";
                        }
                echo "</select>";
        echo "</div>";
        ?>
      <button type="button" class="btn btn-danger" onclick="pulihkanJam()">PROSES</button>
      
    </form>
</div>
<div id="restore_result" style="display:none">
    <!--HEADER-->
    <div class="header">
        <!--TITLE--><center style="margin-bottom:-20px;"><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;">JAM</span> (<span id="waktu_pilihan">-</span>)</span></h1></center><!--END TITLE-->
        <!--DESCRIPTION--><!-- <center><h2><span style="font-size:11px;color:#008899;">..::: PENGGUNA RTPAPAT.NET :::...</span></h2></center><!--END DESCRIPTION-->
    </div>
    <div class="content">
        <div class="table-responsive" id="div_restore_table_jam">
            <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> <i>sedang memuat data...</i>
        </div>
    </div>
</div>