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
						<th colspan="11">DIRECT CARGO (Kilograms)</th>
					</tr>
					<tr class="info">
						<th rowspan="2" class="col-md-1">AIRCRAFT</th>
						<th rowspan="2" class="col-md-1">ROUTE</th>
						<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>
						<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>
						<th rowspan="2" class="col-md-1">ROUTE</th>
						<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>
						<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>
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
						<th colspan="2" class="text-right">TOTAL:</th>
						<th class="total_cargoRev text-right">0.00</th>
						<th class="total_cargoNonRev text-right">0.00</th>
						<th class="total_mailRev text-right">0.00</th>
						<th class="total_mailNonRev text-right">0.00</th>
						<th></th>
						<th class="total_cargoRevDep text-right">0.00</th>
						<th class="total_cargoNonRevDep text-right">0.00</th>
						<th class="total_mailRevDep text-right">0.00</th>
						<th class="total_mailNonRevDep text-right">0.00</th>
					</tr>
					<tr class="info">
						<td colspan="8" id="pagination"></td>
						<td colspan="3" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive mb-xs">
			<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">
				<thead>
					<tr class="info">
						<th colspan="11">TRANSIT CARGO (Kilograms)</th>
					</tr>
					<tr class="info">
						<th rowspan="2" class="col-md-1">AIRCRAFT</th>
						<th rowspan="2" class="col-md-1">ROUTE</th>
						<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>
						<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>
						<th rowspan="2" class="col-md-1">ROUTE</th>
						<th colspan="2" class="col-md-2">CARGO (Kilograms)</th>
						<th colspan="2" class="col-md-2">MAIL (Kilograms)</th>
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
						<th colspan="2" class="text-right">TOTAL:</th>
						<th class="total_cargoRev text-right">0.00</th>
						<th class="total_cargoNonRev text-right">0.00</th>
						<th class="total_mailRev text-right">0.00</th>
						<th class="total_mailNonRev text-right">0.00</th>
						<th></th>
						<th class="total_cargoRevDep text-right">0.00</th>
						<th class="total_cargoNonRevDep text-right">0.00</th>
						<th class="total_mailRevDep text-right">0.00</th>
						<th class="total_mailNonRevDep text-right">0.00</th>
					</tr>
					<tr class="info">
						<td colspan="8" id="pagination"></td>
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
	var report_details2 = <?php echo json_encode((isset($form_details2) && $form_details2) ? $form_details2 : array()) ?>;
	$('#delete_report').click(function() {
		$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', '<?=$ajax_post?>', function(data) {
			if (data.success) {
				window.location = data.redirect;
			}
		});
	});
	function addNoEntry() {
		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="11" class="text-center">No Entries</td></tr>`);
	}
	function addNoEntry2() {
		$('#tableList2 tbody').html(`<tr class="no-entry"><td colspan="11" class="text-center">No Entries</td></tr>`);
	}
	addNoEntry();
	addNoEntry2();
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
	function addRow(data) {
		if (data.aircraft == 'NO OPERATION') {
			var row = `
				<tr class="no_operation">
					<td class="text-center" colspan="11">NO OPERATION<input type="hidden" name="aircraft[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			var row = `
				<tr class="entry">
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
				</tr>
			`;
		}
		$('#tableList tbody .no-entry').remove();
		$('#tableList tbody .no_operation').remove();
		$('#tableList tbody').append(row);
	}
	function addRow2(data) {
		if (data.aircraft == 'NO OPERATION') {
			var row = `
				<tr class="no_operation">
					<td class="text-center" colspan="11">NO OPERATION<input type="hidden" name="t_aircraft[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			var row = `
				<tr class="entry">
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
				</tr>
			`;
		}
		$('#tableList2 tbody .no-entry').remove();
		$('#tableList2 tbody .no_operation').remove();
		$('#tableList2 tbody').append(row);
	}
	report_details.forEach(function(data) {
		addRow(data);
	});
	report_details2.forEach(function(data) {
		addRow2(data);
	});
	computeTotal();
	computeTotal2();
	$('#tableList .entry_count').html($('#tableList tbody .entry').length);
	$('#tableList2 .entry_count').html($('#tableList2 tbody .entry').length);
</script>