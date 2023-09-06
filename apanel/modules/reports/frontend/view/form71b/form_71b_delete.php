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
						<th colspan="7">CARGO DIRECT SHIPMENTS</th>
					</tr>
					<tr class="info">
						<th class="col-md-2">AIR CARRIER</th>
						<th class="col-md-2">ORIGIN</th>
						<th class="col-md-2">DESTINATION</th>
						<th class="col-md-1">NUMBER OF AWBs USED</th>
						<th class="col-md-1">CHARGEABLE WEIGHT (Kilograms)</th>
						<th class="col-md-2">AIRLINE FREIGHT CHARGES (Philippine Peso)</th>
						<th class="col-md-1">COMMISSION EARNED (Philippine Peso)</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr class="info total_row">
						<th colspan="3" class="text-right">TOTAL:</th>
						<th class="total_numMawbs text-right">0.00</th>
						<th class="total_weight text-right">0.00</th>
						<th class="total_fcharge text-right">0.00</th>
						<th class="total_commission text-right">0.00</th>
					</tr>
					<tr class="info">
						<td colspan="5" id="pagination"></td>
						<td colspan="2" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive mb-xs">
			<table id="tableList2" class="table table-hover table-bordered table-sidepad mb-none">
				<thead>
					<tr class="info">
						<th colspan="7">CARGO CONSOLIDATION</th>
					</tr>
					<tr class="info">
						<th rowspan="2" class="col-md-2">AIRFREIGHT FORWARDER</th>
						<th rowspan="2" class="col-md-2">DESTINATION</th>
						<th colspan="2" class="col-md-2">NUMBER OF AWBs USED</th>
						<th rowspan="2" class="col-md-1">CHARGEABLE WEIGHT (Kilograms)</th>
						<th rowspan="2" class="col-md-2">AIRLINE FREIGHT CHARGES (Philippine Peso)</th>
						<th rowspan="2" class="col-md-2">GROSS CONSOLIDATED REVENUE  (Philippine Peso)</th>
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
						<th colspan="2" class="text-right">TOTAL:</th>
						<th class="total_numMawbs text-right">0.00</th>
						<th class="total_numHawbs1 text-right">0.00</th>
						<th class="total_weight text-right">0.00</th>
						<th class="total_fcharge text-right">0.00</th>
						<th class="total_revenue text-right">0.00</th>
					</tr>
					<tr class="info">
						<td colspan="5" id="pagination"></td>
						<td colspan="2" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="table-responsive mb-xs">
			<table id="tableList3" class="table table-hover table-bordered table-sidepad mb-none">
				<thead>
					<tr class="info">
						<th colspan="4">CARGO BREAKBULKING</th>
					</tr>
					<tr class="info">
						<th class="col-md-3">ORIGIN</th>
						<th class="col-md-3">TOTAL NO. OF HAWBs USED</th>
						<th class="col-md-3">CHARGEABLE WEIGHT (Kilograms)</th>
						<th class="col-md-2">INCOME FROM BREAKBULKING (Philippine Peso)</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr class="info total_row3">
						<th class="text-right">TOTAL:</th>
						<th class="total_numHawbs2 text-right">0.00</th>
						<th class="total_orgWeight text-right">0.00</th>
						<th class="total_incomeBreak text-right">0.00</th>
					</tr>
					<tr class="info">
						<td colspan="2" id="pagination"></td>
						<td colspan="2" class="text-center"><b>Entries: </b> <span class="entry_count"></span></td>
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
	$('#delete_report').click(function() {
		$.post('<?=MODULE_URL?>ajax/<?=$ajax_task?>', '<?=$ajax_post?>', function(data) {
			if (data.success) {
				window.location = data.redirect;
			}
		});
	});
	function addNoEntry() {
		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="7" class="text-center">No Entries</td></tr>`);
	}
	function addNoEntry2() {
		$('#tableList2 tbody').html(`<tr class="no-entry"><td colspan="7" class="text-center">No Entries</td></tr>`);
	}
	function addNoEntry3() {
		$('#tableList3 tbody').html(`<tr class="no-entry"><td colspan="4" class="text-center">No Entries</td></tr>`);
	}
	addNoEntry();
	addNoEntry2();
	addNoEntry3();
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
	function addRow(data) {
		if (data.aircraft == 'NO OPERATION') {
			var row = `
				<tr class="no_operation">
					<td class="text-center" colspan="7">NO OPERATION<input type="hidden" name="aircraft[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			var row = `
				<tr class="entry">
					<td><span>` + data.aircraft + `</span><input type="hidden" name="aircraft[]" class="aircraft" value="` + data.aircraft + `"></td>
					<td><span>` + data.origin + `</span><input type="hidden" name="origin[]" class="origin" value="` + data.origin + `"></td>
					<td><span>` + data.destination + `</span><input type="hidden" name="destination[]" class="destination" value="` + data.destination + `"></td>
					<td class="text-right"><span>` + data.numMawbs + `</span><input type="hidden" name="numMawbs[]" class="numMawbs" value="` + data.numMawbs + `"></td>
					<td class="text-right"><span>` + data.weight + `</span><input type="hidden" name="weight[]" class="weight" value="` + data.weight + `"></td>
					<td class="text-right"><span>` + data.fcharge + `</span><input type="hidden" name="fcharge[]" class="fcharge" value="` + data.fcharge + `"></td>
					<td class="text-right"><span>` + data.commission + `</span><input type="hidden" name="commission[]" class="commission" value="` + data.commission + `"></td>
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
					<td class="text-center" colspan=7">NO OPERATION<input type="hidden" name="c_aircraft[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			var row = `
				<tr class="entry">
					<td><span>` + data.aircraft + `</span><input type="hidden" name="c_aircraft[]" class="aircraft" value="` + data.aircraft + `"></td>
					<td><span>` + data.destination + `</span><input type="hidden" name="c_destination[]" class="destination" value="` + data.destination + `"></td>
					<td class="text-right"><span>` + data.numMawbs + `</span><input type="hidden" name="c_numMawbs[]" class="numMawbs" value="` + data.numMawbs + `"></td>
					<td class="text-right"><span>` + data.numHawbs1 + `</span><input type="hidden" name="c_numHawbs1[]" class="numHawbs1" value="` + data.numHawbs1 + `"></td>
					<td class="text-right"><span>` + data.weight + `</span><input type="hidden" name="c_weight[]" class="weight" value="` + data.weight + `"></td>
					<td class="text-right"><span>` + data.fcharge + `</span><input type="hidden" name="c_fcharge[]" class="fcharge" value="` + data.fcharge + `"></td>
					<td class="text-right"><span>` + data.revenue + `</span><input type="hidden" name="c_revenue[]" class="revenue" value="` + data.revenue + `"></td>
				</tr>
			`;
		}
		$('#tableList2 tbody .no-entry').remove();
		$('#tableList2 tbody .no_operation').remove();
		$('#tableList2 tbody').append(row);
	}
	function addRow3(data) {
		if (data.aircraft == 'NO OPERATION' || data.origin == 'NO OPERATION') {
			var row = `
				<tr class="no_operation">
					<td class="text-center" colspan="4">NO OPERATION<input type="hidden" name="c_aircraft[]" value="NO OPERATION"></td>
				</tr>
			`;
		} else {
			var row = `
				<tr class="entry">
					<td><span>` + data.origin + `</span><input type="hidden" name="b_origin[]" class="origin" value="` + data.origin + `"></td>
					<td class="text-right"><span>` + data.numHawbs2 + `</span><input type="hidden" name="b_numHawbs2[]" class="numHawbs2" value="` + data.numHawbs2 + `"></td>
					<td class="text-right"><span>` + data.orgWeight + `</span><input type="hidden" name="b_orgWeight[]" class="orgWeight" value="` + data.orgWeight + `"></td>
					<td class="text-right"><span>` + data.incomeBreak + `</span><input type="hidden" name="b_incomeBreak[]" class="incomeBreak" value="` + data.incomeBreak + `"></td>
				</tr>
			`;
		}
		$('#tableList3 tbody .no-entry').remove();
		$('#tableList3 tbody .no_operation').remove();
		$('#tableList3 tbody').append(row);
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
	computeTotal();
	computeTotal2();
	computeTotal3();
	$('#tableList .entry_count').html($('#tableList tbody .entry').length);
	$('#tableList2 .entry_count').html($('#tableList2 tbody .entry').length);
	$('#tableList3 .entry_count').html($('#tableList3 tbody .entry').length);
</script>