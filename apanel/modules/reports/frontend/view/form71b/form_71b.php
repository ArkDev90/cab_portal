<div class="panel panel-primary br-xs">

	<div class="panel-heading bb-colored text-center">

		<?php echo $form_title ?>

	</div>

	<div class="box-body pb-none">

		<ul class="nav nav-tabs" role="tablist">

			<li role="presentation" class="active"><a href="#cargo_direct" aria-controls="cargo_direct" role="tab" data-toggle="tab">CARGO DIRECT</a></li>

			<li role="presentation"><a href="#cargo_consolidation" aria-controls="cargo_consolidation" role="tab" data-toggle="tab">CARGO CONSOLIDATION</a></li>

			<li role="presentation"><a href="#serial_number" aria-controls="serial_number" role="tab" data-toggle="tab">SERIAL NUMBER</a></li>

			<li role="presentation"><a href="#cargo_breakbulking" aria-controls="cargo_breakbulking" role="tab" data-toggle="tab">CARGO BREAKBULKING</a></li>

		</ul>

		<br>

		<div class="form-group">

			<button type="button" id="submit_report" class="btn btn-primary btn-sm mb-xs">Submit Report</button>

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

					?>

				</div>

			</div>

		</div>

		<div class="tab-content">

			<div role="tabpanel" class="tab-pane fade in active" id="cargo_direct">

				<form action="" method="post" id="entry_form" class="form-horizontal">

					<h4 class="text-center">CARGO DIRECT SHIPMENT</h4>

					<div class="row">

						<div class="col-md-6">

							<?php

								echo $ui->formField('dropdown')

										->setLabel('*Origin:')

										->setPlaceholder('Select One')

										->setSplit('col-md-5', 'col-md-7')

										->setId('origin')

										->setName('origin')

										->setValidation('required')

										->setList($domestic_list)

										->draw();

							?>

						</div>

						<div class="col-md-6">

							<?php

								echo $ui->formField('dropdown')

										->setLabel('*Destination:')

										->setPlaceholder('Select One')

										->setSplit('col-md-5', 'col-md-7')

										->setId('destination')

										->setName('destination')

										->setValidation('required')

										->setList($domestic_list)

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

										->setLabel('*No. of AWBs Used:')

										->setSplit('col-md-5', 'col-md-7')

										->setId('numMawbs')

										->setName('numMawbs')

										->setValidation('required decimal')

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

									<th colspan="9">CARGO DIRECT SHIPMENTS</th>

								</tr>

								<tr class="info">

									<th><input type="checkbox" class="selectall"></th>

									<th class="col-md-2">AIR CARRIER</th>

									<th class="col-md-2">ORIGIN</th>

									<th class="col-md-2">DESTINATION</th>

									<th class="col-md-1">NUMBER OF AWBs USED</th>

									<th class="col-md-1">CHARGEABLE WEIGHT (Kilograms)</th>

									<th class="col-md-2">AIRLINE FREIGHT CHARGES (Philippine Peso)</th>

									<th class="col-md-1">COMMISSION EARNED (Philippine Peso)</th>

									<th class="col-md-1">EDIT</th>

								</tr>

							</thead>

							<tbody>



							</tbody>

							<tfoot>

								<tr class="info total_row">

									<th colspan="4" class="text-right">TOTAL:</th>

									<th class="total_numMawbs text-right">0.00</th>

									<th class="total_weight text-right">0.00</th>

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

			<div role="tabpanel" class="tab-pane fade" id="cargo_consolidation">

				<form action="" method="post" id="entry_form2" class="form-horizontal">

					<h4 class="text-center">CARGO CONSOLIDATION</h4>

					<div class="row">

						<div class="col-md-6">

							<?php

								echo $ui->formField('text')

										->setLabel('*Airline:')

										->setSplit('col-md-5', 'col-md-7')

										->setId('aircraft')

										->setName('aircraft')

										->setValidation('required')

										->draw();

							?>

						</div>

						<div class="col-md-6">

							<?php

								echo $ui->formField('dropdown')

										->setLabel('*Destination:')

										->setPlaceholder('Select One')

										->setSplit('col-md-5', 'col-md-7')

										->setId('destination')

										->setName('destination')

										->setValidation('required')

										->setList($domestic_list)

										->draw();

							?>

						</div>

					</div>

					<div class="row">

						<div class="col-md-6">

							<?php

								echo $ui->formField('text')

										->setLabel('*No. of MAWBs Used:')

										->setSplit('col-md-5', 'col-md-7')

										->setId('numMawbs')

										->setName('numMawbs')

										->setValidation('required decimal')

										->draw();

							?>

						</div>

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

					</div>

					<div class="row">

						<div class="col-md-6">

							<?php

								echo $ui->formField('text')

										->setLabel('*No. of HAWBs Used:')

										->setSplit('col-md-5', 'col-md-7')

										->setId('numHawbs1')

										->setName('numHawbs1')

										->setValidation('required decimal')

										->draw();

							?>

						</div>

						<div class="col-md-6">

							<?php

								echo $ui->formField('text')

										->setLabel('*Gross Revenue:')

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

				<form action="" method="post" id="entries2">

					<br>

					<div class="text-right">

						<button type="button" class="btn btn-danger btn-sm mb-xs delete_entry">Delete</button>

					</div>

					<div class="table-responsive mb-xs">

						<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">

							<thead>

								<tr class="info">

									<th colspan="9">CARGO CONSOLIDATION</th>

								</tr>

								<tr class="info">

									<th rowspan="2"><input type="checkbox" class="selectall"></th>

									<th rowspan="2" class="col-md-2">AIRFREIGHT FORWARDER</th>

									<th rowspan="2" class="col-md-2">DESTINATION</th>

									<th colspan="2" class="col-md-2">NUMBER OF AWBs USED</th>

									<th rowspan="2" class="col-md-1">CHARGEABLE WEIGHT (Kilograms)</th>

									<th rowspan="2" class="col-md-2">AIRLINE FREIGHT CHARGES (Philippine Peso)</th>

									<th rowspan="2" class="col-md-2">GROSS CONSOLIDATED REVENUE  (Philippine Peso)</th>

									<th rowspan="2" class="col-md-1">EDIT</th>

								</tr>

								<tr class="info">

									<th>MAWB</th>

									<th>HAWB</th>

								</tr>

							</thead>

							<tbody>



							</tbody>

							<tfoot>

								<tr class="info total_row2">

									<th colspan="3" class="text-right">TOTAL:</th>

									<th class="total_numMawbs text-right">0.00</th>

									<th class="total_numHawbs1 text-right">0.00</th>

									<th class="total_weight text-right">0.00</th>

									<th class="total_fcharge text-right">0.00</th>

									<th class="total_revenue text-right">0.00</th>

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

			<div role="tabpanel" class="tab-pane fade" id="cargo_breakbulking">

				<form action="" method="post" id="entry_form3" class="form-horizontal">

					<h4 class="text-center">CARGO BREAKBULKING</h4>

					<div class="row">

						<div class="col-md-6">

							<?php

								echo $ui->formField('dropdown')

										->setLabel('*Origin:')

										->setPlaceholder('Select One')

										->setSplit('col-md-5', 'col-md-7')

										->setId('origin')

										->setName('origin')

										->setValidation('required')

										->setList($domestic_list)

										->draw();

							?>

						</div>

						<div class="col-md-6">

							<?php

								echo $ui->formField('text')

										->setLabel('*Total Number of HAWBs used:')

										->setSplit('col-md-5', 'col-md-7')

										->setId('numHawbs2')

										->setName('numHawbs2')

										->setValidation('required decimal')

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

										->setId('orgWeight')

										->setName('orgWeight')

										->setAddon(array('class' => '', 'value' => 'Kilograms'))

										->setValidation('required decimal')

										->draw();

							?>

						</div>

						<div class="col-md-6">

							<?php

								echo $ui->formField('text')

										->setLabel('*Income for Breakbulking:')

										->setSplit('col-md-5', 'col-md-7')

										->setId('incomeBreak')

										->setName('incomeBreak')

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

				<form action="" method="post" id="entries3">

					<br>

					<div class="text-right">

						<button type="button" class="btn btn-danger btn-sm mb-xs delete_entry">Delete</button>

					</div>

					<div class="table-responsive mb-xs">

						<table id="tableList3" class="table table-hover table-bordered table-sidepad mb-none">

							<thead>

								<tr class="info">

									<th colspan="6">CARGO BREAKBULKING</th>

								</tr>

								<tr class="info">

									<th><input type="checkbox" class="selectall"></th>

									<th class="col-md-3">ORIGIN</th>

									<th class="col-md-3">TOTAL NO. OF HAWBs USED</th>

									<th class="col-md-3">CHARGEABLE WEIGHT (Kilograms)</th>

									<th class="col-md-2">INCOME FROM BREAKBULKING (Philippine Peso)</th>

									<th class="col-md-1">EDIT</th>

								</tr>

							</thead>

							<tbody>



							</tbody>

							<tfoot>

								<tr class="info total_row3">

									<th colspan="2" class="text-right">TOTAL:</th>

									<th class="total_numHawbs2 text-right">0.00</th>

									<th class="total_orgWeight text-right">0.00</th>

									<th class="total_incomeBreak text-right">0.00</th>

									<th></th>

								</tr>

								<tr class="info">

									<td colspan="4" id="pagination"></td>

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

			<div role="tabpanel" class="tab-pane fade" id="serial_number">

				<h4 class="text-center">SERIAL NUMBER</h4>

				<form action="" method="post" id="entries4">

					<table id="tableList4" class="table table-bordered table-sidepad mb-none">

						<thead>

							<tr class="info">

								<th colspan="2">AIRWAY BILL SERIAL NO.;</th>

							</tr>

						</thead>

						<tbody>

							<tr>

								<td class="col-md-4 text-center info">

									<b>

										Range <br>

										(ex. S0004-S0090) <br>

										Separate by Comma (,) <br>

										(ex. S0004-S0090,S00100,S00120-S00125)

									</b>

								</td>

								<td class="col-md-8">

									<?php

										echo $ui->setElement('textarea')

												->setPlaceholder('Input Serial Number Range Here')

												->setId('serialnum')

												->setName('serialnum')

												->setValue($serialnum)

												->draw();

									?>

									<p id="included_error" class="help-block m-none"></p>

								</td>

							</tr>

							<tr>

								<td class="col-md-4 text-center info">

									<b>

										Excluded List <br>

										(ex. S0005-S0010) <br>

										Separate by Comma (,) <br>

										(ex. S0004-S0010,S00121)

									</b>

								</td>

								<td class="col-md-8">

									<?php

										echo $ui->setElement('textarea')

												->setPlaceholder('Input Exluded List Here')

												->setId('excluded')

												->setName('excluded')

												->setValue($excluded)

												->draw();

									?>

									<p id="excluded_error" class="help-block m-none"></p>

								</td>

							</tr>

						</tbody>

						<tfoot>

							<tr class="info">

								<td class="text-center"><b>Total Hawbs</b></td>

								<td class="text-center"><b id="totalhawbs">0</b></td>

							</tr>

						</tfoot>

					</table>

				</form>

			</div>

		</div>

	</div>

