<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		<?php
			if ($db_table == 'form51a') {
				echo 'FORM51A : FOR APPROVAL LIST OF REPORTS';
			}
			else if ($db_table == 'form51b') {
				echo 'FORM51B : FOR APPROVAL LIST OF REPORTS';
			}
			else if ($db_table == 'form61a') {
				echo 'FORM61A : FOR APPROVAL LIST OF REPORTS';
			}
			else if ($db_table == 'form61b') {
				echo 'FORM61B : FOR APPROVAL LIST OF REPORTS';
			}
			else if ($db_table == 'form71a') {
				echo 'FORM71A : FOR APPROVAL LIST OF REPORTS';
			}
			else if ($db_table == 'form71b') {
				echo 'FORM71B : FOR APPROVAL LIST OF REPORTS';
			}
			else if ($db_table == 'form71c') {
				echo 'FORM71C : FOR APPROVAL LIST OF REPORTS';
			}
			else if ($db_table == 'formt1a') {
				echo 'FORMT1A : FOR APPROVAL LIST OF REPORTS';
			}
		?>
	</div>
	<div class="box-body table-responsive no-padding">
		<table border = "1" id="list" class="table table-hover table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('NO', array('class' => 'col-md-1'))
                        ->addHeader('REPORT DATE', array('class' => 'col-md-3'))
                        ->addHeader('DATE CREATED', array('class' => 'col-md-2'))
                        ->addHeader('CREATED BY', array('class' => 'col-md-2'))
                        ->addHeader('STATUS', array('class' => 'col-md-2'))
                        ->addHeader('VIEW REPORT', array('class' => 'col-md-3'))
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
var ajax = {}
var ajax_call = '';
ajax.id = '<?php echo $id ?>';
ajax.client_id = '<?php echo $client_id ?>';
ajax.db_table = '<?php echo $db_table ?>';
ajax.user_type = '<?php echo $user_type ?>';
function getList() {
	if (ajax_call != '') {
		ajax_call.abort();
	}
	ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_pending_reports', ajax, function(data) {
		$('#list tbody').html(data.table);
		if (ajax.page > data.page_limit && data.page_limit > 0) {
			ajax.page = data.page_limit;
			getList();
		}
	});
}
getList();
</script>