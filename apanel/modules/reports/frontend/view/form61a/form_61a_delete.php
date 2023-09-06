<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		<?php echo $form_title ?>
	</div>
	<div class="box-body pb-none">
		<h4 class="text-center text-red">Please Review the Data you are about to Delete. Delete Button Below.</h4>
		<div class="table-responsive mb-xs">
			<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
				<thead>
					<tr class="info">
						<th class="col-md-2" rowspan="2">DATE</th>
						<th class="col-md-2" colspan="2">AIRCRAFT</th>
						<th class="col-md-1" rowspan="2">LOCATION</th>
						<th class="col-md-1" rowspan="2">TYPES OF TREATMENT</th>
						<th class="col-md-1" rowspan="2">AREA TREATED (Hectares)</th>
						<th class="col-md-1" rowspan="2">QUANTITY (Liters)</th>
						<th class="col-md-1" rowspan="2">REVENUE EARNED (Peso)</th>
						<th class="col-md-2" colspan="2">A/C FLYING TIME</th>
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
						<th colspan="5" class="text-right">TOTAL:</th>
						<th class="total_areaTreated text-right">0.00</th>
						<th class="total_qLiters text-right">0.00</th>
						<th class="total_revenue text-right">0.00</th>
						<th class="total_flyTimeHour text-right">0</th>
						<th class="total_flyTimeMin text-right">0</th>
					</tr>
					<tr class="info">
						<td colspan="7" id="pagination"></td>
						<td colspan="3" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<h4 class="text-center text-red">Do you want to Delete this Draft Report?</h4>
		<div class="text-center">
			<button type="button" id="delete_report" class="btn btn-danger btn-sm">Delete</button>
			<a href="<?php echo MODULE_URL ?>view_draft_list" class="btn btn-default btn-sm">Cancel</a>
		</div>
	</div>
</div>
<script>
	var report_details = <?php echo json_encode((isset($form_details) && $form_details) ? $form_details : array()) ?>;
	$('#delete_report').click(function() {
		$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', '<?=$ajax_post?>', function(data) {
			if (data.success) {
				window.location = data.redirect;
			}
		});
	});
	function addNoEntry() {
		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="10" class="text-center">No Entries</td></tr>`);
	}
	addNoEntry();
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
	function addRow(data) {
		if (data.aircraft == 'NO OPERATION') {
			var row = `
				<tr class="no_operation">
					<td class="text-center" colspan="10">NO OPERATION<input type="hidden" name="aircraft[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			var row = `
				<tr class="entry">
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
				</tr>
			`;
		}
		$('#tableList tbody .no-entry').remove();
		$('#tableList tbody .no_operation').remove();
		$('#tableList tbody').append(row);
		if (typeof drawTemplate === 'function') {
			drawTemplate();
		}
	}
	report_details.forEach(function(data) {
		addRow(data);
	});
	computeTotal();
	$('.entry_count').html($('#tableList tbody .entry').length);
</script>