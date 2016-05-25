
<hr style="margin:0;margin-bottom:10px;"/>
<div class="copyright">
    <center style="font-size:10px;">Hi, <b><?php echo $this->session->userdata('name'); ?></b> <a href="<?php echo base_url('logout') ?>">(keluar)</a></center>
    <center><h6>MIKROSTATOR &copy; 2016. All rights reserved. Developed by <a href="http://warungkost.com/studio" target="_blank">warungkost.com/studio</h6></center>
</div>
</div><!-- end cpasform -->
</div><!-- end wrapper -->
<script>
    var default_width_kanan = document.getElementById('kanan').style.maxWidth;
    function showhidekiri() {
        if (document.getElementById('kiri').style.display == 'none') {
            document.getElementById('kiri').style.display = 'inline-block';
            document.getElementById('kanan').style.maxWidth = default_width_kanan;
        } else {
            document.getElementById('kiri').style.display = 'none';
            document.getElementById('kanan').style.maxWidth = '100%';
        }
    }

    function replaceDay(hariEng) {
        switch (hariEng) {
            case "Mon":
                return "Senin";
                break;
            case "Tue":
                return "Selasa";
                break;
            case "Wed":
                return "Rabu";
                break;
            case "Thu":
                return "Kamis";
                break;
            case "Fri":
                return "Jum'at";
                break;
            case "Sat":
                return "Sabtu";
                break;
            case "Sun":
                return "Minggu";
                break;
            default:
                return hariEng;
                break;
        }
    }
    function jam() {
        //.Sat Feb 15 2014 | 12:34:01
        setTimeout("jam()", 1000);
        var Tgl = new Date().toDateString();
        var tglPisah = Tgl.split(' ');
        var hari = replaceDay(tglPisah[0]);
        var tgl = tglPisah[2];
        var bln = tglPisah[1];
        var thn = tglPisah[3];
        Tgl = hari + ", " + tgl + "-" + bln + "-" + thn;
        var Jam = new Date().toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
        $("#jamku").html(" | " + Tgl + " (" + Jam + ")");
    }

    $(document).ready(function() {
        jam();
    });
</script>
</body>
</html>
