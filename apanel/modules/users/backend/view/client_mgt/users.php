<div class="panel panel-primary br-xs">
	<div class="panel-heading bb-colored text-center">
		USERS ADMIN
	</div>
	<?php $this->load('client_mgt/client_info_header', $data, false) ?>
	<div class="box-body table-responsive">
		<div class="form-group text-center">
			<a href="<?= MODULE_URL ?>create_user/<?php echo $client_id ?>" class="btn btn-sm btn-primary">CREATE NEW USER</a>
			<?php if ($status == 'Pending'): ?>
				<a href="<?= BASE_URL ?>client_mgt/edit/<?php echo $client_id ?>" class="btn btn-sm btn-primary">RESEND TEMP USER ACCESS</a>
				<!-- <button type="button" id="reset_temp_access" class="btn btn-primary btn-sm">RESEND TEMP USER ACCESS</button> -->
			<?php endif ?>
		</div>
		<table id="tableList" class="table table-hover table-bordered table-sidepad">
			<?php
				echo $ui->loadElement('table')
						->setHeaderClass('info')
						->addHeader('#', array('class' => 'col-md-1'))
						->addHeader('Name', array('class' => 'col-md-3'))
						->addHeader('Designation', array('class' => 'col-md-2'))
						->addHeader('Email', array('class' => 'col-md-2'))
						->addHeader('Action', array('class' => 'col-md-2'))
						->addHeader('User Level', array('class' => 'col-md-2'))
						->draw();
			?>
			
			<tbody>

			</tbody>
			<tfoot>
				<tr class="info">
					<td colspan="4" id="pagination"></td>
					<td colspan="2" class="text-center"><b>Result: </b> <span class="result"></span></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<script>
	var ajax = {}
	ajax.limit = 20;
	ajax.client_id = '<?php echo $client_id ?>';
	var ajax_call = '';
	var ajax_call2 = '';
	$('#pagination').on('click', 'a', function(e) {
		e.preventDefault();
		ajax.page = $(this).attr('data-page');
		getList();
	});
	function getList() {
		if (ajax_call != '') {
			ajax_call.abort();
		}
		ajax_call = $.post('<?=MODULE_URL?>ajax/ajax_user_list', ajax, function(data) {
			$('#tableList tbody').html(data.table);
			$('#pagination').html(data.pagination);
			if (ajax.page > data.page_limit && data.page_limit > 0) {
				ajax.page = data.page_limit;
				getList();
			}
			$('#tableList tfoot .result').html('None');
			if (data.result_count > 0) {
				var min = (ajax.limit * (data.page - 1) + data.page);
				var max = ((ajax.limit * data.page) > data.result_count) ? data.result_count : ajax.limit * data.page;
				$('#tableList tfoot .result').html(min + ' - ' + max + ' of ' + data.result_count);
			}
		});
	}
	getList();
	$('#reset_temp_access').click(function() {
		if (ajax_call2 != '') {
			ajax_call2.abort();
		}
		ajax_call2 = $.post('<?=MODULE_URL?>ajax/ajax_reset_temp_user', ajax, function(data) {
			if (data.success) {
				location.reload();
			}
		});
	});
</script>