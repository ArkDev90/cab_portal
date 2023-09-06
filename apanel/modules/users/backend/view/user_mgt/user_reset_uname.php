<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		RESET USERNAME
	</div>
	<div class="panel-body">
		<p class="text-center">Click confirm to reset password for <?php echo $username ?> <b> [ Cab User ] </b></p>
		<form action="" method="post" class="form-horizontal">
			<?php
				echo $ui->formField('text')
						->setLabel('Old Username:')
						->setSplit('col-md-4', 'col-md-6')
						->setValue($username)
						->draw(false);
					
				echo $ui->formField('text')
						->setLabel('New Username:')
						->setSplit('col-md-4', 'col-md-6')
						->setName('username')
						->setId('username')
						->setValidation('required')
						->draw();
			?>
			<div class="row">
				<div class="col-md-12 text-center">
					<a href="<?php echo MODULE_URL ?>" class="btn btn-sm btn-default">CANCEL</a>
					<button type="submit" class="btn btn-sm btn-primary">CONFIRM</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	var ajax_call = '';
	$('#username').on('change input', function() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		var username = $(this).val();
		$('#username').closest('form').find('[type="submit"]').addClass('disabled');
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_check_username', 'username=' + username + '<?=$ajax_post?>', function(data) {
			var error_message = 'Username already Exist';
			if (data.available) {
				var form_group = $('#username').closest('.form-group');
				if (form_group.find('p.help-block').html() == error_message) {
					form_group.removeClass('has-error').find('p.help-block').html('');
				}
			} else {
				$('#username').closest('.form-group').addClass('has-error').find('p.help-block').html(error_message);
			}
			$('#username').closest('form').find('[type="submit"]').removeClass('disabled');
		});
	});

	$('form').submit(function(e) {
		e.preventDefault();
		$(this).find('.form-group').find('input, textarea, select').trigger('blur');
		if ($(this).find('.form-group.has-error').length == 0) {
			$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '<?=$ajax_post?>', function(data) {
				if (data.success) {
					window.location = data.redirect;
				}
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>