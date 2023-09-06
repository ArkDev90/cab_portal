<div class="panel panel-primary br-xs">

	<div class="panel-heading bb-colored text-center">

		<?php echo $form_title ?>

	</div>

	<div class="box-body pb-none">

		<ul class="nav nav-tabs" role="tablist">

			<li role="presentation" class="active"><a aria-controls="direct_cargo" role="tab" data-tab="direct_cargo"">DIRECT CARGO</a></li>

			<li role="presentation"><a aria-controls="transit_cargo" data-tab="transit_cargo" role="tab">TRANSIT CARGO</a></li>

		</ul>

		<br>

		<div class="form-group">

			<button type="button" id="confirm_proceed" class="btn btn-primary btn-sm mb-xs">Confirm and Proceed</button>

			<button type="button" id="submit_report" class="btn btn-primary btn-sm mb-xs" style="display: none">Submit Report</button>

			<button type="button" id="no_operation" class="btn btn-warning btn-sm mb-xs">No Operation</button>

			<button type="button" id="save_draft" class="btn btn-default btn-sm mb-xs">Save as Draft</button>

		</div>

		<div class="form-horizontal">

			<div class="row">

				<div class="col-md-6">

					<?php

						echo $ui->formField('text')

								->setLabel('Report Date:')

								->setSplit('col-md-6', 'col-md-6')

								->setValue($month_name . ' ' . $year)

								->draw(false);



						// echo $ui->formField('text')

						// 		->setLabel('Air Carrier:')

						// 		->setSplit('col-md-6', 'col-md-6')

						// 		->setValue('123123123')

						// 		->draw(false);

					?>

				</div>

			</div>

		</div>

		<div class="tab-content">

			<div role="tabpanel" class="tab-pane fade in active" id="direct_cargo">

				<form action="" method="post" id="entry_form" class="form-horizontal">

					<div class="row">

						<div class="col-md-6">

							<?php

								echo $ui->formField('text')

										->setLabel('*Aircraft Used:')

										->setSplit('col-md-6', 'col-md-6')

										->setId('aircraft')

										->setName('aircraft')

										->setValidation('required')

										->draw();

							?>

						</div>

						<div class="col-md-6">

							<?php
								/*
								echo $ui->formField('text')

										->setLabel('*Flight Number:')

										->setSplit('col-md-5', 'col-md-6')

										->setId('flightNum')

										->setName('flightNum')

										->setValidation('required')

										->draw();
								*/

							?>

						</div>

					</div>

					<div class="row">

						<label class="control-label col-md-3">*Routing:</label>

						<div class="col-md-6">

							<div class="row">

								<div class="col-md-6">

									<?php

										echo $ui->formField('dropdown')

												->setPlaceholder('Select One')

												->setSplit('', 'col-md-12')

												->setId('routeFrom')

												->setName('routeFrom')

												->setValidation('required')

												->setList($origin_list)

												->draw();

									?>

								</div>

								<div class="col-md-6">

									<?php

										echo $ui->formField('dropdown')

												->setPlaceholder('Select One')

												->setSplit('', 'col-md-12')

												->setId('routeTo')

												->setName('routeTo')

												->setValidation('required')

												->setList($destination_list)

												->draw();

									?>

								</div>

							</div>

						</div>

					</div>

					<br>

					<h4 class="text-center">DIRECT CARGO</h4>

					<br>

					<table class="table-style">

						<thead>

							<tr>

								<th class="col-xs-2">ROUTE</th>

								<th class="col-xs-2">CARGO (Kilograms) <br> REVENUE</th>

								<th class="col-xs-2">CARGO (Kilograms) <br> NON REVENUE</th>

								<th class="col-xs-2">MAIL (Kilograms) <br> REVENUE</th>

								<th class="col-xs-2">MAIL (Kilograms) <br> NON REVENUE</th>

							</tr>

						</thead>

						<tbody>

							<tr>

								<th class="sector_label">FROM/TO</th>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('cargoRev')

												->setName('cargoRev')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('cargoNonRev')

												->setName('cargoNonRev')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('mailRev')

												->setName('mailRev')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('mailNonRev')

												->setName('mailNonRev')

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

												->setId('cargoRevDep')

												->setName('cargoRevDep')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('cargoNonRevDep')

												->setName('cargoNonRevDep')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('mailRevDep')

												->setName('mailRevDep')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('mailNonRevDep')

												->setName('mailNonRevDep')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

							</tr>

						</tbody>

					</table>

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

									<th colspan="13">DIRECT CARGO (Kilograms)</th>

								</tr>

								<tr class="info">

									<th rowspan="2"><input type="checkbox" class="selectall"></th>

									<th rowspan="2" class="col-md-1">AIRCRAFT</th>

									<th rowspan="2" class="col-md-1">ROUTE</th>

									<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>

									<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>

									<th rowspan="2" class="col-md-1">ROUTE</th>

									<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>

									<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>

									<th rowspan="2" class="col-md-1">EDIT</th>

								</tr>

								<tr class="info">

									<th>REVENUE</th>

									<th>NON REVENUE</th>

									<th>REVENUE</th>

									<th>NON REVENUE</th>

									<th>REVENUE</th>

									<th>NON REVENUE</th>

									<th>REVENUE</th>

									<th>NON REVENUE</th>

								</tr>

							</thead>

							<tbody>



							</tbody>

							<tfoot>

								<tr class="info total_row">

									<th colspan="3" class="text-right">TOTAL:</th>

									<th class="total_cargoRev text-right">0.00</th>

									<th class="total_cargoNonRev text-right">0.00</th>

									<th class="total_mailRev text-right">0.00</th>

									<th class="total_mailNonRev text-right">0.00</th>

									<th></th>

									<th class="total_cargoRevDep text-right">0.00</th>

									<th class="total_cargoNonRevDep text-right">0.00</th>

									<th class="total_mailRevDep text-right">0.00</th>

									<th class="total_mailNonRevDep text-right">0.00</th>

									<th></th>

								</tr>

								<tr class="info">

									<td colspan="10" id="pagination"></td>

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

			<div role="tabpanel" class="tab-pane fade" id="transit_cargo">

				<form action="" method="post" id="entry_form2" class="form-horizontal">

					<div class="row">

						<label class="control-label col-md-3">*Added Routes:</label>

						<div class="col-md-6">

							<div class="row">

								<div class="col-md-6">

									<?php

										echo $ui->formField('dropdown')

												->setPlaceholder('Select One')

												->setSplit('', 'col-md-12')

												->setId('addedRoutes')

												->setName('addedRoutes')

												->setValidation('required')

												->draw();

									?>

								</div>

							</div>

						</div>

					</div>

					<br>

					<h4 class="text-center">TRANSIT CARGO</h4>

					<br>

					<table class="table-style">

						<thead>

							<tr>

								<th class="col-xs-2">ROUTE</th>

								<th class="col-xs-2">CARGO (Kilograms) <br> REVENUE</th>

								<th class="col-xs-2">CARGO (Kilograms) <br> NON REVENUE</th>

								<th class="col-xs-2">MAIL (Kilograms) <br> REVENUE</th>

								<th class="col-xs-2">MAIL (Kilograms) <br> NON REVENUE</th>

							</tr>

						</thead>

						<tbody>

							<tr>

								<th class="t_sector_label">FROM/TO</th>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('cargoRev')

												->setName('cargoRev')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('cargoNonRev')

												->setName('cargoNonRev')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('mailRev')

												->setName('mailRev')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('mailNonRev')

												->setName('mailNonRev')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

							</tr>

							<tr>

								<th class="t_sector_d_label">TO/FROM</th>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('cargoRevDep')

												->setName('cargoRevDep')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('cargoNonRevDep')

												->setName('cargoNonRevDep')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('mailRevDep')

												->setName('mailRevDep')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

								<td>

									<?php

										echo $ui->formField('text')

												->setSplit('', 'col-md-12')

												->setId('mailNonRevDep')

												->setName('mailNonRevDep')

												->setValidation('required decimal')

												->draw();

									?>

								</td>

							</tr>

						</tbody>

					</table>

					<div class="text-center">

						<br>

						<button type="submit" id="add_entry" class="btn btn-primary btn-sm">Add Entry</button>

						<button type="button" id="update_entry" class="btn btn-primary btn-sm" style="display: none;">Update Entry</button>

						<button type="button" id="cancel_edit" class="btn btn-default btn-sm" style="display: none;">Cancel Edit</button>

					</div>

				</form>

				<form action="" method="post" id="entries2">

					<br>

					<div class="text-right">

						<button type="button" class="btn btn-danger btn-sm mb-xs delete_entry">Delete</button>

					</div>

					<div class="table-responsive mb-xs">

						<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">

							<thead>

								<tr class="info">

									<th colspan="13">TRANSIT CARGO (Kilograms)</th>

								</tr>

								<tr class="info">

									<th rowspan="2"><input type="checkbox" class="selectall"></th>

									<th rowspan="2" class="col-md-1">AIRCRAFT</th>

									<th rowspan="2" class="col-md-1">ROUTE</th>

									<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>

									<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>

									<th rowspan="2" class="col-md-1">ROUTE</th>

									<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>

									<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>

									<th rowspan="2" class="col-md-1">EDIT</th>

								</tr>

								<tr class="info">

									<th>REVENUE</th>

									<th>NON REVENUE</th>

									<th>REVENUE</th>

									<th>NON REVENUE</th>

									<th>REVENUE</th>

									<th>NON REVENUE</th>

									<th>REVENUE</th>

									<th>NON REVENUE</th>

								</tr>

							</thead>

							<tbody>



							</tbody>

							<tfoot>

								<tr class="info total_row2">

									<th colspan="3" class="text-right">TOTAL:</th>

									<th class="total_cargoRev text-right">0.00</th>

									<th class="total_cargoNonRev text-right">0.00</th>

									<th class="total_mailRev text-right">0.00</th>

									<th class="total_mailNonRev text-right">0.00</th>

									<th></th>

									<th class="total_cargoRevDep text-right">0.00</th>

									<th class="total_cargoNonRevDep text-right">0.00</th>

									<th class="total_mailRevDep text-right">0.00</th>

									<th class="total_mailNonRevDep text-right">0.00</th>

									<th></th>

								</tr>

								<tr class="info">

									<td colspan="10" id="pagination"></td>

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

	</div>

