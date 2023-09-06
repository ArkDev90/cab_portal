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

		<div class="form-horizontal">

			<div class="row">

				<div class="col-md-6 col-md-offset-3">

					<p class="mb-sm">Note: Input Base of Operation upon Submission</p>

					<?php

						echo $ui->formField('text')

								->setLabel('*Base of Operation:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('operation')

								->setName('operation')

								->setValue($operation)

								->setValidation('required')

								->draw();

					?>

				</div>

			</div>

		</div>

		<br>

		<form action="" method="post" id="entry_form" class="form-horizontal">

			<div class="row">

				<div class="col-md-6">

					<div class="form-group">

						<label class="control-label col-md-5">*Date: </label>

						<div class="col-md-7">

							<div class="row">

								<div class="col-xs-4 text-right" style="padding-right: 3px;">

									<div class="form-control-static"><?php echo $month_name; ?></div>

								</div>

								<div class="col-xs-5">

									<?php

										echo $ui->setElement('dropdown')

												->setId('report_day')

												->setName('report_day')

												->setList($month_days)

												->draw();

									?>

								</div>

								<div class="col-xs-3" style="padding-left: 3px;">

									<div class="form-control-static"><?php echo $year; ?></div>

								</div>

							</div>

						</div>

					</div>

				</div>

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Aircraft Type:')

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

								->setLabel('*Distance Travelled:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('distance')

								->setName('distance')

								->setAddon(array('class' => '', 'value' => 'Kilometers'))

								->setValidation('required decimal')

								->draw();

					?>

				</div>

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Aircraft Number:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('aircraft_num')

								->setName('aircraft_num')

								->setValidation('required')

								->draw();

					?>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Revenue Passengers:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('passengers_num')

								->setName('passengers_num')

								->setValidation('required integer')

								->draw();

					?>

				</div>

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Revenue Derived:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('revenue')

								->setName('revenue')

								->setAddon(array('class' => '', 'value' => 'Philippine Peso'))

								->setValidation('required decimal allow_negative')

								->draw();

					?>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<div class="row">

						<label class="control-label col-md-5">*A/C Flying Time:</label>

						<div class="col-md-7">

							<div class="row">

								<div class="col-xs-6" style="padding-right: 6px">

									<?php

										echo $ui->formField('text')

												->setId('flown_hour')

												->setName('flown_hour')

												->setSplit('', 'col-md-12')

												->setAddon(array('class' => '', 'value' => 'Hours'))

												->setValidation('required integer')

												->draw();

									?>

								</div>

								<div class="col-xs-6" style="padding-left: 0">

									<?php

										echo $ui->formField('text')

												->setId('flown_min')

												->setName('flown_min')

												->setSplit('', 'col-md-12')

												->setAttribute(array('data-max' => 60))

												->setAddon(array('class' => '', 'value' => 'Minutes'))

												->setValidation('required integer')

												->draw();

									?>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

			<br>

			<div class="row">

				<div class="col-md-6">

					<label class="mb-none">ROUTES SERVED</label>

					<p class="mb-sm">Note: Please type FULL name of Origin/Destination</p>

					<?php

						echo $ui->formField('text')

								->setLabel('*Origin:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('origin')

								->setName('origin')

								->setValidation('required')

								->draw();



						echo $ui->formField('text')

								->setLabel('*Destination:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('destination')

								->setName('destination')

								->setValidation('required')

								->draw();

					?>

				</div>

				<div class="col-md-6">

					<p class="mb-none">&nbsp;</p>

					<label class="mb-sm">Revenue Cargo Carried:</label>

					<?php

						echo $ui->formField('text')

								->setLabel('*Quantity:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('cargo_qty')

								->setName('cargo_qty')

								->setAddon(array('class' => '', 'value' => 'KG'))

								->setValidation('required decimal')

								->draw();



						echo $ui->formField('text')

								->setLabel('*Value:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('cargo_value')

								->setName('cargo_value')

								->setAddon(array('class' => '', 'value' => 'Philippine Peso'))

								->setValidation('required decimal')

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

							<th class="" rowspan="2"><input type="checkbox" class="selectall"></th>

							<th class="col-md-2" rowspan="2">DATE</th>

							<th class="col-md-2" colspan="2">AIRCRAFT</th>

							<th class="col-md-2" colspan="2">ROUTES SERVED</th>

							<th class="col-md-1" rowspan="2">DISTANCE TRAVELLED (Kilometers)</th>

							<th class="col-md-1" colspan="2">A/C FLYING TIME</th>

							<th class="col-md-1" rowspan="2">NUMBER OF PASSENGERS CARRIED</th>

							<th class="col-md-1" colspan="2">CARGO CARRIED</th>

							<th class="col-md-1" rowspan="2">REVENUE DERIVED (Philippine Peso)</th>

							<th class="col-md-1" rowspan="2">EDIT</th>

						</tr>

						<tr class="info">

							<th>TYPE</th>

							<th>NUMBER</th>

							<th>ORIGIN</th>

							<th>DESTINATION</th>

							<th>HOURS</th>

							<th>MINUTES</th>

							<th>QTY</th>

							<th>VALUE</th>

						</tr>

					</thead>

					<tbody>



					</tbody>

					<tfoot>

						<tr class="info total_row">

							<th colspan="6" class="text-right">TOTAL:</th>

							<th class="total_distance text-right">0</th>

							<th class="total_flown_hour text-right">0</th>

							<th class="total_flown_min text-right">0.00</th>

							<th class="total_passengers_num text-right">0.00</th>

							<th class="total_cargo_qty text-right">0</th>

							<th class="total_cargo_value text-right">0.00</th>

							<th class="total_revenue text-right">0.00</th>

							<th></th>

						</tr>

						<tr class="info">

							<td colspan="11" id="pagination"></td>

							<td colspan="3" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>

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



		$('#report_day').val(edit_row.find('.report_day').val()).trigger('change');

		$('#aircraft').val(edit_row.find('.aircraft').val());

		$('#aircraft_num').val(edit_row.find('.aircraft_num').val());

		$('#origin').val(edit_row.find('.origin').val());

		$('#destination').val(edit_row.find('.destination').val());

		$('#distance').val(edit_row.find('.distance').val());

		$('#flown_hour').val(edit_row.find('.flown_hour').val());

		$('#flown_min').val(edit_row.find('.flown_min').val());

		$('#passengers_num').val(edit_row.find('.passengers_num').val());

		$('#cargo_qty').val(edit_row.find('.cargo_qty').val());

		$('#cargo_value').val(edit_row.find('.cargo_value').val());

		$('#revenue').val(edit_row.find('.revenue').val());

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

		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="14" class="text-center">Add Entry or Click No Operation</td></tr>`);

	}

	function checkButtons() {

		var has_entry = !! ($('#tableList tbody .entry').length);

		var no_operation = !! ($('#tableList tbody .no_operation').length);

		$('#submit_report').attr('disabled', ! (has_entry || no_operation));

		$('#save_draft').attr('disabled', ! (has_entry || no_operation));

		$('#no_operation').attr('disabled', no_operation);

		$('.delete_entry').attr('disabled', ! has_entry);



		$('.entry_count').html($('#tableList tbody .entry').length);



		$('#operation').attr('disabled', ! $('#tableList tbody .entry').length).attr('data-validation', ($('#tableList tbody .entry').length) ? 'required' : '');

		console.log($('#operation[data-validation=""]').length);

		if ($('#operation[data-validation=""]').length) {

			$('#operation[data-validation=""]').val('');

		}

	}

	function computeTotal() {

		var rows = 0;

		var total_distance = 0;

		var total_flown_hour = 0;

		var total_flown_min = 0;

		var total_passengers_num = 0;

		var total_cargo_qty = 0;

		var total_cargo_value = 0;

		var total_revenue = 0;

		$('#tableList tbody tr').each(function() {

			if ($(this).find('.distance').length) {

				rows++;

			}

			total_distance += removeComma($(this).find('.distance').val());

			total_flown_hour += removeComma($(this).find('.flown_hour').val());

			total_flown_min += removeComma($(this).find('.flown_min').val());

			total_passengers_num += removeComma($(this).find('.passengers_num').val());

			total_cargo_qty += removeComma($(this).find('.cargo_qty').val());

			total_cargo_value += removeComma($(this).find('.cargo_value').val());

			total_revenue += removeComma($(this).find('.revenue').val());

		});

		total_flown_hour += Math.floor(total_flown_min / 60);

		total_flown_min = total_flown_min % 60;

		$('.total_row .total_distance').html(addComma(total_distance));

		$('.total_row .total_flown_hour').html(addComma(total_flown_hour, 0));

		$('.total_row .total_flown_min').html(addComma(total_flown_min, 0));

		$('.total_row .total_passengers_num').html(addComma(total_passengers_num, 0));

		$('.total_row .total_cargo_qty').html(addComma(total_cargo_qty));

		$('.total_row .total_cargo_value').html(addComma(total_cargo_value));

		$('.total_row .total_revenue').html(addComma(total_revenue));

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

		$('#operation').trigger('blur');

		var operation = $('#operation').val();

		if ( ! $('#operation').closest('.form-group').is('.has-error')) {

			if ($('#tableList tbody .entry').length || $('#tableList tbody .no_operation').length) {

				$('#submit_report').attr('disabled', true);

				$('#save_draft').attr('disabled', true);

				$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '&report_month=<?php echo $report_month; ?>&year=<?php echo $year; ?>&submit_type=' + submit_type + '<?=$ajax_post?>' + '&operation=' + operation, function(data) {

					if (data.success) {

						window.location = data.redirect;

					} else {

						checkButtons();

					}

				});

			}

		} else {

			$('#operation').focus();

		}

	});

	$('#submit_report').click(function() {

		if("<?php echo GROUPNAME ?>" == "Master Admin")
		{
			if(!confirm("I, the undersigned of the specified  airtaxi, do certifiy that this report has been prepared by my or under my discretion, that I have fully examined it correctly reflects the operating statistics and revenues earned on airtaxi operations of our company and to the best of my knowledge and belief constitue complete and accurate statement."))
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

					<td class="text-center" colspan="14">NO OPERATION<input type="hidden" name="aircraft[]" value="NO OPERATION"></td>

				</tr>

			`;

		} else {

			data.flown_hour = removeComma(data.flown_hour);

			data.flown_min = removeComma(data.flown_min);

			data.flown_hour += Math.floor(data.flown_min / 60);

			data.flown_min = data.flown_min % 60;



			var row = `

				<tr class="entry">

					<td><input type="checkbox"></td>

					<td class="text-center"><span><?php echo $month_name; ?> ` + data.report_day + `</span><input type="hidden" name="report_day[]" class="report_day" value="` + data.report_day + `"></td>

					<td><span>` + data.aircraft + `</span><input type="hidden" name="aircraft[]" class="aircraft" value="` + data.aircraft + `"></td>

					<td><span>` + data.aircraft_num + `</span><input type="hidden" name="aircraft_num[]" class="aircraft_num" value="` + data.aircraft_num + `"></td>

					<td><span>` + data.origin + `</span><input type="hidden" name="origin[]" class="origin" value="` + data.origin + `"></td>

					<td><span>` + data.destination + `</span><input type="hidden" name="destination[]" class="destination" value="` + data.destination + `"></td>

					<td class="text-right"><span>` + addComma(data.distance) + `</span><input type="hidden" name="distance[]" class="distance" value="` + data.distance + `"></td>

					<td class="text-right"><span>` + data.flown_hour + `</span><input type="hidden" name="flown_hour[]" class="flown_hour" value="` + data.flown_hour + `"></td>

					<td class="text-right"><span>` + data.flown_min + `</span><input type="hidden" name="flown_min[]" class="flown_min" value="` + data.flown_min + `"></td>

					<td class="text-right"><span>` + data.passengers_num + `</span><input type="hidden" name="passengers_num[]" class="passengers_num" value="` + data.passengers_num + `"></td>

					<td class="text-right"><span>` + data.cargo_qty + `</span><input type="hidden" name="cargo_qty[]" class="cargo_qty" value="` + data.cargo_qty + `"></td>

					<td class="text-right"><span>` + data.cargo_value + `</span><input type="hidden" name="cargo_value[]" class="cargo_value" value="` + data.cargo_value + `"></td>

					<td class="text-right"><span>` + data.revenue + `</span><input type="hidden" name="revenue[]" class="revenue" value="` + data.revenue + `"></td>

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

		data.flown_hour = removeComma(data.flown_hour);

		data.flown_min = removeComma(data.flown_min);

		data.flown_hour += Math.floor(data.flown_min / 60);

		data.flown_min = data.flown_min % 60;



		edit_row.find('.report_day').val(data.report_day).closest('td').find('span').html('<?php echo $month_name; ?> ' + data.report_day);

		edit_row.find('.aircraft').val(data.aircraft).closest('td').find('span').html(data.aircraft);

		edit_row.find('.aircraft_num').val(data.aircraft_num).closest('td').find('span').html(data.aircraft_num);

		edit_row.find('.origin').val(data.origin).closest('td').find('span').html(data.origin);

		edit_row.find('.destination').val(data.destination).closest('td').find('span').html(data.destination);

		edit_row.find('.distance').val(data.distance).closest('td').find('span').html(data.distance);

		edit_row.find('.flown_hour').val(data.flown_hour).closest('td').find('span').html(data.flown_hour);

		edit_row.find('.flown_min').val(data.flown_min).closest('td').find('span').html(data.flown_min);

		edit_row.find('.passengers_num').val(data.passengers_num).closest('td').find('span').html(data.passengers_num);

		edit_row.find('.cargo_qty').val(data.cargo_qty).closest('td').find('span').html(data.cargo_qty);

		edit_row.find('.cargo_value').val(data.cargo_value).closest('td').find('span').html(data.cargo_value);

		edit_row.find('.revenue').val(data.revenue).closest('td').find('span').html(data.revenue);



		computeTotal();

	}

	report_details.forEach(function(data) {

		addRow(data);

	});

	checkButtons();

</script>