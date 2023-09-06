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
						<th class="col-md-2" colspan="2">ROUTES SERVED</th>
						<th class="col-md-1" rowspan="2">DISTANCE TRAVELLED (Kilometers)</th>
						<th class="col-md-1" colspan="2">A/C FLYING TIME</th>
						<th class="col-md-1" rowspan="2">NUMBER OF PASSENGERS CARRIED</th>
						<th class="col-md-1" colspan="2">CARGO CARRIED</th>
						<th class="col-md-1" rowspan="2">REVENUE DERIVED (Philippine Peso)</th>
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
						<th colspan="5" class="text-right">TOTAL:</th>
						<th class="total_distance text-right">0</th>
						<th class="total_flown_hour text-right">0</th>
						<th class="total_flown_min text-right">0.00</th>
						<th class="total_passengers_num text-right">0.00</th>
						<th class="total_cargo_qty text-right">0</th>
						<th class="total_cargo_value text-right">0.00</th>
						<th class="total_revenue text-right">0.00</th>
					</tr>
					<tr class="info">
						<td colspan="9" id="pagination"></td>
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
		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="12" class="text-center">No Entries</td></tr>`);
	}
	addNoEntry();
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
	function addRow(data) {
		if (data.aircraft == 'NO OPERATION') {
			var row = `
				<tr class="no_operation">
					<td class="text-center" colspan="12">NO OPERATION<input type="hidden" name="aircraft[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			var row = `
				<tr class="entry">
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
				</tr>
			`;
		}
		$('#tableList tbody .no-entry').remove();
		$('#tableList tbody .no_operation').remove();
		$('#tableList tbody').append(row);
	}
	report_details.forEach(function(data) {
		addRow(data);
	});
	computeTotal();
	$('.entry_count').html($('#tableList tbody .entry').length);
</script>