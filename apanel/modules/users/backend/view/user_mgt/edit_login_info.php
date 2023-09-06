<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		LOGIN INFORMATION
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal">
			<?php
				echo $ui->formField('text')
						->setLabel('Birthday:')
						->setSplit('col-md-3', 'col-md-4')
						->setClass('datepicker-input')
						->setAddon('calendar')
						->setName('birthdate')
						->setId('birthdate')
						->setValue($birthdate)
						->setValidation('required')
						->draw($show_input);

				echo $ui->formField('dropdown')
						->setLabel('Security Question:')
						->setPlaceholder('Security Question')
						->setSplit('col-md-3', 'col-md-7')
						->setName('question')
						->setId('question')
						->setList($sec_quest_list)
						->setValue($question)
						->setValidation('required')
						->draw($show_input);

				echo $ui->formField('text')
						->setLabel('Your Answer:')
						->setSplit('col-md-3', 'col-md-7')
						->setName('answer')
						->setId('answer')
						->setValue($answer)
						->setValidation('required')
						->draw($show_input);

				echo $ui->formField('text')
						->setLabel('Username:')
						->setSplit('col-md-3', 'col-md-4')
						->setName('username')
						->setId('username')
						->setValue($username)
						->setValidation('required')
						->draw($show_input);
			?>
			<br>
			<div class="form-group">
				<div class="col-md-7 col-md-offset-3 reminder">
					<center>Input password for your protection.</center>
						<?php
							echo $ui->formField('password')
									->setName('password')
									->setSplit('', 'col-md-6 col-md-offset-3')
									->setId('password')
									->draw($show_input);
						?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12 text-center">
					<button type="submit" class="btn btn-primary btn-sm">UPDATE</button>
					<a href="<?php echo MODULE_URL . 'view/' . $username ?>" class="btn btn-sm btn-default">CANCEL</a>
				</div>
			</div>
		</form>
	</div>
</div>


<script>
	var ajax_call = '';
	$('#username').on('input', function() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		var username = $(this).val();
		$('#username').closest('form').find('[type="submit"]').addClass('disabled');
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_check_username', 'username=' + username + '<?= $ajax_post ?>', function(data) {
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
			$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '<?= $ajax_post ?>', function(data) {
				if (data.success) {
					window.location = data.redirect;
				}
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>