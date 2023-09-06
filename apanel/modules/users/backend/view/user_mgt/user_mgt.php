<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		LIST OF CAB USER ADMIN
	</div>
	<div class="box-header pb-none">
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<a href="<?= MODULE_URL ?>create" class="btn btn-sm btn-primary">CREATE NEW CAB USER ADMIN</a>
				</div>
			</div>
			<!-- <div class="col-md-9">
				<div class="row">
					<div class="col-md-6 col-md-offset-6">
						<?php
							echo $ui->formField('text')
									->setName('search')
									->setId('search')
									->setButtonAddon('search')
									->draw();
						?>
					</div>
				</div>
			</div> -->
		</div>
	</div>
	<div class="box-body table-responsive">
		<table id="tableList" class="table table-bordered table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('LAST NAME', array('class' => 'col-md-2'))
						->addHeader('FIRST NAME', array('class' => 'col-md-2'))
						->addHeader('USERNAME', array('class' => 'col-md-2'))
						->addHeader('LEVEL', array('class' => 'col-md-1'))
						->addHeader('GROUP', array('class' => 'col-md-1'))
						->addHeader('ACTION', array('class' => 'col-md-4'))
						->addHeader('STATUS', array('class' => 'col-md-1'))
						->draw();
			?>
			<tbody>
				<tr>
					<td class="text-center" colspan="7">Loading List...</td>
				</tr>
			</tbody>
			<tfoot>
				<tr class="info">
					<td colspan="5" id="pagination"></td>
					<td colspan="2" class="text-center"><b>Result: </b> <span class="result"></span></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<script>
	var ajax = {};
	ajax.limit = 20;
	var ajax_call = '';
	$('#search').on('input', function() {
		ajax.search = $(this).val();
		getList();
	});
	$('#search_button').click(function() {
		$('#search').trigger('input');
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
			$('#tableList #pagination').html(data.pagination);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
			$('#tableList tfoot .result').html('None');
			if (data.result_count > 0) {
				var min = (ajax.limit * (data.page - 1) + data.page);
				var max = ((ajax.limit * data.page) > data.result_count) ? data.result_count : ajax.limit * data.page;
				$('#tableList tfoot .result').html(min + ' - ' + max + ' of ' + data.result_count);
			}
		});
	}
	getList();
</script>