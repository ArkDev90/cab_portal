<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CLIENT'S INFORMATION
	</div>
	<?php $this->load('client_mgt/client_info_header', $data, false) ?>
	<div class="panel-body">
		<div class="panel panel-primary br-xs">
			<div class="panel-heading bb-colored text-center">
				CLIENT INFORMATION
			</div>
			<div class="panel-body">
				<form method="post" class="form-horizontal">
					<?php
						echo $ui->formField('text')
								->setLabel('Code :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('code')
								->setId('code')
								->setValue($code)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Client Name :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('name')
								->setId('name')
								->setValue($name)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('TIN No :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('tin_no')
								->setId('tin_no')
								->setValue($tin_no)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Address :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('address')
								->setId('address')
								->setValue($address)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('dropdown')
								->setLabel('Country :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('country')
								->setId('country')
								->setList($country_list)
								->setValue($country)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Email Address :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('email')
								->setId('email')
								->setValue($email)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Website :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('website')
								->setId('website')
								->setValue($website)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Fax No :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('faxno')
								->setId('faxno')
								->setValue($faxno)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Mobile No :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('mobno')
								->setId('mobno')
								->setValue($mobno)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Contact Person :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('cperson')
								->setId('cperson')
								->setValue($cperson)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Contact Info :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('cp_contact')
								->setId('cp_contact')
								->setValue($cp_contact)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Airline Represented :')
								->setSplit('col-md-4', 'col-md-6')
								->setName('airline_represented')
								->setId('airline_represented')
								->setValue($airline_represented)
								->setValidation('required')
								->draw($show_input);

						echo $ui->formField('text')
								->setLabel('Registration Date :')
								->setSplit('col-md-4', 'col-md-6')
								->setValue($regdate)
								->setValidation('required')
								->draw(false);
					?>
					<div class="text-right">
						<?php if ($show_input): ?>
							<button type="submit" class="btn btn-primary btn-sm">Save</button>
							<a href="<?php echo MODULE_URL . 'client_info/' . $client_id ?>" class="btn btn-default btn-sm">Cancel</a>
						<?php else : ?>
							<a href="<?php echo MODULE_URL . 'client_info_edit/' . $client_id ?>" class="btn btn-default btn-sm">Edit Information</a>
						<?php endif ?>
					</div>
				</form>
			</div>
		</div>
		<div class="panel panel-primary br-xs mb-none">
			<div class="panel-heading bb-colored text-center">
				NATURE OF OPERATION REGISTERED
			</div>
			<div class="box-body table-responsive no-padding">
				<table id="list" class="table table-hover table-sidepad">
					<?php
						echo $ui->loadElement('table')
								->setHeaderClass('info')
								->addHeader('Nature of Operation', array('class' => 'col-md-7 text-left'))
								->addHeader('Expiration Date', array('class' => 'col-md-3'))
								->addHeader('Status', array('class' => 'col-md-2'))
								->draw();
					?>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	var ajax2 = {};
	function getList() {
		$.post('<?=MODULE_URL?>ajax/ajax_reg_client_operation_list', ajax2, function(data) {
			$('#list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();
</script>
<?php if ($show_input): ?>
<script>
	var ajax = {}
	var ajax_call = '';
	$('form').submit(function(e) {
		e.preventDefault();
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '<?=$ajax_post?>', function(data) {
			if (data.success) {
				window.location = data.redirect;
			}
		});
	});
</script>
<?php endif ?>