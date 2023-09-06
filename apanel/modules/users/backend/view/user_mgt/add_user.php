<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CREATE NEW ADMIN USER
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal">
			<?php
				echo $ui->formField('text')
						->setLabel('First Name:')
						->setSplit('col-md-3', 'col-md-5')
						->setName('firstname')
						->setId('firstname')
						->setValidation('required')
						->draw($show_input);

				echo $ui->formField('text')
						->setLabel('Middle Name:')
						->setSplit('col-md-3', 'col-md-5')
						->setName('middlename')
						->setId('middlename')
						->setValidation('required')
						->draw($show_input);

				echo $ui->formField('text')
						->setLabel('Last Name:')
						->setSplit('col-md-3', 'col-md-5')
						->setName('lastname')
						->setId('lastname')
						->setValidation('required')
						->draw($show_input);

				echo $ui->formField('text')
						->setLabel('Email:')
						->setSplit('col-md-3', 'col-md-9')
						->setName('email')
						->setId('email')
						->setValidation('required')
						->draw($show_input);
			?>
			<div class="form-group">
				<div class="col-md-9 col-md-offset-3 note">
					<p class="form-control-static">
						If you would like to send the information to this client, please indicate their email address. <br>
						For multiple email addresses, add comma "," after each email. <b> Maximum of 3 emails. </b>
					</p>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-9 col-md-offset-3">
					<p class="form-control-static">
						<b>Admin User's Temporary Login Account</b>
					</p>
				</div>
			</div>
			<?php
				echo $ui->formField('text')
						->setLabel('Username:')
						->setSplit('col-md-3', 'col-md-5')
						->setName('username')
						->setId('username')
						->setValidation('required')
						->draw($show_input);

				echo $ui->formField('checkbox')
						->setLabel('Summary Viewer Only:')
						->setSplit('col-md-6', 'col-md-6')
						->setName('summary_check')
						->setId('summary_check')
						->setDefault('1')
						->setValue(false)
						->draw($show_input);
			?>
			<div class="form-group">
				<div class="col-md-7 col-md-offset-3">
					<table id="operation_list" class="table table-bordered table-sidepad">
						<?php
							echo $ui->loadElement('table')
									->setHeaderClass('info')
									->addHeader('Nature of Operation', array('class' => 'col-md-12', 'style' => 'text-align:center'))
									->draw();
						?>
						
						<tbody>
							<?php foreach ($airtype_list as $key => $row): ?>
								<tr>
									<td>
										<label class="mb-none">
											<input type="checkbox" name="nature[]" class="nature" value="<?php echo $row->id ?>">
											<?php echo $row->title ?>
										</label>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12 text-center">
					<button type="submit" class="btn btn-primary btn-sm">Create</button>
					<a href="<?php echo MODULE_URL ?>" class="btn btn-default btn-sm">Cancel</a>
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
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_check_username', 'username=' + username, function(data) {
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
			$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize(), function(data) {
				if (data.success) {
					window.location = data.redirect;
				}
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>