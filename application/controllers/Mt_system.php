<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mt_system extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        $this->load->model('rich_model');
    }

    public function resource($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            $array = $API->comm('/system/resource/print');

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

            /*             * *******************************
             *  list result
             * ********************************
             */
            echo '<ul>';
            foreach ($array[0] as $key => $val):
                switch ($key) {
                    case "cpu-frequency":;
                        echo '<li>' . $key . '<b>: ' . $val . ' MHz</b></li>';
                        break;
                    case "cpu-load":;
                        echo '<li>' . $key . '<b>: ' . $val . ' %</b></li>';
                        break;
                    case "free-memory":;
                        echo '<li>' . $key . '<b>: ' . $val . '</b> (' . $this->rich_model->formatBytes($val) . ')</li>';
                        break;
                    case "total-memory":;
                        echo '<li>' . $key . '<b>: ' . $val . '</b> (' . $this->rich_model->formatBytes($val) . ')</li>';
                        break;
                    case "free-hdd-space":;
                        echo '<li>' . $key . '<b>: ' . $val . '</b> (' . $this->rich_model->formatBytes($val) . ')</li>';
                        break;
                    case "total-hdd-space":;
                        echo '<li>' . $key . '<b>: ' . $val . '</b> (' . $this->rich_model->formatBytes($val) . ')</li>';
                        break;
                    default:
                        echo '<li>' . $key . '<b>: ' . $val . '</b></li>';
                        break;
                }
            endforeach;
            echo '</ul>';

            /*             * *******************************
             *  form result
             * ********************************
             */
//        echo '<form>';
//        foreach ($array[0] as $key => $val):
//            
            ?>
            <!--            <div class="form-group">
                            <label for="//<?= $key ?>" class="control-label"><?= $key ?>:</label>
                            <input type="text" class="form-control" id="//<?= $key ?>" value="<?= $val ?>">
                        </div>-->
            <?php
//        endforeach;
//        echo '</form>';

            /*             * *******************************
             *  source result
             * ********************************
             */
//        echo "<pre>";
//        print_r($array);
//        echo "</pre>";
        } else {
            ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Mikrotik not connected!</h4>                    
            </div>
            <?php
        }
    }

    public function reboot($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            $array = $API->comm('/system/reboot');
//            $this->rich_model->debug_array($array, true);
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
                Command executed!
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

    public function shutdown($session_id, $cmd = "") {
        $koneksi = $this->rich_model->get_session_by_id($session_id);
        $API = new $this->mikrostator();
        if ($API->konek($koneksi)) {
            $array = $API->comm('/system/shutdown');

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
                Command executed!
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
