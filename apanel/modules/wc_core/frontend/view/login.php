<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Login</title>
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
					<h4 class="m-none text-bold">Login</h4>
				</div>
				<div class="p-sm text-center show_error" style="display: none;">
					Please use the latest Browser to prevent any Error.
				</div>
				<div class="p-sm hide_error">
					<p id="error_msg" class="text-red text-center"></p>
					<?php if ( ! empty($error_msg)): ?>
						<!-- <p class="login-box-msg text-red"><?=$error_msg?></p> -->
					<?php else: ?>
						<!-- <p class="login-box-msg">Sign in to start your session</p> -->
					<?php endif ?>
					<?php if ( ! empty($locktime)): ?>
						<!-- <p class="login-box-msg text-red">Login Locked Till: <?=$locktime?></p> -->
					<?php endif ?>
					<form id="login" action="" method="post">
						<div class="form-group has-feedback">
							<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username ?>">
							<span class="glyphicon glyphicon-user form-control-feedback"></span>
						</div>
						<div class="form-group has-feedback">
							<input type="password" name="password" class="form-control" placeholder="Password">
							<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						</div>
						<div id="client_dropdown" class="form-group">
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-default btn-cab">Log In</button>
							</div>
						</div>
					</form>
				</div>
				<div class="navy-blue p-xs text-right hide_error">
					<a href="<?php echo BASE_URL ?>forgot" class="text-bold">Forgot Password?</a>
				</div>
			</div>
		</div>


		<div class="login-box">

			<div class="content-body">

				<div class="navy-blue p-xs text-center">

					
				</div>

				
				<div class="p-sm ">

					
					
				
						<div class="row">
				<div class="col-lg-12 text-center">

							<b>Welcome to Civil Aeronautics Board Reportorial Portal</b>

							</div>



						</div>



				</div>

			

			</div>

		</div>

		<script>
			$('.hide_error').hide();
			$('.show_error').show();
		</script>
		<script>
			var test = `test`;
			$('.show_error').hide();
			$('.hide_error').show();
			var ajax_call = '';
			if ($('[name="username"]').val().length > 0) {
				$('[name="password"]').focus();
			} else {
				$('[name="username"]').focus();
			}
			$('#login').submit(function(e) {
				e.preventDefault();
				if (ajax_call != '') {
					ajax_call.abort();
				}
				ajax_call = $.post('<?=MODULE_URL?>/ajax/verify_login', $(this).serialize() + '&redirect=<?php echo $redirect ?>', function(data) {
					if (data.success) {
						$('#error_msg').html('');
						window.location = data.redirect;
					}
					if (data.client_dropdown) {
						$('#client_dropdown').html(data.client_dropdown);
					}
					if (data.error_msg) {
						$('#error_msg').html(data.error_msg);
					}
				});
			});
		</script>
	</body>
</html>
