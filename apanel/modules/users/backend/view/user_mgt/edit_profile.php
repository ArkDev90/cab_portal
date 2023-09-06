<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		PERSONAL INFORMATION
	</div>
	<div class="panel-body">
		<form action="" method="post" class="form-horizontal">
			<div class="form-group">
				<label class="control-label col-md-3">Member Name:</label>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-4">
							<?php
								echo $ui->setElement('text')
										->setPlaceholder('Last Name')
										->setName('lastname')
										->setId('lastname')
										->setValue($lastname)
										->draw($show_input);
							?>
						</div>
						<div class="col-md-4">
							<?php
								echo $ui->setElement('text')
										->setPlaceholder('First Name')
										->setName('firstname')
										->setId('firstname')
										->setValue($firstname)
										->draw($show_input);
							?>
						</div>
						<div class="col-md-4">
							<?php
								echo $ui->setElement('text')
										->setPlaceholder('Middle Name')
										->setName('middlename')
										->setId('middlename')
										->setValue($middlename)
										->draw($show_input);
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
				echo $ui->formField('text')
						->setLabel('Address: ')
						->setSplit('col-md-3', 'col-md-9')
						->setName('address')
						->setId('address')
						->setValue($address)
						->draw($show_input);

				echo $ui->formField('dropdown')
						->setPlaceholder('Select a Country')
						->setLabel('Country: ')
						->setSplit('col-md-3', 'col-md-3')
						->setName('country')
						->setId('country')
						->setList($country_list)
						->setValue($country)
						->draw($show_input);

				echo $ui->formField('text')
						->setLabel('Email: ')
						->setSplit('col-md-3', 'col-md-9')
						->setName('email')
						->setId('email')
						->setValue($email)
						->draw($show_input);

				echo $ui->formField('text')
						->setLabel('Contact No: ')
						->setSplit('col-md-3', 'col-md-9')
						->setName('phone')
						->setId('phone')
						->setValue($phone)
						->draw($show_input);
			?>
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