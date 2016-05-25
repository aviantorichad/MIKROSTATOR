<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <link rel="shortcut icon" type="x-icon" href="<?php echo base_url('assets/img/favicon.png') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-select.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/dataTables.bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/mikrostator_style.css') ?>" />
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap-select.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js') ?>"></script>
    </head>
    <body>
        <style>
            #luding{position:fixed;top:0;text-align:center;z-index:999;width:100%;background:rgba(0,0,0,0.7);padding:5px 0;height:100%;display:none;}
            #luding_div{position:fixed;top:0;text-align:center;z-index:999;width:100%;background:rgba(255,255,255,1);padding:5px 0;display:block;color:#ff2222;}
        </style>
        <div id="luding">
            <div id="luding_div"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> silahkan tunggu...</div>
        </div>
        <div id="wrapper">
            <div class="chpass-form">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius:1px 0 2px 0;background:transparent;border:none;color:#222;">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($listmenu as $row) {
                            $menu_id = $row->menu_id;
                            $menu_name = $row->menu_name;
                            $menu_link = $row->menu_link;
                            $menu_note = $row->menu_note;
                            $menu_icon = $row->menu_icon;
                            $menu_etc = $row->menu_etc;
                            if ($menu_name == '***') {
                                echo '<li role="separator" class="divider"></li>';
                            } else {
                                echo '<li><a href="' . $menu_link . '" ' . $menu_etc . '><span class="glyphicon ' . $menu_icon . '" aria-hidden="true"></span> ' . $menu_name . '</a></li>';
                            }
                        }
                        ?>
                    </ul>
                    <span style="font-family:Arial;font-weight:bold;display:none;"><span style="color:#009988;">ADMIN</span> RTPAPAT.NET ::::::::::......</span>
                    <span style="font-size:10px;color:#aaa;float:right;margin:10px;text-align:right;">
                        <span id="countdown">
                            <h1 style="margin:0;padding:0;font-weight:none;font-size:10px;display:inline-block;">
                                <span style="color:#009988;">MIKRO</span><span style="color:#008899;">STATOR</span>
                            </h1>
                            <span id="jamku"></span>

                        </span>
                        <br/>
                        <label style="vertical-align:top;<?php echo isset($display_autorefresh)?$display_autorefresh:'display:none;' ?>">
                            <input type="checkbox" name="chkAutoRefresh" id="chkAutoRefresh" onclick="monitoring();" /> Auto Refresh
                        </label>
                        
                    </span>
                </div>

                <div><marquee id="info_baru_saja" style="color:orange;background:#222;padding:5px;font-style:italic;margin-top:0px;" scrollamount="3"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> sedang memuat data...</marquee></div>
                <div style="background:yellow;color:maroon;text-align:center;font-size:12px;padding:5px;margin-top:10px;border-top:5px solid orange;border-bottom:3px solid orange;display:none;" onclick="$('#lbl_msg').fadeOut('slow');" id="lbl_msg"></div>