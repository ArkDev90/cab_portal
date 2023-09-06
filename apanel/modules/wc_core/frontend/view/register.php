<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Register</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/ionicons.min.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/select2.min.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/daterangepicker.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/datepicker3.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/skin.min.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/icheck.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/cabcustom.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/morris.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/nprogress.css">
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="<?= BASE_URL ?>assets/js/jquery-2.2.3.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/select2.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/bootstrap.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/bootbox.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/moment.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/daterangepicker.js"></script>
	<script src="<?= BASE_URL ?>assets/js/bootstrap-datepicker.js"></script>
	<script src="<?= BASE_URL ?>assets/js/icheck.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/slimscroll.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/fastclick.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/app.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/jquery.inputmask.bundle.js"></script>
	<script src="<?= BASE_URL ?>assets/js/raphael.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/morris.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/bootstrap-select.min.js"></script>
	<script src="<?= BASE_URL ?>assets/js/global.js"></script>
	<script src="<?= BASE_URL ?>assets/js/nprogress.js"></script>
	<script src="<?= BASE_URL ?>assets/js/jquery.form.min.js"></script>
<style> 
	ul.col {
		list-style-type:none;
		margin-left: -36px;
	}
</style>
</head>
	<body class="hold-transition skin-red fixed layout-top-nav">
		<div class="wrapper">
			<div id="nprogress_parent"></div>
				<div class="content-wrapper">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="content-body">
									<div class="navy-blue p-md text-center">
										
									</div>
									<div style="padding-top: 6px; padding-bottom: 5px; background-image: url(<?php echo BASE_URL ?>assets/images/bg_silver.jpg)">
										<div style="background-image: url(<?php echo BASE_URL ?>assets/images/bg_silver.jpg); padding: 0 5px; height: 14px; line-height: 13px;">
											<div class="row">
												<div class="col-md-6 col-xs-4">
													Welcome, User Name [Company]
												</div>
												<div class="col-md-3 col-xs-4 text-right">
													Date : <b>Feb 21 2018</b> Time: <b>17:06</b>
												</div>
												<div class="col-md-3 col-xs-4 text-right">
													<a href="<?php echo BASE_URL ?>logout" class="cab-link text-bold">LOG OUT</a>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-primary mb-xs">
												<div class="panel-heading text-center">
													REGISTRATION
												</div>
												<div class="panel-body p-sm">
													<?php
														if ($form_type == 'company') {
															$this->load('register_step_1', $data, false);
														} else {
															$this->load('register_step_2', $data, false);
														}
													?>
												</div>
											</div>
										</div>
									</div>
									<div class="navy-blue p-sm text-center" style="font-size: 10px">
										2007 All Rights Reserved Civil Aeronautics Board of the Philippines
										<br>
										Web Hosting and Developed by CidHosting.Net
										<br>
										Website: <a href="http://www.cidhosting.net">http://www.cidhosting.net</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="warning_modal" class="modal fade" role="dialog">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title modal-danger"><span class="glyphicon glyphicon-warning-sign"></span> Oops!</h4>
						</div>
						<div class="modal-body">
							<p id = "warning_message"></p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Ok</button>
						</div>
					</div>
				</div>
			</div>
			<div id="success_modal" class="modal fade" role="dialog">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title modal-success"><span class="glyphicon glyphicon-ok"></span> Success!</h4>
						</div>
						<div class="modal-body">
							<p id = "message"></p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
						</div>
					</div>
				</div>
			</div>
			<div id="invalid_characters" class="modal fade" role="dialog">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Invalid Characters</h4>
						</div>
						<div class="modal-body">
							<p><b>Allowed Characters:</b> a-z A-Z 0-9 - _</p>
							<p>Letters, Numbers, Dash, and Underscore</p>
							<p><b>Note:</b> Space is an Invalid Character</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
						</div>
					</div>
				</div>
			</div>
			<div id="delete_modal" class="modal modal-danger">
				<div class="modal-dialog" style = "width: 300px;">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Confirmation</h4>
						</div>
						<div class="modal-body">
							<p>Are you sure you want to delete this record?</p>
						</div>
						<div class="modal-footer text-center">
							<button type="button" id="delete_yes" class="btn btn-outline btn-flat" onclick="">Yes</button>
							<button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">No</button>
						</div>
					</div>
				</div>
			</div>
			<div id="cancel_modal" class="modal modal-warning">
				<div class="modal-dialog" style = "width: 300px;">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Confirmation</h4>
						</div>
						<div class="modal-body">
							<p>Are you sure you want to cancel this record?</p>
						</div>
						<div class="modal-footer text-center">
							<button type="button" id="cancel_yes" class="btn btn-outline btn-flat" onclick="">Yes</button>
							<button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">No</button>
						</div>
					</div>
				</div>
			</div>
			<div id="confimation_modal" class="modal">
				<div class="modal-dialog" style = "width: 300px;">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Confirmation</h4>
						</div>
						<div class="modal-body">
							<p id="confimation_question">Are you sure you want to delete this record?</p>
						</div>
						<div class="modal-footer text-center">
							<button type="button" id="confirmation_yes" class="btn btn-primary btn-flat" onclick="">Yes</button>
							<button type="button" id="confirmation_no" class="btn btn-default btn-flat" data-dismiss="modal">No</button>
						</div>
					</div>
				</div>
			</div>
			<div class="control-sidebar-bg"></div>
		</div>
		<div id="monthly_datefilter"></div>
		<script src="<?= BASE_URL ?>assets/js/site.js"></script>
	</body>
</html>