</div>

<script>

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

		getRoutes();

		checkButtons();

		// $('#entry_form #cancel_edit').trigger('click');

		// $('#entry_form2 #cancel_edit').trigger('click');

	});

	$('#confirm_proceed').click(function() {

		$('a[data-tab="direct_cargo"]').closest('li').removeClass('active');

		$('a[data-tab="transit_cargo"]').closest('li').addClass('active');

		$('#direct_cargo').removeClass('in');

		$('#direct_cargo').removeClass('active');

		$('#transit_cargo').addClass('in');

		$('#transit_cargo').addClass('active');

		$('#confirm_proceed').hide();

		$('#submit_report').show();

		getRoutes();

		checkButtons();

	});

	var report_details = <?php echo json_encode((isset($form_details) && $form_details) ? $form_details : array()) ?>;

	var report_details2 = <?php echo json_encode((isset($form_details2) && $form_details2) ? $form_details2 : array()) ?>;

	$('#tableList').on('ifChanged', '.selectall', function() {

		var check = ($(this).is(':checked')) ? 'check' : 'uncheck';

		$('#tableList tbody input[type="checkbox"]').iCheck(check);

	});

	$('#routeFrom, #routeTo').on('change', function() {

		var sector = $('#routeFrom').val() || 'FROM';

		var sector_d = $('#routeTo').val() || 'TO';

		var sector_label = sector + '/' + sector_d;

		var sector_d_label = sector_d + '/' + sector;



		$('.sector_label').html(sector_label);

		$('.sector_d_label').html(sector_d_label);

	});

	$('#addedRoutes').on('change', function() {

		var temp = $(this).val().split('|');

		var sector = temp[0] || 'FROM';

		var sector_d = temp[1] || 'TO';

		var sector_label = sector + '/' + sector_d;

		var sector_d_label = sector_d + '/' + sector;



		$('.t_sector_label').html(sector_label);

		$('.t_sector_d_label').html(sector_d_label);

	});

	var edit_row = '';

	$('#tableList').on('click', '.edit_entry', function(e) {

		e.preventDefault();

		edit_row = $(this).closest('tr');

		edit_row.addClass('warning');

		$('#entry_form #routeTo').val(edit_row.find('.routeTo').val()).trigger('change');

		$('#entry_form #routeFrom').val(edit_row.find('.routeFrom').val()).trigger('change');

		$('#entry_form #aircraft').val(edit_row.find('.aircraft').val());

		$('#entry_form #flightNum').val(edit_row.find('.flightNum').val());

		$('#entry_form #cargoRev').val(edit_row.find('.cargoRev').val());

		$('#entry_form #cargoNonRev').val(edit_row.find('.cargoNonRev').val());

		$('#entry_form #mailRev').val(edit_row.find('.mailRev').val());

		$('#entry_form #mailNonRev').val(edit_row.find('.mailNonRev').val());

		$('#entry_form #cargoRevDep').val(edit_row.find('.cargoRevDep').val());

		$('#entry_form #cargoNonRevDep').val(edit_row.find('.cargoNonRevDep').val());

		$('#entry_form #mailRevDep').val(edit_row.find('.mailRevDep').val());

		$('#entry_form #mailNonRevDep').val(edit_row.find('.mailNonRevDep').val());

		$('#entry_form').find('.form-group').find('input, textarea, select').trigger('blur');

		$('#entries .delete_entry').attr('disabled', true);

		$('#entry_form #add_entry').hide();

		$('#entry_form #update_entry').show();

		$('#entry_form #cancel_edit').show();

	});

	$('#tableList2').on('click', '.edit_entry', function(e) {

		e.preventDefault();

		edit_row = $(this).closest('tr');

		edit_row.addClass('warning');

		$('#entry_form2 #addedRoutes').val(edit_row.find('.routeFrom').val() + '|' + edit_row.find('.routeTo').val() + '|' + edit_row.find('.aircraft').val()).trigger('change');

		$('#entry_form2 #cargoRev').val(edit_row.find('.cargoRev').val());

		$('#entry_form2 #cargoNonRev').val(edit_row.find('.cargoNonRev').val());

		$('#entry_form2 #mailRev').val(edit_row.find('.mailRev').val());

		$('#entry_form2 #mailNonRev').val(edit_row.find('.mailNonRev').val());

		$('#entry_form2 #cargoRevDep').val(edit_row.find('.cargoRevDep').val());

		$('#entry_form2 #cargoNonRevDep').val(edit_row.find('.cargoNonRevDep').val());

		$('#entry_form2 #mailRevDep').val(edit_row.find('.mailRevDep').val());

		$('#entry_form2 #mailNonRevDep').val(edit_row.find('.mailNonRevDep').val());

		$('#entry_form2').find('.form-group').find('input, textarea, select').trigger('blur');

		$('#entries2 .delete_entry').attr('disabled', true);

		$('#entry_form2 #add_entry').hide();

		$('#entry_form2 #update_entry').show();

		$('#entry_form2 #cancel_edit').show();

	});

	$('#entry_form #update_entry').click(function() {

		$('#entry_form').find('.form-group').find('input, textarea, select').trigger('blur');

		if ($('#entry_form').find('.form-group.has-error').length == 0) {

			var data = {};

			$('#entry_form').serializeArray().map(function(x) {

				data[x.name] = x.value

			});

			updateRow(data);

			$('#entry_form #cancel_edit').trigger('click');

		} else {

			$('#entry_form').find('.form-group.has-error').first().find('input, textarea, select').focus();

		}

	});

	$('#entry_form2 #update_entry').click(function() {

		$('#entry_form2').find('.form-group').find('input, textarea, select').trigger('blur');

		if ($('#entry_form2').find('.form-group.has-error').length == 0) {

			var data = {};

			$('#entry_form2').serializeArray().map(function(x) {

				data[x.name] = x.value

			});

			updateRow2(data);

			$('#entry_form2 #cancel_edit').trigger('click');

		} else {

			$('#entry_form2').find('.form-group.has-error').first().find('input, textarea, select').focus();

		}

	});

	$('#entry_form #cancel_edit').click(function() {

		edit_row.removeClass('warning');

		edit_row = '';



		$('#entry_form #add_entry').show();

		$('#entry_form #update_entry').hide();

		$('#entry_form #cancel_edit').hide();



		$('#entry_form')[0].reset();

		$('#entry_form select').trigger('change.select2');



		$('#entries .delete_entry').attr('disabled', false);



		$('.sector_label').html('FROM/TO');

		$('.sector_d_label').html('TO/FROM');

	});

	$('#entry_form2 #cancel_edit').click(function() {

		edit_row.removeClass('warning');

		edit_row = '';



		$('#entry_form2 #add_entry').show();

		$('#entry_form2 #update_entry').hide();

		$('#entry_form2 #cancel_edit').hide();



		$('#entry_form2')[0].reset();

		$('#entry_form2 select').trigger('change.select2');



		$('#entries2 .delete_entry').attr('disabled', false);



		$('.t_sector_label').html('FROM/TO');

		$('.t_sector_d_label').html('TO/FROM');

	});

	$('#entries .delete_entry').click(function() {

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

	$('#entries2 .delete_entry').click(function() {

		$('#tableList2 tbody input[type="checkbox"]').each(function() {

			if ($(this).is(':checked')) {

				$(this).closest('tr').remove();

			}

		});

		$('.selectall').iCheck('uncheck');

		if ($('#tableList2 tbody tr').length == 0) {

			addNoEntry2();

		}

		computeTotal2();

		checkButtons();

	});

	addNoEntry();

	addNoEntry2();

	function addNoEntry() {

		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="13" class="text-center">Add Entry or Click No Operation</td></tr>`);

	}

	function addNoEntry2() {

		$('#tableList2 tbody').html(`<tr class="no-entry"><td colspan="13" class="text-center">Add Entry or Click No Operation</td></tr>`);

	}

	function checkButtons() {

		var has_entry = !! ($('#tableList tbody .entry').length);

		var has_entry2 = !! ($('#tableList2 tbody .entry').length);

		var no_operation = !! ($('#tableList tbody .no_operation').length);

		var no_operation2 = !! ($('#tableList2 tbody .no_operation').length);

		var page_no_operation = false;

		var page_has_entry = false;

		if ($('#direct_cargo.active').length) {

			page_no_operation = no_operation;

			page_has_entry = has_entry;

		} else if ($('#transit_cargo.active').length) {

			page_no_operation = no_operation2;

			page_has_entry = has_entry2;

		}

		$('#confirm_proceed').attr('disabled', ! (has_entry || no_operation));

		$('#submit_report').attr('disabled', ! ((has_entry || no_operation) && (has_entry2 || no_operation2)));

		$('#save_draft').attr('disabled', ! (has_entry || no_operation));

		$('#no_operation').attr('disabled', page_no_operation);

		$('.delete_entry').attr('disabled', ! page_has_entry);



		$('#tableList .entry_count').html($('#tableList tbody .entry').length);

		$('#tableList2 .entry_count').html($('#tableList2 tbody .entry').length);

	}

	function computeTotal() {

		var total_cargoRev = 0;

		var total_cargoNonRev = 0;

		var total_mailRev = 0;

		var total_mailNonRev = 0;

		var total_cargoRevDep = 0;

		var total_cargoNonRevDep = 0;

		var total_mailRevDep = 0;

		var total_mailNonRevDep = 0;

		$('#tableList tbody tr').each(function() {

			total_cargoRev += removeComma($(this).find('.cargoRev').val());

			total_cargoNonRev += removeComma($(this).find('.cargoNonRev').val());

			total_mailRev += removeComma($(this).find('.mailRev').val());

			total_mailNonRev += removeComma($(this).find('.mailNonRev').val());

			total_cargoRevDep += removeComma($(this).find('.cargoRevDep').val());

			total_cargoNonRevDep += removeComma($(this).find('.cargoNonRevDep').val());

			total_mailRevDep += removeComma($(this).find('.mailRevDep').val());

			total_mailNonRevDep += removeComma($(this).find('.mailNonRevDep').val());

		});

		$('.total_row .total_cargoRev').html(addComma(total_cargoRev));

		$('.total_row .total_cargoNonRev').html(addComma(total_cargoNonRev));

		$('.total_row .total_mailRev').html(addComma(total_mailRev));

		$('.total_row .total_mailNonRev').html(addComma(total_mailNonRev));

		$('.total_row .total_cargoRevDep').html(addComma(total_cargoRevDep));

		$('.total_row .total_cargoNonRevDep').html(addComma(total_cargoNonRevDep));

		$('.total_row .total_mailRevDep').html(addComma(total_mailRevDep));

		$('.total_row .total_mailNonRevDep').html(addComma(total_mailNonRevDep));

	}

	function computeTotal2() {

		var total_cargoRev = 0;

		var total_cargoNonRev = 0;

		var total_mailRev = 0;

		var total_mailNonRev = 0;

		var total_cargoRevDep = 0;

		var total_cargoNonRevDep = 0;

		var total_mailRevDep = 0;

		var total_mailNonRevDep = 0;

		$('#tableList2 tbody tr').each(function() {

			total_cargoRev += removeComma($(this).find('.cargoRev').val());

			total_cargoNonRev += removeComma($(this).find('.cargoNonRev').val());

			total_mailRev += removeComma($(this).find('.mailRev').val());

			total_mailNonRev += removeComma($(this).find('.mailNonRev').val());

			total_cargoRevDep += removeComma($(this).find('.cargoRevDep').val());

			total_cargoNonRevDep += removeComma($(this).find('.cargoNonRevDep').val());

			total_mailRevDep += removeComma($(this).find('.mailRevDep').val());

			total_mailNonRevDep += removeComma($(this).find('.mailNonRevDep').val());

		});

		$('.total_row2 .total_cargoRev').html(addComma(total_cargoRev));

		$('.total_row2 .total_cargoNonRev').html(addComma(total_cargoNonRev));

		$('.total_row2 .total_mailRev').html(addComma(total_mailRev));

		$('.total_row2 .total_mailNonRev').html(addComma(total_mailNonRev));

		$('.total_row2 .total_cargoRevDep').html(addComma(total_cargoRevDep));

		$('.total_row2 .total_cargoNonRevDep').html(addComma(total_cargoNonRevDep));

		$('.total_row2 .total_mailRevDep').html(addComma(total_mailRevDep));

		$('.total_row2 .total_mailNonRevDep').html(addComma(total_mailNonRevDep));

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

		$('.sector_label').html('FROM/TO');

		$('.sector_d_label').html('TO/FROM');

	});

	$('#entry_form2').submit(function(e) {

		e.preventDefault();

		$(this).find('.form-group').find('input, textarea, select').trigger('blur');

		if ($(this).find('.form-group.has-error').length == 0) {

			var data = {};

			$(this).serializeArray().map(function(x) {

				data[x.name] = x.value;

				if (x.name == 'addedRoutes') {

					var temp = x.value.split('|');

					data.routeFrom = temp[0];

					data.routeTo = temp[1];

					data.aircraft = temp[2];

				}

			});

			$(this)[0].reset();

			addRow2(data);

		} else {

			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();

		}

		checkButtons();

		$('.t_sector_label').html('FROM/TO');

		$('.t_sector_d_label').html('TO/FROM');

	});

	var submit_type = '';

	$('#entries').submit(function(e) {

		e.preventDefault();

		var has_entry = !! ($('#tableList tbody .entry').length);

		var has_entry2 = !! ($('#tableList2 tbody .entry').length);

		var no_operation = !! ($('#tableList tbody .no_operation').length);

		var no_operation2 = !! ($('#tableList2 tbody .no_operation').length);

		var page_no_operation = false;

		var page_has_entry = false;

		if ($('#direct_cargo.active').length) {

			page_no_operation = no_operation;

			page_has_entry = has_entry;

		} else if ($('#transit_cargo.active').length) {

			page_no_operation = no_operation2;

			page_has_entry = has_entry2;

		}

		var submit_report = (has_entry || no_operation) && (has_entry2 || no_operation2);

		var save_draft = submit_type == 'draft' && ((has_entry || no_operation));

		if (submit_report || save_draft) {

			$('#submit_report').attr('disabled', true);

			$('#save_draft').attr('disabled', true);

			$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '&' + $('#entries2').serialize() + '&report_month=<?php echo $report_month; ?>&year=<?php echo $year; ?>&submit_type=' + submit_type + '<?=$ajax_post?>', function(data) {

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
			if(!confirm("I, the undersigned of the specified airline, do certifiy that this report has been prepared by my or under my discretion, that I have fully examined it correctly reflects the operating statistics and revenues earned on airline operations of our company and to the best of my knowledge and belief constitue complete and accurate statement."))
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

		if ($('#direct_cargo.active').length) {

			$('#tableList tbody').html('');

			addRow(data);

		}

		$('#tableList2 tbody').html('');

		addRow2(data);

		checkButtons();

	});

	function addRow(data) {

		if (data.aircraft == 'NO OPERATION') {

			var row = `

				<tr class="no_operation">

					<td class="text-center" colspan="13">NO OPERATION<input type="hidden" name="aircraft[]" value="NO OPERATION"></td>

				</tr>

			`;

		} else {

			var row = `

				<tr class="entry">

					<td><input type="checkbox"></td>

					<td><span>` + data.aircraft + `</span><input type="hidden" name="aircraft[]" class="aircraft" value="` + data.aircraft + `"></td>

					<td><span class="firstRoute">` + data.routeFrom + ` - ` + data.routeTo + `</span><input type="hidden" name="routeTo[]" class="routeTo" value="` + data.routeTo + `"><input type="hidden" name="routeFrom[]" class="routeFrom" value="` + data.routeFrom + `"><input type="hidden" name="flightNum[]" class="flightNum" value="` + data.flightNum + `"></td>

					<td class="text-right"><span>` + data.cargoRev + `</span><input type="hidden" name="cargoRev[]" class="cargoRev" value="` + data.cargoRev + `"></td>

					<td class="text-right"><span>` + data.cargoNonRev + `</span><input type="hidden" name="cargoNonRev[]" class="cargoNonRev" value="` + data.cargoNonRev + `"></td>

					<td class="text-right"><span>` + data.mailRev + `</span><input type="hidden" name="mailRev[]" class="mailRev" value="` + data.mailRev + `"></td>

					<td class="text-right"><span>` + data.mailNonRev + `</span><input type="hidden" name="mailNonRev[]" class="mailNonRev" value="` + data.mailNonRev + `"></td>

					<td><span class="lastRoute">` + data.routeTo + ` - ` + data.routeFrom + `</span></td>

					<td class="text-right"><span>` + data.cargoRevDep + `</span><input type="hidden" name="cargoRevDep[]" class="cargoRevDep" value="` + data.cargoRevDep + `"></td>

					<td class="text-right"><span>` + data.cargoNonRevDep + `</span><input type="hidden" name="cargoNonRevDep[]" class="cargoNonRevDep" value="` + data.cargoNonRevDep + `"></td>

					<td class="text-right"><span>` + data.mailRevDep + `</span><input type="hidden" name="mailRevDep[]" class="mailRevDep" value="` + data.mailRevDep + `"></td>

					<td class="text-right"><span>` + data.mailNonRevDep + `</span><input type="hidden" name="mailNonRevDep[]" class="mailNonRevDep" value="` + data.mailNonRevDep + `"></td>

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

	function addRow2(data) {

		if (data.aircraft == 'NO OPERATION') {

			var row = `

				<tr class="no_operation">

					<td class="text-center" colspan="13">NO OPERATION<input type="hidden" name="t_aircraft[]" value="NO OPERATION"></td>

				</tr>

			`;

		} else {

			var row = `

				<tr class="entry">

					<td><input type="checkbox"></td>

					<td><span>` + data.aircraft + `</span><input type="hidden" name="t_aircraft[]" class="aircraft" value="` + data.aircraft + `"></td>

					<td><span class="firstRoute">` + data.routeFrom + ` - ` + data.routeTo + `</span><input type="hidden" name="t_routeTo[]" class="routeTo" value="` + data.routeTo + `"><input type="hidden" name="t_routeFrom[]" class="routeFrom" value="` + data.routeFrom + `"></td>

					<td class="text-right"><span>` + data.cargoRev + `</span><input type="hidden" name="t_cargoRev[]" class="cargoRev" value="` + data.cargoRev + `"></td>

					<td class="text-right"><span>` + data.cargoNonRev + `</span><input type="hidden" name="t_cargoNonRev[]" class="cargoNonRev" value="` + data.cargoNonRev + `"></td>

					<td class="text-right"><span>` + data.mailRev + `</span><input type="hidden" name="t_mailRev[]" class="mailRev" value="` + data.mailRev + `"></td>

					<td class="text-right"><span>` + data.mailNonRev + `</span><input type="hidden" name="t_mailNonRev[]" class="mailNonRev" value="` + data.mailNonRev + `"></td>

					<td><span class="lastRoute">` + data.routeTo + ` - ` + data.routeFrom + `</span></td>

					<td class="text-right"><span>` + data.cargoRevDep + `</span><input type="hidden" name="t_cargoRevDep[]" class="cargoRevDep" value="` + data.cargoRevDep + `"></td>

					<td class="text-right"><span>` + data.cargoNonRevDep + `</span><input type="hidden" name="t_cargoNonRevDep[]" class="cargoNonRevDep" value="` + data.cargoNonRevDep + `"></td>

					<td class="text-right"><span>` + data.mailRevDep + `</span><input type="hidden" name="t_mailRevDep[]" class="mailRevDep" value="` + data.mailRevDep + `"></td>

					<td class="text-right"><span>` + data.mailNonRevDep + `</span><input type="hidden" name="t_mailNonRevDep[]" class="mailNonRevDep" value="` + data.mailNonRevDep + `"></td>

					<td class="text-center"><a href="#edit" class="edit_entry text-info">Edit</a></td>

				</tr>

			`;

		}

		$('#tableList2 tbody .no-entry').remove();

		$('#tableList2 tbody .no_operation').remove();

		$('#tableList2 tbody').append(row);

		if (typeof drawTemplate === 'function') {

			drawTemplate();

		}

		computeTotal2();

		checkButtons();

	}

	function getRoutes() {

		added_routes = [];

		$('#addedRoutes').html('<option></option>');

		$('#tableList tbody .entry').each(function() {

			$('#addedRoutes').append('<option value="' +  $(this).find('.routeFrom').val() + '|' + $(this).find('.routeTo').val() + '|' + $(this).find('.aircraft').val() + '">' + $(this).find('.routeFrom').val() + '-' + $(this).find('.routeTo').val() + '</option>');

		});

	}

	function updateRow(data) {

		edit_row.find('.aircraft').val(data.aircraft).closest('td').find('span').html(data.aircraft);

		edit_row.find('.routeTo').val(data.routeTo);

		edit_row.find('.routeFrom').val(data.routeFrom);

		edit_row.find('.flightNum').val(data.flightNum);

		edit_row.find('.cargoRev').val(data.cargoRev).closest('td').find('span').html(data.cargoRev);

		edit_row.find('.cargoNonRev').val(data.cargoNonRev).closest('td').find('span').html(data.cargoNonRev);

		edit_row.find('.mailRev').val(data.mailRev).closest('td').find('span').html(data.mailRev);

		edit_row.find('.mailNonRev').val(data.mailNonRev).closest('td').find('span').html(data.mailNonRev);

		edit_row.find('.cargoRevDep').val(data.cargoRevDep).closest('td').find('span').html(data.cargoRevDep);

		edit_row.find('.cargoNonRevDep').val(data.cargoNonRevDep).closest('td').find('span').html(data.cargoNonRevDep);

		edit_row.find('.mailRevDep').val(data.mailRevDep).closest('td').find('span').html(data.mailRevDep);

		edit_row.find('.mailNonRevDep').val(data.mailNonRevDep).closest('td').find('span').html(data.mailNonRevDep);

		edit_row.find('.firstRoute').html(data.routeFrom + ' - ' + data.routeTo);

		edit_row.find('.lastRoute').html(data.routeTo + ' - ' + data.routeFrom);



		computeTotal();

	}

	function updateRow2(data) {

		var temp = data.addedRoutes.split('|');

		data.routeFrom = temp[0];

		data.routeTo = temp[1];

		data.aircraft = temp[2];

		edit_row.find('.aircraft').val(data.aircraft).closest('td').find('span').html(data.aircraft);

		edit_row.find('.routeTo').val(data.routeTo);

		edit_row.find('.routeFrom').val(data.routeFrom);

		edit_row.find('.flightNum').val(data.flightNum);

		edit_row.find('.cargoRev').val(data.cargoRev).closest('td').find('span').html(data.cargoRev);

		edit_row.find('.cargoNonRev').val(data.cargoNonRev).closest('td').find('span').html(data.cargoNonRev);

		edit_row.find('.mailRev').val(data.mailRev).closest('td').find('span').html(data.mailRev);

		edit_row.find('.mailNonRev').val(data.mailNonRev).closest('td').find('span').html(data.mailNonRev);

		edit_row.find('.cargoRevDep').val(data.cargoRevDep).closest('td').find('span').html(data.cargoRevDep);

		edit_row.find('.cargoNonRevDep').val(data.cargoNonRevDep).closest('td').find('span').html(data.cargoNonRevDep);

		edit_row.find('.mailRevDep').val(data.mailRevDep).closest('td').find('span').html(data.mailRevDep);

		edit_row.find('.mailNonRevDep').val(data.mailNonRevDep).closest('td').find('span').html(data.mailNonRevDep);

		edit_row.find('.firstRoute').html(data.routeFrom + ' - ' + data.routeTo);

		edit_row.find('.lastRoute').html(data.routeTo + ' - ' + data.routeFrom);



		computeTotal2();

	}

	report_details.forEach(function(data) {

		addRow(data);

	});

	report_details2.forEach(function(data) {

		addRow2(data);

	});

	checkButtons();

</script>