<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mt_voucher extends MY_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('stator_model');
        $this->load->model('rich_model');
    }

    public function voucher_list($session_id, $cmd = "") {
        ?>
        <p>
            <label>Voucher List:</label>
            <select id="voucher-list-option-<?= $session_id ?>" class="form-control"></select>
        </p>
        <p class="text-right">
            <span class="btn-group pull-left">
                <button type="button" name="add" id="add-voucher-<?= $session_id ?>" class="btn btn-success btn-xs" title="Add"><i class="fa fa-plus-square"></i> Add New</button>
                <button type="button" name="delete" id="delete-voucher-list-<?= $session_id ?>" class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-close"></i> Delete</button>
                <!-- <button type="button" name="delete_vouchers" id="delete-voucher-<?= $session_id ?>" class="btn btn-warning btn-xs" title="Delete Voucher"><i class="fa fa-close"></i> Delete Voucher</button> -->
                <button type="button" name="template" id="template-voucher-list-<?= $session_id ?>" class="btn btn-info btn-xs" title="Print"><i class="fa fa-print"></i> Print</button>
            </span>
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>

        <div class="table-responsive">
            <table id="mt_voucher-voucher-list-<?= $session_id ?>" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">name</th>
                        <th class="text-nowrap">password</th>
                        <th class="text-nowrap">server</th>
                        <th class="text-nowrap">profile</th>
                        <th class="text-nowrap">address</th>
                        <th class="text-nowrap">mac-address</th>
                        <th class="text-nowrap">limit-uptime</th>
                        <th class="text-nowrap" title="limit-uptime in minute">LU (m)</th>
                        <th class="text-nowrap">uptime</th>
                        <th class="text-nowrap" title="uptime in minute">U (m)</th>
                        <th class="text-nowrap">session-time-left</th>
                        <th class="text-nowrap" title="session-time-left in minute">STL (m)</th>
                        <th class="text-nowrap">bytes-in</th>
                        <th class="text-nowrap">bytes-in (n)</th>
                        <th class="text-nowrap">bytes-out</th>
                        <th class="text-nowrap">bytes-out (n)</th>
                        <th class="text-nowrap">limit-bytes-in</th>
                        <th class="text-nowrap">limit-bytes-in (n)</th>
                        <th class="text-nowrap">limit-bytes-out</th>
                        <th class="text-nowrap">limit-bytes-out (n)</th>
                        <th class="text-nowrap">limit-bytes-total</th>
                        <th class="text-nowrap">limit-bytes-total (n)</th>
                        <th class="text-nowrap">packets-in</th>
                        <th class="text-nowrap">packets-out</th>
                        <th class="text-nowrap">dynamic</th>
                        <th class="text-nowrap">disabled</th>
                        <th class="text-nowrap">email</th>
                        <th class="text-nowrap">comment</th>
                        <th class="text-nowrap">vname</th>
                        <th class="text-nowrap">vprice</th>
                        <th class="text-nowrap">vcomment</th>
                        <th class="text-nowrap">action</th>
                        <th class="text-nowrap"><i class="fa fa-check"></i></th>
                        <th class="text-nowrap">name</th>
                        <th class="text-nowrap">vprofile</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_voucher-voucher-list-<?= $session_id ?>').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_voucher/json_voucher_list/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            // console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }

                            var myVName = [];
                            var sisaVoucher = [];
                            var voucherDetail = [];
                            $('#voucher-list-option-<?= $session_id ?> option').remove();
                            $('#voucher-list-option-<?= $session_id ?>').append('<option value="*">all</option>');

                            json.data.forEach(function (entry) {
                                var used = 0;
                                var unuse = 0;
                                entry[11] > 0 ? used++ : unuse++;
                                myVName.push(JSON.parse(entry['29']).vname);
                                // sisaVoucher.push('{"vname": "' + JSON.parse(entry['29']).vname + '", "used":"0", "unuse":"1"}');
                                // sisaVoucher.push('{"vname": "' + JSON.parse(entry['29']).vname + '", "used":"0", "unuse":"1"}');
                                // sisaVoucherJSON.parse(entry['29']).vname] = JSON.parse(entry['29']).vname;
                                // sisaVoucher.used = used;
                                // sisaVoucher.unuse = unuse;
                                // voucherDetail.push(sisaVoucher);
                            });
                            // console.log(sisaVoucher);
                            // console.log(voucherDetail);
                            myVName.filter(onlyUnique).sort().forEach(function (list) {
                                $('#voucher-list-option-<?= $session_id ?>').append('<option value="' + list + '">' + list + '</option>');
                            });
                            return json.data;
                        }
                    },
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    order: [[2, "asc"]],
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'pageLength',
                            className: 'btn-xs'
                        },
                        {
                            extend: 'colvis',
                            collectionLayout: 'fixed two-column',
                            postfixButtons: ['colvisRestore'],
                            className: 'btn-xs'
                        },
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: ':visible', footer: true
                            },
                            className: 'btn-xs'
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: ':visible', footer: true
                            },
                            className: 'btn-xs'
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: ':visible', footer: true
                            },
                            className: 'btn-xs'
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: ':visible', footer: true
                            },
                            orientation: 'landscape',
                            className: 'btn-xs'
                        }
                    ],
                    columnDefs: [
                        {
                            visible: false
                        }
                    ],
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
                    ],
                    createdRow: function (row, data, index) {
                        $('td', row).addClass('text-nowrap');
                        $('td:eq(3)', row).addClass('text-center');
                        $('td:eq(8)', row).addClass('text-right');
                        $('td:eq(9)', row).addClass('text-right');
                        $('td:eq(10)', row).addClass('text-right');
                        $('td:eq(11)', row).addClass('text-right');
                        $('td:eq(12)', row).addClass('text-right');
                        $('td:eq(13)', row).addClass('text-right');
                        $('td:eq(14)', row).addClass('text-right');
                        $('td:eq(15)', row).addClass('text-right');
                        $('td:eq(16)', row).addClass('text-right');
                        $('td:eq(17)', row).addClass('text-right');
                        $('td:eq(18)', row).addClass('text-right');
                        $('td:eq(19)', row).addClass('text-right');
                        $('td:eq(20)', row).addClass('text-right');
                        $('td:eq(21)', row).addClass('text-right');
                        $('td:eq(22)', row).addClass('text-right');
                        $('td:eq(23)', row).addClass('text-right');
                        $('td:eq(24)', row).addClass('text-right');
                        $('td:eq(25)', row).addClass('text-right');
                        $('td:eq(26)', row).addClass('text-center');
                        $('td:eq(27)', row).addClass('text-center');
                        $('td:eq(31)', row).addClass('text-right');
                        $('td:eq(33)', row).addClass('text-center');
                    }
                });
                $('#voucher-list-option-<?= $session_id ?>').on('change', function () {
                    if (this.value == '*') {
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].columns(29).search('').draw();
                    } else {
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].columns(29).search(this.value).draw();
                    }
                    var countData = window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].page.info().recordsDisplay;
                    $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(countData + ' Data(s)');
                });
                
                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                    });
                });

                $(document).ready(function () {
                                    $('#delete-voucher-list-<?= $session_id ?>').on('click', function () {
                                        if (!confirm('Are you sure?')) {
                                            return false;
                                        }
                                        var msids = [];
                                        $("input:checked", window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].rows({search: 'applied'}).nodes()).each(function () {
                                            msids.push($(this).data('id'));
                                        });
                                        
                                        //                            console.log(JSON.stringify(myId));
                                        $('#voucher-list-modal-<?= $session_id ?>').modal('show');
                                        $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                                        window['voucher-list-modal-<?= $session_id ?>'] = $.ajax({
                                            url: "<?= site_url('mt_voucher/delete_voucher_list') ?>/<?= $session_id ?>",
                                                            type: 'POST',
                                                            data: {"msids": JSON.stringify(msids)},
                                                            success: function (data) {
                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(data);
                                                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                                            },
                                                            error: function (xhr) {
                                                                console.log(xhr);
                                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                                alert(msgError);
                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(msgError);
                                                            }
                                                        });
                                                    });

                                    $('#delete-voucher-<?= $session_id ?>').on('click', function () {

                                        var vname = $('#voucher-list-option-<?= $session_id ?>').val();
                                        if(vname == '*') {
                                            alert('Please select voucher first');
                                            return false;
                                        }
                                        if (!confirm('Are you sure?')) {
                                            return false;
                                        }

                                        var msids = [];
                                        $("input:checked", window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].rows({search: 'applied'}).nodes()).each(function () {
                                            msids.push($(this).data('id'));
                                        });
                                        
                                        //                            console.log(JSON.stringify(myId));
                                        $('#voucher-list-modal-<?= $session_id ?>').modal('show');
                                        $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                                        window['voucher-list-modal-<?= $session_id ?>'] = $.ajax({
                                            url: "<?= site_url('mt_voucher/delete_voucher') ?>/<?= $session_id ?>",
                                                            type: 'POST',
                                                            data: {"vname": vname, "msids": msids},
                                                            success: function (data) {
                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(data);
                                                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                                            },
                                                            error: function (xhr) {
                                                                console.log(xhr);
                                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                                alert(msgError);
                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(msgError);
                                                            }
                                                        });
                                                    });

                                                    $('#template-voucher-list-<?= $session_id ?>').on('click', function () {
                                                    
                                                        msusers = [];
                                                        mspwds = [];
                                                        msvname = [];
                                                        msvprice = [];
                                                        msvvalidity = [];
                                                        msvlimituptime = [];

                                                        msvoucher = [];

                                                        $("td:eq(2)", window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].rows({search: 'applied'}).nodes()).each(function () {
                                                            msusers.push(this.innerHTML);
                                                        });
                                                        $("td:eq(3) a", window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].rows({search: 'applied'}).nodes()).each(function () {
                                                            mspwds.push($(this).data('id'));
                                                        });
                                                        $("td:eq(8)", window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].rows({search: 'applied'}).nodes()).each(function () {
                                                            msvlimituptime.push(this.innerHTML);
                                                        });
                                                        $("td:eq(29)", window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].rows({search: 'applied'}).nodes()).each(function () {
                                                            msvname.push(JSON.parse(this.innerHTML).vname);
                                                        });
                                                        $("td:eq(36)", window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].rows({search: 'applied'}).nodes()).each(function () {
                                                            msvprice.push(JSON.parse(this.innerHTML).vprice);
                                                            msvvalidity.push(JSON.parse(this.innerHTML).vvalidity);
                                                        });
                                                        for (var i = 0; i < msusers.length; i++) {
                                                            msvoucher.push({
                                                                "msusers": msusers[i],
                                                                "mspwds": mspwds[i],
                                                                "msvname": msvname[i],
                                                                "msvlimituptime": msvlimituptime[i],
                                                                "msvvalidity": msvvalidity[i],
                                                                "msvprice": msvprice[i]
                                                            });
                                                        }
                                                        // console.log(msvoucher);
                                                        $('#voucher-list-modal-<?= $session_id ?>').modal('show');
                                                        $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(loadingBar);



                                                        window['voucher-list-modal-<?= $session_id ?>'] = $.ajax({
                                                            url: "<?= site_url('mt_voucher/template_voucher_list') ?>/<?= $session_id ?>",
                                                                            success: function (data) {
                                                                                // console.log(data);
                                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(data);
                                                                            },
                                                                            error: function (xhr) {
                                                                                console.log(xhr);
                                                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                                                alert(msgError);
                                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(msgError);
                                                                            }
                                                                        });
                                                                    });



                                                                    $('#add-voucher-<?= $session_id ?>').on('click', function () {
                                                                        $('#voucher-list-modal-<?= $session_id ?>').modal('show');
                                                                        $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                                                                        window['voucher-list-modal-<?= $session_id ?>'] = $.ajax({
                                                                            url: "<?= site_url('mt_voucher/modal_voucher_list') ?>/<?= $session_id ?>",
                                                                                            success: function (data) {
                                                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(data);
                                                                                                // window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                                                                            },
                                                                                            error: function (xhr) {
                                                                                                console.log(xhr);
                                                                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                                                                alert(msgError);
                                                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(msgError);
                                                                                            }
                                                                                        });
                                                                                    });

                                                                                    $('#voucher-list-modal-<?= $session_id ?>').on('hide.bs.modal', function (e) {
                                                                                        window['voucher-list-modal-<?= $session_id ?>'].abort();
                                                                                    });

                                                                                    window['delete-hotspot-user-<?= $session_id ?>'] = function (msid) {
                                                                                        $('#voucher-list-modal-<?= $session_id ?>').modal('show');
                                                                                        $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                                                                                        var msids = [];
                                                                                        msids.push(msid);
                                                                                        window['voucher-list-modal-<?= $session_id ?>'] = $.ajax({
                                                                                            url: "<?= site_url('mt_voucher/delete_voucher_list') ?>/<?= $session_id ?>",
                                                                                                            type: 'POST',
                                                                                                            data: {"msids": msids},
                                                                                                            success: function (data) {
                                                                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(data);
                                                                                                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                                                                                            },
                                                                                                            error: function (xhr) {
                                                                                                                console.log(xhr);
                                                                                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                                                                                alert(msgError);
                                                                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(msgError);
                                                                                                            }
                                                                                                        });
                                                                                                    }

                                                                                                    $('#save-voucher-<?= $session_id ?>').on('click', function () {
                                                                                                        // validasi form.begin
                                                                                                        if ($('#voucher-server').val() == '' || $('#voucher-server').val() == '*') {
                                                                                                            alert('Please fill server!');
                                                                                                            return false;
                                                                                                        }
                                                                                                        if ($('#voucher-profile').val() == '' || $('#voucher-profile').val() == '*') {
                                                                                                            alert('Please fill profile!');
                                                                                                            return false;
                                                                                                        }
                                                                                                        if ($('#voucher-name').val() == '') {
                                                                                                            alert('Please fill name!');
                                                                                                            return false;
                                                                                                        }
                                                                                                        if ($('#voucher-qty').val() == '') {
                                                                                                            alert('Please fill qty!');
                                                                                                            return false;
                                                                                                        }
                                                                                                        // validasi form.end

                                                                                                        var formData = {
                                                                                                            "voucher_server": $('#voucher-server').val(),
                                                                                                            "voucher_profile": $('#voucher-profile').val(),
                                                                                                            "voucher_name": $('#voucher-name').val(),
                                                                                                            "voucher_password_type": $('#voucher-password-type').val(),
                                                                                                            "voucher_password": $('#voucher-password').val(),
                                                                                                            "voucher_qty": $('#voucher-qty').val(),
                                                                                                            "voucher_price": $('#voucher-price').val(),
                                                                                                            "voucher_comment": $('#voucher-comment').val(),
                                                                                                            "voucher_disabled": $('#voucher-disabled').val(),
                                                                                                            "voucher_limit_uptime": $('#voucher-limit-uptime').val(),
                                                                                                            "voucher_limit_bytes_in": $('#voucher-limit-bytes-in').val(),
                                                                                                            "voucher_limit_bytes_out": $('#voucher-limit-bytes-out').val(),
                                                                                                            "voucher_limit_bytes_total": $('#voucher-limit-bytes-total').val(),
                                                                                                            "voucher_random_char": $('#voucher-random-char').val(),
                                                                                                            "voucher_char_length": $('#voucher-char-length').val()
                                                                                                        }
                                                                                                        $('#voucher-list-modal-<?= $session_id ?> .modal-body .notifikasi').html(loadingBar);
                                                                                                        window['save-voucher-list-modal-<?= $session_id ?>'] = $.ajax({
                                                                                                            url: "<?= site_url('mt_voucher/save_voucher_list') ?>/<?= $session_id ?>",
                                                                                                                            type: 'POST',
                                                                                                                            data: formData,
                                                                                                                            success: function (data) {
                                                                                                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body .notifikasi').html(data);
                                                                                                                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                                                                                                            },
                                                                                                                            error: function (xhr) {
                                                                                                                                console.log(xhr);
                                                                                                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                                                                                                alert(msgError);
                                                                                                                            }
                                                                                                                        });
                                                                                                                    });
                                                                                                                });
            </script>
        </div>

        <!-- Modal Add Hotspot User.begin -->
        <div class="modal fade" id="voucher-list-modal-<?= $session_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">
                            Voucher
                        </h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="save-voucher-<?= $session_id ?>">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Add IP Hotspot User.end -->
        <?php
    }

    public function json_voucher_list($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/ip/hotspot/user/print', array(
                '?email' => 'voucher@mikro.stator'
            ));

            $array_profile = $API->comm('/ip/hotspot/user/profile/print');
            if (isset($array_profile['!trap'])) {
                return false;
            }
            if (count($array_profile) == 0) {
                return false;
            }
            foreach ($array_profile as $value_profile):
                $row_profile[$value_profile['name']]['vvalidity'] = isset($value_profile['on-login']) ? $this->rich_model->parse_validity($value_profile['on-login'], 'validity') : '';
                $row_profile[$value_profile['name']]['vprice'] = isset($value_profile['on-login']) ? $this->rich_model->parse_validity($value_profile['on-login'], 'price') : '';
            endforeach;


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
            $no = 1;
            // print_r($array);
            foreach ($array as $value):
                $profile_name = $value['profile'];
                $row_profile_json = json_encode($row_profile[$profile_name]);
                $row = array();
                $row[] = $no;
                $row[] = isset($value['.id']) ? $value['.id'] : '';
                $row[] = isset($value['name']) ? $value['name'] : '';
                $row[] = isset($value['password']) ? '<a href="javascript:void(0)" data-id="' . $value['password'] . '" onclick="prompt(\'password: \',\'' . $value['password'] . '\')">***</a>' : '<a href="javascript:void(0)" data-id="" onclick="prompt(\'password: \',\'\')">***</a>';
                $row[] = isset($value['server']) ? $value['server'] : '';
                $row[] = isset($value['profile']) ? $value['profile'] : '';
                $row[] = isset($value['address']) ? $value['address'] : '';
                $row[] = isset($value['mac-address']) ? $value['mac-address'] : '';
                $row[] = isset($value['limit-uptime']) ? $value['limit-uptime'] : '';
                $row[] = isset($value['limit-uptime']) ? $this->stator_model->get_menit($value['limit-uptime']) : '';
                $row[] = isset($value['uptime']) ? $value['uptime'] : '';
                $row[] = isset($value['uptime']) ? $this->stator_model->get_menit($value['uptime']) : '';
                $row[] = isset($value['limit-uptime']) ? $this->stator_model->time_elapsed_A($this->stator_model->get_menit($value['limit-uptime'], 's') - $this->stator_model->get_menit($value['uptime'], 's')) : '';
                $row[] = isset($value['limit-uptime']) ? $this->stator_model->get_menit($value['limit-uptime']) - $this->stator_model->get_menit($value['uptime']) : '';
                $row[] = isset($value['bytes-in']) ? $value['bytes-in'] : '';
                $row[] = isset($value['bytes-in']) ? $this->rich_model->formatBytes($value['bytes-in']) : '';
                $row[] = isset($value['bytes-out']) ? $value['bytes-out'] : '';
                $row[] = isset($value['bytes-out']) ? $this->rich_model->formatBytes($value['bytes-out']) : '';
                $row[] = isset($value['limit-bytes-in']) ? $value['limit-bytes-in'] : '';
                $row[] = isset($value['limit-bytes-in']) ? $this->rich_model->formatBytes($value['limit-bytes-in']) : '';
                $row[] = isset($value['limit-bytes-out']) ? $value['limit-bytes-out'] : '';
                $row[] = isset($value['limit-bytes-out']) ? $this->rich_model->formatBytes($value['limit-bytes-out']) : '';
                $row[] = isset($value['limit-bytes-total']) ? $value['limit-bytes-total'] : '';
                $row[] = isset($value['limit-bytes-total']) ? $this->rich_model->formatBytes($value['limit-bytes-total']) : '';
                $row[] = isset($value['packets-in']) ? $value['packets-in'] : '';
                $row[] = isset($value['packets-out']) ? $value['packets-out'] : '';
                $row[] = isset($value['dynamic']) ? $this->rich_model->get_logic_label($value['dynamic']) : '';
                $row[] = isset($value['disabled']) ? $this->rich_model->get_logic_label($value['disabled']) : '';
                $row[] = isset($value['email']) ? $value['email'] : '';
                $row[] = isset($value['comment']) ? $value['comment'] : '';
                $row[] = isset($value['comment']) ? json_decode($value['comment'])->vname : '';
                $row[] = isset($value['comment']) ? json_decode($value['comment'])->vname : '';
                $row[] = isset($value['comment']) ? json_decode($value['comment'])->vcomment : '';
                $row[] = '
