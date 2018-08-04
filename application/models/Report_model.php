<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {
    
    public function get_selling($session_id, $cmd = "") {
        ?>
        <div id="report_selling_notifikasi-<?= $session_id ?>"></div>
        <p>
            <label>Periode:</label>
            <select id="mt_report-selling_periode" class="form-control"></select>
        </p>
        <p class="text-right">
            <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
            <span class="btn-group">
                <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-flat btn-xs"><i class="fa fa-refresh"></i> Reload Data</button>
                <button id="cari-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-filter"></i> Filter</button>
                <button id="reset-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-warning btn-flat btn-xs" style="display:none" ><i class="fa fa-eye"></i> Reset</button>
            </span>
        </p>
        <div class="table-responsive">
            <table id="mt_report-selling-<?= $session_id ?>" class="table table-bordered table-striped table-condensed table-hover" border="1">
                <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">date</th>
                        <th class="text-nowrap">time</th>
                        <th class="text-nowrap">name</th>
                        <th class="text-nowrap">validity</th>
                        <th class="text-nowrap bg-success">price</th>
                        <th class="text-nowrap">ip</th>
                        <th class="text-nowrap">mac</th>
                        <th class="text-nowrap">host</th>
                        <th class="text-nowrap">notes</th>
                        <th class="text-nowrap">periode</th>
                        <th class="text-nowrap">type</th>
                        <th class="text-nowrap">aksi</th>
                        <th class="text-nowrap">name</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap text-right bg-success">0</th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                        <th class="text-nowrap"></th>
                    </tr>
                </tfoot>
            </table>

            <script>
                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_report-selling-<?= $session_id ?>').DataTable({
                    ajax: {
                        url: "<?= site_url('mt_report/json_selling/' . $session_id . '/' . $cmd) ?>",
                        dataSrc: function (json) {
                            console.log(json);
                            $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').removeClass('fa-spin');
                            if (json.error_msg != "") {
                                $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(json.error_msg);
                            }

                            var listPeriode = [];
                            $('#mt_report-selling_periode option').remove();
                            $('#mt_report-selling_periode').append('<option value="*">all</option>');
                            json.data.forEach(function (entry) {
                                listPeriode.push(entry[10]);
                                // console.log(entry[10]);
                            });

                            listPeriode.filter(onlyUnique).sort().forEach(function (list) {
                                $('#mt_report-selling_periode').append('<option value="' + list + '">' + list + '</option>');
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
                        $('td:eq(1)', row).addClass('text-right');
                        $('td:eq(2)', row).addClass('text-right');
                        $('td:eq(4)', row).addClass('text-right');
                        $('td:eq(5)', row).addClass('text-right bg-success');
                        $('td:eq(6)', row).addClass('text-right');
                        $('td:eq(7)', row).addClass('text-right');
                        $('td:eq(8)', row).addClass('text-right');
                        $('td:eq(10)', row).addClass('text-right');
                    },
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;
                        var totalPrice;

                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$.]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                
                        // Total Price.begin
                        totalPrice = api
                            .column( 5, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        // Update footer
                        $( api.column( 5 ).footer() ).html(
                            totalPrice
                        );
                        // Total Price.end
                            
                    }
                });

                $('#cari-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                    $('#cari-data-<?= $session_id ?>-<?= $cmd ?>').hide();
                    $('#reset-data-<?= $session_id ?>-<?= $cmd ?>').show();
                    $('#mt_report-selling-<?= $session_id ?> tfoot th').each(function () {
                        var title = $(this).text();
                        $(this).html('<input type="text" placeholder="filter  ' + title + '" />');
                    });
                    window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].columns().every(function () {
                        var that = this;
                        $('input', this.footer()).on('keyup change', function () {
                            if (that.search() !== this.value) {
                                that
                                        .search(this.value)
                                        .draw();
                            }
                        });
                    });
                });

                $('#reset-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                    $('#cari-data-<?= $session_id ?>-<?= $cmd ?>').show();
                    $('#reset-data-<?= $session_id ?>-<?= $cmd ?>').hide();
                    var i = 0;
                    $('#mt_report-selling-<?= $session_id ?> tfoot th').each(function () {
                        // $(this).html($('#mt_report-selling-<?= $session_id ?>  thead th')[i].innerHTML);
                        $(this).html('&nbsp;');
                        i++;
                    });
                    window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].columns().search("").draw();
                });

                $(function () {
                    $('#reload-data-<?= $session_id ?>-<?= $cmd ?>').on('click', function () {
                        $('#reload-data-<?= $session_id ?>-<?= $cmd ?> i').addClass('fa-spin');
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html('');
                        window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                    });

                     $('#mt_report-selling_periode').on('change', function () {
                        if (this.value == '*') {
                            window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].columns(10).search('').draw();
                        } else {
                            window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].columns(10).search(this.value).draw();
                        }
                        var countData = window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].page.info().recordsDisplay;
                        $('#msg-error-<?= $session_id ?>-<?= $cmd ?>').html(countData + ' Data(s)');
                    });
                    
                });

                window['delete_report_selling-<?= $session_id ?>'] = function (msid) {
                    $('#report_selling_notifikasi-<?= $session_id ?>').html(loadingBar);
                    var msids = [];
                    msids.push(msid);
                    window['report_selling_notifikasi-<?= $session_id ?>'] = $.ajax({
                        url: "<?= site_url('mt_report/delete_report_selling') ?>/<?= $session_id ?>",
                        type: 'POST',
                        data: {"msids": msids},
                        success: function (data) {
                            $('#report_selling_notifikasi-<?= $session_id ?>').html(data);
                            window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                            alert(msgError);
                            $('#report_selling_notifikasi-<?= $session_id ?>').html(msgError);
                        }
                    });
                }
            </script>
        </div>
        <?php

    }
        
}
