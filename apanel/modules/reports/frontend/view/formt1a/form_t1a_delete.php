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
						<th class="col-md-3">SECTOR</th>
						<th class="col-md-2">DISTANCE(Kilometers)</th>
						<th class="col-md-1">AVAILABLE SEAT-KMS OFFERED</th>
						<th class="col-md-1">AVAILABLE SEATS</th>
						<th class="col-md-1">REVENUE PASSENGERS</th>
						<th class="col-md-1">NON-REVENUE PASSENGERS</th>
						<th class="col-md-1">PASSENGER LOAD FACTOR</th>
						<th class="col-md-1">CARGO (Kilograms)</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr class="info total_row">
						<th class="text-right">TOTAL:</th>
						<th class="total_distance text-right">0.00</th>
						<th class="total_kms text-right">0</th>
						<th class="total_seats text-right">0</th>
						<th class="total_passenger text-right">0</th>
						<th class="total_nonrev text-right">0</th>
						<th class="total_load text-right">0.00%</th>
						<th class="total_cargo text-right">0.00</th>
					</tr>
					<tr class="info">
						<td colspan="6" id="pagination"></td>
						<td colspan="2" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive mb-xs">
			<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">
				<thead>
					<tr class="info">
						<th colspan="9">CODE SHARED</th>
					</tr>
					<tr class="info">
						<th class="col-md-2">MARKETING AIRLINE</th>
						<th class="col-md-2">SECTOR</th>
						<th class="col-md-1">DISTANCE(Kilometers)</th>
						<th class="col-md-1">AVAILABLE SEAT-KMS OFFERED</th>
						<th class="col-md-1">AVAILABLE SEATS</th>
						<th class="col-md-1">REVENUE PASSENGERS</th>
						<th class="col-md-1">NON-REVENUE PASSENGERS</th>
						<th class="col-md-1">PASSENGER LOAD FACTOR</th>
						<th class="col-md-1">CARGO (Kilograms)</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr class="info total_row2">
						<th colspan="2" class="text-right">TOTAL:</th>
						<th class="total_distance text-right">0.00</th>
						<th class="total_kms text-right">0</th>
						<th class="total_seats text-right">0</th>
						<th class="total_passenger text-right">0</th>
						<th class="total_nonrev text-right">0</th>
						<th class="total_load text-right">0.00%</th>
						<th class="total_cargo text-right">0.00</th>
					</tr>
					<tr class="info">
						<td colspan="7" id="pagination"></td>
						<td colspan="2" class="text-center"><b>Entries: </b> <span class="entry_count2"></span></td>
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
		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="8" class="text-center">No Entries</td></tr>`);
	}
	function addNoEntry2() {
		$('#tableList2 tbody').html(`<tr class="no-entry"><td colspan="9" class="text-center">No Entries</td></tr>`);
	}
	addNoEntry();
	addNoEntry2();
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
					<td rowspan="3" class="text-center ` + show_codeshare + `"><span>` + data.codeshared + `</span><input type="hidden" name="codeshared[]" class="codeshared" value="` + data.codeshared + `"></td>
					<td class="text-center"><span>` + (data.sector + '/' + data.sector_d) + `</span><input type="hidden" name="sector[]" class="sector" value="` + data.sector + `"></td>
					<td class="text-right"><span>` + addComma(data.distance) + `</span><input type="hidden" name="distance[]" class="distance" value="` + data.distance + `"></td>
					<td class="text-right"><span>` + addComma(data.sk_offered, 0) + `</span><input type="hidden" name="sk_offered[]" class="sk_offered" value="` + data.sk_offered + `"></td>
					<td class="text-right"><span>` + addComma(data.seats_offered, 0) + `</span><input type="hidden" name="seats_offered[]" class="seats_offered" value="` + data.seats_offered + `"></td>
					<td class="text-right"><span>` + addComma(data.rev_pass, 0) + `</span><input type="hidden" name="rev_pass[]" class="rev_pass" value="` + data.rev_pass + `"></td>
					<td class="text-right"><span>` + addComma(data.nonrev_pass, 0) + `</span><input type="hidden" name="nonrev_pass[]" class="nonrev_pass" value="` + data.nonrev_pass + `"></td>
					<td class="text-right"><span>` + addComma(data.load_factor) + `%</span><input type="hidden" name="load_factor[]" class="load_factor" value="` + data.load_factor + `"></td>
					<td class="text-right"><span>` + addComma(data.cargo) + `</span><input type="hidden" name="cargo[]" class="cargo" value="` + data.cargo + `"></td>
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
					<td class="text-right"><b>SUBTOTAL:</b></td>
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
	}
	report_details.forEach(function(data) {
		addRow(data);
	});
	computeTotal();
	computeTotal2();
	$('.entry_count').html($('#tableList tbody .entry').length);
	$('.entry_count2').html($('#tableList2 tbody .entry').length);
</script>