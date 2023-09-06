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
    .apanel_deco_title_header {
        border-left-width: 1px;
        border-right-width: 1px;
        border-top-width: 1px;
        border-bottom: 3px dotted #005CB9;
        font-family: arial;
        font-size: 10pt;
        color: #005CB9;
        font-weight: 600;
        text-align:center;
        margin-top: 4%;
        margin-left: 30%;
        margin-right: 30%;
    }


</style>
<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		SETTINGS : LIST OF ORIGIN / DESTINATION
	</div>
    <div class = "row apanel_deco_title_header">
        Sort List Results
    </div>
    <div class = "row" style = "padding: 1% 0% 0% 0%">
        <div class = "col-md-offset-3 col-md-3">
            <?php
                echo $ui->formField('dropdown')
                ->setList($reports)
                ->setName('sort')
                ->setId('sort')
                ->setNone('All Type')
                ->draw($show_input);
            ?>
        </div>
        <div class = "col-md-2" style = "padding-left: 0%">
            <button type = "button" id = "submit" class = "btn btn-default btn-md" style = "width:100%">Sort</button>
        </div>
    </div>
    <div class = "row nav_link">
        <a href = "<?php echo MODULE_URL?>create">Add Origin / Destination</a>
    </div>
    <div class="box-body table-responsive no-padding">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('Code', array('class' => 'col-md-2'))
						->addHeader('Name', array('class' => 'col-md-2'))
						->addHeader('Type', array('class' => 'col-md-2'))
						->addHeader('Part', array('class' => 'col-md-2'))
						->addHeader('Date', array('class' => 'col-md-2'))
						->addHeader('Action', array('class' => 'col-md-2'))
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
$('#submit').on('click', function() {
    var sort = $('#sort').val();
    ajax.sort = sort;
    getList();
});
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
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_origin_destination_list', ajax, function(data) {
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