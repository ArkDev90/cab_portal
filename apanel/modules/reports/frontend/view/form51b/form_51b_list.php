<div class="panel panel-primary br-xs">

	<div class="panel-heading bb-colored text-center">

		<?php echo $form_title ?>

	</div>

	<div class="box-body pb-none">

		<div class="text-right">

			<a href="<?php echo MODULE_URL ?>view_draft_list" class="btn btn-primary btn-sm">View Draft Reports</a>

		</div>

		<br>

		<div class="row">

			<div class="col-md-6 col-md-offset-3">

				<div class="form-horizontal">

					<?php

						echo $ui->formField('dropdown')

								->setLabel('Report Period')

								->setPlaceholder('Select Month')

								->setSplit('col-md-4', 'col-md-6')

								->setId('report_month')

								->setList($month_list)

								->draw();



						echo $ui->formField('dropdown')

								->setLabel('Report Year')

								->setPlaceholder('Select Year')

								->setSplit('col-md-4', 'col-md-6')

								->setId('report_year')

								->setList($year_list)

								->draw();

					?>

					<div class="text-center">

						<p class="text-red" id="error_message"></p>

						<br>

						<button type="button" id="check_report" class="btn btn-primary btn-sm">Confirm and Proceed</button>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-left">
		Reminder
	</div>
	<div class="box-body table-responsive ">
		<b class="text-red">Reports that are not Approved before the Deadline of submission will still be considered late.</b> You may check the status of the report on status column on the right side of the table below.
	</div>
</div>

<div class="panel panel-primary br-xs">

	<div class="panel-heading bb-colored text-center">

		HISTORY LISTING

	</div>

	<div class="box-body table-responsive">

		<table id="tableList" class="table table-hover table-bordered table-sidepad">

			<?php

				echo $ui->loadElement('table')

						->setHeaderClass('info')

						->addHeader('#', array('class' => 'col-md-1'))

						->addHeader('Report Date', array('class' => 'col-md-4'))

						->addHeader('Date Approved', array('class' => 'col-md-3'))

						->addHeader('Approved By', array('class' => 'col-md-3'))

						->addHeader('Status', array('class' => 'col-md-1'))

						->draw();

			?>

			<tbody>

				<tr>

					<td colspan="5" class="center">Loading Entries...</td>

				</tr>

			</tbody>

			<tfoot>

				<tr class="info">

					<td colspan="3" id="pagination"></td>

					<td colspan="2" class="text-center"><b>Result: </b> <span class="result"></span></td>

				</tr>

			</tfoot>

		</table>

	</div>

</div>



<script>

	var ajax = {}

	ajax.limit = 20;

	var ajax_call = '';

	var ajax_call2 = '';

	$('#report_month').on('change', function() {

		ajax.month = $(this).val();

		enableProceed();

	});

	$('#report_year').on('change', function() {

		ajax.year = $(this).val();

		enableProceed();

	});

	function enableProceed() {

		$('#error_message').html('');

		if (ajax.month && ajax.year) {

			$('#check_report').attr('disabled', false);

		} else {

			$('#check_report').attr('disabled', true);

		}

	}

	enableProceed();

	$('#check_report').click(function() {

		if (ajax_call2 != '') {

			ajax_call2.abort();

		}

		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_check_report', ajax, function(data) {

			if (data.existing) {

				$('#error_message').html('Report Date Already Exist');

			} else {

				window.location = '<?=MODULE_URL?>create/' + ajax.year + '/' + ajax.month;

			}

		});

	});

	$('#pagination').on('click', 'a', function(e) {

		e.preventDefault();

		ajax.page = $(this).attr('data-page');

		getList();

	});

	function getList() {

		if (ajax_call != '') {

			ajax_call.abort();

		}

		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_list', ajax, function(data) {

			$('#tableList tbody').html(data.table);

			$('#pagination').html(data.pagination);

			if (ajax.page > data.page_limit && data.page_limit > 0) {

				ajax.page = data.page_limit;

				getList();

			}

			$('#tableList tfoot .result').html('None');

			if (data.result_count > 0) {

				var min = (ajax.limit * (data.page - 1) + 1);

				var max = ((ajax.limit * data.page) > data.result_count) ? data.result_count : ajax.limit * data.page;

				$('#tableList tfoot .result').html(min + ' - ' + max + ' of ' + data.result_count);

			}

		});

	}

	getList();

</script>