</div>

<script>

	$('[href="#serial_number"]').hide();

	$('#serialnum, #excluded').on('input change', function() {

		var range = $('#serialnum').val().replace(/(?:\r\n|\r|\n|,)/g, ',').replace(/ /g,"").split(',');

		var excluded = $('#excluded').val().replace(/(?:\r\n|\r|\n|,)/g, ',').replace(/ /g,"").split(',');

		var count = 0;

		var included_list = [];

		var excluded_list = [];

		var included_error = '';

		var excluded_error = '';

		excluded.forEach(function(val) {

			var cur_excluded = val.split('-');

			if (cur_excluded.length == 1) {

				if (cur_excluded[0] != '') {

					excluded_list.push(cur_excluded[0]);

				}

			} else if (cur_excluded.length > 1) {

				var value1 = cur_excluded[0].match(/\d+$/);

				value1 = value1 ? value1[0] : '';

				var pre1 = cur_excluded[0].replace(value1, '');

				var value2 = cur_excluded[cur_excluded.length - 1].match(/\d+$/);

				value2 = value2 ? value2[0] : '';

				var pre2 = cur_excluded[cur_excluded.length - 1].replace(value2, '');

				if ((pre1 == pre2 && value1.length == value2.length) || (pre1 == '' && pre2 == '')) {

					for (var x = parseInt(value1); x <= parseInt(value2); x++) {

						var y = x + '';

						while (y.length < value1.length && pre1 != '') y = "0" + y;

						if (pre1 + y != '') {

							excluded_list.push(pre1 + y);

						}

					}

				} else if (value1.length != value2.length) {

					excluded_error += '(' + val + ') Range has Different Length.';

				} else if (pre1 != pre2) {

					excluded_error += '(' + val + ') Range has Different Pre Text.';

				}

			}

		});

		range.forEach(function(val) {

			var cur_range = val.split('-');

			if (cur_range.length == 1) {

				if (excluded_list.indexOf(cur_range[0]) == -1 && cur_range[0] != '') {

					included_list.push(cur_range[0]);

				}

			} else if (cur_range.length > 1) {

				var value1 = cur_range[0].match(/\d+$/);

				value1 = value1 ? value1[0] : '';

				var pre1 = cur_range[0].replace(value1, '');

				var value2 = cur_range[cur_range.length - 1].match(/\d+$/);

				value2 = value2 ? value2[0] : '';

				var pre2 = cur_range[cur_range.length - 1].replace(value2, '');

				if ((pre1 == pre2 && value1.length == value2.length) || (pre1 == '' && pre2 == '')) {

					for (var x = parseInt(value1); x <= parseInt(value2); x++) {

						var y = x + '';

						while (y.length < value1.length && pre1 != '') y = "0" + y;

						if (excluded_list.indexOf(pre1 + y) == -1 && pre1 + y != '') {

							included_list.push(pre1 + y);

						}

					}

				} else if (value1.length != value2.length) {

					included_error += '(' + val + ') Range has Different Length.';

				} else if (pre1 != pre2) {

					included_error += '(' + val + ') Range has Different Pre Text.';

				}

			}

		});

		$('#included_error').html(included_error).css('color', 'red');

		$('#excluded_error').html(excluded_error).css('color', 'red');

		$("#totalhawbs").text(included_list.length);

	});

	$('#serialnum').trigger('change');

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

		getRoutes();

		checkButtons();

		$('#entry_form #cancel_edit').trigger('click');

		$('#entry_form2 #cancel_edit').trigger('click');

		$('#entry_form3 #cancel_edit').trigger('click');

	});

	var report_details = <?php echo json_encode((isset($form_details) && $form_details) ? $form_details : array()) ?>;

	var report_details2 = <?php echo json_encode((isset($form_details2) && $form_details2) ? $form_details2 : array()) ?>;

	var report_details3 = <?php echo json_encode((isset($form_details3) && $form_details3) ? $form_details3 : array()) ?>;

	$('#tableList').on('ifChanged', '.selectall', function() {

		var check = ($(this).is(':checked')) ? 'check' : 'uncheck';

		$('#tableList tbody input[type="checkbox"]').iCheck(check);

	});

	var edit_row = '';

	$('#tableList').on('click', '.edit_entry', function(e) {

		e.preventDefault();

		edit_row = $(this).closest('tr');

		edit_row.addClass('warning');

		$('#entry_form #aircraft').val(edit_row.find('.aircraft').val());

		$('#entry_form #origin').val(edit_row.find('.origin').val()).trigger('change');

		$('#entry_form #destination').val(edit_row.find('.destination').val()).trigger('change');

		$('#entry_form #numMawbs').val(edit_row.find('.numMawbs').val());

		$('#entry_form #weight').val(edit_row.find('.weight').val());

		$('#entry_form #fcharge').val(edit_row.find('.fcharge').val());

		$('#entry_form #commission').val(edit_row.find('.commission').val());

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

		$('#entry_form2 #aircraft').val(edit_row.find('.aircraft').val());

		$('#entry_form2 #destination').val(edit_row.find('.destination').val()).trigger('change');

		$('#entry_form2 #numMawbs').val(edit_row.find('.numMawbs').val());

		$('#entry_form2 #weight').val(edit_row.find('.weight').val());

		$('#entry_form2 #numHawbs1').val(edit_row.find('.numHawbs1').val());

		$('#entry_form2 #revenue').val(edit_row.find('.revenue').val());

		$('#entry_form2 #fcharge').val(edit_row.find('.fcharge').val());

		$('#entry_form2').find('.form-group').find('input, textarea, select').trigger('blur');

		$('#entries2 .delete_entry').attr('disabled', true);

		$('#entry_form2 #add_entry').hide();

		$('#entry_form2 #update_entry').show();

		$('#entry_form2 #cancel_edit').show();

	});

	$('#tableList3').on('click', '.edit_entry', function(e) {

		e.preventDefault();

		edit_row = $(this).closest('tr');

		edit_row.addClass('warning');

		$('#entry_form3 #origin').val(edit_row.find('.origin').val()).trigger('change');

		$('#entry_form3 #numHawbs2').val(edit_row.find('.numHawbs2').val());

		$('#entry_form3 #orgWeight').val(edit_row.find('.orgWeight').val());

		$('#entry_form3 #incomeBreak').val(edit_row.find('.incomeBreak').val());

		$('#entry_form3').find('.form-group').find('input, textarea, select').trigger('blur');

		$('#entries3 .delete_entry').attr('disabled', true);

		$('#entry_form3 #add_entry').hide();

		$('#entry_form3 #update_entry').show();

		$('#entry_form3 #cancel_edit').show();

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

	$('#entry_form3 #update_entry').click(function() {

		$('#entry_form3').find('.form-group').find('input, textarea, select').trigger('blur');

		if ($('#entry_form3').find('.form-group.has-error').length == 0) {

			var data = {};

			$('#entry_form3').serializeArray().map(function(x) {

				data[x.name] = x.value

			});

			updateRow3(data);

			$('#entry_form3 #cancel_edit').trigger('click');

		} else {

			$('#entry_form3').find('.form-group.has-error').first().find('input, textarea, select').focus();

		}

	});
	$('#entry_form #cancel_edit').click(function() {

		//edit_row.removeClass('warning');

		edit_row = '';



		$('#entry_form #add_entry').show();

		$('#entry_form #update_entry').hide();

		$('#entry_form #cancel_edit').hide();



		$('#entry_form')[0].reset();

		$('#entry_form select').trigger('change.select2');



		$('#entries .delete_entry').attr('disabled', false);

	});

	$('#entry_form2 #cancel_edit').click(function() {

		//edit_row.removeClass('warning');

		edit_row = '';



		$('#entry_form2 #add_entry').show();

		$('#entry_form2 #update_entry').hide();

		$('#entry_form2 #cancel_edit').hide();



		$('#entry_form2')[0].reset();

		$('#entry_form2 select').trigger('change.select2');



		$('#entries2 .delete_entry').attr('disabled', false);

	});

	$('#entry_form3 #cancel_edit').click(function() {

		//edit_row.removeClass('warning');

		edit_row = '';



		$('#entry_form3 #add_entry').show();

		$('#entry_form3 #update_entry').hide();

		$('#entry_form3 #cancel_edit').hide();



		$('#entry_form3')[0].reset();

		$('#entry_form3 select').trigger('change.select2');



		$('#entries3 .delete_entry').attr('disabled', false);

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

	$('#entries3 .delete_entry').click(function() {

		$('#tableList3 tbody input[type="checkbox"]').each(function() {

			if ($(this).is(':checked')) {

				$(this).closest('tr').remove();

			}

		});

		$('.selectall').iCheck('uncheck');

		if ($('#tableList3 tbody tr').length == 0) {

			addNoEntry3();

		}

		computeTotal3();

		checkButtons();

	});

	addNoEntry();

	addNoEntry2();

	addNoEntry3();

	function addNoEntry() {

		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="9" class="text-center">Add Entry or Click No Operation</td></tr>`);

	}

	function addNoEntry2() {

		$('#tableList2 tbody').html(`<tr class="no-entry"><td colspan="9" class="text-center">Add Entry or Click No Operation</td></tr>`);

	}

	function addNoEntry3() {

		$('#tableList3 tbody').html(`<tr class="no-entry"><td colspan="6" class="text-center">Add Entry or Click No Operation</td></tr>`);

	}

	function checkButtons() {

		var has_entry = !! ($('#tableList tbody .entry').length);

		var has_entry2 = !! ($('#tableList2 tbody .entry').length);

		var has_entry3 = !! ($('#tableList3 tbody .entry').length);

		var no_operation = !! ($('#tableList tbody .no_operation').length);

		var no_operation2 = !! ($('#tableList2 tbody .no_operation').length);

		var no_operation3 = !! ($('#tableList3 tbody .no_operation').length);

		var page_no_operation = false;

		var page_has_entry = false;



		if ($('#cargo_direct.active').length) {

			page_no_operation = no_operation;

			page_has_entry = has_entry;

		} else if ($('#cargo_consolidation.active').length) {

			page_no_operation = no_operation2;

			page_has_entry = has_entry2;

		} else if ($('#cargo_breakbulking.active').length) {

			page_no_operation = no_operation3;

			page_has_entry = has_entry3;

		}
		console.log((has_entry && $('#serial_number #serialnum').val() != '') || no_operation);
		console.log((has_entry2 && $('#serial_number #serialnum').val() != '') || no_operation2);
		$('#submit_report').attr('disabled', ! 
			(
				$('#tableList4 #included_error').html() == '' && 
				$('#tableList4 #excluded_error').html() == '' &&
				(has_entry || no_operation) && 
				(has_entry2 || no_operation2) && 	
				(has_entry3 || no_operation3) && 
				((has_entry && $('#serial_number #serialnum').val() != '') || no_operation) &&  
				((has_entry2 && $('#serial_number #serialnum').val() != '') || no_operation2)  
					
			)
		);


		$('#save_draft').attr('disabled', ! ((has_entry || no_operation) || (has_entry2 || no_operation2) || (has_entry3 || no_operation3)));

		$('#no_operation').attr('disabled', page_no_operation);

		$('.delete_entry').attr('disabled', ! page_has_entry);



		$('#tableList .entry_count').html($('#tableList tbody .entry').length);

		$('#tableList2 .entry_count').html($('#tableList2 tbody .entry').length);

		$('#tableList3 .entry_count').html($('#tableList3 tbody .entry').length);

		if ($('#tableList tbody .entry').length > 0 || $('#tableList2 tbody .entry').length > 0) {

			$('[href="#serial_number"]').show();

		} else {

			$('#serial_number #serialnum').val('');

		}

	}

	$('#entries4').on('blur', '#serialnum', function() {
		var has_entry = !! ($('#tableList tbody .entry').length);

		var has_entry2 = !! ($('#tableList2 tbody .entry').length);

		var has_entry3 = !! ($('#tableList3 tbody .entry').length);

		var no_operation = !! ($('#tableList tbody .no_operation').length);

		var no_operation2 = !! ($('#tableList2 tbody .no_operation').length);

		var no_operation3 = !! ($('#tableList3 tbody .no_operation').length);


		console.log(has_entry);
		console.log(has_entry2);
		console.log(has_entry3);
		if ($('#tableList4 #included_error').html() == '' && $('#tableList4 #excluded_error').html() == '') {
			//$('#submit_report').attr('disabled', false);
			
			$('#submit_report').attr('disabled', ! 
				(
					$('#tableList4 #included_error').html() == '' && 
					$('#tableList4 #excluded_error').html() == '' &&
					(has_entry || no_operation) && 
					(has_entry2 || no_operation2) && 	
					(has_entry3 || no_operation3) && 
					((has_entry && $('#serial_number #serialnum').val() != '') || no_operation) &&  
					((has_entry2 && $('#serial_number #serialnum').val() != '') || no_operation2)  
						
				)
			);
			
		

		}

		else {

			$('#submit_report').attr('disabled', true);

		}

	});

	function computeTotal() {

		var total_numMawbs = 0;

		var total_weight = 0;

		var total_fcharge = 0;

		var total_commission = 0;

		$('#tableList tbody tr').each(function() {

			total_numMawbs += removeComma($(this).find('.numMawbs').val());

			total_weight += removeComma($(this).find('.weight').val());

			total_fcharge += removeComma($(this).find('.fcharge').val());

			total_commission += removeComma($(this).find('.commission').val());

		});

		$('.total_row .total_numMawbs').html(addComma(total_numMawbs));

		$('.total_row .total_weight').html(addComma(total_weight));

		$('.total_row .total_fcharge').html(addComma(total_fcharge));

		$('.total_row .total_commission').html(addComma(total_commission));

	}

	function computeTotal2() {

		var total_numMawbs = 0;

		var total_weight = 0;

		var total_numHawbs1 = 0;

		var total_fcharge = 0;

		var total_revenue = 0;

		$('#tableList2 tbody tr').each(function() {

			total_numMawbs += removeComma($(this).find('.numMawbs').val());

			total_weight += removeComma($(this).find('.weight').val());

			total_numHawbs1 += removeComma($(this).find('.numHawbs1').val());

			total_fcharge += removeComma($(this).find('.fcharge').val());

			total_revenue += removeComma($(this).find('.revenue').val());

		});

		$('.total_row2 .total_numMawbs').html(addComma(total_numMawbs));

		$('.total_row2 .total_weight').html(addComma(total_weight));

		$('.total_row2 .total_numHawbs1').html(addComma(total_numHawbs1));

		$('.total_row2 .total_fcharge').html(addComma(total_fcharge));

		$('.total_row2 .total_revenue').html(addComma(total_revenue));

	}

	function computeTotal3() {

		var total_numHawbs2 = 0;

		var total_orgWeight = 0;

		var total_incomeBreak = 0;

		$('#tableList3 tbody tr').each(function() {

			total_numHawbs2 += removeComma($(this).find('.numHawbs2').val());

			total_orgWeight += removeComma($(this).find('.orgWeight').val());

			total_incomeBreak += removeComma($(this).find('.incomeBreak').val());

		});

		$('.total_row3 .total_numHawbs2').html(addComma(total_numHawbs2));

		$('.total_row3 .total_orgWeight').html(addComma(total_orgWeight));

		$('.total_row3 .total_incomeBreak').html(addComma(total_incomeBreak));

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

	});

	$('#entry_form3').submit(function(e) {

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

			addRow3(data);

		} else {

			$(this).find('.form-group.has-error').first().find('input, textarea, select').focus();

		}

		checkButtons();

	});

	var submit_type = '';

	$('#entries').submit(function(e) {

		e.preventDefault();

		var has_entry = !! ($('#tableList tbody .entry').length);

		var has_entry2 = !! ($('#tableList2 tbody .entry').length);

		var has_entry3 = !! ($('#tableList3 tbody .entry').length);

		var no_operation = !! ($('#tableList tbody .no_operation').length);

		var no_operation2 = !! ($('#tableList2 tbody .no_operation').length);

		var no_operation3 = !! ($('#tableList3 tbody .no_operation').length);

		var page_no_operation = false;

		var page_has_entry = false;

		if ($('#cargo_direct.active').length) {

			page_no_operation = no_operation;

			page_has_entry = has_entry;

		} else if ($('#cargo_consolidation.active').length) {

			page_no_operation = no_operation2;

			page_has_entry = has_entry2;

		} else if ($('#cargo_breakbulking.active').length) {

			page_no_operation = no_operation3;

			page_has_entry = has_entry3;

		}

		var submit_report = (has_entry || no_operation) && (has_entry2 || no_operation2) && (has_entry3 || no_operation3) && ($('#tableList2 tbody .entry').length == 0 || $('#serial_number #serialnum').val() != '');

		var save_draft = submit_type == 'draft' && ((has_entry || no_operation) || (has_entry2 || no_operation2) || (has_entry3 || no_operation3));

		if (submit_report || save_draft) {

			$('#submit_report').attr('disabled', true);

			$('#save_draft').attr('disabled', true);

			$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', $(this).serialize() + '&' + $('#entries2').serialize() + '&' + $('#entries3').serialize() + '&' + $('#entries4').serialize() + '&report_month=<?php echo $report_month; ?>&year=<?php echo $year; ?>&submit_type=' + submit_type + '<?=$ajax_post?>', function(data) {

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
			if(!confirm("I, the undersigned of the specified  airfreight forwarder, do certifiy that this report has been prepared by my or under my discretion, that I have fully examined it correctly reflects the operating statistics and revenues earned on airfreight forwarding operations of our company and to the best of my knowledge and belief constitue complete and accurate statement."))
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

		if ($('#cargo_direct.active').length) {

			$('#tableList tbody').html('');

			addRow(data);

		} else if ($('#cargo_consolidation.active').length) {

			$('#tableList2 tbody').html('');

			addRow2(data);

		} else if ($('#cargo_breakbulking.active').length) {

			$('#tableList3 tbody').html('');

			addRow3(data);

		}

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

					<td><span>` + data.aircraft + `</span><input type="hidden" name="aircraft[]" class="aircraft" value="` + data.aircraft + `"></td>

					<td><span>` + data.origin + `</span><input type="hidden" name="origin[]" class="origin" value="` + data.origin + `"></td>

					<td><span>` + data.destination + `</span><input type="hidden" name="destination[]" class="destination" value="` + data.destination + `"></td>

					<td class="text-right"><span>` + data.numMawbs + `</span><input type="hidden" name="numMawbs[]" class="numMawbs" value="` + data.numMawbs + `"></td>

					<td class="text-right"><span>` + data.weight + `</span><input type="hidden" name="weight[]" class="weight" value="` + data.weight + `"></td>

					<td class="text-right"><span>` + data.fcharge + `</span><input type="hidden" name="fcharge[]" class="fcharge" value="` + data.fcharge + `"></td>

					<td class="text-right"><span>` + data.commission + `</span><input type="hidden" name="commission[]" class="commission" value="` + data.commission + `"></td>

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

	}

	function addRow2(data) {

		if (data.aircraft == 'NO OPERATION') {

			var row = `

				<tr class="no_operation">

					<td class="text-center" colspan="9">NO OPERATION<input type="hidden" name="c_aircraft[]" value="NO OPERATION"></td>

				</tr>

			`;

		} else {

			var row = `

				<tr class="entry">

					<td><input type="checkbox"></td>

					<td><span>` + data.aircraft + `</span><input type="hidden" name="c_aircraft[]" class="aircraft" value="` + data.aircraft + `"></td>

					<td><span>` + data.destination + `</span><input type="hidden" name="c_destination[]" class="destination" value="` + data.destination + `"></td>

					<td class="text-right"><span>` + data.numMawbs + `</span><input type="hidden" name="c_numMawbs[]" class="numMawbs" value="` + data.numMawbs + `"></td>

					<td class="text-right"><span>` + data.numHawbs1 + `</span><input type="hidden" name="c_numHawbs1[]" class="numHawbs1" value="` + data.numHawbs1 + `"></td>

					<td class="text-right"><span>` + data.weight + `</span><input type="hidden" name="c_weight[]" class="weight" value="` + data.weight + `"></td>

					<td class="text-right"><span>` + data.fcharge + `</span><input type="hidden" name="c_fcharge[]" class="fcharge" value="` + data.fcharge + `"></td>

					<td class="text-right"><span>` + data.revenue + `</span><input type="hidden" name="c_revenue[]" class="revenue" value="` + data.revenue + `"></td>

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

	}

	function addRow3(data) {

		if (data.aircraft == 'NO OPERATION' || data.origin == 'NO OPERATION') {

			var row = `

				<tr class="no_operation">

					<td class="text-center" colspan="9">NO OPERATION<input type="hidden" name="b_origin[]" value="NO OPERATION"></td>

				</tr>

			`;

		} else {

			var row = `

				<tr class="entry">

					<td><input type="checkbox"></td>

					<td><span>` + data.origin + `</span><input type="hidden" name="b_origin[]" class="origin" value="` + data.origin + `"></td>

					<td class="text-right"><span>` + data.numHawbs2 + `</span><input type="hidden" name="b_numHawbs2[]" class="numHawbs2" value="` + data.numHawbs2 + `"></td>

					<td class="text-right"><span>` + data.orgWeight + `</span><input type="hidden" name="b_orgWeight[]" class="orgWeight" value="` + data.orgWeight + `"></td>

					<td class="text-right"><span>` + data.incomeBreak + `</span><input type="hidden" name="b_incomeBreak[]" class="incomeBreak" value="` + data.incomeBreak + `"></td>

					<td class="text-center"><a href="#edit" class="edit_entry text-info">Edit</a></td>

				</tr>

			`;

		}

		$('#tableList3 tbody .no-entry').remove();

		$('#tableList3 tbody .no_operation').remove();

		$('#tableList3 tbody').append(row);

		if (typeof drawTemplate === 'function') {

			drawTemplate();

		}

		computeTotal3();

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

		edit_row.find('.origin').val(data.origin).closest('td').find('span').html(data.origin);

		edit_row.find('.destination').val(data.destination).closest('td').find('span').html(data.destination);

		edit_row.find('.numMawbs').val(data.numMawbs).closest('td').find('span').html(data.numMawbs);

		edit_row.find('.weight').val(data.weight).closest('td').find('span').html(data.weight);

		edit_row.find('.fcharge').val(data.fcharge).closest('td').find('span').html(data.fcharge);

		edit_row.find('.commission').val(data.commission).closest('td').find('span').html(data.commission);



		computeTotal();

	}

	function updateRow2(data) {

		edit_row.find('.aircraft').val(data.aircraft).closest('td').find('span').html(data.aircraft);

		edit_row.find('.destination').val(data.destination).closest('td').find('span').html(data.destination);

		edit_row.find('.numMawbs').val(data.numMawbs).closest('td').find('span').html(data.numMawbs);

		edit_row.find('.weight').val(data.weight).closest('td').find('span').html(data.weight);

		edit_row.find('.numHawbs1').val(data.numHawbs1).closest('td').find('span').html(data.numHawbs1);

		edit_row.find('.revenue').val(data.revenue).closest('td').find('span').html(data.revenue);

		edit_row.find('.fcharge').val(data.fcharge).closest('td').find('span').html(data.fcharge);



		computeTotal2();

	}

	function updateRow3(data) {

		edit_row.find('.origin').val(data.origin).closest('td').find('span').html(data.origin);

		edit_row.find('.numHawbs2').val(data.numHawbs2).closest('td').find('span').html(data.numHawbs2);

		edit_row.find('.orgWeight').val(data.orgWeight).closest('td').find('span').html(data.orgWeight);

		edit_row.find('.incomeBreak').val(data.incomeBreak).closest('td').find('span').html(data.incomeBreak);



		computeTotal3();

	}

	report_details.forEach(function(data) {

		addRow(data);

	});

	report_details2.forEach(function(data) {

		addRow2(data);

	});

	report_details3.forEach(function(data) {

		addRow3(data);

	});

	checkButtons();

</script>