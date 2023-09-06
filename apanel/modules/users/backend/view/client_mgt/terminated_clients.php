<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		LIST OF TERMINATED CLIENTS
	</div>
    <div class="box-body table-responsive no-padding">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('#', array('class' => 'col-md-1'))
						->addHeader('Client Code', array('class' => 'col-md-2'))
						->addHeader('Client Name', array('class' => 'col-md-3'))
						->addHeader('TIN No', array('class' => 'col-md-2'))
						->addHeader('Country', array('class' => 'col-md-1'))
						->addHeader('Status', array('class' => 'col-md-1'))
						->draw();
			?>
			
			<tbody>

			</tbody>
			<tfoot>
			<th colspan="6"><div id = "pagination"></div></th>
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
	var ajax_call = '';
	function getList() {
		filterToURL();
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_terminated_clients_list', ajax, function(data) {
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