<form action="" method="post" id="form_step_1" class="form-horizontal">
	<br>
	<div class="row">
		<div class="col-md-11">
			<?php
				echo $ui->formField('text')
						->setLabel('Company Code:')
						->setSplit('col-md-3', 'col-md-9')
						->setValue($code)
						->draw(false);

				echo $ui->formField('text')
						->setLabel('Client Name:')
						->setSplit('col-md-3', 'col-md-9')
						->setValue($name)
						->draw(false);
			?>
			<div class="form-group">
				<label class="control-label col-md-3">Nature of Operation:</label>
				<div class="col-md-9">
					<?php foreach ($nature_list as $row): ?>
						<p class="form-control-static"><?php echo $row->title ?></p>
					<?php endforeach ?>
				</div>
			</div>
			<?php
				echo $ui->formField('text')
						->setLabel('*TIN NO:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('tin_no')
						->setName('tin_no')
						->setValue($tin_no)
						->setValidation('required')
						->draw();

				echo $ui->formField('textarea')
						->setLabel('*Address:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('address')
						->setName('address')
						->setValue($address)
						->setValidation('required')
						->draw();
			?>
			<div class="row">
				<div class="col-md-6">
					<?php
						echo $ui->formField('dropdown')
								->setLabel('*Country:')
								->setSplit('col-md-6', 'col-md-6')
								->setId('country')
								->setName('country')
								->setValue($country)
								->setList($country_list)
								->setValidation('required')
								->draw();
					?>
				</div>
				<div class="col-md-6">
					<?php
						echo $ui->formField('text')
								->setLabel('*Postal Code:')
								->setSplit('col-md-6', 'col-md-6')
								->setId('postal_code')
								->setName('postal_code')
								->setValue($postal_code)
								->setValidation('required')
								->draw();
					?>
				</div>
			</div>
			<?php
				echo $ui->formField('text')
						->setLabel('*Email Address:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('email')
						->setName('email')
						->setValue($email)
						->setValidation('required')
						->draw();

				echo $ui->formField('text')
						->setLabel('Website:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('website')
						->setName('website')
						->setValue($website)
						->draw();

				echo $ui->formField('text')
						->setLabel('*Telephone No:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('telno')
						->setName('telno')
						->setValue($telno)
						->setValidation('required')
						->draw();

				echo $ui->formField('text')
						->setLabel('Fax No:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('faxno')
						->setName('faxno')
						->setValue($faxno)
						->draw();

				echo $ui->formField('text')
						->setLabel('Mobile No:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('mobno')
						->setName('mobno')
						->setValue($mobno)
						->draw();
			?>
			<div class="row">
				<div class="col-md-9 col-md-offset-3">
					<h5>CONTACT PERSON DETAILS</h5>
				</div>
			</div>
			<?php
				echo $ui->formField('text')
						->setLabel('*Contact Person:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('cperson')
						->setName('cperson')
						->setValue($cperson)
						->setValidation('required')
						->draw();

				echo $ui->formField('text')
						->setLabel('*Designation:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('cp_designation')
						->setName('cp_designation')
						->setValue($cp_designation)
						->setValidation('required')
						->draw();

				echo $ui->formField('text')
						->setLabel('*Contact Info:')
						->setSplit('col-md-3', 'col-md-9')
						->setId('cp_contact')
						->setName('cp_contact')
						->setValue($cp_contact)
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
	$('#form_step_1').submit(function(e) {
		e.preventDefault();
		$(this).find('.form-group').find('input, textarea, select').trigger('blur');
		if ($(this).find('.form-group.has-error').length == 0) {
			$.post('<?=MODULE_URL?>/ajax/ajax_update_client', $(this).serialize(), function(data) {
				if (data.success) {
					window.location = data.redirect;
				}
			});
		} else {
			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();
		}
	});
</script>