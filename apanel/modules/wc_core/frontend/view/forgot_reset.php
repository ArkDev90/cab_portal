<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Reset Password</title>
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
						<input type="hidden" name="reset" value="<?= $reset ?>">
						<div class="form-group has-feedback">
							<input type="password" name="password" id="password" class="form-control" placeholder="Password" minlength="6" maxlength="15" value="">
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							<p class="help-block m-none"></p>
						</div>
						<div class="form-group has-feedback">
							<input type="password" name="conf_password" id="conf_password" class="form-control" placeholder="Confirm Password" value="">
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
							<p class="help-block m-none"></p>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-default btn-cab">Change Password</button>
							</div>
						</div>
					</form>
					<div class="reset_success text-center" style="display: none;">
						You have Changed your Password. Proceed to Login.
					</div>
				</div>
				<div class="navy-blue p-xs text-right">
					<a href="<?php echo BASE_URL ?>login" class="text-bold">Back to Login</a>
				</div>
			</div>
		</div>
		<script>
			var ajax_call = '';
			$('#conf_password').on('blur', function() {
				var password = $('#password').val();
				var error_message = 'Must match password!';
				if (password != $(this).val()) {
					$(this).closest('.form-group').addClass('has-error').find('p.help-block').html(error_message);
				} else {
					$(this).closest('.form-group').removeClass('has-error').find('p.help-block').html('');
				}

			});
			$('[name="username"]').focus();
			$('#login').submit(function(e) {
				
				e.preventDefault();
				if (ajax_call != '') {
					ajax_call.abort();
				}
				$(this).find('.form-group').find('input, textarea, select').trigger('blur');
				if ($(this).find('.form-group.has-error').length == 0) {
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
				}
			});
		</script>
	</body>
</html>
