<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CREATE GENERAL SALES AGENT
	</div>
	<div class="panel-body">
		<form action="" method="post" id="gsa_form" class="form-horizontal">
			<div class="row">
				<div class="col-md-6">
					<h4>Personal Information</h4>
					<?php
						echo $ui->formField('text')
								->setLabel('First Name:')
								->setName('fname')
								->setId('fname')
								->setSplit('col-md-4', 'col-md-8')
								->setValue($fname)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Last Name:')
								->setName('lname')
								->setId('lname')
								->setSplit('col-md-4', 'col-md-8')
								->setValue($lname)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Middle Name:')
								->setName('mname')
								->setId('mname')
								->setSplit('col-md-4', 'col-md-8')
								->setValue($mname)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Company:')
								->setName('company')
								->setId('company')
								->setSplit('col-md-4', 'col-md-8')
								->setValue($company)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('textarea')
								->setLabel('Address:')
								->setName('address')
								->setId('address')
								->setSplit('col-md-4', 'col-md-8')
								->setValue($address)
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Email:')
								->setName('email')
								->setId('email')
								->setSplit('col-md-4', 'col-md-8')
								->setValue($email)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Contact:')
								->setName('contact')
								->setId('contact')
								->setSplit('col-md-4', 'col-md-8')
								// ->setValue($contact)
								->draw($show_input);
					?>
				</div>
				<div class="col-md-6">
					<h4>List of Stakeholders</h4>
					<?php foreach ($client_list as $row): ?>
						<p><?php echo $row->name ?></p>
					<?php endforeach ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12 text-center">
					<a href="<?php echo MODULE_URL ?>" class="btn btn-sm btn-default">Back to List</a>
					<?php if ($show_input): ?>
						<button type="submit" class="btn btn-sm btn-primary">Save</button>
					<?php else: ?>
						<a href="<?php echo MODULE_URL . 'edit/' . $user_id ?>" class="btn btn-sm btn-primary">Edit Information</a>
					<?php endif ?>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
$('#gsa_form').submit(function(e) {
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