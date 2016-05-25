<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0;"/>
        <link rel="shortcut icon" type="x-icon" href="<?php echo base_url('assets/img/favicon.png') ?>" />
        <link href="<?php echo base_url('assets/css/login_style.css') ?>" rel="stylesheet" type="text/css" />
        <title>LOGIN MIKROSTATOR - Admin RTPAPAT.NET</title>
    </head>
    <body>
        <div id="wrapper">
            <form name="chpass-form" class="chpass-form" action="<?php echo base_url('login'); ?>" method="POST" >
                <!--HEADER-->
                <div class="header">
                    <!--TITLE--><center><h1><span style="font-family:Arial;font-weight:bold;"><span style="color:#009988;	">MIKRO</span>STATOR</span></h1></center><!--END TITLE-->
                    <!--DESCRIPTION--><center><h2 style="margin:0;padding:0;"><span style="font-size:10px;color:#999;">MIKROTIK ADMINISTRATOR</span></h2></center><!--END DESCRIPTION-->
                </div>
                <div class="content">
                    <input name="username" type="text" placeholder="Username" class="input username" size="30" style="font-weight:bold;"  autocomplete="off" required />
                    <input name="password" type="password" placeholder="Password" class="input password" size="30" required />
                </div>
                <?php if ($this->session->flashdata('message')) : ?>
                    <div style="background:yellow;color:maroon;text-align:center;font-size:12px;padding:5px;margin-bottom:10px;border-top:5px solid orange;border-bottom:3px solid orange;">
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php endif; ?>
                <div class="footer">
                    <input type="submit" name="submit" value="MASUK" class="button proses" />
                </div>
            </form>
        </div>
    </body>
</html>