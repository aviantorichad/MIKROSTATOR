<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<title>
		<?=$title?>
	</title>
	<link rel="shortcut icon" type="x-icon" href="<?php echo base_url('favicon.png') ?>" />
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css')?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/AdminLTE.min.css') ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url('assets/font-awesome/css/font-awesome.min.css')?>">
</head>

<body class="text-black" style="overflow:hidden; background-color: #222;">
	<div class="container" style="margin:auto;margin-top: 7%;">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success bg-black text-black">
					<!-- <div class="box-header with-border "> -->
					<!-- <div class="box-header">
						<h3 class="box-title">&nbsp;</h3>
						<div class="box-tools pull-right">
						</div>
					</div> -->
					<div class="box-body" style="padding: 30px;">
							<?php $this->load->model('rich_model'); ?>
						<?php if ($this->session->flashdata('message')) : ?>
							<?php echo $this->session->flashdata('message'); ?>
						<?php endif; ?>
						<div class="row">
							<div class="col-md-4" style="color: #ddd">
								<h1 style="font-size: 2em;"><img src="<?php echo base_url('favicon.png') ?>" style="width:1.5em;"> MIKROSTATOR</h1>
								<p>Please Log in first to enter this app..</p>
							</div>
							<div class="col-md-8" style="color: #999;">
								<form autocomplete="off" method="post">
									<div class="form-group">
										<label class="control-label">Username:</label>
										<input type="text" name="_username" class="form-control bg-black" onfocus="$(this).addClass('input-lg')" onblur="$(this).removeClass('input-lg')" style="border:none;border-bottom: 1px solid #777; color:#fff;padding-left: 0;padding-right:0;" placeholder="..." />
									</div>
									<div class="form-group">
										<label class="control-label">Password:</label>
										<input type="password" name="_password" class="form-control bg-black" onfocus="$(this).addClass('input-lg')" onblur="$(this).removeClass('input-lg')" style="border:none;border-bottom: 1px solid #777; color:#fff;padding-left: 0;padding-right:0;" placeholder="..." />
									</div>
									<button class="btn btn-success btn-block btn-lg" type="submit">LOG IN</button>
								</form>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer no-border" style="background-color: #333; color: #ddd;">
						<strong>Copyright &copy; 2018
							<a href="javascript:void(0)" class="text-green">MIKROSTATOR</a>.</strong> All rights reserved.
					</div>
					<!-- box-footer -->
				</div>
				<!-- /.box -->
			</div>
		</div>

	</div>
	<!-- Bootstrap 3.3.7 -->
	<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
</body>

</html>
