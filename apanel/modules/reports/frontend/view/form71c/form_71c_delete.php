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
						<th class="col-md-2">ORIGIN</th>
						<th class="col-md-2">DESTINATION</th>
						<th class="col-md-1">AIR CARRIER</th>
						<th class="col-md-2">NUMBER OF MAWBs USED</th>
						<th class="col-md-1">CHARGEABLE WEIGHT (Kilograms)</th>
						<th class="col-md-2">FREIGHT CHARGES (Philippine Peso)</th>
						<th class="col-md-1">COMMISSION EARNED (Philippine Peso)</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr class="info total_row">
						<th colspan="3" class="text-right">TOTAL:</th>
						<th class="total_weight text-right">0.00</th>
						<th class="total_numMawbs text-right">0</th>
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
		$('#tableList tbody').html(`<tr class="no-entry"><td colspan="7" class="text-center">No Entries</td></tr>`);
	}
	addNoEntry();
	function computeTotal() {
		var rows = 0;
		var total_weight = 0;
		var total_numMawbs = 0;
		var total_commission = 0;
		var total_fcharge = 0;
		$('#tableList tbody tr').each(function() {
			if ($(this).find('.distance').length) {
				rows++;
			}
			total_weight += removeComma($(this).find('.weight').val());
			total_numMawbs += removeComma($(this).find('.numMawbs').val());
			total_commission += removeComma($(this).find('.commission').val());
			total_fcharge += removeComma($(this).find('.fcharge').val());
		});
		$('.total_row .total_weight').html(addComma(total_weight));
		$('.total_row .total_numMawbs').html(addComma(total_numMawbs, 0));
		$('.total_row .total_commission').html(addComma(total_commission));
		$('.total_row .total_fcharge').html(addComma(total_fcharge));
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
					<td><span>` + data.origin + `</span><input type="hidden" name="origin[]" class="origin" value="` + data.origin + `"></td>
					<td><span>` + data.destination + `</span><input type="hidden" name="destination[]" class="destination" value="` + data.destination + `"></td>
					<td><span>` + data.aircraft + `</span><input type="hidden" name="aircraft[]" class="aircraft" value="` + data.aircraft + `"></td>
					<td class="text-right"><span>` + addComma(data.weight) + `</span><input type="hidden" name="weight[]" class="weight" value="` + data.weight + `"></td>
					<td class="text-right"><span>` + addComma(data.numMawbs, 0) + `</span><input type="hidden" name="numMawbs[]" class="numMawbs" value="` + data.numMawbs + `"></td>
					<td class="text-right"><span>` + addComma(data.fcharge) + `</span><input type="hidden" name="fcharge[]" class="fcharge" value="` + data.fcharge + `"></td>
					<td class="text-right"><span>` + addComma(data.commission) + `</span><input type="hidden" name="commission[]" class="commission" value="` + data.commission + `"></td>
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