<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mt_ip extends MY_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('stator_model');
        $this->load->model('rich_model');
    }

    /*
     * *************************************
     * hotspot server.begin
     * *************************************
     */

    public function hotspot_server($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_ip-hotspot_server" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">name</th>
                        <th class="text-nowrap">interface</th>
                        <th class="text-nowrap">address-pool</th>
                        <th class="text-nowrap">profile</th>
                        <th class="text-nowrap">idle-timeout</th>
                        <th class="text-nowrap">keepalive-timeout</th>
                        <th class="text-nowrap">login-timeout</th>
                        <th class="text-nowrap">addresses-per-mac</th>
                        <th class="text-nowrap">proxy-status</th>
                        <th class="text-nowrap">invalid</th>
                        <th class="text-nowrap">HTTPS</th>
                        <th class="text-nowrap">disabled</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_ip-hotspot_server').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_ip/json_hotspot_server/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }
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
                        $('td:eq(6)', row).addClass('text-right');
                        $('td:eq(7)', row).addClass('text-right');
                        $('td:eq(8)', row).addClass('text-right');
                        $('td:eq(9)', row).addClass('text-right');
                        $('td:eq(11)', row).addClass('text-center');
                        $('td:eq(12)', row).addClass('text-center');
                        $('td:eq(13)', row).addClass('text-center');
                    }
                });
                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                    });
                });
            </script>
        </div>
        <?php
    }

    public function json_hotspot_server($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/ip/hotspot/print');
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
            foreach ($array as $value):
                $row = array();
                $row[] = $no;
                $row[] = isset($value['.id']) ? $value['.id'] : '';
                $row[] = isset($value['name']) ? $value['name'] : '';
                $row[] = isset($value['interface']) ? $value['interface'] : '';
                $row[] = isset($value['address-pool']) ? $value['address-pool'] : '';
                $row[] = isset($value['profile']) ? $value['profile'] : '';
                $row[] = isset($value['idle-timeout']) ? $value['idle-timeout'] : '';
                $row[] = isset($value['keepalive-timeout']) ? $value['keepalive-timeout'] : '';
                $row[] = isset($value['login-timeout']) ? $value['login-timeout'] : '';
                $row[] = isset($value['addresses-per-mac']) ? $value['addresses-per-mac'] : '';
                $row[] = isset($value['proxy-status']) ? $value['proxy-status'] : '';
                $row[] = isset($value['invalid']) ? $this->rich_model->get_logic_label($value['invalid']) : '';
                $row[] = isset($value['HTTPS']) ? $this->rich_model->get_logic_label($value['HTTPS']) : '';
                $row[] = isset($value['disabled']) ? $this->rich_model->get_logic_label($value['disabled']) : '';
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

    /*
     * **************************************************************************
     * hotspot server.end
     * **************************************************************************
     */



    /*
     * *************************************
     * hotspot server profile.begin
     * *************************************
     */

    public function hotspot_server_profile($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_ip-hotspot_server_profile" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">name</th>
                        <th class="text-nowrap">hotspot-address</th>
                        <th class="text-nowrap">dns-name</th>
                        <th class="text-nowrap">html-directory</th>
                        <th class="text-nowrap">html-directory-override</th>
                        <th class="text-nowrap">rate-limit</th>
                        <th class="text-nowrap">http-proxy</th>
                        <th class="text-nowrap">smtp-server</th>
                        <th class="text-nowrap">login-by</th>
                        <th class="text-nowrap">http-cookie-lifetime</th>
                        <th class="text-nowrap">split-user-domain</th>
                        <th class="text-nowrap">use-radius</th>
                        <th class="text-nowrap">default</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_ip-hotspot_server_profile').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_ip/json_hotspot_server_profile/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }
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
                        $('td:eq(7)', row).addClass('text-right');
                        $('td:eq(11)', row).addClass('text-right');
                        $('td:eq(12)', row).addClass('text-center');
                        $('td:eq(13)', row).addClass('text-center');
                        $('td:eq(14)', row).addClass('text-center');
                    }
                });
                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                    });
                });
            </script>
        </div>
        <?php
    }

    public function json_hotspot_server_profile($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/ip/hotspot/profile/print');
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
            foreach ($array as $value):
                $row = array();
                $row[] = $no;
                $row[] = isset($value['.id']) ? $value['.id'] : '';
                $row[] = isset($value['name']) ? $value['name'] : '';
                $row[] = isset($value['hotspot-address']) ? $value['hotspot-address'] : '';
                $row[] = isset($value['dns-name']) ? $value['dns-name'] : '';
                $row[] = isset($value['html-directory']) ? $value['html-directory'] : '';
                $row[] = isset($value['html-directory-override']) ? $value['html-directory-override'] : '';
                $row[] = isset($value['rate-limit']) ? $value['rate-limit'] : '';
                $row[] = isset($value['http-proxy']) ? $value['http-proxy'] : '';
                $row[] = isset($value['smtp-server']) ? $value['smtp-server'] : '';
                $row[] = isset($value['login-by']) ? $value['login-by'] : '';
                $row[] = isset($value['http-cookie-lifetime']) ? $value['http-cookie-lifetime'] : '';
                $row[] = isset($value['split-user-domain']) ? $this->rich_model->get_logic_label($value['split-user-domain']) : '';
                $row[] = isset($value['use-radius']) ? $this->rich_model->get_logic_label($value['use-radius']) : '';
                $row[] = isset($value['default']) ? $this->rich_model->get_logic_label($value['default']) : '';
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

    /*
     * **************************************************************************
     * hotspot server profile.end
     * **************************************************************************
     */



    /*
     * *************************************
     * hotspot hotspot host.begin
     * *************************************
     */

    public function hotspot_host($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_ip-hotspot_host" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">mac-address</th>
                        <th class="text-nowrap">address</th>
                        <th class="text-nowrap">to-address</th>
                        <th class="text-nowrap">server</th>
                        <th class="text-nowrap">uptime</th>
                        <th class="text-nowrap" title="uptime in minute">U (m)</th>
                        <th class="text-nowrap">idle-time</th>
                        <th class="text-nowrap">idle-timeout</th>
                        <th class="text-nowrap">host-dead-time</th>
                        <th class="text-nowrap">bytes-in</th>
                        <th class="text-nowrap">bytes-in (n)</th>
                        <th class="text-nowrap">bytes-out</th>
                        <th class="text-nowrap">bytes-out (n)</th>
                        <th class="text-nowrap">packets-in</th>
                        <th class="text-nowrap">packets-out</th>
                        <th class="text-nowrap">found-by</th>
                        <th class="text-nowrap">authorized</th>
                        <th class="text-nowrap">bypassed</th>
                        <th class="text-nowrap">comment</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_ip-hotspot_host').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_ip/json_hotspot_host/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }
                            return json.data;
                        }
                    },
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    order: [[0, "asc"]],
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
                        $('td:eq(6)', row).addClass('text-right');
                        $('td:eq(7)', row).addClass('text-right');
                        $('td:eq(8)', row).addClass('text-right');
                        $('td:eq(9)', row).addClass('text-right');
                        $('td:eq(10)', row).addClass('text-right');
                        $('td:eq(11)', row).addClass('text-right');
                        $('td:eq(12)', row).addClass('text-right');
                        $('td:eq(13)', row).addClass('text-right');
                        $('td:eq(14)', row).addClass('text-right');
                        $('td:eq(15)', row).addClass('text-right');
                        $('td:eq(16)', row).addClass('text-right');
                        $('td:eq(18)', row).addClass('text-center');
                        $('td:eq(19)', row).addClass('text-center');
                    }
                });
                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                    });
                });
            </script>
        </div>
        <?php
    }

    public function json_hotspot_host($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/ip/hotspot/host/print');
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
            foreach ($array as $value):
                $row = array();
                $row[] = $no;
                $row[] = isset($value['.id']) ? $value['.id'] : '';
                $row[] = isset($value['mac-address']) ? $value['mac-address'] : '';
                $row[] = isset($value['address']) ? $value['address'] : '';
                $row[] = isset($value['to-address']) ? $value['to-address'] : '';
                $row[] = isset($value['server']) ? $value['server'] : '';
                $row[] = isset($value['uptime']) ? $value['uptime'] : '';
                $row[] = isset($value['uptime']) ? $this->stator_model->get_menit($value['uptime']) : '';
                $row[] = isset($value['idle-time']) ? $value['idle-time'] : '';
                $row[] = isset($value['idle-timeout']) ? $value['idle-timeout'] : '';
                $row[] = isset($value['host-dead-time']) ? $value['host-dead-time'] : '';
                $row[] = isset($value['bytes-in']) ? $value['bytes-in'] : '';
                $row[] = isset($value['bytes-in']) ? $this->rich_model->formatBytes($value['bytes-in']) : '';
                $row[] = isset($value['bytes-out']) ? $value['bytes-out'] : '';
                $row[] = isset($value['bytes-out']) ? $this->rich_model->formatBytes($value['bytes-out']) : '';
                $row[] = isset($value['packets-in']) ? $value['packets-in'] : '';
                $row[] = isset($value['packets-out']) ? $value['packets-out'] : '';
                $row[] = isset($value['found-by']) ? $value['found-by'] : '';
                $row[] = isset($value['authorized']) ? $this->rich_model->get_logic_label($value['authorized']) : '';
                $row[] = isset($value['bypassed']) ? $this->rich_model->get_logic_label($value['bypassed']) : '';
                $row[] = isset($value['comment']) ? $value['comment'] : '';
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

    /*
     * **************************************************************************
     * hotspot hotspot host.end
     * **************************************************************************
     */




    /*
     * *************************************
     * hotspot hotspot ip binding.begin
     * *************************************
     */

    public function hotspot_ip_binding($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_ip-hotspot_host" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">mac-address</th>
                        <th class="text-nowrap">address</th>
                        <th class="text-nowrap">to-address</th>
                        <th class="text-nowrap">server</th>
                        <th class="text-nowrap">type</th>
                        <th class="text-nowrap">bypassed</th>
                        <th class="text-nowrap">blocked</th>
                        <th class="text-nowrap">disabled</th>
                        <th class="text-nowrap">comment</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_ip-hotspot_host').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_ip/json_hotspot_ip_binding/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }
                            return json.data;
                        }
                    },
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    order: [[0, "asc"]],
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
                        $('td:eq(7)', row).addClass('text-center');
                        $('td:eq(8)', row).addClass('text-center');
                        $('td:eq(9)', row).addClass('text-center');
                    }
                });
                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
        //                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('<i class="fa fa-refresh fa-spin"></i> loading');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                    });
                });
            </script>
        </div>
        <?php
    }

    public function json_hotspot_ip_binding($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/ip/hotspot/ip-binding/print');
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
            foreach ($array as $value):
                $row = array();
                $row[] = $no;
                $row[] = isset($value['.id']) ? $value['.id']: '';
                $row[] = isset($value['mac-address']) ? $value['mac-address']: '';
                $row[] = isset($value['address']) ? $value['address']: '';
                $row[] = isset($value['to-address']) ? $value['to-address']: '';
                $row[] = isset($value['server']) ? $value['server']: '';
                $row[] = isset($value['type']) ? $value['type']: '';
                $row[] = isset($value['bypassed']) ? $this->rich_model->get_logic_label($value['bypassed']): '';
                $row[] = isset($value['blocked']) ? $this->rich_model->get_logic_label($value['blocked']): '';
                $row[] = isset($value['disabled']) ? $this->rich_model->get_logic_label($value['disabled']): '';
                $row[] = isset($value['comment']) ? $value['comment']: '';
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

    /*
     * **************************************************************************
     * hotspot hotspot ip binding.end
     * **************************************************************************
     */




    /*
     * *************************************
     * hotspot active.begin
     * *************************************
     */

    public function hotspot_active($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_ip-hotspot_active" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">server</th>
                        <th class="text-nowrap">user</th>
                        <th class="text-nowrap">address</th>
                        <th class="text-nowrap">mac-address</th>
                        <th class="text-nowrap">login-by</th>
                        <th class="text-nowrap">uptime</th>
                        <th class="text-nowrap" title="uptime in minute">U (m)</th>
                        <th class="text-nowrap">session-time-left</th>
                        <th class="text-nowrap" title="session-time-left in minute">STL (m)</th>
                        <th class="text-nowrap">idle-time</th>
                        <th class="text-nowrap">keepalive-timeout</th>
                        <th class="text-nowrap">bytes-in</th>
                        <th class="text-nowrap">bytes-in (n)</th>
                        <th class="text-nowrap">bytes-out</th>
                        <th class="text-nowrap">bytes-out (n)</th>
                        <th class="text-nowrap">packets-in</th>
                        <th class="text-nowrap">packets-out</th>
                        <th class="text-nowrap">radius</th>
                        <th class="text-nowrap">comment</th>
                        <th class="text-nowrap">action</th>
                        <th class="text-nowrap">user</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_ip-hotspot_active').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_ip/json_hotspot_active/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }
                            return json.data;
                        }
                    },
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    order: [[10, "asc"]],
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
                        $('td:eq(7)', row).addClass('text-right');
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
                        $('td:eq(19)', row).addClass('text-center');
                    }
                });
                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
        //                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('<i class="fa fa-refresh fa-spin"></i> loading');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);

                        if ($('#autorefresh-<?= $session_id ?>-<?= $cmd ?>').prop('checked')) {                        
                            window['autoRefreshInterval-<?= $session_id ?>-<?= $cmd ?>']($('#autorefresh_interval-<?= $session_id ?>-<?= $cmd ?>').val());
                        } else {
                            clearInterval(window['interval-<?= $session_id ?>-<?= $cmd ?>']);
                        }
                    });
                });

                window['autoRefreshInterval-<?= $session_id ?>-<?= $cmd ?>'] = function(ms){
                    window['interval-<?= $session_id ?>-<?= $cmd ?>'] = setInterval( function () {
                        if ($('#autorefresh-<?= $session_id ?>-<?= $cmd ?>').prop('checked')) {                        
                            window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                        } else {
                            clearInterval(window['interval-<?= $session_id ?>-<?= $cmd ?>']);
                        }
                    }, ms );
                }
                window['delete-hotspot-active-<?= $session_id ?>'] = function (msid) {
                    $('#hotspot-active-modal-<?= $session_id ?>').modal('show');
                    $('#hotspot-active-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                    window['hotspot-active-modal-<?= $session_id ?>'] = $.ajax({
                        url: "<?= site_url('mt_ip/delete_hotspot_active') ?>/<?= $session_id ?>",
                                    type: 'POST',
                                    data: {"msid": msid},
                                    success: function (data) {
                                        $('#hotspot-active-modal-<?= $session_id ?> .modal-body').html(data);
                                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                    },
                                    error: function (xhr) {
                                        console.log(xhr);
                                        var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                        alert(msgError);
                                        $('#hotspot-active-modal-<?= $session_id ?> .modal-body').html(msgError);
                                    }
                                });
                            }
            </script>
        </div>
        <!-- Modal Add Hotspot Active.begin -->
        <div class="modal fade" id="hotspot-active-modal-<?= $session_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">
                            Hotspot Active
                        </h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="save-hotspot-active-<?= $session_id ?>">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Add IP Hotspot Active.end -->
        <?php
    }

    public function json_hotspot_active($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/ip/hotspot/active/print');
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
            foreach ($array as $value):
                $row = array();
                $row[] = $no;
                $row[] = isset($value['.id']) ? $value['.id'] : '';
                $row[] = isset($value['server']) ? $value['server'] : '';
                $row[] = isset($value['user']) ? $value['user'] : '';
                $row[] = isset($value['address']) ? $value['address'] : '';
                $row[] = isset($value['mac-address']) ? $value['mac-address'] : '';
                $row[] = isset($value['login-by']) ? $value['login-by'] : '';
                $row[] = isset($value['uptime']) ? $value['uptime'] : '';
                $row[] = isset($value['uptime']) ? $this->stator_model->get_menit($value['uptime']) : '';
                $row[] = isset($value['session-time-left']) ? $value['session-time-left'] : '';
                $row[] = isset($value['session-time-left']) ? $this->stator_model->get_menit($value['session-time-left']) : '';
                $row[] = isset($value['idle-time']) ? $value['idle-time'] : '';
                $row[] = isset($value['keepalive-timeout']) ? $value['keepalive-timeout'] : '';
                $row[] = isset($value['bytes-in']) ? $value['bytes-in'] : '';
                $row[] = isset($value['bytes-in']) ? $this->rich_model->formatBytes($value['bytes-in']) : '';
                $row[] = isset($value['bytes-out']) ? $value['bytes-out'] : '';
                $row[] = isset($value['bytes-out']) ? $this->rich_model->formatBytes($value['bytes-out']) : '';
                $row[] = isset($value['packets-in']) ? $value['packets-in'] : '';
                $row[] = isset($value['packets-out']) ? $value['packets-out'] : '';
                $row[] = isset($value['radius']) ? $this->rich_model->get_logic_label($value['radius']) : '';
                $row[] = isset($value['comment']) ? $value['comment'] : '';
                $row[] = '<button type="button" name="delete"  onclick="if (confirm(\'Are you sure?\')) {
                                window[\'delete-hotspot-active-' . $session_id . '\'](\'' . $value['.id'] . '\')
                            }"  class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-close"></i> Del</button>';
                $row[] = isset($value['user']) ? $value['user'] : '';
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

    public function delete_hotspot_active($session_id) {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $msid = $this->input->post('msid');

        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            $API->write("/ip/hotspot/active/remove", false);
            $API->write("=.id=" . $msid);
            $array = $API->read();

//                $this->rich_model->debug_array($array, true);

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
            ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Done!</h4>
                Data deleted!
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

    /*
     * **************************************************************************
     * hotspot active.end
     * **************************************************************************
     */





    /*
     * *************************************
     * hotspot user.begin
     * *************************************
     */

    public function hotspot_user($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <button type="button" name="add" id="add-hotspot-user-<?= $session_id ?>" class="btn btn-success btn-xs pull-left" title="Add"><i class="fa fa-plus-square"></i> Add New</button>
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>

        <div class="table-responsive">
            <table id="mt_ip-hotspot_user" class="table table-bordered table-striped table-condensed table-hover" border="1">
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
                        <th class="text-nowrap">action</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_ip-hotspot_user').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_ip/json_hotspot_user/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }
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
                    }
                });
                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                    });
                });

                $(document).ready(function () {

                    $('#add-hotspot-user-<?= $session_id ?>').on('click', function () {
                        $('#hotspot-user-modal-<?= $session_id ?>').modal('show');
                        $('#hotspot-user-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                        window['hotspot-user-modal-<?= $session_id ?>'] = $.ajax({
                            url: "<?= site_url('mt_ip/modal_hotspot_user') ?>/<?= $session_id ?>",
                                            success: function (data) {
                                                $('#hotspot-user-modal-<?= $session_id ?> .modal-body').html(data);
                                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                            },
                                            error: function (xhr) {
                                                console.log(xhr);
                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                alert(msgError);
                                                $('#hotspot-user-modal-<?= $session_id ?> .modal-body').html(msgError);
                                            }
                                        });
                                    });

                                    $('#hotspot-user-modal-<?= $session_id ?>').on('hide.bs.modal', function (e) {
                                        window['hotspot-user-modal-<?= $session_id ?>'].abort();
                                    });


                                    window['edit-hotspot-user-<?= $session_id ?>'] = function (msid) {
                                        $('#hotspot-user-modal-<?= $session_id ?>').modal('show');
                                        $('#hotspot-user-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                                        window['hotspot-user-modal-<?= $session_id ?>'] = $.ajax({
                                            url: "<?= site_url('mt_ip/modal_hotspot_user') ?>/<?= $session_id ?>/edit",
                                            type: 'POST',
                                            data: {"msid": msid},
                                            success: function (data) {
                                                $('#hotspot-user-modal-<?= $session_id ?> .modal-body').html(data);
                                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                            },
                                            error: function (xhr) {
                                                console.log(xhr);
                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                alert(msgError);
                                                $('#hotspot-user-modal-<?= $session_id ?> .modal-body').html(msgError);
                                            }
                                        });
                                    }

                                    window['delete-hotspot-user-<?= $session_id ?>'] = function (msid) {
                                        $('#hotspot-user-modal-<?= $session_id ?>').modal('show');
                                        $('#hotspot-user-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                                        window['hotspot-user-modal-<?= $session_id ?>'] = $.ajax({
                                            url: "<?= site_url('mt_ip/delete_hotspot_user') ?>/<?= $session_id ?>",
                                                            type: 'POST',
                                                            data: {"msid": msid},
                                                            success: function (data) {
                                                                $('#hotspot-user-modal-<?= $session_id ?> .modal-body').html(data);
                                                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                                            },
                                                            error: function (xhr) {
                                                                console.log(xhr);
                                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                                alert(msgError);
                                                                $('#hotspot-user-modal-<?= $session_id ?> .modal-body').html(msgError);
                                                            }
                                                        });
                                                    }

                                                    $('#save-hotspot-user-<?= $session_id ?>').on('click', function () {
        // validasi form.begin
                                                        if ($('#hotspot-user-server').val() == '' || $('#hotspot-user-server').val() == '*') {
                                                            alert('Please fill server!');
                                                            return false;
                                                        }
                                                        if ($('#hotspot-user-profile').val() == '' || $('#hotspot-user-profile').val() == '*') {
                                                            alert('Please fill profile!');
                                                            return false;
                                                        }
                                                        if ($('#hotspot-user-name').val() == '') {
                                                            alert('Please fill name!');
                                                            return false;
                                                        }
        // validasi form.end

                                                        var formData = {
                                                            "hotspot_user_server": $('#hotspot-user-server').val(),
                                                            "hotspot_user_profile": $('#hotspot-user-profile').val(),
                                                            "hotspot_user_id": $('#hotspot-user-id').val(),
                                                            "hotspot_user_name": $('#hotspot-user-name').val(),
                                                            "hotspot_user_password": $('#hotspot-user-password').val(),
                                                            "hotspot_user_disabled": $('#hotspot-user-disabled').val(),
                                                            "hotspot_user_address": $('#hotspot-user-address').val(),
                                                            "hotspot_user_mac_address": $('#hotspot-user-mac-address').val(),
                                                            "hotspot_user_routes": $('#hotspot-user-routes').val(),
                                                            "hotspot_user_email": $('#hotspot-user-email').val(),
                                                            "hotspot_user_comment": $('#hotspot-user-comment').val(),
                                                            "hotspot_user_limit_uptime": $('#hotspot-user-limit-uptime').val(),
                                                            "hotspot_user_limit_bytes_in": $('#hotspot-user-limit-bytes-in').val(),
                                                            "hotspot_user_limit_bytes_out": $('#hotspot-user-limit-bytes-out').val(),
                                                            "hotspot_user_limit_bytes_total": $('#hotspot-user-limit-bytes-total').val()
                                                        }
                                                        $('#hotspot-user-modal-<?= $session_id ?> .modal-body .notifikasi').html(loadingBar);
                                                        window['save-hotspot-user-modal-<?= $session_id ?>'] = $.ajax({
                                                            url: "<?= site_url('mt_ip/save_hotspot_user') ?>/<?= $session_id ?>",
                                                                            type: 'POST',
                                                                            data: formData,
                                                                            success: function (data) {
                                                                                $('#hotspot-user-modal-<?= $session_id ?> .modal-body .notifikasi').html(data);
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
        <div class="modal fade" id="hotspot-user-modal-<?= $session_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">
                            Hotspot User
                        </h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="save-hotspot-user-<?= $session_id ?>">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Add IP Hotspot User.end -->
        <?php
    }

    public function json_hotspot_user($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
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
            $no = 1;
            foreach ($array as $value):
                $row = array();
                $row[] = $no;
                $row[] = isset($value['.id']) ? $value['.id'] : '';
                $row[] = isset($value['name']) ? $value['name'] : '';
                $row[] = isset($value['password']) ? '<a href="javascript:void(0)" onclick="prompt(\'password: \',\'' . $value['password'] . '\')">***</a>' : '<a href="javascript:void(0)" onclick="prompt(\'password: \',\'\')">***</a>';
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
                $row[] = '<button type="button" name="edit" onclick="window[\'edit-hotspot-user-' . $session_id . '\'](\'' . $value['.id'] . '\')" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-pencil-square"></i> Edit</button>
<button type="button" name="delete"  onclick="if (confirm(\'Are you sure?\')) {
    window[\'delete-hotspot-user-' . $session_id . '\'](\'' . $value['.id'] . '\')
}"  class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-close"></i> Del</button>';
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

    public function modal_hotspot_user($session_id, $msid = "") {
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
                    <li class="active"><a href="#tab_1_hotspot_user-<?=$session_id?>" data-toggle="tab">Basic</a></li>
                    <li><a href="#tab_2_hotspot_user-<?=$session_id?>" data-toggle="tab">Advanced</a></li>
                    <li><a href="#tab_3_hotspot_user-<?=$session_id?>" data-toggle="tab">Limits</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1_hotspot_user-<?=$session_id?>">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Server:</label>
                                <select class="form-control" id="hotspot-user-server">
                                    <!--<option value="*">-- Select Server --</option>-->
                                    <option value="all">all</option>
                                    <?php foreach ($list_server as $value): ?>
                                        <option value="<?= $value['name'] ?>" <?= isset($list_user['server']) ? $value['name'] == $list_user['server'] ? 'selected' : '' : '' ?>><?= $value['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Profile:</label>
                                <select class="form-control" id="hotspot-user-profile">
                                    <!--<option value="*">-- Select Profile --</option>-->
                                    <?php foreach ($list_user_profile as $value): ?>
                                        <option value="<?= $value['name'] ?>" <?= isset($list_user['profile']) ? $value['name'] == $list_user['profile'] ? 'selected' : '' : '' ?>><?= $value['name'] ?></option>                        
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Name:</label>
                                <input type="hidden" class="form-control" id="hotspot-user-id" placeholder="" value="<?= isset($list_user['.id']) ? $list_user['.id'] : '' ?>">
                                <input type="text" class="form-control" id="hotspot-user-name" autocomplete="off" placeholder="" value="<?= isset($list_user['name']) ? $list_user['name'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Password:</label>
                                <input type="text" class="form-control" id="hotspot-user-password" autocomplete="off" placeholder="" value="<?= isset($list_user['password']) ? $list_user['password'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Disabled:</label>
                                <select class="form-control" id="hotspot-user-disabled">
                                    <option value="no" <?= isset($list_user['disabled']) ? 'false' == $list_user['disabled'] ? 'selected' : '' : '' ?>>No</option>
                                    <option value="yes" <?= isset($list_user['disabled']) ? 'true' == $list_user['disabled'] ? 'selected' : '' : '' ?>>Yes</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2_hotspot_user-<?=$session_id?>">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Address:</label>
                                <input type="text" class="form-control" id="hotspot-user-address" placeholder="" value="<?= isset($list_user['address']) ? $list_user['address'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">MAC Address:</label>
                                <input type="text" class="form-control" id="hotspot-user-mac-address" placeholder="" value="<?= isset($list_user['mac-address']) ? $list_user['mac-address'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Routes:</label>
                                <input type="text" class="form-control" id="hotspot-user-routes" placeholder="" value="<?= isset($list_user['routes']) ? $list_user['routes'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email:</label>
                                <input type="text" class="form-control" id="hotspot-user-email" placeholder="" value="<?= isset($list_user['email']) ? $list_user['email'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Comment:</label>
                                <!--<input type="text" class="form-control" id="hotspot-user-comment" placeholder="" value="<?= isset($list_user['comment']) ? $list_user['comment'] : '' ?>">-->
                                <textarea class="form-control" id="hotspot-user-comment" placeholder=""><?= isset($list_user['comment']) ? $list_user['comment'] : '' ?></textarea>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3_hotspot_user-<?=$session_id?>">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Limit Uptime:</label>
                                <input type="text" class="form-control" id="hotspot-user-limit-uptime" placeholder="" value="<?= isset($list_user['limit-uptime']) ? $list_user['limit-uptime'] : '' ?>">
                                <small class="help-block">Example: 1w2d3h4m5s (w=week, d=day, h=hour, m=minute, s=second)</small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Limit Bytes In:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="hotspot-user-limit-bytes-in" placeholder="" value="<?= isset($list_user['limit-bytes-in']) ? $list_user['limit-bytes-in'] : '' ?>">
                                    <span class="input-group-addon convert-limit-bytes-in">0</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Limit Bytes Out:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="hotspot-user-limit-bytes-out" placeholder="" value="<?= isset($list_user['limit-bytes-out']) ? $list_user['limit-bytes-out'] : '' ?>">
                                    <span class="input-group-addon convert-limit-bytes-out">0</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Limit Bytes Total:</label>                                
                                <div class="input-group">
                                    <input type="text" class="form-control" id="hotspot-user-limit-bytes-total" placeholder="" value="<?= isset($list_user['limit-bytes-total']) ? $list_user['limit-bytes-total'] : '' ?>">
                                    <span class="input-group-addon convert-limit-bytes-total">0</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- Custom Tabs -->
            <script>
                $('#hotspot-user-limit-bytes-in').on('change', function () {
                    $('.convert-limit-bytes-in').load("<?= site_url('home/convertBytes') ?>/" + $(this).val());
                });
                $('#hotspot-user-limit-bytes-out').on('change', function () {
                    $('.convert-limit-bytes-out').load("<?= site_url('home/convertBytes') ?>/" + $(this).val());
                });
                $('#hotspot-user-limit-bytes-total').on('change', function () {
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

    public function save_hotspot_user($session_id) {
        $koneksi = $this->rich_model->get_session_by_id($session_id);

        $hotspot_user_id = $this->input->post('hotspot_user_id');
        $hotspot_user_server = $this->input->post('hotspot_user_server');
        $hotspot_user_name = $this->input->post('hotspot_user_name');
        $hotspot_user_password = $this->input->post('hotspot_user_password');
        $hotspot_user_disabled = $this->input->post('hotspot_user_disabled');
        $hotspot_user_address = $this->input->post('hotspot_user_address');
        $hotspot_user_mac_address = $this->input->post('hotspot_user_mac_address');
        $hotspot_user_profile = $this->input->post('hotspot_user_profile');
        $hotspot_user_routes = $this->input->post('hotspot_user_routes');
        $hotspot_user_email = $this->input->post('hotspot_user_email');
        $hotspot_user_limit_uptime = $this->input->post('hotspot_user_limit_uptime');
        $hotspot_user_limit_bytes_in = $this->input->post('hotspot_user_limit_bytes_in');
        $hotspot_user_limit_bytes_out = $this->input->post('hotspot_user_limit_bytes_out');
        $hotspot_user_limit_bytes_total = $this->input->post('hotspot_user_limit_bytes_total');
        $hotspot_user_comment = $this->input->post('hotspot_user_comment');

        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {

            if (isset($hotspot_user_id) && $hotspot_user_id != '') {
                // edit
                $API->write("/ip/hotspot/user/set", false);
                $API->write("=.id=" . $hotspot_user_id, false);
            } else {
                // add
                $API->write("/ip/hotspot/user/add", false);
            }
            // required
            $API->write("=server=" . $hotspot_user_server, false);
            $API->write("=profile=" . $hotspot_user_profile, false);
            $API->write("=name=" . $hotspot_user_name, false);
            $API->write("=password=" . $hotspot_user_password, false);
            $API->write("=disabled=" . $hotspot_user_disabled, false);

            // advanced
            $hotspot_user_address != '' ? $API->write("=address=" . $hotspot_user_address, false) : NULL;
            $hotspot_user_mac_address != '' ? $API->write("=mac-address=" . $hotspot_user_mac_address, false) : NULL;
            $hotspot_user_routes != '' ? $API->write("=routes=" . $hotspot_user_routes, false) : NULL;
            $hotspot_user_email != '' ? $API->write("=email=" . $hotspot_user_email, false) : NULL;

            // limits
            $hotspot_user_limit_uptime != '' ? $API->write("=limit-uptime=" . $hotspot_user_limit_uptime, false) : NULL;
            $hotspot_user_limit_bytes_in != '' ? $API->write("=limit-bytes-in=" . $hotspot_user_limit_bytes_in, false) : NULL;
            $hotspot_user_limit_bytes_out != '' ? $API->write("=limit-bytes-out=" . $hotspot_user_limit_bytes_out, false) : NULL;
            $hotspot_user_limit_bytes_total != '' ? $API->write("=limit-bytes-total=" . $hotspot_user_limit_bytes_total, false) : NULL;

            // prolog
            $API->write("=comment=" . $hotspot_user_comment);
            $array = $API->read();

//                $this->rich_model->debug_array($array, true);

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

            /*
             * ********************************************************
             *  untuk add dan edit tidak perlu validasi jumlah array
             * ********************************************************
             */
//                if (count($array) == 0) {
//                    
            ?>
            <!--                    <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    Result not found!
                                </div>-->
            <?php
//                    return false;
//                }
            ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Done!</h4>
                Data saved!
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

    public function delete_hotspot_user($session_id) {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $msid = $this->input->post('msid');

        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            $API->write("/ip/hotspot/user/remove", false);
            $API->write("=.id=" . $msid);
            $array = $API->read();

//                $this->rich_model->debug_array($array, true);

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
            ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Done!</h4>
                Data deleted!
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

    /*
     * **************************************************************************
     * hotspot user.end
     * **************************************************************************
     */





    /*
     * *************************************
     * hotspot user profile.begin
     * *************************************
     */

    public function hotspot_user_profile($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <button type="button" name="add" id="add-hotspot-user-profile-<?= $session_id ?>" class="btn btn-success btn-xs pull-left" title="Add"><i class="fa fa-plus-square"></i> Add New</button>
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_ip-hotspot_user_profile" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">name</th>
                        <th class="text-nowrap">idle-timeout</th>
                        <th class="text-nowrap">keepalive-timeout</th>
                        <th class="text-nowrap">status-autorefresh</th>
                        <th class="text-nowrap">shared-users</th>
                        <th class="text-nowrap">rate-limit</th>
                        <th class="text-nowrap">transparent-proxy</th>
                        <th class="text-nowrap">validity</th>
                        <th class="text-nowrap">price</th>
                        <th class="text-nowrap">default</th>
                        <th class="text-nowrap">action</th>
                        <th class="text-nowrap">name</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_ip-hotspot_user_profile').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_ip/json_hotspot_user_profile/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }
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
                        $('td:eq(3)', row).addClass('text-right');
                        $('td:eq(4)', row).addClass('text-right');
                        $('td:eq(5)', row).addClass('text-right');
                        $('td:eq(6)', row).addClass('text-right');
                        $('td:eq(7)', row).addClass('text-right');
                        $('td:eq(8)', row).addClass('text-center');
                        $('td:eq(9)', row).addClass('text-right');
                        $('td:eq(10)', row).addClass('text-right');
                    }
                });
                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                    });
                });

                $(document).ready(function () {

                    $('#add-hotspot-user-profile-<?= $session_id ?>').on('click', function () {
                        $('#hotspot-user-profile-modal-<?= $session_id ?>').modal('show');
                        $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                        window['hotspot-user-profile-modal-<?= $session_id ?>'] = $.ajax({
                            url: "<?= site_url('mt_ip/modal_hotspot_user_profile') ?>/<?= $session_id ?>",
                                            success: function (data) {
                                                $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body').html(data);
                                            },
                                            error: function (xhr) {
                                                console.log(xhr);
                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                alert(msgError);
                                                $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body').html(msgError);
                                            }
                                        });
                                    });

                                    $('#hotspot-user-profile-modal-<?= $session_id ?>').on('hide.bs.modal', function (e) {
                                        window['hotspot-user-profile-modal-<?= $session_id ?>'].abort();
                                    });


                                    window['edit-hotspot-user-profile-<?= $session_id ?>'] = function (msid) {
                                        $('#hotspot-user-profile-modal-<?= $session_id ?>').modal('show');
                                        $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                                        window['hotspot-user-profile-modal-<?= $session_id ?>'] = $.ajax({
                                            url: "<?= site_url('mt_ip/modal_hotspot_user_profile') ?>/<?= $session_id ?>/edit",
                                            type: 'POST',
                                            data: {"msid": msid},
                                            success: function (data) {
                                                $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body').html(data);
                                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                            },
                                            error: function (xhr) {
                                                console.log(xhr);
                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                alert(msgError);
                                                $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body').html(msgError);
                                            }
                                        });
                                    }

                                    window['delete-hotspot-user-profile-<?= $session_id ?>'] = function (msid) {
                                        $('#hotspot-user-profile-modal-<?= $session_id ?>').modal('show');
                                        $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                                        window['hotspot-user-profile-modal-<?= $session_id ?>'] = $.ajax({
                                            url: "<?= site_url('mt_ip/delete_hotspot_user_profile') ?>/<?= $session_id ?>",
                                                            type: 'POST',
                                                            data: {"msid": msid},
                                                            success: function (data) {
                                                                $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body').html(data);
                                                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                                                            },
                                                            error: function (xhr) {
                                                                console.log(xhr);
                                                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                                                alert(msgError);
                                                                $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body').html(msgError);
                                                            }
                                                        });
                                                    }

                                                    $('#save-hotspot-user-profile-<?= $session_id ?>').on('click', function () {
        // validasi form.begin
                                                        if ($('#hotspot-user-profile-server').val() == '' || $('#hotspot-user-profile-server').val() == '*') {
                                                            alert('Please fill server!');
                                                            return false;
                                                        }
                                                        if ($('#hotspot-user-profile-profile').val() == '' || $('#hotspot-user-profile-profile').val() == '*') {
                                                            alert('Please fill profile!');
                                                            return false;
                                                        }
                                                        if ($('#hotspot-user-profile-name').val() == '') {
                                                            alert('Please fill name!');
                                                            return false;
                                                        }
        // validasi form.end

                                                        var formData = {
                                                            "hotspot_user_profile_id": $('#hotspot-user-profile-id').val(),
                                                            "hotspot_user_profile_name": $('#hotspot-user-profile-name').val(),
                                                            "hotspot_user_profile_address_pool": $('#hotspot-user-profile-address-pool').val(),
                                                            "hotspot_user_profile_shared_users": $('#hotspot-user-profile-shared-users').val(),
                                                            "hotspot_user_profile_rate_limit": $('#hotspot-user-profile-rate-limit').val(),
                                                            "hotspot_user_profile_open_status_page": $('#hotspot-user-profile-open-status-page').val(),
                                                            "hotspot_user_profile_transparent_proxy": $('#hotspot-user-profile-transparent-proxy').val(),
                                                            "hotspot_user_profile_comment": $('#hotspot-user-profile-comment').val(),
                                                            "hotspot_user_profile_validity": $('#hotspot-user-profile-validity').val(),
                                                            "hotspot_user_profile_price": $('#hotspot-user-profile-price').val()
                                                        //     "hotspot_user_profile_on_login": $('#hotspot-user-profile-on-login').val(),
                                                        //     "hotspot_user_profile_on_logout": $('#hotspot-user-profile-on-logout').val()
                                                        }
                                                        $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body .notifikasi').html(loadingBar);
                                                        window['save-hotspot-user-profile-modal-<?= $session_id ?>'] = $.ajax({
                                                            url: "<?= site_url('mt_ip/save_hotspot_user_profile') ?>/<?= $session_id ?>",
                                                                            type: 'POST',
                                                                            data: formData,
                                                                            success: function (data) {
                                                                                $('#hotspot-user-profile-modal-<?= $session_id ?> .modal-body .notifikasi').html(data);
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

        <!-- Modal Add Hotspot User Profile.begin -->
        <div class="modal fade" id="hotspot-user-profile-modal-<?= $session_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">
                            Hotspot User Profile
                        </h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="save-hotspot-user-profile-<?= $session_id ?>">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Add IP Hotspot User Profile.end -->
        <?php
    }

    public function json_hotspot_user_profile($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/ip/hotspot/user/profile/print');
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
            foreach ($array as $value):
                $row = array();
                $row[] = $no;
                $row[] = isset($value['.id']) ? $value['.id'] : '';
                $row[] = isset($value['name']) ? $value['name'] : '';
                $row[] = isset($value['idle-timeout']) ? $value['idle-timeout'] : '';
                $row[] = isset($value['keepalive-timeout']) ? $value['keepalive-timeout'] : '';
                $row[] = isset($value['status-autorefresh']) ? $value['status-autorefresh'] : '';
                $row[] = isset($value['shared-users']) ? $value['shared-users'] : '';
                $row[] = isset($value['rate-limit']) ? $value['rate-limit'] : '';
                $row[] = isset($value['transparent-proxy']) ? $this->rich_model->get_logic_label($value['transparent-proxy']) : '';
                $row[] = isset($value['on-login']) ? $this->rich_model->parse_validity($value['on-login'], 'validity') : '';
                $row[] = isset($value['on-login']) ? $this->rich_model->parse_validity($value['on-login'], 'price') : '';
                $row[] = isset($value['default']) ? $this->rich_model->get_logic_label($value['default']) : '';
                $row[] = '<button type="button" name="edit" onclick="window[\'edit-hotspot-user-profile-' . $session_id . '\'](\'' . $value['.id'] . '\')" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-pencil-square"></i> Edit</button>
<button type="button" name="delete"  onclick="if (confirm(\'Are you sure?\')) {
    window[\'delete-hotspot-user-profile-' . $session_id . '\'](\'' . $value['.id'] . '\')
}"  class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-close"></i> Del</button>';
                $row[] = isset($value['name']) ? $value['name'] : '';
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

    public function modal_hotspot_user_profile($session_id, $msid = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            $array_address_pool = $API->comm('/ip/pool/print');
//            $this->rich_model->debug_array($array_address_pool, true); // ($array, exit)

            $list_address_pool = !isset($array_address_pool['!trap']) ? $array_address_pool : array();

            if ($msid == "edit") {
                $msid = $this->input->post('msid');
                $array_user_profile = $API->comm('/ip/hotspot/user/profile/print', array(
                    "?.id" => $msid,
                ));
//                $this->rich_model->debug_array($array_user_profile, true); // ($array, exit)
                if (isset($array['!trap'])) {
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <?php
                        echo '<ul>';
                        foreach ($array_user_profile['!trap'][0] as $key => $val):
                            echo '<li>' . $key . ': <b>' . $val . '</b></li>';
                        endforeach;
                        echo '</ul>';
                        ?>
                    </div>
                    <?php
                    return false;
                }
                if (count($array_user_profile) == 0) {
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        Result not found!
                    </div>
                    <?php
                    return false;
                }
                $list_user_profile = !isset($array_user_profile['!trap']) ? count($array_user_profile) > 0 ? $array_user_profile[0] : array() : array();
//                $this->rich_model->debug_array($array_user_profile, true); // ($array, exit)
//                $this->rich_model->debug_array(preg_replace("/$|=/", ";\n", $list_user_profile['on-logout']), true); // ($array, exit)
            }
//            $this->rich_model->make_td_array($array[0], false, true); // ($array, th, exit)
            ?>
            <div class="notifikasi"></div>
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1_hotspot_user_profile-<?=$session_id?>" data-toggle="tab">Required</a></li>
                    <li><a href="#tab_2_hotspot_user_profile-<?=$session_id?>" data-toggle="tab">Advanced</a></li>
                    <!-- <li><a href="#tab_3" data-toggle="tab">Scripts</a></li> -->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1_hotspot_user_profile-<?=$session_id?>">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Name:</label>
                                <input type="hidden" class="form-control" id="hotspot-user-profile-id" placeholder="" value="<?= isset($list_user_profile['.id']) ? $list_user_profile['.id'] : '' ?>">
                                <input type="text" class="form-control" id="hotspot-user-profile-name" autocomplete="off" placeholder="" value="<?= isset($list_user_profile['name']) ? $list_user_profile['name'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Address Pool:</label>
                                <select class="form-control" id="hotspot-user-profile-address-pool">
                                    <!--<option value="*">-- Select Server --</option>-->
                                    <option value="none">none</option>
                                    <?php foreach ($list_address_pool as $value): ?>
                                        <option value="<?= $value['name'] ?>" <?= isset($list_user_profile['address-pool']) ? $value['name'] == $list_user_profile['address-pool'] ? 'selected' : '' : '' ?>><?= $value['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="control-label">Shared Users:</label>
                                <input type="text" class="form-control" id="hotspot-user-profile-shared-users" autocomplete="off" placeholder="" value="<?= isset($list_user_profile['shared-users']) ? $list_user_profile['shared-users'] : '1' ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Rate Limit (rx/tx):</label>
                                <input type="text" class="form-control" id="hotspot-user-profile-rate-limit" autocomplete="off" placeholder="" value="<?= isset($list_user_profile['rate-limit']) ? $list_user_profile['rate-limit'] : '' ?>">
                                <small class="help-block" id="help-session-list">example : 512k/1M</small>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="control-label">Open Status Page:</label>
                                <select class="form-control" id="hotspot-user-profile-open-status-page">
                                    <option value="always" <?= isset($list_user_profile['open-status-page']) ? 'always' == $list_user_profile['open-status-page'] ? 'selected' : '' : '' ?>>Always</option>
                                    <option value="http-login" <?= isset($list_user_profile['open-status-page']) ? 'http-login' == $list_user_profile['open-status-page'] ? 'selected' : '' : '' ?>>HTTP Login</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Transparent Proxy:</label>
                                <select class="form-control" id="hotspot-user-profile-transparent-proxy">
                                    <option value="yes" <?= isset($list_user_profile['transparent-proxy']) ? 'true' == $list_user_profile['transparent-proxy'] ? 'selected' : '' : '' ?>>Yes</option>
                                    <option value="no" <?= isset($list_user_profile['transparent-proxy']) ? 'false' == $list_user_profile['transparent-proxy'] ? 'selected' : '' : '' ?>>No</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2_hotspot_user_profile-<?=$session_id?>">
                        <form>
                            <div class="form-group">
                                <label class="control-label">Validity:</label>
                                <input type="text" class="form-control" id="hotspot-user-profile-validity" autocomplete="off" placeholder="" value="<?= isset($list_user_profile['on-login']) ? $this->rich_model->parse_validity($list_user_profile['on-login'], 'validity') : '' ?>">
                                <small class="help-block" id="help-session-list">example : 1w2d3h4m5s</small>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Price:</label>
                                <input type="number" class="form-control" id="hotspot-user-profile-price" autocomplete="off" placeholder="" value="<?= isset($list_user_profile['on-login']) ? $this->rich_model->parse_validity($list_user_profile['on-login'], 'price') : '' ?>" min="0">
                                <small class="help-block" id="help-session-list">example : 50000</small>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    <!-- <div class="tab-pane" id="tab_3">
                        <form>
                            <div class="form-group">
                                <label class="control-label">On Login:</label>
                                <textarea class="form-control" id="hotspot-user-profile-on-login" placeholder="" rows="5"><?= isset($list_user_profile['on-login']) ? preg_replace("/;/", ";\n", $list_user_profile['on-login']) : '' ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">On Logout:</label>
                                <textarea class="form-control" id="hotspot-user-profile-on-logout" placeholder="" rows="5"><?= isset($list_user_profile['on-logout']) ? preg_replace("/;/", ";\n", $list_user_profile['on-logout']) : '' ?></textarea>
                            </div>
                        </form>
                    </div> -->
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- Custom Tabs -->
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

    public function save_hotspot_user_profile($session_id) {
        $koneksi = $this->rich_model->get_session_by_id($session_id);

        $hotspot_user_profile_id = $this->input->post('hotspot_user_profile_id');
        $hotspot_user_profile_name = $this->input->post('hotspot_user_profile_name');
        $hotspot_user_profile_address_pool = $this->input->post('hotspot_user_profile_address_pool');
        $hotspot_user_profile_shared_users = $this->input->post('hotspot_user_profile_shared_users');
        $hotspot_user_profile_rate_limit = $this->input->post('hotspot_user_profile_rate_limit');
        $hotspot_user_profile_open_status_page = $this->input->post('hotspot_user_profile_open_status_page');
        $hotspot_user_profile_transparent_proxy = $this->input->post('hotspot_user_profile_transparent_proxy');
        $hotspot_user_profile_validity = $this->input->post('hotspot_user_profile_validity');
        $hotspot_user_profile_price = $this->input->post('hotspot_user_profile_price');
        // $hotspot_user_profile_on_login = $this->input->post('hotspot_user_profile_on_login');
        // $hotspot_user_profile_on_logout = $this->input->post('hotspot_user_profile_on_logout');

        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {

            if (isset($hotspot_user_profile_id) && $hotspot_user_profile_id != '') {
                // edit
                $API->write("/ip/hotspot/user/profile/set", false);
                $API->write("=.id=" . $hotspot_user_profile_id, false);
            } else {
                // add
                $API->write("/ip/hotspot/user/profile/add", false);
            }
            // required
            $API->write("=address-pool=" . $hotspot_user_profile_address_pool, false);
            $API->write("=open-status-page=" . $hotspot_user_profile_open_status_page, false);
            $API->write("=shared-users=" . $hotspot_user_profile_shared_users, false);
            $API->write("=rate-limit=" . $hotspot_user_profile_rate_limit, false);
            $API->write("=transparent-proxy=" . $hotspot_user_profile_transparent_proxy, false);

            // advanced
            $for_validity = ':put #' . $hotspot_user_profile_validity . '#' . $hotspot_user_profile_price . '#;';
            $for_validity .= ':local nama ($user);:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$hotspot_user_profile_validity.');:delay 5s;:local dirh ("hotspot");:local nmfile ("vex-$nama");:local path ("$dirh/$nmfile");';
            $for_validity .= '{';
            $for_validity .= '/system scheduler add comment="mikrostator" disabled=no interval=$uptime name=$nama on-event="[/ip hotspot user set limit-uptime=1s [find where name=$nama]];[/ip hotspot active remove [find where user=$nama]];[/system scheduler remove [find where name=$nama]];[/file remove $path.txt]" start-date=$date start-time=$time;';
            $for_validity .= ':local year [:pick $date 7 11];:local month [:pick $date 0 3];/system script add name="$nama" source=":put #$date#$time#$nama#' . $hotspot_user_profile_validity . '#' . $hotspot_user_profile_price . '#$address#$"mac-address"###voucher#;" owner="$year-$month" comment="report_mikrostator";';
            $for_validity .= ':local expired ([/system scheduler get [find where name=$nama]]->"next-run");:delay 5s;/file print file=$path;:delay 5s;/file set "$path.txt" contents=$expired;';
            $for_validity .= '}';
            $API->write("=on-login=" . $for_validity, false);

            
            // scripts
            // $hotspot_user_profile_on_login != '' ? $API->write("=on-login=" . preg_replace("/\r|\n/", "", $hotspot_user_profile_on_login), false) : NULL;
            // $hotspot_user_profile_on_logout != '' ? $API->write("=on-logout=" . preg_replace("/\r|\n/", "", $hotspot_user_profile_on_logout), false) : NULL;

            // prolog
            $API->write("=name=" . $hotspot_user_profile_name);
            $array = $API->read();

//                $this->rich_model->debug_array($array, true);

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

            /*
             * ********************************************************
             *  untuk add dan edit tidak perlu validasi jumlah array
             * ********************************************************
             */
//                if (count($array) == 0) {
//                    
            ?>
            <!--                    <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    Result not found!
                                </div>-->
            <?php
//                    return false;
//                }
            ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Done!</h4>
                Data saved!
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

    public function delete_hotspot_user_profile($session_id) {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $msid = $this->input->post('msid');

        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            $API->write("/ip/hotspot/user/profile/remove", false);
            $API->write("=.id=" . $msid);
            $array = $API->read();

//                $this->rich_model->debug_array($array, true);

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
            ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Done!</h4>
                Data deleted!
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

    /*
     * **************************************************************************
     * hotspot user profile.end
     * **************************************************************************
     */
    
    
    /*
     * *************************************
     * dns cache.begin
     * *************************************
     */

    public function dns_cache($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_ip-dns_cache" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">name</th>
                        <th class="text-nowrap">address</th>
                        <th class="text-nowrap">ttl</th>
                        <th class="text-nowrap">static</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_ip-dns_cache').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_ip/json_dns_cache/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }
                            return json.data;
                        }
                    },
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    order: [[0, "desc"]],
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
                        $('td:eq(4)', row).addClass('text-right');
                        $('td:eq(5)', row).addClass('text-center');
                    }
                });
                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                    });
                });
            </script>
        </div>
        <?php
    }

    public function json_dns_cache($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/ip/dns/cache/print');
//            $this->rich_model->debug_array($array, true);
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
            foreach ($array as $value):
                $row = array();
                $row[] = $no;
                $row[] = isset($value['.id']) ? $value['.id'] : '';
                $row[] = isset($value['name']) ? $value['name'] : '';
                $row[] = isset($value['address']) ? $value['address'] : '';
                $row[] = isset($value['ttl']) ? $value['ttl'] : '';
                $row[] = isset($value['static']) ? $this->rich_model->get_logic_label($value['static']) : '';
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

    /*
     * **************************************************************************
     * dns cache.end
     * **************************************************************************
     */
    
    
    
    
    /*
     * *************************************
     * dhcp server lease.begin
     * *************************************
     */

    public function dhcp_server_lease($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_ip-dhcp_server_lease" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">address</th>
                        <th class="text-nowrap">mac-address</th>
                        <th class="text-nowrap">client-id</th>
                        <th class="text-nowrap">address-lists</th>
                        <th class="text-nowrap">server</th>
                        <th class="text-nowrap">dhcp-option</th>
                        <th class="text-nowrap">status</th>
                        <th class="text-nowrap">expires-after</th>
                        <th class="text-nowrap">last-seen</th>
                        <th class="text-nowrap">active-address</th>
                        <th class="text-nowrap">active-mac-address</th>
                        <th class="text-nowrap">active-client-id</th>
                        <th class="text-nowrap">active-server</th>
                        <th class="text-nowrap">host-name</th>
                        <th class="text-nowrap">radius</th>
                        <th class="text-nowrap">dynamic</th>
                        <th class="text-nowrap">blocked</th>
                        <th class="text-nowrap">disabled</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_ip-dhcp_server_lease').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_ip/json_dhcp_server_lease/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }
                            return json.data;
                        }
                    },
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    order: [[0, "desc"]],
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
                        $('td:eq(9)', row).addClass('text-right');
                        $('td:eq(10)', row).addClass('text-right');
                        $('td:eq(16)', row).addClass('text-center');
                        $('td:eq(17)', row).addClass('text-center');
                        $('td:eq(18)', row).addClass('text-center');
                        $('td:eq(19)', row).addClass('text-center');
                    }
                });
                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                    });
                });
            </script>
        </div>
        <?php
    }

    public function json_dhcp_server_lease($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/ip/dhcp-server/lease/print');
//            $this->rich_model->debug_array($array, true);
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
            foreach ($array as $value):
                $row = array();
                $row[] = $no;
                $row[] = isset($value['.id']) ? $value['.id'] : '';
                $row[] = isset($value['address']) ? $value['address'] : '';
                $row[] = isset($value['mac-address']) ? $value['mac-address'] : '';
                $row[] = isset($value['client-id']) ? $value['client-id'] : '';
                $row[] = isset($value['address-lists']) ? $value['address-lists'] : '';
                $row[] = isset($value['address']) ? $value['address'] : '';
                $row[] = isset($value['server']) ? $value['server'] : '';
                $row[] = isset($value['dhcp-option']) ? $value['dhcp-option'] : '';
                $row[] = isset($value['expires-after']) ? $value['expires-after'] : '';
                $row[] = isset($value['last-seen']) ? $value['last-seen'] : '';
                $row[] = isset($value['active-address']) ? $value['active-address'] : '';
                $row[] = isset($value['active-mac-address']) ? $value['active-mac-address'] : '';
                $row[] = isset($value['active-client-id']) ? $value['active-client-id'] : '';
                $row[] = isset($value['active-server']) ? $value['active-server'] : '';
                $row[] = isset($value['host-name']) ? $value['host-name'] : '';
                $row[] = isset($value['radius']) ? $this->rich_model->get_logic_label($value['radius']) : '';
                $row[] = isset($value['dynamic']) ? $this->rich_model->get_logic_label($value['dynamic']) : '';
                $row[] = isset($value['blocked']) ? $this->rich_model->get_logic_label($value['blocked']) : '';
                $row[] = isset($value['disabled']) ? $this->rich_model->get_logic_label($value['disabled']) : '';
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

    /*
     * **************************************************************************
     * dhcp server lease.end
     * **************************************************************************
     */


}
