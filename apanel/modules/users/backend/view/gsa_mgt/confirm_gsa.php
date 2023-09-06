<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		CREATE GENERAL SALES AGENT
    </div>
    <div class = "row">
        <div class = "col-md-12 head_link" style = "padding: 3% 2% 2% 3%">
            <a href = "<?= MODULE_URL ?>create"> GSA INFORMATION </a> |
            <a href = "<?MODULE_URL ?>assign_gsa"> ASSIGN STAKEHOLDER </a> | 
            <a href = "<?MODULE_URL ?>confirm_gsa"> CONFIRMATION </a>
        </div>
    </div>
    <div class = "row font-normal" style = "padding: 3% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('GSA Name:')
            ->setSplit('col-md-3', 'col-md-4')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Email:')
            ->setSplit('col-md-3', 'col-md-4')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 0% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Username:')
            ->setSplit('col-md-3', 'col-md-4')
            ->draw($show_input);
        ?>
    </div>
    <div class = "row font-normal" style = "padding: 1% 3% 2% 0%">
        <?php
            echo $ui->formField('text')
            ->setLabel('Assigned Stakeholder/s and Nature of Operation:')
            ->setSplit('col-md-3', 'col-md-4')
            ->draw($show_input);
        ?>
    </div>
    <div class="box-body table-responsive no-padding">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('No.', array('class' => 'col-md-3'))
						->addHeader("Stakeholder's Name", array('class' => 'col-md-5'))
						->addHeader('Assigned Nature of Operation', array('class' => 'col-md-4'))
						->draw();
			?>
			
			<tbody>

			</tbody>
		</table>
	</div>
    <div class = "row">
        <div class = "col-md-12" style = "padding: 2% 0% 2% 0%; text-align:center">
            <button type = "button" class = "btn btn-sm btn-default">BACK</button>
            <button type = "button" class = "btn btn-sm btn-primary">CONFIRM</button>
        </div>
    </div>
</div>
<script>
	var ajax = {}
	var ajax_call = '';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_assigned_list', ajax, function(data) {
			$('#list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();
</script>