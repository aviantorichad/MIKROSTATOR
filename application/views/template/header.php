<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <title><?= $title ?></title>
        <link rel="shortcut icon" type="x-icon" href="<?php echo base_url('favicon.png') ?>" />
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('assets/css/select2.min.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/AdminLTE.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/skin-green.min.css') ?>">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.responsive.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/buttons.dataTables.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.colVis.min.css') ?>">
        
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap3-wysihtml5.min.css') ?>">




        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>
            .content-wrapper {
                background-color: #222d32;
                
            }
            .dropdown-menu{
                z-index:2002;
            }
            .main-sidebar {
                box-shadow: 2px 0px 5px #000;
            }

        </style>

        <!-- Google Font -->
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->

        <!-- jQuery 3 -->
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>
        <script>
            var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
        </script>
    </head>
    <body class="hold-transition skin-green sidebar-mini fixed">
        <noscript>
        <meta http-equiv="refresh" content="0; url=<?= base_url('noscript.html') ?>" />
        </noscript>
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?= base_url() ?>" onclick="return confirm('Are you sure?\nAll applications will be closed!')" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>///</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>/// MIKROSTATOR</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="javascript:void(0)"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<span id="jamku"></span></a>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= base_url('favicon.png') ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs">&nbsp;</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header" style="cursor: pointer;">
                                        <img src="<?= base_url('favicon.png') ?>" id="btn_user_login" class="img-circle" alt="User Image">

                                        <p>
                                            <?= $this->session->userdata('user_full_name') ?>
                                            <small>Hello bro!</small>
                                        </p>
                                        <label style="color: #fff"><input type="checkbox" checked id="app_multiview"> Multiview</label>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body" style="display:none">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <a href="javascript:void(0)">Followers</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="javascript:void(0)">Sales</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="javascript:void(0)">Friends</a>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="javascript:void(0)" class="btn btn-default btn-flat" id="logout-one">Del this Session</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="javascript:void(0)" class="btn btn-default btn-flat" id="logout">Del all Sessions</a>
                                        </div>
                                    </li>
                                    <li class="user-footer">
                                        <div>
                                            <a href="<?=site_url('/logout')?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-block" id="logout-one"><i class="fa fa-power-off"></i> Logout</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

        <!-- Modal user_login Config.begin -->
        <div class="modal fade" id="user_login_config_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">
                            User Login
                        </h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="save_user_login_config">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal user_login Config.end -->
<script>
    $(document).ready(function(){
        $('#btn_user_login').on('click', function () {
            $('#user_login_config_modal').modal('show');
            $('#user_login_config_modal .modal-body').html(loadingBar);
            window['user_login_config_modal'] = $.ajax({
                url: "<?= site_url('home/modal_user_login_config') ?>/<?= $session_id ?>",
                success: function (data) {
                    $('#user_login_config_modal .modal-body').html(data);
                },
                error: function (xhr) {
                    console.log(xhr);
                    var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                    alert(msgError);
                    $('#user_login_config_modal .modal-body').html(msgError);
                }
            });
        });
        $('#save_user_login_config').on('click', function () {
            var formData = {
                "input_user_login_config": $('#input_user_login_config').val()
            }
            // $('#user_login_config_modal .modal-body .notifikasi').html(loadingBar);
            window['user_login_config'] = $.ajax({
            url: "<?= site_url('home/save_user_login_to_file') ?>/<?= $session_id ?>",
                type: 'POST',
                data: formData,
                success: function (data) {
                    // $('#user_login_config_modal .modal-body .notifikasi').html(data);
                    var obj = JSON.parse(data);
                    alert(obj.msg);
                },
                error: function (xhr) {
                    console.log(xhr);
                    var msgError = 'Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText;
                    // $('#user_login_config_modal .modal-body .notifikasi').html(msgError);
                    alert(msgError);
                }
            });
        });
    });
    </script>