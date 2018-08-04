<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mt_log extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('rich_model');
    }

    // log.begin
    public function index($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_log-index" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">time</th>
                        <th class="text-nowrap">topics</th>
                        <th class="text-nowrap">message</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_log-index').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_log/json_index/' . $session_id . '/' . $cmd) ?>",
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
                        $('td:eq(3)', row).text().includes('error')?$('td', row).css({'color': 'red'}):null;
                        $('td:eq(3)', row).text().includes('warning')?$('td', row).css({'color': 'blue'}):null;
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

    public function json_index($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/log/print');
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
                $row[] = isset($value['time']) ? $value['time'] : '';
                $row[] = isset($value['topics']) ? $value['topics'] : '';
                $row[] = isset($value['message']) ? $value['message'] : '';
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
    // log.end

    // log_access.begin
    public function access($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_log-access" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">time</th>
                        <th class="text-nowrap">topics</th>
                        <th class="text-nowrap">message</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_log-access').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_log/json_access/' . $session_id . '/' . $cmd) ?>",
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
                        $('td:eq(3)', row).text().includes('error')?$('td', row).css({'color': 'red'}):null;
                        $('td:eq(3)', row).text().includes('warning')?$('td', row).css({'color': 'blue'}):null;
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

    public function json_access($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/log/print', array(
                "?topics" => "web-proxy, account"));
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
                $row[] = isset($value['time']) ? $value['time'] : '';
                $row[] = isset($value['topics']) ? $value['topics'] : '';
                $row[] = isset($value['message']) ? $value['message'] : '';
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
    // log_access.end

    // log_hotspot.begin
    public function hotspot($session_id, $cmd = "") {
        ?>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
        </p>
        <div class="table-responsive">
            <table id="mt_log-hotspot" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">time</th>
                        <th class="text-nowrap">topics</th>
                        <th class="text-nowrap">message</th>
                    </tr>
                </thead>
            </table>
            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_log-hotspot').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_log/json_hotspot/' . $session_id . '/' . $cmd) ?>",
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
                        $('td:eq(3)', row).text().includes('error')?$('td', row).css({'color': 'red'}):null;
                        $('td:eq(3)', row).text().includes('warning')?$('td', row).css({'color': 'blue'}):null;
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

    public function json_hotspot($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        $output = array("data" => array());
        if ($API->konek($koneksi)) {
            $array = $API->comm('/log/print', array(
                "?topics" => "hotspot,info,debug"));
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
                $row[] = isset($value['time']) ? $value['time'] : '';
                $row[] = isset($value['topics']) ? $value['topics'] : '';
                $row[] = isset($value['message']) ? $value['message'] : '';
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
    // log_access.end
}
