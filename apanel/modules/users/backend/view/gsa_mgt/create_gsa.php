<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CREATE GENERAL SALES AGENT
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal">
			<div id="step1" class="tab">
				<?php
					echo $ui->formField('text')
							->setLabel('Company Name:')
							->setSplit('col-md-3', 'col-md-4')
							->setName('company')
							->setId('company')
							->setValidation('required')
							// ->setValue($company)
							->draw($show_input);
				?>
				<div class="row">
					<label class="control-label col-md-3">GSA Name:</label>
					<div class="col-md-9">
						<div class="row">
							<div class="col-md-4">
								<?php
									echo $ui->formField('text')
											->setPlaceholder('Last Name')
											->setSplit('', 'col-md-12')
											->setName('lname')
											->setId('lname')
											// ->setValue($lastname)
											->setValidation('required')
											->draw($show_input);
								?>
							</div>
							<div class="col-md-4">
								<?php
									echo $ui->formField('text')
											->setPlaceholder('First Name')
											->setSplit('', 'col-md-12')
											->setName('fname')
											->setId('fname')
											// ->setValue($firstname)
											->setValidation('required')
											->draw($show_input);
								?>
							</div>
							<div class="col-md-4">
								<?php
									echo $ui->formField('text')
											->setPlaceholder('Middle Name')
											->setSplit('', 'col-md-12')
											->setName('mname')
											->setId('mname')
											// ->setValue($middlename)
											->setValidation('required')
											->draw($show_input);
								?>
							</div>
						</div>
					</div>
				</div>
				<?php
					echo $ui->formField('text')
							->setLabel('Email:')
							->setSplit('col-md-3', 'col-md-9')
							->setName('email')
							->setId('email')
							->setValidation('required')
							// ->setValue($email)
							->draw($show_input);

					echo $ui->formField('text')
							->setLabel('Address:')
							->setSplit('col-md-3', 'col-md-9')
							->setName('address')
							->setId('address')
							// ->setValue($address)
							->draw($show_input);

					echo $ui->formField('text')
							->setLabel('Contact Info:')
							->setSplit('col-md-3', 'col-md-9')
							->setName('contact')
							->setId('contact')
							// ->setValue($contact)
							->draw($show_input);

					echo $ui->formField('text')
							->setLabel('Username:')
							->setSplit('col-md-3', 'col-md-4')
							->setName('username')
							->setId('username')
							->setValidation('required')
							// ->setValue($username)
							->draw($show_input);

					echo $ui->formField('password')
							->setLabel('Password:')
							->setSplit('col-md-3', 'col-md-4')
							->setName('password')
							->setId('password')
							->setValidation('required')
							->draw($show_input);

					echo $ui->formField('password')
							->setLabel('Confirm Password:')
							->setSplit('col-md-3', 'col-md-4')
							->setName('conf_password')
							->setId('conf_password')
							->setValidation('required')
							->draw($show_input);
				?>
				<br>
				<div class="row">
					<div class="col-md-12 text-center">
						<button type="button" id="continue_1" class="btn btn-primary btn-sm">CONTINUE</button>
						<!-- <button type="submit" class="btn btn-primary btn-sm">SUBMIT</button> -->
						<a href="<?= MODULE_URL ?>" class="btn btn-default btn-sm">CANCEL</a>
					</div>
				</div>
			</div>
			<div id="step2" class="tab" style="display: none">
				<div class="row">
					<div class="col-md-6">
						<table id="operation_list" class="table table-bordered table-sidepad">
							<?php
								echo $ui->loadElement('table')
										->setHeaderClass('info')
										->addHeader('Nature of Operation', array('class' => 'col-md-12', 'style' => 'text-align:center'))
										->draw();
							?>
							
							<tbody>
								<?php foreach ($nature_list as $key => $row): ?>
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
							<tfoot>
								<tr>
									<td class="text-center">
										<button type="button" id="filter_client" class="btn btn-primary btn-sm">FILTER</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="col-md-6">
						<table id="client_list" class="table table-bordered table-sidepad">
							<?php
								echo $ui->loadElement('table')
										->setHeaderClass('info')
										->addHeader('List of Stakeholders', array('class' => 'col-md-12', 'style' => 'text-align:center'))
										->draw();
							?>
							
							<tbody>
								<tr>
									<td class="text-center">Select Nature of Operation</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-primary btn-sm">SUBMIT</button>
								<a href="<?= MODULE_URL ?>" class="btn btn-default btn-sm">CANCEL</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	var ajax = {};
	var ajax_call = '';
	$('#continue_1').click(function() {
		$('#step1 input').trigger('blur');
		if ($('.form-group.has-error').length == 0) {
			$('#step1').hide();
			$('#step2').show();
		}
	});
	$('#conf_password').on('input blur', function() {
		var password = $('#password').val();
		var error_message = 'Password does not Match';
		var form_group = $(this).closest('.form-group');
		var val = $(this).val() || '';
		if (password != $(this).val() && password != '') {
			form_group.addClass('has-error');
				form_group.find('p.help-block.m-none').html(error_message)
		} else {
			if (form_group.find('p.help-block.m-none').html() == error_message) {
				form_group.removeClass('has-error').find('p.help-block.m-none').html('');
			}
		}
	});
	$('#filter_client').click(function() {
		var nature_list = [];
		$(this).closest('table').find('tbody .nature:checked').each(function() {
			nature_list.push($(this).val());
		});
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?= MODULE_URL ?>ajax/ajax_get_client', { nature: nature_list }, function(data) {
			if (data.success) {
				$('#client_list tbody').html('');
			} else {
				$('#client_list tbody').html(`<tr>
					<td class="text-center">No Clients Found</td>
				</tr>`);
			}
			data.result.forEach(function(row){
				$('#client_list tbody').append(`<tr>
					<td>
						<label class="mb-none">
							<input type="checkbox" name="client[]" class="client" value="` + row.id + `">
							` + row.name + `
						</label>
					</td>
				</tr>`);
			});
		});
	});
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
		$.post('<?= MODULE_URL ?>ajax/<?= $ajax_task ?>', $(this).serialize(), function(data) {
			if (data.success) {
				window.location = data.redirect;
			}
		});
	});
</script>