<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		<?php echo $form_title ?>
	</div>
	<div class="box-body pb-none">
		<div class="text-right">
			<a href="<?php echo MODULE_URL ?>" class="btn btn-primary btn-sm mb-xs">Back to Report List</a>
		</div>
		<div class="table-reponsive">
			<table id="tableList" class="table table-hover table-bordered table-sidepad mb-none">
				<?php
					echo $ui->loadElement('table')
							->setHeaderClass('info')
							->addHeader('#', array('class' => 'col-md-1'))
							->addHeader('Report Date', array('class' => 'col-md-3'))
							->addHeader('Date Created', array('class' => 'col-md-2'))
							->addHeader('Created By', array('class' => 'col-md-3'))
							->addHeader('Action', array('class' => 'col-md-3'))
							->draw();
				?>
				<tbody>
					<tr>
						<td colspan="5" class="center">Loading Entries...</td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="info">
						<td colspan="4" id="pagination"></td>
						<td colspan="1" class="text-center"><b>Result: </b> <span class="result"></span></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<script>
	var ajax = {}
	ajax.limit = 20;
	var ajax_call = '';
	$('#pagination').on('click', 'a', function(e) {
		e.preventDefault();
		ajax.page = $(this).attr('data-page');
		getList();
	});
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_draft_list', ajax, function(data) {
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