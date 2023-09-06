<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		LIST OF REPORTS
    </div>
    <?php $this->load('client_mgt/client_info_header', $data, false) ?>
    <div class="box-body table-responsive no-padding">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('Report Code', array('class' => 'col-md-3'))
						->addHeader('Report Name', array('class' => 'col-md-7'))
						->addHeader('#', array('class' => 'col-md-1'))
						->addHeader('View', array('class' => 'col-md-1'))
						->draw();
			?>
			
			<tbody>

			</tbody>
		</table>
	</div>
</div>

<script>
	var ajax = {}
	ajax.limit = 20;
	ajax.client_id = '<?php echo $client_id ?>';
	ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_late_report_list', ajax, function(data) {
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