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

			</div>

			<div class="row">

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

								->setLabel('*Location:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('location')

								->setName('location')

								->setValidation('required')

								->draw();

					?>

				</div>

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Types of Treatment:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('treatment')

								->setName('treatment')

								->setValidation('required')

								->draw();

					?>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Total Area Treated:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('areaTreated')

								->setName('areaTreated')

								->setAddon(array('class' => '', 'value' => 'Hectares'))

								->setValidation('required decimal')

								->draw();

					?>

				</div>

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Quantity:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('qLiters')

								->setName('qLiters')

								->setAddon(array('class' => '', 'value' => 'Liters'))

								->setValidation('required decimal')

								->draw();

					?>

				</div>

			</div>

			<div class="row">

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('*Revenue Earned:')

								->setSplit('col-md-5', 'col-md-7')

								->setId('revenue')

								->setName('revenue')

								->setAddon(array('class' => '', 'value' => 'Peso'))

								->setValidation('required decimal allow_negative')

								->draw();

					?>

				</div>

				<div class="col-md-6">

					<div class="row">

						<label class="control-label col-md-5">*A/C Flying Time:</label>

						<div class="col-md-7">

							<div class="row">

								<div class="col-xs-6" style="padding-right: 6px">

									<?php

										echo $ui->formField('text')

												->setId('flyTimeHour')

												->setName('flyTimeHour')

												->setSplit('', 'col-md-12')

												->setAddon(array('class' => '', 'value' => 'Hours'))

												->setValidation('required integer')

												->draw();

									?>

								</div>

								<div class="col-xs-6" style="padding-left: 0">

									<?php

										echo $ui->formField('text')

												->setId('flyTimeMin')

												->setName('flyTimeMin')

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

							<th class="col-md-1" rowspan="2">LOCATION</th>

							<th class="col-md-1" rowspan="2">TYPES OF TREATMENT</th>

							<th class="col-md-1" rowspan="2">AREA TREATED (Hectares)</th>

							<th class="col-md-1" rowspan="2">QUANTITY (Liters)</th>

							<th class="col-md-1" rowspan="2">REVENUE EARNED (Peso)</th>

							<th class="col-md-2" colspan="2">A/C FLYING TIME</th>

							<th class="col-md-1" rowspan="2">EDIT</th>

						</tr>

						<tr class="info">

							<th>TYPE</th>

							<th>NUMBER</th>

							<th>HOURS</th>

							<th>MINUTES</th>

						</tr>

					</thead>

					<tbody>



					</tbody>

					<tfoot>

						<tr class="info total_row">

							<th colspan="6" class="text-right">TOTAL:</th>

							<th class="total_areaTreated text-right">0.00</th>

							<th class="total_qLiters text-right">0.00</th>

							<th class="total_revenue text-right">0.00</th>

							<th class="total_flyTimeHour text-right">0</th>

							<th class="total_flyTimeMin text-right">0</th>

							<th></th>

						</tr>

						<tr class="info">

							<td colspan="9" id="pagination"></td>

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

		$('#location').val(edit_row.find('.location').val());

		$('#treatment').val(edit_row.find('.treatment').val());

		$('#areaTreated').val(edit_row.find('.areaTreated').val());

		$('#qLiters').val(edit_row.find('.qLiters').val());

		$('#revenue').val(edit_row.find('.revenue').val());

		$('#flyTimeHour').val(edit_row.find('.flyTimeHour').val());

		$('#flyTimeMin').val(edit_row.find('.flyTimeMin').val());

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

		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="12" class="text-center">Add Entry or Click No Operation</td></tr>`);

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

		var total_areaTreated = 0;

		var total_qLiters = 0;

		var total_revenue = 0;

		var total_flyTimeHour = 0;

		var total_flyTimeMin = 0;

		$('#tableList tbody tr').each(function() {

			if ($(this).find('.distance').length) {

				rows++;

			}

			total_areaTreated += removeComma($(this).find('.areaTreated').val());

			total_qLiters += removeComma($(this).find('.qLiters').val());

			total_revenue += removeComma($(this).find('.revenue').val());

			total_flyTimeHour += removeComma($(this).find('.flyTimeHour').val());

			total_flyTimeMin += removeComma($(this).find('.flyTimeMin').val());

		});

		total_flyTimeHour += Math.floor(total_flyTimeMin / 60);

		total_flyTimeMin = total_flyTimeMin % 60;

		$('.total_row .total_areaTreated').html(addComma(total_areaTreated));

		$('.total_row .total_qLiters').html(addComma(total_qLiters));

		$('.total_row .total_revenue').html(addComma(total_revenue));

		$('.total_row .total_flyTimeHour').html(addComma(total_flyTimeHour, 0));

		$('.total_row .total_flyTimeMin').html(addComma(total_flyTimeMin, 0));

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
			if(!confirm("I, the undersigned of the specified agricultural sprayer, do certifiy that this report has been prepared by my or under my discretion, that I have fully examined it correctly reflects the operating statistics and revenues earned on agricultural sprayer operations of our company and to the best of my knowledge and belief constitue complete and accurate statement."))
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

					<td class="text-center" colspan="12">NO OPERATION<input type="hidden" name="aircraft[]" value="NO OPERATION"></td>

				</tr>

			`;

		} else {

			data.flyTimeHour = removeComma(data.flyTimeHour);

			data.flyTimeMin = removeComma(data.flyTimeMin);

			data.flyTimeHour += Math.floor(data.flyTimeMin / 60);

			data.flyTimeMin = data.flyTimeMin % 60;



			var row = `

				<tr class="entry">

					<td><input type="checkbox"></td>

					<td class="text-center"><span><?php echo $month_name; ?> ` + data.report_day + `</span><input type="hidden" name="report_day[]" class="report_day" value="` + data.report_day + `"></td>

					<td><span>` + data.aircraft + `</span><input type="hidden" name="aircraft[]" class="aircraft" value="` + data.aircraft + `"></td>

					<td><span>` + data.aircraft_num + `</span><input type="hidden" name="aircraft_num[]" class="aircraft_num" value="` + data.aircraft_num + `"></td>

					<td><span>` + data.location + `</span><input type="hidden" name="location[]" class="location" value="` + data.location + `"></td>

					<td><span>` + data.treatment + `</span><input type="hidden" name="treatment[]" class="treatment" value="` + data.treatment + `"></td>

					<td class="text-right"><span>` + addComma(data.areaTreated) + `</span><input type="hidden" name="areaTreated[]" class="areaTreated" value="` + data.areaTreated + `"></td>

					<td class="text-right"><span>` + addComma(data.qLiters) + `</span><input type="hidden" name="qLiters[]" class="qLiters" value="` + data.qLiters + `"></td>

					<td class="text-right"><span>` + addComma(data.revenue) + `</span><input type="hidden" name="revenue[]" class="revenue" value="` + data.revenue + `"></td>

					<td class="text-right"><span>` + data.flyTimeHour + `</span><input type="hidden" name="flyTimeHour[]" class="flyTimeHour" value="` + data.flyTimeHour + `"></td>

					<td class="text-right"><span>` + data.flyTimeMin + `</span><input type="hidden" name="flyTimeMin[]" class="flyTimeMin" value="` + data.flyTimeMin + `"></td>

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

		data.flyTimeHour = removeComma(data.flyTimeHour);

		data.flyTimeMin = removeComma(data.flyTimeMin);

		data.flyTimeHour += Math.floor(data.flyTimeMin / 60);

		data.flyTimeMin = data.flyTimeMin % 60;



		edit_row.find('.report_day').val(data.report_day).closest('td').find('span').html('<?php echo $month_name; ?> ' + data.report_day);

		edit_row.find('.aircraft').val(data.aircraft).closest('td').find('span').html(data.aircraft);

		edit_row.find('.aircraft_num').val(data.aircraft_num).closest('td').find('span').html(data.aircraft_num);

		edit_row.find('.location').val(data.location).closest('td').find('span').html(data.location);

		edit_row.find('.treatment').val(data.treatment).closest('td').find('span').html(data.treatment);

		edit_row.find('.areaTreated').val(data.areaTreated).closest('td').find('span').html(data.areaTreated);

		edit_row.find('.qLiters').val(data.qLiters).closest('td').find('span').html(data.qLiters);

		edit_row.find('.revenue').val(data.revenue).closest('td').find('span').html(data.revenue);

		edit_row.find('.flyTimeHour').val(data.flyTimeHour).closest('td').find('span').html(data.flyTimeHour);

		edit_row.find('.flyTimeMin').val(data.flyTimeMin).closest('td').find('span').html(data.flyTimeMin);



		computeTotal();

	}

	report_details.forEach(function(data) {

		addRow(data);

	});

	checkButtons();

</script>