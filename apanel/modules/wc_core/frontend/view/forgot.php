<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Forgot Password</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/ionicons.min.css">
		<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/AdminLTE.min.css">
		<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/skin.css">
		<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/cabcustom.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="<?= BASE_URL ?>assets/js/jquery-2.2.3.min.js"></script>
		<script src="<?= BASE_URL ?>assets/js/bootstrap.min.js"></script>
	</head>
	<body class="hold-transition login-page" style="background: #003366 !important; font-">
		<div class="login-box">
			<div class="content-body">
				<div class="navy-blue p-xs text-center">
					<h4 class="m-none text-bold">Reset Password</h4>
				</div>
				<div class="p-sm">
					<p id="error_msg" class="text-red text-center"></p>
					<form id="login" action="" method="post">
						<div class="form-group has-feedback">
							<input type="text" name="username" class="form-control" placeholder="Username" value="">
							<span class="glyphicon glyphicon-user form-control-feedback"></span>
							<p class="help-block m-none"></p>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-default btn-cab">Reset Password</button>
							</div>
						</div>
					</form>
					<div class="reset_success text-center" style="display: none;">
						Please Check your Email Address to Continue Reset Password.
					</div>
				</div>
				<div class="navy-blue p-xs text-right">
					<a href="<?php echo BASE_URL ?>login" class="text-bold">Back to Login</a>
				</div>
			</div>
		</div>


<div class="login-box">

			<div class="content-body">

				<div class="navy-blue p-xs text-center">

					
				</div>

				
				<div class="p-sm ">

					
					
				
						<div class="row">
				<div class="col-lg-12 ">

								The CAB Reportial Portal may experience some slowing down due to high traffic. <br><br>


In regards to that we encourage patience on the report submission<br><br>



To avoid this we are currently upgrading our IT facilities to further improve our services. <br><br>

<b class="text-red">If the problem still occur. Please refresh the portal</b>  <br><br>


You may also submit your report a few days before the deadline to avoid the high traffic on required date of submission.<br>
<br>


You may access the link below to view on how to submit your report.<br><br>


<b><a href="https://shorturl.at/mosJX">How to Submit Reports</a><br></b>
							</div>



						</div>



				</div>

			

			</div>

		</div>


		
		<script>
			var ajax_call = '';
			$('[name="username"]').focus();
			$('#login').submit(function(e) {
				e.preventDefault();
				if (ajax_call != '') {
					ajax_call.abort();
				}
				ajax_call = $.post('<?=MODULE_URL?>/ajax/ajax_reset_pw', $(this).serialize(), function(data) {
					if (data.success) {
						$('#error_msg').html('');
						$('form#login').hide();
						$('.reset_success').show();
					}
					if (data.error_msg) {
						$('#error_msg').html(data.error_msg);
					}
				});
			});
		</script>
	</body>
</html>
