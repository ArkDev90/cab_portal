<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		HISTORY LISTING <br>
		<?php
			 if($db_table == 'form51a'){echo 'FORM 51-A: Traffic Flow - Quarterly Report On Scheduled International Services';}
			 else if($db_table == 'form51b'){echo 'FORM 51-B: Monthly International Cargo Traffic Flow';}
			 else if($db_table == 'form61a'){echo 'FORM 61-A: Monthly Statement of Traffic and Operating Statistics (Agricultural Aviation)';}
			 else if($db_table == 'form61b'){echo 'FORM 61-B: Monthly Statement of Traffic and Operating Statistics';}
			 else if($db_table == 'form71a'){echo 'FORM 71-A: International Airfreight Forwarder Cargo Production Report';}
			 else if($db_table == 'form71b'){echo 'FORM 71-B: Domestic Airfreight Forwarder Cargo Production Report';}
			 else if($db_table == 'form71c'){echo 'FORM 71-C: Cargo Sales Agency Report';}
			 else if($db_table == 'formt1a'){echo 'FORM T1-A: Domestic Sector Load Report';}
		?>
    </div>
    <?php $this->load('client_mgt/client_info_header', $data, false) ?>
    <div class="box-body table-responsive no-padding" style = "margin: 5% 10%">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('No.', array('class' => 'col-md-1'))
						->addHeader('Report Period', array('class' => 'col-md-2'))
						->addHeader('Year', array('class' => 'col-md-2'))
						->addHeader('Date Created', array('class' => 'col-md-2'))
						->addHeader('Created By', array('class' => 'col-md-3'))
						->addHeader('Status', array('class' => 'col-md-1'))
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
	ajax.db_table = '<?php echo $db_table ?>';
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_view_reporthistory', ajax, function(data) {
			$('#list tbody').html(data.table);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
		});
	}
	getList();
</script>