<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		FORM 71-B : Domestic Airfreight Forwarder Cargo Production Report
	</div>
    <div class = "row" style = "padding: 1% 7% 0% 0%">
        <div class = "col-md-7">

        </div>
        <div class = "col-md-2" style = "padding: 1%">
            <?php
                echo $ui->formField('dropdown')
                ->setList(array('January', 'February', 'March'))
                ->setName('month')
                ->setId('month')
                ->draw($show_input);
            ?>
        </div>
        <div class = "col-md-2" style = "padding: 1%">
            <?php
                echo $ui->formField('dropdown')
                ->setList(array('2010', '2011', '2012'))
                ->setName('year')
                ->setId('year')
                ->draw($show_input);
            ?>
        </div>
        <div class = "col-md-1" style = "padding: 1%">
            <button type = "button" class = "btn btn-sm btn-default">SEARCH</button>
        </div>
    </div>
	<div class = "row nav_link">
        <a href = "">[ Back to Home ]</a>
    </div>
	<div class="box-body table-responsive no-padding">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('Client Code', array('class' => 'col-md-1'))
						->addHeader('Client Name', array('class' => 'col-md-2'))
						->addHeader('Air Type', array('class' => 'col-md-2'))
						->addHeader('Report Period', array('class' => 'col-md-2'))
						->addHeader('Report Year', array('class' => 'col-md-2'))
						->addHeader('Submit Date', array('class' => 'col-md-2'))
						->addHeader('Action', array('class' => 'col-md-2'))
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
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_list', ajax, function(data) {
			$('#list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();
</script>