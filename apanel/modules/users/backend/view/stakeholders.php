<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		MONITORING OF STAKEHOLDERS
	</div>
	<div class="panel-body">
		<div class="form-horizontal">
			<?php
				echo $ui->formField('dropdown')
						->setLabel('Nature of Operation:')
						->setPlaceholder('Select Main Form')
						->setSplit('col-md-3', 'col-md-6')
						->setName('nature')
						->setId('nature')
						->setList($nature_list)
						->draw();
			?>
			<div id="report_form_field" style="display: none;">
				<?php
					echo $ui->formField('dropdown')
							->setLabel('Report Form:')
							->setPlaceholder('Select Main Form')
							->setSplit('col-md-3', 'col-md-6')
							->setName('report_form')
							->setId('report_form')
							->setList($report_list)
							->draw();
				?>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default br-xs">
					<div class="panel-body">
						<div class="form-group">
							<?php
								echo $ui->formField('dropdown')
										->setName('report')
										->setId('report')
										->setPlaceholder('Select Report')
										->setList(array('late' => 'Late Reports', 'unsubmitted' => 'Non-Submission Reports'))
										->draw();
							?>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div id="period_month" class="form-group">
									<?php
										echo $ui->formField('dropdown')
										->setName('month')
										->setId('month')
										->setPlaceholder('Select Month')
										->setList($month_list)
										->draw();
									?>
								</div>
								<div id="period_quarter" class="form-group" style="display: none">
									<?php
										echo $ui->formField('dropdown')
										->setName('quarter')
										->setId('quarter')
										->setPlaceholder('Select Quarter')
										->setList($quarter_list)
										->draw();
									?>
								</div>
								<div class="form-group">
									<a id="show_notice" class="btn btn-default btn-sm btn-block">Show Notices</a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<?php
										echo $ui->formField('dropdown')
												->setName('year')
												->setId('year')
												->setPlaceholder('Select Year')
												->setList($year_list)
												->draw();
									?>
								</div>
								<div class="form-group">
									<a id="notice_pdf" target="_blank" class="btn btn-default btn-sm btn-block">Download PDF</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default br-xs" style="min-height: 129px">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<?php
										echo $ui->formField('dropdown')
												->setName('checklist_year')
												->setId('checklist_year')
												->setPlaceholder('Select Year')
												->setList($year_list)
												->draw();
									?>
								</div>
								<div class="form-group">
									<a id="checklist_pdf" target="_blank" class="btn btn-default btn-sm btn-block">Download PDF</a>
								</div>
							</div>
							<div class="col-md-6">
								<a id="excel" class="btn btn-default btn-sm btn-block">View Checklist</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var notice_href = "<?=MODULE_URL?>csv_notice/";
	var checklist_pdf_href = "<?=MODULE_URL?>srs_checklist/";
	var checklist_csv_href = "<?=MODULE_URL?>csv_checklist/";
	var notice_pdf_href = "<?=MODULE_URL?>srs_notice/";

	var nature_list = <?php echo ($nature_json) ? $nature_json : '{}' ?>;

	$('#nature').on('change', function() {
		var nature = $(this).val();

		if (nature_list[nature].length > 1) {
			$('#report_form_field').show();
		} else {
			$('#report_form_field').hide();
		}

		var nature_dropdown = ``;
		nature_list[nature].forEach(function(item) {
			nature_dropdown += '<option value="' + item.ind + '">' + item.val + '</option>';
		});
		$('#report_form').html(nature_dropdown);

		$('#report_form').val(nature_list[nature][0].ind).trigger('change');
	});

	$('#report_form').on('change', function() {
		if ($(this).val() == '11') {
			$('#period_quarter').val('').show();
			$('#period_month').val('').hide();
		} else {
			$('#period_quarter').val('').hide();
			$('#period_month').val('').show();
		}
		updateLeft();
		updateRight();
	});

	$('#report, #year, #quarter, #month').on('change', function() {
		updateLeft();
	});
	$('#checklist_year').on('change', function() {
		updateRight();
	});

	function updateRight() {
		// var nature = $('#nature').val();
		var report_form = $('#report_form').val();
		var year = $("#checklist_year").val();
		if (report_form > 0 && year > 0) {
			$('#checklist_pdf').attr('href', checklist_pdf_href + report_form + '/' + year);
			$('#checklist_pdf').css({'color': '#000'});
			$('#excel').attr('href', checklist_csv_href + report_form + '/' + year);
			$('#excel').css({'color': '#000'});
		} else {
			$('#checklist_pdf').removeAttr('href');
			$('#checklist_pdf').css({'color': '#AAA'});
			$('#excel').removeAttr('href');
			$('#excel').css({'color': '#AAA'});
		}
	}

	function updateLeft() {
		var type = $('#report').val();
		// var nature = $('#nature').val();
		var report_form = $('#report_form').val();
		var month = $('#month').val();
		if (month == '') {
			month = $('#quarter').val();
		}
		var year = $("#year").val();
		if (type != 0 && report_form > 0 && month > 0 && year > 0) {
			$('#notice_pdf').attr('href', notice_pdf_href + report_form + '/' + type + '/' + month + '/' + year);
			$('#notice_pdf').css({'color': '#000'});
			$('#show_notice').attr('href', notice_href + report_form + '/' + type + '/' + month + '/' + year);
			$('#show_notice').css({'color': '#000'});
		} else {
			$('#notice_pdf').removeAttr('href');
			$('#notice_pdf').css({'color': '#AAA'});
			$('#show_notice').removeAttr('href');
			$('#show_notice').css({'color': '#AAA'});
		}
	}
	$('#checklist_pdf').css({'color': '#AAA'});
	$('#excel').css({'color': '#AAA'});
	$('#notice_pdf').css({'color': '#AAA'});
	$('#show_notice').css({'color': '#AAA'});
</script>