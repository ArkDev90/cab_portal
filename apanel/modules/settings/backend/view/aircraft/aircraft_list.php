<style>
	td {
		font-size: 10px !important;
	}
	td a {
		color:black;
	}
	td a:hover {
		color:#003366;
		text-decoration:underline;
	}
	th {
		font-size: 10px !important;
		text-align:center;
	}
    .nav_link {
        text-align:center;
        padding:2%;
    }
    .nav_link a {
        font-weight: normal;
        text-align:center;
        font-size:9px;
        color:black;
    }
    .nav_link a:hover {
        color:#003366;
        text-decoration:underline;
    }
</style>
	<section class="content">
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		SETTINGS : LIST OF AIRCRAFTS
	</div>
    <div class = "row nav_link">
        <a href = "<?php echo MODULE_URL?>create">Add New Aircraft</a>
    </div>
	<div class="box-body table-responsive no-padding">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('Name', array('class' => 'col-md-8'))
						->addHeader('Date', array('class' => 'col-md-2'))
						->addHeader('Action', array('class' => 'col-md-2'))
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

</section>
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
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_aircraft_list', ajax, function(data) {
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