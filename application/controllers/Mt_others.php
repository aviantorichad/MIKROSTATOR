<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mt_others extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('stator_model');
        $this->load->model('rich_model');
        $this->load->model('report_model');
    }

    public function dashboard($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {

            // get system resources.begin
            $array1 = $API->comm('/system/resource/print');
            $val_resource = isset($array1[0]) ? $array1[0] : array();
            $resource_platform = isset($val_resource['platform']) ? $val_resource['platform'] : '';
            $resource_architecture_name = isset($val_resource['architecture-name']) ? $val_resource['architecture-name'] : '';
            $resource_board_name = isset($val_resource['board-name']) ? $val_resource['board-name'] : '';
            $resource_version = isset($val_resource['version']) ? $val_resource['version'] : '';
            $resource_cpu = isset($val_resource['cpu']) ? $val_resource['cpu'] : '';
            $resource_cpu_load = isset($val_resource['cpu-load']) ? $val_resource['cpu-load'] : '';
            $resource_cpu_count = isset($val_resource['cpu-count']) ? $val_resource['cpu-count'] : '';
            $resource_uptime = isset($val_resource['uptime']) ? $val_resource['uptime'] : '';
            $resource_build_time = isset($val_resource['build-time']) ? $val_resource['build-time'] : '';
            $resource_build_time = isset($val_resource['build-time']) ? $val_resource['build-time'] : '';
            $resource_write_sect_since_reboot = isset($val_resource['write-sect-since-reboot']) ? $val_resource['write-sect-since-reboot'] : '';
            $resource_write_sect_total = isset($val_resource['write-sect-total']) ? $val_resource['write-sect-total'] : '';
            $resource_free_memory = isset($val_resource['free-memory']) ? $this->rich_model->formatBytes($val_resource['free-memory']) : '';
            $resource_total_memory = isset($val_resource['total-memory']) ? $this->rich_model->formatBytes($val_resource['total-memory']) : '';
            $resource_free_hdd_space = isset($val_resource['free-hdd-space']) ? $this->rich_model->formatBytes($val_resource['free-hdd-space']) : '';
            $resource_total_hdd_space = isset($val_resource['total-hdd-space']) ? $this->rich_model->formatBytes($val_resource['total-hdd-space']) : '';
            // get system resources.end
            // get ip hotspot user.begin
            $array2 = $API->comm('/ip/hotspot/user/print', array(
                "count-only" => ''
            ));
            $count_hotspot_user = isset($array2) ? $array2 : 0;
            // get ip hotspot user.end
            // get ip hotspot active.begin
            $array3 = $API->comm('/ip/hotspot/active/print', array(
                "count-only" => ''
            ));
            $count_hotspot_active = isset($array3) ? $array3 : 0;
            $persen_hotspot_active = $count_hotspot_active / $count_hotspot_user * 100;
            // get ip hotspot active.end
            ?>

            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <!-- Info Boxes Style 2 -->
                    <div class="info-box bg-yellow">
                        <span class="info-box-icon"><i class="fa fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Hotspot User</span>
                            <span class="info-box-number"><?= $count_hotspot_user ?></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">
                                
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green">
                        <span class="info-box-icon"><i class="fa fa-wifi"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Hotspot Active</span>
                            <span class="info-box-number"><?= $count_hotspot_active ?></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: <?= $persen_hotspot_active ?>%"></div>
                            </div>
                            <span class="progress-description">
                                <?= number_format($persen_hotspot_active, 2) ?>% of <?= $count_hotspot_user ?> User(s)
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <!-- /.info-box -->
                    <div class="info-box bg-red">
                        <span class="info-box-icon"><i class="fa fa-dashboard"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">CPU</span>
                            <span class="info-box-number"><?= $resource_cpu_load ?>%</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: <?= $resource_cpu_load ?>%"></div>
                            </div>
                            <span class="progress-description">
                                <small><?= $resource_cpu ?> x<?= $resource_cpu_count ?></small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-aqua">
                        <span class="info-box-icon"><i class="fa fa-eye"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">UPTIME</span>
                            <span class="info-box-number"><?= $resource_uptime ?></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 40%"></div>
                            </div>
                            <span class="progress-description">
                                ref: <?= date('d/m/y H:i:s') ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xs-12">
                    <!-- /.info-box -->
                    <div class="info-box bg-gray">
                        <span class="info-box-icon"><i class="fa fa-gear"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><b><?= $resource_platform ?> ver. <?= $resource_version ?></b></span>
                            <span class="progress-description">
                                Architecture Name: <b><?= $resource_architecture_name ?></b>,
                                Board Name: <b><?= $resource_board_name ?></b><br/>
                                Memory: <b><?= $resource_free_memory ?>/<?= $resource_total_memory ?></b>, 
                                HDD: <b><?= $resource_free_hdd_space ?>/<?= $resource_total_hdd_space ?></b><br/>
                                Sector Writes Since Reboot: <b><?= $resource_write_sect_since_reboot ?></b>,
                                Total Sector Writes: <b><?= $resource_write_sect_total ?></b>,
                                Build Time: <b><?= $resource_build_time ?></b>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <script>
                $('#refresh-<?= $session_id ?>-menu-profile').on('click', function () {
                    $('#mikrostator-section #mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                        url: "<?= site_url('mt_others/profile') ?>/" + itemValue,
                        success: function (data) {
                            $('#mikrostator-section #mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                            alert(msgError);
                            $('#mikrostator-section #mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                        }
                    });
                });
            </script>
            <?php
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Mikrotik not connected!</h4>                    
            </div>
            <?php
        }
    }

    public function ping($session_id, $cmd = "") {
        ?>
        <div class="pull-right">Real time
            <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                <button type="button" class="btn btn-default btn-xs active" data-toggle="on">On</button>
                <button type="button" class="btn btn-default btn-xs" data-toggle="off">Off</button>
            </div>
        </div>
        <br/>
        <br/>
        <div id="interactive" style="height: 300px;"></div>
        <script>
            $(function () {
                /*
                 * Flot Interactive Chart
                 * -----------------------
                 */
        // We use an inline data source in the example, usually data would
        // be fetched from a server
                var data = [], totalPoints = 100;

                function getRandomData() {

                    if (data.length > 0)
                        data = data.slice(1);

        // Do a random walk
                    while (data.length < totalPoints) {

                        var prev = data.length > 0 ? data[data.length - 1] : 50,
                                y = prev + Math.random() * 10 - 5;

                        if (y < 0) {
                            y = 0;
                        } else if (y > 100) {
                            y = 100;
                        }

                        data.push(y);
                    }

        // Zip the generated y values with the x values
                    var res = [];
                    for (var i = 0; i < data.length; ++i) {
                        res.push([i, data[i]]);
                    }

                    return res;
                }

                var interactive_plot = $.plot("#interactive", [getRandomData()], {
                    grid: {
                        borderColor: "#f3f3f3",
                        borderWidth: 1,
                        tickColor: "#f3f3f3"
                    },
                    series: {
                        shadowSize: 0, // Drawing is faster without shadows
                        color: "#3c8dbc"
                    },
                    lines: {
                        fill: true, //Converts the line chart to area chart
                        color: "#3c8dbc"
                    },
                    yaxis: {
                        min: 0,
                        max: 100,
                        show: true
                    },
                    xaxis: {
                        show: true
                    }
                });

                var updateInterval = 500; //Fetch data ever x milliseconds
                var realtime = "on"; //If == to on then fetch data every x seconds. else stop fetching
                function update() {

                    interactive_plot.setData([getRandomData()]);

        // Since the axes don't change, we don't need to call plot.setupGrid()
                    interactive_plot.draw();
                    if (realtime === "on")
                        setTimeout(update, updateInterval);
                }

        //INITIALIZE REALTIME DATA FETCHING
                if (realtime === "on") {
                    update();
                }
        //REALTIME TOGGLE
                $("#realtime .btn").click(function () {
                    if ($(this).data("toggle") === "on") {
                        realtime = "on";
                    } else {
                        realtime = "off";
                    }
                    update();
                });
                /*
                 * END INTERACTIVE CHART
                 */
            });
        </script>
        <?php
    }

    public function form_billing($session_id, $cmd = "") {
        /*
        required: 
        - harus ada di script mikrotik dengan kondisi:
        --- name: mikrostator_list_type
        --- source: 
                [ { "name":"LAPTOP", "value":"pc", "price":"2500" }, { "name": "HP", "value": "hp", "price":"2000" }, { "name": "GADGET MAHAL", "value": "gm", "price":"20000" }]
        */
        ?>
        <div class="box no-border" style="background-color: #2c3b41; color: #ddd;">
            <div class="box-body">

        <div class="row">
                <!-- /.col -->
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-primary btn-sm" id="billing_refresh-<?= $session_id ?>"><i class="fa fa-refresh"></i> REFRESH FORM</button>
                    <button type="button" class="btn btn-info btn-sm" id="billing_config-<?= $session_id ?>"><i class="fa fa-gear"></i> CONFIG</button>
                </div>
                <br>
                <br>
                <div id="billing_notifikasi-<?= $session_id ?>"></div>
                <form autocomplete="off">
                    <div class="form-group">
                        <label class="control-label">User:</label>
                        <select class="form-control input-lg select2" id="billing_user-<?= $session_id ?>" onchange="return false;$('#user_detail-<?= $session_id ?>').html('limit-uptime: ' + $('option:selected', $(this)).data('limituptime'),)" style="border-color: #dd4b39;">
                            <option value="*">-- select user --</option>
                        </select>
                        <!-- <span class="help-block text-right" id="user_detail-<?= $session_id ?>"></span> -->
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Type:</label>
                        <select class="form-control select2" id="billing_type-<?= $session_id ?>" onchange="$(this).val()=='tr'?$('#frm_billing_user2-<?= $session_id ?>').show():$('#frm_billing_user2-<?= $session_id ?>').hide()" style="border-color: #009abf;">
                            <option value="*">-- select type --</option>
                        </select>
                    </div>

                    <div class="form-group" id="frm_billing_user2-<?= $session_id ?>" style="display:none;">
                        <label class="control-label">Sender:</label>
                        <select class="form-control" id="billing_user2-<?= $session_id ?>" onchange="$(this).val()==$('#billing_user-<?= $session_id ?>').val()?($(this).val('*'),alert('Sender can not same with User.')):null" style="border-color: #f39c12;">
                            <option value="*">-- select sender --</option>
                        </select>
                    </div>
                    
                    <div class="form-group" style="display:none;">
                        <label class="control-label">Time or Money:</label>
                        <select class="form-control select2" id="billing_tom-<?= $session_id ?>">
                            <option value="*">-- select time or money --</option>
                            <option value="money">MONEY</option>
                            <option value="time">TIME</option>
                        </select>
                        <small class="help-block">*TRANSFER type must use TIME</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">How Much?:</label>
                        <input type="text" class="form-control input-lg" id="billing_total-<?= $session_id ?>" placeholder="..." onkeyup="hitungrumus()" style="font-weight:bold;color:red;" />
                        <small class="help-block" id="rumus_result"></small>
                    </div>
                    
                    <button type="button" class="btn btn-success btn-block btn-lg" id="billing_process-<?= $session_id ?>"><i class="fa fa-check"></i> PROCESS</button>
                    
                </form>
            </div>
            <!-- /.col -->
        </div>
            </div>
        </div>

        <!-- Modal Billing Config.begin -->
        <div class="modal fade" id="billing_config_modal-<?= $session_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">
                            Config
                        </h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="save_billing_config-<?= $session_id ?>">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Billing Config.end -->

        <script>
        $(document).ready(function(){

            $('.select2').select2({
                // allowClear: true
            });


            $('#billing_config-<?= $session_id ?>').on('click', function () {
                $('#billing_config_modal-<?= $session_id ?>').modal('show');
                $('#billing_config_modal-<?= $session_id ?> .modal-body').html(loadingBar);
                window['billing_config_modal-<?= $session_id ?>'] = $.ajax({
                    url: "<?= site_url('mt_others/modal_billing_config') ?>/<?= $session_id ?>",
                        success: function (data) {
                            $('#billing_config_modal-<?= $session_id ?> .modal-body').html(data);
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                            alert(msgError);
                            $('#billing_config_modal-<?= $session_id ?> .modal-body').html(msgError);
                        }
                    });
                });

            $('#billing_refresh-<?= $session_id ?>').on('click', function(){
                var formData = {};
                $('#billing_refresh-<?= $session_id ?> i').addClass('fa-spin');
                window['billing_refresh-<?= $session_id ?>'] = $.ajax({
                url: "<?= site_url('mt_others/refresh_form_billing') ?>/<?= $session_id ?>",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('#billing_refresh-<?= $session_id ?> i').removeClass('fa-spin');
                        
                        var obj = JSON.parse(data);
                        if (obj.error_msg != "") {
                            // alert(obj.data.error_msg);
                            var alertError = '<div class="alert alert-danger alert-dismissible">' +
                                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                            '<h4><i class="icon fa fa-ban"></i> '+ obj.error_msg +'</h4>' +
                                        '</div>';
                            $('#billing_notifikasi-<?= $session_id ?>').html(alertError);
                            return false;
                        }

                        //billing user.begin
                        var billing_user = obj.data.billing_user;
                        billing_user.sort(function (a, b) {
                            var x = a.name;
                            var y = b.name;
                            if (x < y) {
                                return -1;
                            }
                            if (x > y) {
                                return 1;
                            }
                            return 0;
                        });
                        $('#billing_user-<?= $session_id ?> option').remove();
                            $('#billing_user-<?= $session_id ?>')
                                    .append($("<option></option>")
                                            .attr("value", '*')
                                            .text('-- select user ('+billing_user.length+') --'));
                            
                            $.each(billing_user, function (key, value) {
                                var limitUptime = value['limit-uptime']== null?'~':value['limit-uptime'];
                                $('#billing_user-<?= $session_id ?>')
                                        .append($("<option></option>")
                                                .attr("value", value['.id'])
                                                .attr("data-pass", value['password'])
                                                .attr("data-limituptime", value['limit-uptime'])
                                                .text(value.name + ' (' + limitUptime +')'));
                        });
                        
                        $('#billing_user2-<?= $session_id ?> option').remove();
                            $('#billing_user2-<?= $session_id ?>')
                                    .append($("<option></option>")
                                            .attr("value", '*')
                                            .text('-- select sender ('+billing_user.length+') --'));
                                    $.each(billing_user, function (key, value) {
                                        var limitUptime = value['limit-uptime']== null?'~':value['limit-uptime'];
                                        $('#billing_user2-<?= $session_id ?>')
                                        .append($("<option></option>")
                                                .attr("value", value['.id'])
                                                .attr("data-pass", value['password'])
                                                .text(value.name + ' (' + limitUptime +')'));
                            });
                        //billing user.end

                        //billing type.begin
                        // console.log(JSON.parse(obj.data.billing_type[0]['source']));
                        $('#billing_type-<?= $session_id ?> option').remove();
                            $('#billing_type-<?= $session_id ?>')
                                    .append($("<option></option>")
                                            .attr("value", '*')
                                            .text('-- select type --'));
                                            
                        if(obj.data.billing_type[0]['source'] != "") {
                            var billing_type = JSON.parse(obj.data.billing_type[0]['source']);


                            if(billing_type.length > 0) {
                                $.each(billing_type, function (key, value) {
                                    $('#billing_type-<?= $session_id ?>')
                                            .append($("<option></option>")
                                                    .attr("value", value['value'])
                                                    .attr("data-price", value['price'])
                                                    .text(value['name'] + ' ('+value['price']+'/h)'));
                                });
                            }
                        }
                        $('#billing_type-<?= $session_id ?>')
                                .append($("<option></option>")
                                        .attr("value", 'tr')
                                        .attr("data-price", '0')
                                        .text('TRANSFER MINUTE(s)'));
                        //billing type.end



                    },
                    error: function (xhr) {
                        $('#billing_refresh-<?= $session_id ?> i').removeClass('fa-spin');
                        console.log(xhr);
                        var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                        alert(msgError);
                    }
                });
            });
            
            $('#billing_process-<?= $session_id ?>').on('click', function(){
                if($('#billing_user-<?= $session_id ?>').val() == "" || $('#billing_user-<?= $session_id ?>').val() == "*") {
                    alert('please select User');
                    return false;
                }

                if($('#billing_type-<?= $session_id ?>').val() == "" || $('#billing_type-<?= $session_id ?>').val() == "*") {
                    alert('please select Type');
                    return false;
                }

                if($('#billing_total-<?= $session_id ?>').val() == "") {
                    alert('please fill "How Much?"');
                    return false;
                }
                
                if($('#billing_type-<?= $session_id ?>').val() == "tr") {
                    if($('#billing_user2-<?= $session_id ?>').val() == "" || $('#billing_user2-<?= $session_id ?>').val() == "*") {
                        alert('please select Sender');
                        return false;
                    }
                }

                $('#billing_notifikasi-<?= $session_id ?>').html(loadingBar);
                var formData = {
                    "billing_user" : $('#billing_user-<?= $session_id ?>').val(),
                    "billing_user2" : $('#billing_user2-<?= $session_id ?>').val(),
                    "billing_type" : $('#billing_type-<?= $session_id ?>').val(),
                    "billing_tom" : $('#billing_tom-<?= $session_id ?>').val(),
                    "billing_price" : $('option:selected', $('#billing_type-<?= $session_id ?>')).data('price'),
                    "billing_total" : $('#billing_total-<?= $session_id ?>').val()
                };
                window['billing_refresh-<?= $session_id ?>'] = $.ajax({
                url: "<?= site_url('mt_others/save_form_billing') ?>/<?= $session_id ?>",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('#billing_notifikasi-<?= $session_id ?>').html(data);

                        // /reset form
                        $('#billing_user-<?= $session_id ?>').val('*');
                        $('#billing_user2-<?= $session_id ?>').val('*');
                        $('#billing_type-<?= $session_id ?>').val('*');
                        $('#billing_tom-<?= $session_id ?>').val('*');
                        $('#billing_total-<?= $session_id ?>').val('');
                    },
                    error: function (xhr) {
                        console.log(xhr);
                        var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                        alert(msgError);
                        var alertError = '<div class="alert alert-danger alert-dismissible">' +
                                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                            '<h4><i class="icon fa fa-ban"></i> '+ msgError +'</h4>' +
                                        '</div>';
                        $('#billing_notifikasi-<?= $session_id ?>').html(alertError);
                    }
                });
            });

            $('#save_billing_config-<?= $session_id ?>').on('click', function () {
                // validasi form.begin
                // validasi form.end

                var formData = {
                    "billing_config_list_type_exist": $('#billing_config_list_type_exist-<?=$session_id?>').val(),
                    "billing_config_list_type_id": $('#billing_config_list_type_id-<?=$session_id?>').val(),
                    "billing_config_list_type": $('#billing_config_list_type-<?=$session_id?>').val()
                }
                $('#billing_config_modal-<?= $session_id ?> .modal-body .notifikasi').html(loadingBar);
                window['billing_config_modal-<?= $session_id ?>'] = $.ajax({
                url: "<?= site_url('mt_others/save_billing_config') ?>/<?= $session_id ?>",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        $('#billing_config_modal-<?= $session_id ?> .modal-body .notifikasi').html(data);
                    },
                    error: function (xhr) {
                        console.log(xhr);
                        var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                        alert(msgError);
                    }
                });
            });
        });

        function hitungrumus() {
            var str = $('#billing_total-<?= $session_id ?>').val();
            var res = str.substring(0, 1);
            var rumus = str.substring(1);
            if (res == "=") {
                if (rumus == 'pwd') {
                    var pwd = $('option:selected', $('#billing_user-<?= $session_id ?>')).data('pass');
                    console.log($('option:selected', $('#billing_user-<?= $session_id ?>')).data('pass'));
                    $("#rumus_result").html('<div style="color:#f77;text-align:right">password=</span><span style="color:orange;font-weight:bold;">' + pwd + '</div>');
                    return false;
                }
                var hasil = rumus;
                if (isNaN(rumus)) {
                    hasil = eval(rumus);
                }
                if (rumus != '') {
                    $("#rumus_result").html('<div style="color:#f77;text-align:right">' + rumus + '=</span><span style="color:orange;font-weight:bold;">' + hasil + '</div>');
                }
            } else {
                $("#rumus_result").html('');
                // if (str != '') {
                //     if ($('#billing_tom-<?= $session_id ?>').val() == "time") {
                //         $("#detail_type").html(str + ' time (' + $('#txt_selectgadget').val() + ')');
                //     } else {
                //         $("#detail_type").html(toRp(str) + ' (' + $('#txt_selectgadget').val() + ')');
                //     }
                // } else {
                //     $("#detail_type").html('');
                // }
            }
        }
        </script>
        <?php
    }

    public function form_billing_n_report($session_id, $cmd = "") {
        ?>
        <div class="row">
            <div class="col-md-4">
                <?php echo $this->form_billing($session_id, $cmd); ?>
            </div>
            <div class="col-md-8" id="form_billing_n_report_report">
                <?php echo $this->report_model->get_selling($session_id, $cmd); ?>
            </div>
        </div>
        <?php
    }

    public function modal_billing_config($session_id, $msid = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            $array_script = $API->comm('/system/script/print', array(
                "?name" => "mikrostator_list_type"
            ));

            // print_r(count($array_script));
            
        
            $list_script = !isset($array_script['!trap']) ? count($array_script) > 0 ? $array_script[0] : array() : array();
        ?>
            <div class="notifikasi"></div>
            <form>
                <div class="form-group">
                    <label>List Type:</label>
                    <input type="hidden" id="billing_config_list_type_exist-<?=$session_id?>" value="<?=count($array_script)?>"/>
                    <input type="hidden" id="billing_config_list_type_id-<?=$session_id?>" value="<?= isset($list_script['.id']) ? $list_script['.id'] : '' ?>"/>
                    <textarea id="billing_config_list_type-<?=$session_id?>" class="form-control" rows="15"><?= isset($list_script['source']) ? json_encode(json_decode($list_script['source']), JSON_PRETTY_PRINT) : '' ?></textarea>
                    <textarea id="billing_config_list_type_default-<?=$session_id?>" class="form-control" rows="4" style="display: none;">[{ "name":"LAPTOP", "value":"pc", "price":"2500" }, { "name": "HP", "value": "hp", "price":"2000" }, { "name": "GADGET MAHAL", "value": "gm", "price":"20000" }]</textarea>
                    <small class="help-block" id="help-session-list"><i class="fa fa-info-circle"></i> don't use enter. what is this? <a href="javascript:void(0)" onclick="$('#billing_config_list_type-<?=$session_id?>').val(JSON.stringify(JSON.parse($('#billing_config_list_type_default-<?=$session_id?>').val()), null, '\t'))">load example</a></small>
                </div>
            </form>
        <?php
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Mikrotik not connected!</h4>                    
            </div>
            <?php
        }
    }

    public function refresh_form_billing($session_id, $cmd = "") {        
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {

            //get type list.begin
            $array = $API->comm('/system/script/print', array(
                "?name" => "mikrostator_list_type"
            ));
            // $array = $API->comm('/system/script/print');
            if (isset($array['!trap'])) {
                // trap
                $msg_list = "";
                foreach ($array['!trap'][0] as $key => $val):
                    $msg_list .= $key . ': ' . $val . '\n';
                endforeach;
                $msg = '<span style="cursor:pointer" onclick="alert(\'' . $msg_list . '\')">Error, click for detail!</span>';
                $output['error_msg'] = $msg;
                echo json_encode($output, JSON_PRETTY_PRINT);
                return false;
            }
            if (count($array) == 0) {
                // no data
                $output['error_msg'] = 'No Data!';
                echo json_encode($output, JSON_PRETTY_PRINT);
                return false;
            }
            ?>
            <?php
            $output['data']['billing_type'] = $array;
            $output['error_msg']['billing_type'] = "";
            //get type list.end

            //get user list.begin
            $array = $API->comm('/ip/hotspot/user/print');
            if (isset($array['!trap'])) {
                // trap
                $msg_list = "";
                foreach ($array['!trap'][0] as $key => $val):
                    $msg_list .= $key . ': ' . $val . '\n';
                endforeach;
                $msg = '<span style="cursor:pointer" onclick="alert(\'' . $msg_list . '\')">Error, click for detail!</span>';
                $output['error_msg'] = $msg;
                echo json_encode($output, JSON_PRETTY_PRINT);
                return false;
            }
            if (count($array) == 0) {
                // no data
                $output['error_msg'] = 'No Data!';
                echo json_encode($output, JSON_PRETTY_PRINT);
                return false;
            }
            ?>
            <?php
            $output['data']['billing_user'] = $array;
            $output['error_msg']['billing_user'] = "";
            //get user list.end
            ?>


            <?php
            $output['error_msg'] = "";
            echo json_encode($output, JSON_PRETTY_PRINT);
        } else {
            // mikrotik not connected!
            $output['error_msg'] = 'Mikrotik not connected!';
            echo json_encode($output, JSON_PRETTY_PRINT);
            return false;
        }
    }

    public function save_form_billing($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);

        $billing_user = $this->input->post('billing_user');
        $billing_user2 = $this->input->post('billing_user2');
        $billing_type = $this->input->post('billing_type');
        $billing_tom = $this->input->post('billing_tom');
        $billing_price = $this->input->post('billing_price');
        $billing_total = $this->input->post('billing_total');


        //bypass billing_tom.begin
        //karena dibuat lebih simpel dengan menghilangkan isian time or money
        $billing_tom = "money";
        //bypass billing_tom.end

        //rumus hitung.begin

        if ($billing_price > 0) { 
            //..konversi.begin
            $tambah2 = ceil($billing_total / $billing_price * 60);
            $tambah = $tambah2; //..jika tipenya bayar uang
            //..konversi.end
        } else {
            $tambah = $billing_total; //..jika tipenya menit
        }

        $tambah = $tambah * 60; //pengurang dalam menit dikonversi ke detik
        $tambahin = $this->stator_model->time_elapsed_A($tambah);
        $akhir = "";

        //rumus hitung.end


        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {


            //ambil data awal dulu.begin
            $IPUser = $API->comm("/ip/hotspot/user/print", array(
                "?.id" => $billing_user,
            ));
            $i = 0;
            $name = $IPUser[$i]['name'];
            $limit_uptime = isset($IPUser[$i]['limit-uptime']) ? $IPUser[$i]['limit-uptime'] : 0; //batas
            $uptime = $IPUser[$i]['uptime']; //dipakai
            $awal = $limit_uptime;
            //ambil data awal dulu.end

            if ($billing_type == 'tr') {

                //bypass billing_tom.begin
                //karena dibuat lebih simpel dengan menghilangkan isian time or money
                $billing_tom = "minute(s)";
                //bypass billing_tom.end

                //jika transfer.begin
                //ambil user mikrotik sumber pengguna .begin
                $IPUser2 = $API->comm("/ip/hotspot/user/print", array(
                    "?.id" => $billing_user2,
                ));
                $i = 0;
                $name2 = $IPUser2[$i]['name'];
                $limit_uptime2 = isset($IPUser2[$i]['limit-uptime']) ? $IPUser2[$i]['limit-uptime'] : 0; //batas
                $uptime2 = $IPUser2[$i]['uptime']; //dipakai
                $sumber_sisa2 = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($limit_uptime2, 's') - $this->stator_model->get_menit($uptime2, 's')); //penambah
                $sumber_sisa_menit = $this->stator_model->get_menit($sumber_sisa2, 'm');
                $sumber2 = $this->stator_model->get_menit($sumber_sisa2, 's') - $tambah;
                

                if ($sumber2 < 0 || $this->stator_model->get_menit($limit_uptime2, 's') <= 0 || $limit_uptime2 == '') {
                    $msg = "GAGAL! Jam $name2 tidak mencukupi untuk ditransfer " . $billing_total . " menit (" . $this->stator_model->time_elapsed_A($tambah) . "). Sisa waktu " . $name2 . " : " . $sumber_sisa_menit . " menit (" . $sumber_sisa2 . ").";
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> <?=$msg?></h4>                    
                    </div>
                    <?php
                    return false;
                } else {
                    //..bisa ditransfer
                    $sumber_batas = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($limit_uptime2, 's') - $tambah);
                    $sisa2 = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($sumber_batas, 's') - $this->stator_model->get_menit($uptime2, 's'));

                    // kurangi jam user2
                    $API->write("/ip/hotspot/user/set", false);
                    $API->write("=.id=" . $billing_user2, false);
                    $API->write("=limit-uptime=" . $sumber_batas);
                    $array = $API->read();

                    if (isset($array['!trap'])) {
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php
                            echo '<ul>';
                            foreach ($array['!trap'][0] as $key => $val):
                                echo '<li>' . $key . ': <b>' . $val . '</b></li>';
                            endforeach;
                            echo '</ul>';
                            ?>
                        </div>
                        <?php
                        return false;
                    }
                    
                    $msg2 = " dan $name2 BERHASIL DIKURANGI dari $limit_uptime2 jadi $sumber_batas (sisa: $sisa2)";

                    //..perhitungan waktu.begin
                    $kahir = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($awal, 's') + $tambah);
                    $akhir = $kahir;
                    //..perhitungan waktu.end

                    // tambahkan limit-uptime user1
                    $API->write("/ip/hotspot/user/set", false);
                    $API->write("=.id=" . $billing_user, false);
                    $API->write("=limit-uptime=" . $akhir);
                    $array = $API->read();

                    if (isset($array['!trap'])) {
                        ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php
                            echo '<ul>';
                            foreach ($array['!trap'][0] as $key => $val):
                                echo '<li>' . $key . ': <b>' . $val . '</b></li>';
                            endforeach;
                            echo '</ul>';
                            ?>
                        </div>
                        <?php
                        return false;
                    }  
                    $awal = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($awal, 's'));
                    $akhir = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($akhir, 's'));
                    $sisa = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($akhir, 's') - $this->stator_model->get_menit($uptime, 's'));
                    $msg = $name . " BERHASIL DITAMBAHKAN " . $billing_total . " " . $billing_tom . " (" . $billing_type . ": " . $tambahin . ") dari $awal jadi $akhir (sisa: $sisa)" . $msg2;
                    ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Done!</h4>
                        <?=$msg?>
                    </div>
                <?php
                //jika transfer.end
                }
            } else {
                //jika bukan transfer
                //..perhitungan waktu.begin
                $kahir = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($awal, 's') + $tambah);
                $akhir = $kahir;
                //..perhitungan waktu.end

                // tambahkan limit-uptime user1
                $API->write("/ip/hotspot/user/set", false);
                $API->write("=.id=" . $billing_user, false);
                $API->write("=limit-uptime=" . $akhir);
                $array = $API->read();

                if (isset($array['!trap'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <?php
                        echo '<ul>';
                        foreach ($array['!trap'][0] as $key => $val):
                            echo '<li>' . $key . ': <b>' . $val . '</b></li>';
                        endforeach;
                        echo '</ul>';
                        ?>
                    </div>
                    <?php
                    return false;
                }  
                $awal = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($awal, 's'));
                $akhir = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($akhir, 's'));
                $sisa = $this->stator_model->time_elapsed_A($this->stator_model->get_menit($akhir, 's') - $this->stator_model->get_menit($uptime, 's'));
                $msg2 = "";
                $msg = $name . " BERHASIL DITAMBAHKAN " . $billing_total . " " . $billing_tom . " (" . $billing_type . "[".$billing_price."]: " . $tambahin . ") dari $awal jadi $akhir (sisa: $sisa)" . $msg2;

                //tulis ke report mikrotik.begin
                // tambahkan limit-uptime user1
                $date = strtolower(date('M/d/Y'));
                $time = date('H:i:s');
                $periode = strtolower(date('Y-M'));
                $API->write("/system/script/add", false);
                $API->write("=name=" . $name."-".date('YmdHis'), false);
                $API->write("=source=:put #".$date."#".$time."#".$name."##".$billing_total."####".$msg."#billing#;", false);
                $API->write("=owner=" . $periode, false);
                $API->write("=comment=report_mikrostator");
                $array = $API->read();
                //tulis ke report mikrotik.end
                ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Done!</h4>
                    <?=$msg?>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Mikrotik not connected!</h4>                    
            </div>
            <?php
        }
        
    }

    public function save_billing_config($session_id) {
        $koneksi = $this->rich_model->get_session_by_id($session_id);

        $billing_config_list_type_exist = $this->input->post('billing_config_list_type_exist');
        $billing_config_list_type_id = $this->input->post('billing_config_list_type_id');
        $billing_config_list_type = $this->input->post('billing_config_list_type');

        // print_r(str_replace("\r\n",'', $billing_config_list_type));exit();
        $trap = 0;
        $done = 0;
        $msg_trap = "";

        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            if($billing_config_list_type_exist == 0){
                $API->write("/system/script/add", false);
            } else {
                $API->write("/system/script/set", false);
                $API->write("=.id=" . $billing_config_list_type_id, false);
            }
            // required
            $API->write("=name=mikrostator_list_type", false);
            $API->write("=source=" . str_replace("\r",'', str_replace("\n",'', $billing_config_list_type)));

            $array = $API->read();
            if (isset($array['!trap'])) {
                $trap++;
                foreach ($array['!trap'][0] as $key => $val):
                    $msg_trap .= '<li>' . $key . ': <b>' . $val . '</b></li>';
                endforeach;
            } else {
                $done++;
            }
        ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info-circle"></i> <?= $done ?> Success and <?= $trap ?> Error</h4>                    
                <?php if ($msg_trap != "") { ?>
                    <ul>
                        <?= $msg_trap; ?>
                    </ul>
                <?php } ?>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Mikrotik not connected!</h4>                    
            </div>
            <?php
        }
    }
    
}
