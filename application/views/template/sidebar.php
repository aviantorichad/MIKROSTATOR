<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- session form -->
        <div class="input-group">
            <select name="select_session" id="select-session" class="form-control">
                <option value="*">-- Select Session --</option>
            </select>
            <span class="input-group-btn">
                <button type="button" name="add_session" id="add-session" class="btn btn-flat" title="Session Menu" data-toggle="modal" data-target="#add-session-modal"><i class="fa fa-database"></i>
                </button>
            </span>
        </div>
        <!-- /.session form -->

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MIKROSTATOR MENU</li>
            <li><a hr   ef="javascript:void(0)" id="menu-dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>


            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-qrcode"></i>
                    <span>Voucher</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="javascript:void(0)" id="menu-voucher-list"><i class="fa fa-circle-o"></i> <span>Voucher List</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-money"></i>
                    <span>Billing</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="javascript:void(0)" id="menu-form-billing"><i class="fa fa-circle-o"></i> <span>Add Billing</span></a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-file-text-o"></i>
                    <span>Reports</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="javascript:void(0)" id="menu-report-selling"><i class="fa fa-circle-o"></i> <span>Selling Report</span></a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-cubes"></i>
                    <span>Utility</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="javascript:void(0)" id="menu-log-hotspot"><i class="fa fa-circle-o"></i> <span>Log Hotspot</span></a></li>
                    <li><a href="javascript:void(0)" id="menu-log-access"><i class="fa fa-circle-o"></i> <span>Log Access</span></a></li>
                    <li><a href="javascript:void(0)" id="menu-ping"><i class="fa fa-circle-o"></i> <span>Ping</span></a></li>
                </ul>
            </li>
            
            <li>
                <a href="javascript:void(0)" id="menu-session-detail"><i class="fa fa-desktop"></i> <span>Session Detail</span></a>
            </li>

            <li>
                <a href="javascript:void(0)" id="menu-about"><i class="fa fa-github"></i> <span>About</span></a>
            </li>

            <li class="header">MIKROTIK MENU</li>
            <li class="treeview <?php echo ($this->uri->segment(1)) == "setting" ? "active" : "" ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-wifi"></i>
                    <span>IP</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
<!--                    <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i> ARP</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i> Accounting</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i> Address</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i> DHCP Client</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i> DHCP Relay</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i> DHCP Server</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i> DNS</a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i> Firewall</a></li>-->
                    <li class="treeview">
                        <a href="javascript:void(0)">
                            <i class="fa fa-circle-o"></i> <span>Hotspot</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="javascript:void(0)" id="menu-hotspot-server"><i class="fa fa-circle"></i> Hotspot Server</a></li>
                            <li><a href="javascript:void(0)" id="menu-hotspot-server-profile"><i class="fa fa-circle"></i> Hotspot Server Profile</a></li>
                            <li><a href="javascript:void(0)" id="menu-hotspot-user"><i class="fa fa-circle"></i> Hotspot User</a></li>
                            <li><a href="javascript:void(0)" id="menu-hotspot-user-profile"><i class="fa fa-circle"></i> Hotspot User Profile</a></li>
                            <li><a href="javascript:void(0)" id="menu-hotspot-active"><i class="fa fa-circle"></i> Hotspot Active</a></li>
                            <li><a href="javascript:void(0)" id="menu-hotspot-host"><i class="fa fa-circle"></i> Hotspot Host</a></li>
                            <li><a href="javascript:void(0)" id="menu-hotspot-ip-binding"><i class="fa fa-circle"></i> Hotspot IP Binding</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="javascript:void(0)">
                            <i class="fa fa-circle-o"></i> <span>DHCP Server</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="javascript:void(0)" id="menu-dhcp-server"><i class="fa fa-circle"></i> DHCP Server</a></li>
                            <li><a href="javascript:void(0)" id="menu-dhcp-server-network"><i class="fa fa-circle"></i> DHCP Server Network</a></li>
                            <li><a href="javascript:void(0)" id="menu-dhcp-server-lease"><i class="fa fa-circle"></i> DHCP Server Lease</a></li>
                            <li><a href="javascript:void(0)" id="menu-dhcp-server-option"><i class="fa fa-circle"></i> DHCP Server Option</a></li>
                            <li><a href="javascript:void(0)" id="menu-dhcp-server-option-set"><i class="fa fa-circle"></i> DHCP Server Option Set</a></li>
                            <li><a href="javascript:void(0)" id="menu-dhcp-server-alert"><i class="fa fa-circle"></i> DHCP Server Alert</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="javascript:void(0)">
                            <i class="fa fa-circle-o"></i> <span>DNS</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="javascript:void(0)" id="menu-dns-cache"><i class="fa fa-circle"></i> DNS Cache</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

