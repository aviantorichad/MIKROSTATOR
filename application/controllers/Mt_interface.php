<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Mt_interface extends Admin_Controller
	{
		
		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set('Asia/Jakarta');
			
			$this->load->model('rich_model');
		}
		
		// interface.begin
		public function index($session_id, $cmd = "")
		{
			?>
            <p class="text-right">
                <span id="msg-error-<?= $session_id ?>-<?= $cmd ?>" class="label label-danger"></span>
                <button id="reload-data-<?= $session_id ?>-<?= $cmd ?>" class="btn btn-default btn-xs"><i
                            class="fa fa-refresh"></i> Reload Data
                </button>
            </p>
            <div class="table-responsive">
                <table id="mt_interface-index" class="table table-bordered table-striped table-condensed table-hover"
                       border="1">
                    <thead>
                    <tr>
                        <th class="text-nowrap">no.</th>
                        <th class="text-nowrap">.id</th>
                        <th class="text-nowrap">nama</th>
                        <th class="text-nowrap">status</th>
                        <th class="text-nowrap">type</th>
                        <th class="text-nowrap">rx-byte</th>
                        <th class="text-nowrap">tx-byte</th>
                        <th class="text-nowrap">action</th>
                    </tr>
                    </thead>
                </table>
                <script>
                    window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'] = $('#mt_interface-index').DataTable({
                        ajax: {
                            url: "<?= site_url('mt_interface/json_index/' . $session_id . '/' . $cmd) ?>",
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

                    window['autoRefreshInterval-<?= $session_id ?>-<?= $cmd ?>'] = function (ms) {
                        window['interval-<?= $session_id ?>-<?= $cmd ?>'] = setInterval(function () {
                            if ($('#autorefresh-<?= $session_id ?>-<?= $cmd ?>').prop('checked')) {
                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                            } else {
                                clearInterval(window['interval-<?= $session_id ?>-<?= $cmd ?>']);
                            }
                        }, ms);
                    };
                    window['action-interface-<?= $session_id ?>'] = function (msid) {
                        $('#ethernet-modal-<?= $session_id ?>').modal('show');
                        $('#ethernet-modal-<?= $session_id ?> .modal-body').html(loadingBar);
                        window['ethernet-modal-<?= $session_id ?>'] = $.ajax({
                            url: "<?= site_url('mt_interface/interface_action') ?>/<?= $session_id ?>",
                            type: 'POST',
                            data: {"msid": msid},
                            success: function (data) {
                                $('#ethernet-modal-<?= $session_id ?> .modal-body').html(data);
                                window['myDatatable-<?= $session_id ?>-<?= $cmd ?>'].ajax.reload(null, false);
                            },
                            error: function (xhr) {
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#ethernet-modal-<?= $session_id ?> .modal-body').html(msgError);
                            }
                        });
                    }
                </script>
            </div>

            <!-- Modal Add Hotspot Active.begin -->
            <div class="modal fade" id="ethernet-modal-<?= $session_id ?>" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">
                                Ethernet
                            </h4>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Add IP Hotspot Active.end -->
			
			<?php
		}
		
		public function json_index($session_id, $cmd = "")
		{
			$koneksi = $this->rich_model->get_session_by_id($session_id);
			$API = new $this->mikrostator();
			$output = array("data" => array());
			if ($API->konek($koneksi)) {
				$array = $API->comm('/interface/print');
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
				
				$no = 1;
				foreach ($array as $value):
					$row = array();
					$row[] = $no;
					$row[] = isset($value['.id']) ? $value['.id'] : '';
					$row[] = isset($value['name']) ? $value['name'] : '';
					$row[] = isset($value['running']) ? $this->rich_model->get_logic_label($value['running']) : '';
					$row[] = isset($value['type']) ? $value['type'] : '';
					$row[] = isset($value['rx-byte']) ? $this->rich_model->formatBytes($value['rx-byte']) : '';
					$row[] = isset($value['tx-byte']) ? $this->rich_model->formatBytes($value['tx-byte']) : '';
					$sent = $value['running'] . "," . $value['.id'];
					if ($value['running'] == "true") {
						$act = '<button type="button" name="delete"  onclick="if (confirm(\'Are you sure?\')) {
                                window[\'action-interface-' . $session_id . '\'](\'' . $sent . '\')
                            }"  class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-close"></i> Dis</button>';
					} else {
						$act = '<button type="button" name="delete"  onclick="if (confirm(\'Are you sure?\')) {
                                window[\'action-interface-' . $session_id . '\'](\'' . $sent . '\')
                            }"  class="btn btn-success btn-xs" title="Delete"><i class="fa fa-close"></i> Ena</button>';
					}
					
					$row[] = $act;
					
					
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
		
		public function interface_action($session_id)
		{
			$koneksi = $this->rich_model->get_session_by_id($session_id);
			$msid = $this->input->post('msid');
			$str_arr = explode (",", $msid);
			$API = new $this->mikrostator();
			if ($API->konek($koneksi)) {
				if ($str_arr[0] == "true") {
					$API->write("/interface/ethernet/disable", false);
					$API->write("=.id=" . $str_arr[1], true);
				} else {
					$API->write("/interface/ethernet/enable", false);
					$API->write("=.id=" . $str_arr[1], true);
				}
				
				$array = $API->read();
				//$this->rich_model->debug_array($array, true);
				
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
		
		// interface.end
		
	}