<button type="button" name="delete"  onclick="if (confirm(\'Are you sure?\')) {
    window[\'delete-hotspot-user-' . $session_id . '\'](\'' . $value['.id'] . '\')
}"  class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-close"></i> Del</button>';
                $row[] = '<input type="checkbox" name="select_user[]" data-id="' . $value['.id'] . '" checked />';
                $row[] = isset($value['name']) ? $value['name'] : '';
                $row[] = isset($row_profile_json) ? $row_profile_json : '';
                $output['data'][] = $row;
                $no++;
            endforeach;
            $output['error_msg'] = --$no . " Data(s)";
            echo json_encode($output, JSON_PRETTY_PRINT);
            ?>
            <?php
        } else {
            // mikrotik not connected!
            $output['error_msg'] = 'Mikrotik not connected!';
            echo json_encode($output, JSON_PRETTY_PRINT);
            return false;
        }
    }

    public function modal_voucher_list($session_id, $msid = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            $array_server = $API->comm('/ip/hotspot/print');
            $array_user_profile = $API->comm('/ip/hotspot/user/profile/print');

            $list_server = !isset($array_server['!trap']) ? $array_server : array();
            $list_user_profile = !isset($array_user_profile['!trap']) ? $array_user_profile : array();

            if ($msid == "edit") {
                $msid = $this->input->post('msid');
                $array_user = $API->comm('/ip/hotspot/user/print', array(
                    "?.id" => $msid,
                ));

//                $this->rich_model->debug_array($array_user, true);
                if (isset($array['!trap'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <?php
                        echo '<ul>';
                        foreach ($array_user['!trap'][0] as $key => $val):
                            echo '<li>' . $key . ': <b>' . $val . '</b></li>';
                        endforeach;
                        echo '</ul>';
                        ?>
                    </div>
                    <?php
                    return false;
                }
                if (count($array_user) == 0) {
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Result not found!
                    </div>
                    <?php
                    return false;
                }
                $list_user = !isset($array_user['!trap']) ? count($array_user) > 0 ? $array_user[0] : array() : array();
//                $this->rich_model->debug_array($array_user, true); // ($array, exit)
            }
//            $this->rich_model->make_td_array($array[0], false, true); // ($array, th, exit)
            ?>
            <div class="notifikasi"></div>
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1_voucher-<?= $session_id ?>" data-toggle="tab">Basic</a></li>
                    <li><a href="#tab_2_voucher-<?= $session_id ?>" data-toggle="tab">Limits</a></li>
                    <li><a href="#tab_3_voucher-<?= $session_id ?>" data-toggle="tab">Options</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1_voucher-<?= $session_id ?>">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Name:</label>
                                <input type="text" class="form-control" id="voucher-name" autocomplete="off" placeholder="" value="<?= isset($list_user['name']) ? $list_user['name'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Qty:</label>
                                <input type="number" class="form-control input-lg" id="voucher-qty" style="color: red; font-weight: bold;" autocomplete="off" placeholder="" value="<?= isset($list_user['qty']) ? $list_user['qty'] : '1' ?>" min="1">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Password Type:</label>
                                <select class="form-control" id="voucher-password-type" onchange="this.value=='mt'?$('#manual_password_voucher<?= $session_id ?>').show():$('#manual_password_voucher<?= $session_id ?>').hide()">
                                    <option value="at">Automatic</option>
                                    <option value="mt">Manual</option>
                                    <option value="su">Same as Username</option>
                                </select>
                            </div>
                            <div class="form-group" id="manual_password_voucher<?= $session_id ?>" style="display:none">
                                <label class="control-label">Password:</label>
                                <input type="text" class="form-control" id="voucher-password" autocomplete="off" placeholder="" value="<?= isset($list_user['password']) ? $list_user['password'] : '' ?>">
                                <small class="help-block">Only for manual password type</small>
                            </div>
                            <hr>

                            <div class="form-group">
                                <label class="control-label">Server:</label>
                                <select class="form-control" id="voucher-server">
                                    <!--<option value="*">-- Select Server --</option>-->
                                    <option value="all">all</option>
                                    <?php foreach ($list_server as $value): ?>
                                        <option value="<?= $value['name'] ?>" <?= isset($list_user['server']) ? $value['name'] == $list_user['server'] ? 'selected' : '' : '' ?>><?= $value['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Profile:</label>
                                <select 
                                    class="form-control" 
                                    id="voucher-profile" 
                                    onchange="
                                        $('#voucher-validity').val($(this).find(':selected').data('validity'));
                                        $('#voucher-price').val($(this).find(':selected').data('price'))
                                        " >
                                    <!--<option value="*">-- Select Profile --</option>-->
                                    <?php foreach ($list_user_profile as $value): ?>
                                        <option 
                                            value="<?= $value['name'] ?>" 
                                            data-validity="<?= isset($value['on-login']) ? $this->rich_model->parse_validity($value['on-login'], 'validity') : '' ?>" 
                                            data-price="<?= isset($value['on-login']) ? $this->rich_model->parse_validity($value['on-login'], 'price') : '' ?>" 
                                            <?= isset($list_user['profile']) ? $value['name'] == $list_user['profile'] ? 'selected' : '' : '' ?>
                                        >
                                            <?= $value['name'] ?>
                                        </option>                        
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Validity:</label>
                                <input type="text" class="form-control" id="voucher-validity" autocomplete="off" placeholder="" value="<?= isset($list_user['validity']) ? $list_user['validity'] : '' ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Price:</label>
                                <input type="number" class="form-control" id="voucher-price" autocomplete="off" placeholder="" value="<?= isset($list_user['price']) ? $list_user['price'] : '' ?>" readonly>
                            </div>
                            <hr>

                            <div class="form-group">
                                <label class="control-label">Disabled:</label>
                                <select class="form-control" id="voucher-disabled">
                                    <option value="no" <?= isset($list_user['disabled']) ? 'false' == $list_user['disabled'] ? 'selected' : '' : '' ?>>No</option>
                                    <option value="yes" <?= isset($list_user['disabled']) ? 'true' == $list_user['disabled'] ? 'selected' : '' : '' ?>>Yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Comment:</label>
                                <textarea id="voucher-comment" class="form-control" rows="4"><?= isset($list_user['comment']) ? $list_user['comment'] : '' ?></textarea>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2_voucher-<?= $session_id ?>">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Limit Uptime:</label>
                                <input type="text" class="form-control" id="voucher-limit-uptime" placeholder="" value="<?= isset($list_user['limit-uptime']) ? $list_user['limit-uptime'] : '' ?>">
                                <small class="help-block">Example: 1w2d3h4m5s (w=week, d=day, h=hour, m=minute, s=second)</small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Limit Bytes In:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="voucher-limit-bytes-in" placeholder="" value="<?= isset($list_user['limit-bytes-in']) ? $list_user['limit-bytes-in'] : '' ?>">
                                    <span class="input-group-addon convert-limit-bytes-in">0</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Limit Bytes Out:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="voucher-limit-bytes-out" placeholder="" value="<?= isset($list_user['limit-bytes-out']) ? $list_user['limit-bytes-out'] : '' ?>">
                                    <span class="input-group-addon convert-limit-bytes-out">0</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Limit Bytes Total:</label>                                
                                <div class="input-group">
                                    <input type="text" class="form-control" id="voucher-limit-bytes-total" placeholder="" value="<?= isset($list_user['limit-bytes-total']) ? $list_user['limit-bytes-total'] : '' ?>">
                                    <span class="input-group-addon convert-limit-bytes-total">0</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3_voucher-<?= $session_id ?>">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Random Character:</label>
                                <input type="text" class="form-control" id="voucher-random-char" placeholder="" value="0123456789abcdefghijklmnopqrstuvwxyz">
                                <small class="help-block">Default: 0123456789abcdefghijklmnopqrstuvwxyz</small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Character Length:</label>
                                <input type="number" class="form-control" id="voucher-char-length" placeholder="" value="6">
                                <small class="help-block">Length of user and password generated</small>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- Custom Tabs -->
            <script>
                $('#voucher-limit-bytes-in').on('change', function () {
                    $('.convert-limit-bytes-in').load("<?= site_url('home/convertBytes') ?>/" + $(this).val());
                });
                $('#voucher-limit-bytes-out').on('change', function () {
                    $('.convert-limit-bytes-out').load("<?= site_url('home/convertBytes') ?>/" + $(this).val());
                });
                $('#voucher-limit-bytes-total').on('change', function () {
                    $('.convert-limit-bytes-total').load("<?= site_url('home/convertBytes') ?>/" + $(this).val());
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

    public function save_voucher_list($session_id) {
        $koneksi = $this->rich_model->get_session_by_id($session_id);

        $voucher_server = $this->input->post('voucher_server');
        $voucher_profile = $this->input->post('voucher_profile');
        $voucher_disabled = $this->input->post('voucher_disabled');
        $voucher_address = '';
        $voucher_mac_address = '';
        $voucher_routes = '';
        $voucher_email = 'voucher@mikro.stator'; // special for voucher
        $voucher_limit_uptime = $this->input->post('voucher_limit_uptime');
        $voucher_limit_bytes_in = $this->input->post('voucher_limit_bytes_in');
        $voucher_limit_bytes_out = $this->input->post('voucher_limit_bytes_out');
        $voucher_limit_bytes_total = $this->input->post('voucher_limit_bytes_total');


        // treatment for voucher
        $vch['vname'] = $this->input->post('voucher_name');
        // $vch['vprice'] = $this->input->post('voucher_price');
        $vch['vcomment'] = $this->input->post('voucher_comment');
        $voucher_comment = json_encode($vch);
        $voucher_password = $this->input->post('voucher_password');
        $voucher_password_type = $this->input->post('voucher_password_type');
        $voucher_qty = $this->input->post('voucher_qty');
//        $chars = "0123456789abcdefghijklmnopqrstuvwxyz";
        $chars = $this->input->post('voucher_random_char');
        $char_length = $this->input->post('voucher_char_length');
        $trap = 0;
        $done = 0;
        $msg_trap = "";

        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            for ($n = 1; $n <= $voucher_qty; $n++) {
                $gen_user = '';
                $gen_pwd = '';
                for ($i = 0; $i < $char_length; $i++) {
                    $gen_user .= $chars[mt_rand(0, strlen($chars) - 1)];
                }

                switch ($voucher_password_type) {
                    case 'at': // automatic
                        for ($i = 0; $i < $char_length; $i++) {
                            $gen_pwd .= $chars[mt_rand(0, strlen($chars) - 1)];
                        }
                        break;
                    case 'su': // same as user
                        $gen_pwd = $gen_user;
                        break;
                    default: // manual
                        $gen_pwd = $voucher_password;
                        break;
                }

                $user = $gen_user;
                $password = $gen_pwd;

                $API->write("/ip/hotspot/user/add", false);
                // required
                $API->write("=server=" . $voucher_server, false);
                $API->write("=profile=" . $voucher_profile, false);
                $API->write("=name=" . $user, false);
                $API->write("=password=" . $password, false);
                $API->write("=disabled=" . $voucher_disabled, false);

                // advanced
                $voucher_address != '' ? $API->write("=address=" . $voucher_address, false) : NULL;
                $voucher_mac_address != '' ? $API->write("=mac-address=" . $voucher_mac_address, false) : NULL;
                $voucher_routes != '' ? $API->write("=routes=" . $voucher_routes, false) : NULL;
                $voucher_email != '' ? $API->write("=email=" . $voucher_email, false) : NULL;

                // limits
                $voucher_limit_uptime != '' ? $API->write("=limit-uptime=" . $voucher_limit_uptime, false) : NULL;
                $voucher_limit_bytes_in != '' ? $API->write("=limit-bytes-in=" . $voucher_limit_bytes_in, false) : NULL;
                $voucher_limit_bytes_out != '' ? $API->write("=limit-bytes-out=" . $voucher_limit_bytes_out, false) : NULL;
                $voucher_limit_bytes_total != '' ? $API->write("=limit-bytes-total=" . $voucher_limit_bytes_total, false) : NULL;

                // prolog
                $API->write("=comment=" . $voucher_comment);

                $array = $API->read();
                if (isset($array['!trap'])) {
                    $trap++;
                    foreach ($array['!trap'][0] as $key => $val):
                        $msg_trap .= '<li>[' . $n . '] ' . $key . ': <b>' . $val . '</b></li>';
                    endforeach;
                } else {
                    $done++;
                }
            }
            ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info-circle"></i> <?= $done ?> Success and <?= $trap ?> Error from <?= $voucher_qty ?> Total Requested</h4>                    
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

    public function delete_voucher_list($session_id) {
        $msids = json_decode($this->input->post('msids'), true);
        $req_qty = count($msids);
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();

        $trap = 0;
        $done = 0;
        $msg_trap = "";

        if ($API->konek($koneksi)) {
            foreach ($msids as $msid):
                $n = 1;
                $API->write("/ip/hotspot/user/remove", false);
                $API->write("=.id=" . $msid);
                $array = $API->read();

                if (isset($array['!trap'])) {
                    $trap++;
                    foreach ($array['!trap'][0] as $key => $val):
                        $msg_trap .= '<li>[' . $n . '] ' . $key . ': <b>' . $val . '</b></li>';
                    endforeach;
                } else {
                    $done++;
                }
                $n++;
            endforeach;
            ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info-circle"></i> <?= $done ?> Deleted and <?= $trap ?> Error from <?= $req_qty ?> Total Requested</h4>                    
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

    public function delete_voucher($session_id) {
        $vname = $this->input->post('vname');
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();

        $trap = 0;
        $done = 0;
        $msg_trap = "";
        
        if ($API->konek($koneksi)) {
            $API->write("/ip/hotspot/user/remove", false);
            // $API->write("~comment~\"\"vname\":\"" . $vname."\"\"");
            $API->write('?comment="{\"vname\":\"yyy\",\"vprice\":\"1002\"}"');
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
                <h4><i class="icon fa fa-info-circle"></i> <?= $done ?> Deleted</h4>                    
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

    public function template_voucher_list($session_id) {
        $template = '
<style>
    .v_wrapper {
        width: 241px;
        padding: 0 5px 5px 0;
        display: inline-block; 
        border-right: 1px dashed #999;
        border-bottom: 1px dashed #999;
    }
    .table_printed{
        border: 1px solid #ccc; 
        font-family: arial; 
        font-size: 12px; 
    }
    .td_header{
        border-bottom:1px solid #ccc;
        background:#ddd !important;
        text-align:center;
    }
    .td_body_title {
        text-align: left;
    }
    .td_body_content {
        text-align: right;
    }
    .td_footer{
        border-bottom:1px solid #ccc;
        background:#eee !important;
    }
</style>
<div class="v_wrapper">
    <table class="table_printed" width="100%">
        <tr>
            <th colspan="3" class="td_header"><span style="padding:10px;font-size:15px;">** Voucher %voucher_name% **</span></th>
        </tr>
        <tr>
            <td rowspan="6">
                %qrcode%
            </td>
        </tr>
        <tr>
            <td class="td_body_title"><span style="padding:5px;">Username</span></td>
            <td class="td_body_content"><span style="padding:5px;"><b>%username%</b></span></td>
        </tr>
        <tr>
            <td class="td_body_title"><span style="padding:5px;">Password</span></td>
            <td class="td_body_content"><span style="padding:5px;"><b>%password%</b></span></td>
        </tr>
        <tr>
            <td class="td_body_title"><span style="padding:5px;">Limit Uptime</span></td>
            <td class="td_body_content"><span style="padding:5px;"><b>%limit_uptime%</b></span></td>
        </tr>
        <tr>
            <td class="td_body_title"><span style="padding:5px;">Validity</span></td>
            <td class="td_body_content"><span style="padding:5px;"><b>%validity%</b></span></td>
        </tr>
        <tr>
            <td class="td_body_title"><span style="padding:5px;">Price</span></td>
            <td class="td_body_content"><span style="padding:5px;"><b>%price%</b></span></td>
        </tr>
        <tr>
            <td colspan="3" class="td_footer"><span style="padding:5px;font-size:9px;">Ket: w=minggu, d=hari, h=jam, m=menit, s=detik</span></td></td>
        </tr>
        <tr>
            <td style="text-align: center" colspan="3"><span style="color:#008899;">Login: <span style="color:#ff7777">http://%host%</span></span></td>
        </tr>
    </table>
</div>
            ';
        ?>
        <form>
            <label>Template Editor:</label>
            <textarea 
                id="template-editor" 
                class="textarea form-control" 
                style="
                    font-family:mono; 
                    white-space: nowrap;  
                    background: #222;
                    color: #0b0;
                    overflow: auto; 
                    width: 100%; 
                    height: 350px; 
                    font-size: 14px; 
                    line-height: 18px; 
                    border: 1px solid #dddddd; 
                    padding: 10px;"
                >
                    <?= $template ?>
                </textarea>
            <textarea 
                id="template-editor-default" style="display:none">
                <?= $template ?>
                </textarea>
            <small class="help-block">Properties: <br><b>%username%, %password%, %limit_uptime%, %price%, %voucher_name%, %qrcode%, %validity%, %host%</b></small>
            <hr/>
            <div class="input-group">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-flat" id="reload_voucher_template_list"><i class="fa fa-refresh"></i></button>
                </span>
                <select class="form-control" name="voucher_template_list" id="voucher_template_list">
                    <option value="default">Default</value>
                </select>
                <span class="input-group-btn">
                    <button type="button" class="btn btn-info btn-flat" id="voucher_template_list_load"><i class="fa fa-rocket"></i> Load Template</button>
                </span>
                <span class="input-group-btn">
                    <button type="button" class="btn btn-danger btn-flat" id="voucher_template_list_delete" title="Delete Template"><i class="fa fa-trash"></i></button>
                </span>
            </div>
            <div class="input-group" style="margin-top: 5px">
                <input type="text" class="form-control" name="voucher_template_name" id="voucher_template_name" placeholder="Template name..." autocomplete="off">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-flat" id="voucher_template_name_save"><i class="fa fa-save"></i> Save Template</button>
                </span>
            </div>

            <hr/>
            <button type="button" id="reload-template-result" class="btn btn-primary btn-block" style="margin-top: 5px;margin-bottom: 5px;"><i class="fa fa-refresh"></i> Refresh Preview Template</button>
            <label>Preview Template:</label>
            <div id="template-result" style="text-align: center;">
                <?= $template ?>
                <?= $template ?>
            </div>

            <hr>
            <div class="form-group">
                <label class="control-label">Host for Login Hotspot:</label>
                <input type="text" class="form-control" id="voucher-domain" autocomplete="off" placeholder="example: rtpapat.net" value="<?= $this->rich_model->get_session_by_id($session_id)['mikrotik_host'] ?>">
            </div>
            <button type="button" id="print-voucher-list" class="btn btn-success btn-block" style="margin-top: 5px"><i class="fa fa-print"></i> Print Voucher</button>

        </form>
        <script>
            $(function () {
                
                //bootstrap WYSIHTML5 - text editor
                // $(".textarea").wysihtml5();

                $('#reload_voucher_template_list').on('click', function () {
                    $('#reload_voucher_template_list i').addClass('fa-spin');
                    reqAjax = $.ajax({
                        url: "<?= site_url('mt_voucher/get_voucher_template') ?>",
                        type: 'POST',
                        success: function (data) {
                            var obj = JSON.parse(data);
                            if (!obj.ok) {

                                $('#reload_voucher_template_list i').removeClass('fa-spin');
                                return false;
                            }

                            $('#voucher_template_list option').remove();
                            $('#voucher_template_list')
                                    .append($("<option></option>")
                                            .attr("value", 'default')
                                            .text('Default'));
                            $.each(obj.msg, function (key, value) {
                                $('#voucher_template_list')
                                        .append($("<option></option>")
                                                .attr("value", value.id)
                                                .text(value.name));
                            });
                            $('#reload_voucher_template_list i').removeClass('fa-spin');
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                            alert(msgError);
                            $('#reload_voucher_template_list i').removeClass('fa-spin');
                        }
                    });
                });

                $('#voucher_template_name_save').on('click', function () {
                    if($('#voucher_template_name').val() == '') {
                        alert('Please fill template name');
                        return false;
                    }
                    var formData = {
                        "session_id": '<?= $session_id ?>',
                        "template_name": $('#voucher_template_name').val(),
                        "template_value": $('#template-editor').val()
                        // "template_value": Base64.encode($('#template-editor').val())
                    }
                    reqAjax = $.ajax({
                        url: "<?= site_url('mt_voucher/save_template') ?>",
                        type: 'POST',
                        data: formData,
                        success: function (data) {
                            var obj = JSON.parse(data);
                            if (!obj.ok) {
                                alert(obj.msg);
                                return false;
                            }

                            alert(obj.msg);
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                            alert(msgError);
                        }
                    });
                });

                $('#voucher_template_list_load').on('click', function() {
                    if($('#voucher_template_list').val() == 'default') {
                        $('#template-editor').val($('#template-editor-default').val());
                        return false;
                    }

                    $.ajax({
                        url: "<?= site_url('mt_voucher/get_voucher_template_by_id') ?>",
                        type: 'POST',
                        data: {'id': $('#voucher_template_list').val()},
                        success: function (data) {
                            var obj = JSON.parse(data);
                            if (!obj.ok) {
                                alert(obj.msg);
                                return false;
                            }
                            $('#template-editor').val(obj.msg.value);
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                            alert(msgError);
                        }
                    });
                });

                $('#voucher_template_list_delete').on('click', function() {
                    if($('#voucher_template_list').val() == 'default') {
                        return false;
                    }

                    $.ajax({
                        url: "<?= site_url('mt_voucher/del_voucher_template_by_id') ?>",
                        type: 'POST',
                        data: {'id': $('#voucher_template_list').val()},
                        success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.ok) {
                            alert(obj.msg);
                            $('#voucher_template_list option').remove();
                            $('#voucher_template_list')
                                    .append($("<option></option>")
                                            .attr("value", 'default')
                                            .text('Default'));
                            $('#template-editor').val('');
                            $('#voucher_template_name').val('');
                        } else {
                            alert(obj.msg);
                        }
                        return false;
                    },
                    error: function (xhr) {
                        console.log(xhr);
                        var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                        alert(msgError);
                    }
                    });
                });

                $('#reload-template-result').on('click', function () {
                    var paramku = $('#template-editor').val();
                    $.ajax({
                        url: "<?= site_url('mt_voucher/result_template_voucher_list') ?>/<?= $session_id ?>",
                                        type: 'POST',
                                        data: {"param": paramku},
                                        success: function (data) {
                                            $('#template-result').html(data);
                                            //                                            console.log(data);
                                        },
                                        error: function (xhr) {
                                            console.log(xhr);
                                            var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                            alert(msgError);
                                            $('#template-result').html(msgError);
                                        }
                                    });
                                });
                                
                    $('#print-voucher-list').on('click', function () {
                        var paramku = $('#template-editor').val();
                        var domainku = $('#voucher-domain').val();

                        $('#voucher-list-modal-<?= $session_id ?>').modal('show');
                        // $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                        window['voucher-list-modal-<?= $session_id ?>'] = $.ajax({
                            url: "<?= site_url('mt_voucher/print_voucher_list') ?>/<?= $session_id ?>",
                                            type: 'POST',
                                            data: {"msvoucher": JSON.stringify(msvoucher), "param": paramku, "domain": domainku},
                                            success: function (data) {
                                                //  $('#voucher-list-modal-<?= $session_id ?> .modal-body').html('Done! Allow pop-ups if vouchers not shown.');
                                                var newWindow = window.open("", "mikrostator voucher", "fullscreen=yes,width=1024,height=768");
                                                newWindow.document.write(data);
                                            },
                                            error: function (xhr) {
                                                console.log(xhr);
                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                alert(msgError);
                                                $('#voucher-list-modal-<?= $session_id ?> .modal-body').html(msgError);
                                            }
                                        });
                                    });


                            });
        </script>
        <?php
    }

    public function result_template_voucher_list($session_id) {
        $template = $this->input->post('param');
        echo $template;
        echo $template;
    }
   
    public function print_voucher_list($session_id) {
        echo '<script src="'.base_url('assets/js/jquery.min.js').'"></script>';
        echo '<script src="'.base_url('assets/js/jquery.qrcode.min.js').'"></script>';

        echo '<style>@media print {
            .control-group {
              display: none;
            }
        }
        .barcode canvas{width:75px;}</style>';
        $msvoucher = json_decode($this->input->post('msvoucher'), true);
        // print_r($msvoucher);
        $template = $this->input->post('param');
        $domain = $this->input->post('domain');
        if(count($msvoucher)>0){
            foreach ($msvoucher as $voucher):
                $url = urlencode('http://'.$domain.'/login?username='.$voucher['msusers'].'&password='.$voucher['mspwds']);
                $filter1 = str_replace('%username%', $voucher['msusers'], $template);
                $filter2 = str_replace('%password%', $voucher['mspwds'], $filter1);
                $filter3 = str_replace('%limit_uptime%', $voucher['msvlimituptime'], $filter2);
                $filter4 = str_replace('%price%', $voucher['msvprice'], $filter3);
                $filter5 = str_replace('%voucher_name%', $voucher['msvname'], $filter4);
                $filter6 = str_replace('%qrcode%',  '<img src="https://chart.googleapis.com/chart?cht=qr&chs=90x90&chld=L|0&chl='.$url.'" />', $filter5);
                // $filter6 = str_replace('%qrcode%',  '<span id="#barcode_'.$voucher['msusers'].'" class="barcode"></span><script>jQuery(\'#barcode_'.$voucher['msusers'].'\').qrcode({text : "http://'.$domain.'/login?username='.$voucher['msusers'].'&password='.$voucher['mspwds'].'"});</script>', $filter5);
                $filter7 = str_replace('%validity%', $voucher['msvvalidity'], $filter6);
                $filter8 = str_replace('%host%', $domain, $filter7);
                echo $filter8;
            endforeach;
            echo '<script>window.onload = function() {window.print();}</script>';
            echo '<hr class="control-group"><button onclick="window.print()" class="control-group">print</button>';
        }
    }


    public function save_template() {
        $this->load->database();
        $data['name'] = $this->input->post('template_name');
        $data['value'] = $this->input->post('template_value');
        $this->db->insert('voucher_template', $data);
        $afftectedRows = $this->db->affected_rows();
        if ($afftectedRows) {
            $result['ok'] = true;
            $result['msg'] = 'Saved.';
        } else {
            $result['ok'] = false;
            $result['msg'] = $this->db->error()['message'];
        }
        echo json_encode($result);
    }

    public function get_voucher_template() {
        $this->load->database();
        $query = $this->db->get('voucher_template');
        $array = $query->result();
        if (count($array) > 0) {
            $result['ok'] = true;
            $result['msg'] = $array;
        } else {
            $result['ok'] = false;
            $result['msg'] = 'no data';
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function get_voucher_template_by_id() {
        $id = $this->input->post('id');

        $this->load->database();
        $this->db->where('id', $id);
        $query = $this->db->get('voucher_template');
        $array = $query->row();
        if (count($array) > 0) {
            $result['ok'] = true;
            $result['msg'] = $array;
        } else {
            $result['ok'] = false;
            $result['msg'] = 'no data';
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }


    public function del_voucher_template_by_id() {
        $id = $this->input->post('id');

        $this->load->database();
        $this->db->where('id', $id);
        $this->db->delete('voucher_template');
        $afftectedRows = $this->db->affected_rows();
        if ($afftectedRows > 0) {
            $result['ok'] = true;
            $result['msg'] = 'Template deleted.';
        } else {
            $result['ok'] = false;
            $result['msg'] = 'Fail deleting Template.';
        }
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

}