<!--            <li class="treeview <?php echo ($this->uri->segment(1)) == "setting" ? "active" : "" ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-gears"></i>
                    <span>Voucher</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="javascript:void(0)"><i class="fa fa-circle-o"></i> ARP</a></li>
                </ul>
            </li>-->

            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-gears"></i>
                    <span>System</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="javascript:void(0)" id="menu-system-resource"><i class="fa fa-circle-o"></i> <span>System Resources</span></a></li>
                    <li><a href="javascript:void(0)" id="menu-system-administrator"><i class="fa fa-circle-o"></i> <span>System Administrator</span></a></li>
                </ul>
            </li>

            <li><a href="javascript:void(0)" id="menu-log"><i class="fa fa-list-ol"></i> <span>Log</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>



<!-- Modal -->
<div class="modal fade" id="add-session-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Mikrotik</h4>
            </div>
            <div class="modal-body">
                <form autocomplete="off">
                    <div class="row clearfix hidden">
                        <div class="col-sm-6">
                            <label class="control-label">Username:</label>
                            <input type="text" class="form-control" id="login-username" placeholder="">
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">Password:</label>
                            <input type="password" class="form-control" id="login-password" placeholder="">
                        </div>
                        <div class="col-sm-12">
                            <label class="control-label"></label>
                            <button type="button" class="btn btn-success btn-block"><i class="fa fa-lock"></i> Login</button>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Select from DB:</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat" id="reload-session-list"><i class="fa fa-refresh"></i></button>
                                    </span>
                                    <select id="session-list" class="form-control">
                                        <option value="*">-- Select Mikrotik --</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger btn-flat" id="del-new-session" title="Del from DB"><i class="fa fa-trash"></i></button>
                                    </span>
                                </div>
                                <small class="help-block" id="help-session-list">please reload..</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h2>Add Mikrotik</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Session Name:</label>
                                <input type="hidden" class="form-control" id="session-id" placeholder="" value="<?= date('YmdHis') ?>">
                                <input type="text" class="form-control" id="mikrotik-name" placeholder="">
                                <small class="help-block">Example: My Mikrotik</small>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Host Mikrotik:</label>
                                <input type="text" class="form-control" id="mikrotik-host" placeholder="">
                                <small class="help-block">IP or Domain</small>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Port Api Mikrotik:</label>
                                <input type="text" class="form-control" id="mikrotik-port" value="8728" placeholder="">
                                <small class="help-block">Default: 8728</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Username Mikrotik:</label>
                                <input type="text" class="form-control" id="mikrotik-username" placeholder="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Password Mikrotik:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="mikrotik-password" placeholder="">
                                    <span class="input-group-addon">
                                        <input type="checkbox" id="show-mikrotik-password" onclick="showPassword()">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Security PIN:</label>
                                <input type="text" class="form-control" id="security-pin" placeholder="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="btn-group">
                    <button type="button" class="btn btn-primary" id="connect-new-session"><i class="fa fa-star"></i> Connect</button>
                    <button type="button" class="btn btn-success" id="save-new-session"><i class="fa fa-check"></i> Save to DB</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Session.begin -->
<div class="modal fade" id="session-detail-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    Mikrotik Detail
                    <small>Mikrotik Name</small>
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
<!-- Modal Add Session.end -->

