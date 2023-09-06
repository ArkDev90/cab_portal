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
						<th class="col-md-1" rowspan="2">AIRCRAFT</th>
						<th class="col-md-1" rowspan="2">ROUTE</th>
						<th class="col-md-1" rowspan="2">SEATS OFFERED</th>
						<th class="col-md-1" colspan="4">REVENUE PASSENGER TRAFFIC</th>
						<th class="col-md-1">FOC TRAFFIC</th>
						<th class="col-md-1" rowspan="2">ROUTE</th>
						<th class="col-md-1" rowspan="2">SEATS OFFERED</th>
						<th class="col-md-1" colspan="4">REVENUE PASSENGER TRAFFIC</th>
						<th class="col-md-1">FOC TRAFFIC</th>
						<th class="col-md-1">TOTAL</th>
						<th class="col-md-1">LF</th>
					</tr>
					<tr class="info">
						<th><?php echo strtoupper($quarter_months[0]) ?></th>
						<th><?php echo strtoupper($quarter_months[1]) ?></th>
						<th><?php echo strtoupper($quarter_months[2]) ?></th>
						<th>SUB TOTAL</th>
						<th>SUB TOTAL</th>
						<th><?php echo strtoupper($quarter_months[0]) ?></th>
						<th><?php echo strtoupper($quarter_months[1]) ?></th>
						<th><?php echo strtoupper($quarter_months[2]) ?></th>
						<th>SUB TOTAL</th>
						<th>SUB TOTAL</th>
						<th>REV TRAFFIC</th>
						<th>%</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="info total_row">
						<th colspan="2" class="text-right">TOTAL:</th>
						<th class="total_seats_offered text-right">0</th>
						<th class="total_quarter_month1 text-right">0</th>
						<th class="total_quarter_month2 text-right">0</th>
						<th class="total_quarter_month3 text-right">0</th>
						<th class="total_quarter_total text-right">0</th>
						<th class="total_sub_total text-right">0</th>
						<th></th>
						<th class="total_seats_offered_d text-right">0</th>
						<th class="total_quarter_month1_d text-right">0</th>
						<th class="total_quarter_month2_d text-right">0</th>
						<th class="total_quarter_month3_d text-right">0</th>
						<th class="total_quarter_total_d text-right">0</th>
						<th class="total_sub_total_d text-right">0</th>
						<th class="total_total_rev_traffic text-right">0</th>
						<th class="total_total_percent text-right">0.00%</th>
					</tr>
					<tr class="info">
						<td colspan="14" id="pagination"></td>
						<td colspan="3" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive mb-xs">
			<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">
				<thead>
					<tr class="info">
						<th class="col-md-1" rowspan="2">MARKETING AIRLINE</th>
						<th class="col-md-1" rowspan="2">ROUTE</th>
						<th class="col-md-1" rowspan="2">SEATS OFFERED</th>
						<th class="col-md-1" colspan="4">REVENUE PASSENGER TRAFFIC</th>
						<th class="col-md-1">FOC TRAFFIC</th>
						<th class="col-md-1" rowspan="2">ROUTE</th>
						<th class="col-md-1" rowspan="2">SEATS OFFERED</th>
						<th class="col-md-1" colspan="4">REVENUE PASSENGER TRAFFIC</th>
						<th class="col-md-1">FOC TRAFFIC</th>
						<th class="col-md-1">TOTAL</th>
						<th class="col-md-1">LF</th>
					</tr>
					<tr class="info">
						<th><?php echo strtoupper($quarter_months[0]) ?></th>
						<th><?php echo strtoupper($quarter_months[1]) ?></th>
						<th><?php echo strtoupper($quarter_months[2]) ?></th>
						<th>SUB TOTAL</th>
						<th>SUB TOTAL</th>
						<th><?php echo strtoupper($quarter_months[0]) ?></th>
						<th><?php echo strtoupper($quarter_months[1]) ?></th>
						<th><?php echo strtoupper($quarter_months[2]) ?></th>
						<th>SUB TOTAL</th>
						<th>SUB TOTAL</th>
						<th>REV TRAFFIC</th>
						<th>%</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="info total_row2">
						<th colspan="2" class="text-right">TOTAL:</th>
						<th class="total_seats_offered text-right">0</th>
						<th class="total_quarter_month1 text-right">0</th>
						<th class="total_quarter_month2 text-right">0</th>
						<th class="total_quarter_month3 text-right">0</th>
						<th class="total_quarter_total text-right">0</th>
						<th class="total_sub_total text-right">0</th>
						<th></th>
						<th class="total_seats_offered_d text-right">0</th>
						<th class="total_quarter_month1_d text-right">0</th>
						<th class="total_quarter_month2_d text-right">0</th>
						<th class="total_quarter_month3_d text-right">0</th>
						<th class="total_quarter_total_d text-right">0</th>
						<th class="total_sub_total_d text-right">0</th>
						<th class="total_total_rev_traffic text-right">0</th>
						<th class="total_total_percent text-right">0.00%</th>
					</tr>
					<tr class="info">
						<td colspan="14" id="pagination"></td>
						<td colspan="3" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive mb-xs">
			<table id="tableList3" class="table table-hover table-bordered table-sidepad mb-none">
				<thead>
					<tr class="info">
						<th colspan="11">TRANSIT REVENUE</th>
					</tr>
					<tr class="info">
						<th class="col-md-1">ROUTE</th>
						<th class="col-md-1"><?php echo strtoupper($quarter_months[0]) ?></th>
						<th class="col-md-1"><?php echo strtoupper($quarter_months[1]) ?></th>
						<th class="col-md-1"><?php echo strtoupper($quarter_months[2]) ?></th>
						<th class="col-md-1">SUB-TOTAL</th>
						<th class="col-md-1">ROUTE</th>
						<th class="col-md-1"><?php echo strtoupper($quarter_months[0]) ?></th>
						<th class="col-md-1"><?php echo strtoupper($quarter_months[1]) ?></th>
						<th class="col-md-1"><?php echo strtoupper($quarter_months[2]) ?></th>
						<th class="col-md-1">SUB-TOTAL</th>
						<th class="col-md-1">TOTAL</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr class="info total_row3">
						<th class="text-right">TOTAL:</th>
						<th class="total_quarter_month1 text-right">0</th>
						<th class="total_quarter_month2 text-right">0</th>
						<th class="total_quarter_month3 text-right">0</th>
						<th class="total_subtotal text-right">0</th>
						<th></th>
						<th class="total_quarter_month1_d text-right">0</th>
						<th class="total_quarter_month2_d text-right">0</th>
						<th class="total_quarter_month3_d text-right">0</th>
						<th class="total_subtotal_d text-right">0</th>
						<th class="total_total text-right">0</th>
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
	var report_details3 = <?php echo json_encode((isset($form_details3) && $form_details3) ? $form_details3 : array()) ?>;
	var row_num = 0;
	$('#delete_report').click(function() {
		$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', '<?=$ajax_post?>', function(data) {
			if (data.success) {
				window.location = data.redirect;
			}
		});
	});
	function addNoEntry() {
		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="17" class="text-center">No Entries</td></tr>`);
	}
	function addNoEntry2() {
		$('#tableList2 tbody').html(`<tr class="no-entry"><td colspan="17" class="text-center">No Entries</td></tr>`);
	}
	function addNoEntry3() {
		$('#tableList3 tbody').html(`<tr class="no-entry"><td colspan="11" class="text-center">No Entries</td></tr>`);
	}
	addNoEntry();
	addNoEntry2();
	addNoEntry3();
	function computeTotal() {
		var rows = 0;
		var total_seats_offered = 0;
		var total_quarter_month1 = 0;
		var total_quarter_month2 = 0;
		var total_quarter_month3 = 0;
		var total_quarter_total = 0;
		var total_sub_total = 0;
		var total_seats_offered_d = 0;
		var total_quarter_month1_d = 0;
		var total_quarter_month2_d = 0;
		var total_quarter_month3_d = 0;
		var total_quarter_total_d = 0;
		var total_sub_total_d = 0;
		var total_total_rev_traffic = 0;
		$('#tableList tbody tr:visible').each(function() {
			if ($(this).find('.quarter_month1').length || $(this).find('.ex_quarter_month1').length) {
				rows++;
			}
			total_seats_offered += removeComma($(this).find('.seats_offered').html());
			total_quarter_month1 += removeComma($(this).find('.quarter_month1').html());
			total_quarter_month2 += removeComma($(this).find('.quarter_month2').html());
			total_quarter_month3 += removeComma($(this).find('.quarter_month3').html());
			total_quarter_total += removeComma($(this).find('.quarter_total').html());
			total_sub_total += removeComma($(this).find('.sub_total').html());
			total_seats_offered_d += removeComma($(this).find('.seats_offered_d').html());
			total_quarter_month1_d += removeComma($(this).find('.quarter_month1_d').html());
			total_quarter_month2_d += removeComma($(this).find('.quarter_month2_d').html());
			total_quarter_month3_d += removeComma($(this).find('.quarter_month3_d').html());
			total_quarter_total_d += removeComma($(this).find('.quarter_total_d').html());
			total_sub_total_d += removeComma($(this).find('.sub_total_d').html());
			total_total_rev_traffic += removeComma($(this).find('.total_rev_traffic').html());

			total_seats_offered += removeComma($(this).find('.ex_seats_offered').html());
			total_quarter_month1 += removeComma($(this).find('.ex_quarter_month1').html());
			total_quarter_month2 += removeComma($(this).find('.ex_quarter_month2').html());
			total_quarter_month3 += removeComma($(this).find('.ex_quarter_month3').html());
			total_quarter_total += removeComma($(this).find('.ex_quarter_total').html());
			total_sub_total += removeComma($(this).find('.ex_sub_total').html());
			total_seats_offered_d += removeComma($(this).find('.ex_seats_offered_d').html());
			total_quarter_month1_d += removeComma($(this).find('.ex_quarter_month1_d').html());
			total_quarter_month2_d += removeComma($(this).find('.ex_quarter_month2_d').html());
			total_quarter_month3_d += removeComma($(this).find('.ex_quarter_month3_d').html());
			total_quarter_total_d += removeComma($(this).find('.ex_quarter_total_d').html());
			total_sub_total_d += removeComma($(this).find('.ex_sub_total_d').html());
			total_total_rev_traffic += removeComma($(this).find('.ex_total_rev_traffic').html());
		});
		var total_total_percent = ((total_seats_offered + total_seats_offered_d) > 0) ? (total_total_rev_traffic / (total_seats_offered + total_seats_offered_d)) * 100 : 0;
		$('.total_row .total_seats_offered').html(addComma(total_seats_offered, 0));
		$('.total_row .total_quarter_month1').html(addComma(total_quarter_month1, 0));
		$('.total_row .total_quarter_month2').html(addComma(total_quarter_month2, 0));
		$('.total_row .total_quarter_month3').html(addComma(total_quarter_month3, 0));
		$('.total_row .total_quarter_total').html(addComma(total_quarter_total, 0));
		$('.total_row .total_sub_total').html(addComma(total_sub_total, 0));
		$('.total_row .total_seats_offered_d').html(addComma(total_seats_offered_d, 0));
		$('.total_row .total_quarter_month1_d').html(addComma(total_quarter_month1_d, 0));
		$('.total_row .total_quarter_month2_d').html(addComma(total_quarter_month2_d, 0));
		$('.total_row .total_quarter_month3_d').html(addComma(total_quarter_month3_d, 0));
		$('.total_row .total_quarter_total_d').html(addComma(total_quarter_total_d, 0));
		$('.total_row .total_sub_total_d').html(addComma(total_sub_total_d, 0));
		$('.total_row .total_total_rev_traffic').html(addComma(total_total_rev_traffic, 0));
		$('.total_row .total_total_percent').html(addComma(total_total_percent) + '%');
	}
	function computeTotal2() {
		var rows = 0;
		var total_seats_offered = 0;
		var total_quarter_month1 = 0;
		var total_quarter_month2 = 0;
		var total_quarter_month3 = 0;
		var total_quarter_total = 0;
		var total_sub_total = 0;
		var total_seats_offered_d = 0;
		var total_quarter_month1_d = 0;
		var total_quarter_month2_d = 0;
		var total_quarter_month3_d = 0;
		var total_quarter_total_d = 0;
		var total_sub_total_d = 0;
		var total_total_rev_traffic = 0;
		$('#tableList2 tbody tr:visible').each(function() {
			if ($(this).find('.cs_quarter_month1').length || $(this).find('.ex_cs_quarter_month1').length) {
				rows++;
			}
			total_seats_offered += removeComma($(this).find('.cs_seats_offered').html());
			total_quarter_month1 += removeComma($(this).find('.cs_quarter_month1').html());
			total_quarter_month2 += removeComma($(this).find('.cs_quarter_month2').html());
			total_quarter_month3 += removeComma($(this).find('.cs_quarter_month3').html());
			total_quarter_total += removeComma($(this).find('.cs_quarter_total').html());
			total_sub_total += removeComma($(this).find('.cs_sub_total').html());
			total_seats_offered_d += removeComma($(this).find('.cs_seats_offered_d').html());
			total_quarter_month1_d += removeComma($(this).find('.cs_quarter_month1_d').html());
			total_quarter_month2_d += removeComma($(this).find('.cs_quarter_month2_d').html());
			total_quarter_month3_d += removeComma($(this).find('.cs_quarter_month3_d').html());
			total_quarter_total_d += removeComma($(this).find('.cs_quarter_total_d').html());
			total_sub_total_d += removeComma($(this).find('.cs_sub_total_d').html());
			total_total_rev_traffic += removeComma($(this).find('.cs_total_rev_traffic').html());

			total_seats_offered += removeComma($(this).find('.ex_cs_seats_offered').html());
			total_quarter_month1 += removeComma($(this).find('.ex_cs_quarter_month1').html());
			total_quarter_month2 += removeComma($(this).find('.ex_cs_quarter_month2').html());
			total_quarter_month3 += removeComma($(this).find('.ex_cs_quarter_month3').html());
			total_quarter_total += removeComma($(this).find('.ex_cs_quarter_total').html());
			total_sub_total += removeComma($(this).find('.ex_cs_sub_total').html());
			total_seats_offered_d += removeComma($(this).find('.ex_cs_seats_offered_d').html());
			total_quarter_month1_d += removeComma($(this).find('.ex_cs_quarter_month1_d').html());
			total_quarter_month2_d += removeComma($(this).find('.ex_cs_quarter_month2_d').html());
			total_quarter_month3_d += removeComma($(this).find('.ex_cs_quarter_month3_d').html());
			total_quarter_total_d += removeComma($(this).find('.ex_cs_quarter_total_d').html());
			total_sub_total_d += removeComma($(this).find('.ex_cs_sub_total_d').html());
			total_total_rev_traffic += removeComma($(this).find('.ex_cs_total_rev_traffic').html());
		});
		var total_total_percent = ((total_seats_offered + total_seats_offered_d) > 0) ? (total_total_rev_traffic / (total_seats_offered + total_seats_offered_d)) * 100 : 0;
		$('.total_row2 .total_seats_offered').html(addComma(total_seats_offered, 0));
		$('.total_row2 .total_quarter_month1').html(addComma(total_quarter_month1, 0));
		$('.total_row2 .total_quarter_month2').html(addComma(total_quarter_month2, 0));
		$('.total_row2 .total_quarter_month3').html(addComma(total_quarter_month3, 0));
		$('.total_row2 .total_quarter_total').html(addComma(total_quarter_total, 0));
		$('.total_row2 .total_sub_total').html(addComma(total_sub_total, 0));
		$('.total_row2 .total_seats_offered_d').html(addComma(total_seats_offered_d, 0));
		$('.total_row2 .total_quarter_month1_d').html(addComma(total_quarter_month1_d, 0));
		$('.total_row2 .total_quarter_month2_d').html(addComma(total_quarter_month2_d, 0));
		$('.total_row2 .total_quarter_month3_d').html(addComma(total_quarter_month3_d, 0));
		$('.total_row2 .total_quarter_total_d').html(addComma(total_quarter_total_d, 0));
		$('.total_row2 .total_sub_total_d').html(addComma(total_sub_total_d, 0));
		$('.total_row2 .total_total_rev_traffic').html(addComma(total_total_rev_traffic, 0));
		$('.total_row2 .total_total_percent').html(addComma(total_total_percent) + '%');
	}
	function computeTotal3() {
		var total_quarter_month1 = 0;
		var total_quarter_month2 = 0;
		var total_quarter_month3 = 0;
		var total_subtotal = 0;
		var total_quarter_month1_d = 0;
		var total_quarter_month2_d = 0;
		var total_quarter_month3_d = 0;
		var total_subtotal_d = 0;
		var total_total = 0;
		$('#tableList3 tbody tr').each(function() {
			total_quarter_month1 += removeComma($(this).find('.quarter_month1').val());
			total_quarter_month2 += removeComma($(this).find('.quarter_month2').val());
			total_quarter_month3 += removeComma($(this).find('.quarter_month3').val());
			total_subtotal += removeComma($(this).find('.subtotal').val());
			total_quarter_month1_d += removeComma($(this).find('.quarter_month1_d').val());
			total_quarter_month2_d += removeComma($(this).find('.quarter_month2_d').val());
			total_quarter_month3_d += removeComma($(this).find('.quarter_month3_d').val());
			total_subtotal_d += removeComma($(this).find('.subtotal_d').val());
			total_total += removeComma($(this).find('.total').val());
		});
		$('.total_row3 .total_quarter_month1').html(addComma(total_quarter_month1, 0));
		$('.total_row3 .total_quarter_month2').html(addComma(total_quarter_month2, 0));
		$('.total_row3 .total_quarter_month3').html(addComma(total_quarter_month3, 0));
		$('.total_row3 .total_subtotal').html(addComma(total_subtotal, 0));
		$('.total_row3 .total_quarter_month1_d').html(addComma(total_quarter_month1_d, 0));
		$('.total_row3 .total_quarter_month2_d').html(addComma(total_quarter_month2_d, 0));
		$('.total_row3 .total_quarter_month3_d').html(addComma(total_quarter_month3_d, 0));
		$('.total_row3 .total_subtotal_d').html(addComma(total_subtotal_d, 0));
		$('.total_row3 .total_total').html(addComma(total_total, 0));
	}
	function addRow(data) {
		data.codeshared = data.codeshared || '';
		var row2 = '';
		if (data.aircraft == 'NO OPERATION') {
			var fields = ['quarter_month1', 'quarter_month2', 'quarter_month3', 'quarter_total', 'foctraffic_month1', 'foctraffic_month2', 'foctraffic_month3', 'nflight_month1', 'nflight_month2', 'nflight_month3', 'seats_offered_d', 'quarter_month1_d', 'quarter_month2_d', 'quarter_month3_d', 'quarter_total_d', 'foctraffic_month1_d', 'foctraffic_month2_d', 'foctraffic_month3_d', 'nflight_month1_d', 'nflight_month2_d', 'nflight_month3_d'];

			var row = `
				<tr class="no_operation">
					<td class="text-center" colspan="17">NO OPERATION<input type="hidden" name="aircraft[]" value="NO OPERATION"><input type="hidden" name="economy[]" class="economy"><input type="hidden" name="business[]" class="business"><input type="hidden" name="first[]" class="first"><input type="hidden" name="destination_from[]" class="destination_from"><input type="hidden" name="destination_to[]" class="destination_to"><input type="hidden" name="seats_offered[]" class="seats_offered"></td>
			`;
			fields.forEach(function(index) {
				row += `
					<input type="hidden" name="quarter_month1[]" class="quarter_month1">
				`;
			});
			row += '</tr>';

			var row2 = `
				<tr class="no_operation">
					<td class="text-center" colspan="17">NO OPERATION<input type="hidden" name="codeshared[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			row_num++;
			var total_seats = removeComma(data.business) + removeComma(data.economy) + removeComma(data.first);

			var quarter_total = removeComma(data.quarter_month1) + removeComma(data.quarter_month2) + removeComma(data.quarter_month3);
			var quarter_total_d = removeComma(data.quarter_month1_d) + removeComma(data.quarter_month2_d) + removeComma(data.quarter_month3_d);
			var total_rev_traffic = quarter_total + quarter_total_d;
			var seats_offered = (removeComma(data.nflight_month1) + removeComma(data.nflight_month2) + removeComma(data.nflight_month3)) * total_seats;
			var seats_offered_d = (removeComma(data.nflight_month1_d) + removeComma(data.nflight_month2_d) + removeComma(data.nflight_month3_d)) * total_seats;
			var total_percent = removeComma(addComma((total_rev_traffic / (seats_offered + seats_offered_d)) * 100));

			var ex_quarter_total = removeComma(data.ex_quarter_month1) + removeComma(data.ex_quarter_month2) + removeComma(data.ex_quarter_month3);
			var ex_quarter_total_d = removeComma(data.ex_quarter_month1_d) + removeComma(data.ex_quarter_month2_d) + removeComma(data.ex_quarter_month3_d);
			var ex_total_rev_traffic = ex_quarter_total + ex_quarter_total_d;
			var ex_seats_offered = (removeComma(data.ex_nflight_month1) + removeComma(data.ex_nflight_month2) + removeComma(data.ex_nflight_month3)) * total_seats;
			var ex_seats_offered_d = (removeComma(data.ex_nflight_month1_d) + removeComma(data.ex_nflight_month2_d) + removeComma(data.ex_nflight_month3_d)) * total_seats;
			var ex_total_percent = removeComma(addComma((ex_total_rev_traffic / (ex_seats_offered + ex_seats_offered_d)) * 100));

			var row = `
				<tr class="entry" data-entry="` + row_num + `">
					<td class="dyna_column"><span class="aircraft">` + data.aircraft + `</span></td>
					<td><span class="destination_from_to">` + data.destination_from + ' - ' + data.destination_to + `</span></td>
					<td class="text-right"><span class="seats_offered">` + addComma(seats_offered, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month1">` + addComma(data.quarter_month1, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month2">` + addComma(data.quarter_month2, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month3">` + addComma(data.quarter_month3, 0) + `</span></td>
					<td class="text-right"><span class="quarter_total">` + addComma(quarter_total, 0) + `</span></td>
					<td class="text-right"><span class="sub_total">` + addComma(removeComma(data.foctraffic_month1) + removeComma(data.foctraffic_month2) + removeComma(data.foctraffic_month3), 0) + `</span></td>
					<td><span class="destination_to_from">` + data.destination_to + ' - ' + data.destination_from + `</span></td>
					<td class="text-right"><span class="seats_offered_d">` + addComma(seats_offered_d, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month1_d">` + addComma(data.quarter_month1_d, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month2_d">` + addComma(data.quarter_month2_d, 0) + `</span></td>
					<td class="text-right"><span class="quarter_month3_d">` + addComma(data.quarter_month3_d, 0) + `</span></td>
					<td class="text-right"><span class="quarter_total_d">` + addComma(quarter_total_d, 0) + `</span></td>
					<td class="text-right"><span class="sub_total_d">` + addComma(removeComma(data.foctraffic_month1_d) + removeComma(data.foctraffic_month2_d) + removeComma(data.foctraffic_month3_d), 0) + `</span></td>
					<td class="text-right"><span class="total_rev_traffic">` + addComma(total_rev_traffic, 0) + `</span></td>
					<td class="text-right"><span class="total_percent">` + addComma(total_percent) + `%</span><textarea name="data_values[]" class="data_values hidden">` + JSON.stringify(data) + `</textarea></td>
				</tr>
				<tr>
					<td><span class="ex_destination_from_to">` + data.extra_dest + ' - ' + data.destination_to + `</span></td>
					<td class="text-right"><span class="ex_seats_offered">` + addComma(ex_seats_offered, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month1">` + addComma(data.ex_quarter_month1, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month2">` + addComma(data.ex_quarter_month2, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month3">` + addComma(data.ex_quarter_month3, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_total">` + addComma(ex_quarter_total, 0) + `</span></td>
					<td class="text-right"><span class="ex_sub_total">` + addComma(removeComma(data.ex_foctraffic_month1) + removeComma(data.ex_foctraffic_month2) + removeComma(data.ex_foctraffic_month3), 0) + `</span></td>
					<td><span class="ex_destination_to_from">` + data.destination_to + ' - ' + data.extra_dest + `</span></td>
					<td class="text-right"><span class="ex_seats_offered_d">` + addComma(ex_seats_offered_d, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month1_d">` + addComma(data.ex_quarter_month1_d, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month2_d">` + addComma(data.ex_quarter_month2_d, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_month3_d">` + addComma(data.ex_quarter_month3_d, 0) + `</span></td>
					<td class="text-right"><span class="ex_quarter_total_d">` + addComma(ex_quarter_total_d, 0) + `</span></td>
					<td class="text-right"><span class="ex_sub_total_d">` + addComma(removeComma(data.ex_foctraffic_month1_d) + removeComma(data.ex_foctraffic_month2_d) + removeComma(data.ex_foctraffic_month3_d), 0) + `</span></td>
					<td class="text-right"><span class="ex_total_rev_traffic">` + addComma(ex_total_rev_traffic, 0) + `</span></td>
					<td class="text-right"><span class="ex_total_percent">` + addComma(ex_total_percent) + `%</span></td>
				</tr>
			`;

			var cs_quarter_total = removeComma(data.cs_quarter_month1) + removeComma(data.cs_quarter_month2) + removeComma(data.cs_quarter_month3);
			var cs_quarter_total_d = removeComma(data.cs_quarter_month1_d) + removeComma(data.cs_quarter_month2_d) + removeComma(data.cs_quarter_month3_d);
			var cs_total_rev_traffic = cs_quarter_total + cs_quarter_total_d;
			var cs_seats_offered = (removeComma(data.cs_nflight_month1) + removeComma(data.cs_nflight_month2) + removeComma(data.cs_nflight_month3)) * total_seats;
			var cs_seats_offered_d = (removeComma(data.cs_nflight_month1_d) + removeComma(data.cs_nflight_month2_d) + removeComma(data.cs_nflight_month3_d)) * total_seats;
			var cs_total_percent = removeComma(addComma((cs_total_rev_traffic / (cs_seats_offered + cs_seats_offered_d)) * 100));

			var ex_cs_quarter_total = removeComma(data.ex_cs_quarter_month1) + removeComma(data.ex_cs_quarter_month2) + removeComma(data.ex_cs_quarter_month3);
			var ex_cs_quarter_total_d = removeComma(data.ex_cs_quarter_month1_d) + removeComma(data.ex_cs_quarter_month2_d) + removeComma(data.ex_cs_quarter_month3_d);
			var ex_cs_total_rev_traffic = ex_cs_quarter_total + ex_cs_quarter_total_d;
			var ex_cs_seats_offered = (removeComma(data.ex_cs_nflight_month1) + removeComma(data.ex_cs_nflight_month2) + removeComma(data.ex_cs_nflight_month3)) * total_seats;
			var ex_cs_seats_offered_d = (removeComma(data.ex_cs_nflight_month1_d) + removeComma(data.ex_cs_nflight_month2_d) + removeComma(data.ex_cs_nflight_month3_d)) * total_seats;
			var ex_cs_total_percent = removeComma(addComma((ex_cs_total_rev_traffic / (ex_cs_seats_offered + ex_cs_seats_offered_d)) * 100));

			var hidden = ! (data.codeshared != '' && data.codeshared != 0 && data.codeshared != 'NO OPERATION');

			var row2 = `
				<tr class="entry" data-entry="` + row_num + `">
					<td class="dyna_column"><span class="codeshared">` + data.codeshared + `</span></td>
					<td><span class="destination_from_to">` + data.destination_from + ' - ' + data.destination_to + `</span></td>
					<td class="text-right"><span class="cs_seats_offered">` + cs_seats_offered + `</span></td>
					<td class="text-right"><span class="cs_quarter_month1">` + data.cs_quarter_month1 + `</span></td>
					<td class="text-right"><span class="cs_quarter_month2">` + data.cs_quarter_month2 + `</span></td>
					<td class="text-right"><span class="cs_quarter_month3">` + data.cs_quarter_month3 + `</span></td>
					<td class="text-right"><span class="cs_quarter_total">` + cs_quarter_total + `</span></td>
					<td class="text-right"><span class="cs_sub_total">` + addComma(removeComma(data.cs_foctraffic_month1) + removeComma(data.cs_foctraffic_month2) + removeComma(data.cs_foctraffic_month3), 0) + `</span></td>
					<td class="text-right"><span class="destination_to_from">` + data.destination_to + ' - ' + data.destination_from + `</span></td>
					<td class="text-right"><span class="cs_seats_offered_d">` + cs_seats_offered_d + `</span></td>
					<td class="text-right"><span class="cs_quarter_month1_d">` + data.cs_quarter_month1_d + `</span></td>
					<td class="text-right"><span class="cs_quarter_month2_d">` + data.cs_quarter_month2_d + `</span></td>
					<td class="text-right"><span class="cs_quarter_month3_d">` + data.cs_quarter_month3_d + `</span></td>
					<td class="text-right"><span class="cs_quarter_total_d">` + cs_quarter_total_d + `</span></td>
					<td class="text-right"><span class="cs_sub_total_d">` + addComma(removeComma(data.cs_foctraffic_month1_d) + removeComma(data.cs_foctraffic_month2_d) + removeComma(data.cs_foctraffic_month3_d), 0) + `</span></td>
					<td class="text-right"><span class="cs_total_rev_traffic">` + cs_total_rev_traffic + `</span></td>
					<td class="text-right"><span class="cs_total_percent">` + addComma(cs_total_percent) + `%</span></td>
				</tr>
				<tr>
					<td><span class="destination_from_to">` + data.extra_dest + ' - ' + data.destination_to + `</span></td>
					<td class="text-right"><span class="ex_cs_seats_offered">` + ex_cs_seats_offered + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month1">` + data.ex_cs_quarter_month1 + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month2">` + data.ex_cs_quarter_month2 + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month3">` + data.ex_cs_quarter_month3 + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_total">` + cs_quarter_total + `</span></td>
					<td class="text-right"><span class="ex_cs_sub_total">` + addComma(removeComma(data.ex_cs_foctraffic_month1) + removeComma(data.ex_cs_foctraffic_month2) + removeComma(data.ex_cs_foctraffic_month3), 0) + `</span></td>
					<td class="text-right"><span class="destination_to_from">` + data.destination_to + ' - ' + data.extra_dest + `</span></td>
					<td class="text-right"><span class="ex_cs_seats_offered_d">` + ex_cs_seats_offered_d + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month1_d">` + data.ex_cs_quarter_month1_d + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month2_d">` + data.ex_cs_quarter_month2_d + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_month3_d">` + data.ex_cs_quarter_month3_d + `</span></td>
					<td class="text-right"><span class="ex_cs_quarter_total_d">` + cs_quarter_total_d + `</span></td>
					<td class="text-right"><span class="ex_cs_sub_total_d">` + addComma(removeComma(data.ex_cs_foctraffic_month1_d) + removeComma(data.ex_cs_foctraffic_month2_d) + removeComma(data.ex_cs_foctraffic_month3_d), 0) + `</span></td>
					<td class="text-right"><span class="ex_cs_total_rev_traffic">` + ex_cs_total_rev_traffic + `</span></td>
					<td class="text-right"><span class="ex_cs_total_percent">` + addComma(ex_cs_total_percent) + `%</span></td>
				</tr>
			`;
		}
		$('#tableList tbody .no-entry').remove();
		$('#tableList tbody .no_operation').remove();
		$('#tableList tbody').append(row);
		$('#tableList2 tbody .no_operation').remove();
		$('#tableList2 tbody').append(row2);
		checkExtraDisplay(row_num);
		checkCodeSharedEntries();
		if ($('#tableList2 tbody tr').length == 0) {
			addNoEntry2();
		}
		if (typeof drawTemplate === 'function') {
			drawTemplate();
		}
		computeTotal();
		computeTotal2();
	}
	function addRow2(data) {
		if (data.aircraft == 'NO OPERATION' || data.destination_from == 'NO OPERATION') {
			var row = `
				<tr class="no_operation">
					<td class="text-center" colspan="11">NO OPERATION<input type="hidden" name="t_aircraft[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			data.subtotal = removeComma(data.quarter_month1) + removeComma(data.quarter_month2) + removeComma(data.quarter_month3);
			data.subtotal_d = removeComma(data.quarter_month1_d) + removeComma(data.quarter_month2_d) + removeComma(data.quarter_month3_d);
			data.total = data.subtotal + data.subtotal_d;
			var row = `
				<tr class="entry">
					<td><span class="firstRoute">` + data.destination_from + ' - ' + data.destination_to + `</span><input type="hidden" name="t_destination_from[]" class="destination_from" value="` + data.destination_from + `"><input type="hidden" name="t_destination_to[]" class="destination_to" value="` + data.destination_to + `"></td>
					<td class="text-right"><span>` + addComma(data.quarter_month1, 0) + `</span><input type="hidden" name="t_quarter_month1[]" class="quarter_month1" value="` + data.quarter_month1 + `"></td>
					<td class="text-right"><span>` + addComma(data.quarter_month2, 0) + `</span><input type="hidden" name="t_quarter_month2[]" class="quarter_month2" value="` + data.quarter_month2 + `"></td>
					<td class="text-right"><span>` + addComma(data.quarter_month3, 0) + `</span><input type="hidden" name="t_quarter_month3[]" class="quarter_month3" value="` + data.quarter_month3 + `"></td>
					<td class="text-right"><span>` + addComma(data.subtotal, 0) + `</span><input type="hidden" name="t_subtotal[]" class="subtotal" value="` + data.subtotal + `"></td>
					<td><span class="lastRoute">` + data.destination_to + ' - ' + data.destination_from + `</span></td>
					<td class="text-right"><span>` + addComma(data.quarter_month1_d, 0) + `</span><input type="hidden" name="t_quarter_month1_d[]" class="quarter_month1_d" value="` + data.quarter_month1_d + `"></td>
					<td class="text-right"><span>` + addComma(data.quarter_month2_d, 0) + `</span><input type="hidden" name="t_quarter_month2_d[]" class="quarter_month2_d" value="` + data.quarter_month2_d + `"></td>
					<td class="text-right"><span>` + addComma(data.quarter_month3_d, 0) + `</span><input type="hidden" name="t_quarter_month3_d[]" class="quarter_month3_d" value="` + data.quarter_month3_d + `"></td>
					<td class="text-right"><span>` + addComma(data.subtotal_d, 0) + `</span><input type="hidden" name="t_subtotal_d[]" class="subtotal_d" value="` + data.subtotal_d + `"></td>
					<td class="text-right"><span>` + addComma(data.total, 0) + `</span><input type="hidden" name="t_total[]" class="total" value="` + data.total + `"></td>
				</tr>
			`;
		}
		$('#tableList3 tbody .no-entry').remove();
		$('#tableList3 tbody .no_operation').remove();
		$('#tableList3 tbody').append(row);
		computeTotal3();
		if (typeof drawTemplate === 'function') {
			drawTemplate();
		}
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
	function checkCodeSharedEntries() {
		if ($('#tableList2 tbody tr.entry:visible').length) {
			$('#tableList2 tbody .no-entry').hide();
		} else {
			$('#tableList2 tbody .no-entry').show();
		}
	}
	function checkExtraDisplay(row_num) {
		var main_row = $('#tableList tr[data-entry="' + row_num + '"]');
		var ex_edit_row = $('#tableList tr[data-entry="' + row_num + '"] + tr');
		var cs_row = $('#tableList2 tr[data-entry="' + row_num + '"]');
		var ex_cs_row = $('#tableList2 tr[data-entry="' + row_num + '"] + tr');

		var data_values = JSON.parse(main_row.find('.data_values').val() || '{}');
		var rowspan = ((data_values.extra || 'no') == 'no') ? 1 : 2;
		var visible = ! ((data_values.extra || 'no') == 'no')

		main_row.find('.dyna_column').attr('rowspan', rowspan);
		cs_row.find('.dyna_column').attr('rowspan', rowspan);

		ex_edit_row.toggle(visible);
		ex_cs_row.toggle(visible);

		cs_row.toggle( !! (data_values.codeshared));
		ex_cs_row.toggle( !! (data_values.codeshared) && visible);
	}
	$('#tableList .entry_count').html($('#tableList tbody .entry').length);
	$('#tableList2 .entry_count').html($('#tableList2 tbody .entry:visible').length);
	$('#tableList3 .entry_count').html($('#tableList3 tbody .entry').length);
</script>