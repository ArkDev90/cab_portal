<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		SETTINGS : LIST OF PARTS
	</div>
    <div class = "row nav_link">
        <a href = "<?php echo MODULE_URL?>create">Add Part</a>
    </div>
    <div class="box-body table-responsive no-padding">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('Code', array('class' => 'col-md-2'))
						->addHeader('Part', array('class' => 'col-md-5'))
						->addHeader('Date', array('class' => 'col-md-2'))
						->addHeader('Action', array('class' => 'col-md-3'))
						->draw();
			?>
			
			<tbody>

			</tbody>
			<tfoot>
			<th colspan="5"><div id = "pagination"></div></th>
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
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_part_list', ajax, function(data) {
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