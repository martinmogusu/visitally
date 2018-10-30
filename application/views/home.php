<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('public/img/tally.png') ?>" />
	<link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/css/app.css') ?>">
	<title>Visitally - Keep track of page views</title>
</head>
<body>
	<nav class="navbar navbar-light bg-light">
		<a class="navbar-brand" href="<?php echo base_url() ?>">
			<img src="<?php echo base_url('public/img/tally.png') ?>" alt="Logo" width="30" height="30"> Visitally
		</a>
	</nav>
	
	<div style="padding: 0px 15px">
		<br>
		<h3 class="text-center">You have</h3>
		<p class="text-center text-danger" style="font-size: 48px;"><?php echo $summary['total_requests'] ?></p>
		<h3 class="text-center">page views so far...</h3>
		<center>
			<a href="<?php echo base_url() ?>" class="btn btn-dark">Refresh</a>
		</center>
		<hr>
		<div class="row buffer-top-md">
			<div class="col-md-6 buffer-top-sm">
				<div class="card">
					<div class="card-header">Analytics</div>
					<ul class="list-group list-group-flush">
						<a class="list-group-item list-group-item-action">Unique IP Addresses: <b><?php echo $summary['unique_ip'] ?></b></a>
						<a class="list-group-item list-group-item-action">Unique Browsing Sessions: <b><?php echo $summary['total_sessions'] ?></b></a>
						<a class="list-group-item list-group-item-action">Unique Browsers: <b><?php echo $summary['unique_browsers'] ?></b></a>
						<a class="list-group-item list-group-item-action">Unique Referrers: <b><?php echo $summary['unique_referrers'] ?></b></a>
					</ul>
				</div>
			</div>
			<div class="col-md-6 buffer-top-sm">
				<div class="card">
					<div class="card-header">Info</div>
					<div class="card-body">
						<p>This site records the number of page views (total number of times the pages of this site are accessed). Github: <a href="https://github.com/martinmogusu/visitally" target="_blank" title="View source">https://github.com/martinmogusu/visitally</a></p>
						<p><u><i>About you</i></u></p>
						<p>Your IP address is <b><?php echo $request['ip_address'] ?></b></p>
						<p>You are using <b><?php echo $request['agent'] ?></b></p>
						<p>You came here from <b><?php echo $request['referrer'] ?></b></p>
						<p>You started browsing here on <b><?php echo $request['session_start_time'] ?></b></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url('public/js/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/popper.min.js') ?>"></script>
	<script src="<?php echo base_url('public/js/bootstrap.min.js') ?>"></script>
</body>
</html>