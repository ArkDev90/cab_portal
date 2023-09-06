<form action="" method="post" id="form_step_1" class="form-horizontal">
	<br>
	<div class="row">
		<div class="col-md-11">
			<div class="row">
				<div class="col-md-9 col-md-offset-3">
					<h5>USER ACCESS</h5>
				</div>
			</div>
			<?php
				echo $ui->formField('text')
						->setLabel('*Username:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('username')
						->setName('username')
						->setValidation('required')
						->draw();

				echo $ui->formField('password')
						->setLabel('*Password:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('password')
						->setName('password')
						->setValidation('required')
						->draw();

				echo $ui->formField('password')
						->setLabel('*Confirm Password:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('password')
						->setName('password')
						->setValidation('required')
						->draw();
			?>
			<div class="row">
				<div class="col-md-9 col-md-offset-3">
					<h5>USER DETAILS</h5>
				</div>
			</div>
			<div class="row">
				<label class="control-label col-md-3">*Member Name:</label>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-4">
							<?php
								echo $ui->formField('text')
										->setPlaceholder('Last Name')
										->setSplit('', 'col-md-12')
										->setId('lname')
										->setName('lname')
										->setValidation('required')
										->draw();
							?>
						</div>
						<div class="col-md-4">
							<?php
								echo $ui->formField('text')
										->setPlaceholder('First Name')
										->setSplit('', 'col-md-12')
										->setId('fname')
										->setName('fname')
										->setValidation('required')
										->draw();
							?>
						</div>
						<div class="col-md-4">
							<?php
								echo $ui->formField('text')
										->setPlaceholder('Middle Name')
										->setSplit('', 'col-md-12')
										->setId('mname')
										->setName('mname')
										->setValidation('required')
										->draw();
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
				echo $ui->formField('text')
						->setLabel('*Designation:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('designation')
						->setName('designation')
						->setValidation('required')
						->draw();

				echo $ui->formField('textarea')
						->setLabel('*Address:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('address')
						->setName('address')
						->setValidation('required')
						->draw();

				echo $ui->formField('dropdown')
						->setLabel('*Country:')
						->setSplit('col-md-3', 'col-md-6')
						->setId('country')
						->setName('country')
						->setValue($country)
						->setList($country_list)
						->setValidation('required')
						->draw();

				echo $ui->formField('text')
						->setLabel('*Email:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('email')
						->setName('email')
						->setValidation('required')
						->draw();

				echo $ui->formField('text')
						->setLabel('*Contact No:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('contact')
						->setName('contact')
						->setValidation('required')
						->draw();
			?>
		</div>
	</div>
	<div class="text-center">
		<button type="submit" class="btn btn-primary btn-sm">Save</button>
	</div>
</form>
<script>
	var ajax_call = '';
	$('#username').on('input', function() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		var username = $(this).val();
		$('#username').closest('form').find('[type="submit"]').addClass('disabled');
		ajax_call = $.post('<?=MODULE_URL?>/ajax/ajax_check_username', 'username=' + username, function(data) {
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
	$('#form_step_1').submit(function(e) {
		e.preventDefault();
		$(this).find('.form-group').find('input, textarea, select').trigger('blur');
		if ($(this).find('.form-group.has-error').length == 0) {
			$.post('<?=MODULE_URL?>/ajax/ajax_register_user', $(this).serialize(), function(data) {
				if (data.success) {
					window.location = data.redirect;
				}
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>