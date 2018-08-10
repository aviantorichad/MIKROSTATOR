
<script>
    $(document).ready(function () {
        loadingBar = '<div class="alert bg-gray"><i class="fa fa-refresh fa-spin"></i> loading...</div>';
        // $(document).ajaxStart(function () {
        //     Pace.restart();
        // });

        // autoload.begin
        autoLoad();
        // autoload.end

        /* 
         * **********************************
         * event menu.begin
         * **********************************
         */
        $('#menu-session-detail').on('click', function () {
            // alert($('#select-session').val());
            var itemValue = $('#select-session').val();
            var itemText = $('#select-session :selected').text();
            if (validateSession(itemValue)) {
                reqAjax = $.ajax({
                    url: "<?= site_url('home/session_id') ?>/" + itemValue + "/" + true,
                    success: function (data) {
                        if (data == "") {
                            alert('Session not found!\nRefresh your browser now!');
                            return false;
                        }
                        var objData = JSON.parse(data);
                        var formatData = '';
                        formatData = '<ul>\n\
                                        <li>Name: <b>' + objData.mikrotik_name + '</b></li>\n\
                                        <li>Host: <b>' + objData.mikrotik_host + '</b></li>\n\
                                        <li>Port: <b>' + objData.mikrotik_port + '</b></li>\n\
                                        <li>Username: <b>' + objData.mikrotik_username + '</b></li>\n\
                                        <li>Password: <b>' + objData.mikrotik_password + '</b></li>\n\
                                    </ul>'

                        $('#session-detail-modal').modal('show');
                        $('#session-detail-modal .modal-header small').html(itemText);
                        $('#session-detail-modal .modal-body').html(formatData);
                    },
                    error: function (xhr) {
                        console.log(xhr);
                        var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                        alert(msgError);
                    }
                });
            }
        });

        $('#menu-about').on('click', function () {
            $('#about-modal').modal('show');
        });

        $('#menu-system-resource').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-system-resource');
        });

        $('#menu-hotspot-server').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-hotspot-server');
        });

        $('#menu-hotspot-server-profile').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-hotspot-server-profile');
        });

        $('#menu-hotspot-user').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-hotspot-user');
        });

        $('#menu-hotspot-user-profile').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-hotspot-user-profile');
        });

        $('#menu-hotspot-active').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-hotspot-active');
        });

        $('#menu-hotspot-host').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-hotspot-host');
        });

        $('#menu-hotspot-ip-binding').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-hotspot-ip-binding');
        });

        $('#menu-log').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-log');
        });

        $('#menu-log-hotspot').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-log-hotspot');
        });

        $('#menu-log-access').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-log-access');
        });

        $('#menu-report-selling').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-report-selling');
        });

        $('#menu-ping').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-ping');
        });

        $('#menu-form-billing').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-form-billing');
        });

        $('#menu-form-billing-n-report').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-form-billing-n-report');
        });

        $('#menu-form-billing-add-user-hotspot').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-hotspot-user');
        });

        $('#menu-voucher-list').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-voucher-list');
        });

        $('#menu-voucher-profile').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-hotspot-user-profile');
        });

        $('#menu-dns-cache').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-dns-cache');
        });

        $('#menu-dhcp-server-lease').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-dhcp-server-lease');
        });

        $('#menu-system-administrator').on('click', function () {
            var itemValue = $('#select-session').val();
            var itemText = $('#select-session :selected').text();
            if (validateSession(itemValue)) {
                reqAjax = $.ajax({
                    url: "<?= site_url('home/session_id') ?>/" + itemValue + "/" + true,
                    success: function (data) {
                        if (data == "") {
                            alert('Session not found!\nRefresh your browser now!');
                            return false;
                        }
                        var objData = JSON.parse(data);
                        var formatData = '';
                        formatData = '<center><button id="reboot-' + itemValue + '" class="btn btn-lg btn-warning" onclick="mikrotikReboot(' + itemValue + ')"><i class="fa fa-gear"></i> Reboot</button>\n\
                                <button id="shutdown-' + itemValue + '" class="btn btn-lg btn-danger" onclick="mikrotikShutdown(' + itemValue + ')"><i class="fa fa-power-off"></i> Shutdown</button></center>'

                        $('#system-administrator-modal').modal('show');
                        $('#system-administrator-modal .modal-header small').html(itemText);
                        $('#system-administrator-modal .modal-body').html(formatData);
                    },
                    error: function (xhr) {
                        console.log(xhr);
                        var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                        alert(msgError);
                    }
                });
            }
        });

        $('#menu-update-list').on('click', function () {
            updateSelectSessionLists();
        });

        $('#menu-append-section').on('click', function () {
            addSection();
        });

        $('#menu-dashboard').on('click', function () {
            var menuName = $(this).text();
            addSection(menuName, 'menu-dashboard');
        });
        // event menu.end

        /* 
         * **********************************
         * event menu.end
         * **********************************
         */


        //event modal.begin
        $('#add-session-modal').on('show.bs.modal', function (e) {
            var d = new Date();
            var cd = d.getFullYear() + '' + eval(d.getMonth() + 1) + '' + d.getDate() + '' + d.getHours() + '' + d.getMinutes() + '' + d.getSeconds();
            $('#session-id').val(cd);
        });

        $('#reload-session-list').on('click', function () {
            $('#help-session-list').html('loading...');
            reqAjax = $.ajax({
                // url: "<?= site_url('home/get_session_logins') ?>",
                url: "<?= site_url('home/get_session_logins_from_file') ?>",
                type: 'POST',
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (!obj.ok) {
                        alert(obj.msg);

                        $('#help-session-list').html(obj.msg);
                        return false;
                    }

                    $('#session-list option').remove();
                    $('#session-list')
                            .append($("<option></option>")
                                    .attr("value", '*')
                                    .text('-- Select Mikrotik --'));
                    $.each(obj.msg, function (key, value) {
                        $('#session-list')
                                .append($("<option></option>")
                                        .attr("value", value.id)
                                        .text(value.mikrotik_name));
                    });

                    $('#help-session-list').html('#uptodate');
//                    
                },
                error: function (xhr) {
                    console.log(xhr);
                    var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                    alert(msgError);
                }
            });
        });

        $('#session-list').on('change', function () {
            if ($('#session-list').val() == '*' || $('#session-list').val() == '') {
                return false;
            }
            reqAjax = $.ajax({
                url: "<?= site_url('home/is_security_mikrotik_from_file') ?>",
                type: 'POST',
                data: {'id': $('#session-list').val()},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (!obj.ok) {
                        alert(obj.msg);
                        return false;
                    }
                    if (obj.msg == 'pin') {
                        // $('#add-session-modal')
                        //         .find("input,textarea")
                        //         .val('')
                        //         .end()
                        //         .find("input[type=checkbox], input[type=radio]")
                        //         .prop("checked", "")
                        //         .end();
                        $('#mikrotik-name').val('');
                        $('#mikrotik-host').val('');
                        $('#mikrotik-port').val('');
                        $('#mikrotik-username').val('');
                        $('#mikrotik-password').val('');
                        $('#show-mikrotik-password').prop("checked", "");
                        $('#mikrotik-pin').val('');
                        var pin = prompt("Please enter your PIN", "");

                        if (pin != null || pin != "" || typeof pin != 'undefined') {
                            reqAjax = $.ajax({
                                url: "<?= site_url('home/check_security_mikrotik_from_file') ?>",
                                type: 'POST',
                                data: {
                                    'id': $('#session-list').val(),
                                    'pin': pin
                                },
                                success: function (data) {
                                    var obj = JSON.parse(data);
                                    if (!obj.ok) {
                                        // $('#session-list').val('*'); //agar bisa dihapus jika lupa PIN
                                        alert(obj.msg);
                                        return false;
                                    }
                                    $('#mikrotik-name').val(obj.msg.mikrotik_name);
                                    $('#mikrotik-host').val(obj.msg.mikrotik_host);
                                    $('#mikrotik-port').val(obj.msg.mikrotik_port);
                                    $('#mikrotik-username').val(obj.msg.mikrotik_username);
                                    $('#mikrotik-password').val(obj.msg.mikrotik_password);
                                    $('#security-pin').val(obj.msg.pin);
                                },
                                error: function (xhr) {
                                    $('#session-list').val('*');
                                    console.log(xhr);
                                    var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                    alert(msgError);
                                }
                            });
                        }
                        return false;
                    } else {
                        useSession();
                    }

                },
                error: function (xhr) {
                    console.log(xhr);
                    var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                    alert(msgError);
                }
            });
        });
        
        function useSession() {
            reqAjax = $.ajax({
                url: "<?= site_url('home/get_session_login_by_id_from_file') ?>",
                type: 'POST',
                data: {'id': $('#session-list').val()},
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (!obj.ok) {
                        alert(obj.msg);
                        return false;
                    }
                    $('#mikrotik-name').val(obj.msg.mikrotik_name);
                    $('#mikrotik-host').val(obj.msg.mikrotik_host);
                    $('#mikrotik-port').val(obj.msg.mikrotik_port);
                    $('#mikrotik-username').val(obj.msg.mikrotik_username);
                    $('#mikrotik-password').val(obj.msg.mikrotik_password);
                    $('#security-pin').val(obj.msg.pin);
                },
                error: function (xhr) {
                    console.log(xhr);
                    var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                    alert(msgError);
                }
            });
        }

        $('#del-new-session').on('click', function () {
            if ($('#session-list').val() == '*' || $('#session-list').val() == '' || $('#session-list').val() == null) {
                alert('No seleted session');
                return false;
            }
            if (confirm('Are you sure?')) {
                reqAjax = $.ajax({
                    url: "<?= site_url('home/del_session_list_by_id_from_file') ?>",
                    type: 'POST',
                    data: {'id': $('#session-list').val()},
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (obj.ok) {
                            alert(obj.msg);
                            $('#session-list option').remove();
                            $('#session-list')
                                    .append($("<option></option>")
                                            .attr("value", '*')
                                            .text('-- Select Mikrotik --'));
                            $('#mikrotik-name').val('');
                            $('#mikrotik-host').val('');
                            $('#mikrotik-port').val('');
                            $('#mikrotik-username').val('');
                            $('#mikrotik-password').val('');
                            $('#help-session-list').html('please reload...');
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
            }
        });

        $('#save-new-session').on('click', function () {
            if($('#mikrotik-name').val() == ""){
                alert('Please fill Session Name');
                return false;
            }
            if($('#mikrotik-host').val() == ""){
                alert('Please fill Host Mikrotik');
                return false;
            }
            if($('#mikrotik-port').val() == ""){
                alert('Please fill Port Mikrotik');
                return false;
            }
            if($('#mikrotik-username').val() == ""){
                alert('Please fill username Mikrotik');
                return false;
            }

            var formData = {
                "session_id": $('#session-id').val(),
                "mikrotik_name": $('#mikrotik-name').val(),
                "mikrotik_host": $('#mikrotik-host').val(),
                "mikrotik_port": $('#mikrotik-port').val(),
                "mikrotik_username": $('#mikrotik-username').val(),
                "mikrotik_password": $('#mikrotik-password').val(),
                "security_pin": $('#security-pin').val()
            }
            reqAjax = $.ajax({
                url: "<?= site_url('home/save_session_to_file') ?>",
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

        $('#connect-new-session').on('click', function () {
            var formData = {
                "session_id": $('#session-id').val(),
                "mikrotik_name": $('#mikrotik-name').val(),
                "mikrotik_host": $('#mikrotik-host').val(),
                "mikrotik_port": $('#mikrotik-port').val(),
                "mikrotik_username": $('#mikrotik-username').val(),
                "mikrotik_password": $('#mikrotik-password').val()
            }
            reqAjax = $.ajax({
                url: "<?= site_url('home/insert_session') ?>",
                type: 'POST',
                data: formData,
                success: function (data) {
//                    $('#select-session').remove('option'); //remove all option
                    $('#add-session-modal').modal('hide');
                    $('#add-session-modal')
                            .find("input,textarea,select")
                            .val('')
                            .end()
                            .find("input[type=checkbox], input[type=radio]")
                            .prop("checked", "")
                            .end();
                    updateSelectSessionLists();
                },
                error: function (xhr) {
                    console.log(xhr);
                    var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                    alert(msgError);
                }
            });
        });

        $('#logout-one').on('click', function () {
            if (confirm('Are you sure?\nSelected Session will be deleted!')) {
                var itemValue = $('#select-session').val();
                if (validateSession(itemValue)) {
                    reqAjax = $.ajax({
                        url: "<?= site_url('home/logout_one') ?>/" + itemValue,
                        async: false,
                        success: function (data) {
                            var obj = JSON.parse(data);
                            if (!obj.ok) {
                                alert(obj.msg);
                                return false;
                            }

                            alert(obj.msg);
                            updateSelectSessionLists();
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                            alert(msgError);
                        }
                    });
                }
            }
        });

        $('#logout').on('click', function () {
            if (confirm('Are you sure?\nAll Sessions will be deleted!')) {
                reqAjax = $.ajax({
                    url: "<?= site_url('home/logout') ?>",
                    async: false,
                    success: function (data) {
                        var obj = JSON.parse(data);
                        if (!obj.ok) {
                            alert(obj.msg);
                            return false;
                        }

                        alert(obj.msg);
                        updateSelectSessionLists();
                    },
                    error: function (xhr) {
                        console.log(xhr);
                        var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                        alert(msgError);
                    }
                });
            }
        });


        // kumpulan function.begin

        function autoLoad() {
            updateSelectSessionLists();
            setInterval(jamku, 1000);
        }

        var itemValue = "";
        function validateSession(itemValue) {
            if (itemValue == "*") {
                alert("Please select Session!");
                return false;
            }
            return true;
        }

        function isEmptySection(idSection) {
            if ($(idSection).length > 0) {
                alert("Application has opened!");
                return false;
            }
            return true;
        }

        function updateSelectSessionLists() {
            reqAjax = $.ajax({
                url: "<?= site_url('home/sessions') ?>",
                success: function (data) {
                    $('#select-session').empty();
                    $('#select-session').append(data);
                },
                error: function (xhr) {
                    console.log(xhr);
                    var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                    alert(msgError);
                }
            });
        }


        /* 
         * **********************************
         * section.begin
         * **********************************
         */
        function addSection(menuName, cmd) {
            var itemValue = $('#select-session').val();
            var itemText = $('#select-session :selected').text();
            if (validateSession(itemValue)) {
                if (isEmptySection('#mikrostator-box-' + itemValue + '-' + cmd)) {
                    reqAjax = $.ajax({
                        url: "<?= site_url('home/insert_section') ?>/" + itemValue + "/" + cmd,
                        success: function (data) {
                            if (data == "") {
                                alert('Session not found!\nRefresh your browser now!');
                                return false;
                            }
                            if($('#app_multiview').prop('checked')){
                                $('#mikrostator-section').prepend(data);
                            } else {
                                $('#mikrostator-section').html(data);
                            }
                            $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-header h3').html(menuName);
                            $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-header small').html(itemText);
                            runCmdMikrotik(itemValue, cmd);
                        },
                        error: function (xhr) {
                            console.log(xhr);
                            var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                            alert(msgError);
                        }
                    });
                }
            }
        }

        /* 
         * **********************************
         * section.end
         * **********************************
         */



        /* 
         * **********************************
         * application mikrotik.begin
         * 
         * ref: 
         * -> untuk membuat variable ajax dinamis: https://www.sitepoint.com/community/t/dynamic-i-variable-names-in-javascript/4236/13
         * **********************************
         */
        function runCmdMikrotik(itemValue, cmd) {
            switch (cmd) {
                case 'menu-hotspot-server':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_ip/hotspot_server') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-hotspot-server-profile':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_ip/hotspot_server_profile') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-hotspot-user':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_ip/hotspot_user') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-hotspot-user-profile':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_ip/hotspot_user_profile') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-hotspot-active':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_ip/hotspot_active') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-hotspot-host':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_ip/hotspot_host') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-hotspot-ip-binding':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_ip/hotspot_ip_binding') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-system-resource':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_system/resource') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-log':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_log/index') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-log-hotspot':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_log/hotspot') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-log-access':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_log/access') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-report-selling':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_report/selling') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-ping':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_others/ping') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-form-billing':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_others/form_billing') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-form-billing-n-report':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_others/form_billing_n_report') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-voucher-list':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_voucher/voucher_list') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-dns-cache':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_ip/dns_cache') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-dhcp-server-lease':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_ip/dhcp_server_lease') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        });
                    }
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                case 'menu-dashboard':
                    $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(loadingBar);
                    window['freqAjax-' + itemValue + '-' + cmd] = function () {
                        window['reqAjax-' + itemValue + '-' + cmd] = $.ajax({
                            url: "<?= site_url('mt_others/dashboard') ?>/" + itemValue + "/" + cmd,
                            success: function (data) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(data);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);

                            },
                            error: function (xhr) {
                                var d = new Date();
                                var cdx = d.getDate() + '/' + eval(d.getMonth() + 1) + '/' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                                console.log(xhr);
                                var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                                alert(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-body').html(msgError);
                                $('#mikrostator-box-' + itemValue + '-' + cmd + ' .box-tools .updated-at').html('section at: ' + cdx);
                            }
                        })

                        if ($('#autorefresh-' + itemValue + '-' + cmd).prop('checked')) {
                            setTimeout(window['freqAjax-' + itemValue + '-' + cmd], $('#autorefresh_interval-' + itemValue + '-' + cmd).val()); // function refers to itself
                        }
                    }
                    
                    window['freqAjax-' + itemValue + '-' + cmd]();
                    break;
                default:
                    break;
            }

        }
        /* 
         * **********************************
         * application mikrotik.end
         * **********************************
         */

        function open_popup(url) {
            var w = 880;
            var h = 570;
            var l = Math.floor((screen.width - w) / 2);
            var t = Math.floor((screen.height - h) / 2);
            var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
        }

        function jamku() {
            var Tgl = new Date().toDateString();
            var tglPisah = Tgl.split(' ');
            var hari = tglPisah[0];
            var tgl = tglPisah[2];
            var bln = tglPisah[1];
            var thn = tglPisah[3];
            Tgl = hari + ", " + tgl + " " + bln + " " + thn;
            var Jam = new Date().toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
            $("#jamku").html(Tgl + "&nbsp;&nbsp;<b>" + Jam + "</b>");
        }

        // kumpulan function.end

    });

    function mikrotikReboot(itemValue) {
        if (confirm('Are you sure?')) {
            reqAjax = $.ajax({
                url: "<?= site_url('mt_system/reboot') ?>/" + itemValue + "/" + true,
                success: function (data) {
                    $('#system-administrator-modal .modal-body').html(data);
                },
                error: function (xhr) {
                    console.log(xhr);
                    var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                    alert(msgError);
                }
            });
        }
    }

    function mikrotikShutdown(itemValue) {
        if (confirm('Are you sure?')) {
            reqAjax = $.ajax({
                url: "<?= site_url('mt_system/shutdown') ?>/" + itemValue + "/" + true,
                success: function (data) {
                    $('#system-administrator-modal .modal-body').html(data);
                },
                error: function (xhr) {
                    console.log(xhr);
                    var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                    alert(msgError);
                }
            });
        }
    }

    function showPassword() {
        var x = document.getElementById("mikrotik-password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function onlyUnique(value, index, self) {
        return self.indexOf(value) === index;
    }
</script>