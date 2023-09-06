<div class="panel panel-primary br-xs">

	<div class="panel-heading bb-colored text-center">

		<?php echo $form_title ?>

	</div>

	<div class="box-body pb-none">

		<div class="form-group">

			<button type="button" id="submit_report" class="btn btn-primary btn-sm mb-xs">Submit Report</button>

			<button type="button" id="no_operation" class="btn btn-warning btn-sm mb-xs">No Operation</button>

			<button type="button" id="save_draft" class="btn btn-default btn-sm mb-xs">Save as Draft</button>

		</div>

		<form action="" method="post" id="entry_form" class="form-horizontal">

			<div class="row">

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('Report Date:')

								->setSplit('col-md-5', 'col-md-7')

								->setValue($month_name . ' ' . $year)

								->draw(false);

					?>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<?php

						echo $ui->formField('dropdown')

								->setLabel('*Origin:')

								->setPlaceholder('Select Origin')

								->setSplit('col-md-5', 'col-md-7')

								->setId('origin')

								->setName('origin')

								->setList($mix_list)

								->setValidation('required')

								->draw();

					?>

				</div>

				<div class="col-md-6">

					<?php

						echo $ui->formField('dropdown')

								->setLabel('*Destination:')

								->setPlaceholder('Select Destination')

								->setSplit('col-md-5', 'col-md-7')

								->setId('destination')

								->setName('destination')

								->setList($mix_list)

								->setValidation('required')

								->draw();

					?>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Air Carrier:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('aircraft')

								->setName('aircraft')

								->setValidation('required')

								->draw();

					?>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Chargeable Weight:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('weight')

								->setName('weight')

								->setAddon(array('class' => '', 'value' => 'Kilograms'))

								->setValidation('required decimal')

								->draw();

					?>

				</div>

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*No. of MAWBs Used:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('numMawbs')

								->setName('numMawbs')

								->setValidation('required integer')

								->draw();

					?>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Commission Earned:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('commission')

								->setName('commission')

								->setAddon(array('class' => '', 'value' => 'Philippine Peso'))

								->setValidation('required decimal allow_negative')

								->draw();

					?>

				</div>

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Freight Charges:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('fcharge')

								->setName('fcharge')

								->setAddon(array('class' => '', 'value' => 'Philippine Peso'))

								->setValidation('required decimal allow_negative')

								->draw();

					?>

				</div>

			</div>

			<div class="text-center">

				<br>

				<button type="submit" id="add_entry" class="btn btn-primary btn-sm">Add Entry</button>

				<button type="button" id="update_entry" class="btn btn-primary btn-sm" style="display: none;">Update Entry</button>

				<button type="button" id="cancel_edit" class="btn btn-default btn-sm" style="display: none;">Cancel Edit</button>

			</div>

		</form>

		<form action="" method="post" id="entries">

			<br>

			<div class="text-right">

				<button type="button" class="btn btn-danger btn-sm mb-xs delete_entry">Delete</button>

			</div>

			<div class="table-responsive mb-xs">

				<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">

					<thead>

						<tr class="info">

							<th><input type="checkbox" class="selectall"></th>

							<th class="col-md-2">ORIGIN</th>

							<th class="col-md-2">DESTINATION</th>

							<th class="col-md-1">AIR CARRIER</th>

							<th class="col-md-1">CHARGEABLE WEIGHT (Kilograms)</th>

							<th class="col-md-2">NUMBER OF MAWBs USED</th>

							<th class="col-md-2">FREIGHT CHARGES (Philippine Peso)</th>

							<th class="col-md-1">COMMISSION EARNED (Philippine Peso)</th>

							<th class="col-md-1">EDIT</th>

						</tr>

					</thead>

					<tbody>



					</tbody>

					<tfoot>

						<tr class="info total_row">

							<th colspan="4" class="text-right">TOTAL:</th>

							<th class="total_weight text-right">0.00</th>

							<th class="total_numMawbs text-right">0</th>

							<th class="total_fcharge text-right">0.00</th>

							<th class="total_commission text-right">0.00</th>

							<th></th>

						</tr>

						<tr class="info">

							<td colspan="7" id="pagination"></td>

							<td colspan="2" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>

						</tr>

					</tfoot>

				</table>

			</div>

			<div class="text-right">

				<button type="button" class="btn btn-danger btn-sm delete_entry">Delete</button>

			</div>

		</form>

	</div>

