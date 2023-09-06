
<div id="create" class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		Reset Temporary Master Admin Account
	</div>
	<br>
	<form action="" class="form-horizontal" method="post">
		<div class="row">
			<div class="col-md-9 col-md-offset-3">
				<b>	Master's Temporary Login Account</b>
			</div>
		</div>
		<?php
			echo $ui->formField('text')
			->setLabel('Username:')
			->setSplit('col-md-3', 'col-md-4')
			->setName('temp_username')
			->setId('temp_username')
			->setValue($temp_username)
			->setValidation('required')
			->draw($show_input);
		?>
		<div class="row">
			<div class="col-md-4 col-md-offset-3">
				<input type="submit" class="btn btn-sm btn-primary" value="RESEND TEMP USER ACCESS">
			</div>
		</div>
	</form>
	<div id="success_message" class="form-horizontal" style="display: none;">
		<div class="row">
			<div class="col-md-9 col-md-offset-3">
				<b>Master's Temporary Login Account Password Sent</b>
			</div>
		</div>
		<div class="temp_username_field">
			<?php
				echo $ui->formField('text')
				->setLabel('Username:')
				->setSplit('col-md-3', 'col-md-4')
				->setClass('temp_username')
				->setValue($temp_username)
				->setValidation('required')
				->draw(false);
			?>
		</div>
		<div class="email_field">
			<?php
				echo $ui->formField('text')
				->setLabel('Email:')
				->setSplit('col-md-3', 'col-md-4')
				->setClass('email')
				->setValidation('required')
				->draw(false);
			?>
		</div>
		<div class="row">
			<div class="col-md-4 col-md-offset-3">
				<a href="" class="btn btn-sm btn-primary close_button">CLOSE</a>
			</div>
		</div>
	</div>
	<br>
</div>
<script>
var ajax_call = '';
$('#temp_username').on('input', function() {
	if (ajax_call != '') {
		ajax_call.abort();
	}
	var temp_username = $(this).val();
	$('#temp_username').closest('form').find('[type="submit"]').addClass('disabled');
	ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_check_temp_username', 'temp_username=' + temp_username + '<?=$ajax_post?>', function(data) {
		var error_message = 'Username Already Exists';
		if (data.available) {
			var form_group = $('#temp_username').closest('.form-group');
			if (form_group.find('p.help-block').html() == error_message) {
				form_group.removeClass('has-error').find('p.help-block').html('');
			}
		} else {
			$('#temp_username').closest('.form-group').addClass('has-error').find('p.help-block').html(error_message);
		}
		$('#temp_username').closest('form').find('[type="submit"]').removeClass('disabled');
	});
});
$('form').submit(function(e) {
	e.preventDefault();

	
	
	$.post('<?=MODULE_URL?>ajax/ajax_reset_temp_user', $(this).serialize() + '<?=$ajax_post?>', function(data) {
		
		if (data.success) {
			$('#temp_username').closest('form').find('[type="submit"]').removeClass('disabled');
			$('form').hide();
			$('#success_message').show();
			$('.temp_username_field').find('.form-control-static').html(data.username);
			$('.email_field').find('.form-control-static').html(data.email);
			$('.close_button').attr('href', data.redirect);
		}
		
	
	})
	

	
});
</script>