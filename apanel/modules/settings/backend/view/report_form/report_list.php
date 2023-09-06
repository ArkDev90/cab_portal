<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		SETTINGS : LIST OF REPORTS
	</div>
    <div class="box-body table-responsive no-padding">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('REPORT NAME', array('class' => 'col-md-6'))
						->addHeader('REVISE CODE', array('class' => 'col-md-2'))
						->addHeader('TYPE', array('class' => 'col-md-1'))
						->addHeader('REPORT START DATE', array('class' => 'col-md-2'))
						->addHeader('EDIT', array('class' => 'col-md-1'))
						->draw();
			?>
			
			<tbody>

			</tbody>
		</table>
	</div>
</div>

<script>
	var ajax = {}
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_report_list', ajax, function(data) {
			$('#list tbody').html(data.table);
			$('#pagination').html(data.pagination);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();
</script>