</div>

<script>

	var report_details = <?php echo json_encode((isset($form_details) && $form_details) ? $form_details : array()) ?>;

	$('#tableList').on('ifChanged', '.selectall', function() {

		var check = ($(this).is(':checked')) ? 'check' : 'uncheck';

		$('#tableList tbody input[type="checkbox"]').iCheck(check);

	});

	var edit_row = '';

	$('#tableList').on('click', '.edit_entry', function(e) {

		e.preventDefault();

		edit_row = $(this).closest('tr');

		edit_row.addClass('warning');



		$('#origin').val(edit_row.find('.origin').val()).trigger('change');

		$('#destination').val(edit_row.find('.destination').val()).trigger('change');

		$('#aircraft').val(edit_row.find('.aircraft').val());

		$('#weight').val(edit_row.find('.weight').val());

		$('#numMawbs').val(edit_row.find('.numMawbs').val());

		$('#commission').val(edit_row.find('.commission').val());

		$('#fcharge').val(edit_row.find('.fcharge').val());

		$('#entry_form').find('.form-group').find('input, textarea, select').trigger('blur');

		$('.delete_entry').attr('disabled', true);



		$('#add_entry').hide();

		$('#update_entry').show();

		$('#cancel_edit').show();

	});

	$('#update_entry').click(function() {

		$('#entry_form').find('.form-group').find('input, textarea, select').trigger('blur');

		if ($('#entry_form').find('.form-group.has-error').length == 0) {

			var data = {};

			$('#entry_form').serializeArray().map(function(x) {

				data[x.name] = x.value

			});

			updateRow(data);

			$('#cancel_edit').trigger('click');

		} else {

			$('#entry_form').find('.form-group.has-error').first().find('input, textarea, select').focus();

		}

	});

	$('#cancel_edit').click(function() {

		edit_row.removeClass('warning');

		edit_row = '';



		$('#add_entry').show();

		$('#update_entry').hide();

		$('#cancel_edit').hide();



		$('#entry_form')[0].reset();

		$('#report_day').trigger('change');



		$('.delete_entry').attr('disabled', false);

	});

	$('.delete_entry').click(function() {

		$('#tableList tbody input[type="checkbox"]').each(function() {

			if ($(this).is(':checked')) {

				$(this).closest('tr').remove();

			}

		});

		$('.selectall').iCheck('uncheck');

		if ($('#tableList tbody tr').length == 0) {

			addNoEntry();

		}

		computeTotal();

		checkButtons();

	});

	addNoEntry();

	function addNoEntry() {

		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="9" class="text-center">Add Entry or Click No Operation</td></tr>`);

	}

	function checkButtons() {

		var has_entry = !! ($('#tableList tbody .entry').length);

		var no_operation = !! ($('#tableList tbody .no_operation').length);

		$('#submit_report').attr('disabled', ! (has_entry || no_operation));

		$('#save_draft').attr('disabled', ! (has_entry || no_operation));

		$('#no_operation').attr('disabled', no_operation);

		$('.delete_entry').attr('disabled', ! has_entry);



		$('.entry_count').html($('#tableList tbody .entry').length);

	}

	function computeTotal() {

		var rows = 0;

		var total_weight = 0;

		var total_numMawbs = 0;

		var total_commission = 0;

		var total_fcharge = 0;

		$('#tableList tbody tr').each(function() {

			if ($(this).find('.distance').length) {

				rows++;

			}

			total_weight += removeComma($(this).find('.weight').val());

			total_numMawbs += removeComma($(this).find('.numMawbs').val());

			total_commission += removeComma($(this).find('.commission').val());

			total_fcharge += removeComma($(this).find('.fcharge').val());

		});

		$('.total_row .total_weight').html(addComma(total_weight));

		$('.total_row .total_numMawbs').html(addComma(total_numMawbs, 0));

		$('.total_row .total_commission').html(addComma(total_commission));

		$('.total_row .total_fcharge').html(addComma(total_fcharge));

	}

	$('#entry_form').submit(function(e) {

		e.preventDefault();

		$(this).find('.form-group').find('input, textarea, select').trigger('blur');

		if ($(this).find('.form-group.has-error').length == 0) {

			var data = {};

			$(this).serializeArray().map(function(x) {

				data[x.name] = x.value

			});

			$(this)[0].reset();

			addRow(data);

		} else {

			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();

		}

		checkButtons();

	});

	var submit_type = '';

	$('#entries').submit(function(e) {

		e.preventDefault();

		if ($('#tableList tbody .entry').length || $('#tableList tbody .no_operation').length) {

			$('#submit_report').attr('disabled', true);

			$('#save_draft').attr('disabled', true);

			$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '&report_month=<?php echo $report_month; ?>&year=<?php echo $year; ?>&submit_type=' + submit_type + '<?=$ajax_post?>', function(data) {

				if (data.success) {

					window.location = data.redirect;

				} else {

					checkButtons();

				}

			});

		}

	});

	$('#submit_report').click(function() {

		if("<?php echo GROUPNAME ?>" == "Master Admin")
		{
			if(!confirm("I, the undersigned of the specified  cargo sales agent, do certifiy that this report has been prepared by my or under my discretion, that I have fully examined it correctly reflects the operating statistics and revenues earned on cargo sales agent operations of our company and to the best of my knowledge and belief constitue complete and accurate statement."))
			{
				return 0;
			}
		}
		submit_type = 'submit';

		$('#entries').submit();

	});

	$('#save_draft').click(function() {

		submit_type = 'draft';

		$('#entries').submit();

	});

	$('#no_operation').click(function() {

		if(!confirm("This will clear the initial data below.  Do you want to continue?"))
		{
			return 0;
		}

		var data = {};

		data.aircraft = 'NO OPERATION';

		$('#tableList tbody').html('');

		addRow(data);

		checkButtons();

	});

	function addRow(data) {

		if (data.aircraft == 'NO OPERATION') {

			var row = `

				<tr class="no_operation">

					<td class="text-center" colspan="9">NO OPERATION<input type="hidden" name="aircraft[]" value="NO OPERATION"></td>

				</tr>

			`;

		} else {

			var row = `

				<tr class="entry">

					<td><input type="checkbox"></td>

					<td><span>` + data.origin + `</span><input type="hidden" name="origin[]" class="origin" value="` + data.origin + `"></td>

					<td><span>` + data.destination + `</span><input type="hidden" name="destination[]" class="destination" value="` + data.destination + `"></td>

					<td><span>` + data.aircraft + `</span><input type="hidden" name="aircraft[]" class="aircraft" value="` + data.aircraft + `"></td>

					<td class="text-right"><span>` + addComma(data.weight) + `</span><input type="hidden" name="weight[]" class="weight" value="` + data.weight + `"></td>

					<td class="text-right"><span>` + addComma(data.numMawbs, 0) + `</span><input type="hidden" name="numMawbs[]" class="numMawbs" value="` + data.numMawbs + `"></td>

					<td class="text-right"><span>` + addComma(data.fcharge) + `</span><input type="hidden" name="fcharge[]" class="fcharge" value="` + data.fcharge + `"></td>

					<td class="text-right"><span>` + addComma(data.commission) + `</span><input type="hidden" name="commission[]" class="commission" value="` + data.commission + `"></td>

					<td class="text-center"><a href="#edit" class="edit_entry text-info">Edit</a></td>

				</tr>

			`;

		}

		$('#tableList tbody .no-entry').remove();

		$('#tableList tbody .no_operation').remove();

		$('#tableList tbody').append(row);

		if (typeof drawTemplate === 'function') {

			drawTemplate();

		}

		computeTotal();

		checkButtons();

	}

	function updateRow(data) {

		edit_row.find('.origin').val(data.origin).closest('td').find('span').html(data.origin);

		edit_row.find('.destination').val(data.destination).closest('td').find('span').html(data.destination);

		edit_row.find('.aircraft').val(data.aircraft).closest('td').find('span').html(data.aircraft);

		edit_row.find('.weight').val(data.weight).closest('td').find('span').html(data.weight);

		edit_row.find('.numMawbs').val(data.numMawbs).closest('td').find('span').html(data.numMawbs);

		edit_row.find('.commission').val(data.commission).closest('td').find('span').html(data.commission);

		edit_row.find('.fcharge').val(data.fcharge).closest('td').find('span').html(data.fcharge);



		computeTotal();

	}

	report_details.forEach(function(data) {

		addRow(data);

	});

	checkButtons();

</script>