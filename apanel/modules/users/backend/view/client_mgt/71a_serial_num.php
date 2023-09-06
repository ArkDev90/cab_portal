<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		Report Viewer
    </div>
    <?php $this->load('client_mgt/client_info_header', $data, false) ?>
    <div class = "row report_name">
        FORM 71-A : Serial Number (<?php echo $month.' '.$year; ?>)
    </div>
    <div class = "row nav_link">
        <a href = "" data-toggle = "back_page">Back to FORM 71-A : International Airfreight Forwarder Cargo Production Report</a>
    </div>
    <div class = "row dl_button">
		<button id = "download" type = "button" class = "btn btn-info btn-md" style = "font-weight:bold">DOWNLOAD REPORT</button>
    </div>
    <div class = "row" style = "margin: 1% 2% 0% 2%">
        <table border = "1" id = "serial_number" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('SERIAL NUMBER', array('colspan' => '7'))
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
	ajax.client_id = '<?php echo $client_id ?>';
	ajax.id = '<?php echo $id ?>';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_serialnum71a_list', ajax, function(data) {
			$('#serial_number tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();

	$("#download").on('click', function() {
        window.open("<?php echo MODULE_URL ?>serialnum71a_pdf/<?php echo $client_id.'/'. $id ?>");
    });
</script>