<!-- Modal Add Session.begin -->
<div class="modal fade" id="about-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    About MIKROSTATOR
                </h4>
            </div>
            <div class="modal-body">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1_about" data-toggle="tab">About</a></li>
                        <li><a href="#tab_2_about" data-toggle="tab">Contributors</a></li>
                        <li><a href="#tab_3_about" data-toggle="tab">Donate</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_about">
                            <h3>MIKROSTATOR V1</h3>
                            <h4>Requirement</h4>
                            <ul>
                                <li>PHP 5.6 or newer</li>
                                <li>Codeigniter 3.1.3</li>
                                <li>Bootstrap 3.3.7</li>
                                <li>AdminLTE v2.4.0</li>
                                <li>jQuery v3.2.1</li>
                                <li>SQLite</li>
                            </ul>
                            <hr>

                            <h4>Testing Tools</h4>
                            <ul>
                                <li>PHP 7.2.7-1+ubuntu16.04.1+deb.sury.org+1</li>
                                <li>XAMPP 5.6 on Windows 7</li>
                                <li>Router Mikrotik RB 941-2nd hAP Lite</li>
                                <li>Router Mikrotik on Winbox v.6.34.3</li>
                                <li>Penguin Web Server on Android</li>
                            </ul>
                            <hr>
                            
                            <h4>Documentation</h4>
                                <ul>
                                    <li><a href="http://aviantorichad.github.io/MIKROSTATOR/" target="_blank">Publication Page</a></li>
                                    <li><a href="http://mikrostator.aviantorichad.com" target="_blank">Blog</a></li>
                                    <li><a href="https://www.youtube.com/playlist?list=PLYM1Z9mW-R4-0a7YdpHtJaK2Ih74oClAR" target="_blank">Youtube</a></li>
                                    <li><a href="https://instagram.com/mikrostator" target="_blank">Instagram</a></li>
                                </ul>
                            <hr>

                            <h4>License</h4>
                                <ul>
                                    <li>MIT</li>
                                </ul>
                            <hr>

                            <h4>Developer(s)</h4>
                            <ul>
                                    <li>
                                    <a href="http://aviantorichad.com" target="_blank">@aviantorichad</a>
                             - <small>a father who is trying to make his wife and his son happy</small>
                                    </li>
                                </ul>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2_about">
                            <p>
                                Ini adalah tempat anda, silakan bagikan pengalaman anda menggunakan 
                                MIKROSTATOR. Anda bisa berkontribusi sebagai penguji coba, mencari bug, membuat dokumentasi, 
                                review, dan sebagainya.
                            </p>
                            <p>
                                <i>
                                This is your place, please share your experience using MIKROSTATOR. You can contribute as a tester, debugger, create documentation, reviews, and so on.
                                </i>
                            </p>
                            <ul>
                                <li>anda...</li>
                                <li>teman anda...</li>
                                <li>...</li>
                            </ul>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_3_about">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h2>Are you happy?</h2>
                                    <p>Please give me a cup of coffee :)</p>
                                    <hr>
                                    <p>Hello sedulur, jika anda merasa MIKROSTATOR
                                        berguna, kami membuka donasi untuk membantu
                                        MIKROSTATOR berkembang</p>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-dark">
                                        <div class="card-header">
                                            <h5>Donasi via Paypal</h5>
                                        </div>
                                        <div class="card-body">
                                            <p>Klik tombol di bawah untuk melakukan
                                                donasi via paypal</p>
                                            <form
                                                action="https://www.paypal.com/cgi-bin/webscr"
                                                method="post" target="_top">
                                                <input type="hidden" name="cmd"
                                                    value="_s-xclick" />
                                                <input type="hidden"
                                                    name="hosted_button_id"
                                                    value="EK6UWF45PVDR6" />
                                                <input type="image"
                                                    src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif"
                                                    border="0" name="submit" alt="PayPal
                                                    - The
                                                    safer, easier way to pay online!" />
                                                <img alt="" border="0"
                                                    src="https://www.paypalobjects.com/id_ID/i/scr/pixel.gif"
                                                    width="1" height="1" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-dark">
                                        <div class="card-header">
                                            <h5>Donasi via Transfer BANK</h5>
                                        </div>
                                        <div class="card-body">
                                            <p>Anda bisa mengirimkan donasi melalui BANK
                                                di bawah ini:</p>
                                            <p>BANK: <b>BCA</b></p>
                                            <p>No. Rek.: <b>8715-9843-81</b></p>
                                            <p>a/n: <b>Richad Avianto</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- Custom Tabs -->
            </div>
            <div class="modal-footer">
                <small>created with <i class="fa fa-heart" style="color: #b00"></i> by <a href="http://instagram.com/aviantorichad" target="_blank">@aviantorichad</a></small>                    
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Session.end -->

<!-- Modal System Administrator.begin -->
<div class="modal fade" id="system-administrator-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    System Administrator
                    <small>Session Name</small>
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
<!-- Modal System Administrator.end -->