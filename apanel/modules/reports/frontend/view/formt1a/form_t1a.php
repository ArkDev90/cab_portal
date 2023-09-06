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

			<?php

				echo $ui->formField('text')

						->setLabel('Report Date:')

						->setSplit('col-md-3', 'col-md-7')

						->setValue($month_name . ' ' . $year)

						->draw(false);

			?>

			<div class="row">

				<label class="control-label col-md-3">*Sector:</label>

				<div class="col-md-7">

					<div class="row">

						<div class="col-xs-6">

							<?php

								echo $ui->formField('dropdown')

										->setPlaceholder('Select One')

										->setSplit('', 'col-md-12')

										->setId('sector')

										->setName('sector')

										->setList($origin_list)

										->setValidation('required')

										->draw();

							?>

						</div>

						<div class="col-xs-6">

							<?php

								echo $ui->formField('dropdown')

										->setPlaceholder('Select One')

										->setSplit('', 'col-md-12')

										->setId('sector_d')

										->setName('sector_d')

										->setList($destination_list)

										->setValidation('required')

										->draw();

							?>

						</div>

					</div>

				</div>

			</div>

			<?php

				echo $ui->formField('checkbox')

						->setLabel('Code Shared Flight:')

						->setSplit('col-md-3', 'col-md-7')

						->setId('codeshared_checkbox')

						->setDefault('codeshared')

						->draw();



				echo $ui->formField('text')

						->setLabel('Marketing Airline:')

						->setSplit('col-md-3', 'col-md-4')

						->setId('codeshared')

						->setName('codeshared')

						->setAttribute(array('disabled' => 'disabled'))

						->draw();

			?>

			<br>

			<table class="table-style">

				<thead>

					<tr>

						<th class="col-xs-2">Sector</th>

						<th class="col-xs-2">Distance (Kilometers)</th>

						<th class="col-xs-2">Available Seats Offered</th>

						<th class="col-xs-2">Revenue Passengers</th>

						<th class="col-xs-2">Non-revenue Passengers</th>

						<th class="col-xs-2">Cargo & Mail (Kilograms)</th>

					</tr>

				</thead>

				<tbody>

					<tr>

						<th class="sector_label">FROM/TO</th>

						<td>

							<?php

								echo $ui->formField('text')

										->setSplit('', 'col-md-12')

										->setId('distance')

										->setName('distance')

										->setValidation('required decimal')

										->draw();

							?>

						</td>

						<td>

							<?php

								echo $ui->formField('text')

										->setSplit('', 'col-md-12')

										->setId('seats_offered')

										->setName('seats_offered')

										->setValidation('required integer')

										->draw();

							?>

						</td>

						<td>

							<?php

								echo $ui->formField('text')

										->setSplit('', 'col-md-12')

										->setId('rev_pass')

										->setName('rev_pass')

										->setValidation('required integer')

										->draw();

							?>

						</td>

						<td>

							<?php

								echo $ui->formField('text')

										->setSplit('', 'col-md-12')

										->setId('nonrev_pass')

										->setName('nonrev_pass')

										->setValidation('required integer')

										->draw();

							?>

						</td>

						<td>

							<?php

								echo $ui->formField('text')

										->setSplit('', 'col-md-12')

										->setId('cargo')

										->setName('cargo')

										->setValidation('required decimal')

										->draw();

							?>

						</td>

					</tr>

					<tr>

						<th class="sector_d_label">TO/FROM</th>

						<td>

							<?php

								echo $ui->formField('text')

										->setSplit('', 'col-md-12')

										->setId('distance_d')

										->setName('distance_d')

										->setValidation('required decimal')

										->draw();

							?>

						</td>

						<td>

							<?php

								echo $ui->formField('text')

										->setSplit('', 'col-md-12')

										->setId('seats_offered_d')

										->setName('seats_offered_d')

										->setValidation('required integer')

										->draw();

							?>

						</td>

						<td>

							<?php

								echo $ui->formField('text')

										->setSplit('', 'col-md-12')

										->setId('rev_pass_d')

										->setName('rev_pass_d')

										->setValidation('required integer')

										->draw();

							?>

						</td>

						<td>

							<?php

								echo $ui->formField('text')

										->setSplit('', 'col-md-12')

										->setId('nonrev_pass_d')

										->setName('nonrev_pass_d')

										->setValidation('required integer')

										->draw();

							?>

						</td>

						<td>

							<?php

								echo $ui->formField('text')

										->setSplit('', 'col-md-12')

										->setId('cargo_d')

										->setName('cargo_d')

										->setValidation('required decimal')

										->draw();

							?>

						</td>

					</tr>

				</tbody>

			</table>

			<p id="loadFactorError" class="m-none text-center text-danger"></p>

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

			<div class="table-responsive mb-lg">

				<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">

					<thead>

						<tr class="info">

							<th><input type="checkbox" class="selectall"></th>

							<th class="col-md-3">SECTOR</th>

							<th class="col-md-2">DISTANCE (Kilometers)</th>

							<th class="col-md-1">AVAILABLE SEAT-KMS OFFERED</th>

							<th class="col-md-1">AVAILABLE SEATS</th>

							<th class="col-md-1">REVENUE PASSENGERS</th>

							<th class="col-md-1">NON-REVENUE PASSENGERS</th>

							<th class="col-md-1">PASSENGER LOAD FACTOR</th>

							<th class="col-md-1">CARGO (Kilograms)</th>

							<th class="col-md-1">EDIT</th>

						</tr>

					</thead>

					<tbody>



					</tbody>

					<tfoot>

						<tr class="info total_row">

							<th colspan="2" class="text-right">TOTAL:</th>

							<th class="total_distance text-right">0.00</th>

							<th class="total_kms text-right">0</th>

							<th class="total_seats text-right">0</th>

							<th class="total_passenger text-right">0</th>

							<th class="total_nonrev text-right">0</th>

							<th class="total_load text-right">0.00%</th>

							<th class="total_cargo text-right">0.00</th>

							<th></th>

						</tr>

						<tr class="info">

							<td colspan="8" id="pagination"></td>

							<td colspan="2" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>

						</tr>

					</tfoot>

				</table>

			</div>

			<div class="table-responsive mb-xs">

				<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">

					<thead>

						<tr class="info">

							<th colspan="11">CODE SHARED</th>

						</tr>

						<tr class="info">

							<th><input type="checkbox" class="selectall"></th>

							<th class="col-md-2">MARKETING AIRLINE</th>

							<th class="col-md-2">SECTOR</th>

							<th class="col-md-1">DISTANCE (Kilometers)</th>

							<th class="col-md-1">AVAILABLE SEAT-KMS OFFERED</th>

							<th class="col-md-1">AVAILABLE SEATS</th>

							<th class="col-md-1">REVENUE PASSENGERS</th>

							<th class="col-md-1">NON-REVENUE PASSENGERS</th>

							<th class="col-md-1">PASSENGER LOAD FACTOR</th>

							<th class="col-md-1">CARGO (Kilograms)</th>

							<th class="col-md-1">EDIT</th>

						</tr>

					</thead>

					<tbody>



					</tbody>

					<tfoot>

						<tr class="info total_row2">

							<th colspan="3" class="text-right">TOTAL:</th>

							<th class="total_distance text-right">0.00</th>

							<th class="total_kms text-right">0</th>

							<th class="total_seats text-right">0</th>

							<th class="total_passenger text-right">0</th>

							<th class="total_nonrev text-right">0</th>

							<th class="total_load text-right">0.00%</th>

							<th class="total_cargo text-right">0.00</th>

							<th></th>

						</tr>

						<tr class="info">

							<td colspan="9" id="pagination"></td>

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

	$('#tableList2').on('ifChanged', '.selectall', function() {

		var check = ($(this).is(':checked')) ? 'check' : 'uncheck';

		$('#tableList2 tbody input[type="checkbox"]').iCheck(check);

	});

	$('#sector, #sector_d').on('change', function() {

		var sector = $('#sector').val() || 'FROM';

		var sector_d = $('#sector_d').val() || 'TO';

		var sector_label = sector + '/' + sector_d;

		var sector_d_label = sector_d + '/' + sector;



		$('.sector_label').html(sector_label);

		$('.sector_d_label').html(sector_d_label);

	});

	$('#seats_offered, #rev_pass, #nonrev_pass, #seats_offered_d, #rev_pass_d, #nonrev_pass_d').change(function() {

		checkLoadFactor();

	});

	function checkLoadFactor() {

		var seats_offered = $('#seats_offered').val();

		var rev_pass = $('#rev_pass').val();

		var nonrev_pass = $('#nonrev_pass').val();

		var seats_offered_d = $('#seats_offered_d').val();

		var rev_pass_d = $('#rev_pass_d').val();

		var nonrev_pass_d = $('#nonrev_pass_d').val();

		var exceed = false;

		if (removeComma(seats_offered) < (removeComma(rev_pass) + removeComma(nonrev_pass))) {

			exceed = true;

		}

		if (removeComma(seats_offered_d) < (removeComma(rev_pass_d) + removeComma(nonrev_pass_d))) {

			exceed = true;

		}

		var error_message = 'PASSENGER TRAFFIC EXCEEDS FROM SEATING CAPACITY';

		if (exceed) {

			$('#loadFactorError').html(error_message);

		} else if ($('#loadFactorError').html() == error_message) {

			$('#loadFactorError').html('');

		}

	}

	function computeTotal() {

		var rows = 0;

		var total_distance = 0;

		var total_sk_offered = 0;

		var total_seats_offered = 0;

		var total_rev_pass = 0;

		var total_nonrev_pass = 0;

		var total_cargo = 0;

		$('#tableList tbody tr').each(function() {

			if ($(this).find('.distance').length) {

				rows++;

			}

			total_distance += removeComma($(this).find('.distance').val());

			total_distance += removeComma($(this).find('.distance_d').val());

			total_sk_offered += removeComma($(this).find('.sk_offered').val());

			total_sk_offered += removeComma($(this).find('.sk_offered_d').val());

			total_seats_offered += removeComma($(this).find('.seats_offered').val());

			total_seats_offered += removeComma($(this).find('.seats_offered_d').val());

			total_rev_pass += removeComma($(this).find('.rev_pass').val());

			total_rev_pass += removeComma($(this).find('.rev_pass_d').val());

			total_nonrev_pass += removeComma($(this).find('.nonrev_pass').val());

			total_nonrev_pass += removeComma($(this).find('.nonrev_pass_d').val());

			total_cargo += removeComma($(this).find('.cargo').val());

			total_cargo += removeComma($(this).find('.cargo_d').val());

		});

		var total_load_factor = (total_seats_offered > 0) ? (total_rev_pass / total_seats_offered) * 100 : 0;;

		$('.total_row .total_distance').html(addComma(total_distance));

		$('.total_row .total_kms').html(addComma(total_sk_offered, 0));

		$('.total_row .total_seats').html(addComma(total_seats_offered, 0));

		$('.total_row .total_passenger').html(addComma(total_rev_pass, 0));

		$('.total_row .total_nonrev').html(addComma(total_nonrev_pass, 0));

		$('.total_row .total_load').html(addComma(total_load_factor) + '%');

		$('.total_row .total_cargo').html(addComma(total_cargo));

	}

	function computeTotal2() {

		var rows = 0;

		var total_distance = 0;

		var total_sk_offered = 0;

		var total_seats_offered = 0;

		var total_rev_pass = 0;

		var total_nonrev_pass = 0;

		var total_cargo = 0;

		$('#tableList2 tbody tr').each(function() {

			if ($(this).find('.distance').length) {

				rows++;

			}

			total_distance += removeComma($(this).find('.distance').val());

			total_distance += removeComma($(this).find('.distance_d').val());

			total_sk_offered += removeComma($(this).find('.sk_offered').val());

			total_sk_offered += removeComma($(this).find('.sk_offered_d').val());

			total_seats_offered += removeComma($(this).find('.seats_offered').val());

			total_seats_offered += removeComma($(this).find('.seats_offered_d').val());

			total_rev_pass += removeComma($(this).find('.rev_pass').val());

			total_rev_pass += removeComma($(this).find('.rev_pass_d').val());

			total_nonrev_pass += removeComma($(this).find('.nonrev_pass').val());

			total_nonrev_pass += removeComma($(this).find('.nonrev_pass_d').val());

			total_cargo += removeComma($(this).find('.cargo').val());

			total_cargo += removeComma($(this).find('.cargo_d').val());

		});

		var total_load_factor = (total_seats_offered > 0) ? (total_rev_pass / total_seats_offered) * 100 : 0;;

		$('.total_row2 .total_distance').html(addComma(total_distance));

		$('.total_row2 .total_kms').html(addComma(total_sk_offered, 0));

		$('.total_row2 .total_seats').html(addComma(total_seats_offered, 0));

		$('.total_row2 .total_passenger').html(addComma(total_rev_pass, 0));

		$('.total_row2 .total_nonrev').html(addComma(total_nonrev_pass, 0));

		$('.total_row2 .total_load').html(addComma(total_load_factor) + '%');

		$('.total_row2 .total_cargo').html(addComma(total_cargo));

	}

	var edit_row = '';

	var edit_row2 = '';

	var edit_row3 = '';

	$('#tableList, #tableList2').on('click', '.edit_entry', function(e) {

		e.preventDefault();

		$('#tableList tbody tr, #tableList2 tbody tr').removeClass('warning');

		edit_row = $(this).closest('tr');

		edit_row.addClass('warning');

		edit_row2 = edit_row.next('tr');

		edit_row2.addClass('warning');

		edit_row3 = edit_row2.next('tr');

		edit_row3.addClass('warning');



		var codeshared = edit_row.find('.codeshared').val();

		$('#codeshared_checkbox').iCheck((codeshared) ? 'check' : 'uncheck');

		$('#codeshared').val(codeshared);



		$('#sector').val(edit_row.find('.sector').val()).trigger('change');

		$('#sector_d').val(edit_row2.find('.sector_d').val()).trigger('change');

		$('#distance').val(edit_row.find('.distance').val());

		$('#seats_offered').val(edit_row.find('.seats_offered').val());

		$('#rev_pass').val(edit_row.find('.rev_pass').val());

		$('#nonrev_pass').val(edit_row.find('.nonrev_pass').val());

		$('#cargo').val(edit_row.find('.cargo').val());

		$('#distance_d').val(edit_row2.find('.distance_d').val());

		$('#seats_offered_d').val(edit_row2.find('.seats_offered_d').val());

		$('#rev_pass_d').val(edit_row2.find('.rev_pass_d').val());

		$('#nonrev_pass_d').val(edit_row2.find('.nonrev_pass_d').val());

		$('#cargo_d').val(edit_row2.find('.cargo_d').val());

		$('#entry_form').find('.form-group').find('input, textarea, select').trigger('blur');

		$('.delete_entry').attr('disabled', true);



		checkLoadFactor();



		$('#add_entry').hide();

		$('#update_entry').show();

		$('#cancel_edit').show();

	});

	$('#entry_form').on('ifToggled', '#codeshared_checkbox', function() {

		checkButtons();

	});

	$('#codeshared').closest('div').append('<p class="help-block m-none"></p>');

	$('#update_entry').click(function() {

		$('#entry_form').find('.form-group').find('input, textarea, select').trigger('blur');

		if ($('#entry_form').find('.form-group.has-error').length == 0 && $('#loadFactorError').html() == '') {

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

		edit_row2.removeClass('warning');

		edit_row3.removeClass('warning');

		edit_row = '';

		edit_row2 = '';

		edit_row3 = '';



		$('#add_entry').show();

		$('#update_entry').hide();

		$('#cancel_edit').hide();



		$('#entry_form')[0].reset();



		$('#sector').val('').trigger('change.select2');

		$('#sector_d').val('').trigger('change.select2');



		$('#codeshared_checkbox').iCheck('update');

		checkButtons();

		$('.delete_entry').attr('disabled', false);



		$('.sector_label').html('FROM/TO');

		$('.sector_d_label').html('TO/FROM');

	});

	$('.delete_entry').click(function() {

		$('#tableList tbody input[type="checkbox"]').each(function() {

			if ($(this).is(':checked')) {

				var row1 = $(this).closest('tr');

				var row2 = row1.next('tr');

				var row3 = row2.next('tr');

				row1.remove();

				row2.remove();

				row3.remove();

			}

		});

		$('#tableList2 tbody input[type="checkbox"]').each(function() {

			if ($(this).is(':checked')) {

				var row1 = $(this).closest('tr');

				var row2 = row1.next('tr');

				var row3 = row2.next('tr');

				row1.remove();

				row2.remove();

				row3.remove();

			}

		});

		$('.selectall').iCheck('uncheck');

		if ($('#tableList tbody tr').length == 0) {

			addNoEntry();

		}

		if ($('#tableList2 tbody tr').length == 0) {

			addNoEntry2();

		}

		computeTotal();

		computeTotal2();

		checkButtons();

	});

	function addNoEntry() {

		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="10" class="text-center">Add Entry or Click No Operation</td></tr>`);

	}

	function addNoEntry2() {

		$('#tableList2 tbody').html(`<tr class="no-entry"><td colspan="11" class="text-center">No Entries</td></tr>`);

	}

	addNoEntry();

	addNoEntry2();

	function checkButtons() {

		var has_entry = !! ($('#tableList tbody .entry').length || $('#tableList2 tbody .entry').length);

		var no_operation = !! ($('#tableList tbody .no_operation').length);

		$('#submit_report').attr('disabled', ! (has_entry || no_operation));

		$('#save_draft').attr('disabled', ! (has_entry || no_operation));

		$('#no_operation').attr('disabled', no_operation);

		$('.delete_entry').attr('disabled', ! has_entry);



		$('#tableList .entry_count').html($('#tableList tbody .entry').length);

		$('#tableList2 .entry_count').html($('#tableList2 tbody .entry').length);



		$('#codeshared').attr('disabled', ! $('#codeshared_checkbox').is(':checked')).attr('data-validation', ($('#codeshared_checkbox').is(':checked')) ? 'required' : '').val('');

	}

	$('#entry_form').submit(function(e) {

		e.preventDefault();

		$(this).find('.form-group').find('input, textarea, select').trigger('blur');

		if ($(this).find('.form-group.has-error').length == 0 && $('#loadFactorError').html() == '') {

			var data = {};

			$(this).serializeArray().map(function(x) {

				data[x.name] = x.value

			});

			$(this)[0].reset();

			addRow(data);

			$('.sector_label').html('FROM/TO');

			$('.sector_d_label').html('TO/FROM');

		} else {

			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();

		}

		checkButtons();

	});

	var submit_type = '';

	$('#entries').submit(function(e) {

		e.preventDefault();

		if ($('#tableList tbody .entry').length || $('#tableList2 tbody .entry').length || $('#tableList tbody .no_operation').length) {

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
			if(!confirm("I, the undersigned of the specified  airlines, do certifiy that this report has been prepared by my or under my discretion, that I have fully examined it correctly reflects the operating statistics and revenues earned on airlines operations of our company and to the best of my knowledge and belief constitue complete and accurate statement."))
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

		data.sector = 'NO OPERATION';

		data.codeshared = '';

		$('#tableList tbody').html('');

		addRow(data);

		$('#tableList2 tbody').html('');

		data.codeshared = true;

		addRow(data);

		checkButtons();

	});

	function addRow(data) {

		var table_name = (data.codeshared) ? '#tableList2' : '#tableList';

		if (data.sector == 'NO OPERATION' && data.codeshared) {

			var row = `

				<tr class="no_operation">

					<td class="text-center" colspan="11">NO OPERATION<input type="hidden" name="sector[]" value="NO OPERATION"><input type="hidden" name="codeshared[]" class="codeshared" value="` + data.codeshared + `"></td>

				</tr>

			`;

		} else if (data.sector == 'NO OPERATION') {

			var row = `

				<tr class="no_operation">

					<td class="text-center" colspan="10">NO OPERATION<input type="hidden" name="sector[]" value="NO OPERATION"><input type="hidden" name="codeshared[]" class="codeshared" value="` + data.codeshared + `"></td>

				</tr>

			`;

		} else {

			var show_codeshare = (data.codeshared) ? '' : 'hidden';



			data.codeshared = data.codeshared || '';



			data.distance = removeComma(data.distance);

			data.seats_offered = removeComma(data.seats_offered);

			data.rev_pass = removeComma(data.rev_pass);



			data.distance_d = removeComma(data.distance_d);

			data.seats_offered_d = removeComma(data.seats_offered_d);

			data.rev_pass_d = removeComma(data.rev_pass_d);



			data.sk_offered = data.distance * data.seats_offered;

			data.load_factor = (data.seats_offered > 0) ? (data.rev_pass / data.seats_offered) * 100 : 0;

			data.sk_offered_d = data.distance_d * data.seats_offered_d;

			data.load_factor_d = (data.seats_offered_d > 0) ? (data.rev_pass_d / data.seats_offered_d) * 100 : 0;

			var row = `

				<tr class="entry">

					<td rowspan="3"><input type="checkbox"></td>

					<td rowspan="3" class="text-center ` + show_codeshare + `"><span>` + data.codeshared + `</span><input type="hidden" name="codeshared[]" class="codeshared" value="` + data.codeshared + `"></td>

					<td class="text-center"><span>` + (data.sector + '/' + data.sector_d) + `</span><input type="hidden" name="sector[]" class="sector" value="` + data.sector + `"></td>

					<td class="text-right"><span>` + addComma(data.distance) + `</span><input type="hidden" name="distance[]" class="distance" value="` + data.distance + `"></td>

					<td class="text-right"><span>` + addComma(data.sk_offered, 0) + `</span><input type="hidden" name="sk_offered[]" class="sk_offered" value="` + data.sk_offered + `"></td>

					<td class="text-right"><span>` + addComma(data.seats_offered, 0) + `</span><input type="hidden" name="seats_offered[]" class="seats_offered" value="` + data.seats_offered + `"></td>

					<td class="text-right"><span>` + addComma(data.rev_pass, 0) + `</span><input type="hidden" name="rev_pass[]" class="rev_pass" value="` + data.rev_pass + `"></td>

					<td class="text-right"><span>` + addComma(data.nonrev_pass, 0) + `</span><input type="hidden" name="nonrev_pass[]" class="nonrev_pass" value="` + data.nonrev_pass + `"></td>

					<td class="text-right"><span>` + addComma(data.load_factor) + `%</span><input type="hidden" name="load_factor[]" class="load_factor" value="` + data.load_factor + `"></td>

					<td class="text-right"><span>` + addComma(data.cargo) + `</span><input type="hidden" name="cargo[]" class="cargo" value="` + data.cargo + `"></td>

					<td rowspan="3" class="text-center"><a href="#edit" class="edit_entry text-info">Edit</a></td>

				</tr>

				<tr>

					<td class="text-center"><span>` + (data.sector_d + '/' + data.sector) + `</span><input type="hidden" name="sector_d[]" class="sector_d" value="` + data.sector_d + `"></td>

					<td class="text-right"><span>` + addComma(data.distance_d) + `</span><input type="hidden" name="distance_d[]" class="distance_d" value="` + data.distance_d + `"></td>

					<td class="text-right"><span>` + addComma(data.sk_offered_d, 0) + `</span><input type="hidden" name="sk_offered_d[]" class="sk_offered_d" value="` + data.sk_offered_d + `"></td>

					<td class="text-right"><span>` + addComma(data.seats_offered_d, 0) + `</span><input type="hidden" name="seats_offered_d[]" class="seats_offered_d" value="` + data.seats_offered_d + `"></td>

					<td class="text-right"><span>` + addComma(data.rev_pass_d, 0) + `</span><input type="hidden" name="rev_pass_d[]" class="rev_pass_d" value="` + data.rev_pass_d + `"></td>

					<td class="text-right"><span>` + addComma(data.nonrev_pass_d, 0) + `</span><input type="hidden" name="nonrev_pass_d[]" class="nonrev_pass_d" value="` + data.nonrev_pass_d + `"></td>

					<td class="text-right"><span>` + addComma(data.load_factor_d) + `%</span><input type="hidden" name="load_factor_d[]" class="load_factor_d" value="` + data.load_factor_d + `"</td>

					<td class="text-right"><span>` + addComma(data.cargo_d) + `</span><input type="hidden" name="cargo_d[]" class="cargo_d" value="` + data.cargo_d + `"></td>

				</tr>

				<tr class="info">

					<td class="text-right"><b>SUBTOTAL:<b></td>

					<td class="sub_distance text-right">` + addComma(removeComma(data.distance) + removeComma(data.distance_d)) + `</td>

					<td class="sub_sk_offered text-right">` + addComma(removeComma(data.sk_offered) + removeComma(data.sk_offered_d), 0) + `</td>

					<td class="sub_seats_offered text-right">` + addComma(removeComma(data.seats_offered) + removeComma(data.seats_offered_d), 0) + `</td>

					<td class="sub_rev_pass text-right">` + addComma(removeComma(data.rev_pass) + removeComma(data.rev_pass_d), 0) + `</td>

					<td class="sub_nonrev_pass text-right">` + addComma(removeComma(data.nonrev_pass) + removeComma(data.nonrev_pass_d), 0) + `</td>

					<td class="sub_load_factor text-right">` + addComma((removeComma(data.seats_offered) + removeComma(data.seats_offered_d) > 0) ? ((removeComma(data.rev_pass) + removeComma(data.rev_pass_d)) / (removeComma(data.seats_offered) + removeComma(data.seats_offered_d))) * 100 : 0) + `%</td>

					<td class="sub_cargo text-right">` + addComma(removeComma(data.cargo) + removeComma(data.cargo_d)) + `</td>

				</tr>

			`;

		}

		$(table_name + ' tbody .no-entry').remove();

		$(table_name + ' tbody .no_operation').remove();

		$(table_name + ' tbody').append(row);

		computeTotal();

		computeTotal2();

		if (typeof drawTemplate === 'function') {

			drawTemplate();

		}

	}

	function updateRow(data) {

		data.distance = removeComma(data.distance);

		data.seats_offered = removeComma(data.seats_offered);

		data.rev_pass = removeComma(data.rev_pass);



		data.distance_d = removeComma(data.distance_d);

		data.seats_offered_d = removeComma(data.seats_offered_d);

		data.rev_pass_d = removeComma(data.rev_pass_d);



		data.sk_offered = data.distance * data.seats_offered;

		data.load_factor = (data.seats_offered > 0) ? (data.rev_pass / data.seats_offered) * 100 : 0;

		data.sk_offered_d = data.distance_d * data.seats_offered_d;

		data.load_factor_d = (data.seats_offered_d > 0) ? (data.rev_pass_d / data.seats_offered_d) * 100 : 0;



		edit_row.find('.origin').val(data.origin).closest('td').find('span').html(data.origin);

		edit_row.find('.destination').val(data.destination).closest('td').find('span').html(data.destination);

		edit_row.find('.aircraft').val(data.aircraft).closest('td').find('span').html(data.aircraft);

		edit_row.find('.weight').val(data.weight).closest('td').find('span').html(data.weight);

		edit_row.find('.numMawbs').val(data.numMawbs).closest('td').find('span').html(data.numMawbs);

		edit_row.find('.commission').val(data.commission).closest('td').find('span').html(data.commission);

		edit_row.find('.fcharge').val(data.fcharge).closest('td').find('span').html(data.fcharge);



		edit_row.find('.codeshared').val(data.codeshared).closest('td').find('span').html(data.codeshared);

		edit_row.find('.sector').val(data.sector).closest('td').find('span').html(data.sector + '/' + data.sector_d);

		edit_row2.find('.sector_d').val(data.sector_d).closest('td').find('span').html(data.sector_d + '/' + data.sector);

		edit_row.find('.distance').val(data.distance).closest('td').find('span').html(addComma(data.distance));

		edit_row.find('.sk_offered').val(data.sk_offered).closest('td').find('span').html(addComma(data.sk_offered, 0));

		edit_row.find('.seats_offered').val(data.seats_offered).closest('td').find('span').html(addComma(data.seats_offered, 0));

		edit_row.find('.rev_pass').val(data.rev_pass).closest('td').find('span').html(addComma(data.rev_pass, 0));

		edit_row.find('.nonrev_pass').val(data.nonrev_pass).closest('td').find('span').html(addComma(data.nonrev_pass, 0));

		edit_row.find('.load_factor').val(data.load_factor).closest('td').find('span').html(addComma(data.load_factor) + '%');

		edit_row.find('.cargo').val(data.cargo).closest('td').find('span').html(addComma(data.cargo));

		edit_row2.find('.distance_d').val(data.distance_d).closest('td').find('span').html(addComma(data.distance_d));

		edit_row2.find('.sk_offered_d').val(data.sk_offered_d).closest('td').find('span').html(addComma(data.sk_offered_d, 0));

		edit_row2.find('.seats_offered_d').val(data.seats_offered_d).closest('td').find('span').html(addComma(data.seats_offered_d, 0));

		edit_row2.find('.rev_pass_d').val(data.rev_pass_d).closest('td').find('span').html(addComma(data.rev_pass_d, 0));

		edit_row2.find('.nonrev_pass_d').val(data.nonrev_pass_d).closest('td').find('span').html(addComma(data.nonrev_pass_d, 0));

		edit_row2.find('.load_factor_d').val(data.load_factor_d).closest('td').find('span').html(addComma(data.load_factor_d) + '%');

		edit_row2.find('.cargo_d').val(data.cargo_d).closest('td').find('span').html(addComma(data.cargo_d));



		edit_row3.find('.sub_distance').html(addComma(removeComma(data.distance) + removeComma(data.distance_d)));

		edit_row3.find('.sub_sk_offered').html(addComma(removeComma(data.sk_offered) + removeComma(data.sk_offered_d), 0));

		edit_row3.find('.sub_seats_offered').html(addComma(removeComma(data.seats_offered) + removeComma(data.seats_offered_d), 0));

		edit_row3.find('.sub_rev_pass').html(addComma(removeComma(data.rev_pass) + removeComma(data.rev_pass_d), 0));

		edit_row3.find('.sub_nonrev_pass').html(addComma(removeComma(data.nonrev_pass) + removeComma(data.nonrev_pass_d), 0));

		edit_row3.find('.sub_load_factor').html(addComma(((removeComma(data.load_factor) + removeComma(data.load_factor_d)) / 2)) + '%');

		edit_row3.find('.sub_cargo').html(addComma(removeComma(data.cargo) + removeComma(data.cargo_d)));



		computeTotal();

		computeTotal2();

	}

	report_details.forEach(function(data) {

		addRow(data);

	});

	checkButtons();

</script>