<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		SETTINGS : LIST OF NATURE OF OPERATION
	</div>
    <div class = "row nav_link">
        <a href = "<?php echo BASE_URL?>operations/create">Add New Nature of Operation</a>
    </div>
	<div class="box-body table-responsive no-padding">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('Name', array('class' => 'col-md-7'))
						->addHeader('Date', array('class' => 'col-md-3'))
						->addHeader('Action', array('class' => 'col-md-2'))
						->draw();
			?>
			
			<tbody>

			</tbody>
			<!-- <tfoot>
				<th colspan="6"><div id = "pagination"></div></th>
			</tfoot> -->
			<tfoot>
				<tr class="info">
					<td colspan="2" id="pagination"></td>
					<td colspan="1" class="text-center"><b>Result: </b> <span class="result"></span></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<script>

$('#pagination').on('click', 'a', function(e) {
      e.preventDefault();
      ajax.page = $(this).attr('data-page');
      getList();
    });
	var ajax = {}
	ajax.limit = 10;
	var ajax_call = '';
	function getList() {
		filterToURL();
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_operation_list', ajax, function(data) {
			$('#list tbody').html(data.table);
			$('#pagination').html(data.pagination);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
			$('#list tfoot .result').html('None');
			if (data.result_count > 0) {
				var min = (ajax.limit * (data.page - 1) + data.page);
				var max = ((ajax.limit * data.page) > data.result_count) ? data.result_count : ajax.limit * data.page;
				$('#list tfoot .result').html(min + ' - ' + max + ' of ' + data.result_count);
			}
		});
	}
	getList();
</script>